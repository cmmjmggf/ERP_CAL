<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Articulos_model')->model('Articulos10_model')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                    } else if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vArticulos');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onReporteHistoryPrecios() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["articulo"] = $this->input->post('ArticuloHistory');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\reporteCambiosPreciosHistory.jasper');
        $jc->setFilename('HISTORIAL_DE_PRECIOS_POR_ART_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificarArticulo() {
        try {
            print json_encode($this->db->query("select clave from articulos where clave = '{$this->input->get('Articulo')}' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGenerarPreciosBaseMaquilaUno() {
        try {
            $Art = $this->input->post('Clave');
            $Existe = $this->db->query("SELECT precio FROM preciosmaquilas where Articulo = '$Art' and Maquila = '1' and Estatus = 'A' ")->result();
            if (!empty($Existe)) {
                $Precio = $Existe[0]->precio;
                $this->db->query("delete from preciosmaquilas where Articulo = '$Art' ");
                $this->db->query("INSERT INTO `preciosmaquilas`
                                (`Articulo`,
                                `Maquila`,
                                `Precio`,
                                `Estatus`)
                                select '$Art', clave, $Precio, 'A' from maquilas where estatus = 'ACTIVO' ");
            } else {
                print 1;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Articulos_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticuloByID() {
        try {
            print json_encode($this->Articulos_model->getArticuloByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleByID() {
        try {
            print json_encode($this->Articulos_model->getDetalleByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            print json_encode($this->Articulos_model->getMaquilas($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->Articulos_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            print json_encode($this->Articulos_model->getGrupos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUnidades() {
        try {
            print json_encode($this->Articulos_model->getUnidades());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Articulos_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUnidadByID() {
        try {
            print json_encode($this->Articulos_model->getUnidadByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $datos = array(
                'Clave' => $x->post('Clave'),
                'Departamento' => $x->post('Departamento'),
                'Descripcion' => $x->post('Descripcion'),
                'Grupo' => $x->post('Grupo'),
                'UnidadMedida' => $x->post('UnidadMedida'),
                'Tmnda' => $x->post('Tmnda'),
                'Temporada' => $x->post('Temporada'),
                'Min' => $x->post('Min'),
                'Max' => $x->post('Max'),
                'ProveedorUno' => $x->post('ProveedorUno'),
                'ProveedorDos' => $x->post('ProveedorDos'),
                'ProveedorTres' => $x->post('ProveedorTres'),
                'Observaciones' => $x->post('Observaciones'),
                'UbicacionUno' => $x->post('UbicacionUno'),
                'UbicacionDos' => $x->post('UbicacionDos'),
                'UbicacionTres' => $x->post('UbicacionTres'),
                'UbicacionCuatro' => $x->post('UbicacionCuatro'),
                'TipoArticulo' => $x->post('TipoArticulo'),
                'Estatus' => 'ACTIVO',
                'PrecioUno' => $x->post('PrecioUno'),
                'PrecioDos' => $x->post('PrecioDos'),
                'PrecioTres' => $x->post('PrecioTres')
            );
            $ID = $this->Articulos_model->onAgregar($datos);
            $this->Articulos10_model->onAgregar($datos);

            $precios = json_decode($this->input->post('Precios'));
            foreach ($precios as $k => $v) {
                $precio = array('Articulo' => $ID, 'Maquila' => $v->Maquila, 'Precio' => $v->Precio, 'Estatus' => 'ACTIVO');
                $this->db->insert('preciosmaquilas', $precio);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $datos = array(
                'Departamento' => $x->post('Departamento'),
                'Descripcion' => $x->post('Descripcion'), /* REQUIERE PERMISO */
                'Grupo' => $x->post('Grupo'),
                'Tmnda' => $x->post('Tmnda'),
                'Temporada' => $x->post('Temporada'),
                'Min' => $x->post('Min'),
                'Max' => $x->post('Max'),
                'ProveedorUno' => $x->post('ProveedorUno'),
                'ProveedorDos' => $x->post('ProveedorDos'),
                'ProveedorTres' => $x->post('ProveedorTres'),
                'PrecioUno' => $x->post('PrecioUno'),
                'PrecioDos' => $x->post('PrecioDos'),
                'PrecioTres' => $x->post('PrecioTres'),
                'Observaciones' => $x->post('Observaciones'),
                'UbicacionUno' => $x->post('UbicacionUno'),
                'UbicacionDos' => $x->post('UbicacionDos'),
                'UbicacionTres' => $x->post('UbicacionTres'),
                'UbicacionCuatro' => $x->post('UbicacionCuatro'),
                'TipoArticulo' => $x->post('TipoArticulo')
            );
            //Guarda el historial de modificación de precios
            $p1 = $x->post('PrecioUno');
            $p2 = $x->post('PrecioDos');
            $p3 = $x->post('PrecioTres');
            if (floatval($p1) || floatval($p2) || floatval($p3)) {
                $precios_ant = $this->db->query("select PrecioUno, PrecioDos, PrecioTres from articulos where clave = '{$x->post('Clave')}' ")->result();
                $datos_history = array(
                    'Articulo' => $x->post('Clave'),
                    'NomArticulo' => $x->post('Descripcion'),
                    'fecha' => Date('Y-m-d H:i:s'),
                    'usuario' => $_SESSION["USERNAME"],
                    'preciounonuevo' => $x->post('PrecioUno'),
                    'preciodosnuevo' => $x->post('PrecioDos'),
                    'preciotresnuevo' => $x->post('PrecioTres'),
                    'preciounoant' => $precios_ant[0]->PrecioUno,
                    'preciodosant' => $precios_ant[0]->PrecioDos,
                    'preciotresant' => $precios_ant[0]->PrecioTres
                );

                if (floatval($p1) !== floatval($precios_ant[0]->PrecioUno) ||
                        floatval($p2) !== floatval($precios_ant[0]->PrecioDos) ||
                        floatval($p3) !== floatval($precios_ant[0]->PrecioTres)) {
                    $this->db->insert('articuloshistory', $datos_history);
                }
            }
            $this->Articulos_model->onModificar($x->post('Clave'), $datos);
            $this->db->where('Clave', $x->post('Clave'))->update("articulos10", $datos);

            $precios = json_decode($this->input->post('Precios'));
            foreach ($precios as $k => $v) {
                $precio = array(
                    'Articulo' => $x->post('Clave'),
                    'Maquila' => $v->Maquila,
                    'Precio' => $v->Precio, 'Estatus' => 'A');
                $this->db->insert('preciosmaquilas', $precio);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Articulos_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalle() {
        try {
            $this->db->set('Estatus', 'INACTIVO')->where('ID', $this->input->post('ID'))->update("preciosmaquilas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function onIgualarPrecios() {
        try {
            $Articulo = $this->input->post('Clave');
            $precio = $this->Articulos_model->getPrimerMaquilaPrecio($this->input->post('Clave'))[0]->PRECIO;
            $maquilas = $this->Articulos_model->getMaquilasXArticulo($Articulo);
            foreach ($maquilas as $k => $v) {
                $p = array(
                    'Precio' => $precio);
                $this->db->where('ID', $v->ID)->update("preciosmaquilas", $p);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function onEditarPrecioPorMaquila() {
        try {
            $x = $this->input;
            $this->db->set('Precio', $x->post('VALOR'))->where('ID', $x->post('ID'))->update("preciosmaquilas");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSuelasPlantas() {
        try {
            print json_encode($this->Articulos_model->getSuelasPlantas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
