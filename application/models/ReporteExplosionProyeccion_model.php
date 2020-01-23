<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteExplosionProyeccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getRegistros($Ano, $Semana, $Maquila, $aMaquila, $TipoE, $MesAnt, $FechaIni, $FechaFin, $Sem_Compras) {
        try {
            $Subalmacen = ($Maquila === '1') ? " or  MA.Maq  = '97' " : '';
            $this->db->query("set sql_mode=''");
            $this->db->select("EXPL.Grupo, EXPL.Articulo, EXPL.Descripcion, EXPL.Unidad, sum(EXPL.Explosion) as Explosion, EXPL.Inv_Ini,

                                ifnull((select SUM(OC.Cantidad) AS Cantidad from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA')
                                 ), 0) AS CantPedida,

                                ifnull((select SUM(OC.CantidadRecibida) AS CantidadRecibida from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA')
                                ), 0) AS CantEntregada,

                                ifnull((select OC.Folio from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA')
                                AND OC.Folio IS NOT NULL LIMIT 1
                                 ), '') AS FolioOrden,

                                 ifnull((select OC.FechaOrden from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA')
                                AND OC.FechaOrden IS NOT NULL LIMIT 1
                                 ), '') AS FechaOrden,

                                 ifnull((select sum(MA.CantidadMov) from movarticulos MA
                                where MA.EntradaSalida = '1'
                                and MA.Articulo = EXPL.Articulo
                                and MA.Maq BETWEEN $Maquila AND $aMaquila
                                AND STR_TO_DATE(MA.FechaMov, '%d/%m/%Y') BETWEEN STR_TO_DATE('$FechaIni', '%d/%m/%Y') AND STR_TO_DATE('$FechaFin', '%d/%m/%Y')
                                ), 0) AS Entradas,

                                ifnull((select sum(MA.CantidadMov) from movarticulos MA
                                where MA.EntradaSalida = '2'
                                and MA.Articulo = EXPL.Articulo
                                and (MA.Maq BETWEEN $Maquila AND $aMaquila   $Subalmacen  )
                                AND STR_TO_DATE(MA.FechaMov, '%d/%m/%Y') BETWEEN STR_TO_DATE('$FechaIni', '%d/%m/%Y') AND STR_TO_DATE('$FechaFin', '%d/%m/%Y')
                                ), 0) AS Salidas

                                from


                                (SELECT A.Grupo, FT.Articulo, A.Descripcion, U.Descripcion AS Unidad,
                                case when $TipoE = '10' then
                                (PE.Pares *  FT.Consumo)*
                                (CASE
                                WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                                WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                                WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                                WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                                WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                                WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a END + 1 )
                                else (PE.Pares *  FT.Consumo) end AS Explosion,
                                ifnull(A.$MesAnt,0) AS Inv_Ini
                                FROM `pedidox` `PE`
                                JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                                JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                                JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo`
                                JOIN `maquilas` `MA` ON `MA`.`Clave` = PE.Maquila
                                JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                                WHERE cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila
                                AND PE.Semana = $Semana
                                AND `PE`.`Ano` = '$Ano'
                                AND case
                                when $TipoE = '10' then `A`.`Grupo` IN('1', '2')
                                when $TipoE = '80' then `A`.`Grupo` IN('3')
                                when $TipoE = '90' then `A`.`Grupo` NOT IN('1', '2', '3')
                                end) as EXPL
                                GROUP BY `EXPL`.`Articulo`
                                ORDER BY `EXPL`.`Grupo` ASC, `EXPL`.`Descripcion` ASC "
                    . " ", false);

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

    public function getGruposReporte() {
        try {

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS ClaveGrupo, G.Nombre AS NombreGrupo  "
                            . "", false)
                    ->from('explosion_proyeccion_temp ET')
                    ->join('grupos G', 'ON G.Clave = ET.Grupo');

            $this->db->group_by('ClaveGrupo');
            $this->db->group_by('G.Nombre');
            $this->db->order_by('ClaveGrupo', 'ASC');

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

    public function getDetalleReporte() {
        try {

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(Grupo AS SIGNED ) AS ClaveGrupo,
                                Articulo,
                                Descripcion,
                                Unidad,
                                Inicial,
                                Entradas,
                                Salidas,
                                Actual,
                                OrdCom,
                                FechaCom,
                                Pedido,
                                Recibido,
                                sum(SemAnt) as Anterior,
                                sum(Sem1) AS Sem1,
                                sum(Sem2) AS Sem2,
                                sum(Sem3) AS Sem3,
                                sum(Sem4) AS Sem4,
                                sum(Sem5) AS Sem5,
                                sum(Sem6) AS Sem6  "
                            . "", false)
                    ->from('explosion_proyeccion_temp');

            $this->db->group_by('Articulo');
            $this->db->order_by('ClaveGrupo', 'ASC');
            $this->db->order_by('Descripcion', 'ASC');

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

    public function getPares($Ano, $Semana, $Maquila, $aMaquila) {
        try {
            $this->db->select("SUM(PE.Pares) AS Pares "
                            . " ", false)
                    ->from('pedidox PE')
                    ->where('PE.Estatus', 'A')
                    ->where("PE.Maquila BETWEEN $Maquila AND $aMaquila")
                    ->where('PE.Semana', $Semana)
                    ->where('PE.Ano', $Ano)
                    ->where('PE.Control <>  ', false)
                    ->where('PE.Control IS NOT NULL ', NULL, false);


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

    /* Tallas */

    public function getExplosionTallas($Ano, $Semana, $Maquila, $aMaquila) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("
                EXPL.ClaveART,  EXPL.Descripcion,
SUM(EXPL.C1) AS C1, SUM(EXPL.C2) AS C2, SUM(EXPL.C3) AS C3, SUM(EXPL.C4) AS C4, SUM(EXPL.C5) AS C5, SUM(EXPL.C6) AS C6, SUM(EXPL.C7) AS C7, SUM(EXPL.C8) AS C8, SUM(EXPL.C9) AS C9, SUM(EXPL.C10) AS C10, SUM(EXPL.C11) AS C11,
SUM(EXPL.C12) AS C12, SUM(EXPL.C13) AS C13, SUM(EXPL.C14) AS C14, SUM(EXPL.C15) AS C15, SUM(EXPL.C16) AS C16, SUM(EXPL.C17) AS C17, SUM(EXPL.C18) AS C18, SUM(EXPL.C19) AS C19, SUM(EXPL.C20) AS C20, SUM(EXPL.C21) AS C21, SUM(EXPL.C22) AS C22,
EXPL.T1, EXPL.T2, EXPL.T3, EXPL.T4, EXPL.T5, EXPL.T6, EXPL.T7, EXPL.T8, EXPL.T9, EXPL.T10, EXPL.T11, EXPL.T12, EXPL.T13, EXPL.T14, EXPL.T15, EXPL.T16, EXPL.T17, EXPL.T18, EXPL.T19, EXPL.T20, EXPL.T21, EXPL.T22,
EXPL.A1, EXPL.A2, EXPL.A3, EXPL.A4, EXPL.A5, EXPL.A6, EXPL.A7, EXPL.A8, EXPL.A9, EXPL.A10, EXPL.A11, EXPL.A12, EXPL.A13, EXPL.A14, EXPL.A15, EXPL.A16, EXPL.A17, EXPL.A18, EXPL.A19, EXPL.A20, EXPL.A21, EXPL.A22,
EXPL.Grupo, EXPL.Articulo, EXPL.Descripcion, EXPL.Unidad AS Unidad, SUM(EXPL.Pares) AS Pares, EXPL.Precio
from
(SELECT CAST(FT.Articulo AS SIGNED ) AS ClaveART,
(PE.C1) AS C1, (PE.C2) AS C2, (PE.C3) AS C3, (PE.C4) AS C4, (PE.C5) AS C5, (PE.C6) AS C6, (PE.C7) AS C7, (PE.C8) AS C8, (PE.C9) AS C9, (PE.C10) AS C10, (PE.C11) AS C11,
(PE.C12) AS C12, (PE.C13) AS C13, (PE.C14) AS C14, (PE.C15) AS C15, (PE.C16) AS C16, (PE.C17) AS C17, (PE.C18) AS C18, (PE.C19) AS C19, (PE.C20) AS C20, (PE.C21) AS C21, (PE.C22) AS C22,
S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22,
SC.A1, SC.A2, SC.A3, SC.A4, SC.A5, SC.A6, SC.A7, SC.A8, SC.A9, SC.A10, SC.A11, SC.A12, SC.A13, SC.A14, SC.A15, SC.A16, SC.A17, SC.A18, SC.A19, SC.A20, SC.A21, SC.A22,
A.Grupo, FT.Articulo, A.Descripcion, U.Descripcion AS Unidad, PM.Precio,
PE.Pares
FROM `pedidox` `PE`
JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo`
JOIN `series` `S` ON `S`.`Clave` =  `E`.`Serie`
JOIN `suelascompras` `SC` ON `SC`.`ArticuloCBZ` =  `FT`.`Articulo`  AND S.Clave = SC.Serie
JOIN `preciosmaquilas` `PM` ON PM.Articulo = FT.Articulo AND PM.Maquila = '1'
WHERE cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila
AND cast(PE.Semana as signed) = $Semana
AND `PE`.`Ano` = '$Ano'
AND `PE`.`Estatus` IN('A', 'F')
AND `A`.`Grupo` IN('3')
ORDER BY `A`.`Descripcion` ASC) AS EXPL
group by EXPL.ClaveART ORDER BY EXPL.Descripcion ASC "
                    . " ", false);



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

    public function onCreaYObtieneTablaTemporalAgrupada($Texto_Mes_Anterior, $Desglosado) {
        try {
            $this->db->query("
                            INSERT INTO explosion_proyeccion_tallas_temp
                            (`Grupo`,`Articulo`,`Descripcion`,`Unidad`,`Inicial`,`Entradas`,`Salidas`,
                            `Actual`,`OrdCom`,`FechaCom`,`Pedido`,`Recibido`,`SemAnt`,`Sem1`,`Sem2`,`Sem3`,`Sem4`,`Sem5`,`Sem6`,`Talla`)
                            SELECT CON.ClaveGrupo, CON.Articulo, $Desglosado.Descripcion, CON.Unidad,
                            A.$Texto_Mes_Anterior AS Inicial,
                            0 AS Entradas,
                            0 AS Salidas,
                            0 AS Actual,
                            '' AS OrdCom,
                            '' AS FechaCom,
                            0 AS Pedido,
                            0 AS Recibido,
                            CON.Anterior as Anterior,
                            CON.Sem1 AS Sem1,
                            CON.Sem2 AS Sem2,
                            CON.Sem3 AS Sem3,
                            CON.Sem4 AS Sem4,
                            CON.Sem5 AS Sem5,
                            CON.Sem6 AS Sem6,
                            CON.Talla
                            from
                            (select CAST(et.Grupo AS SIGNED ) AS ClaveGrupo,
                            et.Articulo,
                            et.Descripcion,
                            et.Unidad,
                            sum(et.SemAnt) as Anterior,
                            sum(et.Sem1) AS Sem1,
                            sum(et.Sem2) AS Sem2,
                            sum(et.Sem3) AS Sem3,
                            sum(et.Sem4) AS Sem4,
                            sum(et.Sem5) AS Sem5,
                            sum(et.Sem6) AS Sem6,
                            et.Talla
                            from explosion_proyeccion_temp et
                            group by et.Articulo
                            ) as CON
                            JOIN articulos A on A.Clave = CON.Articulo
                            order by ClaveGrupo, A.Descripcion asc ");

            return $this->db->query("select * from explosion_proyeccion_tallas_temp ")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGruposReporteTallas() {
        try {

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS ClaveGrupo, G.Nombre AS NombreGrupo  "
                            . "", false)
                    ->from('explosion_proyeccion_tallas_temp ET')
                    ->join('grupos G', 'ON G.Clave = ET.Grupo');

            $this->db->group_by('ClaveGrupo');
            $this->db->group_by('G.Nombre');
            $this->db->order_by('ClaveGrupo', 'ASC');

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

    public function getDetalleReporteTallas() {
        try {

            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(Grupo AS SIGNED ) AS ClaveGrupo,
                                Articulo,
                                Descripcion,
                                Unidad,
                                sum(Inicial) as Inicial,
                                sum(Entradas) as Entradas,
                                sum(Salidas) as Salidas,
                                sum(Actual) as Actual,
                                OrdCom,
                                FechaCom,
                                sum(Pedido) as Pedido,
								sum(Recibido) as Recibido,
                                sum(SemAnt) as Anterior,
                                sum(Sem1) AS Sem1,
                                sum(Sem2) AS Sem2,
                                sum(Sem3) AS Sem3,
                                sum(Sem4) AS Sem4,
                                sum(Sem5) AS Sem5,
                                sum(Sem6) AS Sem6
                                from
                                explosion_proyeccion_tallas_temp
                                group by Descripcion
                                order by Descripcion "
                    . "", false);

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
