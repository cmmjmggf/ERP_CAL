<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoCambio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Tipocambio_model');
    }

    public function getTipoCambio() {
        try {
            print json_encode($this->Tipocambio_model->getTipoCambio());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $this->Tipocambio_model->onModificar(array(
                'Dolar' => ($x->post('Dolar') !== NULL) ? $x->post('Dolar') : 0,
                'Libra' => ($x->post('Libra') !== NULL) ? $x->post('Libra') : 0,
                'Euro' => ($x->post('Euro') !== NULL) ? $x->post('Euro') : 0,
                'Jen' => ($x->post('Jen') !== NULL) ? $x->post('Jen') : 0
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
