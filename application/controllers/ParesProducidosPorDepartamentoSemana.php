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
        $TIPO = intval($x->post('TIPO'));
        $jc->setDocumentformat('pdf');
        switch ($TIPO) {
            case 0: 
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorDepartamentoSemana.jasper');
                $jc->setFilename('ParesFabricadosPorDepartamentoSemana' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 1:
                /*PESPUNTE*/
                $parametros["DEPTO"] = 110;
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaPespunte' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 2:
                /*MONTADO A*/
                $parametros["DEPTO"] = 180;
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaMontado' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 3:
                /*ADORNO A*/
                $parametros["DEPTO"] = 210;
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaAdorno' . Date('h_i_s'));
                print $jc->getReport();
                break;
            case 4:
                /*TEJIDO*/
                $parametros["DEPTO"] = 150;
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\producidosxdepto\ParesFabricadosPorPersonaSemana.jasper');
                $jc->setFilename('ParesFabricadosPorPersonaSemanaTejido' . Date('h_i_s'));
                print $jc->getReport();
                break;
        }
    }

    public function getSemanaActual() {
        try {
            $s = $this->input->get('FECHA');
            print json_encode($this->db->select('SP.Sem AS SEMANA, SP.FechaIni AS FEINI, SP.FechaFin AS FEFIN')->from('semanasnomina AS SP')
                                    ->where('str_to_date("' . $s . '", \'%d/%m/%Y\') BETWEEN str_to_date(FechaIni, \'%d/%m/%Y\') AND str_to_date(FechaFin, \'%d/%m/%Y\')', null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFechasXSemana() {
        try {
            $s = $this->input->get('SEMANA');
            print json_encode($this->db->select('SP.Sem AS SEMANA, SP.FechaIni AS FEINI, SP.FechaFin AS FEFIN')->from('semanasnomina AS SP')
                                    ->where("SP.Sem = $s ", null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
