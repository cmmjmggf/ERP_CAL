
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Fichatecnicafija_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select(""
                    . "CONCAT(FTF.Pieza,'-',P.Descripcion) AS Pieza, "
                    . "CONCAT(FTF.Articulo,'-',A.Descripcion)  AS Material,  "
                    . "CONCAT('<strong>',D.Clave,'-',D.Descripcion,'</strong>') AS Departamento, "
                    . "CONCAT(G.Clave, '-', G.Nombre)  AS Grupo,  "
                    . "CAST(G.Clave AS SIGNED ) AS GID,"
                    . "FTF.Consumo AS Consumo, "
                    . "CONCAT('<strong>',U.Descripcion,'</strong>') AS Unidad, "
                    . "CONCAT('<span class=''fa fa-trash fa-lg text-danger'' onclick=''onEliminar(',FTF.Pieza, ',' , FTF.Articulo ,')  ''></span>') AS Eliminar "
                    . " ", false);
            $this->db->from('fichatecnicafija AS FTF');
            $this->db->join('piezas AS P', 'P.Clave = FTF.Pieza', 'left');
            $this->db->join('articulos AS A', 'A.Clave = FTF.Articulo', 'left');
            $this->db->join('grupos AS G', 'G.Clave = A.Grupo', 'left');
            $this->db->join('departamentos AS D', 'D.Clave = P.Departamento', 'left');
            $this->db->join('unidades AS U', 'U.Clave = A.UnidadMedida', 'left');
            //$this->db->order_by('GID', 'ASC');
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

    public function getGrupos() {
        try {
            return $this->db->select("CONVERT(E.Clave, UNSIGNED INTEGER) AS ID ,CONCAT(E.Clave,'-',IFNULL(E.Nombre,'')) AS Grupo")->from("grupos AS E")->where("E.Estatus", "ACTIVO")->order_by('ID', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezas() {
        try {
            return $this->db->select("CONVERT(E.Clave, UNSIGNED INTEGER) AS ID ,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Pieza")->from("piezas AS E")->where("E.Estatus", "ACTIVO")->order_by('ID', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos($Grupo) {
        try {
            return $this->db->select("CONVERT(E.Clave, UNSIGNED INTEGER) AS ID ,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Articulo")->from("articulos AS E")->where("E.Estatus", "ACTIVO")->where('E.Grupo', $Grupo)->order_by('ID', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("fichatecnicafija", $array);
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
            $this->db->where('ID', $ID)->update("fichatecnicafija", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($IDP, $IDM) {
        try {
            $this->db->where('Pieza', $IDP)->where('Pieza', $IDP)->delete("fichatecnicafija");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
