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

    public function onVerificarProveedor() {
        try {
            $Proveedor = $this->input->get('Proveedor');
            print json_encode($this->db->query("select clave from proveedores where clave = '$Proveedor ' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
                $cant = $v->Cantidad;
                $sql = "UPDATE ordencompra OC "
                        . "SET OC.CantidadRecibida =  (ifnull(OC.CantidadRecibida,0) - $cant) , "
                        . "OC.Factura = '' , "
                        . "OC.FechaFactura = '' "
                        . "WHERE OC.Tp = '{$v->TpOrdenCompra}' "
                        . "AND OC.Folio = '{$v->OrdenCompra}' "
                        . "AND OC.Proveedor = '{$this->input->post('Proveedor')}' "
                        . "AND OC.Articulo = '{$v->Articulo}' ";

                $this->db->query($sql);

                //Actualiza estatus orden de compra dependiendo de lo que elimina
                $sql_upd = "UPDATE ordencompra SET estatus = CASE
                                   WHEN CantidadRecibida = 0 THEN 'ACTIVA'
                                   WHEN Cantidad > CantidadRecibida THEN 'PENDIENTE'
                                   WHEN CantidadRecibida >= Cantidad THEN 'RECIBIDA'
                                   END
                               WHERE Tp = '{$v->TpOrdenCompra}' "
                        . "AND Folio = '{$v->OrdenCompra}' "
                        . "AND Proveedor = '{$this->input->post('Proveedor')}' "
                        . "AND Articulo = '{$v->Articulo}' ";

                $this->db->query($sql_upd);
            }


            //Eliminamos compra
            $this->EliminaEntradaCompra_model->onEliminarCompra($this->input->post('Doc'), $this->input->post('Tp'), $this->input->post('Proveedor'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
