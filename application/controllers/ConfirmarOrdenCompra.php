<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ConfirmarOrdenCompra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ConfirmarOrdencompra_model')->helper('ReportesCompras_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vConfirmarOrderCompra');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->ConfirmarOrdencompra_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $datos = array(
                'ObservacionesConf' => $x->post('ObservacionesConf'),
                'FechaConf' => Date('d/m/Y')
            );
            $this->ConfirmarOrdencompra_model->onModificar($x->post('Tp'), $x->post('Folio'), $datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function onImprimirReporteConfirmacion() {
        $cm = $this->ConfirmarOrdencompra_model;
        $Ano = $this->input->post('Ano');
        $Sem = $this->input->post('Sem');
        $Maq = $this->input->post('Maq');
        $Tipo = $this->input->post('Tipo');
        $DatosEmpresa = $cm->getDatosEmpresa();
        $OrdenCompra = $cm->getReporteConfirmacionOrdenCompra($Ano, $Sem, $Maq, $Tipo);
        if (!empty($OrdenCompra)) {
            $pdf = new PDFConfirmaciones('P', 'mm', array(215.9, 279.4));

            switch ($Tipo) {
                case '10':
                    $TipoE = '******* PIEL Y FORRO *******';
                    break;
                case '80':
                    $TipoE = '******* SUELA *******';
                    break;
                case '90':
                    $TipoE = '******* INDIRECTOS *******';
                    break;
            }

            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Ano = $Ano;
            $pdf->Sem = $Sem;
            $pdf->Maq = $Maq;
            $pdf->Tipo = $TipoE;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 26.9);

            foreach ($OrdenCompra as $keyFT => $F) {
                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);

                $pdf->Row(array(
                    utf8_decode($F->Proveedor),
                    mb_strimwidth(utf8_decode($F->NombreProveedor), 0, 50, "..."),
                    utf8_decode($F->Folio),
                    utf8_decode($F->FechaOrden),
                    utf8_decode($F->FechaEntrega),
                    utf8_decode($F->FechaConf),
                    utf8_decode($F->Dias),
                    utf8_decode($F->Dias2),
                    utf8_decode($F->ObservacionesConf)
                ));
            }


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ConfirmacionOrdenescompra';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "CONFIRMACIONES DE ORDENES DE COMPRA " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/ConfirmacionOrdenescompra/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
