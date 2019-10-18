<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Controlescancelados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $a = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla\" align=\"center\">';
            $b = '</div><div class=\"col-12 cantidad\" align=\"center\">';
            $c = '</div></div>';
            $d = 'CASE WHEN';
            $e = 'THEN \'-\' ELSE ';
            return $this->db->select("CT.ID AS CONTROLID, PD.Clave PEDIDOID, PE.Clave AS Pedido, "
                                    . " CT.Cancelacion AS Cancelo, "
                                    . "PD.FechaEntrega AS 'Fecha Entrega', "
                                    . "CONCAT(CL.Clave,' - ', SUBSTRING(CL.RazonS, 1, 24),'...')  AS Cliente, E.Clave AS Estilo, "
                                    . "C.Clave AS Color, PD.Semana AS Semana, PD.Ano AS Anio,"
                                    . "PD.Maquila AS Maquila, PD.Serie AS Serie, "
                                    . "CONCAT('$a',($d S.T1='0' $e S.T1 END),'$b', ($d PD.C1='0' $e PD.C1 END),'$c') AS  C1,"
                                    . "CONCAT('$a',($d S.T2='0' $e S.T2 END),'$b', ($d PD.C2='0' $e PD.C2 END),'$c') AS  C2,"
                                    . "CONCAT('$a',($d S.T3='0' $e S.T3 END),'$b', ($d PD.C3='0' $e PD.C3 END),'$c') AS  C3,"
                                    . "CONCAT('$a',($d S.T4='0' $e S.T4 END),'$b', ($d PD.C4='0' $e PD.C4 END),'$c') AS  C4,"
                                    . "CONCAT('$a',($d S.T5='0' $e S.T5 END),'$b', ($d PD.C5='0' $e PD.C5 END),'$c') AS  C5,"
                                    . "CONCAT('$a',($d S.T6='0' $e S.T6 END),'$b', ($d PD.C6='0' $e PD.C6 END),'$c') AS  C6,"
                                    . "CONCAT('$a',($d S.T7='0' $e S.T7 END),'$b', ($d PD.C7='0' $e PD.C7 END),'$c') AS  C7,"
                                    . "CONCAT('$a',($d S.T8='0' $e S.T8 END),'$b', ($d PD.C8='0' $e PD.C8 END),'$c') AS  C8,"
                                    . "CONCAT('$a',($d S.T9='0' $e S.T9 END),'$b', ($d PD.C9='0' $e PD.C9 END),'$c') AS  C9,"
                                    . "CONCAT('$a',($d S.T10='0' $e S.T10 END),'$b', ($d PD.C10='0' $e PD.C10 END),'$c') AS  C10,"
                                    . "CONCAT('$a',($d S.T11='0' $e S.T11 END),'$b', ($d PD.C11='0' $e PD.C11 END),'$c') AS  C11,"
                                    . "CONCAT('$a',($d S.T12='0' $e S.T12 END),'$b', ($d PD.C12='0' $e PD.C12 END),'$c') AS  C12,"
                                    . "CONCAT('$a',($d S.T13='0' $e S.T13 END),'$b', ($d PD.C13='0' $e PD.C13 END),'$c') AS  C13,"
                                    . "CONCAT('$a',($d S.T14='0' $e S.T14 END),'$b', ($d PD.C14='0' $e PD.C14 END),'$c') AS  C14,"
                                    . "CONCAT('$a',($d S.T15='0' $e S.T15 END),'$b', ($d PD.C15='0' $e PD.C15 END),'$c') AS  C15,"
                                    . "CONCAT('$a',($d S.T16='0' $e S.T16 END),'$b', ($d PD.C16='0' $e PD.C16 END),'$c') AS  C16,"
                                    . "CONCAT('$a',($d S.T17='0' $e S.T17 END),'$b', ($d PD.C17='0' $e PD.C17 END),'$c') AS  C17,"
                                    . "CONCAT('$a',($d S.T18='0' $e S.T18 END),'$b', ($d PD.C18='0' $e PD.C18 END),'$c') AS  C18,"
                                    . "CONCAT('$a',($d S.T19='0' $e S.T19 END),'$b', ($d PD.C19='0' $e PD.C19 END),'$c') AS  C19,"
                                    . "CONCAT('$a',($d S.T20='0' $e S.T20 END),'$b', ($d PD.C20='0' $e PD.C20 END),'$c') AS  C20,"
                                    . "CONCAT('$a',($d S.T21='0' $e S.T21 END),'$b', ($d PD.C21='0' $e PD.C21 END),'$c') AS  C21,"
                                    . "CONCAT('$a',($d S.T22='0' $e S.T22 END),'$b', ($d PD.C22='0' $e PD.C22 END),'$c') AS  C22,"
                                    . "PD.Pares, PD.Control,CONCAT(SUBSTRING( CT.Motivo, 1, 24),'...') AS Motivo, CT.Estatus AS ControlEstatus,"
                                    . "(CASE WHEN CT.Estatus = 'A' THEN "
                                    . "CONCAT('<button type=\"button\" class=\"btn btn-danger\" onclick=\"onCancelarControl(this,',CT.ID,',',PE.Clave,',',PD.Clave,')\"><span class=\"fa fa-trash\"></span>CANCELARX</button>') "
                                    . " ELSE 'CANCELADO' END)AS CANCELA ", false)
                            ->from('pedidodetalle AS PD')
                            ->join('pedidos AS PE', 'PD.Pedido = PE.Clave')
                            ->join('clientes AS CL', 'CL.Clave = PE.Cliente')
                            ->join('estilos AS E', 'PD.Estilo = E.Clave')
                            ->join('colores AS C', 'PD.color = C.Clave AND C.Estilo = E.Clave')
                            ->join('series AS S', 'E.Serie = S.Clave')
                            ->join('controles AS CT', 'CT.pedidodetalle = PD.Clave')
                            ->limit(999)
                            ->get()->result();
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

    public function getSemanasDeProduccion() {
        try {
            return $this->db->select("S.Sem AS Semana")->from("semanasproduccion AS S")->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
