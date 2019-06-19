<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class DiaFestivo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getSemanaNomina($FECHA) {
        try {
            return $this->db->select("S.Sem AS SEMANA", false)
                            ->from('semanasnomina AS S')
                            ->where("STR_TO_DATE(\"{$FECHA}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}