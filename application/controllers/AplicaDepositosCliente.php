<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class AplicaDepositosCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AplicaDepositosCliente_model', 'adc')->helper('jaspercommand_helper')->helper('file');
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

            $this->load->view('vFondo')->view('vAplicaDepositosCliente')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getBancos() {
        try {
            print json_encode($this->adc->getBancos($this->input->get('Tp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCtaBancoCont() {
        try {
            $banco = $this->input->get('Banco');
            print json_encode($this->db->query("select "
                                    . "sctaconf "
                                    . "from bancos "
                                    . "where clave = $banco  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaExisteDepoCliente() {
        try {
            $doc = $this->input->get('Docto');
            print json_encode($this->db->query("select "
                                    . "docto  "
                                    . "from depoctes "
                                    . "where remicion = $doc order by docto desc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $bco = $this->input->post('Banco');
            $tp = $this->input->post('Tp');
            $fecha = $this->input->post('Fecha');
            $rem = ($this->input->post('Rem') !== NULL) ? $this->input->post('Rem') : 0;

            print json_encode($this->db->query("SELECT tipo,banco,cuenta,date_format(fecha,'%d/%m/%Y') as fecha, docto,importe,pagos,tmnda,tcamb,importemn
                                                FROM depoctes
                                                where banco = $bco
                                                and tipo = $tp
                                                and case when $rem > 0 then remicion = $rem else '' end
                                                and fecha = str_to_date('$fecha','%d/%m/%Y') "
                                    . " ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            $doc = $this->input->get('Doc');
            $cliente = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query(" "
                                    . "select remicion "
                                    . "from cartcliente "
                                    . "where "
                                    . "remicion = $doc "
                                    . "and cliente = $cliente "
                                    . "and tipo = $tp "
                                    . "order by ID asc  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $fecha = str_replace('/', '-', $this->input->post('FechaDoc'));
            $nuevaFecha = date("Y-m-d", strtotime($fecha));
            $datos = array(
                'cliente' => 0,
                'remicion' => $this->input->post('Remi'),
                'fecha' => $nuevaFecha,
                'fechacap' => Date('Y-m-d'),
                'tipo' => $this->input->post('Tp'),
                'importe' => $this->input->post('Importe'),
                'pagos' => 0,
                'banco' => $this->input->post('Banco'),
                'cuenta' => $this->input->post('CtaCont'),
                'docto' => $this->input->post('Doc'),
                'tmnda' => $this->input->post('Moneda'),
                'tcamb' => $this->input->post('TipoCambio'),
                'importemn' => $this->input->post('ImporteTC')
            );
            $this->db->insert('depoctes', $datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->where('docto', $this->input->post('Doc'))
                    ->where('cuenta', $this->input->post('Cuenta'))
                    ->where('banco', $this->input->post('Banco'))
                    ->where('tipo', $this->input->post('Tp'))
                    ->delete('depoctes');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte */

    public function onImprimirDepositoClientes() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fecha"] = $this->input->post('Fecha');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\depositosCapturadosNoAplicados.jasper');
        $jc->setFilename('DEPOSITOS_CLIENTES_NO_IDENT_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirDepositoClientesNoApli() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\depositosCapturadosNoAplicadosDos.jasper');
        $jc->setFilename('DEPOSITOS_CLIENTES_NO_APLI_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
