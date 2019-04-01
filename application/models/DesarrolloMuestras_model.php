<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class DesarrolloMuestras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($ESTILO, $COLOR) {
        try {
            $this->db->select('FT.ID, E.Clave AS Estilo, FT.Color, FT.Pieza AS Pza, '
                            . 'P.Descripcion AS PzaT, A.Clave AS Articulo, FT.Precio, '
                            . 'FT.Consumo AS Cons, FT.PzXPar, FT.Estatus, FT.FechaAlta, '
                            . 'FT.AfectaPV, P.Departamento AS Sec,'
                            . '(CASE WHEN P.Rango IS NULL THEN "" ELSE P.Rango END) AS Rango, '
                            . 'A.Descripcion AS ArticuloT, E.Linea AS Linea, E.Foto AS Foto', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave');
            if ($ESTILO !== '' && $COLOR !== '') {
                $this->db->where('E.Clave', $ESTILO)->where('FT.Color', $COLOR);
            } else {
                $this->db->limit(500);
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMuestras() {
        try {
            $this->db->select('DM.ID, DM.Estilo, DM.EstiloT, DM.Color, DM.ColorT, 
DM.EspecificacionCorte, DM.FechaCorte, DM.AccionCorrectivaCorte, DM.FechaAccionCorrectivaCorte, DM.EspecificacionRayado, 
DM.FechaRayado, DM.AccionCorrectivaRayado, DM.FechaAccionCorrectivaRayado, DM.EspecificacionRebajadoyperforado, DM.FechaRebajadoyperforado, 
DM.AccionCorrectivaRebajadoyperforado, DM.FechaAccionCorrectivaRebajadoyperforado, DM.EspecificacionFoleado, DM.FechaFoleado, 
DM.AccionCorrectivaFoleado, DM.FechaAccionCorrectivaFoleado, DM.EspecificacionLaser, DM.FechaLaser, DM.AccionCorrectivaLaser, DM.FechaAccionCorrectivaLaser, 
DM.EspecificacionPrelcorte, DM.FechaPrelcorte, DM.AccionCorrectivaPrelcorte, DM.FechaAccionCorrectivaPrelcorte, DM.EspecificacionRayadocontado, 
DM.FechaRayadocontado, DM.AccionCorrectivaRayadocontado, DM.FechaAccionCorrectivaRayadocontado, DM.EspecificacionEntretelado, DM.FechaEntretelado, 
DM.AccionCorrectivaEntretelado, DM.FechaAccionCorrectivaEntretelado, DM.EspecificacionMaquila, DM.FechaMaquila, DM.AccionCorrectivaMaquila, 
DM.FechaAccionCorrectivaMaquila, DM.EspecificacionPespunte, DM.FechaPespunte, DM.AccionCorrectivaPespunte, DM.FechaAccionCorrectivaPespunte, 
DM.EspecificacionPrelpespunte, DM.FechaPrelpespunte, DM.AccionCorrectivaPrelpespunte, DM.FechaAccionCorrectivaPrelpespunte,  DM.EspecificacionEnsuelado, DM.FechaEnsuelado, 
DM.AccionCorrectivaEnsuelado, DM.FechaAccionCorrectivaEnsuelado, DM.EspecificacionTejido, DM.FechaTejido, DM.AccionCorrectivaTejido, 
DM.FechaAccionCorrectivaTejido, DM.EspecificacionChoferes, DM.FechaChoferes, DM.AccionCorrectivaChoferes, 
DM.FechaAccionCorrectivaChoferes, DM.EspecificacionMontadoa, DM.FechaMontadoa, DM.AccionCorrectivaMontadoa, 
DM.FechaAccionCorrectivaMontadoa, DM.EspecificacionMontadob, DM.FechaMontadob, DM.AccionCorrectivaMontadob, 
DM.FechaAccionCorrectivaMontadob, DM.EspecificacionPegado, DM.FechaPegado, DM.AccionCorrectivaPegado, DM.FechaAccionCorrectivaPegado, 
DM.EspecificacionAdornoa, DM.FechaAdornoa, DM.AccionCorrectivaAdornoa, DM.FechaAccionCorrectivaAdornoa, DM.EspecificacionAdornob, 
DM.FechaAdornob, DM.AccionCorrectivaAdornob, DM.FechaAccionCorrectivaAdornob, DM.Registro, DM.Usuario', false)
                    ->from('desarrollo_muestras AS DM');
            return $this->db->get()->result();
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

    public function getFotoXEstilo($Estilo) {
        try {
            return $this->db->select("E.Descripcion AS Estilo, E.Foto AS Foto", false)
                            ->from('estilos AS E')
                            ->where('E.Clave', $Estilo)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            return $this->db->select("D.Clave AS CLAVE, D.Descripcion AS DEPTO,"
                                    . "REPLACE(REPLACE(REPLACE(CONCAT(UCASE(LEFT(Descripcion, 1)), LOWER(substr(Descripcion, 2,length(Descripcion) ) ) ),' ',''),'-',''),'\"','') AS DEPTOR", false)
                            ->from('departamentos AS D')
                            ->where('D.Avance IN(1) AND D.Produccion = 1', null, false)
                            ->order_by('ABS(D.Clave)', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDesarrolloMuestra($ESTILO, $COLOR) {
        try {
            return $this->db->select("DM.*", false)
                            ->from('desarrollo_muestras AS DM')
                            ->where("DM.Estilo = $ESTILO AND DM.Color = $COLOR", null, false)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
