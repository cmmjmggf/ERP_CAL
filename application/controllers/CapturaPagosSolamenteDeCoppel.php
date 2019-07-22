<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CapturaPagosSolamenteDeCoppel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
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
                    $this->load->view('vMenuFacturacion');
                    break;
            }
            $this->load->view('vFondo')->view('vCapturaPagosSolamenteDeCoppel')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDocumentosConSaldoXClientes() {
        try {
            $x = $this->input->get();
            $this->db->select("CC.ID AS ID, CC.cliente AS CLIENTE, CC.remicion AS DOCUMENTO,
                CC.tipo AS TP, CC.fecha AS FECHA_DEPOSITO,  
                FORMAT(CC.importe,2) AS IMPORTE, FORMAT(CC.pagos,2) AS PAGOS, FORMAT(CC.saldo,2) AS SALDO, 
                CC.status AS ST, DATEDIFF(NOW(),fecha) AS DIAS, CC.saldo AS SALDOX", false)
                    ->from("cartcliente AS CC")
                    ->where('CC.cliente', 2121)->where('CC.saldo > ', 2);
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CC.remicion', $x['DOCUMENTO']);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosXDocumentos() {
        try {
            $this->db->select("CCP.ID AS ID, CCP.cliente AS CLIENTE, CCP.remicion AS DOCUMENTO, 
                CCP.tipo AS TP, CCP.fecha AS FECHA_DEPOSITO, CCP.fechacap AS FECHA_CAPTURA, 
                FORMAT(CCP.importe,2) AS IMPORTE, CCP.mov AS MV, CCP.doctopa AS REFERENCIA, 
                CCP.numfol AS DIAS ", false)
                    ->from("cartctepagos AS CCP");
            if ($this->input->get('DOCUMENTO') !== '') {
                $this->db->where('CCP.remicion', $this->input->get('DOCUMENTO'));
            }
            $this->db->where('CCP.cliente', 2121)
                    ->order_by("CCP.fecha", "DESC");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCartCliente() {
        try {
            print json_encode($this->db->query("SELECT CC.ID, CC.cliente, CC.remicion, date_format(CC.fecha,'%d/%m/%Y') AS fecha, CC.importe, CC.tipo, CC.numpol, CC.numcia, CC.status, CC.pagos, CC.saldo, CC.comiesp, CC.tcamb, CC.tmnda, CC.stscont, CC.nc, CC.factura FROM cartcliente AS CC WHERE cliente = 2121 AND status < 2 AND remicion LIKE '{$this->input->get("FACTURA")}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturaXNumero() {
        try {
            print json_encode($this->db->query("SELECT * FROM cfdifa AS F WHERE F.Factura LIKE '{$this->input->get('FACTURA')}' AND F.numero = {$this->input->get('TP')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
