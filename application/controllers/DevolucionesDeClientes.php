<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DevolucionesDeClientes extends CI_Controller {

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
                case 'CLIENTES':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getPedidos() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID, F.contped AS CONTROL, F.factura AS DOCUMENTO, F.tp AS TP, DATE_FORMAT(F.fecha,\"%d/%m/%Y\") AS FECHA, F.pareped AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, F.precto AS PRECIO, F.staped AS ST", false)
                    ->from("facturacion AS F");
            if ($x["CLIENTE"] !== '') {
                $this->db->where('F.cliente', $x["CLIENTE"]);
            }
            if ($x["CLIENTE"] === '') {
                $this->db->order_by("F.fecha", "DESC")->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
            print json_encode($this->db->query("SELECT P.Cliente AS CLIENTE "
                                    . "FROM pedidox AS P WHERE P.Control LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->db->query("SELECT P.*,P.Clave AS CLAVE_PEDIDO, CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
                                    . "S.T21, S.T22, P.EstatusProduccion AS ESTATUS, P.stsavan AS AVANCE_ESTATUS, P.EstiloT AS ESTILO_TEXT "
                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
                                    . "WHERE P.Control LIKE '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesFacturadosXControl() {
        try {
            print json_encode($this->db->query("SELECT F.factura, F.tp, F.cliente, F.contped, F.fecha, F.hora, F.corrida, F.pareped, F.estilo, F.combin, F.par01, F.par02, F.par03, F.par04, F.par05, F.par06, F.par07, F.par08, F.par09, F.par10, F.par11, F.par12, F.par13, F.par14, F.par15, F.par16, F.par17, F.par18, F.par19, F.par20, F.par21, F.par22, F.precto, F.subtot, F.iva, F.staped, F.monletra, F.tmnda, F.tcamb, F.cajas, F.origen, F.referen, F.decdias, F.agente, F.colsuel, F.tpofac, F.año, F.zona, F.horas, F.numero, F.talla, F.cobarr, F.pedime, F.ordcom, F.numadu, F.nomadu, F.regadu, F.periodo, F.costo, F.obs "
                                    . "FROM facturacion AS F WHERE F.contped = '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
