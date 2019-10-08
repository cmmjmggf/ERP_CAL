<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class CerrarSemanasProd extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('Cerrarsemanasprod_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vCerrarSemanasProd');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onImportarSemanasTablaFili() {
        try {
            $SemanasFili = $this->db->query("SELECT numsem, `status` as ano, maq1, maq2, maq3, maq4, maq5, maq6, maq7, maq8, maq9
                                            FROM semanasprodfili order by `status` asc, numsem asc")->result();


            $this->db->query("truncate table semanasproduccioncerradas ");
            foreach ($SemanasFili as $key => $v) {

                for ($i = 1; $i < 10; $i++) {
                    $statusSem = intval($v->{"maq$i"});
                    if ($statusSem > 0) {
                        $ano = $v->ano;
                        $maq = $i;
                        $sem = $v->numsem;
                        $statusSem = ($statusSem === 2) ? 'CERRADA' : '';
                        $this->db->query("INSERT INTO `erp_cal`.`semanasproduccioncerradas` (`Ano`,`Maq`,`Sem`,`Estatus`)
                                        VALUES($ano,$maq,$sem,'$statusSem') ; ");
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Cerrarsemanasprod_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion() {
        try {
            print json_encode($this->Cerrarsemanasprod_model->onComprobarSemanasProduccion($this->input->get('Clave'), $this->input->get('Ano')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->Cerrarsemanasprod_model->onComprobarMaquilas($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada() {
        try {
            print json_encode($this->Cerrarsemanasprod_model->onVerificarSemanaProdCerrada(
                                    $this->input->get('Ano'), $this->input->get('Maq'), $this->input->get('Sem')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            $data = array(
                'Ano' => $this->input->post('Ano'),
                'Maq' => $this->input->post('Maq'),
                'Sem' => $this->input->post('Sem'),
                'Estatus' => 'CERRADA'
            );
            $this->Cerrarsemanasprod_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            var_dump($this->input->post());
            $data = array(
                'Estatus' => $this->input->post('Estatus')
            );
            $this->Cerrarsemanasprod_model->onModificar(
                    $this->input->post('Ano'), $this->input->post('Maq'), $this->input->post('Sem'), $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
