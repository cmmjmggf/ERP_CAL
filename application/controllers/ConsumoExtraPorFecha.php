<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumoExtraPorFecha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper("jaspercommand_helper");
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vConsumoExtraPorFecha');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vConsumoExtraPorFecha');
                    break;
            }
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirConsumoPielYForroExtra() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON; 
            $parametros["FECHA_INICIAL"] = $x['FECHA_INICIAL'];
            $parametros["FECHA_FINAL"] =  $x['FECHA_FINAL'];
            $jc->setJasperurl("jrxml\consumopifo\ConsumoPielYForroExtra.jasper");
            $jc->setParametros($parametros);
            $jc->setFilename('ConsumoPielYForroExtra_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    public function onImprimirConsumoPielYForroExtraXLS() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON; 
            $parametros["FECHA_INICIAL"] = $x['FECHA_INICIAL'];
            $parametros["FECHA_FINAL"] =  $x['FECHA_FINAL'];
            $jc->setJasperurl("jrxml\consumopifo\ConsumoPielYForroExtraXLS.jasper");
            $jc->setParametros($parametros);
            $jc->setFilename('ConsumoExtra_' . Date('dmY_h_i_s'));
            $jc->setDocumentformat('xls');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
