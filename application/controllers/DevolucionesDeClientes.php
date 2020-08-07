<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DevolucionesDeClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CLIENTES':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }
            $this->load->view('vDevolucionesDeClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getConsecutivo() {
        print json_encode($this->db->query("SELECT max(consecutivo)+1 as folio FROM erp_cal.devolucionnp; ")->result()[0]->folio);
    }

    public function getPedidosFacturados() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID, F.contped AS CONTROL, group_concat(F.factura) AS DOCUMENTO, F.tp AS TP, DATE_FORMAT(F.fecha,\"%d/%m/%Y\") AS FECHA, SUM(F.pareped) AS PARES, F.estilo AS ESTILO, F.combin AS COLOR, F.precto AS PRECIO, F.staped AS ST", false)
                    ->from("facturacion AS F")->where('F.contped <> 0 AND F.staped = 2', null, false);
            if ($x["CLIENTE"] === '') {
                $this->db->where("F.cliente", 0);
            } else {
                $this->db->where('F.cliente', $x["CLIENTE"]);
            }
            $this->db->group_by("F.contped");
            $this->db->order_by("F.fecha", "DESC");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarControlXCliente() {
        try {
            print json_encode($this->db->query("SELECT P.Cliente AS CLIENTE "
                                    . "FROM pedidox AS P WHERE P.Control = '{$this->input->get('CONTROL')}' LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.*,P.Clave AS CLAVE_PEDIDO, "
                                    . "CONCAT(S.PuntoInicial,\"/\",S.PuntoFinal) AS SERIET,"
                                    . "P.ColorT AS COLORT ,P.Estilo AS ESTILOT , P.Precio AS PRECIO, "
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, "
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, "
                                    . "S.T21, S.T22, P.EstatusProduccion AS ESTATUS, P.stsavan AS AVANCE_ESTATUS, "
                                    . "P.EstiloT AS ESTILO_TEXT,"
                                    . "SUM(F.par01) AS par01, sum(F.par02) AS par02, SUM(F.par03) AS par03, sum(F.par04) AS par04,"
                                    . "SUM(F.par05) AS par05, SUM(F.par06) AS par06, sum(F.par07) AS par07, "
                                    . "SUM(F.par08) AS par08, sum(F.par09) AS par09, SUM(F.par10) AS par10, "
                                    . "SUM(F.par11) AS par11, SUM(F.par12) AS par12, SUM(F.par13) AS par13, "
                                    . "SUM(F.par14) AS par14, SUM(F.par15) AS par15, SUM(F.par16) AS par16, "
                                    . "SUM(F.par17) AS par17, SUM(F.par18) AS par18, SUM(F.par19) AS par19, "
                                    . "SUM(F.par20) AS par20, SUM(F.par21) AS par21, SUM(F.par22) AS par22 "
                                    . "FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave "
                                    . "INNER JOIN facturacion AS F ON P.Control = F.contped "
                                    . "WHERE P.Control = '{$x['CONTROL']}' AND F.staped = 2 group by Control")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesFacturadosXControl() {
        try {
            print json_encode($this->db->query("SELECT F.factura, F.tp, F.cliente, F.contped, F.fecha, F.hora, F.corrida, F.pareped, F.estilo, F.combin, F.par01, F.par02, F.par03, F.par04, F.par05, F.par06, F.par07, F.par08, F.par09, F.par10, F.par11, F.par12, F.par13, F.par14, F.par15, F.par16, F.par17, F.par18, F.par19, F.par20, F.par21, F.par22, F.precto, F.subtot, F.iva, F.staped, F.monletra, F.tmnda, F.tcamb, F.cajas, F.origen, F.referen, F.decdias, F.agente, F.colsuel, F.tpofac, F.año, F.zona, F.horas, F.numero, F.talla, F.cobarr, F.pedime, F.ordcom, F.numadu, F.nomadu, F.regadu, F.periodo, F.costo, F.obs "
                                    . "FROM facturacion AS F WHERE F.contped = '{$this->input->get('CONTROL')}' AND F.staped = 2")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevoluciones() {
        try {
            $x = $this->input->get();
            $this->db->select("D.ID, D.cliente AS CLIENTE, D.docto AS DOCUMENTO, "
                            . "concat(D.control,\" \",D.consecutivo) AS CONTROL, D.paredev AS PARES, "
                            . "D.defecto AS DEFECTO, D.detalle AS DETALLE, "
                            . "D.clasif AS CLASIFICACION, D.cargoa AS CARGO, "
                            . "D.maq AS MAQUILA, DATE_FORMAT(D.fecha,\"%d/%m/%Y\") AS FECHA, D.tp AS TP, "
                            . "D.conce AS CONCEPTO, D.preciodev AS PRECIO_DEVOLUCION, "
                            . "D.preciomaq AS PRECIO_CG, D.consecutivo AS CONSECUTIVO", false)
                    ->from("devolucionnp AS D")
                    ->where_in('D.staapl', array(0, 1));
            if ($x['CONTROL'] !== '') {
                $this->db->where('D.control', $x['CONTROL']);
            }
            if ($x['FOLIO'] !== '') {
                $this->db->where('D.consecutivo', $x['FOLIO']);
            }
            if ($x["CLIENTE"] === '') {
                $this->db->where("D.cliente", 0);
            } else {
                $this->db->where('D.cliente', $x["CLIENTE"]);
            }
            $this->db->order_by("D.consecutivo", "DESC");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColorXControl() {
        try {
            print json_encode($this->db->query("SELECT (CASE WHEN p.ColorT IS NULL THEN \"SIN COLOR\" ELSE p.ColorT END) AS COLOR_T, E.Foto "
                                    . " FROM pedidox as p "
                                    . " LEFT JOIN Estilos E on E.Clave = P.Estilo "
                                    . " where p.Control = {$this->input->get('CONTROL')} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            $fecha = Date('Y-m-d 00:00:00');
            $p = array(
                "cliente" => $x["CLIENTE"],
                "docto" => $x["DOCUMENTO"],
                "aplica" => 0, "nc" => 0,
                "fact" => 0, "fact1" => 0,
                "fact2" => 0,
                "conce" => $x["MOTIVO"] . "-" . $x["CONTROL"] . "-" . $x["ESTILO"] . "-" . $x["COLOR"],
                "tp" => $x["TP"], "tpvta" => 0,
                "control" => $x["CONTROL"], "controlprd" => 0,
                "paredev" => $x["PARES_DEVUELTOS"], "parefac" => 0, "consecutivo" => $x["FOLIO"]);

            for ($index = 1; $index < 23; $index++) {
                if ($index < 10) {
                    $p["par0{$index}"] = $x["PAR0{$index}"];
                } else {
                    $p["par{$index}"] = $x["PAR{$index}"];
                }
            }
            $registro = $this->db->query("SELECT (D.registro +1) AS REGISTRITO FROM devolucionnp AS D ORDER BY D.registro DESC LIMIT 1")->result();
            $subtotal = 0;
            $subtotal = $x["PRECIO"] * $x["PARES_DEVUELTOS"];
            $pp = array_merge($p, array(
                "defecto" => $x["DEFECTO"], "detalle" => $x["DETALLE"],
                "clasif" => $x["CLASIFICACION"], "cargoa" => $x["CARGO_A"],
                "fecha" => $fecha, "fechadev" => $fecha,
                "estilo" => $x["ESTILO"], "comb" => $x["COLOR"],
                "seriped" => $x["SERIE"], "precio" => $x["PRECIO"],
                "subtot" => $subtotal,
                "registro" => (empty($registro) ? 1 : $registro[0]->REGISTRITO),
                "stafac" => 0, "staapl" => 0,
                "maq" => $x["MAQUILA"], "preciodev" => $x["PRECIO_DEVOLUCION"],
                "preciomaq" => $x["PRECIO_DEVOLUCION"] * 0.1, "obs1" => 0,
                "ctenvo" => $x["DEPARTAMENTO"],
                "usuario" => $this->session->ID,
                "usuario_nombre" => $this->session->USERNAME
            ));
            $this->db->insert('devolucionnp', $pp);
            $l = new Logs("DEVOLUCIONES PENDIENTES POR APLICAR", "HA CREADO UNA DEVOLUCION DEL CLIENTE {$x["CLIENTE"]} CON EL CONTROL {$x['CONTROL']} DE {$x["PARES_DEVUELTOS"]} PAR(ES) POR $ {$subtotal}.", $this->session);

//                SE CONSIDERA COMO PASO 1 PARA UNA DEVOLUCION
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirRepNormal() {
        try {
            $reports = array();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );
            /* 1. REPORTE AGRUPADO POR CLASIFICACIÓN */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\devolnapl.jasper');
            $jc->setFilename('DEV_X_CLASIFICACION_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports["1UNO"] = $jc->getReport();

            /* 2. REPORTE AGRUPADO POR MAQUILA */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\devolnaplm.jasper');
            $jc->setFilename('DEV_X_MAQUILA_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /* 3. REPORTE AGRUPADO CARGO UNO (cargoa = 1) */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\devolnaplp.jasper');
            $jc->setFilename('DEV_CON_CARGO_PARA_VTA_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();

            /* 4. REPORTE AGRUPADO CARGO CERO (cargoa = 0, Cargo a = NO) */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\devolnapl0.jasper');
            $jc->setFilename('DEV_SIN_CARGO_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['4CUATRO'] = $jc->getReport();

            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirRepNormalXLS() {
        try {
            $reports = array();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );

            /* 1. REPORTE AGRUPADO POR CLASIFICACIÓN */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\Excel\devolnapl.jasper');
            $jc->setFilename('DEV_X_CLASIFICACION_' . Date('dmYhis'));
            $jc->setDocumentformat('xls');
            $reports['1UNO'] = $jc->getReport();

//            /* 2. REPORTE AGRUPADO POR MAQUILA */
//            $jc->setParametros($P);
//            $jc->setJasperurl('jrxml\facturacion\devolnaplm.jasper');
//            $jc->setFilename('DEV_X_MAQUILA_' . Date('dmYhis'));
//            $jc->setDocumentformat('xls');
//            $reports['2DOS'] = $jc->getReport();
//            /* 3. REPORTE AGRUPADO CARGO UNO (cargoa = 1) */
//            $jc->setParametros($P);
//            $jc->setJasperurl('jrxml\facturacion\devolnaplp.jasper');
//            $jc->setFilename('DEV_CON_CARGO_PARA_VTA_' . Date('dmYhis'));
//            $jc->setDocumentformat('xls');
//            $reports['3TRES'] = $jc->getReport();
//            /* 4. REPORTE AGRUPADO CARGO CERO (cargoa = 0, Cargo a = NO) */
//            $jc->setParametros($P);
//            $jc->setJasperurl('jrxml\facturacion\devolnapl0.jasper');
//            $jc->setFilename('DEV_SIN_CARGO_' . Date('dmYhis'));
//            $jc->setDocumentformat('xls');
//            $reports['4CUATRO'] = $jc->getReport();

            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePorCliente() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );
            /* 1. REPORTE AGRUPADO POR CLIENTE */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\estadvcli.jasper');
            $jc->setFilename('DEV_X_CLIENTE_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePorMaquila() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );
            /* 1. REPORTE AGRUPADO POR MAQUILA */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\estadvmaqi.jasper');
            $jc->setFilename('DEV_X_MAQ_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePorDefectoDetalle() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );
            /* 1. REPORTE AGRUPADO POR MAQUILA */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\estadvded.jasper');
            $jc->setFilename('DEV_X_DEFECTODETALLE_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePorAgenteClienteDepartamentoDefectoDetalle() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array(
                "logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "FECHA_INICIAL" => $x["FECHA_INICIAL"],
                "FECHA_FINAL" => $x["FECHA_FINAL"],
            );
            /* 1. REPORTE AGRUPADO POR AGENTE, POR CLIENTE, POR DEPARTAMENTO, POR DEFECTO Y DETALLE */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\facturacion\estadvdedi.jasper');
            $jc->setFilename('DEV_X_AGTECTEDEPTODEFEDETA_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
