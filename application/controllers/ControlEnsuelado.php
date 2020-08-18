<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlEnsuelado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('ControlPlantilla_model', 'cpm')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion')->view('vControlEnsuelado')->view('vFooter');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes')->view('vControlEnsuelado')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlEnsuelado')->view('vFooter');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion')->view('vControlEnsuelado')->view('vFooter');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion')->view('vControlEnsuelado')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlEnsuelado')->view('vFooter');
                    break;
                default :
                    $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarEmpleado() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero from empleados "
                                    . " where numero = $clave and altabaja = 1 and FijoDestajoAmbos in (2,3) "
                                    . "   ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Traer los de la fecha de actual para que solo muestre los del dia */

    public function getRecords() {
        try {
            $this->db->select('CP.`ID`,
                                        CP.`Empleado` AS NUMEMP,
                                        CP.`EmpleadoT` AS NOMEMP,
                                        CP.`Control` AS CONTROL,
                                        CP.`Fecha` AS FECHA,
                                          CONCAT("<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminarControlEnsuelado(",CP.Control,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN', false)
                    ->from('controlens AS CP')->where("DATE_FORMAT(CP.Registro, '%Y-%m-%d') =   CURDATE()", null, false);


            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->db->select('PRM.Numero AS ID, PRM.BUSQUEDA AS EMPLEADO', false)
                                    ->from('empleados AS PRM')->where('PRM.Altabaja ', '1')->where_in('PRM.FijoDestajoAmbos ', array('2', '3'))
                                    ->order_by('EMPLEADO', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->cpm->getInfoXControlEnsuelado($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input;
            $this->db->insert('controlens', array(
                'Empleado' => $x->post('Empleado'),
                'EmpleadoT' => $x->post('EmpleadoT'),
                'Control' => $x->post('CONTROL'),
                'Fecha' => $x->post('FECHA'),
                'Registro' => Date('Y-m-d H:i:s'),
                'Usuario' => $this->session->ID,
                'UsuarioT' => $this->session->USERNAME
            ));
            $this->db->set('AsignadoPegado', 1)->where('Control', $x->post('CONTROL'))->update('pedidox');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $Control = $this->input->post('Control');
            $this->db->where('control', $Control);
            $this->db->delete("controlens");

            $this->db->set('AsignadoPegado', 0)->where('Control', $Control)->update('pedidox');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
