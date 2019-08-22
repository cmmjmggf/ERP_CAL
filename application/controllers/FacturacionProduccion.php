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
            print json_encode($this->db->query("SELECT C.ListaPrecios AS LP, C.Descuento AS DESCUENTO, C.Zona AS ZONA, C.Agente AS AGENTE FROM clientes AS C WHERE C.Clave = {$this->input->post('CLIENTE')}")->result());
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
                WHERE F.contped LIKE '{$this->input->get('CONTROL')}' LIMIT 1")->result());
//            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
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

    public function onCerrarDocto() {
        try {
            $x = $this->input->post();
            $TOTAL = $x['IMPORTE_TOTAL_SIN_IVA'];
            if (intval($x['MONEDA']) === 1) {
                $TOTAL = $x['IMPORTE_TOTAL_SIN_IVA'] * $x['TIPO_DE_CAMBIO'];
            }
            $cc = array(
                'C.cliente' => $x['CLIENTE'], 'C.remicion' => $x['FACTURA'],
                'C.fecha' => $x['FECHA'], 'C.importe' => $TOTAL,
                'C.tipo' => $x['TP_DOCTO'],
                'C.status' => 1, 'C.pagos' => 0,
                'C.saldo' => $TOTAL, 'C.comiesp' => 1,
                'C.tcamb' => $x['TIPO_DE_CAMBIO'], 'C.tmnda' => (intval($x["MONEDA"]) > 1 ? $x["MODENA"] : 1),
                'C.nc' => (($x['REFACTURACION'] === 1) ? 888 : 0),
                'C.factura' => ((intval($x['TP_DOCTO']) === 1) ? 0 : 1));

            $this->db->insert('cartcliente', $cc);
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
                'factura' => $x['FACTURA'],
                'tp' => $x['TP_DOCTO'],
                'cliente' => $x['CLIENTE'],
                'contped' => $x['CONTROL'],
                'fecha' => "$anio-$mes-$dia $hora",
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
            $f["origen"] = NULL;
            $f["referen"] = $x["REFERENCIA"];

            $f["decdias"] = NULL;
            $f["agente"] = $x["AGENTE"];
            $f["colsuel"] = $x["COLOR_TEXT"];
            $f["tpofac"] = 1;
            $f["año"] = date('Y');
            $f["zona"] = $x["ZONA"];
            $f["horas"] = date('h:i:s a');
            $f["numero"] = 1;
            $f["talla"] = 0;
            $f["cobarr"] = NULL;
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
            $saldopares = intval($x['PARES']) - ($x['PARES_FACTURADOS'] + intval($x['PARES_A_FACTURAR']));
            $facturaciondif = array(
                'pareped' => $saldopares/* PARES QUE FALTAN POR FACTURAR */,
                'staped' => (($saldopares == 0) ? 99 : 98)
            );
            if ($saldopares === 0) {
                $this->db->where('Control', $x['CONTROL'])->update('pedidox', array('stsavan' => 13));
            }
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
                            . "WHERE FD.contped LIKE '{$x['CONTROL']}'")->result();

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
            print json_encode(
                            $this->db->query("SELECT COUNT(F.factura) AS FACTURA_EXISTE "
                                    . "FROM facturacion AS F "
                                    . "WHERE F.factura LIKE '{$this->input->get('FACTURA')}'")->result());
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

    public function getVistaPrevia() {
        try {
            $x = $this->input->post();

            $rfc_cliente = $this->db->query("SELECT C.RFC AS RFC FROM clientes AS C WHERE C.Clave LIKE '{$x['CLIENTE']}' LIMIT 1")->result();

            $dtm = $this->db->query("SELECT F.Factura, F.numero, F.FechaFactura, F.CadenaOriginal,"
                            . "F.uuid, F.fechatimbrado, F.certificadosat, F.certificadocfd, F.sellosat, "
                            . "F.acuse, F.sellocfd FROM cfdifa AS F WHERE F.Factura LIKE '{$x['DOCUMENTO_FACTURA']}' ")->result();

            $total_factura = $this->db->query("SELECT round(((SUM(F.subtot)) * 1.16),2) AS TOTAL FROM facturacion AS F "
                            . "WHERE F.factura LIKE '{$x['DOCUMENTO_FACTURA']}' AND F.tp = {$x['TP']} LIMIT 1")->result();
            $cfdi = $dtm[0];
            $TOTAL_FOR = number_format($total_factura[0]->TOTAL, 6, ".", "");
            $UUID = $cfdi->uuid;
            $rfc_emi = $this->session->EMPRESA_RFC;
            $rfc_rec = $rfc_cliente[0]->RFC;
            
            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$UUID&re=$rfc_emi&rr=$rfc_rec&tt=$TOTAL_FOR&fe=TW9+rA==";

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $qr_url = QRcode::png($qr, 'rpt/qr.png');
            $pr = array();
            $pr["logo"] = base_url() . $this->session->LOGO;
            $pr["empresa"] = $this->session->EMPRESA_RAZON;
            $pr["callecolonia"] = $this->session->EMPRESA_DIRECCION;
            $pr["ciudadestadotel"] = "{$this->session->EMPRESA_CIUDAD}, {$this->session->EMPRESA_TELEFONO}";
            $pr["certificado"] = '00001000000201352796';
            $pr["factura"] = $x['DOCUMENTO_FACTURA'];
            $pr["qrCode"] = base_url('rpt/qr.png');
            $jc->setParametros($pr);
            $jc->setJasperurl('jrxml\facturacion\FacturacionVP.jasper');
            $jc->setFilename("{$x['DOCUMENTO_FACTURA']}_" . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getQR($str) {
        QRcode::png($str);
    }

}
