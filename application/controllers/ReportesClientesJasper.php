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

    public function onReporteVentasPorFecha() {

        $fechaini = str_replace('/', '-', $this->input->post('FechaIniVentasPorFecha'));
        $nuevaFechaIni = date("Y-m-d", strtotime($fechaini));
        $fechafin = str_replace('/', '-', $this->input->post('FechaFinVentasPorFecha'));
        $nuevaFechaFin = date("Y-m-d", strtotime($fechafin));

        $tp = $this->input->post('TpVentasPorFecha');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $nuevaFechaIni;
        $parametros["fechaFin"] = $nuevaFechaFin;


        $tipo = $this->input->post('Reporte');
        $reports = array();


        if ($tp === '0') {
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaMaquila.jasper');
            $jc->setFilename('REPORTE_VTAS_POR_FECHAS_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();
            print json_encode($reports);
        } else {
            switch ($tipo) {
                case '1':
                    $parametros["tp"] = $tp;
                    $jc->setParametros($parametros);
                    $jc->setFilename('REPORTE_VTAS_POR_FECHAS_' . Date('h_i_s'));
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaSinRefacNiTraspDetalleTp.jasper');
                    $jc->setDocumentformat('pdf');
                    $reports['1UNO'] = $jc->getReport();
                    print json_encode($reports);
                    break;
                case '2':
                    $parametros["tp"] = $tp;
                    $jc->setParametros($parametros);
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaSinRefacNiTraspDetalleTp.jasper');
                    $jc->setFilename('REPORTE_VTAS_POR_FECHAS__SIN_REFAC_NI_TRASPASOS' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    $reports['1UNO'] = $jc->getReport();
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaNormalGeneralTp.jasper');
                    $jc->setFilename('REPORTE_VTAS_POR_FECHA_AGENTE_' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    $reports['2DOS'] = $jc->getReport();
                    print json_encode($reports);
                    break;
                case '3':
                    $parametros["tp"] = $tp;
                    $jc->setParametros($parametros);
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaClienteImporteDoctoDetalleTp.jasper');
                    $jc->setFilename('REPORTE_VTAS_POR_FECHAS_' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    $reports['1UNO'] = $jc->getReport();
                    print json_encode($reports);
                    break;
                default:
                    $parametros["tp"] = $tp;
                    $jc->setParametros($parametros);
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaNormalGeneralTp.jasper');
                    $jc->setFilename('REPORTE_GENERAL_VTAS_POR_FECHAS_' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    $reports['1UNO'] = $jc->getReport();
                    $jc->setJasperurl('jrxml\clientes\reporteVentasPorFechaNormalDetalleTp.jasper');
                    $jc->setFilename('REPORTE_GENERAL_VTAS_POR_FECHAS_DETALLE_' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    $reports['2DOS'] = $jc->getReport();
                    print json_encode($reports);
                    break;
            }
        }
    }

    public function onReporteVentasPorClienteAno() {
        $tipo = $this->input->post('TipoVtasAnoCliente');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoVtasAnoCliente');
        $parametros["cliente"] = $this->input->post('ClienteVtasAnocliente');

        switch ($tipo) {
            case '1':
                $parametros["tp"] = $this->input->post('TpVtasAnoCliente');
                $jc->setJasperurl('jrxml\clientes\reporteVentasAnoTpClienteFactura.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\clientes\reporteVentasAnoTpClientePedido.jasper');
                break;
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_VTAS_CLIENTE_TP_ANO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteConsolidadoLineaEstilo() {
        $linea = $this->input->post('LineaConsolidadoLineaEstilo');
        $filtro = $this->input->post('FiltroConsolidadoLineaEstilo');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dAno"] = $this->input->post('dAnoConsolidadoLineaEstilo');
        $parametros["aAno"] = $this->input->post('aAnoConsolidadoLineaEstilo');
        $parametros["tp"] = $this->input->post('TpConsolidadoLineaEstilo');



        if ($linea !== '') {//Por Agente
            $parametros["linea"] = 6160;
            if ($filtro === '1') {//Pares
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorEstiloLineaPares.jasper');
            } else {
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorEstiloLineaPesos.jasper');
            }
        } else {//General
            if ($filtro === '1') {//Pares
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorLineaPares.jasper');
            } else {
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorLineaPesos.jasper');
            }
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_CONSOLIDADO_MENSUAL_LINEA_ESTILO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteConsolidadoMes() {
        $tipo = $this->input->post('TipoConsolidadoMes');
        $filtro = $this->input->post('FiltroConsolidadoMes');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dAno"] = $this->input->post('dAnoConsolidadoMes');
        $parametros["aAno"] = $this->input->post('aAnoConsolidadoMes');
        $parametros["tp"] = $this->input->post('TpConsolidadoMes');



        if ($tipo === '1') {//Por Agente
            if ($filtro === '1') {//Pares
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorAnoAgentePares.jasper');
            } else {
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorAnoAgentePesos.jasper');
            }
        } else {//General
            if ($filtro === '1') {//Pares
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorAnoPares.jasper');
            } else {
                $jc->setJasperurl('jrxml\clientes\consolidadoVentasPorAnoPesos.jasper');
            }
        }

        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_CONSOLIDADO_MENSUAL_ANUAL_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteParesPesosTiendas() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/clientes/';

        $parametros["tp"] = $this->input->post('TpParesPesosTiendas');
        $parametros["ano"] = $this->input->post('AnoParesPesosTiendas');
        $jc->setJasperurl('jrxml\clientes\reporteParesPesosTiendas.jasper');
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTES_PARES_PESOS_TIENDAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
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
        $comicion = Date('ymd'); /* 170905  Dia actual */
        if ($chMarcaComPagadas === '1') {
            $this->db->query("update cartctepagos set pagada = '$comicion'  "
                    . " WHERE agente= $agente and tipo= $tipo and pagada = 0  ");
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

    public function onReporteEstadoCuentaExcel() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dCliente"] = $this->input->post('dClienteEdoCta');
        $parametros["aCliente"] = $this->input->post('aClienteEdoCta');
        $parametros["tp"] = $this->input->post('TpEdoCuenta');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteEstadoCuentaExcel.jasper');
        $jc->setFilename('EDO_CTA_CLIENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
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

    public function onReportePagosClientesExcel() {
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
        $jc->setJasperurl('jrxml\clientes\reportePagosClientesExcel.jasper');
        $jc->setFilename('PAGOS_CLIENTES_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
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

    public function onReporteDiasPagoPromedioExcel() {
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
        $jc->setJasperurl('jrxml\clientes\Excel\diasPagoPromedioFecha.jasper');
        $jc->setFilename('DIAS_PAGO_PROMEDIO_EXCEL_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
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

    public function onReporteSeguroExcel() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["mes"] = $this->input->post('Mes');
        $parametros["nombreReporte"] = $this->input->post('NombreMes') . ' del ' . $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteSeguroExcel.jasper');
        $jc->setFilename('PAGO_MENSUAL_SEGURO_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
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

    public function onReporteComparativoVentasPorAno() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["agt"] = $this->input->post('Agente');
        $parametros["anoI"] = $this->input->post('AnoI');
        $parametros["anoF"] = $this->input->post('AnoF');
        $parametros["mes"] = $this->input->post('Mes');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\ventas\comparativoVentasPorAno.jasper');
        $jc->setFilename('VENTAS_X_ANO_COMPARATIVO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificarAgente() {
        try {
            $Agente = $this->input->get('Agente');
            print json_encode($this->db->query("select clave from agentes where clave = '$Agente ' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
