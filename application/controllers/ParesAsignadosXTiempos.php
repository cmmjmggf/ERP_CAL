<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignadosXTiempos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ParesAsignadosControl_model')->helper('jaspercommand_helper');
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
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'CLIENTES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vParesAsignadosXTiempos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getParesAsignadosControlXTiempos() {

        $x = $this->input->post();

        $programacion = $this->db->query("SELECT P.control AS CONTROL, P.estilo AS ESTILO, P.diaprg AS DIA, "
                        . "P.semana AS SEMANA, P.año AS ANIO, P.fecha AS FECHA "
                        . "FROM programacion AS P "
                        . "WHERE P.semana = '{$x['SEMANA']}' AND P.año = '{$x['ANIO']}'")->result();

        foreach ($programacion as $k => $v) {
            $this->db->set('DiaProg', $v->DIA)
                    ->set('SemProg', $v->SEMANA)
                    ->set('AnioProg', $v->ANIO)
                    ->set('FechaProg', $v->FECHA)
                    ->where('Control', $v->CONTROL)
                    ->where('Estilo', $v->ESTILO)
                    ->update('pedidox');
        }

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);

        $jc->setParametros(array("logo" => base_url() . $this->session->LOGO, "empresa" => $this->session->EMPRESA_RAZON,
            "MAQUILA" => intval($x['MAQUILA']), "SEMANA" => intval($x['SEMANA']),
            "DIA" => intval($x['DIA']), "ANO" => intval($x['ANIO'])));
        if ($x['DIA'] !== '') {
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosXTiemposYCapacidadesXMaqSem.jasper');
            $jc->setFilename('ParesAsignadosXTiemposYCapacidadesXMaqSem_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } else {
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosXTiemposYCapacidadesXMaqSemSinDia.jasper');
            $jc->setFilename('ParesAsignadosXTiemposYCapacidadesXMaqSem_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        }
    }

    public function getParesAsignadosControlXTiemposXLS() {

        $x = $this->input->post();

        $programacion = $this->db->query("SELECT P.control AS CONTROL, P.estilo AS ESTILO, P.diaprg AS DIA, "
                        . "P.semana AS SEMANA, P.año AS ANIO, P.fecha AS FECHA "
                        . "FROM programacion AS P "
                        . "WHERE P.semana = '{$x['SEMANA']}' AND P.año = '{$x['ANIO']}'")->result();

        foreach ($programacion as $k => $v) {
            $this->db->set('DiaProg', $v->DIA)
                    ->set('SemProg', $v->SEMANA)
                    ->set('AnioProg', $v->ANIO)
                    ->set('FechaProg', $v->FECHA)
                    ->where('Control', $v->CONTROL)
                    ->where('Estilo', $v->ESTILO)
                    ->update('pedidox');
        }

        if ($x['DIA'] !== '' && intval($x['DIA']) > 0) {

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $jc->setParametros(array("logo" => base_url() . $this->session->LOGO, "empresa" => $this->session->EMPRESA_RAZON,
                "MAQUILA" => intval($x['MAQUILA']), "SEMANA" => intval($x['SEMANA']),
                "DIA" => intval($x['DIA']), "ANO" => intval($x['ANIO'])));
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosXTiemposYCapacidadesXMaqSem.jasper');
            $jc->setFilename('ParesAsignadosXTiemposYCapacidadesXMaqSem_' . Date('h_i_s'));
            $jc->setDocumentformat('xls');
            print $jc->getReport();
        } else {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $jc->setParametros(array("logo" => base_url() . $this->session->LOGO, "empresa" => $this->session->EMPRESA_RAZON,
                "MAQUILA" => intval($x['MAQUILA']), "SEMANA" => intval($x['SEMANA']),
                "ANO" => intval($x['ANIO'])));
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosXTiemposYCapacidadesXMaqSemSinDia.jasper');
            $jc->setFilename('ParesAsignadosXTiemposYCapacidadesXMaqSem_' . Date('h_i_s'));
            $jc->setDocumentformat('xls');
            print $jc->getReport();
        }
    }

}
