<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ExplosionesPorArticulo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getDatosEmpresa() {
        try {
            $this->db->select("E.RazonSocial as Empresa, E.Foto as Logo "
                            . " ", false)
                    ->from('empresas AS E')
                    ->where('Estatus', 'ACTIVO');

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

    public function getExplosionMateriales($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $TipoE, $Articulo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("A.Grupo, "
                            . "FT.Articulo, "
                            . "A.Descripcion, "
                            . "U.Descripcion AS Unidad,"
                            . "CASE WHEN PZA.Clasificacion = '1' THEN
                                '1ra'
                                WHEN PZA.Clasificacion = '2' THEN
                                '2da'
                                WHEN PZA.Clasificacion = '3' THEN
                                '3ra'
                                ELSE '-'
                                END AS Clasificacion, "
                            . "CASE WHEN E.PiezasCorte <= 10 THEN
                                MA.PorExtra3a10
                                WHEN E.PiezasCorte > 10 AND E.PiezasCorte <= 14 THEN
                                MA.PorExtra11a14
                                WHEN E.PiezasCorte > 14 AND E.PiezasCorte <= 18 THEN
                                MA.PorExtra15a18
                                WHEN E.PiezasCorte > 18  THEN
                                MA.PorExtra19a
                                END AS Desperdicio , "
                            . "PE.Pares,"
                            . "PE.Pares *  SUM(FT.Consumo) AS Explosion,"
                            . "SUM(FT.Consumo) AS Consumo,"
                            . "PM.Precio "
                            . " ", false)
                    ->from('pedidox PE')
                    ->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color')
                    ->join('preciosmaquilas PM', "ON PM.Articulo = FT.Articulo AND PM.Maquila ='$Maquila' ")
                    ->join('articulos A', 'ON A.Clave =  FT.Articulo')
                    ->join('piezas PZA', 'ON PZA.Clave =  FT.Pieza')
                    ->join('grupos G', 'ON G.Clave = A.Grupo')
                    ->join('unidades U', 'ON U.Clave = A.UnidadMedida')
                    ->join('maquilas MA', "MA.Clave = '$Maquila'")
                    ->join('estilos E', 'ON E.Clave = PE.Estilo')
                    ->where("PE.Maquila BETWEEN $Maquila AND $aMaquila")
                    ->where("PE.Semana BETWEEN $Semana AND $aSemana")
                    ->where('PE.Ano', $Ano)
                    ->where('A.Clave', $Articulo)
                    ->where('PE.Estatus', 'A')
                    ->where('PE.Control <>  ', false)
                    ->where('PE.Control IS NOT NULL ', NULL, false);
            switch ($TipoE) {
                case '10':
                    $this->db->where_in('G.Clave', array('1', '2'));
                    break;
                case '80':
                    $this->db->where_in('G.Clave', array('3', '50', '52'));
                    break;
                case '90':
                    $this->db->where_not_in('G.Clave', array('1', '2', '3', '50', '52'));
                    break;
            }

            //Agrupacion
            $this->db->group_by('A.Clave');
            $this->db->group_by('PZA.Clasificacion');

            //Ordenamiento
            switch ($TipoE) {
                case '10':
                    $this->db->order_by('A.Grupo', 'ASC');
                    $this->db->order_by('A.Descripcion', 'ASC');
                    $this->db->order_by('PZA.Clasificacion', 'ASC');

                    break;
                case '80':
                    $this->db->order_by('Explosion', 'DESC');
                    break;
                case '90':
                    $this->db->order_by('A.Grupo', 'ASC');
                    $this->db->order_by('A.Descripcion', 'ASC');

                    break;
            }




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

    /* Explosion por tallas */

    public function getExplosionMaterialesTallas($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $Articulo) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select(""
                            . "CAST(FT.Articulo AS SIGNED ) AS ClaveART, "
                            . "SUM(PE.C1) AS C1, SUM(PE.C2) AS C2, SUM(PE.C3) AS C3, SUM(PE.C4) AS C4, SUM(PE.C5) AS C5,
SUM(PE.C6) AS C6, SUM(PE.C7) AS C7, SUM(PE.C8) AS C8, SUM(PE.C9) AS C9, SUM(PE.C10) AS C10,
SUM(PE.C11) AS C11, SUM(PE.C12) AS C12, SUM(PE.C13) AS C13, SUM(PE.C14) AS C14, SUM(PE.C15) AS C15,
SUM(PE.C16) AS C16, SUM(PE.C17) AS C17, SUM(PE.C18) AS C18, SUM(PE.C19) AS C19, SUM(PE.C20) AS C20,
SUM(PE.C21) AS C21, SUM(PE.C22) AS C22,"
                            . "S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10,
S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20,
S.T21, S.T22, "
                            . "SC.A1, SC.A2, SC.A3, SC.A4, SC.A5, SC.A6, SC.A7, SC.A8, SC.A9, SC.A10,
SC.A11, SC.A12, SC.A13, SC.A14, SC.A15, SC.A16, SC.A17, SC.A18, SC.A19, SC.A20,
SC.A21, SC.A22, "
                            . "A.Grupo, "
                            . "FT.Articulo, "
                            . "A.Descripcion, "
                            . "U.Descripcion AS Unidad,"
                            . "PE.Pares,"
                            . "PE.Pares *  SUM(FT.Consumo) AS Explosion,"
                            . "SUM(FT.Consumo) AS Consumo,"
                            . "PM.Precio  "
                            . " "
                            . " ", false)
                    ->from('pedidox PE')
                    ->join('fichatecnica FT', 'ON FT.Estilo =  PE.Estilo AND FT.Color = PE.Color')
                    ->join('articulos A', 'ON A.Clave =  FT.Articulo')
                    ->join('unidades U', 'ON U.Clave = A.UnidadMedida')
                    ->join('estilos E', 'ON E.Clave = PE.Estilo')
                    ->join('series S', 'ON S.Clave =  E.Serie')
                    ->join('suelascompras SC', 'ON SC.ArticuloCBZ =  FT.Articulo')
                    ->join('preciosmaquilas PM', "ON PM.Articulo = FT.Articulo AND PM.Maquila ='$Maquila' ")
                    ->where("PE.Maquila BETWEEN $Maquila AND $aMaquila")
                    ->where("PE.Semana BETWEEN $Semana AND $aSemana")
                    ->where('PE.Ano', $Ano)
                    ->where('A.Clave', $Articulo)
                    ->where('PE.Estatus', 'A')
                    ->where('PE.Control <>  ', false)
                    ->where('PE.Control IS NOT NULL ', NULL, false);
            $this->db->where_in('A.Grupo', array('3', '50', '52'));

            //Agrupacion
            $this->db->group_by('A.Clave');


            //Ordenamiento
            $this->db->order_by('ClaveART', 'ASC');
            //$this->db->order_by('Explosion', 'DESC');



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
