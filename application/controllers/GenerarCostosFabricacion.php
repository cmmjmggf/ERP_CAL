<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class GenerarCostosFabricacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('GenerarCostosFabricacion_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $Seguridad = isset($_SESSION["SEG"]) ? $_SESSION["SEG"] : '0';
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vFondo');

                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    } else if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }

                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }
            $this->load->view('vGenerarCostosFabricacion');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->GenerarCostosFabricacion_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptosParaGastosDepto() {
        try {
            print json_encode($this->GenerarCostosFabricacion_model->getDeptosParaGastosDepto());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChangeCosto() {
        try {
            $this->db->where('clave', $this->input->post('depto'));
            $this->db->update("gastosfabricaxdepto", array(
                'costo' => $this->input->post('costo')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onLimpiarTabla() {
        $this->GenerarCostosFabricacion_model->onLimpiarTabla();
    }

    public function onValidaExisteFichaTecnicaManoObra() {
        try {
            //Valida que existan todos los estilo-color en fichas tecnicas
            print json_encode($this->GenerarCostosFabricacion_model->onValidaExisteFichaTecnicaManoObra());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarCostosInventarioProceso() {
        $this->GenerarCostosFabricacion_model->onCrearTablaConRegistrosEncabezado();
        $DatosEnc = $this->GenerarCostosFabricacion_model->getTablaEncabezadosParaInsert();
        $DatosEncMO = $this->GenerarCostosFabricacion_model->getTablaEncabezadosManoObraParaInsert();
        $this->db->query('truncate table estilosprocesod');
        $this->db->query('truncate table estilosprocesodmo');

        foreach ($DatosEncMO as $key => $D) {
            $this->GenerarCostosFabricacion_model->getTablaDetalleParaInsertManoObra($D->estilo);
        }
        foreach ($DatosEnc as $key => $D) {
            $this->GenerarCostosFabricacion_model->getTablaDetalleParaInsert($D->estilo, $D->color, $D->maq);
            $this->GenerarCostosFabricacion_model->onActualizarTotalEncabezado($D->estilo, $D->color, $D->maq);
        }
    }

    public function getDetalleByEstiloColorMaq() {
        try {
            print json_encode($this->GenerarCostosFabricacion_model->getDetalleByEstiloColorMaq($this->input->get('estilo'), $this->input->get('color'), $this->input->get('maq')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
