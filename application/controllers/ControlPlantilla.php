<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlPlantilla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('ControlPlantilla_model', 'cpm')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                default :
                    $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
//            print json_encode($this->cpm->getRecords());
            $this->db->select('CP.`ID`,
                                        CP.`Proveedor` AS PROVEEDOR,
                                        CP.`Tipo` AS ESTATUS,
                                        CP.`Documento` AS DOCUMENTO,
                                        CP.`Control` AS CONTROL,
                                        CP.`Estilo` AS ESTILO,
                                        CP.`Color` AS COLOR,
                                        CP.`Pares` AS PARES,
                                        CP.`Fraccion` AS FRACCION,
                                        CP.`FraccionT` AS FRACCIONT,
                                        CP.`Precio` AS PRECIO,
                                        CP.`Fecha` AS FECHA,
                                        CP.`Registro`,
                                        CP.`Estatus` AS ESTATUS,
                                        CONCAT("<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminarControlPlantilla(",CP.ID,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN', false)
                    ->from('controlpla AS CP')->where_in('CP.Estatus', array(1, 2));

            $x = $this->input->get();
            if ($x['PROVEEDOR'] !== '') {
                $this->db->where('CP.Proveedor', $x['PROVEEDOR']);
            }
            if ($x['PROVEEDOR'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEntregados() {
        try {
//            print json_encode($this->cpm->getEntregados());
            $this->db->select('CP.`ID`,
                                        CP.`Tipo` AS ESTATUS,
                                        CP.Documento AS DOCUMENTO,
                                        CP.`Proveedor` AS PROVEEDOR,
                                        CP.`Fecha` AS FECHA,
                                        CP.FechaRetorna AS FECHA_RETORNA,
                                        CP.`Control` AS CONTROL,
                                        CP.`Estilo` AS ESTILO,
                                        CP.`Color` AS COLOR,
                                        CP.`Pares` AS PARES,
                                        CP.`Fraccion` AS FRACCION,
                                        CP.`FraccionT` AS FRACCIONT,
                                        CP.`Precio` AS PRECIO,
                                        CP.`Registro`,
                                        CP.`Estatus` AS ESTATUS,
                                        CONCAT("<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminarRetornoControlPlantilla(",CP.ID,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN', false)
                    ->from('controlpla AS CP')->where_in('CP.Estatus', array(2));
            $x = $this->input->get();
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CP.Documento', $x['DOCUMENTO']);
            }
            if ($x['DOCUMENTO'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            print json_encode($this->cpm->getMaquilasPlantillas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresMaquilas() {
        try {
            print json_encode($this->cpm->getProveedoresMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->db->query("SELECT max(ifnull(Documento,0))+1 as docto FROM controlpla  WHERE Documento <> 0; ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->cpm->getInfoXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->cpm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXEstilo() {
        try {
            print json_encode($this->cpm->getFraccionesXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioXFraccionXEstilo() {
        try {
            print json_encode($this->cpm->getPrecioXFraccionXEstilo($this->input->get('FRACCION'), $this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaControlFraccion() {
        try {
            print json_encode($this->db->query("SELECT * from controlpla where control = {$this->input->get('CONTROL')} and fraccion = {$this->input->get('FRACCION')}  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarEstatusDocumento() {
        try {
            print json_encode($this->cpm->onComprobarEstatusDocumento($this->input->get('DOCTO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            /*
             *  ESTATUS
             *  1 = ENTREGADO A MAQUILA / EN PROCESO / EN TRANSITO
             *  2 = ENTREGADO/RECIBIDO/RETORNADO
             *  3 = PROCESADO COMO PLANTILLA
             */
            $x = $this->input;
            $this->db->insert('controlpla', array(
                'Proveedor' => $x->post('PROVEEDOR'),
                'ProveedorT' => str_replace("{$x->post('PROVEEDOR')} ", "", $x->post('PROVEEDORT')),
                'Tipo' => $x->post('TIPO'),
                'Documento' => $x->post('DOCUMENTO'),
                'Control' => $x->post('CONTROL'),
                'Estilo' => $x->post('ESTILO'),
                'Color' => $x->post('COLOR'),
                'ColorT' => str_replace("{$x->post('COLOR')}-", "", $x->post('COLORT')),
                'Pares' => $x->post('PARES'),
                'Fraccion' => $x->post('FRACCION'),
                'FraccionT' => str_replace("{$x->post('FRACCION')} ", "", $x->post('FRACCIONT')),
                'Precio' => $x->post('PRECIO'),
                'Fecha' => $x->post('FECHA'),
                'Registro' => Date('d/m/Y h:i:s a'),
                'Estatus' => 1));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->set('Estatus', 3)->where('ID', $this->input->post('ID'))->update('controlpla');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRetornaDocumento() {
        try {
            $this->db->set('Estatus', 2)->set('FechaRetorna', $this->input->post('FECHA'))->where('ID', $this->input->post('ID'))->update('controlpla');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRetornoControlPlantilla() {
        try {
            $this->db->set('Estatus', 1)->set('FechaRetorna', $this->input->post('FECHA'))->where('ID', $this->input->post('ID'))->update('controlpla');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporteDePago() {
        $x = $this->input->post();
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["FECHAINICIAL"] = $x['FECHAINICIAL'];
        $parametros["FECHAFINAL"] = $x['FECHAFINAL'];
        switch (intval($x['STS'])) {
            case 1:
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\plantilla\ReportePagoSinRecibir.jasper');
                $jc->setFilename('ReporteDePagoSinRecibir_' . Date('h_i_s'));

                switch (intval($x['TDOC'])) {
                    case 1:
                        $jc->setDocumentformat('pdf');
                        break;
                    case 2:
                        $jc->setDocumentformat('xls');
                        break;
                }
                PRINT $jc->getReport();
                break;
            case 2:
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\plantilla\ReportePagoRecibido.jasper');
                $jc->setFilename('ReporteDePagoRecibido_' . Date('h_i_s'));

                switch (intval($x['TDOC'])) {
                    case 1:
                        $jc->setDocumentformat('pdf');
                        break;
                    case 2:
                        $jc->setDocumentformat('xls');
                        break;
                }
                $l = new Logs("Captura plantillas para maquila", "GENERO UN REPORTE DE PAGO '{$x['FECHAINICIAL']}' - '{$x['FECHAFINAL']}' , " . (intval($x['STS']) === 1 ? "sin recibir" : "recibido") . ". ", $this->session);
                PRINT $jc->getReport();
                break;
        }
    }

}
