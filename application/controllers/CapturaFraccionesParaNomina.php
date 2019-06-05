<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaFraccionesParaNomina extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaFraccionesParaNomina_model')->model('SemanasNomina_model')->helper('credencial_helper')->helper('file')->helper('jaspercommand_helper');
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
            $this->load->view('vCapturaDestajos')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
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
            print json_encode($this->CapturaFraccionesParaNomina_model->getRecords($this->input->get('Ano'), $this->input->get('Sem')));
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
                'anio' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL
            );
            $this->CapturaFraccionesParaNomina_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
