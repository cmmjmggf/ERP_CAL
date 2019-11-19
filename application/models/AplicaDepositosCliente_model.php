<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class AplicaDepositosCliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getBancos($tp) {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.Nombre) AS Banco", false)
                            ->from('bancos AS C')->where_in('C.Estatus', 'ACTIVO')->where('C.Tp', $tp)->order_by('Banco', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.RazonS) AS Cliente", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('Cliente', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
