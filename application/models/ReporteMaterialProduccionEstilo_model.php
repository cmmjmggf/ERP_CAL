<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteMaterialProduccionEstilo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
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

    public function getArticulosXDepto($Tipo) {
        try {
            return $this->db->select("CONVERT(A.Clave, UNSIGNED INTEGER) AS Clave , "
                                    . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo "
                                    . " ", false)
                            ->from("articulos AS A")
                            ->where("A.Departamento", $Tipo)
                            ->order_by("Clave", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporte($Ano, $Sem, $Articulo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select(" EXPL.Articulo, EXPL.Descripcion as ArticuloT, EXPL.Unidad,
                                EXPL.Control as ControlT, EXPL.Estilo, EXPL.Color,
                                sum(EXPL.Explosion) as Cantidad, sum(EXPL.Pares) as ParesR,
                                (select sum(pares)
                                from pedidox
                                where clave = EXPL.Pedido
                                and estilo = EXPL.Estilo
                                and color = EXPL.Color
                                and cast(Semana as signed) = $Sem
                                and Ano = '$Ano'
                                and stsavan <> 14
                                and Maquila = 1
                                )  as Pares
                                from (
                                SELECT
                                FT.Articulo, A.Descripcion, U.Descripcion AS Unidad,
                                PE.Control, PE.Estilo, PE.Color, PE.Clave AS Pedido, PE.Cliente AS Cliente,
                                case when A.Departamento = '10' then
                                (PE.Pares *  FT.Consumo)*
                                (CASE
                                WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                                WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                                WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                                WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                                WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                                WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a END + 1 )
                                else (PE.Pares *  FT.Consumo)
                                end AS Explosion,
                                PE.Pares
                                FROM `pedidox` `PE`
                                JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                                JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                                JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo`
                                JOIN `maquilas` `MA` ON `MA`.`Clave` = PE.Maquila
                                JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                                AND cast(PE.Semana as signed) = $Sem
                                AND `PE`.`Ano` = '$Ano'
                                AND FT.Articulo = '$Articulo'
                                AND PE.stsavan <> 14
                                AND PE.Maquila = 1
                                ) as EXPL
                                group by EXPL.Control,EXPL.Estilo,EXPL.Color
                                order by EXPL.Control asc ", false);
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

    public function onImprimirReporteDesglosado($Ano, $dSem, $aSem, $Articulo, $TipoE, $sts) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("
                            EXPL.Articulo, EXPL.Descripcion as ArticuloT,
                            EXPL.Control as ControlT, EXPL.Pedido, EXPL.FechaEntrega, EXPL.Estilo, EXPL.Cliente as Clave,
                            (select razons from clientes where clave = EXPL.Cliente) as Cliente,
                            EXPL.Semana, EXPL.Maquila,
                            sum(EXPL.Explosion) as Cantidad, sum(EXPL.Pares) as ParesResp,

                            (select sum(pares)
                            from pedidox
                            where clave = EXPL.Pedido
                            and estilo = EXPL.Estilo
                            and color = EXPL.Color
                            and cliente = EXPL.Cliente
                            and cast(Semana as signed) BETWEEN $dSem AND $aSem
                            and Ano = '$Ano'
                            and id = EXPL.ID
                            )  as Pares

                            from (
                            SELECT
                            PE.ID,
                            FT.Articulo, A.Descripcion,
                            PE.Control, PE.Clave as Pedido, PE.FechaEntrega, PE.Estilo, PE.Color, PE.Cliente,
                            PE.Semana, PE.Maquila,
                            case when $TipoE = '10' then
                            (PE.Pares *  FT.Consumo)*(CASE
                            WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                            WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                            WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                            WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                            WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                            WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a END + 1 )
                            else
                            (PE.Pares *  FT.Consumo)
                            end AS Explosion,
                            PE.Pares
                            FROM `pedidox` `PE`
                            JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                            JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                            JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo`
                            JOIN `maquilas` `MA` ON `MA`.`Clave` = PE.Maquila
                            AND cast(PE.Semana as signed) BETWEEN $dSem AND $aSem
                            AND `PE`.`Ano` = '$Ano'
                            AND FT.Articulo = '$Articulo'
                            AND
                            case
                            when $sts = 1 then PE.stsavan < 3
                            when $sts = 2 then PE.stsavan <> 14
                            end

                            ) as EXPL

                            group by EXPL.Control, EXPL.Estilo
                            order by EXPL.Control asc ", false);
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
