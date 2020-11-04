<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CodigosXCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Bancos_model');
    } 
    
    public function getClientes() {
        try {
            print json_encode($this->db->query("SELECT C.Clave,concat(C.Clave,\" \",C.RazonS) AS Descripcion FROM clientes AS C WHERE C.Clave IN(39,531,854,995,1234,1640,2121,2332,2564,2566,2567,2568) ORDER BY ABS(C.Clave) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getEstilos() {
        try {
            print json_encode($this->db->query("SELECT E.Clave, CONCAT(E.Clave,\" \",E.Descripcion) AS Descripcion FROM estilos AS E  ORDER BY ABS(E.Clave) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getFotoXEstilo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT E.Foto AS FOTO FROM estilos AS E  WHERE E.Clave = '{$x['ESTILO']}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getColoresXEstilo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT C.Clave, CONCAT(C.Clave,\" \",C.Descripcion) AS Descripcion FROM colores AS C WHERE C.Estilo = '".$x['ESTILO']."'  ORDER BY ABS(C.Clave) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
 
}
