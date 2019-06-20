<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ConsultaAsistencias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($EMPLEADO) {
        try {
            $this->db->select(" numemp, nomemp,
                            (case
                            when dayofweek(fecalta) = 1 then 'Domingo'
                            when dayofweek(fecalta) = 2 then 'Lunes'
                            when dayofweek(fecalta) = 3 then 'Martes'
                            when dayofweek(fecalta) = 4 then 'Miércoles'
                            when dayofweek(fecalta) = 5 then 'Jueves'
                            when dayofweek(fecalta) = 6 then 'Viernes'
                            when dayofweek(fecalta) = 7 then 'Sábado'
                            end) as Dia,
                            hora,turno, ampm, semana, año ,  fecalta  "
                            . "", false)
                    ->from("relojchecador");
            $this->db->where('numemp', $EMPLEADO);
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
