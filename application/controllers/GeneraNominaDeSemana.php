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

            /*1. REPORTE DE PRENOMINA COMPLETO*/
            $jc->setJasperurl('jrxml\prenomina\prenoml.jasper');
            $jc->setFilename('GenNomDeSem_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();

            /*2. REPORTE DE PRENOMINA POR DEPARTAMENTO*/
            $jc->setJasperurl('jrxml\prenomina\prenomlt.jasper');
            $jc->setFilename('GenNomDeSemXDepto_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /*3. REPORTE DE TEJIDO*/
            $jc->setJasperurl('jrxml\prenomina\prenomltej.jasper');
            $jc->setFilename('GenNomDeSemXDeptoTej_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();

            /*4. REPORTE SIN TARJETA*/
            $jc->setJasperurl('jrxml\prenomina\prenomlst.jasper');
            $jc->setFilename('GenNomDeSemSinTarjeta_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['4CUATRO'] = $jc->getReport();

            /*5. REPORTE PRENOMINA FIS*/
            $jc->setJasperurl('jrxml\prenomina\prenomfis.jasper');
            $jc->setFilename('GenNomDeSemPreNomFis_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['5CINCO'] = $jc->getReport();

            /*6. REPORTE PRENOMINA FIS DOS (TJ = 1,ABONO_FIS = 0)*/
            $jc->setJasperurl('jrxml\prenomina\prenomfiszero.jasper');
            $jc->setFilename('GenNomDeSemPreNomFisZero_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['6SEIS'] = $jc->getReport();

            /*7. REPORTE PRENOMINA BANAMEX (ABONO NETO)*/
            $jc->setJasperurl('jrxml\prenomina\prenomfisbanamex.jasper');
            $jc->setFilename('GenNomDeSemPreNomBanamex_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['7SIETE'] = $jc->getReport();
            
            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
