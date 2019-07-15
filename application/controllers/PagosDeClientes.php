<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";
defined('BASEPATH') OR exit('No direct script access allowed');

class PagosDeClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('PagosDeClientes_model', 'mepcc');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vNavGeneral')
                    ->view('vMenuClientes')->view('vPagosDeClientes')
                    ->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
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
            if ($this->input->get('CLIENTE') !== '') {
                $this->db->where('CCP.cliente', $this->input->get('CLIENTE'));
            }
            if ($this->input->get('CLIENTE') === '' && $this->input->get('DOCUMENTO') === '') {
                $this->db->order_by("CCP.fecha", "DESC")->limit(99);
            } else {
                 $this->db->order_by("CCP.fecha", "DESC");
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->join('cartcliente AS CC', 'C.Clave = CC.cliente')
                                    ->where_in('C.Estatus', 'ACTIVO')
                                    ->where('CC.saldo > ', 2)
                                    ->order_by('ABS(C.Clave)', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosDelDocumentoConSaldo() {
        try {
            $x = $this->input->get();
            $documento = $this->db->query("SELECT  CC.importe AS IMPORTE, CC.pagos AS PAGOS, CC.Fecha AS FECHA, CC.saldo AS SALDO FROM cartcliente AS CC WHERE CC.remicion LIKE '{$x['DOCUMENTO']}'")->result();
            print json_encode($documento);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosConSaldoXClientes() {
        try {
            $x = $this->input->get();
            $this->db->select("CC.ID AS ID, CC.cliente AS CLIENTE, CC.remicion AS DOCUMENTO,
                CC.tipo AS TP, CC.fecha AS FECHA_DEPOSITO,  
                FORMAT(CC.importe,2) AS IMPORTE, FORMAT(CC.pagos,2) AS PAGOS, FORMAT(CC.saldo,2) AS SALDO, 
                CC.status AS ST, DATEDIFF(NOW(),fecha) AS DIAS, CC.saldo AS SALDOX", false)
                    ->from("cartcliente AS CC");
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CC.cliente', $x['CLIENTE']);
            }
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CC.remicion', $x['DOCUMENTO']);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CC.saldo > ', 2)->order_by("CC.fecha", "DESC")->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
