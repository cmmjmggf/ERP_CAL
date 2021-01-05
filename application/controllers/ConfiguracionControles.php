<?php

class ConfiguracionControles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR' || 'PRODUCCION' || 'SUPERVISION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vConfiguracionControles')->view('vFooter');
                    break;
                default:
                    header("Location: " . base_url());
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getPedidoXControl() {
        try {
            $x = $this->input->get();
            $SELECT = "SELECT P.ID, P.Clave AS PEDIDO, P.Cliente AS CLIENTE, "
                    . "P.Estilo AS ESTILO, P.Color AS COLOR, P.Maquila AS MAQUILA, P.Semana AS SEMANA, P.Ano AS ANO, "
                    . "P.Control AS CONTROL, P.Pares AS PARES, P.ParesFacturados AS PARES_FACTURADOS, "
                    . "P.Estatus AS ESTATUS,P.EstatusProduccion AS ESTATUS_PRODUCCION, P.DeptoProduccion AS DEPTO_PRODUCCION, "
                    . "P.stsavan AS STSAVAN FROM pedidox AS P ";
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->query("{$SELECT} WHERE P.Control = {$x["CONTROL"]}")->result());
            } else {
                print json_encode($this->db->query("{$SELECT} WHERE P.Control = 0123456789")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlXControl() {
        try {
            $x = $this->input->get();
            $SELECT = "SELECT C.ID, C.Control AS CONTROL,C.Semana AS SEMANA, C.Ano AS ANO, C.Maquila AS MAQUILA, 
C.Estatus AS ESTATUS, C.Pedido AS CLAVE_PEDIDO, C.PedidoDetalle AS PEDIDO_DETALLE, C.EstatusProduccion AS ESTATUS_PRODUCCION, 
C.DeptoProduccion AS DEPTO_PRODUCCION FROM controles AS C ";
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->query("{$SELECT} WHERE C.Control = {$x["CONTROL"]}")->result());
            } else {
                print json_encode($this->db->query("{$SELECT} WHERE C.Control = 0123456789")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAvancesXControl() {
        try {
            $x = $this->input->get();
            $SELECT = "SELECT ID AS ID, Control AS CONTROL, FechaAProduccion AS FECHA_A_PRODUCCION, "
                    . "Departamento AS CLAVE_DEPTO, DepartamentoT AS DEPARTAMENTO,"
                    . "FechaAvance AS FECHA_AVANCE, Estatus AS ESTATUS, Usuario AS USUARIO_AVANZO, "
                    . "Fecha AS FECHA_REGISTRO, Hora AS HORA_REGISTRO, Fraccion AS FRACCION, Docto AS DOCUMENTO, modulo AS MODULO FROM avance AS A ";
            $ORDER = " ORDER BY A.ID ASC ";
            if ($x['CONTROL'] !== '') {
                print json_encode($this->db->query("{$SELECT} WHERE A.Control = {$x["CONTROL"]} {$ORDER}")->result());
            } else {
                print json_encode($this->db->query("{$SELECT} WHERE A.Control = 0123456789 {$ORDER}")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionXControl() {
        try {
            $x = $this->input->get();
            $data = $this->db->query("SELECT CONCAT(P.Cliente,\" \", (SELECT C.RazonS FROM clientes AS C WHERE C.Clave = P.Cliente LIMIT 1)) AS CLIENTE, CONCAT(P.DeptoProduccion,\" \" ,P.EstatusProduccion) AS CONTROL_ESTATUS FROM pedidox AS P WHERE P.Control = {$x['CONTROL']}")->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
