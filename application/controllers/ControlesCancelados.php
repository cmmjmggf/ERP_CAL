<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControlesCancelados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Controlescancelados_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vControlesCancelados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
//            print json_encode($this->Controlescancelados_model->getRecords());
            $x = $this->input->get();
            $a = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla\" align=\"center\">';
            $b = '</div><div class=\"col-12 cantidad\" align=\"center\">';
            $c = '</div></div>';
            $d = 'CASE WHEN';
            $e = 'THEN \'-\' ELSE ';
            $this->db->select("CT.ID AS CONTROLID, P.Clave PEDIDOID, P.Clave AS Pedido, "
                            . " CT.Cancelacion AS Cancelo, "
                            . "P.FechaEntrega AS 'Fecha Entrega', "
                            . "CONCAT(CL.Clave,' - ', SUBSTRING(CL.RazonS, 1, 24),'...')  AS Cliente, E.Clave AS Estilo, "
                            . "C.Clave AS Color, P.Semana AS Semana, P.Ano AS Anio,"
                            . "P.Maquila AS Maquila, P.Serie AS Serie, "
                            . "CONCAT('$a',($d S.T1='0' $e S.T1 END),'$b', ($d P.C1='0' $e P.C1 END),'$c') AS  C1,"
                            . "CONCAT('$a',($d S.T2='0' $e S.T2 END),'$b', ($d P.C2='0' $e P.C2 END),'$c') AS  C2,"
                            . "CONCAT('$a',($d S.T3='0' $e S.T3 END),'$b', ($d P.C3='0' $e P.C3 END),'$c') AS  C3,"
                            . "CONCAT('$a',($d S.T4='0' $e S.T4 END),'$b', ($d P.C4='0' $e P.C4 END),'$c') AS  C4,"
                            . "CONCAT('$a',($d S.T5='0' $e S.T5 END),'$b', ($d P.C5='0' $e P.C5 END),'$c') AS  C5,"
                            . "CONCAT('$a',($d S.T6='0' $e S.T6 END),'$b', ($d P.C6='0' $e P.C6 END),'$c') AS  C6,"
                            . "CONCAT('$a',($d S.T7='0' $e S.T7 END),'$b', ($d P.C7='0' $e P.C7 END),'$c') AS  C7,"
                            . "CONCAT('$a',($d S.T8='0' $e S.T8 END),'$b', ($d P.C8='0' $e P.C8 END),'$c') AS  C8,"
                            . "CONCAT('$a',($d S.T9='0' $e S.T9 END),'$b', ($d P.C9='0' $e P.C9 END),'$c') AS  C9,"
                            . "CONCAT('$a',($d S.T10='0' $e S.T10 END),'$b', ($d P.C10='0' $e P.C10 END),'$c') AS  C10,"
                            . "CONCAT('$a',($d S.T11='0' $e S.T11 END),'$b', ($d P.C11='0' $e P.C11 END),'$c') AS  C11,"
                            . "CONCAT('$a',($d S.T12='0' $e S.T12 END),'$b', ($d P.C12='0' $e P.C12 END),'$c') AS  C12,"
                            . "CONCAT('$a',($d S.T13='0' $e S.T13 END),'$b', ($d P.C13='0' $e P.C13 END),'$c') AS  C13,"
                            . "CONCAT('$a',($d S.T14='0' $e S.T14 END),'$b', ($d P.C14='0' $e P.C14 END),'$c') AS  C14,"
                            . "CONCAT('$a',($d S.T15='0' $e S.T15 END),'$b', ($d P.C15='0' $e P.C15 END),'$c') AS  C15,"
                            . "CONCAT('$a',($d S.T16='0' $e S.T16 END),'$b', ($d P.C16='0' $e P.C16 END),'$c') AS  C16,"
                            . "CONCAT('$a',($d S.T17='0' $e S.T17 END),'$b', ($d P.C17='0' $e P.C17 END),'$c') AS  C17,"
                            . "CONCAT('$a',($d S.T18='0' $e S.T18 END),'$b', ($d P.C18='0' $e P.C18 END),'$c') AS  C18,"
                            . "CONCAT('$a',($d S.T19='0' $e S.T19 END),'$b', ($d P.C19='0' $e P.C19 END),'$c') AS  C19,"
                            . "CONCAT('$a',($d S.T20='0' $e S.T20 END),'$b', ($d P.C20='0' $e P.C20 END),'$c') AS  C20,"
                            . "CONCAT('$a',($d S.T21='0' $e S.T21 END),'$b', ($d P.C21='0' $e P.C21 END),'$c') AS  C21,"
                            . "CONCAT('$a',($d S.T22='0' $e S.T22 END),'$b', ($d P.C22='0' $e P.C22 END),'$c') AS  C22,"
                            . "P.Pares, P.Control,CONCAT(SUBSTRING( CT.Motivo, 1, 24),'...') AS Motivo, CT.Estatus AS ControlEstatus,"
                            . "(CASE WHEN CT.Estatus = 'A' THEN "
                            . "CONCAT('<button type=\"button\" class=\"btn btn-danger\" onclick=\"onCancelarControl(this,',P.Control,',',P.Clave,',',P.Clave,')\"><span class=\"fa fa-trash\"></span></button>') "
                            . " ELSE 'CANCELADO' END)AS CANCELA ", false)
                    ->from('pedidox AS P')
                    ->join('clientes AS CL', 'CL.Clave = P.Cliente')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('colores AS C', 'P.color = C.Clave AND C.Estilo = E.Clave')
                    ->join('series AS S', 'E.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.pedidodetalle = P.Clave')
                    ->where('P.stsavan <= 2', null, false);

            if ($x['MAQUILA'] !== '') {
                $this->db->where('P.Maquila', $x['MAQUILA']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('P.Semana', $x['SEMANA']);
            }
            if ($x['ANO'] !== '') {
                $this->db->where('P.Ano', $x['ANO']);
            }
            if ($x['PEDIDO'] !== '') {
                $this->db->where('P.Clave', $x['PEDIDO']);
            }
            if ($x['MAQUILA'] === '' && $x['SEMANA'] === '' && $x['ANO'] === '' && $x['PEDIDO'] === '') {
                $this->db->limit(50);
            } else {
                $this->db->limit(9999);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasDeProduccion() {
        try {
            print json_encode($this->Controlescancelados_model->getSemanasDeProduccion());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarMaquilaValida() {
        try {
            print json_encode($this->Controlescancelados_model->onChecarMaquilaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarControlPedido() {
        try {
//            $pedido = $this->input->post('PEDIDO');
//            $pedidodetalle = $this->input->post('PEDIDODETALLE');
//            $motivo = strtoupper($this->input->post('MOTIVO'));
//            $this->db->set('Cancelacion', Date('d/m/Y h:i:s a'))
//                    ->set('Estatus', 'C')->set('Motivo', $motivo)
//                    ->where('Pedido', $pedido)
//                    ->where('PedidoDetalle', $pedidodetalle)->update('Controles');
            $x = $this->input->post();
            if ($x['CONTROL'] !== '') {
                $this->db->select("CT.ID AS CONTROLID, P.ID PEDIDOID, P.Clave AS PEDIDO_CLAVE, "
                                . " CT.Cancelacion AS Cancelo, "
                                . "P.FechaEntrega AS 'Fecha Entrega', "
                                . "CONCAT(CL.Clave,' - ', SUBSTRING(CL.RazonS, 1, 24),'...')  AS Cliente, E.Clave AS Estilo, "
                                . "C.Clave AS Color, P.Semana AS Semana, P.Ano AS Anio,"
                                . "P.Maquila AS Maquila, P.Serie AS Serie, "
                                . "P.Pares, P.Control,CONCAT(SUBSTRING( CT.Motivo, 1, 24),'...') AS Motivo, "
                                . "CT.Estatus AS ControlEstatus", false)
                        ->from('pedidox AS P')
                        ->join('clientes AS CL', 'CL.Clave = P.Cliente')
                        ->join('estilos AS E', 'P.Estilo = E.Clave')
                        ->join('colores AS C', 'P.color = C.Clave AND C.Estilo = E.Clave')
                        ->join('series AS S', 'E.Serie = S.Clave')
                        ->join('controles AS CT', 'CT.pedidodetalle = P.Clave')
                        ->where('P.stsavan <= 2', null, false)
                        ->where('P.Clave', $x['PEDIDO'])
                        ->where('P.Control', $x['CONTROL'])->limit(1);

                foreach ($this->db->get()->result() as $k => $v) {
                    $this->db->set('Cancelacion', Date('d/m/Y h:i:s a'))
                            ->set('EstatusProduccion', 'CANCELADO')
                            ->set('DeptoProduccion', '270')
                            ->set('Motivo', strtoupper($x['MOTIVO']))
                            ->where('ID', $v->CONTROLID)
                            ->where('Pedido', $v->PEDIDO_CLAVE)
                            ->where('PedidoDetalle', $v->PEDIDO_CLAVE)->update('Controles');

                    $this->db->set('EstatusProduccion', 'CANCELADO')
                            ->set('DeptoProduccion', '270')->set('stsavan', 14)
                            ->where('ID', $v->PEDIDOID)->where('Control', $v->Control)
                            ->where('Clave', $v->PEDIDO_CLAVE)->update('pedidox');
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarControlesPedido() {
        try {
            $x = $this->input->post();
            $this->db->select("CT.ID AS CONTROLID, P.ID PEDIDOID, P.Clave AS PEDIDO_CLAVE, "
                            . " CT.Cancelacion AS Cancelo, "
                            . "P.FechaEntrega AS 'Fecha Entrega', "
                            . "CONCAT(CL.Clave,' - ', SUBSTRING(CL.RazonS, 1, 24),'...')  AS Cliente, E.Clave AS Estilo, "
                            . "C.Clave AS Color, P.Semana AS Semana, P.Ano AS Anio,"
                            . "P.Maquila AS Maquila, P.Serie AS Serie, "
                            . "P.Pares, P.Control,CONCAT(SUBSTRING( CT.Motivo, 1, 24),'...') AS Motivo, "
                            . "CT.Estatus AS ControlEstatus", false)
                    ->from('pedidox AS P')
                    ->join('clientes AS CL', 'CL.Clave = P.Cliente')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('colores AS C', 'P.color = C.Clave AND C.Estilo = E.Clave')
                    ->join('series AS S', 'E.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.pedidodetalle = P.Clave')
                    ->where('P.stsavan <= 2', null, false);
            if ($x['MAQUILA'] !== '') {
                $this->db->where('P.Maquila', $x['MAQUILA']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('P.Semana', $x['SEMANA']);
            }
            if ($x['ANO'] !== '') {
                $this->db->where('P.Ano', $x['ANO']);
            }
            if ($x['PEDIDO'] !== '') {
                $this->db->where('P.Clave', $x['PEDIDO']);
            }

            foreach ($this->db->get()->result() as $k => $v) {
                $this->db->set('Cancelacion', Date('d/m/Y h:i:s a'))
                        ->set('EstatusProduccion', 'CANCELADO')
                        ->set('DeptoProduccion', '270')
                        ->set('Motivo', strtoupper($x['MOTIVO']))
                        ->where('ID', $v->CONTROLID)
                        ->where('Pedido', $v->PEDIDO_CLAVE)
                        ->where('PedidoDetalle', $v->PEDIDO_CLAVE)->update('Controles');

                $this->db->set('EstatusProduccion', 'CANCELADO')
                        ->set('DeptoProduccion', '270')->set('stsavan', 14)
                        ->where('ID', $v->PEDIDOID)->where('Control', $v->Control)
                        ->where('Clave', $v->PEDIDO_CLAVE)->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->Controlescancelados_model->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
