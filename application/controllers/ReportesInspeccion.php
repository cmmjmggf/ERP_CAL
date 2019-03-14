<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesInspeccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReportesInspeccion_model')
                ->helper('Reportesinspeccion_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function getProveedores() {
        try {
            print json_encode($this->ReportesInspeccion_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            print json_encode($this->ReportesInspeccion_model->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteInspeccion() {
        $Tp = $this->input->post('Tp');
        $Prov = $this->input->post('Proveedor');
        $Articulo = $this->input->post('Articulo');
        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');


        $cm = $this->ReportesInspeccion_model;
        $Proveedores = $cm->getProveedoresReporteInspeccion($Prov, $Articulo, $Tp, $fecha, $aFecha);
        $Doctos = $cm->getDoctosByProveedor($Prov, $Articulo, $Tp, $fecha, $aFecha);


        if (!empty($Proveedores)) {

            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            foreach ($Proveedores as $key => $P) {
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 7.5);
                $pdf->Cell(15, 4, utf8_decode('Proveedor: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 7.5);
                $pdf->Cell(50, 4, utf8_decode($P->Proveedor), 'B'/* BORDE */, 1, 'L');

                $CONT = 0;
                $TOTAL_RECIBIDA = 0;
                $TOTAL_DEV = 0;
                $TOTAL_REAL = 0;
                $MERMA_T = 0;
                $HOJAS_C = 0;
                $HOJAS_R = 0;
                $POR_HOJA = 0;
                $PRIM = 0;
                $SEGUN = 0;
                $TERC = 0;
                $CUAR = 0;

                $AP_S = 0;
                $AP_2 = 0;
                $AP_3 = 0;

                foreach ($Doctos as $key => $D) {

                    $Merma = 0;
                    $Selecta = 0;

                    switch ($D->Aprovechamiento) {
                        case "100":
                            $Merma = $D->Cant_Real * 1;
                            break;
                        case "9505":
                            $Merma = $D->Cant_Real * 0.05;
                            break;
                        case "9010":
                            $Merma = $D->Cant_Real * 0.1;
                            break;
                        case "8515":
                            $Merma = $D->Cant_Real * 0.15;
                            break;
                        case "8020":
                            $Merma = $D->Cant_Real * 0.2;
                            break;
                        case "7525":
                            $Merma = $D->Cant_Real * 0.25;
                            break;
                        case "7030":
                            $Merma = $D->Cant_Real * 0.3;
                            break;
                        case "6535":
                            $Merma = $D->Cant_Real * 0.35;
                            break;
                        case "6040":
                            $Merma = $D->Cant_Real * 0.4;
                            break;
                        case "5545":
                            $Merma = $D->Cant_Real * 0.45;
                            break;
                        case "5050":
                            $Merma = $D->Cant_Real * 0.5;
                            break;
                    }

                    if ($P->ClaveNum === $D->ClaveNum) {

                        $pdf->SetLineWidth(0.2);
                        $pdf->SetFont('Calibri', '', 7.5);
                        $pdf->Row(array(
                            $D->OrdenCompra,
                            $D->Factura,
                            $D->Articulo,
                            mb_strimwidth(utf8_decode($D->ArtDesc), 0, 25, ""),
                            $D->Precio,
                            number_format($D->Cantidad, 0, ".", ","),
                            ($D->CantidadDevuelta > 0) ? number_format($D->CantidadDevuelta, 0, ".", ",") : '',
                            ($D->Cant_Real > 0) ? number_format($D->Cant_Real, 0, ".", ",") : '',
                            $D->Aprovechamiento,
                            number_format($Merma, 0, ".", ","),
                            $D->NumHojas,
                            $D->HojasRevisadas,
                            number_format(($D->Por_Hoj), 0, ".", ","),
                            mb_strimwidth(utf8_decode($D->Defecto), 0, 15, ""),
                            ($D->Primera > 0) ? number_format($D->Primera, 0, ".", ",") : '',
                            ($D->Segunda > 0) ? number_format($D->Segunda, 0, ".", ",") : '',
                            ($D->Tercera > 0) ? number_format($D->Tercera, 0, ".", ",") : '',
                            ($D->Cuarta > 0) ? number_format($D->Cuarta, 0, ".", ",") : '',
                            (number_format(($D->Primera / $D->Cant_Real) * 100, 0, ".", ",") > 0) ? number_format(($D->Primera / $D->Cant_Real) * 100, 0, ".", ",") . ' |' : '' . ' |',
                            (number_format(($D->Segunda / $D->Cant_Real) * 100, 0, ".", ",") > 0) ? number_format(($D->Segunda / $D->Cant_Real) * 100, 0, ".", ",") . ' |' : '' . ' |',
                            (number_format(($D->Tercera / $D->Cant_Real) * 100, 0, ".", ",") > 0) ? number_format(($D->Tercera / $D->Cant_Real) * 100, 0, ".", ",") . ' |' : '' . ' |',
                            $D->PartidaIni,
                            '|' . $D->PartidaFin), 'B');

                        $TOTAL_RECIBIDA += $D->Cantidad;
                        $TOTAL_DEV += $D->CantidadDevuelta;
                        $TOTAL_REAL += $D->Cant_Real;
                        $MERMA_T += $Merma;
                        $HOJAS_C += $D->NumHojas;
                        $HOJAS_R += $D->HojasRevisadas;
                        $POR_HOJA += ceil($D->Por_Hoj);

                        $PRIM += $D->Primera;
                        $SEGUN += $D->Segunda;
                        $TERC += $D->Tercera;
                        $CUAR += $D->Cuarta;

                        $AP_S += ceil(($D->Primera / $D->Cant_Real) * 100);
                        $AP_2 += ceil(($D->Segunda / $D->Cant_Real) * 100);
                        $AP_3 += ceil(($D->Tercera / $D->Cant_Real) * 100);
                        $CONT++;
                    }
                }
                $pdf->SetX(40);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(15, 4, utf8_decode('Total por Proveedor: '), 0/* BORDE */, 0, 'L');

                $pdf->SetFont('Calibri', 'B', 8.5);

                $anchos = array(
                    12/* 1 O.C. */,
                    10/* 2 Doc */,
                    0/* 3 MAT */,
                    40/* 4  */,
                    0/* 5  PRECIO */,
                    19/* 6  CANTIDAD REC */,
                    0/* 7   Devuelta */,
                    20/* 8 Real */,
                    10/* 9 APRV */,
                    0/* 10 Merma */,
                    20/* 11 HOJA REC */,
                    0/* 12  Conta */,
                    19/* 13 DM2 */,
                    16/* 14 DETALLE */,
                    15/* 15  1 */,
                    0/* 16 2 */,
                    18/* 17 3 */,
                    0/* 18 4 */,
                    18.5/* 19 Selecta */,
                    0/* 20 90/10 */,
                    20/* 21 80/20 */,
                    0/* 22 Inicial */,
                    0/* 23 Final */);
                $pdf->SetWidths($anchos);

                //PRIMEROS TOTALES
                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    number_format($TOTAL_RECIBIDA, 0, ".", ","),
                    '',
                    number_format($TOTAL_REAL, 0, ".", ","),
                    '',
                    '',
                    $HOJAS_C,
                    '',
                    number_format($POR_HOJA, 0, ".", ","),
                    '',
                    ($PRIM > 0) ? number_format($PRIM, 0, ".", ",") : '',
                    '',
                    ($TERC > 0) ? number_format($TERC, 0, ".", ",") : '',
                    '',
                    (number_format(($AP_S / $CONT), 0, ".", ",") > 0) ? number_format(($AP_S / $CONT), 0, ".", ",") . '  ' : '',
                    '',
                    (number_format(($AP_3 / $CONT), 0, ".", ",") > 0) ? number_format(($AP_3 / $CONT), 0, ".", ",") . '  ' : '',
                    '',
                    ''), 0);
                //SEGUNDOS TOTALES

                $anchos = array(
                    12/* 1 O.C. */,
                    10/* 2 Doc */,
                    0/* 3 MAT */,
                    40/* 4  */,
                    9/* 5  PRECIO */,
                    0/* 6  CANTIDAD REC */,
                    20/* 7   Devuelta */,
                    10/* 8 Real */,
                    0/* 9 APRV */,
                    21/* 10 Merma */,
                    0/* 11 HOJA REC */,
                    18/* 12  Conta */,
                    10/* 13 DM2 */,
                    22/* 14 DETALLE */,
                    0/* 15  1 */,
                    18/* 16 2 */,
                    0/* 17 3 */,
                    18/* 18 4 */,
                    0/* 19 Selecta */,
                    19.5/* 20 90/10 */,
                    0/* 21 80/20 */,
                    0/* 22 Inicial */,
                    0/* 23 Final */);
                $pdf->SetWidths($anchos);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    number_format($TOTAL_DEV, 0, ".", ","),
                    '',
                    '',
                    number_format($MERMA_T, 0, ".", ","),
                    '',
                    $HOJAS_R,
                    '',
                    '',
                    '',
                    ($SEGUN > 0) ? number_format($SEGUN, 0, ".", ",") : '',
                    '',
                    ($CUAR > 0) ? number_format($CUAR, 0, ".", ",") : '',
                    '',
                    (number_format(($AP_2 / $CONT), 0, ".", ",") > 0) ? number_format(($AP_2 / $CONT), 0, ".", ",") . '  ' : '',
                    '',
                    '',
                    ''), 0);
            }


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inspeccion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE DE INSPECCION DE PIEL " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inspeccion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
