<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class AvanceTejido_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("ID, Clave, Descripcion, Direccion, Tel, Cel", false)
                    ->from('agentes AS C');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getChoferes() {
        try {
            return $this->db->select("E.ID, CONCAT(E.Numero,' ', E.PrimerNombre,' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS Empleado", false)
                            ->from('empleados AS E')
                            ->where('E.AltaBaja', 1)->where('E.DepartamentoFisico', 170)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoDocumento($ANO, $MES, $DIA) {
        try {
            $EXISTE = $this->db->select("COUNT(CP.ID) AS VALIDO", false)
                            ->from('controltej AS CP')
                            ->where("SUBSTRING(CP.docto,1,2) = SUBSTRING({$ANO},3,2) "
                                    . "AND SUBSTRING(CP.docto,3,2) = {$MES} "
                                    . "AND SUBSTRING(CP.docto,5,2) = {$DIA} ", null, false)
                            ->order_by('CP.docto', 'DESC')
                            ->limit(1)
                            ->get()->result();
            $preselect = "CP.docto AS DOCTO_ANTERIOR, 
                CASE WHEN CP.docto IS NULL THEN SUBSTRING(YEAR(NOW()),3,2) ELSE SUBSTRING(CP.docto,1,2) END AS ANO, 
                CASE WHEN CP.docto IS NULL THEN LPAD(MONTH(NOW()),2,0) ELSE SUBSTRING(CP.docto,3,2) END AS MES, 
                CASE WHEN CP.docto IS NULL THEN LPAD(DAY(NOW()),2,0) ELSE SUBSTRING(CP.docto,5,2) END AS DIA,  
                CASE WHEN CP.docto IS NULL THEN LPAD(1,3,0) ELSE LPAD(SUBSTRING(CP.docto+1,7,3),3,0) END AS CONSECUTIVO";
            if (intval($EXISTE[0]->VALIDO) > 0) {
                $this->db->select($preselect, false);
            } else {
                $preselect .= ",COUNT(CP.ID) AS VALID";
                $this->db->select($preselect, false);
            }
            return $this->db->from('controltej AS CP')
                            ->where("SUBSTRING(CP.docto,1,2) = SUBSTRING({$ANO},3,2) "
                                    . "AND SUBSTRING(CP.docto,3,2) = {$MES} "
                                    . "AND SUBSTRING(CP.docto,5,2) = {$DIA} ", null, false)
                            ->order_by('CP.docto', 'DESC')
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTejedoras() {
        try {
            return $this->db->select("E.ID, CONCAT(E.Numero,' ', E.PrimerNombre,' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS Empleado", false)
                            ->from('empleados AS E')
                            ->where('E.AltaBaja', 1)->where('E.Puesto', 'TEJEDORA')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina($FECHA) {
        try {
            return $this->db->select("S.Sem AS SEMANA", false)
                            ->from('semanasnomina AS S')
                            ->where("STR_TO_DATE(\"{$FECHA}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaTejido() {
        try {
            return $this->db->select("C.ID, C.Control AS CONTROL, "
                                    . "C.Estilo AS ESTILO, C.Color AS COLOR, C.Pares AS PARES, "
                                    . "P.FechaEntrega AS ENTREGA, C.Maquila AS MAQUILA", false)
                            ->from('controles AS C')
                            ->join('pedidox AS P', 'C.Control = P.Control')
                            ->join('controltej AS CT', 'CT.Control = C.Control', 'left')
                            ->where('CT.ID IS NULL', null, false)
                            ->where('C.EstatusProduccion', 'ALM-PESPUNTE')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnTejido() {
        try {
            return $this->db->select("C.ID, C.numcho AS CHOFER, "
                                    . "C.numtej AS TEJEDORA, C.fechapre AS FECHA, "
                                    . "C.control AS CONTROL, C.estilo AS ESTILO, "
                                    . "C.color AS COLOR, C.nomcolo AS COLORT, "
                                    . "C.docto AS DOCTO, C.pares AS PARES", false)
                            ->from('controltej AS C')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo($Estilo) {
        try {
            return $this->db->select("CAST(C.Clave AS SIGNED ) AS ID, CONCAT(C.Clave,'-', C.Descripcion) AS Descripcion ", false)
                            ->from('colores AS C')
                            ->where('C.Estilo', $Estilo)
                            ->where('C.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance($control) {
        try {
            /*
             * 140	ENSUELADO = 1
             * 150	TEJIDO = 1
             * 160	ALMACEN TEJIDO = 0
             *  */
            return $this->db->select("COUNT(A.ID) AS EXISTE", false)
                            ->from('avance AS A')
                            ->where_in('A.Departamento', array(150, 160))
                            ->like('A.Control', $control)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl($CONTROL) {
        try {
            return $this->db->select("A.Departamento AS DEPTO", false)
                            ->from('avance AS A')
                            ->like('A.Control', $CONTROL)
                            ->order_by('A.ID', 'DESC')
                            ->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
