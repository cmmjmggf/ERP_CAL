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

            $this->db->query("set sql_mode=''");
            $this->db->select("EXPL.Grupo, EXPL.Articulo, EXPL.Descripcion, EXPL.Unidad, sum(EXPL.Explosion) as Explosion, EXPL.Inv_Ini,

                                ifnull((select SUM(OC.Cantidad) AS Cantidad from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA', 'INACTIVA', 'RECIBIDA')
                                 ), 0) AS CantPedida,

                                ifnull((select SUM(OC.CantidadRecibida) AS CantidadRecibida from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA', 'INACTIVA', 'RECIBIDA')
                                ), 0) AS CantEntregada,

                                ifnull((select OC.Folio from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA', 'INACTIVA', 'RECIBIDA')
                                AND OC.Folio IS NOT NULL LIMIT 1
                                 ), '') AS FolioOrden,

                                 ifnull((select OC.FechaOrden from ordencompra OC
                                where OC.Articulo = EXPL.Articulo
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem = $Sem_Compras
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA', 'INACTIVA', 'RECIBIDA')
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
                                and MA.Maq BETWEEN $Maquila AND $aMaquila
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
                                JOIN `maquilas` `MA` ON `MA`.`Clave` = '1'
                                JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                                WHERE cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila
                                AND PE.Semana = $Semana
                                AND `PE`.`Ano` = '$Ano'
                                AND case
                                when $TipoE = '10' then `A`.`Grupo` IN('1', '2')
                                when $TipoE = '80' then `A`.`Grupo` IN('3', '50', '52')
                                when $TipoE = '90' then `A`.`Grupo` NOT IN('1', '2', '3', '50', '52')
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

}
