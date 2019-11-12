<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConceptosTesoreria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ConceptosTesoreria_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vConceptosTesoreria');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getUltimoRegistro() {
        try {
            print json_encode($this->ConceptosTesoreria_model->getUltimoRegistro());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->ConceptosTesoreria_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupoByID() {
        try {
            print json_encode($this->ConceptosTesoreria_model->getGrupoByID($this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            extract($this->input->post());
            $DATA = array(
                'Clave' => ($Clave !== NULL) ? $Clave : NULL,
                'Nombre' => ($Nombre !== NULL) ? $Nombre : NULL,
                'Tipo' => ($Tipo !== NULL) ? $Tipo : NULL,
                'Estatus' => 'ACTIVO'
            );
            $this->ConceptosTesoreria_model->onAgregar($DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            extract($this->input->post());
            $DATA = array(
                'Nombre' => ($Nombre !== NULL) ? $Nombre : NULL,
                'Tipo' => ($Tipo !== NULL) ? $Tipo : NULL
            );
            $this->ConceptosTesoreria_model->onModificar($ID, $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            extract($this->input->post());
            $this->ConceptosTesoreria_model->onEliminar($ID);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
