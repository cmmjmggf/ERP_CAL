<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AvanceTejido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->model('AvanceTejido_model', 'avtm');
    }

    public function index() {
        try {
            $is_valid = false;
            if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
                $this->load->view('vEncabezado');
                switch ($this->session->userdata["TipoAcceso"]) {
                    case 'SUPER ADMINISTRADOR':
                        $this->load->view('vNavGeneral')->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                    case 'ADMINISTRACION':
                        $this->load->view('vMenuAdministracion');
                        $is_valid = true;
                        break;
                    case 'PRODUCCION':
                        $this->load->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                }
                $dt["TYPE"] = 2;
                $this->load->view('vFondo')->view('vAvanceTejido')->view('vWatermark', $dt)->view('vFooter');
            }
            if (!$is_valid) {
                $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getChoferes() {
        try {
            print json_encode($this->avtm->getChoferes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->avtm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTejedoras() {
        try {
            print json_encode($this->avtm->getTejedoras());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->avtm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVale() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["DOCUMENTO"] = $this->input->post('DOCUMENTO');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\tejido\AvanceTejido.jasper');
        $jc->setFilename('CONTROLES_ENTREGADOS_A_TEJIDA' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento(Date('Y'), Date('m'), Date('d')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarNumeroDeDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento($this->input->post('DOCUMENTO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            print json_encode($this->avtm->getUltimoAvanceXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaTejido() {
        try {
            print json_encode($this->avtm->getControlesParaTejido());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnTejido() {
        try {
            print json_encode($this->avtm->getControlesEnTejido());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance() {
        try {
            print json_encode($this->avtm->onVerificarAvance($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            $this->db->insert('controltej', array(
                'numcho' => $x->post('NUM_CHOFER'),
                'nomcho' => $x->post('CHOFER'),
                'numtej' => $x->post('NUM_TEJEDORA'),
                'nomtej' => $x->post('TEJEDORA'),
                'fechapre' => $x->post('FECHA'),
                'control' => $x->post('CONTROL'),
                'estilo' => $x->post('ESTILO'),
                'color' => $x->post('COLOR'),
                'nomcolo' => $x->post('COLORT'),
                'docto' => $x->post('DOCUMENTO'),
                'pares' => $x->post('PARES'),
                'fechalle' => Date('d/m/Y h:i:s a'),
                'tipo' => 0,
                'fraccion' => $x->post('FRACCION')
            ));
            $this->db->insert('avance', array(
                'Control' => $x->post('CONTROL'),
                'FechaAProduccion' => $x->post('FECHA'),
                'Departamento' => 150,
                'DepartamentoT' => 'TEJIDO',
                'FechaAvance' => $x->post('FECHA')/* FECHA AVANCE */,
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => $x->post('FRACCION')
            ));
            $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')
                    ->where('Control', $x->post('CONTROL'))
                    ->update('controles');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
