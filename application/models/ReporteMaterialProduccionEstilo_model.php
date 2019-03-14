<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteMaterialProduccionEstilo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getArticulos() {
        try {
            return $this->db->select("CONVERT(A.Clave, UNSIGNED INTEGER) AS Clave , "
                                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->order_by("Clave", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosXDepto($Tipo) {
        try {
            return $this->db->select("CONVERT(A.Clave, UNSIGNED INTEGER) AS Clave , "
                                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->where("A.Departamento", $Tipo)
                            ->order_by("Clave", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporte($Ano, $Sem, $Articulo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("ODP.ControlT, "
                    . "ODP.Estilo, "
                    . "ODP.Color,  "
                    . "ODPD.Articulo, "
                    . "ODPD.ArticuloT ,"
                    . "sum(ODPD.Cantidad) AS Cantidad, "
                    . "ODPD.UnidadMedidaT, "
                    . "ODP.Pares  "
                    . " ", false);
            $this->db->from('ordendeproduccion ODP');
            $this->db->join('ordendeproducciond ODPD', 'ON ODP.ID = ODPD.OrdenDeProduccion');
            $this->db->where('ODP.Ano', $Ano);
            $this->db->where('ODP.Semana', $Sem);
            $this->db->where('ODPD.Articulo', $Articulo);
            $this->db->where('ODPD.Estatus', 'A');
            $this->db->group_by('ODP.ControlT');
            $this->db->order_by('ODP.ControlT', 'ASC');
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

    public function onImprimirReporteDesglosado($Ano, $dSem, $aSem, $Articulo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("ODP.ControlT, "
                    . "ODP.Clave,  "
                    . "ODP.Cliente,  "
                    . "ODP.FechaEntrega,  "
                    . "ODP.Pedido,  "
                    . "ODP.Semana,  "
                    . "ODP.Maquila,  "
                    . "ODP.Estilo, "
                    . "ODP.Color,  "
                    . "ODPD.Articulo, "
                    . "ODPD.ArticuloT ,"
                    . "sum(ODPD.Cantidad) AS Cantidad, "
                    . "ODPD.UnidadMedidaT, "
                    . "ODP.Pares  "
                    . " ", false);
            $this->db->from('ordendeproduccion ODP');
            $this->db->join('ordendeproducciond ODPD', 'ON ODP.ID = ODPD.OrdenDeProduccion');
            $this->db->where('ODP.Ano', $Ano);
            $this->db->where("ODP.Semana BETWEEN $dSem AND $aSem");
            $this->db->where('ODPD.Articulo', $Articulo);
            $this->db->where('ODPD.Estatus', 'A');
            $this->db->group_by('ODP.ControlT');
            $this->db->order_by('ODP.ControlT', 'ASC');
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

}
