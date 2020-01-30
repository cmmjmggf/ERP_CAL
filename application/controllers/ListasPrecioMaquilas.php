<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ListasPrecioMaquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ListasPrecioMaquilas_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {

                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'FT') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;

                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vListasPrecioMaquilas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getColoresXEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->select("CAST(C.Clave AS SIGNED ) AS ID, CONCAT(C.Descripcion) AS Descripcion ", false)
                                    ->from('colores AS C')
                                    ->where('C.Estilo', $Estilo)
                                    ->where('C.Estatus', 'ACTIVO')
                                    ->order_by('Descripcion', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEstiloColor() {
        try {
            $Estilo = $this->input->get('Estilo');
            $Color = $this->input->get('Color');
            print json_encode($this->db->query("select clave from colores where estilo = '$Estilo' and clave = '$Color' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->query("select clave, linea from estilos where clave = '$Estilo'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $Maq = $this->input->post('Maq');
            $Linea = $this->input->post('Linea');
            print json_encode($this->ListasPrecioMaquilas_model->getRecords($Maq, $Linea));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {
            $this->ListasPrecioMaquilas_model->onEliminarDetalleByID($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $maq = $this->input->post('Maq');
            $est = $this->input->post('Estilo');
            $col = $this->input->post('Color');
            $precio = $this->input->post('PrecioVta');
            $datos = array(
                'Maq' => $maq,
                'Linea' => $this->input->post('Linea'),
                'Estilo' => $est,
                'Color' => $col,
                'Corrida' => $this->input->post('Corrida'),
                'PrecioVta' => $precio
            );

            //Si no existe lo agrega, de lo contrario solo modifica el registro
            $Existe = $this->db->query("select * from listapreciosmaquilas where maq = {$maq} and estilo = '{$est}' and color = {$col} ")->result();

            if (!empty($Existe)) {
                $this->db->query("update listapreciosmaquilas set PrecioVta = {$precio} where maq = {$maq} and estilo = '{$est}' and color = {$col} ");
            } else {
                $this->ListasPrecioMaquilas_model->onAgregar($datos);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
