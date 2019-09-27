<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesOrdenesCompraJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onImprimirOrdenesCompraMaqSemAno() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoOCMaqSem');
        $parametros["sem"] = $this->input->post('SemOCMaqSem');
        $parametros["asem"] = $this->input->post('aSemOCMaqSem');
        $parametros["maq"] = $this->input->post('MaqOCMaqSem');
        $parametros["amaq"] = $this->input->post('aMaqOCMaqSem');
        $parametros["tipo"] = $this->input->post('TipoOCMaqSem');
        $parametros["proveedor"] = $this->input->post('ProveedorOCMaqSem');
        $parametros["csaldo"] = $this->input->post('cSaldoPendiente');

        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\reporteOrdenesCompraAnoMaqSem.jasper');
        $jc->setFilename('ORDENES_COMPRA_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
