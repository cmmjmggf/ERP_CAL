<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RastreoDeControlesEnDocumentos
 *
 * @author Y700
 */
class RastreoDeControlesEnDocumentos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RastreoDeControlesEnDocumentos_model', 'rced');
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
            }
            $this->load->view('vRastreoDeControlesEnDocumentos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->rced->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->rced->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidos() {
        try {
            print json_encode($this->rced->getPedidos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFechasDeAvance() {
        try {
            $x = $this->input->get();
            $this->db->select("A.ID, A.contped AS CONTROL, A.status, A.fec1 AS PREPROGRAMADO, date_format(A.fec2,'%d/%m/%Y') AS CORTE, 
                date_format(A.fec3,'%d/%m/%Y') AS RAYADO, date_format(A.fec33,'%d/%m/%Y') AS REBAJADO, date_format(A.fec4,'%d/%m/%Y') AS FOLEADO, date_format(A.fec40,'%d/%m/%Y') AS ENTRETELADO, date_format(A.fec42,'%d/%m/%Y') AS  MAQUILA, 
                date_format(A.fec44,'%d/%m/%Y') AS \"ALM-CORTE\", date_format(A.fec5,'%d/%m/%Y') AS PESPUNTE, date_format(A.fec55,'%d/%m/%Y') AS \"ALM-PESP\", date_format(A.fec6,'%d/%m/%Y') AS TEJIDO, 
                date_format(A.fec7,'%d/%m/%Y') AS \"ALM-TEJIDO\", date_format(A.fec8,'%d/%m/%Y') AS MONTADO, date_format(A.fec9,'%d/%m/%Y') AS  ADORNO, date_format(A.fec10,'%d/%m/%Y') AS \"ALM-ADORNO\", 
                date_format(A.fec11,'%d/%m/%Y') AS \"TERMINADO\", date_format(A.fec12,'%d/%m/%Y'), A.programado, A.corte, A.rayado, A.rebajado, A.foleado, A.pespunte, A.ensuelado, A.almpesp, A.tejido, A.almtejido, A.montado, A.adorno, A.almadorno, A.terminado, A.fec13, A.fec14, A.fec15, A.fec16, A.fec17, A.fec18", false)->from("avaprd AS A");
            if ($x['CONTROL'] !== '') {
                $this->db->where('contped', $x['CONTROL']);
            }else{
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnNomina() {
        try {
            $xi = $this->input;
            print json_encode(
                            $this->rced->getControlesEnNomina(
                                    $xi->get('CONTROL'),
                                    $xi->get('EMPLEADO'),
                                    $xi->get('FRACCION')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->rced->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->rced->getInfoXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
