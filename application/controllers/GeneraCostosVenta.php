<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class GeneraCostosVenta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
            }
            $this->load->view('vGeneraCostosVenta')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRegistros() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT * FROM costovaria
                                                where linea = '$linea' and corr = $corrida and lista = $lista
                                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoInicial() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT
                                gtosf,
                                date_format(fecha,'%d/%m/%Y') as fecha,
                                comic,
                                `desc`,
                                matpri,
                                mextr,
                                toler,
                                maob,
                                gfabri,
                                tejida,
                                gvta,
                                gadmon,
                                hms,
                                flete
                                FROM costovaria
                                where linea = '$linea' and corr = $corrida and lista = $lista
                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarGastosFijos() {
        try {
            $gastosf = $this->input->post('GastosF');
            $this->db->query("update costovaria set gtosf = $gastosf ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reportes */

    public function onImprimirListaPrecios() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["lista"] = $this->input->post('Lista');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reporteListasPrecios.jasper');
        $jc->setFilename('REPORTE_LISTAS_PRECIO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteCostos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["linea"] = $this->input->post('Linea');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reportePreciosPorLinea.jasper');
        $jc->setFilename('REPORTE_COSTOS_LINEA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
