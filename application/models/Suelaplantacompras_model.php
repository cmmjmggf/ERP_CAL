<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Suelaplantacompras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getRecords() {
        try {
            $this->db->select("SC.ID , "
                            . "CONCAT(A.Clave,' ',A.Descripcion) AS Cabecero, "
                            . "SC.Serie "
                            . " ", false)
                    ->from('suelascompras AS SC')
                    ->join('articulos AS A', 'SC.ArticuloCBZ = A.Clave')
                    ->where('SC.Estatus', 'ACTIVO');

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByGrupo($Grupo) {
        try {
            return $this->db->select("M.Clave AS ID, CONCAT(M.Clave,' - ', IFNULL(M.Descripcion,'')) AS Articulo", false)
                            ->from('articulos AS M')->where_in('M.Estatus', array('ACTIVO'))
                            ->where_in('M.Grupo', $Grupo)
                            ->order_by("M.Clave", "ASC")
                            ->get()
                            ->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarArticulo($C) {
        try {
            return $this->db->select("P.ArticuloCBZ")->from("suelascompras AS P")->where("P.ArticuloCBZ", $C)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSuelaPlantabyID($ID) {
        try {
            return $this->db->select("SP.*", false)->from("suelascompras AS SP")->where('SP.ID', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("suelascompras", $array);
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
            $this->db->where('ID', $ID)->update("suelascompras", $DATA);
            $str = $this->db->last_query();
            print $str;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
