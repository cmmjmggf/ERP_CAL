<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReasignarControles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Reasignarcontroles_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuRecursosHumanos');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vReasignarControles')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Reasignarcontroles_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->Reasignarcontroles_model->getMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarMaquilaValida() {
        try {
            print json_encode($this->Reasignarcontroles_model->onChecarMaquilaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->Reasignarcontroles_model->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHistorialDeControles() {
        try {
            print json_encode($this->Reasignarcontroles_model->getHistorialDeControles());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerElUltimoControl() {
        try {
            print json_encode($this->Reasignarcontroles_model->onObtenerElUltimoControl($this->input->get('SEMANA'), $this->input->get('MAQUILA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function onReAsignarControles() {
        try {
            $controles = json_decode($this->input->post('Controles'));

            /* ELIMINAR CUALQUIER ORDEN DE PRODUCCION */
            $CONTROL_INICIAL = $this->input->post('INICIO');
            $CONTROL_FINAL = $this->input->post('FIN');
            $this->db->trans_begin();
            $this->db->query("DELETE OPD.* FROM ordendeproducciond AS OPD 
                INNER JOIN OrdenDeProduccion AS OP 
                ON OPD.OrdenDeProduccion = OP.ID 
                WHERE OPD.ID > 0 AND OP.ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL");
            $this->db->query("DELETE FROM ordendeproduccion WHERE ID > 0 AND ControlT BETWEEN $CONTROL_INICIAL AND $CONTROL_FINAL");
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            foreach ($controles as $k => $v) {
                $Y = substr(Date('Y'), 2);
                $M = str_pad($v->Maquila, 2, '0', STR_PAD_LEFT);
                $S = str_pad($v->Semana, 2, '0', STR_PAD_LEFT);
                $IDN = $this->Reasignarcontroles_model->getMaximoConsecutivo($M, $S, 0);
                if (count($IDN) > 0) {
                    $C = str_pad($IDN[0]->MAXIMO, 3, '0', STR_PAD_LEFT);
                    /* CAMBIAR EN CONTROLES; LA SEMANA, LA MAQUILA Y EL CONSECUTIVO EN 'N' */
                    $this->db->set('Semana', $S)->set('Maquila', $M)
                            ->set('Control', $Y . $S . $M . $C)
                            ->set('Consecutivo', $C)
                            ->where('PedidoDetalle', $v->PedidoDetalle)->update('controles');
                    /* MODIFICAR EN EL PEDIDO (DETALLE), EL CONTROL */
                    $this->db->set('Control', $Y . $S . $M . $C)
                            ->set('Semana', $S)
                            ->set('Maquila', $M)
                            ->set('Observacion', $v->Observacion)
                            ->set('ObservacionDetalle', $v->Adicionales)
                            ->where('ID', $v->PedidoDetalle)->update('pedidodetalle');
                } else {
                    //VACIO
                    /* CAMBIAR EN CONTROLES; LA SEMANA, LA MAQUILA Y EL CONSECUTIVO EN 001 */
                    $C = str_pad(1, 3, '0', STR_PAD_LEFT);
                    $this->db->set('Semana', $S)
                            ->set('Maquila', $M)
                            ->set('Control', $Y . $S . $M . $C)
                            ->set('Consecutivo', $C)
                            ->where('PedidoDetalle', $v->PedidoDetalle)->update('controles');
                    /* MODIFICAR EN EL PEDIDO (DETALLE), EL CONTROL */
                    $this->db->set('Control', $Y . $S . $M . $C)
                            ->set('Semana', $S)
                            ->set('Maquila', $M)
                            ->set('Observacion', $v->Observacion)
                            ->set('ObservacionDetalle', $v->Adicionales)
                            ->where('ID', $v->PedidoDetalle)->update('pedidodetalle');
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}