<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CapturaAsistencias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPrenominaLinea($Emp, $Sem, $Ano) {
        try {
            $this->db->select(" numemp "
                            . " ")
                    ->from(" prenominal ")
                    ->where("año", $Ano)->where("numsem", $Sem)->where("numemp", $Emp);

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

    public function onVerificarSemanaNominaCerrada($Sem, $Ano) {
        try {
            $this->db->select(" PM.status as 'status' "
                    . "FROM "
                    . "prenomina PM "
                    . "where PM.numsem = $Sem "
                    . "and PM.año = $Ano "
                    . " ")->group_by('PM.numsem');

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

    public function onVerificarAsistenciaCapturada($Ano, $Sem, $Emp) {
        try {
            $this->db->select("numemp ")->from('asistencia')->where('numsem', $Sem)->where('numemp', $Emp)->where('año', $Ano);

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

    public function getEmpleadosGeneral() {
        try {
            return $this->db->select("CAST(E.numero AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.numero,' ',E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Empleado ")
                            ->from("empleados AS E")->where("E.altabaja", "1")->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoByEmpleado($Empleado) {
        try {
            return $this->db->select("P.DepartamentoFisico as Depto, P.CelulaPorcentaje ", false)
                            ->from('empleados AS P')->where("P.Numero", $Empleado)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
