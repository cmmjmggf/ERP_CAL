<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ModificaEliminaPedidoSinControl_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            return $this->db->select("E.Clave AS Clave,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Estilo")
                            ->from("estilos AS E")
                            ->where("E.Estatus", "ACTIVO")
                            ->order_by('E.Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresByEstilo($Estilo) {
        try {
            return $this->db->select("E.Clave AS Clave,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Color")
                            ->from("colores AS E")
                            ->where("E.Estatus", "ACTIVO")
                            ->where("E.Estilo", $Estilo)
                            ->order_by('abs(E.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosByID($ID) {
        try {
            $data = $this->db->select("P.Clave, P.Cliente, P.FechaPedido, P.ID,
                                    P.Estilo, P.Color,P.FechaEntrega, P.Maquila, P.Semana, P.Ano,
                                    P.Precio, P.Observacion, P.ObservacionDetalle, P.Serie,
                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,
                                    S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11,
                                    S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22,
                                    P.Pares ", false)
                            ->from('pedidox AS P')
                            ->join('series S', 'ON S.Clave = P.Serie')
                            ->where('P.ID', $ID)
                            ->limit(1)
                            ->get()->result();
//            print $this->db->last_query();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoDByID($ID, $CLIENTE) {
        try {
            $ini = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla\" align=\"center\">';
            $mid = '</div><div class="col-12 cantidad" align="center">';
            $end = '</div></div>';
            $data = $this->db->select("P.ID as PDID,
                                    P.Clave AS Pedido,
                                    P.Estilo, P.EstiloT,
                                    P.Color, P.ColorT, P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio,
                                    P.Precio, P.Observacion, P.ObservacionDetalle, P.Serie, P.Control,

                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,

                                    'A' AS EstatusDetalle, P.Recibido,
                                    S.Clave AS Serie, P.Pares, 'A' AS EstatusD, (P.Pares * P.Precio) AS STT,
                                    CONCAT('$ini',(CASE WHEN S.T1 = 0 THEN '-' ELSE S.T1 END),'$mid',CASE WHEN P.C1 = 0 THEN '-' ELSE P.C1 END,'$end') AS T1,
                                    CONCAT('$ini',(CASE WHEN S.T2 = 0 THEN '-' ELSE S.T2 END),'$mid',CASE WHEN P.C2 = 0 THEN '-' ELSE P.C2 END,'$end') AS T2,
                                    CONCAT('$ini',(CASE WHEN S.T3 = 0 THEN '-' ELSE S.T3 END),'$mid',CASE WHEN P.C3 = 0 THEN '-' ELSE P.C3 END,'$end') AS T3,
                                    CONCAT('$ini',(CASE WHEN S.T4 = 0 THEN '-' ELSE S.T4 END),'$mid',CASE WHEN P.C4 = 0 THEN '-' ELSE P.C4 END,'$end') AS T4,
                                    CONCAT('$ini',(CASE WHEN S.T5 = 0 THEN '-' ELSE S.T5 END),'$mid',CASE WHEN P.C5 = 0 THEN '-' ELSE P.C5 END,'$end') AS T5,
                                    CONCAT('$ini',(CASE WHEN S.T6 = 0 THEN '-' ELSE S.T6 END),'$mid',CASE WHEN P.C6 = 0 THEN '-' ELSE P.C6 END,'$end') AS T6,
                                    CONCAT('$ini',(CASE WHEN S.T7 = 0 THEN '-' ELSE S.T7 END),'$mid',CASE WHEN P.C7 = 0 THEN '-' ELSE P.C7 END,'$end') AS T7,
                                    CONCAT('$ini',(CASE WHEN S.T8 = 0 THEN '-' ELSE S.T8 END),'$mid',CASE WHEN P.C8 = 0 THEN '-' ELSE P.C8 END,'$end') AS T8,
                                    CONCAT('$ini',(CASE WHEN S.T9 = 0 THEN '-' ELSE S.T9 END),'$mid',CASE WHEN P.C9 = 0 THEN '-' ELSE P.C9 END,'$end') AS T9,
                                    CONCAT('$ini',(CASE WHEN S.T10 = 0 THEN '-' ELSE S.T10 END),'$mid',CASE WHEN P.C10 = 0 THEN '-' ELSE P.C10 END,'$end') AS T10,
                                    CONCAT('$ini',(CASE WHEN S.T11 = 0 THEN '-' ELSE S.T11 END),'$mid',CASE WHEN P.C11 = 0 THEN '-' ELSE P.C11 END,'$end') AS T11,
                                    CONCAT('$ini',(CASE WHEN S.T12 = 0 THEN '-' ELSE S.T12 END),'$mid',CASE WHEN P.C12 = 0 THEN '-' ELSE P.C12 END,'$end') AS T12,
                                    CONCAT('$ini',(CASE WHEN S.T13 = 0 THEN '-' ELSE S.T13 END),'$mid',CASE WHEN P.C13 = 0 THEN '-' ELSE P.C13 END,'$end') AS T13,
                                    CONCAT('$ini',(CASE WHEN S.T14 = 0 THEN '-' ELSE S.T14 END),'$mid',CASE WHEN P.C14 = 0 THEN '-' ELSE P.C14 END,'$end') AS T14,
                                    CONCAT('$ini',(CASE WHEN S.T15 = 0 THEN '-' ELSE S.T15 END),'$mid',CASE WHEN P.C15 = 0 THEN '-' ELSE P.C15 END,'$end') AS T15,
                                    CONCAT('$ini',(CASE WHEN S.T16 = 0 THEN '-' ELSE S.T16 END),'$mid',CASE WHEN P.C16 = 0 THEN '-' ELSE P.C16 END,'$end') AS T16,
                                    CONCAT('$ini',(CASE WHEN S.T17 = 0 THEN '-' ELSE S.T17 END),'$mid',CASE WHEN P.C17 = 0 THEN '-' ELSE P.C17 END,'$end') AS T17,
                                    CONCAT('$ini',(CASE WHEN S.T18 = 0 THEN '-' ELSE S.T18 END),'$mid',CASE WHEN P.C18 = 0 THEN '-' ELSE P.C18 END,'$end') AS T18,
                                    CONCAT('$ini',(CASE WHEN S.T19 = 0 THEN '-' ELSE S.T19 END),'$mid',CASE WHEN P.C19 = 0 THEN '-' ELSE P.C19 END,'$end') AS T19,
                                    CONCAT('$ini',(CASE WHEN S.T20 = 0 THEN '-' ELSE S.T20 END),'$mid',CASE WHEN P.C20 = 0 THEN '-' ELSE P.C20 END,'$end') AS T20,
                                    CONCAT('$ini',(CASE WHEN S.T21 = 0 THEN '-' ELSE S.T21 END),'$mid',CASE WHEN P.C21 = 0 THEN '-' ELSE P.C21 END,'$end') AS T21,
                                    CONCAT('$ini',(CASE WHEN S.T22 = 0 THEN '-' ELSE S.T22 END),'$mid',CASE WHEN P.C22 = 0 THEN '-' ELSE P.C22 END,'$end') AS T22,

                                    CONCAT('<button type=\"button\" class=\"btn btn-danger\" onclick=\"onEliminar(this,2)\"><span class=\"fa fa-trash\"></span></button>') AS ELIMINAR", false)
                            ->from('pedidox AS P')
                            ->join('series AS S', 'P.Serie = S.Clave')
                            ->order_by('abs(S.Clave)', 'ASC')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->get()->result();
//            print $this->db->last_query();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte */

    public function getMaquila() {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, CONCAT(M.Clave," - ", M.Nombre) AS MAQUILA, M.CapacidadPares AS CAPACIDAD_PARES', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            $this->db->group_by(array('M.Nombre'))->order_by('abs(P.Maquila)', 'ASC')->order_by('abs(P.Semana)', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosPorMaquila($M) {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, M.Nombre AS MAQUILA, '
                            . 'M.CapacidadPares AS CAPACIDAD_PARES, P.Semana AS SEMANA, '
                            . 'SUM(P.Pares) AS PARES, '
                            . 'M.CapacidadPares - SUM(P.Pares) AS DIFERENCIA', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where('M.Clave', $M)->where('P.Maquila', $M)
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            $this->db->group_by(array('M.Nombre', 'P.Semana'))
                    ->order_by('abs(P.Maquila)', 'ASC')
                    ->order_by('abs(P.Semana)', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
