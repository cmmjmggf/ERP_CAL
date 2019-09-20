<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenDeProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Ordendeproduccion_model', 'odpm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vOrdenDeProduccion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            try {
                $x = $this->input->get();
                $this->db->select('PD.ID AS ID, '
                                . 'PD.Estilo AS IdEstilo, '
                                . 'PD.Color AS IdColor, '
                                . "PD.Estilo AS Estilo, "
                                . "PD.Estilo AS \"Descripcion Estilo\", "
                                . "PD.color AS Color, "
                                . "PD.color AS \"Descripcion Color\", "
                                . "PD.Clave AS Pedido,"
                                . "PD.FechaPedido AS \"Fecha Pedido\","
                                . "PD.FechaRecepcion AS \"Fecha Entrega\","
                                . "PD.Registro AS \"Fecha Captura\","
                                . "PD.Semana AS Semana,"
                                . "PD.Maquila AS Maq,"
                                . "PD.Cliente AS Cliente,"
                                . "PD.Cliente AS \"Cliente Razon\","
                                . "PD.Pares AS Pares,"
                                . "CONCAT('$',PD.Precio) AS Precio , "
                                . "CONCAT('$',(PD.Precio * PD.Pares)) AS Importe, "
                                . "CONCAT('$',(PD.Precio * PD.Pares)) AS Descuento,"
                                . "PD.FechaEntrega AS Entrega,"
                                . "PD.Serie AS Serie, "
                                . "PD.Ano AS Anio,"
                                . " CASE "
                                . "WHEN PD.Control IS NULL THEN '' "
                                . "ELSE PD.Control END AS Marca, "
                                . "CONCAT(RIGHT(CT.Ano,2), CT.Semana, CT.Maquila, CT.Consecutivo) AS Control,"
                                . "S.ID AS SerieID,"
                                . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                        ->join('clientes AS CL', 'CL.Clave = PD.Cliente', 'left')
                        ->join('series AS S', 'PD.Serie = S.Clave')
                        ->join('controles AS CT', 'CT.PedidoDetalle = PD.ID')
                        ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.ID', 'left')
                        ->where('PD.Control <> 0 AND OP.ID IS NULL', null, false)
                        ->where('CT.Estatus', 'A');
                if ($x["ANIO"] !== '') {
                    $this->db->where('PD.Ano', $x["ANIO"]);
                }
                if ( $x["MAQUILA"] !== '') {
                    $this->db->where('PD.Maquila', $x["MAQUILA"]);
                }
                if ($x["SEMANA"] !== '') {
                    $this->db->where('PD.Semana', $x["SEMANA"]);
                }
                if ($x["ANIO"] === '' &&  $x["MAQUILA"] === '' && $x["SEMANA"] === '') {
                    $this->db->limit(99);
                }
                $sql = $this->db->get();
//            PRINT $this->db->last_query();
                print json_encode($sql->result());
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarMaquilaValida() {
        try {
            print json_encode($this->odpm->onChecarMaquilaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->odpm->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* OBTENER Y AGREGAR A ORDEN DE PRODUCCION LOS PEDIDOS */

    public function onAgregarAOrdenDeProduccion() {
        try {
            $x = $this->input;
            $PEDIDO_DETALLE = $this->odpm->getPedidosByMaquilaSemana($x->post('MAQUILA'), $x->post('SEMANA'), $x->post('ANO'));
            foreach ($PEDIDO_DETALLE as $k => $v) {
                $op = array();
                $op["Clave"] = $v->CLAVE_CLIENTE;
                $op["Cliente"] = $v->CLIENTE;
                $op["FechaEntrega"] = $v->FechaEntrega;
                $op["FechaPedido"] = $v->FECHA_PEDIDO;
                $op["Control"] = $v->CLAVE_CONTROL;
                $op["ControlT"] = $v->Control;
                $op["Pedido"] = $v->Pedido;
                $op["PedidoDetalle"] = $v->PEDIDO_DETALLE;
                $op["Linea"] = $v->CLAVE_LINEA;
                $op["LineaT"] = $v->LINEA;
                $op["Recio"] = $v->Recio;
                $op["Estilo"] = $v->Estilo;
                $op["EstiloT"] = $v->OESTILOT;
                $op["Color"] = $v->Color;
                $op["ColorT"] = $v->OCOLORT;
                $op["Agente"] = $v->AGENTE;
                $op["Transporte"] = $v->TRANSPORTE;
                $op["Semana"] = $x->post('SEMANA');
                $op["Maquila"] = $x->post('MAQUILA');
                $op["Ano"] = $x->post('ANO');

                $P_F_S_S = $this->odpm->getPIEL_FORRO_SINTETICO_SUELA($v->Estilo, $v->Color, $v->Pares);
                $total_piel = 0;
                $total_forro = 0;
                $total_sintetico = 0;
                $piel = 1;
                $forro = 1;
                $sintetico = 1;
                foreach ($P_F_S_S as $kk => $vv) {
                    switch ($vv->Grupo) {
                        case 'PIEL':
                            $op["Piel" . $piel] = $vv->PIEL_FORRO_SINTETICO_SUELA;
                            $op["CantidadPiel" . $piel] = $vv->CONSUMOTOTAL;
                            $total_piel += $vv->CONSUMOTOTAL;
                            $piel += 1;
                            break;
                        case 'FORRO':
                            $op["Forro" . $forro] = $vv->PIEL_FORRO_SINTETICO_SUELA;
                            $op["CantidadForro" . $forro] = $vv->CONSUMOTOTAL;
                            $total_forro += $vv->CONSUMOTOTAL;
                            $forro += 1;
                            break;
                        case 'SINTETICO':
                            $op["Sintetico" . $sintetico] = $vv->PIEL_FORRO_SINTETICO_SUELA;
                            $op["CantidadSintetico" . $sintetico] = $vv->CONSUMOTOTAL;
                            $total_sintetico += $vv->CONSUMOTOTAL;
                            $sintetico += 1;
                            break;
                        case 'SUELA':
                            $op["Suela"] = $vv->Clave;
                            $op["SuelaT"] = $vv->PIEL_FORRO_SINTETICO_SUELA;
                            break;
                    }
                }

                $op["TotalPiel"] = $total_piel;
                $op["TotalForro"] = $total_forro;
                $op["TotalSintetico"] = $total_sintetico;

                $op["Suaje"] = '';

                $op["SerieCorrida"] = $v->SERIE;
                $op["EstatusProduccion"] = 'PROGRAMADO';

                for ($index = 1; $index <= 22; $index++) {
                    $op["S$index"] = $v->{"T$index"};
                }

                $op["Horma"] = $v->HORMA;
                $op["Pares"] = $v->Pares;

                for ($index = 1; $index <= 22; $index++) {
                    $op["C$index"] = $v->{"C$index"};
                }
                $op["Registro"] = Date('d/m/Y h:i:s a');
                $op["Usuario"] = $_SESSION["ID"];
                $op["UsuarioT"] = $_SESSION["USERNAME"];

                $this->db->insert('ordendeproduccion', $op);
                $row = $this->db->query('SELECT LAST_INSERT_ID()')->row_array();
                $ID = $row['LAST_INSERT_ID()'];

                /* DETALLE */
                $ORDENDEPRODUCCIOND = $this->odpm->getFichaTecnicaParaOrdenDeProduccion($v->Estilo, $v->Color, $v->Pares);
                foreach ($ORDENDEPRODUCCIOND as $kkk => $vvv) {
                    $opd = array();
                    $opd["OrdenDeProduccion"] = $ID;
                    $opd["Pieza"] = $vvv->PIEZA;
                    $opd["PiezaT"] = $vvv->PIEZAT;
                    $opd["Departamento"] = $vvv->DEPARTAMENTO;
                    $opd["DepartamentoT"] = $vvv->DEPARTAMENTOT;
                    $opd["Articulo"] = $vvv->ARTICULO;
                    $opd["ArticuloT"] = $vvv->ARTICULOT;
                    $opd["Grupo"] = $vvv->GRUPO;
                    $opd["Precio"] = $vvv->PRECIO;
                    $opd["Consumo"] = $vvv->CONSUMO;
                    $opd["PzXPar"] = $vvv->PZXPAR;
                    $opd["UnidadMedida"] = $vvv->UNIDAD;
                    $opd["UnidadMedidaT"] = $vvv->UNIDADT;
                    $opd["Cantidad"] = $vvv->CANTIDAD_CONSUMO;
                    $opd["Estatus"] = 'A';
                    $opd["FechaAlta"] = Date('d/m/Y');
                    $opd["AfectaPV"] = $vvv->AFECTAPV;
                    $opd["PiezaClasificacion"] = $vvv->CLASIFICACION;
                    $opd["DepartamentoArt"] = $vvv->DEPTOART;
                    $this->db->insert('ordendeproducciond', $opd);
                }
            }
            print count($PEDIDO_DETALLE);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
