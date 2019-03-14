<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            $this->db->select("C.ID AS ID, C.Clave AS Clave, C.RazonS AS Nombre", false)
                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO');
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

    public function onComprobarClave($C) {
        try {
            return $this->db->select("G.Clave")->from("clientes AS G")->where("G.Clave", $C)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("A.Clave AS CLAVE")->from("clientes AS A")->order_by("Clave", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstados() {
        try {
            return $this->db->select("E.Clave, CONCAT(E.Clave, \" - \", E.Descripcion) AS Estado", false)
                            ->from('estados AS E')
                            ->where_in('E.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getListasDePrecios() {
        try {
            return $this->db->select("LP.Lista AS Clave, CONCAT(LP.Lista,'-',LP.Descripcion) AS ListaPrecios", false)
                            ->from('listadeprecios AS LP')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPaises() {
        try {
            return $this->db->select("E.Clave, CONCAT(E.Clave, \" - \", E.Descripcion) AS Pais", false)
                            ->from('paises AS E')
                            ->where_in('E.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgentes() {
        try {
            return $this->db->select("A.Clave, CONCAT(A.Clave, \" - \", A.Nombre) AS Agente", false)
                            ->from('agentes AS A')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            return $this->db->select("G.Clave, CONCAT(G.Clave, \" - \", G.Descripcion) AS Grupo", false)
                            ->from('gruposclientes AS G')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getZonas() {
        try {
            return $this->db->select("Z.Clave, CONCAT(Z.Clave, \" - \", Z.Descripcion) AS Zona", false)
                            ->from('zonas AS Z')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTransportes() {
        try {
            return $this->db->select("T.Clave, CONCAT(T.Clave, \" - \", T.Descripcion) AS Transporte", false)
                            ->from('transportes AS T')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMetodosDePago() {
        try {
            return $this->db->select("MP.Clave, CONCAT(MP.Clave, \" - \", MP.Descripcion) AS \"Metodo de pago\"", false)
                            ->from('metodos_de_pago AS MP')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFormasDePago() {
        try {
            return $this->db->select("FP.Clave, CONCAT(FP.Clave, \" - \", FP.Descripcion) AS FormaDePago", false)
                            ->from('formaspago AS FP')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("clientes", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
//            PRINT "\n ID IN MODEL: $LastIdInserted \n";
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("clientes", $DATA);
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("clientes");
//            print $str = $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClienteByID($ID) {
        try {
            return $this->db->select('U.*', false)->from('clientes AS U')->where('U.ID', $ID)->where_in('U.Estatus', 'ACTIVO')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClienteXRFC($ID, $RFC) {
        try {
            $this->db->select("COUNT(C.ID) AS EXISTE", false)->from('clientes AS C')->where_in('C.RFC', $RFC);
            if ($ID > 0) {
                $this->db->where('C.ID <> ' . $ID, null, false);
            }
            $this->db->where_in('C.Estatus', 'ACTIVO');
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

}
