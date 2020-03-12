<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ChecadorComedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vChecadorComedor')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onAplicarComidasEmpleadosSemana() {
        try {
            $x = $this->input->post();
            $sem = $x['Sem'];
            $año = Date('Y');
            $existe_comida_sem = $this->db->query("SELECT numemp, SUM(cantida) AS comida FROM comida WHERE año = $año AND sem = $sem GROUP BY numemp ORDER BY ABS(numemp) ASC ")->result();

            if (!empty($existe_comida_sem)) {
                $this->db->query("UPDATE empleados SET comida = 0 WHERE comida <> 0 ");
                foreach ($existe_comida_sem as $key => $v) {
                    $this->db->query("UPDATE empleados SET comida = {$v->comida} where numero =  '{$v->numemp}' ");
                }
                //Imprime Reporte
                $this->onImprimirReporteComedor($año, $sem);
            } else {//No existen movimientos
                print 0;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporteComedor($año, $sem) {

        $REPORTES = array();

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $año;
        $parametros["sem"] = $sem;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\comedor\reporteComedorAnoSem.jasper');
        $jc->setFilename('COMIDAS_POR_EMPLEADO_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        $REPORTES['PDF'] = $jc->getReport();


        $jc->setJasperurl('jrxml\comedor\reporteComedorAnoSemExcel.jasper');
        $jc->setFilename('COMIDAS_POR_EMPLEADO_SEM_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
        $REPORTES['XLS'] = $jc->getReport();

        print json_encode($REPORTES);
    }

    public function getInformacionSemana() {
        try {
            print json_encode($this->ASM->getInformacionSemana(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getComidas() {
        try {
            $x = $this->input->get();
            $numemp = $x['Empleado'];
            $sem = $x['Semana'];
            $año = Date('Y');
            print json_encode($this->db->query("SELECT numemp, nomemp, año, sem, date_format(fecha,'%d/%m/%Y') as fecha , "
                                    . "cantida FROM comida WHERE `numemp` = '$numemp' AND año = $año AND sem = $sem order by fecha desc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarComedor() {
        try {
            $fecha = Date('Y-m-d');
            $x = $this->input->post();
            $numemp = $x['Numero'];
            $sem = $x['Semana'];
            $año = Date('Y');
            $empleado = $this->db->query("select * from empleados where numero = '{$numemp}' and altabaja = 1 ")->result();

            if (!empty($empleado)) {//Existe
                print json_encode($empleado[0]);
                $Comida = $this->db->query("SELECT * FROM comida WHERE `numemp` = '$numemp' AND año = $año AND sem = $sem AND fecha = '$fecha' ")->result();
                if (empty($Comida)) {
                    $data = array(
                        'numemp' => $numemp,
                        'nomemp' => $empleado[0]->Busqueda,
                        'año' => $año,
                        'sem' => $sem,
                        'fecha' => $fecha,
                        'cantida' => 24
                    );
                    $this->db->insert("comida", $data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
