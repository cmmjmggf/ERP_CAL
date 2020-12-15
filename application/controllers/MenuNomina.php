<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuNomina extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $l = new Logs("MENU NOMINAS", "INGRESO AL MENU DE NOMINAS", $this->session);
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuNominas');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
                case 'PRODUCCION':
                    /* INGENIERIA */
                    $this->load->view('vNavGeneral')->view('vMenuNominas');
                    break;
            }
            $this->load->view('vFooter')->view('vWatermark', $dt);
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

}
