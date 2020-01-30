<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignadosExportaXLS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vNavGeneral');
        switch ($this->session->userdata["TipoAcceso"]) {
            case 'SUPER ADMINISTRADOR':
                $this->load->view('vMenuProduccion')
                        ->view('vParesAsignadosExportaXLS');
                break;
            case 'PRODUCCION':
                $this->load->view('vMenuProduccion')
                        ->view('vParesAsignadosExportaXLS');
                break;
        }
        $this->load->view('vFooter');
    }

    public function getDatosXSemanaAnio() {
        try {
//            REGEXP_REPLACE(columnName, '[^\\x20-\\x7E]', '')
            $x = $this->input->get();
            $this->db->select("P.Clave AS PEDIDO, P.Control AS CONTROL,  REPLACE(P.Estilo, \"-\", \"_\") AS ESTILO, "
                    . "P.Color AS CLAVE_COLOR,  REPLACE(P.ColorT, \"-\", \"_\") AS COLOR_PIEL, "
                    . "P.Cliente AS CLIENTE_CLAVE, "
                    . "(SELECT REPLACE(CC.RazonS, \"-\", \"_\") FROM clientes AS CC "
                    . "WHERE CC.Clave = P.Cliente LIMIT 1) AS CLIENTE, "
                    . "P.FechaEntrega AS FECHA_ENTREGA, P.Pares AS PARES", false)
                    ->from("pedidox AS P");

            if ($x['SEMANA'] !== '') {
                $this->db->where("P.Semana", $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where("P.Ano", $x['ANIO']);
            }
            $this->db->where("P.Control > 0", null, false)
                    ->order_by("abs(P.Cliente)", "ASC");
            if ($x['SEMANA'] === '' && $x['ANIO'] !== '') {
                $this->db->limit(5);
            }
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
