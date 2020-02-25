<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Colores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("C.ID, C.Estilo, C.Clave, C.Descripcion AS Color")->from("colores AS C")
                            ->join('estilos AS E', 'C.Estilo = E.Clave', 'left')->where("C.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            return $this->db->select("E.Clave AS ID,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Estilo")->from("estilos AS E")->where("E.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
//            GRUPO = 1
            return $this->db->select("A.Clave AS ID,CONCAT(A.Clave,'-',IFNULL(A.Descripcion,'')) AS Articulo")->from("articulos AS A")
                            ->where("A.Estatus", "ACTIVO")->where("A.Grupo", 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColorByID($IDX) {
        try {
            return $this->db->select("E.*")->from("colores AS E")->where("E.Estatus", "ACTIVO")->where("E.ID", $IDX)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("E.Clave AS CLAVE")->from("colores AS E")->where("E.Estatus", "Activo")->order_by("E.Clave", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("colores", $array);
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
            $this->db->where('ID', $ID)->update("colores", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("colores");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaClave($Estilo) {
        try {
            $this->db->select('MAX(CAST(C.Clave AS SIGNED)) as Clave ', false)->from('colores AS C')->where('C.Estilo', $Estilo);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
