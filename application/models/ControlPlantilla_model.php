<?php

/**
 * Description of ControlPlantilla_model
 *
 * @author Y700
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ControlPlantilla_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select('CP.`ID`,
                                        CP.`Proveedor` AS PROVEEDOR,
                                        CP.`Tipo` AS ESTATUS,
                                        CP.`Documento` AS DOCUMENTO,
                                        CP.`Control` AS CONTROL,
                                        CP.`Estilo` AS ESTILO,
                                        CP.`Color` AS COLOR,
                                        CP.`Pares` AS PARES,
                                        CP.`Fraccion` AS FRACCION,
                                        CP.`FraccionT` AS FRACCIONT,
                                        CP.`Precio` AS PRECIO,
                                        CP.`Fecha` AS FECHA,
                                        CP.`Registro`,
                                        CP.`Estatus` AS ESTATUS,
                                        CONCAT("<button type=\"button\" class=\"btn btn-danger\" onclick=\"onEliminarControlPlantilla(",CP.ID,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN
', false)->from('controlpla AS CP')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresMaquilas() {
        try {
            return $this->db->select('PRM.numprv AS ID, PRM.nomprv AS PROVEEDOR', false)
                            ->from('provmaqui AS PRM')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            return $this->db->select('MP.Clave AS ID, MP.Descripcion AS MAQPLA', false)
                            ->from('maquilasplantillas AS MP')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl($CONTROL) {
        try {
            return $this->db->select("C.Estilo AS ESTILO, C.Color AS COLOR, C.Pares AS PARES", false)
                            ->from('controles as C')
                            ->where("C.Control", $CONTROL)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo($Estilo) {
        try {
            return $this->db->select("CAST(C.Clave AS SIGNED ) AS CLAVE, CONCAT(C.Clave,'-', C.Descripcion) AS COLOR ", false)
                            ->from('colores AS C')
                            ->where('C.Estilo', $Estilo)
                            ->where('C.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoDocumento($ANO, $MES, $DIA) {
        try {

            return $this->db->select("CP.Documento AS DOCTO_ANTERIOR, 
                CASE WHEN CP.Documento IS NULL THEN SUBSTRING(YEAR(NOW()),3,2) ELSE SUBSTRING(CP.Documento,1,2) END AS ANO, 
                CASE WHEN CP.Documento IS NULL THEN LPAD(MONTH(NOW()),2,0) ELSE SUBSTRING(CP.Documento,3,2) END AS MES, 
                CASE WHEN CP.Documento IS NULL THEN LPAD(DAY(NOW()),2,0) ELSE SUBSTRING(CP.Documento,5,2) END AS DIA,  
                CASE WHEN CP.Documento IS NULL THEN LPAD(1,3,0) ELSE SUBSTRING(CP.Documento + 1,7,3) END AS CONSECUTIVO,
                COUNT(CP.ID) AS VALID", false)
                            ->from('controlpla AS CP')
                            ->where("SUBSTRING(CP.Documento,1,2) = SUBSTRING({$ANO},3,2) "
                                    . "AND SUBSTRING(CP.Documento,3,2) = {$MES} "
                                    . "AND SUBSTRING(CP.Documento,5,2) = {$DIA} ", null, false)
                            ->order_by('CP.Documento', 'ASC')
                            ->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function getFraccionesXEstilo($ESTILO) {
        try {
            return $this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                            ->from('fracciones AS F')
                            ->join('fraccionesxestilo AS FXE', 'F.Clave = FXE.Fraccion')
                            ->where("FXE.Estilo LIKE '{$ESTILO}'", null, false)
                            ->group_by('F.Clave')
                            ->order_by('ABS(F.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioXFraccionXEstilo($FRACCION, $ESTILO) {
        try {
            return $this->db->select("FXE.CostoMO AS PRECIO_COSTOMO", false)
                            ->from('fraccionesxestilo AS FXE')
                            ->where("FXE.Estilo LIKE '{$ESTILO}' AND FXE.Fraccion LIKE '{$FRACCION}'", null, false)
                            ->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
