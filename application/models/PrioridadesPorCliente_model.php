<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class PrioridadesPorCliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($cliente) {
        try {
            $this->db->select("P.Cliente,
                                P.Clave AS Pedido,
                                P.Control,
                                P.Ano,
                                P.Semana,
                                P.Maquila,
                                P.Pares,
                                P.Estilo,
                                (case
                                when (P.stsavan  = 0) then 'Pre-programado'
                                when (P.stsavan  = 1) then 'Programado'
                                when (P.stsavan = 2) then 'Corte'
                                when (P.stsavan = 3) then 'Rayado'
                                when (P.stsavan = 33) then 'Rebajado'
                                when (P.stsavan = 4) then 'Foleado'
                                when (P.stsavan = 40) then 'Entretelado'
                                when (P.stsavan = 42) then 'Proceso Maq'
                                when (P.stsavan = 44) then 'Alm-Corte'
                                when (P.stsavan = 5) then 'Pespunte'
                                when (P.stsavan = 55) then 'Ensuelado'
                                when (P.stsavan = 6) then 'Alm-Pespu'
                                when (P.stsavan = 7) then 'Tejido'
                                when (P.stsavan = 8) then 'Alm-Tejido'
                                when (P.stsavan = 9) then 'Montado'
                                when (P.stsavan = 10) then 'Adorno'
                                when (P.stsavan = 11) then 'Alm-Adorno'
                                when (P.stsavan = 12) then 'Prd-Termi'
                                when (P.stsavan = 13) then 'Facturado'
                                end) AS EstatusProduccion,
                                P.FechaPedido,
                                P.FechaEntrega,
                                DATEDIFF(CURRENT_DATE(), date_format(str_to_date(P.FechaEntrega, '%d/%m/%Y'), '%Y-%m-%d')) AS Dias  "
                            . "", false)
                    ->from("pedidox AS P")
                    ->where("P.stsavan not in (0,13,14)", null, false)->where("P.Cliente", $cliente);
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
