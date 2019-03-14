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
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
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
            print json_encode($this->apftsacxc->getControlesAsignados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            print json_encode($this->apftsacxc->getRegresos());
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
            $x = $this->input;
            print json_encode($this->apftsacxc->getPieles(
                                    isset($_GET['SEMANA']) ? $x->get('SEMANA') : '', isset($_GET['CONTROL']) ? $x->get('CONTROL') : '', $x->get('FT')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            $x = $this->input;
            print json_encode($this->apftsacxc->getForros(
                                    isset($_GET['SEMANA']) ? $x->get('SEMANA') : '', isset($_GET['CONTROL']) ? $x->get('CONTROL') : '', $x->get('FT')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            $x = $this->input;
            print json_encode($this->apftsacxc->getTextiles(
                                    isset($_GET['SEMANA']) ? $x->get('SEMANA') : '', isset($_GET['CONTROL']) ? $x->get('CONTROL') : '', $x->get('FT')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            $x = $this->input;
            print json_encode($this->apftsacxc->getSinteticos(
                                    isset($_GET['SEMANA']) ? $x->get('SEMANA') : '', isset($_GET['CONTROL']) ? $x->get('CONTROL') : '', $x->get('FT')));
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
            $x = $this->input;
            $Ano = $this->db->select('P.Ano AS Ano')->from('pedidox AS P')->where('P.Control', $x->post('CONTROL'))->get()->result()[0]->Ano;
            /* COMPROBAR SI YA EXISTE EL REGISTRO POR EMPLEADO,SEMANA, CONTROL, FRACCION, ARTICULO */
            $DT = $this->apftsacxc->onComprobarEntrega($x->post('SEMANA'), $x->post('CONTROL'), $x->post('ARTICULO'), $x->post('FRACCION'));
            /* EXISTE LA POSIBILIDAD DE QUE LA FRACCION SEA DIFERENTE Y QUE HAGA UN NUEVO REGISTRO */
            if (count($DT) > 0) {
                $this->db->set('Cargo', ( $DT[0]->Cargo + $x->post('ENTREGA')))->where('ID', $DT[0]->ID)->update('asignapftsacxc');
            } else {
                $PRECIO = $this->apftsacxc->onObtenerPrecioMaquila($x->post('ARTICULO'));
                $data = array(
                    'PrecioProgramado' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                    'PrecioActual' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                    'OrdenProduccion' => $x->post('ORDENDEPRODUCCION'),
                    'Pares' => $x->post('PARES'),
                    'Semana' => $x->post('SEMANA'),
                    'Control' => $x->post('CONTROL'),
                    'Fraccion' => $x->post('FRACCION'),
                    'Empleado' => 0,
                    'Articulo' => $x->post('ARTICULO'),
                    'Descripcion' => $x->post('ARTICULOT'),
                    'Fecha' => Date('d/m/Y h:i:s a'),
                    'Explosion' => $x->post('EXPLOSION'),
                    'Cargo' => $x->post('EXPLOSION'),
                    'Abono' => $x->post('ENTREGA'),
                    'Devolucion' => 0,
                    'Estatus' => 'A',
                    'TipoMov' => $x->post('TIPO')/* 1 = PIEL, 2 = FORRO, 34 = TEXTIL , 40 = SINTETICO */,
                    'Extra' => $x->post('MATERIAL_EXTRA'),
                    'ExtraT' => ($x->post('MATERIAL_EXTRA') > 0 && $x->post('EXPLOSION') < $x->post('ENTREGA')) ? $x->post('ENTREGA') - $x->post('EXPLOSION') : 0
                );
                $this->db->insert('asignapftsacxc', $data);
                $this->db->query("UPDATE asignapftsacxc AS A INNER JOIN ordendeproduccion AS O ON A.OrdenProduccion = O.ID
                    SET A.Estilo = O.Estilo, A.Color = O.Color
                    WHERE A.Control LIKE '" . $x->post('CONTROL') . "'
                    AND A.OrdenProduccion = " . $x->post('ORDENDEPRODUCCION')
                        . " AND A.Articulo = " . $x->post('ARTICULO')
                        . " AND A.Pares = " . $x->post('PARES')
                        . " AND A.Semana = " . $x->post('SEMANA')
                        . " AND A.Fraccion = " . $x->post('FRACCION'));
                /* GENERAR AVANCE DE CONTROL A CORTE */

                /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
                $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)->from('avance AS A')->where('A.Control', $x->post('CONTROL'))->where('A.Departamento', 10)->get()->result();
                print "\n onEntregarPielForroTextilSintetico ESTATUS DE AVANCE: ";
                
                print "\n *FIN ESTATUS DE AVANCE* \n";
                if (intval($check_avance[0]->EXISTE) === 0) {
                    /* YA EXISTE UN AVANCE DE CORTE EN ESTE CONTROL */
                    $avance = array(
                        'Control' => $x->post('CONTROL'),
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
                    $this->db->set('EstatusProduccion', 'CORTE')
                            ->where('Control', $x->post('CONTROL'))
                            ->update('controles');
                }
                /* FIN DE AVANCE DE CONTROL A CORTE */

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
                /* AGREGAR MOVIMIENTO DE ARTICULO */
                $datos = array(
                    'Articulo' => $x->post('ARTICULO'),
                    'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                    'CantidadMov' => $x->post('ENTREGA'),
                    'FechaMov' => Date('d/m/Y'),
                    'EntradaSalida' => '2'/* 1= ENTRADA, 2 = SALIDA */,
                    'TipoMov' => 'SPR', /* SXP = SALIDA A PRODUCCION */
                    'DocMov' => $x->post('ORDENDEPRODUCCION'),
                    'Tp' => '',
                    'Maq' => intval(substr($x->post('CONTROL'), 4, 2)),
                    'Sem' => $x->post('SEMANA'),
                    'Ano' => $Ano,
                    'OrdenCompra' => NULL,
                    'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x->post('ENTREGA')
                );
                $this->db->insert("movarticulos_fabrica", $datos);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDevolverPielForro() {
        try {
            /* AGREGAR MOVIMIENTO DE ARTICULO */
            $x = $this->input;

            $Ano = $this->db->select('P.Ano AS Ano')->from('pedidox AS P')->where('P.Control', $x->post('CONTROL'))->get()->result()[0]->Ano;

            if (floatval($x->post('REGRESO')) === 0) {
                /* OBTENER ULTIMO REGRESO */
                $REGRESO = $this->apftsacxc->onObtenerUltimoRegreso($x->post('ID'));
                if (isset($REGRESO[0]->REGRESO)) {
                    $this->db->set('Empleado', $x->post('EMPLEADO'))->set('Empleado', $x->post('EMPLEADO'))
                            ->set('Devolucion', $x->post('REGRESO') + $REGRESO[0]->REGRESO)
                            ->set('MaterialMalo', 0)
                            ->where('ID', $x->post('ID'))->update('asignapftsacxc');
                } else {
                    $this->db->set('Empleado', $x->post('EMPLEADO'))
                            ->set('Devolucion', $x->post('REGRESO'))
                            ->set('MaterialMalo', 0)
                            ->where('ID', $x->post('ID'))->update('asignapftsacxc');
                }
            } else {
                $PRECIO = $this->apftsacxc->onObtenerPrecioMaquila($x->post('ARTICULO'));
                if ($x->post('REGRESO') >= 0 && $x->post("MATERIALMALO") <= 0) {
                    $datos = array(
                        'Articulo' => $x->post('ARTICULO'),
                        'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                        'CantidadMov' => $x->post('REGRESO'),
                        'FechaMov' => Date('d/m/Y'),
                        'EntradaSalida' => '1'/* 1= ENTRADA, 2 = SALIDA */,
                        'TipoMov' => 'EPR', /* EXP = ENTRADA POR PRODUCCION */
                        'DocMov' => $x->post('ID'),
                        'Tp' => ''/*                         * PORQUE NO VIENE UN MOVIMIENTO DE ALMACEN* */,
                        'Maq' => 1,
                        'Sem' => substr($x->post('CONTROL'), 2, 2),
                        'Ano' => $Ano,
                        'OrdenCompra' => NULL,
                        'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x->post('REGRESO')
                    );
                    $this->db->insert("movarticulos_fabrica", $datos);

                    /* OBTENER ULTIMO REGRESO */
                    $REGRESO = $this->apftsacxc->onObtenerUltimoRegreso($x->post('ID'));
                    if (isset($REGRESO[0]->REGRESO)) {
                        $this->db->set('Empleado', $x->post('EMPLEADO'))->set('Empleado', $x->post('EMPLEADO'))
                                ->set('Devolucion', $x->post('REGRESO') + $REGRESO[0]->REGRESO)
                                ->set('MaterialMalo', 0)
                                ->where('ID', $x->post('ID'))->update('asignapftsacxc');
                    } else {
                        $this->db->set('Empleado', $x->post('EMPLEADO'))
                                ->set('Devolucion', $x->post('REGRESO'))
                                ->set('MaterialMalo', 0)
                                ->where('ID', $x->post('ID'))->update('asignapftsacxc');
                    }
                } else {
                    if ($x->post("MATERIALMALO") > 0) {
                        $datos = array(
                            'Articulo' => $x->post('ARTICULO'),
                            'PrecioMov' => $PRECIO[0]->PRECIO_MAQUILA_UNO,
                            'CantidadMov' => $x->post('REGRESO'),
                            'FechaMov' => Date('d/m/Y'),
                            'EntradaSalida' => '1'/* 1= ENTRADA, 2 = SALIDA */,
                            'TipoMov' => 'EPR', /* EXP = ENTRADA POR PRODUCCION */
                            'DocMov' => $x->post('ID'),
                            'Tp' => '',
                            'Maq' => 1,
                            'Sem' => substr($x->post('CONTROL'), 2, 2),
                            'Ano' => $Ano,
                            'OrdenCompra' => NULL,
                            'Subtotal' => $PRECIO[0]->PRECIO_MAQUILA_UNO * $x->post('REGRESO')
                        );
                        $this->db->insert("movarticulos_fabrica", $datos);
                        /**/
                        $this->db->set('Empleado', $x->post('EMPLEADO'))
                                ->set('Basura', $x->post('REGRESO'))
                                ->set('MaterialMalo', 1)
                                ->where('ID', $x->post('ID'))->update('asignapftsacxc');
                    } else {
                        print "LA CANTIDAD DEVUELTA ESTA DEFECTUOSA HA SIDO ZERO 0";
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
