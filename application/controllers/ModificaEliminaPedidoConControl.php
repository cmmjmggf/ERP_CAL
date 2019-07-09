<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";
defined('BASEPATH') OR exit('No direct script access allowed');

class ModificaEliminaPedidoConControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('ModificaEliminaPedidoConControl_model', 'mepcc')
                ->model('ModificaEliminaPedidoSinControl_model', 'meped')
                ->helper('parespreprogramados_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')
                    ->view('vNavGeneral')
                    ->view('vMenuClientes')
                    ->view('vModificaEliminaPedidoConControl')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getPedidoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.* FROM pedidox AS P WHERE P.Control LIKE '{$x["CONTROL"]}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')
                                    ->order_by('ABS(C.Clave)', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSerieXControl() {
        try {
            print json_encode($this->db->query("SELECT S.T1,S.T2,S.T3,S.T4,S.T5,S.T6,S.T7,S.T8,S.T9,S.T10,S.T11,S.T12,S.T13,S.T14,S.T15,S.T16,S.T17,S.T18,S.T19,S.T20,S.T21,S.T22 FROM series AS S WHERE S.Clave = {$this->input->get('SERIE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoByID() {
        try {
            $CONTROL = $this->input->get('CONTROL');
            $CLIENTE = $this->input->get('CLIENTE');
            $ini = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla\" align=\"center\">';
            $mid = '</div><div class="col-12 cantidad" align="center">';
            $end = '</div></div>';
            $this->db->select("P.ID as PDID,
                                    P.Clave AS Pedido,P.FechaPedido,P.Cliente,
                                    P.Estilo, P.EstiloT,
                                    P.Color, P.ColorT, P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio,
                                    P.Precio, P.Observacion, P.ObservacionDetalle, P.Serie, P.Control,

                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,

                                    'A' AS EstatusDetalle, P.Recibido,
                                    S.Clave AS Serie, P.Pares, 'A' AS EstatusD, (P.Pares * P.Precio) AS STT,
                                    CONCAT('{$ini}',(CASE WHEN S.T1 = 0 THEN '-' ELSE S.T1 END),'{$mid}',CASE WHEN P.C1 = 0 THEN '-' ELSE P.C1 END,'{$end}') AS T1,
                                    CONCAT('{$ini}',(CASE WHEN S.T2 = 0 THEN '-' ELSE S.T2 END),'{$mid}',CASE WHEN P.C2 = 0 THEN '-' ELSE P.C2 END,'{$end}') AS T2,
                                    CONCAT('{$ini}',(CASE WHEN S.T3 = 0 THEN '-' ELSE S.T3 END),'{$mid}',CASE WHEN P.C3 = 0 THEN '-' ELSE P.C3 END,'{$end}') AS T3,
                                    CONCAT('{$ini}',(CASE WHEN S.T4 = 0 THEN '-' ELSE S.T4 END),'{$mid}',CASE WHEN P.C4 = 0 THEN '-' ELSE P.C4 END,'{$end}') AS T4,
                                    CONCAT('{$ini}',(CASE WHEN S.T5 = 0 THEN '-' ELSE S.T5 END),'{$mid}',CASE WHEN P.C5 = 0 THEN '-' ELSE P.C5 END,'{$end}') AS T5,
                                    CONCAT('{$ini}',(CASE WHEN S.T6 = 0 THEN '-' ELSE S.T6 END),'{$mid}',CASE WHEN P.C6 = 0 THEN '-' ELSE P.C6 END,'{$end}') AS T6,
                                    CONCAT('{$ini}',(CASE WHEN S.T7 = 0 THEN '-' ELSE S.T7 END),'{$mid}',CASE WHEN P.C7 = 0 THEN '-' ELSE P.C7 END,'{$end}') AS T7,
                                    CONCAT('{$ini}',(CASE WHEN S.T8 = 0 THEN '-' ELSE S.T8 END),'{$mid}',CASE WHEN P.C8 = 0 THEN '-' ELSE P.C8 END,'{$end}') AS T8,
                                    CONCAT('{$ini}',(CASE WHEN S.T9 = 0 THEN '-' ELSE S.T9 END),'{$mid}',CASE WHEN P.C9 = 0 THEN '-' ELSE P.C9 END,'{$end}') AS T9,
                                    CONCAT('{$ini}',(CASE WHEN S.T10 = 0 THEN '-' ELSE S.T10 END),'{$mid}',CASE WHEN P.C10 = 0 THEN '-' ELSE P.C10 END,'{$end}') AS T10,
                                    CONCAT('{$ini}',(CASE WHEN S.T11 = 0 THEN '-' ELSE S.T11 END),'{$mid}',CASE WHEN P.C11 = 0 THEN '-' ELSE P.C11 END,'{$end}') AS T11,
                                    CONCAT('{$ini}',(CASE WHEN S.T12 = 0 THEN '-' ELSE S.T12 END),'{$mid}',CASE WHEN P.C12 = 0 THEN '-' ELSE P.C12 END,'{$end}') AS T12,
                                    CONCAT('{$ini}',(CASE WHEN S.T13 = 0 THEN '-' ELSE S.T13 END),'{$mid}',CASE WHEN P.C13 = 0 THEN '-' ELSE P.C13 END,'{$end}') AS T13,
                                    CONCAT('{$ini}',(CASE WHEN S.T14 = 0 THEN '-' ELSE S.T14 END),'{$mid}',CASE WHEN P.C14 = 0 THEN '-' ELSE P.C14 END,'{$end}') AS T14,
                                    CONCAT('{$ini}',(CASE WHEN S.T15 = 0 THEN '-' ELSE S.T15 END),'{$mid}',CASE WHEN P.C15 = 0 THEN '-' ELSE P.C15 END,'{$end}') AS T15,
                                    CONCAT('{$ini}',(CASE WHEN S.T16 = 0 THEN '-' ELSE S.T16 END),'{$mid}',CASE WHEN P.C16 = 0 THEN '-' ELSE P.C16 END,'{$end}') AS T16,
                                    CONCAT('{$ini}',(CASE WHEN S.T17 = 0 THEN '-' ELSE S.T17 END),'{$mid}',CASE WHEN P.C17 = 0 THEN '-' ELSE P.C17 END,'{$end}') AS T17,
                                    CONCAT('{$ini}',(CASE WHEN S.T18 = 0 THEN '-' ELSE S.T18 END),'{$mid}',CASE WHEN P.C18 = 0 THEN '-' ELSE P.C18 END,'{$end}') AS T18,
                                    CONCAT('{$ini}',(CASE WHEN S.T19 = 0 THEN '-' ELSE S.T19 END),'{$mid}',CASE WHEN P.C19 = 0 THEN '-' ELSE P.C19 END,'{$end}') AS T19,
                                    CONCAT('{$ini}',(CASE WHEN S.T20 = 0 THEN '-' ELSE S.T20 END),'{$mid}',CASE WHEN P.C20 = 0 THEN '-' ELSE P.C20 END,'{$end}') AS T20,
                                    CONCAT('{$ini}',(CASE WHEN S.T21 = 0 THEN '-' ELSE S.T21 END),'{$mid}',CASE WHEN P.C21 = 0 THEN '-' ELSE P.C21 END,'{$end}') AS T21,
                                    CONCAT('{$ini}',(CASE WHEN S.T22 = 0 THEN '-' ELSE S.T22 END),'{$mid}',CASE WHEN P.C22 = 0 THEN '-' ELSE P.C22 END,'{$end}') AS T22,
                                    CONCAT('<button type=\"button\" class=\"btn btn-danger\" onclick=\"onEliminar(this,2)\"><span class=\"fa fa-trash\"></span></button>') AS ELIMINAR ", false)->
                    from("pedidox AS P")->join("series AS S", "P.Serie = S.Clave");
            $this->db->where("P.Control <> 0", null, false);
            if ($CONTROL !== '' && $CONTROL !== "") {
                $this->db->where("P.Control", $CONTROL);
            } else if ($CLIENTE !== '' && $CLIENTE !== "") {
                $this->db->where("P.Cliente", $CLIENTE);
            } else {
                $this->db->order_by("P.Ano", "DESC")->order_by("P.Clave", "DESC")->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            /*
              pedidox
              controles
              avaprd
              avance
              asignapftsacxc
              controlpes
              controlpla
              controltej
              controlterm
              historialcontroles
             */
            $C = $this->input->post('CONTROL');
            $sql = "SELECT CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END";
            $PEDIDOX = $this->db->query("{$sql} AS TIENE_PEDIDO FROM pedidox AS PE WHERE PE.Control LIKE '{$C}'")->result();
            $CONTROLES = $this->db->query("{$sql} AS TIENE_PEDIDO FROM controles AS C WHERE C.Control LIKE '{$C}'")->result();
            $AVAPRD = $this->db->query("{$sql} AS TIENE_AVAPRD FROM avaprd AS AV WHERE AV.contped LIKE '{$C}'")->result();
            $AVANCE = $this->db->query("{$sql} AS TIENE_AVANCE FROM avance AS AVC WHERE AVC.Control LIKE '{$C}'")->result();
            $ASIGNAPFTSACXC = $this->db->query("{$sql} AS TIENE_ASIGNAPFTS FROM asignapftsacxc AS ASPFST WHERE ASPFST.Control LIKE '{$C}'")->result();
            $CONTROLPES = $this->db->query("{$sql} AS TIENE_CONTROLPES FROM controlpes AS CPS WHERE CPS.Control LIKE '{$C}'")->result();
            $CONTROLPLA = $this->db->query("{$sql} AS TIENE_CONTROLPLA FROM controlpla AS CPL WHERE CPL.Control LIKE '{$C}'")->result();
            $CONTROLTEJ = $this->db->query("{$sql} AS TIENE_CONTROLTEJ FROM controltej AS CTEJ WHERE CTEJ.Control LIKE '{$C}'")->result();
            $CONTROLTERM = $this->db->query("{$sql} AS TIENE_CONTROLTERM FROM controlterm AS CTERM WHERE CTERM.Control LIKE '{$C}'")->result();

//            $PEDIDOX = $this->db->query("SELECT CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS TIENE_PEDIDO FROM historialcontroles AS PE WHERE PE.Control LIKE '{$this->input->post('CONTROL')}'")->result();
//            $this->db->where('ID', $this->input->post('ID'))
//                    ->where('Clave', $this->input->post('CLAVE'))
//                    ->where('Control', $this->input->post('CONTROL'))
//                    ->delete('pedidox');
            var_dump($PEDIDOX, $CONTROLES, $AVAPRD, $AVANCE, $ASIGNAPFTSACXC, $CONTROLPES, $CONTROLPLA, $CONTROLTEJ, $CONTROLTERM);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    } 
}
