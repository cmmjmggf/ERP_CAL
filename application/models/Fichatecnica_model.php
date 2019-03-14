<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Fichatecnica_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function onLimpiarTabla() {
        try {
            $sql = "TRUNCATE TABLE fichatecnicatemp;";
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarRecords() {
        try {
            $sql = "INSERT INTO fichatecnicatemp (estilo, color) SELECT estilo, color FROM fichatecnica AS FT GROUP BY Estilo, Color;";
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $this->db->select("FTT.Estilo AS EstiloId, "
                            . "FTT.Color AS ColorId, "
                            . "CONCAT(FTT.Estilo,' - ',E.Descripcion) AS Estilo, "
                            . "CONCAT(FTT.Color,' - ',C.Descripcion) AS Color "
                            . " ", false)
                    ->from('fichatecnicatemp AS FTT')
                    ->join('estilos AS E', 'FTT.Estilo = E.Clave')
                    ->join('colores AS C', 'FTT.Color = C.Clave AND C.Estilo = FTT.Estilo');

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

    public function getFichaTecnicaDetalleByID($Estilo, $Color) {
        try {
            $this->db->select('
            P.Clave AS Pieza_ID,
            CONCAT(P.Clave, \'-\', P.Descripcion) AS Pieza,
            FT.Articulo Articulo_ID,
            CONCAT(M.Clave, \'-\', M.Descripcion) AS Articulo,
            C.Descripcion AS Unidad,
            CONCAT(\'\', FT.Consumo, \'\') AS Consumo,
            IFNULL(FT.PzXPar, 1) AS PzXPar,
            FT.ID AS ID,
            CONCAT(\'<span class="fa fa-trash fa-lg " onclick="onEliminarArticuloID(\', FT.ID, \')">\', \'</span>\') AS Eliminar,
            CONCAT(D.Clave, \' - \', D.Descripcion) AS DeptoCat,
            D.Clave AS DEPTO,FT.AfectaPV ', false)
                    ->from('fichatecnica AS FT')
                    ->join('`articulos` AS `M`', '`FT`.`Articulo` = `M`.`Clave`')
                    ->join('`piezas` AS `P`', '`FT`.`Pieza` = `P`.`Clave`')
                    ->join('unidades AS C', '`M`.`UnidadMedida` = `C`.`Clave`')
                    ->join('departamentos AS D', '`P`.`Departamento` = `D`.`Clave`')
                    ->where('FT.Estilo', $Estilo)->where('FT.Color', $Color)
                    ->where('FT.Estatus', 'ACTIVO');
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

    public function onComprobarExisteEstiloColor($Estilo, $Color) {
        try {
            return $this->db->select('COUNT(*) AS EXISTE', false)->from('fichatecnica AS FT ')
                            ->where('FT.Estilo', $Estilo)->where('FT.Color', $Color)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("fichatecnica", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("fichatecnica", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarDetalle($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("fichatecnica", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('Estilo', $ID)->update("fichatecnica");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRenglonDetalle($ID) {
        try {
            $this->db->where('ID', $ID)->delete("fichatecnica");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaByEstiloByColor($Estilo, $Color) {
        try {
            return $this->db->select('U.*', false)->from('fichatecnica AS U')
                            ->where('U.Estilo', $Estilo)->where('U.Color', $Color)
                            ->where_in('U.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosRequeridos($Familia) {
        try {
            return $this->db->select("M.Clave AS ID, CONCAT(M.Clave,' - ', IFNULL(M.Descripcion,'')) AS Articulo", false)
                            ->from('articulos AS M')->where_in('M.Estatus', array('ACTIVO'))->where_in('M.Grupo', $Familia)
                            ->order_by("M.Clave", "ASC")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByClave($Clave) {
        try {
            $this->db->select("CAST(M.Clave AS SIGNED ) AS Clave, IFNULL(M.Descripcion,'') AS Articulo", false)
                    ->from('articulos AS M')
                    ->where_in('M.Estatus', array('ACTIVO'));
            $this->db->where('M.Clave', $Clave);
            $this->db->or_like('M.Descripcion', $Clave);


            $this->db->order_by("Clave", "ASC");
            $query = $this->db->get();
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezas() {
        try {
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ID, CONCAT(P.Clave,' - ',IFNULL(P.Descripcion,'')) AS Descripcion ", false)
                            ->from('piezas AS P')
                            ->where_in('P.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            return $this->db->select("CAST(A.Clave AS SIGNED ) AS ID, CONCAT(A.Clave,' - ',IFNULL(A.Descripcion,'')) AS Descripcion ", false)
                            ->from('articulos AS A')
                            ->where_in('A.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            return $this->db->select("E.Clave AS Clave, CONCAT(E.Clave,' - ',IFNULL(E.Descripcion,'')) AS Estilo")
                            ->from("estilos AS E")
                            ->where("E.Estatus", "ACTIVO")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            return $this->db->select("CAST(G.Clave AS SIGNED ) AS ID, CONCAT(G.Clave,'-', G.Nombre) AS Grupo")
                            ->from("grupos AS G")
                            ->where("G.Estatus", "ACTIVO")
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloByID($ID) {
        try {
            return $this->db->select('E.*', false)->from('estilos AS E')->where('E.Clave', $ID)->where_in('E.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioPorArticuloByID($ID) {
        try {
            $this->db->select('PM.Precio AS PRECIO', false)->from('articulos AS E')
                    ->join('preciosmaquilas AS PM', 'E.Clave = PM.Articulo')
                    ->where('E.Clave', $ID)->where_in('E.Estatus', 'ACTIVO');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo($Estilo) {
        try {
            return $this->db->select("CAST(C.Clave AS SIGNED ) AS ID, CONCAT(C.Clave,'-', C.Descripcion) AS Descripcion ", false)
                            ->from('colores AS C')
                            ->where('C.Estilo', $Estilo)
                            ->where('C.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosByLinea($Linea) {
        try {

            return $this->db->select("E.Clave AS Clave, CONCAT(E.Clave,' - ',IFNULL(E.Descripcion,'')) AS Estilo")
                            ->from("estilos AS E")
                            ->where('E.Linea', $Linea)
                            ->where("E.Estatus", "ACTIVO")
                            ->order_by('Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
