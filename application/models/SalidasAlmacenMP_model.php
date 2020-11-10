<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class SalidasAlmacenMP_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($doc) {
        try {
            return $this->db->select("MA.ID, A.Clave, A.Descripcion, MA.CantidadMov, MA.Maq, MA.TipoMov, "
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',MA.ID,\')">\',\'</span>\') AS Eliminar'
                                    . "", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->where('MA.DocMov', $doc)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecordsSubAlmacen($doc) {
        try {
            return $this->db->select("MA.ID, A.Clave, A.Descripcion, MA.CantidadMov, MA.Maq, MA.TipoMov, "
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',MA.ID,\')">\',\'</span>\') AS Eliminar'
                                    . "", false)
                            ->from("movarticulos_fabrica MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->where('MA.DocMov', $doc)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMatEntregado($Ano, $Maq, $Sem, $Articulo) {
        try {
            $this->db->select("MA.DocMov,MA.Articulo, MA.CantidadMov "
                            . "", false)
                    ->from("movarticulos MA")
                    ->where('MA.EntradaSalida', '2')
                    ->where_in('MA.TipoMov', array('SXM', 'SPR', 'SXP', 'SXC'))
                    ->where('MA.Maq', $Maq)
                    ->where('MA.Sem', $Sem)
                    ->where('MA.Ano', $Ano)
                    ->where('MA.Articulo', $Articulo);
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

    public function getDatosByArticulo($Mat, $Maq, $d1, $d2, $d3) {
        try {
            $Maquila = ($Maq === '97' || $Maq === '98') ? 1 : $Maq;
            $this->db->select("PM.Precio, U.Descripcion AS Unidad, M.grupo "
                            . "")
                    ->from("articulos AS M")
                    ->join("unidades AS U", 'ON U.Clave = M.UnidadMedida')
                    ->join("preciosmaquilas AS PM", 'ON M.Clave = PM.Articulo')
                    ->where_in("M.Departamento", array($d1, $d2, $d3))
                    ->where("M.Clave", $Mat)
                    ->where("PM.Maquila", $Maquila);
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

    public function getArticulos($depto) {
        try {
            return $this->db->query("SELECT CAST(D.Clave AS SIGNED ) AS ID ,CONCAT(D.Descripcion) AS Articulo
                                    FROM articulos D WHERE
                                    (D.estatus = 'INACTIVO' AND D.Existencia > 0)
                                    OR
                                    (D.estatus = 'ACTIVO')
                                    and D.Departamento = '{$depto}'
                                    ORDER BY Articulo ASC ")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select(""
                            . "G.Clave, "
                            . "G.Direccion, "
                            . "CONCAT(ifnull(G.EntregaMat1,''),' - ',ifnull(G.EntregaMat2,''),' - ',ifnull(G.EntregaMat3,'')) AS EntregaMat,"
                            . "ifnull(G.EntregaMat1,'') AS Depto1, "
                            . "ifnull(G.EntregaMat2,'') AS Depto2, "
                            . "ifnull(G.EntregaMat3,'') AS Depto3 "
                            . "")->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion($Clave, $Ano) {
        try {
            return $this->db->select("G.Sem")->from("semanasproduccion AS G")->where("G.Sem", $Clave)->where("G.Ano", $Ano)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada($Ano, $Maq, $Sem) {
        try {
            $this->db->select("G.Estatus")->from("semanasproduccioncerradas AS G")
                    ->where("G.Ano", $Ano)
                    ->where("G.Maq", $Maq)
                    ->where("G.Sem", $Sem);
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
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarSubAlmacen($array) {
        try {
            $this->db->insert("movarticulos_fabrica", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('ID', $ID);
            $this->db->delete("movarticulos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporte($doc) {
        try {
            return $this->db->select("A.Clave, "
                                    . "A.Descripcion, "
                                    . "MA.FechaMov, "
                                    . "MA.CantidadMov, "
                                    . "MA.Sem , "
                                    . "MA.Maq, "
                                    . "MA.PrecioMov, "
                                    . "MA.Subtotal, "
                                    . "MA.TipoMov, "
                                    . "MA.DocMov,"
                                    . "U.Descripcion AS Unidad "
                                    . "", false)
                            ->from("movarticulos MA")
                            ->join("articulos A", 'ON A.Clave = MA.Articulo')
                            ->join("unidades U", 'ON U.Clave = A.UnidadMedida')
                            ->where('MA.DocMov', $doc)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
