<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class InventarioProcesoXDepto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
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
            $this->load->view('vFondo')->view('vInventarioProcesoXDepto')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getReporte() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $parametros["MAQUILA_INICIAL"] = intval($x->post('MAQUILA_INICIAL'));
        $parametros["MAQUILA_FINAL"] = intval($x->post('MAQUILA_FINAL'));
        $parametros["SEMANA_INICIAL"] = intval($x->post('SEMANA_INICIAL'));
        $parametros["SEMANA_FINAL"] = intval($x->post('SEMANA_FINAL'));
        $parametros["ANO"] = intval($x->post('ANIO'));

        $jc->setParametros($parametros);
        switch (intval($x->post('TIPO'))) {
            case 1:
                $this->db->query('TRUNCATE TABLE invxdeptodia');
                $deptos = $this->db->select("",false);
                for ($i = intval($x->post('MAQUILA_INICIAL')); $i <= intval($x->post('MAQUILA_FINAL')); $i++) {
                    for ($ii = intval($x->post('SEMANA_INICIAL')); $ii <= intval($x->post('SEMANA_FINAL')); $ii++) {
                        $this->db->insert('invxdeptodia', array(
                            'ANIO' => $x->post('ANIO'),
                            'MAQUILA' => $i,
                            'SEMANA' => $ii,
                            'DEPTO' => $ii
                        ));
                    }
                }

                $jc->setJasperurl('jrxml\inventarioxdepto\InventarioXDeptoDia.jasper');
                $jc->setFilename('InventarioXDeptoDia' . Date('h_i_s'));
                $jc->setDocumentformat('pdf');
                print $jc->getReport();
                break;
            case 2:
                $jc->setJasperurl('jrxml\inventarioxdepto\InventarioXDepto.jasper');
                $jc->setFilename('InventarioXDepto' . Date('h_i_s'));
                $jc->setDocumentformat('pdf');
                print $jc->getReport();
                break;
        }
    }

}
