<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CapturaNominaFraccionesSemanal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($emp, $ano, $sem) {
        try {
            $this->db->select("control, anio,semana, numeroempleado, numfrac, estilo, preciofrac, pares, subtot ")
                    ->from("fracpagnomina ")
                    ->where("anio", $ano)->where("semana", $sem)->where("numeroempleado", $emp);
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

    public function onVerificarConceptoCapturado($conc, $ano, $sem, $emp) {
        try {
            $this->db->select("C.numcon "
                            . "")
                    ->from("prenomina C")
                    ->where("C.numsem", $sem)->where("C.numemp", $emp)->where("C.año", $ano)->where("C.numcon", $conc);
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
            return $this->db->select("CAST(E.numero AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Empleado ")
                            ->from("empleados AS E")->where_in("E.FijoDestajoAmbos", array("2", "3"))->where("E.altabaja", "1")->order_by('Empleado', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            return $this->db->select("CAST(E.Clave AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.Descripcion) AS Fraccion ")
                            ->from("fracciones AS E")->where("E.Estatus", "ACTIVO")->order_by('Fraccion', 'ASC')
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
