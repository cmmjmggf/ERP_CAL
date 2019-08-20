<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AuxReportesClientesDos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->helper('jaspercommand_helper')
                ->helper('file')
                ->model('AplicaDepositosCliente_model', 'adc')
                ->helper('Reportesclientes_helper')->helper('file');
    }

    public function getPedidosXAgenteFechaCaptura() {
        try {
            $Agente = $this->input->get('Agente');

            $fechaini = str_replace('/', '-', $this->input->get('FechaIni'));
            $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));
            $fechafin = str_replace('/', '-', $this->input->get('FechaFin'));
            $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

            $query = "select
                                                cast(PE.Cliente as signed) AS Cliente,
                                                PE.Control,
                                                PE.Clave as Pedido,
                                                date_format(PE.Registro,'%d/%m/%Y') as FechaCaptura,
                                                PE.FechaPedido,
                                                PE.FechaEntrega,
                                                PE.Estilo,
                                                PE.Color,
                                                PE.ColorT,
                                                PE.Maquila,
                                                PE.Semana,
                                                CASE
                                                WHEN PE.Control = 0 OR PE.Control IS NULL THEN 0
                                                WHEN PE.Control > 0 AND C.EstatusProduccion IS NULL THEN 1
                                                WHEN PE.Control > 0 AND C.EstatusProduccion IS NOT NULL THEN CAST(D.Clave AS SIGNED)
                                                END AS Avance,
                                                CASE
                                                WHEN PE.Control = 0 OR PE.Control IS NULL THEN 'PRE-PROGRAMADO'
                                                WHEN PE.Control > 0 AND C.EstatusProduccion IS NULL THEN 'PROGRAMADO'
                                                WHEN PE.Control > 0 AND C.EstatusProduccion IS NOT NULL THEN D.Descripcion
                                                END AS AvanceT ,
                                                PE.Pares,
                                                PE.ParesFacturados
                                                from pedidox PE
                                                left join controles C on PE.Control =  C.control
                                                left join departamentos D on D.Descripcion  = C. EstatusProduccion
                                                where PE.estatus in ('A')
                                                and PE.agente = $Agente
                                                and PE.Registro between '$nuevaFechaIni' and '$nuevaFechaFin' ";
            //echo $query;
            print json_encode($this->db->query($query)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES EDOS DE CUENTA */

    public function onReporteAntiguedadSaldosTp1() {
        $Tp = 1;
        $Cte = $this->input->post('dClienteEdoCtaMasDias');
        $aCte = $this->input->post('aClienteEdoCtaMasDias');


        $Clientes = $this->getClientesReporteAntiguedad($Cte, $aCte, $Tp);
        $Doctos = $this->getDoctosByClientesTpAntiguedad($Cte, $aCte, $Tp);


        if (!empty($Clientes)) {

            $pdf = new PDFAntiguedadCliente('L', 'mm', array(215.9, 279.4));
            $pdf->Cliente = $Cte;
            $pdf->Acliente = $aCte;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

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
            $GPares = 0;

            foreach ($Clientes as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Times', 'B', 7.2);
                $pdf->SetLineWidth(0.5);
                $pdf->Cell(90, 6, utf8_decode($G->ClienteF . ' =====> PLAZO: ' . $G->Plazo . ' DÍAS'), 'B'/* BORDE */, 1, 'L');
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
                $Pares = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->SetFont('Times', '', 7.2);
                        $pdf->Row(array(
                            utf8_decode($D->Tp),
                            mb_strimwidth(utf8_decode($D->Doc), 0, 6, ""),
                            utf8_decode($D->FechaDoc),
                            '$' . number_format($D->ImporteDoc, 2, ".", ","),
                            ($D->Pagos_Doc > 0) ? '$' . number_format($D->Pagos_Doc, 2, ".", ",") : '',
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
                            ($D->NUEVE > 0) ? '$' . number_format($D->NUEVE, 2, ".", ",") : '',
                            ($D->pares > 0) ? $D->pares : '',
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
                        $Pares += $D->pares;
                        $GPares += $D->pares;
                    }
                }
                $pdf->SetX(5);
                $pdf->SetFont('Times', 'B', 7.2);
                $pdf->Cell(70, 4, utf8_decode('TOTAL POR CLIENTE: '), 0/* BORDE */, 0, 'L');

                $pdf->RowNoBorder(array(
                    '',
                    '',
                    '',
                    mb_strimwidth('$' . number_format($TP_IMPORTE, 2, ".", ","), 0, 14, ""),
                    mb_strimwidth('$' . number_format($TP_PAGOS, 2, ".", ","), 0, 14, ""),
                    mb_strimwidth('$' . number_format($TP_SALDO, 2, ".", ","), 0, 14, ""),
                    '',
                    ($TOTAL_1 > 0) ? mb_strimwidth('$' . number_format($TOTAL_1, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_2 > 0) ? mb_strimwidth('$' . number_format($TOTAL_2, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_3 > 0) ? mb_strimwidth('$' . number_format($TOTAL_3, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_4 > 0) ? mb_strimwidth('$' . number_format($TOTAL_4, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_5 > 0) ? mb_strimwidth('$' . number_format($TOTAL_5, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_6 > 0) ? mb_strimwidth('$' . number_format($TOTAL_6, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_7 > 0) ? mb_strimwidth('$' . number_format($TOTAL_7, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_8 > 0) ? mb_strimwidth('$' . number_format($TOTAL_8, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_9 > 0) ? mb_strimwidth('$' . number_format($TOTAL_9, 2, ".", ","), 0, 14, "") : '',
                    ($Pares > 0) ? $Pares : '',
                ));
                $pdf->SetLineWidth(0.8);
                $pdf->Line(5, $pdf->GetY(), 274.9, $pdf->GetY());
                $pdf->SetLineWidth(0.2);
            }
            $pdf->SetX(5);
            $pdf->SetFont('Times', 'B', 7.2);
            $pdf->Cell(70, 4, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                mb_strimwidth('$' . number_format($TP_IMPORTE_G, 2, ".", ","), 0, 14, ""),
                mb_strimwidth('$' . number_format($TP_PAGOS_G, 2, ".", ","), 0, 14, ""),
                mb_strimwidth('$' . number_format($TP_SALDO_G, 2, ".", ","), 0, 14, ""),
                '',
                ($GTOTAL_1 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_1, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_2 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_2, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_3 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_3, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_4 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_4, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_5 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_5, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_6 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_6, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_7 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_7, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_8 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_8, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_9 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_9, 2, ".", ","), 0, 14, "") : '',
                ($GPares > 0) ? $GPares : '',
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes/Tp1';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ANTIGUEDAD SALDOS CLIENTES TP1 " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/Tp1/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            return base_url() . $url;
        } else {
            return 0;
        }
    }

    public function onReporteAntiguedadSaldosTp2() {
        $Tp = 2;
        $Cte = $this->input->post('dClienteEdoCtaMasDias');
        $aCte = $this->input->post('aClienteEdoCtaMasDias');


        $Clientes = $this->getClientesReporteAntiguedad($Cte, $aCte, $Tp);
        $Doctos = $this->getDoctosByClientesTpAntiguedad($Cte, $aCte, $Tp);


        if (!empty($Clientes)) {

            $pdf = new PDFAntiguedadCliente('L', 'mm', array(215.9, 279.4));
            $pdf->Cliente = $Cte;
            $pdf->Acliente = $aCte;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

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
            $GPares = 0;

            foreach ($Clientes as $key => $G) {
                $pdf->SetX(5);
                $pdf->SetFont('Times', 'B', 7.2);
                $pdf->SetLineWidth(0.5);
                $pdf->Cell(90, 6, utf8_decode($G->ClienteF . ' =====> PLAZO: ' . $G->Plazo . ' DÍAS'), 'B'/* BORDE */, 1, 'L');
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
                $Pares = 0;
                foreach ($Doctos as $key => $D) {

                    if ($G->ClaveNum === $D->ClaveNum) {
                        $pdf->SetFont('Times', '', 7.2);
                        $pdf->Row(array(
                            utf8_decode($D->Tp),
                            mb_strimwidth(utf8_decode($D->Doc), 0, 6, ""),
                            utf8_decode($D->FechaDoc),
                            '$' . number_format($D->ImporteDoc, 2, ".", ","),
                            ($D->Pagos_Doc > 0) ? '$' . number_format($D->Pagos_Doc, 2, ".", ",") : '',
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
                            ($D->NUEVE > 0) ? '$' . number_format($D->NUEVE, 2, ".", ",") : '',
                            ($D->pares > 0) ? $D->pares : '',
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
                        $Pares += $D->pares;
                        $GPares += $D->pares;
                    }
                }
                $pdf->SetX(5);
                $pdf->SetFont('Times', 'B', 7.2);
                $pdf->Cell(70, 4, utf8_decode('TOTAL POR CLIENTE: '), 0/* BORDE */, 0, 'L');

                $pdf->RowNoBorder(array(
                    '',
                    '',
                    '',
                    mb_strimwidth('$' . number_format($TP_IMPORTE, 2, ".", ","), 0, 14, ""),
                    mb_strimwidth('$' . number_format($TP_PAGOS, 2, ".", ","), 0, 14, ""),
                    mb_strimwidth('$' . number_format($TP_SALDO, 2, ".", ","), 0, 14, ""),
                    '',
                    ($TOTAL_1 > 0) ? mb_strimwidth('$' . number_format($TOTAL_1, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_2 > 0) ? mb_strimwidth('$' . number_format($TOTAL_2, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_3 > 0) ? mb_strimwidth('$' . number_format($TOTAL_3, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_4 > 0) ? mb_strimwidth('$' . number_format($TOTAL_4, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_5 > 0) ? mb_strimwidth('$' . number_format($TOTAL_5, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_6 > 0) ? mb_strimwidth('$' . number_format($TOTAL_6, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_7 > 0) ? mb_strimwidth('$' . number_format($TOTAL_7, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_8 > 0) ? mb_strimwidth('$' . number_format($TOTAL_8, 2, ".", ","), 0, 14, "") : '',
                    ($TOTAL_9 > 0) ? mb_strimwidth('$' . number_format($TOTAL_9, 2, ".", ","), 0, 14, "") : '',
                    ($Pares > 0) ? $Pares : '',
                ));
                $pdf->SetLineWidth(0.8);
                $pdf->Line(5, $pdf->GetY(), 274.9, $pdf->GetY());
                $pdf->SetLineWidth(0.2);
            }
            $pdf->SetX(5);
            $pdf->SetFont('Times', 'B', 7.2);
            $pdf->Cell(70, 4, utf8_decode('TOTAL GENERAL: '), 0/* BORDE */, 0, 'L');

            $pdf->RowNoBorder(array(
                '',
                '',
                '',
                mb_strimwidth('$' . number_format($TP_IMPORTE_G, 2, ".", ","), 0, 14, ""),
                mb_strimwidth('$' . number_format($TP_PAGOS_G, 2, ".", ","), 0, 14, ""),
                mb_strimwidth('$' . number_format($TP_SALDO_G, 2, ".", ","), 0, 14, ""),
                '',
                ($GTOTAL_1 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_1, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_2 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_2, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_3 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_3, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_4 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_4, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_5 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_5, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_6 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_6, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_7 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_7, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_8 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_8, 2, ".", ","), 0, 14, "") : '',
                ($GTOTAL_9 > 0) ? mb_strimwidth('$' . number_format($GTOTAL_9, 2, ".", ","), 0, 14, "") : '',
                ($GPares > 0) ? $GPares : '',
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes/Tp2';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ANTIGUEDAD SALDOS CLIENTES TP2 " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/Tp2/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            return base_url() . $url;
        } else {
            return 0;
        }
    }

    public function onReporteEdoCta306090() {
        $Tp = $this->input->post('TpEdoCuentaMasDias');
        $reports = array();
        $reports['CARTERACLIENTESTP1'] = 0;
        $reports['CARTERACLIENTESTP2'] = 0;
        //Validamos que reporte se va a imprimir a si se imprimen los dos
        if ($Tp === '1') {
            $reports['CARTERACLIENTESTP1'] = $this->onReporteAntiguedadSaldosTp1();
        } else if ($Tp === '2') {
            $reports['CARTERACLIENTESTP2'] = $this->onReporteAntiguedadSaldosTp2();
        } else {
            $reports['CARTERACLIENTESTP1'] = $this->onReporteAntiguedadSaldosTp1();
            $reports['CARTERACLIENTESTP2'] = $this->onReporteAntiguedadSaldosTp2();
        }
        if ($reports['CARTERACLIENTESTP1'] === 0) {
            unset($reports['CARTERACLIENTESTP1']);
        }
        if ($reports['CARTERACLIENTESTP2'] === 0) {
            unset($reports['CARTERACLIENTESTP2']);
        }
        print json_encode($reports);
    }

    public function getClientesReporteAntiguedad($cte, $acte, $tp) {
        try {
            $dias = $this->input->post('DiasEdoCta');
            $this->db->query("SET sql_mode = '';");

            $query = "SELECT
                                    CAST(C.Clave AS SIGNED ) AS ClaveNum,
                                    C.DiasPlazo as Plazo,
                                    Ag.Clave as numagente,
                                    Ag.Nombre as nomagente,
                                    CONCAT(C.Clave,' ',IFNULL(C.RazonS,'')) AS ClienteF
                                    FROM cartcliente AS CC
                                    JOIN clientes AS C ON C.Clave =  CC.cliente
                                    join agentes Ag on Ag.Clave = C.Agente
                                    WHERE CC.status < 3
                                    and DATEDIFF(CURRENT_DATE(), CC.fecha) > $dias
                                    and CC.cliente BETWEEN $cte AND $acte
                                    and CC.tipo = $tp
                                    group by CC.cliente
                                    order by C.RazonS asc ";

            return $this->db->query($query)->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByClientesTpAntiguedad($cte, $acte, $tp) {
        try {
            $dias = $this->input->post('DiasEdoCta');
            $query = "SELECT CAST(CC.cliente AS SIGNED ) AS ClaveNum,
                                    Ag.Clave as numagente,
                                    Ag.Nombre as nomagente,
                                    CC.tipo as Tp,
                                    CC.remicion as Doc,
                                    date_format(CC.fecha,'%d/%m/%Y') as FechaDoc,
                                    CC.importe as ImporteDoc,
                                    CC.pagos as Pagos_Doc,
                                    CC.saldo as Saldo_Doc,
                                    IFNULL(DATEDIFF(CURDATE(), CC.fecha),'') AS Dias,
                                    (select sum(pareped) from facturacion where tp = CC.tipo and cliente = CC.cliente and factura = CC.remicion)as pares,
                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 0
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 8
                                            THEN CC.saldo END AS 'UNO',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 7
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 16
                                            THEN CC.saldo END AS 'DOS',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 15
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 22
                                            THEN CC.saldo END AS 'TRES',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 21
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 31
                                            THEN CC.saldo END AS 'CUATRO',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 30
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 38
                                            THEN CC.saldo END AS 'CINCO',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 37
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 46
                                            THEN CC.saldo END AS 'SEIS',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 45
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 53
                                            THEN CC.saldo END AS 'SIETE',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 52
                                                            AND  DATEDIFF(CURRENT_DATE(), CC.fecha) < 61
                                            THEN CC.saldo END AS 'OCHO',

                                    CASE WHEN DATEDIFF(CURRENT_DATE(), CC.fecha) > 60
                                            THEN CC.saldo END AS 'NUEVE'
                                        FROM cartcliente AS CC
                                        JOIN clientes AS C ON C.Clave =  CC.cliente
                                        join agentes Ag on Ag.Clave = C.Agente
                                        WHERE CC.status < 3
                                        and DATEDIFF(CURRENT_DATE(), CC.fecha) > $dias
                                        and CC.cliente BETWEEN $cte AND $acte
                                        and CC.tipo = $tp
                                        order by CC.fecha asc, CC.remicion asc ";
            return $this->db->query($query)->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
