<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class EliminaOrdenDeProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Ordendeproduccion_model');
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
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vEliminaOrdenDeProduccion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Ordendeproduccion_model->getRecordsGenerados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarEntreControles() {
        try {
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
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarControlesXMaquilaSemanaAno() {
        try {
            $MAQUILA = $this->input->post('MAQUILA');
            $SEMANA = $this->input->post('SEMANA');
            $ANIO = $this->input->post('ANIO');
            $ORDENES = $this->input->post('ORDENES');
            if ($MAQUILA !== '' && $SEMANA !== '' && $ANIO !== '') {

                $this->db->trans_begin();
                
                $this->db->query("DELETE FROM ordendeproducciond WHERE OrdenDeProduccion IN(SELECT O.ID FROM OrdenDeProduccion AS O WHERE O.Semana = {$SEMANA} AND O.Ano = {$ANIO} AND O.Maquila = {$MAQUILA});");
                $this->db->query("DELETE FROM OrdenDeProduccion WHERE Semana = {$SEMANA} AND Ano = {$ANIO}  AND Maquila = {$MAQUILA}");
                $l = new Logs("ELIMINA ORDENES DE PRODUCCION", "HA ELIMINADO {$ORDENES} ORDENES DE PRODUCCIÓN DE LA MAQUILA {$MAQUILA} SEMANA {$SEMANA} AÑO {$ANIO}.", $this->session);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTotalOrdenesAEliminar() {
        try {
            $x = $this->input->get();
            $this->db->select("COUNT(*) AS ORDENES", false)->from("OrdenDeProduccion AS O");
            if ($x['MAQUILA'] !== '') {
                $this->db->where("Maquila", $x['MAQUILA']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where("Semana", $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where("Ano", $x['ANIO']);
            }
            $data = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($data);
//            print json_encode($this->db->query("SELECT COUNT(*) AS ORDENES FROM OrdenDeProduccion AS O WHERE O.Semana = {$x['SEMANA']} AND O.Ano = {$x['ANIO']}  AND O.Maquila = {$x['MAQUILA']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
