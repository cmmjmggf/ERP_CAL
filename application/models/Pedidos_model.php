<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Pedidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords() {
        try {
            return $this->db->select("P.ID, P.Clave, P.Cliente AS Cliente, P.Agente Agente,P.FechaPedido,SUM(P.Pares) AS Pares", false)
                            ->from('pedidox AS P')->group_by('P.Clave')->group_by('P.Cliente')
                            ->order_by('P.FechaPedido', 'DESC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getIDXClave($Clave, $CLIENTE) {
        try {
            return $this->db->select('P.Clave AS ID, P.Clave, P.Cliente')->from('pedidox AS P')
                            ->where('P.Clave', $Clave)
                            ->where('P.Cliente', $CLIENTE)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosByID($ID, $CLIENTE) {
        try {
            $data = $this->db->select("P.ID as PDID, P.Clave, P.Cliente, P.Agente, P.FechaPedido, P.FechaRecepcion, P.Usuario, P.Estatus, P.Registro,
                                    P.Clave AS Pedido, P.Estilo,P.EstiloT, P.Color, P.ColorT,P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio,
                                    P.Precio, P.Observacion, P.ObservacionDetalle, P.Serie, P.Control,
                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,
                                    'A' AS EstatusDetalle, P.Recibido, P.Pares, CONCAT(C.Clave,'-',C.RazonS) AS ClienteT,
                                    CONCAT(A.Clave, \" - \", A.Nombre) AS AgenteT", false)
                            ->from('pedidox AS P')
                            ->join('clientes AS C', 'P.Cliente = C.Clave')
                            ->join('agentes AS A', 'P.Agente = A.Clave', 'left')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->limit(1)
                            ->get()->result();
//            print $this->db->last_query();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoDByID($ID, $CLIENTE) {
        try {
            $ini = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla\" align=\"center\">';
            $mid = '</div><div class="col-12 cantidad" align="center">';
            $end = '</div></div>';
            $data = $this->db->select("P.ID as PDID,
                                    P.Clave AS Pedido,
                                    P.Estilo, P.EstiloT,
                                    P.Color, P.ColorT, P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio,
                                    P.Precio, P.Observacion, P.ObservacionDetalle, P.Serie, P.Control,

                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,

                                    'A' AS EstatusDetalle, P.Recibido,
                                    S.Clave AS Serie, P.Pares, 'A' AS EstatusD, (P.Pares * P.Precio) AS STT,
                                    CONCAT('$ini',(CASE WHEN S.T1 = 0 THEN '-' ELSE S.T1 END),'$mid',CASE WHEN P.C1 = 0 THEN '-' ELSE P.C1 END,'$end') AS T1,
                                    CONCAT('$ini',(CASE WHEN S.T2 = 0 THEN '-' ELSE S.T2 END),'$mid',CASE WHEN P.C2 = 0 THEN '-' ELSE P.C2 END,'$end') AS T2,
                                    CONCAT('$ini',(CASE WHEN S.T3 = 0 THEN '-' ELSE S.T3 END),'$mid',CASE WHEN P.C3 = 0 THEN '-' ELSE P.C3 END,'$end') AS T3,
                                    CONCAT('$ini',(CASE WHEN S.T4 = 0 THEN '-' ELSE S.T4 END),'$mid',CASE WHEN P.C4 = 0 THEN '-' ELSE P.C4 END,'$end') AS T4,
                                    CONCAT('$ini',(CASE WHEN S.T5 = 0 THEN '-' ELSE S.T5 END),'$mid',CASE WHEN P.C5 = 0 THEN '-' ELSE P.C5 END,'$end') AS T5,
                                    CONCAT('$ini',(CASE WHEN S.T6 = 0 THEN '-' ELSE S.T6 END),'$mid',CASE WHEN P.C6 = 0 THEN '-' ELSE P.C6 END,'$end') AS T6,
                                    CONCAT('$ini',(CASE WHEN S.T7 = 0 THEN '-' ELSE S.T7 END),'$mid',CASE WHEN P.C7 = 0 THEN '-' ELSE P.C7 END,'$end') AS T7,
                                    CONCAT('$ini',(CASE WHEN S.T8 = 0 THEN '-' ELSE S.T8 END),'$mid',CASE WHEN P.C8 = 0 THEN '-' ELSE P.C8 END,'$end') AS T8,
                                    CONCAT('$ini',(CASE WHEN S.T9 = 0 THEN '-' ELSE S.T9 END),'$mid',CASE WHEN P.C9 = 0 THEN '-' ELSE P.C9 END,'$end') AS T9,
                                    CONCAT('$ini',(CASE WHEN S.T10 = 0 THEN '-' ELSE S.T10 END),'$mid',CASE WHEN P.C10 = 0 THEN '-' ELSE P.C10 END,'$end') AS T10,
                                    CONCAT('$ini',(CASE WHEN S.T11 = 0 THEN '-' ELSE S.T11 END),'$mid',CASE WHEN P.C11 = 0 THEN '-' ELSE P.C11 END,'$end') AS T11,
                                    CONCAT('$ini',(CASE WHEN S.T12 = 0 THEN '-' ELSE S.T12 END),'$mid',CASE WHEN P.C12 = 0 THEN '-' ELSE P.C12 END,'$end') AS T12,
                                    CONCAT('$ini',(CASE WHEN S.T13 = 0 THEN '-' ELSE S.T13 END),'$mid',CASE WHEN P.C13 = 0 THEN '-' ELSE P.C13 END,'$end') AS T13,
                                    CONCAT('$ini',(CASE WHEN S.T14 = 0 THEN '-' ELSE S.T14 END),'$mid',CASE WHEN P.C14 = 0 THEN '-' ELSE P.C14 END,'$end') AS T14,
                                    CONCAT('$ini',(CASE WHEN S.T15 = 0 THEN '-' ELSE S.T15 END),'$mid',CASE WHEN P.C15 = 0 THEN '-' ELSE P.C15 END,'$end') AS T15,
                                    CONCAT('$ini',(CASE WHEN S.T16 = 0 THEN '-' ELSE S.T16 END),'$mid',CASE WHEN P.C16 = 0 THEN '-' ELSE P.C16 END,'$end') AS T16,
                                    CONCAT('$ini',(CASE WHEN S.T17 = 0 THEN '-' ELSE S.T17 END),'$mid',CASE WHEN P.C17 = 0 THEN '-' ELSE P.C17 END,'$end') AS T17,
                                    CONCAT('$ini',(CASE WHEN S.T18 = 0 THEN '-' ELSE S.T18 END),'$mid',CASE WHEN P.C18 = 0 THEN '-' ELSE P.C18 END,'$end') AS T18,
                                    CONCAT('$ini',(CASE WHEN S.T19 = 0 THEN '-' ELSE S.T19 END),'$mid',CASE WHEN P.C19 = 0 THEN '-' ELSE P.C19 END,'$end') AS T19,
                                    CONCAT('$ini',(CASE WHEN S.T20 = 0 THEN '-' ELSE S.T20 END),'$mid',CASE WHEN P.C20 = 0 THEN '-' ELSE P.C20 END,'$end') AS T20,
                                    CONCAT('$ini',(CASE WHEN S.T21 = 0 THEN '-' ELSE S.T21 END),'$mid',CASE WHEN P.C21 = 0 THEN '-' ELSE P.C21 END,'$end') AS T21,
                                    CONCAT('$ini',(CASE WHEN S.T22 = 0 THEN '-' ELSE S.T22 END),'$mid',CASE WHEN P.C22 = 0 THEN '-' ELSE P.C22 END,'$end') AS T22,

                                    CONCAT('<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminar(this,2)\"><span class=\"fa fa-trash\"></span> ELIMINAR </button>') AS ELIMINAR", false)
                            ->from('pedidox AS P')
                            ->join('series AS S', 'P.Serie = S.Clave')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->order_by('abs(S.Clave)', 'ASC')
                            ->get()->result();
//            print $this->db->last_query();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSuelaByArticulo($Art) {
        try {
            return $this->db->select("A.Clave, A.Descripcion AS Suela", false)
                            ->from('fichatecnica as FT')
                            ->join('articulos AS A', 'FT.Articulo = A.Clave')
                            ->where('FT.Estilo', $Art)
                            ->where('A.Grupo', 3)
                            ->limit(1)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoByID($ID, $CLIENTE) {
        try {
            return $this->db->select("P.ID as PDID, P.Clave, P.Cliente, P.Agente, P.FechaPedido, P.FechaRecepcion, P.Usuario, P.Estatus, P.Registro,
                                    P.Clave, P.Estilo,P.EstiloT, P.Color, P.ColorT,P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio, P.Precio,
                                    P.Observacion AS OBSTITULO, P.ObservacionDetalle AS OBSCONTENIDO, P.Serie, P.Control,
                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,
                                    'A' AS EstatusDetalle, P.Recibido, C.ciudad AS Ciudad, CONCAT(E.Clave,' - ',E.Descripcion) AS Estado, C.RFC, C.TelPart AS Tel,
                                    S.Clave AS Serie, P.Pares, CONCAT(C.Clave,'-',C.RazonS) AS ClienteT, C.Direccion AS Dir,C.CodigoPostal AS CP,
                                    CONCAT(A.Clave, \" - \", A.Nombre) AS AgenteT, P.Observacion AS Obs, T.Descripcion AS Transporte, C.Observaciones AS OBSCLIENTE,
                                    S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11,
                                    S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22", false)
                            ->from('pedidox AS P')
                            ->join('series AS S', 'P.Serie = S.Clave')->join('clientes AS C', 'P.Cliente = C.Clave')
                            ->join('estados AS E', 'C.Estado = E.Clave', 'left')->join('agentes AS A', 'P.Agente = A.Clave', 'left')
                            ->join('transportes AS T', 'C.Transporte = T.Clave', 'left')
                            ->order_by('P.ID', 'DESC')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClavePedido($ID, $CLIENTE) {
        try {
            return $this->db->select("COUNT(*) AS EXISTE", false)
                            ->from('pedidox AS P')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanaMaquila($M, $S) {
        try {
            return $this->db->select("COUNT(*) AS EXISTE", false)
                            ->from('semanasproduccioncerradas AS SPC')
                            ->where('SPC.Maq', $M)
                            ->where('SPC.Sem', $S)
                            ->where('SPC.Estatus', 'CERRADA')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSerieXPedido($ID, $CLIENTE) {
        try {
            $this->db->query("set sql_mode=''");
            return $this->db->select("P.ID as PDID, P.Clave,
                                    S.Clave AS Serie,
                                    S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10,
                                    S.T11, S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20,
                                    S.T21, S.T22", false)
                            ->from('pedidox AS P')
                            ->join('series AS S', 'P.Serie = S.Clave')
                            ->join('clientes AS C', 'P.Cliente = C.Clave')
                            ->join('estados AS E', 'C.Estado = E.Clave')
                            ->join('agentes AS A', 'P.Agente = A.Clave')
                            ->group_by(array('S.Clave'))
                            ->order_by('S.Clave', 'ASC')
                            ->where('P.Clave', $ID)
                            ->where('P.Cliente', $CLIENTE)
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave($C, $CLIENTE) {
        try {
            return $this->db->select("G.Clave")->from("pedidox AS G")->where("G.Clave", $C)
                            ->where('G.Cliente', $CLIENTE)
                            ->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            return $this->db->select("A.Clave AS CLAVE")->from("pedidox AS A")->order_by("Clave", "DESC")->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCapacidadMaquila($CLAVE, $SEMANA) {
        try {
            return $this->db->select("`M`.`CapacidadPares` AS `CAPACIDAD`,"
                                    . "(SELECT SUM(PD.Pares) FROM pedidox AS PD WHERE PD.Maquila = M.Clave AND PD.Semana = '$SEMANA') AS PARES")
                            ->from('maquilas AS M')
                            ->where('M.Clave', $CLAVE)
                            ->limit(1)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("pedidox", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* ELIMINAR YA NO EXISTE */

    public function onAgregarDetalle($array) {
        try {
            $this->db->insert("pedidox", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID() AS IDL');
            $row = $query->row_array();
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("pedidox", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $ID)->update("pedidox");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarByID($ID) {
        try {
            return $this->db->select('COUNT(*) AS Control', false)->from('controles AS C')
                            ->where('C.PedidoDetalle', $ID)->where('C.Estatus', 'A')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProduccionMaquilaSemana($M, $S) {
        try {
            return $this->db->select('SUM(P.Pares) AS Pares', false)->from('pedidox AS P')
                            ->where('P.Maquila', $M)->where('P.Semana', $S)->where('P.Estatus', 'A')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getListaDePreciosByID($ID) {
        try {
            return $this->db->select('U.*', false)->from('listadeprecios AS U')->where('U.ID', $ID)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            return $this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgenteXCliente($C) {
        try {
            return $this->db->select("C.Agente AS Agente", false)
                            ->from('clientes AS C')->where_in('C.Clave', $C)->get()->result();
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

    public function getAnosValidos() {
        try {
            return $this->db->select("SP.Ano Anos", false)
                            ->from('semanasproduccion AS SP')->group_by(array('SP.Ano'))->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos($CLAVE) {
        try {
            $this->db->query("set sql_mode=''"); //FULL GROUP
            return $this->db->select("E.Clave AS Clave,CONCAT(E.Clave,'-',IFNULL(E.Descripcion,'')) AS Estilo")
                            ->from("estilos AS E")
                            ->join('fichatecnica AS FT', 'FT.Estilo = E.Clave')
                            ->join('fraccionesxestilo AS FE', 'FE.Estilo = E.Clave')
                            ->where("E.Clave", $CLAVE)
                            ->where("E.Estatus", "ACTIVO")
                            ->group_by('FT.Estilo')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            return $this->db->select("CONVERT(M.Clave, UNSIGNED INTEGER) AS Clave, CONCAT(M.Clave,' - ',M.Nombre) AS Maquila")->from("maquilas AS M")->where("M.Estatus", "ACTIVO")->order_by('Clave', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaSerieXEstilo($E) {
        try {
            return $this->db->select("E.Maquila,E.Serie, S.T1,S.T2,S.T3,S.T4,S.T5,S.T6,S.T7,S.T8,S.T9,S.T10,S.T11,S.T12,S.T13,S.T14,S.T15,S.T16,S.T17,S.T18,S.T19,S.T20,S.T21,S.T22,E.Foto")
                            ->from("estilos AS E")
                            ->join("series AS S", "E.Serie = S.`Clave`")
                            ->where("E.Clave", $E)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaXFechaDeEntrega($F) {
        try {
            return $this->db->select('SP.Sem AS Semana', false)->from('semanasproduccion AS SP')
                            ->where('STR_TO_DATE("' . $F . '", "%d/%m/%Y") BETWEEN STR_TO_DATE(FechaIni, "%d/%m/%Y") AND STR_TO_DATE(FechaFin, "%d/%m/%Y")')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida($S) {
        try {
            return $this->db->select(" COUNT(*) AS Semana")->from("semanasproduccion AS S")->where("S.Sem", $S)->where("S.Estatus", "ACTIVO")->order_by('S.Sem', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo($Estilo) {
        try {
            return $this->db->select("CAST(C.Clave AS SIGNED) AS Clave, CONCAT(C.Clave,'-', C.Descripcion) AS Color", false)
                            ->from('colores AS C')
                            ->where('C.Estilo', $Estilo)
                            ->where('C.Estatus', 'ACTIVO')
                            ->order_by('C.Clave', 'ASC')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
