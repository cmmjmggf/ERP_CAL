<?php

/*
 * ControlesADiasDevencimientoXCliente
 */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlesADiasDevencimientoXCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vControlesADiasDevencimientoXCliente')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getReporte() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $x = $this->input->post();
            $p["MAQUILA_INICIAL"] = intval($x['MAQUILA_INICIAL']);
            $p["MAQUILA_FINAL"] = intval($x['MAQUILA_FINAL']);
            $p["DIAS"] = intval($x['DIAS']);
            $p["ANIO"] = intval($x['ANIO']);
            $p["CLIENTE"] = $x['CLIENTE'];
//            $p["XQUERY"] = "WHERE DATEDIFF(DATE_FORMAT(str_to_date(P.FechaEntrega,"%d/%m/%Y"), "%Y-%m-%d"), NOW()) <= $P{DIAS} 
//AND P.Ano = $P{ANIO} 
//AND P.Maquila BETWEEN $P{MAQUILA_INICIAL} AND $P{MAQUILA_FINAL} 
//AND P.Cliente = $P{CLIENTE} 
//ORDER BY P.Cliente ASC ";
            $jc->setParametros($p);
            $jc->setJasperurl('jrxml\controles\ControlesADiasDeVencerMaquilaSemXCliente.jasper');
            $jc->setFilename('ControlesADiasDeVencerMaquilaSemXCliente' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaCliente() {
        try {
            $x = $this->input->get();
            $CLIENTE = $x['Cliente'];
            print json_encode($this->db->query("select clave from clientes where clave = '{$CLIENTE}' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesCtrlsDiasVenXCli() {
        try {
            print json_encode($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY C.RazonS ASC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
