<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');        
        $Facturados = new Facturados();
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    /* INGENIERIA */
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vProduccion')->view('vFooter')->view('vWatermark', $dt);
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
