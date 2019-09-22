<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesCompras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTotalGrupoReporte($FechaIni, $FechaFin, $Tp, $Grupo) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(A.Grupo AS SIGNED) AS ClaveGrupo, sum(C.Cantidad) AS TotalGrupo   ", false)
                            ->from("compras C")
                            ->join("articulos A", 'ON A.Clave =  C.Articulo')
                            ->where("C.Estatus", 'CONCLUIDA')
                            ->like("C.Tp ", $Tp)
                            ->where("A.Grupo ", $Grupo)
                            ->where("STR_TO_DATE(C.FechaDoc, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                            ->group_by("A.Grupo")
                            ->order_by("ClaveGrupo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGruposReporte($FechaIni, $FechaFin, $Tp, $Grupo, $Articulo) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(G.Clave AS SIGNED) AS ClaveGrupo, G.Nombre AS NombreGrupo  ", false)
                    ->from("compras C")
                    ->join("articulos A", 'ON A.Clave =  C.Articulo')
                    ->join("grupos G", "ON G.Clave = A.Grupo ")
                    ->where("C.Estatus", 'CONCLUIDA')
                    ->like("C.Tp ", $Tp);

            if ($Grupo !== '') {
                $this->db->where("A.Grupo ", $Grupo);
            }

            if ($Articulo !== '') {

                $this->db->where("C.Articulo ", $Articulo);
            }

            $this->db->where("STR_TO_DATE(C.FechaDoc, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            return $this->db->group_by("G.Clave")
                            ->group_by("G.Nombre")
                            ->order_by("ClaveGrupo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosReporte($FechaIni, $FechaFin, $Tp, $Grupo, $Articulo) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(A.Grupo AS SIGNED) AS ClaveGrupo, A.Clave, A.Descripcion,U.Descripcion AS Unidad, sum(C.Cantidad) AS Cantidad  ", false)
                    ->from("compras C")
                    ->join("articulos A", 'ON A.Clave =  C.Articulo')
                    ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                    ->where("C.Estatus", 'CONCLUIDA')
                    ->like("C.Tp ", $Tp);
            if ($Grupo !== '') {
                $this->db->where("A.Grupo ", $Grupo);
            }

            if ($Articulo !== '') {

                $this->db->where("C.Articulo ", $Articulo);
            }
            $this->db->where("STR_TO_DATE(C.FechaDoc, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            return $this->db->group_by("A.Clave")
                            ->order_by("ClaveGrupo", 'ASC')
                            ->order_by("sum(C.Cantidad)", 'DESC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Compras Generales */

    public function getProveedoresReporte($FechaIni, $FechaFin, $Tp, $Tipo) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(P.Clave AS SIGNED) AS ClaveProveedor,"
                            . "CASE WHEN CP.Tp = '1' THEN P.NombreF  "
                            . "ELSE P.NombreI "
                            . "END AS NombreProveedor"
                            . "  ", false)
                    ->from("cartera_proveedores CP")
                    ->join("proveedores P", 'ON P.Clave =  CP.Proveedor')
                    ->like("CP.Tp ", $Tp)
                    ->where_in("CP.Estatus ", array('SIN PAGAR', 'PAGADO', 'PENDIENTE'))
                    ->where("STR_TO_DATE(CP.FechaDoc, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);

            if ($Tipo === '0') {
                $this->db->where("DocDirecto", '1');
            }
            if ($Tipo === '') {

            }
            if ($Tipo !== '' && $Tipo !== '0') {
                $this->db->like("CP.Departamento", $Tipo);
            }

            return $this->db->group_by("P.Clave")
                            ->order_by("ClaveProveedor", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosReporte($FechaIni, $FechaFin, $Tp, $Tipo) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(P.Clave AS SIGNED) AS ClaveProveedor,"
                            . "CASE WHEN CP.Tp = '1' THEN P.NombreF  "
                            . "ELSE P.NombreI "
                            . "END AS NombreProveedor,"
                            . "CP.FechaDoc,"
                            . "CP.Doc,"
                            . "CP.ImporteDoc,"
                            . "CP.Pagos_Doc,"
                            . "CP.Saldo_Doc"
                            . "  ", false)
                    ->from("cartera_proveedores CP")
                    ->join("proveedores P", 'ON P.Clave =  CP.Proveedor')
                    ->like("CP.Tp ", $Tp)
                    ->where_in("CP.Estatus ", array('SIN PAGAR', 'PAGADO', 'PENDIENTE'))
                    ->where("STR_TO_DATE(CP.FechaDoc, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            if ($Tipo === '0') {
                $this->db->where("DocDirecto", '1');
            }
            if ($Tipo === '') {

            }
            if ($Tipo !== '' && $Tipo !== '0') {
                $this->db->like("CP.Departamento", $Tipo);
            }
            return $this->db->order_by("ClaveProveedor", 'ASC')
                            ->order_by("CP.Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Desglose de compras por fecha */

    public function getArticulosReporteGeneralDesgloce($Doc, $Proveedor, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select(" A.Clave, A.Descripcion AS Articulo, U.Descripcion AS Unidad, C.Cantidad, C.Precio, C.Subtotal, "
                                    . "CASE WHEN C.Tp = '1' THEN C.Subtotal * 0.16 ELSE 0 END AS Iva, "
                                    . "CASE WHEN C.Tp = '1' THEN C.Subtotal * 1.16 ELSE C.Subtotal END AS Total "
                                    . "  ", false)
                            ->from("compras C")
                            ->join("articulos A", 'ON A.Clave =  C.Articulo')
                            ->join("unidades U", 'ON U.Clave =  A.UnidadMedida')
                            ->where("C.Doc ", $Doc)
                            ->where("C.Proveedor ", $Proveedor)
                            ->where("C.Tp ", $Tp)
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte Devoluciones */

    public function getProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(P.Clave AS SIGNED) AS ClaveProveedor,"
                            . "CASE WHEN NC.Tp = '1' THEN P.NombreF  "
                            . "ELSE P.NombreI "
                            . "END AS NombreProveedor"
                            . "  ", false)
                    ->from("notascreditoprov NC")
                    ->join("proveedores P", 'ON P.Clave =  NC.Proveedor')
                    ->like("NC.Tp ", $Tp)
                    ->where("NC.Estatus ", 2)
                    ->where("STR_TO_DATE(NC.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            return $this->db->group_by("P.Clave")
                            ->order_by("ClaveProveedor", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocsProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(NC.Proveedor AS SIGNED) AS ClaveProveedor, CAST(NC.DocCartProv AS SIGNED) AS DocCartProv  "
                            . "  ", false)
                    ->from("notascreditoprov NC")
                    ->like("NC.Tp ", $Tp)
                    ->where("NC.Estatus ", 2)
                    ->where("STR_TO_DATE(NC.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            return $this->db->group_by("NC.Proveedor")
                            ->group_by("NC.DocCartProv")
                            ->order_by("ClaveProveedor", 'ASC')
                            ->order_by("DocCartProv", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleDocsProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(NC.Proveedor AS SIGNED) AS ClaveProveedor, CAST(NC.DocCartProv AS SIGNED) AS DocCartProv,"
                            . "NC.Folio, "
                            . "NC.Fecha, "
                            . "NC.DocCartProv, "
                            . "NC.Cantidad, "
                            . "A.Descripcion AS Articulo, "
                            . "NC.Concepto, "
                            . "NC.Precio, "
                            . "NC.Subtotal "
                            . "  ", false)
                    ->from("notascreditoprov NC")
                    ->join("articulos A", 'ON A.Clave =  NC.Articulo')
                    ->like("NC.Tp ", $Tp)
                    ->where("NC.Estatus ", 2)
                    ->where("STR_TO_DATE(NC.Fecha, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false);
            return $this->db->order_by("ClaveProveedor", 'ASC')
                            ->order_by("DocCartProv", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte Movimientos Almacen */

    public function getGruposMovimientosAlmacen($FechaIni, $FechaFin) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(G.Clave AS SIGNED) AS ClaveGrupo, G.Nombre AS NombreGrupo  ", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave =  MA.Articulo')
                            ->join("grupos G", "ON G.Clave = A.Grupo ")
                            ->where("MA.CantidadMov > 0", null, false)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                            ->group_by("G.Clave")
                            ->group_by("G.Nombre")
                            ->order_by("ClaveGrupo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosMovimientosAlmacen($FechaIni, $FechaFin, $Grupo) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(A.Grupo AS SIGNED) AS ClaveGrupo,"
                                    . "A.Clave, "
                                    . "A.Descripcion AS Articulo,  "
                                    . "U.Descripcion AS Unidad,"
                                    . "MA.FechaMov, "
                                    . "MA.PrecioMov,"
                                    . "MA.CantidadMov,"
                                    . "MA.Subtotal,"
                                    . "MA.DocMov,"
                                    . "MA.TipoMov"
                                    . "", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave =  MA.Articulo')
                            ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                            ->where("MA.CantidadMov > 0", null, false)
                            ->where("A.Grupo", $Grupo)
                            ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                            ->order_by("ClaveGrupo", 'ASC')
                            ->order_by("abs(A.Clave)", 'ASC')
                            ->order_by("MA.TipoMov", 'ASC')
                            ->order_by("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") ASC ")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte Venta Fabrica sin Desgloce */

    public function getMaquilasReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->order_by("Maquila", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentosReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento  "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento, CAST(MA.DocMov AS SIGNED) AS Doc,"
                            . "SUM(MA.Subtotal) AS Subtotal, MA.Sem  "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->group_by("MA.DocMov")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->order_by("Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Para el desgloce */

    public function getSemanasReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento, "
                            . "CAST(MA.Sem AS SIGNED) AS Sem  "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->group_by("MA.Sem")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->order_by("Sem", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento, "
                            . "CAST(MA.Sem AS SIGNED) AS Sem, CAST(MA.DocMov AS SIGNED) AS Doc  "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->group_by("MA.Sem")
                            ->group_by("MA.DocMov")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->order_by("Sem", 'ASC')
                            ->order_by("Doc", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGruposArticulosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento, "
                            . "CAST(MA.Sem AS SIGNED) AS Sem, CAST(MA.DocMov AS SIGNED) AS Doc ,"
                            . "CAST(A.Grupo AS SIGNED) AS ClaveGrupo, G.Nombre AS NombreGrupo  "
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->join("grupos G", "ON G.Clave = A.Grupo ")
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->group_by("MA.Sem")
                            ->group_by("MA.DocMov")
                            ->group_by("A.Grupo")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->order_by("Sem", 'ASC')
                            ->order_by("Doc", 'ASC')
                            ->order_by("ClaveGrupo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq) {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select("CAST(MA.Maq AS SIGNED) AS Maquila, CAST(A.Departamento AS SIGNED) AS Departamento, "
                            . "CAST(MA.Sem AS SIGNED) AS Sem, CAST(MA.DocMov AS SIGNED) AS Doc ,"
                            . "CAST(A.Grupo AS SIGNED) AS ClaveGrupo, "
                            . "A.Clave AS ClaveArt,"
                            . "A.Descripcion AS Articulo,"
                            . "U.Descripcion AS Unidad,"
                            . "MA.FechaMov,"
                            . "sum(MA.CantidadMov) AS CantidadMov,"
                            . "MA.PrecioMov,"
                            . "sum(MA.Subtotal) AS Subtotal"
                            . "  ", false)
                    ->from("movarticulos MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->join("unidades U", "ON U.Clave = A.UnidadMedida ")
                    ->where("STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FechaIni', \"%d/%m/%Y\") AND STR_TO_DATE('$FechaFin', \"%d/%m/%Y\") ", null, false)
                    ->where("MA.CantidadMov > 0", null, false)
                    ->like('MA.Sem', $Sem)
                    ->like('MA.Maq', $Maq);


            if ($Tipo === '0') {
                $this->db->where("MA.TipoMov", 'DIRECTO');
            }
            if ($Tipo === '1') {
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC', 'DIRECTO'));
            }
            if ($Tipo !== '' && $Tipo !== '0' && $Tipo !== '1') {
                $this->db->like("A.Departamento", $Tipo);
                $this->db->where_in("MA.TipoMov ", array('SXM', 'SPR', 'SXP', 'SXC'));
            }

            return $this->db->group_by("MA.Maq")
                            ->group_by("A.Departamento")
                            ->group_by("MA.Sem")
                            ->group_by("MA.DocMov")
                            ->group_by("A.Grupo")
                            ->group_by("A.Clave")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Departamento", 'ASC')
                            ->order_by("Sem", 'ASC')
                            ->order_by("Doc", 'ASC')
                            ->order_by("ClaveGrupo", 'ASC')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
