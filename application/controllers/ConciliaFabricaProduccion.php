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

    public function verificaUsoReporte() {
        $VerificaEnUso = $this->db->query("select concilias from modulos_en_uso ")->result();
        //print $VerificaEnUso[0]->concilias . ' asas';
        if ($VerificaEnUso[0]->concilias === '1') {//Hay alguien haciendo la concilia y detenemos el proceso
            print 1;
            exit();
        } else {
            exit();
        }
    }

    public function onReporteConciliaFabricaProduccion() {
        $this->db->query("update modulos_en_uso set concilias = 1 ");
        $cm = $this->ReporteConciliaFabricaProduccion_model;
        $T_Precio = $this->input->get('Precio');
        $Maq = $this->input->get('Maq');
        $Sem = $this->input->get('Sem');
        $Ano = $this->input->get('Ano');

        $MaqSub = ($Maq === '1') ? " '1','97' " : $Maq;
        $this->db->query("TRUNCATE TABLE concilias_temp ");
        //Sí Obtenemos todas las DEVOLUCIONES del minialmacen
//        if ($Maq === '1') {
//            $this->db->query("
//                INSERT INTO concilias_temp
//                (Grupo,Articulo,Unidad,Talla,Explosion,Entregado,Devuelto,Precio)
//                 SELECT
//                A.Grupo,
//                A.Clave AS Articulo,
//                U.Descripcion AS Unidad,
//                '' as Talla,
//                0 as Explosion,
//                0 as CantidadEntregada,
//                sum(ifnull(MA.CantidadMov, 0)) as Devolucion,
//                CASE WHEN $T_Precio = 1 THEN PM.Precio ELSE MA.PrecioMov END as Precio
//                FROM articulos A
//                JOIN movarticulos_fabrica MA ON MA.Articulo = A.Clave
//                JOIN unidades U ON U.Clave = A.UnidadMedida
//                JOIN preciosmaquilas PM ON PM.Articulo = MA.Articulo AND PM.Maquila = '$Maq'
//                WHERE MA.TipoMov = 'SDV'
//                AND MA.Ano = '$Ano'
//                AND MA.Sem = '$Sem'
//                GROUP BY A.Clave, A.Descripcion, MA.tipomov
//                ORDER BY A.Descripcion ASC; ");
//        }
        //Obtenemos todas las salidas a maquilas de movarticulos einsertamos a tabla temporal del reporte
        $this->db->query("
                INSERT INTO concilias_temp
                (Grupo,Articulo,Unidad,Talla,Explosion,Entregado,Devuelto,Precio)
                SELECT
                A.Grupo,
                A.Clave AS Articulo,
                U.Descripcion AS Unidad,
                '' as Talla,
                0 as Explosion,
                CASE WHEN MA.TipoMov in ('SXM', 'SPR', 'SXP', 'SXC') THEN sum(ifnull(MA.CantidadMov, 0)) ELSE 0 END as CantidadEntregada,
                CASE WHEN MA.TipoMov in ('EDV') THEN sum(ifnull(MA.CantidadMov, 0)) ELSE 0 END as Devolucion,
                CASE WHEN $T_Precio = 1 THEN PM.Precio ELSE MA.PrecioMov END as Precio

                FROM articulos A
                JOIN movarticulos MA ON MA.Articulo = A.Clave
                JOIN unidades U ON U.Clave = A.UnidadMedida
                JOIN preciosmaquilas PM ON PM.Articulo = A.Clave AND PM.Maquila = '$Maq'
                WHERE MA.TipoMov IN('SXM', 'SPR', 'SXP', 'SXC', 'EDV')
                AND MA.Ano = '$Ano'
                AND MA.Sem = '$Sem'
                AND MA.Maq in ($MaqSub)
                GROUP BY A.Clave, A.Descripcion, MA.tipomov
                ORDER BY A.Descripcion ASC; ");
        //Obtenemos la explosión de materiales sin suela ni planta y los guardamos en concilias_temp
        $this->db->query("
                INSERT INTO concilias_temp
                (Grupo,Articulo,Unidad,Talla,Explosion,Entregado,Devuelto,Precio)
                SELECT EXPL.Grupo, EXPL.Articulo, EXPL.Unidad,'' AS Talla, sum(EXPL.Explosion) as Explosion, 0 as ENT, 0 as DEV, EXPL.Precio
                from ( SELECT A.Grupo, FT.Articulo, U.Descripcion AS Unidad,
                CASE WHEN A.Grupo in ('1', '2') then
                (PE.Pares *  FT.Consumo)*
                (CASE
                WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a END + 1 )
                else (PE.Pares *  FT.Consumo) end AS Explosion,
                PM.Precio
                FROM `pedidox` `PE`
                JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                JOIN `preciosmaquilas` `PM` ON `PM`.`Articulo` = `FT`.`Articulo` AND `PM`.`Maquila` ='$Maq'
                JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo`
                JOIN `maquilas` `MA` ON `MA`.`Clave` = '$Maq'
                JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                WHERE PE.Maquila in ($MaqSub)
                AND cast(PE.Semana as signed) = $Sem
                AND `PE`.`Ano` = '$Ano'
                AND `A`.`Grupo` NOT IN('3', '50', '52') ) as EXPL
                GROUP BY `EXPL`.`Articulo`
                ORDER BY `EXPL`.`Grupo` ASC, CAST(`EXPL`.`Articulo` AS SIGNED) ASC
                ");


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
                        $Articulo = $D->{"A$i"};
                        $this->db->query("INSERT INTO concilias_temp (Grupo,Articulo,Unidad,Talla,Explosion,Entregado,Devuelto,Precio) "
                                . " VALUES ($D->Grupo,$Articulo,'$D->Unidad',$Talla,$Exp_Acum,0,0,$D->Precio) ");
                    }
                } else {
                    if ($Exp_Acum > 0) {
                        $Articulo = $D->{"A$i"};
                        $this->db->query("INSERT INTO concilias_temp (Grupo,Articulo,Unidad,Talla,Explosion,Entregado,Devuelto,Precio) "
                                . " VALUES ($D->Grupo,$Articulo,'$D->Unidad',$Talla,$Exp_Acum,0,0,$D->Precio) ");
                    }
                    $Talla = $D->{"T$sig"};
                    $Exp_Acum = $D->{"C$sig"};
                }
            }
        }
        $this->db->query("update modulos_en_uso set concilias = 0 ");
        // **************Reporte*************** */
        $Grupos = $cm->getGruposReporte();
        $Articulos = $cm->getDetalleReporte();


        if (!empty($Grupos)) {

            $pdf = new Concilias('P', 'mm', array(215.9, 279.4));
            $pdf->Maq = $Maq;
            $pdf->Sem = $Sem;
            $pdf->Ano = $Ano;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);

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
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->Cell(15, 3, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 7);
                $pdf->Cell(38, 3, utf8_decode($G->ClaveGrupo . '    ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

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


                        $pdf->SetFont('Calibri', '', 7);
                        $pdf->SetX(5);
                        $pdf->Cell(8, 3, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(42, 3, utf8_decode(mb_strimwidth($D->Descripcion, 0, 34, "")), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(10, 3, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(10, 3, ($D->Talla <> 0) ? number_format($D->Talla, 0, ".", ",") : '', 'B'/* BORDE */, 0, 'C');
                        $pdf->SetFont('Calibri', 'B', 7);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($D->Explosion <> 0) ? number_format($D->Explosion, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($D->Entregado <> 0) ? number_format($D->Entregado, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($Diferencia <> 0) ? number_format($Diferencia, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 3, ($D->Devuelto <> 0) ? number_format($D->Devuelto, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($Diferencia + $D->Devuelto <> 0) ? number_format($Diferencia + $D->Devuelto, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 3, number_format($D->Precio, 2, ".", ","), 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($D->Explosion * $D->Precio <> 0) ? '$' . number_format($D->Explosion * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($D->Entregado * $D->Precio <> 0) ? '$' . number_format($D->Entregado * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($D->Devuelto * $D->Precio <> 0) ? '$' . number_format($D->Devuelto * $D->Precio, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3, ($Diferencia_Pesos <> 0) ? '$' . number_format($Diferencia_Pesos, 2, ".", ",") : '', 'TRBL'/* BORDE */, 1, 'R');


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
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->SetX(5);
                $pdf->Cell(35, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(35, 3, 'Totales por Grupo:', 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Explosion <> 0) ? number_format($T_Explosion, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Entregado <> 0) ? number_format($T_Entregado, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Diferencia <> 0) ? number_format($T_Diferencia, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 3, ($T_Devol <> 0) ? number_format($T_Devol, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Dif_Ex_En_Dv <> 0) ? number_format($T_Dif_Ex_En_Dv, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Explosion_P <> 0) ? '$' . number_format($T_Explosion_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Entregado_P <> 0) ? '$' . number_format($T_Entregado_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Devol_P <> 0) ? '$' . number_format($T_Devol_P, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3, ($T_Dif_P <> 0) ? '$' . number_format($T_Dif_P, 2, ".", ",") : '', 0/* BORDE */, 1, 'R');
            }

            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->SetX(5);
            $pdf->Cell(35, 5, '', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(35, 3, 'Total Semana Maquila:', 'T'/* BORDE */, 0, 'L');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Explosion <> 0) ? number_format($GT_Explosion, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Entregado <> 0) ? number_format($GT_Entregado, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Diferencia <> 0) ? number_format($GT_Diferencia, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 3, ($GT_Devol <> 0) ? number_format($GT_Devol, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Dif_Ex_En_Dv <> 0) ? number_format($GT_Dif_Ex_En_Dv, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 3, '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Explosion_P <> 0) ? '$' . number_format($GT_Explosion_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Entregado_P <> 0) ? '$' . number_format($GT_Entregado_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Devol_P <> 0) ? '$' . number_format($GT_Devol_P, 2, ".", ",") : '', 'T'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(14, 3, ($GT_Dif_P <> 0) ? '$' . number_format($GT_Dif_P, 2, ".", ",") : '', 'T'/* BORDE */, 1, 'R');

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
