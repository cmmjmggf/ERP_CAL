<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class PagosProveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProveedores() {
        try {
            return $this->db->select("P.Clave AS ID, "
                                    . "CONCAT(IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getBancos($Tp) {
        try {
            return $this->db->select("G.Clave AS ID, CONCAT(IFNULL(G.Nombre,'')) AS Banco", false)
                            ->from("bancos AS G")->where("G.Tp", $Tp)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("pagosproveedores", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarSaldoCartera($DATA) {
        try {

            $Prov = $DATA{'Proveedor'};
            $Doc = $DATA{'Factura'};
            $Pago = $DATA{'Importe'};
            $Tp = $DATA{'Tp'};
            $sql = "UPDATE cartera_proveedores CP "
                    . "SET CP.Saldo_Doc = ifnull(CP.Saldo_Doc,0) - $Pago  , "
                    . "CP.Pagos_Doc = ifnull(CP.Pagos_Doc,0) + $Pago  "
                    . "WHERE CP.Proveedor= '$Prov' "
                    . "AND CP.Tp = '$Tp' "
                    . "AND CP.Doc = '$Doc' "
                    . "";
            $this->db->query($sql);

            $sql2 = "UPDATE cartera_proveedores "
                    . "SET Estatus = CASE "
                    . "WHEN ifnull(Saldo_Doc,0) <= 0 THEN 'PAGADO' ELSE 'PENDIENTE' END "
                    . "WHERE Proveedor= '$Prov' "
                    . "AND Tp = '$Tp' "
                    . "AND Doc = '$Doc' ";
            $this->db->query($sql2);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("C.* , "
                            . 'IFNULL(DATEDIFF(CURDATE(), STR_TO_DATE( C.FechaDoc , "%d/%m/%Y" )),\'\') AS Dias '
                            . "")
                    ->from("cartera_proveedores AS C")
                    ->where("C.Doc", $Doc)
                    ->where("C.Tp", $Tp)
                    ->where("C.Proveedor", $Proveedor);
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

    public function getDocumentosByTpByProveedor($Tp, $Proveedor) {
        try {
            $this->db->select("CONVERT(C.Doc, UNSIGNED INTEGER) AS DOC_F , C.* "
                            . "")
                    ->from("cartera_proveedores AS C")
                    ->where("C.Tp", $Tp)
                    ->where_in("C.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                    ->where("C.Proveedor", $Proveedor)->order_by('DOC_F', 'ASC');
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

}
