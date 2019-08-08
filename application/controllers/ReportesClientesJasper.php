<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesClientesJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteDiasPagoPromedio() {
        $fechaini = str_replace('/', '-', $this->input->post('FechaIni'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));

        $fechafin = str_replace('/', '-', $this->input->post('FechaFin'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;
        $parametros["fechaIniF"] = $this->input->post('FechaIni');
        $parametros["fechaFinF"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\diasPagoPromedioFecha.jasper');
        $jc->setFilename('DIAS_PAGO_PROMEDIO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteSeguro() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["mes"] = $this->input->post('Mes');
        $parametros["nombreReporte"] = $this->input->post('NombreMes') . ' del ' . $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteSeguro.jasper');
        $jc->setFilename('PAGO_MENSUAL_SEGURO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteDocsVencidos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteDocsVencidos.jasper');
        $jc->setFilename('DOCS_VENCIDOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteVencimientoPorFechas() {
        $fechaini = str_replace('/', '-', $this->input->post('FechaIni'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));

        $fechafin = str_replace('/', '-', $this->input->post('FechaFin'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;
        $parametros["fechaIniF"] = $this->input->post('FechaIni');
        $parametros["fechaFinF"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteDocsPorVencer.jasper');
        $jc->setFilename('DOCS_POR_VENCER_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteCobranzaDiaria() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dAgente"] = $this->input->post('dAgente');
        $parametros["aAgente"] = $this->input->post('aAgente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteCobranzaHoy.jasper');
        $jc->setFilename('COBRANZA_DIARIA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
