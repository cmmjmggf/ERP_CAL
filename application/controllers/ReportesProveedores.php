<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesProveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReportesProveedores_model')
                ->helper('Reportesproveedores_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onVerificarProveedor() {
        try {
            $Proveedor = $this->input->get('Proveedor');
            print json_encode($this->db->query("select clave from proveedores where clave = '$Proveedor ' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->ReportesProveedores_model->onComprobarMaquilas($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->ReportesProveedores_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteCostoMaterialesMaqFecha() {

        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');
        $maq = $this->input->post('Maq');
        $conPrecioActual = $this->input->post('ConPrecioActual');

        $cm = $this->ReportesProveedores_model;
        $Grupos = $cm->getGruposCostoMaterialMaqFecha($fecha, $aFecha, $maq);
        if ($conPrecioActual === '1') {
            $Articulos = $cm->getArticulosCostoMaterialMaqFechaPrecioActual($fecha, $aFecha, $maq);
        } else {
            $Articulos = $cm->getArticulosCostoMaterialMaqFecha($fecha, $aFecha, $maq);
        }


        if (!empty($Grupos)) {

            $pdf = new PDFCostosMateriales('P', 'mm', array(215.9, 279.4));

            $pdf->Fecha = $fecha;
            $pdf->Afecha = $aFecha;
            $pdf->Maq = $maq;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);


            $IMPORTE_G = 0;
            foreach ($Grupos as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Cell(15, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8.5);
                $pdf->Cell(50, 4, utf8_decode($G->Grupo), 'B'/* BORDE */, 1, 'L');


                $IMPORTE = 0;
                $pdf->SetFont('Calibri', '', 8.5);
                foreach ($Articulos as $key => $D) {
                    if ($G->Clave === $D->ClaveGpo) {
                        $pdf->Row(array(
                            utf8_decode($D->Clave),
                            mb_strimwidth(utf8_decode($D->Descripcion), 0, 45, ""),
                            utf8_decode($D->Unidad),
                            utf8_decode($D->Tp),
                            number_format($D->CantidadMov, 2, ".", ","),
                            '$' . number_format($D->PrecioMov, 2, ".", ","),
                            '$' . number_format($D->Subtotal, 2, ".", ","),
                            mb_strimwidth(utf8_decode($D->DocMov), 0, 12, ""),
                            utf8_decode($D->FechaMov),
                            utf8_decode($D->Maq),
                            utf8_decode($D->Sem)
                                ), 0);

                        $IMPORTE += $D->Subtotal;
                        $IMPORTE_G += $D->Subtotal;
                    }
                }
                $pdf->SetX(85);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Cell(70, 4, utf8_decode('TOTAL POR PROVEEDOR: '), 0/* BORDE */, 0, 'L');

                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '$' . number_format($IMPORTE, 2, ".", ","),
                    '',
                    '',
                    '',
                    ''
                        ), 'T');
            }
            $pdf->SetX(85);
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->Cell(70, 4, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->Row(array(
                '',
                '',
                '',
                '',
                '',
                '',
                '$' . number_format($IMPORTE_G, 2, ".", ","),
                '',
                '',
                '',
                ''
                    ), 'T');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "RELACION PAGOS POR PROVEEDOR " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteRecibosEfectivoProv() {

        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');

        $cm = $this->ReportesProveedores_model;
        $Proveedores = $cm->getProveedoresReporteRecibosEfectivo($fecha, $aFecha);
        $Doctos = $cm->getDocsReporteRecibosEfectivo($fecha, $aFecha);

        if (!empty($Proveedores)) {

            $pdf = new PDFRecibosEfectivo('P', 'mm', array(215.9, 279.4));
            foreach ($Proveedores as $key => $G) {
                $pdf->AddPage();
                $pdf->SetAutoPageBreak(true, 10);
                $pdf->SetFont('Calibri', '', 9.5);

                $TP_IMPORTE = 0;
                foreach ($Doctos as $key => $D) {
                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->RowNoBorder(array(
                            utf8_decode($D->Factura),
                            '$' . number_format($D->Importe, 2, ".", ","),
                            '',
                            mb_strimwidth(utf8_decode($D->DocPago), 0, 40, "")
                        ));

                        $TP_IMPORTE += $D->Importe;
                    }
                }

                $pdf->SetY($pdf->GetY() + 5);
                $pdf->SetX(45);
                $pdf->SetFont('Calibri', 'B', 11);

                $pdf->MultiCell(140, 4, utf8_decode('Recibí del ' . $_SESSION["EMPRESA_REPRESENTANTE"] . ' la cantidad de $' . number_format($TP_IMPORTE, 2, ".", ",")
                                . ' por el concepto de PAGO DE DOCUMENTOS ANTES MENCIONADOS.'), 0/* BORDE */, 'J');

                $pdf->SetY($pdf->GetY() + 20);
                $pdf->SetFont('Calibri', '', 11);

                $pdf->SetX(30);
                $pdf->Cell(60, 5, utf8_decode($_SESSION["EMPRESA_REPRESENTANTE"]), 'T'/* BORDE */, 0, 'C');
                $pdf->SetX(125);
                $pdf->Cell(60, 5, utf8_decode($G->ProveedorF), 'T'/* BORDE */, 0, 'C');

                $pdf->SetFont('Calibri', 'B', 11);
                $pdf->SetY($pdf->GetY() + 5);
                $pdf->SetX(30);
                $pdf->Cell(60, 5, utf8_decode('ENTREGA'), 0/* BORDE */, 0, 'C');
                $pdf->SetX(125);
                $pdf->Cell(60, 5, utf8_decode('RECIBE'), 0/* BORDE */, 0, 'C');
            }



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "RECIBOS DE PAGO EN EFECTIVO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteRelacionPagos() {

        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');

        $cm = $this->ReportesProveedores_model;
        $Proveedores = $cm->getProveedoresReporteRelacionPagos($fecha, $aFecha);
        $Doctos = $cm->getPagosByProveedor($fecha, $aFecha);


        if (!empty($Proveedores)) {

            $pdf = new PDFRelacionPagos('P', 'mm', array(215.9, 279.4));

            $pdf->Fecha = $fecha;
            $pdf->Afecha = $aFecha;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            $TP_IMPORTE_G = 0;
            foreach ($Proveedores as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(80, 5, utf8_decode($G->ProveedorF), 'B'/* BORDE */, 1, 'L');


                $TP_IMPORTE = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->Row(array(
                            utf8_decode($D->Tp),
                            utf8_decode($D->Factura),
                            utf8_decode($D->Fecha),
                            '$' . number_format($D->Importe, 2, ".", ","),
                            mb_strimwidth(utf8_decode($D->DocPago), 0, 40, "")
                        ));

                        $TP_IMPORTE += $D->Importe;
                        $TP_IMPORTE_G += $D->Importe;
                    }
                }
                $pdf->SetX(85);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(70, 5, utf8_decode('TOTAL POR PROVEEDOR: '), 0/* BORDE */, 0, 'L');

                $pdf->RowNoBorder(array(
                    '',
                    '',
                    '',
                    '$' . number_format($TP_IMPORTE, 2, ".", ","),
                    '',
                ));
            }
            $pdf->SetX(85);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(70, 5, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                '$' . number_format($TP_IMPORTE_G, 2, ".", ","),
                '',
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "RELACION PAGOS POR PROVEEDOR " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteAntiguedadSaldos() {
        $Tp = $this->input->post('Tp');
        $Prov = $this->input->post('Proveedor');
        $aProv = $this->input->post('aProveedor');

        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');

        $cm = $this->ReportesProveedores_model;
        $Proveedores = $cm->getProveedoresReporteAntiguedad($Prov, $aProv, $Tp, $fecha, $aFecha);
        $Doctos = $cm->getDoctosByProveedorTpAntiguedad($Prov, $aProv, $Tp, $fecha, $aFecha);


        if (!empty($Proveedores)) {

            $pdf = new PDFAntiguedadProv('L', 'mm', array(215.9, 279.4));
            $pdf->Proveedor = $Prov;
            $pdf->Aproveedor = $aProv;
            $pdf->fecha = $fecha;
            $pdf->Afecha = $aFecha;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $TP_IMPORTE_G = 0;
            $TP_PAGOS_G = 0;
            $TP_SALDO_G = 0;

            $GTOTAL_1 = 0;
            $GTOTAL_2 = 0;
            $GTOTAL_3 = 0;
            $GTOTAL_4 = 0;
            $GTOTAL_5 = 0;
            $GTOTAL_6 = 0;
            $GTOTAL_7 = 0;
            $GTOTAL_8 = 0;
            $GTOTAL_9 = 0;

            foreach ($Proveedores as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Times', '', 7.8);
                $pdf->SetLineWidth(0.5);
                $pdf->Cell(90, 6, utf8_decode($G->ProveedorF . ' =====> PLAZO: ' . $G->Plazo . ' DÍAS'), 'B'/* BORDE */, 1, 'L');
                $pdf->SetLineWidth(0.2);

                $TP_IMPORTE = 0;
                $TP_PAGOS = 0;
                $TP_SALDO = 0;

                $TOTAL_1 = 0;
                $TOTAL_2 = 0;
                $TOTAL_3 = 0;
                $TOTAL_4 = 0;
                $TOTAL_5 = 0;
                $TOTAL_6 = 0;
                $TOTAL_7 = 0;
                $TOTAL_8 = 0;
                $TOTAL_9 = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->Row(array(
                            utf8_decode($D->Tp),
                            mb_strimwidth(utf8_decode($D->Doc), 0, 6, ""),
                            utf8_decode($D->FechaDoc),
                            '$' . number_format($D->ImporteDoc, 2, ".", ","),
                            '$' . number_format($D->Pagos_Doc, 2, ".", ","),
                            '$' . number_format($D->Saldo_Doc, 2, ".", ","),
                            utf8_decode($D->Dias),
                            ($D->UNO > 0) ? '$' . number_format($D->UNO, 2, ".", ",") : '',
                            ($D->DOS > 0) ? '$' . number_format($D->DOS, 2, ".", ",") : '',
                            ($D->TRES > 0) ? '$' . number_format($D->TRES, 2, ".", ",") : '',
                            ($D->CUATRO > 0) ? '$' . number_format($D->CUATRO, 2, ".", ",") : '',
                            ($D->CINCO > 0) ? '$' . number_format($D->CINCO, 2, ".", ",") : '',
                            ($D->SEIS > 0) ? '$' . number_format($D->SEIS, 2, ".", ",") : '',
                            ($D->SIETE > 0) ? '$' . number_format($D->SIETE, 2, ".", ",") : '',
                            ($D->OCHO > 0) ? '$' . number_format($D->OCHO, 2, ".", ",") : '',
                            ($D->NUEVE > 0) ? '$' . number_format($D->NUEVE, 2, ".", ",") : ''
                        ));

                        $TP_IMPORTE += $D->ImporteDoc;
                        $TP_PAGOS += $D->Pagos_Doc;
                        $TP_SALDO += $D->Saldo_Doc;
                        $TP_IMPORTE_G += $D->ImporteDoc;
                        $TP_PAGOS_G += $D->Pagos_Doc;
                        $TP_SALDO_G += $D->Saldo_Doc;
                        $TOTAL_1 += $D->UNO;
                        $TOTAL_2 += $D->DOS;
                        $TOTAL_3 += $D->TRES;
                        $TOTAL_4 += $D->CUATRO;
                        $TOTAL_5 += $D->CINCO;
                        $TOTAL_6 += $D->SEIS;
                        $TOTAL_7 += $D->SIETE;
                        $TOTAL_8 += $D->OCHO;
                        $TOTAL_9 += $D->NUEVE;
                        $GTOTAL_1 += $D->UNO;
                        $GTOTAL_2 += $D->DOS;
                        $GTOTAL_3 += $D->TRES;
                        $GTOTAL_4 += $D->CUATRO;
                        $GTOTAL_5 += $D->CINCO;
                        $GTOTAL_6 += $D->SEIS;
                        $GTOTAL_7 += $D->SIETE;
                        $GTOTAL_8 += $D->OCHO;
                        $GTOTAL_9 += $D->NUEVE;
                    }
                }
                $pdf->SetX(5);
                $pdf->SetFont('Times', 'B', 7.8);
                $pdf->Cell(70, 4, utf8_decode('TOTAL POR PROVEEDOR: '), 0/* BORDE */, 0, 'L');

                $pdf->RowNoBorder(array(
                    '',
                    '',
                    '',
                    mb_strimwidth('$' . number_format($TP_IMPORTE, 2, ".", ","), 0, 12, ""),
                    mb_strimwidth('$' . number_format($TP_PAGOS, 2, ".", ","), 0, 12, ""),
                    mb_strimwidth('$' . number_format($TP_SALDO, 2, ".", ","), 0, 12, ""),
                    '',
                    ($TOTAL_1 > 0) ? mb_strimwidth('$' . number_format($TOTAL_1, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_2 > 0) ? mb_strimwidth('$' . number_format($TOTAL_2, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_3 > 0) ? mb_strimwidth('$' . number_format($TOTAL_3, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_4 > 0) ? mb_strimwidth('$' . number_format($TOTAL_4, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_5 > 0) ? mb_strimwidth('$' . number_format($TOTAL_5, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_6 > 0) ? mb_strimwidth('$' . number_format($TOTAL_6, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_7 > 0) ? mb_strimwidth('$' . number_format($TOTAL_7, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_8 > 0) ? mb_strimwidth('$' . number_format($TOTAL_8, 2, ".", ","), 0, 12, "") : '',
                    ($TOTAL_9 > 0) ? mb_strimwidth('$' . number_format($TOTAL_9, 2, ".", ","), 0, 12, "") : ''
                ));
                $pdf->SetLineWidth(0.8);
                $pdf->Line(5, $pdf->GetY(), 274.9, $pdf->GetY());
                $pdf->SetLineWidth(0.2);
            }
            $pdf->SetX(5);
            $pdf->SetFont('Times', 'B', 7.8);
            $pdf->Cell(70, 4, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                mb_strimwidth('$' . number_format($TP_IMPORTE_G, 2, ".", ","), 0, 12, ""),
                mb_strimwidth('$' . number_format($TP_PAGOS_G, 2, ".", ","), 0, 12, ""),
                mb_strimwidth('$' . number_format($TP_SALDO_G, 2, ".", ","), 0, 12, ""),
                '',
                ($GTOTAL_1 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_1, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_2 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_2, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_3 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_3, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_4 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_4, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_5 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_5, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_6 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_6, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_7 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_7, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_8 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_8, 2, ".", ","), 0, 12, "") : '',
                ($GTOTAL_9 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_9, 2, ".", ","), 0, 12, "") : ''
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ANTIGUEDAD SALDOS " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteEdosCuentaDesgloce() {
        $Tp = $this->input->post('Tp');
        $Prov = $this->input->post('Proveedor');
        $aProv = $this->input->post('aProveedor');


        $cm = $this->ReportesProveedores_model;
        $Proveedores = $cm->getProveedoresReporte($Prov, $aProv, $Tp);
        $Doctos = $cm->getDoctosByProveedorTp($Prov, $aProv, $Tp);


        if (!empty($Proveedores)) {

            $pdf = new PDFEdoCtaProv('P', 'mm', array(215.9, 279.4));
            $pdf->Proveedor = $Prov;
            $pdf->Aproveedor = $aProv;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $TP_IMPORTE_G = 0;
            $TP_PAGOS_G = 0;
            $TP_SALDO_G = 0;
            foreach ($Proveedores as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(70, 4, utf8_decode(mb_strimwidth(utf8_decode($G->ProveedorF), 0, 60, "")), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(75);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(10, 4, utf8_decode($G->Plazo), 'B'/* BORDE */, 1, 'C');

                $TP_IMPORTE = 0;
                $TP_PAGOS = 0;
                $TP_SALDO = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->Row(array(
                            utf8_decode($D->Tp),
                            utf8_decode($D->Doc),
                            utf8_decode($D->FechaDoc),
                            '$' . number_format($D->ImporteDoc, 2, ".", ","),
                            '$' . number_format($D->Pagos_Doc, 2, ".", ","),
                            '$' . number_format($D->Saldo_Doc, 2, ".", ","),
                            utf8_decode($D->Dias)
                        ));

                        $TP_IMPORTE += $D->ImporteDoc;
                        $TP_PAGOS += $D->Pagos_Doc;
                        $TP_SALDO += $D->Saldo_Doc;
                        $TP_IMPORTE_G += $D->ImporteDoc;
                        $TP_PAGOS_G += $D->Pagos_Doc;
                        $TP_SALDO_G += $D->Saldo_Doc;
                    }
                }
                $pdf->SetX(95);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(70, 4, utf8_decode('TOTAL POR PROVEEDOR: '), 0/* BORDE */, 0, 'L');

                $pdf->RowNoBorder(array(
                    '',
                    '',
                    '',
                    '$' . number_format($TP_IMPORTE, 2, ".", ","),
                    '$' . number_format($TP_PAGOS, 2, ".", ","),
                    '$' . number_format($TP_SALDO, 2, ".", ","),
                    '',
                ));
            }
            $pdf->SetX(95);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(70, 4, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                '$' . number_format($TP_IMPORTE_G, 2, ".", ","),
                '$' . number_format($TP_PAGOS_G, 2, ".", ","),
                '$' . number_format($TP_SALDO_G, 2, ".", ","),
                '',
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EDO CTA PROVEEDORES DESGLOSADO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteEdosCuenta() {
        $Tp = $this->input->post('Tp');
        $Prov = $this->input->post('Proveedor');
        $aProv = $this->input->post('aProveedor');


        $cm = $this->ReportesProveedores_model;
        $Proveedores = $cm->getProveedoresReporte($Prov, $aProv, $Tp);
        $Doctos = $cm->getDoctosByProveedorTp($Prov, $aProv, $Tp);


        if (!empty($Proveedores)) {

            $pdf = new PDFEdoCtaProvSinDesgloce('P', 'mm', array(215.9, 279.4));
            $pdf->Proveedor = $Prov;
            $pdf->Aproveedor = $aProv;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $TP_IMPORTE_G = 0;
            $TP_PAGOS_G = 0;
            $TP_SALDO_G = 0;
            foreach ($Proveedores as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(70, 4, utf8_decode(mb_strimwidth(utf8_decode($G->ProveedorF), 0, 60, "")), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(75);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(10, 4, utf8_decode($G->Plazo), 'B'/* BORDE */, 0, 'C');

                $TP_IMPORTE = 0;
                $TP_PAGOS = 0;
                $TP_SALDO = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {


                        $TP_IMPORTE += $D->ImporteDoc;
                        $TP_PAGOS += $D->Pagos_Doc;
                        $TP_SALDO += $D->Saldo_Doc;
                        $TP_IMPORTE_G += $D->ImporteDoc;
                        $TP_PAGOS_G += $D->Pagos_Doc;
                        $TP_SALDO_G += $D->Saldo_Doc;
                    }
                }
                $pdf->SetX(55);
                $pdf->SetFont('Calibri', 'B', 8);


                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '$' . number_format($TP_IMPORTE, 2, ".", ","),
                    '$' . number_format($TP_PAGOS, 2, ".", ","),
                    '$' . number_format($TP_SALDO, 2, ".", ","),
                    '',
                ));
            }
            $pdf->SetX(75);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(70, 5, utf8_decode('TOTAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                '$' . number_format($TP_IMPORTE_G, 2, ".", ","),
                '$' . number_format($TP_PAGOS_G, 2, ".", ","),
                '$' . number_format($TP_SALDO_G, 2, ".", ","),
                '',
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EDO CTA PROVEEDORES " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
