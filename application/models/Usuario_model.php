<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("ID, U.usuario  AS Nombre,
                CONCAT('<span class=\'label label-info\'>',ifnull(U.UltimoAcceso,'--'),'</span>') AS 'Último Acceso',
                  (CASE WHEN  U.Estatus ='ACTIVO' THEN CONCAT('<span class=\'label label-success\'>','ACTIVO','</span>')
                    ELSE CONCAT('<span class=\'label label-danger\'>','INACTIVO','</span>') END) AS Estatus ,
                    U.TipoAcceso AS Acceso
                    FROM usuarios AS U; ", false)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAcceso($USUARIO, $CONTRASENA) {
        try {
            $this->db->select('U.*,'
                    . 'E.Representante AS EMPRESA_REPRESENTANTE, '
                    . 'E.RazonSocial AS EMPRESA_RAZON,'
                    . 'E.Direccion AS EMPRESA_DIRECCION, '
                    . 'E.Colonia AS EMPRESA_COLONIA, '
                    . 'E.RFC AS EMPRESA_RFC, '
                    . 'E.Telefono AS EMPRESA_TELEFONO, '
                    . 'E.NoExt AS EMPRESA_NOEXT, '
                    . 'E.CP AS EMPRESA_CP, '
                    . 'E.Foto AS LOGO,'
                    . 'ES.Descripcion AS EMPRESA_ESTADO,'
                    . 'E.Ciudad AS EMPRESA_CIUDAD,'
                    . 'E.MH AS TIPOMH', false);
            $this->db->from('usuarios AS U')
                    ->join('empresas AS E', 'U.Empresa = E.ID')
                    ->join('estados AS ES', 'E.Estado = ES.Clave')
                    ->where('U.Usuario', $USUARIO)
                    ->where('\'' . $CONTRASENA . '\'  = AES_DECRYPT(U.AES, \'System32\')', NULL, FALSE);
            $this->db->where_in('U.Estatus', 'ACTIVO');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getContrasena($USUARIO) {
        try {
            $this->db->select('U.Contrasena', false);
            $this->db->from('usuarios AS U');
            $this->db->where('U.Usuario', $USUARIO);
            $this->db->where_in('U.Estatus', 'Activo');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//       print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("usuarios", $array);
            print $str = $this->db->last_query();
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
            $this->db->where('ID', $ID);
            $this->db->update("usuarios", $DATA);
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
 

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'Inactivo');
            $this->db->where('ID', $ID);
            $this->db->update("usuarios");
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUsuarioByID($ID) {
        try {
            /* PARA LINUX */
//            $this->db->select('U.ID, U.Usuario, U.Estatus, U.Nombre, U.Apellidos, '
//                    . 'U.TipoAcceso, U.UltimoAcceso, U.Registro, U.UltimaModificacion, '
//                    . 'CONVERT(AES_DECRYPT(U.AES,\'System32\') USING latin1) AS Contrasena, '
//                    . 'U.Seguridad AS SEG, U.Empresa', false);
            /* WINDOWS */
            $this->db->select('U.ID, U.Usuario, U.Estatus, U.Nombre, U.Apellidos, '
                    . 'U.TipoAcceso, U.UltimoAcceso, U.Registro, U.UltimaModificacion, '
                    . 'CAST(AES_DECRYPT(U.AES, \'System32\') AS CHAR(500)) AS Contrasena , '
                    . 'U.Seguridad AS SEG, U.Empresa', false);
            $this->db->from('usuarios AS U');
            $this->db->where('U.ID', $ID);
            //$this->db->where_in('U.Estatus', 'Activo');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpresas() {
        try {
            return $this->db->select("CAST(P.Clave AS SIGNED ) AS ID, CONCAT(P.Clave,' - ',IFNULL(P.RazonSocial,'')) AS Empresa ", false)
                            ->from('empresas AS P')
                            ->where_in('P.Estatus', 'ACTIVO')
                            ->order_by('ID', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerClave($CLAVE) {
        try {
            return $this->db->select("CONVERT(AES_DECRYPT(CAST(AES AS CHAR(10000) CHARACTER SET utf8),'System32') USING latin1) AS PW", false)
                            ->from("usuarios AS U")->where("U.ID", $CLAVE)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
