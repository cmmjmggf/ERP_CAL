<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class InspeccionPielForro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('InspeccionPielForro_model')
                ->helper('Reportesinspeccion_helper')
                ->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo')->view('vInspeccionPielForro')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onCerrarCaptura() {
        try {
            $this->InspeccionPielForro_model->onCerrarCaptura($this->input->post('Tp'), $this->input->post('Factura'), $this->input->post('Proveedor'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {
            $this->InspeccionPielForro_model->onEliminarDetalleByID($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            $x = $this->input;
            $data = array(
                'Tp' => $x->post('Tp'),
                'OrdenCompra' => $x->post('OrdenCompra'),
                'Proveedor' => $x->post('Proveedor'),
                'Factura' => $x->post('Factura'),
                'FechaFactura' => $x->post('FechaFactura'),
                'Articulo' => $x->post('Articulo'),
                'Precio' => $x->post('Precio'),
                'Cantidad' => $x->post('Cantidad'),
                'CantidadDevuelta' => $x->post('CantidadDevuelta'),
                'Observaciones' => $x->post('Observaciones'),
                'Defecto' => $x->post('Defecto'),
                'DetalleDefecto' => $x->post('DetalleDefecto'),
                'PartidaIni' => $x->post('PartidaIni'),
                'PartidaFin' => $x->post('PartidaFin'),
                'Aprovechamiento' => $x->post('Aprovechamiento'),
                'NumHojas' => $x->post('NumHojas'),
                'HojasRevisadas' => $x->post('HojasRevisadas'),
                'Primera' => $x->post('Primera'),
                'Segunda' => $x->post('Segunda'),
                'Tercera' => $x->post('Tercera'),
                'Cuarta' => $x->post('Cuarta'),
                'FechaMov' => Date('d/m/Y'),
                'Estatus' => 'BORRADOR'
            );
            //AGREGA EN NOTAS DE CREDITO
            $this->InspeccionPielForro_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->InspeccionPielForro_model->getRecords($this->input->get('Tp'), $this->input->get('Fac'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleOrdenCompra() {
        try {
            print json_encode($this->InspeccionPielForro_model->getDetalleOrdenCompra($this->input->get('Tp'), $this->input->get('Doc')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteOrdenCompra() {
        try {
            print json_encode($this->InspeccionPielForro_model->onVerificarExisteOrdenCompra($this->input->get('Tp'), $this->input->get('Doc')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteFactura() {
        try {
            print json_encode($this->InspeccionPielForro_model->onVerificarExisteFactura($this->input->get('Tp'), $this->input->get('Doc')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDefectos() {
        try {
            print json_encode($this->InspeccionPielForro_model->getDefectos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetallesDefectos() {
        try {
            print json_encode($this->InspeccionPielForro_model->getDetallesDefectos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteInspeccion() {
        $Tp = $this->input->post('Tp');
        $Prov = $this->input->post('Proveedor');
        $Factura = $this->input->post('Factura');


        $cm = $this->InspeccionPielForro_model;
        $Proveedores = $cm->getProveedoresReporteInspeccion($Prov, $Factura, $Tp);
        $Doctos = $cm->getDoctosByProveedor($Prov, $Factura, $Tp);


        if (!empty($Proveedores)) {

            $pdf = new PDF('L', 'mm', array(215.9, 279.4));

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            foreach ($Proveedores as $key => $P) {
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->Cell(15, 4, utf8_decode('Proveedor: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 7);
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
                        $pdf->SetFont('Calibri', '', 7);
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
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->Cell(15, 4, utf8_decode('Total por Proveedor: '), 0/* BORDE */, 0, 'L');

                $pdf->SetFont('Calibri', 'B', 7);

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
                $pdf->SetFont('Calibri', 'B', 7);
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
