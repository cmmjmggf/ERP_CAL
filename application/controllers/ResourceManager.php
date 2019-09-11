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
     
    public function getAccesosDirectosXModulo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT AD.ID, AD.Modulo, AD.Nombre, 
                AD.Fecha, AD.Icon, AD.Ref, AD.`Order` FROM accesos_directos AS AD 
                INNER JOIN accesos_directos_x_usuario AS ADU ON AD.ID = ADU.Acceso_directo 
                WHERE AD.Modulo = {$x["MODULO"]} AND ADU.Usuario = {$x["USUARIO"]} ORDER BY AD.Order ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
