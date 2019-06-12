<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Departamentos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("D.ID,CAST(D.Clave AS SIGNED ) AS Clave, D.Descripcion, D.Tipo, D.Avance, D.Fraccion")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS Clave,CONCAT(D.Clave,'-',D.Descripcion) AS Departamento")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentosAvanceAnterior() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS Clave,CONCAT(D.Clave,'-',D.Descripcion) AS Departamento")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->where("D.Tipo", "1")
                            ->where("CAST(D.Clave AS SIGNED) > 20 AND CAST(D.Clave AS SIGNED) < 240 ", null, false)
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS ID,CONCAT(D.Clave,'-',D.Descripcion) AS Fraccion")
                            ->from("fracciones AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave($C) {
        try {
            return $this->db->select("G.Clave")->from("departamentos AS G")->where("G.Clave", $C)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoByID($IDX) {
        try {
            return $this->db->select("D.*")->from("departamentos AS D")->where("D.Estatus", "ACTIVO")->where("D.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(D.Clave, UNSIGNED INTEGER) AS CLAVE")->from("departamentos AS D")->where("D.Estatus", "ACTIVO")->order_by("CLAVE", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("departamentos", $array);
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
            $this->db->where('ID', $ID)->update("departamentos", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("departamentos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
