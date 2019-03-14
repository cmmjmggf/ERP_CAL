<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Tipocambio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTipoCambio() {
        try {
            return $this->db->select("T.*")->from("tipocambio AS T")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($DATA) {
        try {
            $this->db->update("tipocambio", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
