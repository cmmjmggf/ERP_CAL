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

    public function onReportePagoComisiones306090365() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setJasperurl('jrxml\clientes\reportePagosClientes306090365.jasper');
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_PAGOS_COMISIONES_306090365_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReportePagoComisiones() {
        $tipo = $this->input->post('TpPagoComisiones');
        $chMarcaComPagadas = $this->input->post('chMarcaComPagadas');
        $agente = $this->input->post('AgentePagoComisiones');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["agente"] = $agente;

        switch ($tipo) {
            case '1':
                $jc->setJasperurl('jrxml\clientes\reportePagoComisiones.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\clientes\reportePagoComisiones2.jasper');
                break;
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_PAGOS_COMISIONES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
        //Marca las comisiones pagadas
        $comicion = Date('y-m-d'); /* 170905 */
        if ($chMarcaComPagadas === '1') {
            $this->db->query("update cartctepagos set pagada = $comicion  "
                    . " WHERE agente= $agente and tipo= $tipo and pagada = 0 and mov <> 10   ");
        }
    }

    public function onReporteControlesPorFacturar() {
        $tipo = $this->input->post('Reporte');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;

        switch ($tipo) {
            case '1':
                $jc->setJasperurl('jrxml\clientes\controlesPorFacturarClientes.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\clientes\controlesPorFacturarDevoluciones.jasper');
                break;
            case '3':
                $jc->setJasperurl('jrxml\clientes\controlesPorFacturarMuestrasPrototipos.jasper');
                break;
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_CONTROLES_POR_FACTURAR_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteAgentesCuatriAnual() {
        $tipo = $this->input->post('Cuatrimestre');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoCuatrimestre');

        switch ($tipo) {
            case '1':
                $jc->setJasperurl('jrxml\clientes\reporteCuotasAgentesPrimerCuatrimestre.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\clientes\reporteCuotasAgentesSegundoCuatrimestre.jasper');
                break;
            case '3':
                $jc->setJasperurl('jrxml\clientes\reporteCuotasAgentesTercerCuatrimestre.jasper');
                break;
            case '4':
                $jc->setJasperurl('jrxml\clientes\reporteCuotasAgentesAnual.jasper');
                break;
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_CUATRIMESTRAL_AGENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEstatusPedidoXAgenteFechas() {
        $fechaini = str_replace('/', '-', $this->input->post('FechaIniRepFechas'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));
        $fechafin = str_replace('/', '-', $this->input->post('FechaFinRepFechas'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;
        $parametros["agente"] = $this->input->post('AgenteRepFechas');
        $jc->setJasperurl('jrxml\clientes\estatusPedidosPorAgenteFechas.jasper');
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_ESTATUS_PEDIDOS_AGENTE_FECHAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteRelacionNC() {
        $Tipo = $this->input->post('TipoRelNC');
        $fechaini = str_replace('/', '-', $this->input->post('FechaIniRelNC'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));

        $fechafin = str_replace('/', '-', $this->input->post('FechaFinRelNC'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;
        $parametros["tp"] = $this->input->post('TpRelNC');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\relacionNotasCreditoSimple.jasper');
        if ($Tipo === '2') {
            $jc->setJasperurl('jrxml\clientes\relacionNotasCreditoGeneral.jasper');
        }
        $jc->setFilename('REPORTE_RELACION_NC_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteDetalladoMovimientosClientes() {
        $fechaini = str_replace('/', '-', $this->input->post('FechaIniDetalleMovimientos'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));

        $fechafin = str_replace('/', '-', $this->input->post('FechaFinDetalleMovimientos'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;
        $parametros["dCliente"] = $this->input->post('dClienteDetalleMovimientos');
        //$parametros["fechaIniF"] = $this->input->post('FechaIni');
        //$parametros["fechaFinF"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteEstadoCuentaDetalleCliente.jasper');
        $jc->setFilename('REPORTE_MOVS_DETALLADO_CLIENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
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
