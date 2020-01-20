<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('Pedido_helper')->model('Pedidos_model', 'pem');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
            }
            foreach (array('vFondo', 'vPedidos', 'vFooter') as $v) {
                $this->load->view($v);
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onVerificaMaquilas() {
        try {
            $x = $this->input->get();
            $MAQUILA = $x['Maquila'];
            print json_encode($this->db->query("SELECT * from maquilas  WHERE estatus = 'ACTIVO' and clave = '$MAQUILA' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaColorXEstilo() {
        try {
            $x = $this->input->get();
            $ESTILO = $x['Estilo'];
            $Color = $x['Color'];
            print json_encode($this->db->query("SELECT C.Descripcion AS Color FROM colores AS C  WHERE C.Estilo= '{$ESTILO}' AND C.Clave = {$Color} ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaEstilo() {
        try {
            $x = $this->input->get();
            $ESTILO = $x['Estilo'];
            print json_encode($this->db->query("SELECT E.Descripcion AS Estilo FROM estilos AS E  WHERE E.Estatus = 'ACTIVO' and E.clave = '$ESTILO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaCliente() {
        try {
            $x = $this->input->get();
            $CLIENTE = $x['Cliente'];
            print json_encode($this->db->query("select clave from clientes where clave = '$CLIENTE' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioEstiloColor() {
        try {
            $x = $this->input->get();
            $CLIENTE = $x['Cliente'];
            print json_encode($this->db->select("cv.preaut", false)
                                    ->from("costovaria cv")
                                    ->join("clientes ct", "ON ct.Clave = '$CLIENTE' and ct.ListaPrecios = cv.lista ")
                                    ->where('cv.estilo', $x['Estilo'])
                                    ->where('cv.color', $x['Color'])
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFichaTecnicaXEstilo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->select("(CASE WHEN COUNT(F.Estilo) > 0 THEN COUNT(F.Estilo) ELSE 0 END) AS TIENEFICHA", false)
                                    ->from("fichatecnica AS F")
                                    ->where('F.Estilo', $x['ESTILO'])
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFraccionesXEstilo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->select("(CASE WHEN COUNT(F.Estilo) > 0 THEN COUNT(F.Estilo) ELSE 0 END) AS TIENEFRACCIONES", false)
                                    ->from("fraccionesxestilo AS F")
                                    ->where('F.Estilo', $x['ESTILO'])
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->pem->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosByID() {
        try {
            print json_encode($this->pem->getPedidosByID($this->input->get('ID'), $this->input->get('CLIENTE')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoDByID() {
        try {
            $x = $this->input->get();
//            print json_encode($this->pem->getPedidoDByID($this->input->get('ID'), $this->input->get('CLIENTE')));
            $ini = '<div class=\"row\"><div class=\"col-12 text-danger text-nowrap talla font-weight-bold\" align=\"center\">';
            $mid = '</div><div class="col-12 cantidad font-weight-bold" align="center">';
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

                                    CONCAT('<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminar(this,2)\"><span class=\"fa fa-trash\"></span> </button>') AS ELIMINAR", false)
                            ->from('pedidox AS P')->join('series AS S', 'P.Serie = S.Clave')
                            ->where('P.Clave', $x['ID'])->where('P.Cliente', $x['CLIENTE'])
                            ->where_not_in('P.stsavan', 14)
                            ->order_by('abs(S.Clave)', 'ASC')->get()->result();
//            print $this->db->last_query();
             print json_encode( $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getIDXClave() {
        try {
            print json_encode($this->pem->getIDXClave($this->input->get('PEDIDO'), $this->input->get('CLIENTE')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanaMaquila() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->select("COUNT(*) AS EXISTE", false)
                                    ->from('semanasproduccioncerradas AS SPC')
                                    ->where('SPC.Maq', $x['MAQUILA'])
                                    ->where('SPC.Sem', $x['SEMANA'])
                                    ->where('SPC.Ano', $x['ANIO'])
                                    ->where('SPC.Estatus', 'CERRADA')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->pem->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCapacidadMaquila() {
        try {
            $x = $this->input->get();
            $date = DateTime::createFromFormat("d/m/Y", "{$x['ANIO']}");

//            print json_encode($this->pem->getCapacidadMaquila($x['CLAVE'], $x['SEMANA'], $x['ANIO']));
            $this->db->select("`M`.`CapacidadPares` AS `CAPACIDAD`,"
                            . "IFNULL((SELECT SUM(PD.Pares) FROM pedidox AS PD WHERE PD.Maquila = M.Clave AND PD.Semana = '{$x['SEMANA']}' AND PD.Ano = '{$date->format("Y")}'),0) AS PARES")
                    ->from('maquilas AS M');
            print json_encode(
                            $this->db->where('M.Clave', $x['CLAVE'])
                                    ->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->pem->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave() {
        try {
            print json_encode($this->pem->onComprobarClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarByID() {
        try {
            print json_encode($this->pem->onVerificarByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->pem->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgentes() {
        try {
            print json_encode($this->pem->getAgentes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->pem->getEstilos($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->pem->getColoresXEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->pem->getMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAnosValidos() {
        try {
            print json_encode($this->pem->getAnosValidos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaSerieXEstilo() {
        try {
            print json_encode($this->pem->getMaquilaSerieXEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProduccionMaquilaSemana() {
        try {
            print json_encode($this->pem->getProduccionMaquilaSemana($this->input->get('Maquila'), $this->input->get('Semana')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgenteXCliente() {
        try {
            print json_encode($this->pem->getAgenteXCliente($this->input->get('Cliente')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaXFechaDeEntrega() {
        try {
            print json_encode($this->pem->getSemanaXFechaDeEntrega($this->input->get('Fecha')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClavePedido() {
        try {
            print json_encode($this->pem->onComprobarClavePedido($this->input->get('CLAVE'), $this->input->get('cliente')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarX() {
        try {
            $x = $this->input->post();
            $this->db->trans_begin();

            $fecha = $x['FECHA_ENTREGA'];
            $anio = substr($fecha, 6, 4);
            $p = array(
                "Clave" => $x['PEDIDO'], "Cliente" => $x['CLIENTE'],
                "Agente" => $x['AGENTE'], "FechaPedido" => $x['FECHA_PEDIDO'],
                "FechaRecepcion" => $x['FECHA_RECEPCION'], "Usuario" => $_SESSION["USERNAME"],
                "Estilo" => $x['ESTILO'], "Color" => $x['COLOR'],
                "FechaEntrega" => $x['FECHA_ENTREGA'], "Maquila" => $x['MAQUILA'],
                "Semana" => $x['SEMANA'], "Ano" => $anio,
                "Recio" => $x['RECIO'], "Precio" => $x['PRECIO'],
                "Observacion" => $x['OBSERVACION'],
                "ObservacionDetalle" => $x['OBSERVACION_DETALLE'],
                "Serie" => $x['SERIE'], "Control" => 0,
                "C1" => $x['C1'], "C2" => $x['C2'], "C3" => $x['C3'], "C4" => $x['C4'],
                "C5" => $x['C5'], "C6" => $x['C6'], "C7" => $x['C7'], "C8" => $x['C8'],
                "C9" => $x['C9'], "C10" => $x['C10'], "C11" => $x['C11'], "C12" => $x['C12'],
                "C13" => $x['C13'], "C14" => $x['C14'], "C15" => $x['C15'], "C16" => $x['C16'],
                "C17" => $x['C17'], "C18" => $x['C18'], "C19" => $x['C19'], "C20" => $x['C20'],
                "C21" => $x['C21'], "C22" => $x['C22'],
                "Estatus" => 'A', "Registro" => Date('Y-m-d 00:00:00'), "Recibido" => $x['RECIBIDO'],
                "Pares" => $x['PARES'], "ParesFacturados" => 0, "EstiloT" => $x['ESTILOT'],
                "ColorT" => $x['COLORT'], "DiaProg" => 0, "SemProg" => 0,
                "AnioProg" => 0, "FechaProg" => NULL, "HoraProg" => NULL,
                "Empleado" => NULL, "Tiempo" => NULL, "EstatusProduccion" => NULL,
                "DeptoProduccion" => NULL, "stsavan" => 0
            );
            $this->db->insert('pedidox', $p);

            $COLOR_DESCRIPCION = $this->db->query("SELECT C.Descripcion AS DESCRIPCION_COLOR FROM estilos AS E 
                INNER JOIN colores AS C ON E.Clave = C.Estilo 
                WHERE E.Clave = '{$x['ESTILO']}' AND C.Clave = {$x['COLOR']};")->result();

            $this->db->set("ColorT", $COLOR_DESCRIPCION[0]->DESCRIPCION_COLOR)
                    ->where("Clave", $x['PEDIDO'])->where("Cliente", $x['CLIENTE'])
                    ->where("Agente", $x['AGENTE'])->where("Estilo", $x['ESTILO'])
                    ->where("Color", $x['COLOR'])->where("Semana", $x['SEMANA'])
                    ->where("Ano", $anio)->where("Maquila", $x['MAQUILA'])
                    ->update("pedidox");

            $insert_id = $this->db->insert_id();
            $l = new Logs("PEDIDOS", "AGREGO UN REGISTRO AL PEDIDO({$insert_id}) {$x['PEDIDO']} DE {$x['PARES']} PARES, CON EL ESTILO-COLOR {$x['ESTILO']} {$x['COLOR']}.", $this->session);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                print json_encode($this->db->select("ID,Clave,Cliente")
                                        ->from('pedidox')->where('Clave', $x['PEDIDO'])
                                        ->where('Cliente', $x['CLIENTE'])->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $usr = $_SESSION["USERNAME"];
            $clave = $x->post('Clave');
            $Detalle = json_decode($this->input->post("Detalle"));
            foreach ($Detalle as $key => $v) {
                $dt = date_parse($v->FechaEntrega);
                $data = array(
                    "Clave" => $clave,
                    "Cliente" => $x->post('Cliente'),
                    "Agente" => $x->post('Agente'),
                    "FechaPedido" => $x->post('FechaPedido'),
                    "FechaRecepcion" => $x->post('FechaRecepcion'),
                    "Usuario" => $usr,
                    "Estilo" => ($v->Estilo !== '') ? $v->Estilo : NULL,
                    "EstiloT" => ($v->EstiloT !== '') ? $v->EstiloT : NULL,
                    "Color" => ($v->Color !== '') ? $v->Color : NULL,
                    "ColorT" => ($v->ColorT !== '') ? $v->ColorT : NULL,
                    "FechaEntrega" => ($v->FechaEntrega !== '') ? $v->FechaEntrega : NULL,
                    "Maquila" => ($v->Maquila !== '') ? $v->Maquila : NULL,
                    "Semana" => ($v->Semana !== '') ? $v->Semana : NULL,
                    "Ano" => $dt["year"],
                    "Recio" => ($v->Recio !== '') ? $v->Recio : NULL,
                    "Precio" => ($v->Precio !== '') ? $v->Precio : NULL,
                    "Observacion" => ($v->Observacion !== '') ? $v->Observacion : NULL,
                    "ObservacionDetalle" => ($v->ObservacionDetalle !== '') ? $v->ObservacionDetalle : NULL,
                    "Serie" => ($v->Serie !== '') ? $v->Serie : NULL,
                    "Control" => 0,
                    "Pares" => ($v->Pares !== '') ? $v->Pares : NULL,
                    "C1" => ($v->C1 !== '') ? $v->C1 : NULL, "C2" => ($v->C2 !== '') ? $v->C2 : NULL,
                    "C3" => ($v->C3 !== '') ? $v->C3 : NULL, "C4" => ($v->C4 !== '') ? $v->C4 : NULL,
                    "C5" => ($v->C5 !== '') ? $v->C5 : NULL, "C6" => ($v->C6 !== '') ? $v->C6 : NULL,
                    "C7" => ($v->C7 !== '') ? $v->C7 : NULL, "C8" => ($v->C8 !== '') ? $v->C8 : NULL,
                    "C9" => ($v->C9 !== '') ? $v->C9 : NULL, "C10" => ($v->C10 !== '') ? $v->C10 : NULL,
                    "C11" => ($v->C11 !== '') ? $v->C11 : NULL, "C12" => ($v->C12 !== '') ? $v->C12 : NULL,
                    "C13" => ($v->C13 !== '') ? $v->C13 : NULL, "C14" => ($v->C14 !== '') ? $v->C14 : NULL,
                    "C15" => ($v->C15 !== '') ? $v->C15 : NULL, "C16" => ($v->C16 !== '') ? $v->C16 : NULL,
                    "C17" => ($v->C17 !== '') ? $v->C17 : NULL, "C18" => ($v->C18 !== '') ? $v->C18 : NULL,
                    "C19" => ($v->C19 !== '') ? $v->C19 : NULL, "C20" => ($v->C20 !== '') ? $v->C20 : NULL,
                    "C21" => ($v->C21 !== '') ? $v->C21 : NULL, "C22" => ($v->C22 !== '') ? $v->C22 : NULL,
                    "Recibido" => ($v->Recibido !== '') ? $v->Recibido : NULL
                );
                $data["Estatus"] = 'A';
                $data["Registro"] = Date('Y-m-d 00:00:00');
                $this->db->insert("pedidox", $data);
                $this->onLog("AGREGO " . $v->Pares . " PARES AL PEDIDO $clave DEL ESTILO: " . $v->EstiloT . ", COLOR: " . $v->ColorT);
            }
            //RETURN ID
            print '{ "ID":' . $clave . ',"EVT":"Agregar"}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $usr = $_SESSION["USERNAME"];
            $clave = $x->post('Clave');
            $Detalle = json_decode($this->input->post("Detalle"));
            foreach ($Detalle as $key => $v) {
                $dt = date_parse($v->FechaEntrega);
                $data = array(
                    "Clave" => $clave,
                    "Cliente" => $x->post('Cliente'),
                    "Agente" => $x->post('Agente'),
                    "FechaPedido" => $x->post('FechaPedido'),
                    "FechaRecepcion" => $x->post('FechaRecepcion'),
                    "Usuario" => $usr,
                    "Estilo" => ($v->Estilo !== '') ? $v->Estilo : NULL,
                    "EstiloT" => ($v->EstiloT !== '') ? $v->EstiloT : NULL,
                    "Color" => ($v->Color !== '') ? $v->Color : NULL,
                    "ColorT" => ($v->ColorT !== '') ? $v->ColorT : NULL,
                    "FechaEntrega" => ($v->FechaEntrega !== '') ? $v->FechaEntrega : NULL,
                    "Maquila" => ($v->Maquila !== '') ? $v->Maquila : NULL,
                    "Semana" => ($v->Semana !== '') ? $v->Semana : NULL,
                    "Ano" => $dt["year"],
                    "Recio" => ($v->Recio !== '') ? $v->Recio : NULL,
                    "Precio" => ($v->Precio !== '') ? $v->Precio : NULL,
                    "Observacion" => ($v->Observacion !== '') ? $v->Observacion : NULL,
                    "ObservacionDetalle" => ($v->ObservacionDetalle !== '') ? $v->ObservacionDetalle : NULL,
                    "Serie" => ($v->Serie !== '') ? $v->Serie : NULL,
                    "Control" => 0,
                    "Pares" => ($v->Pares !== '') ? $v->Pares : NULL,
                    "C1" => ($v->C1 !== '') ? $v->C1 : NULL, "C2" => ($v->C2 !== '') ? $v->C2 : NULL,
                    "C3" => ($v->C3 !== '') ? $v->C3 : NULL, "C4" => ($v->C4 !== '') ? $v->C4 : NULL,
                    "C5" => ($v->C5 !== '') ? $v->C5 : NULL, "C6" => ($v->C6 !== '') ? $v->C6 : NULL,
                    "C7" => ($v->C7 !== '') ? $v->C7 : NULL, "C8" => ($v->C8 !== '') ? $v->C8 : NULL,
                    "C9" => ($v->C9 !== '') ? $v->C9 : NULL, "C10" => ($v->C10 !== '') ? $v->C10 : NULL,
                    "C11" => ($v->C11 !== '') ? $v->C11 : NULL, "C12" => ($v->C12 !== '') ? $v->C12 : NULL,
                    "C13" => ($v->C13 !== '') ? $v->C13 : NULL, "C14" => ($v->C14 !== '') ? $v->C14 : NULL,
                    "C15" => ($v->C15 !== '') ? $v->C15 : NULL, "C16" => ($v->C16 !== '') ? $v->C16 : NULL,
                    "C17" => ($v->C17 !== '') ? $v->C17 : NULL, "C18" => ($v->C18 !== '') ? $v->C18 : NULL,
                    "C19" => ($v->C19 !== '') ? $v->C19 : NULL, "C20" => ($v->C20 !== '') ? $v->C20 : NULL,
                    "C21" => ($v->C21 !== '') ? $v->C21 : NULL, "C22" => ($v->C22 !== '') ? $v->C22 : NULL,
                    "Recibido" => ($v->Recibido !== '') ? $v->Recibido : NULL
                );
                $data["Estatus"] = 'A';
                $data["Registro"] = Date('Y-m-d 00:00:00');
                $this->db->insert("pedidox", $data);
                $insert_id = $this->db->insert_id();
                $l = new Logs("PEDIDOS", "ID({$insert_id}), AGREGO UN REGISTRO AL PEDIDO({$x['PEDIDO']}) DE {$x['PARES']} PARES DEL CLIENTE({$x['CLIENTE']}) (SERIE-{$x['SERIE']}), CON EL ESTILO-COLOR ({$x['ESTILO']} - {$x['COLOR']}).", $this->session);
            }
            //RETURN ID
            print '{ "ID":' . $x->post('Clave') . ',"EVT":"Agregar"}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarX() {
        try {
            $x = $this->input->post();
            $this->db->trans_begin();
            $p = array(
                "Clave" => $x['PEDIDO'], "Cliente" => $x['CLIENTE'],
                "Agente" => $x['AGENTE'], "FechaPedido" => $x['FECHA_PEDIDO'],
                "FechaRecepcion" => $x['FECHA_RECEPCION'], "Usuario" => $_SESSION["USERNAME"],
                "Estilo" => $x['ESTILO'], "Color" => $x['COLOR'],
                "FechaEntrega" => $x['FECHA_ENTREGA'], "Maquila" => $x['MAQUILA'],
                "Semana" => $x['SEMANA'], "Ano" => Date('Y'),
                "Recio" => $x['RECIO'], "Precio" => $x['PRECIO'],
                "Observacion" => $x['OBSERVACION'],
                "ObservacionDetalle" => $x['OBSERVACION_DETALLE'],
                "Serie" => $x['SERIE'], "Control" => 0,
                "C1" => $x['C1'], "C2" => $x['C2'], "C3" => $x['C3'], "C4" => $x['C4'],
                "C5" => $x['C5'], "C6" => $x['C6'], "C7" => $x['C7'], "C8" => $x['C8'],
                "C9" => $x['C9'], "C10" => $x['C10'], "C11" => $x['C11'], "C12" => $x['C12'],
                "C13" => $x['C13'], "C14" => $x['C14'], "C15" => $x['C15'], "C16" => $x['C16'],
                "C17" => $x['C17'], "C18" => $x['C18'], "C19" => $x['C19'], "C20" => $x['C20'],
                "C21" => $x['C21'], "C22" => $x['C22'],
                "Estatus" => 'A', "Registro" => Date('Y-m-d 00:00:00'), "Recibido" => $x['RECIBIDO'],
                "Pares" => $x['PARES'], "ParesFacturados" => 0, "EstiloT" => $x['ESTILOT'],
                "ColorT" => $x['COLORT'], "DiaProg" => 0, "SemProg" => 0,
                "AnioProg" => 0, "FechaProg" => NULL, "HoraProg" => NULL,
                "Empleado" => NULL, "Tiempo" => NULL, "EstatusProduccion" => NULL,
                "DeptoProduccion" => NULL
            );
            $this->db->insert('pedidox', $p);

            $COLOR_DESCRIPCION = $this->db->query("SELECT C.Descripcion AS DESCRIPCION_COLOR FROM estilos AS E 
                INNER JOIN colores AS C ON E.Clave = C.Estilo 
                WHERE E.Clave = '{$x['ESTILO']}' AND C.Clave = {$x['COLOR']};")->result();

            $this->db->set("ColorT", $COLOR_DESCRIPCION[0]->DESCRIPCION_COLOR)
                    ->where("Clave", $x['PEDIDO'])->where("Cliente", $x['CLIENTE'])
                    ->where("Agente", $x['AGENTE'])->where("Estilo", $x['ESTILO'])
                    ->where("Color", $x['COLOR'])->where("Semana", $x['SEMANA'])
                    ->where("Ano", Date('Y'))->where("Maquila", $x['MAQUILA'])
                    ->update("pedidox");

            $insert_id = $this->db->insert_id();
            $l = new Logs("PEDIDOS", "ID({$insert_id}), AGREGO UN REGISTRO AL PEDIDO({$x['PEDIDO']}) DE {$x['PARES']} PARES DEL CLIENTE({$x['CLIENTE']}) (SERIE-{$x['SERIE']}), CON EL ESTILO-COLOR ({$x['ESTILO']} - {$x['COLOR']}).", $this->session);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                print json_encode($this->db->select("ID,Clave,Cliente")
                                        ->from('pedidox')->where('Clave', $x['PEDIDO'])
                                        ->where('Cliente', $x['CLIENTE'])->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('pedidox');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function onImprimirPedidoReducido() {
        try {
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');

            $IDX = $this->input->post('ID');
            $CLIENTE = $this->input->post('CLIENTE');
//            $Pedido = $this->pem->getPedidoByID($IDX, $CLIENTE);
            $this->db->select("P.ID as PDID, P.Clave, P.Cliente, P.Agente, P.FechaPedido, P.FechaRecepcion, P.Usuario, P.Estatus, P.Registro,
                                    P.Clave, P.Estilo,P.EstiloT, P.Color, P.ColorT,P.FechaEntrega, P.Maquila, P.Semana, P.Ano, P.Recio, P.Precio,
                                    P.Observacion AS OBSTITULO, P.ObservacionDetalle AS OBSCONTENIDO, P.Serie, P.Control,
                                    P.C1, P.C2, P.C3, P.C4, P.C5, P.C6, P.C7, P.C8, P.C9, P.C10, P.C11,
                                    P.C12, P.C13, P.C14, P.C15, P.C16, P.C17, P.C18, P.C19, P.C20, P.C21, P.C22,
                                    'A' AS EstatusDetalle, P.Recibido, C.ciudad AS Ciudad, CONCAT(E.Clave,' - ',E.Descripcion) AS Estado, C.RFC, C.TelPart AS Tel,
                                    S.Clave AS Serie, P.Pares, CONCAT(C.Clave,'-',C.RazonS) AS ClienteT, C.Direccion AS Dir,C.CodigoPostal AS CP,
                                    CONCAT(A.Clave, \" - \", A.Nombre) AS AgenteT, P.Observacion AS Obs, T.Descripcion AS Transporte, C.Observaciones AS OBSCLIENTE,
                                    S.T1, S.T2, S.T3, S.T4, S.T5, S.T6, S.T7, S.T8, S.T9, S.T10, S.T11,
                                    S.T12, S.T13, S.T14, S.T15, S.T16, S.T17, S.T18, S.T19, S.T20, S.T21, S.T22, P.Control AS CONTROL_T", false)
                    ->from('pedidox AS P')
                    ->join('series AS S', 'P.Serie = S.Clave')
                    ->join('clientes AS C', 'P.Cliente = C.Clave')
                    ->join('estados AS E', 'C.Estado = E.Clave', 'left')
                    ->join('agentes AS A', 'P.Agente = A.Clave', 'left')
                    ->join('transportes AS T', 'C.Transporte = T.Clave', 'left');
            if ($IDX !== '') {
                $this->db->where('P.Clave', $IDX);
            }
            $Pedido = $this->db->where('P.Cliente', $CLIENTE)
                            ->where_not_in('P.stsavan', 14)
                            ->order_by('P.ID', 'ASC')
                            ->get()->result();
//            print "\n";
//            print $this->db->last_query();
//            print "\n";
//            exit(0);
//            $Series = $this->pem->getSerieXPedido($IDX, $CLIENTE);

            $this->db->query("set sql_mode=''");
            $Series = $this->db->select("P.ID as PDID, P.Clave,
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
                            ->where('P.Clave', $IDX)
                            ->where('P.Cliente', $CLIENTE)
                            ->where_not_in('P.stsavan', 14)
                            ->get()->result();

            $pdf->SetFont('Calibri', '', 7.5);
            $E = $Pedido[0];
            $pdf->setPedido($E->Clave);
            $pdf->setCliente($E->ClienteT);
            $pdf->setFecha($E->FechaPedido);
            $pdf->setCiudad($E->Ciudad);
            $pdf->setEstado($E->Estado);
            $pdf->setRFC($E->RFC);
            $pdf->setTel($E->Tel);
            $pdf->setObs($E->OBSCLIENTE);
            $pdf->setDireccion($E->Dir);
            $pdf->setCP($E->CP);
            $pdf->setAgente($E->AgenteT);
            $pdf->setTrasp($E->Transporte);
            $pdf->setRegistro($E->Registro);

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
            $aligns = array('L', 'L', 'L', 'L');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->SetTextColor(0, 0, 0);
            $posi = array(5, 60, 68, 75, 85, 95);
            /* ENCABEZADO DETALLE */

            $pdf->setY(15);
            $pdf->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30, 12.5);
            $pdf->SetFont('Calibri', 'B', 9.25);

            $pos = array(65/* 0 */, 80/* 1 */, 145/* 2 */, 160/* 3 */, 40/* 4 */, 200/* 5 */, 215/* 6 */);
            $anc = array(15/* 0 */, 65/* 1 */, 40/* 2 */, 120/* 3 */, 55/* 4 */);

            $base = 6;
            $alto_celda = 4;
            $pdf->SetY($base);
            $pdf->SetX(40);
            $pdf->Cell(110, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 0, 'L');
            $pdf->SetX(85);
            $pdf->Cell(110, $alto_celda, utf8_decode($_SESSION["EMPRESA_DIRECCION"]), 0/* BORDE */, 1, 'L');

            $base = $base + 4;
            $pdf->SetY($base);
            $pdf->SetX($pos[4]);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->Cell(25, $alto_celda, utf8_decode("Pedido"), 1/* BORDE */, 1, 'C', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[4]);
            $pdf->Cell(25, $alto_celda, utf8_decode($pdf->getPedido()), 1/* BORDE */, 1, 'C');

            $Y = $pdf->GetY();

            $pdf->SetX($pos[4] - 30);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->Cell(30, $alto_celda, utf8_decode("Fe Cap. "), 1/* BORDE */, 1, 'C', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[4] - 30);
            $pdf->Cell(30, $alto_celda, utf8_decode($pdf->getRegistro()), 1/* BORDE */, 1, 'C');

            $pdf->SetY($Y);
            $pdf->SetX($pos[4]);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->Cell(25, $alto_celda, utf8_decode("Fe Ped. "), 1/* BORDE */, 1, 'C', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[4]);
            $pdf->Cell(25, $alto_celda, utf8_decode($pdf->getFecha()), 1/* BORDE */, 0, 'C');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetY($base);
            $pdf->SetX($pos[0]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Cliente"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetY($base);
            $pdf->SetX($pos[1]);
            $pdf->Cell($anc[3], $alto_celda, utf8_decode($pdf->getCliente()), 1/* BORDE */, 1, 'L', 1);

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[0]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Ciudad"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[1]);
            $pdf->Cell($anc[1], $alto_celda, utf8_decode($pdf->getCiudad()), 1/* BORDE */, 0, 'L');

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[2]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Estado"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[3]);
            $pdf->Cell($anc[2], $alto_celda, utf8_decode($pdf->getEstado()), 1/* BORDE */, 1, 'L');

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[0]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("R.F.C"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[1]);
            $pdf->Cell($anc[1], $alto_celda, utf8_decode($pdf->getRFC()), 1/* BORDE */, 0, 'L');

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[2]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Tel."), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[3]);
            $pdf->Cell($anc[2], $alto_celda, utf8_decode($pdf->getTel()), 1/* BORDE */, 1, 'L');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[0]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Obs."), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFont('Calibri', 'B', 7.5);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[1]);
            $pdf->Cell($anc[3], $alto_celda, utf8_decode($pdf->getObs()), 1/* BORDE */, 0, 'L');

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[5]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Trans."), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[6]);
            $pdf->Cell($anc[4], $alto_celda, utf8_decode($pdf->getTrasp()), 1/* BORDE */, 1, 'L');

            $pdf->SetY($base);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[5]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Dirección"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetY($base);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[6]);
            $pdf->Cell($anc[4], $alto_celda, utf8_decode($pdf->getDireccion()), 1/* BORDE */, 1, 'L', 1);

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[5]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("Agente"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[6]);
            $pdf->Cell($anc[4], $alto_celda, utf8_decode($pdf->getAgente()), 1/* BORDE */, 1, 'L');

            $pdf->SetFillColor(225, 225, 234);
            $pdf->SetX($pos[5]);
            $pdf->Cell($anc[0], $alto_celda, utf8_decode("C.P"), 1/* BORDE */, 0, 'L', 1);
            $pdf->SetFillColor(250, 250, 250);
            $pdf->SetX($pos[6]);
            $pdf->Cell($anc[4], $alto_celda, utf8_decode($pdf->getCP()), 1/* BORDE */, 1, 'L');

            /* FIN ENCABEZADO DETALLE */

            $pares_totales = 0;
            $total_final = 0;

            /* RESUMEN */
            $pdf->SetFont('Calibri', 'B', 8);
            $anchos = array(55/* 0 */, 7/* 1 */, 7/* 2 */, 9/* 3 */, 10/* 4 */, 6.5/* 5 */);
            for ($index = 1; $index < 22; $index++) {
                array_push($anchos, 6.5);
            }
            array_push($anchos, 10); //PRECIO
            array_push($anchos, 15); //TOTAL
            array_push($anchos, 15); //ENTREGA

            $aligns = array('C'/* 0 */, 'C', 'C', 'C', 'C');
            for ($index = 1; $index <= 22; $index++) {
                array_push($aligns, 'C');
            }
            array_push($aligns, 'C'); //PRECIO
            array_push($aligns, 'C'); //TOTAL
            array_push($aligns, 'C'); //ENTREGA

            $pdf->setY(35); //DISTANCIA ENTRE EL ENCABEZADO Y EL DETALLE
            foreach ($Series as $sk => $sv) {
                /* TALLAS */
                $aligns[0] = 'C';
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->SetX($posi[0]);
                $pdf->SetAligns($aligns);
                $pdf->SetWidths(array(55, 7, 7, 9, 10, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 6.5, 10, 15, 15));
                $rs = array();
                array_push($rs, 'Estilo/Color');
                array_push($rs, 'Maq');
                array_push($rs, 'Sem');
                array_push($rs, 'Recio');
                array_push($rs, 'Pares');
                for ($index = 1; $index <= 22; $index++) {
                    array_push($rs, ($sv->{"T$index"} !== '0') ? $sv->{"T$index"} : '');
                }
                array_push($rs, 'Precio');
                array_push($rs, 'Total');
                array_push($rs, 'Entrega');
                $pdf->setFilled(true);
                $pdf->setBorders(1);
                $pdf->setAlto(3);
                $pdf->Row($rs);
                $pdf->setFilled(false);
                $pdf->setBorders(0);
                /* FIN TALLAS */
                foreach ($Pedido as $k => $v) {
                    /* PRIMER DETALLE */
                    if ($sv->Serie === $v->Serie) {
                        $aligns[0] = 'L';
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetX($posi[0]);
                        $pdf->SetFont('Calibri', '', 7.5);
                        $row = array();
                        $estilo_color = $v->Estilo . " - {$v->Color} {$v->ColorT}";
                        array_push($row, $estilo_color, $v->Maquila, $v->Semana, $v->Recio, $v->Pares); //4
                        for ($index = 1; $index <= 22; $index++) {
                            array_push($row, ( $v->{"C$index"} !== '0') ? $v->{"C$index"} : '-'); //5
                        }
                        array_push($row, number_format($v->Precio, 2, ".", ",")); //PRECIO 6
                        $precio = ($v->Pares * $v->Precio);
                        if (strlen($precio) >= 12) {
                            $pdf->SetFont('Calibri', '', 7);
                        } else {
                            $pdf->SetFont('Calibri', '', 8);
                        }
                        array_push($row, number_format($precio, 2, ".", ",")); //TOTAL 7
                        array_push($row, $v->FechaEntrega); //ENTREGA 8
                        if (strlen($estilo_color) >= 40) {
                            $pdf->setAlto(3);
                        } else {
                            $pdf->setAlto(3.5);
                        }
                        $pdf->SetFont('Calibri', '', 7.5);
                        $pdf->Row($row);
                        $pdf->setAlto(3.5);
                        $pares_totales += $v->Pares;
                        $total_final += ($v->Pares * $v->Precio);
                        /* FIN PRIMER DETALLE */

                        /* SEGUNDO DETALLE (SUELA) */
                        $suela = array();
//                        $suelin = $this->pem->getSuelaByArticulo($v->Estilo, $v->Color);
                        $suelin = $this->db->select("A.Clave, A.Descripcion AS Suela", false)
                                        ->from('fichatecnica as FT')
                                        ->join('articulos AS A', 'FT.Articulo = A.Clave AND A.Grupo = 3')
                                        ->where('FT.Estilo', $v->Estilo)
                                        ->where('FT.Color', $v->Color)
                                        ->limit(1)->get()->result();

                        $pdf->SetAligns(array('L', 'L', 'L', 'L'));
                        $pdf->SetWidths(array(198.5, 72.5));
                        $pdf->SetX($posi[0]);
                        $pdf->SetFont('Calibri', '', 8);
                        if (count($suelin) > 0) {
                            array_push($suela, 'OBS. ' . $v->OBSTITULO . " | " . $v->OBSCONTENIDO . " " . $v->CONTROL_T, 'SUELA: ' . $suelin[0]->Suela); //3
                        } else {
                            array_push($suela, 'OBS. ' . $v->OBSTITULO . " | " . $v->OBSCONTENIDO . " " . $v->CONTROL_T, 'SUELA NO DISPONIBLE'); //3
                        }
                        $pdf->SetFont('Calibri', 'BI', 8);
                        $pdf->Row($suela);
                        /* SEGUNDO DETALLE (SUELA) */
                    }
                }
            }
            /* TOTALES */
            $Y = $pdf->GetY();
            $pdf->SetX(47);
            $pdf->SetFont('Calibri', 'BI', 8);
            $aligns = array('C', 'C');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths(array(15, 32));
            $pdf->setFilled(true);
            $pdf->setBorders(1);
            $pdf->Row(array("PARES", $pares_totales));
            $pdf->SetY($Y);
            $pdf->SetX(231);
            $pdf->SetAligns($aligns);
            $pdf->SetWidths(array(15, 30));
            $pdf->Row(array("TOTAL", "" . number_format($total_final, 3, ".", ",")));

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Pedidos';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/Pedidos/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "Pedido $IDX " . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            $l = new Logs("PEDIDOS", "GENERO UN REPORTE DEL PEDIDO CON LA CLAVE $IDX.", $this->session);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public $Padre = '';
    public $Hijo = '';

    function getPadre() {
        return $this->Padre;
    }

    function getHijo() {
        return $this->Hijo;
    }

    function setPadre($Padre) {
        $this->Padre = $Padre;
    }

    function setHijo($Hijo) {
        $this->Hijo = $Hijo;
    }

    public function onLog($Accion) {
        try {
            /* LOG TO ACCIONS */
            $xlog = array();
            $xlog["Empresa"] = $this->session->Empresa;
            $xlog["Tipo"] = $this->session->TipoAcceso;
            $xlog["IdUsuario"] = $this->session->ID;
            $xlog["Usuario"] = $this->session->Nombre . " " . $this->session->Apellidos;
            $xlog["Modulo"] = "PEDIDOS";
            $xlog["Accion"] = $this->session->Nombre . " " . $this->session->Apellidos . ":" . $Accion;
            $xlog["Fecha"] = Date('d/m/Y');
            $xlog["Hora"] = Date('h:i:s a');
            $xlog["Dia"] = Date('d');
            $xlog["Mes"] = Date('m');
            $xlog["Anio"] = Date('Y');
            $xlog["Registro"] = Date('d/m/Y h:i:s a');
            $xlog["Padre"] = $this->getPadre();
            $xlog["Hijo"] = $this->getHijo();
            $xlog["Estatus"] = 'ACTIVO';
            $this->db->insert('logs', $xlog);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
