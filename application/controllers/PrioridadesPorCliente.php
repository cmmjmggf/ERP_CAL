<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class PrioridadesPorCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('PrioridadesPorCliente_model')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vPrioridadesPorCliente');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getClientesEtiXCli() {
        try {
            print json_encode($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesVisPed() {
        try {
            print json_encode($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePedidoGeneral() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["dSem"] = $this->input->post('dSem');
        $parametros["aSem"] = $this->input->post('aSem');
        $parametros["Ano"] = $this->input->post('ano');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reportePedidosGeneral.jasper');

        $jc->setFilename('REPORTE_PEDIDOS_GENERAL_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReportePedidoCliente() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Cliente"] = $this->input->post('Cliente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reportePedidosCliente.jasper');

        $jc->setFilename('REPORTE_PEDIDOS_CLIENTE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReportePedidoControl() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Pedido"] = $this->input->post('Pedido');
        $parametros["Cliente"] = $this->input->post('Cliente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reportePedidoClienteControl.jasper');

        $jc->setFilename('REPORTE_PEDIDO_CLIENTE_CONTROL_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificarCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select * from clientesprioridad where cliente = '$Cliente' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarClienteAgregarPrioridad() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select clave from clientes where clave = '$Cliente' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesPrioridad() {
        try {
            print json_encode($this->db->query("select CP.cliente, (select razons from clientes where clave = CP.cliente ) as nomcliente from clientesprioridad CP order by abs(CP.cliente) asc  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $cliente = $this->input->post('Cliente');
            print json_encode($this->PrioridadesPorCliente_model->getRecords($cliente));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->PrioridadesPorCliente_model->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarClientePrioridad() {
        try {
            $cte = $this->input->post('Cliente');
            $existe = $this->db->query("select cliente from clientesprioridad where cliente = $cte ")->result();
            if (empty($existe)) {
                $this->db->insert("clientesprioridad", array(
                    'cliente' => $this->input->post('Cliente')
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
