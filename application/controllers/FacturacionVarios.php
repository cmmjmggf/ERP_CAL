<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class FacturacionVarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')
                ->model('RastreoDeControlesEnDocumentos_model', 'rced');
    }

    public function index() {
        $indice = $this->input->get();
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFacturacionVarios')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            $this->db->insert('facturacion', array(
                "factura" => $x["FACTURA"],
                "tp" => $x["TP"],
                "cliente" => $x["CLIENTE"],
                "contped" => 0,
                "fecha" => $x["FECHA"],
                "hora" => Date("d/m/Y"),
                "corrida" => $x["TALLA"],
                "pareped" => $x["CANTIDAD"],
                "estilo" => $x["ESTILO"] . " " . $x["CONCEPTO"],
                "combin" => 99,
                "par01" => 0, "par02" => 0, "par03" => 0,
                "par04" => 0, "par05" => 0, "par06" => 0,
                "par07" => 0, "par08" => 0, "par09" => 0,
                "par10" => 0, "par11" => 0, "par12" => 0,
                "par13" => 0, "par14" => 0, "par15" => 0,
                "par16" => 0, "par17" => 0, "par18" => 0,
                "par19" => 0, "par20" => 0, "par21" => 0,
                "par22" => 0,
                "precto" => $x["PRECIO"],
                "subtot" => $x["SUBTOTAL"],
                "iva" => ((intval($x["TP"]) === 1 && intval($x["NO_GENERA_IVA"]) === 0) ? ($x["SUBTOTAL"] * 0.16) : 0),
                "staped" => 1,
                "monletra" => $x["MONEDA_LETRA"],
                "tmnda" => $x["TIPO_MONEDA"],
                "tcamb" => $x["TIPO_CAMBIO"],
                "cajas" => 0,
                "origen" => 0,
                "referen" => "{$x["CLIENTE"]}{$x["FACTURA"]}",
                "decdias" => 0,
                "agente" => $x["AGENTE"],
                "colsuel" => (intval($x["NO_GENERA_IVA"]) === 0 ? 0 : 1111),
                "tpofac" => 0,
                "año" => Date('Y'),
                "zona" => $x["ZONA"],
                "horas" => Date('h:i:s'),
                "numero" => 1,
                "talla" => 0,
                "cobarr" => 0,
                "pedime" => $x["PEDIMENTO"],
                "ordcom" => $x["ORDEN_DE_COMPRA"],
                "numadu" => 0,
                "nomadu" => 0,
                "regadu" => NULL,
                "periodo" => Date('Y'),
                "costo" => 0,
                "obs" => $x["OBS"],
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFactura() {
        try {
            $x = $this->input->get();
            if ($x['CLIENTE'] !== '') {
                print json_encode(
                                $this->db->query("SELECT COUNT(F.factura) AS FACTURA_EXISTE, F.cliente AS CLIENTE "
                                        . "FROM facturacion AS F "
                                        . "WHERE F.factura = '{$x['FACTURA']}' AND F.cliente = '{$x['CLIENTE']}' ORDER BY year(F.fecha) DESC ")->result());
            } else {
                print json_encode(
                                $this->db->query("SELECT COUNT(F.factura) AS FACTURA_EXISTE, F.cliente AS CLIENTE "
                                        . "FROM facturacion AS F "
                                        . "WHERE F.factura = '{$x['FACTURA']}' ORDER BY year(F.fecha) DESC ")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getListaDePreciosXCliente() {
        try {
            print json_encode($this->db->query("SELECT C.ListaPrecios AS LP, C.Descuento AS DESCUENTO, C.Zona AS ZONA, C.Agente AS AGENTE FROM clientes AS C WHERE C.Clave = {$this->input->post('CLIENTE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerCodigoSatXEstilo() {
        try {
            print json_encode(
                            $this->db->query("SELECT G.ClaveProductoSAT AS CPS FROM estilos AS E INNER JOIN generos AS G ON E.Genero = G.Clave WHERE E.Clave LIKE '{$this->input->get('ESTILO')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosXCliente() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID, F.cliente AS CLIENTE, F.factura AS DOCTO, F.fecha AS FECHA, F.tp AS TP, (F.subtot + F.iva) AS IMPORTE,  CC.pagos AS PAGOS,"
                    . " ((F.subtot + F.iva) - CC.pagos) AS SALDO, F.precto, F.subtot, F.iva", false)
                    ->from("facturacion AS F")->join("cartcliente as CC", "F.cliente = CC.cliente AND F.factura  = CC.remicion");
            if ($x["CLIENTE"] !== '') {
                $this->db->where('CC.cliente', $x["CLIENTE"]);
            } else {
                $this->db->order_by('F.fecha','DESC')->limit(100);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
