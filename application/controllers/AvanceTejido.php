<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AvanceTejido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->model('AvanceTejido_model', 'avtm');
    }

    public function index() {
        try {
            $is_valid = false;
            if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
                $this->load->view('vEncabezado');
                switch ($this->session->userdata["TipoAcceso"]) {
                    case 'SUPER ADMINISTRADOR':
                        $this->load->view('vNavGeneral')->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                    case 'ADMINISTRACION':
                        $this->load->view('vMenuAdministracion');
                        $is_valid = true;
                        break;
                    case 'PRODUCCION':
                        $this->load->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                }
                $dt["TYPE"] = 2;
                $this->load->view('vFondo')->view('vAvanceTejido')->view('vWatermark', $dt)->view('vFooter');
            }
            if (!$is_valid) {
                $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getChoferes() {
        try {
            print json_encode($this->avtm->getChoferes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->avtm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTejedoras() {
        try {
            print json_encode($this->avtm->getTejedoras());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->avtm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVale() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["DOCUMENTO"] = $this->input->post('DOCUMENTO');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\tejido\AvanceTejido.jasper');
        $jc->setFilename('CONTROLES_ENTREGADOS_A_TEJIDA' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento(Date('Y'), Date('m'), Date('d')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarNumeroDeDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento($this->input->post('DOCUMENTO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            print json_encode($this->avtm->getUltimoAvanceXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaTejido() {
        try {
//            print json_encode($this->avtm->getControlesParaTejido());
            $this->db->select("C.ID, C.Control AS CONTROL, "
                            . "C.Estilo AS ESTILO, C.Color AS COLOR, C.Pares AS PARES, "
                            . "P.FechaEntrega AS ENTREGA, C.Maquila AS MAQUILA", false)
                    ->from('controles AS C')
                    ->join('pedidox AS P', 'C.Control = P.Control')
                    ->join('controltej AS CT', 'CT.Control = C.Control', 'left')
                    ->where('CT.ID IS NULL', null, false)
                    ->where('C.DeptoProduccion', 130);
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnTejido() {
        try {
//            print json_encode($this->avtm->getControlesEnTejido());
            $x = $this->input->get();

            $this->db->select("C.ID, C.numcho AS CHOFER, "
                            . "C.numtej AS TEJEDORA, C.fechapre AS FECHA, "
                            . "C.control AS CONTROL, C.estilo AS ESTILO, "
                            . "C.color AS COLOR, C.nomcolo AS COLORT, "
                            . "C.docto AS DOCTO, C.pares AS PARES", false)
                    ->from('controltej AS C');
            if ($x['CHOFER'] !== '') {
                $this->db->where('C.numcho', $x['CHOFER']);
            }
            $this->db->order_by('C.fechapre', 'DESC');
            if ($x['CHOFER'] === '') {
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance() {
        try {
            print json_encode($this->avtm->onVerificarAvance($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            $xXx = $this->input->post();

            /* avance, avaprd */
            $this->db->insert('controltej', array(
                'numcho' => $xXx['NUM_CHOFER'],
                'nomcho' => $xXx['CHOFER'],
                'numtej' => $xXx['NUM_TEJEDORA'],
                'nomtej' => $xXx['TEJEDORA'],
                'fechapre' => $xXx['FECHA'],
                'control' => $xXx['CONTROL'],
                'estilo' => $xXx['ESTILO'],
                'color' => $xXx['COLOR'],
                'nomcolo' => $xXx['COLORT'],
                'docto' => $xXx['DOCUMENTO'],
                'pares' => $xXx['PARES'],
                'fechalle' => Date('d/m/Y h:i:s a'),
                'tipo' => 0,
                'fraccion' => $xXx['FRACCION']
            ));
            $ID = $this->db->insert('avance', array(
                'Control' => $xXx['CONTROL'],
                'FechaAProduccion' => $xXx['FECHA'],
                'Departamento' => 150,
                'DepartamentoT' => 'TEJIDO',
                'FechaAvance' => $xXx['FECHA']/* FECHA AVANCE */,
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => $xXx['FRACCION']
            )); 

            /* fracpagnomina */
            $FXE = $this->db->select('FXE.CostoMO AS PRECIO', false)->from('fraccionesxestilo AS FXE')
                            ->where('FXE.Estilo', $xXx['ESTILO'])
                            ->where('FXE.Fraccion', $xXx['FRACCION'])
                            ->get()->result();
            $fecha = $x->post('FECHA');
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);
            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            
            $MAQUILA_X_CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x->post('CONTROL')} limit 1")->result();
            
            $this->db->insert('fracpagnomina', array(
                'numeroempleado' => $x->post('NUM_TEJEDORA'),
                'maquila' => intval($MAQUILA_X_CONTROL[0]->MAQUILA),
                'control' => $x->post('CONTROL'),
                'estilo' => $x->post('ESTILO'),
                'numfrac' => $x->post('FRACCION'),
                'preciofrac' => $FXE[0]->PRECIO,
                'pares' => $x->post('PARES'),
                'subtot' => (intval($x->post('PARES')) * floatval($FXE[0]->PRECIO)),
                'status' => 0,
                'fecha' => $nueva_fecha->format('Y-m-d h:i:s'),
                'semana' => $x->post('SEMANA'),
                'depto' => 150,
                'registro' => 0,
                'anio' => Date('Y'),
                'avance_id' => $ID,
                'fraccion' => $x->post('FRACCIONT')
            ));
            
            /* ACTUALIZAR  ESTATUS DE PRODUCCION  EN CONTROLES */
            $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 150)
                    ->where('Control', $xXx['CONTROL'])
                    ->update('controles');
            /* ACTUALIZAR ESTATUS DE PRODUCCION EN PEDIDOS */
            $this->db->set('stsavan', 7)->set('EstatusProduccion', 'ALMACEN TEJIDO')
                    ->set('DeptoProduccion', 150)->where('Control', $xXx['CONTROL'])
                    ->update('pedidox');
            /* ACTUALIZAR FECHA 7 (TEJIDO) EN AVAPRD (SE HACE PARA FACILITAR LOS REPORTES) */
            $this->db->set('fec7', Date('Y-m-d h:i:s'))->where('contped', $xXx['CONTROL'])
                    ->update('avaprd');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
