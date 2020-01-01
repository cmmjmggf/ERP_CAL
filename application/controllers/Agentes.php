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
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    }

                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
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
            $xxx = $this->input->post();
            $data = array();
            foreach ($xxx as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            unset($data["Rangos"]);
            $this->Agentes_model->onModificar($xxx['ID'], $data);
            $rangos = json_decode($xxx['Rangos']);
            foreach ($rangos as $k => $v) {
                $check_agente = $this->db->query("SELECT COUNT(*) AS EXISTE FROM agentesporcentajes AS AP WHERE AP.Agente = {$xxx['Clave']} AND AP.Dias = '{$v->Dias}' AND AP.A = '{$v->A}' AND AP.Porcentaje = {$v->Porcentaje}")->result();
                if (intval($check_agente[0]->EXISTE) === 0) {
                    $this->db->insert('agentesporcentajes', array('Agente' => $xxx['Clave'], 'Dias' => $v->Dias, 'A' => $v->A, 'Porcentaje' => $v->Porcentaje));
                }
            }
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
