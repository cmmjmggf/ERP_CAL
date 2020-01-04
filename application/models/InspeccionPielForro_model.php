
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class InspeccionPielForro_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onCerrarCaptura($Tp, $Fact, $Proveedor) {
        try {


            $this->db->where('Tp', $Tp)
                    ->where('Factura', $Fact)
                    ->where('Proveedor', $Proveedor)
                    ->update("recepcionmat_inspeccion", array('Estatus' => 'ACTIVO'));
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('ID', $ID);
            $this->db->delete("recepcionmat_inspeccion");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("recepcionmat_inspeccion", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords($Tp, $Fac, $Prov) {
        try {
            $this->db->select("RMI.ID, "
                            . "RMI.Articulo AS ClaveArt, "
                            . "A.Descripcion AS Articulo,"
                            . "RMI.Cantidad,"
                            . "RMI.CantidadDevuelta,"
                            . "D.Descripcion AS Defecto, "
                            . "DD.Descripcion AS DetalleDefecto,"
                            . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',RMI.ID,\')">\',\'</span>\') AS Eliminar'
                            . "")
                    ->from("recepcionmat_inspeccion AS RMI")
                    ->join("articulos AS A", 'ON A.Clave = RMI.Articulo')
                    ->join("defectos AS D", 'ON D.Clave = RMI.Defecto', 'left')
                    ->join("defectosdetalle AS DD", 'ON DD.Clave = RMI.DetalleDefecto', 'left')
                    ->where("RMI.Tp", $Tp)
                    ->where("RMI.Factura", $Fac)
                    ->where("RMI.Proveedor", $Prov)
                    ->where("RMI.Estatus", 'BORRADOR');
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

    public function getDetalleOrdenCompra($Tp, $Doc) {
        try {
            $this->db->select("OC.ID, "
                            . "OC.Articulo AS ClaveArt, "
                            . "A.Descripcion AS Articulo,"
                            . "OC.CantidadRecibida AS Recibida,"
                            . "OC.Factura,"
                            . "OC.Cantidad,"
                            . "OC.Precio, "
                            . "OC.SubTotal,"
                            . "OC.Sem "
                            . "")
                    ->from("ordencompra AS OC")
                    ->join("articulos AS A", 'ON A.Clave = OC.Articulo')
                    ->where("OC.Folio", $Doc)
                    ->where("OC.Tp", $Tp)
                    ->where("OC.Tipo", '10');
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

    public function onVerificarExisteFactura($Tp, $Doc) {
        try {
            $this->db->select("RM.* "
                            . "")
                    ->from("recepcionmat_inspeccion AS RM")
                    ->where("RM.Factura", $Doc)
                    ->where("RM.Tp", $Tp);
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

    public function onVerificarExisteOrdenCompra($Tp, $Doc) {
        try {
            $this->db->select("OC.* , P.NombreI, P.NombreF "
                            . "")
                    ->from("ordencompra AS OC")
                    ->join("proveedores AS P", 'ON P.Clave = OC.Proveedor')
                    ->where("OC.Folio", $Doc)
                    ->where("OC.Tp", $Tp)
                    ->where("OC.Tipo", '10');
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

    public function getDefectos() {
        try {
            return $this->db->select("T.Clave,CONCAT(T.Clave,'-',T.Descripcion) AS Defecto")->from("defectos AS T")->where("T.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetallesDefectos() {
        try {
            return $this->db->select("T.Clave,CONCAT(T.Clave,'-',T.Descripcion) AS DetalleDefecto")->from("defectosdetalle AS T")->where("T.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function getProveedoresReporteInspeccion($Prov, $Factura, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ClaveNum,  "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS Proveedor "
                                    . " ", false)
                            ->from("recepcionmat_inspeccion AS RI")
                            ->join("proveedores AS P", 'ON P.Clave =  RI.Proveedor')
                            ->like("RI.Tp", $Tp)
                            ->like("RI.Proveedor", $Prov)
                            ->like("RI.Factura", $Factura)
                            ->where_in("RI.Estatus", array('ACTIVO'))
                            ->group_by("P.Clave")
                            ->order_by("ClaveNum", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosByProveedor($Prov, $Factura, $Tp) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(RI.Proveedor AS SIGNED ) AS ClaveNum,  "
                                    . "RI.OrdenCompra,"
                                    . "RI.Factura,"
                                    . "RI.Articulo,"
                                    . "A.Descripcion As ArtDesc,"
                                    . "RI.Articulo,"
                                    . "RI.Precio,"
                                    . "RI.Cantidad,"
                                    . "RI.CantidadDevuelta,"
                                    . "(RI.Cantidad - RI.CantidadDevuelta) AS Cant_Real,"
                                    . "RI.Aprovechamiento,"
                                    . "RI.NumHojas,"
                                    . "(RI.Cantidad - RI.CantidadDevuelta) / RI.NumHojas AS Por_Hoj ,"
                                    . "RI.HojasRevisadas,"
                                    . "D.Descripcion AS Defecto,"
                                    . "RI.Primera,"
                                    . "RI.Segunda,"
                                    . "RI.Tercera,"
                                    . "RI.Cuarta,"
                                    . "RI.PartidaIni,"
                                    . "RI.PartidaFin "
                                    . " ", false)
                            ->from("recepcionmat_inspeccion AS RI")
                            ->join("articulos AS A", "ON RI.Articulo = A.Clave ")
                            ->join("defectos AS D", "ON RI.Defecto = D.Clave ", "left")
                            ->like("RI.Tp", $Tp)
                            ->like("RI.Proveedor", $Prov)
                            ->like("RI.Factura", $Factura)
                            ->where_in("RI.Estatus", array('ACTIVO'))
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("RI.Factura", 'ASC')
                            ->order_by("RI.Articulo", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
