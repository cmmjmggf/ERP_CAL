<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteCapturaFisica_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getInfoArticulo($Articulo, $Maq, $Mes) {
        try {
            return $this->db->select("U.Descripcion AS Unidad, A.$Mes AS ExistenciaCapturada, PM.Precio "
                                    . " "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->join("unidades AS U", "ON A.UnidadMedida = U.Clave")
                            ->join("preciosmaquilas AS PM", "ON PM.Articulo = A.Clave")
                            ->where("A.Clave", $Articulo)
                            ->where("PM.Maquila", '1') /* Se toma el precio de la maquila 1 ya que somos los unicos que hacemos inventario */
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosParaConteoFisico() {
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

    public function getGrupos() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave, G.Nombre "
                            . "")
                    ->from("articulos A")
                    ->join("grupos G", 'ON A.Grupo = G.Clave')
//                    ->where("ifnull(A.Pinvini,0) > 0 and ifnull(A.Invini,0) > 0 ", null, false)
                    ->group_by("G.Clave")
                    ->group_by("G.Nombre")
                    ->order_by('Clave', 'ASC');
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

    public function getArticulos() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select(""
                            . "CAST(A.Grupo AS SIGNED ) AS Grupo,"
                            . "A.Clave, "
                            . "A.Descripcion, "
                            . "U.Descripcion AS Unidad "
                            . "")
                    ->from("articulos A")
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
//                    ->where("ifnull(A.Pinvini,0) > 0 and ifnull(A.Invini,0) > 0 ", null, false)
                    ->order_by('Grupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');

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

    /* Comparativo inv fisico VS inv sis */

    public function getDetalleReporteComparativo($Tipo, $Mes, $Maq, $Ano, $Texto_Mes, $Mes_Anterior) {
        try {
            $tabla_movs = 'movarticulos';

            if ($Maq === 'articulos10') {
                $tabla_movs = 'movarticulos_fabrica';
            }

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED ) AS ClaveGrupo, "
                            . "A.Clave AS Codigo, "
                            . "A.Descripcion AS Articulo, "
                            . "U.Descripcion AS Unidad, "
                            . "A.$Mes_Anterior AS MesAnterior,  "
                            . "(SELECT SUM(CantidadMov) FROM $tabla_movs WHERE EntradaSalida = 1 "
                            . "AND MONTH(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Ano "
                            . "AND Articulo = A.Clave) AS Entradas, "
                            . "(SELECT SUM(CantidadMov) FROM $tabla_movs WHERE EntradaSalida = 2 "
                            . "AND MONTH(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Ano "
                            . "AND Articulo = A.Clave) AS Salidas, "
                            . "A.$Texto_Mes AS MesActual,"
                            . "ifnull(PM.Precio,0) AS Precio,"
                            . "A.Departamento "
                            . "")
                    ->from("$Maq A")
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida', "left")
                    ->join("preciosmaquilas PM", "ON PM.Articulo = A.Clave AND PM.Maquila = '1' ", "left")
                    ->where("(A.$Texto_Mes > 0 or  A.$Mes_Anterior >0 )", null, false);
            switch ($Tipo) {
                case '10':
                    $GRUPOS = " AND SA.grupo IN ('1', '2','12','15','16','17','18','34','40') ";
                    $this->db->where_in('A.Grupo', array('1', '2', '12', '15', '16', '17', '18', '34', '40'));
                    break;
                case '80':
                    $GRUPOS = " AND SA.grupo IN ('3','50') ";
                    $this->db->where_in('A.Grupo', array('3', '50'));
                    break;
                case '90':
                    $GRUPOS = " AND SA.grupo NOT IN ('1', '2', '3','12','15','16','17','18','34','40','50') ";
                    $this->db->where_not_in('A.Grupo', array('1', '2', '3', '12', '15', '16', '17', '18', '34', '40', '50'));
                    break;
            }

            $this->db->or_where("IFNULL((SELECT SUM(SMA.CantidadMov) FROM $tabla_movs SMA  "
                            . "JOIN articulos SA on SA.clave = SMA.articulo $GRUPOS "
                            . "WHERE SMA.EntradaSalida = 1 "
                            . "AND SMA.Articulo = A.Clave "
                            . "AND MONTH(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Ano),0) > 0 ", null, false)
                    ->or_where("IFNULL((SELECT SUM(SMA.CantidadMov) FROM $tabla_movs SMA "
                            . "JOIN articulos SA on SA.clave = SMA.articulo $GRUPOS "
                            . "WHERE SMA.EntradaSalida = 2 "
                            . "AND SMA.Articulo = A.Clave "
                            . "AND MONTH(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Ano),0) > 0 ", null, false)
                    //->like("A.Departamento", $Tipo)
                    ->order_by('ClaveGrupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
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

    public function getGruposReporteComparativo($Tipo, $Mes, $Maq, $Ano, $Texto_Mes, $Texto_Mes_Anterior) {
        try {

            $GRUPOS = '';

            $tabla_movs = 'movarticulos';
            if ($Maq === 'articulos10') {
                $tabla_movs = 'movarticulos_fabrica';
            }

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED ) AS Clave, G.Nombre, A.Departamento "
                            . "")
                    ->from("$Maq A")
                    ->join("grupos G", 'ON A.Grupo = G.Clave')
                    ->where("(A.$Texto_Mes > 0 or  A.$Texto_Mes_Anterior >0 )", null, false);
            switch ($Tipo) {
                case '10':
                    $GRUPOS = " AND SA.grupo IN ('1', '2','12','15','16','17','18','34','40') ";
                    $this->db->where_in('A.Grupo', array('1', '2', '12', '15', '16', '17', '18', '34', '40'));
                    break;
                case '80':
                    $GRUPOS = " AND SA.grupo IN ('3','50') ";
                    $this->db->where_in('A.Grupo', array('3', '50'));
                    break;
                case '90':
                    $GRUPOS = " AND SA.grupo NOT IN ('1', '2', '3','12','15','16','17','18','34','40','50') ";
                    $this->db->where_not_in('A.Grupo', array('1', '2', '3', '12', '15', '16', '17', '18', '34', '40', '50'));
                    break;
            }
            $this->db->or_where("IFNULL((SELECT SUM(SMA.CantidadMov) FROM $tabla_movs SMA  "
                            . "JOIN articulos SA on SA.clave = SMA.articulo $GRUPOS "
                            . "WHERE SMA.EntradaSalida = 1 "
                            . "AND SMA.Articulo = A.Clave "
                            . "AND MONTH(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Ano),0) > 0 ", null, false)
                    ->or_where("IFNULL((SELECT SUM(SMA.CantidadMov) FROM $tabla_movs SMA "
                            . "JOIN articulos SA on SA.clave = SMA.articulo $GRUPOS "
                            . "WHERE SMA.EntradaSalida = 2 "
                            . "AND SMA.Articulo = A.Clave "
                            . "AND MONTH(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Mes "
                            . "AND YEAR(STR_TO_DATE(SMA.FechaMov, \"%d/%m/%Y\")) = $Ano),0) > 0 ", null, false)
                    //->like("A.Departamento", $Tipo)
                    ->group_by("G.Clave")
                    ->group_by("G.Nombre")
                    ->order_by('Clave', 'ASC');
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

    /* Reporte de movimientos de ajuste */

    public function getMovimientosAjuste($Maq, $Mes, $Año) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("tipomov ")
                    ->from("$Maq ")
                    ->where_in("TipoMov", array('EAJ', 'ETR', 'SAJ', 'STR'))
                    ->where("MONTH(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Mes  ", null, false)
                    ->where("YEAR(STR_TO_DATE(FechaMov, \"%d/%m/%Y\")) = $Año  ", null, false)
                    ->group_by("tipomov");
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

    public function getGruposMovimientosAjuste($Maq, $Mes, $Año, $Tipo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave, G.Nombre, MA.TipoMov "
                            . "")
                    ->from("$Maq MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->join("grupos G", 'ON A.Grupo = G.Clave')
                    ->where("MA.TipoMov", $Tipo)
                    ->where("MONTH(STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\")) = $Mes  ", null, false)
                    ->where("YEAR(STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\")) = $Año  ", null, false)
                    ->group_by("G.Clave")
                    ->group_by("G.Nombre")
                    //->order_by('MA.TipoMov', 'ASC')
                    ->order_by('Clave', 'ASC');
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

    public function getDetalleMovimientosAjuste($Maq, $Mes, $Año, $Tipo, $Grupo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED ) AS ClaveGrupo,  "
                            . "A.Clave AS ClaveArt, "
                            . "A.Descripcion AS Articulo, "
                            . "U.Descripcion AS Unidad, "
                            . "MA.FechaMov,"
                            . "CASE WHEN MA.EntradaSalida = '1' THEN MA.CantidadMov ELSE 0 END AS Entradas, "
                            . "CASE WHEN MA.EntradaSalida = '2' THEN MA.CantidadMov ELSE 0 END AS Salidas,"
                            . "MA.PrecioMov, "
                            . "MA.Subtotal, "
                            . "MA.Sem,"
                            . "MA.Maq,"
                            . "MA.EntradaSalida,"
                            . "MA.TipoMov"
                            . "")
                    ->from("$Maq MA")
                    ->join("articulos A", 'ON A.Clave = MA.Articulo')
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("MA.TipoMov", $Tipo)
                    ->where("A.Grupo", $Grupo)
                    ->where("MONTH(STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\")) = $Mes  ", null, false)
                    ->where("YEAR(STR_TO_DATE(MA.FechaMov, \"%d/%m/%Y\")) = $Año  ", null, false)
                    //->order_by('MA.TipoMov', 'ASC')
                    //->order_by('ClaveGrupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
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

    public function getGruposReporteCosto($Maq) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave, G.Nombre "
                            . "")
                    ->from("$Maq A")
                    ->join("grupos G", 'ON A.Grupo = G.Clave')
                    ->where("ifnull(A.Existencia,0) > 0  ", null, false)
                    ->group_by("G.Clave")
                    ->group_by("G.Nombre")
                    ->order_by('Clave', 'ASC');
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

    public function getDetalleReporteCosto($Maq, $Mes) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED ) AS ClaveGrupo,  "
                            . "A.Clave AS ClaveArt, "
                            . "A.Descripcion AS Articulo, "
                            . "U.Descripcion AS Unidad, "
                            . "A.P$Mes AS Costo, "
                            . "A.Existencia as Existencia "
                            . ""
                            . "")
                    ->from("$Maq A")
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("ifnull(A.Existencia,0) > 0 ", null, false)
                    ->order_by('ClaveGrupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
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

    /* Reporte de etiquetas para inv */

    public function getArticulosPorGruposParaEtiquetas($Grupo, $aGrupo, $Texto_Mes) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED ) AS ClaveGrupo, "
                            . "G.Nombre AS NombreGrupo,"
                            . "A.Clave, "
                            . "A.Descripcion ,"
                            . "A.$Texto_Mes AS Existencia,    "
                            . "U.Descripcion As Unidad"
                            . "")
                    ->from("articulos A")
                    ->join("grupos G", 'ON G.Clave = A.Grupo')
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("ifnull(A.$Texto_Mes,0) > 0 ", null, false)
                    ->where("A.Grupo BETWEEN $Grupo AND $aGrupo  ", null, false)
                    ->order_by('ClaveGrupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
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

    /* Reporte inv anual por mes */

    public function getGruposReporteExistenciasAnualPorMes($Maq) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED) AS ClaveGrupo, G.Nombre AS NombreGrupo "
                            . "")
                    ->from("$Maq A")
                    ->join("grupos G", 'ON A.Grupo = G.Clave')
                    ->where("(ifnull(A.Ene,0) +
                                ifnull(A.Feb,0) +
                                ifnull(A.Mar,0) +
                                ifnull(A.Abr,0) +
                                ifnull(A.May,0) +
                                ifnull(A.Jun,0) +
                                ifnull(A.Jul,0) +
                                ifnull(A.Ago,0) +
                                ifnull(A.Sep,0) +
                                ifnull(A.Oct,0) +
                                ifnull(A.Nov,0) +
                                ifnull(A.Dic,0) )  > 0 ", null, false)
                    ->group_by("G.Clave")
                    ->group_by("G.Nombre")
                    ->order_by('ClaveGrupo', 'ASC');
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

    public function getArticulosReporteExistenciasAnualPorMes($Maq) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(A.Grupo AS SIGNED) AS ClaveGrupo, A.Clave AS Codigo, A.Descripcion AS Articulo, U.Descripcion AS Unidad, "
                            . "
                                ifnull(A.Ene,0) AS Ene, ifnull(A.PEne,0) AS PEne,
                                ifnull(A.Feb,0) AS Feb, ifnull(A.PFeb,0) AS PFeb,
                                ifnull(A.Mar,0) AS Mar, ifnull(A.PMar,0) AS PMar,
                                ifnull(A.Abr,0) AS Abr, ifnull(A.PAbr,0) AS PAbr,
                                ifnull(A.May,0) AS May, ifnull(A.PMay,0) AS PMay,
                                ifnull(A.Jun,0) AS Jun, ifnull(A.PJun,0) AS PJun,
                                ifnull(A.Jul,0) AS Jul, ifnull(A.PJul,0) AS PJul,
                                ifnull(A.Ago,0) AS Ago, ifnull(A.PAgo,0) AS PAgo,
                                ifnull(A.Sep,0) AS Sep, ifnull(A.PSep,0) AS PSep,
                                ifnull(A.Oct,0) AS Oct, ifnull(A.POct,0) AS POct,
                                ifnull(A.Nov,0) AS Nov, ifnull(A.PNov,0) AS PNov,
                                ifnull(A.Dic,0) AS Dic, ifnull(A.PDic,0) AS PDic "
                            . ""
                            . "")
                    ->from("$Maq A")
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("(ifnull(A.Ene,0) +
                                ifnull(A.Feb,0) +
                                ifnull(A.Mar,0) +
                                ifnull(A.Abr,0) +
                                ifnull(A.May,0) +
                                ifnull(A.Jun,0) +
                                ifnull(A.Jul,0) +
                                ifnull(A.Ago,0) +
                                ifnull(A.Sep,0) +
                                ifnull(A.Oct,0) +
                                ifnull(A.Nov,0) +
                                ifnull(A.Dic,0) )  > 0 ", null, false)
                    ->order_by('ClaveGrupo', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
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
