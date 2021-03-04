<?php

require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ControlPiochas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ControlPiochas_model', 'ctm')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'ADMINISTRACION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuDisDes');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuAlmacen');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vFondo')->view('vControlPiochas')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onReportePiochas() {
        $Tipo = $this->input->post('Tipo');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);


        switch (intval($Tipo)) {
            case 1:
                $jc->setJasperurl('jrxml\produccion\piochas\reportePiochasMaq.jasper');
                break;
            case 2:
                $jc->setJasperurl('jrxml\produccion\piochas\reportePiochasLinea.jasper');
                break;
            case 3:
                $jc->setJasperurl('jrxml\produccion\piochas\reportePiochasEstilo.jasper');
                break;
            case 4:
                $jc->setJasperurl('jrxml\produccion\piochas\reportePiochasDepartamento.jasper');
                break;
            case 5:
                $jc->setJasperurl('jrxml\produccion\piochas\Defecto.jasper');
                break;
        }

        $jc->setFilename("{$Tipo}_REPORTE_PIOCHAS_X_FEC_" . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getArticuloConsumoUnidadByPieza() {
        try {
            print json_encode($this->ctm->getArticuloConsumoUnidadByPieza($this->input->get('Pieza'), $this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasOrdPrdByControl() {
        try {
            print json_encode($this->ctm->getPiezasOrdPrdByControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosXDepartamento() {
        try {
            print json_encode($this->db->select("CAST(D.Numero AS SIGNED ) AS ID,CONCAT(D.Numero,'-',D.Busqueda) AS Empleado")
                                    ->from("empleados AS D")
                                    ->where("D.AltaBaja", "1")
                                    ->where("D.DepartamentoFisico", $this->input->get('Departamento'))
                                    ->order_by('ID', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXDepartamento() {
        try {
            print json_encode($this->ctm->getFraccionesXDepartamento($this->input->get('Departamento')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            print json_encode($this->ctm->getDepartamentos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExistePiocha() {
        try {
            print json_encode($this->ctm->getExistePiocha($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControl() {
        try {
            print json_encode($this->ctm->getControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVeriricarTallas() {
        try {
            print json_encode($this->ctm->onVeriricarTallas($this->input->get('Serie')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiochas() {
        try {
            print json_encode($this->ctm->getPiochas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $this->ctm->onAgregar(array(
                'Control' => ($x->post('Control') !== NULL) ? $x->post('Control') : NULL,
                'Maq' => ($x->post('Maquila') !== NULL) ? $x->post('Maquila') : NULL,
                'Fecha' => Date('d/m/Y'),
                'Estilo' => ($x->post('Estilo') !== NULL) ? $x->post('Estilo') : NULL,
                'Color' => ($x->post('Color') !== NULL) ? $x->post('Color') : NULL,
                'Departamento' => ($x->post('Departamento') !== NULL) ? $x->post('Departamento') : NULL,
                'TipoCargo' => ($x->post('TipoCargo') !== NULL) ? $x->post('TipoCargo') : NULL,
                'Empleado' => ($x->post('Empleado') !== NULL) ? $x->post('Empleado') : NULL,
                'ParteZapato' => ($x->post('ParteZapato') !== NULL) ? $x->post('ParteZapato') : NULL,
                'Pieza' => ($x->post('Pieza') !== NULL) ? $x->post('Pieza') : NULL,
                'Fraccion' => ($x->post('Fraccion') !== NULL) ? $x->post('Fraccion') : NULL,
                'Material' => ($x->post('ClaveArt') !== NULL) ? $x->post('ClaveArt') : NULL,
                'Consumo' => ($x->post('Consumo') !== NULL) ? $x->post('Consumo') : NULL,
                'ConsumoTotal' => ($x->post('ConsumoTotal') !== NULL) ? $x->post('ConsumoTotal') : NULL,
                'Talla' => ($x->post('Talla') !== NULL) ? $x->post('Talla') : NULL,
                'Defecto' => ($x->post('Defecto') !== NULL) ? $x->post('Defecto') : NULL,
                'Detalle' => ($x->post('DetalleDefecto') !== NULL) ? $x->post('DetalleDefecto') : NULL,
                'Pares' => ($x->post('Pares') !== NULL) ? $x->post('Pares') : NULL,
                'Usuario' => $this->session->userdata('USERNAME'),
                'Estatus' => '1'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {

            $control = $this->ctm->getControlParaReparar($this->input->post('Control'));

            if (intval($control[0]->Estatus) > 1) { //Si el estatus esta en 2 es que ya se reparó
                print 0;
            } else {
                $datos = array(
                    'FechaReparacion' => Date('d/m/Y'),
                    'Estatus' => '2'
                );
                /* Cambia de estatus a reparada(2) la piocha seleccionada */
                $this->ctm->onModificarControlPiocha($this->input->post('Control'), $datos);

                print 1;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
