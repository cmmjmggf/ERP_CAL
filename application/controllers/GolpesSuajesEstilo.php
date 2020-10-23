<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class GolpesSuajesEstilo extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaAsistencias_model')->model('SemanasNomina_model')->model('Departamentos_model')->helper('file')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vGolpesSuajesEstilo')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onAgregarInfoSuajes() {
        try {
            $x = $this->input;
            $A = $this->db->query("select * from golpessuajesestilo where estilo = '{$x->post('estilo')}' ")->result();
            $linea = $this->db->query("select linea from estilos where clave = '{$x->post('estilo')}' ")->result()[0]->linea;
            $fechapiel = str_replace('/', '-', $x->post('fechaaltasuajepiel'));
            $nuevaFechapiel = date("Y-m-d", strtotime($fechapiel));
            $fechaforro = str_replace('/', '-', $x->post('fechaaltasuajeforro'));
            $nuevaFechaIforro = date("Y-m-d", strtotime($fechaforro));
            $costopiel = $x->post('costopiel');
            $proveedorpiel = $x->post('proveedorpiel');
            $facturapiel = $x->post('facturapiel');

            $costoforro = $x->post('costoforro');
            $proveedorforro = $x->post('proveedorforro');
            $facturaforro = $x->post('facturaforro');

            if (!empty($A)) {
                $this->db->where('estilo', $x->post('estilo'));
                $this->db->update("golpessuajesestilo", array(
                    'costopiel' => $costopiel,
                    'proveedorpiel' => $proveedorpiel,
                    'facturapiel' => $facturapiel,
                    'costoforro' => $costoforro,
                    'proveedorforro' => $proveedorforro,
                    'facturaforro' => $facturaforro,
                    'fechaaltasuajepiel' => $nuevaFechapiel,
                    'fechaaltasuajeforro' => $nuevaFechaIforro
                ));
            } else {
                $this->db->insert("golpessuajesestilo", array(
                    'linea' => $linea,
                    'estilo' => $x->post('estilo'),
                    'fechaaltasuajepiel' => $nuevaFechapiel,
                    'fechaaltasuajeforro' => $nuevaFechaIforro,
                    'costopiel' => $costopiel,
                    'proveedorpiel' => $proveedorpiel,
                    'facturapiel' => $facturapiel,
                    'costoforro' => $costoforro,
                    'proveedorforro' => $proveedorforro,
                    'facturaforro' => $facturaforro
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->db->query("select "
                                    . "ID, "
                                    . "estilo,"
                                    . "date_format(fechaaltasuajepiel,'%d/%m/%Y') as fechaaltasuajepiel,"
                                    . "proveedorpiel,"
                                    . "facturapiel,"
                                    . "costopiel,"
                                    . "date_format(fechaaltasuajeforro,'%d/%m/%Y') as fechaaltasuajeforro,"
                                    . "proveedorforro,"
                                    . "facturaforro,"
                                    . "costoforro,"
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg text-danger" onclick="onEliminarByID(\',ID,\')">\',\'</span>\') AS BTN '
                                    . " from golpessuajesestilo ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarByID() {
        try {
            $ID = $this->input->post('ID');
            $this->db->query("delete from golpessuajesestilo where ID = {$ID} ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporteSuajes() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["linea"] = $this->input->post('linea');
            $jc->setJasperurl('jrxml\suajes\reporteGolpesSuajes.jasper');
            $jc->setParametros($parametros);
            $jc->setFilename('REPORTE_SUAJES_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
