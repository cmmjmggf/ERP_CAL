<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ConciliaFabricaProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')
                ->model('ReporteConciliaFabricaProduccion_model')
                ->helper('Concilias_helper')
                ->helper('file');
    }

    public function onReporteConciliaFabricaProduccion() {

        $cm = $this->ReporteConciliaFabricaProduccion_model;
        $T_Precio = $this->input->post('Precio');
        $Maq = $this->input->post('Maq');
        $Sem = $this->input->post('Sem');
        $Ano = $this->input->post('Ano');

        $this->db->query("TRUNCATE TABLE concilias_temp ");
        //Obtenemos todas las salidas a maquilas de movarticulos einsertamos a tabla temporal del reporte
        $Entregado = $cm->getMatEntregado($Ano, $Sem, $Maq);
        $Precio = 0;
        foreach ($Entregado as $key => $D) {

            $Precio = ($T_Precio === '1') ? $D->PrecioActual : $D->PrecioMov;

            //Insertamos la explosion en la tabla temporal
            $this->db->insert("concilias_temp", array(
                'Grupo' => $D->Grupo,
                'Articulo' => $D->Articulo,
                'Unidad' => $D->Unidad,
                'Talla' => '',
                'Explosion' => 0,
                'Entregado' => $D->CantidadEntregada,
                'Devuelto' => $D->Devolucion,
                'Precio' => $Precio
            ));
        }
        $Explosion_normal = $cm->getExplosionNormal($Ano, $Sem, $Maq);
        foreach ($Explosion_normal as $key => $D) {

            //Insertamos la explosion en la tabla temporal
            $this->db->insert("concilias_temp", array(
                'Grupo' => $D->ClaveGrupo,
                'Articulo' => $D->Articulo,
                'Unidad' => $D->Unidad,
                'Talla' => '',
                'Explosion' => $D->Explosion,
                'Entregado' => 0,
                'Devuelto' => 0,
                'Precio' => $D->Precio
            ));
        }
        //Realizacion de consulta a cabeceros para insertarlos
        $Explosion_tallas = $cm->getExplosionTallas($Ano, $Sem, $Maq);

        foreach ($Explosion_tallas as $key => $D) {

            $Exp_Acum = $D->C1;
            $Talla = $D->T1;

            for ($i = 1; $i < 22; $i++) {
                $sig = $i + 1;
                if ($D->{"A$i"} === $D->{"A$sig"}) {
                    $Exp_Acum += $D->{"C$sig"};
                } else if ($D->{"A$sig"} === '0') {
                    $Exp_Acum += $D->{"C$sig"};
                    if ($Exp_Acum > 0) {

                        $this->db->insert("concilias_temp", array(
                            'Grupo' => $D->Grupo,
                            'Articulo' => $D->{"A$i"},
                            'Unidad' => $D->Unidad,
                            'Talla' => $Talla,
                            'Explosion' => $Exp_Acum,
                            'Entregado' => 0,
                            'Devuelto' => 0,
                            'Precio' => $D->Precio
                        ));
                    }
                } else {
                    if ($Exp_Acum > 0) {
                        $this->db->insert("concilias_temp", array(
                            'Grupo' => $D->Grupo,
                            'Articulo' => $D->{"A$i"},
                            'Unidad' => $D->Unidad,
                            'Talla' => $Talla,
                            'Explosion' => $Exp_Acum,
                            'Entregado' => 0,
                            'Devuelto' => 0,
                            'Precio' => $D->Precio
                        ));
                    }
                    $Talla = $D->{"T$sig"};
                    $Exp_Acum = $D->{"C$sig"};
                }
            }
        }
        // **************Reporte*************** */
        $Grupos = $cm->getGruposReporte();
        $Articulos = $cm->getDetalleReporte();

        if (!empty($Grupos)) {

            $pdf = new Concilias('L', 'mm', array(215.9, 279.4));
            $pdf->Maq = $Maq;
            $pdf->Sem = $Sem;
            $pdf->Ano = $Ano;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);

            $GT_Explosion = 0;
            $GT_Entregado = 0;
            $GT_Diferencia = 0;
            $GT_Devol = 0;
            $GT_Dif_Ex_En_Dv = 0;
            $GT_Explosion_P = 0;
            $GT_Entregado_P = 0;
            $GT_Devol_P = 0;
            $GT_Dif_P = 0;

            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(15, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(38, 4, utf8_decode($G->ClaveGrupo . '    ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);

                $T_Explosion = 0;
                $T_Entregado = 0;
                $T_Diferencia = 0;
                $T_Devol = 0;
                $T_Dif_Ex_En_Dv = 0;
                $T_Explosion_P = 0;
                $T_Entregado_P = 0;
                $T_Devol_P = 0;
                $T_Dif_P = 0;

                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->Grupo) {

                        $Diferencia = $D->Explosion - $D->Entregado;
                        $Diferencia_Pesos = ($D->Explosion * $D->Precio) - ($D->Entregado * $D->Precio) + ($D->Devuelto * $D->Precio);


                        $pdf->SetFont('Calibri', '', 8);
                        $pdf->SetX(5);
                        $pdf->Cell(10, 3, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(60, 3, mb_strimwidth(utf8_decode($D->Descripcion), 0, 38, ""), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12.5, 3, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12.5, 3, ($D->Talla <> 0) ? number_format($D->Talla, 0, ".", ",") : '', 'B'/* BORDE */, 0, 'C');
                        $pdf->SetFont('Calibri', 'B', 8);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($D->Explosion <> 0) ? number_format($D->Explosion, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($D->Entregado <> 0) ? number_format($D->Entregado, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($Diferencia <> 0) ? number_format($Diferencia, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 3, ($D->Devuelto <> 0) ? number_format($D->Devuelto, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($Diferencia + $D->Devuelto <> 0) ? number_format($Diferencia + $D->Devuelto, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 3, number_format($D->Precio, 2, ".", ","), 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($D->Explosion * $D->Precio <> 0) ? '$' . number_format($D->Explosion * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($D->Entregado * $D->Precio <> 0) ? '$' . number_format($D->Entregado * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($D->Devuelto * $D->Precio <> 0) ? '$' . number_format($D->Devuelto * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 3, ($Diferencia_Pesos <> 0) ? '$' . number_format($Diferencia_Pesos, 2, ".", ",") : '', 'TRBL'/* BORDE */, 1, 'R');


                        $GT_Explosion += $D->Explosion;
                        $GT_Entregado += $D->Entregado;
                        $GT_Diferencia += $Diferencia;
                        $GT_Devol += $D->Devuelto;
                        $GT_Dif_Ex_En_Dv += $Diferencia + $D->Devuelto;
                        $GT_Explosion_P += $D->Explosion * $D->Precio;
                        $GT_Entregado_P += $D->Entregado * $D->Precio;
                        $GT_Devol_P += $D->Devuelto * $D->Precio;
                        $GT_Dif_P += $Diferencia_Pesos;

                        $T_Explosion += $D->Explosion;
                        $T_Entregado += $D->Entregado;
                        $T_Diferencia += $Diferencia;
                        $T_Devol += $D->Devuelto;
                        $T_Dif_Ex_En_Dv += $Diferencia + $D->Devuelto;
                        $T_Explosion_P += $D->Explosion * $D->Precio;
                        $T_Entregado_P += $D->Entregado * $D->Precio;
                        $T_Devol_P += $D->Devuelto * $D->Precio;
                        $T_Dif_P += $Diferencia_Pesos;
                    }
                }
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(60, 4, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(34, 4, 'Totales por Grupo:', 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Explosion <> 0) ? number_format($T_Explosion, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Entregado <> 0) ? number_format($T_Entregado, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Diferencia <> 0) ? number_format($T_Diferencia, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 4, ($T_Devol <> 0) ? number_format($T_Devol, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Dif_Ex_En_Dv <> 0) ? number_format($T_Dif_Ex_En_Dv, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 4, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Explosion_P <> 0) ? '$' . number_format($T_Explosion_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Entregado_P <> 0) ? '$' . number_format($T_Entregado_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Devol_P <> 0) ? '$' . number_format($T_Devol_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($T_Dif_P <> 0) ? '$' . number_format($T_Dif_P, 2, ".", ",") : '', 0/* BORDE */, 1, 'R');
            }

            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->SetX(5);
            $pdf->Cell(60, 5, '', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(35, 5, 'Total Semana Maquila:', 'T'/* BORDE */, 0, 'L');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Explosion <> 0) ? number_format($GT_Explosion, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Entregado <> 0) ? number_format($GT_Entregado, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Diferencia <> 0) ? number_format($GT_Diferencia, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 5, ($GT_Devol <> 0) ? number_format($GT_Devol, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Dif_Ex_En_Dv <> 0) ? number_format($GT_Dif_Ex_En_Dv, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 5, '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Explosion_P <> 0) ? '$' . number_format($GT_Explosion_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Entregado_P <> 0) ? '$' . number_format($GT_Entregado_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Devol_P <> 0) ? '$' . number_format($GT_Devol_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($GT_Dif_P <> 0) ? '$' . number_format($GT_Dif_P, 2, ".", ",") : '', 'T'/* BORDE */, 1, 'R');

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "CONCILIA MATERIALES FABRICA PRODUCCION " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
