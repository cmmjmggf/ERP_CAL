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
                    $this->load->view('vNavGeneral');
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

    public function onVerificarEmpleadoComidas() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero from empleados where numero = $clave and comedor = 1 and altabaja = 1 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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

    public function onVerificarConcepto() {
        try {
            $clave = $this->input->get('Concepto');
            print json_encode($this->db->query("select clave from conceptosnomina where clave = $clave and estatus = 'ACTIVO' and clave not in ('65','70') ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
//            print json_encode($this->ConceptosVariablesNomina_model->onVerificarSemanaNominaCerrada(
//                                    $this->input->get('Sem'), $this->input->get('Ano')
//            ));
            $x = $this->input->get();
            $this->db->select(" PM.status as 'status' "
                    . "FROM "
                    . "prenomina PM "
                    . "where PM.numsem = {$x['Sem']} "
                    . "and PM.año = {$x['Ano']} "
                    . " ")->group_by('PM.numsem');

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            print json_encode($data);
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

    public function getTipoConcepto() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getTipoConcepto($this->input->get('Concepto')));
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

    public function getDepartamentoByEmpleado() {
        try {
            print json_encode($this->ConceptosVariablesNomina_model->getDepartamentoByEmpleado($this->input->get('Empleado')));
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
            $PN = $this->ConceptosVariablesNomina_model->onVerificarConceptoCapturado($x->post('Concepto'), $x->post('Ano'), $x->post('Sem'), $x->post('Empleado'));

            /* PRENOMINA */
            if (!empty($PN)) {
                $this->db->where('numemp', $x->post('Empleado'))
                        ->where('numsem', $x->post('Sem'))
                        ->where('año', $x->post('Ano'))
                        ->where('numcon', $x->post('Concepto'));
                $this->db->update("prenomina", array(
                    'registro' => 999,
                    'tpcon' => ($x->post('tpcon') === '1') ? $x->post('tpcon') : 0,
                    'tpcond' => ($x->post('tpcon') === '2') ? $x->post('tpcon') : 0,
                    'importe' => ($x->post('tpcon') === '1') ? $x->post('Importe') : 0,
                    'imported' => ($x->post('tpcon') === '2') ? $x->post('Importe') : 0
                ));
            } else {
                $this->db->insert("prenomina", array(
                    'numsem' => $x->post('Sem'),
                    'numemp' => $x->post('Empleado'),
                    'numcon' => $x->post('Concepto'),
                    'año' => $x->post('Ano'),
                    'tpcon' => ($x->post('tpcon') === '1') ? $x->post('tpcon') : 0,
                    'tpcond' => ($x->post('tpcon') === '2') ? $x->post('tpcon') : 0,
                    'importe' => ($x->post('tpcon') === '1') ? $x->post('Importe') : 0,
                    'imported' => ($x->post('tpcon') === '2') ? $x->post('Importe') : 0,
                    'diasemp' => $x->post('diasemp'),
                    'fecha' => Date('Y-m-d'),
                    'tpomov' => 1,
                    'status' => 1,
                    'registro' => 999,
                    'depto' => $x->post('deptoemp')
                ));
            }

            /* PRENOMINA L */
            $PNL = $this->ConceptosVariablesNomina_model->getPrenominaLinea($x->post('Empleado'), $x->post('Sem'), $x->post('Ano'));

            if (!empty($PNL)) {

                $this->db->where('numemp', $x->post('Empleado'))->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));

                $this->db->set('diasemp', $x->post('diasemp'));
                $this->db->set('tpomov', 1);
                $this->db->set('status', 1);
                $this->db->set('registro', 999);
                $this->db->set('depto', $x->post('deptoemp'));
                $this->db->set('año', $x->post('Ano'));

                switch ($x->post('Concepto')) {
                    case '1':
                        $this->db->set('salario', $x->post('Importe'))->update("prenominal");
                        break;
                    case '5':
                        $this->db->set('salariod', $x->post('Importe'))->update("prenominal");
                        break;
                    case '10':
                        $this->db->set('horext', $x->post('Importe'))->update("prenominal");
                        break;
                    case '15':
                        $this->db->set('otrper', $x->post('Importe'))->update("prenominal");
                        break;
                    case '20':
                        $this->db->set('otrper1', $x->post('Importe'))->update("prenominal");
                        break;
                    case '50':
                        $this->db->set('infon', $x->post('Importe'))->update("prenominal");
                        break;
                    case '51':
                        $this->db->set('impu', $x->post('Importe'))->update("prenominal");
                        break;
                    case '55':
                        $this->db->set('imss', $x->post('Importe'))->update("prenominal");
                        break;
                    case '60':
                        $this->db->set('impu', $x->post('Importe'))->update("prenominal");
                        break;
                    case '65':
                        $this->db->set('precaha', $x->post('Importe'))->update("prenominal");
                        break;
                    case '70':
                        $this->db->set('cajhao', $x->post('Importe'))->update("prenominal");
                        break;
                    case '75':
                        $this->db->set('vtazap', $x->post('Importe'))->update("prenominal");
                        break;
                    case '80':
                        $this->db->set('zapper', $x->post('Importe'))->update("prenominal");
                        break;
                    case '85':
                        $this->db->set('fune', $x->post('Importe'))->update("prenominal");
                        break;
                    case '90':
                        $this->db->set('cargo', $x->post('Importe'))->update("prenominal");
                        break;
                    case '95':
                        $this->db->set('fonac', $x->post('Importe'))->update("prenominal");
                        break;
                    case '100':
                        $this->db->set('otrde', $x->post('Importe'))->update("prenominal");
                        break;
                    case '105':
                        $this->db->set('otrde1', $x->post('Importe'))->update("prenominal");
                        break;
                }
            } else {
                $this->db->insert("prenominal", array(
                    'numsem' => $x->post('Sem'),
                    'numemp' => $x->post('Empleado'),
                    'diasemp' => $x->post('diasemp'),
                    'tpomov' => 1,
                    'status' => 1,
                    'año' => $x->post('Ano'),
                    'registro' => 999,
                    'depto' => $x->post('deptoemp'),
                    'salario' => ($x->post('Concepto') === '1') ? $x->post('Importe') : 0,
                    'salariod' => ($x->post('Concepto') === '5') ? $x->post('Importe') : 0,
                    'horext' => ($x->post('Concepto') === '10') ? $x->post('Importe') : 0,
                    'otrper' => ($x->post('Concepto') === '15') ? $x->post('Importe') : 0,
                    'otrper1' => ($x->post('Concepto') === '20') ? $x->post('Importe') : 0,
                    'infon' => ($x->post('Concepto') === '50') ? $x->post('Importe') : 0,
                    'impu' => ($x->post('Concepto') === '51') ? $x->post('Importe') : 0,
                    'imss' => ($x->post('Concepto') === '55') ? $x->post('Importe') : 0,
                    'impu' => ($x->post('Concepto') === '60') ? $x->post('Importe') : 0,
                    'precaha' => ($x->post('Concepto') === '65') ? $x->post('Importe') : 0,
                    'cajhao' => ($x->post('Concepto') === '70') ? $x->post('Importe') : 0,
                    'vtazap' => ($x->post('Concepto') === '75') ? $x->post('Importe') : 0,
                    'zapper' => ($x->post('Concepto') === '80') ? $x->post('Importe') : 0,
                    'fune' => ($x->post('Concepto') === '85') ? $x->post('Importe') : 0,
                    'cargo' => ($x->post('Concepto') === '90') ? $x->post('Importe') : 0,
                    'fonac' => ($x->post('Concepto') === '95') ? $x->post('Importe') : 0,
                    'otrde' => ($x->post('Concepto') === '100') ? $x->post('Importe') : 0,
                    'otrde1' => ($x->post('Concepto') === '105') ? $x->post('Importe') : 0
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
