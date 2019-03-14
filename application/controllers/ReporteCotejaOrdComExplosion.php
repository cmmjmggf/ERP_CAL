<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteCotejaOrdComExplosion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteCotejaOrdComExplosion_model')
                ->helper('Explosiones_helper')->helper('file');
    }

    public function onReporteCotejaOrdComExplosion() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $Mes = Date('n');
        $Texto_Mes_Anterior = '';
        $Mes_Anterior = $Mes - 1;

        switch ($Mes_Anterior) {
            case 0:
                $Texto_Mes_Anterior = 'Dic';

                break;
            case 1:
                $Texto_Mes_Anterior = 'Ene';

                break;
            case 2:
                $Texto_Mes_Anterior = 'Feb';

                break;
            case 3:
                $Texto_Mes_Anterior = 'Mar';

                break;
            case 4:
                $Texto_Mes_Anterior = 'Abr';

                break;
            case 5:
                $Texto_Mes_Anterior = 'May';

                break;
            case 6:
                $Texto_Mes_Anterior = 'Jun';

                break;
            case 7:
                $Texto_Mes_Anterior = 'Jul';

                break;
            case 8:
                $Texto_Mes_Anterior = 'Ago';

                break;
            case 9:
                $Texto_Mes_Anterior = 'Sep';

                break;
            case 10:
                $Texto_Mes_Anterior = 'Oct';

                break;
            case 11:
                $Texto_Mes_Anterior = 'Nov';

                break;
            case 12:
                $Texto_Mes_Anterior = 'Dic';

                break;
        }

        $cm = $this->ReporteCotejaOrdComExplosion_model;

        $Explosion = $cm->getRegistros(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo, $Texto_Mes_Anterior
        );


        if (!empty($Explosion)) {

            $pdf = new CotejaOrdComExplosion('P', 'mm', array(215.9, 279.4));


            switch ($Tipo) {
                case '10':
                    $TipoE = '******* PIEL Y FORRO *******';
                    break;
                case '80':
                    $TipoE = '******* SUELA *******';
                    break;
                case '90':
                    $TipoE = '******* INDIRECTOS *******';
                    break;
            }

            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->TipoE = $TipoE;
            $pdf->Ano = $Ano;


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 8);

            $T_InvIni = 0;
            $T_Pedido = 0;
            $T_Entregado = 0;
            $T_EntregaProveedor = 0;
            $T_EntregadoMaquilas = 0;
            $T_Real = 0;
            $T_Explosion = 0;
            $T_FaltSobra = 0;


            foreach ($Explosion as $key => $D) {


                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);

                $ExplosionCant = 0;
                $Existencia_Real = 0;
                $Faltante_Sobrante = 0;
                switch ($Tipo) {
                    case '10':
                        $ExplosionCant = ($D->Consumo * $D->Pares) * ($D->Desperdicio + 1);
                        break;
                    case '80':
                        $ExplosionCant = ($D->Consumo * $D->Pares);
                        break;
                    case '90':
                        $ExplosionCant = ($D->Consumo * $D->Pares);
                        break;
                }
                $Existencia_Real = $D->Inv_Ini + $D->CantEntregada - $D->EntregadoMaquilas;
                $Faltante_Sobrante = $Existencia_Real - $ExplosionCant;

                $pdf->SetX(5);
                $pdf->Cell(10, 4, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(40, 4, mb_strimwidth(utf8_decode($D->Descripcion), 0, 35, ""), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(19, 4, ($D->Inv_Ini <> 0) ? number_format($D->Inv_Ini, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17.5, 4, ($D->CantPedida <> 0) ? number_format($D->CantPedida, 2, ".", ",") : '', 'BL'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17.5, 4, ($D->CantEntregada <> 0) ? number_format($D->CantEntregada, 2, ".", ",") : '', 'BR'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 4, ($D->CantPedida - $D->CantEntregada <> 0) ? number_format($D->CantPedida - $D->CantEntregada, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($D->EntregadoMaquilas <> 0) ? number_format($D->EntregadoMaquilas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 4, ($Existencia_Real <> 0) ? number_format($Existencia_Real, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(19, 4, ($ExplosionCant <> 0) ? number_format($ExplosionCant, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 4, ($Faltante_Sobrante <> 0) ? number_format($Faltante_Sobrante, 2, ".", ",") : '', 1/* BORDE */, 1, 'R');


                $T_InvIni += $D->Inv_Ini;
                $T_Pedido += $D->CantPedida;
                $T_Entregado += $D->CantEntregada;
                $T_EntregaProveedor += $D->CantPedida - $D->CantEntregada;
                $T_EntregadoMaquilas += $D->EntregadoMaquilas;
                $T_Real += $Existencia_Real;
                $T_Explosion += $ExplosionCant;
                $T_FaltSobra += $Faltante_Sobrante;
            }
            $pdf->SetFont('Calibri', 'B', 9);

            $pdf->SetX(5);
            $pdf->Cell(10, 4, '', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 4, 'Total General:', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 4, '', 0/* BORDE */, 0, 'C');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 4, number_format($T_InvIni, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17.5, 4, number_format($T_Pedido, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17.5, 4, number_format($T_Entregado, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 4, number_format($T_EntregaProveedor, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 4, number_format($T_EntregadoMaquilas, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 4, number_format($T_Real, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 4, number_format($T_Explosion, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 4, number_format($T_FaltSobra, 2, ".", ","), 0/* BORDE */, 1, 'R');



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES " . ' ' . date("d-m-Y his");
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
