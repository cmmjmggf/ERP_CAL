<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class FacturacionProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->model('RastreoDeControlesEnDocumentos_model', 'rced');
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
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFacturacionProduccion')->view('vFooter');
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
            print json_encode($this->db->query("SELECT P.*,P.Color AS COLOR_CLAVE, P.Clave AS CLAVE_PEDIDO, CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
                                    . "S.T21, S.T22, P.EstatusProduccion AS ESTATUS, P.stsavan AS AVANCE_ESTATUS, P.EstiloT AS ESTILO_TEXT "
                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
                                    . "WHERE P.Control = '{$this->input->get('CONTROL')}'")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturacionDiff() {
        try {
            /* OBTENGO LAS DIFERENCIAS Y EL CLIENTE DE ESTE CONTROL PORQUE NO SE PUEDE FACTURAR UN CONTROL A UN CLIENTE AL QUE YA SE ELIGIO */
            $facturacion_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM facturaciondif AS F WHERE F.contped LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result();
//            if (intval($facturacion_existe[0]->EXISTE) > 0) {
//                print json_encode($this->db->query(" F.cliente,
//SUM(F.par01) AS par01, SUM(F.par02) AS par02, SUM(F.par03) AS par03, SUM(F.par04) AS par04, SUM(F.par05) AS par05,
//SUM(F.par06) AS par06, SUM(F.par07) AS par07, SUM(F.par08) AS par08, SUM(F.par09) AS par09, SUM(F.par10) AS par10,
//SUM(F.par11) AS par11, SUM(F.par12) AS par12, SUM(F.par13) AS par13, SUM(F.par14) AS par14, SUM(F.par15) AS par15,
//SUM(F.par16) AS par16, SUM(F.par17) AS par17, SUM(F.par18) AS par18, SUM(F.par19) AS par19, SUM(F.par20) AS par20,
//SUM(F.par21) AS par21, SUM(F.par22) AS par22
//FROM facturacion AS F  INNER JOIN pedidox AS P ON F.contped = P.Control
//                WHERE F.contped LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
            print json_encode($this->db->query("SELECT
                                        F.contped, F.pareped, F.par01, F.par02, F.par03, F.par04, F.par05,
                                        F.par06, F.par07, F.par08, F.par09, F.par10,
                                        F.par11, F.par12, F.par13, F.par14, F.par15,
                                        F.par16, F.par17, F.par18, F.par19, F.par20,
                                        F.par21, F.par22, F.staped, P.Cliente AS CLIENTE
                                        FROM facturaciondif AS F  INNER JOIN pedidox AS P ON F.contped = P.Control
                WHERE F.contped = '{$this->input->get('CONTROL')}' LIMIT 1")->result());
//            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
            $xxx = $this->input->get();
            $this->db->select("P.Cliente AS CLIENTE", false)->from("pedidox AS P")
                    ->where("P.Control", $xxx['CONTROL']);
            $people = array(39, 2121, 1810, 2260, 2394, 2285, 2343, 1782, 2332);
            if (!in_array($xxx['CLIENTE'], $people)) {
                $this->db->where_not_in("P.stsavan", array(13, 14));
            }
            $this->db->limit(1);
            print json_encode($this->db->get()->result());
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
            $xxx = $this->input->get();
            $this->db->select("P.ID, P.Control AS CONTROL,
                                P.Clave AS PEDIDO,
                                (SELECT CONCAT(P.Cliente,' ',C.RazonS) FROM clientes AS C WHERE C.Clave = P.Cliente LIMIT 1) AS CLIENTE ,
                                P.FechaPedido  AS FECHA_PEDIDO, P.FechaEntrega AS FECHA_ENTREGA,
                                P.Estilo AS ESTILO, P.Color AS COLOR, P.Pares AS PARES,
                                0  AS FAC, P.Maquila AS MAQUILA, P.Semana AS SEMANA,
                                P.Precio AS PRECIO, FORMAT(P.Precio,2) AS PRECIOT, P.ColorT AS COLORT", false)
                    ->from("pedidox AS P")
                    ->where_not_in("P.Control", array(0, 1));

            $people = array(39, 2121, 1810, 2260, 2394, 2285, 2343, 1782, 2332);
            if (!in_array($xxx['CLIENTE'], $people)) {
                $this->db->where_not_in("P.stsavan", array(13, 14));
            }
//            if ($xxx['CLIENTE'] !== '') {
//                $this->db->where("P.Cliente", $xxx['CLIENTE']);
//            }
            if ($xxx['CONTROL'] !== '') {
                $this->db->where("P.Control", $xxx['CONTROL']);
            }
            if ($xxx['PEDIDO'] !== '') {
                $this->db->where("P.Control", $xxx['PEDIDO']);
            }
            if ($xxx['ESTILO'] !== '') {
                $this->db->where("P.Control", $xxx['ESTILO']);
            }
            if ($xxx['CONTROL'] === '') {
                $this->db->limit(100);
            }
            $this->db->order_by("P.FechaRecepcion", "DESC");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarDocto() {
        try {
            $x = $this->input->post();

//            exit(0);
            $HORA = Date('d/m/Y')/* HORA ES UNA FECHA, NO ES UNA HORA NADA QUE VER EL NOMBRE */;
            $HORAS = Date('h:i:s a')/* HORAS SI ES LA HORA */;

//            foreach ($this->db->query("SELECT * FROM facturacion AS F WHERE F.factura = {$x['FACTURA']} AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']} AND F.staped = 1")->result() AS $k => $v) {
//
//            }

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

            if (intval($x['TP_DOCTO']) === 1) {
                $IMPORTE_TOTAL_SIN_IVA = $this->db->query("SELECT SUM(F.importe) AS IMPORTE FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']} AND F.numcte = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']}")->result();

                $IMPORTE_TOTAL_IVA = $this->db->query("SELECT IFNULL(SUM(F.iva),0) AS IMPORTE FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']} AND F.numcte = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']}")->result();
            } else {
                $IMPORTE_TOTAL_SIN_IVA = $this->db->query("SELECT SUM(F.subtot) AS IMPORTE FROM facturacion AS F WHERE F.factura = {$x['FACTURA']}  AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']}")->result();

                $IMPORTE_TOTAL_IVA = $this->db->query("SELECT IFNULL(SUM(F.iva),0) AS IMPORTE FROM facturacion AS F WHERE F.factura = {$x['FACTURA']}  AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']}")->result();
            }

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
            PRINT "\n*** IMPORTE TOTAL SIN IVA TOTAL ***\n";
            var_dump($TOTAL);
            PRINT "\n*** IMPORTE TOTAL SIN IVA TOTAL***\n";
            $this->db->insert('cartcliente', array(
                'cliente' => $x['CLIENTE'], 'remicion' => $x['FACTURA'],
                'fecha' => "{$anio}-{$mes}-{$dia} 00:00:00", 'importe' => $TOTAL,
                'tipo' => $x['TP_DOCTO'],
                'status' => 1, 'pagos' => 0,
                'saldo' => $TOTAL, 'comiesp' => 1,
                'tcamb' => $x['TIPO_DE_CAMBIO'],
                'tmnda' => (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1),
                'nc' => (($x['REFACTURACION'] === 1) ? 888 : 0),
                'factura' => ((intval($x['TP_DOCTO']) === 1) ? 0 : 1)));
            $l = new Logs("FACTURACION (CIERRE)", "HA CERRADO LA FACTURA {$x['FACTURA']} CON EL CLIENTE {$x['CLIENTE']} DE  $" . number_format($TOTAL, 4, ".", ",") . ", CON UNA MONEDA EN {$x["MONEDA"]} Y CON UN TIPO DE CAMBIO DE {$x['TIPO_DE_CAMBIO']}.", $this->session);

//
//            if (intval($x['TP_DOCTO']) === 1) {
//                print "\n*** TIMBRANDO FACTURA {$x['FACTURA']} CON IMPORTE DE $" . number_format($TOTAL, 4, ".", ",") . "***\n";
//                exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe ' . $x['FACTURA'] . '" ');
//                exec('schtasks /run /tn "Timbrar"  ');
//                exec('schtasks /delete /tn "Timbrar" /F ');
//                $l = new Logs("FACTURACION (TIMBRADO)", "HA TIMBRADO LA FACTURA {$x['FACTURA']} CON EL CLIENTE {$x['CLIENTE']}, POR  $" . number_format($TOTAL, 4, ".", ",") . ", CON UN TIPO DE CAMBIO DE {$x['TIPO_DE_CAMBIO']}.", $this->session);
//            }
            /*             * *CARTAFAC** */
            $FACTURA_CAJAS = $this->db->query("SELECT SUM(F.cajas) AS CAJAS FROM facturacion AS F WHERE F.factura = '{$x['FACTURA']}' AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']};")->result();
            if (intval($x['TP_DOCTO']) === 1) {
                $FACTURA_PARES = $this->db->query("SELECT SUM(F.cantidad) AS PARES FROM facturadetalle AS F WHERE F.numfac = '{$x['FACTURA']}' AND F.numcte = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']};")->result();
            } else {
                $FACTURA_PARES = $this->db->query("SELECT SUM(F.pareped) AS PARES FROM facturacion AS F WHERE F.factura = '{$x['FACTURA']}' AND F.cliente = {$x['CLIENTE']} AND F.tp = {$x['TP_DOCTO']};")->result();
            }
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
                "cajas" => $x['CAJAS'],
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
//            exit(0);
            $this->db->trans_begin();
            $fecha = $x['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            $hora = Date('h:i:s');
            $f = array(
                'factura' => $x['FACTURA'],
                'tp' => $x['TP_DOCTO'],
                'cliente' => $x['CLIENTE'],
                'contped' => $x['CONTROL'],
                'fecha' => "$anio-$mes-$dia 00:00:00",
                'hora' => Date('d/m/Y'),
                'corrida' => $x['SERIE'],
                'pareped' => $x['PARES_A_FACTURAR'],
                'estilo' => $x['ESTILO'],
                'combin' => $x['COLOR']
            );
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
            $f["obs"] = strlen($x["OBSERVACIONES"]) > 0 ? $x["OBSERVACIONES"] : "SO";
            $this->db->insert('facturacion', $f);
//            print $this->db->last_query();
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
            if (intval($x['TP_DOCTO']) === 1) {
                $facturacion_detalle = array(
                    'numfac' => $x['FACTURA'], 'numcte' => $x['CLIENTE'],
                    'tp' => $x['TP_DOCTO'], 'claveproducto' => $x['CODIGO_SAT'],
                    'claveunidad' => 'PR', 'cantidad' => $x['PARES_A_FACTURAR'],
                    'unidad' => 'PAR', 'codigo' => $x['ESTILO'],
                    'descripcion' => $x['ESTILOT'], 'Precio' => $x['PRECIO'],
                    'importe' => $x['SUBTOTAL'], 'fecha' => "$anio-$mes-$dia $hora",
                    'control' => $x['CONTROL'], 'iva' => $x['IVA'],
                    'tmnda' => (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1),
                    'tcamb' => $tipo_cambio,
                    'noidentificado' => NULL,
                    'referencia' => $x['REFERENCIA'],
                    'tienda' => $x['TIENDA']);
                $this->db->insert('facturadetalle', $facturacion_detalle);
            }
//            contped, pareped, par01, par02, par03, par04, par05, par06, par07, par08, par09, par10, par11, par12, par13, par14, par15, par16, par17, par18, par19, par20, par21, par22, staped
            $saldopares = intval($x['PARES']) - ($x['PARES_FACTURADOS'] + intval($x['PARES_A_FACTURAR']));
            print "SALDO PARES : {$saldopares}";

            $facturaciondif = array(
                'pareped' => $saldopares/* PARES QUE FALTAN POR FACTURAR */,
                'staped' => (($saldopares == 0) ? 99 : 98)
            );
            if ($saldopares === 0) {


                //Validar clientes permitidos para facturar por adelantado

                $people = array(39, 2121, 1810, 2260, 2394, 2343, 2228, 2285, 2428, 1445, 1782);
                if (!in_array($x['CLIENTE'], $people)) {
                    $EstatusProduccion = 'FACTURADO';
                    $DeptoProduccion = 260;
                    /* ACTUALIZAR  ESTATUS DE PRODUCCION  EN CONTROLES */
                    $this->db->set('EstatusProduccion', $EstatusProduccion)
                            ->set('DeptoProduccion', $DeptoProduccion)
                            ->where('Control', $x['CONTROL'])->update('controles');
                    /* ACTUALIZAR ESTATUS DE PRODUCCION EN PEDIDOS */
                    $this->db->where('Control', $x['CONTROL'])->update('pedidox', array('stsavan' => 13,
                        'EstatusProduccion' => $EstatusProduccion,
                        'DeptoProduccion' => $DeptoProduccion
                    ));
                    /* ACTUALIZAR FECHA 13 (FACTURADO) EN AVAPRD (SE HACE PARA FACILITAR LOS REPORTES) */
                    $this->db->set('fec13', Date('Y-m-d 00:00:00'))->where('contped', $x['CONTROL'])
                            ->update('avaprd');
                    $l = new Logs("FACTURACIÓN", "HA AVANZO EL CONTROL {$x['CONTROL']} A FACTURADO CON EL CLIENTE {$x['CLIENTE']}.", $this->session);
                }

                $control = $this->db->query("SELECT P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, "
                                . "P.C11, P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, "
                                . "P.C21, P.C22 FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result();
                $control_pedidox = $control[0];
//                print "\n";
//                print_r($control_pedidox);
//                print "\n";

                $this->db->where('contped', $x['CONTROL'])->update('facturacion',
                        array(
                            'par01' => $control_pedidox->C1, 'par02' => $control_pedidox->C2,
                            'par03' => $control_pedidox->C3, 'par04' => $control_pedidox->C4,
                            'par05' => $control_pedidox->C5, 'par06' => $control_pedidox->C6,
                            'par07' => $control_pedidox->C7, 'par08' => $control_pedidox->C8,
                            'par09' => $control_pedidox->C9, 'par10' => $control_pedidox->C10,
                            'par11' => $control_pedidox->C11, 'par12' => $control_pedidox->C12,
                            'par13' => $control_pedidox->C13, 'par14' => $control_pedidox->C14,
                            'par15' => $control_pedidox->C15, 'par16' => $control_pedidox->C16,
                            'par17' => $control_pedidox->C17, 'par18' => $control_pedidox->C18,
                            'par19' => $control_pedidox->C19, 'par20' => $control_pedidox->C20
                ));

//                par01, par02, par03, par04, par05, par06, par07, par08, par09, par10, par11, par12, par13, par14, par15, par16, par17, par18, par19, par20, par21, par22
            }
            /* SUMA LOS PARES FACTURADOS: SI  SON 36 PARES Y SOLO FACTURAN 18, */
            $PF = (is_numeric($x['PARES_A_FACTURAR']) ? intval($x['PARES_A_FACTURAR']) : 0);
            $this->db->query("UPDATE pedidox "
                    . "SET ParesFacturados = (IFNULL(ParesFacturados,0)+ {$PF}) "
                    . "WHERE Control = {$x['CONTROL']}");

            /* SI EXISTE ES PORQUE YA HAY PARES FACTURADOS DE ESTE CONTROL CON ANTERIORIDAD */
            $existe_en_facdetalle = $this->db->query(
                            "SELECT COUNT(*) AS EXISTE, FD.contped AS ID,"
                            . "FD.contped, FD.pareped, "
                            . "FD.par01, FD.par02, FD.par03, FD.par04, FD.par05, "
                            . "FD.par06, FD.par07, FD.par08, FD.par09, FD.par10, "
                            . "FD.par11, FD.par12, FD.par13, FD.par14, FD.par15, "
                            . "FD.par16, FD.par17, FD.par18, FD.par19, FD.par20, "
                            . "FD.par21, FD.par22 "
                            . "FROM facturaciondif AS FD "
                            . "WHERE FD.contped = '{$x['CONTROL']}'")->result();

            if (intval($existe_en_facdetalle[0]->EXISTE) > 0) {
                for ($ii = 1; $ii < 23; $ii++) {
                    $c = 0;
                    if (intval($x["CAF$ii"]) > 0) {
                        $c = intval($x["C$ii"]) - (intval($x["CF$ii"]) + intval($x["CAF$ii"]));
                    }
                    if ($ii < 10) {
                        $facturaciondif["par0$ii"] = $c;
                    } else {
                        $facturaciondif["par$ii"] = $c;
                    }
                }
                $this->db->where('contped', $x['CONTROL'])
                        ->update('facturaciondif', $facturaciondif);
            } else {
                for ($iii = 1; $iii < 23; $iii++) {
                    $c = 0;
                    if (intval($x["CAF$iii"]) > 0) {
                        $c = (intval($x["C$iii"]) - intval($x["CAF$iii"]));
                    }
                    if ($iii < 10) {
                        $facturaciondif["par0$iii"] = intval($x["CAF$iii"]);
                    } else {
                        $facturaciondif["par$iii"] = intval($x["CAF$iii"]);
                    }
                }
                $facturaciondif['contped'] = $x['CONTROL'];
                $this->db->insert('facturaciondif', $facturaciondif);
            }
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
                                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura = '{$x['DOCUMENTO_FACTURA']}' ")
                                    ->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVistaPrevia() {
        try {
            $x = $this->input->post();

            $rfc_cliente = $this->db->query("SELECT C.RFC AS RFC FROM clientes AS C WHERE C.Clave LIKE '{$x['CLIENTE']}' LIMIT 1")->result();

//            $dtm = $this->db->query("SELECT F.Factura, F.numero, F.FechaFactura, F.CadenaOriginal,"
//                            . "F.uuid, F.fechatimbrado, F.certificadosat, F.certificadocfd, F.sellosat, "
//                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura LIKE '{$x['DOCUMENTO_FACTURA']}' ")
//                    ->result();
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
                    $pr["logo"] = base_url() . $this->session->LOGO;
                    $pr["empresa"] = $this->session->EMPRESA_RAZON;
                    switch (intval($x['CLIENTE'])) {
                        case 2121:
                            /* COPPEL - OK */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MÉXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2121.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 1810:
                            /* ZAPATERIAS COBAN, S.A.  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 1445:
//                    print "AQUI 1445";
                            /* ELECTROLAB MEDIC, S.A. DE C.V.  = SI HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2394:
                            /* INVERSIONES CENTROAMERICANAS INCEN, S.A.  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2432:
                            /* CONFIANDO, SOCIEDAD ANONIMA = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2434:
                            /* PIELES FINAS, SOCIEDAD ANONIMA  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2212:
                            /* COORDINADORA DE FOMENTO AL COMERCIO EXTERIOR DEL ESTADO DE GUANAJUATO  = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2212.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2415:
                            /* IMPORTADORA SOES, S.A.   = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2428:
                            /* INTERNACIONAL DE CALZADO, SOCIEDAD ANONIMA    = NO HAY RESULTADOS 28/08/2019 */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1810.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 39:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 1755:
                            ;                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec1755.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_1755_39_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2361:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 1782:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 696:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 100:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2285:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2228:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2228.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2332:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2332.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 2343:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2343.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        case 1967:
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2212.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_xxx_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                        default :
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = $CERTIFICADO_CFD;
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec3.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            exit(0);
                            break;
                    }
                    break;
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
            $jc->setJasperurl('jrxml\facturacion\{$num_reporte}.jasper');
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

    public function getParesDevueltos() {
        try {

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHistorialFacturacion() {
        try {
            $xxx = $this->input->get();
            $this->db->select("F.ID AS ID, CONCAT(\"<span class='font-weight-bold'>\",F.factura,\"</span>\")  AS FACTURA, F.tp AS TP, F.cliente AS CLIENTE,
CONCAT(\"<span class='font-weight-bold'>\",F.contped,\"</span>\") AS CONTROL, F.estilo AS ESTILO, F.combin AS COLOR, F.corrida AS CORRIDA,
F.pareped AS PARES, F.precto AS PRECIO, F.subtot AS SUBTOTAL, F.iva AS IVA,
(IFNULL(F.subtot,0) + IFNULL(F.iva,0)) AS TOTAL, DATE_FORMAT(F.fecha,\"%d/%m/%Y\") AS FECHA", false)->from("facturacion AS F");

            if ($xxx['FACTURA'] !== '') {
                $this->db->where("F.factura", $xxx['FACTURA']);
            }
            if ($xxx['TP'] !== '') {
                $this->db->where("F.tp", $xxx['TP']);
            }
            if ($xxx['CLIENTE'] !== '') {
                $this->db->where("F.cliente", $xxx['CLIENTE']);
            }
            if ($xxx['CONTROL'] !== '') {
                $this->db->where("F.contped", $xxx['CONTROL']);
            }
            if ($xxx['FACTURA'] === '' && $xxx['TP'] === '' && $xxx['CLIENTE'] === '' && $xxx['CONTROL'] === '') {
                $this->db->limit(25);
            }
            $this->db->group_by("F.factura")->order_by("F.fecha", "DESC");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onControlSinTerminar() {
        try {

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
