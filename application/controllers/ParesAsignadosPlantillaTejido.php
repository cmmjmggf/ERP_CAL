<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignadosPlantillaTejido extends CI_Controller {

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
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vParesAsignadosPlantillaTejido')->view('vFooter');
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
            $parametros["FECHA_INICIAL"] = $this->input->post('FECHA_INICIAL');
            $parametros["FECHA_FINAL"] = $this->input->post('FECHA_FINAL');
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\asignados\PrefabricacionDePlantillasXFecha.jasper');
            $jc->setFilename('PARES_PARA_PREPARAR_PLANTILLA_A_TEJIDO_X_FECHA');
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
