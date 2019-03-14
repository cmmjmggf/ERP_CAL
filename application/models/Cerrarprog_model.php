<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Cerrarprog_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($MAQUILA, $SEMANA, $ANO) {
        try {
            $this->db->select('PD.ID AS ID, '
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
                            . "CONCAT(S.PuntoInicial ,'/',S.PuntoFinal) AS Serie, "
                            . "PD.Ano AS Anio,"
                            . " CASE "
                            . "WHEN PD.Control IS NULL THEN '' "
                            . "WHEN PD.Control  = 0 THEN '' "
                            . "ELSE PD.Control END AS Marca, "
                            . "PD.Control AS Control,"
                            . "S.ID AS SerieID,"
                            . "PD.ID AS ID_PEDIDO", false)->from('pedidox AS PD')
                    ->join('controles AS CT', 'CT.pedidodetalle = PD.ID', 'left')
                    ->join('series AS S', 'PD.Serie = S.Clave')
                    ->where('PD.Control', 0);
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

    public function getHistorialDeControles() {
        try {
            return $this->db->select('PD.ID AS ID, '
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
                                    . "CONCAT(S.PuntoInicial ,'/',S.PuntoFinal) AS Serie, "
                                    . "PD.Ano AS Anio,"
                                    . " CASE "
                                    . "WHEN PD.Control IS NULL THEN '' "
                                    . "ELSE PD.Control END AS Marca, "
                                    . "CONCAT(CT.Ano, CT.Semana, CT.Maquila, CT.Consecutivo) AS Control,"
                                    . "S.ID AS SerieID,"
                                    . "PD.ID AS ID_PEDIDO", false)->from('pedidox AS PD')
                            ->join('series AS S', 'PD.Serie = S.Clave')
                            ->join('controles AS CT', 'CT.pedidodetalle = PD.ID')
                            ->where('PD.Control <> 0', null, false)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaximoConsecutivo($M, $S, $ID) {
        try {
            $this->db->select('CASE WHEN CT.Consecutivo IS NULL THEN 1 ELSE CT.Consecutivo+1 END AS MAX', false)
                    ->from('pedidox AS PD')
                    ->join('controles AS CT', 'CT.pedidodetalle = PD.ID', 'left')
                    ->where_not_in('PD.Control', array(0))->where('PD.Maquila', $M)->where('PD.Semana', $S);
            return $this->db->order_by('CT.Consecutivo', 'DESC')->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarControl($x) {
        try {
            $this->db->insert("controles", $x);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarHistorialControl($x) {
        try {
            $this->db->insert("historialcontroles", $x);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
