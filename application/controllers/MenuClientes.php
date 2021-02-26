<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MenuClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $Facturados = new Facturados();
        $l = new Logs("MENU CLIENTES", "INGRESO AL MENU DE CLIENTES", $this->session);
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFooter')->view('vWatermark', $dt);
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
