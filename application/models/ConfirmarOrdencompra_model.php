<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ConfirmarOrdencompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("OC.ID AS ID, "
                                    . "OC.Tp AS Tp, "
                                    . "CASE WHEN OC.Tipo = '10' THEN '10 PIEL Y FORRO' "
                                    . "WHEN OC.Tipo = '80' THEN '80 SUELAS' "
                                    . "ELSE '90 PELETERIA' END AS Tipo,"
                                    . "OC.Folio AS Folio, "
                                    . "CASE WHEN OC.Tp ='1' THEN  CONCAT(P.Clave,'-',P.NombreF) ELSE "
                                    . "CONCAT(P.Clave,'-',P.NombreI) END AS Proveedor, "
                                    . "OC.FechaOrden AS FechaOrden, "
                                    . "OC.FechaEntrega AS FechaEnt, "
                                    . "OC.FechaConf AS FechaConf, "
                                    . "OC.ObservacionesConf AS ObsConf "
                                    . "", false)
                            ->from("ordencompra AS OC")
                            ->join("proveedores AS P", 'P.Clave =  OC.Proveedor')
                            ->where_in('OC.Estatus', array('ACTIVA'))
                            ->group_by('OC.Tp')
                            ->group_by('OC.Folio')
                            ->get()->result();
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

    public function onModificar($Tp, $Folio, $DATA) {
        try {
            $this->db->where('Tp', $Tp)->where('Folio', $Folio)->update("ordencompra", $DATA);
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

    public function getReporteConfirmacionOrdenCompra($Año, $Sem, $Maq, $Tipo) {
        try {
            $this->db->select(''
                    . 'OC.Folio,'
                    . 'OC.FechaOrden,'
                    . 'OC.FechaEntrega,'
                    . "IFNULL(OC.FechaConf,'') AS FechaConf,"
                    . "OC.Proveedor,"
                    . "CASE WHEN OC.Tp ='1' THEN  P.NombreF ELSE "
                    . "P.NombreI END AS NombreProveedor, "
                    . "IFNULL(OC.ObservacionesConf,'') AS ObservacionesConf,"
                    . 'IFNULL(DATEDIFF(STR_TO_DATE( OC.FechaConf , "%d/%m/%Y" ), STR_TO_DATE( OC.FechaOrden , "%d/%m/%Y" )),\'\') AS Dias,'
                    . 'IFNULL(DATEDIFF(STR_TO_DATE( OC.FechaConf , "%d/%m/%Y" ), STR_TO_DATE( OC.FechaEntrega , "%d/%m/%Y" )),\'\') AS Dias2,'
                    . '', false);
            $this->db->from('ordencompra AS OC')
                    ->join('proveedores AS P', 'OC.Proveedor = P.Clave')
                    ->where('OC.Ano', $Año)
                    ->where('OC.Sem', $Sem)
                    ->where('OC.Maq', $Maq)
                    ->where('OC.Tipo', $Tipo)
                    ->where_in('OC.Estatus', array('ACTIVA'))
                    ->group_by('OC.Tp', 'OC.Folio')
                    ->order_by('OC.Folio', 'ASC');
//                    ->where('OC.Tp', $TP);
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
