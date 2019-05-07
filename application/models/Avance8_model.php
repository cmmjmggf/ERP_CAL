<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Avance8_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onComprobarDeptoXEmpleado($EMPLEADO) {
        try {
            return $this->db->select("CONCAT(E.PrimerNombre,' ',"
                                    . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                    . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                    . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
                                    . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Descripcion AS DEPTO", false)
                            ->from('empleados AS E')->join('departamentos AS D', 'D.Clave = E.DepartamentoFisico')
                            ->where('E.Numero', $EMPLEADO)
                            ->where_in('E.AltaBaja', array(1))
                            ->where_in('E.FijoDestajoAmbos', array(2, 3))
                            ->where_in('E.DepartamentoFisico', array(20, 30, 40/* PREL-CORTE */, 60, 80/* RAYADO CONTADO */, 90/* ENTRETELADO */, 140/* ENSUELADO */))
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl($CONTROL, $FR) {
        try {
            $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
                    ->from('asignapftsacxc AS A')
                    ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo')
                    ->where("A.Control", $CONTROL);
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

    public function getPagosXEmpleadoXSemana($e, $s) {
        try {
            $a = "IFNULL((SELECT FORMAT(SUM(fpn.subtot),2) FROM fracpagnomina AS fpn WHERE dayofweek(fpn.fecha)";
            $b = "AND fpn.numeroempleado = '$e' AND fpn.Semana = $s GROUP BY dayofweek(fpn.fecha)),0)";

            return $this->db->select(
                                    "$a = 2 $b AS LUNES,"
                                    . "$a = 3 $b AS MARTES,"
                                    . "$a = 4 $b AS MIERCOLES,"
                                    . "$a = 5 $b AS JUEVES,"
                                    . "$a = 6 $b AS VIERNES,"
                                    . "$a = 7 $b AS SABADO,"
                                    . "$a = 1 $b AS DOMINGO", false)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha($fecha) {
        try {
            $this->db->select("U.Sem, '$fecha' AS Fecha", false)
                    ->from('semanasproduccion AS U')
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

    public function getUltimoAvanceXControl($CONTROL) {
        try {
            $this->db->select("A.ID, A.Control, A.FechaAProduccion, A.Departamento, A.DepartamentoT, A.FechaAvance, A.Estatus, A.Usuario, A.Fecha, A.Hora ", false)
                    ->from('avance AS A')
                    ->where("A.Control", $CONTROL)
                    ->order_by('A.ID', 'DESC')
                    ->limit(1);
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

    public function onComprobarEstiloXControlXFraccion($CONTROL, $FR) {
        try {
            $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
                    ->from('pedidox AS A')
                    ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo')
                    ->where("FXE.Fraccion", $FR)
                    ->where("A.Control", $CONTROL);
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

    public function getFraccionesPagoNomina($E, $F) {
        try {
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "FACN.numfrac AS FRAC, FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, FACN.subtot AS SUBTOTAL, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN')->where("FACN.numfrac IN($F)", null, false);
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

    public function onComprobarFraccionXEstilo($ESTILO, $FRACCION) {
        try {
            return $this->db->select("FE.ID, FE.Estilo, FE.FechaAlta, FE.Fraccion, FE.CostoMO, FE.CostoVTA, FE.AfectaCostoVTA, FE.Estatus, F.ID AS FID, F.Clave AS FCLAVE, F.Descripcion AS FRACCIONDES, F.Departamento AS FRACCIONDEPTO", false)
                            ->from('fraccionesxestilo AS FE')->join('fracciones AS F', 'F.Clave = FE.Fraccion')
                            ->where('FE.Estilo', $ESTILO)
                            ->where('FE.Fraccion', $FRACCION)
                            ->get()->result();
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

}
