<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CerrarProg extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Cerrarprog_model', 'cprm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vCerrarProg')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $x = $this->input;
            print json_encode($this->cprm->getRecords($x->get('MAQUILA'), $x->get('SEMANA'), $x->get('ANIO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHistorialDeControles() {
        try {
            print json_encode($this->cprm->getHistorialDeControles());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarControles() {
        try {
            $controles = json_decode($this->input->post('SubControles'));

            switch ($this->input->post('Marca')) {
                case 1:
                    foreach ($controles as $k => $v) {
                        if ($v->Control == "" || $v->Control == 0) {
                            $Y = substr(Date('Y'), 2);
                            $M = str_pad($v->Maquila, 2, '0', STR_PAD_LEFT);
                            $S = str_pad($v->Semana, 2, '0', STR_PAD_LEFT);
                            $C = str_pad($this->cprm->getMaximoConsecutivo($v->Maquila, $v->Semana, 0)[0]->MAX, 3, '0', STR_PAD_LEFT);
                            $C = $C > 0 ? $C : str_pad(1, 3, '0', STR_PAD_LEFT);
                            $this->cprm->onAgregarControl(array(
                                'Control' => $Y . $S . $M . $C,
                                'FechaProgramacion' => Date('Y-m-d h:i:s'),
                                'Estilo' => $v->Estilo, 'Color' => $v->Color,
                                'Serie' => $v->Serie, 'Cliente' => $v->Cliente,
                                'Pares' => $v->Pares, 'Pedido' => $v->Pedido,
                                'PedidoDetalle' => $v->PedidoDetalle,
                                'Estatus' => 'A', 'Departamento' => 1 /* 0|null|Inexistente - PEDIDO => 1 - PROGRAMADO */,
                                'Ano' => $Y, 'Maquila' => $M, 'Semana' => $S, 'Consecutivo' => $C
                            ));
                            $Control = $Y . $S . $M . $C;
                            $this->db->set('Control', $Control)->where('ID', $v->PedidoDetalle)->update('pedidox');
//                            print $this->db->last_query();/*QUEDA PARA PRUEBAS*/

                            /* AGREGAR REGISTRO EN AVAPRD (FILI) */
                            $check_control = $this->db->select('COUNT(A.contped) AS EXISTE', false)
                                            ->from('avaprd AS A')
                                            ->where('A.contped', $Control)
                                            ->get()->result();
                            if ($check_control[0]->EXISTE <= 0) {
                                $this->db->insert('avaprd', array(
                                    'contped' => $Control,
                                    'status' => 1,
                                    'fec1' => Date('Y-m-d h:i:s')
                                ));
                            } else {
                                $this->db->set('fec1', Date('Y-m-d h:i:s'))
                                        ->where('contped', $Control)
                                        ->update('avaprd');
                            }
                        }
                    }
                    break;
                case 2:
                    foreach ($controles as $k => $v) {
                        $this->cprm->onAgregarHistorialControl(array(
                            'Control' => $v->Control,
                            'Estilo' => $v->Estilo,
                            'EstiloDescripcion' => $v->DescripcionEstilo,
                            'Color' => $v->Color,
                            'ColorDescripcion' => $v->ColorDescripcion,
                            'Pedido' => $v->PedidoID,
                            'FechaPedido' => $v->FechaPedido,
                            'FechaEntregaRecepcion' => $v->FechaEntregaRecepcion,
                            'FechaCaptura' => $v->FechaCaptura,
                            'Semana' => $v->Semana,
                            'Maquila' => $v->Maquila,
                            'ClaveCliente' => $v->ClaveCliente,
                            'ClienteRazon' => $v->ClienteRazon,
                            'Pares' => $v->Pares,
                            'Precio' => $v->Precio,
                            'Importe' => $v->Importe,
                            'Descuento' => 0,
                            'FechaEntrega' => $v->FechaEntrega,
                            'Serie' => $v->SerieT,
                            'Ano' => $v->Ano,
                            'Marca' => $v->Marca,
                            'FechaEliminacion' => Date('d/m/Y h:i:s a'),
                            'Usuario' => $_SESSION["USERNAME"]
                        ));
                        $this->db->where('Pedido', $v->Pedido)->where('PedidoDetalle', $v->PedidoDetalle)->delete('Controles');
                        $this->db->set('Control', 0)->where('ID', $v->PedidoDetalle)->update('pedidox');
                    }
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
