<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SemanasProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Semanasproduccion_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':

                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;


                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vSemanasProduccion');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            extract($this->input->post());
            $data = $this->Semanasproduccion_model->getRecords();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onValidarExisteAno() {
        try {
            print json_encode($this->Semanasproduccion_model->onValidarExisteAno($this->input->post('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaProduccionByAno() {
        try {
            extract($this->input->post());
            $data = $this->Semanasproduccion_model->getSemanaProduccionByAno($this->input->post('Ano'));
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasProduccionByAno() {
        try {
            print json_encode($this->Semanasproduccion_model->getSemanasProduccionByAno($this->input->post('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $Detalle = json_decode($this->input->post("Detalle"));
            foreach ($Detalle as $key => $v) {
                $data = array(
                    'Ano' => $v->Ano,
                    'Sem' => $v->Sem,
                    'FechaIni' => $v->FechaIni,
                    'FechaFin' => $v->FechaFin,
                    'Estatus' => 'ACTIVO'
                );
                $this->Semanasproduccion_model->onAgregar($data);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarExtra() {
        try {
            $data = array(
                'Ano' => $this->input->post('Ano'),
                'Sem' => $this->input->post('Sem'),
                'FechaIni' => $this->input->post('FechaIni'),
                'FechaFin' => $this->input->post('FechaFin'),
                'Estatus' => 'ACTIVO'
            );
            $this->Semanasproduccion_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            extract($this->input->post());
            unset($_POST['ID']);
            $this->Semanasproduccion_model->onModificar($ID, $this->input->post());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Semanasproduccion_model->onEliminar($this->input->post('Ano'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
