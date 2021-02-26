<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesProducidosPorDepartamentoSemana extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
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

            $this->load->view('vFondo')->view('vParesProducidosPorDepartamentoSemana')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getReporte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $xxx = $this->input->post();
        $parametros["SEMANA"] = intval($x->post('SEMANA'));
        $parametros["ANO"] = intval($x->post('ANIO'));
        $TIPO = intval($x->post('TIPO'));
        $jc->setDocumentformat('pdf');
        switch ($TIPO) {
            case 0:
                $this->db->set('status', 0)->set('registro', 8888)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->update('fracpagnomina');

                $this->db->query("TRUNCATE TABLE fabricadosxdeptoxsem");
                /* 22 CORTE ok */
                $this->db->set('status', 22)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(100, 101))->update('fracpagnomina');

                /* 33 RAYADO ok */
                $this->db->set('status', 33)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(102))->update('fracpagnomina');

                /* 34 REBAJADO ok */
                $this->db->set('status', 34)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(103))->update('fracpagnomina');

                /* 37 ENTRETELADO */
                $this->db->set('status', 37)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(51))->update('fracpagnomina');

//                /* 74 ALMACEN CORTE */
//                $this->db->set('status', 74)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(74))->update('fracpagnomina');

                /* 40 FOLEADO */
                $this->db->set('status', 40)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(60))->update('fracpagnomina');

                /* 50 PESPUNTE */
                $this->db->set('status', 50)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(300))->update('fracpagnomina');

                /* 55 ENSUELADO */
                $this->db->set('status', 55)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(397))->update('fracpagnomina');

                /* 70 TEJIDO */
                $this->db->set('status', 70)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(604, 401))->update('fracpagnomina');

                /* 90 MONTADO */
                $this->db->set('status', 90)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(500))->update('fracpagnomina');

                /* 100 ADORNO */
                $this->db->set('status', 100)->where('semana', $xxx['SEMANA'])->where('anio', $xxx['ANIO'])->where_in('numfrac', array(600))->update('fracpagnomina');


                $DEPTOS = array(22/* CORTE */,
                    33/* RAYADO */,
                    34/* REBAJADO */,
                    40/* FOLEADO */,
                    37/* ENTRETELADO */,
//                    74/* ALM-CORTE */,
                    50/* PESPUNTE */,
                    55/* ENSUELADO */,
                    70/* TEJIDO */,
                    90/* MONTADO */,
                    100/* ADORNO */);
                foreach ($DEPTOS as $key => $v) {
//if (in_array($v->DEPTO, $STATUS_I, true)) {
                    $PARES_JUEVES = $this->db->query("SELECT str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y') AS FECHA_JUEVES, F.depto,SUM(F.pares) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\")) AND DAY(F.fecha) =  DAY(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"));")->result();
                    $PARES_VIERNES = $this->db->query("SELECT DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL 1 DAY) AS FECHA_VIERNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 1 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 1 DAY));")->result();
                    $PARES_SABADO = $this->db->query("SELECT DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL 2 DAY) AS FECHA_SABADO, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 2 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 2 DAY));")->result();
                    $PARES_DOMINGO = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL 3 DAY) AS FECHA_DOMINGO, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 3 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL 3 DAY));")->result();
                    switch (intval($xxx['SEMANA'])) {
                        case 1:
                            $DIAS_LUNES = 12;
                            $DIAS_MARTES = 13;
                            $DIAS_MIERCOLES = 14;

                            $PARES_LUNES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_LUNES} DAY) AS FECHA_LUNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY));")->result();
                            $PARES_MARTES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_MARTES} DAY) AS FECHA_MARTES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY));")->result();
                            $PARES_MIERCOLES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_MIERCOLES} DAY) AS FECHA_MIERCOLES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY));")->result();
                            break;
                        default:
                            $DIAS_LUNES = 4;
                            $DIAS_MARTES = 5;
                            $DIAS_MIERCOLES = 6;
                            $PARES_LUNES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_LUNES} DAY) AS FECHA_LUNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY));")->result();
                            $PARES_MARTES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_MARTES} DAY) AS FECHA_MARTES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY));")->result();
                            $PARES_MIERCOLES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\", '%d/%m/%Y'),INTERVAL {$DIAS_MIERCOLES} DAY) AS FECHA_MIERCOLES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$xxx['SEMANA']} AND F.anio = {$xxx['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$xxx['FECHA_INICIAL']}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY));")->result();
                            break;
                    }
                    $this->db->insert('fabricadosxdeptoxsem',
                            array("DEPTOCLAVE" => $v, "DEPARTAMENTO" => $v,
                                "FECHA_JUEVES" => $PARES_JUEVES[0]->FECHA_JUEVES,
                                "FECHA_VIERNES" => $PARES_VIERNES[0]->FECHA_VIERNES,
                                "FECHA_SABADO" => $PARES_SABADO[0]->FECHA_SABADO,
                                "FECHA_DOMINGO" => $PARES_DOMINGO[0]->FECHA_DOMINGO,
                                "FECHA_LUNES" => $PARES_LUNES[0]->FECHA_LUNES,
                                "FECHA_MARTES" => $PARES_MARTES[0]->FECHA_MARTES,
                                "FECHA_MIERCOLES" => $PARES_MIERCOLES[0]->FECHA_MIERCOLES,
                                "CANTIDAD_JUEVES" => $PARES_JUEVES[0]->PARES,
                                "CANTIDAD_VIERNES" => $PARES_VIERNES[0]->PARES,
                                "CANTIDAD_SABADO" => $PARES_SABADO[0]->PARES,
                                "CANTIDAD_DOMINGO" => $PARES_DOMINGO[0]->PARES,
                                "CANTIDAD_LUNES" => $PARES_LUNES[0]->PARES,
                                "CANTIDAD_MARTES" => $PARES_MARTES[0]->PARES,
                                "CANTIDAD_MIERCOLES" => $PARES_MIERCOLES[0]->PARES,
                                "TOTALES" => ($PARES_JUEVES[0]->PARES + $PARES_VIERNES[0]->PARES +
                                $PARES_SABADO[0]->PARES + $PARES_DOMINGO[0]->PARES +
                                $PARES_LUNES[0]->PARES + $PARES_MARTES[0]->PARES + $PARES_MIERCOLES[0]->PARES),
                                "SEM" => $xxx['SEMANA'],
                                "ANIO" => $xxx['ANIO']
                    ));
                }
//                exit(0);
//                $parametros["FECHA_INICIAL"] = ($x->post('FECHA_INICIAL'));
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorDepartamentoSemana.jasper');
                $jc->setFilename('ParesFabricadosPorDepartamentoSemana' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 1:
                /* PESPUNTE */
                $parametros["DEPTO"] = 110;
                $parametros["FECHA_INICIAL"] = ($x->post('FECHA_INICIAL'));
                $parametros["FECHA_FINAL"] = ($x->post('FECHA_FINAL'));
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaPespunte' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 2:
                /* MONTADO A */
                $parametros["DEPTO"] = 180;
                $parametros["FECHA_INICIAL"] = ($x->post('FECHA_INICIAL'));
                $parametros["FECHA_FINAL"] = ($x->post('FECHA_FINAL'));
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaMontado' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 3:
                /* ADORNO A */
                $parametros["DEPTO"] = 210;
                $parametros["FECHA_INICIAL"] = ($x->post('FECHA_INICIAL'));
                $parametros["FECHA_FINAL"] = ($x->post('FECHA_FINAL'));
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaAdorno' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 4:
                /* TEJIDO */
                $parametros["DEPTO"] = 150;
                $parametros["FECHA_INICIAL"] = ($x->post('FECHA_INICIAL'));
                $parametros["FECHA_FINAL"] = ($x->post('FECHA_FINAL'));
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaTejido' . Date('h_i_s'));
                print $jc->getReport();
                break;
        }
    }

    public function getSemanaActual() {
        try {
            $s = $this->input->get('FECHA');
            print json_encode($this->db->select('SP.Sem AS SEMANA, SP.FechaIni AS FEINI, SP.FechaFin AS FEFIN')->from('semanasnomina AS SP')
                                    ->where('str_to_date("' . $s . '", \'%d/%m/%Y\') BETWEEN str_to_date(FechaIni, \'%d/%m/%Y\') AND str_to_date(FechaFin, \'%d/%m/%Y\')', null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFechasXSemana() {
        try {
            $s = $this->input->get('SEMANA');
            print json_encode($this->db->select('SP.Sem AS SEMANA, SP.FechaIni AS FEINI, SP.FechaFin AS FEFIN')->from('semanasnomina AS SP')
                                    ->where("SP.Sem = $s ", null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* chart en grafico */

    public function getOrigenDeDatos() {
        try {
            $x = $this->input->get();
            $FECHA_INICIAL = $x['FECHA_INICIAL'] !== '' ? $x['FECHA_INICIAL'] : Date('d/m/Y');
            $SEMANA = $x['SEMANA'] !== '' ? $x['SEMANA'] : $this->getSemanaByFecha(Date('d/m/Y'));

            $this->db->set('status', 0)->set('registro', 8888)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->update('fracpagnomina');

            $this->db->query("TRUNCATE TABLE fabricadosxdeptoxsem");
            /* 22 CORTE ok */
            $this->db->set('status', 22)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(100, 101))->update('fracpagnomina');

            /* 33 RAYADO ok */
            $this->db->set('status', 33)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(102))->update('fracpagnomina');

            /* 34 REBAJADO ok */
            $this->db->set('status', 34)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(103))->update('fracpagnomina');

            /* 37 ENTRETELADO */
            $this->db->set('status', 37)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(51))->update('fracpagnomina');

//                /* 74 ALMACEN CORTE */
//                $this->db->set('status', 74)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(74))->update('fracpagnomina');

            /* 40 FOLEADO */
            $this->db->set('status', 40)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(60))->update('fracpagnomina');

            /* 50 PESPUNTE */
            $this->db->set('status', 50)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(300))->update('fracpagnomina');

            /* 55 ENSUELADO */
            $this->db->set('status', 55)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(397))->update('fracpagnomina');

            /* 70 TEJIDO */
            $this->db->set('status', 70)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(604, 401))->update('fracpagnomina');

            /* 90 MONTADO */
            $this->db->set('status', 90)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(500))->update('fracpagnomina');

            /* 100 ADORNO */
            $this->db->set('status', 100)->where('semana', $SEMANA)->where('anio', $x['ANIO'])->where_in('numfrac', array(600))->update('fracpagnomina');


            $DEPTOS = array(22/* CORTE */,
                33/* RAYADO */,
                34/* REBAJADO */,
                40/* FOLEADO */,
                37/* ENTRETELADO */,
//                    74/* ALM-CORTE */,
                50/* PESPUNTE */,
                55/* ENSUELADO */,
                70/* TEJIDO */,
                90/* MONTADO */,
                100/* ADORNO */);
            $DEPARTAMENTOS = array();
            $data = array();
            foreach ($DEPTOS as $key => $v) { 
                $PARES_JUEVES = $this->db->query("SELECT str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y') AS FECHA_JUEVES, F.depto,SUM(F.pares) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\")) AND DAY(F.fecha) =  DAY(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"));")->result();
                $PARES_VIERNES = $this->db->query("SELECT DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL 1 DAY) AS FECHA_VIERNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 1 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 1 DAY));")->result();
                $PARES_SABADO = $this->db->query("SELECT DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL 2 DAY) AS FECHA_SABADO, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 2 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 2 DAY));")->result();
                $PARES_DOMINGO = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL 3 DAY) AS FECHA_DOMINGO, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 3 DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL 3 DAY));")->result();
                switch (intval($SEMANA)) {
                    case 1:
                        $DIAS_LUNES = 12;
                        $DIAS_MARTES = 13;
                        $DIAS_MIERCOLES = 14;

                        $PARES_LUNES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_LUNES} DAY) AS FECHA_LUNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY));")->result();
                        $PARES_MARTES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_MARTES} DAY) AS FECHA_MARTES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY));")->result();
                        $PARES_MIERCOLES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_MIERCOLES} DAY) AS FECHA_MIERCOLES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY));")->result();
                        break;
                    default:
                        $DIAS_LUNES = 4;
                        $DIAS_MARTES = 5;
                        $DIAS_MIERCOLES = 6;
                        $PARES_LUNES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_LUNES} DAY) AS FECHA_LUNES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_LUNES} DAY));")->result();
                        $PARES_MARTES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_MARTES} DAY) AS FECHA_MARTES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MARTES} DAY));")->result();
                        $PARES_MIERCOLES = $this->db->query("SELECT  DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\", '%d/%m/%Y'),INTERVAL {$DIAS_MIERCOLES} DAY) AS FECHA_MIERCOLES, F.depto,IFNULL(SUM(F.pares),0) AS PARES FROM fracpagnomina AS F WHERE F.semana = {$SEMANA} AND F.anio = {$x['ANIO']} AND F.status ='{$v}' AND MONTH(F.fecha) = MONTH(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY)) AND DAY(F.fecha) =  DAY(DATE_ADD(str_to_date(\"{$FECHA_INICIAL}\",\"%d/%m/%Y\"),INTERVAL {$DIAS_MIERCOLES} DAY));")->result();
                        break;
                } 
//                array_push($DEPARTAMENTOS, $this->getDepartamentoClave($v));
                array_push($data, array("DEPTOCLAVE" => $v, "DEPARTAMENTO" => $this->getDepartamentoClave($v),
                    "FECHA_JUEVES" => $this->getFecha($PARES_JUEVES[0]->FECHA_JUEVES),
                    "FECHA_VIERNES" => $this->getFecha($PARES_VIERNES[0]->FECHA_VIERNES),
                    "FECHA_SABADO" => $this->getFecha($PARES_SABADO[0]->FECHA_SABADO),
                    "FECHA_DOMINGO" => $this->getFecha($PARES_DOMINGO[0]->FECHA_DOMINGO),
                    "FECHA_LUNES" => $this->getFecha($PARES_LUNES[0]->FECHA_LUNES),
                    "FECHA_MARTES" => $this->getFecha($PARES_MARTES[0]->FECHA_MARTES),
                    "FECHA_MIERCOLES" => $this->getFecha($PARES_MIERCOLES[0]->FECHA_MIERCOLES),
                    "CANTIDAD_JUEVES" => $PARES_JUEVES[0]->PARES,
                    "CANTIDAD_VIERNES" => $PARES_VIERNES[0]->PARES,
                    "CANTIDAD_SABADO" => $PARES_SABADO[0]->PARES,
                    "CANTIDAD_DOMINGO" => $PARES_DOMINGO[0]->PARES,
                    "CANTIDAD_LUNES" => $PARES_LUNES[0]->PARES,
                    "CANTIDAD_MARTES" => $PARES_MARTES[0]->PARES,
                    "CANTIDAD_MIERCOLES" => $PARES_MIERCOLES[0]->PARES,
                    "TOTALES" => ($PARES_JUEVES[0]->PARES + $PARES_VIERNES[0]->PARES +
                    $PARES_SABADO[0]->PARES + $PARES_DOMINGO[0]->PARES +
                    $PARES_LUNES[0]->PARES + $PARES_MARTES[0]->PARES + $PARES_MIERCOLES[0]->PARES),
                    "SEM" => $SEMANA,
                    "ANIO" => $x['ANIO']
                )); 
            } 
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoClave($CLAVE_DEPTO) {
        switch (intval($CLAVE_DEPTO)) {
            case 22:
                return "CORTE";
                break;
            case 33:
                return "RAYADO";
                break;
            case 40:
                return "FOLEADO";
                break;
            case 34:
                return "REBAJADO";
                break;
            case 37:
                return "ENTRETELADO";
                break;
            case 50:
                return "PESPUNTE";
                break;
            case 55:
                return "ENSUELADO";
                break;
            case 70:
                return "TEJIDO";
                break;
            case 90:
                return "MONTADO";
                break;
            case 100:
                return "ADORNO";
                break;
        }
    }

    public function getFecha($F) {
        RETURN date_format(date_create($F), "d/m/Y");
    }

    public function getSemanaByFecha($fecha) {
        try {
            $this->db->select('U.sem, U.FechaIni, U.FechaFin, U.sem AS SEMANA', false)
                    ->from('semanasnomina AS U')
                    ->where("str_to_date('$fecha','%d/%m/%Y') BETWEEN str_to_date(FechaIni,'%d/%m/%Y') AND str_to_date(FechaFin,'%d/%m/%Y')", null, false);
            $query = $this->db->get();
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data[0]->SEMANA;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaXFecha() {
        try {
            $this->db->select('U.sem, U.FechaIni, U.FechaFin, U.sem AS SEMANA', false)
                    ->from('semanasnomina AS U')
                    ->where("str_to_date('{$this->input->get('Fecha')}','%d/%m/%Y') BETWEEN str_to_date(FechaIni,'%d/%m/%Y') AND str_to_date(FechaFin,'%d/%m/%Y')", null, false);
            $query = $this->db->get();
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
