<?php

class RastreoDeControlesEnDocumentosClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
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
            $this->load->view('vRastreoDeControlesEnDocumentosClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getFacturas() {
        try {
            $this->db->select("F.ID AS ID, F.factura AS DOCUMENTO, F.tp AS TP, "
                    . "F.cliente AS CLIENTE, F.contped AS CONTROL, date_format(F.fecha, '%d/%m/%Y') AS FECHA, "
                    . "F.pareped AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, F.precto AS PRECIO, "
                    . "F.subtot AS SUBTOTAL, F.staped AS ESTATUS_PEDIDO", false)->from("facturacion AS F");
            $C = $this->input->get();
            if ($C['CONTROL'] !== '') {
                $this->db->where('F.contped', $C['CONTROL']);
            }
            if ($C['DOCTO'] !== '') {
                $this->db->where('F.factura', $C['DOCTO']);
            }
            if ($C['ORDEN'] !== '') {
                switch (intval($C['ORDEN'])) {
                    case 1:
                        $this->db->order_by('F.factura', 'ASC');
                        break;
                    case 2:
                        $this->db->order_by('F.fecha', 'ASC');
                        break;
                    case 3:
                        $this->db->order_by('F.estilo', 'ASC');
                        break;
                }
            }
            if ($C['CONTROL'] === '' || intval($C['ORDEN']) === 0) {
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevoluciones() {
        try {
            $this->db->select("DV.ID AS ID, DV.cliente AS CLIENTE, DV.control AS CONTROL, "
                            . "DV.fecha AS FECHA, DV.paredev AS PARES, DV.estilo AS ESTILO, "
                            . "DV.comb AS COLOR, DV.staapl AS CART, DV.stafac AS FAC, "
                            . "DV.maq AS MAQUILA, DV.cargoa AS CARGO", false)
                    ->from("devolucionnp AS DV");

            $C = $this->input->get();
            if ($C['CONTROL'] !== '') {
                $this->db->where('DV.control', $C['CONTROL']);
            } else {
                $this->db->limit(99);
            }

            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->select("F.ID, F.factura AS DOCUMENTO, F.tp AS TP, F.cliente AS CLIENTE, F.contped AS CONTROL, 
date_format(F.fecha, '%d/%m/%Y') AS FECHA, F.pareped AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, 
F.precto AS PRECIO, F.subtot AS SUBTOTAL, F.staped AS ESTATUS_PEDIDO,
    
SUM(F.par01 + F.par02 + F.par03+ F.par04+ F.par05+ F.par06+ F.par07+ F.par08+ F.par09+ F.par10+ F.par11+ 
F.par12+ F.par13+ F.par14+ F.par15+ F.par16+ F.par17+ F.par18+ F.par19+ F.par20+ F.par21+ F.par22) AS PARES_VENDIDOS , (SELECT 
SUM(d.par01+ d.par02+ d.par03 +  d.par04 +  d.par05 +  d.par06 +  d.par07 +  d.par08 +  d.par09 +  d.par10 +  d.par11 +  
d.par12 +  d.par13 +  d.par14 +  d.par15 +  d.par16 +  d.par17 +  d.par18 +  d.par19 +  d.par20 +  d.par21 +  d.par22 ) 
FROM devolucionnp as d where d.control LIKE '18061036' GROUP BY d.control) AS PARES_DEVUELTOS,

(SUM(F.par01 + F.par02 + F.par03+ F.par04+ F.par05+ F.par06+ F.par07+ F.par08+ F.par09+ F.par10+ F.par11+ 
F.par12+ F.par13+ F.par14+ F.par15+ F.par16+ F.par17+ F.par18+ F.par19+ F.par20+ F.par21+ F.par22) - (SELECT 
SUM(d.par01+ d.par02+ d.par03 +  d.par04 +  d.par05 +  d.par06 +  d.par07 +  d.par08 +  d.par09 +  d.par10 +  d.par11 +  
d.par12 +  d.par13 +  d.par14 +  d.par15 +  d.par16 +  d.par17 +  d.par18 +  d.par19 +  d.par20 +  d.par21 +  d.par22 ) 
FROM devolucionnp as d where d.control LIKE '18061036' GROUP BY d.control)) AS TOTAL_PARES", false)
                                        ->from('facturacion  AS F')->where('F.contped', $x['CONTROL'])->group_by('F.contped')
                                        ->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevolucionesXControl() {
        try {
            $x = $this->input->get();
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->select("ID, D.cliente, D.docto, D.aplica, D.nc, 
                                                D.fact, D.fact1, D.fact2, D.conce, D.tp, 
                                                D.tpvta, D.control, D.controlprd, D.paredev, D.parefac, 
                                                (D.par01 + D.par02 + D.par03 + D.par04 + D.par05 + 
                                                D.par06 + D.par07 + D.par08 + D.par09 + D.par10+ 
                                                D.par11 + D.par12 + D.par13 + D.par14 + D.par15+ 
                                                D.par16 + D.par17 + D.par18 + D.par19 + D.par20+ 
                                                D.par21 + D.par22) AS PARES_DEVUELTOS,  
                                                D.defecto, D.detalle, D.clasif, D.cargoa, 
                                                D.fecha, D.fechadev, D.estilo, D.comb, D.seriped, 
                                                D.precio, D.subtot, D.registro, D.stafac, D.staapl, 
                                                D.maq, D.preciodev, D.preciomaq, D.obs1, D.ctenvo, 
                                                D.pedidonvo", false)
                                        ->from('devolucionnp AS D')
                                        ->where('D.control', $x['CONTROL'])
                                        ->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstatusPedidoXControl() {
        try {
            $x = $this->input->get();
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->select("P.stsavan AS ESTATUS_AVANCE_PEDIDO", false)
                                        ->from('pedidox AS P')
                                        ->where('P.Control', $x['CONTROL'])
                                        ->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
