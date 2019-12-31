<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class PagosConCincoDescuento extends CI_Controller {

    public function accion() {
        exec('schtasks /create /sc minute /tn "Timbrar" /tr "C:/Mis comprobantes/Timbrar.exe 8825 " ');
        exec('schtasks /run /tn "Timbrar"  ');
        exec('schtasks /delete /tn "Timbrar" /F ');
    }

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AplicaDepositosCliente_model', 'adc')->helper('jaspercommand_helper')->helper('file');
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

            $this->load->view('vFondo')->view('vPagosConCincoDescuento')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificarBanco() {
        try {
            $Tp = $this->input->get('Tp');
            $Banco = $this->input->get('Banco');
            print json_encode($this->db->query("select clave from bancos where clave = '$Banco' and Tp = $Tp and estatus = 'ACTIVO' ")->result());
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

    public function getRecords() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT
                                                cliente, remicion as docto, tipo,
                                                date_format(fecha,'%d/%m/%Y') as fecha, importe, pagos, importe-pagos as saldo,
                                                status, datediff(now(),fecha) as dias
                                                FROM cartcliente
                                                where cliente like '$cte'
                                                and tipo like '$tp'
                                                and status < 3
                                                and saldo > 1 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosByClienteFactTp() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            $fac = $this->input->get('Factura');
            print json_encode($this->db->query("select cliente,remicion as docto,tipo,
                                                date_format(fechadep,'%d/%m/%Y') as fechadep ,
                                                date_format(fechacap,'%d/%m/%Y') as fechacap ,
                                                importe,mov, doctopa
                                                from cartctepagos where cliente like '$cte' and remicion like '$fac' and tipo like '$tp' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioNC() {
        try {
            $tp = $this->input->get('Tp');
            if ($tp === '1') {
                print json_encode($this->db->query("select max(nc)+1 as nc from notcred where tp = $tp and nc < 10000 ")->result());
            } else {
                print json_encode($this->db->query("select max(nc)+1 as nc from notcred where tp = $tp  ")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaExisteNC() {
        try {
            $tp = $this->input->get('Tp');
            $nc = $this->input->get('NC');
            print json_encode($this->db->query("select nc from notcred where tp = $tp and nc = $nc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancos() {
        try {
            print json_encode($this->adc->getBancos($this->input->get('Tp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->adc->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentos() {
        try {
            $banco = $this->input->get('Banco');
            $tipo = $this->input->get('Tp');
            print json_encode($this->db->query("select docto, banco, cuenta, importe "
                                    . "from depoctes "
                                    . "where status < 3  and banco = $banco and tipo = $tipo "
                                    . " "
                                    . "order by docto asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepositobyDocto() {
        try {
            $doc = $this->input->get('Docto');
            print json_encode($this->db->query("select * , date_format(fecha,'%d/%m/%Y') as fechaF "
                                    . "from depoctes "
                                    . "where docto = $doc  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioFiscal() {
        try {
            $Factura = $this->input->get('Factura');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query("select uuid "
                                    . "from comprobantes "
                                    . "where Folio = $Factura and Tipo = 'I' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select Agente "
                                    . "from clientes "
                                    . "where clave = $Cliente  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCtaBancoCont() {
        try {
            $banco = $this->input->get('Banco');
            print json_encode($this->db->query("select "
                                    . "CtaCheques  "
                                    . "from bancos "
                                    . "where clave = $banco  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
            //Guardamos el pago del descuento solamente 5%

            $fechadep = str_replace('/', '-', $this->input->post('FechaDeposito'));
            $nuevaFechaDep = date("Y-m-d", strtotime($fechadep));
            $datosPagoDescuento = array(
                'cliente' => $this->input->post('Cliente'),
                'remicion' => $this->input->post('DocFac'),
                'fecha' => Date('Y-m-d'),
                'fechacap' => $nuevaFechaDep,
                'fechadep' => $nuevaFechaDep,
                'importe' => $this->input->post('DescuentoDocto'),
                'tipo' => $this->input->post('Tp'),
                'gcom' => 0,
                'mov' => 5,
                'doctopa' => 'Dc5%',
                'numpol' => 0,
                'agente' => $this->input->post('Agente'),
                'status' => 1,
                'control' => $banco,
                'nc' => $this->input->post('FolioNC'),
                'uuid' => ($this->input->post('Tp') === '1') ? $this->input->post('UUID') : 0
            );
            $this->db->insert('cartctepagos', $datosPagoDescuento);

            //Guardamos el pago del IVA desglosado del descuento si es Tp1
            if ($this->input->post('Tp') === '1') {
                $datosIVA = array(
                    'cliente' => $this->input->post('Cliente'),
                    'remicion' => $this->input->post('DocFac'),
                    'fecha' => Date('Y-m-d'),
                    'fechacap' => $nuevaFechaDep,
                    'fechadep' => $nuevaFechaDep,
                    'importe' => $this->input->post('IvaDocto'),
                    'tipo' => $this->input->post('Tp'),
                    'gcom' => 0,
                    'mov' => 5,
                    'doctopa' => "IVA  N-C " . $this->input->post('FolioNC'),
                    'numpol' => 0,
                    'agente' => $this->input->post('Agente'),
                    'status' => 1,
                    'control' => $banco,
                    'pagada' => 0,
                    'posfe' => 0,
                    'nc' => $this->input->post('FolioNC'),
                    'uuid' => ($this->input->post('Tp') === '1') ? $this->input->post('UUID') : 0
                );
                $this->db->insert('cartctepagos', $datosIVA);
            }

            //Guardamos el pago normal(sobrante despues de aplicar descuento) como pago normal
            $datosPagoNormal = array(
                'cliente' => $this->input->post('Cliente'),
                'remicion' => $this->input->post('DocFac'),
                'fecha' => Date('Y-m-d'),
                'fechacap' => $nuevaFechaDep,
                'fechadep' => $nuevaFechaDep,
                'importe' => $depositoAPagar,
                'tipo' => $this->input->post('Tp'),
                'gcom' => 0,
                'mov' => 1,
                'doctopa' => 'Bco. ' . $banco . ' Cuenta. ' . $this->input->post('CuentaDeposito') . ' Docto. ' . $docto,
                'numpol' => 0,
                'agente' => $this->input->post('Agente'),
                'status' => 1,
                'control' => $banco,
                'pagada' => 0,
                'posfe' => 0,
                'nc' => $this->input->post('FolioNC'),
                'uuid' => ($this->input->post('Tp') === '1') ? $this->input->post('UUID') : 0
            );
            $this->db->insert('cartctepagos', $datosPagoNormal);


            //Guardamos la nota de credito
            $fechaNC = str_replace('/', '-', $this->input->post('FechaCapturaNC'));
            $nuevaFechaNC = date("Y-m-d", strtotime($fechaNC));
            $datosNC = array(
                'nc' => $this->input->post('FolioNC'),
                'cliente' => $this->input->post('Cliente'),
                'numfac' => $this->input->post('DocFac'),
                'tp' => $this->input->post('Tp'),
                'orden' => 5,
                'fecha' => $nuevaFechaNC,
                'hora' => Date('H:i:s'),
                'cant' => 1,
                'descripcion' => 'Desc.5% Nc-' . $this->input->post('FolioNC'),
                'precio' => $this->input->post('DescuentoDocto'),
                'subtot' => $this->input->post('DescuentoDocto'),
                'monletra' => $this->input->post('ImporteLetra'),
                'concepto' => 0,
                'defecto' => 0,
                'detalle' => 0,
                'status' => ($this->input->post('Tp') === '1') ? 0 : 2
            );
            $this->db->insert('notcred', $datosNC);
//-------------------------------Timbrar.exe------------------------------------
            //Acualizamos la cartera de clientes
            $importeFac = floatval($this->input->post('MontoDocto'));
            $descuento = $this->input->post('DescuentoDocto');
            $iva = $this->input->post('IvaDocto');
            $pagosAcum = floatval($descuento) + $depositoAPagar + floatval($iva);
            $saldoAcum = $importeFac - $pagosAcum;
            $cliente = $this->input->post('Cliente');
            $doctoFac = $this->input->post('DocFac');
            $tp = $this->input->post('Tp');
            $cartcliente = "";
            if ($saldoAcum <= 0.9) {
                $cartcliente = "update cartcliente set pagos = $pagosAcum , saldo = 0 , status = 3 where cliente = $cliente and remicion = $doctoFac and tipo = $tp ";
            } else {
                $cartcliente = "update cartcliente set pagos = $pagosAcum , saldo = $saldoAcum , status = 2 where cliente = $cliente and remicion = $doctoFac and tipo = $tp ";
            }
            $this->db->query($cartcliente);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
