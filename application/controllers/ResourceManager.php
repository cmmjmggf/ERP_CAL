<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ResourceManager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ResourceManager_model','rsm');
    }

    public function getModulos() {
        try {
            print json_encode($this->rsm->getModulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getOpcionesXModulo() {
        try {
            print json_encode($this->rsm->getOpcionesXModulo($this->input->post('MOD')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
     
}
