<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class RastreoDeControlesEnDocumentos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return$this->db->select("ID, Clave, Descripcion, Direccion, Tel, Cel", false)
                            ->from('agentes AS C')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidos() {
        try {
            return$this->db->select("PX.ID AS ID, PX.Clave AS PEDIDO, "
                                    . "PX.FechaEntrega AS ENTREGA, PX.FechaRecepcion AS CAPTURA, "
                                    . "PX.FechaProg AS PRODUCCION", false)
                            ->from('pedidox AS PX')->where('PX.Control <> 0', null, false)->limit(3999)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnNomina($CONTROL, $EMPLEADO, $FRACCION) {
        try {
            $this->db->select("FPN.ID AS ID, FPN.numeroempleado AS EMPLEADO, 
                FPN.control AS CONTROL, FPN.fecha AS FECHA, 
                FPN.estilo AS ESTILO, FPN.fraccion AS FRACCION, FPN.numfrac AS NUM_FRACCION, 
                FPN.semana AS SEMANA, FPN.pares AS PARES, FPN.depto AS DEPTO", false)
                    ->from('fracpagnomina AS FPN');
            if ($CONTROL !== '') {
                $this->db->where('FPN.control', $CONTROL);
            }
            if ($EMPLEADO !== '') {
                $this->db->where('FPN.numeroempleado', $EMPLEADO);
            }
            if ($FRACCION !== '') {
                $this->db->where('FPN.fraccion', $FRACCION);
            }
            return $this->db->limit(999)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
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

    public function getInfoXControl($Control) {
        try {
            return $this->db->select("C.ID, C.Control, C.FechaProgramacion, C.Estilo, C.Color, C.Serie, C.Cliente, C.Pares, C.Pedido, C.PedidoDetalle, C.Estatus, C.Departamento, C.Ano, C.Maquila, C.Semana, C.Consecutivo, C.Motivo, C.Cancelacion, C.EstatusProduccion", false)
                            ->from('controles AS C')
                            ->where('C.Control', $Control)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            return $this->db->select("E.Numero AS CLAVE, "
                                    . "CONCAT(E.Numero,' ', (CASE WHEN E.PrimerNombre = '0' THEN '' ELSE E.PrimerNombre END),' ',"
                                    . "(CASE WHEN E.SegundoNombre = '0' THEN '' ELSE E.SegundoNombre END),' ', "
                                    . "(CASE WHEN E.Paterno = '0' THEN '' ELSE E.Paterno END),' ', "
                                    . "(CASE WHEN E.Materno = '0' THEN '' ELSE E.Materno END)) AS EMPLEADO")
                            ->from("empleados AS E")->where('E.DepartamentoFisico', 10)->where('E.AltaBaja', 1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
