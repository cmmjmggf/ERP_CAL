<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuParametros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $l = new Logs("MENU PARÁMETROS", "INGRESO AL MENU DE PARÁMETROS", $this->session);
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
            }
            $this->load->view('vParametros')->view('vFooter')->view('vWatermark', $dt);
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
