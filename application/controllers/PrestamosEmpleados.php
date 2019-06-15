<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class PrestamosEmpleados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('PrestamosEmpleados_model', 'pem');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuNominas');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNominas');
                    break;
            }
            $this->load->view('vFondo')->view('vPrestamosEmpleados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->pem->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamos() {
        try {
            print json_encode($this->pem->getPrestamos($this->input->get('EMPLEADO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamosPagos() {
        try {
            print json_encode($this->pem->getPrestamosPagos($this->input->get('EMPLEADO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoSaldo() {
        try {
            print json_encode($this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                                            . "P.pagare AS PAGARE,P.sem AS SEM, P.fechapre AS FECHA, "
                                            . "P.preemp AS PRESTAMO, P.aboemp AS ABONO, P.salemp, "
                                            . "P.pesos,P.fecpag,P.sempag,"
                                            . "((SELECT SUM(PX.preemp) FROM prestamos AS PX WHERE PX.numemp = P.numemp ) - "
                                            . "(SELECT SUM(PP.aboemp) FROM prestamospag AS PP WHERE PP.numemp = P.numemp)) AS SALDO", false)->from('prestamos AS P')
                                    ->where('P.numemp', $this->input->get('EMPLEADO'))
                                    ->order_by('P.fechapre', 'DESC')->limit(1)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionSemana() {
        try {
            print json_encode($this->pem->getInformacionSemana(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarPrestamosEmpleados() {
        try {
            $x = $this->input;
            $E = $this->db->select("E.Numero AS CLAVE, "
                                    . "CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")
                            ->where('E.Numero', $x->post('EMPLEADO'))
                            ->where('E.AltaBaja', 1)->get()->result();
            $semanas = $x->post('PRESTAMO') / $x->post('ABONO');
            $dias = $semanas * 7;
            $fecha = Date('Y-m-d');
            $fecha_final = $this->db->query("SELECT DATE_ADD(\"{$fecha}\", INTERVAL {$dias} DAY) AS FDP")->row_array();

            $this->db->insert('prestamos', array(
                'numemp' => $x->post('EMPLEADO'),
                'nomemp' => $E[0]->EMPLEADO,
                'pagare' => $x->post('PAGARE'),
                'sem' => $x->post('SEMANA'),
                'fechapre' => Date('Y-m-d h:i:s'),
                'preemp' => $x->post('PRESTAMO'),
                'aboemp' => $x->post('ABONO'),
                'salemp' => $x->post('SALDO'),
                'pesos' => $x->post('PRESTAMOLETRA'),
                'fecpag' => $fecha_final['FDP'],
                'sempag' => $semanas
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
