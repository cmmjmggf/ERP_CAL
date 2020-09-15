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
            $this->db->select("FPN.numeroempleado, FPN.control, FPN.numfrac, FPN.preciofrac, FPN.estilo,concat(F.Clave,' ',F.Descripcion) as nomfrac, "
                            . "date_format(FPN.fecha,'%d/%m/%Y') as fecha, FPN.semana, FPN.pares, cast(FPN.subtot as decimal(10,2)) as subtot "
                            . "")
                    ->from("fracpagnomina FPN")
                    ->join("fracciones F", 'on F.Clave = FPN.numfrac ');
            if ($Control !== '') {
                $this->db->where('FPN.control', $Control);
            }
            if ($Ano !== '') {
                $this->db->where('FPN.anio', $Ano);
            }
            if ($Sem !== '') {
                $this->db->where('FPN.semana', $Sem);
            }
            if ($Empleado !== '') {
                $this->db->where('FPN.numeroempleado', $Empleado);
            }
            $this->db->limit(900);
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

    public function getConceptosNominaRastreo($Ano, $Empleado) {
        try {
            $this->db->select("PN.numsem, "
                            . "PN.numemp, "
                            . "PN.numcon, "
                            . " date_format(PN.fecha, '%d/%m/%Y') as fecha, "
                            . " (case when PN.tpcon = 1 then PN.tpcon else PN.tpcond end) as PerDed , "
                            . " cast((case when PN.tpcon = 1 then PN.importe else -PN.imported end)as decimal(10,2)) as Importe "
                            . " ")
                    ->from("prenomina PN")
                    ->where('PN.Año', $Ano)
                    ->where('PN.numemp', $Empleado)
                    ->limit(900);
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

    public function getRecords($Ano, $Sem, $Empl) {
        try {
            $this->db->select("ID, numeroempleado, semana, date_format(fecha,'%d/%m/%Y') as fecha, control, estilo ,numfrac, pares, "
                            . 'CONCAT(\'<span class="fa fa-times fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',numeroempleado,\',\',control,\',\',numfrac,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("fracpagnomina")
                    ->where("anio", $Ano)->where("semana", $Sem)->where("numeroempleado", $Empl);
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
                            C.DeptoProduccion AS Depto,
                            C.EstatusProduccion AS DeptoT,
                            C.Estilo Estilo,
                            C.Color AS Color,
                            C.Maquila AS Maquila,
                            C.Pares "
                            . "")
                    ->from("pedidox C")
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
            return $this->db->select("CAST(P.Fraccion AS SIGNED ) AS Clave, CONCAT(IFNULL(F.Descripcion,'')) AS Fraccion ", false)
                            ->from('fraccionesxestilo AS P')->join('fracciones F', 'ON F.Clave = P.Fraccion')
                            ->where("P.Estilo", $Estilo)->where_in('P.Estatus', 'ACTIVO')->order_by('Fraccion', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("CAST(E.numero AS SIGNED ) AS Clave, "
                                    . " CONCAT(E.Busqueda) AS Empleado ")
                            ->from("empleados AS E")->where_in("E.FijoDestajoAmbos", array("2", "3"))->where("E.altabaja", "1")
                            ->or_where("E.Numero between 899 and 1006", null, false)
                            ->order_by('Empleado', 'ASC')
                            ->get()->result();
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
                            ->from("conceptosnomina AS E")->where("E.Estatus", "ACTIVO")->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
