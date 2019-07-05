<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Empleados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUltimo() {
        try {
            return $this->db->select("CAST(E.Numero as signed) AS Numero")->from("empleados AS E")
                            ->where('Numero < 5555', null, false)
                            ->order_by("Numero", "DESC")
                            ->limit(1)
                            ->get()
                            ->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoEmpleadoZapTda($ID) {
        try {
            return $this->db->select("E.ZapatosTDA, datediff(now(),E.FechaIngreso) as DiasAlta  ", false)
                            ->from('empleados AS E')
                            ->where('E.Numero', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadoByNumeroExt($ID) {
        try {
            return $this->db->select("E.Ahorro", false)
                            ->from('empleados AS E')
                            ->where('E.Numero', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosComidas() {
        try {
            return $this->db->select("E.Numero AS Clave, "
                                    . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Nombre, "
                                    . "E.Comida "
                                    . "  ", false)
                            ->from('empleados AS E')->where('E.Comida > 0', null, false)->where('E.altabaja', 1)->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosComidasSelect() {
        try {
            return $this->db->select("E.Numero AS Clave, "
                                    . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Nombre, "
                                    . " "
                                    . "  ", false)
                            ->from('empleados AS E')->where('E.altabaja', 1)->where('E.Comedor', 1)->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosCajaAhorro() {
        try {
            return $this->db->select("E.Numero AS Clave, "
                                    . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Nombre, "
                                    . "E.Ahorro, E.SaldoPres, E.PressAcum, E.AbonoPres "
                                    . "  ", false)
                            ->from('empleados AS E')->where('E.Ahorro > 0', null, false)->where('E.altabaja', 1)->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords($Estatus) {
        try {
            $this->db->select("E.ID, "
                            . "E.Numero AS No, "
                            . "E.NumFis, E.Egresos, E.Activos, "
                            . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS Nombre, "
                            . "E.Busqueda, "
                            . "E.Direccion AS Dire, "
                            . "E.Colonia AS Col, "
                            . "E.Ciudad AS Ciu, "
                            . "E.Estado, "
                            . "E.CP, "
                            . "E.RFC, E.CURP, E.NoIMSS AS Seg, "
                            . "date_format(str_to_date(E.FechaIngreso,'%Y-%m-%d'),'%d/%m/%Y') as FechaIngreso, "
                            . "E.Nacimiento, "
                            . "E.FechaIMSS, "
                            . "E.Sexo, E.EstadoCivil, E.Tel, E.Cel, E.DepartamentoFisico, E.DepartamentoCostos, "
                            . "E.AltaBaja, E.Puesto, E.Tarjeta, E.Egreso, E.Comedor, E.TBanamex, E.TBanbajio, "
                            . "E.FijoDestajoAmbos, E.CuentaBB, E.Beneficiario, E.Parentesco, E.Porcentaje, "
                            . "E.Sueldo, E.IMSS, E.Fierabono, E.Infonavit, E.Ahorro, E.PressAcum, E.AbonoPres, "
                            . "E.SaldoPres, E.Comida, E.Celula, E.CelulaPorcentaje, E.Funeral, E.SueldoFijo, "
                            . "E.SalarioDiarioIMSS, E.ZapatosTDA, E.AbonoZap, E.Fonacot, E.EntregaDeMaterialYPrecio, "
                            . "E.Foto, E.Registro, E.Estatus ", false)
                    ->from('empleados AS E');
            if ($Estatus === '1') {
                $this->db->where('E.altabaja', '1');
            } else {
                $this->db->where_in('E.altabaja', array('1', '2'));
            }


            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadoByID($ID) {
        try {
            return
                            $this->db->select("E.ID, "
                                    . "E.Numero, "
                                    . "E.NumFis, "
                                    . "E.Egresos, "
                                    . "E.Activos, "
                                    . "E.PrimerNombre, "
                                    . "E.SegundoNombre,"
                                    . "E.Paterno, "
                                    . "E.Materno, "
                                    . "E.Busqueda, "
                                    . "E.Direccion, "
                                    . "E.Colonia, "
                                    . "E.Ciudad, "
                                    . "E.Estado, "
                                    . "E.CP, "
                                    . "E.RFC, "
                                    . "E.CURP, "
                                    . "E.NoIMSS, "
                                    . "date_format(str_to_date(E.FechaIngreso,'%Y-%m-%d'),'%d/%m/%Y') as FechaIngreso, "
                                    . "date_format(str_to_date(E.Nacimiento,'%Y-%m-%d'),'%d/%m/%Y') as Nacimiento, "
                                    . "date_format(str_to_date(E.FechaIMSS,'%Y-%m-%d'),'%d/%m/%Y') as FechaIMSS, "
                                    . "E.Sexo, E.EstadoCivil, E.Tel, E.Cel, E.DepartamentoFisico, E.DepartamentoCostos, "
                                    . "E.AltaBaja, E.Puesto, E.Tarjeta, E.Egreso, E.Comedor, E.TBanamex, E.TBanbajio, "
                                    . "E.FijoDestajoAmbos, E.CuentaBB, E.Beneficiario, E.Parentesco, E.Porcentaje, "
                                    . "E.Sueldo, E.IMSS, E.Fierabono, E.Infonavit, E.Ahorro, E.PressAcum, E.AbonoPres, "
                                    . "E.SaldoPres, E.Comida, E.Celula, E.CelulaPorcentaje, E.Funeral, E.SueldoFijo, "
                                    . "E.SalarioDiarioIMSS, E.ZapatosTDA, E.AbonoZap, E.Fonacot, E.EntregaDeMaterialYPrecio, "
                                    . "E.Foto AS FOTOEMPLEADO, E.Registro, E.Estatus, E.Incapacitado, E.FechaIncapacidad, E.FechaIncapacidadFin, E.MotivoBaja ", false)
                            ->from('empleados AS E')->where('E.ID', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadoByNumero($ID) {
        try {
            return $this->db->select("E.ID, E.Numero, "
                                    . "CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS NOMBRE_COMPLETO, E.Foto, "
                                    . "D.Descripcion AS DEPARTAMENTO", false)
                            ->from('empleados AS E')
                            ->join('departamentos AS D', 'D.Clave = E.DepartamentoFisico')
                            ->where('E.Numero', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosByDepartamentos($dDepto, $ADepto) {
        try {
            return $this->db->select("E.ID, E.Numero as NUMERO, "
                                    . "CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS NOMBRE_COMPLETO, E.Foto, "
                                    . "D.Descripcion AS DEPARTAMENTO", false)
                            ->from('empleados AS E')
                            ->join('departamentos AS D', 'D.Clave = E.DepartamentoFisico')
                            ->where('E.AltaBaja', '1')
                            ->where("cast(E.DepartamentoFisico as signed) between $dDepto and $ADepto ", null, false)
                            ->order_by('cast(E.DepartamentoFisico as signed)', 'ASC')
                            ->order_by('NUMERO', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("empleados", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstados() {
        try {
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ID, CONCAT(P.Clave,' - ',IFNULL(P.Descripcion,'')) AS Estado ", false)
                            ->from('estados AS P')->where_in('P.Estatus', 'ACTIVO')->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS Clave, CONCAT(D.Clave,' - ',D.Descripcion) AS Departamento")
                            ->from("departamentos AS D")->where("D.Estatus", "ACTIVO")->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
