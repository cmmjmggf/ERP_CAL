<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaOtrosParaBanco extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaOtrosParaBanco_model')->model('SemanasNomina_model')->model('Departamentos_model')->helper('file')->helper('jaspercommand_helper');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }//Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuNominas');
                    }
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vCapturaOtrosParaBanco')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarEmpleado() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero from empleados where numero = $clave and altabaja = 1 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->CapturaOtrosParaBanco_model->getEmpleadosGeneral());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->CapturaOtrosParaBanco_model->getRecords(
                                    $this->input->get('Ano'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $this->CapturaOtrosParaBanco_model->onEliminarDetalleByID(
                    $this->input->post('Empleado'), $this->input->post('Ano'), $this->input->post('Sem')
            );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            /* PRENOMINA L */
            $PNL = $this->CapturaOtrosParaBanco_model->getPrenominaLinea($x->post('Empleado'), $x->post('Sem'), $x->post('Ano'));
            if (!empty($PNL)) {
                $this->db->where('numemp', $x->post('Empleado'))->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
                $this->db->set('salariod', $x->post('ImporteD'))
                        ->set('salfis', $x->post('ImporteF'))
                        ->update("prenominal");
            } else {
                $this->db->insert("prenominal", array(
                    'numsem' => $x->post('Sem'),
                    'numemp' => $x->post('Empleado'),
                    'status' => 2,
                    'diasemp' => 7,
                    'año' => $x->post('Ano'),
                    'salariod' => $x->post('ImporteD'),
                    'salfis' => $x->post('ImporteF')
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
