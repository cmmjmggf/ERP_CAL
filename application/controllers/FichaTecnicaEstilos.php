<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class FichaTecnicaEstilos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City'); 
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vFichaTecnicaEstilos');  
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }
}