<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteEntSalContables extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteEntSalContables_model')
                ->helper('Reporteentsalcontables_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteEntSalContables() {

        $NomProveedor = $this->input->post('Nombre');
        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');

        $Mes_Act = substr($fecha, 3, 2);
        $Texto_Mes = '';
        $Texto_Mes_Act_Query = '';

        switch ($Mes_Act) {

            case 1:
                $Texto_Mes = 'ENERO';
                $Texto_Mes_Act_Query = 'Ene';
                break;
            case 2:
                $Texto_Mes = 'FEBRERO';
                $Texto_Mes_Act_Query = 'Feb';
                break;
            case 3:
                $Texto_Mes = 'MARZO';
                $Texto_Mes_Act_Query = 'Mar';
                break;
            case 4:
                $Texto_Mes = 'ABRIL';
                $Texto_Mes_Act_Query = 'Abr';
                break;
            case 5:
                $Texto_Mes = 'MAYO';
                $Texto_Mes_Act_Query = 'May';
                break;
            case 6:
                $Texto_Mes = 'JUNIO';
                $Texto_Mes_Act_Query = 'Jun';
                break;
            case 7:
                $Texto_Mes = 'JULIO';
                $Texto_Mes_Act_Query = 'Jul';
                break;
            case 8:
                $Texto_Mes = 'AGOSTO';
                $Texto_Mes_Act_Query = 'Ago';
                break;
            case 9:
                $Texto_Mes = 'SEPTIEMBRE';
                $Texto_Mes_Act_Query = 'Sep';
                break;
            case 10:
                $Texto_Mes = 'OCUBRE';
                $Texto_Mes_Act_Query = 'Oct';
                break;
            case 11:
                $Texto_Mes = 'NOVIMEBRE';
                $Texto_Mes_Act_Query = 'Nov';
                break;
            case 12:
                $Texto_Mes = 'DICIEMBRE';
                $Texto_Mes_Act_Query = 'Dic';
                break;
        }

        $Mes = substr($fecha, 3, 2);
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


        $cm = $this->ReporteEntSalContables_model;

        $Articulos = $cm->getArticulosByProveedor($fecha, $aFecha, $Texto_Mes_Anterior, $Texto_Mes_Act_Query);
        $Doctos = $cm->getDoctosByProveedor($fecha, $aFecha, $Texto_Mes_Anterior);

        if (!empty($Articulos)) {

            $pdf = new PDEntSalContables('L', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->setMes($Texto_Mes);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);


            foreach ($Articulos as $key => $A) {
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('NewsCycle', 'B', 8);
                $pdf->Cell(12, 5, utf8_decode($A->ClaveArt), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(60, 5, mb_strimwidth(utf8_decode($A->Articulo), 0, 40, ""), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 5, utf8_decode($A->Unidad), 'B'/* BORDE */, 1, 'C');


                $pdf->SetFont('NewsCycle', '', 8);

                $Total_Sub = 0;
                $Total_Ent = 0;
                $Total_Ent_P = 0;
                $Total_Sal = 0;
                $Total_Sal_P = 0;

                $Total_Sal_Ini = 0;

                $valida = false;
                foreach ($Doctos as $key => $D) {
                    if ($A->ClaveArt === $D->ClaveArt) {
                        $pdf->SetX(45);
                        //Valida para no imprimir repetidos
                        $pdf->SetLineWidth(0.5);
                        $pdf->SetFont('NewsCycle', 'B', 8);
                        if ($valida === false) {
                            $pdf->Cell(16, 5, number_format($A->SaldoInicial, 2, ".", ","), 1/* BORDE */, 0, 'R');
                            $valida = true;
                        } else {
                            $pdf->Cell(16, 5, '', 0/* BORDE */, 0, 'R');
                        }
                        $pdf->SetLineWidth(0.2);
                        $pdf->SetFont('NewsCycle', '', 8);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 5, $D->FechaMov, 0/* BORDE */, 0, 'L');

                        $pdf->SetFont('NewsCycle', '', 6);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(19, 5, $D->DocMov, 0/* BORDE */, 0, 'C');

                        $pdf->SetFont('NewsCycle', '', 8);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 5, ($D->Entrada <> 0) ? number_format($D->Entrada, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 5, ($D->Salida <> 0) ? number_format($D->Salida, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 5, '', 0/* BORDE */, 0, 'C');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 5, '', 0/* BORDE */, 0, 'C');

                        /* Validar repetidos */

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 5, '$' . number_format($D->PrecioMov, 2, ".", ","), 0/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 5, ($A->SaldoInicial * $D->PrecioMov <> 0) ? '$' . number_format($D->SaldoInicial * $D->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                        /* End Validar repetidos */

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 5, ($D->Entrada * $D->PrecioMov <> 0) ? '$' . number_format($D->Entrada * $D->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 5, ($D->Salida * $D->PrecioMov <> 0) ? '$' . number_format($D->Salida * $D->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');


                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 5, '', 0/* BORDE */, 0, 'R');


                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(45, 5, mb_strimwidth(utf8_decode($D->Proveedor), 0, 30, ""), 0/* BORDE */, 1, 'L');

                        $Total_Sub += $D->Subtotal;
                        $Total_Ent += $D->Entrada;
                        $Total_Ent_P += $D->Entrada * $D->PrecioMov;
                        $Total_Sal += $D->Salida;
                        $Total_Sal_P += $D->Salida * $D->PrecioMov;
                        $Total_Sal_Ini += $A->SaldoInicial * $D->PrecioMov;
                    }
                }
                $pdf->SetFont('NewsCycle', 'B', 8);
                $pdf->SetX(5);

                $pdf->SetLineWidth(0.5);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(90, 5, utf8_decode("Total por Artículo:"), 'T'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 5, number_format($Total_Ent, 2, ".", ","), 'T'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 5, number_format($Total_Sal, 2, ".", ","), 'T'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 5, number_format($A->SaldoInicial + $Total_Ent - $Total_Sal, 2, ".", ","), 'T'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 5, number_format($A->SaldoFisico, 2, ".", ","), 'T'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 5, '', 'T'/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 5, '$' . number_format($Total_Sal_Ini, 2, ".", ","), 'LT'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 5, '$' . number_format($Total_Ent_P, 2, ".", ","), 'LT'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 5, '$' . number_format($Total_Sal_P, 2, ".", ","), 'LT'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 5, '$' . number_format($Total_Sal_Ini + $Total_Ent_P - $Total_Sal_P, 2, ".", ","), 'RLT'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 5, '', 'T'/* BORDE */, 1, 'L');
                $pdf->SetY($pdf->GetY() + 5);
            }



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTRADAS Y SALIDAS CONTABLES" . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
