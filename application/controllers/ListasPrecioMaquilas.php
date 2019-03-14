<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ListasPrecioMaquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ListasPrecioMaquilas_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;

                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vListasPrecioMaquilas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->ListasPrecioMaquilas_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {
            $this->ListasPrecioMaquilas_model->onEliminarDetalleByID($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $datos = array(
                'Maq' => $this->input->post('Maq'),
                'Linea' => $this->input->post('Linea'),
                'Estilo' => $this->input->post('Estilo'),
                'Color' => $this->input->post('Color'),
                'Corrida' => $this->input->post('Corrida'),
                'PrecioVta' => $this->input->post('PrecioVta')
            );
            $this->ListasPrecioMaquilas_model->onAgregar($datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
