<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class RastreoControlesEmpleado_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($EMPLEADO, $ANIO, $SEMANA) {
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
            if ($EMPLEADO !== '' && $ANIO === '' && $SEMANA === '') {
                $this->db->where('OC.numeroempleado', $EMPLEADO);
            } else if ($EMPLEADO !== '' && $ANIO !== '' && $SEMANA == '') {
                $this->db->where('OC.numeroempleado', $EMPLEADO)->where('OC.anio', $ANIO);
            } else if ($EMPLEADO !== '' && $ANIO !== '' && $SEMANA !== '') {
                $this->db->where('OC.numeroempleado', $EMPLEADO)->where('OC.anio', $ANIO)->where('OC.semana', $SEMANA);
            } else {
                $this->db->limit(9999);
            }
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

    public function getEmpleados() {
        try {
            return $this->db->select("CAST(D.Numero AS SIGNED ) AS ID,CONCAT(D.Numero,'-',D.Busqueda) AS Empleado")
                            ->from("empleados AS D")
                            ->join("fracpagnomina AS FPN", "D.Numero = FPN.numeroempleado")
                            ->where("D.Estatus", "ACTIVO")
                            ->where("D.AltaBaja", "1")
                            ->group_by('D.Numero')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
