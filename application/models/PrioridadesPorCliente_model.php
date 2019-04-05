<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class PrioridadesPorCliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("P.Cliente,
                                P.Clave AS Pedido,
                                P.Control,
                                P.Ano,
                                P.Semana,
                                P.Maquila,
                                P.Pares,
                                P.Estilo,
                                ifnull(C.EstatusProduccion,'PREPROGRAMADO') AS EstatusProduccion,
                                P.FechaPedido,
                                P.FechaEntrega,
                                DATEDIFF(CURRENT_DATE(), date_format(str_to_date(P.FechaEntrega, '%d/%m/%Y'), '%Y-%m-%d')) AS Dias  "
                            . "", false)
                    ->from("pedidox AS P")
                    ->join("controles C", "ON C.Control =  P.Control", "left")
                    ->join('departamentos DEP', 'ON DEP.Descripcion =  C.EstatusProduccion', 'left')
                    ->where("cast(ifnull(DEP.Clave,'0') as signed) <= 240 AND P.ESTATUS = 'A' ", null, false);
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

    public function getClientes() {
        try {
            return $this->db->select("CAST(D.Clave AS SIGNED ) AS ID,CONCAT(D.Clave,'-',D.RazonS) AS Cliente")
                            ->from("clientes AS D")
                            ->where("D.Estatus", "ACTIVO")
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
