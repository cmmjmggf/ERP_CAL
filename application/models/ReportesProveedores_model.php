<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesProveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProveedores() {
        try {
            return $this->db->select("P.Clave AS ID, "
                                    . "CONCAT(IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGruposCostoMaterialMaqFecha($fecha, $aFecha, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave, CONCAT(G.Clave,' - ',G.Nombre) AS Grupo  "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->join("grupos G", 'ON G.Clave =  A.Grupo', 'left')
                            ->where("MA.TipoMov", 'SXM')
                            ->where("MA.Maq", $Maq)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by("G.Clave")
                            ->order_by("Clave", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosCostoMaterialMaqFechaPrecioActual($fecha, $aFecha, $Maq) {
        try {
            return $this->db->select("CAST(G.Clave AS SIGNED ) AS ClaveGpo, "
                                    . "A.Clave, "
                                    . "A.Descripcion, "
                                    . "U.Descripcion AS Unidad, "
                                    . "MA.Tp, "
                                    . "MA.CantidadMov, "
                                    . "PM.Precio AS PrecioMov, "
                                    . "(PM.Precio * MA.CantidadMov)AS Subtotal, "
                                    . "MA.DocMov, "
                                    . "MA.FechaMov,"
                                    . "MA.Maq, "
                                    . "MA.Sem "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->join("grupos G", 'ON G.Clave =  A.Grupo', 'left')
                            ->join('unidades U', 'ON U.Clave = A.UnidadMedida')
                            ->join('preciosmaquilas PM', "ON PM.Articulo = MA.Articulo AND PM.Maquila = '$Maq' ")
                            ->where("MA.TipoMov", 'SXM')
                            ->where("MA.Maq", $Maq)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("MA.DocMov", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosCostoMaterialMaqFecha($fecha, $aFecha, $Maq) {
        try {
            return $this->db->select("CAST(G.Clave AS SIGNED ) AS ClaveGpo, "
                                    . "A.Clave, "
                                    . "A.Descripcion, "
                                    . "U.Descripcion AS Unidad, "
                                    . "MA.Tp, "
                                    . "MA.CantidadMov, "
                                    . "MA.PrecioMov, "
                                    . "MA.Subtotal, "
                                    . "MA.DocMov, "
                                    . "MA.FechaMov,"
                                    . "MA.Maq, "
                                    . "MA.Sem "
                                    . " ", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->join("grupos G", 'ON G.Clave =  A.Grupo', 'left')
                            ->join('unidades U', 'ON U.Clave = A.UnidadMedida')
                            ->where("MA.TipoMov", 'SXM')
                            ->where("MA.Maq", $Maq)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("MA.DocMov", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresReporteRecibosEfectivo($fecha, $aFecha) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, "
                                    . "P.NombreF AS ProveedorF ", false)
                            ->from("pagosproveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->where("CP.Estatus", 'ACTIVO')
                            ->where("CP.TipoPago", '1')
                            ->where("STR_TO_DATE(CP.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by("CP.Proveedor")
                            ->order_by("ClaveNum", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocsReporteRecibosEfectivo($fecha, $aFecha) {
        try {
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, "
                                    . "CP.Factura, "
                                    . "CP.Fecha, "
                                    . "CP.Importe, "
                                    . "CP.Tp, "
                                    . "CP.DocPago "
                                    . "", false)
                            ->from("pagosproveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->where("CP.Estatus", 'ACTIVO')
                            ->where("CP.TipoPago", '1')
                            ->where("STR_TO_DATE(CP.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("CP.Tp", 'ASC')
                            ->order_by("CP.Factura", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresReporteRelacionPagos($fecha, $aFecha) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, P.Plazo, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("pagosproveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->where("CP.Estatus", 'ACTIVO')
                            ->where("STR_TO_DATE(CP.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->group_by("CP.Proveedor")
                            ->order_by("ClaveNum", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosByProveedor($fecha, $aFecha) {
        try {
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, "
                                    . "CP.Factura, "
                                    . "CP.Fecha, "
                                    . "CP.Importe, "
                                    . "CP.Tp, "
                                    . "CP.DocPago "
                                    . "", false)
                            ->from("pagosproveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->where("CP.Estatus", 'ACTIVO')
                            ->where("STR_TO_DATE(CP.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$fecha', \"%d/%m/%Y\") AND STR_TO_DATE('$aFecha', \"%d/%m/%Y\")")
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("CP.Tp", 'ASC')
                            ->order_by("CP.Factura", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresReporteAntiguedad($prov, $aprov, $tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, P.Plazo, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("cartera_proveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->like("CP.Tp", $tp)
                            ->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                            ->where("CP.Proveedor BETWEEN $prov AND $aprov  ", null, false)
                            ->group_by("CP.Proveedor")
                            ->order_by("P.NombreF", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedorTpAntiguedad($prov, $aprov, $tp) {
        try {
            return $this->db->select("CAST(CP.Proveedor AS SIGNED ) AS ClaveNum, "
                                    . "CP.Tp,"
                                    . "CP.Doc, "
                                    . "date_format(str_to_date(CP.FechaDoc,'%d/%m/%Y'),'%d/%m/%y') AS FechaDoc, "
                                    . "str_to_date(CP.FechaDoc,'%d/%m/%Y') as FechaOrd,"
                                    . "CP.ImporteDoc, "
                                    . "CP.Pagos_Doc,"
                                    . "CP.Saldo_Doc,"
                                    . 'IFNULL(DATEDIFF(CURDATE(), STR_TO_DATE(CP.FechaDoc , "%d/%m/%Y" )),\'\') AS Dias,'
                                    . "
CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) >= 0
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 8
	THEN CP.Saldo_Doc END AS 'UNO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 7
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 16
	THEN CP.Saldo_Doc END AS 'DOS',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 15
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 22
	THEN CP.Saldo_Doc END AS 'TRES',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 21
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 31
	THEN CP.Saldo_Doc END AS 'CUATRO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 30
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 38
	THEN CP.Saldo_Doc END AS 'CINCO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 37
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 46
	THEN CP.Saldo_Doc END AS 'SEIS',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 45
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 53
	THEN CP.Saldo_Doc END AS 'SIETE',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 52
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 61
	THEN CP.Saldo_Doc END AS 'OCHO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 60
	THEN CP.Saldo_Doc END AS 'NUEVE' "
                                    . ' '
                                    . " "
                                    . "", false)
                            ->from("cartera_proveedores AS CP")
                            ->like("CP.Tp", $tp)
                            ->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                            ->where("CP.Saldo_Doc > 1 ", null, false)
                            ->where("CP.Proveedor BETWEEN $prov AND $aprov  ", null, false)
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("abs(Dias)", 'DESC')
                            ->order_by("CP.Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Extendido */

    public function getDoctosByProveedorTpAntiguedadExt($prov, $aprov, $tp) {
        try {
            return $this->db->select("CAST(CP.Proveedor AS SIGNED ) AS ClaveNum, "
                                    . "CP.Tp,"
                                    . "CP.Doc, "
                                    . "date_format(str_to_date(CP.FechaDoc,'%d/%m/%Y'),'%d/%m/%y') AS FechaDoc, "
                                    . "str_to_date(CP.FechaDoc,'%d/%m/%Y') as FechaOrd,"
                                    . "CP.ImporteDoc, "
                                    . "CP.Pagos_Doc,"
                                    . "CP.Saldo_Doc,"
                                    . 'IFNULL(DATEDIFF(CURDATE(), STR_TO_DATE(CP.FechaDoc , "%d/%m/%Y" )),\'\') AS Dias,'
                                    . "
CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) >= 0
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 60
	THEN CP.Saldo_Doc END AS 'UNO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 59
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 68
	THEN CP.Saldo_Doc END AS 'DOS',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 67
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 76
	THEN CP.Saldo_Doc END AS 'TRES',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 75
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 84
	THEN CP.Saldo_Doc END AS 'CUATRO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 83
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 92
	THEN CP.Saldo_Doc END AS 'CINCO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 91
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 100
	THEN CP.Saldo_Doc END AS 'SEIS',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 99
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 108
	THEN CP.Saldo_Doc END AS 'SIETE',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) > 107
			AND  DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) < 116
	THEN CP.Saldo_Doc END AS 'OCHO',

CASE WHEN DATEDIFF(CURRENT_DATE(), date_format(str_to_date(CP.FechaDoc, '%d/%m/%Y'), '%Y-%m-%d')) >= 116
	THEN CP.Saldo_Doc END AS 'NUEVE' "
                                    . ' '
                                    . " "
                                    . "", false)
                            ->from("cartera_proveedores AS CP")
                            ->like("CP.Tp", $tp)
                            ->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                            ->where("CP.Saldo_Doc > 1 ", null, false)
                            ->where("CP.Proveedor BETWEEN $prov AND $aprov  ", null, false)
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("abs(Dias)", 'DESC')
                            ->order_by("CP.Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresReporte($prov, $aprov, $tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum, P.Plazo, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("cartera_proveedores AS CP")
                            ->join("proveedores AS P", 'ON P.Clave =  CP.Proveedor')
                            ->like("CP.Tp", $tp)
                            ->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                            ->where("CP.Proveedor BETWEEN $prov AND $aprov  ", null, false)
                            ->group_by("CP.Proveedor")
                            ->order_by("ClaveNum", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedorTp($prov, $aprov, $tp) {
        try {
            return $this->db->select("CAST(CP.Proveedor AS SIGNED ) AS ClaveNum, CP.Tp,"
                                    . "CP.Doc, CP.FechaDoc, CP.ImporteDoc, CP.Pagos_Doc,"
                                    . "CP.Saldo_Doc,"
                                    . 'IFNULL(DATEDIFF(CURDATE(), STR_TO_DATE(CP.FechaDoc , "%d/%m/%Y" )),\'\') AS Dias '
                                    . " "
                                    . "", false)
                            ->from("cartera_proveedores AS CP")
                            ->like("CP.Tp", $tp)
                            ->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                            ->where("CP.Saldo_Doc > 1 ")
                            ->where("CP.Proveedor BETWEEN $prov AND $aprov  ", null, false)
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("CP.Tp", 'ASC')
                            ->order_by("Dias", 'DESC')
                            ->order_by("CP.Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("G.Clave, G.Direccion")->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
