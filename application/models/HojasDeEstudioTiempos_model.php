<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class HojasDeEstudioTiempos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDepartamentosXEstilo($E) {
        try {
            $this->db->select('D.Clave, D.Descripcion, 0 AS EXISTE')
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('departamentos AS D', 'P.Departamento = D.Clave')
                    ->where('FT.Estilo', $E)
                    ->where('D.Tipo', 1); /* 1 SON DEPTOS DE PRODUCCIÓN */
            return $this->db->group_by(array('D.Clave'))->order_by('ABS(D.Clave)', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTiemposXEstiloDepto() {
        try {
            return $this->db->select('TXED.ID, TXED.Linea AS LINEA, TXED.Estilo AS ESTILO,'
                                    . 'TXEDHDTO.Departamento AS CLAVE_DEPARTAMENTO, DEPTO.Descripcion AS DEPARTAMENTO, '
                                    . 'TXEDHDTO.Tiempo AS TIEMPO, '
                                    . 'CONCAT(\'<span class="btn btn-danger" onclick="onEliminarDeptoXEstilo(this)"><span class="fa fa-minus"></span></span>\') AS TIEMPO_BTN, '
                                    . 'TXED.Total AS TOTAL, TXEDHDTO.ID AS IDD')
                            ->from('tiemposxestilodepto AS TXED')
                            ->join('tiemposxestilodepto_has_deptos AS TXEDHDTO', 'TXED.ID = TXEDHDTO.TiempoXEstiloDepto')
                            ->join('departamentos AS DEPTO', 'TXEDHDTO.Departamento = DEPTO.Clave')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarTiempoXEstiloDeptos($E) {
        try {
            return $this->db->select('TXED.ID, TXED.Linea AS LINEA, TXED.Estilo AS ESTILO,'
                                    . 'TXEHD.Departamento AS CLAVE_DEPARTAMENTO, DEPTO.Descripcion AS DEPARTAMENTO, '
                                    . 'TXEHD.Tiempo AS TIEMPO, TXED.Total AS TOTAL, 1 AS EXISTE')
                            ->from('tiemposxestilodepto AS TXED')
                            ->join('tiemposxestilodepto_has_deptos AS TXEHD', 'TXED.ID = TXEHD.TiempoXEstiloDepto')
                            ->join('departamentos AS DEPTO', 'TXEHD.Departamento = DEPTO.Clave')
                            ->where('TXED.Estilo', $E)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarDeptoXEstilo($E, $D) {
        try {
            return $this->db->select('COUNT(DEPTO.Clave) AS EXISTE')
                            ->from('tiemposxestilodepto AS TXED')
                            ->join('tiemposxestilodepto_has_deptos AS TXEHD', 'TXED.ID = TXEHD.TiempoXEstiloDepto')
                            ->join('departamentos AS DEPTO', 'TXEHD.Departamento = DEPTO.Clave')
                            ->where('TXED.Estilo', $E)
                            ->where('DEPTO.Clave', $D)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaXEstilo($E) {
        try {
            return $this->db->select('E.Linea AS LINEA, E.Descripcion AS ESTILO')
                            ->from('estilos AS E')
                            ->where('E.Clave', $E)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
