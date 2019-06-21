<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesNominaJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onImprimirEtiquetasLockers() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["depto"] = $this->input->get('Depto');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteEtiquetasLockers.jasper');
        $jc->setFilename('ETIQUETAS_LOCKERS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirValeZapTda() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["empleado"] = $this->input->get('Empleado');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\valeZapatosTdas.jasper');
        $jc->setFilename('VALE_ZAPATOS_TIENDAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirAsistenciasF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoAsistenciaF');
        $parametros["sem"] = $this->input->post('SemAsistenciaF');
        $parametros["empleado"] = $this->input->post('EmpleadoAsistenciaF');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\asistencias\asistenciasRelojChecadorF.jasper');
        $jc->setFilename('ASISTENCIAS_RELOJ_CHECADOR_F_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
