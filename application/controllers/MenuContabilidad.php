<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MenuContabilidad extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vFondo');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
            }

            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

}
