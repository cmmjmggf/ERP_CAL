<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class SubfraccionesXEstilo extends CI_Controller {

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
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuNominas');
                    }
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vSubfraccionesXEstilo')->view('vFooter');
        } else {
            $this->load->view('vFondo')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReporteSubfraccionesXEstilo() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["estilo"] = $this->input->post('Estilo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\subfraccionePorEstilo.jasper');
        $jc->setFilename('SUBFRACCIONESXESTILO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificaEstiloSubFracciones() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->query("select estilo from subfraccionesxestilo where estilo = '$Estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCopiarSubFraccionesDeEstiloaEstilo() {
        try {
            $estilo = $this->input->post('dEstilo');
            $aestilo = $this->input->post('aEstilo');

            $sql = "INSERT INTO subfraccionesxestilo
                    (
                    `estilo`,
                    `fraccion`,
                    `subfraccion`,
                    `tiempoestandar`,
                    `eficiencia`,
                    `tiemporeal`,
                    `costo`,
                    `puesto`,
                    `sueldobase`
                    )
                    select
                    '$aestilo' as Estilo,
                    `fraccion`,
                    `subfraccion`,
                    `tiempoestandar`,
                    `eficiencia`,
                    `tiemporeal`,
                    `costo`,
                    `puesto`,
                    `sueldobase`
                    from subfraccionesxestilo
                    where estilo = '$estilo' ";
            $this->db->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEficiencia() {
        try {
            $fraccion = $this->input->get('Fraccion');
            print json_encode($this->db->query("SELECT d.eficiencia
                                        FROM fracciones f
                                        JOIN departamentos d ON d.clave = f.departamento
                                        WHERE f.clave = '{$fraccion}'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubfraccionesXFraccion() {
        try {
            $fraccion = $this->input->get('Fraccion');
            print json_encode($this->db->query("SELECT Clave AS ID, Descripcion
                                        FROM subfracciones
                                        WHERE fraccion = '{$fraccion}' order by Descripcion ASC  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubfraccionXFraccion() {
        try {
            $fraccion = $this->input->get('Fraccion');
            $subfraccion = $this->input->get('Subfraccion');
            print json_encode($this->db->query("SELECT SF.ID, P.SueldoBase, SF.Puesto
                                        FROM subfracciones SF
                                        JOIN puestos P on P.Clave = SF.Puesto
                                        WHERE SF.fraccion = '{$fraccion}' and SF.clave = '{$subfraccion}' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalle() {
        try {
            $estilo = $this->input->post('Estilo');
            print json_encode($this->db->query("SELECT
                                        SFE.ID,
                                        SFE.fraccion numfra,
                                        F.descripcion AS nomfra,
                                        SFE.subfraccion numsubfra,
                                        SF.descripcion AS nomsubfra,
                                        CONCAT(P.Clave, ' - ',P.Descripcion) AS puesto,
                                        SFE.tiempoestandar,
                                        (SFE.eficiencia*100) AS efi,
                                        SFE.tiemporeal,
                                        SFE.sueldobase,
                                        SFE.costo, "
                                    . 'CONCAT(\'<span class="fa fa-trash fa-lg " onclick="onEliminar(\', SFE.ID, \')">\', \'</span>\') AS Eliminar'
                                    . " FROM subfraccionesxestilo SFE
                                        JOIN fracciones F ON F.Clave = SFE.fraccion
                                        JOIN subfracciones SF ON SF.Clave = SFE.subfraccion
                                        JOIN puestos P ON P.clave = SF.puesto  where SFE.estilo = '{$estilo}' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $existe = $this->db->query("select * from subfraccionesxestilo "
                            . " where fraccion = '{$x->post('Fraccion')}' "
                            . " and subfraccion = '{$x->post('SubFraccion')}' "
                            . " and estilo = '{$x->post('Estilo')}' ")->result();
            if (empty($existe)) {
                //Inserta
                $this->db->insert("subfraccionesxestilo", array(
                    'estilo' => ($x->post('Estilo') !== NULL) ? $x->post('Estilo') : NULL,
                    'fraccion' => ($x->post('Fraccion') !== NULL) ? $x->post('Fraccion') : NULL,
                    'subfraccion' => ($x->post('SubFraccion') !== NULL) ? $x->post('SubFraccion') : NULL,
                    'tiempoestandar' => ($x->post('TiempoEstandar') !== NULL) ? $x->post('TiempoEstandar') : NULL,
                    'eficiencia' => ($x->post('Eficiencia') !== NULL) ? $x->post('Eficiencia') : NULL,
                    'tiemporeal' => ($x->post('TiempoReal') !== NULL) ? $x->post('TiempoReal') : NULL,
                    'costo' => ($x->post('Costo') !== NULL) ? $x->post('Costo') : NULL,
                    'puesto' => ($x->post('Puesto') !== NULL) ? $x->post('Puesto') : NULL,
                    'sueldobase' => ($x->post('SueldoBase') !== NULL) ? $x->post('SueldoBase') : NULL
                ));
            } else {
                //Actualiza
                $this->db->where('fraccion', $x->post('Fraccion'))
                        ->where('subfraccion', $x->post('SubFraccion'))
                        ->where('estilo', $x->post('Estilo'))
                        ->update("subfraccionesxestilo", array(
                            'tiempoestandar' => ($x->post('TiempoEstandar') !== NULL) ? $x->post('TiempoEstandar') : NULL,
                            'eficiencia' => ($x->post('Eficiencia') !== NULL) ? $x->post('Eficiencia') : NULL,
                            'tiemporeal' => ($x->post('TiempoReal') !== NULL) ? $x->post('TiempoReal') : NULL,
                            'costo' => ($x->post('Costo') !== NULL) ? $x->post('Costo') : NULL,
                            'puesto' => ($x->post('Puesto') !== NULL) ? $x->post('Puesto') : NULL,
                            'sueldobase' => ($x->post('SueldoBase') !== NULL) ? $x->post('SueldoBase') : NULL
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $ID = $this->input->post('ID');
            $this->db->where('ID', $ID)->delete("subfraccionesxestilo");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
