<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DocDirecConAfectacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('DocDirectos_model');
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
            $this->load->view('vDocDirectosConAfectacion');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->DocDirectos_model->getRecords($this->input->post('Tp'), $this->input->post('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            print json_encode($this->DocDirectos_model->getGrupos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTipoCont() {
        try {
            print json_encode($this->DocDirectos_model->getTipoCont($this->input->get('Grupo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTipoCambio() {
        try {
            print json_encode($this->DocDirectos_model->getTipoCambio());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->DocDirectos_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            print json_encode($this->DocDirectos_model->onVerificarExisteDocumento($this->input->get('Doc'), $this->input->get('TpDoc'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->DocDirectos_model->onComprobarMaquilas($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $Importe = $this->input->post('Importe');
            $datosCartProv = array(
                'Proveedor' => $this->input->post('Proveedor'),
                'Doc' => $this->input->post('Doc'),
                'FechaDoc' => $this->input->post('FechaDoc'),
                'ImporteDoc' => ($this->input->post('Tp') === '1') ? $Importe * 1.16 : $Importe,
                'Pagos_Doc' => 0,
                'Saldo_Doc' => ($this->input->post('Tp') === '1') ? $Importe * 1.16 : $Importe,
                'Estatus' => 'SIN PAGAR',
                'Tp' => $this->input->post('Tp'),
                'Moneda' => $this->input->post('Moneda'),
                'TipoCambio' => ($this->input->post('TipoCambio') !== NULL) ? $this->input->post('TipoCambio') : 1,
                'Departamento' => '',
                'DocDirecto' => 1,
                'Grupo' => $this->input->post('Grupo'),
                'Flete' => $this->input->post('Flete'),
                'TipoContable' => $this->input->post('TipoCont'),
                'Estatus_Contable' => ''
            );
            $this->DocDirectos_model->onAgregar($datosCartProv);

            $maq = $this->input->post('Maq');
            $año = substr($this->input->post('FechaDoc'), -4);


            $datos = array(
                'Articulo' => '0',
                'PrecioMov' => $Importe,
                'CantidadMov' => 1,
                'FechaMov' => $this->input->post('FechaDoc'),
                'EntradaSalida' => '1',
                'TipoMov' => 'DIRECTO',
                'DocMov' => $this->input->post('Doc'),
                'Tp' => $this->input->post('Tp'),
                'Ano' => $año,
                'Maq' => $this->input->post('Maq'),
                'OrdenCompra' => '',
                'Subtotal' => $Importe,
                'Sem' => $this->input->post('Sem'),
                'ProvDocDirecto' => $this->input->post('Proveedor'),
            );

            if (intval($maq) === 97) {
                //Graba en movarticulos_fabrica
                $this->DocDirectos_model->onAgregarMovArtFabrica($datos);
            } else {
                //Graba en movarticulos
                $this->DocDirectos_model->onAgregarMovArt($datos);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
