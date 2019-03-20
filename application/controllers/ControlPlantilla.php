<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlPlantilla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ControlPlantilla_model', 'cpm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vControlPlantilla')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->cpm->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            print json_encode($this->cpm->getMaquilasPlantillas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresMaquilas() {
        try {
            print json_encode($this->cpm->getProveedoresMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->cpm->getUltimoDocumento(Date('Y'), Date('m'), Date('d')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->cpm->getInfoXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->cpm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXEstilo() {
        try {
            print json_encode($this->cpm->getFraccionesXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioXFraccionXEstilo() {
        try {
            print json_encode($this->cpm->getPrecioXFraccionXEstilo($this->input->get('FRACCION'), $this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            /*
             *  ESTATUS  
             *  1 = ENTREGADO A MAQUILA / EN PROCESO / EN TRANSITO
             *  2 = ENTREGADO/RECIBIDO/RETORNADO
             *  3 = PROCESADO COMO PLANTILLA
             */
            $x = $this->input;
            $this->db->insert('controlpla', array(
                'Proveedor' => $x->post('PROVEEDOR'),
                'Tipo' => $x->post('TIPO'),
                'Documento' => $x->post('DOCUMENTO'),
                'Control' => $x->post('CONTROL'),
                'Estilo' => $x->post('ESTILO'),
                'Color' => $x->post('COLOR'),
                'Pares' => $x->post('PARES'),
                'Fraccion' => $x->post('FRACCION'),
                'FraccionT' => $x->post('FRACCIONT'),
                'Precio' => $x->post('PRECIO'),
                'Fecha' => $x->post('FECHA'),
                'Registro' => Date('d/m/Y h:i:s a'),
                'Estatus' => 1));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
