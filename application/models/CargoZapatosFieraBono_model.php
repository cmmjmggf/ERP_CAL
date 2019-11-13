<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CargoZapatosFieraBono_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("E.ID, E.Numero AS NUMERO, CONCAT(E.PrimerNombre,' ',"
                                    . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                    . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                    . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE, "
                                    . "E.ZapatosTDA AS IMPORTE, E.AbonoZap AS PAGOS", false)
                            ->from('empleados AS E')->where('E.AltaBaja', 1)
                            ->where('E.ZapatosTDA > 0', null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero,\" \",E.PrimerNombre,' ',"
                                    . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                    . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                    . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS EMPLEADO", false)
                            ->from('empleados AS E')->where('E.AltaBaja', 1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
