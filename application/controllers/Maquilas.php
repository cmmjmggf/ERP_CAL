<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Maquilas_model')->model('Departamentos_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'PROVEEDORES') {
                        $this->load->view('vMenuProveedores');
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
                case 'PROVEEDORES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProveedores');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vMaquilas');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getDepartamentos() {
        try {
            extract($this->input->post());
            $data = $this->Departamentos_model->getDepartamentos();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Maquilas_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Maquilas_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaByID() {
        try {
            print json_encode($this->Maquilas_model->getMaquilaByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaByClave() {
        try {
            print json_encode($this->Maquilas_model->getMaquilaByClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->Maquilas_model->onAgregar(array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Nombre' => ($x->post('Nombre') !== NULL) ? $x->post('Nombre') : NULL,
                'DepartamentoInicial' => ($x->post('DepartamentoInicial') !== NULL) ? $x->post('DepartamentoInicial') : NULL,
                'DepartamentoFinal' => ($x->post('DepartamentoFinal') !== NULL) ? $x->post('DepartamentoFinal') : NULL,
                'EntregaMat1' => ($x->post('EntregaMat1') !== NULL) ? $x->post('EntregaMat1') : NULL,
                'EntregaMat2' => ($x->post('EntregaMat2') !== NULL) ? $x->post('EntregaMat2') : NULL,
                'EntregaMat3' => ($x->post('EntregaMat3') !== NULL) ? $x->post('EntregaMat3') : NULL,
                'Direccion' => ($x->post('Direccion') !== NULL) ? $x->post('Direccion') : NULL,
                'Telefono' => ($x->post('Telefono') !== NULL) ? $x->post('Telefono') : NULL,
                'CapacidadPares' => ($x->post('CapacidadPares') !== NULL) ? $x->post('CapacidadPares') : NULL,
                'OpcionPorcentaje' => ($x->post('OpcionPorcentaje') !== NULL) ? $x->post('OpcionPorcentaje') : NULL,
                'PorExtraXProduccion' => ($x->post('PorExtraXProduccion') !== NULL) ? $x->post('PorExtraXProduccion') : NULL,
                'PorExtraXExplosionConcilia' => ($x->post('PorExtraXExplosionConcilia') !== NULL) ? $x->post('PorExtraXExplosionConcilia') : NULL,
                'PorExtraXFichaTecnica' => ($x->post('PorExtraXFichaTecnica') !== NULL) ? $x->post('PorExtraXFichaTecnica') : NULL,
                'PorExtraXBotaAlta' => ($x->post('PorExtraXBotaAlta') !== NULL) ? $x->post('PorExtraXBotaAlta') : NULL,
                'PorExtraXBota' => ($x->post('PorExtraXBota') !== NULL) ? $x->post('PorExtraXBota') : NULL,
                'PorExtra3a10' => ($x->post('PorExtra3a10') !== NULL) ? $x->post('PorExtra3a10') : NULL,
                'PorExtra11a14' => ($x->post('PorExtra11a14') !== NULL) ? $x->post('PorExtra11a14') : NULL,
                'PorExtra15a18' => ($x->post('PorExtra15a18') !== NULL) ? $x->post('PorExtra15a18') : NULL,
                'PorExtra19a' => ($x->post('PorExtra19a') !== NULL) ? $x->post('PorExtra19a') : NULL,
                'RecibeMaterial' => ($x->post('RecibeMaterial') !== NULL) ? $x->post('RecibeMaterial') : NULL,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $this->Maquilas_model->onModificar($x->post('ID'), array(
                'Nombre' => ($x->post('Nombre') !== NULL) ? $x->post('Nombre') : NULL,
                'DepartamentoInicial' => ($x->post('DepartamentoInicial') !== NULL) ? $x->post('DepartamentoInicial') : NULL,
                'DepartamentoFinal' => ($x->post('DepartamentoFinal') !== NULL) ? $x->post('DepartamentoFinal') : NULL,
                'EntregaMat1' => ($x->post('EntregaMat1') !== NULL) ? $x->post('EntregaMat1') : NULL,
                'EntregaMat2' => ($x->post('EntregaMat2') !== NULL) ? $x->post('EntregaMat2') : NULL,
                'EntregaMat3' => ($x->post('EntregaMat3') !== NULL) ? $x->post('EntregaMat3') : NULL,
                'Direccion' => ($x->post('Direccion') !== NULL) ? $x->post('Direccion') : NULL,
                'Telefono' => ($x->post('Telefono') !== NULL) ? $x->post('Telefono') : NULL,
                'CapacidadPares' => ($x->post('CapacidadPares') !== NULL) ? $x->post('CapacidadPares') : NULL,
                'OpcionPorcentaje' => ($x->post('OpcionPorcentaje') !== NULL) ? $x->post('OpcionPorcentaje') : NULL,
                'PorExtraXProduccion' => ($x->post('PorExtraXProduccion') !== NULL) ? $x->post('PorExtraXProduccion') : NULL,
                'PorExtraXExplosionConcilia' => ($x->post('PorExtraXExplosionConcilia') !== NULL) ? $x->post('PorExtraXExplosionConcilia') : NULL,
                'PorExtraXFichaTecnica' => ($x->post('PorExtraXFichaTecnica') !== NULL) ? $x->post('PorExtraXFichaTecnica') : NULL,
                'PorExtraXBotaAlta' => ($x->post('PorExtraXBotaAlta') !== NULL) ? $x->post('PorExtraXBotaAlta') : NULL,
                'PorExtraXBota' => ($x->post('PorExtraXBota') !== NULL) ? $x->post('PorExtraXBota') : NULL,
                'PorExtra3a10' => ($x->post('PorExtra3a10') !== NULL) ? $x->post('PorExtra3a10') : NULL,
                'PorExtra11a14' => ($x->post('PorExtra11a14') !== NULL) ? $x->post('PorExtra11a14') : NULL,
                'PorExtra15a18' => ($x->post('PorExtra15a18') !== NULL) ? $x->post('PorExtra15a18') : NULL,
                'PorExtra19a' => ($x->post('PorExtra19a') !== NULL) ? $x->post('PorExtra19a') : NULL,
                'RecibeMaterial' => ($x->post('RecibeMaterial') !== NULL) ? $x->post('RecibeMaterial') : NULL,
                'Estatus' => 'ACTIVO'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Maquilas_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
