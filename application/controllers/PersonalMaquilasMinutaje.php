<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class PersonalMaquilasMinutaje extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vPersonalMaquilasMinutaje')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
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
            $data['fecha'] = Date('Y-m-d');
            $this->db->insert("deptosmaq", $data);
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
            $data['fecha'] = Date('Y-m-d');
            unset($data["Maq"]);
            $this->db->where('numcia', $x->post('Maq'))->update("deptosmaq", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->where('numcia', $this->input->post('Maq'))->delete('deptosmaq');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            print json_encode($this->db->query("SELECT
                                                `numcia`,
                                                `dep10`,
                                                `dep15`,
                                                `dep20`,
                                                `dep24`,
                                                `dep35`,
                                                `dep40`,
                                                `dep45`,
                                                `dep46`,
                                                `dep60`,
                                                `dep80`,
                                                `dep82`,
                                                `dep90`,
                                                `dep91`,
                                                date_format(fecha,'%d/%m/%Y') as fecha, "
                                    . ' CONCAT(\'<span class="fa fa-trash fa-lg " onclick="onEliminar(\', numcia, \')">\', \'</span>\') AS eliminar '
                                    . " FROM `deptosmaq` where numcia > 0 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarMaquila() {
        try {
            $Maq = $this->input->get('Maq');
            print json_encode($this->db->query("select clave from maquilas where clave = '$Maq' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDeptosMaq() {
        try {
            $maq = $this->input->get('Maq');
            print json_encode($this->db->query("select * from deptosmaq where numcia = '$maq'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
