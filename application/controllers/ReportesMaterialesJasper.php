<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesMaterialesJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteConsumoHiloMaquila() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["Nmaq"] = '1 CALZADO LOBO SA, DE CV';
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\relacionCoreHiloTejido.jasper');
        $jc->setFilename('RELACION_HILO_TEJIDO_CONTROL_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirValeEntradaOTROS() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["doc"] = $this->input->post('Doc');
        $parametros["tipo"] = $this->input->post('Tipo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\entradasDiversas.jasper');
        $jc->setFilename('VALE_ENTRADA_OTROS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteCosteoMatMaqDocumento() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["doc"] = $this->input->post('DocMov');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');
        $reporte = ($this->input->post('chEsSubAlmacen')) ? 'jrxml\materiales\costoMatMaqSemDocSubAlmacen.jasper' : 'jrxml\materiales\costoMatMaqSemDoc.jasper';

        $jc->setParametros($parametros);
        $jc->setJasperurl($reporte);
        $jc->setFilename('COSTO_MAT_MAQ_DOCUMENTO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteCosteoMatMaqSem() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\costoMatMaqSem.jasper');
        $jc->setFilename('COSTO_MAT_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteCosteoMatMaqFecha() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\costoMatMaqSemFechas.jasper');
        $jc->setFilename('COSTO_MAT_MAQ_SEM_FECHA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteMaterialRecibidoPedido() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $parametros["grupo"] = $this->input->post('Grupo');
        $parametros["nombreGrupo"] = $this->input->post('NombreGrupo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\materialRecibidoPedido.jasper');
        $jc->setFilename('MATERIAL_PEDIDO_RECIBIDO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEntSalTipo() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $parametros["tipo"] = $this->input->post('Tipo');
        $parametros["ano"] = $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\entSalTipo.jasper');
        $jc->setFilename('ENT_SAL_TIPO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEntSalSubAlmacen() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\entSalSubAlmacen.jasper');
        $jc->setFilename('ENT_SAL_SUBALMACEN_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteMatOtraMaqEntregadoMaq1() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\matOtraMaqEntregadoMaq1.jasper');
        $jc->setFilename('MAT_OTR_MAQ_ENT_MAQ_UNO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteConsultaArticulos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dGrupo"] = $this->input->post('dGrupo');
        $parametros["aGrupo"] = $this->input->post('aGrupo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\consultaArticulos.jasper');
        $jc->setFilename('CONSULTA_ARTICULOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteOrdComAnoSemMaq() {

        $piel = "1,2";
        $suela = "52,3,50";
        $indirectos = "52,3,50,1,2";

        $Tipo = $this->input->post('Tipo');

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');

        $jc->setJasperurl('jrxml\materiales\ordComMaqSem.jasper');

        switch ($Tipo) {
            case '10':
                $parametros["Depto"] = $piel;
                $parametros["Tipo"] = '10 PIEL Y FORRO';
                break;
            case '80':
                $parametros["Depto"] = $suela;
                $parametros["Tipo"] = '80 SUELA';
                break;
            case '90':
                $parametros["Depto"] = $indirectos;
                $parametros["Tipo"] = '90 INDIRECTOS';
                $jc->setJasperurl('jrxml\materiales\ordComMaqSemInd.jasper');
                break;
        }

        $jc->setParametros($parametros);

        $jc->setFilename('ORD_COM_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteVentaMatMaqSem() {
        $Precio = $this->input->post('Precio');

        $xGrupo = $this->input->post('GrupoVtaMat');


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["ano"] = $this->input->post('Ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\costoMatMaqSem.jasper');
        if ($Precio === '1') {
            if ($xGrupo === '1') {
                $jc->setJasperurl('jrxml\materiales\ventaMatMaqSemXGrupo.jasper');
            } else {
                $jc->setJasperurl('jrxml\materiales\ventaMatMaqSem.jasper');
            }
        } else {
            if ($xGrupo === '1') {
                $jc->setJasperurl('jrxml\materiales\costoMatMaqSemXGrupo.jasper');
            } else {
                $jc->setJasperurl('jrxml\materiales\costoMatMaqSem.jasper');
            }
        }
        $jc->setFilename('ENTREGA_MAT_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteSalidasMaqPorFechasGrupo() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $parametros["grupo"] = $this->input->post('Grupo');
        $parametros["nombreGrupo"] = $this->input->post('NombreGrupo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\salidasMaqPorFechaGrupo.jasper');
        $jc->setFilename('SALIDA_MAT_MAQ_FECHA_GRUPO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteComprasGeneralSemMaq() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $parametros["Tp"] = $this->input->post('Tp');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\comprasGeneralSemMaq.jasper');
        $jc->setFilename('COMPRAS_GENERAL_SEM_MAQ_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteRelacionControlesMaq() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\relacionControlesMaq.jasper');
        $jc->setFilename('RELACION_CONTROLES_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteRelacionControlesMaqExcel() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\excel\relacionControlesMaq.jasper');
        $jc->setFilename('RELACION_CONTROLES_MAQ_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
        PRINT $jc->getReport();
    }

}
