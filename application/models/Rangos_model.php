<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Rangos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("R.ID,R.Clave, CONCAT(S.Clave,' - DEL ',S.PuntoInicial,' AL ',S.PuntoFinal) Serie")
                            ->from("rangos AS R")->join('series AS S', 'R.Serie = S.Clave')->where("R.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSeries() {
        try {
            return $this->db->select("S.Clave, CONCAT(S.Clave,' - DEL ',S.PuntoInicial,' AL ',S.PuntoFinal) AS 'Serie' ", false)
                            ->from('series AS S')->where_in('S.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave($C) {
        try {
            return $this->db->select("R.Clave")->from("rangos AS R")->where("R.Clave", $C)->where("R.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSerieXClave($Clave) {
        try {
            return $this->db->select("S.*", false)->from('series AS S')->where('S.Clave', $Clave)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRangoByID($IDX) {
        try {
            return $this->db->select("R.*")->from("rangos AS R")->where("R.Estatus", "ACTIVO")->where("R.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(R.Clave, UNSIGNED INTEGER) AS CLAVE")->from("rangos AS R")->where("R.Estatus", "Activo")->order_by("R.Clave", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("rangos", $array);
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
            $this->db->where('ID', $ID)->update("rangos", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("rangos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
