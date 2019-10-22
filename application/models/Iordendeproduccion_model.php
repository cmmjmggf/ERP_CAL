<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Iordendeproduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($CI, $CF) {
        try {
            $this->db->select('PD.Clave AS ID, '
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
                    ->join('clientes AS CL', 'CL.Clave = PD.Cliente', 'left')
                    ->join('estilos AS E', 'PD.Estilo = E.Clave')
                    ->join('colores AS C', 'PD.color = C.Clave AND C.Estilo = E.Clave')
                    ->join('series AS S', 'E.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.PedidoDetalle = PD.Clave')
                    ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.Clave', 'left')
                    ->where('PD.Control != 0', null, false);
            if ($CI !== '' && $CF !== '') {
                $this->db->where("OP.ControlT BETWEEN $CI AND $CF", null, false);
            }
            return $this->db->where('CT.Estatus', 'A')->limit(1000)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOrdenDeProduccionEntreControles($CONTROL_INICIAL, $CONTROL_FINAL, $SEMANA, $ANO) {
        try {
            $this->db->select("OP.Clave, OP.Cliente, OP.FechaEntrega, "
                            . "OP.FechaPedido, OP.Control, OP.ControlT, OP.Pedido, OP.Linea, "
                            . "OP.LineaT, OP.Recio, OP.Estilo, OP.EstiloT, OP.Color, "
                            . "OP.ColorT, OP.Agente, OP.Transporte, OP.Piel1, OP.CantidadPiel1, "
                            . "OP.Piel2, "
                            . "IFNULL(OP.CantidadPiel2,0) AS CantidadPiel2, "
                            . "CASE WHEN OP.Piel3 IS NULL THEN '' ELSE OP.Piel3 END AS Piel3,  "
                            . "IFNULL(OP.CantidadPiel3,0) AS CantidadPiel3, OP.Piel4, "
                            . "OP.CantidadPiel4, OP.Piel5, OP.CantidadPiel5, OP.Piel6, OP.CantidadPiel6, "
                            . "OP.TotalPiel, OP.Forro1, OP.CantidadForro1, OP.Forro2, OP.CantidadForro2, "
                            . "OP.Forro3, OP.CantidadForro3, OP.TotalForro, OP.Sintetico1, OP.CantidadSintetico1, "
                            . "OP.Sintetico2, OP.CantidadSintetico2, OP.Sintetico3, OP.CantidadSintetico3, OP.TotalSintetico, "
                            . "OP.Suela, OP.SuelaT, OP.Suaje, OP.SerieCorrida, "
                            . "OP.S1, OP.S2, OP.S3, OP.S4, OP.S5, OP.S6, OP.S7, OP.S8, OP.S9, OP.S10, "
                            . "OP.S11, OP.S12, OP.S13, OP.S14, OP.S15, OP.S16, OP.S17, OP.S18, OP.S19, OP.S20, "
                            . "OP.S21, OP.S22, "
                            . "OP.Horma, OP.Pares, "
                            . "OP.C1, OP.C2, OP.C3, OP.C4, OP.C5, OP.C6, OP.C7, OP.C8, OP.C9, OP.C10, "
                            . "OP.C11, OP.C12, OP.C13, OP.C14, OP.C15, OP.C16, OP.C17, OP.C18, OP.C19, OP.C20, "
                            . "OP.C21, OP.C22,"
                            . "OP.Observaciones,"
                            . "OP.ObservacionesDetalle,"
                            . "OP.EstatusProduccion, OPD.Departamento AS DEPARTAMENTO, "
                            . "OPD.DepartamentoT AS DEPARTAMENTOT, OPD.PiezaT AS PIEZA, "
                            . "OPD.ArticuloT AS ARTICULOT, OPD.PzXPar AS PZXPAR, "
                            . "OPD.UnidadMedidaT AS UNIDAD, FORMAT(OPD.Cantidad,2) AS CANTIDAD, "
                            . "(CASE "
                            . "WHEN OPD.PiezaClasificacion = 1 THEN ' - 1ra' "
                            . "WHEN OPD.PiezaClasificacion = 2 THEN ' - 2da' "
                            . "WHEN OPD.PiezaClasificacion = 3 THEN ' - 3ra' "
                            . " ELSE '' END) AS CLASIFICACION", false)
                    ->from('ordendeproduccion AS OP')
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($CONTROL_INICIAL !== '' && $CONTROL_FINAL !== '') {
                $this->db->where("OP.ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL", null, false);
            }
//            if ($SEMANA !== '') {
//                $this->db->where("OP.Semana", $SEMANA);
//            }
//            if ($ANO !== '') {
//                $this->db->where("OP.Ano", $ANO);
//            } 
            $this->db->order_by('ABS(OPD.Departamento)', 'ASC')->order_by('OPD.ArticuloT', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesXOrdenDeProduccionEntreControles($CONTROL_INICIAL, $CONTROL_FINAL, $SEMANA, $ANO) {
        try {
            $this->db->select("OP.Control, OP.ControlT, E.Foto AS FOTO, "
                            . "E.Observaciones AS OBSERVACIONES_ESTILO, C.ObservacionesOrdenProduccion AS OBSERVACIONES_COLOR", false)->from('ordendeproduccion AS OP')
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion')
                    ->join('estilos AS E', 'OP.Estilo = E.Clave', 'left')
                    ->join('colores AS C', 'OP.Color = C.Clave', 'left');
            if ($CONTROL_INICIAL !== '' && $CONTROL_FINAL !== '') {
                $this->db->where("OP.ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL", null, false);
            }
//            if ($SEMANA !== '') {
//                $this->db->where("OP.Semana", $SEMANA);
//            }
//            if ($ANO !== '') {
//                $this->db->where("OP.Ano", $ANO);
//            }
            $this->db->where('E.Clave = C.Estilo', null, false);
            $this->db->group_by(array('OP.ControlT'));
            $this->db->order_by('ABS(OP.ControlT)', 'ASC');
            $this->db->order_by('ABS(OPD.Departamento)', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentosXOrdenDeProduccionEntreControles($CONTROL_INICIAL, $CONTROL_FINAL, $SEMANA, $ANO) {
        try {
            $this->db->select("OPD.Departamento AS DEPARTAMENTO, OPD.DepartamentoT AS DEPARTAMENTOT", false)->from('ordendeproduccion AS OP')
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($CONTROL_INICIAL !== '' && $CONTROL_FINAL !== '') {
                $this->db->where("OP.ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL", null, false);
            }
            $this->db->group_by(array('Departamento'));
            $this->db->order_by('ABS(OPD.Departamento)', 'ASC');
            return $this->db->get()->result();
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

    public function onObtenerElUltimoControl($S, $M) {
        try {
            return $this->db->select("OP.ControlT AS ULTIMO_CONTROL")->from("ordendeproduccion AS OP")
                            ->where("OP.Semana", $S)->where("OP.Maquila", $M)->order_by('OP.ControlT', 'DESC')
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
