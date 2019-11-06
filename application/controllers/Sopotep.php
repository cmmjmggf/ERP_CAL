<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sopotep extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('Fichatecnica_model', 'ftm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vFondo');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
            }
            $this->load->view('vSopotep');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

}
