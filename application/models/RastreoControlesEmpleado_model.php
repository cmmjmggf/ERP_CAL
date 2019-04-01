<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class RastreoControlesEmpleado_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("OC.control AS Control,"
                            . "OC.numfrac AS Fraccion, "
                            . "OC.anio AS Ano,"
                            . "OC.semana AS Semana, "
                            . "OC.estilo AS Estilo, "
                            . "OC.pares AS Pares, "
                            . "OC.fecha AS Fecha,"
                            . "OC.numeroempleado AS Empleado  "
                            . "", false)
                    ->from("fracpagnomina AS OC");
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

    public function getEmpleados() {
        try {
            return $this->db->select("CAST(D.Numero AS SIGNED ) AS ID,CONCAT(D.Numero,'-',D.Busqueda) AS Empleado")
                            ->from("empleados AS D")
                            ->where("D.Estatus", "A")
                            ->where("D.AltaBaja", "1")
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
