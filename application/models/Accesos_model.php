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
                    ->from('usuarios AS U')->order_by('ABS(U.ID)','ASC');
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
            return $this->db->select("IXO.ID, IXO.Item, IXO.Opcion", false)
                            ->from('itemsxopcion AS IXO')->where('IXO.Opcion', $O)
                            ->order_by('IXO.Item', 'ASC')->get()->result();
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
                            ->order_by('IXO.Item', 'ASC')
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

    public function onAsignarTodo($USUARIO) {
        try {
            $USUARIO_ASIGNA = $this->session->ID;
            $FECHA = Date('d/m/Y h:i:s a');
            $this->db->trans_start();
            $sql = "INSERT INTO `modulosxusuario` (`Modulo`, `Usuario`, `UsuarioAsigna`, `Fecha`) 
                SELECT A.ID AS MODULO,  $USUARIO AS USUARIO, $USUARIO_ASIGNA AS `USUARIO_ASIGNA`,'$FECHA' AS FECHA 
                FROM modulos AS A WHERE A.ID NOT IN (SELECT B.Modulo FROM modulosxusuario B WHERE B.Usuario = $USUARIO);";
            $this->db->query($sql);

            /* ASIGNANDO OPCIONES X MODULO X USUARIO */
            $sql_uno = "INSERT INTO `opcionesxmoduloxusuario` 
                (`Usuario`,`Modulo`,`Opcion`,`Fecha`,`UsuarioAsigna`) 
                SELECT $USUARIO AS USUARIO, A.Modulo AS MODULO, A.ID AS OPCION, "
                    . "'$FECHA' AS FECHA, $USUARIO_ASIGNA AS USUARIO_ASIGNA 
                        FROM   opcionesxmodulo AS A 
                        WHERE A.ID NOT IN (SELECT B.Opcion FROM opcionesxmoduloxusuario B WHERE B.Usuario = $USUARIO);";
            $this->db->query($sql_uno);

            /* ASIGNA ITEMS X OPCION X MODULO X USUARIO */
            $sql_dos = "INSERT INTO `itemsxopcionxmoduloxusuario` 
                (`Item`,`Opcion`,`Modulo`,`Usuario`,`UsuarioAsigna`,`Fecha`) 
                SELECT AA.ID AS ITEM, AA.Opcion AS OPCION, OXM.Modulo AS MODULO, 
                $USUARIO AS `USUARIO`, $USUARIO_ASIGNA AS `USUARIO_ASIGNA`, 
                    '$FECHA' AS FECHA 
                        FROM  itemsxopcion AS AA INNER JOIN opcionesxmodulo AS OXM ON AA.Opcion = OXM.ID 
                        WHERE AA.ID NOT IN ( 
                        SELECT A.ID FROM   itemsxopcion AS A 
                        INNER JOIN itemsxopcionxmoduloxusuario B 
                        ON A.ID = B.Item and B.Usuario = $USUARIO );";
            $this->db->query($sql_dos);

            /* ASIGNA SUBITEMS X ITEM X OPCION X MODULO X USUARIO */
            $sql_tres = "INSERT INTO `subitemsxitemxopcionxmoduloxusuario` 
                (`SubItem`,`Item`,`Opcion`,`Modulo`,`Usuario`,`UsuarioAsigna`,`Fecha`) 
                SELECT A.ID AS SUBITEM, B.ID AS ITEM, C.ID AS OPCION, C.Modulo AS MODULO, 
                    $USUARIO AS USUARIO, $USUARIO_ASIGNA AS `USUARIO_ASIGNA`,'$FECHA' AS FECHA 
                        FROM  subitemsxitem AS A INNER JOIN itemsxopcion AS B ON A.Item = B.ID 
                        INNER JOIN opcionesxmodulo AS C ON B.Opcion = C.ID  
                        WHERE A.ID NOT IN(SELECT  A.ID 
                        FROM  subitemsxitem AS A INNER JOIN itemsxopcion AS B 
                        ON A.Item = B.ID INNER JOIN opcionesxmodulo AS C ON B.Opcion = C.ID 
                        INNER JOIN subitemsxitemxopcionxmoduloxusuario AS AA ON A.ID = AA.SubItem 
                        WHERE AA.Usuario = $USUARIO);";
            $this->db->query($sql_tres);

            /* ASIGNA SUBITEMS X ITEM X OPCION X MODULO X USUARIO */
            $sql_cuatro = "INSERT INTO `subsubitemsxitemxopcionxmoduloxusuario` 
                (`SubSubItem`, `SubItem`, `Item`, `Opcion`, `Modulo`, `Usuario`, `UsuarioAsigna`, `Fecha`) 
                SELECT A.ID AS SUBSUBITEM, B.ID AS SUBITEM, C.ID AS ITEM, D.ID AS OPCION, 
                D.Modulo AS MODULO, $USUARIO AS USUARIO, $USUARIO_ASIGNA AS `USUARIO_ASIGNA`,'$FECHA' AS FECHA 
                FROM  subsubitemxsubitem AS A INNER JOIN subitemsxitem AS B ON A.SubItem = B.ID 
                INNER JOIN itemsxopcion AS C ON B.Item = C.ID INNER JOIN opcionesxmodulo AS D ON C.Opcion = D.ID 
                WHERE A.ID NOT IN(SELECT A.ID FROM  subsubitemxsubitem AS A INNER JOIN subitemsxitem AS B 
                ON A.SubItem = B.ID INNER JOIN itemsxopcion AS C ON B.Item = C.ID 
                INNER JOIN opcionesxmodulo AS D ON C.Opcion = D.ID 
                INNER JOIN subsubitemsxitemxopcionxmoduloxusuario AS AA ON A.ID = AA.SubSubItem 
                WHERE AA.Usuario = $USUARIO);";
            $this->db->query($sql_cuatro);
            $this->db->trans_complete();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
