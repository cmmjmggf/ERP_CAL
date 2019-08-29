<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class FacturacionVarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')
                ->model('RastreoDeControlesEnDocumentos_model', 'rced');
    }

    public function index() {
        $indice = $this->input->get();
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
            $this->load->view('vFacturacionVarios')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
