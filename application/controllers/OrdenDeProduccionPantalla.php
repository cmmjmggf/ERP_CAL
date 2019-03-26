<?php

class OrdenDeProduccionPantalla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('OrdenProduccionPantalla_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');

                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";


                    if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'FACTURACION') {
                        $this->load->view('vMenuFacturacion');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;

                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuRecursosHumanos');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vOrdenProduccionPantalla')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getOrdenProduccion() {
        try {
            print json_encode($this->OrdenProduccionPantalla_model->getOrdenProduccion($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
