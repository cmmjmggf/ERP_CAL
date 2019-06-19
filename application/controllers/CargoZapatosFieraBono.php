<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CargoZapatosFieraBono extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('CargoZapatosFieraBono_model', 'czfb');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vCargoZapatosFieraBono')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->czfb->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->czfb->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarDeudaXEmpleado() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarValeBono() {
        try {
            $x = $this->input;
            $EMPLEADO = $x->post('EMPLEADO');
            $DOCUMENTO = intval($x->post('DOCUMENTO'));
            $IMPORTE = floatval($x->post('IMPORTE'));
            $PAGOS = intval($x->post('PAGOS'));
            $VALIDO = true;
            /* COMPROBAR SI YA TIENE VALE O BONO */
            $tiene_vale_o_bono = $this->db->select('E.*', false)
                            ->from('empleados AS E')->where('E.Numero', $EMPLEADO)
                            ->get()->result();
            /* EMPLEADO VALIDO PARA VALE O BONO */
            $evb = $tiene_vale_o_bono[0];
            if (intval($evb->Fierabono) <= 0 && $DOCUMENTO === 2) {
                print "\n FIERA BONO SIN SALDO \n";
                $this->db->set('FieraBonoPagos', $PAGOS)->set('Fierabono', $IMPORTE)
                        ->where('Numero', $EMPLEADO)->update('empleados');
            } else if (intval($evb->ZapatosTDA) <= 0 && $DOCUMENTO === 1) {
                print "\n VALE TIENDA  SIN SALDO \n";
                $this->db->set('AbonoZap', $PAGOS)->set('ZapatosTDA', $IMPORTE)
                        ->where('Numero', $EMPLEADO)->update('empleados');
            } else if ($evb->Fierabono > 0 && $DOCUMENTO === 2) {
                print "\n FIERA BONO  CON SALDO {$evb->Fierabono} \n";
                $SALDO_FINAL = $IMPORTE;
                $SALDO_FINAL += $evb->Fierabono;
                print "\n FIERA BONO SALDO FINAL {$SALDO_FINAL} \n";
                $this->db->set('FieraBonoPagos', $PAGOS)->set('Fierabono', $SALDO_FINAL)
                        ->where('Numero', $EMPLEADO)->update('empleados');
            } else if ($evb->ZapatosTDA > 0 && $DOCUMENTO === 1) {
                print "\n VALE TIENDA  CON SALDO {$evb->ZapatosTDA} \n";
                $SALDO_FINAL = $IMPORTE;
                $SALDO_FINAL += $evb->ZapatosTDA;
                $this->db->set('AbonoZap', $PAGOS)->set('ZapatosTDA', $SALDO_FINAL)
                        ->where('Numero', $EMPLEADO)->update('empleados');
                print "\n VALE TIENDA SALDO FINAL {$SALDO_FINAL} \n";
            } else {
                print "\n NO ES POSIBLE DETERMINAR SI ES FIERA BONO O VALE TIENDA \n";
                $VALIDO = false;
            }
            if ($VALIDO) {
                /* PROCESAR */
                $this->db->insert('valezapfiera',
                        array('Empleado' => $EMPLEADO,
                            'Documento' => $DOCUMENTO,
                            'Importe' => $IMPORTE,
                            'Abonos' => $PAGOS,
                            'Registro' => Date('d/m/Y h:i:s a')));
            } 
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
