<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Accesos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getTiposDeAcceso() {
        try {
            $this->db->select("GROUP_CONCAT(DISTINCT U.TipoAcceso ORDER BY U.TipoAcceso ASC SEPARATOR ',') AS TIPOS_DE_ACCESO", false)
                    ->from('usuarios AS U');
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

    public function getUsuarios() {
        try {
            $this->db->select("U.ID AS ID, U.Usuario AS USUARIO, U.TipoAcceso AS TIPO_ACCESO", false)
                    ->from('usuarios AS U');
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

    public function getModulos() {
        try {
            $this->db->select("M.ID, M.Modulo, M.Fecha, M.Icon, M.Ref, M.Order", false)
                    ->from('modulos AS M');
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

    public function getOpciones($M) {
        try {
            $this->db->select("OXM.ID, OXM.Modulo, OXM.Opcion, OXM.Fecha, OXM.Icon, OXM.Ref, OXM.Order, OXM.Button, OXM.Class", false)
                    ->from('opcionesxmodulo AS OXM')->where('OXM.Modulo', $M)->order_by('OXM.Order', 'ASC');
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

    public function getItems($O) {
        try {
            $this->db->select("IXO.ID, IXO.Item, IXO.Opcion", false)
                    ->from('itemsxopcion AS IXO')->where('IXO.Opcion', $O);
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

    public function getSubItems($I) {
        try {
            $this->db->select("SIXI.ID, SIXI.SubItem, SIXI.Item, SIXI.Dropdown", false)
                    ->from('subitemsxitem AS SIXI')->where('SIXI.Item', $I);
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

    public function getSubSubItems($I) {
        try {
            $this->db->select("SSI.ID, SSI.SubSubItem, SSI.SubItem", false)
                    ->from('subsubitemxsubitem AS SSI')->where('SSI.SubItem', $I);
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

    public function getModulosXUsuario($U) {
        try {
            return $this->db->select("M.ID, M.Modulo", false)
                            ->from('modulosxusuario AS U')
                            ->join('modulos AS M', 'U.Modulo = M.ID')
                            ->where('U.Usuario', $U)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModuloxUsuario($U, $M) {
        try {
            return $this->db->select("OXM.ID, OXM.Opcion", false)
                            ->from('opcionesxmoduloxusuario AS OXMU')
                            ->join('opcionesxmodulo AS OXM', 'OXMU.Opcion = OXM.ID')
                            ->where('OXMU.Usuario', $U)
                            ->where('OXMU.Modulo', $M) 
                            ->order_by('OXM.Order', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getItemsXOpcionXModuloxUsuario($U, $M, $O) {
        try {
            return $this->db->select("IXO.ID, IXO.Item", false)
                            ->from('itemsxopcionxmoduloxusuario AS IXOMU')
                            ->join('itemsxopcion AS IXO', 'IXOMU.Item = IXO.ID')
                            ->where('IXOMU.Usuario', $U)
                            ->where('IXOMU.Modulo', $M)
                            ->where('IXOMU.Opcion', $O)
                            ->where('IXO.Opcion', $O)
                            ->order_by('IXO.Order', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    public function getItemsConSubItemsXOpcionXModuloxUsuario($U, $M, $O) {
        try {
            return $this->db->select("IXO.ID, IXO.Item, IXO.Dropdown", false)
                            ->from('itemsxopcionxmoduloxusuario AS IXOMU')
                            ->join('itemsxopcion AS IXO', 'IXOMU.Item = IXO.ID')
                            ->where('IXOMU.Usuario', $U)
                            ->where('IXOMU.Modulo', $M)
                            ->where('IXOMU.Opcion', $O)
                            ->where('IXO.Opcion', $O)
                            ->where('IXO.Dropdown', 1)
                            ->order_by('IXO.Order', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubItemsXItemXOpcionXModuloxUsuario($U, $M, $O, $I) {
        try {
            return $this->db->select("I.ID, I.SubItem, I.Dropdown", false)
                            ->from('subitemsxitemxopcionxmoduloxusuario AS SI')
                            ->join('subitemsxitem AS I', 'SI.SubItem = I.ID')
                            ->where('SI.Usuario', $U)
                            ->where('SI.Modulo', $M)
                            ->where('SI.Opcion', $O)
                            ->where('SI.Item', $I)
                            ->order_by('I.Order', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubSubItemsXSubItemXItemXOpcionXModuloxUsuario($U, $M, $O, $I, $SI) {
        try {
            return $this->db->select("I.ID, I.SubSubItem", false)
                            ->from('subsubitemsxitemxopcionxmoduloxusuario AS SI')
                            ->join('subsubitemxsubitem AS I', 'SI.SubSubItem = I.ID')
                            ->where('SI.Usuario', $U)
                            ->where('SI.Modulo', $M)
                            ->where('SI.Opcion', $O)
                            ->where('SI.Item', $I)
                            ->where('SI.SubItem', $SI)
                            ->order_by('I.Order', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
