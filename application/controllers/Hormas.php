<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Hormas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Hormas_model')->model('Series_model')->model('Maquilas_model');
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
            $this->load->view('vHormas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getSeries() {
        try {
            print json_encode($this->Series_model->getSeries());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->Maquilas_model->getMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Hormas_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Hormas_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHormaByID() {
        try {
            print json_encode($this->Hormas_model->getHormaByID($this->input->get('ID')));
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

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->Hormas_model->onAgregar(array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Maquila' => ($x->post('Maquila') !== NULL) ? $x->post('Maquila') : NULL,
                'Ex1' => ($x->post('C1') !== NULL) ? $x->post('C1') : 0,
                'Ex2' => ($x->post('C2') !== NULL) ? $x->post('C2') : 0,
                'Ex3' => ($x->post('C3') !== NULL) ? $x->post('C3') : 0,
                'Ex4' => ($x->post('C4') !== NULL) ? $x->post('C4') : 0,
                'Ex5' => ($x->post('C5') !== NULL) ? $x->post('C5') : 0,
                'Ex6' => ($x->post('C6') !== NULL) ? $x->post('C6') : 0,
                'Ex7' => ($x->post('C7') !== NULL) ? $x->post('C7') : 0,
                'Ex8' => ($x->post('C8') !== NULL) ? $x->post('C8') : 0,
                'Ex9' => ($x->post('C9') !== NULL) ? $x->post('C9') : 0,
                'Ex10' => ($x->post('C10') !== NULL) ? $x->post('C10') : 0,
                'Ex11' => ($x->post('C11') !== NULL) ? $x->post('C11') : 0,
                'Ex12' => ($x->post('C12') !== NULL) ? $x->post('C12') : 0,
                'Ex13' => ($x->post('C13') !== NULL) ? $x->post('C13') : 0,
                'Ex14' => ($x->post('C14') !== NULL) ? $x->post('C14') : 0,
                'Ex15' => ($x->post('C15') !== NULL) ? $x->post('C15') : 0,
                'Ex16' => ($x->post('C16') !== NULL) ? $x->post('C16') : 0,
                'Ex17' => ($x->post('C17') !== NULL) ? $x->post('C17') : 0,
                'Ex18' => ($x->post('C18') !== NULL) ? $x->post('C18') : 0,
                'Ex19' => ($x->post('C19') !== NULL) ? $x->post('C19') : 0,
                'Ex20' => ($x->post('C20') !== NULL) ? $x->post('C20') : 0,
                'Ex21' => ($x->post('C21') !== NULL) ? $x->post('C21') : 0,
                'Ex22' => ($x->post('C22') !== NULL) ? $x->post('C22') : 0,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            var_dump($x->post());
            $horma = array(
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Maquila' => ($x->post('Maquila') !== NULL) ? $x->post('Maquila') : NULL
            );
            $this->Hormas_model->onModificar($x->post('ID'), $horma);
            for ($i = 1; $i <= 22; $i++) {
                if ($x->post("C$i") > 0) {
                    $ne = $x->post("Ex$i") + $x->post("C$i");
                    $this->Hormas_model->onModificar($x->post('ID'), array("Ex$i" => $ne));
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Hormas_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
