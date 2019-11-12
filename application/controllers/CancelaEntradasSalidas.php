<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CancelaEntradasSalidas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('CancelaEntradasSalidas_model');
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
            $this->load->view('vCancelaEntradasSalidas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->CancelaEntradasSalidas_model->getRecords($this->input->post('DocMov'), $this->input->post('Maq'), $this->input->post('Sem'), $this->input->post('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion() {
        try {
            print json_encode($this->CancelaEntradasSalidas_model->onComprobarSemanasProduccion($this->input->get('Clave'), $this->input->get('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada() {
        try {

            print json_encode($this->CancelaEntradasSalidas_model->onVerificarSemanaProdCerrada(
                                    $this->input->get('Ano'), $this->input->get('Maq'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->CancelaEntradasSalidas_model->onComprobarMaquilas($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarDoctos() {
        try {
            $x = $this->input;
            $this->CancelaEntradasSalidas_model->onCancelarDoctos($x->post('DocMov'), $x->post('Maq'), $x->post('Sem'), $x->post('Ano'));
            if (intval($x->post('Maq')) === 97) {
                $this->CancelaEntradasSalidas_model->onCancelarDoctosFabrica($x->post('DocMov'), $x->post('Maq'), $x->post('Sem'), $x->post('Ano'));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
