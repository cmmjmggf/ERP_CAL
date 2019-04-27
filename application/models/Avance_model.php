<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Avance_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAvancesNomina($CONTROL) {
        try {
            $this->db->select("F.ID, F.numeroempleado AS EMPLEADO, F.maquila AS MAQUILA, "
                            . "F.control AS CONTROL, F.estilo AS ESTILO, F.numfrac AS NUM_FRACCION, "
                            . "F.preciofrac AS PRECIO_FRACCION, F.pares AS PARES, F.subtot AS SUBTOTAL, "
                            . "F.status, F.fecha AS FECHA, F.semana AS SEMANA, F.depto, "
                            . "F.registro, F.anio, F.avance_id, F.fraccion AS FRACCION", false)
                    ->from("fracpagnomina AS F");

            if ($CONTROL !== '') {
                $this->db->like('F.control', $CONTROL);
            }
            $this->db->limit(99);

            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS Clave, CONCAT(D.Clave,' - ',D.Descripcion) AS Departamento, D.Descripcion AS DesDepto")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->where("D.Tipo", 1)
                            ->where("D.Avance", 1)
                            ->where_not_in("D.Clave", array(10, 20))/* 10 CORTE <-*-> 20 RAYADO */
                            ->where_not_in("D.Clave", array(60, 70))/* 60 LASER <-*-> 70 PREL CORTE */
                            ->where_not_in("D.Clave", array(80, 120))/* 80 RAYADO CONTADO <-*-> 120 PREL PESPUNTE */
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha($fecha) {
        try {
            return $this->db->select("U.Sem, '$fecha' AS Fecha", false)
                            ->from('semanasproduccion AS U')
                            ->where("STR_TO_DATE(\"{$fecha}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccionXEstiloFraccion($ESTILO, $FRACCION) {
        try {
            return $this->db->select("FXE.ID, FXE.Estilo AS ESTILO, FXE.FechaAlta AS FECHA_ALTA, FXE.Fraccion AS FRACCION, FXE.CostoMO AS COSTO_MO", false)
                            ->from('fraccionesxestilo AS FXE')
                            ->where("FXE.Estilo = '{$ESTILO}' AND FXE.Fraccion = {$FRACCION}", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            return $this->db->select("CAST(MP.Clave AS SIGNED ) AS Clave, MP.Descripcion AS MaquilasPlantillas")
                            ->from("maquilasplantillas AS MP")
                            ->order_by('MP.Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXControl() {
        try {
            return $this->db->select("FP.ID, FP.control AS CONTROL, FP.numeroempleado AS EMPLEADO, FP.estilo AS ESTILO, "
                                    . "FP.numfrac AS NUM_FRACCION, FP.fecha AS FECHA, "
                                    . "FP.fecha AS FECHA,FP.Semana AS SEMANA, "
                                    . "FP.pares AS PARES, FP.preciofrac AS PRECIO_FRACCION, "
                                    . "FP.subtot AS SUBTOTAL")
                            ->from("fracpagnomina AS FP")->limit(999)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXConcepto($E, $C) {
        try {
            $this->db->select("PN.ID, "
                            . "PN.numsem AS SEMANA,"
                            . "PN.numemp AS EMPLEADO, "
                            . "PN.numcon AS CONCEPTO, "
                            . "PN.fecha AS FECHA, "
                            . "PN.tpcon AS PER, "
                            . "PN.importe AS IMPORTE, "
                            . "PN.tpcond AS DED, "
                            . "PN.imported AS SUBTOTAL")
                    ->from("prenomina AS PN")->limit(999);
            if ($E !== "") {
                $this->db->where('PN.numemp', $E);
            }
            if ($C !== '') {
                $this->db->where('PN.numcon', $C);
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNomina() {
        try {
            return $this->db->select("CN.Clave AS CLAVE, CN.Descripcion AS CONCEPTO")
                            ->from("conceptosnomina AS CN")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")->where_in('E.FijoDestajoAmbos', array(2, 3))->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            return $this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                            ->from('fracciones AS F')
                            ->where_not_in('F.Departamento', array(10, 20))
                            ->order_by('ABS(F.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXEstilo($ESTILO) {
        try {
            return $this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                            ->from('fracciones AS F')
                            ->join('fraccionesxestilo AS FXE', 'F.Clave = FXE.Fraccion')
                            ->where("FXE.Estilo LIKE '{$ESTILO}'", null, false)
                            ->where_not_in('F.Departamento', array(10, 20))
                            ->group_by('F.Clave')
                            ->order_by('ABS(F.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina($FECHA) {
        try {
            return $this->db->select("S.Sem AS SEMANA", false)
                            ->from('semanasnomina AS S')
                            ->where("STR_TO_DATE(\"{$FECHA}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptoActual($CONTROL) {
        try {
            return $this->db->select("A.Departamento AS DEPTO, C.Estilo AS ESTILO, C.Pares AS PARES", false)
                            ->from('avance AS A')
                            ->join('controles AS C', 'A.Control = C.Control')
                            ->like("A.Control", $CONTROL)
                            ->order_by("A.ID", "DESC")
                            ->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
