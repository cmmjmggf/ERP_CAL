<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Avance7_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onComprobarDeptoXEmpleado($EMPLEADO) {
        try {
            return $this->db->select("CONCAT(E.PrimerNombre,' ',"
                                    . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                    . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                    . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
                                    . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE", false)
                            ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                            ->where('E.Numero', $EMPLEADO)
                            ->where_in('E.AltaBaja', array(1))
                            ->where_in('E.FijoDestajoAmbos', array(2, 3))
                            ->where_in('E.DepartamentoFisico', array(20/* RAYADO */, 30/* REBAJADO */, 40/* FOLEADO */))
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarAvanceXControl($CONTROL) {
        try {
            return $this->db->select("FP.ID, FP.numeroempleado AS EMPLEADO, FP.control AS CONTROL", false)
                            ->from('fracpagnomina AS FP')
                            ->where('FP.control', $CONTROL)
                            ->where('FP.numfrac', 60)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosXEmpleadoXSemana($e, $s) {
        try {
            $a = "IFNULL((SELECT FORMAT(SUM(fpn.subtot),2) FROM fracpagnomina AS fpn WHERE dayofweek(fpn.fecha)";
            $b = "AND fpn.numeroempleado = '{$e}' AND fpn.Semana = {$s} GROUP BY dayofweek(fpn.fecha)),0)";
            return $this->db->select("{$a}= 2 {$b} AS LUNES,"
                                    . "{$a} = 3 {$b} AS MARTES,"
                                    . "{$a} = 4 {$b} AS MIERCOLES,"
                                    . "{$a} = 5 {$b} AS JUEVES,"
                                    . "{$a} = 6 {$b} AS VIERNES,"
                                    . "{$a} = 7 {$b} AS SABADO,"
                                    . "{$a} = 1 {$b} AS DOMINGO", false)->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha($fecha) {
        try {
            $this->db->select("U.Sem, '{$fecha}' AS Fecha", false)
                    ->from('semanasnomina AS U')
                    ->where("STR_TO_DATE(\"{$fecha}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")");
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl($CONTROL) {
        try {
            $this->db->select("C.Estilo, C.Pares, FXE.CostoMO, (C.Pares * FXE.CostoMO) AS TOTAL", false)
                    ->from('pedidox as C')
                    ->join('fraccionesxestilo as FXE', 'C.Estilo = FXE.Estilo')
                    ->where("C.Control", $CONTROL)->limit(1);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterial($CONTROL, $FRACCION, $EMPLEADO) {
        try {
            return $this->db->select("COUNT(*) AS EXISTE", false)
                            ->from('asignapftsacxc AS A')
                            ->like("A.Control", $CONTROL)
                            ->like("A.Fraccion", $FRACCION)
                            ->like("A.Empleado", $EMPLEADO)
                            ->order_by('A.ID', 'DESC')
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl($CONTROL) {
        try {
            return $this->db->select("A.ID, A.Control, A.FechaAProduccion, A.Departamento, A.DepartamentoT, A.FechaAvance, A.Estatus, A.Usuario, A.Fecha, A.Hora ", false)
                            ->from('avance AS A')
                            ->where("A.Control", $CONTROL)
                            ->order_by('A.ID', 'DESC')
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesPagoNomina($E, $F) {
        try {
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "FACN.numfrac AS FRAC, FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, CONCAT('$',FORMAT(FACN.subtot,2)) AS SUBTOTAL, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN')->where("FACN.numfrac IN($F) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);
            if ($E !== '' && $E !== NULL) {
                $this->db->where('FACN.numeroempleado', $E);
            }
            $dtm = $this->db->get()->result();
            $str = $this->db->last_query();
//            print $str;
            return $dtm;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoFraccionesPagoNomina($C, $S, $E) {
        try {
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "FACN.numfrac AS FRAC, FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, CONCAT('$',FORMAT(FACN.subtot,2)) AS SUBTOTAL, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN')->where("FACN.numfrac IN($F) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);

            $dtm = $this->db->get()->result();
            $str = $this->db->last_query();
//            print $str;
            return $dtm;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
