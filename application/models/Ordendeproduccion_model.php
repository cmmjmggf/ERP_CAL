<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Ordendeproduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($MAQUILA, $SEMANA, $ANO) {
        try {
            $this->db->select('PD.Clave AS ID, '
                            . 'PD.Estilo AS IdEstilo, '
                            . 'PD.Color AS IdColor, '
                            . "PD.Estilo AS Estilo, "
                            . "PD.Estilo AS \"Descripcion Estilo\", "
                            . "PD.color AS Color, "
                            . "PD.color AS \"Descripcion Color\", "
                            . "PD.Clave AS Pedido,"
                            . "PD.FechaPedido AS \"Fecha Pedido\","
                            . "PD.FechaRecepcion AS \"Fecha Entrega\","
                            . "PD.Registro AS \"Fecha Captura\","
                            . "PD.Semana AS Semana,"
                            . "PD.Maquila AS Maq,"
                            . "PD.Cliente AS Cliente,"
                            . "PD.Cliente AS \"Cliente Razon\","
                            . "PD.Pares AS Pares,"
                            . "CONCAT('$',PD.Precio) AS Precio , "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Importe, "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Descuento,"
                            . "PD.FechaEntrega AS Entrega,"
                            . "PD.Serie AS Serie, "
                            . "PD.Ano AS Anio,"
                            . " CASE "
                            . "WHEN PD.Control IS NULL THEN '' "
                            . "ELSE PD.Control END AS Marca, "
                            . "CONCAT(RIGHT(CT.Ano,2), CT.Semana, CT.Maquila, CT.Consecutivo) AS Control,"
                            . "S.ID AS SerieID,"
                            . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                    ->join('clientes AS CL', 'CL.Clave = PD.Cliente', 'left')
                    ->join('series AS S', 'PD.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.PedidoDetalle = PD.Clave')
                    ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.Clave', 'left')
                    ->where('PD.Control <> 0 AND OP.ID IS NULL', null, false)
                    ->where('CT.Estatus', 'A');
            if ($ANO !== '') {
                $this->db->where('PD.Ano', $ANO);
            }
            if ($MAQUILA !== '') {
                $this->db->where('PD.Maquila', $MAQUILA);
            }
            if ($SEMANA !== '') {
                $this->db->where('PD.Semana', $SEMANA);
            }
            $sql = $this->db->get();
//            PRINT $this->db->last_query();
            return $sql->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecordsGenerados() {
        try {
            return $this->db->select('PD.Clave AS ID, '
                                    . 'PD.Estilo AS IdEstilo, '
                                    . 'PD.Color AS IdColor, '
                                    . "E.Clave AS Estilo, "
                                    . "E.Descripcion AS \"Descripcion Estilo\", "
                                    . "C.Clave AS Color, "
                                    . "C.Descripcion AS \"Descripcion Color\", "
                                    . "PD.Clave AS Pedido,"
                                    . "PD.FechaPedido AS \"Fecha Pedido\","
                                    . "PD.FechaRecepcion AS \"Fecha Entrega\","
                                    . "PD.Registro AS \"Fecha Captura\","
                                    . "PD.Semana AS Semana,"
                                    . "PD.Maquila AS Maq,"
                                    . "CL.Clave AS Cliente,"
                                    . "CL.RazonS AS \"Cliente Razon\","
                                    . "PD.Pares AS Pares,"
                                    . "CONCAT('$',PD.Precio) AS Precio , "
                                    . "CONCAT('$',(PD.Precio * PD.Pares)) AS Importe, "
                                    . "CONCAT('$',(PD.Precio * PD.Pares)) AS Descuento,"
                                    . "PD.FechaEntrega AS Entrega,"
                                    . "CONCAT(S.PuntoInicial ,'/',S.PuntoFinal) AS Serie, "
                                    . "PD.Ano AS Anio,"
                                    . " CASE "
                                    . "WHEN PD.Control IS NULL THEN '' "
                                    . "ELSE PD.Control END AS Marca, "
                                    . "CONCAT(CT.Ano, CT.Semana, CT.Maquila, CT.Consecutivo) AS Control,"
                                    . "S.ID AS SerieID,"
                                    . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                            ->join('clientes AS CL', 'CL.Clave = PD.Cliente')
                            ->join('estilos AS E', 'PD.Estilo = E.Clave')
                            ->join('colores AS C', 'PD.color = C.Clave AND C.Estilo = E.Clave')
                            ->join('series AS S', 'E.Serie = S.Clave')
                            ->join('controles AS CT', 'CT.PedidoDetalle = PD.Clave')
                            ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.Clave', 'left')
                            ->where('PD.Control != 0 AND OP.ID IS NOT NULL', null, false)
                            ->where('CT.Estatus', 'A')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosByMaquilaSemana($MAQUILA, $SEMANA, $ANO) {
        try {
            $this->db->select("P.Clave AS CLAVE_PEDIDO, P.Cliente CLAVE_CLIENTE, "
                            . "IFNULL(C.RazonS,\"Z FALTA AGREGAR EL CLIENTE\") AS CLIENTE, P.FechaPedido AS FECHA_PEDIDO, "
                            . "T.Descripcion AS TRANSPORTE, A.Nombre AGENTE, S.Clave AS SERIE,"
                            . "CT.ID AS CLAVE_CONTROL,"
                            . "S.T1, S.T2, S.T3, S.T4, S.T5,"
                            . "S.T6, S.T7, S.T8, S.T9, S.T10,"
                            . "S.T11, S.T12, S.T13, S.T14, S.T15,"
                            . "S.T16, S.T17, S.T18, S.T19, S.T20,"
                            . "S.T21,S.T22,L.Clave AS CLAVE_LINEA, L.Descripcion AS LINEA,"
                            . "E.Horma AS HORMA, E.Descripcion AS OESTILOT, CO.Descripcion AS OCOLORT, P.ID AS PEDIDO_DETALLE,"
                            . "P.*, P.Clave AS Pedido", false)
                    ->from('pedidox AS P')
                    ->join('clientes AS C', 'P.Cliente = C.Clave', 'left')
                    ->join('estilos AS E', 'P.Estilo = E.Clave', 'left')
                    ->join('colores AS CO', 'P.Color = CO.Clave', 'left')
                    ->join('agentes AS A', 'P.Agente = A.Clave', 'left')
                    ->join('transportes AS T', 'C.Transporte = T.Clave', 'left')
                    ->join('series AS S', 'P.Serie = S.Clave', 'left')
                    ->join('lineas AS L', 'E.Linea = L.Clave', 'left')
                    ->join('controles AS CT', 'CT.PedidoDetalle = P.ID', 'left')
                    ->join('ordendeproduccion AS OP', 'OP.Pedido = P.Clave  AND OP.PedidoDetalle = P.ID', 'left')
                    ->where('P.Maquila', $MAQUILA)
                    ->where('P.Semana', $SEMANA)
                    ->where('P.Ano', $ANO)
                    ->where('E.Clave = CO.Estilo AND CT.PedidoDetalle = P.ID AND CT.Estilo = E.Clave AND CT.Color = CO.Clave AND OP.ID IS NULL', null, false);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            PRINT $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPIEL_FORRO_SINTETICO_SUELA($ESTILO, $COLOR, $PARES) {
        try {
            $this->db->select("G.Clave, G.Nombre AS Grupo, A.Descripcion AS PIEL_FORRO_SINTETICO_SUELA ,
                            ((sum(FT.Consumo) * (
                            (CASE
                            WHEN  E.PiezasCorte BETWEEN 0 AND 10 AND A.Grupo IN(1,2) THEN M.PorExtra3a10
                            WHEN  E.PiezasCorte BETWEEN 11 AND 14  AND A.Grupo IN(1,2) THEN M.PorExtra11a14
                            WHEN  E.PiezasCorte BETWEEN 15 AND 18 AND A.Grupo IN(1,2) THEN M.PorExtra15a18
                            WHEN  E.PiezasCorte >=19  AND A.Grupo IN(1,2) THEN M.PorExtra19a
                            ELSE 0
                            END) +1)) * $PARES) AS CONSUMOTOTAL", false)
                    ->from('fichatecnica AS FT')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave')
                    ->join('maquilas AS M', 'E.Maquila = M.Clave')
                    ->join('grupos AS G ', 'A.Grupo = G.Clave')
                    ->where('FT.Estilo', $ESTILO)
                    ->where('FT.Color', $COLOR)
                    ->where_in('A.Grupo', array(1, 2, 40, 3))
                    ->group_by('A.Descripcion')
                    ->order_by('ABS(G.Clave)', 'ASC')
                    ->order_by('A.Descripcion', 'ASC');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            PRINT $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaParaOrdenDeProduccion($ESTILO, $COLOR, $PARES) {
        try {
            return $this->db->select("P.Clave AS PIEZA, P.Descripcion AS PIEZAT,
                                    A.Clave AS ARTICULO, A.Descripcion AS ARTICULOT,
                                    D.Clave AS DEPARTAMENTO, D.Descripcion AS DEPARTAMENTOT,
                                    FT.PzXPar AS PZXPAR, U.Clave AS UNIDAD, U.Descripcion AS UNIDADT,
                                    FT.Consumo AS CONSUMO, P.Clasificacion AS CLASIFICACION,
                                    ((SUM(FT.Consumo) * ((CASE
                                      WHEN  E.PiezasCorte BETWEEN 0 AND 10 AND A.Grupo IN(1,2) THEN M.PorExtra3a10
                                      WHEN  E.PiezasCorte BETWEEN 11 AND 14  AND A.Grupo IN(1,2) THEN M.PorExtra11a14
                                      WHEN  E.PiezasCorte BETWEEN 15 AND 18 AND A.Grupo IN(1,2) THEN M.PorExtra15a18
                                      WHEN  E.PiezasCorte >=19  AND A.Grupo IN(1,2) THEN M.PorExtra19a
                                      ELSE 0 END) +1)) * $PARES) AS CANTIDAD_CONSUMO, FT.Precio AS PRECIO,
                                    FT.AfectaPV AS AFECTAPV, A.Grupo AS GRUPO, A.Departamento AS DEPTOART", false)
                            ->from('fichatecnica AS FT')
                            ->join('articulos AS A', 'FT.Articulo = A.Clave')
                            ->join('estilos AS E', 'FT.Estilo = E.Clave')
                            ->join('maquilas AS M', 'E.Maquila = M.Clave')
                            ->join('piezas AS P', 'FT.Pieza = P.Clave')
                            ->join('departamentos AS D', 'P.Departamento = D.Clave')
                            ->join('unidades AS U', 'A.UnidadMedida = U.Clave')
                            ->where('FT.Estilo', $ESTILO)
                            ->where('FT.Color', $COLOR)
                            ->where_not_in('A.Grupo', 3)
                            ->group_by('P.Clave')
                            ->order_by('ABS(D.Clave)', 'ASC')
                            ->order_by('CANTIDAD_CONSUMO', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUID() {
        try {
            return $this->db->select("A.*", false)->from('agentes AS A')->order_by('A.ID', 'DESC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarMaquilaValida($ID) {
        try {
            return $this->db->select(" COUNT(*) AS Maquila")->from("maquilas AS M")->where("M.Clave", $ID)->where("M.Estatus", "ACTIVO")->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida($S) {
        try {
            return $this->db->select(" COUNT(*) AS Semana")->from("semanasproduccion AS S")->where("S.Sem", $S)->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
