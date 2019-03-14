<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Generos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Generos_model')->model('Series_model');
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
            $this->load->view('vGeneros');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getSeries() {
        try {
            extract($this->input->post());
            $data = $this->Series_model->getSeries();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Generos_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Generos_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGeneroByID() {
        try {
            print json_encode($this->Generos_model->getGeneroByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave() {
        try {
            print json_encode($this->Generos_model->onComprobarClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->Generos_model->onAgregar(array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Nombre' => ($x->post('Nombre') !== NULL) ? $x->post('Nombre') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Descripcion1' => ($x->post('Descripcion1') !== NULL) ? $x->post('Descripcion1') : NULL,
                'Descripcion2' => ($x->post('Descripcion2') !== NULL) ? $x->post('Descripcion2') : NULL,
                'Descripcion3' => ($x->post('Descripcion3') !== NULL) ? $x->post('Descripcion3') : NULL,
                'ClaveProductoSAT' => ($x->post('ClaveProductoSAT') !== NULL) ? $x->post('ClaveProductoSAT') : NULL,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $this->Generos_model->onModificar($x->post('ID'), array(
                'Nombre' => ($x->post('Nombre') !== NULL) ? $x->post('Nombre') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Descripcion1' => ($x->post('Descripcion1') !== NULL) ? $x->post('Descripcion1') : NULL,
                'Descripcion2' => ($x->post('Descripcion2') !== NULL) ? $x->post('Descripcion2') : NULL,
                'Descripcion3' => ($x->post('Descripcion3') !== NULL) ? $x->post('Descripcion3') : NULL,
                'ClaveProductoSAT' => ($x->post('ClaveProductoSAT') !== NULL) ? $x->post('ClaveProductoSAT') : NULL,
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Generos_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
