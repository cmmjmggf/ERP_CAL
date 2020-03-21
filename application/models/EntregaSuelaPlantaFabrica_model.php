<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class EntregaSuelaPlantaFabrica_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function onVerificarMaterialEntregado($Control, $Tipo) {
        try {
            $this->db->select("M.* "
                            . "")
                    ->from("movarticulos AS M")
                    ->where("M.Control", $Control)
                    ->where("M.TpoSuPlEn", $Tipo);
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

    public function getPedidoByControl($Control) {
        try {
            $this->db->select("PD.* ,S.* ,PD.EstatusProduccion, "
                            . "CONCAT(ifnull(M.EntregaMat1,''),' - ',ifnull(M.EntregaMat2,''),' - ',ifnull(M.EntregaMat3,'')) AS EntregaMat "
                            . "")
                    ->from("pedidox AS PD")
                    ->join("series AS S", 'ON PD.Serie = S.Clave ')
                    ->join("maquilas AS M", 'ON PD.Maquila = M.Clave ')
                    ->where("PD.Control", $Control)->where("PD.stsavan <> 14", null, false);
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

    public function getCabeceroFichaTecnica($Estilo, $Color, $Tipo) {
        try {
            $this->db->select("CONCAT(A.Clave,' ', A.Descripcion) AS Cabecero, SC.*  "
                            . "")
                    ->from("fichatecnica AS FT")
                    ->join("articulos AS A", 'ON A.Clave =  FT.Articulo ')
                    ->join("piezas AS P", 'ON P.Clave =  FT.Pieza ')
                    ->join("suelascompras AS SC", 'ON SC.ArticuloCBZ = FT.Articulo  ')
                    ->where("FT.Estilo", $Estilo)
                    ->where("FT.Color", $Color)
                    ->where("P.TipoPiezaTallas", $Tipo);
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

    public function getPrecioArticulosByMaquila($Maquila, $Articulo) {
        try {
            $this->db->select("PM.Precio "
                            . "")
                    ->from("preciosmaquilas AS PM")
                    ->where("PM.Maquila", $Maquila)
                    ->where("PM.Articulo", $Articulo);
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

    public function onAgregar($array) {
        try {
            $this->db->insert("movarticulos", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            return $row['LAST_INSERT_ID()'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporte($doc) {
        try {
            $this->db->query("set sql_mode=''");
            return $this->db->select("A.Clave, "
                                    . "A.Descripcion, "
                                    . "MA.FechaMov, "
                                    . "sum(MA.CantidadMov) AS CantidadMov, "
                                    . "MA.Sem , "
                                    . "MA.Maq, "
                                    . "MA.PrecioMov, "
                                    . "sum(MA.Subtotal) AS Subtotal, "
                                    . "MA.TipoMov, "
                                    . "MA.DocMov,"
                                    . "U.Descripcion AS Unidad "
                                    . "", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                            ->where('MA.DocMov', $doc)
                            ->group_by('A.Clave')
                            ->order_by('A.Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
