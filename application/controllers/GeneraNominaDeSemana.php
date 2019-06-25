<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraNominaDeSemana extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('GeneraNominaDeSemana_model', 'dfm')->helper('jaspercommand_helper');
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->dfm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaPrenomina() {
        try {
            print json_encode($this->dfm->getSemanaPrenomina($this->input->get('SEMANA'), $this->input->get('ANIO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNominaCerrada() {
        try {
            $x = $this->input;
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $p["SEMANA"] = $x->post('SEMANA');
            $p["FECHAINI"] = $x->post('FECHAINI');
            $p["FECHAFIN"] = $x->post('FECHAFIN');
            $p["ANIO"] = $x->post('ANIO');
            $jc->setParametros($p);

            $reports = array();

            $jc->setJasperurl('jrxml\prenomina\prenoml.jasper');
            $jc->setFilename('GeneraNominaDeSemana_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['GENERANOMINADESEMANA'] = $jc->getReport();

            $jc->setJasperurl('jrxml\prenomina\prenomlt.jasper');
            $jc->setFilename('GeneraNominaDeSemanaXDepto_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['GENERANOMINADESEMANAXDEPTO'] = $jc->getReport();
            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
