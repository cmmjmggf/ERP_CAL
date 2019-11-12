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
                case 'CLIENTES':
                    $this->load->view('vNavGeneral');
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
                    ->from("facturacion AS F")->where('F.contped <> 0', null, false);
            if ($x["CLIENTE"] !== '') {
                $this->db->where('F.cliente', $x["CLIENTE"])->order_by("F.fecha", "DESC");
            }
            if ($x["CLIENTE"] === '') {
                $this->db->order_by("F.fecha", "DESC")->limit(15);
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
                $this->db->order_by("D.ID", "DESC")->order_by("D.fecha", "DESC")->limit(15);
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
            $x = $this->input->post();
            $fecha = Date('Y-m-d h:i:s');
            $p = array(
                "cliente" => $x["CLIENTE"],
                "docto" => $x["DOCUMENTO"],
                "aplica" => 0, "nc" => 0,
                "fact" => 0, "fact1" => 0,
                "fact2" => 0,
                "conce" => $x["MOTIVO"] . "-" . $x["CONTROL"] . "-" . $x["ESTILO"] . "-" . $x["COLOR"],
                "tp" => $x["TP"], "tpvta" => 0,
                "control" => $x["CONTROL"], "controlprd" => 0,
                "paredev" => $x["PARES_DEVUELTOS"], "parefac" => $x["PARES_FACTURADOS"]);

            for ($index = 1; $index < 23; $index++) {
                if ($index < 10) {
                    $p["par0{$index}"] = $x["PAR0{$index}"];
                } else {
                    $p["par{$index}"] = $x["PAR{$index}"];
                }
            }
            $registro = $this->db->query("SELECT (D.registro +1) AS REGISTRITO FROM devolucionnp AS D ORDER BY D.registro DESC LIMIT 1")->result();
            $pp = array_merge($p, array(
                "defecto" => $x["DEFECTO"], "detalle" => $x["DETALLE"],
                "clasif" => $x["CLASIFICACION"], "cargoa" => $x["CARGO_A"],
                "fecha" => $fecha, "fechadev" => $fecha,
                "estilo" => $x["ESTILO"], "comb" => $x["COLOR"],
                "seriped" => $x["SERIE"], "precio" => $x["PRECIO"],
                "subtot" => $x["PRECIO"] * $x["PARES_DEVUELTOS"],
                "registro" => (empty($registro) ? 1 : $registro[0]->REGISTRITO),
                "stafac" => 0, "staapl" => 0,
                "maq" => $x["MAQUILA"], "preciodev" => $x["PRECIO_DEVOLUCION"],
                "preciomaq" => $x["PRECIO_DEVOLUCION"] * 0.1, "obs1" => 0,
                "ctenvo" => $x["DEPARTAMENTO"]
            ));
            $this->db->insert('devolucionnp', $pp);
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
