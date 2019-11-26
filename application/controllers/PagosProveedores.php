<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class PagosProveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('PagosProveedores_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'CONTABILIDAD') {
                        $this->load->view('vMenuContabilidad');
                    } else if ($Origen === 'PROVEEDORES') {
                        $this->load->view('vMenuProveedores');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PROVEEDORES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProveedores');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProveedores');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vPagosProveedores');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onVerificarBanco() {
        try {
            $Tp = $this->input->get('Tp');
            $Banco = $this->input->get('Banco');
            print json_encode($this->db->query("select clave from bancos where clave = '$Banco' and Tp = $Tp and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarProveedor() {
        try {
            $Proveedor = $this->input->get('Proveedor');
            print json_encode($this->db->query("select clave from proveedores where clave = '$Proveedor ' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancos() {
        try {
            print json_encode($this->PagosProveedores_model->getBancos($this->input->get('Tp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->PagosProveedores_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosByTpByProveedor() {
        try {
            print json_encode($this->PagosProveedores_model->getDocumentosByTpByProveedor($this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            print json_encode($this->PagosProveedores_model->onVerificarExisteDocumento($this->input->get('Doc'), $this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            $datosPagoProv = array(
                'Proveedor' => $this->input->post('Proveedor'),
                'Factura' => $this->input->post('Factura'),
                'Fecha' => $this->input->post('Fecha'),
                'Importe' => $this->input->post('Importe'),
                'Tp' => $this->input->post('Tp'),
                'DocPago' => $this->input->post('DocPago'),
                'TipoPago' => $this->input->post('TipoPago'),
                'Banco' => $this->input->post('Banco'),
                'Estatus' => 'ACTIVO',
                'Registro' => Date('d/m/Y H:i:s'),
                'Usuario' => $this->session->userdata('ID')
            );

            $datosCartProv = array(
                'Proveedor' => $this->input->post('Proveedor'),
                'Factura' => $this->input->post('Factura'),
                'Importe' => $this->input->post('Importe'),
                'Tp' => $this->input->post('Tp'),
            );
            $this->PagosProveedores_model->onModificarSaldoCartera($datosCartProv);
            $this->PagosProveedores_model->onAgregar($datosPagoProv);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
