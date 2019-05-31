<?php

/* 
 * ControlesADiasDeVencimientoXMaqSem
 */
/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlesADiasDeVencimientoXMaqSem extends CI_Controller {

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
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vControlesADiasDeVencimientoXMaqSem')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getReporte() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $x = $this->input;
            $parametros["MAQUILA_INICIAL"] = intval($x->post('MAQUILA_INICIAL'));
            $parametros["MAQUILA_FINAL"] = intval($x->post('MAQUILA_FINAL'));
            $parametros["DIAS"] = intval($x->post('DIAS'));
            $parametros["ANIO"] = intval($x->post('ANIO'));

            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\controles\ControlesADiasDeVencerMaquilaSem.jasper');
            $jc->setFilename('ControlesADiasDeVencerMaquilaSem' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}