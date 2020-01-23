<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class MaterialRecibido_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($Ano, $Tp, $Tipo) {
        try {
            $this->db->select("OC.ID,"
                            . "OC.Tp, "
                            . "OC.Folio, "
                            . "OC.Proveedor, "
                            . "CASE WHEN OC.Tp ='1' THEN  CONCAT(P.Clave,' ',P.NombreF) "
                            . "ELSE CONCAT(P.Clave,' ',P.NombreI) END AS NombreProveedor, "
                            . "CASE WHEN OC.Tp ='1' THEN  "
                            . "CONCAT('[Ord_Compra: ',OC.Folio,']----->    Prov. ',OC.Proveedor,' ',P.NombreF) "
                            . "ELSE "
                            . "CONCAT('[Ord_Compra: ',OC.Folio,']----->    Prov. ',OC.Proveedor,' ',P.NombreI) "
                            . "END AS GruposT, "
                            . "OC.FechaOrden, "
                            . "OC.FechaEntrega, "
                            . "OC.FechaFactura, "
                            . "CONCAT(A.Clave,' ',A.Descripcion) AS Articulo, "
                            . "OC.Cantidad, "
                            . "OC.CantidadRecibida, "
                            . "OC.Precio, "
                            . "OC.SubTotal, "
                            . "OC.Sem, "
                            . "OC.Maq, "
                            . "CONCAT(G.Clave,'-',G.Nombre) AS Grupo,"
                            . "OC.Ano,"
                            . "OC.Tipo, "
                            . "(CASE "
                            . "WHEN  OC.Estatus ='ACTIVA' THEN CONCAT('<span class=\'badge badge-info\'>','ACTIVA','</span>') "
                            . "WHEN  OC.Estatus ='PENDIENTE' THEN CONCAT('<span class=\'badge badge-warning\'>','PENDIENTE','</span>')"
                            . "WHEN  OC.Estatus ='RECIBIDA' THEN CONCAT('<span class=\'badge badge-success\'>','RECIBIDA','</span>')"
                            . "WHEN  OC.Estatus ='CANCELADA' THEN CONCAT('<span class=\'badge badge-danger\'>','CANCELADA','</span>')"
                            . "WHEN  OC.Estatus ='INACTIVA' THEN CONCAT('<span class=\'badge badge-secondary\'>','INACTIVA','</span>')"
                            . " END) AS Estatus "
                            . "", false)
                    ->from("ordencompra AS OC")
                    ->join("proveedores P", 'ON P.Clave = OC.Proveedor')
                    ->join("articulos A", 'ON A.Clave = OC.Articulo')
                    ->join("grupos G", 'ON G.Clave =  A.Grupo')
                    ->join("unidades U", 'ON U.Clave =  A.UnidadMedida')
                    ->where('OC.Ano', $Ano)
                    ->where('OC.Tp', $Tp)
                    ->where('OC.Tipo', $Tipo)
                    ->where_in('OC.Estatus', array('ACTIVA', 'PENDIENTE', 'RECIBIDA', 'CANCELADA', 'INACTIVA'));
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

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("ordencompra", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function getDatosEmpresa() {
        try {
            $this->db->select("E.RazonSocial as Empresa, E.Foto as Logo,"
                            . "CONCAT(E.Direccion,' ',E.NoExt,' Col. ',E.Colonia) AS Direccion, "
                            . "CONCAT(E.Ciudad,', ',EDOS.Descripcion,'  Tel. 1464646 AL 49   E-mail: compras@lobosolo.com.mx') AS Direccion2 "
                            . " ", false)
                    ->from('empresas AS E')
                    ->join('estados AS EDOS', 'EDOS.Clave = E.Estado');

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
