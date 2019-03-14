<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReporteCotejaOrdComExplosion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getRegistros($Ano, $Semana, $aSemana, $Maquila, $aMaquila, $TipoE, $MesAnt) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("A.Grupo, "
                            . "FT.Articulo, "
                            . "A.Descripcion, "
                            . "U.Descripcion AS Unidad,"
                            . "ifnull(A.$MesAnt,0) AS Inv_Ini,"
                            /* Compras en firme */
                            /*  quitar el año y poner parameto */
                            . "ifnull((select OC.Cantidad from ordencompra OC
                                where OC.Articulo = A.Clave
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem BETWEEN $Semana AND $aSemana
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA','INACTIVA')
                                 ),0) AS CantPedida,"
                            /* Compras recibidas  quitar el año y poner parameto */
                            . "ifnull((select OC.CantidadRecibida from ordencompra OC
                                where OC.Articulo = A.Clave
                                and OC.Maq BETWEEN $Maquila AND $aMaquila
                                AND OC.Sem BETWEEN $Semana AND $aSemana
                                AND OC.Ano =  $Ano
                                AND OC.Estatus NOT IN ('CANCELADA','INACTIVA')
                                ),0) AS CantEntregada,"
                            /* Entregado a maquilas */
                            . "ifnull((select sum(MA.CantidadMov) from movarticulos MA
                                where  MA.tipomov in ('SXM','SPR','SXP','SXC')
                                and MA.EntradaSalida = '2'
                                and MA.Articulo = A.Clave
                                and MA.Maq BETWEEN $Maquila AND $aMaquila
                                AND MA.Sem BETWEEN $Semana AND $aSemana
                                AND MA.Ano = $Ano
                                ),0) AS EntregadoMaquilas, "
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
            $this->db->order_by('A.Descripcion', 'ASC');

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
