<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DesarrolloMuestras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('DesarrolloMuestras_model', 'dmm');
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
            $this->load->view('vFondo')->view('vDesarrolloMuestras')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->dmm->getRecords($this->input->get('ESTILO'), $this->input->get('COLOR')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }  

    public function getColoresXEstilo() {
        try {
            print json_encode($this->dmm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } 

    public function getFotoXEstilo() {
        try {
            print json_encode($this->dmm->getFotoXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } 

}
