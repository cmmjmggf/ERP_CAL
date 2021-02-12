<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CapturaFraccionesParaNomina extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
        $this->load->model('CapturaFraccionesParaNomina_model')->model('SemanasNomina_model')->model('Departamentos_model')->helper('file')->helper('jaspercommand_helper');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }//Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuNominas');
                    }
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vCapturaDestajos')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReporteEntregaControlesMaquilas() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["docto"] = $this->input->post('Docto');
        $jc->setJasperurl('jrxml\produccion\entregaControlesMaquilas.jasper');
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_ENTREGA_CONTROLES_MAQUILAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteDestajos() {
        $Reporte = $this->input->post('Reporte');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["emp"] = $this->input->post('Emp');

        $report_name = "jrxml\destajos\\{$Reporte}.jasper";


        $jc->setJasperurl($report_name);
        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_DESTAJOS_NOMINA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteRastreoControl() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["control"] = $this->input->post('Control');
        $jc->setJasperurl("jrxml\destajos\destajoNominaRastreoControl.jasper");
        $jc->setParametros($parametros);
        $jc->setFilename('REPORTE_RASTREO_CONTROL_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onVerificarFraccion() {
        try {
            $estilo = $this->input->get('Estilo');
            $numfrac = $this->input->get('Fraccion');
            $pcelula = $this->input->get('PorCel');
            $pares = $this->input->get('Pares');
            $control = $this->input->get('Control');
            $subtot = 0;
            $response = array();
            $ExisteFracXEstilo = $this->db->query("select fraccion,CostoMO from fraccionesxestilo where fraccion = $numfrac and estilo = '$estilo' and estatus = 'ACTIVO' ")->result();
            if (empty($ExisteFracXEstilo)) {//Si no existe el la fraccion por estilo
                print 1;
                exit();
            } else {//Si existe
                //Valida si tiene precio
                $PrecioFrac = $ExisteFracXEstilo[0]->CostoMO;
                $response['precio'] = $PrecioFrac;
                if (floatval($PrecioFrac) > 0) {//SI TIENE PRECIO MAYOR A 0
                    $ExisteEnFragPagNomina = $this->db->query("select * from fracpagnomina where control = $control and numfrac = $numfrac ")->result();
                    if (!empty($ExisteEnFragPagNomina)) {//Ya existe el control cobrado por otro empleado
                        print 3;
                        exit();
                    }
                    $ExisteEnControlPla = $this->db->query("select * from controlpla where control = $control and fraccion = $numfrac ")->result();
                    if (!empty($ExisteEnControlPla)) {//Ya existe el control cobrado en maquilas
                        print 4;
                        exit();
                    } else {//si no existe cobrado por alguien mas
                        if (floatval($pcelula)) {
                            $subtot = (floatval($pcelula) * $PrecioFrac) * floatval($pares);
                            $subtot = $PrecioFrac * floatval($pares);
                        } else {
                            $subtot = $PrecioFrac * floatval($pares);
                        }
                        $response['subtot'] = $subtot;
                        print json_encode($response);
                    }
                } else {
                    print 2;
                    exit();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEmpleado() {
        try {
            $clave = $this->input->get('Empleado');
            print json_encode($this->db->query("select numero, CelulaPorcentaje as pcecula from empleados "
                                    . " where numero = $clave and altabaja = 1 and FijoDestajoAmbos in (2,3) "
                                    . " or (numero between 899 and 1006 and numero = $clave ) ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->onVerificarSemanaNominaCerrada(
                                    $this->input->get('Sem'), $this->input->get('Ano')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarFraccionCapturada() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->onVerificarFraccionCapturada(
                                    $this->input->get('Fraccion'), $this->input->get('Control'), $this->input->get('Empleado')
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControl() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlAvanAnterior() {
        try {
            $control = $this->input->get('Control');
            print json_encode($this->db->query("select * from pedidox where control =  $control ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha() {
        try {
            print json_encode($this->SemanasNomina_model->getSemanaByFecha($this->input->get('Fecha')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccion() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getPrecioFraccion($this->input->get('Fraccion'), $this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesByEstilo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getFraccionesByEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentoByEmpleado() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getDepartamentoByEmpleado($this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentosAvanceAnterior() {
        try {
            print json_encode($this->Departamentos_model->getDepartamentosAvanceAnterior());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosGeneral() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getEmpleadosGeneral());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNomina() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getConceptosNomina());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNominaRastreo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getConceptosNominaRastreo(
                                    $this->input->get('Ano'), $this->input->get('Emp'), $this->input->get('Concepto')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesNominaRastreo() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getControlesNominaRastreo(
                                    $this->input->get('Control'), $this->input->get('Ano'), $this->input->get('Sem'), $this->input->get('Emp')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->CapturaFraccionesParaNomina_model->getRecords($this->input->get('Ano'), $this->input->get('Sem'), $this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $this->CapturaFraccionesParaNomina_model->onEliminarDetalleByID($this->input->post('Control'), $this->input->post('Empleado'), $this->input->post('Fraccion'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAvanceAnt() {
        try {
            $x = $this->input;
            $xxx = $this->input->post();


            $origFecha = $x->post('Fecha');
            $fecha = str_replace('/', '-', $origFecha);
            $nuevaFecha = date("Y-m-d", strtotime($fecha));
            $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xxx['Control']} AND A.Departamento = {$xxx['DeptoClave']}")->result();
            if (intval($check_avance[0]->EXISTE) === 0) {
                $this->db->insert('avance', array(
                    'Control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                    'FechaAProduccion' => Date('d/m/Y'),
                    'FechaAvance' => Date('d/m/Y'),
                    'Departamento' => ($x->post('DeptoClave') !== NULL) ? $x->post('DeptoClave') : NULL,
                    'DepartamentoT' => ($x->post('DeptoNombre') !== NULL) ? $x->post('DeptoNombre') : NULL,
                    'Control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                    'Docto' => ($x->post('Docto') !== NULL) ? $x->post('Docto') : NULL,
                    'Estatus' => 'A',
                    'Usuario' => $this->session->userdata('ID'),
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a')
                ));
                $this->db->set('Departamento', $x->post('stsavaprd'))->set('EstatusProduccion', $x->post('DeptoNombre'))->set('DeptoProduccion', $x->post('DeptoClave'))->where('Control', $x->post('Control'))->update('controles');
                $this->db->set('stsavan', $x->post('stsavaprd'))->set('EstatusProduccion', $x->post('DeptoNombre'))->set('DeptoProduccion', $x->post('DeptoClave'))->where('Control', $x->post('Control'))->update('pedidox');
                $this->db->set('almpesp', $x->post('Docto'))->set('status', $x->post('stsavaprd'))->set($x->post('Campo'), $nuevaFecha)->where('contped', $x->post('Control'))->update('avaprd');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $xx = $this->input->post();
            $DIA = $this->db->query("SELECT 
    NOW() AS FECHA,
    CASE
        WHEN UPPER(DAYNAME(NOW())) = 'MONDAY' THEN 'LUNES'
        WHEN UPPER(DAYNAME(NOW())) = 'TUESDAY' THEN 'MARTES'
        WHEN UPPER(DAYNAME(NOW())) = 'WEDNESDAY' THEN 'MIERCOLES'
        WHEN UPPER(DAYNAME(NOW())) = 'THURSDAY' THEN 'JUEVES'
        WHEN UPPER(DAYNAME(NOW())) = 'FRIDAY' THEN 'VIERNES'
        WHEN UPPER(DAYNAME(NOW())) = 'SATURDAY' THEN 'SABADO'
        WHEN UPPER(DAYNAME(NOW())) = 'SUNDAY' THEN 'DOMINGO'
    END AS NOMBRE_DIA")->result();
            if ($this->session->TipoAcceso !== "SUPER ADMINISTRADOR" && $DIA[0]->NOMBRE_DIA !== "JUEVES") {
                $fracciones_de_avance = array(96, 100, 113, 102, 114, 103, 61, 60, 127, 51, 396, 397, 402, 401, 499, 500, 601, 600);
                if (in_array(intval($xx['Fraccion']), $fracciones_de_avance)) {
                    print "\n NO SE PUEDEN CAPTURAR FRACCIONES DE AVANCE !!!! \n";
                    $l = new Logs("CAPTURA FRACCIONES PARA NOMINA", "HA INTENTADO CAPTURAR UNA FRACCION DE NOMINA {$xx['Fraccion']} .", $this->session);
                    exit(0);
                }
            }
            $Existe = $this->CapturaFraccionesParaNomina_model->onVerificarFraccionCapturada(
                    $this->input->post('Fraccion'), $this->input->post('Control'), $this->input->post('Empleado'));
            if (!empty($Existe)) {
                print 1;
                exit();
            }


            $origFecha = $xx['Fecha'];
            $fecha = str_replace('/', '-', $origFecha);
            $nuevaFecha = date("Y-m-d", strtotime($fecha));


            $data = array(
                'numeroempleado' => ($xx['Empleado'] !== NULL) ? $xx['Empleado'] : NULL,
                'maquila' => 2,
                'control' => ($xx['Control'] !== NULL) ? $xx['Control'] : NULL,
                'estilo' => ($xx['Estilo'] !== NULL) ? $xx['Estilo'] : NULL,
                'numfrac' => ($xx['Fraccion'] !== NULL) ? $xx['Fraccion'] : NULL,
                'preciofrac' => ($xx['Precio'] !== NULL) ? $xx['Precio'] : NULL,
                'pares' => ($xx['Pares'] !== NULL) ? $xx['Pares'] : NULL,
                'subtot' => ($xx['Subtotal'] !== NULL) ? $xx['Subtotal'] : NULL,
                'depto' => ($xx['DeptoEmp'] !== NULL) ? $xx['DeptoEmp'] : NULL,
                'fecha' => $nuevaFecha,
                'status' => 1,
                'semana' => ($xx['Sem'] !== NULL) ? $xx['Sem'] : NULL,
                'anio' => ($xx['Ano'] !== NULL) ? $xx['Ano'] : NULL,
                'fraccion' => ($xx['Fraccion'] !== NULL) ? $xx['Fraccion'] : NULL,
                'modulo' => 'DSTN',
                "fecha_registro" => Date('d/m/Y h:i:s')
            );
            if ($xx['Control'] !== '0' && $xx['Control'] !== '') {
                $stsnom = $this->CapturaFraccionesParaNomina_model->onVerificarSemanaNominaCerrada($this->input->post('Sem'), $this->input->post('Ano'));
                if (!empty($stsnom)) {
                    if ($stsnom[0]->status === '2') {
                        print 2;
                        exit();
                    } else if ($stsnom[0]->status === '1') {
                        $this->CapturaFraccionesParaNomina_model->onAgregar($data);
                    }
                } else {
                    $this->CapturaFraccionesParaNomina_model->onAgregar($data);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
