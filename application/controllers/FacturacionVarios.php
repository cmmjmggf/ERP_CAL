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
            $CodigoBarras = "";
            $Descripcion = "";
            $FECHA_FACTURA = str_replace('/', '-', $this->input->post('FECHA'));
            $FECHIN = date("Y-m-d h:i:s", strtotime($FECHA_FACTURA));
            $FECHA_REGISTRO = $this->db->insert('facturacion', array(
                "factura" => $x["FACTURA"],
                "tp" => $x["TP"],
                "cliente" => $x["CLIENTE"],
                "contped" => 0,
                "fecha" => $FECHIN,
                "hora" => Date("d/m/Y"),
                "corrida" => $x["TALLA"],
                "pareped" => $x["CANTIDAD"],
                "estilo" => strtoupper(substr($x["ESTILO"] . " " . $x["CONCEPTO"], 0, 199)),
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
                "obs" => substr($x["OBS"], 0, 199)
            ));

            if (intval($x["TP"]) === 1) {
                switch ($x["CLIENTE"]) {
                    case 1810:
                        $Descripcion = $x["ESTILO"] . " " . $x["CONCEPTO"];
                        break;
                    case 2332:
                        $Tetiqcodbarr = $this->db->query("SELECT E.codbarr AS CODIGO_DE_BARRA "
                                        . "FROM etiqcodbarr AS E "
                                        . "WHERE E.cliente = {$x["CLIENTE"]} AND "
                                        . "E.estilo = {$x["ESTILO"]}")->result();
                        if (!empty($Tetiqcodbarr)) {
                            $CodigoBarras = $Tetiqcodbarr[0]->CODIGO_DE_BARRA;
                        }
                        break;
                    case 2432:
                        $Descripcion = $x["ESTILO"] . " " . $x["CONCEPTO"];
                        break;
                    case 2428:
                        $Descripcion = $x["ESTILO"] . " " . $x["CONCEPTO"];
                        break;
                    case 2343:
                        $Descripcion = $x["ESTILO"] . " " . $x["CONCEPTO"];
                        break;
                    case 2121:
                        $Tetiqcodbarr = $this->db->query("SELECT E.codbarr AS CODIGO_DE_BARRA "
                                        . "FROM etiqcodbarr AS E "
                                        . "WHERE E.cliente = {$x["CLIENTE"]} AND "
                                        . "E.estilo = {$x["ESTILO"]}")->result();
                        if (!empty($Tetiqcodbarr)) {
                            $CodigoBarras = $Tetiqcodbarr[0]->CODIGO_DE_BARRA;
                        }
                        $lxe = $this->db->query("SELECT E.Linea AS LINEA FROM estilos AS E WHERE E.Estilo = {$x["ESTILO"]}")->result();
                        if (!empty($lxe)) {
                            $Descripcion = $lxe[0]->LINEA . " " . $x["ESTILO"] . " " . $x["TALLA"];
                        }
                        break;
                    default :
                        $Descripcion = $x["ESTILO"] . " " . $x["CONCEPTO"];
                        break;
                }
                if (intval($x["TP"]) === 1) {
                    $this->db->insert('facturadetalle', array(
                        "numfac" => $x["FACTURA"], "numcte" => $x["CLIENTE"],
                        "tp" => $x["TP"], "claveproducto" => $x["PRODUCTO_SAT"],
                        "claveunidad" => "PR", "cantidad" => $x["CANTIDAD"],
                        "unidad" => "PAR", "codigo" => $x["ESTILO"],
                        "descripcion" => $Descripcion, "Precio" => $x["PRECIO"],
                        "importe" => ($x["CANTIDAD"] * $x["PRECIO"]),
                        "fecha" => $FECHIN, "control" => 0,
                        "iva" => ((intval($x["TP"]) === 1 && intval($x["NO_GENERA_IVA"]) === 0) ? ($x["SUBTOTAL"] * 0.16) : 0),
                        "tmnda" => intval($x["TIPO_MONEDA"]),
                        "tcamb" => $x["TIPO_CAMBIO"], "noidentificado" => $CodigoBarras,
                        "referencia" => $x["REFERENCIA"], "tienda" => 0
                    ));
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarDocumento() {
        try {
            $x = $this->input->post();
            $FECHA_FACTURA = str_replace('/', '-', $this->input->post('FECHA'));
            $FECHIN = date("Y-m-d", strtotime($FECHA_FACTURA));
            $importe_saldo_final = 0;
            $importe_saldo_final = (intval($x["TIPO_MONEDA"]) === 1) ? $x["IMPORTE"] : floatval($x["IMPORTE"]) * floatval($x["TIPO_CAMBIO"]);
            $facturacion = $this->db->query("SELECT F.pareped AS PARES, F.subtot AS SUBTOTAL, F.iva AS IVA FROM facturacion AS F WHERE F.factura = {$x["FACTURA"]} AND F.cliente = {$x["CLIENTE"]}")->result();
            $total_pares = 0;
            $total_facturado_iva = 0;
            $subtotal_facturado = 0;
            $total_facturado = 0;
            if (!empty($facturacion)) {
                foreach ($facturacion as $k => $v) {
//                    print "{$v->PARES}, {$v->SUBTOTAL}, {$v->IVA}\n";
                    $total_pares += intval($v->PARES);
                    $subtotal_facturado += floatval($v->SUBTOTAL);
                    $total_facturado_iva += floatval($v->IVA);
                    $total_facturado += floatval($v->SUBTOTAL) + floatval($v->IVA);
                }
//                print "PARES:  {$total_pares}; SUBTOTAL: {$subtotal_facturado}; IVA : {$total_facturado_iva}; TOTAL: {$total_facturado}";
            }
            $this->db->trans_begin();

            $this->db->insert('cartcliente', array(
                "cliente" => $x["CLIENTE"], "remicion" => $x["FACTURA"],
                "fecha" => $FECHIN, "importe" => $importe_saldo_final,
                "tipo" => $x["TIPO"], "numpol" => NULL,
                "numcia" => NULL, "status" => 1,
                "pagos" => 0, "saldo" => $importe_saldo_final,
                "comiesp" => NULL, "tcamb" => $x["TIPO_CAMBIO"],
                "tmnda" => (intval($x["TIPO_MONEDA"]) === 1) ? 1111 : $x["TIPO_MONEDA"],
                "stscont" => NULL, "nc" => (intval($x["TIMBRAR"]) === 1) ? 0 : 999,
                "factura" => (intval($x["TIPO"]) === 1) ? 0 : 1
            ));
            $this->db->where('factura', $x["FACTURA"])->where('cliente', $x["CLIENTE"])
                    ->update('facturacion', array("staped" => 2,
                        "hora" => Date('Y-m-d'),
                        "monletra" => (intval($x["TIPO_MONEDA"]) === 1 ? $x["MONEDA_LETRA_PESOS"] : $x["MONEDA_LETRA_DOLARES"]),
                        "horas" => Date('h:i:s')));

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
                                $this->db->query("SELECT COUNT(F.factura) AS FACTURA_EXISTE, F.cliente AS CLIENTE FROM facturacion AS F WHERE F.factura = '{$x['FACTURA']}' AND F.cliente = '{$x['CLIENTE']}' ORDER BY year(F.fecha) DESC")->result());
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

    public function getTipoDeCambio() {
        try {
            print json_encode($this->db->query('SELECT TDC.Dolar AS DOLAR, TDC.Euro AS EURO, TDC.Libra AS LIBRA, TDC.Jen AS JEN FROM tipocambio AS TDC')->result());
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

    public function getDetalleDocumento() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID, F.cliente AS CLIENTE, F.factura AS DOCTO, F.fecha AS FECHA, "
                            . "F.estilo AS CONCEPTO, F.tp AS TP, (F.subtot + F.iva) AS IMPORTE, F.pareped AS CANTIDAD, "
                            . "F.precto AS PRECIO, F.subtot AS SUBTOTAL, F.iva", false)
                    ->from("facturacion AS F");
            if ($x["CLIENTE"] !== '' && $x["FACTURA"] !== '') {
                $this->db->where('F.cliente', $x["CLIENTE"])->where('F.factura', $x["FACTURA"]);
            } else {
                $this->db->order_by('F.fecha', 'DESC')->limit(100);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosXCliente() {
        try {
            $x = $this->input->get();
            $this->db->select("CC.ID, CC.cliente AS CLIENTE, CC.remicion AS DOCTO, date_format(CC.fecha,\"%d/%m/%Y\") AS FECHA, CC.tipo AS TP, CC.importe AS IMPORTE,  CC.pagos AS PAGOS, (CC.importe - CC.pagos) AS SALDO ", false)
                    ->from("cartcliente as CC");
            if ($x["CLIENTE"] !== '') {
                $this->db->where('CC.cliente', $x["CLIENTE"]);
            } else {
                $this->db->order_by('CC.fecha', 'DESC')->limit(100);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVistaPrevia() {
        try {
            $x = $this->input->post();

            $rfc_cliente = $this->db->query("SELECT C.RFC AS RFC FROM clientes AS C "
                            . "WHERE C.Clave LIKE '{$x['CLIENTE']}' LIMIT 1")->result();

            $dtm = $this->db->query("SELECT F.Factura, F.numero, F.FechaFactura, F.CadenaOriginal,"
                            . "F.uuid, F.fechatimbrado, F.certificadosat, F.certificadocfd, F.sellosat, "
                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura LIKE '{$x['DOCUMENTO_FACTURA']}' ")
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
                $qr = "NO SE OBTUVIERON DATOS DEL CFDI, INTENTE NUEVAMENTE O MAS TARDE";
            }
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $qr_url = QRcode::png($qr, 'rpt/qr.png');
            $pr = array();
            switch (intval($x["TP"])) {
                case 1:
                    $pr["logo"] = base_url() . $this->session->LOGO;
                    $pr["empresa"] = $this->session->EMPRESA_RAZON;
                    BREAK;
            }
            switch (intval($x["TP"])) {
                case 1:
                    switch (intval($x['CLIENTE'])) {
                        case 2121:
                            /* COPPEL - OK */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MÉXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("facturaelec39{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 1755:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. = PRICE SHOES */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2361:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();

                            break;
                        case 1782:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 696:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();

                            break;
                        case 100:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec39.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2285:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
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
                            $pr["certificado"] = '00001000000201352796';
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2228.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2332:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadotel"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $jc->setParametros($pr);
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2332.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 2343:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $pr["callecolonia"] = "{$this->session->EMPRESA_DIRECCION} #{$this->session->EMPRESA_NOEXT}, COL.{$this->session->EMPRESA_COLONIA}";
                            $pr["ciudadestadopaiscp"] = utf8_decode("{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_ESTADO}, MEXICO, {$this->session->EMPRESA_CP}");
                            $pr["qrCode"] = base_url('rpt/qr.png');
                            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                            $pr["certificado"] = '00001000000201352796';
                            $pr["rfctel"] = "R.F.C. $rfc_rec, TEL. {$this->session->EMPRESA_TELEFONO}";
                            $pr["CLIENTE"] = $x['CLIENTE'];
                            $jc->setJasperurl('jrxml\facturacion\facturaelec2343.jasper');
                            $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        case 1967:
                            /* GRUPO EMPRESARIAL S.J., S.A. DE C.V. */
                            $jc->setParametros($pr);
                            $jc->setJasperurl("jrxml\facturacion\facturaelec2212.jasper");
                            $jc->setFilename("{$x['CLIENTE']}_xxx_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                        default :
                            $jc->setParametros($pr);
                            $jc->setJasperurl("jrxml\facturacion\facturaelec3.jasper");
                            $jc->setFilename("{$x['CLIENTE']}_xxx_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                            $jc->setDocumentformat('pdf');
                            PRINT $jc->getReport();
                            break;
                    }
                    break;
                case 2:
                    $pr["factura"] = $x['DOCUMENTO_FACTURA'];
                    $jc->setParametros($pr);
                    $jc->setJasperurl('jrxml\facturacion\remisionva1.jasper');
                    $jc->setFilename("{$x['CLIENTE']}_{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
                    $jc->setDocumentformat('pdf');
                    PRINT $jc->getReport();
                    break;
            }
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
    }

}
