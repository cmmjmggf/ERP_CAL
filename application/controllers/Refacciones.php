<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refacciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
            EXIT(0);
            $check_refaccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM refacciones AS R WHERE R.Codigo = {$x['CODIGO']} OR R.Descripcion ='{$x['DESCRIPCION']}'")->result();
            if (intval($check_refaccion[0]->EXISTE) === 0) {
                $this->db->insert('refacciones', array(
                    'Codigo' => $x['CODIGO'], 'Descripcion' => $x['DESCRIPCION'],
                    'FechaAlta' => $x['FECHA_ALTA'], 'Costo' => $x['COSTO'],
                    'Departamento' => $x['DEPARTAMENTO'],
                    'DepartamentoT' => $x['DEPARTAMENTOT'],
                    'ProveedorUno' => $x['PROVEEDOR_UNO'],
                    'ProveedorUnoT' => $x['PROVEEDOR_UNOT'],
                    'ProveedorDos' => $x['PROVEEDOR_DOS'],
                    'ProveedorDosT' => $x['PROVEEDOR_DOST'],
                    'ProveedorTres' => $x['PROVEEDOR_TRES'],
                    'ProveedorTresT' => $x['PROVEEDOR_TREST']
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
