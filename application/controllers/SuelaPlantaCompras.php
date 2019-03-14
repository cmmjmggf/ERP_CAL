<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class SuelaPlantaCompras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('Suelaplantacompras_model')
                ->model('Series_model')
                ->helper('ReportesCompras_helper')
                ->helper('file');
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
            $this->load->view('vSuelaPlantaCompras');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Suelaplantacompras_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSeries() {
        try {
            $data = $this->Series_model->getSeries();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarArticulo() {
        try {
            print json_encode($this->Suelaplantacompras_model->onComprobarArticulo($this->input->get('ArticuloCBZ')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSerieXClave() {
        try {
            print json_encode($this->Series_model->getSerieXClave($this->input->post('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByGrupo() {
        try {
            print json_encode($this->Suelaplantacompras_model->getArticulosByGrupo($this->input->get('Grupo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSuelaPlantabyID() {
        try {
            print json_encode($this->Suelaplantacompras_model->getSuelaPlantabyID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->Suelaplantacompras_model->onAgregar(array(
                'ArticuloCBZ' => ($x->post('ArticuloCBZ') !== NULL) ? $x->post('ArticuloCBZ') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Registro' => Date('d/m/Y'),
                'Grupo' => ($x->post('Grupo') !== NULL) ? $x->post('Grupo') : NULL,
                'A1' => ($x->post('A1') !== NULL) ? $x->post('A1') : 0,
                'A2' => ($x->post('A2') !== NULL) ? $x->post('A2') : 0,
                'A3' => ($x->post('A3') !== NULL) ? $x->post('A3') : 0,
                'A4' => ($x->post('A4') !== NULL) ? $x->post('A4') : 0,
                'A5' => ($x->post('A5') !== NULL) ? $x->post('A5') : 0,
                'A6' => ($x->post('A6') !== NULL) ? $x->post('A6') : 0,
                'A7' => ($x->post('A7') !== NULL) ? $x->post('A7') : 0,
                'A8' => ($x->post('A8') !== NULL) ? $x->post('A8') : 0,
                'A9' => ($x->post('A9') !== NULL) ? $x->post('A9') : 0,
                'A10' => ($x->post('A10') !== NULL) ? $x->post('A10') : 0,
                'A11' => ($x->post('A11') !== NULL) ? $x->post('A11') : 0,
                'A12' => ($x->post('A12') !== NULL) ? $x->post('A12') : 0,
                'A13' => ($x->post('A13') !== NULL) ? $x->post('A13') : 0,
                'A14' => ($x->post('A14') !== NULL) ? $x->post('A14') : 0,
                'A15' => ($x->post('A15') !== NULL) ? $x->post('A15') : 0,
                'A16' => ($x->post('A16') !== NULL) ? $x->post('A16') : 0,
                'A17' => ($x->post('A17') !== NULL) ? $x->post('A17') : 0,
                'A18' => ($x->post('A18') !== NULL) ? $x->post('A18') : 0,
                'A19' => ($x->post('A19') !== NULL) ? $x->post('A19') : 0,
                'A20' => ($x->post('A20') !== NULL) ? $x->post('A20') : 0,
                'A21' => ($x->post('A21') !== NULL) ? $x->post('A21') : 0,
                'A22' => ($x->post('A22') !== NULL) ? $x->post('A22') : 0,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $datos = array(
                'A1' => ($x->post('A1') !== NULL) ? $x->post('A1') : 0,
                'A2' => ($x->post('A2') !== NULL) ? $x->post('A2') : 0,
                'A3' => ($x->post('A3') !== NULL) ? $x->post('A3') : 0,
                'A4' => ($x->post('A4') !== NULL) ? $x->post('A4') : 0,
                'A5' => ($x->post('A5') !== NULL) ? $x->post('A5') : 0,
                'A6' => ($x->post('A6') !== NULL) ? $x->post('A6') : 0,
                'A7' => ($x->post('A7') !== NULL) ? $x->post('A7') : 0,
                'A8' => ($x->post('A8') !== NULL) ? $x->post('A8') : 0,
                'A9' => ($x->post('A9') !== NULL) ? $x->post('A9') : 0,
                'A10' => ($x->post('A10') !== NULL) ? $x->post('A10') : 0,
                'A11' => ($x->post('A11') !== NULL) ? $x->post('A11') : 0,
                'A12' => ($x->post('A12') !== NULL) ? $x->post('A12') : 0,
                'A13' => ($x->post('A13') !== NULL) ? $x->post('A13') : 0,
                'A14' => ($x->post('A14') !== NULL) ? $x->post('A14') : 0,
                'A15' => ($x->post('A15') !== NULL) ? $x->post('A15') : 0,
                'A16' => ($x->post('A16') !== NULL) ? $x->post('A16') : 0,
                'A17' => ($x->post('A17') !== NULL) ? $x->post('A17') : 0,
                'A18' => ($x->post('A18') !== NULL) ? $x->post('A18') : 0,
                'A19' => ($x->post('A19') !== NULL) ? $x->post('A19') : 0,
                'A20' => ($x->post('A20') !== NULL) ? $x->post('A20') : 0,
                'A21' => ($x->post('A21') !== NULL) ? $x->post('A21') : 0,
                'A22' => ($x->post('A22') !== NULL) ? $x->post('A22') : 0
            );


            $this->Suelaplantacompras_model->onModificar($x->post('ID'), $datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
