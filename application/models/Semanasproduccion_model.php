<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Semanasproduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("U.Ano AS 'Año',U.Estatus  ", false);
            $this->db->from('semanasproduccion AS U');
            $this->db->where_in('U.Estatus', 'ACTIVO');
            $this->db->group_by(array('U.Ano', 'U.Estatus'));
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

    public function onValidarExisteAno($Ano) {
        try {
            $this->db->select("COUNT(*) AS EXISTE", false)->from('semanasproduccion AS S');
            $this->db->where('S.Ano', $Ano);
            $this->db->where_in('S.Estatus', 'ACTIVO');
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
            $this->db->insert("semanasproduccion", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            return $row['LAST_INSERT_ID()'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID);
            $this->db->update("semanasproduccion", $DATA);
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($Ano) {
        try {
            $this->db->set('Estatus', 'INACTIVO');
            $this->db->where('Ano', $Ano);
            $this->db->update("semanasproduccion");
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaProduccionByAno($Ano) {
        try {
            $this->db->select('U.*', false);
            $this->db->from('semanasproduccion AS U');
            $this->db->where('U.Ano', $Ano);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasProduccionByAno($Ano) {
        try {
            $this->db->select(""
                    . "CONCAT('<input type=''text'' id=''#Sem'' onkeypress= ''validate(event, this.value);'' class=''form-control form-control-sm numbersOnly'' onpaste= ''return false;''  value=''', U.Sem ,''' onchange=''onModificarSemanaXID(this.value,',U.ID ,')'' />') AS 'NoSem',  "
                    . "U.FechaIni AS 'FechaInicio', "
                    . "U.FechaFin AS 'FechaFin' "
                    . " ", false);
            $this->db->from('semanasproduccion AS U');
            $this->db->where('U.Ano', $Ano);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha($fecha) {
        try {
            $this->db->select('U.Sem', false);
            $this->db->from('semanasproduccion AS U');
            $this->db->where('\'' . $fecha . '\' BETWEEN CONVERT(DATE,U.FechaIni) AND CONVERT(DATE,U.FechaFin)');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
