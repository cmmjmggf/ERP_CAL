<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class MovimientosCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AplicaDepositosCliente_model', 'adc');
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

            $this->load->view('vFondo')->view('vMovimientosCliente')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $cliente = $this->input->post('Cliente');
            print json_encode($this->db->query(" SELECT
                            CC.cliente,
                            CC.remicion,
                            date_format(CC.fecha,'%d/%m/%Y') as fechadoc,
                            CC.importe,
                            CC.pagos,
                            CC.saldo,
                            CC.tipo,
                            CC.status,
                            date_format(CP.fechacap,'%d/%m/%Y') as fechacap,
                            date_format(CP.fechadep,'%d/%m/%Y') as fechadep,
                            CP.importe as importeP,
                            CP.mov,
                            CP.pagada,
                            CP.doctopa,
                            datediff(CP.fecha,CC.fecha) as dias
                            FROM cartcliente CC
                            join cartctepagos CP on CC.remicion = CP.remicion
                            where CC.cliente = $cliente
                            ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->adc->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
