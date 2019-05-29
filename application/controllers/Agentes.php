<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Agentes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Agentes_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
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

            $this->load->view('vFondo')->view('vAgentes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Agentes_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgentesSelect() {
        try {
            print json_encode($this->Agentes_model->getAgentesSelect());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Agentes_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgenteByID() {
        try {
            print json_encode($this->Agentes_model->getAgenteByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleByID() {
        try {
            print json_encode($this->Agentes_model->getDetalleByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["Rangos"]);
            $this->Agentes_model->onAgregar($data);
            $rangos = json_decode($this->input->post('Rangos'));
            foreach ($rangos as $k => $v) {
                $this->db->insert('agentesporcentajes', array('Agente' => $this->input->post('Clave'), 'Dias' => $v->Dias, 'A' => $v->A, 'Porcentaje' => $v->Porcentaje));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            unset($data["Rangos"]);
            $this->Agentes_model->onModificar($x->post('ID'), $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalle() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('agentesporcentajes');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
