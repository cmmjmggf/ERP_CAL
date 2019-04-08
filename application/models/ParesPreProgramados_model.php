<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ParesPreProgramados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getParesPreProgramados($CEL, $I, $CLIENTE, $ESTILO, $LINEA, $MAQUILA, $SEMANA, $FECHA, $FECHAF) {
        try {
            $this->db->select('C.Clave AS CLAVE_CLIENTE, C.RazonS AS  CLIENTE, A.Clave AS CLAVE_AGENTE, A.Nombre AS AGENTE, ES.Descripcion AS ESTADO,
P.Clave AS PEDIDO, E.Linea AS CLAVE_LINEA, L.Descripcion AS LINEA, P.Estilo AS CLAVE_ESTILO, CO.Descripcion AS COLOR,
P.FechaEntrega AS FECHA_ENTREGA, P.Pares AS PARES, P.Maquila AS MAQUILA, P.Semana AS SEMANA, C.Pais AS PAIS', false)
                    ->from('pedidox AS P')
                    ->join('clientes AS C', 'P.Cliente = C.Clave')
                    ->join('agentes AS A', 'P.Agente = A.Clave')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('colores AS CO', 'E.Clave = CO.Estilo AND P.Color = CO.Clave')
                    ->join('lineas AS L', 'E.Linea = L.Clave')
                    ->join('estados AS ES', 'C.Estado = ES.Clave');
            switch ($I) {
                case 1:
                    $this->db->where("C.Clave", $CEL);
                    break;
                case 2:
                    $this->db->where("P.Estilo", $CEL);
                    $this->db->where("E.Clave", $CEL);
                    $this->db->where("CO.Estilo", $CEL);
                    break;
                case 3:
                    $this->db->where("L.Clave", $CEL);
                    $this->db->where("E.Linea", $CEL);
                    break;
            }
            if ($CLIENTE !== '') {
                $this->db->where("C.Clave", $CLIENTE);
            }
            if ($ESTILO !== '') {
                $this->db->where("E.Clave", $ESTILO);
            }
            if ($LINEA !== '') {
                $this->db->where("L.Clave", $LINEA);
            }
            if ($MAQUILA !== '') {
                $this->db->where("P.Maquila", $MAQUILA);
            }
            if ($SEMANA !== '') {
                $this->db->where("P.Semana", $SEMANA);
            }
            if ($FECHA !== '' && $FECHAF !== '') {
                $this->db->where("STR_TO_DATE(P.FechaEntrega, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FECHA', \"%d/%m/%Y\") AND STR_TO_DATE('$FECHAF', \"%d/%m/%Y\")");
            } else if ($FECHA !== '') {
                $this->db->where("STR_TO_DATE(P.FechaEntrega, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FECHA', \"%d/%m/%Y\") AND STR_TO_DATE('$FECHA', \"%d/%m/%Y\")");
            } else if ($FECHAF !== '') {
                $this->db->where("STR_TO_DATE(P.FechaEntrega, \"%d/%m/%Y\") BETWEEN STR_TO_DATE('$FECHAF', \"%d/%m/%Y\") AND STR_TO_DATE('$FECHAF', \"%d/%m/%Y\")");
            }
            $this->db->where("P.Estatus LIKE 'A' AND P.Control = 0 ", null, false);
            $sql = $this->db->get()->result();
            return $sql;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes($CLIENTE, $ESTILO, $LINEA, $MAQUILA, $SEMANA, $FECHA) {
        try {
            $this->db->select('C.Clave AS CLAVE_CLIENTE, '
                            . 'C.RazonS AS CLIENTE, '
                            . 'A.Clave AS CLAVE_AGENTE, '
                            . 'A.Nombre AS AGENTE, '
                            . 'ES.Clave AS CLAVE_ESTADO, '
                            . 'ES.Descripcion AS ESTADO', false)
                    ->from('pedidox AS P');
            $this->db->join('clientes AS C', 'P.Cliente = C.Clave');
            $this->db->join('agentes AS A', 'C.Agente = A.Clave');
            $this->db->join('estados AS ES', 'C.Estado = ES.Clave');
            $this->db->join('estilos AS E', 'P.Estilo = E.Clave');
            $this->db->join('lineas AS L', 'E.Linea = L.Clave');
            if ($CLIENTE !== '') {
                $this->db->where('C.Clave', $CLIENTE);
            }
            if ($MAQUILA !== '') {
                $this->db->where("P.Maquila", $MAQUILA);
            }
            if ($SEMANA !== '') {
                $this->db->where("P.Semana", $SEMANA);
            }
            if ($ESTILO !== '') {
                $this->db->where("P.Estilo", $ESTILO);
            }
            if ($LINEA !== '') {
                $this->db->where("L.Clave", $LINEA);
            }
            if ($FECHA !== '') {
                $this->db->where("P.FechaEntrega", $FECHA);
            }
            $this->db->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            return $this->db->group_by('C.ID')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesX() {
        try {
            $this->db->select('C.Clave AS CLAVE_CLIENTE, '
                            . 'CONCAT(C.Clave," - ",C.RazonS) AS CLIENTE', false)
                    ->from('clientes AS C')->where('C.Estatus', 'ACTIVO');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos($E, $C, $M, $S) {
        try {
            $this->db->select('P.Estilo AS CLAVE_ESTILO, P.ColorT AS COLOR', false)
                    ->from('pedidox AS P');
            if ($E !== '') {
                $this->db->where('P.Estilo', $E);
            }
            if ($C !== '') {
                $this->db->where('P.Cliente', $C);
            }
            if ($M !== '') {
                $this->db->where("P.Maquila", $M);
            }
            if ($S !== '') {
                $this->db->where("P.Semana", $S);
            }
            $this->db->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            return $this->db->group_by('P.Estilo')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosX() {
        try {
            $this->db->select('E.Clave AS CLAVE_ESTILO, E.Descripcion AS ESTILO', false)
                    ->from('pedidox AS P')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false)
                    ->group_by('P.Estilo');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas($C, $E, $L, $M, $S) {
        try {
            $this->db->select('E.Linea AS CLAVE_LINEA, L.Descripcion AS LINEA', false)
                    ->from('pedidox AS P')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('colores AS CO', 'E.Clave = CO.Estilo AND P.Color = CO.Clave')
                    ->join('lineas AS L', 'E.Linea = L.Clave');
            if ($C !== '') {
                $this->db->where('P.Cliente', $C);
            }
            if ($E !== '') {
                $this->db->where('E.Clave', $E);
            }
            if ($L !== '') {
                $this->db->where('L.Clave', $L);
            }
            if ($M !== '') {
                $this->db->where("P.Maquila", $M);
            }
            if ($S !== '') {
                $this->db->where("P.Semana", $S);
            }
            $this->db->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            $this->db->group_by('L.Clave');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineasX() {
        try {
            $this->db->select('L.Clave AS CLAVE_LINEA, CONCAT(L.Clave," - ", L.Descripcion) AS LINEA', false)
                    ->from('pedidox AS P')
                    ->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('lineas AS L', 'E.Linea = L.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false)
                    ->group_by('L.Clave');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, M.Nombre AS MAQUILA, M.CapacidadPares AS CAPACIDAD_PARES', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false)
                    ->group_by(array('M.Nombre'))
                    ->order_by('P.Maquila', 'ASC')
                    ->order_by('P.Semana', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasX() {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, CONCAT(M.Clave," - ", M.Nombre) AS MAQUILA', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false)
                    ->group_by(array('M.Nombre'))
                    ->order_by('P.Maquila', 'ASC')
                    ->order_by('P.Semana', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquila($M, $CLIENTE, $ESTILO, $MAQUILA, $SEMANA) {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, CONCAT(M.Clave," - ", M.Nombre) AS MAQUILA, M.CapacidadPares AS CAPACIDAD_PARES', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);
            if ($M !== '') {
                $this->db->where('M.Clave', $M);
            }
            if ($CLIENTE !== '') {
                $this->db->where("P.Cliente", $CLIENTE);
            }
            if ($ESTILO !== '') {
                $this->db->where("P.Estilo", $ESTILO);
            }
            if ($MAQUILA !== '') {
                $this->db->where("P.Maquila", $MAQUILA);
            }
            if ($SEMANA !== '') {
                $this->db->where("P.Semana", $SEMANA);
            }
            $this->db->group_by(array('M.Nombre'))->order_by('P.Maquila', 'ASC')->order_by('P.Semana', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesPreProgramadosPorMaquila($M, $CLIENTE, $ESTILO, $MAQUILA, $SEMANA) {
        try {
            $this->db->select('M.Clave AS CLAVE_MAQUILA, M.Nombre AS MAQUILA, '
                            . 'M.CapacidadPares AS CAPACIDAD_PARES, P.Semana AS SEMANA, '
                            . 'SUM(P.Pares) AS PARES, '
                            . 'M.CapacidadPares - SUM(P.Pares) AS DIFERENCIA', false)
                    ->from('pedidox AS P')
                    ->join('maquilas AS M', 'P.Maquila = M.Clave')
                    ->where('M.Clave', $M)->where('P.Maquila', $M)
                    ->where("P.Control = 0 AND P.Estatus LIKE 'A'", null, false);

            if ($CLIENTE !== '') {
                $this->db->where("P.Cliente", $CLIENTE);
            }
            if ($ESTILO !== '') {
                $this->db->where("P.Estilo", $ESTILO);
            }
            if ($MAQUILA !== '') {
                $this->db->where("P.Maquila", $MAQUILA);
            }
            if ($SEMANA !== '') {
                $this->db->where("P.Semana", $SEMANA);
            }
            $this->db->group_by(array('M.Nombre', 'P.Semana'))
                    ->order_by('P.Maquila', 'ASC')
                    ->order_by('P.Semana', 'ASC');
            return $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
