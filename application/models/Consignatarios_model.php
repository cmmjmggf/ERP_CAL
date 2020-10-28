<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Consignatarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("C.ID, C.Clave, CONCAT(CL.Clave,' - ',CL.RazonS) AS Cliente, CONCAT(C.Clave,' - ',C.Consignatario) AS Consignatario , C.Direccion, "
                                    . "C.Colonia, C.Ciudad, C.Estado, C.CodigoPostal, C.RFC, "
                                    . "C.TelOficina, C.TelParticular, C.Transporte, C.Estatus, C.Registro", false)
                            ->from('consignatarios AS C')->join('clientes AS CL', 'C.Cliente = CL.Clave')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)','DESC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave($C) {
        try {
            return $this->db->select("G.Clave")->from("consignatarios AS G")->where("G.Clave", $C)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID($C) {
        try {
            return $this->db->select("C.Clave AS CLAVE")->from("consignatarios AS C")->where("C.Cliente", $C)->order_by('ABS(C.Clave)','DESC')->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstados() {
        try {
            return $this->db->select("E.Clave, CONCAT(E.Clave, \" - \", E.Descripcion) AS Estado", false)
                            ->from('estados AS E')
                            ->where_in('E.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \"-\",C.RazonS) AS Cliente", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTransportes() {
        try {
            return $this->db->select("T.Clave, CONCAT(T.Clave, \" - \", T.Descripcion) AS Transporte", false)
                            ->from('transportes AS T')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("consignatarios", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
//            PRINT "\n ID IN MODEL: $LastIdInserted \n";
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("consignatarios", $DATA);
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("consignatarios");
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConsignatarioByID($ID) {
        try {
            return $this->db->select('U.*', false)->from('consignatarios AS U')->where('U.ID', $ID)->where_in('U.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClienteXRFC($ID, $RFC) {
        try {
            $this->db->select("COUNT(C.ID) AS EXISTE", false)->from('consignatarios AS C')->where_in('C.RFC', $RFC);
            if ($ID > 0) {
                $this->db->where('C.ID <> ' . $ID, null, false);
            }
            $this->db->where_in('C.Estatus', 'ACTIVO');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
