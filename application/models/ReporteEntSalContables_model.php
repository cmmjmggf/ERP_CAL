<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteEntSalContables_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* REPORTE ENT SAL CONTABLES */

    public function getArticulosByProveedor($fecha, $aFecha, $Texto_Mes_Anterior, $Texto_Mes_Act_Query) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT concat($Texto_Mes_Anterior,'-',P$Texto_Mes_Anterior,'-',$Texto_Mes_Act_Query) FROM articulos WHERE Clave = MA.Articulo) AS Saldos,  "
                                    //. "(SELECT  FROM articulos WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    //. "(SELECT $Texto_Mes_Act_Query FROM articulos WHERE Clave = MA.Articulo) AS SaldoFisico, "
                                    . "MA.Articulo AS ClaveArt, "
                                    . "A.Descripcion AS Articulo, "
                                    . "U.Descripcion AS Unidad "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by('MA.Articulo')
                            ->order_by("cast(MA.Articulo as signed)", 'ASC')
                            ->order_by("MA.Articulo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedor($fecha, $aFecha, $Texto_Mes_Anterior) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select(""
                                    // . "(SELECT $Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS SaldoInicial,  "
                                    // . "(SELECT P$Texto_Mes_Anterior FROM articulos WHERE Clave = MA.Articulo) AS PrecioInicial, "
                                    . "MA.Articulo AS ClaveArt, A.Descripcion AS Articulo, "
                                    . "MA.DocMov, MA.OrdenCompra,"
                                    . "MA.Maq, MA.Sem, MA.TipoMov, MA.FechaMov, MA.PrecioMov, MA.Subtotal,"
                                    //. "CONCAT(P.Clave,' ',P.NombreF) AS Proveedor,"
                                    . "(select concat(Clave,' ',NombreF) from proveedores where clave = MA.Proveedor) as Proveedor,"
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
                            //->join("proveedores AS P", "ON MA.Proveedor = P.Clave ", 'left')
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("cast(MA.Articulo as signed)", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosReporte($fecha, $aFecha, $Texto_Mes_Anterior, $Texto_Mes_Act_Query) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("(SELECT concat($Texto_Mes_Anterior,'-',P$Texto_Mes_Anterior,'-',$Texto_Mes_Act_Query) FROM articulos WHERE Clave = MA.Articulo) AS Saldos,  "
                                    . "MA.Articulo AS ClaveArt, A.Descripcion AS Articulo, "
                                    . "MA.DocMov, MA.OrdenCompra,"
                                    . "MA.Maq, MA.Sem, MA.TipoMov, MA.FechaMov, MA.PrecioMov, MA.Subtotal,"
                                    . "(select concat(Clave,' ',NombreF) from proveedores where clave = MA.Proveedor) as Proveedor,"
                                    . "STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") AS FechaOrd,"
                                    . "CASE WHEN MA.EntradaSalida = 1 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Entrada,"
                                    . "CASE WHEN MA.EntradaSalida = 2 THEN
                                        MA.CantidadMov
                                        ELSE 0 END AS Salida, "
                                    . "U.Descripcion AS Unidad "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos AS A", "ON MA.Articulo = A.Clave ")
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("cast(MA.Articulo as signed)", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
