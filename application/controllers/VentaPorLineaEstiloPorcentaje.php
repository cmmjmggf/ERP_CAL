<?php

class VentaPorLineaEstiloPorcentaje extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEstilosXLinea() {
        try {
            $LINEA = $this->input->get('LINEA'); 
            print json_encode($this->db->query("SELECT  E.Clave AS CLAVE_ESTILO, E.Descripcion AS DESCRIPCION_ESTILO FROM estilos AS E WHERE E.Linea = {$LINEA} ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
