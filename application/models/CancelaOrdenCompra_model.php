<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class CancelaOrdenCompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Tp, $Folio) {
        try {
            $this->db->select(""
                    . "OC.Articulo AS Clave, "
                    . "A.Descripcion AS Articulo, "
                    . "OC.Cantidad, "
                    . "OC.Precio, "
                    . "OC.SubTotal, "
                    . "OC.FechaOrden AS Fecha,"
                    . "CONCAT(OC.Proveedor,' - ', P.NombreF ) AS Proveedor"
                    . "", false);
            $this->db->from("ordencompra OC");
            $this->db->join("articulos A", "A.Clave = OC.Articulo ");
            $this->db->join("proveedores P", "P.Clave = OC.Proveedor ");
            $this->db->where("OC.Tp", $Tp);
            $this->db->where("OC.Folio", $Folio);
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

    public function onVerificarExisteOrdenCompra($Tp, $Folio) {
        try {
            $this->db->select(""
                    . "OC.Estatus "
                    . "", false);
            $this->db->from("ordencompra OC");
            $this->db->where("OC.Tp", $Tp);
            $this->db->where("OC.Folio", $Folio);
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

    public function onCancelarOrden($Tp, $Folio) {
        try {
            $this->db->set('Estatus', 'CANCELADA')
                    ->where('Tp', $Tp)
                    ->where('Folio', $Folio)
                    ->update("ordencompra");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
