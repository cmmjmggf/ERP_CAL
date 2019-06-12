<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RelojChecador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RelojChecador_model', 'ASM');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vRelojChecador', array('vigilancia' => 0))->view('vFooter');
    }

    public function getInformacionSemana() {
        try {
            print json_encode($this->ASM->getInformacionSemana(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAcceder() {
        try {
            $fecha = Date('Y-m-d');
            $Entrada_Salida = $this->ASM->onComprobarEntrada($this->input->post('Numero'), $fecha);
            $info_empleado = $this->ASM->getInformacionPorEmpleado($this->input->post('Numero'));
            $dtm = json_decode(json_encode($info_empleado), FALSE);

            if (count($dtm) > 0) {
                $es = array(
                    'numemp' => $this->input->post('Numero'),
                    'fecalta' => Date('Y-m-d h:i:s'),
                    'hora' => Date('h:i:s a'),
                    'nomemp' => $dtm[0]->Empleado,
                    'numdep' => $dtm[0]->DEPTO,
                    'nomdep' => $dtm[0]->DEPTOT,
                    'ampm' => Date('a'),
                    'año' => Date('Y'),
                    'semana' => $this->input->post('Semana'),
                    'reg' => $this->session->ID);
                switch (count($Entrada_Salida)) {
                    case 0:
                        $es['turno'] = 1;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 1:
                        $es['turno'] = 2;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 2:
                        $es['turno'] = 3;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 3:
                        $es['turno'] = 4;
                        $this->db->insert('relojchecador', $es);
                        break;
                }
                print json_encode($info_empleado);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
