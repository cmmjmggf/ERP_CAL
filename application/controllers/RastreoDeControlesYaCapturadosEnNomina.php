<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RastreoDeControlesYaCapturadosEnNomina extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RastreoDeControlesYaCapturadosEnNomina_model', 'rdc')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vRastreoDeControlesYaCapturadosEnNomina')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->rdc->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
