<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CancelaDocumentosVenta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
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

            $this->load->view('vFondo')->view('vCancelaDocumentosVenta')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onCancelarDocto() {
        try {
            $Tipo = $this->input->post('Tipo');
            $Timbrada = $this->input->post('Timbrada');
            $Tp = $this->input->post('Tp');
            $NC = $this->input->post('NC');
            $Docto = $this->input->post('Doc');
            $Cliente = $this->input->post('Cliente');
            $Concepto = $this->input->post('Concepto');
            $UUID = '';
            if ($Tipo === '1') {//PRODUCCIÓN, SACA LO QUE HABIA EN FACTURACIÓN PARA REGRESARLO A TERMINADO Y QUE SE PUEDAN VOLVER A FACTURAR
                $Facturacion = $this->db->query("select * from facturacion where factura = $Docto and cliente = $Cliente and tp = $Tp ")->result();
                foreach ($Facturacion as $key => $v) {
                    $txtcontped = $v->contped;
                    $txtstatusf = $v->staped;

                    if ($txtstatusf === '3') {//Si la factura ya esta cancelada, sale del método
                        print 3;
                        exit();
                    }

                    //Si no esta cancelada, actualiza el estatus 3=(cancelada) a la factura
                    $this->db->query("update facturacion set staped = 3 where  factura = $Docto and cliente = $Cliente and tp = $Tp ");
                    //Buscamos las facturas para traer los pares restantes vigentes y compararlos con los del pedido para saber a que estatus mandarlo
                    $paresfact = $this->db->query("select sum(pareped) as paresfact from facturacion where staped = 2 and contped = $txtcontped ")->result()[0]->paresfact;

                    if ($Timbrada === '0') {//Traemos el UUID
                        if ($Tp === '1') {
                            $UUID = $this->db->query("SELECT uuid FROM comprobantes  WHERE Folio = $Docto and Tipo = 'I' ")->result()[0]->uuid;
                        }
                    }

                    if (intval($txtcontped) > 0) {
                        $Pedido = $this->db->query("select Pares from pedidox where control = $txtcontped ")->result();
                        if (!empty($Pedido)) {//Si existe en pedidos traemos los pares
                            $txtpareped = $Pedido[0]->Pares;

                            if (intval($paresfact) < intval($txtpareped)) {//Si los pares sobrantes son menores a los del pedido se va a terminado y actualiza los pares
                                $this->db->set('DeptoProduccion', 240)->set('ParesFacturados', $paresfact)
                                        ->set('EstatusProduccion', 'TERMINADO')->set('stsavan', 12)->set('Estatus', 'A')->where('Control', $txtcontped)->update("pedidox");
                                $this->db->set('DeptoProduccion', 12)->set('EstatusProduccion', 'TERMINADO')->where('Control', $txtcontped)->update("controles");
                            } else {//Si no, se va a facturado y actualiza los pares
                                $this->db->set('DeptoProduccion', 260)->set('ParesFacturados', $txtpareped)
                                        ->set('EstatusProduccion', 'FACTURADO')->set('stsavan', 13)->set('Estatus', 'F')->where('Control', $txtcontped)->update("pedidox");
                                $this->db->set('DeptoProduccion', 13)->set('EstatusProduccion', 'FACTURADO')->where('Control', $txtcontped)->update("controles");
                            }
                        }
                    }
                }
                //Actualiza CartCliente
                $CartCliente = $this->db->query("select * from cartcliente where remicion = $Docto and cliente = $Cliente and tipo = $Tp  ")->result();
                if (!empty($CartCliente)) {
                    $importe = $CartCliente[0]->importe;
                    //Cancelamos el documento den la cartera de clientes, estatus 4= cancelado
                    $this->db->query("update cartcliente set saldo = 0, status = 4, factura = 1 where remicion = $Docto and cliente = $Cliente and tipo = $Tp ");

                    //Agrega la nc para saldar el doc en CartClientePagos
                    $this->db->insert("cartctepagos", array(
                        'cliente' => $Cliente,
                        'remicion' => $Docto,
                        'fecha' => Date('Y-m-d'),
                        'fechacap' => Date('Y-m-d'),
                        'fechadep' => Date('Y-m-d'),
                        'importe' => $importe,
                        'tipo' => $Tp,
                        'mov' => 10,
                        'doctopa' => 'Nc' . $NC,
                        'numpol' => 0,
                        'numfol' => 0,
                        'agente' => 0,
                        'status' => 1,
                        'nc' => $NC,
                        'control' => 0,
                        'uuid' => ($Tp === '1') ? $UUID : 0
                    ));
                    //Agrega la nota de credito
                    $this->db->insert("canfacvta", array(
                        'cliente' => $Cliente,
                        'docto' => $Docto,
                        'fecha' => Date('Y-m-d'),
                        'tp' => $Tp,
                        'motivo' => $Concepto,
                        'Nc' => $NC
                    ));
                }
            }
            if ($Tipo === '2') {//Factura controles pero descontando las existencias de devoluciones, previamente capturadas en devolucionesnp
                $Facturacion = $this->db->query("select * from facturacion where factura = $Docto and cliente = $Cliente and tp = $Tp ")->result();
                foreach ($Facturacion as $key => $v) {
                    $txtcontped = $v->contped;
                    $txtstatusf = $v->staped;
                    $txtparesfact = $v->pareped;
                    $txtregistro = $v->tpofac;

                    if ($txtstatusf === '3') {//Si la factura ya esta cancelada, sale del método
                        print 3;
                        exit();
                    }

                    if ($Timbrada === '0') {//Traemos el UUID
                        if ($Tp === '1') {
                            $UUID = $this->db->query("SELECT uuid FROM comprobantes  WHERE Folio = $Docto and Tipo = 'I' ")->result()[0]->uuid;
                        }
                    }

                    if (intval($txtcontped) > 0) {
                        $Devol = $this->db->query("select paredev,parefac from devolucionnp where control = $txtcontped and registro = $txtregistro ")->result();
                        if (!empty($Devol)) {//Si existe en pedidos traemos los pares
                            $txtparedev = $Devol[0]->paredev;
                            $txtparefac = $Devol[0]->parefac;
                            $saldo = intval($txtparefac) - intval($txtparesfact);
                            if (intval($txtparedev) === intval($txtparesfact)) {//Si los pares sobrantes son menores a los del pedido se va a terminado y actualiza los pares
                                $this->db->query("update devolucionnp set stafac = 0, parefac = 0 where control = $txtcontped and registro = $txtregistro ");
                            }
                            if (intval($txtparedev) > intval($txtparefac)) {//Si no, se va a facturado y actualiza los pares
                                $this->db->query("update devolucionnp set stafac = 1, parefac = $saldo where control = $txtcontped and registro = $txtregistro ");
                            }
                        }
                        //Si no esta cancelada, actualiza el estatus 3=(cancelada) a la factura
                        $this->db->query("update facturacion set staped = 3 where  factura = $Docto and cliente = $Cliente and tp = $Tp ");
                    }
                }
                //Actualiza CartCliente
                $CartCliente = $this->db->query("select * from cartcliente where remicion = $Docto and cliente = $Cliente and tipo = $Tp  ")->result();
                if (!empty($CartCliente)) {
                    $importe = $CartCliente[0]->importe;
                    //Cancelamos el documento den la cartera de clientes, estatus 4= cancelado
                    $this->db->query("update cartcliente set saldo = 0, status = 4, factura= 1 where remicion = $Docto and cliente = $Cliente and tipo = $Tp ");

                    //Agrega la nc para saldar el doc en CartClientePagos
                    $this->db->insert("cartctepagos", array(
                        'cliente' => $Cliente,
                        'remicion' => $Docto,
                        'fecha' => Date('Y-m-d'),
                        'fechacap' => Date('Y-m-d'),
                        'fechadep' => Date('Y-m-d'),
                        'importe' => $importe,
                        'tipo' => $Tp,
                        'mov' => 10,
                        'doctopa' => 'Nc' . $NC,
                        'numpol' => 0,
                        'numfol' => 0,
                        'agente' => 0,
                        'status' => 1,
                        'nc' => $NC,
                        'control' => 0,
                        'uuid' => ($Tp === '1') ? $UUID : 0
                    ));
                    //Agrega la nota de credito
                    $this->db->insert("canfacvta", array(
                        'cliente' => $Cliente,
                        'docto' => $Docto,
                        'fecha' => Date('Y-m-d'),
                        'tp' => $Tp,
                        'motivo' => $Concepto,
                        'Nc' => $NC
                    ));
                }
            }
            if ($Tipo === '3') {//Varios
                $Facturacion = $this->db->query("select * from facturacion where factura = $Docto and cliente = $Cliente and tp = $Tp ")->result();
                foreach ($Facturacion as $key => $v) {
                    $txtstatusf = $v->staped;
                    if ($txtstatusf === '3') {//Si la factura ya esta cancelada, sale del método
                        print 3;
                        exit();
                    }
                }

                //Si no esta cancelada, actualiza el estatus 3=(cancelada) a la factura
                $this->db->query("update facturacion set staped = 3 where  factura = $Docto and cliente = $Cliente and tp = $Tp ");
                //Actualiza CartCliente
                $CartCliente = $this->db->query("select * from cartcliente where remicion = $Docto and cliente = $Cliente and tipo = $Tp  ")->result();
                if (!empty($CartCliente)) {
                    $importe = $CartCliente[0]->importe;
                    //Cancelamos el documento den la cartera de clientes, estatus 4= cancelado
                    $this->db->query("update cartcliente set saldo = 0, status = 4, factura=1 where remicion = $Docto and cliente = $Cliente and tipo = $Tp ");

                    //Agrega la nc para saldar el doc en CartClientePagos
                    $this->db->insert("cartctepagos", array(
                        'cliente' => $Cliente,
                        'remicion' => $Docto,
                        'fecha' => Date('Y-m-d'),
                        'fechacap' => Date('Y-m-d'),
                        'fechadep' => Date('Y-m-d'),
                        'importe' => $importe,
                        'tipo' => $Tp,
                        'mov' => 10,
                        'doctopa' => 'Nc' . $NC,
                        'numpol' => 0,
                        'numfol' => 0,
                        'agente' => 0,
                        'status' => 1,
                        'nc' => $NC,
                        'control' => 0,
                        'uuid' => ($Tp === '1') ? $UUID : 0
                    ));
                    //Agrega la nota de credito
                    if ($Timbrada === '0') {
                        $this->db->insert("canfacvta", array(
                            'cliente' => $Cliente,
                            'docto' => $Docto,
                            'fecha' => Date('Y-m-d'),
                            'tp' => $Tp,
                            'motivo' => $Concepto,
                            'Nc' => $NC
                        ));
                    }
                }
            }
            //Después de cancelar la factura, afectar pedidos o devolucioes y el documento en cartera, datos del pago
            //Se crea la nota de crédito que va a respaldar la cancelacion del documento ante el sat
            if (intval($NC) > 0) {
                $Facturacion = $this->db->query("select * from facturacion where factura = $Docto and cliente = $Cliente and tp = $Tp ")->result();
                foreach ($Facturacion as $key => $v) {
                    $pares = $v->pareped;
                    $contped = $v->contped;
                    $precto = $v->precto;
                    $subtot = $v->subtot;
                    $estilo = $v->estilo;
                    $combin = $v->combin;
                    $monletra = $v->monletra;
                    //Agrega la nc que va a respaldar la cancelacion del documento ante el sat
                    if ($Timbrada === '0') {
                        $this->db->insert("notcred", array(
                            'nc' => $NC,
                            'cliente' => $Cliente,
                            'numfac' => $Docto,
                            'tp' => $Tp,
                            'orden' => 10,
                            'fecha' => Date('Y-m-d'),
                            'hora' => Date('h:i:s A'),
                            'cant' => $pares,
                            'descripcion' => $contped . "-" . $estilo . "-" . $combin,
                            'precio' => $precto,
                            'subtot' => $subtot,
                            'concepto' => $Concepto,
                            'monletra' => $monletra,
                            'defecto' => 0,
                            'detalle' => 0,
                            'status' => ($Tp === '1') ? 0 : 2,
                            'uuid' => ($Tp === '1') ? $UUID : 0
                        ));
                    }
                }

                if ($Tp === '1') {
                    if ($Timbrada === '0') {//Se ejecuta la cancelación en el SAT de la factura
                        //Verificamos que la factura esté realizada en el sistema
                        $CfdiFa = $this->db->query("SELECT uuid FROM comprobantes  WHERE Folio = $Docto and Tipo = 'I' ")->result();

                        if (empty($CfdiFa)) {
                            //Existe error en la generacion de la factura electronica
                            //no se encuentra el uuid o no se realizó en el sistema
                            print 5;
                            exit();
                        } else {
                            $UUID = $CfdiFa[0]->uuid;
                            //Se ejecuta el programa de cancelación en el SAT
                            exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe ' . $Docto . ',I,S"');
                            exec('schtasks /run /tn "Timbrar"  ');
                            exec('schtasks /delete /tn "Timbrar" /F ');
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExistenPagos() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Cliente = $this->input->get('Cliente');
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT ifnull(sum(importe),0) as pagos FROM cartctepagos WHERE cliente = $Cliente and remicion = $Remicion and tipo = $Tp ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioNC() {
        try {
            print json_encode($this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc > 0  and tp = 2  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioNCFiscal() {
        try {
            print json_encode($this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc < 10000  and tp = 1  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Cliente = $this->input->get('Cliente');

            print json_encode($this->db->query("select tipo, importe, status, remicion, month(fecha) as mes, month(now()) as mesact "
                                    . " from cartcliente "
                                    . " where cliente = '$Cliente' and remicion = '$Remicion' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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

    public function getDocumentosByCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("Select remicion ,concat(remicion, '-', date_format(fecha,'%d/%m/%Y'),'-$',format(importe,2),'-',tipo) as documento
                                                FROM cartcliente WHERE cliente= $Cliente and status< 3  ORDER BY fecha,remicion ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
