<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Fracciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("F.ID, F.Clave, F.Descripcion, (SELECT CONCAT(Clave,\" \",Descripcion) FROM departamentos WHERE Clave = F.Departamento LIMIT 1) AS Depto, F.Departamento AS ORDEN_DEPTO",false)->from("fracciones AS F")->where("F.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            return $this->db->select(" CAST(D.Clave AS SIGNED ) AS Clave ,CONCAT(D.Clave,'-',D.Descripcion) AS Fraccion")
                            ->from("fracciones AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select(" CAST(D.Clave AS SIGNED ) AS Clave ,CONCAT(D.Clave,'-',D.Descripcion) AS Departamento")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionByID($IDX) {
        try {
            return $this->db->select("F.*")->from("fracciones AS F")->where("F.Estatus", "ACTIVO")->where("F.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(F.Clave, UNSIGNED INTEGER) AS CLAVE")
                            ->from("fracciones AS F")
                            ->where("F.Estatus", "Activo")
                            ->where('CLAVE < 9999', null, false)
                            ->order_by("CLAVE", "DESC")
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("fracciones", $array);
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
            $this->db->where('ID', $ID)->update("fracciones", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("fracciones");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
