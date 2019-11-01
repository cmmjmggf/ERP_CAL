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
                                . "PD.Serie AS Serie, "
                                . "PD.Ano AS Anio,"
                                . " CASE "
                                . "WHEN PD.Control IS NULL THEN '' "
                                . "ELSE PD.Control END AS Marca, "
                                . "CT.Control AS Control,"
                                . "S.ID AS SerieID,"
                                . "PD.Clave AS ID_PEDIDO", false)->from('pedidox AS PD')
                        ->join('clientes AS CL', 'CL.Clave = PD.Cliente', 'left')
                        ->join('series AS S', 'PD.Serie = S.Clave')
                        ->join('controles AS CT', 'CT.PedidoDetalle = PD.Clave')
                        ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.Clave', 'left')
                        ->where('PD.Control <> 0 AND OP.ID IS NULL AND CT.Control = PD.Control', null, false)
                        ->where('CT.Estatus', 'A');
                if ($x["ANIO"] !== '') {
                    $this->db->where('PD.Ano', $x["ANIO"]);
                    $ANIO_CT = substr($x["ANIO"], 2, 2);
                    $this->db->where('CT.Ano', $ANIO_CT);
                }
                if ($x["MAQUILA"] !== '') {
                    $this->db->where('PD.Maquila', $x["MAQUILA"]);
                }
                if ($x["SEMANA"] !== '') {
                    $this->db->where('PD.Semana', $x["SEMANA"]);
                }
                if ($x["ANIO"] === '' && $x["MAQUILA"] === '' && $x["SEMANA"] === '') {
                    $this->db->limit(99);
                }
                $sql = $this->db->get();
//                PRINT $this->db->last_query();
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
            $x = $this->input->post();
            $ANIO_CT = substr($x["ANO"], 2, 2);
            $PEDIDO_DETALLE = $this->db->select("P.Clave AS CLAVE_PEDIDO, P.Cliente CLAVE_CLIENTE, "
                                    . "IFNULL(C.RazonS,\"Z FALTA AGREGAR EL CLIENTE\") AS CLIENTE, "
                                    . "P.FechaPedido AS FECHA_PEDIDO, "
                                    . "T.Descripcion AS TRANSPORTE, A.Nombre AGENTE, S.Clave AS SERIE,"
                                    . "CT.ID AS CLAVE_CONTROL,"
                                    . "S.T1, S.T2, S.T3, S.T4, S.T5,"
                                    . "S.T6, S.T7, S.T8, S.T9, S.T10,"
                                    . "S.T11, S.T12, S.T13, S.T14, S.T15,"
                                    . "S.T16, S.T17, S.T18, S.T19, S.T20,"
                                    . "S.T21,S.T22,L.Clave AS CLAVE_LINEA, L.Descripcion AS LINEA,"
                                    . "E.Horma AS HORMA, E.Descripcion AS OESTILOT, "
                                    . "CO.Descripcion AS OCOLORT, P.Clave AS PEDIDO_DETALLE,"
                                    . "P.*, P.Clave AS Pedido", false)
                            ->from('pedidox AS P')
                            ->join('clientes AS C', 'P.Cliente = C.Clave', 'left')
                            ->join('estilos AS E', 'P.Estilo = E.Clave', 'left')
                            ->join('colores AS CO', 'P.Color = CO.Clave', 'left')
                            ->join('agentes AS A', 'P.Agente = A.Clave', 'left')
                            ->join('transportes AS T', 'C.Transporte = T.Clave', 'left')
                            ->join('series AS S', 'P.Serie = S.Clave', 'left')
                            ->join('lineas AS L', 'E.Linea = L.Clave', 'left')
                            ->join('controles AS CT', 'CT.PedidoDetalle = P.Clave', 'left')
                            ->join('ordendeproduccion AS OP', 'OP.Pedido = P.Clave  AND OP.PedidoDetalle = P.Clave', 'left')
                            ->where('P.Maquila', $x['MAQUILA'])
                            ->where('P.Semana', $x['SEMANA'])
                            ->where('P.Ano', $x['ANO'])
                            ->where('E.Clave = CO.Estilo  AND CT.PedidoDetalle = P.Clave  '
                                    . 'AND CT.Ano = ' . $ANIO_CT . ' AND OP.ID IS NULL '
                                    . 'AND CT.Control = P.Control', null, false)
                            ->get()->result();
//            $str = $this->db->last_query();
//            PRINT $str;
//            exit(0);
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
                $op["Semana"] = $x['SEMANA'];
                $op["Maquila"] = $x['MAQUILA'];
                $op["Ano"] = $x['ANO'];
                $op["Observaciones"] = $v->Observacion;
                $op["ObservacionesDetalle"] = $v->ObservacionDetalle;

                $P_F_S_S = $this->db->select("G.Clave, G.Nombre AS Grupo, A.Descripcion AS PIEL_FORRO_SINTETICO_SUELA ,
                            ((sum(FT.Consumo) * (
                            (CASE
                            WHEN  E.PiezasCorte BETWEEN 0 AND 10 AND A.Grupo IN(1,2) THEN M.PorExtra3a10
                            WHEN  E.PiezasCorte BETWEEN 11 AND 14  AND A.Grupo IN(1,2) THEN M.PorExtra11a14
                            WHEN  E.PiezasCorte BETWEEN 15 AND 18 AND A.Grupo IN(1,2) THEN M.PorExtra15a18
                            WHEN  E.PiezasCorte >=19  AND A.Grupo IN(1,2) THEN M.PorExtra19a
                            ELSE 0
                            END) + 1)) * {$v->Pares}) AS CONSUMOTOTAL", false)
                                ->from('fichatecnica AS FT')
                                ->join('articulos AS A', 'FT.Articulo = A.Clave')
                                ->join('estilos AS E', 'FT.Estilo = E.Clave')
                                ->join('maquilas AS M', 'E.Maquila = M.Clave')
                                ->join('grupos AS G ', 'A.Grupo = G.Clave')
                                ->where('FT.Estilo', $v->Estilo)
                                ->where('FT.Color', $v->Color)
                                ->where_in('A.Grupo', array(1, 2, 40, 3))
                                ->group_by('A.Descripcion')
                                ->order_by('ABS(G.Clave)', 'ASC')
                                ->order_by('A.Descripcion', 'ASC')->get()->result();
                $total_piel = 0;
                $total_forro = 0;
                $total_sintetico = 0;
                $piel = 1;
                $forro = 1;
                $sintetico = 1;
                $str = $this->db->last_query();
//            PRINT $str;
//            exit(0);
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
//                var_dump($op);
//                exit(0);
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
                $ORDENDEPRODUCCIOND = $this->db->select("P.Clave AS PIEZA, P.Descripcion AS PIEZAT,
                                    A.Clave AS ARTICULO, A.Descripcion AS ARTICULOT,
                                    D.Clave AS DEPARTAMENTO, D.Descripcion AS DEPARTAMENTOT,
                                    FT.PzXPar AS PZXPAR, U.Clave AS UNIDAD, U.Descripcion AS UNIDADT,
                                    FT.Consumo AS CONSUMO, P.Clasificacion AS CLASIFICACION,
                                    ((SUM(FT.Consumo) * ((CASE
                                      WHEN  E.PiezasCorte BETWEEN 0 AND 10 AND A.Grupo IN(1,2) THEN M.PorExtra3a10
                                      WHEN  E.PiezasCorte BETWEEN 11 AND 14  AND A.Grupo IN(1,2) THEN M.PorExtra11a14
                                      WHEN  E.PiezasCorte BETWEEN 15 AND 18 AND A.Grupo IN(1,2) THEN M.PorExtra15a18
                                      WHEN  E.PiezasCorte >=19  AND A.Grupo IN(1,2) THEN M.PorExtra19a
                                      ELSE 0 END) +1)) * {$v->Pares}) AS CANTIDAD_CONSUMO, FT.Precio AS PRECIO,
                                    FT.AfectaPV AS AFECTAPV, A.Grupo AS GRUPO, A.Departamento AS DEPTOART", false)
                                ->from('fichatecnica AS FT')
                                ->join('articulos AS A', 'FT.Articulo = A.Clave')
                                ->join('estilos AS E', 'FT.Estilo = E.Clave')
                                ->join('maquilas AS M', 'E.Maquila = M.Clave')
                                ->join('piezas AS P', 'FT.Pieza = P.Clave')
                                ->join('departamentos AS D', 'P.Departamento = D.Clave')
                                ->join('unidades AS U', 'A.UnidadMedida = U.Clave')
                                ->where('FT.Estilo', $v->Estilo)
                                ->where('FT.Color', $v->Color)
                                ->where_not_in('A.Grupo', 3)
                                ->group_by('P.Clave')
                                ->order_by('ABS(D.Clave)', 'ASC')
                                ->order_by('CANTIDAD_CONSUMO', 'ASC')
                                ->get()->result();

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

                /* MOVER ESTATUS EN CASO DE MAQUILAS 2,3,4,5...99 */
                if (intval($v->Maquila) > 1) {
                    /*
                     * CUANDO LOS TRAEN DE UNA MAQUILA QUE NO ES LA 1 (UNO): SE DEBEN DE PROCESAR A ENSUELADO 
                     * 140 = ENSUELADO
                     */

                    /* 1.- MOVER EL STSAVAN EN PEDIDOX */
                    $this->db->set('stsavan', 55)->set('DeptoProduccion', 140)
                            ->set('EstatusProduccion', 'ENSUELADO')
                            ->where('Maquila', $x['MAQUILA'])
                            ->where('Semana', $x['SEMANA'])
                            ->where('Ano', $x['ANO'])
                            ->where('Control', $v->Control)
                            ->update('pedidox');

                    /* 2.- AÑADIR UN AVANCE A ENSUELADO */
//                    $this->db->insert('avance', array(
//                        'Control' => $v->Control,
//                        'Departamento' => 140,
//                        'DepartamentoT' => 'ENSUELADO',
//                        'FechaAProduccion' => Date('d/m/Y'),
//                        'FechaAvance' => Date('d/m/Y'),
//                        'Estatus' => 'A',
//                        'Usuario' => $_SESSION["ID"],
//                        'Fecha' => Date('d/m/Y'),
//                        'Hora' => Date('h:i:s a'),
//                        'Fraccion' => 397,
//                        'Docto' => 0
//                    ));
                    $this->db->insert('avance', array(
                        'Control' => $v->Control,
                        'Departamento' => 140,
                        'DepartamentoT' => 'ENSUELADO',
                        'FechaAProduccion' => Date('d/m/Y'),
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => 397,
                        'Docto' => 0
                    ));

                    /* 3.- ACTUALIZAR LA FECHA 55 EN AVAPRD PARA ENSUELADO */
                    $this->db->set('fec55', Date('Y-m-d h:i:s'))
                            ->where('contped', $v->Control)
                            ->update('avaprd');

                    /* 4.- ACTUALIZAR EN CONTROLES  */
                    $this->db->set('DeptoProduccion', 140)
                            ->set('EstatusProduccion', 'ENSUELADO')
                            ->where('Control', $v->Control)
                            ->update('controles');
                }
            }
            print count($PEDIDO_DETALLE);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTotalParesXMaquilaXSemanaXAno() {
        try {
            $x = $this->input->get();
            $this->db->select("IFNULL(SUM(PD.Pares),0) AS PARES", false)->from('pedidox AS PD')
                    ->join('clientes AS CL', 'CL.Clave = PD.Cliente', 'left')
                    ->join('series AS S', 'PD.Serie = S.Clave')
                    ->join('controles AS CT', 'CT.PedidoDetalle = PD.Clave')
                    ->join('ordendeproduccion AS OP', 'OP.Pedido = PD.Clave  AND OP.PedidoDetalle = PD.Clave', 'left')
                    ->where('PD.Control <> 0 AND OP.ID IS NULL AND CT.Control = PD.Control', null, false)
                    ->where('CT.Estatus', 'A');
            if ($x["ANIO"] !== '') {
                $this->db->where('PD.Ano', $x["ANIO"]);
                $ANIO_CT = substr($x["ANIO"], 2, 2);
                $this->db->where('CT.Ano', $ANIO_CT);
            }
            if ($x["MAQUILA"] !== '') {
                $this->db->where('PD.Maquila', $x["MAQUILA"]);
            }
            if ($x["SEMANA"] !== '') {
                $this->db->where('PD.Semana', $x["SEMANA"]);
            }
            $sql = $this->db->get();
//                PRINT $this->db->last_query();
            print json_encode($sql->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
