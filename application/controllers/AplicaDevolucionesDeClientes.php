<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class AplicaDevolucionesDeClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->helper('jaspercommand_helper')
                ->helper('Notacreditoclientes_helper')
                ->helper('nc_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vAplicaDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getTT() {
        try {
            passthru("C:\Mis Comprobantes\Timbrar.exe 8825");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentadosDeEsteClienteConSaldo() {
        try {
            $x = $this->input->get();
            $limite = "";
            if ($x['CLIENTE'] === '') {
                $limite = "LIMIT 5";
            }
            print json_encode($this->db->query("SELECT CC.ID AS ID, CC.tipo AS TP, "
                                    . "CC.remicion AS DOCUMENTO, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA, "
                                    . "CC.importe AS IMPORTE, CC.pagos AS PAGOS, "
                                    . "CC.saldo AS SALDO, CC.status AS ST  "
                                    . "FROM cartcliente AS CC "
                                    . "WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN CC.cliente = '{$x['CLIENTE']}' ELSE CC.cliente LIKE '%%' END) "
                                    . "AND CC.saldo > 1 ORDER BY CC.fecha DESC {$limite};")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentadosDeEsteClienteConSaldoXDocumento() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT CC.ID AS ID, CC.cliente AS CLIENTE, CC.tipo AS TP, "
                                    . "CC.remicion AS DOCUMENTO, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA, "
                                    . "CC.importe AS IMPORTE, CC.pagos AS PAGOS, "
                                    . "CC.saldo AS SALDO, CC.status AS ST  "
                                    . "FROM cartcliente AS CC "
                                    . "WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN CC.cliente = '{$x['CLIENTE']}' ELSE CC.cliente LIKE '%%' END) "
                                    . "AND CC.saldo > 1 AND CC.tipo = {$x["TP"]}  AND CC.remicion = {$x["DOCUMENTO"]} ORDER BY CC.fecha DESC LIMIT 1;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

//CONTROLES POR APLICAR DE ESTE CLIENTE
    public function getControlesPorAplicarDeEsteCliente() {
        try {
            $x = $this->input->get();
            $limite = "";
            $this->db->select("D.ID, D.cliente AS CLIENTE,
                D.docto AS DOCUMENTO,
                CONCAT(\"<span class='font-weight-bold'>\", D.control,\"</span>\") AS CONTROL, D.paredev AS PARES,
                D.defecto AS DEFECTOS, D.detalle AS DETALLE, D.clasif AS CLASIFICACION,
                D.cargoa AS CARGO, D.maq AS MAQUILA,  DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS FECHA, D.tp AS TP,
                CONCAT(\"<span class='font-weight-bold'>\",D.conce,\"</span>\") AS CONCEPTO, 
               D.preciodev  AS PREDV,   CONCAT(\"$ \", D.preciodev) AS PREDVT, D.preciomaq AS PRECG", false)->from("devolucionnp AS D");
            if ($x['CLIENTE'] !== '') {
                $this->db->where("D.cliente", $x['CLIENTE']);
            }
            $this->db->where_in("D.staapl", array(0, 1))->order_by('D.fecha', 'DESC');


            if ($x['CLIENTE'] === '') {
                $limite = "LIMIT 10";
                $this->db->limit(1);
            }
            $dtm = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($dtm);
//            print json_encode($this->db->query("SELECT D.ID, D.cliente AS CLIENTE,
//                D.docto AS DOCUMENTO, D.control AS CONTROL, D.paredev AS PARES,
//                D.defecto AS DEFECTOS, D.detalle AS DETALLE, D.clasif AS CLASIFICACION,
//                D.cargoa AS CARGO, D.maq AS MAQUILA,  DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS FECHA, D.tp AS TP,
//                D.conce AS CONCEPTO, D.preciodev AS PREDV, D.preciomaq AS PRECG
//                FROM devolucionnp AS D
//                WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN D.cliente = '{$x['CLIENTE']}' ELSE D.cliente LIKE '%%' END) "
//                                    . "AND D.staapl IN(0,1)  ORDER BY D.fecha DESC {$limite};")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesPorAplicarDeEsteClienteXDocumento() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT D.ID, D.cliente AS CLIENTE,
                D.docto AS DOCUMENTO, D.control AS CONTROL, D.paredev AS PARES,
                D.defecto AS DEFECTOS, D.detalle AS DETALLE, D.clasif AS CLASIFICACION,
                D.cargoa AS CARGO, D.maq AS MAQUILA,  DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS FECHA, D.tp AS TP,
                D.conce AS CONCEPTO, D.preciodev AS PREDV, D.preciomaq AS PRECG
                FROM devolucionnp AS D
                WHERE (CASE WHEN '{$x['CLIENTE']}' <> '' THEN D.cliente = '{$x['CLIENTE']}' ELSE D.cliente LIKE '%%' END) "
                                    . "AND D.staapl IN(0,1)  "
                                    . "AND D.docto = {$x["DOCUMENTO"]} "
                                    . "LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleDevolucion() {
        try {
            $x = $this->input->get();

            $this->db->select("D.ID AS ID, CONCAT(\"<span class='font-weight-bold'>\",D.cliente,\"</span>\") AS CLIENTE, 
                CONCAT(\"<span class='font-weight-bold'>\",D.docto,\"</span>\")  AS DOCUMENTO,
                 CONCAT(\"<span class='font-weight-bold text-danger'>\",D.aplica,\"</span>\") AS APLICA, 
                 CONCAT(\"<span class='font-weight-bold text-info'>\",D.nc,\"</span>\") AS NC, 
                 CONCAT(\"<span class='font-weight-bold'>\",D.control,\"</span>\") AS CONTROL, D.paredev AS PARES, 
                 CONCAT(\"<span class='font-weight-bold' style='color: #7CB342;'>$\",FORMAT(D.precio,2),\"</span>\") AS PRECIO,
                D.defecto AS DEFECTOS, D.detalle AS DETALLES, D.clasif AS CLASIFICACION, D.cargoa AS CARGO,
                (D.paredev * D.precio) AS TOTAL,
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

            $this->db->order_by("D.fecha", "DESC");

            if ($x["CLIENTE"] === '' || $x["NC"] === '') {
                $this->db->limit(5);
            }

            $data = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($data);
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
                                    . "FROM devolucionnp AS D WHERE D.control = '{$x["CONTROL"]}' AND D.staapl IN(0,1) "
                                    . "AND D.paredev = {$x["PARES"]} AND D.ID = '{$x["IDX"]}'")->result());
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
            $x = $this->input->get();
            switch (intval($x['TP'])) {
                case 1:
                    print json_encode($this->db->query("SELECT (NC.nc + 1) AS NCU FROM notcred AS NC "
                                            . "WHERE NC.tp = 1 AND NC.nc < 20000 ORDER BY NC.nc DESC LIMIT 1")->result());
                    break;
                case 2:
                    print json_encode($this->db->query("SELECT (NC.nc + 1) AS NCU FROM notcred AS NC "
                                            . "WHERE NC.tp = 2  ORDER BY NC.nc DESC LIMIT 1")->result());
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarNC() {
        try {
            $x = $this->input->post();
            $fecha = $x["FECHA"];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $dev = $this->db->query("SELECT * FROM devolucionnp AS D WHERE D.control ='{$x["CONTROL"]}' "
                            . " AND D.paredev ={$x["PARES"]} AND D.ID ='{$x["IDX"]}' AND D.staapl IN(0,1) LIMIT 1")->result();
//            var_dump($dev);
//            print $this->db->last_query(); 
//            exit(0);
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
                switch (intval($x["TP"])) {
                    case 1:
                        $subtotal = $x["PRECIO"] * $r->paredev;
//                        $subtotal *= 1.16;
                        break;
                    case 2:
                        $subtotal = $x["PRECIO"] * $r->paredev;
                        break;
                }
                $ncc = array_merge($nc, array(
                    "defecto" => $r->defecto,
                    "detalle" => $r->detalle,
                    "clasif" => $r->clasif,
                    "cargoa" => $r->cargoa,
                    "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "estilo" => $x["ESTILO"],
                    "comb" => $x["COLOR"],
                    "seriped" => $r->seriped,
                    "precio" => $x["PRECIO"],
                    "subtot" => ($subtotal),
                    "registro" => 0
                ));
                $EXISTE_EN_DEVCTES = $this->db->query("SELECT COUNT(*) AS EXISTE FROM devctes AS D "
                                . "WHERE cliente = {$x["CLIENTE"]} AND docto = {$r->docto} "
                                . "AND aplica = {$x["APLICA"]} AND nc = {$x["NC"]} AND tp ={$x["TP"]} "
                                . "AND control = {$x["CONTROL"]} AND paredev = {$x["PARES"]};")->result();
                if ($EXISTE_EN_DEVCTES[0]->EXISTE <= 0) {
                    $this->db->insert('devctes', $ncc);
                    /*
                     * COLOCA LA DEVOLUCION COMO APLICADA, SE ASIGNA LA NOTA DE CREDITO A LA DEVOLUCION
                     *
                     */
                    $this->db->set('staapl', 1)->set('nc', $x["NC"])
                            ->where('control', $x['CONTROL'])
                            ->where('cliente', $x["CLIENTE"])
                            ->where('tp', $x["TP"])
                            ->where('docto', $r->docto)
                            ->update('devolucionnp');

                    $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (DEVCTES)",
                            "HA APLICADO UNA DEVOLUCION CON LA NOTA {$x["NC"]} AL CONTROL {$x['CONTROL']} POR $ " . number_format($subtotal, 2, ".", ",") . "  .", $this->session);
                    $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (DEVOLUCIONNP)",
                            "HA ASIGNADO LA NOTA {$x["NC"]} AL CONTROL {$x['CONTROL']} POR $ " . number_format($subtotal, 2, ".", ",") . "  .", $this->session);
                }
//                SE CONSIDERA COMO PASO 2 PARA UNA DEVOLUCION
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarNC() {
        try {
            $x = $this->input->post();
//            var_dump($x);
//            exit(0);
            $HORA = Date("h:i:s");
            $dnnp = $this->db->query("SELECT D.* FROM devctes AS D  WHERE D.cliente = {$x["CLIENTE"]} "
                            . "AND D.nc = {$x["NC"]} AND D.tp = {$x["TP"]} ")->result();
            $total_final = 0;
            $cte = $this->db->query("SELECT C.* FROM clientes AS C WHERE C.Clave = {$x["CLIENTE"]} LIMIT 1")->result();

            foreach ($dnnp as $k => $v) {
//                var_dump($v);
                $fecha = $x["FECHA"];
                $dia = substr($fecha, 0, 2);
                $mes = substr($fecha, 3, 2);
                $anio = substr($fecha, 6, 4);

                $nueva_fecha = new DateTime();
                $nueva_fecha->setDate($anio, $mes, $dia);
                $cartctepagos = array(
                    "cliente" => $x["CLIENTE"],
                    "remicion" => $x["DOCUMENTO"],
                    "tipo" => $x["TP"],
                    "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "fechadep" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "fechacap" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "doctopa" => "{$v->conce}-NC{$x["NC"]}",
                    "importe" => $v->subtot,
                    "agente" => $cte[0]->Agente,
                    "mov" => 6, "status" => 1,
                    "nc" => $x["NC"], "control" => $x["CONTROL"],
                    "gcom" => 0, "numpol" => 0, "numfol" => 0, "posfe" => 0,
                    "pagada" => 0, "stscont" => 0, "regdev" => 0);
                $this->db->insert('cartctepagos', $cartctepagos);

                $total_final += $v->subtot;

                $notcred = array(
                    "nc" => $x["NC"],
                    "cliente" => $x["CLIENTE"],
                    "numfac" => $x["DOCUMENTO"],
                    "tp" => $x["TP"], "orden" => 6,
                    "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "hora" => $HORA, "cant" => $v->paredev,
                    "descripcion" => $v->conce,
                    "precio" => $v->precio,
                    "subtot" => $v->subtot,
                    "concepto" => NULL,
                    "monletra" => $x["TOTAL_EN_LETRA"],
                    "defecto" => $v->defecto, "detalle" => $v->detalle,
                    "registro" => 0, "tmnda" => 1, "tcamb" => 0);
                switch (intval($x["TP"])) {
                    case 1:
                        $notcred["status"] = 0;
                        break;
                    case 2:
                        $notcred["status"] = 2;
                        break;
                }
                $this->db->insert('notcred', $notcred);
                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (CARTCTEPAGOS)", "HA HECHO UN PAGO CON LA NDC({$x['NC']}) POR $ " . number_format($v->subtot, 2, ".", ",") . " PARA LA FACTURA ({$x['DOCUMENTO']}) DEL CLIENTE {$x["CLIENTE"]}  TP {$x["TP"]}.", $this->session);
                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (NOTCRED)", "HA GENERADO UN MOVIMIENTO PARA LA NDC({$x['NC']}) POR $ " . number_format($v->subtot, 2, ".", ",") . " PARA LA FACTURA ({$x['DOCUMENTO']}) DEL CLIENTE {$x["CLIENTE"]}  TP {$x["TP"]}.", $this->session);

                /* SI EL TP ES 1, SE AÑADE A LA NOTADE CREDITO UN */
            }/* END FOR */

            $cartcliente = $this->db->query("SELECT * FROM cartcliente  AS N WHERE remicion = {$x['DOCUMENTO']} and cliente= {$x['CLIENTE']} and tipo= {$x['TP']}")->result();
//            print "\n" . $this->db->last_query() . "\n";
//            var_dump($cartcliente);
            if (intval($x["TP"]) === 1) {
                $cartctepagos = array(
                    "cliente" => $x["CLIENTE"],
                    "remicion" => $x["DOCUMENTO"],
                    "tipo" => $x["TP"],
                    "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "fechadep" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "fechacap" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "doctopa" => "IVA-NC{$x["NC"]}",
                    "importe" => $total_final * 0.16,
                    "agente" => $cte[0]->Agente,
                    "mov" => 6, "status" => 1,
                    "nc" => $x["NC"],
                    "control" => $x["CONTROL"],
                    "gcom" => 0, "numpol" => 0, "numfol" => 0, "posfe" => 0,
                    "pagada" => 0, "stscont" => 0, "regdev" => 0);
                $this->db->insert('cartctepagos', $cartctepagos);

                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (CARTCTEPAGOS-IVA)(TP-1)", "HA GENERADO EL IVA PARA LA NDC({$x["NC"]}) DE LA FACTURA ({$x['DOCUMENTO']}) DEL CLIENTE {$x["CLIENTE"]}  POR $ " . number_format($total_final * 0.16, 2, ".", ",") . "   TP 1.", $this->session);
                /* MODIFICAR MONEDA - LETRA */
                $SALDO = $cartcliente[0]->saldo;
                $PAGOS = $cartcliente[0]->pagos;
                $STATUS = $cartcliente[0]->status;

                $total_final_con_iva = ($total_final * 1.16);

                $saldo_final = ($SALDO - $total_final_con_iva);

                $estatus = (floatval($saldo_final) > 1) ? 2 : 3;
                $this->db->set('status', $estatus)
                        ->set('saldo', $saldo_final)
                        ->set('pagos', ($PAGOS + $total_final_con_iva))
                        ->where('cliente', $x['CLIENTE'])->where('remicion', $x['DOCUMENTO'])
                        ->where('tipo', $x['TP'])->update('cartcliente');

                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (CARTCLIENTE-SALDO-PAGOS)(TP-1)", "HA MODIFICADO EL SALDO DE LA NDC({$x["NC"]}) PARA LA FACTURA ({$x['DOCUMENTO']}) DEL CLIENTE {$x["CLIENTE"]}  POR $ " . number_format($total_final * 0.16, 2, ".", ",") . "   TP 1.", $this->session);
                $status = 2;
                if ($saldo_final <= 5) {
                    $status = 3;
                }
                if ($saldo_final > 1) {
                    $status = 2;
                }
                $this->db->set('status', $status)
                        ->where('cliente', $x['CLIENTE'])->where('remicion', $x['DOCUMENTO'])
                        ->where('tipo', $x['TP'])->update('cartcliente');
                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (CARTCLIENTE-STATUS)(TP-1)", "HA MODIFICADO EL ESTATUS({$status}) DE LA NDC({$x["NC"]})  DEL CLIENTE {$x["CLIENTE"]}.", $this->session);
                /*                 * ********************** TimbrarNC.exe TODAVIA NO LO TENEMOS***************** */
//                print "\n*** TIMBRANDO NC {$x['NC']} CON IMPORTE DE $" . number_format($TOTAL, 4, ".", ",") . "***\n";
//                exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe ' . $x['FACTURA'] . '" ');
//                exec('schtasks /run /tn "Timbrar"  ');
//                exec('schtasks /delete /tn "Timbrar" /F ');
                $l = new Logs("APLICA DEVOLUCIONES PENDIENTES (CARTCLIENTE)(TIMBRADO)", "HA TIMBRADO LA NOTA DE CREDITO {$x['NC']} CON EL CLIENTE {$x['CLIENTE']}, POR  $" . number_format($total_final_con_iva, 4, ".", ",") . ", TP 1 (NC).", $this->session);

                $ndc = new NotaDeCredito($x['TP'], $x['NC'], $x['CLIENTE']);

                $l = new Logs("APLICA DEV DE CLIENTES - NOTA DE CREDITO (RPT)(TP-1)", "IMPRIMIO UN REPORTE DE LA NDC({$x["NC"]}) DEL CLIENTE {$x["CLIENTE"]}  POR $ " . number_format($total_final_con_iva, 2, ".", ",") . "   TP 1.", $this->session);
                exit(0);
            } else {
                $SALDO = $cartcliente[0]->saldo;
                $PAGOS = $cartcliente[0]->pagos;
                $STATUS = $cartcliente[0]->status;
                $saldo_final = ($SALDO - $total_final);
                $estatus = (floatval($saldo_final) > 1) ? 2 : 3;

                $this->db->set('status', $estatus)
                        ->set('saldo', $saldo_final)->set('pagos', ($PAGOS + $total_final))
                        ->where('cliente', $x['CLIENTE'])->where('remicion', $x['DOCUMENTO'])
                        ->where('tipo', $x['TP'])->update('cartcliente');

                $l = new Logs("APLICA DEV DE CLIENTES - (CARTCLIENTE-SALDO-PAGOS) (TP-2)",
                        "HA MODIFICADO EL SALDO DE LA NDC({$x["NC"]}) "
                        . "PARA LA FACTURA ({$x['DOCUMENTO']}) "
                        . "DEL CLIENTE {$x["CLIENTE"]}  "
                        . "POR $ " . number_format($total_final, 2, ".", ",") . " TP 2 .",
                        $this->session);

                $status = 2;
                if ($saldo_final <= 5) {
                    $status = 3;
                }
                if ($saldo_final > 1) {
                    $status = 2;
                }
                $this->db->set('status', $status)->where('cliente', $x['CLIENTE'])
                        ->where('remicion', $x['DOCUMENTO'])->where('tipo', $x['TP'])
                        ->update('cartcliente');
                $ndc = new NotaDeCredito($x['TP'], $x['NC'], $x['CLIENTE']);
                $l = new Logs("APLICA DEV DE CLIENTES - NOTA DE CREDITO (RPT)(TP-2)", "IMPRIMIO UN REPORTE DE LA NDC({$x["NC"]}) DEL CLIENTE {$x["CLIENTE"]}  POR $ " . number_format($total_final, 2, ".", ",") . "   TP 2.", $this->session);
                exit(0);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerSaldoXDevolucionDocumentoNC() {
        try {
            $x = $this->input->post();
            print json_encode($this->db->query("SELECT SUM(D.subtot) AS TOTAL_DEVUELTO "
                                    . "FROM devctes AS D "
                                    . "WHERE D.cliente = {$x["CLIENTE"]} "
                                    . "AND D.nc = {$x["NC"]}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTotal() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT SUM(D.subtot) AS TOTAL FROM devctes AS D "
                                    . "WHERE D.cliente = {$x["CLIENTE"]} "
                                    . "AND D.nc = {$x["NC"]} ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
