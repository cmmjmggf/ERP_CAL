<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadisticasFacturacion extends CI_Controller {

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
            }
            $this->load->view('vFondo')->view('vEstadisticasFacturacion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEstadistica() {
        try {
            $anio = $this->input->get();
            if (intval($anio['ANIO']) > 0 && intval($anio['ANIO']) < 2005) {
                $anio['ANIO'] = Date('Y');
            }
            $sql = '
                SELECT (CASE WHEN F.tp = 1 THEN "FACTURA" WHEN F.tp = 2 THEN "REMISIÓN" END) AS TIPO, F.factura AS FACTURA,
                (SELECT C.RazonS FROM clientes AS C WHERE C.Clave = F.cliente LIMIT 1) AS CLIENTE, 
                DATE_FORMAT(F.fecha,"%d/%m/%Y") AS FECHA, 
                SUM(CASE WHEN f.tmnda = 2 THEN f.subtot * f.tcamb ELSE f.subtot END) AS SUBTOTAL,
                SUM(F.pareped) AS PARES,  YEAR(F.fecha) AS "AÑO", 
                SUM(F.iva) AS IVA, 
                (SUM(F.subtot) + SUM(F.iva)) AS TOTAL 
                FROM facturacion AS F 
                WHERE YEAR(F.fecha) = ' . $anio['ANIO'] . ' AND F.staped = 2 
                GROUP BY F.cliente, F.factura  
                ORDER BY ABS(CLIENTE) ASC, F.fecha ASC ';
            print json_encode($this->db->query($sql)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
