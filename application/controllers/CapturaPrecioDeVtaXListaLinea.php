<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CapturaPrecioDeVtaXListaLinea extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('CapturaPrecioDeVtaXListaLinea_model', 'cpvta');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFacturacion');
                    break;
            }
            $this->load->view('vFondo')->view('vCapturaPrecioDeVtaXListaLinea')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $LINEA = $this->input->get('LINEA');
            $LISTA = $this->input->get('LISTA');
            $this->db->select("CVA.ID, CVA.lista AS LISTA, CVA.linea AS LINEA, CVA.estilo AS ESTILO, CVA.color AS COLOR, CVA.corr AS SERIE, CVA.colord AS \"TIPO DE PIEL\", FORMAT(CVA.preaut,2) AS PRECIO", false)
                    ->from("costovaria AS CVA");
            if ($LINEA !== '') {
                $this->db->where('CVA.linea', $LINEA);
            }
            if ($LISTA !== '') {
                $this->db->where('CVA.lista', $LISTA);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getListasDePrecios() {
        try {
            print json_encode($this->db->query("SELECT ID, Lista, Descripcion FROM listadeprecios AS LP ORDER BY ABS(LP.Lista) ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas() {
        try {
            print json_encode($this->db->select("L.Clave,CONCAT(L.Clave,'-',L.Descripcion) AS Linea")->from("lineas AS L")->where("L.Estatus", "ACTIVO")->order_by('ABS(L.Clave)', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarPrecio() {
        try {
            $x = $this->input->post();
            $this->db->set('preaut', $x['PRECIO'])
                    ->where('ID', $x['ID'])
                    ->update('costovaria');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarPrecioXEstiloLista() {
        try {
            $x = $this->input->post();
            if ($x['LISTAUNO'] !== '') {
                $this->db->set('preaut', $x['LISTAUNO'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 1)
                        ->update('costovaria');
            }
            if ($x['LISTADOS'] !== '') {
                $this->db->set('preaut', $x['LISTADOS'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 2)
                        ->update('costovaria');
            }
            if ($x['LISTATRES'] !== '') {
                $this->db->set('preaut', $x['LISTATRES'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 3)
                        ->update('costovaria');
            }
            if ($x['LISTASEIS'] !== '') {
                $this->db->set('preaut', $x['LISTATRES'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 6)
                        ->update('costovaria');
            }
            if ($x['LISTADOCE'] !== '') {
                $this->db->set('preaut', $x['LISTADOCE'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 12)
                        ->update('costovaria');
            }
            if ($x['LISTADOSCINCO'] !== '') {
                $this->db->set('preaut', $x['LISTADOSCINCO'])
                        ->where('estilo', $x['ESTILO'])
                        ->where('lista', 25)
                        ->update('costovaria');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
