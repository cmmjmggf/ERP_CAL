<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CapturaFraccionesParaNomina_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("fracpagnomina", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID($Control, $Empleado, $Fraccion) {
        try {
            $this->db->where('numeroempleado', $Empleado)->where('control', $Control)->where('numfrac', $Fraccion);
            $this->db->delete("fracpagnomina");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesNominaRastreo($Control, $Ano, $Sem, $Empleado) {
        try {
            $this->db->select("*"
                            . "")
                    ->from("fracpagnomina")
                    ->like('control', $Control)
                    ->like('anio', $Ano)
                    ->like('semana', $Sem)
                    ->like('numeroempleado', $Empleado, 'after')->limit(1500);
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

    public function getRecords($Ano, $Sem) {
        try {
            $this->db->select("ID, numeroempleado, semana, date_format(fecha,'%d/%m/%Y') as fecha, control, estilo ,numfrac, pares, "
                            . 'CONCAT(\'<span class="fa fa-times fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',numeroempleado,\',\',control,\',\',numfrac,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("fracpagnomina")
                    ->where("anio", $Ano)->where("semana", $Sem);
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

    public function onVerificarFraccionCapturada($Fraccion, $Control, $Empleado) {
        try {
            $this->db->select("C.* "
                            . "")
                    ->from("fracpagnomina C")
                    ->where("C.numfrac", $Fraccion)->where("C.control", $Control)->where("C.numeroempleado", $Empleado);
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

    public function getControl($Control) {
        try {
            $this->db->select("
                            D.Clave AS Depto,
                            D.Descripcion AS DeptoT,
                            C.Estilo Estilo,
                            C.Color AS Color,
                            C.Pares "
                            . "")
                    ->from("controles C")
                    ->join("departamentos D", 'ON D.Descripcion = C.EstatusProduccion')
                    ->where("C.Control", $Control);
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

    public function getDepartamentoByEmpleado($Empleado) {
        try {
            return $this->db->select("P.DepartamentoFisico as Depto, P.CelulaPorcentaje ", false)
                            ->from('empleados AS P')->where("P.Numero", $Empleado)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccion($Fraccion, $Estilo) {
        try {
            return $this->db->select("P.CostoMO AS Precio ", false)
                            ->from('fraccionesxestilo AS P')
                            ->where("P.Estilo", $Estilo)->where("P.Fraccion", $Fraccion)->where_in('P.Estatus', 'ACTIVO')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesByEstilo($Estilo) {
        try {
            return $this->db->select("CAST(P.Fraccion AS SIGNED ) AS Clave, CONCAT(P.Fraccion,' - ',IFNULL(F.Descripcion,'')) AS Fraccion ", false)
                            ->from('fraccionesxestilo AS P')->join('fracciones F', 'ON F.Clave = P.Fraccion')
                            ->where("P.Estilo", $Estilo)->where_in('P.Estatus', 'ACTIVO')->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("CAST(E.numero AS SIGNED ) AS Clave, "
                                    . "CONCAT(E.numero,' ',E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Empleado ")
                            ->from("empleados AS E")->where_in("E.FijoDestajoAmbos", array("2", "3"))->where("E.altabaja", "1")->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
