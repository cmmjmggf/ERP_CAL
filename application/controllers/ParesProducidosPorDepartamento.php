<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesProducidosPorDepartamento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
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

            $this->load->view('vFondo')->view('vParesProducidosPorDepartamento')->view('vFooter');
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
        $parametros["MAQUILA"] = intval($x->post('MAQUILA'));
        /*ES EL STSAVAN*/
        switch (intval($x->post('DEPARTAMENTO'))) {
            case 10:
                /*CORTE*/
                $parametros["DEPARTAMENTO"] = 2;
                break;
            case 20:
                /*RAYADO*/
                $parametros["DEPARTAMENTO"] = 3;
                break;
            case 30:
                /*REBAJADO*/
                $parametros["DEPARTAMENTO"] = 33;
                break;
            case 40:
                /*FOLEADO*/
                $parametros["DEPARTAMENTO"] = 4;
                break;
            case 60:
                /*LASER*/
                $parametros["DEPARTAMENTO"] = 42;
                break;
            case 90:
                /*ENTRETELADO*/
                $parametros["DEPARTAMENTO"] = 40;
                break;
            case 105:
                /*ALM-CORTE*/
                $parametros["DEPARTAMENTO"] = 44;
                break;
            case 110:
                /*ADORNO*/
                $parametros["DEPARTAMENTO"] = 5;
                break;
            case 130:
                /*ALM-PESPUNTE*/
                $parametros["DEPARTAMENTO"] = 6;
                break;
            case 140:
                /*ENSUELADO*/
                $parametros["DEPARTAMENTO"] = 55;
                break;
            case 150:
                /*ENSUELADO*/
                $parametros["DEPARTAMENTO"] = 7;
                break;
            case 160:
                /*ALM-TEJIDO*/
                $parametros["DEPARTAMENTO"] = 8;
                break;
            case 180:
                /*MONTADO*/
                $parametros["DEPARTAMENTO"] = 9;
                break;
            case 180:
                /*MONTADO*/
                $parametros["DEPARTAMENTO"] = 9;
                break;
            case 210:
                /*ADORNO*/
                $parametros["DEPARTAMENTO"] = 10;
                break;
            case 230:
                /*ADORNO*/
                $parametros["DEPARTAMENTO"] = 10;
                break;
        }
        $parametros["FECHAINICIAL"] = $x->post('FECHA_INICIAL');
        $parametros["FECHAFINAL"] = $x->post('FECHA_FINAL');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\producidosxdepto\ParesProducidosPorDepartamento.jasper');
        $jc->setFilename('ParesProducidosPorDepartamento' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        print $jc->getReport();
    }

}
