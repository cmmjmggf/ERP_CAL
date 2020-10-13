<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class SubfraccionesXEstilo extends CI_Controller {

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
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuNominas');
                    }
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vSubfraccionesXEstilo')->view('vFooter');
        } else {
            $this->load->view('vFondo')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->db->query("select f.ID, f.Clave, Descripcion, abs(f.departamento) as Departamento, "
                                    . " (select concat(Clave,' ',Descripcion) from departamentos where clave = f.departamento) as Depto "
                                    . " from fracciones f ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDesgloce() {
        try {
            $fraccion = $this->input->post('Fraccion');
            print json_encode($this->db->query("select "
                                    . "sf.ID, "
                                    . "sf.Fraccion, "
                                    . "concat(sf.Clave,' - ',sf.Descripcion) as Subfraccion, "
                                    . "(select concat(Clave,' - ',Descripcion) from puestos where clave = sf.Puesto ) AS Puesto,"
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg " onclick="onEliminar(\', sf.ID, \')">\', \'</span>\') AS Eliminar '
                                    . " from subfracciones as sf "
                                    . "where sf.fraccion = '{$fraccion}' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubFraccionByID() {
        try {
            $ID = $this->input->get('ID');
            print json_encode($this->db->query("select * "
                                    . " from subfracciones "
                                    . "where fraccion = '{$ID}' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $data = array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Fraccion' => ($x->post('Fraccion') !== NULL) ? $x->post('Fraccion') : NULL,
                'Puesto' => ($x->post('Puesto') !== NULL) ? $x->post('Puesto') : NULL
            );
            $this->db->insert("subfracciones", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $ID = $this->input->post('ID');
            $this->db->where('ID', $ID)->delete("subfracciones");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
