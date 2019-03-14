<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AsignaDiaSemACtrlParaPespuntePreliminar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AsignaDiaSemACtrlParaPespuntePreliminar_model', 'adscppp');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
            }
            $this->load->view('vAsignaDiaSemACtrlParaPespuntePreliminar')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->adscppp->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCortadores() {
        try {
            print json_encode($this->adscppp->getCortadores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->adscppp->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getProgramacion() {
        try {
            print json_encode($this->adscppp->getProgramacion());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->adscppp->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesAsignados() {
        try {
            print json_encode($this->adscppp->getControlesAsignados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            print json_encode($this->adscppp->getRegresos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->adscppp->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl() {
        try {
            print json_encode($this->adscppp->getParesXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            print json_encode($this->adscppp->getPieles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            print json_encode($this->adscppp->getForros(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            print json_encode($this->adscppp->getTextiles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            print json_encode($this->adscppp->getSinteticos(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo() {
        try {
            print json_encode($this->adscppp->getExplosionXSemanaControlFraccionArticulo($this->input->get('SEMANA'), $this->input->get('CONTROL'), $this->input->get('FRACCION'), $this->input->get('ARTICULO'), $this->input->get('GRUPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColorParesTxParPorControl() {
        try {
            $x = $this->input;
            print json_encode($this->adscppp->getEstiloColorParesTxParPorControl($x->get('CONTROL'), $x->get('TIPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarAsignacionDeDiaXControl() {
        try {
            $x = $this->input;
            $data = array(
                'CORTADOR' => $x->post('CORTADOR'),
                'control' => $x->post('CONTROL'),
                'año' => $x->post('ANIO'),
                'semana' => $x->post('SEMANA'),
                'diaprg' => $x->post('DIA'),
                'frac' => $x->post('FRACCION'),
                'fecha' => Date('d/m/Y h:i:s a'),
                'estilo' => $x->post('ESTILO'),
                'par' => $x->post('PARES'),
                'tiempo' => $x->post('TIEMPO'),
                'precio' => $x->post('PRECIO'),
                'nomart' => $x->post('ARTICULO')
            );
            $this->db->insert('programacion', $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAsignacion() {
        try {
            $this->db->delete('programacion', array('ID' => $this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAnadirAsignacion() {
        try {
            $x = $this->input;
            $data = ($this->adscppp->getEstiloColorParesTxParPorControl($x->post('CONTROL'), $x->post('FRACCION')));
            print_r($data);
            if (isset($data[0])) {
                $r = $data[0];
                $dtm = array(
                    'numemp' => $x->post('CORTADOR'),
                    'control' => $x->post('CONTROL'),
                    'año' => $x->post('ANIO'),
                    'semana' => $x->post('Semana'),
                    'diaprg' => $x->post('DIA'),
                    'frac' => $x->post('FRACCION'),
                    'fecha' => Date('d/m/Y h:i:s a'),
                    'estilo' => $x->post('Estilo'),
                    'par' => $x->post('Pares'),
                    'tiempo' => $r->TIEMPO,
                    'precio' => $r->PRECIO,
                    'nomart' => $x->CLAVE_ARTICULO
                );
                $this->db->insert('programacion', $dtm);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
