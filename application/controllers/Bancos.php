<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bancos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Bancos_model');
    }

    public function index() {

        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {

            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');


                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CONTABILIDAD') {
                        $this->load->view('vMenuContabilidad');
                    } else if ($Origen === 'PROVEEDORES') {
                        $this->load->view('vMenuProveedores');
                    }


                    break;

                case 'PROVEEDORES':
                    $this->load->view('vMenuProveedores');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vBancos');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getUltimoRegistro() {
        try {
            print json_encode($this->Bancos_model->getUltimoRegistro());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Bancos_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancoByID() {
        try {
            print json_encode($this->Bancos_model->getBancoByID($this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            extract($this->input->post());
            $DATA = array(
                'Clave' => ($Clave !== NULL) ? $Clave : NULL,
                'Tp' => ($Tp !== NULL) ? $Tp : NULL,
                'Nombre' => ($Nombre !== NULL) ? $Nombre : NULL,
                'Direccion' => ($Direccion !== NULL) ? $Direccion : NULL,
                'Colonia' => ($Colonia !== NULL) ? $Colonia : NULL,
                'Ciudad' => ($Ciudad !== NULL) ? $Ciudad : NULL,
                'Telefono' => ($Telefono !== NULL) ? $Telefono : NULL,
                'CP' => ($CP !== NULL) ? $CP : NULL,
                'RFC' => ($RFC !== NULL) ? $RFC : NULL,
                'NoCuenta' => ($NoCuenta !== NULL) ? $NoCuenta : NULL,
                'Clabe' => ($Clabe !== NULL) ? $Clabe : NULL,
                'CtaCheques' => ($CtaCheques !== NULL) ? $CtaCheques : NULL,
                'UltCheque' => ($UltCheque !== NULL) ? $UltCheque : NULL,
                'SaldoInicial' => ($SaldoInicial !== NULL) ? $SaldoInicial : 0,
                'Cargos' => ($Cargos !== NULL) ? $Cargos : 0,
                'Abonos' => ($Abonos !== NULL) ? $Abonos : 0,
                'SaldoFinal' => ($SaldoFinal !== NULL) ? $SaldoFinal : 0,
                'CtaContable' => ($CtaContable !== NULL) ? $CtaContable : NULL,
                'Estatus' => 'ACTIVO'
            );
            $this->Bancos_model->onAgregar($DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            extract($this->input->post());
            $DATA = array(
                'Nombre' => ($Nombre !== NULL) ? $Nombre : NULL,
                'Direccion' => ($Direccion !== NULL) ? $Direccion : NULL,
                'Colonia' => ($Colonia !== NULL) ? $Colonia : NULL,
                'Ciudad' => ($Ciudad !== NULL) ? $Ciudad : NULL,
                'Telefono' => ($Telefono !== NULL) ? $Telefono : NULL,
                'CP' => ($CP !== NULL) ? $CP : NULL,
                'RFC' => ($RFC !== NULL) ? $RFC : NULL,
                'NoCuenta' => ($NoCuenta !== NULL) ? $NoCuenta : NULL,
                'Clabe' => ($Clabe !== NULL) ? $Clabe : NULL,
                'CtaCheques' => ($CtaCheques !== NULL) ? $CtaCheques : NULL,
                'UltCheque' => ($UltCheque !== NULL) ? $UltCheque : NULL,
                'SaldoInicial' => ($SaldoInicial !== NULL) ? $SaldoInicial : 0,
                'CtaContable' => ($CtaContable !== NULL) ? $CtaContable : NULL
            );
            $this->Bancos_model->onModificar($ID, $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            extract($this->input->post());
            $this->Bancos_model->onEliminar($ID);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
