<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DiaFestivo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('DiaFestivo_model', 'dfm');
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->dfm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAnadirDiaFestivo() {
        try {
            var_dump($this->input->post());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            return json_encode($this->db->select("PM.status as 'status' "
                                    . "FROM prenomina PM "
                                    . "WHERE PM.numsem = {$this->input->post('SEMANA')} "
                                    . "AND PM.año = {$this->input->post('SEMANA')}")
                            ->group_by('PM.numsem')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
