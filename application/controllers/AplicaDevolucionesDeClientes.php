<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class AplicaDevolucionesDeClientes extends CI_Controller {

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
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vAplicaDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDocumentadosDeEsteClienteConSaldo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT CC.ID AS ID, CC.tipo AS TP, CC.remicion AS DOCUMENTO, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA, CC.importe AS IMPORTE, CC.pagos AS PAGOS, CC.saldo AS SALDO, CC.stscont AS ST  "
                                    . "FROM cartcliente AS CC "
                                    . "WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN CC.cliente = '{$x['CLIENTE']}' ELSE CC.cliente LIKE '%%' END) "
                                    . "AND CC.saldo > 1 ORDER BY CC.fecha DESC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

//CONTROLES POR APLICAR DE ESTE CLIENTE
    public function getControlesPorAplicarDeEsteCliente() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT D.ID, D.cliente AS CLIENTE, 
                D.docto AS DOCUMENTO, D.control AS CONTROL, D.paredev AS PARES, 
                D.defecto AS DEFECTOS, D.detalle AS DETALLE, D.clasif AS CLASIFICACION,  
                D.cargoa AS CARGO, D.maq AS MAQUILA,  DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, D.conce AS CONCEPTO, 
                D.preciodev AS PREDV, D.preciomaq AS PRECG 
                FROM devolucionnp AS D 
                WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN D.cliente = '{$x['CLIENTE']}' ELSE D.cliente LIKE '%%' END) "
                                    . "AND D.staapl < 2  ORDER BY D.fecha DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleDevolucion() {

        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT 
                D.ID AS ID, D.cliente AS CLIENTE, D.docto AS DOCUMENTO, 
                D.aplica AS APLICA, D.nc AS NC, D.control AS CONTROL, D.paredev AS PARES, 
                D.defecto AS DEFECTOS, D.detalle AS DETALLES, D.clasif AS CLASIFICACION, D.cargoa AS CARGO, 
                DATE_FORMAT(D.fecha,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, D.conce AS CONCEPTO 
                FROM devctes AS D 
                WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN D.cliente = '{$x['CLIENTE']}' ELSE D.cliente LIKE '%%' END) "
                                    . "ORDER BY D.fecha DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->post();
            $this->db->query("SELECT D.Control AS CONTROL FROM devolucionnp AS D ")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFacturaXCliente() {
        try {
            $x = $this->input->get();
            $this->db->select("", false)->from("cartcliente AS C")
                    ->where('C.cliente', $x["CLIENTE"])
                    ->where('C.remicion', $x["DOCUMENTO"]);
            if ($x['TP'] !== '') {
                $this->db->where('C.tipo', $x["TP"]);
            }
            print json_encode($this->db->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
