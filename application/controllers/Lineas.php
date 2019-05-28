<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Lineas_model')->model('Temporadas_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vLineas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getTemporadas() {
        try {
            extract($this->input->post());
            $data = $this->Temporadas_model->getTemporadas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Lineas_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineasSelect() {
        try {
            print json_encode($this->Lineas_model->getLineasSelect());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave() {
        try {
            print json_encode($this->Lineas_model->onComprobarClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaByID() {
        try {
            print json_encode($this->Lineas_model->getLineaByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->Lineas_model->onAgregar(array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Ano' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL,
                'Temporada' => ($x->post('Temporada') !== NULL) ? $x->post('Temporada') : NULL,
                'Tipo' => ($x->post('Tipo') !== NULL) ? $x->post('Tipo') : NULL,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $this->Lineas_model->onModificar($x->post('ID'), array(
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Ano' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL,
                'Temporada' => ($x->post('Temporada') !== NULL) ? $x->post('Temporada') : NULL,
                'Tipo' => ($x->post('Tipo') !== NULL) ? $x->post('Tipo') : NULL,
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Lineas_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
