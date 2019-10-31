<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AsignaPFTSACXC extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AsignaPFTSACXC_model', 'apftsacxc');
    }

    public function is_logged() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vAsignaPFTSACXC')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function index() {
        $this->is_logged();
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->apftsacxc->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesAsignados() {
        try {
            $x = $this->input->get();
//            print json_encode($this->apftsacxc->getControlesAsignados());
            $this->db->select("A.ID, A.Empleado, A.Articulo, A.Descripcion, A.Fecha, A.Cargo, A.Abono, A.Devolucion AS Dev, A.Control AS Control")
                    ->from("asignapftsacxc AS A");
            if ($x['SEMANA'] !== '') {
                $this->db->where("A.Semana", $x['SEMANA']);
            }
            $this->db->order_by('A.Fecha', 'DESC');
            if ($x['SEMANA'] === '') {
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
//            print json_encode($this->apftsacxc->getRegresos());
            $x = $this->input->get();
            $this->db->select("A.ID, A.Empleado AS Cortador, A.Control, A.Fraccion AS PiFoFraccion, "
                            . "A.Estilo, A.Color, A.Pares, A.Articulo, A.Descripcion AS ArticuloT, "
                            . "A.Abono AS Entregado, A.Devolucion AS  Regreso, A.TipoMov AS Tipo, A.Fecha AS Fecha")
                    ->from("asignapftsacxc AS A")
                    ->where_in('A.TipoMov', array(1, 2, 34, 40));
            if ($x['CORTADOR'] !== '') {
                $this->db->where('A.Empleado', $x['CORTADOR']);
            }
            if ($x['PIFO'] !== '') {
                $this->db->where('A.Fraccion', $x['PIFO']);
            }
            $this->db->order_by('A.ID', 'DESC');
            $this->db->order_by('A.Semana', 'DESC');
            if ($x['CORTADOR'] === '' && $x['PIFO'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->apftsacxc->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl() {
        try {
            print json_encode($this->apftsacxc->getParesXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            $x = $this->input->get();
            $xdb = $this->db;
            $xdb->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($x['SEMANA'] !== '' && $x['CONTROL'] !== '') {
                $xdb->where('OP.Semana', $x['SEMANA'])->where('OP.ControlT', $x['CONTROL']);
            }
            $xdb->where('OPD.Grupo', 1)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')
                    ->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')
                    ->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');
            $xdb->order_by('OP.Semana', 'DESC');

            if ($x['SEMANA'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            if ($x['CONTROL'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            print json_encode($xdb->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            $x = $this->input->get();

            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($x['SEMANA'] !== '' && $x['CONTROL'] !== '') {
                $this->db->where('OP.Semana', $x['SEMANA'])->where('OP.ControlT', $x['CONTROL']);
            }
            $this->db->where('OPD.Grupo', 2)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');

            if ($x['SEMANA'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            if ($x['CONTROL'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            $x = $this->input->get();

            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($x['SEMANA'] !== '' && $x['CONTROL'] !== '') {
                $this->db->where('OP.Semana', $x['SEMANA'])->where('OP.ControlT', $x['CONTROL']);
            }
            $this->db->where('OPD.Grupo', 34)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');

            if ($x['SEMANA'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            if ($x['CONTROL'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            $x = $this->input->get();
//            print json_encode($this->apftsacxc->getSinteticos(
//                                    isset($_GET['SEMANA']) ? $x->get('SEMANA') : '', isset($_GET['CONTROL']) ? $x->get('CONTROL') : '', $x->get('FT')));

            $this->db->select("OP.ID, OP.ControlT AS CONTROL, OPD.Articulo AS ARTICULO_CLAVE, "
                            . "OPD.ArticuloT AS ARTICULO_DESCRIPCION, OPD.UnidadMedidaT AS UM, OPD.Pieza AS PIEZA, "
                            . "OPD.PiezaT AS PIEZA_DESCRIPCION, OPD.Grupo AS GRUPO, FORMAT(OPD.Cantidad,3) AS CANTIDAD, "
                            . "OP.ControlT AS CONTROL, OP.Semana AS SEMANA, CONCAT(96,99,100) AS FRACCION, "
                            . "OP.Pares AS PARES")
                    ->from("ordendeproduccion AS OP")
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
            if ($x['SEMANA'] !== '' && $x['CONTROL'] !== '') {
                $this->db->where('OP.Semana', $x['SEMANA'])->where('OP.ControlT', $x['CONTROL']);
            }
            $this->db->where('OPD.Grupo', 40)->where('OPD.Departamento', 10)
                    ->group_by('OPD.OrdenDeProduccion')->group_by('OP.ControlT')
                    ->group_by('OPD.Pieza')->group_by('OPD.Articulo')
                    ->group_by('OPD.UnidadMedidaT');

            if ($x['SEMANA'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            if ($x['CONTROL'] === '') {
                $this->db->limit(10); /* CARGA 10 REGISTROS MERAMENTE PARA VISTA */
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo() {
        try {
            print json_encode($this->apftsacxc->getExplosionXSemanaControlFraccionArticulo($this->input->get('SEMANA'), $this->input->get('CONTROL'), $this->input->get('FRACCION'), $this->input->get('ARTICULO'), $this->input->get('GRUPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEntregarPielForroTextilSintetico() {
        try {
            $x = $this->input->post();
            $xx = $this->input->post();
            $CONTROL = $this->db->query("SELECT P.Semana AS SEMANA, P.Maquila AS MAQUILA "
                            . "FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result();
//            var_dump($CONTROL);
//            exit(0);
            $CONTROL_SEMANA_MAQUILA = $CONTROL[0];
            /* CAMBIOS DE MAYO 2019 */
            /* COMPROBAR QUE EL ESTATUS DEL CONTROL SEA MENOR O IGUAL A 10 (CORTE), SI ESTA POR ENCIMA DEL 10 OSEA MAYOR A 10, EL TRATAMIENTO DEBE DE SER COMO PIOCHA */
            $ESTATUS = $this->db->query("SELECT PED.stsavan AS AVANCECORTE FROM pedidox AS PED WHERE PED.Control = {$x['CONTROL']} LIMIT 1")->result();
            $AGREGADO_CON_ANTERIORIDAD = $this->db->query("SELECT A.* AS A FROM asignapftsacxc AS A WHERE A.Control = {$x['CONTROL']} AND A.Articulo = {$xx['ARTICULO']}' LIMIT 1")->result();
//            print "\n ESTATUS \n";
//            var_dump($ESTATUS);
//            exit(0);
            if (intval($ESTATUS[0]->AVANCECORTE) >= 3) {
                $this->db->set('Piocha', $x['ENTREGA'])->where('Control', $x['CONTROL'])->update('asignapftsacxc');
            } else {
                /**/
                $Ano = $this->db->select('P.Ano AS Ano')->from('pedidox AS P')->where('P.Control', $x['CONTROL'])->get()->result()[0]->Ano;
                /* COMPROBAR SI YA EXISTE EL REGISTRO POR EMPLEADO,SEMANA, CONTROL, FRACCION, ARTICULO */
//                $DT = $this->apftsacxc->onComprobarEntrega($x['SEMANA'], $x['CONTROL'], $x['ARTICULO'], $x['FRACCION']);
                $DT = $this->db->select("A.*")
                                ->from("asignapftsacxc AS A")
                                ->where('A.Empleado', 0)
                                ->where("A.Articulo LIKE '{$xx['ARTICULO']}' "
                                        . "AND A.Semana LIKE '{$xx['SEMANA']}' "
                                        . "AND A.Control LIKE '{$xx['CONTROL']}' "
                                        . "AND A.Fraccion LIKE '{$xx['FRACCION']}' ", null, false)
                                ->get()->result();
//                var_dump($DT);
//                exit(0);
                /* EXISTE LA POSIBILIDAD DE QUE LA FRACCION SEA DIFERENTE Y QUE HAGA UN NUEVO REGISTRO */
                if (count($DT) > 0) {
                    $this->db->set('Cargo', ( $DT[0]->Cargo + $x['ENTREGA']))->where('ID', $DT[0]->ID)->update('asignapftsacxc');
                } else {
//                    $PRECIO = $this->apftsacxc->onObtenerPrecioMaquila($x['ARTICULO']);
                    /* MAQUILA UNO FIJO */
                    $PRECIO = $this->db->select("PM.Precio AS PRECIO_MAQUILA_UNO")
                                    ->from("preciosmaquilas AS PM")
                                    ->where("PM.Articulo = '{$x['ARTICULO']}'", null, false)
                                    ->where("PM.Maquila", 1)->get()->result();
                    $MAQUILA_X_CONTROL = $this->db->select("P.Maquila AS MAQUILA")
                                    ->from("pedidox AS P")->where("P.Control", $x['CONTROL'])
                                    ->get()->result();
//                    var_dump($PRECIO);
//                    var_dump($MAQUILA_X_CONTROL);
//                    exit(0);
                    $MAQUILA_CONTROL = 1;
//                            if(count((array)$obj)>0){
                    if (count($MAQUILA_X_CONTROL) > 0) {
                        $MAQUILA_CONTROL = $MAQUILA_X_CONTROL[0]->MAQUILA;
                    }
                    $data = array(
                        'PrecioProgramado' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                        'PrecioActual' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                        'OrdenProduccion' => $x['ORDENDEPRODUCCION'],
                        'Pares' => $x['PARES'],
                        'Semana' => $x['SEMANA'],
                        'Control' => $x['CONTROL'],
                        'Fraccion' => $x['FRACCION'],
                        'Empleado' => 0,
                        'Articulo' => $x['ARTICULO'],
                        'Descripcion' => $x['ARTICULOT'],
                        'Fecha' => Date('d/m/Y'),
                        'Explosion' => $x['EXPLOSION'],
                        'Cargo' => $x['EXPLOSION'],
                        'Abono' => $x['ENTREGA'],
                        'Devolucion' => 0,
                        'Maquila' => $MAQUILA_CONTROL,
                        'Estatus' => 'A',
                        'TipoMov' => $x['TIPO']/* 1 = PIEL, 2 = FORRO, 34 = TEXTIL , 40 = SINTETICO */,
                        'Extra' => $x['MATERIAL_EXTRA'],
                        'ExtraT' => ($x['MATERIAL_EXTRA'] > 0 && $x['EXPLOSION'] < $x['ENTREGA']) ? $x['ENTREGA'] - $x['EXPLOSION'] : 0
                    );
                    $this->db->insert('asignapftsacxc', $data);
//                    var_dump($data);
//                    exit(0);

                    $this->db->query("UPDATE asignapftsacxc AS A INNER JOIN ordendeproduccion AS O ON A.OrdenProduccion = O.ID
                    SET A.Estilo = O.Estilo, A.Color = O.Color
                    WHERE A.Control = '" . $x['CONTROL'] . "'
                    AND A.OrdenProduccion = " . $x['ORDENDEPRODUCCION']
                            . " AND A.Articulo = " . $x['ARTICULO']
                            . " AND A.Pares = " . $x['PARES']
                            . " AND A.Semana = " . $x['SEMANA']
                            . " AND A.Fraccion = " . $x['FRACCION']);
                    /* GENERAR AVANCE DE CONTROL A CORTE */

                    /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
                    $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)->from('avance AS A')->where('A.Control', $x['CONTROL'])->where('A.Departamento', 10)->get()->result();
                    print "\n onEntregarPielForroTextilSintetico ESTATUS DE AVANCE: ";

                    print "\n *FIN ESTATUS DE AVANCE* \n";
                    if (intval($check_avance[0]->EXISTE) === 0) {
                        /* YA EXISTE UN AVANCE DE CORTE EN ESTE CONTROL */
                        $avance = array(
                            'Control' => $x['CONTROL'],
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 10,
                            'DepartamentoT' => 'CORTE',
                            'FechaAvance' => Date('d/m/Y'),
                            'Estatus' => 'A',
                            'Usuario' => $_SESSION["ID"],
                            'Fecha' => Date('d/m/Y'),
                            'Hora' => Date('h:i:s a')
                        );
                        $this->db->insert('avance', $avance);


                        /* ACTUALIZA A 10 CORTE, stsavan 2 */
                        $this->db->set('EstatusProduccion', 'CORTE')
                                ->set('DeptoProduccion', 10)
                                ->where('Control', $x['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 2)
                                ->set('EstatusProduccion', 'CORTE')
                                ->set('DeptoProduccion', 10)
                                ->where('Control', $x['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec2', Date('Y-m-d h:i:s'))
                                ->where('contped', $x['CONTROL'])
                                ->update('avaprd');
                    }
                    /* FIN DE AVANCE DE CONTROL A CORTE */

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                    /* AGREGAR MOVIMIENTO DE ARTICULO */
                    $datos = array(
                        'Articulo' => $x['ARTICULO'],
                        'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                        'CantidadMov' => $x['ENTREGA'],
                        'FechaMov' => Date('d/m/Y'),
                        'EntradaSalida' => '2'/* 1= ENTRADA, 2 = SALIDA */,
                        'TipoMov' => 'SPR', /* SXP = SALIDA A PRODUCCION */
                        'DocMov' => $x['CONTROL'],
                        'Tp' => '',
                        'Maq' => $CONTROL_SEMANA_MAQUILA->MAQUILA,
                        'Sem' => $x['SEMANA'],
                        'Ano' => $Ano,
                        'OrdenCompra' => NULL,
                        'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x['ENTREGA']
                    );
                    $this->db->insert("movarticulos_fabrica", $datos);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDevolverPielForro() {
        try {
            /* AGREGAR MOVIMIENTO DE ARTICULO */
            $x = $this->input->post();
            $CONTROL = $this->db->query("SELECT P.Semana AS SEMANA, P.Maquila AS MAQUILA "
                            . "FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result();

            $Ano = $this->db->select('P.Ano AS Ano')->from('pedidox AS P')->where('P.Control', $x['CONTROL'])->get()->result()[0]->Ano;

            if (floatval($x['REGRESO']) === 0) {
                /* OBTENER ULTIMO REGRESO */
                $REGRESO = $this->apftsacxc->onObtenerUltimoRegreso($x['ID']);
                if (isset($REGRESO[0]->REGRESO)) {
                    $this->db->set('Empleado', $x['EMPLEADO'])->set('Empleado', $x['EMPLEADO'])
                            ->set('Devolucion', $x['REGRESO'] + $REGRESO[0]->REGRESO)
                            ->set('MaterialMalo', 0)
                            ->where('ID', $x['ID'])->update('asignapftsacxc');
                } else {
                    $this->db->set('Empleado', $x['EMPLEADO'])
                            ->set('Devolucion', $x['REGRESO'])
                            ->set('MaterialMalo', 0)
                            ->where('ID', $x['ID'])->update('asignapftsacxc');
                }
            } else {
                $PRECIO = $this->apftsacxc->onObtenerPrecioMaquila($x['ARTICULO']);
                if ($x['REGRESO'] >= 0 && $x["MATERIALMALO"] <= 0) {
                    $datos = array(
                        'Articulo' => $x['ARTICULO'],
                        'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                        'CantidadMov' => $x['REGRESO'],
                        'FechaMov' => Date('d/m/Y'),
                        'EntradaSalida' => '1'/* 1= ENTRADA, 2 = SALIDA */,
                        'TipoMov' => 'EPR', /* EXP = ENTRADA POR PRODUCCION */
                        'DocMov' => $x['CONTROL'],
                        'Tp' => ''/*                         * PORQUE NO VIENE UN MOVIMIENTO DE ALMACEN* */,
                        'Maq' => 1,
                        'Sem' => $CONTROL[0]->SEMANA,
                        'Ano' => $Ano,
                        'OrdenCompra' => NULL,
                        'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x['REGRESO']
                    );
                    $this->db->insert("movarticulos_fabrica", $datos);

                    /* OBTENER ULTIMO REGRESO */
                    $REGRESO = $this->apftsacxc->onObtenerUltimoRegreso($x['ID']);
                    if (isset($REGRESO[0]->REGRESO)) {
                        $this->db->set('Empleado', $x['EMPLEADO'])->set('Empleado', $x['EMPLEADO'])
                                ->set('Devolucion', $x['REGRESO'] + $REGRESO[0]->REGRESO)
                                ->set('MaterialMalo', 0)
                                ->where('ID', $x['ID'])->update('asignapftsacxc');
                    } else {
                        $this->db->set('Empleado', $x['EMPLEADO'])
                                ->set('Devolucion', $x['REGRESO'])
                                ->set('MaterialMalo', 0)
                                ->where('ID', $x['ID'])->update('asignapftsacxc');
                    }
                } else {
                    if ($x["MATERIALMALO"] > 0) {
                        $datos = array(
                            'Articulo' => $x['ARTICULO'],
                            'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                            'CantidadMov' => $x['REGRESO'],
                            'FechaMov' => Date('d/m/Y'),
                            'EntradaSalida' => '2'/* 1= ENTRADA, 2 = SALIDA */,
                            'TipoMov' => 'SPR', /* EXP = ENTRADA POR PRODUCCION */
                            'DocMov' => $x['CONTROL'],
                            'Tp' => '',
                            'Maq' => 1,
                            'Sem' => $CONTROL[0]->SEMANA,
                            'Ano' => $Ano,
                            'OrdenCompra' => 'BASURA',
                            'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x['REGRESO']
                        );
                        $this->db->insert("movarticulos_fabrica", $datos);
                        /**/
                        $this->db->set('Empleado', $x['EMPLEADO'])
                                ->set('Basura', $x['REGRESO'])
                                ->set('MaterialMalo', 1)
                                ->where('ID', $x['ID'])->update('asignapftsacxc');
                    } else {
                        print "LA CANTIDAD DEVUELTA ESTA DEFECTUOSA HA SIDO ZERO 0";
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT  A.Devolucion AS DEVOLVIO_ANTES, A.Estilo AS ESTILO, A.Color AS COLOR, A.ID AS IDA, A.Articulo AS ARTICULO, A.Descripcion AS ARTICULO_DESCRIPCION, A.Abono AS ENTREGO "
                                    . "FROM asignapftsacxc AS A WHERE A.Control = '{$x['CONTROL']}' AND A.Fraccion = {$x['PIFO']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
