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
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuRecursosHumanos');
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
            print json_encode($this->Controlescancelados_model->getRecords());
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
            $pedido = $this->input->post('PEDIDO');
            $pedidodetalle = $this->input->post('PEDIDODETALLE');
            $motivo = strtoupper($this->input->post('MOTIVO'));
            $this->db->set('Cancelacion', Date('d/m/Y h:i:s a'))->set('Estatus', 'C')->set('Motivo', $motivo)->where('Pedido', $pedido)->where('PedidoDetalle', $pedidodetalle)->update('Controles');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarControlesPedido() {
        try {
            $controles = json_decode($this->input->post('Controles'));
            foreach ($controles as $k => $v) {
                $this->db->set('Cancelacion', Date('d/m/Y h:i:s a'))
                        ->set('Estatus', 'C')
                        ->set('Departamento', '490')
                        ->set('Motivo', strtoupper($v->Motivo))
                        ->where('Pedido', $v->Pedido)
                        ->where('PedidoDetalle', $v->PedidoDetalle)->update('Controles');
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
