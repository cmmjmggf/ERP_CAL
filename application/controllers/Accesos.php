<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Accesos_model', 'acm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vAccesos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getTiposDeAcceso() {
        try {
            print json_encode($this->acm->getTiposDeAcceso());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUsuarios() {
        try {
            print json_encode($this->acm->getUsuarios());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getModulos() {
        try {
            print json_encode($this->acm->getModulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getModulosXUsuario() {
        try {
            print json_encode($this->acm->getModulosXUsuario($this->input->get('U')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpciones() {
        try {
            print json_encode($this->acm->getOpciones($this->input->get('M')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModuloxUsuario() {
        try {
            print json_encode($this->acm->getOpcionesXModuloxUsuario($this->input->get('U'), $this->input->get('M')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getItems() {
        try {
            print json_encode($this->acm->getItems($this->input->get('O')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getItemsXOpcionXModuloxUsuario() {
        try {
            print json_encode($this->acm->getItemsXOpcionXModuloxUsuario($this->input->get('U'), $this->input->get('M'), $this->input->get('O')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getItemsConSubItemsXOpcionXModuloxUsuario() {
        try {
            print json_encode($this->acm->getItemsConSubItemsXOpcionXModuloxUsuario($this->input->get('U'), $this->input->get('M'), $this->input->get('O')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubItems() {
        try {
            print json_encode($this->acm->getSubItems($this->input->get('I')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubItemsXItemXOpcionXModuloxUsuario() {
        try {
            print json_encode($this->acm->getSubItemsXItemXOpcionXModuloxUsuario($this->input->get('U'), $this->input->get('M'), $this->input->get('O'), $this->input->get('I')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubSubItems() {
        try {
            print json_encode($this->acm->getSubSubItems($this->input->get('SI')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubSubItemsXSubItemXItemXOpcionXModuloxUsuario() {
        try {
            print json_encode($this->acm->getSubSubItemsXSubItemXItemXOpcionXModuloxUsuario($this->input->get('U'), $this->input->get('M'), $this->input->get('O'), $this->input->get('I'), $this->input->get('SI')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarModulosXUsuario() {
        try {
            $x = $this->input;
            $options = json_decode($this->input->post('OPTIONS'));
            $modulos = array();
            foreach ($options as $k => $v) {
                /* COMPROBAR SI YA SE TIENE ESE MODULO */
                $tiene_el_modulo = $this->db->select('MXU.ID')
                                ->from('modulosxusuario AS MXU')
                                ->where('MXU.Usuario', $x->post('USR'))
                                ->where('MXU.Modulo', $v->MODULO)
                                ->get()->result();

                if (count($tiene_el_modulo) <= 0) {
                    $this->db->insert('modulosxusuario', array(
                        'Modulo' => $v->MODULO,
                        'Usuario' => $x->post('USR'),
                        'UsuarioAsigna' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y h:i:s a')
                    ));
                }
                array_push($modulos, $v->MODULO);
            }
            /* ELIMINAR LOS NO SELECCIONADOS */
            $modulos_no_seleccionados = $this->db->select('MXU.ID, MXU.Modulo AS MODULO')
                            ->from('modulosxusuario AS MXU')
                            ->where('MXU.Usuario', $x->post('USR'))
                            ->get()->result();

            foreach ($modulos_no_seleccionados as $k => $v) {
                if (!in_array($v->MODULO, $modulos)) {
                    $this->db->where('ID', $v->ID)->where('MODULO', $v->MODULO)->where('Usuario', $x->post('USR'))->delete('modulosxusuario');
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarOpcionesXModuloXUsuario() {
        try {
            $x = $this->input;
            $USR = $x->post('USR');
            $MDL = $x->post('MDL');
            $options = json_decode($this->input->post('OPTIONS'));
            $opciones = array();
            foreach ($options as $k => $v) {
                /* COMPROBAR SI YA SE TIENE ESE MODULO */
                $tiene_la_opcion = $this->db->select('MXU.ID')
                                ->from('opcionesxmoduloxusuario AS MXU')
                                ->where('MXU.Usuario', $USR)
                                ->where('MXU.Modulo', $MDL)
                                ->where('MXU.Opcion', $v->OPCION)
                                ->get()->result();

                if (count($tiene_la_opcion) <= 0) {
                    $this->db->insert('opcionesxmoduloxusuario', array(
                        'Opcion' => $v->OPCION,
                        'Modulo' => $MDL,
                        'Usuario' => $USR,
                        'UsuarioAsigna' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y h:i:s a')
                    ));
                }
                array_push($opciones, $v->OPCION);
            }
            /* ELIMINAR LOS NO SELECCIONADOS */
            $opciones_no_seleccionadas = $this->db->select('MXU.ID, MXU.Opcion AS OPCION')
                            ->from('opcionesxmoduloxusuario AS MXU')
                            ->where('MXU.Usuario', $USR)
                            ->get()->result();

            foreach ($opciones_no_seleccionadas as $k => $v) {
                if (!in_array($v->OPCION, $opciones)) {
                    $this->db->where('ID', $v->ID)->where('Modulo', $MDL)
                            ->where('Opcion', $v->OPCION)->where('Usuario', $USR)
                            ->delete('opcionesxmoduloxusuario');
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarItemsXOpcionXModuloXUsuario() {
        try {
            $x = $this->input;
            $USR = $x->post('USR');
            $MDL = $x->post('MDL');
            $OPC = $x->post('OPC');
            $options = json_decode($this->input->post('OPTIONS'));
            $items = array();
            foreach ($options as $k => $v) {
                /* COMPROBAR SI YA SE TIENE ESE MODULO */
                $tiene_la_opcion = $this->db->select('IXOMU.ID')
                                ->from('itemsxopcionxmoduloxusuario AS IXOMU')
                                ->where('IXOMU.Usuario', $USR)
                                ->where('IXOMU.Modulo', $MDL)
                                ->where('IXOMU.Opcion', $OPC)
                                ->where('IXOMU.Item', $v->ITEM)
                                ->get()->result();

                if (count($tiene_la_opcion) <= 0) {
                    $this->db->insert('itemsxopcionxmoduloxusuario', array(
                        'Item' => $v->ITEM,
                        'Opcion' => $OPC,
                        'Modulo' => $MDL,
                        'Usuario' => $USR,
                        'UsuarioAsigna' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y h:i:s a')
                    ));
                }
                array_push($items, $v->ITEM);
            }
            /* ELIMINAR LOS NO SELECCIONADOS */
            $items_no_seleccionados = $this->db->select('IXOMU.ID, IXOMU.Item AS ITEM')
                            ->from('itemsxopcionxmoduloxusuario AS IXOMU')
                            ->where('IXOMU.Usuario', $USR)
                            ->get()->result();
            foreach ($items_no_seleccionados as $k => $v) {
                if (!in_array($v->ITEM, $items)) {
                    $this->db->where('ID', $v->ID)->where('Modulo', $MDL)
                            ->where('Opcion', $OPC)->where('Item', $v->ITEM)
                            ->where('Usuario', $USR)->delete('itemsxopcionxmoduloxusuario');
                    PRINT $this->db->last_query();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarSubItemsXItemXOpcionXModuloXUsuario() {
        try {
            $x = $this->input;
            $USR = $x->post('USR');
            $MDL = $x->post('MDL');
            $OPC = $x->post('OPC');
            $ITE = $x->post('ITE');
            $options = json_decode($this->input->post('OPTIONS'));
            $subitems = array();
            foreach ($options as $k => $v) {
                /* COMPROBAR SI YA SE TIENE ESE MODULO */
                $tiene_la_opcion = $this->db->select('SIXIOMU.ID')
                                ->from('subitemsxitemxopcionxmoduloxusuario AS SIXIOMU')
                                ->where('SIXIOMU.Usuario', $USR)
                                ->where('SIXIOMU.Modulo', $MDL)
                                ->where('SIXIOMU.Opcion', $OPC)
                                ->where('SIXIOMU.Item', $ITE)
                                ->where('SIXIOMU.SubItem', $v->SUBITEM)
                                ->get()->result();

                if (count($tiene_la_opcion) <= 0) {
                    $this->db->insert('subitemsxitemxopcionxmoduloxusuario', array(
                        'SubItem' => $v->SUBITEM,
                        'Item' => $ITE,
                        'Opcion' => $OPC,
                        'Modulo' => $MDL,
                        'Usuario' => $USR,
                        'UsuarioAsigna' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y h:i:s a')
                    ));
                }
                array_push($subitems, $v->SUBITEM);
            }
            /* ELIMINAR LOS NO SELECCIONADOS */
            $items_no_seleccionados = $this->db->select('SIOXM.ID, SIOXM.SubItem AS SUBITEM')
                            ->from('subitemsxitemxopcionxmoduloxusuario AS SIOXM')
                            ->where('SIOXM.Usuario', $USR)
                            ->get()->result();
            foreach ($items_no_seleccionados as $k => $v) {
                if (!in_array($v->SUBITEM, $subitems)) {
                    $this->db->where('ID', $v->ID)->where('Modulo', $MDL)
                            ->where('Opcion', $OPC)->where('Item', $ITE)
                            ->where('SubItem', $v->SUBITEM)->where('Usuario', $USR)
                            ->delete('subitemsxitemxopcionxmoduloxusuario');
                    PRINT $this->db->last_query();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarSubSubItemsXSubItemXItemXOpcionXModuloXUsuario() {
        try {
            $x = $this->input;
            $USR = $x->post('USR');
            $MDL = $x->post('MDL');
            $OPC = $x->post('OPC');
            $ITE = $x->post('ITE');
            $SITE = $x->post('SITE');
            $options = json_decode($this->input->post('OPTIONS'));
            $subsubitems = array();
            foreach ($options as $k => $v) {
                /* COMPROBAR SI YA SE TIENE ESE MODULO */
                $tiene_la_opcion = $this->db->select('A.ID')
                                ->from('subsubitemsxitemxopcionxmoduloxusuario AS A')
                                ->where('A.Usuario', $USR)
                                ->where('A.Modulo', $MDL)
                                ->where('A.Opcion', $OPC)
                                ->where('A.Item', $ITE)
                                ->where('A.SubItem', $SITE)
                                ->where('A.SubSubItem', $v->SUBSUBITEM)
                                ->get()->result();
                if (count($tiene_la_opcion) <= 0) {
                    $this->db->insert('subsubitemsxitemxopcionxmoduloxusuario', array(
                        'SubSubItem' => $v->SUBSUBITEM,
                        'SubItem' => $SITE,
                        'Item' => $ITE,
                        'Opcion' => $OPC,
                        'Modulo' => $MDL,
                        'Usuario' => $USR,
                        'UsuarioAsigna' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y h:i:s a')
                    ));
                }
                array_push($subsubitems, $v->SUBSUBITEM);
            }
            /* ELIMINAR LOS NO SELECCIONADOS */
            $items_no_seleccionados = $this->db->select('B.ID, B.SubSubItem AS SUBSUBITEM')
                            ->from('subsubitemsxitemxopcionxmoduloxusuario AS B')
                            ->where('B.Usuario', $USR)
                            ->get()->result();
            foreach ($items_no_seleccionados as $k => $v) {
                if (!in_array($v->SUBSUBITEM, $subsubitems)) {
                    $this->db->where('ID', $v->ID)->where('Modulo', $MDL)
                            ->where('Opcion', $OPC)->where('Item', $ITE)
                            ->where('SubItem', $SITE)
                            ->where('SubSubItem', $v->SUBSUBITEM)
                            ->where('Usuario', $USR)
                            ->delete('subsubitemsxitemxopcionxmoduloxusuario');
                    print $this->db->last_query();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAsignarTodo() {
        try {
            $this->acm->onAsignarTodo($this->input->post('USUARIO'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAsignaAvaPRD() {
        try {
            $dtm = $this->db->select('ID, contped, status, fec1, fec2, fec3, fec33, '
                                    . 'fec4, fec40, fec42, fec44, fec5, '
                                    . 'fec55, fec6, fec7, fec8, fec9, '
                                    . 'fec10, fec11, fec12, programado, corte, '
                                    . 'rayado, rebajado, foleado, pespunte, ensuelado, '
                                    . 'almpesp, tejido, almtejido, montado, adorno, '
                                    . 'almadorno, terminado, fec13, fec14, fec15, '
                                    . 'fec16, fec17, fec18', false)->from('avaprd AS A')
                            ->get()->result();
            $deptos = array('fec1', 'fec2', 'fec3', 'fec33', 'fec4', 'fec40', 'fec42',
                'fec44', 'fec5', 'fec55', 'fec6', 'fec7', 'fec8', 'fec9', 'fec10', 'fec11', 'fec12');
            foreach ($dtm as $key => $v) {
                foreach ($deptos as $kk => $vv) {
                    $depto = 0;
                    $fecha_depto = "";
                    if ($v->{$vv} !== '1899-12-30 00:00:00') {
                        switch ($vv) {
                            case 'fec1':
                                $depto = 0;
                                break;
                            case 'fec2':
                                $depto = 10;
                                break;
                            case 'fec3':
                                $depto = 20;
                                break;
                            case 'fec33':
                                $depto = 30;
                                break;
                            case 'fec4':
                                $depto = 40;
                                break;
                            case 'fec40':
                                $depto = 90;
                                break;
                            case 'fec42':
                                $depto = 100;
                                break;
                            case 'fec44':
                                $depto = 105;
                                break;
                            case 'fec5':
                                $depto = 110;
                                break;
                            case 'fec55':
                                $depto = 140;
                                break;
                            case 'fec6':
                                $depto = 130;
                                break;
                            case 'fec7':
                                $depto = 150;
                                break;
                            case 'fec8':
                                $depto = 160;
                                break;
                            case 'fec9':
                                $depto = 180;
                                break;
                            case 'fec10':
                                $depto = 210;
                                break;
                            case 'fec11':
                                $depto = 230;
                                break;
                            case 'fec12':
                                $depto = 240;
                                break;
                        }
                        $avance = array('Control' => $v->contped,
                            'FechaAProduccion' => '01/01/2000',
                            'Departamento' => $depto,
                            'FechaAvance' => $v->{$vv},
                            'Estatus' => 'A',
                            'Usuario' => 999,
                            'Fecha' => '01/01/2000',
                            'Hora' => '12:00:00 AM',
                            'Fraccion' => NULL,
                            'Docto' => $v->almpesp);
                        $this->db->insert('avance', $avance);
                    }
                }
            }
            $this->db->query('UPDATE erp_cal.avance AS A INNER JOIN departamentos AS D ON A.Departamento = D.Clave SET A.DepartamentoT = D.Descripcion WHERE A.ID > 0;');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
