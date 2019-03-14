<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ExistenciasSuelasPlantas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Art, $Mes) {
        try {
            $Año_Act = Date('Y');
            $meses = array('Dic', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
            if (intval($Mes) > 0) {
                $MesInvAct = $Mes;
                $MesInvAnt = $Mes - 1;
            } else {
                $MesInvAnt = date('m', strtotime('-1 month'));
                $MesInvAct = date('m');
            }
            //print $MesInvAct . 'sdsd' . $MesInvAnt;

            $sql = "SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A1 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A2 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A3 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A4 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A5 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A6 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A7 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A8 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A9 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A10 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A11 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A12 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A13 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A14 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A15 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A16 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A17 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A18 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A19 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A20 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " IFNULL(A." . $meses[intval($MesInvAnt)] . " ,0) +
                        (IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '1'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0) -
                        IFNULL((select sum(CantidadMov)
                        from movarticulos
                        where Articulo = A.Clave and EntradaSalida  = '2'
                        and year(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $Año_Act
                        and month(date_format(str_to_date(FechaMov, '%d/%m/%Y'), '%Y-%m-%d')) = $MesInvAct ),0)
                   ) AS Existencia  "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A21 "
                    . "WHERE SC.ArticuloCBZ = '$Art' "
                    . "UNION SELECT "
                    . "A.Clave AS Clave, "
                    . "A.Descripcion AS Articulo , "
                    . " '' AS Existencia "
                    . "FROM suelascompras SC "
                    . "JOIN articulos AS A ON A.Clave =  SC.A22 "
                    . "WHERE SC.ArticuloCBZ = '$Art' ";
            $query = $this->db->query($sql);
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCabeceros() {
        try {
            return $this->db->select("CAST(A.Clave AS SIGNED ) AS ID ,"
                                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Material")
                            ->from("suelascompras AS D")
                            ->join("articulos AS A", 'ON A.Clave =  D.ArticuloCBZ')
                            ->order_by('A.Descripcion', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
