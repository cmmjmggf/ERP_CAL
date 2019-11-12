<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class RastreoDeEstilosEnPedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
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
            }
            $this->load->view('vFondo')->view('vRastreoDeEstilosEnPedidos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getPedidos() {
        try {
            $x = $this->input->get();
            $this->db->select("P.ID AS ID, P.Cliente AS CLIENTE, P.Estilo AS ESTILO,
                P.Color AS COLOR, P.Pares AS PARES, P.Control AS CONTROL, P.Maquila AS MAQUILA,
                P.Semana AS SEMANA, P.Clave AS PEDIDO, P.FechaEntrega AS FECHA_ENTREGA,
                P.FechaEntrega AS FECHA_VENTA, P.Precio AS PRECIO, P.stsavan AS AVANCE", false)
                    ->from('pedidox AS P');
            if ($x['ESTILO'] !== '') {
                $this->db->where('P.Estilo', $x['ESTILO']);
            }
            if ($x['COLOR'] !== '') {
                $this->db->where('P.Color', $x['COLOR']);
            }
            if ($x['CLIENTE'] !== '') {
                $this->db->where('P.Cliente', $x['CLIENTE']);
            }
            if ($x['ESTILO'] === '' || $x['COLOR'] === '' || $x['CLIENTE'] === '') {
                $this->db->order_by('P.FechaPedido', 'DESC')->limit(99);
            } else {
                $this->db->order_by('P.FechaPedido', 'DESC');
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporte() {
        try {
            $x = $this->input->post();
            $ESTILO = $x['ESTILO'] !== '' ? $x['ESTILO'] : '';
            $COLOR = $x['COLOR'] !== '' ? $x['COLOR'] : '';
            $CLIENTE = $x['CLIENTE'] !== '' ? $x['CLIENTE'] : '';
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["ESTILO"] = $ESTILO;
            $parametros["COLOR"] = $COLOR;
            $parametros["CLIENTE"] = $CLIENTE;
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\clientes\rastreo_estilo_color_cliente.jasper');
            $jc->setFilename('ReporteDelSistema' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
