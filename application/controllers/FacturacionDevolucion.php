<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class FacturacionDevolucion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Colores_model')->model('Estilos_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CLIENTES':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFacturacionDevolucion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getListaDePreciosXCliente() {
        try {
            print json_encode($this->db->query("SELECT C.ListaPrecios AS LP, C.Descuento AS DESCUENTO, C.Zona AS ZONA, C.Agente AS AGENTE FROM clientes AS C WHERE C.Clave = {$this->input->post('CLIENTE')}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
//            print json_encode($this->db->query("SELECT P.*,P.Clave AS CLAVE_PEDIDO, CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
//                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
//                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
//                                    . "S.T21, S.T22, P.EstatusProduccion AS ESTATUS, P.stsavan AS AVANCE_ESTATUS, P.EstiloT AS ESTILO_TEXT "
//                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
//                                    . "WHERE P.Control LIKE '{$this->input->get('CONTROL')}'")->result());
            print json_encode($this->db->query("SELECT D.docto AS CLAVE_PEDIDO, "
                                    . "CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,"
                                    . "(SELECT C.Descripcion FROM colores AS C "
                                    . "WHERE C.Estilo = D.estilo AND C.Clave = D.comb LIMIT 1)  AS COLORT, "
                                    . "D.estilo AS ESTILOT , D.precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
                                    . "S.T21, S.T22, 
                                        D.par01 AS C1, D.par02 AS C2, D.par03 AS C3, D.par04 AS C4, D.par05 AS C5, 
                                        D.par06 AS C6, D.par07 AS C7, D.par08 AS C8, D.par09 AS C9, D.par10 AS C10, 
                                        D.par11 AS C11, D.par12 AS C12, D.par13 AS C13, D.par14 AS C14, D.par15 AS C15, 
                                        D.par16 AS C16, D.par17 AS C17, D.par18 AS C18, D.par19 AS C19, D.par20 AS C20,
                                        D.par21 AS C21, D.par22 AS C22, "
                                    . "(SELECT E.Descripcion FROM estilos AS E "
                                    . "WHERE E.Clave = D.estilo LIMIT 1) AS ESTILO_TEXT "
                                    . "FROM devolucionnp AS D INNER JOIN series AS S ON D.seriped = S.Clave "
                                    . "WHERE D.control = '{$this->input->get('CONTROL')} LIMIT 1'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturacionDiff() {
        try {
            /* OBTENGO LAS DIFERENCIAS Y EL CLIENTE DE ESTE CONTROL PORQUE NO SE PUEDE FACTURAR UN CONTROL A UN CLIENTE AL QUE YA SE ELIGIO */
            $devolucionnp_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM devolucionnp AS F WHERE F.control = '{$this->input->get('CONTROL')}' LIMIT 1")->result();

            if ($devolucionnp_existe[0]->EXISTE > 0) {

                print json_encode($this->db->query("SELECT  1 AS EXISTE, D.control, D.paredev, D.par01, D.par02, D.par03, D.par04, D.par05, 
D.par06, D.par07, D.par08, D.par09, D.par10, 
D.par11, D.par12, D.par13, D.par14, D.par15, 
D.par16, D.par17, D.par18, D.par19, D.par20, 
D.par21, D.par22 FROM devolucionnp AS D WHERE D.control ='{$this->input->get('CONTROL')}' LIMIT 1")->result());
            } else {
                print json_encode(array("EXISTE" => "NO"));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
            /* SOLO SE VAN A FACTURAR DEVOLUCIONES */
            exit(0);
            $devolucionnp_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM devolucionnp AS F WHERE F.control = '{$this->input->get('CONTROL')}' LIMIT 1")->result();
            print json_encode($this->db->query("SELECT P.Cliente AS CLIENTE "
                                    . "FROM pedidox AS P "
                                    . "WHERE P.Control LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
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
//            $xxx = $this->input->get();
//            $this->db->select("P.ID, P.Control AS CONTROL, 
//                                P.Clave AS PEDIDO, P.Cliente AS CLIENTE, 
//                                P.FechaPedido  AS FECHA_PEDIDO, P.FechaEntrega AS FECHA_ENTREGA, 
//                                P.Estilo AS ESTILO, P.Color AS COLOR, P.Pares AS PARES, 
//                                0  AS FAC, P.Maquila AS MAQUILA, P.Semana AS SEMANA, 
//                                P.Precio AS PRECIO, FORMAT(P.Precio,2) AS PRECIOT, P.ColorT AS COLORT", false)
//                    ->from("pedidox AS P")
//                    ->where_not_in("P.Control", array(0, 1));
//
//            $people = array(39, 2121, 1810, 2260, 2394, 2285, 2343, 1782, 2332);
//            if (!in_array($xxx['CLIENTE'], $people)) {
//                $this->db->where_not_in("P.stsavan", array(13, 14));
//            }
//            if ($xxx['CLIENTE'] !== '') {
//                $this->db->where("P.Cliente", $xxx['CLIENTE']);
//            }
//            $this->db->order_by("P.FechaRecepcion", "DESC");
//            print json_encode($this->db->get()->result());

            $dt = $this->db->query("SELECT D.ID, D.control AS CONTROL, D.estilo AS ESTILO, D.comb AS COLOR, 
                D.paredev AS PARES, D.parefac AS FACTURADOS, D.ID AS REG, D.maq AS MAQUILA, D.staapl AS ST, 
                D.cargoa AS CARGOA, 
                D.par01 AS P1, D.par02 AS P2, D.par03 AS P3,  D.par04 AS P4, D.par05 AS P5, 
                D.par06 AS P6, D.par07 AS P7, D.par08 AS P8, D.par09 AS P9, D.par10 AS P10, 
                D.par11 AS P11, D.par12 AS P12, D.par13 AS P13, D.par14 AS P14, D.par15 AS P15, 
                D.par16 AS P16, D.par17 AS P17, D.par18 AS P18, D.par19 AS P19, D.par20 AS P20, 
                D.par21 AS P21, D.par22 AS P22,
                (D.par01 +  D.par02 +  D.par03 +   D.par04 +  D.par05  +  
                D.par06 +  D.par07 +  D.par08 +  D.par09 +  D.par10 +  
                D.par11 +  D.par12 +  D.par13 +  D.par14 +  D.par15 +  
                D.par16 +  D.par17 +  D.par18 +  D.par19 +  D.par20 +  
                D.par21 +  D.par22 ) AS PARES_TOTALES
                FROM devolucionnp AS D WHERE D.stafac = 1 ORDER BY D.fechadev DESC")->result();
            print json_encode($dt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosXFacturarXControl() {
        try {
            $xxx = $this->input->get();
            $dt = $this->db->query("SELECT D.ID, D.control AS CONTROL, D.estilo AS ESTILO, D.comb AS COLOR, 
                D.paredev AS PARES, D.parefac AS FACTURADOS, D.ID AS REG, D.maq AS MAQUILA, D.staapl AS ST, 
                D.cargoa AS CARGOA, 
                D.par01 AS P1, D.par02 AS P2, D.par03 AS P3,  D.par04 AS P4, D.par05 AS P5, 
                D.par06 AS P6, D.par07 AS P7, D.par08 AS P8, D.par09 AS P9, D.par10 AS P10, 
                D.par11 AS P11, D.par12 AS P12, D.par13 AS P13, D.par14 AS P14, D.par15 AS P15, 
                D.par16 AS P16, D.par17 AS P17, D.par18 AS P18, D.par19 AS P19, D.par20 AS P20, 
                D.par21 AS P21, D.par22 AS P22,
                (D.par01 +  D.par02 +  D.par03 +   D.par04 +  D.par05  +  
                D.par06 +  D.par07 +  D.par08 +  D.par09 +  D.par10 +  
                D.par11 +  D.par12 +  D.par13 +  D.par14 +  D.par15 +  
                D.par16 +  D.par17 +  D.par18 +  D.par19 +  D.par20 +  
                D.par21 +  D.par22 ) AS PARES_TOTALES
                FROM devolucionnp AS D WHERE  D.control = {$xxx['CONTROL']} LIMIT 1")->result();
            print json_encode($dt);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarDocto() {
        try {
            $x = $this->input->post();
            $HORA = Date('d/m/Y')/* HORA ES UNA FECHA, NO ES UNA HORA NADA QUE VER EL NOMBRE */;
            $HORAS = Date('h:i:s a')/* HORAS SI ES LA HORA */;
            $this->db->set('hora', $HORA)
                    ->set('horas', $HORAS)
                    ->set('referen', $x['REFERENCIA'])
                    ->set('monletra', $x['TOTAL_EN_LETRA'])
                    ->where('factura', $x['FACTURA'])
                    ->where('cliente', $x['CLIENTE'])
                    ->where('tp', $x['TP_DOCTO'])
                    ->where('staped', 1)->update('facturacion');
            $this->db->set('staped', 2)
                    ->where('factura', $x['FACTURA'])
                    ->where('cliente', $x['CLIENTE'])
                    ->where('tp', $x['TP_DOCTO'])
                    ->where('staped', 1)->update('facturacion');
            $IMPORTE_TOTAL_SIN_IVA = $this->db->query("SELECT SUM(F.importe) AS IMPORTE FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']}")->result();
            $IMPORTE_TOTAL_IVA = $this->db->query("SELECT IFNULL(SUM(F.iva),0) AS IMPORTE FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']}")->result();
            $IMPORTE_TOTAL_CON_IVA = $IMPORTE_TOTAL_SIN_IVA[0]->IMPORTE + $IMPORTE_TOTAL_IVA[0]->IMPORTE;
            $TOTAL = $IMPORTE_TOTAL_SIN_IVA[0]->IMPORTE;
            /* MONEDAS 
             * 1 = PESOS
             * 2 = DOLARES
             */
            switch (intval($x['MONEDA'])) {
                case 1:
                    switch (intval($x['TP_DOCTO'])) {
                        case 1:
                            $TOTAL = $IMPORTE_TOTAL_CON_IVA;
                            break;
                        case 2:
                            $TOTAL = $IMPORTE_TOTAL_SIN_IVA[0]->IMPORTE;
                            break;
                    }
                    break;
                case 2:
                    switch (intval($x['TP_DOCTO'])) {
                        case 1:
                            $TOTAL *= $x['TIPO_DE_CAMBIO'];
                            $TOTAL *= 0.16;
                            break;
                        case 2:
                            $TOTAL = $IMPORTE_TOTAL_SIN_IVA * $x['TIPO_DE_CAMBIO'];
                            break;
                    }
                    break;
            }

            $fecha = $x['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            $hora = Date('h:i:s');
            PRINT "\n*** IMPORTE TOTAL ***\n";
            var_dump($TOTAL);
            PRINT "\n*** IMPORTE TOTAL ***\n";
            $this->db->insert('cartcliente', array(
                'cliente' => $x['CLIENTE'], 'remicion' => $x['FACTURA'],
                'fecha' => "{$anio}-{$mes}-{$dia} $hora", 'importe' => $TOTAL,
                'tipo' => $x['TP_DOCTO'],
                'status' => 1, 'pagos' => 0,
                'saldo' => $TOTAL, 'comiesp' => 1,
                'tcamb' => $x['TIPO_DE_CAMBIO'], 'tmnda' => (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1),
                'nc' => (($x['REFACTURACION'] === 1) ? 888 : 0),
                'factura' => ((intval($x['TP_DOCTO']) === 1) ? 0 : 1)));
            $l = new Logs("FACTURACION (CIERRE)", "HA CERRADO LA FACTURA {$x['FACTURA']} CON EL CLIENTE {$x['CLIENTE']} DE  $" . number_format($TOTAL, 4, ".", ",") . ", CON UN TIPO DE CAMBIO DE {$x['TIPO_DE_CAMBIO']}.", $this->session);

            if (intval($x['TP_DOCTO']) === 1) {
                print "\n*** TIMBRANDO FACTURA {$x['FACTURA']} CON IMPORTE DE $" . number_format($TOTAL, 4, ".", ",") . "***\n";
                exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe ' . $x['FACTURA'] . '" ');
                exec('schtasks /run /tn "Timbrar"  ');
                exec('schtasks /delete /tn "Timbrar" /F ');
                $l = new Logs("FACTURACION (TIMBRADO)", "HA TIMBRADO LA FACTURA {$x['FACTURA']} CON EL CLIENTE {$x['CLIENTE']}, POR  $" . number_format($TOTAL, 4, ".", ",") . ", CON UN TIPO DE CAMBIO DE {$x['TIPO_DE_CAMBIO']}.", $this->session);
            }
            /*             * *CARTAFAC** */
            $FACTURA_CAJAS = $this->db->query("SELECT SUM(F.cajas) AS CAJAS FROM facturacion AS F WHERE F.factura = '{$x['FACTURA']}' AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']};")->result();
            $FACTURA_PARES = $this->db->query("SELECT SUM(F.cantidad) AS PARES FROM facturadetalle AS F WHERE F.numfac = '{$x['FACTURA']}' AND F.numcte = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']};")->result();
            $PARES = 0;
            $PARES = $FACTURA_PARES[0]->PARES;
            $this->db->insert("cartafac", array(
                "cliente" => $x['CLIENTE'],
                "subcte" => 0,
                "factura" => $x['FACTURA'],
                "tp" => $x['TP_DOCTO'],
                "guia" => 0,
                "fecha" => "{$anio}-{$mes}-{$dia} 00:00:00",
                "pares" => $FACTURA_PARES[0]->PARES,
                "status" => 2,
                "cajas" => $FACTURA_CAJAS[0]->CAJAS,
                "importe" => $TOTAL,
                "traspo" => 0,
                "transp" => 0
            ));
            $l = new Logs("FACTURACION (CIERRE)(CARTAFAC)", "HA GENERADO UNA CARTA PARA LA FACTURA ({$x['FACTURA']}) DEL CLIENTE({$x['CLIENTE']}) CON {$PARES} PARES TIPO {$x['TP_DOCTO']}.", $this->session);
            /*             * *CARTAFAC** */
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTipoDeCambio() {
        try {
            print json_encode($this->db->query('SELECT TDC.Dolar AS DOLAR, TDC.Euro AS EURO, TDC.Libra AS LIBRA, TDC.Jen AS JEN FROM tipocambio AS TDC')->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarDocto() {
        try {
            $x = $this->input->post();
            $this->db->trans_begin();
            $fecha = $x['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            $hora = Date('h:i:s');
            $f = array(
                'factura' => $x['FACTURA'], 'tp' => $x['TP_DOCTO'],
                'cliente' => $x['CLIENTE'], 'contped' => $x['CONTROL'],
                'fecha' => "$anio-$mes-$dia $hora", 'hora' => Date('d/m/Y'),
                'corrida' => $x['SERIE'], 'pareped' => $x['PARES_A_FACTURAR'],
                'estilo' => $x['ESTILO'], 'combin' => $x['COLOR']);
            for ($i = 1; $i < 23; $i++) {
                if ($i < 10) {
                    $f["par0$i"] = $x["CAF$i"];
                } else {
                    $f["par$i"] = $x["CAF$i"];
                }
            }
            $f["precto"] = $x["PRECIO"];
            $f["subtot"] = $x["SUBTOTAL"];
            $f["iva"] = $x["IVA"];
            $f["staped"] = 1;
            $f["monletra"] = $x["TOTAL_EN_LETRA"];
            $f["tmnda"] = (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1);
            $f["tcamb"] = $x["TIPO_CAMBIO"];
            $f["cajas"] = $x["CAJAS"];
            $f["origen"] = 0;
            $f["referen"] = $x["REFERENCIA"];

            $f["decdias"] = 0;
            $f["agente"] = $x["AGENTE"];
            $f["colsuel"] = $x["COLOR_TEXT"];
            $f["tpofac"] = 1;
            $f["año"] = date('Y');
            $f["zona"] = $x["ZONA"];
            $f["horas"] = date('h:i:s a');
            $f["numero"] = 1;
            $f["talla"] = 0;
            $f["cobarr"] = "";
            $f["pedime"] = NULL;
            $f["ordcom"] = NULL;
            $f["numadu"] = NULL;
            $f["nomadu"] = NULL;
            $f["regadu"] = NULL;
            $f["periodo"] = Date('Y');
            $f["costo"] = NULL;
            $f["obs"] = $x["OBSERVACIONES"];
            $this->db->insert('facturacion', $f);
            $tipo_cambio = 0;
            switch (intval($x["TIPO_CAMBIO"])) {
                case 1:
                    /* PESOS */
                    $tipo_cambio = 0;
                    break;
                case 2:
                    /* DOLAR */
                    $tipo_cambio = $x["TIPO_CAMBIO"];
                    break;
                case 3:
                    /* JEN */
                    $tipo_cambio = $x["TIPO_CAMBIO"];
                    break;
            }
            /* FACTURACION DETALLE */
            $facturacion_detalle = array(
                'numfac' => $x['FACTURA'], 'numcte' => $x['CLIENTE'],
                'tp' => $x['TP_DOCTO'], 'claveproducto' => $x['CODIGO_SAT'],
                'claveunidad' => 'PR', 'cantidad' => $x['PARES_A_FACTURAR'],
                'unidad' => 'PAR', 'codigo' => $x['ESTILO'],
                'descripcion' => $x['ESTILOT'], 'Precio' => $x['PRECIO'],
                'importe' => $x['SUBTOTAL'], 'fecha' => $x['FECHA'],
                'control' => $x['CONTROL'], 'iva' => $x['IVA'],
                'tmnda' => (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1),
                'tcamb' => $tipo_cambio,
                'noidentificado' => NULL,
                'referencia' => $x['REFERENCIA'],
                'tienda' => $x['TIENDA']);
            $this->db->insert('facturadetalle', $facturacion_detalle);

//            contped, pareped, par01, par02, par03, par04, par05, par06, par07, par08, par09, par10, par11, par12, par13, par14, par15, par16, par17, par18, par19, par20, par21, par22, staped
            $saldopares = intval($x['PARES']) - intval($x['PARES_A_FACTURAR']);

            $devolucion = $this->db->query("SELECT * FROM devolucionnp AS D WHERE D.ID = {$x['DEVOLUCION']}")->result();
            if ($saldopares === 0) {
                $pares_a_facturar = intval($x['PARES_A_FACTURAR']) > 0 ? intval($x['PARES_A_FACTURAR']) : 0;
                $this->db->query("UPDATE devolucionnp "
                        . "SET stafac = 2, "
                        . "parefac = (parefac + {$pares_a_facturar}) WHERE ID = {$x['DEVOLUCION']}");
            } else if (intval($x['PARES_A_FACTURAR']) < $saldopares) {
                $this->db->query("UPDATE devolucionnp "
                        . "SET stafac = 1, "
                        . "parefac = (parefac + {$pares_a_facturar}) WHERE ID = {$x['DEVOLUCION']}");
            }
            if (intval($devolucion[0]->fact) === 0) {
                $this->db->query("UPDATE devolucionnp "
                        . "SET fact = {$x['FACTURA']} WHERE ID = {$x['DEVOLUCION']}");
            } else if (intval($devolucion[0]->fact1) === 0) {
                $this->db->query("UPDATE devolucionnp "
                        . "SET fact1 = {$x['FACTURA']} WHERE ID = {$x['DEVOLUCION']}");
            } else if (intval($devolucion[0]->fact2) === 0) {
                $this->db->query("UPDATE devolucionnp "
                        . "SET fact2 = {$x['FACTURA']} WHERE ID = {$x['DEVOLUCION']}");
            }
            /* SI EXISTE ES PORQUE YA HAY PARES FACTURADOS DE ESTE CONTROL CON ANTERIORIDAD */

            /* SI EL SALDO ES IGUAL A CERO "0", PASAR A CERO */
//            $this->db->where('Control', $x['CONTROL'])->update('pedidox', array('stsavan' => 13));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
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

    public function onObtenerCodigoSatXEstilo() {
        try {
            print json_encode(
                            $this->db->query("SELECT G.ClaveProductoSAT AS CPS FROM estilos AS E INNER JOIN generos AS G ON E.Genero = G.Clave WHERE E.Clave LIKE '{$this->input->get('ESTILO')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarCFDI() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT F.Factura, F.numero, F.FechaFactura, F.CadenaOriginal,"
                                            . "F.uuid, F.fechatimbrado, F.certificadosat, F.certificadocfd, F.sellosat, "
                                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura LIKE '{$x['DOCUMENTO_FACTURA']}' ")
                                    ->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVistaPrevia() {
        try {
//            $x = $this->input->post();
//
//            $rfc_cliente = $this->db->query("SELECT C.RFC AS RFC FROM clientes AS C WHERE C.Clave LIKE '{$x['CLIENTE']}' LIMIT 1")->result();
//
////            $dtm = $this->db->query("SELECT F.Factura, F.numero, F.FechaFactura, F.CadenaOriginal,"
////                            . "F.uuid, F.fechatimbrado, F.certificadosat, F.certificadocfd, F.sellosat, "
////                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura LIKE '{$x['DOCUMENTO_FACTURA']}' ")
////                    ->result();
//            $dtm = $this->db->query("SELECT 
//A.Comprobante, A.Tipo, A.Version, A.Serie, A.Folio, A.StatusUUID, A.Numero, A.FechaCancelacion, A.UUID AS UUID, A.Fecha, A.SubTotal, A.Descuento, A.Total, 
//A.EmisorRfc, A.ReceptorRfc, A.EmisorNombre, A.ReceptorNombre, A.FormaPago, A.MetodoPago, A.UsoCfdi, A.Moneda, A.TipoCambio, A.CertificadoSAT, A.CertificadoCFD, 
//A.FechaTimbrado, A.CadenaOriginal, A.selloSAT, A.selloCFD, A.CfdiTimbrado, A.Periodo FROM comprobantes AS A WHERE A.Folio = '{$x['DOCUMENTO_FACTURA']}' ")
//                    ->result();
//            $total_factura = $this->db->query("SELECT round(((SUM(F.subtot)) * 1.16),2) AS TOTAL FROM facturacion AS F "
//                            . "WHERE F.factura LIKE '{$x['DOCUMENTO_FACTURA']}' AND F.tp = {$x['TP']} LIMIT 1")->result();
//            $cfdi = $dtm[0];
//            $TOTAL_FOR = number_format($total_factura[0]->TOTAL, 6, ".", "");
//            $UUID = $cfdi->UUID;
//            $rfc_emi = $this->session->EMPRESA_RFC;
//            $rfc_rec = $rfc_cliente[0]->RFC;
//
//            $CERTIFICADO = $cfdi->CertificadoCFD;
//
//            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$UUID&re=$rfc_emi&rr=$rfc_rec&tt=$TOTAL_FOR&fe=TW9+rA==";
//
//            $jc = new JasperCommand();
//            $jc->setFolder('rpt/' . $this->session->USERNAME);
//            $qr_url = QRcode::png($qr, 'rpt/qr.png');
//            $pr = array();
//            $pr["logo"] = base_url() . $this->session->LOGO;
//            $pr["empresa"] = $this->session->EMPRESA_RAZON;
            $x = $this->input->post();

            $rfc_cliente = $this->db->query("SELECT C.RFC AS RFC FROM clientes AS C WHERE C.Clave LIKE '{$x['CLIENTE']}' LIMIT 1")->result();
                
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $pr = array();
            $CERTIFICADO_CFD = "";
            $EXISTE_EN_COMPROBANTES = $this->db->query("SELECT  count(*) AS EXISTE  "
                            . "FROM comprobantes AS C WHERE C.Folio = '{$x['DOCUMENTO_FACTURA']}' ")->result();

            if (intval($x['TP']) === 1 && $EXISTE_EN_COMPROBANTES[0]->EXISTE > 0) {
                $pr["logo"] = base_url() . $this->session->LOGO;
                $pr["empresa"] = $this->session->EMPRESA_RAZON;
                $dtm = $this->db->query("SELECT  C.Comprobante, C.Tipo, C.Version, C.Serie, "
                                . "C.Folio, C.StatusUUID, C.Numero, C.FechaCancelacion, "
                                . "C.UUID AS uuid, C.Fecha, C.SubTotal, C.Descuento, C.Total, "
                                . "C.EmisorRfc, C.ReceptorRfc, C.EmisorNombre, C.ReceptorNombre, "
                                . "C.FormaPago, C.MetodoPago, C.UsoCfdi, C.Moneda, C.TipoCambio, "
                                . "C.CertificadoSAT, C.CertificadoCFD, C.FechaTimbrado, C.CadenaOriginal, "
                                . "C.selloSAT, C.selloCFD, C.CfdiTimbrado, C.Periodo "
                                . "FROM comprobantes AS C WHERE C.Folio = '{$x['DOCUMENTO_FACTURA']}' ")
                        ->result();
                $total_factura = $this->db->query("SELECT round(((SUM(F.subtot)) * 1.16),2) AS TOTAL FROM facturacion AS F "
                                . "WHERE F.factura LIKE '{$x['DOCUMENTO_FACTURA']}' AND F.tp = {$x['TP']} LIMIT 1")->result();

                $rfc_emi = $this->session->EMPRESA_RFC;
                $rfc_rec = (!empty($rfc_cliente) ? $rfc_cliente[0]->RFC : "XXXX");

                if (!empty($dtm)) {
                    $cfdi = $dtm[0];
                    $TOTAL_FOR = number_format($total_factura[0]->TOTAL, 6, ".", "");
                    $UUID = $cfdi->uuid;

                    $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$UUID&re=$rfc_emi&rr=$rfc_rec&tt=$TOTAL_FOR&fe=TW9+rA==";
                } else {
                    $qr = "NO SE OBTUVIERON DATOS DEL CFDI, INTENTE NUEVAMENTE O MAS TARDE  (QR ERROR)";
                    exit(0);
                }
                $qr_url = QRcode::png($qr, 'rpt/qr.png');
                switch (intval($x["TP"])) {
                    case 1:
                        $pr["logo"] = base_url() . $this->session->LOGO;
                        $pr["empresa"] = $this->session->EMPRESA_RAZON;
                        BREAK;
                }
                $CERTIFICADO_CFD = $cfdi->CertificadoCFD;
            }
            switch (intval($x["TP"])) {
                case 1:
                    switch (intval($x['CLIENTE'])) {
                        case 2121:
                            /* COPPEL */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2121.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 1810:
                            /* ZAPATERIAS COBAN, S.A.  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 1445:
//                    print "AQUI 1445";
                            /* ELECTROLAB MEDIC, S.A. DE C.V.  = SI HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2394:
                            /* INVERSIONES CENTROAMERICANAS INCEN, S.A.  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2432:
                            /* CONFIANDO, SOCIEDAD ANONIMA = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2434:
                            /* PIELES FINAS, SOCIEDAD ANONIMA  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2212:
                            /* COORDINADORA DE FOMENTO AL COMERCIO EXTERIOR DEL ESTADO DE GUANAJUATO  = NO HAY RESULTADOS 28/08/2019 */

                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2212.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2415:
                            /* IMPORTADORA SOES, S.A.   = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();

                            break;
                        case 2428:
                            /* INTERNACIONAL DE CALZADO, SOCIEDAD ANONIMA    = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 39:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 1755:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2361:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();

                            break;
                        case 1782:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 696:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();

                            break;
                        case 100:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2285:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2228:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2228.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2228:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $this->getReporteXNumero($x, $jc, "facturaelec2228");
                            break;
                        case 2332:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $jc->setParametros($pr);
                            $this->getReporteXNumero($x, $jc, "facturaelec2332");
                            break;
                        case 2343:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $this->getReporteXNumero($x, $jc, "facturaelec2343");
                            break;
                        case 1967:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $this->getReporteXNumero($x, $jc, "facturaelec2212");
                            break;
                        default :
                            $jc->setParametros($pr);
                            $jc->setJasperurl("jrxml\facturacion\facturaelec3.jasper");
                            $jc->setFilename("{$x['CLIENTE']}_xxx_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                    }
                case 2:
                    $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                    $jc->setParametros($pr);
                    $jc->setJasperurl('jrxml\facturacion\remisionva1.jasper');
                    $jc->setFilename("remisionva1_{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                    $jc->setDocumentformat('pdf');
                    PRINT $jc->getReport();
                    exit(0);
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporteXNumero($x, $jc, $num_reporte) {
        try {
            $jc->setJasperurl("jrxml\facturacion\{$num_reporte}.jasper");
            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getQR($str) {
        QRcode::png($str);
    }

    public function getFacturaXFolio() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT F.ID,(C.Descuento *100) AS DESCUENTO, 
            (F.par01 +  F.par02 +  F.par03 +  F.par04 +  F.par05 +  F.par06 +  F.par07 +  F.par08 +  F.par09 +  F.par10 +  
            F.par11 +  F.par12 +  F.par13 +  F.par14 +  F.par15 +  F.par16 +  F.par17 +  F.par18 +  F.par19 +  F.par20 +  
            F.par21 +  F.par22) AS PARES_FACTURADOS,
            F.factura AS FACTURA, F.tp AS TP, F.cliente AS CLIENTE, F.contped AS CONTROL, 
            DATE_FORMAT(F.fecha,'%d/%m/%Y') AS FECHA_FACTURA, 
            F.hora, F.corrida, F.pareped AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, 
            F.par01, F.par02, F.par03, F.par04, F.par05, F.par06, F.par07, F.par08, F.par09, F.par10, 
            F.par11, F.par12, F.par13, F.par14, F.par15, F.par16, F.par17, F.par18, F.par19, F.par20, 
            F.par21, F.par22, F.precto AS PRECIO, F.subtot AS SUBTOTAL, F.iva, F.staped, F.monletra, 
            F.tmnda AS TIPO_MONEDA, F.tcamb AS TIPO_CAMBIO, F.cajas AS CAJAS_FACTURACION, F.origen, F.referen, F.decdias, F.agente, 
            F.colsuel, F.tpofac, F.año, F.zona, F.horas, F.numero, F.talla, F.cobarr, F.pedime, F.ordcom, 
            F.numadu, F.nomadu, F.regadu, F.periodo, F.costo, F.obs AS OBS, 
            (SELECT P.EstatusProduccion AS ESTATUS_PRODUCCION 
            FROM pedidox AS P WHERE P.Control = F.contped LIMIT 1) AS ESTATUS_PRODUCCION 
            FROM facturacion AS F INNER JOIN clientes AS C ON F.cliente = C.Clave  WHERE F.factura = '{$x['FACTURA']}' "
                                    . " AND F.tp = {$x['TP']} AND F.cliente = '{$x['CLIENTE']}' AND C.Clave = '{$x['CLIENTE']}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDevolver() {
        try {
            $x = $this->input->post();

            $d = array(
                "cliente" => $x["CLIENTE"],
                "docto" => $x["DOCUMENTO"],
                "aplica" => 0,
                "nc" => $x["NOTA_DE_CREDITO"],
                "fact" => $x["FACTURA_UNO"],
                "fact1" => $x["FACTURA_DOS"],
                "fact2" => $x["FACTURA_TRES"],
                "conce" => $x["CONCEPTO"],
                "tp" => $x["TP"],
                "tpvta" => $x["TP_VTA"],
                "control" => $x["CONTROL"],
                "controlprd" => $x["CONTROL_PRODUCCION"],
                "paredev" => $x["PARES"],
                "parefac" => $x["PARES_FACTURADOS"]);

            for ($i = 1; $i < 23; $i++) {
                if ($i < 10) {
                    $d["par0$i"] = $x["CAF$i"];
                } else {
                    $d["par$i"] = $x["CAF$i"];
                }
            }
            $d["defecto"] = $x["xxxxxx"];
            $d["detalle"] = $x["xxxxxx"];
            $d["clasif"] = $x["xxxxxx"];
            $d["cargoa"] = $x["xxxxxx"];
            $d["fecha"] = $x["xxxxxx"];
            $d["fechadev"] = $x["xxxxxx"];
            $d["estilo"] = $x["xxxxxx"];
            $d["comb"] = $x["xxxxxx"];
            $d["seriped"] = $x["xxxxxx"];
            $d["precio"] = $x["xxxxxx"];
            $d["subtot"] = $x["xxxxxx"];
            $d["registro"] = $x["xxxxxx"];
            $d["stafac"] = $x["xxxxxx"];
            $d["staapl"] = $x["xxxxxx"];
            $d["maq"] = $x["xxxxxx"];
            $d["preciodev"] = $x["xxxxxx"];
            $d["preciomaq"] = $x["xxxxxx"];
            $d["obs1"] = $x["xxxxxx"];
            $d["ctenvo"] = $x["xxxxxx"];
            $d["pedidonvo"] = $x["xxxxxx"];
            $this->db->insert("devolucionnp", $d);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevolucionesXControl() {
        try {
            $x = $this->input->post();
            print json_encode($this->db->query("SELECT 
                                                (D.par01 + D.par02 + D.par03 + D.par04 + D.par05 + 
                                                D.par06 + D.par07 + D.par08 + D.par09 + D.par10 + 
                                                D.par11 + D.par12 + D.par13 + D.par14 + D.par15 + 
                                                D.par16 + D.par17 + D.par18 + D.par19 + D.par20 + 
                                                D.par21 + D.par22 ) AS PARES_DEVUELTOS
                                                FROM devolucionnp AS D 
                                                WHERE D.control  = {$x["CONTROL"]}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
