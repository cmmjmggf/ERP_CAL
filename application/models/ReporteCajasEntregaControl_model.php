<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteCajasEntregaControl_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getArticulosReporte($FechaIni, $FechaFin) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("OPD.Articulo, OPD.ArticuloT ", false)
                            ->from("avance AV")
                            ->join("ordendeproduccion OP", 'ON OP.ControlT = AV.Control')
                            ->join("ordendeproducciond OPD", "ON OPD.OrdenDeProduccion = OP.ID AND OPD.Grupo = '14' ")
                            ->where("AV.Departamento < 240 ", null, false)
                            ->where("STR_TO_DATE(AV.FechaAvance, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                            ->group_by("OPD.ArticuloT")
                            ->order_by("OPD.ArticuloT", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleArticulosReporte($FechaIni, $FechaFin) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("AV.Control, OPD.Articulo, OPD.ArticuloT, OPD.Cantidad, OPD.UnidadMedidaT ", false)
                            ->from("avance AV")
                            ->join("ordendeproduccion OP", 'ON OP.ControlT = AV.Control')
                            ->join("ordendeproducciond OPD", "ON OPD.OrdenDeProduccion = OP.ID AND OPD.Grupo = '14' ")
                            ->where("AV.Departamento < 240 ", null, false)
                            ->where("STR_TO_DATE(AV.FechaAvance, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                            ->group_by("AV.Control")
                            ->order_by("OPD.ArticuloT", 'ASC')
                            ->order_by("AV.Control", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
