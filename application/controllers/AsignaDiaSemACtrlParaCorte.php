<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AsignaDiaSemACtrlParaCorte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AsignaDiaSemACtrlParaCorte_model', 'adscpc');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vEncabezado')->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vEncabezado')->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    $is_valid = true;
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vAsignaDiaSemACtrlParaCorte')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->adscpc->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCortadores() {
        try {
            print json_encode($this->adscpc->getCortadores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->adscpc->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProgramacion() {
        try {
            print json_encode($this->adscpc->getProgramacion());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->adscpc->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesAsignados() {
        try {
            print json_encode($this->adscpc->getControlesAsignados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            print json_encode($this->adscpc->getRegresos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->adscpc->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl() {
        try {
            print json_encode($this->adscpc->getParesXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            print json_encode($this->adscpc->getPieles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            print json_encode($this->adscpc->getForros(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            print json_encode($this->adscpc->getTextiles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            print json_encode($this->adscpc->getSinteticos(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo() {
        try {
            print json_encode($this->adscpc->getExplosionXSemanaControlFraccionArticulo($this->input->get('SEMANA'), $this->input->get('CONTROL'), $this->input->get('FRACCION'), $this->input->get('ARTICULO'), $this->input->get('GRUPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColorParesTxParPorControl() {
        try {
            $x = $this->input;
            print json_encode($this->adscpc->getEstiloColorParesTxParPorControl($x->get('CONTROL'), $x->get('TIPO')));
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
            $data = ($this->adscpc->getEstiloColorParesTxParPorControl($x->post('CONTROL'), $x->post('FRACCION')));
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
                /* Modificar en pedidox */
                $this->db->set('DiaProg', $x->post('DIA'))
                        ->set('SemProg', $x->post('Semana'))
                        ->set('AnioProg', $x->post('ANIO'))
                        ->set('FechaProg', Date('Y-m-d'))
                        ->set('HoraProg', Date('h:i:s'))
                        ->where('Control', $x->post('CONTROL'))
                        ->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
