<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class NotasCreditoClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('Notacreditoclientes_helper')->helper('file')->helper('nc_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vNotasCreditoClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onCerrarNC() {
        try {
            $x = $this->input->post();
            $status = ($x['Tp'] === '1') ? 0 : 1;
            $notcred = $this->db->query("SELECT * FROM notcred  WHERE nc = {$x['nc']} and status = $status and tp = {$x['Tp']} and cliente = {$x['Cliente']} ")->result();

            $fechacap = str_replace('/', '-', $x['fechacap']);
            $nuevafechacap = date("Y-m-d", strtotime($fechacap));
            //Verificamos en los renglones de la nota de crédito
            foreach ($notcred as $key => $v) {
                $txtnc = $v->nc;
                $txtcliente = $v->cliente;
                $txtnumfac = $v->numfac;
                $txttp = $v->tp;
                $txtfecha = $v->fecha;
                $txtdesc = $v->descripcion;
                $txtsubtot = $v->subtot;
                $txtorden = $v->orden;
                $txtuuid = $v->uuid;
                $txttmnda = $v->tmnda;
                //Registramos el pago correspondiente
                $datospago = array(
                    'cliente' => $txtcliente,
                    'remicion' => $txtnumfac,
                    'tipo' => $txttp,
                    'mov' => ($txtorden !== '') ? $txtorden : 9,
                    'fecha' => $txtfecha,
                    'fechadep' => $txtfecha,
                    'fechacap' => $nuevafechacap,
                    'doctopa' => $txtdesc,
                    'importe' => $txtsubtot,
                    'agente' => $x['agente'],
                    'status' => 1,
                    'nc' => $txtnc,
                    'control' => 0,
                    'uuid' => ($txttp === '1') ? $txtuuid : 0
                );
                $this->db->insert("cartctepagos", $datospago);
            }

            //Capturamos el pago de IVA del total de la nota de crédito desglosado
            $txtiva = 0;
            if ($x['Tp'] === '1') {
                if (intval($txttmnda) > 1) {
                    $txtiva = 0;
                } else {
                    $txtiva = floatval($x['total']) * 0.16;
                    //Registramos el iva del pago correspondiente
                    $datospagoIVA = array(
                        'cliente' => $txtcliente,
                        'remicion' => $txtnumfac,
                        'tipo' => $txttp,
                        'mov' => $txtorden,
                        'fecha' => $txtfecha,
                        'fechadep' => $txtfecha,
                        'fechacap' => $nuevafechacap,
                        'doctopa' => 'IVA N-C ' . $txtnc,
                        'importe' => $txtiva,
                        'agente' => $x['agente'],
                        'status' => 3,
                        'nc' => $txtnc,
                        'control' => 0,
                        'uuid' => ($txttp === '1') ? $txtuuid : 0
                    );
                    $this->db->insert("cartctepagos", $datospagoIVA);
                }
            }

            //Actualiza statua a nota de crédito
            $statusnc = ($x['Tp'] === '1') ? 0 : 2;
            $sql = "update notcred set status = {$statusnc} , monletra = '{$x['totalletra']}' "
                    . " WHERE nc = {$x['nc']} and tp = {$x['Tp']} and cliente = {$x['Cliente']} ";
            $this->db->query($sql);
            //Actualizamos el saldo de la cartera de clientes
            $cartcliente = $this->db->query("SELECT * FROM cartcliente  WHERE remicion = {$txtnumfac} and tipo = {$txttp} and cliente = {$txtcliente} ")->result();
            $txtsaldo = $cartcliente[0]->saldo;
            $txtpagos = $cartcliente[0]->pagos;
            $id = $cartcliente[0]->ID;
            if ($txttp === '1') {
                if (intval($txttmnda) > 1) {
                    $txtsaldo = floatval($txtsaldo) - floatval($x['total']);
                    $txtpagos = floatval($txtpagos) + floatval($x['total']);
                } else {
                    $txtsaldo = floatval($txtsaldo) - floatval($x['total']) - floatval($txtiva);
                    $txtpagos = floatval($txtpagos) + floatval($x['total']) + floatval($txtiva);
                }
            } else {
                $txtsaldo = floatval($txtsaldo) - floatval($x['total']);
                $txtpagos = floatval($txtpagos) + floatval($x['total']);
            }

            //Actualizamos la cartera con el nuevo saldo y los pagos correspondientes
            $stscartcliente = 0;
            if (floatval($txtsaldo) <= 0.1) {
                $txtsaldo = 0;
                $stscartcliente = 3;
            } else if (floatval($txtsaldo) > 0) {
                $stscartcliente = 2;
            }


            $datosCartCliente = array(
                'saldo' => $txtsaldo,
                'pagos' => $txtpagos,
                'status' => $stscartcliente
            );
            $this->db->where('ID', $id);
            $this->db->update('cartcliente', $datosCartCliente);
            //Actualiza los días de diferencia de la fecha pago en relacion a la fecha de factura
            $sql2 = " update cartctepagos cp
                        join cartcliente cc on cc.cliente = cp.cliente and cc.remicion = cp.remicion and cc.tipo = cp.tipo
                        set cp.numfol = datediff(cp.fecha, cc.fecha)
                        where cp.numfol = 0 ";
            $this->db->query($sql2);
            //  ********** Timbra e imprime
            if ($x['Tp'] === '1') {
//                /*                 * ********************** Timbrar.exe ***************** */
//                exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe ' . $x['nc'] . '" ');
//                exec('schtasks /run /tn "Timbrar"  ');
//                exec('schtasks /delete /tn "Timbrar" /F ');
//                $nc1 = new NotaDeCredito($x['Tp'], $x['nc'], $x['Cliente']);
            } else {
                $nc2 = new NotaDeCredito($x['Tp'], $x['nc'], $x['Cliente']);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $Folio = 0;
            $x = $this->input->post();
            $nuevo = $x['nuevo'];

            if ($nuevo === '1') {//Si es nuevo trae el nuevo folio
                if ($x['tp'] === '1') {
                    $Folio = $this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc < 20000  and tp = 1 ; ")->result()[0]->nc;
                } else {
                    $Folio = $this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc > 0  and tp = 2 ; ")->result()[0]->nc;
                }
            } else {//Si no usa el folio actual en uso
                $Folio = $x['folioact'];
            }


            $fecha = str_replace('/', '-', $x['fecha']);
            $nuevafecha = date("Y-m-d", strtotime($fecha));

            $datos = array(
                'nc' => $Folio,
                'tp' => $x['tp'],
                'cliente' => $x['cliente'],
                'numfac' => $x['numfac'],
                'orden' => $x['orden'],
                'fecha' => $nuevafecha,
                'hora' => Date('h:i:s A'),
                'cant' => ($x['cantidad'] !== '') ? $x['cantidad'] : 1,
                'descripcion' => $x['descripcion'] . $Folio,
                'precio' => $x['precio'],
                'subtot' => $x['subtot'],
                'concepto' => 0,
                'defecto' => $x['defecto'],
                'detalle' => $x['detalle'],
                'status' => ($x['tp'] === '1') ? 0 : 1,
                'tmnda' => ($x['tmnda'] === '0') ? 0 : $x['tmnda'],
                'tcamb' => ($x['tmnda'] === '0') ? 0 : $x['tcamb'],
                'tp' => $x['tp'],
                'uuid' => ($x['tp'] === '1') ? $x['uuid'] : 0
            );
            $this->db->insert("notcred", $datos);
            print $Folio;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUUID() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT uuid FROM comprobantes  WHERE Folio = $Remicion and Tipo = 'I'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarDocumento() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Cliente = $this->input->get('Cliente');
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("select importe, pagos, saldo, status, date_format(fecha,'%d/%m/%Y') as fecha "
                                    . " from cartcliente "
                                    . " where cliente = '$Cliente' and remicion = '$Remicion' and tipo = $Tp ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select * from clientes where clave = '$Cliente' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleNC() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            $doc = $this->input->get('NC');
            print json_encode($this->db->query("select nc, cliente, numfac, orden, date_format(fecha,'%d/%m/%Y') as fecha, descripcion, precio, subtot
                                                from notcred where cliente = $cte and tp = $tp and nc = $doc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $cte = $this->input->get('Cliente');
            print json_encode($this->db->query("SELECT
                                                cliente, remicion as docto, tipo,
                                                date_format(fecha,'%d/%m/%Y') as fecha, importe, pagos, importe-pagos as saldo,
                                                status, datediff(now(),fecha) as dias
                                                FROM cartcliente
                                                where cliente = '$cte'
                                                and status < 3
                                                and saldo > 5 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotasByTpByCliente() {
        try {
            $cte = $this->input->get('Cliente');
            $tipo = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT nc FROM notcred "
                                    . " where cliente = $cte and tp = $tipo group by nc order by nc desc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ReimprimirNC() {
        $x = $this->input->post();
        $nc = new NotaDeCredito($x['Tp'], $x['Folio'], $x['Cliente']);
    }

    public function getQR() {
        QRcode::png($_GET['code']);
    }

}
