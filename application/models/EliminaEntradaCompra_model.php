<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class EliminaEntradaCompra_model extends CI_Model {

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

    public function onRevisarDoctoCartProv($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("CP.Pagos_Doc, CP.Estatus_Contable "
                            . "")
                    ->from("cartera_proveedores AS CP")
                    ->where("CP.Doc", $Doc)
                    ->where("CP.Tp", $Tp)
                    ->where("CP.Proveedor", $Proveedor);
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

    public function onRevisarDoctoCompra($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("CP.* "
                            . "")
                    ->from("compras AS CP")
                    ->where("CP.Doc", $Doc)
                    ->where("CP.Tp", $Tp)
                    ->where("CP.Proveedor", $Proveedor);
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

    public function onEliminarCartProv($Doc, $Tp, $Prov) {
        try {
            $this->db->where('Doc', $Doc)
                    ->where('Tp', $Tp)
                    ->where('Proveedor', $Prov)
                    ->delete("cartera_proveedores");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarCompra($Doc, $Tp, $Prov) {
        try {
            $this->db->where('Doc', $Doc)
                    ->where('Tp', $Tp)
                    ->where('Proveedor', $Prov)
                    ->delete("compras");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarMovArt($Doc, $Tp, $Prov) {
        try {
            $this->db->where('DocMov', $Doc)
                    ->where('Tp', $Tp)
                    ->where('Proveedor', $Prov)
                    ->delete("movarticulos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCompra($Doc, $Tp, $Proveedor) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("C.Articulo, "
                            . "sum(C.Cantidad) AS Cantidad,"
                            . "C.OrdenCompra,"
                            . "C.TpOrdenCompra,"
                            . "sum(C.Cantidad) * Precio AS Subtotal "
                            . "")
                    ->from("compras C")
                    ->join("articulos A", 'ON A.Clave = C.Articulo')
                    ->where("C.Tp", $Tp)
                    ->where("C.Doc", $Doc)
                    ->where("C.Proveedor", $Proveedor)
                    ->group_by("C.TpOrdenCompra", "C.OrdenCompra", "C.Articulo");
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

    public function onActualizarCantidadesOrdenCompra($Doc, $Tp, $Folio, $Prov, $Art, $cant_restada) {
        try {

            $sql = "UPDATE ordencompra OC "
                    . "SET OC.CantidadRecibida =  ifnull(OC.CantidadRecibida,0) - $cant_restada , "
                    . "OC.Factura = '' , "
                    . "OC.FechaFactura = '' "
                    . "WHERE OC.Tp = '$Tp' "
                    . "AND OC.Folio = '$Folio' "
                    . "AND OC.Proveedor = '$Prov' "
                    . "AND OC.Factura = '$Doc' "
                    . "AND OC.Articulo = '$Art' ";
            //print ($sql);
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCantidadesParaEstatus($Tp, $Folio) {
        try {
            $this->db->select("OC.ID, OC.Cantidad AS Cantidad, OC.CantidadRecibida AS Cantidad_Rec "
                            . "")
                    ->from("ordencompra OC")
                    ->where("OC.Tp", $Tp)
                    ->where("OC.Folio", $Folio);
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

    public function onModificarEstatusOrdenCompra($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)
                    ->update("ordencompra", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
