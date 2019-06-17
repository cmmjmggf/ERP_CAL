<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ConceptosVariablesNomina extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('ConceptosVariablesNomina_model')->model('SemanasNomina_model')->model('Departamentos_model')->helper('file')->helper('jaspercommand_helper');
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
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vConceptosVariablesEmpleados')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->onVerificarSemanaNominaCerrada(
                                    $this->input->get('Sem'), $this->input->get('Ano')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarConceptoCapturado() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->onVerificarConceptoCapturado(
                                    $this->input->get('Concepto'), $this->input->get('Ano'), $this->input->get('Sem'), $this->input->get('Empleado')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDiasAsistenciaXEmpleadoSem() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getDiasAsistenciaXEmpleadoSem(
                                    $this->input->get('Empleado'), $this->input->get('Ano'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getEmpleadosGeneral());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNomina() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getConceptosNomina());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasNomina() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getSemanasNomina($this->input->get('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getRecords(
                                    $this->input->get('Empleado'), $this->input->get('Ano'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $this->ConceptosVariablesNomina_model->onEliminarDetalleByID(
                    $this->input->post('Empleado'), $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Concepto')
            );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;

            $origFecha = $x->post('Fecha');
            $fecha = str_replace('/', '-', $origFecha);
            $nuevaFecha = date("Y-m-d", strtotime($fecha));


            $data = array(
                'numeroempleado' => ($x->post('Empleado') !== NULL) ? $x->post('Empleado') : NULL,
                'maquila' => 2,
                'control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                'estilo' => ($x->post('Estilo') !== NULL) ? $x->post('Estilo') : NULL,
                'numfrac' => ($x->post('Fraccion') !== NULL) ? $x->post('Fraccion') : NULL,
                'preciofrac' => ($x->post('Precio') !== NULL) ? $x->post('Precio') : NULL,
                'pares' => ($x->post('Pares') !== NULL) ? $x->post('Pares') : NULL,
                'subtot' => ($x->post('Subtotal') !== NULL) ? $x->post('Subtotal') : NULL,
                'depto' => ($x->post('DeptoEmp') !== NULL) ? $x->post('DeptoEmp') : NULL,
                'fecha' => $nuevaFecha,
                'status' => 1,
                'semana' => ($x->post('Sem') !== NULL) ? $x->post('Sem') : NULL,
                'anio' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL
            );
            $this->ConceptosVariablesNomina_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
