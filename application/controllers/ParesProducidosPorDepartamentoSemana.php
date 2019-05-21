<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesProducidosPorDepartamentoSemana extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vParesProducidosPorDepartamentoSemana')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getReporte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $parametros["SEMANA"] = intval($x->post('SEMANA'));
        $parametros["ANO"] = intval($x->post('ANIO'));

        $jc->setParametros($parametros);

        $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorDepartamentoSemana.jasper');
        $jc->setFilename('ParesFabricadosPorDepartamentoSemana' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        print $jc->getReport();
    }

    public function getSemanaActual() {
        try {
            $s = $this->input->get('FECHA');
            print json_encode($this->db->select('SP.Sem AS SEMANA')->from('semanasproduccion AS SP')
                                    ->where('str_to_date("' . $s . '", \'%d/%m/%Y\') BETWEEN str_to_date(FechaIni, \'%d/%m/%Y\') AND str_to_date(FechaFin, \'%d/%m/%Y\')', null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
