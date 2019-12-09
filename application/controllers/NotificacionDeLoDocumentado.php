<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificacionDeLoDocumentado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        
    }

    public function getCartaFacs() {
        try {
            $x = $this->input->get();
            $this->db->select("ID AS ID, C.cliente AS CLIENTE, C.subcte AS SUBCLIENTE, "
                            . "C.factura AS FACTURA,  C.tp AS TP, C.guia AS GUIA, DATE_FORMAT(C.fecha,\"%d/%m/%Y\") AS FECHA, "
                            . "C.pares AS PARES, C.status AS ESTATUS, C.cajas AS CAJAS, "
                            . "CONCAT(\"$\",FORMAT(C.importe,2)) AS IMPORTE, C.traspo AS TRANSPORTE, C.transp TRANSPORTE_TEXT", false)
                    ->from("cartafac AS C");
            if ($x["CLIENTE"] !== '') {
                $this->db->where("C.cliente", $x['CLIENTE']);
            }
            if ($x["DOCUMENTO"] !== '') {
                $this->db->where("C.factura", $x['DOCUMENTO']);
            }
            if ($x["TP"] !== '') {
                $this->db->where("C.tp", $x['TP']);
            }
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onNotificar() {
        try {
            $x = $this->input->post();
//            var_dump($x);
//            exit(0);
            $pares = 0;
            $cajas = 0;
            $subtotal = 0;
            $fecha = "";
            $facturacion = $this->db->query("SELECT * FROM facturacion AS F WHERE F.factura='{$x['DOCUMENTO']}' AND cliente='{$x['CLIENTE']}' AND tp={$x['TP']}")->result();
            foreach ($facturacion as $k => $v) {
                $pares = intval($v->pareped);
                $cajas = intval($v->cajas);
                $subtotal += $v->subtot;
                $fecha = $v->fecha;
            }
            $this->db->set('cajas', $x['CAJAS'])->where('factura', $x['DOCUMENTO'])
                    ->where('cliente', $x['CLIENTE'])->where('tp', $x['TP'])
                    ->update('facturacion');
            $cartafac = $this->db->query("SELECT * FROM cartafac AS C WHERE C.cliente = {$x['CLIENTE']} AND C.factura = '{$x['DOCUMENTO']}' AND C.tp = {$x['TP']}")->result();
            if (count($cartafac) > 0) {
                $this->db->set('guia', $x['TALON'])->set('status', 1)
                        ->set('cajas', $x['CAJAS'])->set('traspo', $x['TRANSPORTE_CLAVE'])
                        ->set('transp', $x['TRANSPORTE'])
                        ->where('cliente', $x['CLIENTE'])->where('factura', $x['DOCUMENTO'])
                        ->where('tp', $x['TP'])
                        ->update('cartafac');
            } else {
                $this->db->insert("cartafac", array(
                    "cliente" => $x['CLIENTE'], "subcte" => 0,
                    "factura" => $x['DOCUMENTO'], "tp" => $x['TP'],
                    "guia" => $x['TALON'], "fecha" => $fecha,
                    "pares" => $pares, "status" => 1,
                    "cajas" => $cajas, "importe" => $subtotal,
                    "traspo" => $x['TRANSPORTE_CLAVE'], "transp" => $x['TRANSPORTE']
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
