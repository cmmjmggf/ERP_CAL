<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraPoliza extends CI_Controller {

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
                    $this->load->view('vNavGeneral');

                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }

                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuClientes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PROVEEDORES':
                    $this->load->view('vMenuProveedores');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vGeneraPoliza');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

}
