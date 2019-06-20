<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HojasDeEstudioTiempos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('HojasDeEstudioTiempos_model', 'hdetm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }
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
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vHojasDeEstudioTiempos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDepartamentosXEstilo() {
        try {
            print json_encode($this->hdetm->getDepartamentosXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarTiempoXEstiloDeptos() {
        try {
            print json_encode($this->hdetm->onComprobarTiempoXEstiloDeptos($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaXEstilo() {
        try {
            print json_encode($this->hdetm->getLineaXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHojasDeEstudioTiempos() {
        try {
            print json_encode($this->hdetm->getHojasDeEstudioTiempos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarTiempos() {
        try {
            $x = $this->input;
            $TIEMPOS = json_decode($x->post('TIEMPOS')); 
            switch ($x->post('N')) {
                case 0: 
                    $this->db->trans_start();
                    $this->db->insert('tiemposxestilodepto', array('Linea' => $x->post('LINEA'), 'Estilo' => $x->post('ESTILO')));
                    $row = $this->db->query('SELECT LAST_INSERT_ID()')->row_array();
                    $ID = $row['LAST_INSERT_ID()'];
                    $this->db->trans_complete();
                    $TOTAL = 0;
                    foreach ($TIEMPOS as $k => $v) {
                        $this->db->insert('tiemposxestilodepto_has_deptos', 
                                array('TiempoXEstiloDepto' => $ID, 'Departamento' => $v->DEPTO, 'Tiempo' => $v->DEPTOTIME, 'Fecha' => Date('d/m/Y h:i:s a')));
                        $TOTAL += $v->DEPTOTIME;
                    }
                    $this->db->set('Total', $TOTAL)->where('ID', $ID)->update('tiemposxestilodepto');
                    break;
                case 1: 
                    $TOTAL = 0;
                    foreach ($TIEMPOS as $k => $v) {
                        $EX = $this->hdetm->onComprobarDeptoXEstilo($x->post('ESTILO'), $v->DEPTO)[0]->EXISTE;
                        if (intval($EX) > 0) {
                            $this->db->set('Tiempo', $v->DEPTOTIME)
                                    ->where('TiempoXEstiloDepto', $x->post('ID'))
                                    ->where('Departamento', $v->DEPTO)
                                    ->update('tiemposxestilodepto_has_deptos');
                            $TOTAL += $v->DEPTOTIME;
                        } else {
                            $this->db->insert('tiemposxestilodepto_has_deptos', array('TiempoXEstiloDepto' => $x->post('ID'), 'Departamento' => $v->DEPTO, 'Tiempo' => $v->DEPTOTIME));
                            $TOTAL += $v->DEPTOTIME;
                        }
                    }
                    $this->db->set('Total', $TOTAL)->where('ID', $x->post('ID'))->update('tiemposxestilodepto');
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDeptosXEstilo() {
        try {
            $this->db->where('ID', $this->input->post('ID'))
                    ->delete('tiemposxestilodepto');
            $this->db->where('TiempoXEstiloDepto', $this->input->post('ID'))
                    ->delete('tiemposxestilodepto_has_deptos');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDeptoXEstilo() {
        try {
            $this->db->where('TiempoXEstiloDepto', $this->input->post('ID'))
                    ->where('ID', $this->input->post('IDD'))
                    ->delete('tiemposxestilodepto_has_deptos');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
