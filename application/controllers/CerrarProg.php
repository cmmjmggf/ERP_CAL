<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CerrarProg extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Cerrarprog_model', 'cprm');
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

            $this->load->view('vFondo')->view('vCerrarProg')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $x = $this->input->get();
//            print json_encode($this->cprm->getRecords(
//            $x->get('MAQUILA'), $x->get('SEMANA'), $x->get('ANIO')));
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
                            . "DATE_FORMAT(PD.Registro,\"%d/%m/%Y\") AS \"Fecha Captura\","
                            . "PD.Semana AS Semana,"
                            . "PD.Maquila AS Maq,"
                            . "PD.Cliente AS Cliente,"
                            . "PD.Cliente AS \"Cliente Razon\","
                            . "PD.Pares AS Pares,"
                            . "CONCAT('$',PD.Precio) AS Precio , "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Importe, "
                            . "CONCAT('$',(PD.Precio * PD.Pares)) AS Descuento,"
                            . "PD.FechaEntrega AS Entrega,"
                            . "CONCAT(S.PuntoInicial ,'/',S.PuntoFinal) AS Serie, "
                            . "PD.Ano AS Anio,"
                            . " CASE "
                            . "WHEN PD.Control IS NULL THEN '' "
                            . "WHEN PD.Control  = 0 THEN '' "
                            . "ELSE PD.Control END AS Marca, "
                            . "PD.Control AS Control,"
                            . "S.ID AS SerieID,"
                            . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                    ->join('series AS S', 'PD.Serie = S.Clave')
                    ->where('PD.Control', 0);
            if ($x['ANIO'] !== '') {
                $this->db->where('PD.Ano', $x['ANIO']);
            }
            if ($x['MAQUILA'] !== '') {
                $this->db->where('PD.Maquila', $x['MAQUILA']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('PD.Semana', $x['SEMANA']);
            }
            $this->db->order_by('PD.ID', 'DESC');
            if ($x['MAQUILA'] === '' && $x['SEMANA'] === '') {
                $this->db->limit(25);
            }


            $sql = $this->db->get();
//            PRINT $this->db->last_query();
            print json_encode($sql->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHistorialDeControles() {
        try {
//            print json_encode($this->cprm->getHistorialDeControles());
            $x = $this->input->get();
            $this->db->select('PD.Clave AS ID, '
                            . 'PD.Estilo AS IdEstilo, '
                            . 'PD.Color AS IdColor, '
                            . "PD.Estilo AS Estilo, "
                            . "PD.Estilo AS \"Descripcion Estilo\", "
                            . "PD.color AS Color, "
                            . "PD.color AS \"Descripcion Color\", "
                            . "PD.Clave AS Pedido,"
                            . "PD.FechaPedido AS \"Fecha Pedido\","
                            . "PD.FechaRecepcion AS \"Fecha Entrega\","
                            . "DATE_FORMAT(PD.Registro,\"%d/%m/%Y\") AS \"Fecha Captura\","
                            . "PD.Semana AS Semana,"
                            . "PD.Maquila AS Maq,"
                            . "PD.Cliente AS Cliente,"
                            . "PD.Cliente AS \"Cliente Razon\","
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
                            . "CONCAT(CT.Ano, CT.Semana, CT.Maquila, CT.Consecutivo) AS Control,"
                            . "S.ID AS SerieID,"
                            . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                    ->join('series AS S', 'PD.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.Control = PD.Control')
                    ->where('PD.Control <> 0', null, false);
            if ($x['MAQUILA'] !== '') {
                $this->db->where('PD.Maquila', $x['MAQUILA']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('PD.Semana', $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where('PD.Ano', $x['ANIO']);
            }
            $this->db->order_by('PD.ID', 'DESC');
            if ($x['MAQUILA'] === '' && $x['SEMANA'] === '' && $x['ANIO'] === '') {
                $this->db->limit(100);
            }
            $dtm = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($dtm);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarControles() {
        try {
            $x = $this->input->post();
            $controles = json_decode($x['SubControles']);
            switch ($x['Marca']) {
                case 1:
                    foreach ($controles as $k => $v) {
                        if ($v->Control == "" || $v->Control == 0) {
                            $Y = substr(Date('Y'), 2);
                            $M = str_pad($v->Maquila, 2, '0', STR_PAD_LEFT);
                            $S = str_pad($v->Semana, 2, '0', STR_PAD_LEFT);

                            $EXISTEN_REGISTROS = $this->db->select('count(*) AS EXISTE', false)
                                            ->from('controles AS C')
                                            ->where("C.Ano = ABS({$Y}) AND C.Semana = ABS({$v->Semana}) "
                                                    . "AND C.Maquila = ABS({$v->Maquila})"
                                                    . "ORDER BY `C`.`Consecutivo` DESC", null, false)
                                            ->limit(1)->get()->result();


                            $MAXIMO_CONSECUTIVO = $this->db->select('(CT.Consecutivo+1) AS MAX', false)
                                            ->from('controles AS CT')
                                            ->where("CT.Maquila = ABS({$v->Maquila}) "
                                                    . "AND CT.Semana = ABS({$S}) "
                                                    . "AND CT.Ano = ABS({$Y})", null, false)
                                            ->order_by('CT.Consecutivo', 'DESC')
                                            ->limit(1)->get()->result();

//                            print $this->db->last_query();
//                            exit(0);
                            $C = str_pad(((intval($EXISTEN_REGISTROS[0]->EXISTE) === 0) ? 1 : $MAXIMO_CONSECUTIVO[0]->MAX), 3, '0', STR_PAD_LEFT);
                            $C = ((intval($C) > 0) ? $C : str_pad($C, 3, '0', STR_PAD_LEFT));

//                            exit(0);
                            $this->db->insert("controles", array(
                                'Control' => $Y . $S . $M . $C,
                                'FechaProgramacion' => Date('Y-m-d h:i:s'),
                                'Estilo' => $v->Estilo, 'Color' => $v->Color,
                                'Serie' => $v->Serie, 'Cliente' => $v->Cliente,
                                'Pares' => $v->Pares, 'Pedido' => $v->Pedido,
                                'PedidoDetalle' => $v->PedidoDetalle,
                                'Estatus' => 'A', 'Departamento' => 1 /* 0|null|Inexistente - PEDIDO => 1 - PROGRAMADO */,
                                'Ano' => $Y, 'Maquila' => $M, 'Semana' => $S, 'Consecutivo' => $C
                            ));
                            $Control = $Y . $S . $M . $C;
                            $this->db->set('Control', $Control)->set('FechaProduccion', Date('Y-m-d h:i:s'))
                                    ->where('Estilo', $v->Estilo)
                                    ->where('Color', $v->Color)
                                    ->where('Serie', $v->Serie)
                                    ->where('Maquila', $v->Maquila)
                                    ->where('Semana', $v->Semana)
                                    ->where('Ano', $v->Ano)
                                    ->where('Clave', $v->PedidoDetalle)
                                    ->where('ID', $v->ID)
                                    ->where('Control = 0', null, false)
                                    ->update('pedidox');
//                            print $this->db->last_query();/*QUEDA PARA PRUEBAS*/
//                            exit(0);

                            /* AGREGAR REGISTRO EN AVAPRD (FILI) */
                            $check_control = $this->db->select('COUNT(A.contped) AS EXISTE', false)
                                            ->from('avaprd AS A')
                                            ->where('A.contped', $Control)
                                            ->get()->result();
                            if (intval($check_control[0]->EXISTE) <= 0) {
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
                        }
                    }

                    $l = new Logs("Seleccionar pedidos por maquilador/semana/año para generar control", "GENERO CONTROLES DE LA MAQUILA {$x['MAQUILA']}, SEMANA {$x['SEMANA']}, AÑO {$x['ANIO']}.", $this->session);
                    break;
                case 2:
                    foreach ($controles as $k => $v) {
                        $this->cprm->onAgregarHistorialControl(array(
                            'Control' => $v->Control,
                            'Estilo' => $v->Estilo,
                            'EstiloDescripcion' => $v->DescripcionEstilo,
                            'Color' => $v->Color,
                            'ColorDescripcion' => $v->ColorDescripcion,
                            'Pedido' => $v->PedidoID,
                            'FechaPedido' => $v->FechaPedido,
                            'FechaEntregaRecepcion' => $v->FechaEntregaRecepcion,
                            'FechaCaptura' => $v->FechaCaptura,
                            'Semana' => $v->Semana,
                            'Maquila' => $v->Maquila,
                            'ClaveCliente' => $v->ClaveCliente,
                            'ClienteRazon' => $v->ClienteRazon,
                            'Pares' => $v->Pares,
                            'Precio' => $v->Precio,
                            'Importe' => $v->Importe,
                            'Descuento' => 0,
                            'FechaEntrega' => $v->FechaEntrega,
                            'Serie' => $v->SerieT,
                            'Ano' => $v->Ano,
                            'Marca' => $v->Marca,
                            'FechaEliminacion' => Date('d/m/Y h:i:s a'),
                            'Usuario' => $_SESSION["USERNAME"]
                        ));
                        $this->db->where('Pedido', $v->Pedido)->where('PedidoDetalle', $v->PedidoDetalle)->delete('Controles');
                        $this->db->set('Control', 0)->where('ID', $v->PedidoDetalle)->update('pedidox');
                    }
                    $l = new Logs("Seleccionar pedidos por maquilador/semana/año para generar control", "ELIMINO CONTROLES DE LA MAQUILA {$x['MAQUILA']}, SEMANA {$x['SEMANA']}, AÑO {$x['ANIO']}.", $this->session);

                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
