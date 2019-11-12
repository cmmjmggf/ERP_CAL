<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DesarrolloMuestras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('DesarrolloMuestras_model', 'dmm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
            if ($Origen === '') {
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
            }
            $this->load->view('vFondo')->view('vDesarrolloMuestras')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $x = $this->input->get();
//            print json_encode($this->dmm->getRecords($this->input->get('ESTILO'),
//            $this->input->get('COLOR')));

            $this->db->select('FT.ID, E.Clave AS Estilo, FT.Color, FT.Pieza AS Pza, '
                            . 'P.Descripcion AS PzaT, A.Clave AS Articulo, FT.Precio, '
                            . 'FT.Consumo AS Cons, FT.PzXPar, FT.Estatus, FT.FechaAlta, '
                            . 'FT.AfectaPV, P.Departamento AS Sec,'
                            . '(CASE WHEN P.Rango IS NULL THEN "" ELSE P.Rango END) AS Rango, '
                            . 'A.Descripcion AS ArticuloT, E.Linea AS Linea, E.Foto AS Foto', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave');
            if ($x['ESTILO'] !== '' && $x['COLOR'] !== '') {
                $this->db->where('E.Clave', $x['ESTILO'])->where('FT.Color', $x['COLOR']);
            } else {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMuestras() {
        try {
            print json_encode($this->dmm->getMuestras());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->dmm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFotoXEstilo() {
        try {
            print json_encode($this->dmm->getFotoXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            print json_encode($this->dmm->getDepartamentos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDesarrolloMuestra() {
        try {
            print json_encode($this->dmm->getDesarrolloMuestra($this->input->get('ESTILO'), $this->input->get('COLOR')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $data = array();
            foreach ($this->input->post() as $k => $v) {
                $data[$k] = ($v !== '') ? strtoupper($v) : NULL;
            }
            switch (intval($this->input->post('NUEVO'))) {
                case 1:
                    $data["Registro"] = Date('d/m/Y h:i:s a');
                    $data["Usuario"] = $this->session->ID;
                    $this->db->insert('desarrollo_muestras', $data);
                    break;
                case 2:
                    unset($data['NUEVO']);
                    $this->db->where('ID', $this->input->post('ID'))->update('desarrollo_muestras', $data);
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
