<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ActualizaPrecioOrdenCompra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Actualizaprecioordencompra_model');
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
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vActualizaPreciosOrdenCompra');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Actualizaprecioordencompra_model->getRecords($this->input->post('Folio'), $this->input->post('Tp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOrdenCompra() {
        try {
            print json_encode($this->Actualizaprecioordencompra_model->getOrdenCompra($this->input->get('Folio'), $this->input->get('Tp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarPreciosOrdenCompraByOrdenCompra() {
        try {
            $x = $this->input;
            $this->Actualizaprecioordencompra_model->onModificarPreciosOrdenCompraByOrdenCompra($x->post('OC'), $x->post('Tp'), $x->post('Prov'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
