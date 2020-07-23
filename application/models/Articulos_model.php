<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Articulos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("A.ID AS ID, A.Clave AS Clave, "
                                    . "A.Descripcion AS Descripcion,"
                                    . "(SELECT Descripcion as Unidad from unidades where clave = A.UnidadMedida ) as Unidad, "
                                    . "concat('$',(SELECT FORMAT (ifnull(Precio,0),2) as Precio from preciosmaquilas where Maquila = 1 and Articulo = A.Clave limit 1)) as Precio,"
                                    . "(CASE "
                                    . "WHEN A.Estatus ='ACTIVO' THEN CONCAT('<span class=\'badge badge-success \'>','ACTIVO','</span>') "
                                    . "WHEN A.Estatus ='INACTIVO' THEN CONCAT('<span class=\'badge badge-danger \'>','INACTIVO','</span>')"
                                    . " END) AS Estatus "
                                    . "", false)
                            ->from("articulos AS A")
                            //->where('A.Estatus', 'ACTIVO')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecordsConsulta($Grupo) {
        try {
            $this->db->select("A.ID AS ID, "
                            . "CONCAT(G.Clave,' ',G.Nombre) AS Grupo, "
                            . "A.Clave AS Clave, "
                            . "A.Descripcion AS Descripcion,"
                            . "U.Descripcion AS Unidad, "
                            . "CASE WHEN A.ProveedorUno = 0 THEN '' ELSE A.ProveedorUno END AS P1 , "
                            . "CASE WHEN A.ProveedorDos = 0 THEN '' ELSE A.ProveedorDos END AS P2 , "
                            . "CASE WHEN A.ProveedorTres = 0 THEN '' ELSE A.ProveedorTres END AS P3, "
                            . "CASE WHEN A.UbicacionUno = 0 THEN '' ELSE A.UbicacionUno END AS U1 , "
                            . "CASE WHEN A.UbicacionDos = 0 THEN '' ELSE A.UbicacionDos END AS U2 , "
                            . "CASE WHEN A.UbicacionTres = 0 THEN '' ELSE A.UbicacionTres END AS U3, "
                            . "CASE WHEN A.UbicacionCuatro = 0 THEN '' ELSE A.UbicacionCuatro END AS U4 "
                            . "", false)
                    ->from("articulos AS A")
                    ->join("unidades AS U", "U.Clave =  A.UnidadMedida ")
                    ->join("grupos AS G", "G.Clave =  A.Grupo ");

            if ($Grupo !== '') {
                $this->db->where('A.Grupo', $Grupo);
            }
            return $this->db
                            //->where('A.Estatus', 'ACTIVO')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticuloByID($ID) {
        try {
            return $this->db->select("A.*, date_format(A.Registro,'%d/%m/%Y')  as Registro ", false)->from("articulos AS A")->where('A.Clave', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrimerMaquilaPrecio($Clave) {
        try {
            return $this->db->select("PM.Precio AS PRECIO", false)->from('preciosmaquilas AS PM')
                            ->where('PM.Articulo', $Clave)->order_by('PM.ID', 'ASC')->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasXArticulo($Articulo) {
        try {
            return $this->db->select("PM.ID as ID ,PM.Maquila  AS Maquila", false)
                            ->from("preciosmaquilas AS PM")
                            ->where('PM.Articulo', $Articulo)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas($ID) {
        try {
            return $this->db->select("M.Clave AS ID,CONCAT(M.Clave,' - ',IFNULL( M.Nombre,'')) AS Maquila", false)->from("maquilas AS M")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleByID($ID) {
        try {
            $this->db->select("pvm.ID AS ID,"
                            . "CONCAT(M.Clave,' - ', M.Nombre) AS Maquila, "
                            . "pvm.Precio AS Precio, "
                            . "'A' AS Estatus,"
                            . "M.Clave AS ClaveMaquila ", false)->from("preciosmaquilas AS pvm")
                    ->join('maquilas AS M', 'pvm.Maquila = M.Clave')->where('pvm.Articulo', $ID)->like('pvm.Estatus', 'A');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("CONVERT(A.Clave, UNSIGNED INTEGER) AS CLAVE")->from("articulos AS A")->order_by("CLAVE", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            return $this->db->select("G.Clave AS ID, CONCAT(G.Clave,' - ',  IFNULL(G.Nombre,'')) AS Grupo", false)
                            ->from("grupos AS G")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUnidades() {
        try {
            return $this->db->select("U.Clave AS ID, CONCAT(U.Clave,' - ', IFNULL(U.Descripcion,'')) AS Unidad", false)
                            ->from("unidades AS U")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            return $this->db->select("P.Clave AS ID, CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS Proveedor", false)
                            ->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("articulos", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('Clave', $ID)->update("articulos", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("articulos");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSuelasPlantas() {
        try {
            return $this->db->select("P.Clave AS ID, CONCAT(P.Clave,' ',P.Descripcion) AS Articulo", false)
                            ->from("articulos AS P")
                            ->where('P.Departamento', '80')
                            ->order_by("P.Descripcion", "ASC")
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
