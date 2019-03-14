<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Maquilas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("M.ID, M.Clave, M.Nombre")->from("maquilas AS M")->where("M.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            return $this->db->select("CONVERT(M.Clave, UNSIGNED INTEGER) AS Clave, CONCAT(M.Clave,' - ',M.Nombre) AS Maquila")->from("maquilas AS M")->where("M.Estatus", "ACTIVO")->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaByID($IDX) {
        try {
            return $this->db->select("M.*")->from("maquilas AS M")->where("M.Estatus", "ACTIVO")->where("M.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaByClave($IDX) {
        try {
            return $this->db->select("M.*")->from("maquilas AS M")->where("M.Estatus", "ACTIVO")->where("M.Clave", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(M.Clave, UNSIGNED INTEGER) AS CLAVE")
                            ->from("maquilas AS M")
                            ->where("M.Estatus", "ACTIVO")
                            ->where("CONVERT(M.Clave, UNSIGNED INTEGER) < 91")
                            ->order_by("CLAVE", "DESC")
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("maquilas", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("maquilas", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("maquilas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
