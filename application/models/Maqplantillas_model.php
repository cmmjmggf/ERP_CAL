<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Maqplantillas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("MP.ID, MP.Clave, MP.Descripcion")->from("maquilasplantillas AS MP")->where("MP.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaqPlantillas() {
        try {
            return $this->db->select("MP.Clave,CONCAT(MP.Clave,'-',MP.Descripcion) AS MaquilasPlantillas")->from("maquilasplantillas AS MP")->where("MP.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaPlantillaByID($IDX) {
        try {
            return $this->db->select("MP.ID, MP.Clave, MP.Descripcion, MP.Estatus")->from("maquilasplantillas AS MP")->where("MP.Estatus", "ACTIVO")->where("MP.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(MP.Clave, UNSIGNED INTEGER) AS CLAVE")->from("maquilasplantillas AS MP")->where("MP.Estatus", "ACTIVO")->order_by("CLAVE", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("maquilasplantillas", $array);
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
            $this->db->where('ID', $ID)->update("maquilasplantillas", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("maquilasplantillas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
