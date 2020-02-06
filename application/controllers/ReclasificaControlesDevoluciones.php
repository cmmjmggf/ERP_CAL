<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReclasificaControlesDevoluciones extends CI_Controller {

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
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vReclasificaControlesDevoluciones')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarControlDevoluciones() {
        try {
            $control = $this->input->get('Control');
            print json_encode($this->db->query("select "
                                    . "d.cliente, "
                                    . "(select razons from clientes where clave = d.cliente) as nomcliente, "
                                    . "d.paredev, "
                                    . "d.estilo, "
                                    . "d.comb,"
                                    . "CASE
                                        WHEN d.clasif = 1 THEN '*** 1 PARA VENTA ***'
                                        WHEN d.clasif = 2 THEN '*** 2 SALDOS ***'
                                        WHEN d.clasif = 3 THEN '*** 3 REPARACION ***' END AS clasif,  "
                                    . "(select descripcion from colores where estilo = d.estilo and clave = d.comb) as nomcolor "
                                    . " from devolucionnp d where d.control = '$control' and stafac = 0 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReclasificaDevoluciones() {
        try {
            $control = $this->input->post('Control');
            $clasif = $this->input->post('Clasif');
            $this->db->query("update devolucionnp set clasif = '$clasif' where control = '$control' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
