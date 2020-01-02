<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaNominaFraccionesSemanal extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaNominaFraccionesSemanal_model')->helper('file')->helper('jaspercommand_helper');
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
            $this->load->view('vCapturaNominaFraccionesSemanal')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarFraccion() {
        try {
            $numfrac = $this->input->get('Fraccion');
            print json_encode($this->db->query("select clave from fracciones where clave = $numfrac and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEmpleado() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero from empleados where numero = $clave and altabaja = 1 and FijoDestajoAmbos in (2,3) ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            print json_encode($this->CapturaNominaFraccionesSemanal_model->onVerificarSemanaNominaCerrada(
                                    $this->input->get('Sem'), $this->input->get('Ano')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoByEmpleado() {
        try {
            print json_encode($this->CapturaNominaFraccionesSemanal_model->getDepartamentoByEmpleado($this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->CapturaNominaFraccionesSemanal_model->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->CapturaNominaFraccionesSemanal_model->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->CapturaNominaFraccionesSemanal_model->getRecords(
                                    $this->input->get('Empleado'), $this->input->get('Ano'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->where('numeroempleado', $this->input->post('Empleado'))
                    ->where('semana', $this->input->post('Sem'))
                    ->where('anio', $this->input->post('Ano'))
                    ->where('numfrac', $this->input->post('Fraccion'));
            $this->db->delete("fracpagnomina");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $sem = $x->post('SemProd');
            $ano = $x->post('Ano');
            $fraccion = $x->post('Fraccion');
            $query = "select estilo, pares, control from pedidox where Semana = '$sem' and Maquila = '1' and Ano = '$ano' ";
            $Pedidos = $this->db->query($query)->result();

            if (!empty($Pedidos)) {
                foreach ($Pedidos as $P) {
                    //Obtenemos las fracciones
                    $query2 = "select CostoMO from fraccionesxestilo where Estilo = '$P->estilo' and Fraccion = '$fraccion'  ";
                    $FraccionesEstilo = $this->db->query($query2)->row();
                    $precio = (isset($FraccionesEstilo)) ? $FraccionesEstilo->CostoMO : 0;

                    //Agregamos el registro
                    $this->db->insert("fracpagnomina", array(
                        'numeroempleado' => ($x->post('Empleado') !== NULL) ? $x->post('Empleado') : NULL,
                        'maquila' => 1,
                        'control' => $P->control,
                        'estilo' => $P->estilo,
                        'numfrac' => ($x->post('Fraccion') !== NULL) ? $x->post('Fraccion') : NULL,
                        'preciofrac' => $precio,
                        'pares' => $P->pares,
                        'subtot' => floatval($P->pares) * floatval($precio),
                        'depto' => ($x->post('deptoemp') !== NULL) ? $x->post('deptoemp') : NULL,
                        'fecha' => Date('Y-m-d'),
                        'status' => 1,
                        'semana' => ($x->post('Sem') !== NULL) ? $x->post('Sem') : NULL,
                        'anio' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL
                    ));
                }

                //Imprimir reporte
                $jc = new JasperCommand();
                $jc->setFolder('rpt/' . $this->session->USERNAME);
                $parametros = array();
                $parametros["logo"] = base_url() . $this->session->LOGO;
                $parametros["empresa"] = $this->session->EMPRESA_RAZON;
                $parametros["emp"] = $this->input->post('Empleado');
                $parametros["sem"] = $this->input->post('Sem');
                $parametros["ano"] = $this->input->post('Ano');
                $jc->setJasperurl("jrxml\destajos\destajoNominaXEmpleadoSem.jasper");
                $jc->setParametros($parametros);
                $jc->setFilename('REPORTE_DESTAJO_SEM_' . Date('h_i_s'));
                $jc->setDocumentformat('pdf');
                PRINT $jc->getReport();
            } else {
                print 0;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
