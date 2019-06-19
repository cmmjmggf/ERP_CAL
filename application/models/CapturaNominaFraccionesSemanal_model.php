<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CapturaNominaFraccionesSemanal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onEliminarDetalleByID($Empleado, $Ano, $Sem, $Conc) {
        try {
            $this->db->where('numemp', $Empleado)->where('numsem', $Sem)->where('año', $Ano)->where('numcon', $Conc);
            $this->db->delete("prenomina");

            /* Nomina Lineal */
            $this->db->where('numemp', $Empleado)->where('numsem', $Sem)->where('año', $Ano);
            $this->db->update("prenominal", array(
                'salario' => 0,
                'salariod' => 0,
                'horext' => 0,
                'otrper' => 0,
                'otrper1' => 0,
                'infon' => 0,
                'imss' => 0,
                'zapper' => 0,
                'impu' => 0,
                'precaha' => 0,
                'cajhao' => 0,
                'vtazap' => 0,
                'fune' => 0,
                'cargo' => 0,
                'fonac' => 0,
                'otrde' => 0,
                'otrde1' => 0
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords($emp, $ano, $sem) {
        try {
            $this->db->select("ID, (case when tpcon = 1 then tpcon else tpcond end) as perded , numsem, numemp, numcon, importe, imported, "
                            . 'CONCAT(\'<span class="fa fa-times fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',numemp,\',\',año,\',\',numsem,\',\',numcon,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("prenomina")
                    ->where("año", $ano)->where("numsem", $sem)->where("numemp", $emp);
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

    public function getDiasAsistenciaXEmpleadoSem($emp, $ano, $sem) {
        try {
            $this->db->select("C.numasistencias "
                            . "")
                    ->from("asistencia C")
                    ->where("C.numsem", $sem)->where("C.numemp", $emp)->where("C.año", $ano);
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

    public function getConceptosNomina() {
        try {
            return $this->db->select("CAST(E.Clave AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.Clave,' ',E.Descripcion) AS Concepto ")
                            ->from("conceptosnomina AS E")->where("E.Estatus", "ACTIVO")->where_not_in('E.Clave', array('65', '70'))->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTipoConcepto($con) {
        try {
            return $this->db->select("Tipo ")
                            ->from("conceptosnomina")->where("Clave", $con)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasNomina($Ano) {
        try {
            return $this->db->select("Sem, concat(Sem,' (', FechaIni,' - ',FechaFin,')') AS Semana  ")
                            ->from("semanasnomina")->where("Ano", $Ano)->where("Estatus", "ACTIVO")->order_by('Sem', 'ASC')
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
