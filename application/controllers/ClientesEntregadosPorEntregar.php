<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ClientesEntregadosPorEntregar extends CI_Controller {

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
                case 'CLIENTES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vClientesEntregadosPorEntregar')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReportePedidosXEntregarFecha() {
        try {
            $Cliente = $this->input->post('Cliente');

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["cliente"] = $Cliente;
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\clientes\PedidosClientePorEntregar.jasper');
            $jc->setFilename('CTE_PEDIDOS_X_ENTREGAR' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select clave from clientes where clave = '$Cliente' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosEntregados() {
        $cte = $this->input->get('Cliente');
        print json_encode($this->db->query("SELECT
                                            p.cliente, p.clave as pedido, p.maquila,
                                            date_format( str_to_date(p.fechapedido,'%d/%m/%Y') , '%d/%m/%Y') as fechaped,
                                            date_format( str_to_date(p.fechaentrega,'%d/%m/%Y') , '%d/%m/%Y') as fechaentrega,
                                            p.semana, p.pares, p.paresfacturados,
                                            p.control, p.estilo, concat(p.color,' ',p.colort) as color, p.precio,
                                            ifnull(P.EstatusProduccion,'PROGRAMADO') as avance
                                            FROM pedidox P 
                                            WHERE p.stsavan = 13 and p.cliente= $cte  ")->result());
    }

    public function getPedidosNoEntregados() {
        $cte = $this->input->get('Cliente');
        print json_encode($this->db->query("SELECT
                                            p.cliente, p.clave as pedido, p.maquila,
                                            date_format( str_to_date(p.fechapedido,'%d/%m/%Y') , '%d/%m/%Y') as fechaped,
                                            date_format( str_to_date(p.fechaentrega,'%d/%m/%Y') , '%d/%m/%Y') as fechaentrega,
                                            p.semana, p.pares, p.paresfacturados,
                                            p.control, p.estilo, concat(p.color,' ',p.colort) as color, p.precio,
                                            ifnull(P.EstatusProduccion,'PROGRAMADO') as avance
                                            FROM pedidox P 
                                            WHERE p.stsavan <> 13 and p.stsavan <> 14 and p.cliente= $cte  ")->result());
    }

    public function getClientes() {
        try {
            print json_encode($this->db->select("C.Clave AS Clave, CONCAT(C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('Cliente', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
