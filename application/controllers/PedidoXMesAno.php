<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class PedidoXMesAno extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vNavGeneral')->view('vPedidoXMesAno')->view('vFooter');
    }

    public function getDatosPorMesAno() {
        try {
            $x = $this->input->get();
            $ANO = Date('Y');
            $MES = Date('m');
            if ($x['ANO'] !== '') {
                $ANO = $x['ANO'];
            }
            if ($x['MES'] !== '') {
                $MES = $x['MES'];
            }
            $this->db->select("MONTH(str_to_date(P.FechaPedido,\"%d/%m/%Y\")) AS MES,
elt(MONTH(str_to_date(P.FechaPedido,\"%d/%m/%Y\")), 
\"ENERO\",\"FEBRERO\",\"MARZO\",\"ABRIL\",\"MAYO\",\"JUNIO\",
\"JULIO\",\"AGOSTO\",\"SEPTIEMBRE\",\"OCTUBRE\",\"NOVIEMBRE\",\"DICIEMBRE\") AS NOMBRE, 
COUNT(DISTINCT P.Clave) AS PEDIDOS_ESTE_MES", false)->from("pedidox AS P");
            if ($x['ANO'] !== '') {
                $this->db->where("YEAR(str_to_date(P.FechaPedido,\"%d/%m/%Y\"))", $ANO);
            }
            if ($x['MES'] !== '') {
                $this->db->where("MONTH(str_to_date(P.FechaPedido,\"%d/%m/%Y\"))", $MES);
            }
            $data = $this->db->group_by("MONTH(str_to_date(P.FechaPedido,\"%d/%m/%Y\")) ")
                            ->order_by('MONTH(str_to_date(P.FechaPedido,"%d/%m/%Y")) ASC')->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
