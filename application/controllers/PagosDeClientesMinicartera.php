<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";
defined('BASEPATH') OR exit('No direct script access allowed');

class PagosDeClientesMinicartera extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vPagosDeClientesMinicartera')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select clave from clientes where clave = '$Cliente' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosXDocumentos() {
        try {
            $x = $this->input->get();
            $this->db->select("CCP.ID AS ID, CCP.cliente AS CLIENTE, CCP.remicion AS DOCUMENTO,
                CCP.tipo AS TP, DATE_FORMAT(CCP.fechadep,\"%d/%m/%Y\") AS FECHA_DEPOSITO,
                 DATE_FORMAT(CCP.fechacap,\"%d/%m/%Y\") AS FECHA_CAPTURA,
                FORMAT(CCP.importe,2) AS IMPORTE, CCP.mov AS MV, CCP.doctopa AS REFERENCIA,
                CCP.numfol AS DIAS ", false)->from("cartctepagos AS CCP");
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CCP.remicion', $x['DOCUMENTO']);
            }
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CCP.cliente', $x['CLIENTE']);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CCP.remicion', 0);
                $this->db->where('CCP.cliente', 0);
            } else {
                $this->db->order_by("CCP.fecha", "DESC");
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosConSaldoXClientes() {
        try {
            $x = $this->input->get();
            $this->db->select("CC.ID AS ID, CC.cliente AS CLIENTE, CC.remicion AS DOCUMENTO,
                CC.tipo AS TP, DATE_FORMAT(CC.fecha,\"%d/%m/%Y\") AS FECHA_DEPOSITO,
                FORMAT(CC.importe,2) AS IMPORTE, FORMAT(CC.pagos,2) AS PAGOS, FORMAT(CC.saldo,2) AS SALDO,
                CC.status AS ST, DATEDIFF(NOW(),fecha) AS DIAS, CC.saldo AS SALDOX", false)
                    ->from("cartcliente AS CC");
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CC.cliente', $x['CLIENTE'])->where('CC.saldo > ', 2);
            }
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CC.remicion', $x['DOCUMENTO'])->where('CC.saldo > ', 2);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CCP.remicion', 0);
                $this->db->where('CCP.cliente', 0);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Minicartera */

    public function getPagosXDocumentosMini() {
        try {
            $x = $this->input->get();
            $this->db->select("
                CCP.ID AS ID,
                CCP.cliente AS CLIENTE,
                CCP.remicion AS DOCUMENTO,
                CCP.tipo AS TP,
                DATE_FORMAT(CCP.fechadep,\"%d/%m/%Y\") AS FECHA_DEPOSITO,
                DATE_FORMAT(CCP.fecha,\"%d/%m/%Y\") AS FECHA_CAPTURA,
                FORMAT(CCP.importe,2) AS IMPORTE,
                CCP.mov AS MV,
                CCP.doctopa AS REFERENCIA ", false)
                    ->from("cartctepagosm AS CCP");
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CCP.remicion', $x['DOCUMENTO']);
            }
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CCP.cliente', $x['CLIENTE']);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CCP.remicion', 0);
                $this->db->where('CCP.cliente', 0);
            } else {
                $this->db->order_by("CCP.fecha", "DESC");
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosConSaldoXClientesMini() {
        try {
            $x = $this->input->get();
            $this->db->select(" CC.ID AS ID,
                CC.cliente AS CLIENTE,
                CC.remicion AS DOCUMENTO,
                CC.tipo AS TP,
                FORMAT(CC.importemov,2) AS IMPORTE,
                FORMAT(CC.pagos,2) AS PAGOS,
                FORMAT(CC.saldo,2) AS SALDO,
                CC.status AS ST,
                CC.saldo AS SALDOX ", false)
                    ->from("cartclientem AS CC");
            $this->db->where('CC.status < 3 ');
            if ($x['CLIENTE'] !== '') {
                $this->db->where('CC.cliente', $x['CLIENTE']);
            }
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CC.remicion', $x['DOCUMENTO']);
            }
            if ($x['CLIENTE'] === '' && $x['DOCUMENTO'] === '') {
                $this->db->where('CC.cliente', 0);
                $this->db->where('CC.remicion', 0);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosDelDocumentoConSaldo() {
        try {

            $x = $this->input->get();
            $documento = $this->db->query("SELECT "
                            . "CC.cliente AS CLIENTE, "
                            . "date_format(CC.fechamov,'%d/%m/%Y') AS FECHA, "
                            . "CC.importefac AS IMPORTE_FACTURA, "
                            . "CC.importemov AS IMPORTE, "
                            . "CC.pagos AS PAGOS, "
                            . "CC.saldo AS SALDO,"
                            . "CC.tipo AS TIPO "
                            . " "
                            . " FROM cartclientem AS CC WHERE CC.remicion = '{$x['DOCUMENTO']}' and CC.Cliente = '{$x['CLIENTE']}'  ")->result();
            print json_encode($documento);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagoCliente() {
        try {
            $x = $this->input->post();
            $FECHA_FINAL = date("Y-m-d", strtotime(str_replace('/', '-', $x['FECHA'])));
            $ImporteMov = round($x['IMPORTE'], 2);
            //Actualiza saldo y status en cartcliente
            $sql = "UPDATE cartclientem  "
                    . "SET saldo =  ifnull(saldo,0) - {$ImporteMov}, pagos = ifnull(pagos,0) + {$ImporteMov} "
                    . "WHERE tipo = '{$x['TP']}' "
                    . "AND remicion = '{$x['NUMERO_RF']}' "
                    . "AND cliente = '{$x['CLIENTE']}' ";
            $this->db->query($sql);
            $sql_upd = "UPDATE cartclientem
                                   SET status = CASE WHEN saldo <= 1 THEN 3 ELSE 2 END,
                                   saldo = CASE WHEN saldo <= 1 THEN 0 ELSE saldo END
                                   WHERE tipo = '{$x['TP']}'
                                   AND remicion = '{$x['NUMERO_RF']}'
                                   AND cliente = '{$x['CLIENTE']}'  ";
            $this->db->query($sql_upd);


            $this->db->insert("cartctepagosm", array(
                "cliente" => $x['CLIENTE'],
                "remicion" => $x['NUMERO_RF']/* REMISION */,
                "fecha" => Date('Y-m-d'),
                "importe" => $ImporteMov,
                "tipo" => $x['TP'],
                "gcom" => 0,
                "agente" => 0,
                "mov" => $x['MOVIMIENTO']/* MovUno, MovDos... */,
                "doctopa" => $x['REF'],
                "numpol" => 0,
                "status" => 1,
                "regdev" => 0,
                "uuid" => 0,
                "fechadep" => $FECHA_FINAL,
                "nc" => 0,
                "control" => 0,
                "stscont" => 0,
                "pagada" => 0
            ));

            //Si check de regresa esta encendido
            if ($x['REGRESA_SALDO'] === '1') {
                $this->db->query("update cartcliente set pagos = (ifnull(pagos,0)- $ImporteMov) , saldo = $ImporteMov, status = 2 where cliente = {$x['CLIENTE']} and remicion = {$x['NUMERO_RF']}; ");
                $this->db->query("update cartctepagos set importe = 0 where cliente = {$x['CLIENTE']} and mov = 5 and remicion = {$x['NUMERO_RF']} and round(importe,2) = $ImporteMov; ");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteMinicartera() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\minicartera\reporteMinicartera.jasper');
        $jc->setFilename('MINICARTERA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
