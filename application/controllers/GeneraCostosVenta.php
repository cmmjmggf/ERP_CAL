<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class GeneraCostosVenta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
            }
            $this->load->view('vGeneraCostosVenta')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onEliminarParametroFijo() {
        try {
            $Lista = $this->input->post('Lista');
            $existeListaEnClientes = $this->db->query("select count(*) as existe from clientes where ListaPrecios = $Lista ")->result();

            if (intval($existeListaEnClientes[0]->existe) > 0) {
                //no puede eliminar porque existe en clientes
                print 1;
            } else {
                //puede eliminar
                $this->db->query("delete from costofijo where lista = $Lista ");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarParametroFijos() {
        try {
            $x = $this->input;
            $Lista = $this->input->post('Lista');
            $existeLista = $this->db->query("select lista from costofijo where lista = $Lista ")->result();

            if (empty($existeLista)) {
                //Inserta
                $this->db->insert("costofijo", array(
                    'lista' => ($x->post('Lista') !== NULL) ? $x->post('Lista') : NULL,
                    'nomlista' => ($x->post('NomLista') !== NULL) ? $x->post('NomLista') : NULL,
                    'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                    'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                    'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                    'hms' => ($x->post('hmsPF') !== NULL) ? $x->post('hmsPF') : NULL,
                    'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                    'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                    'desc' => ($x->post('descPF') !== NULL) ? $x->post('descPF') : NULL,
                    'comic' => ($x->post('comicPF') !== NULL) ? $x->post('comicPF') : NULL,
                    'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL,
                    'flete' => ($x->post('fletePF') !== NULL) ? $x->post('fletePF') : NULL
                ));
            } else {
                //Actualiza
                $this->db->where('lista', $Lista)->update("costofijo", array(
                    'lista' => ($x->post('Lista') !== NULL) ? $x->post('Lista') : NULL,
                    'nomlista' => ($x->post('NomLista') !== NULL) ? $x->post('NomLista') : NULL,
                    'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                    'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                    'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                    'hms' => ($x->post('hmsPF') !== NULL) ? $x->post('hmsPF') : NULL,
                    'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                    'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                    'desc' => ($x->post('descPF') !== NULL) ? $x->post('descPF') : NULL,
                    'comic' => ($x->post('comicPF') !== NULL) ? $x->post('comicPF') : NULL,
                    'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL,
                    'flete' => ($x->post('fletePF') !== NULL) ? $x->post('fletePF') : NULL
                ));
            }
            //Actualiza parametros globales
            $this->db->update("costofijo", array(
                'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoParametrosFijos() {
        try {
            $lista = $this->input->get('Lista');

            print json_encode($this->db->query("SELECT
                                *
                                FROM costofijo
                                where lista = $lista ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParametrosFijos() {
        try {
            print json_encode($this->db->query("select * from costofijo ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarPrecioAutorizado() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $estilo = $this->input->post('Estilo');
            $color = $this->input->post('Color');
            $PrecioAut = $this->input->post('PrecioAut');
            $this->db->query("update costovaria set preaut = $PrecioAut where linea = $linea and lista = $lista and estilo = $estilo and color = $color ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarEstilo() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $estilo = $this->input->post('Estilo');
            $color = $this->input->post('Color');
            $query = "delete from costovaria where linea = $linea and lista = $lista and estilo = $estilo and color = $color ";
            //print $query;
            $this->db->query($query);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarLineaListaCorrida() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $corrida = $this->input->post('Corrida');
            $query = "delete from costovaria where linea = $linea and lista = $lista and corr = $corrida ";
            $this->db->query($query);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onMarcarTodasLineasAbiertas() {
        try {
            $this->db->query("update estilos set seguridad = 1 ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineasAbiertas() {
        try {
            print json_encode($this->db->query("select linea, clave, seguridad from estilos where Seguridad = 0 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloLineaLista() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select linea,lista,estilo,color
                                                from costovaria
                                                where estilo = '$Estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onMarcarLineaParaNoModificar() {
        try {
            $Linea = $this->input->post('Linea');
            $this->db->query("update estilos set seguridad = 1 where linea = '$Linea' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDescarmarLineaParaModificar() {
        try {
            $Linea = $this->input->post('Linea');
            $this->db->query("update estilos set seguridad = 0 where linea = '$Linea' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarEstiloColorParaCosto() {
        try {
            $Estilo = $this->input->post('Estilo');
            $Color = $this->input->post('Color');
            $this->db->query("update colores set precioventa = 0 where estilo = '$Estilo' ");
            $this->db->query("update colores set precioventa = 1 where estilo = '$Estilo' and clave = '$Color' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select clave from estilos where clave = '$Estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColores() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select estilo, clave as color, descripcion as nomcolor, costo,
                                                case when PrecioVenta = 1 then PrecioVenta else '' end as pventa
                                                from colores where estilo = '$Estilo'
                                                order by estilo, clave asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresByEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->select("CAST(C.Clave AS SIGNED ) AS ID, CONCAT(C.Clave,'-', C.Descripcion) AS Descripcion ", false)
                                    ->from('colores AS C')
                                    ->where('C.Estilo', $Estilo)
                                    ->where('C.Estatus', 'ACTIVO')
                                    ->order_by('ID', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT * FROM costovaria
                                                where linea = '$linea' and corr = $corrida and lista = $lista
                                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoInicial() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT
                                gtosf,
                                date_format(fecha,'%d/%m/%Y') as fecha,
                                comic,
                                `desc`,
                                matpri,
                                mextr,
                                toler,
                                maob,
                                gfabri,
                                tejida,
                                gvta,
                                gadmon,
                                hms,
                                flete
                                FROM costovaria
                                where linea = '$linea' and corr = $corrida and lista = $lista
                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarGastosFijos() {
        try {
            $gastosf = $this->input->post('GastosF');
            $this->db->query("update costovaria set gtosf = $gastosf ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reportes */

    public function onImprimirListaPrecios() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["lista"] = $this->input->post('Lista');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reporteListasPrecios.jasper');
        $jc->setFilename('REPORTE_LISTAS_PRECIO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteCostos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["linea"] = $this->input->post('Linea');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reportePreciosPorLinea.jasper');
        $jc->setFilename('REPORTE_COSTOS_LINEA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
