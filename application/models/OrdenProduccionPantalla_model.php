<?php

/**
 * Description of ControlesTerminados_model
 *
 * @author Y700
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class OrdenProduccionPantalla_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getOrdenProduccion($Control) {
        try {
            $this->db->select("
                            OP.Pedido,
                            CONCAT(OP.Clave,' - ',OP.Cliente) AS Cliente,
                            CONCAT(A.Clave,' - ',OP.Agente) AS Agente,
                            CONCAT(OP.Linea,' - ',OP.LineaT) AS Linea,
                            CONCAT(OP.Estilo,' - ',OP.EstiloT) AS Estilo,
                            CONCAT(OP.Color,' - ',OP.ColorT) AS Color,
                            CONCAT(G.Clave,' - ',G.Nombre) AS GrupoT,
                            C.EstatusProduccion,
                            OP.SerieCorrida,
                            OP.SuelaT AS Suela,
                            OP.S1,OP.S2,OP.S3,OP.S4,OP.S5,OP.S6,OP.S7,OP.S8,OP.S9,OP.S10,OP.S11,OP.S12,OP.S13,OP.S14,OP.S15,OP.S16,OP.S17,OP.S18,OP.S19,OP.S20,OP.S21,OP.S22,
                            OP.C1,OP.C2,OP.C3,OP.C4,OP.C5,OP.C6,OP.C7,OP.C8,OP.C9,OP.C10,OP.C11,OP.C12,OP.C13,OP.C14,OP.C15,OP.C16,OP.C17,OP.C18,OP.C19,OP.C20,OP.C21,OP.C22,
                            OP.Pares,
                            OP.FechaEntrega,
                            OP.FechaPedido,
                            OP.Observaciones,
                            CAST(OP.TotalPiel AS DECIMAL(5,2)) AS TotalPiel,
                            CAST((OP.TotalPiel) / (OP.Pares) AS DECIMAL(5,2)) AS TotalPielPorPar,
                            CAST(OP.TotalForro AS DECIMAL(5,2)) AS TotalForro,
                            CAST((OP.TotalForro) / (OP.Pares) AS DECIMAL(5,2)) AS TotalForroPorPar,
                            CAST(OPD.Grupo AS SIGNED) AS Grupo,
                            OPD.Pieza,
                            OPD.PiezaT,
                            OPD.Articulo,
                            OPD.ArticuloT,
                            OPD.UnidadMedidaT,
                            OPD.Consumo "
                            . " "
                            . "")
                    ->from("ordendeproduccion OP")
                    ->join("ordendeproducciond OPD", 'ON OP.ID =  OPD.OrdenDeProduccion')
                    ->join("agentes A", 'ON A.Nombre =  OP.Agente')
                    ->join("grupos G", 'ON G.Clave =  OPD.Grupo')
                    ->join("pedidox C", 'ON C.Control =  OP.ControlT')
                    ->where("OP.ControlT", $Control)
                    ->order_by("Grupo", 'ASC');
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

}
