<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ExistenciasSuelasPlantas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ExistenciasSuelasPlantas_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vExistenciasSuelasPlantas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->ExistenciasSuelasPlantas_model->getRecords($this->input->post('Articulo'), $this->input->post('Mes')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCabeceros() {
        try {
            print json_encode($this->ExistenciasSuelasPlantas_model->getCabeceros());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
