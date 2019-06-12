<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class RelojChecador_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $query = $this->db->select("A.ID AS ID, A.Usuario AS Usuario,"
                                    . " A.Numero AS Numero, A.Fecha AS Fecha, A.Hora AS Hora,  "
                                    . "A.Tipo As Tipo, A.Estatus AS Estatus", false)
                            ->from('relojchecador AS A')->get();
            $str = $this->db->last_query();
            return $query->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarEntrada($Numero, $fecha) {
        try {
//            $query = $this->db->select("A.ID, A.Usuario, A.Numero, A.Fecha, "
//                                    . "A.Hora, A.Estatus, A.Tipo, A.Empleado, 
//                                    A.EmpleadoT ", false)
            $query = $this->db->select("A.numemp AS Numero, A.nomemp AS Empleado, "
                                    . "A.numdep AS DEPARTAMENTO, "
                                    . "A.nomdep AS DEPARTAMENTOT, "
                                    . "A.fecalta AS FECHAALTA, "
                                    . "A.ampm AS AMPM, "
                                    . "A.turno AS TURNO, A.hora AS HORA, "
                                    . "A.semana AS SEMANA, A.año AS ANO, A.reg", false)
                            ->from('relojchecador AS A')
                            ->join('empleados AS E', 'E.Numero = A.numemp', 'left')
                            ->where('A.numemp', $Numero)
                            ->where('A.fecalta  >= \'' . $fecha . '\'')
                            ->order_by('A.ID', 'DESC')->limit(4)->get();
            $str = $this->db->last_query();
            return $query->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionPorEmpleado($Numero) {
        try {
            return $this->db->select("E.ID AS ID, "
                                    . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ',E.Materno) AS Empleado, "
                                    . "E.Foto AS FOTO, E.DepartamentoFisico AS DEPTO, D.Descripcion AS DEPTOT", false)
                            ->from('empleados AS E')->join('departamentos AS D','E.DepartamentoFisico = D.Clave')
                            ->where('E.Numero', $Numero)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionSemana($Fecha) {
        try {
            return $this->db->select("S.ID ID, S.Ano ANIO, S.Sem AS SEMANA, "
                                    . "S.FechaIni AS FECHA_INICIO, S.FechaFin AS FECHA_FIN", false)
                            ->from('semanasnomina AS S')
                            ->where("str_to_date('$Fecha','%d/%m/%Y') BETWEEN str_to_date(FechaIni, '%d/%m/%Y') AND  str_to_date(FechaFin, '%d/%m/%Y')", null, false)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
