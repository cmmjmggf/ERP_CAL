<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Recibeordencompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Folio, $Tp) {
        try {
            $this->db->select(""
                    . "OC.ID,"
                    . "OC.Tp,"
                    . "OC.Folio, "
                    . "CONCAT(A.Descripcion) AS Articulo, "
                    . "OC.Cantidad, "
                    . "ifnull(OC.CantidadRecibida,'') AS Recibida, "
                    . "OC.Precio, "
                    . "OC.Subtotal,"
                    . "OC.Maq, "
                    . "OC.Sem, "
                    . "OC.Ano, "
                    . "OC.Tipo, "
                    . "OC.Articulo AS ClaveArticulo "
                    . "", false);
            $this->db->from("ordencompra OC");
            $this->db->join("articulos A", "A.Clave = OC.Articulo ");
            $this->db->where_in('OC.Estatus', array('PENDIENTE', 'ACTIVA'));
            $this->db->where('OC.Folio', $Folio);
            $this->db->where('OC.Tp', $Tp);
            $this->db->order_by('A.Descripcion', 'ASC');
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

    public function getOrdenCompra($Folio, $Tp) {
        try {
            $this->db->select("G.FechaOrden, G.Proveedor, G.Maq, "
                            . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                            . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF "
                            . "")
                    ->from("ordencompra AS G")
                    ->join("proveedores AS P", 'ON P.Clave = G.Proveedor')
                    ->where("G.Folio", $Folio)
                    ->where("G.Tp", $Tp)
                    ->where_in("G.Estatus", array("PENDIENTE", "ACTIVA"));
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

    public function onVerificarExisteCompra($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("C.Doc, C.FechaDoc, C.Estatus "
                            . "")
                    ->from("compras AS C")
                    ->where("C.Doc", $Doc)
                    ->where("C.Tp", $Tp)
                    ->where("C.Proveedor", $Proveedor)
                    ->where_in("C.Estatus", array("BORRADOR", "CONCLUIDA"))
                    ->group_by("C.Doc");
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

    public function getArticuloByTpByOC($Articulo, $Tp, $Oc) {
        try {
            $this->db->select("A.Clave, A.Descripcion, OC.Precio, "
                            . "OC.Subtotal, "
                            . "OC.Maq, "
                            . "OC.Sem, "
                            . "OC.Ano, "
                            . "OC.Tipo, "
                            . "OC.Tp  "
                            . "")
                    ->from("ordencompra OC")
                    ->join("articulos A", 'ON A.Clave =  OC.Articulo')
                    ->where("OC.Articulo", $Articulo)
                    ->where("OC.Tp", $Tp)
                    ->where("OC.Folio", $Oc);
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

    public function getCompraParaMovArt($Factura, $Tp, $Proveedor) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("C.Articulo, "
                            . "A.Descripcion AS DescArticulo,"
                            . "U.Descripcion AS Unidad,"
                            . "C.Precio, "
                            . "sum(C.Cantidad) AS Cantidad,"
                            . "C.Proveedor AS ClaveProv,"
                            . "C.FechaDoc,"
                            . "C.Doc,"
                            . "C.Tp,"
                            . "C.Maq,"
                            . "C.Sem,"
                            . "C.Ano,"
                            . "C.OrdenCompra,"
                            . "CASE WHEN C.Tp ='1' THEN  CONCAT(P.Clave,' ',P.NombreF) ELSE "
                            . "CONCAT(P.Clave,' ',P.NombreI) END AS Proveedor, "
                            . "sum(C.Cantidad) * Precio AS Subtotal "
                            . "")
                    ->from("compras C")
                    ->join("proveedores P", 'ON P.Clave = C.Proveedor')
                    ->join("articulos A", 'ON A.Clave = C.Articulo')
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("C.Tp", $Tp)
                    ->where("C.Doc", $Factura)
                    ->where("C.Proveedor", $Proveedor)
                    ->group_by("C.OrdenCompra")
                    ->group_by("C.Articulo");
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

    public function getMovArtSalida($Doc_Salida, $Tp) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("C.Articulo, "
                            . "A.Descripcion AS DescArticulo,"
                            . "U.Descripcion AS Unidad,"
                            . "C.PrecioMov AS Precio, "
                            . "CantidadMov AS Cantidad,"
                            . "C.FechaMov AS FechaDoc,"
                            . "C.DocMov AS Doc,"
                            . "C.OrdenCompra AS DocCompra,"
                            . "C.Tp,"
                            . "C.Maq,"
                            . "C.Sem,"
                            . "C.Subtotal AS Subtotal "
                            . "")
                    ->from("movarticulos C")
                    ->join("articulos A", 'ON A.Clave = C.Articulo')
                    ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                    ->where("C.Tp", $Tp)
                    ->where("C.DocMov", $Doc_Salida)
                    ->where("C.EntradaSalida", '2');
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

    public function getCompraParaCartProv($Factura, $Tp, $Proveedor) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("C.Proveedor, "
                            . "C.Doc,"
                            . "C.FechaDoc, "
                            . "SUM(C.Subtotal) AS Importe, "
                            . "C.Tp, "
                            . "C.Departamento "
                            . "")
                    ->from("compras C")
                    ->where("C.Tp", $Tp)
                    ->where("C.Doc", $Factura)
                    ->where("C.Proveedor", $Proveedor)
                    ->group_by("C.Doc");
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

    public function onModificarEstatusCompra($Doc, $Tp, $Proveedor) {
        try {
            $this->db->set('Estatus', 'CONCLUIDA')
                    ->where('Tp', $Tp)
                    ->where('Doc', $Doc)
                    ->where("Proveedor", $Proveedor)
                    ->update("compras");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("compras", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarMovArt($array) {
        try {
            $this->db->insert("movarticulos", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarMovArtFabrica($array) {
        try {
            $this->db->insert("movarticulos_fabrica", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarCartProv($array) {
        try {
            $this->db->insert("cartera_proveedores", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* ORDENES DE COMPRA */

    public function onModificar($ID, $DATA) {
        try {

            $can_rec = $DATA{'CantidadRecibida'};
            $Fac = $DATA{'Factura'};
            $FechaFac = $DATA{'FechaFactura'};
            $sql = "UPDATE ordencompra OC "
                    . "SET OC.CantidadRecibida = $can_rec + ifnull(OC.CantidadRecibida,0), "
                    . "OC.Factura = '$Fac', "
                    . "OC.FechaFactura = '$FechaFac' "
                    . "WHERE OC.ID = '$ID' ";
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarCantidadRecibidaByArtByOCByTp($Art, $OC, $Tp, $DATA) {
        try {
            $can_rec = $DATA{'CantidadRecibida'};
            $Fac = $DATA{'Factura'};
            $FechaFac = $DATA{'FechaFactura'};
            $sql = "UPDATE ordencompra OC "
                    . "SET OC.CantidadRecibida = $can_rec + ifnull(OC.CantidadRecibida,0), "
                    . "OC.Factura = '$Fac', "
                    . "OC.FechaFactura = '$FechaFac' "
                    . "WHERE OC.Tp = '$Tp' "
                    . "AND OC.Folio = '$OC' "
                    . "AND OC.Articulo = '$Art'";
            //print ($sql);
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCantidadesParaEstatus($Tp, $Folio) {
        try {
            $this->db->select("OC.ID, ifnull(OC.Cantidad,0)  AS Cantidad, ifnull(OC.CantidadRecibida,0) AS Cantidad_Rec "
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
