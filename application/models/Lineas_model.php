<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Lineas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("L.ID, L.Clave, L.Descripcion,L.Ano,L.Tipo")->from("lineas AS L")->where("L.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas() {
        try {
            return $this->db->select("L.Clave,CONCAT(L.Clave,'-',L.Descripcion) AS Linea")->from("lineas AS L")->where("L.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineasSelect() {
        try {
            return $this->db->select("cast(L.Clave AS signed) AS Clave,CONCAT(L.Clave,'-',L.Descripcion) AS Linea")->from("lineas AS L")->where("L.Estatus", "ACTIVO")->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaByID($IDX) {
        try {
            return $this->db->select("L.*")->from("lineas AS L")->where("L.Estatus", "ACTIVO")->where("L.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave($C) {
        try {
            return $this->db->select("L.Clave")->from("lineas AS L")->where("L.Clave", $C)->where("L.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("lineas", $array);
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
            $this->db->where('ID', $ID)->update("lineas", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("lineas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
