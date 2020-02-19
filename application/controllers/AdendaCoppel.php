<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AdendaCoppel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onComprobarFactura() {
        try {
            $x = $this->input->get();
            $EXISTE_FACTURA = $this->db->query("SELECT COUNT(*) AS EXISTE FROM facturas AS F WHERE F.numero ={$x['TIENDA']}  and factura = '{$x['FACTURA']}'")->result();
            $factura = $this->db->query("SELECT * FROM facturacion AS F WHERE F.factura = {$x['FACTURA']} AND F.tp = 1")->result();
            $pedidox = $this->db->query("SELECT * FROM pedidox AS p WHERE p.factura = {$x['FACTURA']}")->result();

            print json_encode(array("FACTURA_EXISTE" => $EXISTE_FACTURA[0]->EXISTE,
                "FACTURA" => $factura,
                "PEDIDO" => $pedidox));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosFactura() {
        try {
            $x = $this->input->get();
            $factura = $this->db->query("SELECT F.*, DATE_FORMAT(F.fecha,'%d/%m/%Y') AS _FECHA_ FROM facturacion AS F WHERE F.factura = {$x['FACTURA']}")->result();
            print json_encode($factura);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
