
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class GenerarCostosFabricacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function onActualizarTotalEncabezado($est, $col, $maq) {
        try {
            $this->db->query("update estilosproceso
                                set totalmp =
                                (select sum(A.costomp)+ sum(A.costomo)+ sum(gastosdepto)
                                FROM
                                (
                               SELECT  EPD.depto, sum(EPD.costomp) as costomp, 0 costomo, EPD.gastosdepto
                                FROM estilosprocesod EPD where EPD.estilo = '$est' and EPD.color = '$col' and EPD.maq = '$maq'
                                group by depto
                                union all

                                select EPDMO.depto, 0 costomp, EPDMO.costo as costomo, 0 as gastosdepto
                                from estilosprocesodmo EPDMO
                                where EPDMO.estilo = '$est'
                                order by depto asc
                                ) AS A )
                                where estilo = '$est' and color = '$col' and maq = $maq ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onValidaExisteFichaTecnicaManoObra() {
        try {
            $this->db->select(" c.estilo,c.color, 'FT' as msg
                                FROM (
                                        select estilo, color from pedidox
                                        where CONCAT(Estilo,Color)  not in (select CONCAT(Estilo,Color) from fichatecnica)
                                        and estilo <> '0' and estilo is not null
                                                and estatus in ('A')
                                    ) AS c

                                union all

                                SELECT c.estilo,'' as color, 'MO' as msg
                                FROM (
                                        select estilo from pedidox
                                        where CONCAT(Estilo)  not in (select CONCAT(Estilo) from fraccionesxestilo)
                                        and estilo <> '0' and estilo is not null
                                                and estatus in ('A')
                                    ) AS c ; "
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

    public function getTablaDetalleParaInsert($est, $col, $maq) {
        try {
            $this->db->query("INSERT INTO estilosprocesod
                                (maq,
                                estilo,
                                color,
                                depto,
                                gastosdepto,
                                costomp)

                                SELECT
                                    maq, estilo, color, depto, gastosdepto, costomp
                                FROM

                                (SELECT
                                MA.Clave AS maq,
                                FT.Estilo as estilo,
                                FT.Color as color,
                                CAST(P.Departamento AS SIGNED ) AS depto,
                                (select GFD.costo from gastosfabricaxdepto GFD where GFD.clave = P.Departamento limit 1) as gastosdepto,
                                @desperdicio := CASE
                                WHEN E.PiezasCorte = 1 THEN MA.PorExtraXBotaAlta
                                WHEN E.PiezasCorte = 2 THEN MA.PorExtraXBota
                                WHEN E.PiezasCorte > 2 AND E.PiezasCorte <= 10 THEN MA.PorExtra3a10
                                WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN MA.PorExtra11a14
                                WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN MA.PorExtra15a18
                                WHEN E.PiezasCorte > 18 THEN MA.PorExtra19a ELSE 0 END as Desperdicio,
                                @costo := FT.Consumo *  PM.Precio as CostoSinDesp,
                                CASE WHEN G.Clave IN (1, 2) THEN
                                @costo + ((@costo) * @desperdicio)
                                ELSE
                                FT.Consumo *  PM.Precio
                                END AS costomp
                                FROM fichatecnica AS FT
                                JOIN piezas AS P ON P.Clave = FT.Pieza
                                JOIN articulos AS A ON A.Clave = FT.Articulo
                                JOIN grupos AS G ON G.Clave =  A.Grupo
                                JOIN preciosmaquilas AS PM ON PM.Articulo = FT.Articulo AND PM.Maquila = '$maq'
                                JOIN estilos E on FT.Estilo = E.Clave
                                join maquilas MA on MA.Clave = '$maq'
                                WHERE FT.Estilo = '$est'
                                AND FT.Color = '$col'
                                ORDER BY depto ASC) AS A");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTablaDetalleParaInsertManoObra($est) {
        try {
            $this->db->query("INSERT INTO estilosprocesodmo
                                (estilo,
                                depto,
                                costo)
                                select
                                FXE.Estilo,
                                CAST(F.Departamento AS SIGNED ) AS depto,
                                SUM(FXE.CostoMO) AS costomo
                                from
                                fraccionesxestilo  FXE
                                join fracciones AS F ON FXE.Fraccion = F.Clave
                                where FXE.Estilo = '$est'
                                and FXE.AfectaCostoVTA = 1
                                group by depto
                                order by depto ASC ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTablaEncabezadosManoObraParaInsert() {
        try {
            $this->db->select("EP.estilo  "
                            . " ", false)
                    ->from('estilosproceso AS EP')
                    ->group_by('EP.estilo')->order_by('EP.estilo', 'ASC');
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

    public function getTablaEncabezadosParaInsert() {
        try {
            $this->db->select("EP.maq, EP.linea AS linea, EP.estilo, EP.color, EP.colorT, EP.totalmp  "
                            . " ", false)
                    ->from('estilosproceso AS EP')
                    ->order_by('EP.maq', 'ASC')->order_by('EP.estilo', 'ASC')->order_by('EP.color', 'ASC');
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

    public function onCrearTablaConRegistrosEncabezado() {
        try {
            $this->db->query('truncate table estilosproceso');

            $this->db->query("INSERT INTO estilosproceso
                            (`linea`,
                            `estilo`,
                            `color`,
                            `colorT`,
                            `maq`,
                            `fecha`,
                            `totalmp`)
                            select E.Linea, E.Clave as Estilo, PE.Color ,PE.ColorT, PE.Maquila, now() as fecha, 0
                            from pedidox PE
                            join estilos E on E.Clave = PE.estilo
                            where PE.estilo <> '0' and PE.estilo is not null
                            and PE.estatus in ('A')
                            GROUP BY PE.Maquila, PE.estilo, PE.Color
                            order by PE.Maquila ASC, PE.estilo ASC, PE.Color ASC ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onLimpiarTabla() {
        try {
            $this->db->query('truncate table gastosfabricaxdepto');
            $this->db->query('INSERT INTO gastosfabricaxdepto (`clave`,`departamento`,`costo`)
              select cast(clave as signed) as clave, Descripcion ,0
              from departamentos where tipo = 1 order by clave asc ');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptosParaGastosDepto() {
        try {
            $this->db->select("clave, "
                            . "departamento, "
                            . "concat('<input type=''text'' class=''form-control form-control-sm'' onkeypress=''validate(event,this.value);'' onpaste= ''return false;''  value=''', costo ,''' onchange=''onChangeCosto(this.value,', clave ,')'' />')  "
                            . " AS costo,  "
                            . "costo as costoHide, "
                            . "'' as Eliminar "
                            . ""
                            . ""
                            . " ", false)
                    ->from('gastosfabricaxdepto')->order_by('clave', 'asc');

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

    public function getRecords() {
        try {
            $this->db->select(""
                            . "EP.maq as maq, "
                            . "EP.linea AS linea, "
                            . "EP.estilo as estilo, "
                            . "EP.color as color, EP.colorT, "
                            . "concat('$',cast(EP.totalmp as decimal(6,2))) as totalmp"
                            . ""
                            . " "
                            . " ", false)
                    ->from('estilosproceso AS EP');

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

    public function getDetalleByEstiloColorMaq($Est, $Col, $Maq) {
        try {
            return $this->db->select("
                                    concat(A.depto,' ',D.Descripcion) as depto, sum(A.costomp) as costomp, sum(A.costomo) as costomo, sum(gastosdepto) as gastos,
                                    sum(A.costomp)+ sum(A.costomo)+ sum(gastosdepto) as total, A.depto as orden
                                    FROM
                                    (
                                    SELECT  depto,
                                    sum(costomp) as costomp, 0 costomo, gastosdepto
                                    FROM estilosprocesod
                                    where estilo = '$Est' and color = '$Col' and maq = '$Maq'
                                    group by depto

                                    union all

                                    select depto,0 costomp, costo as costomo , 0 as gastosdepto
                                    from estilosprocesodmo where estilo = '$Est'
                                    order by depto asc
                                    ) AS A
                                    join departamentos D on D.Clave = A.depto
                                    group by A.depto order by A.depto "
                            . ''
                            . '', false)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
