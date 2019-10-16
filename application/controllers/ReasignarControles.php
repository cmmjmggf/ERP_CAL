<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReasignarControles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Reasignarcontroles_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vReasignarControles')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $x = $this->input->get();
//            print json_encode($this->Reasignarcontroles_model->getRecords());
            $this->db->select('PD.Clave AS ID, '
                            . 'PD.Estilo AS IdEstilo, '
                            . 'PD.Color AS IdColor, '
                            . "E.Clave AS Estilo, "
                            . "E.Descripcion AS \"Descripcion Estilo\", "
                            . "C.Clave AS Color, "
                            . "C.Descripcion AS \"Descripcion Color\", "
                            . "PD.Clave AS Pedido,"
                            . "PD.FechaPedido AS \"Fecha Pedido\","
                            . "PD.FechaRecepcion AS \"Fecha Entrega\","
                            . "PD.Registro AS \"Fecha Captura\","
                            . "PD.Semana AS Semana,"
                            . "PD.Maquila AS Maq,"
                            . "CL.Clave AS Cliente,"
                            . "CL.RazonS AS \"Cliente Razon\","
                            . "PD.Pares AS Pares,"
                            . "CONCAT('$',PD.Precio) AS Precio , "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Importe, "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Descuento,"
                            . "PD.FechaEntrega AS Entrega,"
                            . "CONCAT(S.PuntoInicial ,'/',S.PuntoFinal) AS Serie, "
                            . "PD.Ano AS Anio,"
                            . " CASE "
                            . "WHEN PD.Control IS NULL THEN '' "
                            . "ELSE PD.Control END AS Marca, "
                            . "PD.Control AS Control,"
                            . "S.ID AS SerieID,"
                            . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                    ->join('clientes AS CL', 'CL.Clave = PD.Cliente')
                    ->join('estilos AS E', 'PD.Estilo = E.Clave')
                    ->join('colores AS C', 'PD.color = C.Clave AND C.Estilo = E.Clave')
                    ->join('series AS S', 'E.Serie = S.Clave')
                    ->where('PD.Control <> 0', null, false);

            if ($x['CONTROL_INICIAL'] !== '' && $x['CONTROL_FINAL'] !== '') {
                $this->db->where("PD.Control BETWEEN {$x['CONTROL_INICIAL']} AND {$x['CONTROL_FINAL']}", null, false)
                        ->order_by('PD.Control', 'ASC');
            } else {
                $this->db->order_by('PD.Control', 'ASC')->limit(5);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->Reasignarcontroles_model->getMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarMaquilaValida() {
        try {
            print json_encode($this->Reasignarcontroles_model->onChecarMaquilaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->Reasignarcontroles_model->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHistorialDeControles() {
        try {
            print json_encode($this->Reasignarcontroles_model->getHistorialDeControles());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerElUltimoControl() {
        try {
            print json_encode($this->Reasignarcontroles_model->onObtenerElUltimoControl($this->input->get('SEMANA'), $this->input->get('MAQUILA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReAsignarControles() {
        try {
            $x = $this->input->post();
            print "\n REASIGNANDO A LAS " . Date('h:i:s') . "\n";
            /* ELIMINAR CUALQUIER ORDEN DE PRODUCCION */
            $CONTROL_INICIAL = $x['INICIO'];
            $CONTROL_FINAL = $x['FIN'];

//            $CONTROL_INICIAL = '194901001';
//            $CONTROL_FINAL = '194901001';

            $SEMANA_ASIGNADA = $x['SEMANA_ASIGNADA'];
            $SEMANA_A_ASIGNAR = $x['SEMANA_A_ASIGNAR'];

            $MAQUILA_ASIGNADA = $x['MAQUILA_ASIGNADA'];
            $MAQUILA_A_ASIGNAR = $x['MAQUILA_A_ASIGNAR'];

            $OBSERVACIONES = $x['OBSERVACIONES'];
            $OBSERVACIONES_ADICIONALES = $x['OBSERVACIONES_ADICIONALES'];

            $Y = substr(Date('Y'), 2);

            $this->db->trans_begin();
            $this->db->query("DELETE OPD.* FROM ordendeproducciond AS OPD 
                INNER JOIN OrdenDeProduccion AS OP 
                ON OPD.OrdenDeProduccion = OP.ID 
                WHERE OPD.ID > 0 AND OP.ControlT BETWEEN {$CONTROL_INICIAL} AND {$CONTROL_FINAL}");
            $this->db->query("DELETE FROM ordendeproduccion WHERE ID > 0 AND ControlT BETWEEN {$CONTROL_INICIAL} AND {$CONTROL_FINAL}");
            $this->db->query("DELETE FROM controles WHERE ID > 0 AND Control BETWEEN {$CONTROL_INICIAL} AND {$CONTROL_FINAL}");

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                PRINT "NO FUE POSIBLE EJECUTAR LAS CONSULTAS REQUERIDAS, VERIFIQUE LA CONEXION A LA BASE DE DATOS O A LA RED ETHERNET";
                exit(0);
            } else {
                $this->db->trans_commit();
            }

            /* AQUI SE OBTIENEN LOS PEDIDOS CON LA SEMANA ACTUAL, MAQUILA ACTUAL 
             * ENTRE EL RANGO DE CONTROLES ESPECIFICADOS */
            $controles = $this->db->select("PD.*", false)->from('pedidox AS PD')
                            ->where('PD.Ano', Date('Y'))->where('PD.Maquila', $MAQUILA_ASIGNADA)
                            ->where('PD.Semana', $SEMANA_ASIGNADA)
                            ->where("PD.Control BETWEEN {$CONTROL_INICIAL} AND {$CONTROL_FINAL}", null, false)
                            ->order_by('PD.Control', 'ASC')->get()->result();
            print "\n 1." . $this->db->last_query() . "\n";
//            var_dump($controles);
//            exit(0);

            foreach ($controles as $k => $v) {
                $M = str_pad($MAQUILA_A_ASIGNAR, 2, '0', STR_PAD_LEFT);
                $S = str_pad($SEMANA_A_ASIGNAR, 2, '0', STR_PAD_LEFT);
                print "\n 2.count(*) AS EXISTE \n";
                $EXISTEN_REGISTROS = $this->db->select('count(*) AS EXISTE', false)->from('controles AS C')
                                ->where("C.Semana = ABS({$SEMANA_A_ASIGNAR}) "
                                        . "AND C.Maquila = ABS({$MAQUILA_A_ASIGNAR}) AND C.Ano = ABS({$Y})"
                                        . "ORDER BY `C`.`Consecutivo` DESC", null, false)
                                ->limit(1)->get()->result();
                print  $this->db->last_query() . "\n";

                print "\n 3.Consecutivo + 1 en controles \n";
                $MAXIMO_CONSECUTIVO = $this->db->select('(C.Consecutivo + 1) AS MAX', false)->from('controles AS C')
                                ->where("C.Maquila = ABS({$MAQUILA_A_ASIGNAR}) "
                                        . "AND C.Semana = ABS({$SEMANA_A_ASIGNAR}) "
                                        . "AND C.Ano = ABS({$Y})", null, false)
                                ->order_by('C.Consecutivo', 'DESC')->limit(1)->get()->result();
                print $this->db->last_query() . "\n";

                $C = str_pad(((intval($EXISTEN_REGISTROS[0]->EXISTE) === 0) ? 1 : $MAXIMO_CONSECUTIVO[0]->MAX), 3, '0', STR_PAD_LEFT);
                $C = ((intval($C) > 0) ? $C : str_pad($C, 3, '0', STR_PAD_LEFT));
                $Control = $Y . $S . $M . $C;

                print "\n 4.insert controles \n";
                $this->db->insert("controles", array(
                    'Control' => $Control, 'FechaProgramacion' => Date('Y-m-d h:i:s'),
                    'Estilo' => $v->Estilo, 'Color' => $v->Color, 'Serie' => $v->Serie,
                    'Cliente' => $v->Cliente, 'Pares' => $v->Pares, 'Pedido' => $v->Clave,
                    'PedidoDetalle' => $v->Clave, 'Estatus' => 'A',
                    'Departamento' => 1 /* 0|null|Inexistente - PEDIDO => 1 - PROGRAMADO */,
                    'Ano' => $Y, 'Maquila' => $M, 'Semana' => $S, 'Consecutivo' => $C
                ));
                print $this->db->last_query() . "\n";

                print "\n 5. update pedidox control,semana,maquila" . $this->db->last_query() . "\n";
                $this->db->set('Control', $Control)
                        ->set('Semana', $SEMANA_A_ASIGNAR)
                        ->set('Maquila', $MAQUILA_A_ASIGNAR)
                        ->set('Observacion', $OBSERVACIONES)
                        ->set('ObservacionDetalle', $OBSERVACIONES_ADICIONALES)
                        ->set('FechaProduccion', Date('Y-m-d h:i:s'))
                        ->where('Estilo', $v->Estilo)->where('Color', $v->Color)
                        ->where('Serie', $v->Serie)->where('Maquila', $v->Maquila)
                        ->where('Semana', $v->Semana)->where('Ano', $v->Ano)
                        ->where('Clave', $v->Clave)->where('ID', $v->ID)
                        ->update('pedidox');
                print $this->db->last_query() . "\n";

                print "\n 6. select avaprd \n";
                $check_control = $this->db->select('COUNT(A.contped) AS EXISTE', false)
                                ->from('avaprd AS A')
                                ->where('A.contped', $Control)
                                ->get()->result();
                print $this->db->last_query() . "\n";


                print "\n 7. avaprd" . $this->db->last_query() . "\n";
                if ($check_control[0]->EXISTE <= 0) {
                    $this->db->insert('avaprd', array(
                        'contped' => $Control,
                        'status' => 1,
                        'fec1' => Date('Y-m-d h:i:s')
                    ));
                } else {
                    $this->db->set('fec1', Date('Y-m-d h:i:s'))
                            ->where('contped', $Control)
                            ->update('avaprd');
                }
                print $this->db->last_query() . "\n";
                print "\n SE TERMINO DE REASIGNAR A LAS " . Date('h:i:s') . "\n";
//                exit(0);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaSemanaXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->select("P.Maquila AS MAQUILA, P.Semana AS SEMANA", false)
                                    ->from("pedidox AS P")
                                    ->where("P.Control BETWEEN {$x["CONTROL_INICIAL"]} AND {$x["CONTROL_FINAL"]}", null, false)->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
