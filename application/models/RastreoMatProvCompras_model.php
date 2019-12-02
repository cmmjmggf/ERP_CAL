<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class RastreoMatProvCompras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Proveedor, $Articulo) {
        try {
            $this->db->select(""
                    . "MA.DocMov AS Doc, "
                    . "MA.FechaMov AS Fecha, "
                    . "MA.OrdenCompra AS OC, "
                    . "MA.Tp, "
                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo, "
                    . "MA.CantidadMov AS Cantidad, "
                    . "MA.PrecioMov AS Precio,"
                    . "MA.Subtotal,"
                    . "STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") AS FechaOrd "
                    . "", false);
            $this->db->from("movarticulos MA");
            $this->db->join("articulos A", "ON MA.Articulo = A.Clave ");
            $this->db->where("MA.CantidadMov > 0", null, false);
            $this->db->where("MA.TipoMov", 'EXC');
            $this->db->where("MA.Proveedor", $Proveedor);
            $this->db->where("MA.Articulo", $Articulo);
            $this->db->order_by("FechaOrd", 'ASC');
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

    public function getProveedores() {
        try {
            return $this->db->select("CONVERT(P.Clave, UNSIGNED INTEGER) AS ID, "
                                    . "CONCAT(IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("proveedores AS P")
                            ->order_by("ID", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            return $this->db->select("CONVERT(A.Clave, UNSIGNED INTEGER) AS Clave , "
                                    . "CONCAT(A.Descripcion) AS Articulo "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->order_by("Articulo", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
