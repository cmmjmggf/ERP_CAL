<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesKardex_model extends CI_Model {

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

    public function getDoctosByArticulo($Articulo, $fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT $Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS SaldoInicial,  "
                                    . "(SELECT P$Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    . "G.Clave AS ClaveGrupo, G.Nombre AS NombreGrupo, "
                                    . "MA.Articulo AS ClaveArt, A.Descripcion AS Articulo, "
                                    . "U.Descripcion AS Unidad, "
                                    . "MA.DocMov, MA.OrdenCompra,"
                                    . "MA.Maq, MA.Sem, MA.TipoMov, MA.FechaMov, MA.PrecioMov, MA.Subtotal,"
                                    . "STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") AS FechaOrd,"
                                    . "CASE WHEN MA.EntradaSalida = 1 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Entrada,"
                                    . "CASE WHEN MA.EntradaSalida = 2 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Salida,"
                                    . "CONCAT(P.Clave,' ',P.NombreF) AS Proveedor "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->join("grupos G", "ON G.Clave =  A.Grupo ")
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->join("proveedores P", "ON P.Clave =  MA.Proveedor ", "left")
                            ->like("MA.Articulo", $Articulo)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            // ->order_by("MA.EntradaSalida", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* KARDEX POR PROVEEDOR */

    public function getGruposPorProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("  "
                                    . "CAST(G.Clave AS SIGNED) AS ClaveGrupo, "
                                    . "G.Nombre AS NombreGrupo "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->join("grupos G", "ON G.Clave =  A.Grupo ")
                            ->like("MA.Proveedor", $Proveedor)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            // ->order_by("MA.EntradaSalida", 'ASC')
                            ->group_by('G.Clave')
                            ->order_by("ClaveGrupo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT $Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS SaldoInicial,  "
                                    . "(SELECT P$Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    . "CAST(G.Clave AS SIGNED) AS ClaveGrupo, "
                                    . "G.Nombre AS NombreGrupo, "
                                    . "MA.Articulo AS ClaveArt, "
                                    . "A.Descripcion AS Articulo, "
                                    . "U.Descripcion AS Unidad "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->join("grupos G", "ON G.Clave =  A.Grupo ")
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->like("MA.Proveedor", $Proveedor)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by('ClaveGrupo')
                            ->group_by('MA.Articulo')
                            ->order_by("ClaveGrupo", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT $Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS SaldoInicial,  "
                                    . "(SELECT P$Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    . "CAST(A.Grupo AS SIGNED) AS ClaveGrupo, "
                                    . "MA.Articulo AS ClaveArt, A.Descripcion AS Articulo, "
                                    . "MA.DocMov, MA.OrdenCompra,"
                                    . "MA.Maq, MA.Sem, MA.TipoMov, MA.FechaMov, MA.PrecioMov, MA.Subtotal,"
                                    . "STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") AS FechaOrd,"
                                    . "CASE WHEN MA.EntradaSalida = 1 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Entrada,"
                                    . "CASE WHEN MA.EntradaSalida = 2 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Salida "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->like("MA.Proveedor", $Proveedor)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("ClaveGrupo", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* SubAlmacen por Articulo */

    public function getDoctosSubAlmacenByArticulo($Articulo, $fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT $Texto_Mes_Anterior FROM articulos10 WHERE Clave = MA.Articulo) AS SaldoInicial,  "
                                    . "(SELECT P$Texto_Mes_Anterior FROM articulos10 WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    . "G.Clave AS ClaveGrupo, G.Nombre AS NombreGrupo, "
                                    . "MA.Articulo AS ClaveArt, A.Descripcion AS Articulo, "
                                    . "U.Descripcion AS Unidad, "
                                    . "MA.DocMov, MA.OrdenCompra,"
                                    . "MA.Maq, MA.Sem, MA.TipoMov, MA.FechaMov, MA.PrecioMov, MA.Subtotal,"
                                    . "STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") AS FechaOrd,"
                                    . "CASE WHEN MA.EntradaSalida = 1 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Entrada,"
                                    . "CASE WHEN MA.EntradaSalida = 2 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Salida,"
                                    . "CONCAT(P.Clave,' ',P.NombreF) AS Proveedor "
                                    . " ", false)
                            ->from("movarticulos_fabrica MA")
                            ->join("articulos10 AS A", "ON MA.Articulo = A.Clave ")
                            ->join("grupos G", "ON G.Clave =  A.Grupo ")
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->join("proveedores P", "ON P.Clave =  MA.Proveedor ", "left")
                            ->like("MA.Articulo", $Articulo)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            // ->order_by("MA.EntradaSalida", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
