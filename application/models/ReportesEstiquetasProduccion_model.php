<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesEstiquetasProduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getSuelaFromFichaTecnica($estilo, $color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("A.Descripcion AS Suela from fichatecnica FT
                                join articulos A  on  FT.Articulo = A.Clave
                                where FT.Estilo = '$estilo'  and FT.Color = '$color' AND A.Grupo= 3
                                limit 1  "
                    . " ", false);


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

    public function getDatosSerie($serie) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select('C.* '
                            . " ", false)
                    ->from('series C')
                    ->where('C.Clave', $serie);


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

    public function getDatosEtiqueta($estilo, $color) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select('C.trEtiqueta, C.trPiel, C.trForro, C.trSuela '
                            . " ", false)
                    ->from('colores C')
                    ->where('C.Estilo', $estilo)
                    ->where('C.Clave', $color);


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

    public function getControlesParaEtiquetas($Año, $Sem, $Maq, $Control, $AControl) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select('* '
                            . " ", false)
                    ->from('pedidox')
                    ->where('ano', $Año)
                    ->where('semana', $Sem)
                    ->where('maquila', $Maq)
                    ->where("control between '$Control' and '$AControl' ", null, false)
                    ->where_in('Estatus', array('A', 'F'))->where('Control > 0', null, false)->order_by('Control', 'ASC');


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

    /* Cajas XLS */

    public function getControlesParaEtiquetasCajas($Año, $Sem, $Maq, $Control, $AControl, $Tipo, $Cliente) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select('* '
                            . " ", false)
                    ->from('pedidox');
            /* Sí elije buscar por control aejecuta el primer where si no lo hace por maquila semana año */
            if ($Tipo === '1') {
                $this->db->where("control between '$Control' and '$AControl' ", null, false);
            } else {
                $this->db->where('ano', $Año)->where('semana', $Sem)->where('maquila', $Maq);
            }
            $this->db->like('cliente', $Cliente);
            $this->db->where_in('Estatus', array('A', 'F'))->where('Control > 0', null, false)->order_by('Control', 'ASC');


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

    public function getDatosReporteExcelGenerico() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db
                    ->select("control,estiped,punto,tpo,combped,recio,concat('*',contped,'*') as cod1,contped as cod2 "
                            , false)
                    ->from('etiqcaja');

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

    public function getDatosReporteExcelPriceSuper() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("ECB.estilocte as estilo, ECB.color as color, '' as c3, ECB.idart, ECB.nomprov,
                            '' as c6, EC.control, EC.punto,ECB.codbarr,'Clave Proveedor 1219' AS ClaveProv,'' as c11,
                            EC.recio as Pedido,ECB.catalogo FROM etiqcaja EC
                            JOIN etiqcodbarr ECB on EC.estiped = ECB.estilo AND EC.combped = ECB.comb
                            AND EC.punto = ECB.talla and EC.cliente = ECB.cliente ", false);

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result_array();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosReporteExcelPakar() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select(" EC.control,
                                ECB.estilocte as estilo,
                                ECB.idart as color,
                                ECB.color as piel,
                                EC.suela,
                                EC.punto,
                                ECB.codbarr
                                FROM etiqcaja EC
                                JOIN etiqcodbarr ECB on EC.estiped = ECB.estilo AND EC.combped = ECB.comb and EC.punto = ECB.talla and EC.cliente = ECB.cliente  "
                    . "", false);

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result_array();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
