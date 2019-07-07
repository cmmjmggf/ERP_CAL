<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class PrenominaPreliminaresPespunte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function getReporte() {
        try {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ANO"] = $this->input->post('ANIO');
        $parametros["SEMANA"] = $this->input->post('SEM');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\prenprexsem.jasper');
        $jc->setFilename('PRENOMINAPRELPESXSEM' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
