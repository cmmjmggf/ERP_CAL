<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class NotasCargo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($nc, $tp, $prov) {
        try {
            return $this->db->select("NC.ID, "
                                    . "A.Clave, "
                                    . "A.Descripcion, "
                                    . "NC.Cantidad, "
                                    . "NC.Precio, "
                                    . "NC.Subtotal, "
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',NC.ID,\')">\',\'</span>\') AS Eliminar'
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->join("articulos A", 'ON NC.Articulo = A.Clave')
                            ->where('NC.Proveedor', $prov)
                            ->where('NC.Folio', $nc)
                            ->where('NC.Tp', $tp)
                            ->where('NC.Estatus', '1')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecordsDirecto($nc, $tp, $prov) {
        try {
            return $this->db->select("NC.ID, "
                                    . "NC.Articulo as Clave, "
                                    . "NC.Concepto as Descripcion, "
                                    . "NC.Cantidad, "
                                    . "NC.Precio, "
                                    . "NC.Subtotal, "
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',NC.ID,\')">\',\'</span>\') AS Eliminar'
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->where('NC.Proveedor', $prov)
                            ->where('NC.Folio', $nc)
                            ->where('NC.Tp', $tp)
                            ->where('NC.Estatus', '1')
                            ->get()->result();
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
                    . "WHEN ifnull(Saldo_Doc,0) <= 1 THEN 'PAGADO' ELSE 'PENDIENTE' END "
                    . "WHERE Proveedor= '$Prov' "
                    . "AND Tp = '$Tp' "
                    . "AND Doc = '$Doc' ";
            $this->db->query($sql2);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarNotaCredito($tp, $nc, $prov, $CantidadLetra) {
        try {
            $this->db->set('Estatus', 2)
                    ->set('CantidadLetra', $CantidadLetra)
                    ->where('Tp', $tp)
                    ->where('Folio', $nc)
                    ->where('Proveedor', $prov)
                    ->update("notascreditoprov");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarPagoProveedor($array) {
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

    public function getRegistrosParaFinalizar($tp, $nc, $prov) {
        try {
            return $this->db->select("NC.ID, "
                                    . "NC.Proveedor, "
                                    . "NC.DocCartProv, "
                                    . "NC.Fecha, "
                                    . "A.Clave, "
                                    . "A.Descripcion, "
                                    . "NC.Cantidad, "
                                    . "NC.Precio, "
                                    . "NC.Subtotal "
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->join("articulos A", 'ON NC.Articulo = A.Clave')
                            ->where('NC.Proveedor', $prov)
                            ->where('NC.Folio', $nc)
                            ->where('NC.Tp', $tp)
                            ->where_in("NC.Estatus", '1')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistrosParaFinalizarDirecto($tp, $nc, $prov) {
        try {
            return $this->db->select("NC.ID, "
                                    . "NC.Proveedor, "
                                    . "NC.DocCartProv, "
                                    . "NC.Fecha, "
                                    . "NC.Cantidad, "
                                    . "NC.Precio, "
                                    . "NC.Subtotal "
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->where('NC.Proveedor', $prov)
                            ->where('NC.Folio', $nc)
                            ->where('NC.Tp', $tp)
                            ->where_in("NC.Estatus", '1')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotaCreditoParaReporte($Tp, $Folio, $Proveedor) {
        try {
            return $this->db->select("NC.ID, "
                                    . "NC.Proveedor, "
                                    . "CASE WHEN NC.Tp = '1' THEN P.NombreF ELSE P.NombreI END AS NombreProv, "
                                    . "NC.DocCartProv, "
                                    . "NC.Fecha, "
                                    . "NC.CantidadLetra, "
                                    . "NC.Concepto, "
                                    . "A.Clave, "
                                    . "A.Descripcion, "
                                    . "NC.Cantidad, "
                                    . "U.Descripcion as Unidad,"
                                    . "NC.Precio, "
                                    . "NC.Subtotal "
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->join("articulos A", 'ON NC.Articulo = A.Clave')
                            ->join("proveedores P", 'ON P.Clave = NC.Proveedor')
                            ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                            ->where('NC.Proveedor', $Proveedor)
                            ->where('NC.Folio', $Folio)
                            ->where('NC.Tp', $Tp)
                            ->where('NC.Estatus', '2')
                            ->order_by("A.Descripcion", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotaCreditoDirectaParaReporte($Tp, $Folio, $Proveedor) {
        try {
            return $this->db->select("NC.ID, "
                                    . "NC.Proveedor, "
                                    . "CASE WHEN NC.Tp = '1' THEN P.NombreF ELSE P.NombreI END AS NombreProv, "
                                    . "NC.DocCartProv, "
                                    . "NC.Fecha, "
                                    . "NC.CantidadLetra, "
                                    . "NC.Concepto, "
                                    . "'' AS Clave, "
                                    . "NC.Concepto AS Descripcion, "
                                    . "NC.Cantidad, "
                                    . "'DESC' as Unidad,"
                                    . "NC.Precio, "
                                    . "NC.Subtotal "
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->join("proveedores P", 'ON P.Clave = NC.Proveedor')
                            ->where('NC.Proveedor', $Proveedor)
                            ->where('NC.Folio', $Folio)
                            ->where('NC.Tp', $Tp)
                            ->where('NC.Estatus', '2')
                            ->order_by("NC.ID", 'DESC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioByTp($Tp) {
        try {
            $this->db->select("CAST(NC.Folio AS SIGNED ) AS Folio "
                            . "")
                    ->from("notascreditoprov AS NC")
                    ->where("NC.Tp", $Tp)
                    ->order_by("Folio", 'DESC')
                    ->limit(1);
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

    public function onAgregarNotaCredito($array) {
        try {
            $this->db->insert("notascreditoprov", $array);
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

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('ID', $ID);
            $this->db->delete("notascreditoprov");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosArticuloCompra($Tp, $Doc, $Proveedor, $Articulo) {
        try {
            $this->db->select(" "
                            . "C.Cantidad, "
                            . "U.Descripcion AS Unidad , "
                            . "C.Precio, "
                            . "C.Subtotal "
                            . ' '
                            . "")
                    ->from("compras AS C")
                    ->join("articulos A", 'ON C.Articulo = A.Clave')
                    ->join("unidades U", 'ON U.Clave =  A.UnidadMedida')
                    ->where("C.Doc", $Doc)
                    ->where("C.Tp", $Tp)
                    ->where("C.Proveedor", $Proveedor)
                    ->where("C.Articulo", $Articulo);
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

    public function getArticulosDocProvTp($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("CAST(A.Clave AS SIGNED ) AS Clave, "
                            . "A.Descripcion, "
                            . "C.Cantidad, "
                            . "(select descripcion from unidades where clave = a.unidadmedida) as Unidad,"
                            . "C.Precio, "
                            . "C.Subtotal "
                            . ' '
                            . "")
                    ->from("compras AS C")
                    ->join("articulos A", 'ON C.Articulo = A.Clave')
                    ->where("C.Doc", $Doc)
                    ->where("C.Tp", $Tp)
                    ->where("C.Proveedor", $Proveedor)
                    ->order_by("Clave", 'ASC');
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

    public function onVerificarExisteDocumento($Doc, $Tp, $Proveedor) {
        try {
            $this->db->select("C.* , "
                    . 'IFNULL(DATEDIFF(CURDATE(), STR_TO_DATE( C.FechaDoc , "%d/%m/%Y" )),\'\') AS Dias '
                    . "")->from("cartera_proveedores AS C")->where("C.Doc", $Doc)->where("C.Tp", $Tp)->where("C.Proveedor", $Proveedor);
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
                    . "")->from("cartera_proveedores AS C")->where("C.Tp", $Tp)->where_in("C.Estatus", array('SIN PAGAR', 'PENDIENTE'))->where("C.Proveedor", $Proveedor)->order_by('DOC_F', 'ASC');
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

    public function getNotasByTpByProveedor($Tp, $Proveedor) {
        try {
            $this->db->select("CONVERT(C.Folio, UNSIGNED INTEGER) AS Nota  "
                            . "")
                    ->from("notascreditoprov AS C")
                    ->where("C.Tp", $Tp)
                    ->where_in("C.Estatus", array('2'))
                    ->where("C.Proveedor", $Proveedor)
                    ->group_by('C.Folio')
                    ->order_by('Nota', 'ASC');
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
                            . "CONCAT(IFNULL(P.NombreI,'')) AS ProveedorI, "
                            . "CONCAT(IFNULL(P.NombreF,'')) AS ProveedorF ", false)->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresConClave() {
        try {
            return $this->db->select("P.Clave AS ID, "
                            . "CONCAT(P.Clave,' ',P.NombreI) AS ProveedorI, "
                            . "CONCAT(P.Clave,' ',P.NombreF) AS ProveedorF ", false)->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* CANCELA NOTA CREDITO */

    public function getRegistrosParaCancelar($tp, $nc, $prov) {
        try {
            return $this->db->select("NC.* "
                                    . "", false)
                            ->from("notascreditoprov NC")
                            ->where('NC.Proveedor', $prov)
                            ->where('NC.Folio', $nc)
                            ->where('NC.Tp', $tp)
                            ->where('NC.Estatus', '2')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarNotaCredito($tp, $nc, $prov) {
        try {
            $this->db->set('Estatus', 3)
                    ->set('Cantidad', 0)
                    ->set('Subtotal', 0)
                    ->where('Tp', $tp)
                    ->where('Folio', $nc)
                    ->where('Proveedor', $prov)
                    ->update("notascreditoprov");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarPagoProv($tp, $nc, $prov) {
        try {
            $this->db->set('Estatus', 'CANCELADO')
                    ->set('Importe', 0)
                    ->where('Tp', $tp)
                    ->where('NotaCredito', $nc)
                    ->where('Proveedor', $prov)
                    ->update("pagosproveedores");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarMovArt($tp, $nc, $prov) {
        try {
            $this->db->set('CantidadMov', 0)
                    ->set('Subtotal', 0)
                    ->where('TipoMov', 'SXO')
                    ->where('Tp', $tp)
                    ->where('DocMov', $nc)
                    ->where('Proveedor', $prov)
                    ->update("movarticulos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRegresarSaldoCartera($DATA) {
        try {

            $Prov = $DATA{'Proveedor'};
            $Doc = $DATA{'Factura'};
            $Pago = $DATA{'Importe'};
            $Tp = $DATA{'Tp'};
            $sql = "UPDATE cartera_proveedores CP "
                    . "SET CP.Saldo_Doc = ifnull(CP.Saldo_Doc,0) + $Pago  , "
                    . "CP.Pagos_Doc = ifnull(CP.Pagos_Doc,0) - $Pago  "
                    . "WHERE CP.Proveedor= '$Prov' "
                    . "AND CP.Tp = '$Tp' "
                    . "AND CP.Doc = '$Doc' "
                    . "";
            $this->db->query($sql);

            $sql2 = "UPDATE cartera_proveedores "
                    . "SET Estatus = CASE "
                    . "WHEN ifnull(Saldo_Doc,0) <= 1 THEN 'PAGADO' ELSE 'PENDIENTE' END "
                    . "WHERE Proveedor= '$Prov' "
                    . "AND Tp = '$Tp' "
                    . "AND Doc = '$Doc' ";
            $this->db->query($sql2);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
