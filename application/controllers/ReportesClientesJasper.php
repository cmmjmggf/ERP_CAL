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

    public function onReporteEdoCuentaAgentes() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dAgente"] = $this->input->post('dAgenteEdoCuentaAgt');
        $parametros["aAgente"] = $this->input->post('aAgenteEdoCuentaAgt');
        $parametros["tp"] = $this->input->post('TpEdoCtaAgt');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteEstadoCuentaAgente.jasper');
        $jc->setFilename('EDO_CTA_CLIENTES__AGENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEstadoCuenta() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dCliente"] = $this->input->post('dClienteEdoCta');
        $parametros["aCliente"] = $this->input->post('aClienteEdoCta');
        $parametros["tp"] = $this->input->post('TpEdoCuenta');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteEstadoCuenta.jasper');
        $jc->setFilename('EDO_CTA_CLIENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteControlesEntregadosPorFabrica() {
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
        $jc->setJasperurl('jrxml\clientes\reporteControlesEntregadosPorMaquila.jasper');
        $jc->setFilename('REPORTE_CONTROLES_ENTREGADOS_POR_MAQUILA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteVencimientoCte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["cliente"] = $this->input->post('ClienteCVC');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteVencimientoDiasPorCliente.jasper');
        $jc->setFilename('VENCIMIENTO_CONTROLES_CLIENTE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteVencimientoMaqCte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["dmaq"] = $this->input->post('MaqCV');
        $parametros["amaq"] = $this->input->post('aMaqCV');
        $parametros["dias"] = $this->input->post('DiasCV');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteVencimientoDiasPorMaq.jasper');
        $jc->setFilename('VENCIMIENTO_CONTROLES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReportePagosClientes() {
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
        $parametros["tp"] = $this->input->post('TpPagoDiario');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reportePagosClientes.jasper');
        $jc->setFilename('PAGOS_CLIENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReportePagosClientesEfectivo() {
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
        $jc->setJasperurl('jrxml\clientes\reportePagosClientesEfectivo.jasper');
        $jc->setFilename('PAGOS_CLIENTES_EFECTIVO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteDevolucionesPorAplicar() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteDevolucionesNoAplicadas.jasper');
        $jc->setFilename('DEVOLUCIONES_X_APLICAR_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
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
