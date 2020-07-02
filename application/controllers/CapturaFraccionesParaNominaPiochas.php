<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaFraccionesParaNominaPiochas extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaFraccionesParaNomina_model')->model('SemanasNomina_model')->helper('file')->helper('jaspercommand_helper');
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
            $this->load->view('vCapturaDestajosPiochas')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReporteDestajos() {
        $Reporte = $this->input->post('Reporte');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["emp"] = $this->input->post('Emp');

        $report_name = "jrxml\destajos\\{$Reporte}.jasper";


        $jc->setJasperurl($report_name);
        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_DESTAJOS_NOMINA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteRastreoControl() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["control"] = $this->input->post('Control');
        $jc->setJasperurl("jrxml\destajos\destajoNominaRastreoControl.jasper");
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_RASTREO_CONTROL_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificarFraccion() {
        try {
            $estilo = $this->input->get('Estilo');
            $numfrac = $this->input->get('Fraccion');
            print json_encode($this->db->query("select fraccion from fraccionesxestilo where fraccion = $numfrac and estilo = '$estilo' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEmpleado() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero from empleados "
                                    . " where numero = $clave and altabaja = 1 and FijoDestajoAmbos in (2,3) "
                                    . " or (numero between 899 and 1006 and numero = $clave ) ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->onVerificarSemanaNominaCerrada(
                                    $this->input->get('Sem'), $this->input->get('Ano')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarFraccionCapturada() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->onVerificarFraccionCapturada(
                                    $this->input->get('Fraccion'), $this->input->get('Control'), $this->input->get('Empleado')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControl() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha() {
        try {
            print json_encode($this->SemanasNomina_model->getSemanaByFecha($this->input->get('Fecha')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccion() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getPrecioFraccion($this->input->get('Fraccion'), $this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesByEstilo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getFraccionesByEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoByEmpleado() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getDepartamentoByEmpleado($this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosGeneral() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getEmpleadosGeneral());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNomina() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getConceptosNomina());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNominaRastreo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getConceptosNominaRastreo(
                                    $this->input->get('Ano'), $this->input->get('Emp'), $this->input->get('Concepto')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesNominaRastreo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getControlesNominaRastreo(
                                    $this->input->get('Control'), $this->input->get('Ano'), $this->input->get('Sem'), $this->input->get('Emp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getRecords($this->input->get('Ano'), $this->input->get('Sem'), $this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $this->CapturaFraccionesParaNomina_model->onEliminarDetalleByID($this->input->post('Control'), $this->input->post('Empleado'), $this->input->post('Fraccion'));
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
                'anio' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL,
                'modulo' => 'CNPIO',
                "fecha_registro" => Date('d/m/Y h:i:s')
            );
            if ($x->post('Control') !== '0' && $x->post('Control') !== '') {
                $stsnom = $this->CapturaFraccionesParaNomina_model->onVerificarSemanaNominaCerrada($this->input->post('Sem'), $this->input->post('Ano'));
                if (!empty($stsnom)) {
                    if ($stsnom[0]->status === '2') {
                        print 2;
                        exit();
                    } else if ($stsnom[0]->status === '1') {
                        $this->CapturaFraccionesParaNomina_model->onAgregar($data);
                    }
                } else {
                    $this->CapturaFraccionesParaNomina_model->onAgregar($data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
