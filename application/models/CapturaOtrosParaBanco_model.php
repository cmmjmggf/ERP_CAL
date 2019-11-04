<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CapturaOtrosParaBanco_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onEliminarDetalleByID($Empleado, $Ano, $Sem) {
        try {
            /* Nomina Lineal */
            $this->db->where('numemp', $Empleado)->where('numsem', $Sem)->where('año', $Ano);
            $this->db->delete("prenominal");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords($ano, $sem) {
        try {
            $this->db->select("P.ID, EM.DepartamentoFisico as numdepto, P.numemp, P.salariod, P.salfis, "
                            . 'CONCAT(\'<span class="fa fa-times fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',P.numemp,\',\',P.año,\',\',P.numsem,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("prenominal P")
                    ->join("empleados EM", 'on EM.numero = P.numemp')
                    ->where("P.año", $ano)->where("P.numsem", $sem);
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

    public function getEmpleadosGeneral() {
        try {
            return $this->db->select("CAST(E.numero AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Empleado ")
                            ->from("empleados AS E")->where("E.altabaja", "1")->order_by('Empleado', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
