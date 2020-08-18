<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuFichasTecnicas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuFichasTecnicas');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    /* INGENIERIA */
                    $this->load->view('vNavGeneral')->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    /* INGENIERIA */
                    $this->load->view('vNavGeneral')->view('vMenuFichasTecnicas');
                    break;
                case 'RECURSOS HUMANOS':
                    /* RECURSOS HUMANOS */
                    $this->load->view('vNavGeneral')->view('vMenuFichasTecnicas');
                    break;
            }
            $this->load->view('vFooter')->view('vWatermark', $dt);
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
