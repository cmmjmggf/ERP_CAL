<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class MaterialControlFecha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('MaterialControlFecha_model')
                ->helper('Entregamaterialcontrol_helper')->helper('file')->helper('jaspercommand_helper');
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
                    } else if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;

                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vMaterialControlFecha');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getPedidoByControl() {
        try {
            print json_encode($this->MaterialControlFecha_model->getPedidoByControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOrdenProduccionByControl() {
        try {
            print json_encode($this->MaterialControlFecha_model->getOrdenProduccionByControl($this->input->get('Control')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReportePorControlDepartamento() {
        $Controles = json_decode($this->input->post('Controles'));
        $controles_arr = array();
        foreach ($Controles as $k => $v) {
            array_push($controles_arr, $v->Control);
        }
        $Deptos = $this->MaterialControlFecha_model->getDeptosArticulos($controles_arr);
        $Grupos = $this->MaterialControlFecha_model->getGruposArticulos($controles_arr);
        $ArticulosE = $this->MaterialControlFecha_model->getArticulosEnc($controles_arr);
        $Articulos = $this->MaterialControlFecha_model->getArticulos($controles_arr);
        if (!empty($Deptos)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->SetAutoPageBreak(true, 10);

            //Agregamos una hoja por cada departamento del articulo 10, 80, 90
            $Tipo = '';
            foreach ($Deptos as $key => $T) {
                switch ($T->DepartamentoArt) {
                    case '10':
                        $Tipo = '******* PIEL Y FORRO *******';
                        break;
                    case '80':
                        $Tipo = '******* SUELA *******';
                        break;
                    case '90':
                        $Tipo = '******* INDIRECTOS *******';
                        break;
                }
                $pdf->setTipo($Tipo);
                $pdf->AddPage();


                //Agregamos los Grupos
                foreach ($Grupos as $key => $G) {

                    if ($T->DepartamentoArt === $G->DepartamentoArt) {
                        $pdf->SetLineWidth(0.5);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->SetX(5);
                        $pdf->Cell(15, 5, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX(20);
                        $pdf->SetFont('Calibri', '', 9);
                        $pdf->Cell(50, 5, utf8_decode($G->ClaveGrupo . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');
                        $pdf->SetLineWidth(0.2);
                        $TOTAL_GPO = 0;
                        //Agregamos los articulos
                        foreach ($ArticulosE as $key => $AE) {

                            if ($T->DepartamentoArt === $AE->DepartamentoArt && $G->ClaveGrupo === $AE->ClaveGrupo) {
                                $TOTAL_ART = 0;
                                foreach ($Articulos as $key => $A) {
                                    if ($AE->Articulo === $A->Articulo) {
                                        $pdf->SetFont('Calibri', '', 9);
                                        $pdf->Row(array(
                                            $A->ControlT,
                                            $A->Articulo,
                                            utf8_decode(mb_strimwidth($A->ArticuloT, 0, 45, "")),
                                            $A->UnidadMedidaT,
                                            number_format($A->Cantidad, 2, ".", ","),
                                            ''
                                                ), 0);
                                        $TOTAL_GPO += $A->Cantidad;
                                        $TOTAL_ART += $A->Cantidad;
                                    }
                                }
                                $pdf->SetFont('Calibri', 'B', 9);
                                $pdf->Row(array(
                                    '',
                                    '',
                                    utf8_decode('Total por Artículo: '),
                                    '',
                                    number_format($TOTAL_ART, 2, ".", ","),
                                    ''
                                        ), 'T');
                            }
                        }
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Row(array(
                            '',
                            '',
                            'Total por Grupo: ',
                            '',
                            number_format($TOTAL_GPO, 2, ".", ","),
                            ''
                                ), 'T');
                    }
                }
            }


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/EntregaMateriales';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTREGA MATERIALES POR CONTROL " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/EntregaMateriales/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReportePorAnoSemMaq() {
        $Ano = $this->input->post('Ano');
        $Sem = $this->input->post('Sem');
        $Maq = $this->input->post('Maq');

        $Deptos = $this->MaterialControlFecha_model->getDeptosArticulosByAnoMaqSem($Ano, $Sem, $Maq);
        $Grupos = $this->MaterialControlFecha_model->getGruposArticulosByAnoMaqSem($Ano, $Sem, $Maq);
        $ArticulosE = $this->MaterialControlFecha_model->getArticulosEncByAnoMaqSem($Ano, $Sem, $Maq);
        $Articulos = $this->MaterialControlFecha_model->getArticulosByAnoMaqSem($Ano, $Sem, $Maq);
        if (!empty($Deptos)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->SetAutoPageBreak(true, 10);

            //Agregamos una hoja por cada departamento del articulo 10, 80, 90
            $Tipo = '';
            foreach ($Deptos as $key => $T) {
                switch ($T->DepartamentoArt) {
                    case '10':
                        $Tipo = '******* PIEL Y FORRO *******';
                        break;
                    case '80':
                        $Tipo = '******* SUELA *******';
                        break;
                    case '90':
                        $Tipo = '******* INDIRECTOS *******';
                        break;
                }
                $pdf->setTipo($Tipo);
                $pdf->AddPage();


                //Agregamos los Grupos
                foreach ($Grupos as $key => $G) {

                    if ($T->DepartamentoArt === $G->DepartamentoArt) {
                        $pdf->SetLineWidth(0.5);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->SetX(5);
                        $pdf->Cell(15, 5, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX(20);
                        $pdf->SetFont('Calibri', '', 9);
                        $pdf->Cell(50, 5, utf8_decode($G->ClaveGrupo . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');
                        $pdf->SetLineWidth(0.2);
                        $TOTAL_GPO = 0;
                        //Agregamos los articulos
                        foreach ($ArticulosE as $key => $AE) {

                            if ($T->DepartamentoArt === $AE->DepartamentoArt && $G->ClaveGrupo === $AE->ClaveGrupo) {
                                $TOTAL_ART = 0;
                                foreach ($Articulos as $key => $A) {
                                    if ($AE->Articulo === $A->Articulo && $A->ClaveGrupo === $AE->ClaveGrupo) {
                                        $pdf->SetFont('Calibri', '', 9);
                                        $pdf->Row(array(
                                            $A->ControlT,
                                            $A->Articulo,
                                            utf8_decode(mb_strimwidth($A->ArticuloT, 0, 45, "")),
                                            $A->UnidadMedidaT,
                                            number_format($A->Cantidad, 2, ".", ","),
                                            ''
                                                ), 0);
                                        $TOTAL_GPO += $A->Cantidad;
                                        $TOTAL_ART += $A->Cantidad;
                                    }
                                }
                                $pdf->SetFont('Calibri', 'B', 9);
                                $pdf->Row(array(
                                    '',
                                    '',
                                    utf8_decode('Total por Artículo: '),
                                    '',
                                    number_format($TOTAL_ART, 2, ".", ","),
                                    ''
                                        ), 'T');
                            }
                        }
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Row(array(
                            '',
                            '',
                            'Total por Grupo: ',
                            '',
                            number_format($TOTAL_GPO, 2, ".", ","),
                            ''
                                ), 'T');
                    }
                }
            }


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/EntregaMateriales';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTREGA MATERIALES POR A-MAQ-SEM " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/EntregaMateriales/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReportePorAnoSemMaqPorDepartamento() {
        $Ano = $this->input->post('Ano');
        $Sem = $this->input->post('Sem');
        $Maq = $this->input->post('Maq');
        $Tipo = $this->input->post('Tipo');

        $Grupos = $this->MaterialControlFecha_model->getGruposArticulosByAnoMaqSemByDepto($Ano, $Sem, $Maq, $Tipo);
        $ArticulosE = $this->MaterialControlFecha_model->getArticulosEncByAnoMaqSemByDepto($Ano, $Sem, $Maq, $Tipo);
        $Articulos = $this->MaterialControlFecha_model->getArticulosByAnoMaqSemByDepto($Ano, $Sem, $Maq, $Tipo);
        if (!empty($Grupos)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->SetAutoPageBreak(true, 10);

            //Agregamos una hoja por cada departamento del articulo 10, 80, 90

            switch ($Tipo) {
                case '10':
                    $Tipo = '******* PIEL Y FORRO *******';
                    break;
                case '80':
                    $Tipo = '******* SUELA *******';
                    break;
                case '90':
                    $Tipo = '******* INDIRECTOS *******';
                    break;
            }
            $pdf->setTipo($Tipo);
            $pdf->AddPage();


            //Agregamos los Grupos
            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(5);
                $pdf->Cell(15, 5, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 9);
                $pdf->Cell(50, 5, utf8_decode($G->ClaveGrupo . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');
                $pdf->SetLineWidth(0.2);
                $TOTAL_GPO = 0;
                //Agregamos los articulos
                foreach ($ArticulosE as $key => $AE) {

                    if ($G->ClaveGrupo === $AE->ClaveGrupo) {
                        $TOTAL_ART = 0;
                        foreach ($Articulos as $key => $A) {

                            if ($AE->Articulo === $A->Articulo && $A->ClaveGrupo === $AE->ClaveGrupo) {
                                $pdf->SetFont('Calibri', '', 9);
                                $pdf->Row(array(
                                    $A->ControlT,
                                    $A->Articulo,
                                    utf8_decode(mb_strimwidth($A->ArticuloT, 0, 45, "")),
                                    $A->UnidadMedidaT,
                                    number_format($A->Cantidad, 2, ".", ","),
                                    ''
                                        ), 0);
                                $TOTAL_GPO += $A->Cantidad;
                                $TOTAL_ART += $A->Cantidad;
                            }
                        }
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Row(array(
                            '',
                            '',
                            utf8_decode('Total por Artículo: '),
                            '',
                            number_format($TOTAL_ART, 2, ".", ","),
                            ''
                                ), 'T');
                    }
                }
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Row(array(
                    '',
                    '',
                    'Total por Grupo: ',
                    '',
                    number_format($TOTAL_GPO, 2, ".", ","),
                    ''
                        ), 'T');
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/EntregaMateriales';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTREGA MATERIALES POR A-MAQ-SEM " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/EntregaMateriales/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReportePorAnoSemMaqSinControl() {
        $Ano = $this->input->get('Ano');
        $Sem = $this->input->get('Sem');
        $Maq = $this->input->get('Maq');

        $Grupos = $this->MaterialControlFecha_model->getGruposArticulosByAnoMaqSemByDeptoSinControl($Ano, $Sem, $Maq);
        $ArticulosE = $this->MaterialControlFecha_model->getArticulosEncByAnoMaqSemByDeptoSinControl($Ano, $Sem, $Maq);
        if (!empty($ArticulosE)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->SetAutoPageBreak(true, 10);

            //Agregamos una hoja por cada departamento del articulo 10, 80, 90
            $Tipo = '******* INDIRECTOS *******';
            $pdf->setTipo($Tipo);
            $pdf->AddPage();


            //Agregamos los Grupos
            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(5);
                $pdf->Cell(15, 4, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 9);
                $pdf->Cell(50, 4, utf8_decode($G->ClaveGrupo . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');
                $pdf->SetLineWidth(0.2);
                //Agregamos los articulos
                foreach ($ArticulosE as $key => $AE) {

                    if ($G->ClaveGrupo === $AE->ClaveGrupo) {

                        $pdf->SetFont('Calibri', '', 9);
                        $pdf->Row(array(
                            '',
                            $AE->Articulo,
                            utf8_decode(mb_strimwidth($AE->ArticuloT, 0, 45, "")),
                            $AE->UnidadMedidaT,
                            number_format($AE->Cantidad, 2, ".", ","),
                            ''
                                ), 0);
                    }
                }
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/EntregaMateriales';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ENTREGA MATERIALES POR A-MAQ-SEM " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/EntregaMateriales/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            return base_url() . $url;
        }
    }

    public function imprimirReportes90() {
        $reports = array();
        $reports['CONCENTRADO'] = $this->onImprimirReportePorAnoSemMaqSinControl();
        $reports['DESGLOSADO'] = $this->onReporteMaterialXControlTipo90();
        print json_encode($reports);
    }

    public function onReporteMaterialXControlTipo90() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Ano"] = $this->input->get('Ano');
        $parametros["Maq"] = $this->input->get('Maq');
        $parametros["Sem"] = $this->input->get('Sem');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\matxControlTipo90.jasper');
        $jc->setFilename('MATERIAL_X_CONTROL_TIPO_90_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        return $jc->getReport();
    }

    public function onReporteMaterialXControlTipo80() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Ano"] = $this->input->get('Ano');
        $parametros["Maq"] = $this->input->get('Maq');
        $parametros["Sem"] = $this->input->get('Sem');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\matxControlTipo80.jasper');
        $jc->setFilename('MATERIAL_X_CONTROL_TIPO_80_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        print json_encode($jc->getReport());
    }

}
