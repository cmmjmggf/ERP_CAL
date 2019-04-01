<?php

/**
 * Description of ControlesTerminados_model
 *
 * @author Y700
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CalidadProduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getExiste($Control) {
        try {
            $this->db->select("
                            P.Control "
                            . "")
                    ->from("calidadproduccion P")
                    ->where("P.Control", $Control);
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

    public function getControl($Control) {
        try {
            $this->db->select("
                            C.Estilo,
                            C.Serie,
                            C.Color,
                            C.Maquila,
                            D.Clave AS Depto "
                            . "")
                    ->from("controles C")
                    ->join("departamentos D", 'ON D.Descripcion = C.EstatusProduccion')
                    ->where("C.Control", $Control);
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

    public function getCalidadProduccion() {
        try {
            $this->db->select("
                            P.ID,
                            P.Control,
                            P.Fecha, "
                            . 'CONCAT(\'<span class="fa fa-user-check fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',P.Control,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("calidadproduccion P")
                    ->where("P.Usuario", $this->session->userdata('USERNAME'));
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

    public function onAgregar($array) {
        try {
            $this->db->insert("calidadproduccion", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('Control', $ID);
            $this->db->delete("calidadproduccion");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
