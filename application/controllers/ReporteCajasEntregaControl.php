<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteCajasEntregaControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteCajasEntregaControl_model')
                ->helper('Reportecajasentregacontrol_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteCajasEntregaXControl() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');


        $cm = $this->ReporteCajasEntregaControl_model;
        $Articulos = $cm->getArticulosReporte($FechaIni, $FechaFin);
        $ArticulosDetalle = $cm->getDetalleArticulosReporte($FechaIni, $FechaFin);
        if (!empty($Articulos)) {

            $pdf = new PDFCajasXControl('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $Total_G = 0;
            foreach ($Articulos as $key => $M) {

                $Total_M = 0;
                $valida = false;
                $art = '';
                foreach ($ArticulosDetalle as $key => $D) {
                    if ($M->Articulo === $D->Articulo) {
                        $pdf->SetFont('Calibri', '', 9);
                        if ($valida === false) {
                            $anchos = array(25/* 0 */, 12/* 1 */, 118/* 2 */, 15/* 3 */, 15/* 3 */);
                            $aligns = array('L', 'R', 'L', 'C', 'R');
                            $pdf->SetAligns($aligns);
                            $pdf->SetWidths($anchos);
                            $pdf->Row(array($D->Control, $D->Articulo, $D->ArticuloT, $D->UnidadMedidaT, $D->Cantidad), 0);
                            $valida = true;
                        } else {
                            $pdf->Row(array($D->Control, '', '', $D->UnidadMedidaT, $D->Cantidad), 0);
                        }
                        $Total_M += $D->Cantidad;
                        $Total_G += $D->Cantidad;
                    }
                }
                $valida = false;
                /* Total por articulo */
                $pdf->SetX(70);
                $pdf->SetFont('Calibri', 'B', 9);
                $aligns = array('L', 'R', 'R', 'C', 'R');
                $pdf->SetAligns($aligns);
                $anchos = array(0.1/* 0 */, 134.9/* 1 */, 20/* 2 */, 15/* 3 */, 15/* 3 */);
                $pdf->SetWidths($anchos);
                $pdf->Row(array('', utf8_decode('Total por Artículo:'), '', '', $Total_M), 'T');
            }
            /* Total general */
            $pdf->SetX(70);
            $pdf->SetFont('Calibri', 'B', 9);
            $aligns = array('L', 'R', 'R', 'C', 'R');
            $pdf->SetAligns($aligns);

            $anchos = array(0.1/* 0 */, 134.9/* 1 */, 20/* 2 */, 15/* 3 */, 15/* 3 */);
            $pdf->SetWidths($anchos);
            $pdf->Row(array('', utf8_decode('Total general:'), '', '', $Total_G), 'T');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/CajasXControl';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTREGA CAJAS POR CONTROL " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/CajasXControl/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
