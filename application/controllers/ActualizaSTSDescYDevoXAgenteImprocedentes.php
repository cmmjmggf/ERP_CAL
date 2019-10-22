<?php

require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
defined('BASEPATH') OR exit('No direct script access allowed');

class ActualizaSTSDescYDevoXAgenteImprocedentes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vActualizaSTSDescYDevoXAgenteImprocedentes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReporteXCliente() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["tp"] = $this->input->post('Tp');
        $parametros["agente"] = $this->input->post('Agente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\descuentosimproce\reporteDescuentosImprocedentesXCliente.jasper');
        $jc->setFilename('DESCUENTOS_Y_DEV_X_RECIBIR_X_CLIENTE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["tp"] = $this->input->post('Tp');
        $parametros["agente"] = $this->input->post('Agente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\descuentosimproce\reporteDescuentosImprocedentes.jasper');
        $jc->setFilename('DESCUENTOS_Y_DEV_X_RECIBIR_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onEliminarRegistro() {
        try {
            $ID = $this->input->post('ID');
            $this->db->query("delete from desdevimpro where ID = $ID ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCargarAAgentes() {
        try {
            $ID = $this->input->post('ID');
            $this->db->query("update desdevimpro set status = 1 where ID = $ID ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevDescImprocedentes() {
        try {
            $tp = $this->input->get('Tp');
            $agente = $this->input->get('Agente');
            print json_encode($this->db->query("SELECT cliente, docto, importe, mov, doctopa, ID as tp "
                                    . " FROM desdevimpro "
                                    . " WHERE mov = 6 and status =  1 "
                                    . " and tp = $tp and agente = $agente ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevImprocedentes() {
        try {
            $tp = $this->input->get('Tp');
            $agente = $this->input->get('Agente');
            print json_encode($this->db->query("SELECT cliente, docto, importe, mov, doctopa, ID as tp "
                                    . " FROM desdevimpro "
                                    . " WHERE mov = 6 and status =  0 "
                                    . " and tp = $tp and agente = $agente ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDescDescImprocedentes() {
        try {
            $tp = $this->input->get('Tp');
            $agente = $this->input->get('Agente');
            print json_encode($this->db->query("SELECT cliente, docto, importe, mov, doctopa, ID as tp "
                                    . " FROM desdevimpro "
                                    . " WHERE mov = 5 and status =  1 "
                                    . " and tp = $tp and agente = $agente ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDescImprocedentes() {
        try {
            $tp = $this->input->get('Tp');
            $agente = $this->input->get('Agente');
            print json_encode($this->db->query("SELECT cliente, docto, importe, mov, doctopa, ID as tp "
                                    . " FROM desdevimpro "
                                    . " WHERE mov = 5 and status =  0 "
                                    . " and tp = $tp and agente = $agente ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
