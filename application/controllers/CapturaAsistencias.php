<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaAsistencias extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaAsistencias_model')->model('SemanasNomina_model')->model('Departamentos_model')->helper('file')->helper('jaspercommand_helper');
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
            $this->load->view('vCapturaAsistencias')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDepartamentoByEmpleado() {
        try {
            print json_encode($this->CapturaAsistencias_model->getDepartamentoByEmpleado($this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->CapturaAsistencias_model->getEmpleadosGeneral());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $A = $this->CapturaAsistencias_model->onVerificarAsistenciaCapturada($x->post('Ano'), $x->post('Sem'), $x->post('Empleado'));

            if (!empty($A)) {
                $this->db->where('numemp', $x->post('Empleado'))->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
                $this->db->update("asistencia", array(
                    'numasistencias' => $x->post('NumAsistencias')
                ));
            } else {
                $this->db->insert("asistencia", array(
                    'numsem' => $x->post('Sem'),
                    'numemp' => $x->post('Empleado'),
                    'numasistencias' => $x->post('NumAsistencias'),
                    'año' => $x->post('Ano')
                ));
            }


            /* Graba en nomina */
            $this->db->where('numemp', $x->post('Empleado'))->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
            $this->db->set('diasemp', $x->post('NumAsistencias'))->update("prenomina");

            /* Graba en nomina linea */
            $this->db->where('numemp', $x->post('Empleado'))->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
            $this->db->set('diasemp', $x->post('NumAsistencias'))->update("prenominal");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAsistenciaTodos() {
        try {
            $x = $this->input;
            $Empleados = $this->CapturaAsistencias_model->getEmpleadosGeneral();

            foreach ($Empleados as $key => $E) {

                $A = $this->CapturaAsistencias_model->onVerificarAsistenciaCapturada($x->post('Ano'), $x->post('Sem'), $E->Clave);
                if (!empty($A)) {
                    $this->db->where('numemp', $E->Clave)->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
                    $this->db->update("asistencia", array(
                        'numasistencias' => $x->post('NumAsistencias')
                    ));
                } else {
                    $this->db->insert("asistencia", array(
                        'numsem' => $x->post('Sem'),
                        'numemp' => $E->Clave,
                        'numasistencias' => $x->post('NumAsistencias'),
                        'año' => $x->post('Ano')
                    ));
                }
            }

            /* Graba en nomina */
            $this->db->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
            $this->db->set('diasemp', $x->post('NumAsistencias'))->update("prenomina");

            /* Graba en nomina linea */
            $this->db->where('numsem', $x->post('Sem'))->where('año', $x->post('Ano'));
            $this->db->set('diasemp', $x->post('NumAsistencias'))->update("prenominal");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
