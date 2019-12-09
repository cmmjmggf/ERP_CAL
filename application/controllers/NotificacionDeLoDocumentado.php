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
            $query = "SELECT ID AS ID, C.cliente AS CLIENTE, "
                    . "C.subcte AS SUBCLIENTE, C.factura AS FACTURA, "
                    . "C.tp AS TP, C.guia AS GUIA, DATE_FORMAT(C.fecha,\"%d/%m/%Y\") AS FECHA, "
                    . "C.pares AS PARES, C.status AS ESTATUS, C.cajas AS CAJAS, "
                    . "C.importe AS IMPORTE, C.traspo AS TRANSPORTE, C.transp TRANSPORTE_TEXT "
                    . "FROM cartafac AS C ";
            if ($x["CLIENTE"] !== '') {
                $query .= "WHERE C.cliente = {$x["CLIENTE"]} ";
            }
            $query .= "ORDER BY C.fecha DESC";
            $data = $this->db->query($query)->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
