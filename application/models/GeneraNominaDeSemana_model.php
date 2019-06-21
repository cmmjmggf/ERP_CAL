<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraNominaDeSemana_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getSemanaNomina($FECHA) {
        try {
            return $this->db->select("S.Sem AS SEMANA, S.FechaIni AS FECHAINI, S.FechaFin AS FECHAFIN", false)
                            ->from('semanasnomina AS S')
                            ->where("STR_TO_DATE(\"{$FECHA}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
