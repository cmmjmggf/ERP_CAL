<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesProduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getDeptos($Año, $Semana) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("fpn.depto "
                            . " ", false)
                    ->from('fracpagnomina fpn ')
                    ->where('fpn.anio', $Año)
                    ->where('fpn.maquila', $Semana)
                    ->group_by(array('fpn.depto'))
                    ->order_by('fpn.depto', 'ASC');


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

    public function getTotalesByDeptoAnoSemanaFecha($Depto, $Año, $Semana) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("fpn.depto "
                            . " ", false)
                    ->from('fracpagnomina fpn ')
                    ->where('fpn.anio', $Año)
                    ->where('fpn.maquila', $Semana)
                    ->group_by(array('fpn.depto'))
                    ->order_by('fpn.depto', 'ASC');


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
            $this->db->insert("costomanoobratemp", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptosFT($Estilo, $Color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(D.Clave AS SIGNED ) AS CDEPTO , D.Descripcion AS DDEPTO "
                            . " ", false)
                    ->from('fichatecnica FT')
                    ->join('piezas AS P', 'ON P.Clave = FT.Pieza')
                    ->join('departamentos AS D', 'ON D.Clave = P.Departamento')
                    ->where('FT.Estilo', $Estilo)
                    ->where('FT.Color', $Color)
                    ->group_by(array('D.Clave'))
                    ->order_by('CDEPTO', 'ASC');


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
