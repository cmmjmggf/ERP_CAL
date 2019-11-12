<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class DevolucionesYDescuentosPendientesXRecibir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
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
            $this->load->view('vFondo')->view('vDevolucionesYDescuentosPendientesXRecibir')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
            $fecha = str_replace('/', '-', $x['fecha']);
            $nuevafecha = date("Y-m-d", strtotime($fecha));
            $datos = array(
                'cliente' => $x['cliente'],
                'docto' => $x['docto'],
                'fecha' => $nuevafecha,
                'importe' => $x['importe'],
                'tp' => $x['tp'],
                'agente' => $x['agente'],
                'mov' => $x['mov'],
                'doctopa' => $x['doctopa'],
                'status' => 0
            );
            $this->db->insert("desdevimpro", $datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRegistro() {
        try {
            $ID = $this->input->post('ID');
            $this->db->query("delete from desdevimpro where ID = $ID ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevDesImpro() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT ID, cliente, docto, fecha, importe, mov, doctopa, agente, date_format(fecha,'%d/%m/%Y') as fecha FROM desdevimpro
                                                where cliente = '$cte'
                                                and tp = '$tp' ")->result());
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
                                                where cliente = '$cte'
                                                and tipo = '$tp'
                                                and status < 3
                                                and saldo > 5 ")->result());
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

}
