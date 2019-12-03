<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ListasPrecioMaquilas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Maq, $Linea) {
        try {
            $this->db->select(""
                    . "LPM.ID, "
                    . "LPM.Maq, "
                    . "LPM.Linea, "
                    . "LPM.Estilo, "
                    . "LPM.Color, "
                    . "LPM.Corrida, "
                    . "LPM.PrecioVta, "
                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',LPM.ID,\')">\',\'</span>\') AS Eliminar'
                    . "", false);
            $this->db->from("listapreciosmaquilas LPM");

            $this->db->where("LPM.Maq", $Maq);


            if ($Linea === '0' || $Linea === '') {

            } else {
                $this->db->where("LPM.Linea", $Linea);
            }

            $this->db->order_by("LPM.Maq", "ASC")
                    ->order_by("LPM.Linea", "ASC")
                    ->order_by("LPM.Estilo", "ASC")
                    ->order_by("LPM.Color", "ASC");
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

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('ID', $ID);
            $this->db->delete("listapreciosmaquilas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("listapreciosmaquilas", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
