<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesPreProgramados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ParesPreProgramados_model', 'pam')
                ->helper('parespreprogramados_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vParesPreProgramados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getParesPreProgramados() {
        try {
            $x = $this->input;
            switch (intval($x->post('TIPO'))) {
                case 1:
                    $this->getParesPreProgramadosCliente();
                    break;
                case 2:
                    $this->getParesPreProgramadosEstilo();
                    break;
                case 3:
                    $this->getParesPreProgramadosLineas();
                    break;
                case 4:
                    $this->getParesPreProgramadosMaquila();
                    break;
                case 5:
                    $this->getParesPreProgramadosSemanaMaquila();
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosCliente() {
        try {
            $x = $this->input;
            $xx = $this->input->post();
//            $CLIENTES = $this->pam->getClientes(  $x->post('FECHA'), $x->post('FECHAF'), $xx['ANIO']);

            $this->db->select('C.Clave AS CLAVE_CLIENTE, '
                            . 'C.RazonS AS CLIENTE, '
                            . 'A.Clave AS CLAVE_AGENTE, '
                            . 'A.Nombre AS AGENTE, '
                            . 'ES.Clave AS CLAVE_ESTADO, '
                            . 'ES.Descripcion AS ESTADO', false)
                    ->from('pedidox AS P')
                    ->join('clientes AS C', 'P.Cliente = C.Clave')
                    ->join('agentes AS A', 'C.Agente = A.Clave')
                    ->join('estados AS ES', 'C.Estado = ES.Clave')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('lineas AS L', 'E.Linea = L.Clave')
                    ->where("P.Registro BETWEEN STR_TO_DATE('{$xx['FECHA']}', \"%d/%m/%Y\") "
                            . "AND STR_TO_DATE('{$xx['FECHAF']}', \"%d/%m/%Y\") ")
                    ->where("P.Estatus = 'A'", null, false);

            $CLIENTES = $this->db->group_by('C.ID')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
//            print $this->db->last_query();

            $bordes = 0;
            $alto_celda = 4;
            $TIPO = $x->post('TIPO');
            $pdf = new PDFParesPreProCliente('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');


            $pdf->setFechai($x->post('FECHA'));
            $pdf->setFechaf($x->post('FECHAF'));
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 10;
            $YF = 0;

            foreach ($CLIENTES as $k => $v) {
                $this->db->select('C.Clave AS CLAVE_CLIENTE,
                    C.RazonS AS  CLIENTE, A.Clave AS CLAVE_AGENTE,
                    A.Nombre AS AGENTE, ES.Descripcion AS ESTADO,P.Clave AS PEDIDO,
                    E.Linea AS CLAVE_LINEA, L.Descripcion AS LINEA, P.Estilo AS CLAVE_ESTILO,
                    CO.Descripcion AS COLOR,P.FechaEntrega AS FECHA_ENTREGA,
                    P.Pares AS PARES, P.Maquila AS MAQUILA, P.Semana AS SEMANA, C.Pais AS PAIS', false)
                        ->from('pedidox AS P')
                        ->join('clientes AS C', 'P.Cliente = C.Clave')
                        ->join('agentes AS A', 'P.Agente = A.Clave')
                        ->join('estilos AS E', 'P.Estilo = E.Clave')
                        ->join('colores AS CO', 'E.Clave = CO.Estilo AND P.Color = CO.Clave')
                        ->join('lineas AS L', 'E.Linea = L.Clave')
                        ->join('estados AS ES', 'C.Estado = ES.Clave')
                        ->where("C.Clave", $v->CLAVE_CLIENTE);
// ->where("C.Clave", 371);
                $this->db->where("P.Registro BETWEEN str_to_date(\"{$x->post("FECHA")}\",\"%d/%m/%Y\")  AND str_to_date(\"{$x->post("FECHAF")}\" ,\"%d/%m/%Y\") ", null, false);
                $this->db->order_by('CLAVE_LINEA', 'ASC');
                $this->db->order_by('CLAVE_ESTILO', 'ASC');
                $this->db->order_by('COLOR', 'ASC');

                $PARES_PREPROGRAMADOS = $this->db->get()->result();
//                print $this->db->last_query();
//                exit(0);
                if (count($PARES_PREPROGRAMADOS) > 0) {
                    $Y = $pdf->GetY();
                    $pdf->SetFont('Calibri', 'B', 7);
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('L', 'L', 'C'));
                    $pdf->SetWidths(array(43/* 0 */, 35/* 1 */, 22/* 2 */));
                    $pdf->RowNoBorder(array(substr(utf8_decode($v->CLAVE_CLIENTE . " " . $v->CLIENTE), 0, 30)/* 0 */,
                        utf8_decode($v->CLAVE_AGENTE . " " . $v->AGENTE)/* 1 */, /* SI NO TIENE AGENTE O ESTA EN CERO, ES UNA MUESTRA */
                        utf8_decode($v->ESTADO)));
                    $pdf->Line(10, $pdf->GetY(), 110, $pdf->GetY());
//                $PARES_PREPROGRAMADOS = $this->pam->getParesPreProgramados($v->CLAVE_CLIENTE, 1, $x->post('CLIENTE'), $x->post('ESTILO'), $x->post('LINEA'), 1/* MAQUILA = 1 */, $x->post('SEMANA'), $x->post('FECHA'), $x->post('FECHAF'), $xx['ANIO']);


                    $bordes = 0;
                    $pdf->SetFont('Calibri', 'B', 6.5);
                    foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                        $Y = $pdf->GetY();
                        $pdf->SetX($spacex);
                        $pdf->setFilled(0);
                        $pdf->setBorders(1);
                        $pdf->SetAligns(array('C', 'C'/* 0 */, 'L'/* 1 */, 'C'/* 2 */, 'L'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */));
                        $pdf->SetWidths(array(100, 15/* 0 */, 23/* 1 */, 12/* 2 */, 43/* 3 */, 20/* 4 */, 16/* 5 */, 15/* 6 */, 15/* 7 */));
                        $pdf->RowNoBorder(array('', utf8_decode($vv->PEDIDO)/* 0 */,
                            utf8_decode($vv->CLAVE_LINEA . " " . $vv->LINEA)/* 1 */,
                            utf8_decode($vv->CLAVE_ESTILO)/* 2 */,
                            substr(utf8_decode($vv->COLOR), 0, 28)/* 3 */,
                            utf8_decode($vv->FECHA_ENTREGA)/* 4 */,
                            utf8_decode($vv->PARES)/* 5 */,
                            utf8_decode($vv->MAQUILA)/* 6 */,
                            utf8_decode($vv->SEMANA)/* 7 */));
                        $pdf->Line(110, $pdf->GetY(), 269, $pdf->GetY());
                        $spacex = 10;
                        $PARES += $vv->PARES;
                        $TOTAL_PARES += $vv->PARES;
                    }

                    $bordes = 0;
                    $pdf->SetFont('Calibri', 'B', 8.5);
                    $pdf->SetX(178);
                    $pdf->Cell(45, $alto_celda, "Total por cliente", $bordes/* BORDE */, 0/* SALTO */, 'R', 0);
                    $pdf->SetX(223);
                    $pdf->Cell(16, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C', 0);
                    $PARES = 0;
                }
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetX(178);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'R', 0);
            $pdf->SetX(223);
            $pdf->Cell(16, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosCliente" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosEstilo() {
        try {
            $x = $this->input;
            $xx = $this->input->post();
            $xxx = $this->input->post();

            $this->db->select(' P.Ano,P.Estilo AS CLAVE_ESTILO, P.ColorT AS COLOR', false)
                    ->from('pedidox AS P');
            if ($xxx['ESTILO'] !== '') {
//                $this->db->where('P.Estilo', $xxx['ESTILO']);
            }
            if ($xxx['CLIENTE'] !== '') {
                $this->db->where('P.Cliente', $xxx['CLIENTE']);
            }
            if ($xxx['MAQUILA'] !== '') {
                $this->db->where("P.Maquila", $xxx['MAQUILA']);
            }
            if ($xxx['SEMANA'] !== '') {
                $this->db->where("P.Semana", $xxx['SEMANA']);
            }
            $this->db->where("P.Control = 0  AND P.stsavan NOT IN(13,14)", null, false);
            $ESTILOS = $this->db->group_by('P.Estilo')->order_by('ABS(P.Estilo)', 'ASC')->get()->result();
//            var_dump($ESTILOS);
//            exit(0);
            $bordes = 0;
            $alto_celda = 4;
            $TIPO = $x->post('TIPO');
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));

            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $pdf->setTipoEncabezado(2);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 65;
            $YF = 0;
            foreach ($ESTILOS as $k => $v) {
                $Y = $pdf->GetY();
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->SetX(10);
                $pdf->setFilled(0);
                $pdf->setBorders(0);
                $pdf->SetAligns(array('C', 'L', 'C'));
                $pdf->SetWidths(array(15/* 0 */, 40/* 1 */, 20/* 2 */));
                $pdf->RowNoBorder(array(utf8_decode($v->CLAVE_ESTILO)/* 0 */, utf8_decode($v->COLOR)/* 1 */));
                $pdf->Line(10, $pdf->GetY(), 65, $pdf->GetY());
                $PARES_PREPROGRAMADOS = $this->pam->getParesPreProgramados($v->CLAVE_ESTILO, 2,
                        $x->post('CLIENTE'), $x->post('ESTILO'),
                        $x->post('LINEA'), $x->post('MAQUILA'),
                        $x->post('SEMANA'), $x->post('FECHA'),
                        $x->post('FECHAF'), $xx['ANIO']);
//                var_dump($PARES_PREPROGRAMADOS);
//                exit(0);
                $bordes = 0;
                $pdf->SetX(65);
                foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                    $Y = $pdf->GetY();
                    $spacex = 65;
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('C', 'L'/* 0 */, 'L'/* 1 */, 'C'/* 2 */, 'C'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */, 'C'/* 8 */, 'C'/* 9 */));
                    $pdf->SetWidths(array(55, 43/* 0 */, 35/* 1 */, 25/* 2 */, 15/* 3 */, 20/* 4 */, 20/* 5 */, 15/* 6 */, 16/* 7 */, 15/* 8 */, 15/* 9 */));
                    $pdf->RowNoBorder(array('', substr(utf8_decode($vv->CLAVE_CLIENTE . " " . $vv->CLIENTE), 0, 30)/* 0 */,
                        utf8_decode($vv->AGENTE)/* 1 */,
                        utf8_decode($vv->ESTADO . "/" . $vv->PAIS)/* 2 */,
                        utf8_decode($vv->PEDIDO)/* 3 */,
                        utf8_decode($vv->CLAVE_LINEA . " " . $vv->LINEA)/* 4 OK */,
                        utf8_decode($vv->FECHA_ENTREGA)/* 5 */,
                        utf8_decode($vv->PARES)/* 6 */,
                        utf8_decode($vv->MAQUILA)/* 7 */,
                        utf8_decode($vv->SEMANA)/* 8 */));
                    $pdf->Line(65, $pdf->GetY(), 269, $pdf->GetY());
                    $spacex = 65;
                    $PARES += $vv->PARES;
                    $TOTAL_PARES += $vv->PARES;
                }

                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->SetX(193);
                $pdf->Cell(30, $alto_celda, "Total por estilo", $bordes/* BORDE */, 0/* SALTO */, 'C', 0);
                $pdf->SetX(223);
                $pdf->Cell(16, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetX(178);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'C', 0);
            $pdf->SetX(223);
            $pdf->Cell(16, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosEstilo" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosLineas() {
        try {
            $x = $this->input;
            $xx = $this->input->post();
            $LINEAS = $this->pam->getLineas($x->post('CLIENTE'), $x->post('ESTILO'), $x->post('LINEA'), $x->post('MAQUILA'), $x->post('SEMANA'));
            $bordes = 0;
            $alto_celda = 4;
            $TIPO = $x->post('TIPO');
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $pdf->setTipoEncabezado(3);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 40;
            $YF = 0;
            foreach ($LINEAS as $k => $v) {
                $Y = $pdf->GetY();
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->SetX(10);
                $pdf->setFilled(0);
                $pdf->setBorders(0);
                $pdf->SetAligns(array('C', 'C', 'C'));
                $pdf->SetWidths(array(20/* 0 */, 20/* 1 */, 20/* 2 */));
                $pdf->RowNoBorder(array(utf8_decode($v->CLAVE_LINEA . " " . $v->LINEA)/* 0 */));
                $pdf->Line(10, $pdf->GetY(), 30, $pdf->GetY());
                $PARES_PREPROGRAMADOS = $this->pam->getParesPreProgramados($v->CLAVE_LINEA, 3, $x->post('CLIENTE'), $x->post('ESTILO'), $x->post('LINEA'), $x->post('MAQUILA'), $x->post('SEMANA'), $x->post('FECHA'), $x->post('FECHAF'), $xx['ANIO']);
                $bordes = 0;
                foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                    $Y = $pdf->GetY();
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('C', 'L'/* 0 */, 'L'/* 1 */, 'C'/* 2 */, 'C'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */, 'C'/* 8 */, 'C'/* 9 */));
                    $pdf->SetWidths(array(20, 43/* 0 */, 35/* 1 */, 25/* 2 */, 15/* 3 */, 15/* 4 */, 40/* 5 */, 20/* 6 */, 16/* 7 */, 15/* 8 */, 15/* 9 */));
                    $pdf->RowNoBorder(array('', substr(utf8_decode($vv->CLAVE_CLIENTE . " " . $vv->CLIENTE), 0, 30)/* 0 */,
                        utf8_decode($vv->AGENTE)/* 1 */,
                        utf8_decode($vv->ESTADO . "/" . $vv->PAIS)/* 2 */,
                        utf8_decode($vv->PEDIDO)/* 3 */,
                        utf8_decode($vv->CLAVE_ESTILO)/* 4 OK */,
                        substr(utf8_decode($vv->COLOR), 0, 28)/* 5 OK */,
                        utf8_decode($vv->FECHA_ENTREGA)/* 6 */,
                        utf8_decode($vv->PARES)/* 7 */,
                        utf8_decode($vv->MAQUILA)/* 8 */,
                        utf8_decode($vv->SEMANA)/* 9 */));
                    $pdf->Line(30, $pdf->GetY(), 269, $pdf->GetY());
                    $spacex = 40;
                    $PARES += $vv->PARES;
                    $TOTAL_PARES += $vv->PARES;
                }
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->SetX(193);
                $pdf->Cell(30, $alto_celda, "Total por linea", $bordes/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetX(223);
                $pdf->Cell(16, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetX(178);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'C', 0);
            $pdf->SetX(223);
            $pdf->Cell(16, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosLinea" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosMaquila() {
        try {
            $xxx = $this->input;
            $xxxx = $this->input->post();
            $MAQUILAS = $this->pam->getMaquila($xxx->post('MAQUILA'), $xxx->post('CLIENTE'), $xxx->post('ESTILO'), $xxx->post('MAQUILA'), $xxx->post('SEMANA'));

            $bordes = 0;
            $alto_celda = 4;
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $pdf->setTipoEncabezado(4);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3.5;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 40;
            $YF = 0;
            foreach ($MAQUILAS as $k => $v) {
                $Y = $pdf->GetY();
                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->SetX(10);
                $pdf->setFilled(0);
                $pdf->setBorders(0);
                $pdf->SetAligns(array('L', 'C', 'C'));
                $pdf->SetWidths(array(90.9/* 0 */, 30/* 1 */, 30/* 2 */));
                $pdf->setAlto(4);
                $pdf->RowNoBorder(array(utf8_decode($v->MAQUILA)/* 0 */, utf8_decode($v->CAPACIDAD_PARES)/* 1 */));
                $pdf->Line(10, $pdf->GetY(), 130.9, $pdf->GetY());
                $PARES_PREPROGRAMADOS = $this->pam->getParesPreProgramadosPorMaquila($v->CLAVE_MAQUILA, $xxx->post('CLIENTE'), $xxx->post('ESTILO'), $xxx->post('MAQUILA'), $xxx->post('SEMANA'), $xxxx['ANIO']);
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->setAlto(3.5);
                foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                    $pdf->SetFont('Calibri', 'B', 9);
                    $Y = $pdf->GetY();
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('C', 'C'/* 0 */, 'C'/* 1 */, 'C'/* 2 */, 'C'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */, 'C'/* 8 */, 'C'/* 9 */));
                    $pdf->SetWidths(array(120.9, 25/* 0 */, 25/* 1 */, 25/* 2 */, 15/* 3 */, 15/* 4 */, 40/* 5 */, 20/* 6 */, 16/* 7 */, 15/* 8 */, 15/* 9 */));
                    $pdf->RowNoBorder(array('', utf8_decode($vv->SEMANA)/* 0 */,
                        utf8_decode($vv->PARES)/* 1 */,
                        utf8_decode($vv->DIFERENCIA)/* 2 */));
                    $pdf->Line(130.9, $pdf->GetY(), 205, $pdf->GetY());
                    $spacex = 40;
                    $PARES += $vv->PARES;
                    $TOTAL_PARES += $vv->PARES;
                }
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(129.8);
                $pdf->Cell(26, $alto_celda, "Total por maquila", $bordes/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetX(156);
                $pdf->Cell(25, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->SetX(111);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'C', 0);
            $pdf->SetX(156);
            $pdf->Cell(25, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosMaquilas" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosSemanaMaquila() {
        try {
            $z = $this->input->post();
            $xxx = $this->input;

            $this->db->select('M.Clave AS CLAVE_MAQUILA, CONCAT(M.Clave," - ", M.Nombre) AS MAQUILA, M.CapacidadPares AS CAPACIDAD_PARES', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where("P.Control = 0 AND P.Estatus = 'A'", null, false);
            if ($z['MAQUILA'] !== '') {
                $this->db->where('M.Clave', $z['MAQUILA']);
            }
            if ($z['CLIENTE'] !== '') {
                $this->db->where("P.Cliente", $z['CLIENTE']);
            }
            if ($z['ESTILO'] !== '') {
                $this->db->where("P.Estilo", $z['ESTILO']);
            }
            if ($z['SEMANA'] !== '') {
                $this->db->where("P.Semana", $z['SEMANA']);
            }
            if ($z['ANIO'] !== '') {
                $this->db->where("P.Ano", $z['ANIO']);
            }
            $this->db->group_by(array('M.Nombre'))->order_by('abs(P.Maquila)', 'ASC')->order_by('abs(P.Semana)', 'ASC');
            $MAQUILAS = $this->db->get()->result();


            $bordes = 0;
            $alto_celda = 4;
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $pdf->setTipoEncabezado(5);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3.5;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 40;
            $YF = 0;
            foreach ($MAQUILAS as $k => $v) {
                $Y = $pdf->GetY();
                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->SetX(10);
                $pdf->setFilled(0);
                $pdf->setBorders(0);
                $pdf->SetAligns(array('L', 'C', 'C'));
                $pdf->SetWidths(array(90.9/* 0 */, 30/* 1 */, 30/* 2 */));
                $pdf->setAlto(4);
                $pdf->RowNoBorder(array(utf8_decode($v->MAQUILA)/* 0 */, utf8_decode($v->CAPACIDAD_PARES)/* 1 */));
                $pdf->Line(10, $pdf->GetY(), 130.9, $pdf->GetY());

                $this->db->select('M.Clave AS CLAVE_MAQUILA, M.Nombre AS MAQUILA, '
                                . 'M.CapacidadPares AS CAPACIDAD_PARES, P.Semana AS SEMANA, '
                                . 'SUM(P.Pares) AS PARES, '
                                . 'M.CapacidadPares - SUM(P.Pares) AS DIFERENCIA', false)
                        ->from('pedidox AS P')
                        ->join('maquilas AS M', 'P.Maquila = M.Clave')
                        ->where('M.Clave', $v->CLAVE_MAQUILA)->where('P.Maquila', $v->CLAVE_MAQUILA);

                if ($z['CLIENTE'] !== '') {
                    $this->db->where("P.Cliente", $z['CLIENTE']);
                }
                if ($z['ESTILO'] !== '') {
                    $this->db->where("P.Estilo", $z['ESTILO']);
                }
                if ($v->CLAVE_MAQUILA !== '') {
                    $this->db->where("P.Maquila", $v->CLAVE_MAQUILA);
                }
                if ($z['ESTILO'] !== '') {
                    $this->db->where("P.Semana", $z['ESTILO']);
                }
                if ($z['ANIO'] !== '') {
                    $this->db->where("P.Ano", $z['ANIO']);
                }
                $this->db->where("P.Control = 0 AND P.stsavan NOT IN(13,14) OR P.Control IS NULL", null, false);
                $PARES_PREPROGRAMADOS = $this->db->group_by(array('M.Nombre', 'P.Semana'))
                                ->order_by('abs(P.Maquila)', 'ASC')
                                ->order_by('abs(P.Semana)', 'ASC')->get()->result();

                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->setAlto(3.5);
                foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                    $pdf->SetFont('Calibri', 'B', 9);
                    $Y = $pdf->GetY();
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('C', 'C'/* 0 */, 'C'/* 1 */, 'C'/* 2 */, 'C'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */, 'C'/* 8 */, 'C'/* 9 */));
                    $pdf->SetWidths(array(120.9, 25/* 0 */, 25/* 1 */, 25/* 2 */, 15/* 3 */, 15/* 4 */, 40/* 5 */, 20/* 6 */, 16/* 7 */, 15/* 8 */, 15/* 9 */));
                    $pdf->RowNoBorder(array('', utf8_decode($vv->SEMANA)/* 0 */,
                        utf8_decode($vv->PARES)/* 1 */,
                        utf8_decode($vv->DIFERENCIA)/* 2 */));
                    $pdf->Line(130.9, $pdf->GetY(), 205, $pdf->GetY());
                    $spacex = 40;
                    $PARES += $vv->PARES;
                    $TOTAL_PARES += $vv->PARES;
                }
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(129.9);
                $pdf->Cell(26, $alto_celda, "Total por maquila", $bordes/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetX(156);
                $pdf->Cell(25, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->SetX(111);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(156);
            $pdf->Cell(25, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosMaquilas" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->pam->getClientesX());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesParesPreProgramados() {
        try {
            print json_encode($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus = 'ACTIVO' ORDER BY ABS(C.Clave) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgentes() {
        try {
            print json_encode($this->pam->getAgentes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->pam->getMaquilasX());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas() {
        try {
            print json_encode($this->pam->getLineasX());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->pam->getEstilosX());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
