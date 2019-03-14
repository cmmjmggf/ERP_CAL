<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class MovimientosProveedor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Prov) {
        try {
            $this->db->select(" "
                    . "CP.Tp, "
                    . "CP.Doc, "
                    . "PP.Fecha, "
                    . "PP.DocPago, "
                    . "PP.Importe, "
                    . "CASE "
                    . "WHEN PP.TipoPago = '1' THEN 'EFECTIVO' "
                    . "WHEN PP.TipoPago = '2' THEN 'TRANSFERENCIA' "
                    . "WHEN PP.TipoPago = '3' THEN 'CHEQUE' "
                    . "WHEN PP.TipoPago = '4' THEN 'DESC. SIN COMPROBANTE' "
                    . "WHEN PP.TipoPago = '5' THEN 'DEVOLUCIÓN' "
                    . "WHEN PP.TipoPago = '6' THEN 'CARGOS' "
                    . "END AS TipoPago,"
                    . "CP.Estatus, "
                    . "CP.FechaDoc, "
                    . "FORMAT(CP.ImporteDoc,2) AS ImporteDoc, "
                    . "FORMAT(CP.Pagos_Doc,2) AS Pagos_Doc, "
                    . "FORMAT(CP.Saldo_Doc,2) AS Saldo_Doc "
                    . " "
                    . "", false);
            $this->db->from("cartera_proveedores CP");
            $this->db->join("pagosproveedores PP", "ON PP.Factura = CP.Doc AND CP.Tp =  PP.Tp AND CP.Proveedor = PP.Proveedor");
            $this->db->join("proveedores P", "ON CP.Proveedor = P.Clave");
            $this->db->where("CP.Proveedor", $Prov);
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

    public function getProveedores() {
        try {
            return $this->db->select("P.Clave AS ID, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
