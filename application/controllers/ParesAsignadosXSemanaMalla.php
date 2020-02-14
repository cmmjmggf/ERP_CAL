<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignadosXSemanaMalla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vNavGeneral');
        switch ($this->session->userdata["TipoAcceso"]) {
            case 'SUPER ADMINISTRADOR':
                $this->load->view('vMenuProduccion')
                        ->view('vParesAsignadosXSemanaMalla');
                break;
            case 'PRODUCCION':
                $this->load->view('vMenuProduccion')
                        ->view('vParesAsignadosXSemanaMalla');
                break;
        }
        $this->load->view('vFooter');
    }

    public function getDatosXSemanaAnioConProgramacion() {
        try {
//            REGEXP_REPLACE(columnName, '[^\\x20-\\x7E]', '')
            $x = $this->input->get();
            $this->db->select("C.control AS CONTROL ,C.estilo AS ESTILO, A.ColorT AS COLOR, A.Pares AS PARES, 
CASE WHEN A.C1 = 0 THEN \"\" ELSE A.C1 END AS C1,CASE WHEN A.C2 = 0 THEN \"\" ELSE A.C2 END AS C2,CASE WHEN A.C3 = 0 THEN \"\" ELSE A.C3 END AS C3,CASE WHEN A.C4 = 0 THEN \"\" ELSE A.C4 END AS C4,CASE WHEN A.C5 = 0 THEN \"\" ELSE A.C5 END AS C5,CASE WHEN A.C6 = 0 THEN \"\" ELSE A.C6 END AS C6,CASE WHEN A.C7 = 0 THEN \"\" ELSE A.C7 END AS C7,CASE WHEN A.C8 = 0 THEN \"\" ELSE A.C8 END AS C8,CASE WHEN A.C9 = 0 THEN \"\" ELSE A.C9 END AS C9,CASE WHEN A.C10 = 0 THEN \"\" ELSE A.C10 END AS C10,CASE WHEN A.C11 = 0 THEN \"\" ELSE A.C11 END AS C11,CASE WHEN A.C12 = 0 THEN \"\" ELSE A.C12 END AS C12,CASE WHEN A.C13 = 0 THEN \"\" ELSE A.C13 END AS C13,CASE WHEN A.C14 = 0 THEN \"\" ELSE A.C14 END AS C14,CASE WHEN A.C15 = 0 THEN \"\" ELSE A.C15 END AS C15,CASE WHEN A.C16 = 0 THEN \"\" ELSE A.C16 END AS C16,CASE WHEN A.C17 = 0 THEN \"\" ELSE A.C17 END AS C17,CASE WHEN A.C18 = 0 THEN \"\" ELSE A.C18 END AS C18,CASE WHEN A.C19 = 0 THEN \"\" ELSE A.C19 END AS C19,CASE WHEN A.C20 = 0 THEN \"\" ELSE A.C20 END AS C20,CASE WHEN A.C21 = 0 THEN \"\" ELSE A.C21 END AS C21,
CASE WHEN A.C22 = 0 THEN \"\" ELSE A.C22 END AS C22,
A.S1,A.S2,A.S3,A.S4,A.S5,A.S6,A.S7,A.S8,A.S9,A.S10,A.S11,A.S12,A.S13, 
 SUM(AA.Cantidad) AS CANTIDAD", false)->from("ordendeproduccion AS A ")
                    ->join("ordendeproducciond AS AA ", " A.ID = AA.OrdenDeProduccion")
                    ->join("programacion AS C", "C.control = A.ControlT")
                    ->join("empleados AS D", "C.numemp = D.Numero");

            if ($x['SEMANA'] !== '') {
                $this->db->where("C.semana", $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where("C.año", $x['ANIO']);
            }
            $this->db->where("AA.`Grupo` IN(34) AND AA.ArticuloT LIKE '%MALLA%'", null, false)
                    ->group_by("C.numemp")
                    ->group_by("AA.Articulo");
            if ($x['SEMANA'] === '' && $x['ANIO'] !== '') {
                $this->db->limit(5);
            }
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosXSemanaAnio() {
        try {
//            REGEXP_REPLACE(columnName, '[^\\x20-\\x7E]', '')
            $x = $this->input->get();
            $this->db->select("A.ControlT AS CONTROL ,A.Estilo AS ESTILO, A.ColorT AS COLOR, A.Pares AS PARES, 
CASE WHEN A.C1 = 0 THEN \"\" ELSE A.C1 END AS C1,CASE WHEN A.C2 = 0 THEN \"\" ELSE A.C2 END AS C2,CASE WHEN A.C3 = 0 THEN \"\" ELSE A.C3 END AS C3,CASE WHEN A.C4 = 0 THEN \"\" ELSE A.C4 END AS C4,CASE WHEN A.C5 = 0 THEN \"\" ELSE A.C5 END AS C5,CASE WHEN A.C6 = 0 THEN \"\" ELSE A.C6 END AS C6,CASE WHEN A.C7 = 0 THEN \"\" ELSE A.C7 END AS C7,CASE WHEN A.C8 = 0 THEN \"\" ELSE A.C8 END AS C8,CASE WHEN A.C9 = 0 THEN \"\" ELSE A.C9 END AS C9,CASE WHEN A.C10 = 0 THEN \"\" ELSE A.C10 END AS C10,CASE WHEN A.C11 = 0 THEN \"\" ELSE A.C11 END AS C11,CASE WHEN A.C12 = 0 THEN \"\" ELSE A.C12 END AS C12,CASE WHEN A.C13 = 0 THEN \"\" ELSE A.C13 END AS C13,CASE WHEN A.C14 = 0 THEN \"\" ELSE A.C14 END AS C14,CASE WHEN A.C15 = 0 THEN \"\" ELSE A.C15 END AS C15,CASE WHEN A.C16 = 0 THEN \"\" ELSE A.C16 END AS C16,CASE WHEN A.C17 = 0 THEN \"\" ELSE A.C17 END AS C17,CASE WHEN A.C18 = 0 THEN \"\" ELSE A.C18 END AS C18,CASE WHEN A.C19 = 0 THEN \"\" ELSE A.C19 END AS C19,CASE WHEN A.C20 = 0 THEN \"\" ELSE A.C20 END AS C20,CASE WHEN A.C21 = 0 THEN \"\" ELSE A.C21 END AS C21,
CASE WHEN A.C22 = 0 THEN \"\" ELSE A.C22 END AS C22,
A.S1,A.S2,A.S3,A.S4,A.S5,A.S6,A.S7,A.S8,A.S9,A.S10,A.S11,A.S12,A.S13, 
 SUM(AA.Cantidad) AS CANTIDAD", false)->from("ordendeproduccion AS A ")
                    ->join("ordendeproducciond AS AA ", " A.ID = AA.OrdenDeProduccion");

            if ($x['SEMANA'] !== '') {
                $this->db->where("A.Semana", $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where("A.Ano", $x['ANIO']);
            }
            $this->db->where("AA.`Grupo` IN(34) AND AA.ArticuloT LIKE '%MALLA%'", null, false)
                    ->group_by("A.ControlT")->group_by("AA.Articulo");
            if ($x['SEMANA'] === '' && $x['ANIO'] !== '') {
                $this->db->limit(5);
            }
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
