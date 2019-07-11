<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class DocumentosDirectosClientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
