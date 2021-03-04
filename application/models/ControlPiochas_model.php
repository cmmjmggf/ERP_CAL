<?php

/**
 * Description of ControlesTerminados_model
 *
 * @author Y700
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ControlPiochas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getArticuloConsumoUnidadByPieza($Pieza, $Control) {
        try {
            return $this->db->select("CONCAT(OPD.Articulo,' - ',OPD.ArticuloT) AS Material, OPD.Consumo, OPD.UnidadMedidaT AS Unidad, OPD.Articulo AS ClaveMaterial ")
                            ->from("ordendeproduccion OP")
                            ->join("ordendeproducciond OPD", "ON OPD.OrdenDeProduccion = OP.ID")
                            ->where("OP.controlT", $Control)
                            ->where("OPD.Pieza", $Pieza)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasOrdPrdByControl($Control) {
        try {
            return $this->db->select("CAST(OPD.Pieza AS SIGNED ) AS ID,CONCAT(OPD.Pieza,'-',OPD.PiezaT) AS Pieza")
                            ->from("ordendeproduccion OP")
                            ->join("ordendeproducciond OPD", "ON OPD.OrdenDeProduccion = OP.ID")
                            ->where("OP.controlT", $Control)
                            ->order_by('OPD.PiezaT', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosXDepartamento($Depto) {
        try {
            return $this->db->select("CAST(D.Numero AS SIGNED ) AS ID,CONCAT(D.Numero,'-',D.Busqueda) AS Empleado")
                            ->from("empleados AS D") 
                            ->where("D.AltaBaja", "1")
                            ->where("D.DepartamentoFisico", $Depto)
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXDepartamento($Depto) {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS ID,CONCAT(D.Clave,'-',D.Descripcion) AS Fraccion")
                            ->from("fracciones AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->where("D.Departamento", $Depto)
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS Clave,CONCAT(D.Clave,'-',D.Descripcion) AS Departamento")
                            ->from("departamentos AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->where("D.Tipo", "1")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExistePiocha($Control) {
        try {
            $this->db->select("
                            C.Control "
                            . "")
                    ->from("piochas C")
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

    public function getControl($Control) {
        try {
            $this->db->select("
                            C.Estilo,
                            C.Serie,
                            C.Color,
                            C.Maquila,
                            D.Clave AS Depto "
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

    public function onVeriricarTallas($Serie) {
        try {
            $this->db->select("
                            S.* "
                            . "")
                    ->from("series S")
                    ->where("S.Clave", $Serie);
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

    public function getPiochas() {
        try {
            $this->db->select("
                            P.ID,
                            P.Control,
                            P.Fecha,
                            P.FechaReparacion,
                            P.Estilo,
                            P.Color,
                            P.Departamento,
                            P.Empleado,
                            P.ParteZapato,
                            P.Pieza,
                            P.Fraccion,
                            P.Material,
                            P.Talla,
                            P.Pares,
                            P.Defecto,
                            P.Detalle, "
                            . 'CONCAT(\'<span class="fa fa-user-check fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',P.Control,\')">\',\'</span>\') '
                            . 'AS Eliminar'
                            . "")
                    ->from("piochas P")
                    ->where("P.Estatus", '1')
                    ->where("P.Usuario", $this->session->userdata('USERNAME'));
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

    public function onAgregar($array) {
        try {
            $this->db->insert("piochas", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlParaReparar($Control) {
        try {
            $this->db->select("
                            C.Estatus "
                            . "")
                    ->from("piochas C")
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

    public function onModificarControlPiocha($Control, $DATA) {
        try {
            $this->db->where('Control', $Control)->update("piochas", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
