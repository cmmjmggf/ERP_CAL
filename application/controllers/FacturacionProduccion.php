<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class FacturacionProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RastreoDeControlesEnDocumentos_model', 'rced');
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
            $this->load->view('vFacturacionProduccion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getListaDePreciosXCliente() {
        try {
            print json_encode($this->db->query("SELECT C.ListaPrecios AS LP FROM clientes AS C WHERE C.Clave = {$this->input->post('CLIENTE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->db->query("SELECT P.*,P.Clave AS CLAVE_PEDIDO, CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22 "
                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
                                    . "WHERE P.Control LIKE '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturacionDiff() {
        try {
            print json_encode($this->db->query("SELECT "
                                    . "F.contped, F.pareped, F.par01, F.par02, F.par03, F.par04, F.par05, "
                                    . "F.par06, F.par07, F.par08, F.par09, F.par10, "
                                    . "F.par11, F.par12, F.par13, F.par14, F.par15, "
                                    . "F.par16, F.par17, F.par18, F.par19, F.par20, "
                                    . "F.par21, F.par22, F.staped, P.Cliente AS CLIENTE "
                                    . "FROM facturaciondif AS F  INNER JOIN pedidox AS P ON F.contped = P.Control "
                                    . "WHERE F.contped LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaFactura() {
        try {
            switch (intval($this->input->get('TP'))) {
                case 1:
                    print json_encode(
                                    $this->db->query("SELECT ((FD.numfac) + 1)  AS ULFAC FROM facturadetalle AS FD ORDER BY FD.numfac DESC LIMIT 1")->result());
                    break;
                case 2:
                    print json_encode(
                                    $this->db->query("SELECT ((CC.remicion) + 1) AS ULFACR FROM cartcliente AS CC  WHERE CC.tipo = 2 ORDER BY CC.fecha DESC, CC.remicion DESC LIMIT 1")->result());
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosXFacturar() {
        try {

            print json_encode(
                            $this->db->query("SELECT  P.ID, P.Control AS CONTROL, 
                                P.Clave AS PEDIDO, P.Cliente AS CLIENTE, 
                                P.FechaPedido  AS FECHA_PEDIDO, P.FechaEntrega AS FECHA_ENTREGA, 
                                P.Estilo AS ESTILO, P.Color AS COLOR, P.Pares AS PARES, 
                                0  AS FAC, P.Maquila AS MAQUILA, P.Semana AS SEMANA, 
                                P.Precio AS PRECIO, FORMAT(P.Precio,2) AS PRECIOT, P.ColorT AS COLORT  
                                FROM erp_cal.pedidox AS P 
                                WHERE P.Control NOT IN(0,1) 
                                AND P.stsavan NOT IN(13,14) 
                                AND P.Cliente = '{$this->input->get('CLIENTE')}' 
                                ORDER BY P.FechaRecepcion DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
