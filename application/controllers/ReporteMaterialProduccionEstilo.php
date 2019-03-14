<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteMaterialProduccionEstilo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteMaterialProduccionEstilo_model')
                ->helper('Reportematerialsemanaprodestilo_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function getArticulos() {
        try {
            print json_encode($this->ReporteMaterialProduccionEstilo_model->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosXDepto() {
        try {
            print json_encode($this->ReporteMaterialProduccionEstilo_model->getArticulosXDepto($this->input->get('Tipo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function onReporteMaterialSemanaProdEstilo() {
        $Controles = $this->ReporteMaterialProduccionEstilo_model->onImprimirReporte($this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Articulo'));
        if (!empty($Controles)) {
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $Subtotal = 0;
            foreach ($Controles as $keyFT => $F) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8.5);


                $pdf->Row(array(
                    utf8_decode($F->ControlT),
                    utf8_decode($F->Estilo),
                    utf8_decode($F->Color),
                    mb_strimwidth(utf8_decode($F->Articulo . '   ' . $F->ArticuloT), 0, 70, ""),
                    number_format($F->Cantidad, 2, ".", ","),
                    utf8_decode($F->UnidadMedidaT),
                    utf8_decode($F->Pares)
                        ), 'B');
                $Subtotal += $F->Cantidad;
            }
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->Row(array(
                '',
                '',
                '',
                'Total',
                number_format($Subtotal, 2, ".", ","),
                '',
                ''
                    ), 0);


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/MaterialSemanaProdEstilo';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "MATERIAL DE LA SEMANA PROD POR ESTILO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/MaterialSemanaProdEstilo/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteMaterialSemanaDesgloseProdEstilo() {
        $Controles = $this->ReporteMaterialProduccionEstilo_model->onImprimirReporteDesglosado(
                $this->input->post('Ano'), $this->input->post('dSem'), $this->input->post('aSem'), $this->input->post('Articulo'));
        if (!empty($Controles)) {
            $pdf = new PDFDesglose('P', 'mm', array(215.9, 279.4));

            $pdf->setAno($this->input->post('Ano'));
            $pdf->setAsem($this->input->post('aSem'));
            $pdf->setDsem($this->input->post('dSem'));

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 7);


            $pdf->SetLineWidth(0.5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(80, 5, utf8_decode($Controles[0]->Articulo . '   ' . $Controles[0]->ArticuloT . '  ======> ' . $Controles[0]->UnidadMedidaT), 'B'/* BORDE */, 1, 'L');

            $Subtotal = 0;
            $Pares = 0;
            $pdf->SetLineWidth(0.2);
            foreach ($Controles as $keyFT => $F) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);

                $pdf->Row(array(
                    '',
                    $F->ControlT,
                    $F->Pedido,
                    $F->FechaEntrega,
                    $F->Estilo,
                    $F->Clave,
                    mb_strimwidth(utf8_decode($F->Cliente), 0, 43, ""),
                    $F->Semana,
                    $F->Maquila,
                    number_format($F->Cantidad, 2, ".", ","),
                    $F->Pares), 'B');

                $Subtotal += $F->Cantidad;
                $Pares += $F->Pares;
            }
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Row(array(
                '',
                '',
                '',
                '',
                '',
                '',
                'Total general:',
                '',
                '',
                number_format($Subtotal, 2, ".", ","),
                $Pares), 0);



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/MaterialSemanaProdEstilo';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "MATERIAL DE LA SEMANA PROD POR ESTILO Y CLIENTE" . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/MaterialSemanaProdEstilo/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
