<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentosDirectosClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('DocumentosDirectosClientes_model', 'mddc');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vDocumentosDirectosClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->mddc->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $cliente = $this->input->post('Cliente');
            $tp = $this->input->post('Tp');
            print json_encode($this->db->query("select "
                                    . "cliente, remicion as docto, date_format(fecha,'%d/%m/%Y') as fecha, tipo, importe, pagos, saldo "
                                    . "from cartcliente "
                                    . "where cliente = $cliente and tipo = $tp ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            $doc = $this->input->get('Doc');
            $cliente = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query(" "
                                    . "select remicion "
                                    . "from cartcliente "
                                    . "where "
                                    . "remicion = $doc "
                                    . "and cliente = $cliente "
                                    . "and tipo = $tp "
                                    . "order by ID asc  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $Importe = $this->input->post('Importe');

            $fecha = str_replace('/', '-', $this->input->post('FechaDoc'));
            $nuevaFecha = date("Y-m-d", strtotime($fecha));

            $datosCartCte = array(
                'cliente' => $this->input->post('Cliente'),
                'remicion' => $this->input->post('Doc'),
                'fecha' => $nuevaFecha,
                'tipo' => $this->input->post('Tp'),
                'importe' => $Importe,
                'pagos' => 0,
                'saldo' => $Importe,
                'status' => 1,
                'numcia' => 0,
                'numpol' => 0
            );
            $this->db->insert('cartcliente', $datosCartCte);
            /* GUARDAMOS EN FACTURACION EL DOCUMENTO */
            $datosFacturacion = array(
                'cliente' => $this->input->post('Cliente'),
                'factura' => $this->input->post('Doc'),
                'fecha' => $nuevaFecha,
                'tp' => $this->input->post('Tp'),
                'pareped' => 1,
                'estilo' => $this->input->post('Concepto'),
                'combin' => 1,
                'precto' => ($this->input->post('Tp') === '1') ? $Importe / 1.16 : $Importe,
                'subtot' => ($this->input->post('Tp') === '1') ? $Importe / 1.16 : $Importe,
                'staped' => 2,
                'tmnda' => 1
            );
            $this->db->insert('facturacion', $datosFacturacion);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
