<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultaArticulosEnFichasTecnicas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vConsultaArticulosEnFichasTecnicas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getEstilosPorArticulo() {
        try {
            $Articulo = $this->input->post('Articulo');
            $query = "SELECT ft.estilo, "
                    . "(select foto from estilos where clave = ft.estilo ) as foto "
                    . " FROM fichatecnica ft WHERE ft.articulo = '{$Articulo}'
                        GROUP BY ft.estilo ";
            print json_encode($this->db->query($query)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
