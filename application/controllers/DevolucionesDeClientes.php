<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DevolucionesDeClientes extends CI_Controller {

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
            $this->load->view('vDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getPedidos() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID, F.contped AS CONTROL, F.factura AS DOCUMENTO, F.tp AS TP, DATE_FORMAT(F.fecha,\"%d/%m/%Y\") AS FECHA, F.pareped AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, F.precto AS PRECIO, F.staped AS ST", false)
                    ->from("facturacion AS F");
            if ($x["CLIENTE"] !== '') {
                $this->db->where('F.cliente', $x["CLIENTE"])->order_by("F.fecha", "DESC");
            }
            if ($x["CLIENTE"] === '') {
                $this->db->order_by("F.fecha", "DESC")->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
            print json_encode($this->db->query("SELECT P.Cliente AS CLIENTE "
                                    . "FROM pedidox AS P WHERE P.Control LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->db->query("SELECT P.*,P.Clave AS CLAVE_PEDIDO, CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
                                    . "S.T21, S.T22, P.EstatusProduccion AS ESTATUS, P.stsavan AS AVANCE_ESTATUS, P.EstiloT AS ESTILO_TEXT "
                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
                                    . "WHERE P.Control LIKE '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesFacturadosXControl() {
        try {
            print json_encode($this->db->query("SELECT F.factura, F.tp, F.cliente, F.contped, F.fecha, F.hora, F.corrida, F.pareped, F.estilo, F.combin, F.par01, F.par02, F.par03, F.par04, F.par05, F.par06, F.par07, F.par08, F.par09, F.par10, F.par11, F.par12, F.par13, F.par14, F.par15, F.par16, F.par17, F.par18, F.par19, F.par20, F.par21, F.par22, F.precto, F.subtot, F.iva, F.staped, F.monletra, F.tmnda, F.tcamb, F.cajas, F.origen, F.referen, F.decdias, F.agente, F.colsuel, F.tpofac, F.año, F.zona, F.horas, F.numero, F.talla, F.cobarr, F.pedime, F.ordcom, F.numadu, F.nomadu, F.regadu, F.periodo, F.costo, F.obs "
                                    . "FROM facturacion AS F WHERE F.contped = '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevoluciones() {
        try {
            $x = $this->input->get();
            $this->db->select("D.ID, D.cliente AS CLIENTE, D.docto AS DOCUMENTO, "
                            . "D.control AS CONTROL, D.paredev AS PARES, "
                            . "D.defecto AS DEFECTO, D.detalle AS DETALLE, "
                            . "D.clasif AS CLASIFICACION, D.cargoa AS CARGO, "
                            . "D.maq AS MAQUILA, DATE_FORMAT(D.fecha,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, "
                            . "D.conce AS CONCEPTO, D.preciodev AS PRECIO_DEVOLUCION, "
                            . "D.preciomaq AS PRECIO_CG", false)
                    ->from("devolucionnp AS D");
            if ($x['CLIENTE'] !== '') {
                $this->db->where('D.cliente', $x['CLIENTE'])->order_by("D.fecha", "DESC");
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('D.control', $x['CONTROL'])->order_by("D.fecha", "DESC");
            }
            if ($x['CLIENTE'] === '' && $x['CONTROL'] === '') {
                $this->db->order_by("D.fecha", "DESC")->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColorXControl() {
        try {
            print json_encode($this->db->query("SELECT (CASE WHEN p.ColorT IS NULL THEN \"SIN COLOR\" ELSE p.ColorT END) AS COLOR_T FROM pedidox as p where p.Control = {$this->input->get('CONTROL')} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {

            /*

              Private Sub CmdAcepta_Click()
              If Val(txtnumdefe) = 0 Or Val(txtnumdeta) = 0 Or Val(txtclasif) = 0 Then
              MsgBox "Algun campo no tiene datos verifique": txtnumdefe.SetFocus
              Else
              txtspares = Val(txtpard01) + Val(txtpard02) + Val(txtpard03) + Val(txtpard04) + Val(txtpard05) + Val(txtpard06) + Val(txtpard07) + Val(txtpard08) + Val(txtpard09) + Val(txtpard10) + Val(txtpard11) + Val(txtpard12) + Val(txtpard13) + Val(txtpard14) + Val(txtpard15) + Val(txtpard16) + Val(txtpard17) + Val(txtpard18) + Val(txtpard19) + Val(txtpard20) + Val(txtpard21) + Val(txtpard22)
              If Val(txtspares) = 0 Then MsgBox "Cantida de pares por talla no puese ser 0": txtpard01.SetFocus: Exit Sub
              If Val(txtspares) > Val(txtparedev) Then MsgBox "Cantida  por talla no concuerda con pares devueltos": txtpard01.SetFocus: Exit Sub
              If Val(txtspares) < Val(txtparedev) Then MsgBox "Cantida  por talla no concuerda con pares devueltos": txtpard01.SetFocus: Exit Sub
 
              Data1.RecordSource = "SELECT * FROM devolucionnp WHERE registro > " & 0 & "": Data1.Refresh
              Data1.Recordset.MoveLast
              txtreg = Data1.Recordset.Fields("registro") + 1

              Data1.Recordset.AddNew
              Data1.Recordset.Fields("cliente") = Val(txtcliente)
              Data1.Recordset.Fields("docto") = Val(txtdocto)
              Data1.Recordset.Fields("aplica") = 0
              Data1.Recordset.Fields("nc") = 0
              Data1.Recordset.Fields("conce") = txtconce & "-" & txtcontrol & "-" & txtestilo & "-" & txtcombin
              Data1.Recordset.Fields("tp") = Val(txttp)
              Data1.Recordset.Fields("control") = Val(txtcontrol)
              Data1.Recordset.Fields("controlprd") = 0
              Data1.Recordset.Fields("paredev") = Val(txtparedev)
              Data1.Recordset.Fields("par01") = Val(txtpard01)
              Data1.Recordset.Fields("par02") = Val(txtpard02)
              Data1.Recordset.Fields("par03") = Val(txtpard03)
              Data1.Recordset.Fields("par04") = Val(txtpard04)
              Data1.Recordset.Fields("par05") = Val(txtpard05)
              Data1.Recordset.Fields("par06") = Val(txtpard06)
              Data1.Recordset.Fields("par07") = Val(txtpard07)
              Data1.Recordset.Fields("par08") = Val(txtpard08)
              Data1.Recordset.Fields("par09") = Val(txtpard09)
              Data1.Recordset.Fields("par10") = Val(txtpard10)
              Data1.Recordset.Fields("par11") = Val(txtpard11)
              Data1.Recordset.Fields("par12") = Val(txtpard12)
              Data1.Recordset.Fields("par13") = Val(txtpard13)
              Data1.Recordset.Fields("par14") = Val(txtpard14)
              Data1.Recordset.Fields("par15") = Val(txtpard15)
              Data1.Recordset.Fields("par16") = Val(txtpard16)
              Data1.Recordset.Fields("par17") = Val(txtpard17)
              Data1.Recordset.Fields("par18") = Val(txtpard18)
              Data1.Recordset.Fields("par19") = Val(txtpard19)
              Data1.Recordset.Fields("par20") = Val(txtpard20)
              Data1.Recordset.Fields("par21") = Val(txtpard21)
              Data1.Recordset.Fields("par22") = Val(txtpard22)
              Data1.Recordset.Fields("defecto") = Val(txtnumdefe)
              Data1.Recordset.Fields("detalle") = Val(txtnumdeta)
              Data1.Recordset.Fields("ctenvo") = Val(txtdepto)
              Data1.Recordset.Fields("clasif") = Val(txtclasif)
              Data1.Recordset.Fields("cargoa") = Val(txtcargoa)
              Data1.Recordset.Fields("estilo") = txtestilo
              Data1.Recordset.Fields("comb") = Val(txtcombin)
              Data1.Recordset.Fields("precio") = Val(txtprecio)
              Data1.Recordset.Fields("subtot") = Val(txtprecio) * Val(txtparedev)
              Data1.Recordset.Fields("seriped") = Val(txtseriped)
              Data1.Recordset.Fields("fecha") = fecha
              Data1.Recordset.Fields("fechadev") = Date
              Data1.Recordset.Fields("registro") = Val(txtreg)
              Data1.Recordset.Fields("stafac") = 0
              Data1.Recordset.Fields("staapl") = 0
              Data1.Recordset.Fields("maq") = Val(txtmaq)
              Data1.Recordset.Fields("preciodev") = Val(preciodev)
              Data1.Recordset.Fields("preciomaq") = Val(preciomaq)
              Data1.Recordset.Update
              Data1.RecordSource = "SELECT * FROM devolucionnp  WHERE cliente = " & Val(txtcliente) & " and stafac = " & 0 & " and staapl = " & 0 & " ": Data1.Refresh
              CmdAcepta.Enabled = False: limpia:  txtclasif.SetFocus:
              End If
              End Sub
             */
            $x = $this->input->post();
            $this->db->insert('devolucionnp', array(
                "cliente" => $x["CLIENTE"], "docto" => $x["DOCUMENTO"],
                "aplica" => 0, "nc" => $x["xxxxx"],
                "fact" => $x["xxxxx"], "fact1" => $x["xxxxx"],
                "fact2" => $x["xxxxx"], "conce" => $x["xxxxx"],
                "tp" => $x["xxxxx"], "tpvta" => $x["xxxxx"],
                "control" => $x["xxxxx"], "controlprd" => $x["xxxxx"],
                "paredev" => $x["xxxxx"], "parefac" => $x["xxxxx"],
                "par01" => $x["xxxxx"], "par02" => $x["xxxxx"],
                "par03" => $x["xxxxx"], "par04" => $x["xxxxx"],
                "par05" => $x["xxxxx"], "par06" => $x["xxxxx"],
                "par07" => $x["xxxxx"], "par08" => $x["xxxxx"],
                "par09" => $x["xxxxx"], "par10" => $x["xxxxx"],
                "par11" => $x["xxxxx"], "par12" => $x["xxxxx"],
                "par13" => $x["xxxxx"], "par14" => $x["xxxxx"],
                "par15" => $x["xxxxx"], "par16" => $x["xxxxx"],
                "par17" => $x["xxxxx"], "par18" => $x["xxxxx"],
                "par19" => $x["xxxxx"], "par20" => $x["xxxxx"],
                "par21" => $x["xxxxx"], "par22" => $x["xxxxx"],
                "defecto" => $x["xxxxx"], "detalle" => $x["xxxxx"],
                "clasif" => $x["xxxxx"], "cargoa" => $x["xxxxx"],
                "fecha" => $x["xxxxx"], "fechadev" => $x["xxxxx"],
                "estilo" => $x["xxxxx"], "comb" => $x["xxxxx"],
                "seriped" => $x["xxxxx"], "precio" => $x["xxxxx"],
                "subtot" => $x["xxxxx"], "registro" => $x["xxxxx"],
                "stafac" => $x["xxxxx"], "staapl" => $x["xxxxx"],
                "maq" => $x["xxxxx"], "preciodev" => $x["xxxxx"],
                "preciomaq" => $x["xxxxx"], "obs1" => $x["xxxxx"],
                "ctenvo" => $x["xxxxx"]
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
