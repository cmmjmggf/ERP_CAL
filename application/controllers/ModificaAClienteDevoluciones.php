<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ModificaAClienteDevoluciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function getControlesConDevolucionesSinAplicar() {
        try {
            $x = $this->input->get();
            print json_encode(
                            $this->db->query(
                                    "SELECT "
                                    . "D.ID AS ID, D.cliente AS CLIENTE, D.control AS CONTROL, "
                                    . "D.paredev AS PARES, DATE_FORMAT(D.fechadev,\"%d/%m/%Y\") AS REG "
                                    . "FROM devolucionnp AS D "
                                    . "WHERE D.staapl = 1 AND "
                                    . "(CASE WHEN '{$x["CLIENTE"]}' <> '' THEN D.cliente = '{$x["CLIENTE"]}' ELSE D.cliente LIKE '%%' END)")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCambiarClienteAcontrol() {
        try {
            $x = $this->input->post();
            if ($x['ID'] !== '' && $x['CLIENTE'] !== '' && $x['CLIENTE_NUEVO'] !== '') {
                $this->db->set('cliente', $x['CLIENTE_NUEVO'])
                        ->where('ID', $x['ID'])
                        ->where('cliente', $x['CLIENTE'])
                        ->update('devolucionnp');
                print json_encode(array("MODIFICADO" => 1));
            } else {
                print json_encode(array("MODIFICADO" => 0));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesModDev() {
        try {
            print json_encode($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.Zona AS ZONA, C.ListaPrecios AS LISTADEPRECIO FROM clientes AS C INNER JOIN devolucionnp AS D ON C.Clave = D.cliente WHERE C.Estatus IN('ACTIVO') AND D.staapl IN(0, 1) ORDER BY ABS(C.Clave) ASC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
