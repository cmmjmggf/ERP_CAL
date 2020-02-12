<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ListaDePrecioEstiloPrecioXLS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vNavGeneral');
        switch ($this->session->userdata["TipoAcceso"]) {
            case 'SUPER ADMINISTRADOR':
                $this->load->view('vMenuProduccion')
                        ->view('vListaDePreciosEstiloPrecioXLS');
                break;
            case 'PRODUCCION':
                $this->load->view('vMenuProduccion')
                        ->view('vListaDePreciosEstiloPrecioXLS');
                break;
        }
        $this->load->view('vFooter');
    }

    public function getDatosListasDePrecio() {
        try {
//            REGEXP_REPLACE(columnName, '[^\\x20-\\x7E]', '')
            $x = $this->input->get();
            $this->db->select("cv.estilo AS ESTILO, cv.preaut AS PRECIO", false)->from("costovaria AS cv ")
                    ->join("lineas l", "l.clave = cv.linea")
                    ->join("listadeprecios lp", "lp.Lista = cv.lista")
                    ->join("costofijo cf", "cf.lista = cv.lista");

            if ($x['LISTA'] !== '') {
                $this->db->where("cv.lista", $x['LISTA']);
            } 
            $this->db->order_by("cv.linea","ASC")->order_by("cv.linea","ASC") ;
            if ($x['LISTA'] === '') {
                $this->db->limit(5);
            }
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
