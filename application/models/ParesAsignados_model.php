<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ParesAsignados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getParesAsignados($MI, $MF, $SI, $SF, $A, $T) {
        try {
            $this->db->select('C.Clave AS CLAVE_CLIENTE, C.RazonS AS CLIENTE, '
                            . 'P.Clave AS CLAVE_PEDIDO, P.Estilo AS ESTILO, '
                            . 'P.Color AS CLAVE_COLOR, P.FechaEntrega AS FECHA_ENTREGA, '
                            . 'P.Maquila AS MAQUILA,'
                            . 'P.Semana AS SEMANA, '
                            . 'P.Pares AS PARES,'
                            . 'CO.Descripcion AS COLOR, '
                            . 'P.Observacion AS OBSERVACION_UNO, '
                            . 'P.ObservacionDetalle AS OBSERVACION_DOS,'
                            . 'C.Observaciones AS OBSERVACIONES_CLIENTE', false)
                    ->from('pedidox AS P')->join('clientes AS C', 'P.Cliente = C.ID', 'left')
                    ->join('colores AS CO', 'P.Color = CO.Clave AND CO.Estilo = P.Estilo', 'left');
            if ($MI !== '' && $MF !== '') {
                $this->db->where("P.Maquila BETWEEN '$MI' AND '$MF'", null, false);
            }
            if ($SI !== '' && $SF !== '') {
                $this->db->where("P.Semana BETWEEN '$SI' AND '$SF'", null, false);
            }
            if ($A !== '') {
                $this->db->where("P.Ano LIKE '$A'", null, false);
            }
            switch ($T) {
                case 1:
                    /* CLIENTE ASC- FECHA DE ENTREGA ASC */
                    $this->db->order_by('C.RazonS', 'ASC')->order_by('P.FechaEntrega', 'ASC');
                    break;
                case 2:
                    /* PEDIDO ASC */
                    $this->db->order_by('ABS(P.Clave)', 'ASC');
                    break;
                case 3:
                    /* ESTILO ASC - COLOR ASC */
                    $this->db->order_by('P.Estilo', 'ASC')->order_by('CO.Descripcion', 'ASC');
                    break;
                case 4:
                    /* FECHA DE ENTREGA ASC - CLIENTE ASC */
                    $this->db->order_by('P.FechaEntrega', 'ASC')->order_by('C.RazonS', 'ASC');
                    break;
            }
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("COUNT(*) AS EXISTE_MAQUILA", false)->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida($S) {
        try {
            return $this->db->select("COUNT(*) AS SEMANA_NO_CERRADA")->from("semanasproduccion AS S")->where("S.Sem", $S)->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
