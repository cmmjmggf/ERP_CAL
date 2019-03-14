<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Cerrarsemanasprod_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("SPC.Ano AS Ano ,"
                    . "SPC.Maq AS Maq, "
                    . "SPC.Sem AS Sem, "
                    . "CASE WHEN SPC.Estatus = 'ABIERTA' THEN "
                    . "CONCAT('<span class=''badge badge-success''>','ABIERTA','</span>') "
                    . "ELSE "
                    . "CONCAT('<span class=''badge badge-danger''>','CERRADA','</span>') "
                    . "END AS Estatus "
                    . "", false);
            $this->db->from("semanasproduccioncerradas AS SPC");
            $this->db->join("semanasproduccion SP", "ON SP.Sem = SPC.Sem AND SP.Ano = SPC.Ano AND SP.Estatus = 'ACTIVO' ");
            $this->db->where_in('SPC.Estatus', array('ABIERTA', 'CERRADA'));
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

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("G.Clave, G.Direccion")->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion($Clave, $Ano) {
        try {
            return $this->db->select("G.Sem")->from("semanasproduccion AS G")->where("G.Sem", $Clave)->where("G.Ano", $Ano)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada($Ano, $Maq, $Sem) {
        try {
            $this->db->select("G.Sem")->from("semanasproduccioncerradas AS G")
                    ->where("G.Ano", $Ano)
                    ->where("G.Maq", $Maq)
                    ->where("G.Sem", $Sem)
                    ->where_in("G.Estatus", array("ABIERTA", "CERRADA"));
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
            $this->db->insert("semanasproduccioncerradas", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
//            PRINT "\n ID IN MODEL: $LastIdInserted \n";
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($Ano, $Maq, $Sem, $DATA) {
        try {
            $this->db->where('Ano', $Ano)
                    ->where('Maq', $Maq)
                    ->where('Sem', $Sem)
                    ->update("semanasproduccioncerradas", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
