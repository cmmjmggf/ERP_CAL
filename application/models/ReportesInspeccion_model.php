<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesInspeccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProveedores() {
        try {
            return $this->db->select("CONVERT(P.Clave, UNSIGNED INTEGER) AS ID, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
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
                                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->order_by("Clave", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function getProveedoresReporteInspeccion($Prov, $Articulo, $Tp, $fecha, $aFecha) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum,  "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS Proveedor "
                                    . " ", false)
                            ->from("recepcionmat_inspeccion AS RI")
                            ->join("proveedores AS P", 'ON P.Clave =  RI.Proveedor')
                            ->like("RI.Tp", $Tp)
                            ->like("RI.Proveedor", $Prov)
                            ->like("RI.Articulo", $Articulo)
                            ->where_in("RI.Estatus", array('ACTIVO'))
                            ->where("STR_TO_DATE(RI.FechaFactura, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by("P.Clave")
                            ->order_by("ClaveNum", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedor($Prov, $Articulo, $Tp, $fecha, $aFecha) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(RI.Proveedor AS SIGNED ) AS ClaveNum,  "
                                    . "RI.OrdenCompra,"
                                    . "RI.Factura,"
                                    . "RI.Articulo,"
                                    . "A.Descripcion As ArtDesc,"
                                    . "RI.Articulo,"
                                    . "RI.Precio,"
                                    . "RI.Cantidad,"
                                    . "RI.CantidadDevuelta,"
                                    . "(RI.Cantidad - RI.CantidadDevuelta) AS Cant_Real,"
                                    . "RI.Aprovechamiento,"
                                    . "RI.NumHojas,"
                                    . "(RI.Cantidad - RI.CantidadDevuelta) / RI.NumHojas AS Por_Hoj ,"
                                    . "RI.HojasRevisadas,"
                                    . "D.Descripcion AS Defecto,"
                                    . "RI.Primera,"
                                    . "RI.Segunda,"
                                    . "RI.Tercera,"
                                    . "RI.Cuarta,"
                                    . "RI.PartidaIni,"
                                    . "RI.PartidaFin "
                                    . " ", false)
                            ->from("recepcionmat_inspeccion AS RI")
                            ->join("articulos AS A", "ON RI.Articulo = A.Clave ")
                            ->join("defectos AS D", "ON RI.Defecto = D.Clave ", "left")
                            ->like("RI.Tp", $Tp)
                            ->like("RI.Proveedor", $Prov)
                            ->like("RI.Articulo", $Articulo)
                            ->where_in("RI.Estatus", array('ACTIVO'))
                            ->where("STR_TO_DATE(RI.FechaFactura, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("RI.Factura", 'ASC')
                            ->order_by("RI.Articulo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
