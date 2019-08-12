<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class AuxReportesClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file')->model('AplicaDepositosCliente_model', 'adc');
    }

    public function onReporteEtiCajas() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["cliente"] = $this->input->post('Cliente');
        $parametros["tp"] = $this->input->post('Tp');
        $parametros["factura"] = $this->input->post('Factura');
        $parametros["transporte"] = $this->input->post('Transporte');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteEtiquetaCajasGrandes.jasper');
        $jc->setFilename('ETIQUETAS_CAJAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getClientes() {
        try {
            print json_encode($this->adc->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTransporteCliente() {
        try {
            $cte = $this->input->get('Cliente');
            print json_encode($this->db->query("select t.Descripcion as nomtra
                                                from clientes ct
                                                join transportes t on t.Clave = ct.Transporte
                                                where ct.clave = $cte ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosEtiCajas() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT remicion
                                                FROM cartcliente
                                                where cliente= $cte and tipo = $tp and status < 4
                                                order by remicion asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCajasFactura() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            $doc = $this->input->get('Factura');
            print json_encode($this->db->query("select cajas from facturacion where cliente= $cte and tp = $tp and factura = $doc limit 1 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
