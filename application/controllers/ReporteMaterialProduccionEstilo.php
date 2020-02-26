<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}

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
            $pdf->setAno($this->input->post('Ano'));
            $pdf->setSem($this->input->post('Sem'));
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $Subtotal = 0;
            $Pares = 0;
            foreach ($Controles as $keyFT => $F) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8.5);


                $pdf->Row(array(
                    utf8_decode($F->ControlT),
                    utf8_decode($F->Estilo),
                    utf8_decode($F->Color),
                    mb_strimwidth(utf8_decode($F->Articulo . '   ' . $F->ArticuloT), 0, 70, ""),
                    number_format($F->Cantidad, 2, ".", ","),
                    utf8_decode($F->Unidad),
                    utf8_decode($F->Pares)
                        ), 'B');
                $Subtotal += $F->Cantidad;
                $Pares += $F->Pares;
            }
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->Row(array(
                '',
                '',
                '',
                'Total',
                number_format($Subtotal, 2, ".", ","),
                '',
                number_format($Pares, 0, ".", ",")
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
                $this->input->post('Ano'), $this->input->post('dSem'), $this->input->post('aSem'), $this->input->post('Articulo'), $this->input->post('Tipo'), $this->input->post('Estatus'));
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
            $pdf->Cell(80, 5, utf8_decode($Controles[0]->Articulo . '   ' . $Controles[0]->ArticuloT), 'B'/* BORDE */, 1, 'L');

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
                    mb_strimwidth(utf8_decode($F->Cliente), 0, 42, ""),
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
                number_format($Pares, 0, ".", ",")), 0);



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

    public function onReporteMaterialSemanaDesgloseProdEstiloExcel() {
        $Sem = $this->input->post('dSem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');
        $Controles = $this->ReporteMaterialProduccionEstilo_model->onImprimirReporteDesglosado(
                $Ano, $Sem, $aSem, $this->input->post('Articulo'), $this->input->post('Tipo'), $this->input->post('Estatus'));
        if (!empty($Controles)) {

            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Ancho de columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("35");

            // Encabezado
            $from = "A1";
            $to = "V5";
            $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, utf8_decode($_SESSION["EMPRESA_RAZON"]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'FECHA:');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, Date('d/m/Y H:i:s'));

            //nombre reporte
            $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Programación por Artículo de la sem: " . $Sem . " a la sem: " . $aSem . " del año: " . $Ano);

            //Filtro
            $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Artículo');
            $objPHPExcel->getActiveSheet()->setCellValue('C3', utf8_decode($Controles[0]->Articulo . '   ' . $Controles[0]->ArticuloT));

            //titulos 1
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Control');
            $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Pedido');
            $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Entrega');
            $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Estilo');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:F5');
            $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Cliente');
            $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Sem');
            $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Maq');
            $objPHPExcel->getActiveSheet()->setCellValue('I5', 'Cantidad');
            $objPHPExcel->getActiveSheet()->setCellValue('J5', 'Pares');

            $Subtotal = 0;
            $Pares = 0;
            $row = 6;

            foreach ($Controles as $keyFT => $F) {
                $objPHPExcel->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $F->ControlT);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $F->Pedido);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $F->FechaEntrega);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $F->Estilo);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $F->Clave);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $F->Cliente);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $F->Semana);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $F->Maquila);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $F->Cantidad);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $F->Pares);
                $Subtotal += $F->Cantidad;
                $Pares += $F->Pares;
                $row++;
            }
            $objPHPExcel->getActiveSheet()->getStyle("A$row:J$row")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, 'Total por Articulo');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $Subtotal);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $Pares);

            /* FIN RESUMEN */

            $path = 'uploads/Reportes/MaterialSemanaProdEstilo';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "PROGRAMACION POR ARTICULO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/MaterialSemanaProdEstilo/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        }
    }

}
