<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesProduccionJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteParesPreAsignados() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteParesPreAsignados.jasper');
        $jc->setFilename('PARES_PRE_ASIGNADOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEstadisticasEntrega() {



        $Tipo = $this->input->post('Tipo');

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');

        $jc->setJasperurl('jrxml\materiales\ordComMaqSem.jasper');

        switch ($Tipo) {
            case '1':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaCliente.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaGeneral.jasper');
                break;
            case '3':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaSemana.jasper');
                break;
        }

        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_ESTADISTICAS_ENTREGA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
