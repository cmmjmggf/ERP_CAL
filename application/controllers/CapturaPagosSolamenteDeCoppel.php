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
                CC.tipo AS TP, date_format(CC.fecha,'%d/%m/%Y')  AS FECHA_DEPOSITO,  
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
                CCP.tipo AS TP, date_format(CCP.fecha,'%d/%m/%Y')  AS FECHA_DEPOSITO, CCP.fechacap AS FECHA_CAPTURA, 
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

    public function getUUID() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT CFDI.uuid AS UUID FROM cfdifa AS CFDI WHERE CFDI.Factura = '{$x['DOCUMENTO']}'")->result());
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

    public function getUltimaNC() {
        try {
            print json_encode($this->db->query("SELECT (max(nc)+1) AS NCM FROM notcred AS N WHERE N.nc < 10000 AND   N.tp = 1 ORDER BY N.nc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarPagoDosTresTotal() {
        try {
            $x = $this->input->post();
            /* DOS PORCIENTO */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion', $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IMPORTE_DOS'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "Dc2%",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => $x['FECHA_DEPOSITO'],
                'pagada' => 0,
                'fechacap' => $x['FECHA_DEPOSITO'],
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID']
            ));
            /* TRES PORCIENTO */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion', $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IMPORTE_TRES'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "Dc3%",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => $x['FECHA_DEPOSITO'],
                'pagada' => 0,
                'fechacap' => $x['FECHA_DEPOSITO'],
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID']
            ));
            /* IVA DEL 2 Y 3 PORCIENTO */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion', $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IVADOSTRES'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "IVA  N-C {$x['DOCUMENTO']}",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => $x['FECHA_DEPOSITO'],
                'pagada' => 0,
                'fechacap' => $x['FECHA_DEPOSITO'],
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID']
            ));
            /* RESTANTE */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion', $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['DEPOSITO_REAL'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 1,
                'doctopa' => "DpBMX",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => $x['FECHA_DEPOSITO'],
                'pagada' => 0,
                'fechacap' => $x['FECHA_DEPOSITO'],
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID']
            ));
            /* AÑADIR LAS NOTAS DE CREDITO POR EL DOS PORCIENTO Y EL TRES PORCIENTO */
            /* NOTA DEL DOS PORCIENTO */
            $this->db->insert('notcred', array(
                'nc' => $x['FOLIO_NC'],
                'cliente' => 2121,
                'numfac', $x['DOCUMENTO'],
                'tp' => $x['TP'],
                'orden' => 5,
                'tipo' => $x['TP'],
                'fecha' => 0,
                'hora' => Date('h:i:s a'),
                'cant' => 1,
                'descripcion' => "Desc.2% Nc-{$x['FOLIO_NC']}",
                'precio' => $x['IMPORTE_DOS'],
                'subtot' => $x['IMPORTE_DOS'],
                'concepto' => 0,
                'defecto' => 0,
                'detalle' => 0,
                'status' => intval($x['TP']) === 1 ? 1 : 2
            ));
            /* NOTA DEL TRES PORCIENTO */
            $this->db->insert('notcred', array(
                'nc' => $x['FOLIO_NC'],
                'cliente' => 2121,
                'numfac', $x['DOCUMENTO'],
                'tp' => $x['TP'],
                'orden' => 5,
                'fecha' => 0,
                'hora' => Date('h:i:s a'),
                'cant' => 1,
                'descripcion' => "Desc.3% Nc-{$x['FOLIO_NC']}",
                'precio' => $x['IMPORTE_DOS'],
                'subtot' => $x['IMPORTE_DOS'],
                'concepto' => 0,
                'defecto' => 0,
                'detalle' => 0,
                'status' => intval($x['TP']) === 1 ? 1 : 2
            ));
            /* SALDAR FACTURA */
            $IMPORTE_COMPLETO = 0;
            $IMPORTE_COMPLETO_CALCULADO = 0;
            $IMPORTE_COMPLETO_CALCULADO += floatval($x['IMPORTE_DOS']) +
                    floatval($x['IMPORTE_TRES']) + floatval($x['DEPOSITO_REAL']) +
                    floatval($x['IVADOSTRES']);
            $IMPORTE_COMPLETO = floatval($x['SALDO']) - $IMPORTE_COMPLETO_CALCULADO;
            if ($IMPORTE_COMPLETO <= 0.5) {
                $this->db->set('pagos', $IMPORTE_COMPLETO_CALCULADO)
                        ->set('saldo', 0)->set('status', 3)
                        ->where('cliente', 2121)->where('remicion', $x['DOCUMENTO'])
                        ->update('cartcliente');
            } else {
                $this->db->set('pagos', $IMPORTE_COMPLETO_CALCULADO)
                        ->set('saldo', 0)->set('status', 2)
                        ->where('cliente', 2121)->where('remicion', $x['DOCUMENTO'])
                        ->update('cartcliente');
            }

            /* ACTUALIZAR ESTATUS NOTA DE CREDITO (LETRA) */
            $this->db->set('status', 2)->set("monletra", $x['MONTO_LETRA'])->set("hora", Date('h:i:s a'))
                    ->where('nc', $x['FOLIO_NC'])->where('status', 1)->where('numfac', $x['DOCUMENTO'])
                    ->update('notcred');

            /* VALIDAR LOS DEPOSITOS */
            if (floatval($x['SALDO']) > floatval($x['DEPOSITO_REAL'])) {
                $this->db->query("UPDATE depoctes SET status = 2, pagos = ifnull(pagos,0) + ifnull({$x['DEPOSITO_REAL']},0) "
                                . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'")
                        ->result();
            }
            if (floatval($x['SALDO']) == floatval($x['DEPOSITO_REAL'])) {
                $this->db->query("UPDATE depoctes SET status = 3, pagos = ifnull(pagos,0) + ifnull({$x['DEPOSITO_REAL']},0) "
                                . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'")
                        ->result();
            }
            if (floatval($x['SALDO']) < floatval($x['DEPOSITO_REAL'])) { 
                $this->db->query("UPDATE depoctes SET status = 2, pagos = ifnull(pagos,0) + ifnull({$x['DEPOSITO_REAL']},0) "
                                . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'")
                        ->result();
            }
            /* SALDAR IMPORTES MENORES A 2 PESOS */
            $this->db->set('status', 3)->where('status <', 3)->where('(importe - pagos) < 2', null, false)->update('depoctes');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
