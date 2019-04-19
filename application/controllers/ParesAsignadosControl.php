<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignadosControl extends CI_Controller {

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
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vParesAsignadosControl')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getParesAsignadosControl() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $parametros["MAQUILAINICIO"] = intval($x->post('MAQUILA_INICIAL'));
        $parametros["MAQUILAFIN"] = intval($x->post('MAQUILA_FINAL'));
        $parametros["SEMANAINICIO"] = intval($x->post('SEMANA_INICIAL'));
        $parametros["SEMANAFIN"] = intval($x->post('SEMANA_FINAL'));
        $parametros["ANO"] = intval($x->post('ANIO'));

        $jc->setParametros($parametros);
        $nrpt = $this->input->post('TIPO');
        $reports = array();

        if (intval($this->input->post('NUMERACION')) === 0) {
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosAMaquila.jasper');
            $jc->setFilename('ParesAsignadosAMaquila_' . $x->post('MAQUILA_FIN') . '_' . $x->post('MAQUILA_FIN') . '_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            $reports['PARESASIGNADOSAMAQUILA'] = $jc->getReport();
        }
        if (intval($this->input->post('NUMERACION')) === 1) {
            $jc->setJasperurl('jrxml\asignados\ParesAsignadosAMaquilaSerie.jasper');
            $jc->setFilename('ParesAsignadosAMaquilaSerie_' . $x->post('MAQUILA_FIN') . '_' . $x->post('MAQUILA_FIN') . '_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            $reports['PARESASIGNADOSAMAQUILA'] = $jc->getReport();
        }
        switch (intval($nrpt)) {
            case 1:
                $jc->setJasperurl('jrxml\asignados\ParesAsignadosAMaquilaEsponjasLatex.jasper');
                $jc->setFilename('ParesAsignadosAMaquilaEsponjasLatex_' . $x->post('MAQUILA_FIN') . '_' . $x->post('MAQUILA_FIN') . '_' . Date('h_i_s'));
                $jc->setDocumentformat('pdf');
                $reports['PARESASIGNADOSAMAQUILAESPONJALATEX'] = $jc->getReport();
                break; 
        }

        $jc->setJasperurl('jrxml\asignados\ParesAsignadosControlHerramental.jasper');
        $jc->setFilename('ParesAsignadosControlHerramental_' . $x->post('MAQUILA_FIN') . '_' . $x->post('MAQUILA_FIN') . '_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        $reports['PARESASIGNADOSAMAQUILAHERRAMENTAL'] = $jc->getReport();
        print json_encode($reports);
    }

}
