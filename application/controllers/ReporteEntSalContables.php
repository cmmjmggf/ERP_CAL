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
                $Texto_Mes = 'OCTUBRE';
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
        $Doctos = $cm->getDatosReporte($fecha, $aFecha, $Texto_Mes_Anterior, $Texto_Mes_Act_Query);
        if (!empty($Doctos)) {

            $pdf = new PDEntSalContables('L', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->setMes($Texto_Mes);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);

            $art_act = '';
            $art_com = '';
            $valida = true;

            $Total_Sub = 0;
            $Total_Ent = 0;
            $Total_Ent_P = 0;
            $Total_Sal = 0;
            $Total_Sal_P = 0;
            $Total_Sal_Ini = 0;
            foreach ($Doctos as $key => $A) {
                $art_act = $A->ClaveArt;
                //Articulo no es igual al articulo que ya se imprimió
                if ($art_com !== $art_act) {
                    $pdf->SetX(5);
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->Cell(8, 3.5, utf8_decode($A->ClaveArt), ''/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(50, 3.5, mb_strimwidth(utf8_decode($A->Articulo), 0, 35, ""), ''/* BORDE */, 0, 'L');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(12, 3.5, utf8_decode($A->Unidad), ''/* BORDE */, 1, 'C');
                    //Validamos que solo se imprima la primera vez el inventario inicial
                    $valida = true;
                    $art_com = $A->ClaveArt; //Guardamos el articulo actual
                    //Reiniciamos variables de totales cada iteración
                    $Total_Sub = 0;
                    $Total_Ent = 0;
                    $Total_Ent_P = 0;
                    $Total_Sal = 0;
                    $Total_Sal_P = 0;
                    $Total_Sal_Ini = 0;
                }

                $pdf->SetFont('Calibri', '', 7.5);
                //Saldos
                $saldos = explode("-", $A->Saldos);

                $saldo_ini = $saldos[0]; // SaldoInicial
                $precio_ini = $saldos[1]; // PrecioInicial
                $saldo_actual = $saldos[2]; // Saldo Fisico actual
                //
                //DETALLE-------------------------------------------------------
                //
                $pdf->SetX(45);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', 'B', 7.5);
                //Valida para no imprimir repetidos
                if ($valida === true) {
                    $pdf->Cell(16, 3.5, number_format($saldo_ini, 2, ".", ","), 1/* BORDE */, 0, 'R');
                    $valida = false;
                } else {
                    $pdf->Cell(16, 3.5, '', 0/* BORDE */, 0, 'R');
                }
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', '', 7.5);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3.5, $A->FechaMov, 0/* BORDE */, 0, 'L');
                $pdf->SetFont('Calibri', '', 6);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(19, 3.5, $A->DocMov, 0/* BORDE */, 0, 'C');
                $pdf->SetFont('Calibri', '', 7.5);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3.5, ($A->Entrada <> 0) ? number_format($A->Entrada, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3.5, ($A->Salida <> 0) ? number_format($A->Salida, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3.5, '', 0/* BORDE */, 0, 'C');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(14, 3.5, '', 0/* BORDE */, 0, 'C');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 3.5, '$' . number_format($A->PrecioMov, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 3.5, ($saldo_ini * $A->PrecioMov <> 0) ? '$' . number_format($saldo_ini * $A->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 3.5, ($A->Entrada * $A->PrecioMov <> 0) ? '$' . number_format($A->Entrada * $A->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 3.5, ($A->Salida * $A->PrecioMov <> 0) ? '$' . number_format($A->Salida * $A->PrecioMov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 3.5, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(45, 3.5, utf8_decode(mb_strimwidth($A->Proveedor, 0, 35, "")), 0/* BORDE */, 1, 'L');

                //Acumulamos totales
                $Total_Sub += $A->Subtotal;
                $Total_Ent += $A->Entrada;
                $Total_Ent_P += $A->Entrada * $A->PrecioMov;
                $Total_Sal += $A->Salida;
                $Total_Sal_P += $A->Salida * $A->PrecioMov;
                $Total_Sal_Ini += $saldo_ini * $A->PrecioMov;

                //fIN DETALLE -------------------------------------------------------
                //Obtenemos de cada iteración el valor siguiente
                if (isset($Doctos[$key + 1])) {
                    $next = $Doctos[$key + 1]->ClaveArt; // siguiente elemento
                } else {//Para imprimir el ultimo footer group cuando ya no hay nada en el siguiente elemento
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->SetX(5);
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(65, 3.5, '', 0/* BORDE */, 0, 'C');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(25, 3.5, utf8_decode("Total por Artículo:"), 'LBT'/* BORDE */, 0, 'C');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($Total_Ent, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($Total_Sal, 2, ".", ","), 'TB'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($saldo_ini + $Total_Ent - $Total_Sal, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($saldo_actual, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(12, 3.5, '', 'BT'/* BORDE */, 0, 'L');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_Ini, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Ent_P, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_P, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_Ini + $Total_Ent_P - $Total_Sal_P, 2, ".", ","), 'BRLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(45, 3.5, '', ''/* BORDE */, 1, 'L');
                }
                //Validamos si el valor que sigue ya es diferente
                if ($next !== $art_act) {
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->SetX(5);
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(65, 3.5, '', 0/* BORDE */, 0, 'C');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(25, 3.5, utf8_decode("Total por Artículo:"), 'LBT'/* BORDE */, 0, 'C');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($Total_Ent, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($Total_Sal, 2, ".", ","), 'TB'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($saldo_ini + $Total_Ent - $Total_Sal, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(14, 3.5, number_format($saldo_actual, 2, ".", ","), 'BT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(12, 3.5, '', 'BT'/* BORDE */, 0, 'L');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_Ini, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Ent_P, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_P, 2, ".", ","), 'BLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 3.5, '$' . number_format($Total_Sal_Ini + $Total_Ent_P - $Total_Sal_P, 2, ".", ","), 'BRLT'/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(45, 3.5, '', ''/* BORDE */, 1, 'L');
                }
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
