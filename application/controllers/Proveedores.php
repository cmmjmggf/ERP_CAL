<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Proveedores_model');
    }

    public function index() {

        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {

            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');

                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'PROVEEDORES') {
                        $this->load->view('vMenuProveedores');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PROVEEDORES':
                    $this->load->view('vMenuProveedores');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProveedores');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vProveedores');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getUltimoRegistro() {
        try {
            print json_encode($this->Proveedores_model->getUltimoRegistro());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Proveedores_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedorByClave() {
        try {
            $clave = $this->input->post('ID');
            print json_encode($this->db->query("select * from proveedores where clave = '$clave' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedorByID() {
        try {
            print json_encode($this->Proveedores_model->getProveedorByID($this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            extract($this->input->post());
            $DATA = array(
                'Clave' => ($Clave !== NULL) ? $Clave : NULL,
                'NombreI' => ($NombreI !== NULL) ? $NombreI : NULL,
                'NombreF' => ($NombreF !== NULL) ? $NombreF : NULL,
                'Direccion' => ($Direccion !== NULL) ? $Direccion : NULL,
                'NoExt' => ($NoExt !== NULL) ? $NoExt : NULL,
                'NoInt' => ($NoInt !== NULL) ? $NoInt : NULL,
                'Colonia' => ($Colonia !== NULL) ? $Colonia : NULL,
                'Ciudad' => ($Ciudad !== NULL) ? $Ciudad : NULL,
                'Estado' => ($Estado !== NULL) ? $Estado : NULL,
                'Telefono' => ($Telefono !== NULL) ? $Telefono : NULL,
                'CP' => ($CP !== NULL) ? $CP : NULL,
                'RFC' => ($RFC !== NULL) ? $RFC : NULL,
                'Plazo' => ($Plazo !== NULL) ? $Plazo : NULL,
                'CtaCheques' => ($CtaCheques !== NULL) ? $CtaCheques : NULL,
                'Banco' => ($Banco !== NULL) ? $Banco : NULL,
                'DctoProntoPago' => ($DctoProntoPago !== NULL) ? $DctoProntoPago : NULL,
                'DiasProntoPago' => ($DiasProntoPago !== NULL) ? $DiasProntoPago : NULL,
                'Correo' => ($Correo !== NULL) ? $Correo : NULL,
                'Contacto' => ($Contacto !== NULL) ? $Contacto : NULL,
                'PorcentajeComprasPorPedidoF' => ($PorcentajeComprasPorPedidoF !== NULL) ? $PorcentajeComprasPorPedidoF : NULL,
                'PorcentajeComprasPorPedidoR' => ($PorcentajeComprasPorPedidoR !== NULL) ? $PorcentajeComprasPorPedidoR : NULL,
                'Estatus' => 'ACTIVO'
            );
            $this->Proveedores_model->onAgregar($DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            extract($this->input->post());
            $DATA = array(
                'NombreI' => ($NombreI !== NULL) ? $NombreI : NULL,
                'NombreF' => ($NombreF !== NULL) ? $NombreF : NULL,
                'Direccion' => ($Direccion !== NULL) ? $Direccion : NULL,
                'NoExt' => ($NoExt !== NULL) ? $NoExt : NULL,
                'NoInt' => ($NoInt !== NULL) ? $NoInt : NULL,
                'Colonia' => ($Colonia !== NULL) ? $Colonia : NULL,
                'Ciudad' => ($Ciudad !== NULL) ? $Ciudad : NULL,
                'Estado' => ($Estado !== NULL) ? $Estado : NULL,
                'Telefono' => ($Telefono !== NULL) ? $Telefono : NULL,
                'CP' => ($CP !== NULL) ? $CP : NULL,
                'RFC' => ($RFC !== NULL) ? $RFC : NULL,
                'Plazo' => ($Plazo !== NULL) ? $Plazo : NULL,
                'CtaCheques' => ($CtaCheques !== NULL) ? $CtaCheques : NULL,
                'Banco' => ($Banco !== NULL) ? $Banco : NULL,
                'DctoProntoPago' => ($DctoProntoPago !== NULL) ? $DctoProntoPago : NULL,
                'DiasProntoPago' => ($DiasProntoPago !== NULL) ? $DiasProntoPago : NULL,
                'Correo' => ($Correo !== NULL) ? $Correo : NULL,
                'Contacto' => ($Contacto !== NULL) ? $Contacto : NULL,
                'PorcentajeComprasPorPedidoF' => ($PorcentajeComprasPorPedidoF !== NULL) ? $PorcentajeComprasPorPedidoF : NULL,
                'PorcentajeComprasPorPedidoR' => ($PorcentajeComprasPorPedidoR !== NULL) ? $PorcentajeComprasPorPedidoR : NULL,
            );
            $this->Proveedores_model->onModificar($ID, $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            extract($this->input->post());
            $this->Proveedores_model->onEliminar($ID);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
