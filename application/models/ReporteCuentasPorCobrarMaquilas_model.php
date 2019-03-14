<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteCuentasPorCobrarMaquilas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getMaquilasReporte($maq, $amaq, $ano) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(MA.Maq AS SIGNED ) AS Maquila, M.Nombre AS NombreMaquila ", false)
                            ->from("movarticulos AS MA")
                            ->join("maquilas AS M", 'ON M.Clave =  MA.Maq')
                            ->where("MA.Ano", $ano)
                            ->where_in("MA.TipoMov", array('SXM', 'SPR', 'SXP', 'SXC'))
                            ->where("MA.Maq BETWEEN $maq AND $amaq  ", null, false)
                            ->group_by("MA.Maq")
                            ->group_by("M.Nombre")
                            ->order_by("Maquila", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasReporte($maq, $amaq, $ano) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(MA.Maq AS SIGNED ) AS Maquila, CAST(MA.Sem AS SIGNED ) AS Semana  ", false)
                            ->from("movarticulos AS MA")
                            ->where("MA.Ano", $ano)
                            ->where_in("MA.TipoMov", array('SXM', 'SPR', 'SXP', 'SXC'))
                            ->where("MA.Maq BETWEEN $maq AND $amaq  ", null, false)
                            ->group_by("MA.Maq")
                            ->group_by("MA.Sem")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Semana", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDoctosReporte($maq, $amaq, $ano) {
        try {
            $this->db->query("SET sql_mode = '';");
            return $this->db->select("CAST(MA.Maq AS SIGNED ) AS Maquila, CAST(MA.Sem AS SIGNED ) AS Semana,"
                                    . "MA.DocMov, sum(Ma.Subtotal) AS Subtotal  ", false)
                            ->from("movarticulos AS MA")
                            ->where("MA.Ano", $ano)
                            ->where_in("MA.TipoMov", array('SXM', 'SPR', 'SXP', 'SXC'))
                            ->where("MA.Maq BETWEEN $maq AND $amaq  ", null, false)
                            ->group_by("MA.DocMov")
                            ->order_by("Maquila", 'ASC')
                            ->order_by("Semana", 'ASC')
                            ->order_by("MA.DocMov", 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
