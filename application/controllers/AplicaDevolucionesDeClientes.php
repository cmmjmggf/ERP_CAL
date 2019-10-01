<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class AplicaDevolucionesDeClientes extends CI_Controller {

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
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vAplicaDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDocumentadosDeEsteClienteConSaldo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT CC.ID AS ID, CC.tipo AS TP, CC.remicion AS DOCUMENTO, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA, CC.importe AS IMPORTE, CC.pagos AS PAGOS, CC.saldo AS SALDO, CC.stscont AS ST  "
                                    . "FROM cartcliente AS CC "
                                    . "WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN CC.cliente = '{$x['CLIENTE']}' ELSE CC.cliente LIKE '%%' END) "
                                    . "AND CC.saldo > 1 ORDER BY CC.fecha DESC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

//CONTROLES POR APLICAR DE ESTE CLIENTE
    public function getControlesPorAplicarDeEsteCliente() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT D.ID, D.cliente AS CLIENTE, 
                D.docto AS DOCUMENTO, D.control AS CONTROL, D.paredev AS PARES, 
                D.defecto AS DEFECTOS, D.detalle AS DETALLE, D.clasif AS CLASIFICACION,  
                D.cargoa AS CARGO, D.maq AS MAQUILA,  DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, 
                D.conce AS CONCEPTO, D.preciodev AS PREDV, D.preciomaq AS PRECG 
                FROM devolucionnp AS D 
                WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN D.cliente = '{$x['CLIENTE']}' ELSE D.cliente LIKE '%%' END) "
                                    . "AND D.staapl < 2  ORDER BY D.fecha DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleDevolucion() {
        try {
            $x = $this->input->get();

            $this->db->select("D.ID AS ID, D.cliente AS CLIENTE, D.docto AS DOCUMENTO, 
                D.aplica AS APLICA, D.nc AS NC, D.control AS CONTROL, D.paredev AS PARES, 
                D.defecto AS DEFECTOS, D.detalle AS DETALLES, D.clasif AS CLASIFICACION, D.cargoa AS CARGO, 
                DATE_FORMAT(D.fecha,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, D.conce AS CONCEPTO", false)
                    ->from("devctes AS D");

            if ($x["CLIENTE"] !== '') {
                $this->db->where("D.cliente", $x['CLIENTE']);
            }
            if ($x["APLICAR"] !== '') {
                $this->db->where("D.aplica", $x['APLICAR']);
            }
            if ($x["NC"] !== '') {
                $this->db->where("D.nc ", $x['NC']);
            }
            print json_encode($this->db->order_by("D.fecha", "DESC")->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT D.control AS CONTROL, D.estilo AS ESTILO, "
                                    . "D.comb AS COLOR, D.seriped AS SERIE,(SELECT C.Descripcion "
                                    . "FROM colores AS C WHERE C.Clave = D.comb LIMIT 1) AS COLOR_TEXT, "
                                    . "D.par01, D.par02, D.par03, D.par04, D.par05, "
                                    . "D.par06, D.par07, D.par08, D.par09, D.par10, "
                                    . "D.par11, D.par12, D.par13, D.par14, D.par15, "
                                    . "D.par16, D.par17, D.par18, D.par19, D.par20, D.par21, D.par22 "
                                    . "FROM devolucionnp AS D WHERE D.control = '{$x["CONTROL"]}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFacturaXCliente() {
        try {
            $x = $this->input->get();
            $this->db->select("", false)->from("cartcliente AS C")
                    ->where('C.cliente', $x["CLIENTE"])
                    ->where('C.remicion', $x["DOCUMENTO"]);
            if ($x['TP'] !== '') {
                $this->db->where('C.tipo', $x["TP"]);
            }
            print json_encode($this->db->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaNC() {
        try {
            print json_encode($this->db->query("SELECT (NC.nc + 1) AS NCU FROM notcred AS NC "
                                    . "WHERE NC.tp = 1 AND NC.tp = 1 "
                                    . "ORDER BY NC.nc DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarNC() {
        try {
            $x = $this->input->post();
            $dev = $this->db->query("SELECT * FROM devolucionnp AS D WHERE D.control ='{$x["CONTROL"]}' LIMIT 1")->result();
            if (count($dev) > 0) {
                $r = $dev[0];
                $nc = array(
                    "cliente" => $x["CLIENTE"],
                    "docto" => $r->docto,
                    "aplica" => $x["APLICA"],
                    "nc" => $x["NC"],
                    "conce" => "{$x["CONTROL"]}-{$x["ESTILO"]}-{$x["COLOR"]}",
                    "tp" => $x["TP"],
                    "control" => $x["CONTROL"],
                    "controlprd" => 0,
                    "paredev" => $r->paredev
                );
                for ($i = 1; $i < 23; $i++) {
                    if ($i < 10) {
                        $nc["par0{$i}"] = $x["PAR{$i}"];
                    } else {
                        $nc["par{$i}"] = $x["PAR{$i}"];
                    }
                }
                $ncc = array_merge($nc, array(
                    "defecto" => $r->defecto,
                    "detalle" => $r->detalle,
                    "clasif" => $r->clasif,
                    "cargoa" => $r->cargoa,
                    "fecha" => Date("Y-m-d h:i:s"),
                    "estilo" => $x["ESTILO"],
                    "comb" => $x["COLOR"],
                    "seriped" => $r->seriped,
                    "precio" => $x["PRECIO"],
                    "subtot" => ($x["PRECIO"] * $r->paredev),
                    "registro" => 0
                ));
                $this->db->insert('devctes', $ncc);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarNC() {
        try {
            $x = $this->input->post();
            $HORA = Date("h:i:s");
            $dnnp = $this->db->query("SELECT * FROM devolucionnp "
                            . "WHERE cliente = {$x["CLIENTE"]} "
                            . "AND nc = {$x["NC"]} "
                            . "AND aplica = {$x["DOCUMENTO"]}")->result();
            foreach ($dnnp as $k => $v) {
                print_r($r);
            }
//            $nota_de_credito = array(
//                "nc" => $x["NC"], "cliente" => $x["CLIENTE"],
//                "numfac" => $x["xxxxx"],
//                "tp" => $x["TP"], "orden" => $x["xxxxx"],
//                "fecha" => $x["xxxxx"], "hora" => $HORA,
//                "cant" => $x["xxxxx"], "descripcion" => $x["xxxxx"],
//                "precio" => $x["xxxxx"], "subtot" => $x["xxxxx"],
//                "concepto" => $x["xxxxx"], "status" => $x["xxxxx"],
//                "monletra" => $x["xxxxx"], "defecto" => $x["xxxxx"],
//                "detalle" => $x["xxxxx"], "registro" => $x["xxxxx"],
//                "tmnda" => $x["xxxxx"], "tcamb" => $x["xxxxx"]);
//            $this->db->insert('notcred', $nota_de_credito);
            if (intval($x["TP"]) === 1) {
                $n = array(
                    "cliente" => $x["xxxxx"], "remicion" => $x["xxxxx"],
                    "fecha" => $x["xxxxx"], "importe" => $x["xxxxx"],
                    "tipo" => $x["xxxxx"], "gcom" => $x["xxxxx"],
                    "agente" => $x["xxxxx"], "mov" => $x["xxxxx"],
                    "doctopa" => $x["xxxxx"], "numpol" => $x["xxxxx"],
                    "numfol" => $x["xxxxx"], "status" => $x["xxxxx"],
                    "posfe" => $x["xxxxx"], "fechadep" => $x["xxxxx"],
                    "pagada" => $x["xxxxx"], "fechacap" => $x["xxxxx"],
                    "nc" => $x["xxxxx"], "control" => $x["xxxxx"],
                    "stscont" => $x["xxxxx"], "regdev" => $x["xxxxx"]);
                $this->db->insert('cartctepagos', $nota_de_credito);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /*
     * 


      Private Sub CmdCierra_Click()
      '  graba en la nota de credito --------------------------------------------------------
      Data1.RecordSource = "SELECT * FROM devolucionnp  WHERE cliente = " & Val(txtcliente) & " and nc = " & Val(txtnc) & "  and aplica = " & Val(facorem) & "": Data1.Refresh
      Do While Not Data1.Recordset.EOF
      Tnotcred.AddNew
      Tnotcred.Fields("nc") = Data1.Recordset.Fields("nc")
      Tnotcred.Fields("cliente") = Data1.Recordset.Fields("cliente")
      Tnotcred.Fields("numfac") = Data1.Recordset.Fields("aplica")
      Tnotcred.Fields("tp") = Data1.Recordset.Fields("tp")
      Tnotcred.Fields("orden") = 6
      Tnotcred.Fields("fecha") = Data1.Recordset.Fields("fechadev")
      Tnotcred.Fields("hora") = Time
      Tnotcred.Fields("cant") = Data1.Recordset.Fields("paredev")
      Tnotcred.Fields("descripcion") = Data1.Recordset.Fields("conce")
      Tnotcred.Fields("precio") = Data1.Recordset.Fields("precio")
      Tnotcred.Fields("subtot") = Data1.Recordset.Fields("precio") * Data1.Recordset.Fields("paredev")
      Tnotcred.Fields("concepto") = Data1.Recordset.Fields("control")
      Tnotcred.Fields("defecto") = Data1.Recordset.Fields("defecto")
      Tnotcred.Fields("detalle") = Data1.Recordset.Fields("detalle")
      If Val(txttp) = 1 Then
      Tnotcred.Fields("status") = 0
      Else
      Tnotcred.Fields("status") = 2
      End If
      Tnotcred.Update
      Data1.Recordset.MoveNext
      Loop
      ' saca de la nota de clredito para aplicar en dev.pagos y cartera ----------------------------------------------------
      txtstatus = 1: txttsubtot = 0
      Data5.RecordSource = "SELECT * FROM notcred  WHERE nc= " & Val(txtnc) & " and status= " & Val(txtstatus) & " and numfac= " & Val(facorem) & "": Data5.Refresh
      Do While Not Data5.Recordset.EOF
      txtnc = Data5.Recordset.Fields("nc"):
      txtcliente = Data5.Recordset.Fields("cliente"):
      txtnumfac = Data5.Recordset.Fields("numfac"):
      txttp = Data5.Recordset.Fields("tp")
      txtfechadev = Data5.Recordset.Fields("fecha"):
      txtdesc = Data5.Recordset.Fields("descripcion"):
      txtsubtot = Data5.Recordset.Fields("subtot"):
      txtorden = Data5.Recordset.Fields("orden")
      txtcontrol = Data5.Recordset.Fields("concepto")

      Tcartctepagos.AddNew
      Tcartctepagos.Fields("cliente") = Val(txtcliente)
      Tcartctepagos.Fields("remicion") = Val(txtnumfac)
      Tcartctepagos.Fields("tipo") = Val(txttp)
      Tcartctepagos.Fields("mov") = Val(txtorden)
      Tcartctepagos.Fields("fecha") = txtfechadev
      Tcartctepagos.Fields("fechadep") = txtfechadev
      Tcartctepagos.Fields("fechacap") = txtfechadev
      Tcartctepagos.Fields("doctopa") = txtdesc
      Tcartctepagos.Fields("importe") = Val(txtsubtot)
      Tcartctepagos.Fields("agente") = Val(txtagente)
      Tcartctepagos.Fields("status") = 1
      Tcartctepagos.Fields("nc") = Val(txtnc)
      Tcartctepagos.Fields("control") = Val(txtcontrol)
      Tcartctepagos.Update
      txttsubtot = Val(txttsubtot) + Val(txtsubtot)
      Data5.Recordset.MoveNext
      Loop
      If Val(txttp) = 1 Then
      txtiva = Val(txttsubtot) * 0.16
      Tcartctepagos.AddNew
      Tcartctepagos.Fields("cliente") = Val(txtcliente)
      Tcartctepagos.Fields("remicion") = Val(txtnumfac)
      Tcartctepagos.Fields("tipo") = Val(txttp)
      Tcartctepagos.Fields("fecha") = txtfechadev
      Tcartctepagos.Fields("fechacap") = txtfechadev
      Tcartctepagos.Fields("fechadep") = txtfechadev
      Tcartctepagos.Fields("doctopa") = "IVA " + " N-C " + txtnc
      Tcartctepagos.Fields("importe") = Val(txtiva)
      Tcartctepagos.Fields("agente") = Val(txtagente)
      Tcartctepagos.Fields("mov") = 6
      Tcartctepagos.Fields("status") = 1
      Tcartctepagos.Fields("nc") = Val(txtnc)
      Tcartctepagos.Fields("control") = Val(txtcontrol)
      Tcartctepagos.Update
      End If
      If Val(txttp) = 1 Then Total = Val(txttsubtot) + Val(txtiva): numeletra
      If Val(txttp) = 2 Then Total = Val(txttsubtot): numeletra

      txtstatus = 1
      Data5.RecordSource = "SELECT * FROM notcred  WHERE nc = " & Val(txtnc) & " and cliente = " & Val(txtcliente) & " and status = " & Val(txtstatus) & "": Data5.Refresh
      Do While Not Data5.Recordset.EOF
      Data5.Recordset.Edit
      Data5.Recordset.Fields("status") = 2
      Data5.Recordset.Fields("monletra") = Label4
      Data5.Recordset.Update
      Data5.Recordset.MoveNext
      Loop
      Tcartcliente.Index = "llacldotp"
      Tcartcliente.Seek "=", Val(txtcliente), Val(txtnumfac), Val(txttp)
      If Tcartcliente.NoMatch Then    'no existe
      Else
      txtsaldo = Tcartcliente.Fields("saldo"): txtpagos = Tcartcliente.Fields("pagos"): txtstatus = Tcartcliente.Fields("status")
      If Val(txttp) = 1 Then
      txtsaldo = Val(txtsaldo) - Val(txttsubtot) - Val(txtiva): txtpagos = Val(txtpagos) + Val(txttsubtot) + Val(txtiva)
      Else
      txtsaldo = Val(txtsaldo) - Val(txttsubtot): txtpagos = Val(txtpagos) + Val(txttsubtot)
      End If

      Tcartcliente.Edit
      If Val(txtmov) = 4 Then Tcartcliente.Fields("saldo") = 0 Else Tcartcliente.Fields("saldo") = Val(txtsaldo)
      Tcartcliente.Fields("pagos") = Val(txtpagos)
      If Val(txtsaldo) <= 0.1 Then Tcartcliente.Fields("status") = 3: Tcartcliente.Fields("saldo") = 0
      If Val(txtsaldo) > 0 Then Tcartcliente.Fields("status") = 2
      Tcartcliente.Update
      End If

      Data6 = "": txtnumfol = 0
      Data6.RecordSource = "SELECT * FROM cartctepagos WHERE numfol = " & Val(txtnumfol) & "": Data6.Refresh
      Do While Not Data6.Recordset.EOF
      txtnumcte = Data6.Recordset.Fields("cliente"): txtremicion = Data6.Recordset.Fields("remicion"): txttp = Data6.Recordset.Fields("tipo"): fecha = Data6.Recordset.Fields("fecha")
      dia1 = Val(Mid(fecha, 1, 2)): mes1 = Val(Mid(fecha, 4, 2)) * 30.41: año1 = Val(Mid(fecha, 7, 4)) * 365: tdiasp = Val(dia1) + Val(mes1) + Val(año1):

      Tcartcliente.Index = "llacldotp"
      Tcartcliente.Seek "=", Val(txtnumcte), Val(txtremicion), Val(txttp)
      If Tcartcliente.NoMatch Then    'no existe
      Else
      fechafa = Tcartcliente.Fields("fecha")
      dia1 = Val(Mid(fechafa, 1, 2)): mes1 = Val(Mid(fechafa, 4, 2)) * 30.41: año1 = Val(Mid(fechafa, 7, 4)) * 365: tdiasf = Val(dia1) + Val(mes1) + Val(año1):
      End If
      Tclientes.Index = "llanumcte"
      Tclientes.Seek "=", Val(txtnumcte)
      If Tclientes.NoMatch Then    'no existe
      Else
      txtseccte = Tclientes("seccte")
      End If
      Data6.Recordset.Edit
      Data6.Recordset.Fields("agente") = Val(txtseccte)
      Data6.Recordset.Fields("numfol") = Val(tdiasp) - Val(tdiasf)
      Data6.Recordset.Update
      Data6.Recordset.MoveNext
      Loop
      txtcliente = "": cmbcte = "": txttp = "": txtaplicasn = "": txtclasif = "": txtcargoa = "": txtnumdefe = "": Cmbdefe = "": txtnumdeta = "": Cmbdeta = ""
      facorem = "": txtnc = "": txtsaldofacorem = "": regact = "": siapli = 0: tipodocto = 0: yagrabonc = "": limpia
      CmdAcepta.Enabled = False: CmdCierra.Enabled = False: CmdSalir.Enabled = True: Frame1.Enabled = True: txtcliente.SetFocus
      End Sub

     *  
     * 
     * 
     * 
     */
}
