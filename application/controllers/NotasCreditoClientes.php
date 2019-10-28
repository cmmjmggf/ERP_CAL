<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class NotasCreditoClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AplicaDepositosCliente_model', 'adc')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vNotasCreditoClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onAgregar() {
        try {
            //Cambiamos el estatus del deposito
            $depositoAPagar = floatval($this->input->post('ImporteAPagar'));
            $saldoDeposito = floatval($this->input->post('SaldoDeposito'));
            $estatusDeposito = ($saldoDeposito === $depositoAPagar) ? 3 : 2;
            $banco = $this->input->post('Banco');
            $docto = $this->input->post('Documento');
            $sql = "update depoctes set status = $estatusDeposito , pagos = ifnull(pagos,0) + $depositoAPagar where banco = $banco and docto = $docto  ";
            $this->db->query($sql);
            //Guardamos el pago en cartclientepagos

            $fecha = str_replace('/', '-', $this->input->post('FechaDeposito'));
            $nuevaFecha = date("Y-m-d", strtotime($fecha));
            $datos = array(
                'cliente' => $this->input->post('Cliente'),
                'remicion' => $this->input->post('DocFac'),
                'fecha' => Date('Y-m-d'),
                'fechacap' => $nuevaFecha,
                'fechadep' => $nuevaFecha,
                'importe' => $depositoAPagar,
                'tipo' => $this->input->post('Tp'),
                'gcom' => 0,
                'mov' => 1,
                'doctopa' => 'Bco. ' . $banco . ' Cuenta. ' . $this->input->post('CuentaDeposito') . ' Docto. ' . $docto,
                'numpol' => 0,
                'agente' => $this->input->post('Agente'),
                'status' => 1,
                'control' => $banco,
                'regdev' => $docto,
                'uuid' => ($this->input->post('Tp') === '1') ? $this->input->post('UUID') : 0
            );

            $this->db->insert('cartctepagos', $datos);
            //Acualizamos la cartera de clientes
            $importeFac = $this->input->post('ImporteDocto');
            $pagosFac = $this->input->post('PagosDocto');
            $saldoFac = $this->input->post('SaldoDocto');
            $pagosAcum = floatval($pagosFac) + $depositoAPagar;
            $saldoAcum = floatval($importeFac) - floatval($pagosAcum);
            $estatus = ($pagosAcum >= $importeFac) ? 3 : 2;
            $cliente = $this->input->post('Cliente');
            $doctoFac = $this->input->post('DocFac');
            $tp = $this->input->post('Tp');

            $cartcliente = "update cartcliente set pagos = $pagosAcum , saldo = $saldoAcum , status = $estatus where cliente = $cliente and remicion = $doctoFac and tipo = $tp ";
            $this->db->query($cartcliente);
            $actualizaDepos = "update depoctes set status = 3 where (((importe-pagos) = 0) or ((importe-pagos) < 2)) and status < 3 ";
            $this->db->query($actualizaDepos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
