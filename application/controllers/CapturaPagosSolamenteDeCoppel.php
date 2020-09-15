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
            $this->onRedondeaYActualizaSaldos();
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFacturacion');
                    break;
            }
            $this->load->view('vFondo')->view('vCapturaPagosSolamenteDeCoppel')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onRedondeaYActualizaSaldos() {
        try {
            $this->db->query(" update cartcliente set saldo = 0, status = 3 where saldo <= 1 and saldo >= 0 and status <> 4 ");
            $this->db->query(" update cartcliente set saldo = 0, status = 3 where saldo <= 0 and saldo >= -1 and status <> 4 ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
            if ($x['DOCUMENTO'] === '') {
                $this->db->limit(99);
            }
            $this->db->order_by('CC.ID', 'DESC');
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
            print json_encode($this->db->query("SELECT CC.ID, CC.cliente, CC.remicion, date_format(CC.fecha,'%d/%m/%Y') AS fecha, CC.importe, CC.tipo, CC.numpol, CC.numcia, CC.status, CC.pagos, CC.saldo, CC.comiesp, CC.tcamb, CC.tmnda, CC.stscont, CC.nc, CC.factura FROM cartcliente AS CC WHERE cliente = 2121 AND status < 2 AND remicion = {$this->input->get("FACTURA")}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUUID() {
        try {
            $x = $this->input->get();
//            print json_encode($this->db->query("SELECT CFDI.uuid AS UUID FROM cfdifa AS CFDI WHERE CFDI.Factura = '{$x['DOCUMENTO']}'")->result());
            print json_encode($this->db->query("SELECT CFDI.UUID AS UUID FROM comprobantes AS CFDI WHERE CFDI.Folio = '{$x['DOCUMENTO']}' AND CFDI.Tipo = 'I'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturaXNumero() {
        try {
//            print json_encode($this->db->query("SELECT * FROM cfdifa AS F WHERE F.Factura LIKE '{$this->input->get('FACTURA')}' AND F.numero = {$this->input->get('TP')}")->result());
            print json_encode($this->db->query("SELECT CFDI.* AS UUID FROM comprobantes AS CFDI WHERE CFDI.Folio = '{$this->input->get('FACTURA')}' AND CFDI.Tipo = 'I'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaNC() {
        try {
            $ANIO = Date('Y');
            print json_encode($this->db->query("SELECT (max(nc)+1) AS NCM FROM notcred AS N WHERE YEAR(N.fecha) = {$ANIO} AND  N.tp = 1 ORDER BY N.nc DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentoInfo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT D.docto AS DOCTO, D.banco AS BANCO, D.cuenta AS CUENTA, D.importe AS IMPORTE, D.pagos AS PAGOS, (CASE WHEN (D.importe - D.pagos) < 1 THEN 0 ELSE (D.importe - D.pagos) END) AS SALDO, date_format(D.fecha,'%d/%m/%Y') AS FECHA FROM depoctes AS D WHERE D.status < 3 AND D.docto = {$x['DOCTO']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarPagoDosTresTotal() {
        try {
            $x = $this->input->post();
            /* DOS PORCIENTO */

            $fecha = $x['FECHA_DEPOSITO'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion' => $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IMPORTE_DOS'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "Dc2% {$x['FOLIO_NC']}",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => "$anio-$mes-$dia 00:00:00",
                'pagada' => 0,
                'fechacap' => "$anio-$mes-$dia 00:00:00",
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID'],
                'docto' => $x['DOCUMENTO_BANCO']
            ));
            /* TRES PORCIENTO */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion' => $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IMPORTE_TRES'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "Dc3% {$x['FOLIO_NC']}",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => "$anio-$mes-$dia 00:00:00",
                'pagada' => 0,
                'fechacap' => "$anio-$mes-$dia 00:00:00",
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID'],
                'docto' => $x['DOCUMENTO_BANCO']
            ));
            /* IVA DEL 2 Y 3 PORCIENTO */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion' => $x['DOCUMENTO'],
                'fecha' => Date('Y-m-d'),
                'importe' => $x['IVADOSTRES'],
                'tipo' => $x['TP'],
                'gcom' => 0,
                'agente' => 1/* DIRECTO */,
                'mov' => 5,
                'doctopa' => "IVA  N-C {$x['FOLIO_NC']}",
                'numpol' => 0,
                'numfol' => 0/* DIAS */,
                'status' => 1,
                'posfe' => 0,
                'fechadep' => "$anio-$mes-$dia 00:00:00",
                'pagada' => 0,
                'fechacap' => "$anio-$mes-$dia 00:00:00",
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID'],
                'docto' => $x['DOCUMENTO_BANCO']
            ));
            /* RESTANTE */
            $this->db->insert('cartctepagos', array(
                'cliente' => 2121,
                'remicion' => $x['DOCUMENTO'],
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
                'fechadep' => "$anio-$mes-$dia 00:00:00",
                'pagada' => 0,
                'fechacap' => "$anio-$mes-$dia 00:00:00",
                'nc' => $x['FOLIO_NC'],
                'control' => $x['BANCO']/* BANCO */,
                'stscont' => 0,
                'regdev' => 0,
                'uuid' => $x['UUID'],
                'docto' => $x['DOCUMENTO_BANCO']
            ));
            /* AÑADIR LAS NOTAS DE CREDITO POR EL DOS PORCIENTO Y EL TRES PORCIENTO */
            /* NOTA DEL DOS PORCIENTO */
            $this->db->insert('notcred', array(
                'nc' => $x['FOLIO_NC'],
                'cliente' => 2121,
                'numfac' => $x['DOCUMENTO'],
                'tp' => $x['TP'],
                'orden' => 5,
                'fecha' => "$anio-$mes-$dia 00:00:00",
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
                'numfac' => $x['DOCUMENTO'],
                'tp' => $x['TP'],
                'orden' => 5,
                'fecha' => "$anio-$mes-$dia 00:00:00",
                'hora' => Date('h:i:s a'),
                'cant' => 1,
                'descripcion' => "Desc.3% Nc-{$x['FOLIO_NC']}",
                'precio' => $x['IMPORTE_TRES'],
                'subtot' => $x['IMPORTE_TRES'],
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
                        . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'");
            }
            if (floatval($x['SALDO']) == floatval($x['DEPOSITO_REAL'])) {
                $this->db->query("UPDATE depoctes SET status = 3, pagos = ifnull(pagos,0) + ifnull({$x['DEPOSITO_REAL']},0) "
                        . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'");
            }
            if (floatval($x['SALDO']) < floatval($x['DEPOSITO_REAL'])) {
                $this->db->query("UPDATE depoctes SET status = 2, pagos = ifnull(pagos,0) + ifnull({$x['DEPOSITO_REAL']},0) "
                        . "WHERE docto LIKE '{$x['DOCUMENTO_BANCO']}' AND banco LIKE  '{$x['BANCO']}'");
            }
            /* SALDAR IMPORTES MENORES A 2 PESOS */
            $this->db->set('status', 3)->where('status <', 3)->where('(importe - pagos) < 2', null, false)->update('depoctes');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
