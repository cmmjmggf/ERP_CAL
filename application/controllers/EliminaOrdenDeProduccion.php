<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class EliminaOrdenDeProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Ordendeproduccion_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vEliminaOrdenDeProduccion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Ordendeproduccion_model->getRecordsGenerados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarEntreControles() {
        try {
            $CONTROL_INICIAL = $this->input->post('INICIO');
            $CONTROL_FINAL = $this->input->post('FIN');
            $this->db->trans_begin();
            $this->db->query("DELETE OPD.* FROM ordendeproducciond AS OPD 
                INNER JOIN OrdenDeProduccion AS OP 
                ON OPD.OrdenDeProduccion = OP.ID 
                WHERE OPD.ID > 0 AND OP.ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL");
            $this->db->query("DELETE FROM ordendeproduccion WHERE ID > 0 AND ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL");
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}