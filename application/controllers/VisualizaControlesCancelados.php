<?php

class VisualizaControlesCancelados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('OrdenProduccionPantalla_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
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
            $this->load->view('vFondo')->view('vVisualizaControlesCancelados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getControlCancelado() {
        try {
            $Control = $this->input->get('Control');
            $query = "select OP.Clave AS Pedido,
                            CONCAT(OP.Cliente,' - ',C.RazonS) AS Cliente,
                            CONCAT(OP.Agente,' - ',A.Nombre) AS Agente,
                            CONCAT(E.Linea,' - ',L.Descripcion) AS Linea,
                            CONCAT(OP.Estilo,' - ',OP.EstiloT) AS Estilo,
                            CONCAT(OP.Color,' - ',OP.ColorT) AS Color,
                            OP.EstatusProduccion,
                            OP.Serie AS SerieCorrida,
                            S.T1,S.T2,S.T3,S.T4,S.T5,S.T6,S.T7,S.T8,S.T9,S.T10,S.T11,S.T12,S.T13,S.T14,S.T15,S.T16,S.T17,S.T18,S.T19,S.T20,S.T21,S.T22,
                            OP.C1,OP.C2,OP.C3,OP.C4,OP.C5,OP.C6,OP.C7,OP.C8,OP.C9,OP.C10,OP.C11,OP.C12,OP.C13,OP.C14,OP.C15,OP.C16,OP.C17,OP.C18,OP.C19,OP.C20,OP.C21,OP.C22,
                            OP.Pares,
                            OP.FechaEntrega,
                            OP.FechaPedido,
                            OP.Observacion AS Observaciones
                            FROM pedidox OP
                            JOIN agentes A ON A.Clave =  OP.Agente
                            JOIN clientes C ON C.Clave =  OP.Cliente
                            JOIN estilos E ON E.Clave = OP.Estilo
                            JOIN lineas L ON L.Clave = E.Linea
                            JOIN series S ON S.`Clave` = OP.`Serie`
                            WHERE OP.Control = $Control";
            print json_encode($this->db->query($query)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
