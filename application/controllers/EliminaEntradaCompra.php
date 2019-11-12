<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class EliminaEntradaCompra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('EliminaEntradaCompra_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vEliminaEntradaCompra');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->EliminaEntradaCompra_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarDoctoCartProv() {
        try {
            print json_encode($this->EliminaEntradaCompra_model->onRevisarDoctoCartProv(
                                    $this->input->get('Doc'), $this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarDoctoCompra() {
        try {
            print json_encode($this->EliminaEntradaCompra_model->onRevisarDoctoCompra(
                                    $this->input->get('Doc'), $this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarCompra() {
        try {
            $this->EliminaEntradaCompra_model->onEliminarCartProv($this->input->post('Doc'), $this->input->post('Tp'), $this->input->post('Proveedor'));
            $this->EliminaEntradaCompra_model->onEliminarMovArt($this->input->post('Doc'), $this->input->post('Tp'), $this->input->post('Proveedor'));

            $Compra = $this->EliminaEntradaCompra_model->getCompra($this->input->post('Doc'), $this->input->post('Tp'), $this->input->post('Proveedor'));

            foreach ($Compra as $key => $v) {

                $this->EliminaEntradaCompra_model->onActualizarCantidadesOrdenCompra(
                        $this->input->post('Doc'), $v->TpOrdenCompra, $v->OrdenCompra, $this->input->post('Proveedor'), $v->Articulo, $v->Cantidad
                );
            }

            //Actualiza estatus orden de compra dependiendo de lo que elimina
            $Cantidades = $this->EliminaEntradaCompra_model->getCantidadesParaEstatus($Compra[0]->TpOrdenCompra, $Compra[0]->OrdenCompra);

            foreach ($Cantidades as $key => $v) {
                $can = $v->Cantidad;
                $Can_rec = $v->Cantidad_Rec;
                $ID = $v->ID;
                if ($Can_rec === '0' || $Can_rec === 0) {
                    $datos = array(
                        'Estatus' => 'ACTIVA'
                    );
                    $this->EliminaEntradaCompra_model->onModificarEstatusOrdenCompra($ID, $datos);
                } else if ($can > $Can_rec) {
                    $datos = array(
                        'Estatus' => 'PENDIENTE'
                    );
                    $this->EliminaEntradaCompra_model->onModificarEstatusOrdenCompra($ID, $datos);
                } else {
                    $datos = array(
                        'Estatus' => 'RECIBIDA'
                    );
                    $this->EliminaEntradaCompra_model->onModificarEstatusOrdenCompra($ID, $datos);
                }
            }

            //Eliminamos compra
            $this->EliminaEntradaCompra_model->onEliminarCompra($this->input->post('Doc'), $this->input->post('Tp'), $this->input->post('Proveedor'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
