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
                            . 'FT.AfectaPV, P.Departamento AS Sec,P.Rango AS Rango, '
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
            return $this->db->select("E.Foto AS Foto", false)
                            ->from('estilos AS E')
                            ->where('E.Clave', $Estilo)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
