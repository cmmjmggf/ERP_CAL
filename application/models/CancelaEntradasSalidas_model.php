<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CancelaEntradasSalidas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($DocMov, $Maq, $Sem, $Ano) {
        try {
            $this->db->select("MA.Articulo, "
                    . "A.Descripcion AS DescArticulo, "
                    . "MA.CantidadMov, "
                    . "MA.PrecioMov, "
                    . "MA.Subtotal, "
                    . "MA.FechaMov "
                    . "", false);
            $this->db->from("movarticulos MA");
            $this->db->join("articulos A", "A.Clave = MA.Articulo ");
            $this->db->where("MA.DocMov", $DocMov);
            $this->db->where("MA.Maq", $Maq);
            $this->db->where("MA.Sem", $Sem);
            $this->db->where("MA.Ano", $Ano);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("G.Clave, G.Direccion")->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion($Clave, $Ano) {
        try {
            return $this->db->select("G.Sem")->from("semanasproduccion AS G")->where("G.Sem", $Clave)->where("G.Ano", $Ano)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada($Ano, $Maq, $Sem) {
        try {
            $this->db->select("G.Estatus")->from("semanasproduccioncerradas AS G")
                    ->where("G.Ano", $Ano)
                    ->where("G.Maq", $Maq)
                    ->where("G.Sem", $Sem);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarDoctos($DocMov, $Maq, $sem, $Ano) {
        try {
            $this->db->set('CantidadMov', 0)
                    ->set('Subtotal', 0)
                    ->set('TipoMov', 'CAN')
                    ->where('DocMov', $DocMov)
                    ->where('Sem', $sem)
                    ->where('Maq', $Maq)
                    ->where('Ano', $Ano)
                    ->update("movarticulos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarDoctosFabrica($DocMov, $Maq, $sem, $Ano) {
        try {
            $this->db->set('CantidadMov', 0)
                    ->set('Subtotal', 0)
                    ->set('TipoMov', 'CAN')
                    ->where('DocMov', $DocMov)
                    ->where('Sem', $sem)
                    ->where('Ano', $Ano)
                    ->update("movarticulos_fabrica");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
