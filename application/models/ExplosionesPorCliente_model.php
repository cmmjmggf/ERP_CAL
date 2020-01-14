<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ExplosionesPorCliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getDatosEmpresa() {
        try {
            $this->db->select("E.RazonSocial as Empresa, E.Foto as Logo "
                            . " ", false)
                    ->from('empresas AS E')
                    ->where('Estatus', 'ACTIVO');

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

    public function getGrupos($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $TipoE, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave ,G.Nombre "
                    . " ", false);
            $this->db->from('pedidox PE');
            $this->db->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color');
            $this->db->join('articulos A', 'ON A.Clave =  FT.Articulo');
            $this->db->join('grupos G', 'ON G.Clave = A.Grupo');
            switch ($TipoE) {
                case '10':
                    $this->db->where_in('G.Clave', array('1', '2'));
                    break;
                case '80':
                    $this->db->where_in('G.Clave', array('3'));
                    break;
                case '90':
                    $this->db->where_not_in('G.Clave', array('1', '2', '3'));
                    break;
            }
            $this->db->where("cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila");
            $this->db->where("cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana");
            $this->db->where('PE.Ano', $Ano);
            $this->db->where_in('PE.Estatus', array('A', 'F'));
            $this->db->where('PE.Cliente', $Cliente);
            $this->db->group_by('Clave');
            $this->db->order_by('Clave', 'ASC');
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

    public function getPares($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Cliente) {
        try {
            $this->db->select("SUM(PE.Pares) AS Pares "
                            . " ", false)
                    ->from('pedidox PE')
                    ->where_in('PE.Estatus', array('A', 'F'))
                    ->where("cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila")
                    ->where("cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana")
                    ->where('PE.Ano', $Ano)
                    ->where('PE.Cliente', $Cliente);
            //->where('PE.Control <>  ', false)
            //->where('PE.Control IS NOT NULL ', NULL, false);


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

    public function getTotalesPorGrupoParaPorcentaje($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Cliente, $Grupo) {
        try {
            $this->db->select("sum(PARES.Explosion) as Explosion
                            FROM(SELECT (PE.Pares *  FT.Consumo)  AS Explosion
                            FROM `pedidox` `PE`
                            JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                            JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                            WHERE cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila
                            AND cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana
                            AND `PE`.`Ano` = '$Ano'
                            AND `PE`.`Cliente` = '$Cliente'
                            AND `A`.`Grupo`= '$Grupo' ) AS PARES
                           "
                    . " ", false);
            //->where('PE.Control <>  ', false)
            //->where('PE.Control IS NOT NULL ', NULL, false);


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

    public function getMateriales($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $TipoE, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("A.Grupo, "
                            . "FT.Articulo "
                            . " ", false)
                    ->from('pedidox PE')
                    ->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color')
                    ->join('articulos A', 'ON A.Clave =  FT.Articulo')
                    ->where("cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila")
                    ->where("cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana")
                    ->where('PE.Ano', $Ano)
                    ->where('PE.Cliente', $Cliente)
                    ->where_in('PE.Estatus', array('A', 'F'));
            // ->where('PE.Control <>  ', false)
            // ->where('PE.Control IS NOT NULL ', NULL, false);

            switch ($TipoE) {
                case '10':
                    $this->db->where_in('A.Grupo', array('1', '2'));
                    break;
                case '80':
                    $this->db->where_in('A.Grupo', array('3'));
                    break;
                case '90':
                    $this->db->where_not_in('A.Grupo', array('1', '2', '3'));
                    break;
            }
            $this->db->group_by('A.Clave');


            //Ordenamiento
            switch ($TipoE) {
                case '10':
                    $this->db->order_by('A.Grupo', 'ASC');
                    $this->db->order_by('A.Descripcion', 'ASC');
                    break;
                case '80':
                    $this->db->order_by('A.Grupo', 'ASC');
                    $this->db->order_by('A.Descripcion', 'ASC');
                    break;
                case '90':
                    $this->db->order_by('A.Grupo', 'ASC');
                    $this->db->order_by('A.Descripcion', 'ASC');
                    break;
            }

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

    public function getExplosionMateriales($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $TipoE, $SinClasif, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("EXPL.Grupo, EXPL.Articulo , EXPL.Descripcion, EXPL.Unidad, sum(EXPL.Explosion) as Explosion, EXPL.Precio, EXPL.Clasificacion, sum(EXPL.Pares) as Pares
                                    from ( SELECT A.Grupo, FT.Articulo, A.Descripcion, U.Descripcion AS Unidad,
                                    case when $TipoE = '10' then
                                    (PE.Pares *  FT.Consumo)*
                                     (CASE
                                    WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                                    WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                                    WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                                    WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                                    WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                                    WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a END + 1 )
                                    else
                                    (PE.Pares *  FT.Consumo)
                                    end AS Explosion,
                                    PM.Precio,
                                    PE.Pares,
                                    CASE WHEN PZA.Clasificacion = '1' THEN '1ra'
                                    WHEN PZA.Clasificacion = '2' THEN '2da'
                                    WHEN PZA.Clasificacion = '3' THEN '3ra' ELSE '-' END AS Clasificacion
                                    FROM `pedidox` `PE`
                                    JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                                    LEFT JOIN `piezas` `PZA` ON `FT`.`Pieza`= `PZA`.`Clave`
                                    JOIN `preciosmaquilas` `PM` ON `PM`.`Articulo` = `FT`.`Articulo` AND `PM`.`Maquila` ='1'
                                    JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                                    JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo` AND E.Liberado = 2
                                    JOIN `maquilas` `MA` ON `MA`.`Clave` = PE.Maquila
                                    JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                                    WHERE cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila
                                    AND cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana
                                    AND `PE`.`Ano` = '$Ano'
                                    AND `PE`.`Cliente` = '$Cliente'
                                    AND
                                    case
                                    when $TipoE = '10' then `A`.`Grupo` IN('1', '2')
                                    when $TipoE = '80' then `A`.`Grupo` IN('3')
                                    when $TipoE = '90' then `A`.`Grupo` NOT IN('1', '2','3')
                                    end) as EXPL "
                    . " ", false);

            //Agrupacion
            $this->db->group_by('EXPL.Articulo');
            //Agrupacion validando si se agrupa por tipo de piel
            if ($SinClasif === '0') {
                $this->db->group_by('EXPL.Clasificacion');
            }
            //Ordenamiento
            switch ($TipoE) {
                case '10':
                    $this->db->order_by('EXPL.Grupo', 'ASC');
                    $this->db->order_by('EXPL.Descripcion', 'ASC');
                    if ($SinClasif === '0') {
                        $this->db->order_by('EXPL.Clasificacion', 'ASC');
                    }
                    break;
                case '80':
                    $this->db->order_by('EXPL.Grupo', 'ASC');
                    $this->db->order_by('EXPL.Descripcion', 'ASC');
                    break;
                case '90':
                    $this->db->order_by('EXPL.Grupo', 'ASC');
                    $this->db->order_by('EXPL.Descripcion', 'ASC');
                    if ($SinClasif === '0') {
                        $this->db->order_by('EXPL.Clasificacion', 'ASC');
                    }
                    break;
            }


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

    /* Explosion por tallas */

    public function getGruposTallas($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("CAST(G.Clave AS SIGNED ) AS Clave ,G.Nombre "
                    . " ", false);
            $this->db->from('pedidox PE');
            $this->db->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color');
            $this->db->join('articulos A', 'ON A.Clave =  FT.Articulo');
            $this->db->join('grupos G', 'ON G.Clave = A.Grupo');
            $this->db->where_in('G.Clave', array('3'));

            $this->db->where("cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila");
            $this->db->where("cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana");
            $this->db->where('PE.Ano', $Ano);
            $this->db->where('PE.Cliente', $Cliente);
            $this->db->where_in('PE.Estatus', array('A', 'F'));
            $this->db->group_by('Clave');
            $this->db->order_by('Clave', 'ASC');
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

    public function getMaterialesTallas($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("A.Grupo, "
                            . "FT.Articulo,"
                            . "A.Descripcion AS NombreArticulo,"
                            . "PM.Precio, "
                            . "CAST(FT.Articulo AS SIGNED ) AS ClaveART, (FT.Consumo) AS Consumo "
                            . " ", false)
                    ->from('pedidox PE')
                    ->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color')
                    ->join('articulos A', 'ON A.Clave =  FT.Articulo')
                    ->join('preciosmaquilas PM', "ON PM.Articulo = FT.Articulo AND PM.Maquila ='1' ")
                    ->where("cast(PE.Maquila as signed) BETWEEN $Maquila AND $aMaquila")
                    ->where("cast(PE.Semana as signed) BETWEEN $Semana AND $aSemana")
                    ->where('PE.Ano', $Ano)
                    ->where('PE.Cliente', $Cliente)
                    ->where_in('PE.Estatus', array('A', 'F'));
            //->where('PE.Control <>  ', false)
            //->where('PE.Control IS NOT NULL ', NULL, false);
            $this->db->where_in('A.Grupo', array('3'));
            $this->db->group_by('A.Clave');
            //Ordenamiento será por tallas
            $this->db->order_by('NombreArticulo', 'ASC');

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

    public function getExplosionMaterialesTallas($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("
                EXPL.ClaveART,  EXPL.Descripcion,
                SUM(EXPL.C1) AS C1, SUM(EXPL.C2) AS C2, SUM(EXPL.C3) AS C3, SUM(EXPL.C4) AS C4, SUM(EXPL.C5) AS C5, SUM(EXPL.C6) AS C6, SUM(EXPL.C7) AS C7, SUM(EXPL.C8) AS C8, SUM(EXPL.C9) AS C9, SUM(EXPL.C10) AS C10, SUM(EXPL.C11) AS C11,
                SUM(EXPL.C12) AS C12, SUM(EXPL.C13) AS C13, SUM(EXPL.C14) AS C14, SUM(EXPL.C15) AS C15, SUM(EXPL.C16) AS C16, SUM(EXPL.C17) AS C17, SUM(EXPL.C18) AS C18, SUM(EXPL.C19) AS C19, SUM(EXPL.C20) AS C20, SUM(EXPL.C21) AS C21, SUM(EXPL.C22) AS C22,
                EXPL.T1, EXPL.T2, EXPL.T3, EXPL.T4, EXPL.T5, EXPL.T6, EXPL.T7, EXPL.T8, EXPL.T9, EXPL.T10, EXPL.T11, EXPL.T12, EXPL.T13, EXPL.T14, EXPL.T15, EXPL.T16, EXPL.T17, EXPL.T18, EXPL.T19, EXPL.T20, EXPL.T21, EXPL.T22,
                EXPL.A1, EXPL.A2, EXPL.A3, EXPL.A4, EXPL.A5, EXPL.A6, EXPL.A7, EXPL.A8, EXPL.A9, EXPL.A10, EXPL.A11, EXPL.A12, EXPL.A13, EXPL.A14, EXPL.A15, EXPL.A16, EXPL.A17, EXPL.A18, EXPL.A19, EXPL.A20, EXPL.A21, EXPL.A22,
                EXPL.Grupo, EXPL.Articulo, EXPL.Descripcion, EXPL.Unidad AS Unidad, SUM(EXPL.Pares) AS Pares
                from
                (SELECT CAST(FT.Articulo AS SIGNED ) AS ClaveART,
                (PE.C1) AS C1, (PE.C2) AS C2, (PE.C3) AS C3, (PE.C4) AS C4, (PE.C5) AS C5, (PE.C6) AS C6, (PE.C7) AS C7, (PE.C8) AS C8, (PE.C9) AS C9, (PE.C10) AS C10, (PE.C11) AS C11,
                (PE.C12) AS C12, (PE.C13) AS C13, (PE.C14) AS C14, (PE.C15) AS C15, (PE.C16) AS C16, (PE.C17) AS C17, (PE.C18) AS C18, (PE.C19) AS C19, (PE.C20) AS C20, (PE.C21) AS C21, (PE.C22) AS C22,
                S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22,
                SC.A1, SC.A2, SC.A3, SC.A4, SC.A5, SC.A6, SC.A7, SC.A8, SC.A9, SC.A10, SC.A11, SC.A12, SC.A13, SC.A14, SC.A15, SC.A16, SC.A17, SC.A18, SC.A19, SC.A20, SC.A21, SC.A22,
                A.Grupo, FT.Articulo, A.Descripcion, U.Descripcion AS Unidad,
                PE.Pares
                FROM `pedidox` `PE`
                JOIN `fichatecnica` `FT` ON `FT`.`Estilo` =  `PE`.`Estilo` AND `FT`.`Color` = `PE`.`Color`
                JOIN `articulos` `A` ON `A`.`Clave` =  `FT`.`Articulo`
                JOIN `unidades` `U` ON `U`.`Clave` = `A`.`UnidadMedida`
                JOIN `estilos` `E` ON `E`.`Clave` = `PE`.`Estilo` AND E.Liberado = 2
                JOIN `series` `S` ON `S`.`Clave` =  `E`.`Serie`
                JOIN `suelascompras` `SC` ON `SC`.`ArticuloCBZ` =  `FT`.`Articulo`  AND S.Clave = SC.Serie
                WHERE `PE`.`Maquila` BETWEEN $Maquila AND $aMaquila
                AND `PE`.`Semana` BETWEEN $Semana AND $aSemana
                AND `PE`.`Ano` = '$Ano'
                AND `PE`.`Cliente` = '$Cliente'
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

}
