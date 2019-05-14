<?php

/**
 * Description of ControlesTerminados
 *
 * @author Y700
 */
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ControlesTerminados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ControlesTerminados_model', 'ctm')->helper('jaspercommand_helper')->helper('file');
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
                    $this->load->view('vMenuRecursosHumanos');
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
            $this->load->view('vFondo')->view('vControlesTerminados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirTerminados() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["docto"] = $this->input->post('Doc');
        $parametros["maq"] = $this->input->post('Maquila');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\controlesTerminado.jasper');
        $jc->setFilename('CONTROLES_TERMINADOS_X_DOC_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirRechazados() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["docto"] = $this->input->post('Doc');
        $parametros["maq"] = $this->input->post('Maquila');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\controlesRechazado.jasper');
        $jc->setFilename('CONTROLES_RECHAZADOS_X_DOC_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getRecords() {
        try {
            print json_encode($this->ctm->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocMaqByControlTerm() {
        try {
            print json_encode($this->ctm->getDocMaqByControlTerm($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControl() {
        try {
            print json_encode($this->ctm->getControl($this->input->get('Control'), $this->input->get('Maq')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesTerminados() {
        try {
            print json_encode($this->ctm->getControlesTerminados($this->input->get('Docto'), $this->input->get('Maq')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesRechazados() {
        try {
            print json_encode($this->ctm->getControlesRechazados($this->input->get('Docto'), $this->input->get('Maq')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->ctm->onAgregar(array(
                'control' => ($x->post('control') !== NULL) ? $x->post('control') : NULL,
                'fecha' => Date('Y-m-d'),
                'hora' => Date('H:i:s'),
                'docto' => ($x->post('docto') !== NULL) ? $x->post('docto') : NULL,
                'maq' => ($x->post('maq') !== NULL) ? $x->post('maq') : NULL,
                'sem' => ($x->post('sem') !== NULL) ? $x->post('sem') : NULL,
                'estilo' => ($x->post('estilo') !== NULL) ? $x->post('estilo') : NULL,
                'color' => ($x->post('color') !== NULL) ? $x->post('color') : NULL,
                'prevta' => ($x->post('prevta') !== NULL) ? $x->post('prevta') : NULL,
                'pares' => ($x->post('pares') !== NULL) ? $x->post('pares') : NULL
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarRechazado() {
        try {
            $x = $this->input;
            $this->ctm->onAgregarRechazado(array(
                'Control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                'Fecha' => Date('Y-m-d'),
                'Defecto' => ($x->post('Defecto') !== NULL) ? $x->post('Defecto') : NULL,
                'Detalle' => ($x->post('Detalle') !== NULL) ? $x->post('Detalle') : NULL,
                'Maq' => ($x->post('Maq') !== NULL) ? $x->post('Maq') : NULL,
                'Sem' => ($x->post('Sem') !== NULL) ? $x->post('Sem') : NULL,
                'Docto' => ($x->post('Docto') !== NULL) ? $x->post('Docto') : NULL,
                'Pares' => ($x->post('Pares') !== NULL) ? $x->post('Pares') : NULL
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $control = $this->ctm->getControlParaRechazar($this->input->post('Control'), $this->input->post('Maq'));

            if (intval($control[0]->Depto) < 260) { //Si el estatus esta antes de facturado

                /* Cambia de estatus prod el control */
                $this->ctm->onModificarControlRechazado($this->input->post('Control'), $this->input->post('Maq'));

                /* Eliminamos registro de controlTerm */
                $this->ctm->onEliminarDetalleByID($this->input->post('Control'));

                /* Elimina registro en Avance */
                $this->ctm->onEliminarAvanceByControl($this->input->post('Control'));

                /* Agregamos el control a controlCali */
                $this->ctm->onAgregarRechazado(array(
                    'Control' => $this->input->post('Control'),
                    'Fecha' => Date('Y-m-d'),
                    'Defecto' => $this->input->post('Defecto'),
                    'Detalle' => $this->input->post('Detalle'),
                    'Maq' => $this->input->post('Maq'),
                    'Sem' => $this->input->post('Sem'),
                    'Docto' => $this->input->post('Doc'),
                    'Pares' => $this->input->post('Pares')
                ));
                print 1;
            } else {//Si el estatus esta despues de terminado ya no permite rechazar
                print 0;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAvanceControl() {
        try {
            $x = $this->input;
            $this->ctm->onAgregarAvanceControl(array(
                'Control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => ($x->post('Departamento') !== NULL) ? $x->post('Departamento') : NULL,
                'DepartamentoT' => ($x->post('DepartamentoT') !== NULL) ? $x->post('DepartamentoT') : NULL,
                'FechaAvance' => Date('d/m/Y'),
                'Estatus' => 'A',
                'Usuario' => $this->session->userdata('ID'),
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('H:i:s')
            ));

            $this->ctm->onModificarControl($x->post('Control'), $x->post('DepartamentoT'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
