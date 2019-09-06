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
            "monletra" => (intval($x["TIPO_MONEDA"]) === 1 ? $x["MONEDA_LETRA_PESOS"]:$x["MONEDA_LETRA_DOLARES"]),
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

}
