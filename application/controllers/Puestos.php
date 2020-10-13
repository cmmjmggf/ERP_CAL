<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Puestos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('file')->helper('array');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $Seguridad = isset($_SESSION["SEG"]) ? $_SESSION["SEG"] : '0';
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $this->load->view('vPuestos');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $this->load->view('vPuestos');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    $this->load->view('vPuestos');
                    break;
            }
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getID() {
        try {
            print json_encode($this->db->query("SELECT  CONVERT(Clave, UNSIGNED INTEGER) AS CLAVE FROM puestos ORDER BY ABS(clave) DESC LIMIT 1 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->db->query("select * from puestos ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPuestoByID() {
        try {
            $ID = $this->input->get('ID');
            print json_encode($this->db->query("select * from puestos where ID = {$ID} ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $data = array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'SueldoBase' => ($x->post('SueldoBase') !== NULL) ? $x->post('SueldoBase') : NULL
            );
            $this->db->insert("puestos", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array(
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'SueldoBase' => ($x->post('SueldoBase') !== NULL) ? $x->post('SueldoBase') : NULL
            );
            $this->db->where('ID', $x->post('ID'));
            $this->db->update("puestos", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
