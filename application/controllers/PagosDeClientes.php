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
            $documento = $this->db->query("SELECT  CC.importe AS IMPORTE, CC.pagos AS PAGOS, CC.Fecha AS FECHA, CC.saldo AS SALDO,CC.tipo AS TIPO, DATEDIFF(NOW(),fecha) AS DIAS FROM cartcliente AS CC WHERE CC.remicion LIKE '{$x['DOCUMENTO']}'")->result();
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
                $this->db->where('CC.cliente', $x['CLIENTE'])->where('CC.saldo > ', 2);
            }
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CC.remicion', $x['DOCUMENTO'])->where('CC.saldo > ', 2);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CC.saldo > ', 2)->order_by("CC.fecha", "DESC")->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUUID() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT CFDI.uuid AS UUID FROM cfdifa AS CFDI WHERE CFDI.Factura = '{$x['DOCUMENTO']}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagoCliente() {
        try {
            $x = $this->input->post();
            switch (intval($x["TP"])) {
                case 1:
                    /* FACTURA */
                    $TOTAL_FINAL_CON_IVA = $x['IMPORTE'] * 1.16;
                    $this->db->insert("cartctepagos", array(
                        "cliente" => $x['CLIENTE'],
                        "remicion" => $x['NUMERO_RF']/* FACTURA */,
                        "fecha" => $x['FECHA'],
                        "importe" => $TOTAL_FINAL_CON_IVA,
                        "tipo" => $x['TIPO'],
                        "gcom" => 0,
                        "agente" => $x['CLIENTE'],
                        "mov" => $x['MOVIMIENTO']/* MovUno, MovDos... */,
                        "doctopa" => $x['REF'],
                        "numpol" => 0,
                        "numfol" => 0,
                        "status" => 1,
                        "posfe" => intval($x['MOVIMIENTO']) === 3 ? 1 : 0,
                        "regdev" => intval($x['MOVIMIENTO']) === 2 ? "1" . substr(Date('Y'), 1, 2) . "" . Date('Ymds') : 0,
                        "uuid" => intval($x['MOVIMIENTO']) === 1 ? $x['UUID'] : 0,
                        "fechadep" => $x['FECHA'],
                        "nc" => 0,
                        "control" => $x['CLAVE_BANCO'],
                        "stscont" => 0,
                        "pagada" => 0
                    ));
                    break;
                case 2:
                    /* REMISIÓN */
                    $this->db->insert("cartctepagos", array(
                        "cliente" => $x['CLIENTE'],
                        "remicion" => $x['NUMERO_RF']/* REMISION */,
                        "fecha" => $x['FECHA'],
                        "importe" => $x['IMPORTE'],
                        "tipo" => $x['TIPO'],
                        "gcom" => 0,
                        "agente" => $x['CLIENTE'],
                        "mov" => $x['MOVIMIENTO']/* MovUno, MovDos... */,
                        "doctopa" => $x['REF'],
                        "numpol" => 0,
                        "numfol" => 0,
                        "status" => 1,
                        "posfe" => intval($x['MOVIMIENTO']) === 3 ? 1 : 0,
                        "regdev" => intval($x['MOVIMIENTO']) === 2 ? "2" . substr(Date('Y'), 1, 2) . "" . Date('Ymds') : 0,
                        "uuid" => intval($x['MOVIMIENTO']) === 1 ? $x['UUID'] : 0,
                        "fechadep" => $x['FECHA'],
                        "nc" => 0,
                        "control" => $x['CLAVE_BANCO'],
                        "stscont" => 0,
                        "pagada" => 0
                    ));
                    break;
            }
            if (intval($x['MOVIMIENTO']) === 3) {
                $this->db->insert('chequeposf', array('cliente' => $x['CLIENTE'],
                    'remicion' => $x['NUMERO'], 'fecha' => $x['FECHA'],
                    "fechadep" => $x['FECHA'], 'importe' => $x['IMPORTE'],
                    'tipo' => 1, 'status' => 1, 'doctopa' => $x['DOCUMENTO']));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancos() {
        try {
            print json_encode($this->db->query("SELECT B.Clave AS CLAVE, CONCAT(B.Clave,' ',B.Nombre) AS BANCO FROM bancos AS B ORDER BY ABS(B.Clave) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCtaCheques() {
        try {
            print json_encode($this->db->query("SELECT B.CtaCheques AS CTACHEQUE FROM bancos AS B WHERE B.Clave = {$this->input->get('CLAVE_BANCO')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
