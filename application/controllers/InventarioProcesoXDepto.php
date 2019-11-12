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
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
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
        $xxx = $this->input->post();
        $parametros["MAQUILA_INICIAL"] = intval($x->post('MAQUILA_INICIAL'));
        $parametros["MAQUILA_FINAL"] = intval($x->post('MAQUILA_FINAL'));
        $parametros["SEMANA_INICIAL"] = intval($x->post('SEMANA_INICIAL'));
        $parametros["SEMANA_FINAL"] = intval($x->post('SEMANA_FINAL'));
        $parametros["ANO"] = intval($x->post('ANIO'));

        $jc->setParametros($parametros);

        $avances = array(0, 1, 2, 3, 33, 4, 40, 42, 44, 5, 55, 6, 7, 8, 9, 10, 11, 12);
        $avances_txt = array(0 => "EN-PEDIDO", 1 => "PROGRAMADO", 2 => "CORTE", 3 => "RAYADO", 33 => "REBAJADO",
            4 => "FOLEADO", 40 => "ENTRETELADO", 42 => "MAQUILA", 44 => "ALM-CORTE",
            5 => "PESPUNTE", 55 => "ENSUELADO", 6 => "ALM-PESPUNTE", 7 => "TEJIDO",
            8 => "ALM-TEJIDO", 9 => "MONTADO", 10 => "ADORNO", 11 => "ALM-ADORNO", 12 => "TERMINADO");
        switch (intval($x->post('TIPO'))) {
            case 1:
                $this->db->query('TRUNCATE TABLE invxdeptodia');
                for ($i = intval($x->post('MAQUILA_INICIAL')); $i <= intval($x->post('MAQUILA_FINAL')); $i++) {
                    for ($ii = intval($x->post('SEMANA_INICIAL')); $ii <= intval($x->post('SEMANA_FINAL')); $ii++) {
                        foreach ($avances as $k => $v) {
                            $this->db->insert('invxdeptodia', array(
                                'ANIO' => $xxx['ANIO'],
                                'MAQUILA' => $i,
                                'SEMANA' => $ii,
                                'DEPTO' => $avances_txt[$v],
                                'DEPTOCLAVE' => $v
                            ));
                        }
                    }
                }

                $dias = 6;
                for ($i = intval($x->post('MAQUILA_INICIAL')); $i <= intval($x->post('MAQUILA_FINAL')); $i++) {
                    for ($ii = intval($x->post('SEMANA_INICIAL')); $ii <= intval($x->post('SEMANA_FINAL')); $ii++) {
                        foreach ($avances as $k => $v) {
                            for ($index = 0; $index < $dias; $index++) {
                                $sum_x_dia = $this->db->query("SELECT SUM(PP.Pares) AS PARES "
                                                . "FROM pedidox AS PP "
                                                . "WHERE PP.Maquila BETWEEN {$xxx['MAQUILA_INICIAL']} AND {$xxx['MAQUILA_FINAL']}  AND PP.Ano = {$xxx['ANIO']} "
                                                . "AND PP.Semana BETWEEN {$xxx['SEMANA_INICIAL']} AND {$xxx['SEMANA_FINAL']} AND PP.stsavan = {$v}  AND PP.DiaProg = {$index};")->result();

                                switch ($index) {
                                    case 0:
                                        $this->db->set('DOMINGO', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 1:
                                        $this->db->set('JUEVES', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 2:
                                        $this->db->set('VIERNES', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 3:
                                        $this->db->set('LUNES', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 4:
                                        $this->db->set('MARTES', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 5:
                                        $this->db->set('MIERCOLES', $sum_x_dia[0]->PARES)->where('MAQUILA', $i)->where('SEMANA', $ii)
                                                ->where('DEPTOCLAVE', $v)->update('invxdeptodia');
                                        break;
                                    case 6:

                                        break;
                                }
                            }
                        }
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
