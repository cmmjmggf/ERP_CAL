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
            $this->load->view('vEncabezado')->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vPagosDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
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

    public function getPagosXDocumentos() {
        try {
            $x = $this->input->get();
            $this->db->select("CCP.ID AS ID, CCP.cliente AS CLIENTE, CCP.remicion AS DOCUMENTO,
                CCP.tipo AS TP, DATE_FORMAT(CCP.fecha,\"%d/%m/%Y\") AS FECHA_DEPOSITO,
                 DATE_FORMAT(CCP.fechacap,\"%d/%m/%Y\") AS FECHA_CAPTURA,
                FORMAT(CCP.importe,2) AS IMPORTE, CCP.mov AS MV, CCP.doctopa AS REFERENCIA,
                CCP.numfol AS DIAS ", false)->from("cartctepagos AS CCP");
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CCP.remicion', $x['DOCUMENTO']);
            }
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CCP.cliente', $x['CLIENTE']);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
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
            print json_encode($this->db->select("C.Clave AS Clave, CONCAT(C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->join('cartcliente AS CC', 'C.Clave = CC.cliente')
                                    ->where_in('C.Estatus', 'ACTIVO')
                                    ->where('CC.saldo > ', 2)
                                    ->order_by('Cliente', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDescuentoXCliente() {
        try {
            print json_encode($this->db->query("SELECT (C.Descuento*100) AS DESCUENTO FROM clientes AS C WHERE C.Clave = {$this->input->get('CLIENTE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosDelDocumentoConSaldo() {
        try {
            $x = $this->input->get();
            $documento = $this->db->query("SELECT CC.cliente AS CLIENTE, CC.importe AS IMPORTE, CC.pagos AS PAGOS, CC.Fecha AS FECHA, CC.saldo AS SALDO,CC.tipo AS TIPO, DATEDIFF(NOW(),fecha) AS DIAS FROM cartcliente AS CC WHERE CC.remicion LIKE '{$x['DOCUMENTO']}'")->result();
            print json_encode($documento);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosConSaldoXClientes() {
        try {
            $x = $this->input->get();
            $this->db->select("CC.ID AS ID, CC.cliente AS CLIENTE, CC.remicion AS DOCUMENTO,
                CC.tipo AS TP, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA_DEPOSITO,
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
            $FECHA_FINAL = date("Y-m-d", strtotime(str_replace('/', '-', $x['FECHA'])));

            switch (intval($x["TP"])) {
                case 1:
                    /* FACTURA */
                    $TOTAL_FINAL_CON_IVA = $x['IMPORTE'] * 1.16;
                    $this->db->insert("cartctepagos", array(
                        "cliente" => $x['CLIENTE'],
                        "remicion" => $x['NUMERO_RF']/* FACTURA */,
                        "fecha" => $FECHA_FINAL,
                        "importe" => $TOTAL_FINAL_CON_IVA,
                        "tipo" => $x['TIPO'],
                        "gcom" => 0,
                        "agente" => $x['AGENTE'],
                        "mov" => $x['MOVIMIENTO']/* MovUno, MovDos... */,
                        "doctopa" => $x['REF'],
                        "numpol" => 0,
                        "numfol" => 0,
                        "status" => 1,
                        "posfe" => intval($x['MOVIMIENTO']) === 3 ? 1 : 0,
                        "regdev" => intval($x['MOVIMIENTO']) === 2 ? "1" . substr(Date('Y'), 1, 2) . "" . Date('Ymds') : 0,
                        "uuid" => intval($x["TP"]) === 1 ? $x['UUID'] : 0,
                        "fechadep" => $FECHA_FINAL,
                        "fechacap" => $FECHA_FINAL,
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
                        "fecha" => $FECHA_FINAL,
                        "importe" => $x['IMPORTE'],
                        "tipo" => $x['TIPO'],
                        "gcom" => 0,
                        "agente" => $x['AGENTE'],
                        "mov" => $x['MOVIMIENTO']/* MovUno, MovDos... */,
                        "doctopa" => $x['REF'],
                        "numpol" => 0,
                        "numfol" => 0,
                        "status" => 1,
                        "posfe" => intval($x['MOVIMIENTO']) === 3 ? 1 : 0,
                        "regdev" => intval($x['MOVIMIENTO']) === 2 ? "2" . substr(Date('Y'), 1, 2) . "" . Date('Ymds') : 0,
                        "uuid" => intval($x['MOVIMIENTO']) === 1 ? $x['UUID'] : 0,
                        "fechadep" => $FECHA_FINAL,
                        "fechacap" => $FECHA_FINAL,
                        "nc" => 0,
                        "control" => $x['CLAVE_BANCO'],
                        "stscont" => 0,
                        "pagada" => 0
                    ));
                    break;
            }
            if (intval($x['MOVIMIENTO']) === 3) {
                $this->db->insert('chequeposf', array('cliente' => $x['CLIENTE'],
                    'remicion' => $x['NUMERO'], 'fecha' => $FECHA_FINAL,
                    "fechadep" => $FECHA_FINAL, 'importe' => $x['IMPORTE'],
                    'tipo' => 1, 'status' => 1, 'doctopa' => $x['DOCUMENTO']));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancos() {
        try {
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT B.Clave AS CLAVE, CONCAT(B.Clave,' ',B.Nombre) AS BANCO FROM bancos AS B where B.Tp = $Tp ORDER BY ABS(B.Clave) ASC")->result());
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

    public function getAgenteXCliente() {
        try {
            print json_encode($this->db->query(
                                    "SELECT C.agente AS AGENTE "
                                    . "FROM clientes AS C WHERE C.Clave = {$this->input->get('CLIENTE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificaSaldoXDocumento() {
        try {
            $x = $this->input->post();
            $this->db->set('saldo', $x['NUEVO_SALDO'])
                    ->set('pagos', $x['NUEVO_PAGADO'])
                    ->where('cliente', $x['CLIENTE'])
                    ->where('remicion', $x['REMISION'])
                    ->update('cartcliente');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
