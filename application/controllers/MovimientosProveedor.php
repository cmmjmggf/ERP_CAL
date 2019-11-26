<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class MovimientosProveedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('MovimientosProveedor_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'CONTABILIDAD') {
                        $this->load->view('vMenuContabilidad');
                    } else if ($Origen === 'PROVEEDORES') {
                        $this->load->view('vMenuProveedores');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    }

                    break;
                case 'PROVEEDORES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProveedores');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'MATERIALES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PRODUCPION':
                    $this->load->view('vNavGeneral')->view('vMenuProveedores');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vMovimientosProveedor');
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

    public function getRecords() {
        try {
            $proveedor = $this->input->post('Proveedor');
            print json_encode($this->db->query(" SELECT
                            CP.Proveedor,
                            CP.Doc,
                            date_format(str_to_date(CP.fechadoc, '%d/%m/%Y'),'%Y/%m/%d') as fechadoc,
                            CP.ImporteDoc,
                            CP.Pagos_Doc,
                            CP.Saldo_Doc,
                            CP.Tp,
                            CP.Estatus
                            FROM cartera_proveedores CP
                            where CP.Proveedor = $proveedor
                            ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagos() {
        try {
            $prov = $this->input->post('Proveedor');
            $doc = $this->input->post('Doc');
            $query = " SELECT
                            CP.Factura as remicion,
                            date_format(str_to_date(CP.fecha, '%d/%m/%Y'),'%Y/%m/%d') as fechacap,
                            CP.importe as importeP,
                            CP.DocPago
                            FROM pagosproveedores CP
                            where CP.Proveedor = $prov
                            ";
            if ($doc !== '') {
                $query .= "and CP.Factura = $doc ";
            }
            print json_encode($this->db->query($query)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->MovimientosProveedor_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
