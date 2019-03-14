<?php

/**
 * Description of AvancePespunteMaquila
 *
 * @author Y700
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AvancePespunteMaquila extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AvancePespunteMaquila_model', 'apm');
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
                $this->load->view('vFondo')->view('vAvancePespunteMaquila')->view('vWatermark', $dt)->view('vFooter');
            }
            if (!$is_valid) {
                $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->apm->getMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->apm->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaPespunte() {
        try {
            print json_encode($this->apm->getControlesParaPespunte());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnPespunte() {
        try {
            print json_encode($this->apm->getControlesEnPespunte());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->apm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance() {
        try {
            print json_encode($this->apm->onVerificarAvance($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoControl() {
        try {
            print json_encode($this->apm->getInfoControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            /* AVANCE A MAQUILA */
            $avance = array(
                'Control' => $x->post('CONTROL'),
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => 100,
                'DepartamentoT' => 'MAQUILA',
                'FechaAvance' => Date('d/m/Y'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => $x->post('FRACCION') /* INFORMATIVO */
            );
            $this->db->insert('avance', $avance);

            /* AVANCE A PESPUNTE */
            $avance["Departamento"] = 110;
            $avance["DepartamentoT"] = 'PESPUNTE';
            $avance["Fraccion"] = $x->post('FRACCION');
            $this->db->insert('avance', $avance);

            $pes = array(
                'numcho' => $x->post('MAQUILA'),
                'nomcho' => $x->post('MAQUILAT'),
                'fechapre' => $x->post('FECHA'),
                'control' => $x->post('CONTROL'),
                'estilo' => $x->post('ESTILO'),
                'color' => $x->post('COLOR'),
                'nomcolo' => $x->post('COLORT'),
                'docto' => $x->post('DOCTO'),
                'pares' => $x->post('PARES'),
                'fraccion' => $x->post('FRACCION')
            );
            $this->db->insert('controlpes', $pes);
            $this->db->set('EstatusProduccion', 'ALM-PESPUNTE')
                    ->where('Control', $x->post('CONTROL'))
                    ->update('controles');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAvanceMaquilaByID() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('controlpes');
            $this->db->where('ID', $this->input->post('IDA'))->delete('avance');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
