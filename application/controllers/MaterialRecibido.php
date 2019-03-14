<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class MaterialRecibido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Ordencompra_model')
                ->model('MaterialRecibido_model')
                ->helper('ReportesCompras_helper')->helper('file');
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
            $this->load->view('vMaterialRecibido');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->MaterialRecibido_model->getRecords($this->input->post('Ano'), $this->input->post('Tp'), $this->input->post('Tipo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function onImprimirOrdenCompra() {
        $cm = $this->Ordencompra_model;
        $DatosEmpresa = $cm->getDatosEmpresa();
        $OrdenCompra = $cm->getReporteOrdenCompra($this->input->post('Tp'), $this->input->post('Folio'));

        if (!empty($OrdenCompra)) {
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Direccion = $DatosEmpresa[0]->Direccion;
            $pdf->Direccion2 = $DatosEmpresa[0]->Direccion2;
            $pdf->FechaOrden = $OrdenCompra[0]->FechaOrden;
            $pdf->FechaCaptura = $OrdenCompra[0]->FechaCaptura;
            $pdf->ClaveProveedor = $OrdenCompra[0]->Proveedor;
            $pdf->Proveedor = $OrdenCompra[0]->NombreProveedor;
            $pdf->Observaciones = $OrdenCompra[0]->Observaciones;
            $pdf->ConsignarA = $OrdenCompra[0]->ConsignarA;
            $pdf->Folio = $OrdenCompra[0]->Folio;
            $pdf->Estatus = $OrdenCompra[0]->Estatus;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 26.9);

            $SubTotal = 0;
            $TotalCantidad = 0;
            foreach ($OrdenCompra as $keyFT => $F) {
                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Arial', '', 7);
                //$anchos = array(10/* 0 */, 90/* 1 */, 15/* 2 */, 10/* 3 */, 20/* 4 */, 20/* 5 */, 10/* 6 */, 15/* 7 */, 30/* 8 */, 30/* 9 */, 20/* 10 */);
                //$aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');


                $anchos = array(10/* 0 */, 90/* 1 */, 15/* 2 */, 10/* 3 */, 20/* 4 */, 20/* 5 */, 10/* 6 */, 15/* 7 */, 25/* 8 */, 35/* 9 */, 20/* 10 */);
                $aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'C', 'C', 'L');

                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);

                $pdf->Row(array(
                    utf8_decode($F->Articulo),
                    mb_strimwidth(utf8_decode($F->NombreArticulo), 0, 60, "..."),
                    number_format($F->Cantidad, 2, ".", ","),
                    utf8_decode($F->Unidad),
                    '$' . number_format($F->Precio, 2, ".", ","),
                    '$' . number_format($F->SubTotal, 2, ".", ","),
                    $F->Sem,
                    $F->Maq,
                    number_format($F->CantidadRecibida, 2, ".", ","),
                    $F->Factura,
                    utf8_decode($F->FechaEntrega)
                ));
                //TOTALES GRUPOS
                $SubTotal += $F->SubTotal;
                $TotalCantidad += $F->Cantidad;
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->RowNoBorder(array('', '', number_format($TotalCantidad, 2, ".", ","), '',
                'Subtotal:', '$' . number_format($SubTotal, 2, ".", ","), '', '', '', '', ''
            ));

            //Pintamos el IVA si es TP 1
            if ($OrdenCompra[0]->Tp === '1') {
                $IVA = $SubTotal * 0.16;
                $Total = $SubTotal + $IVA;
                $pdf->RowNoBorder(array('', '', '', '', 'IVA:', '$' . number_format($IVA, 2, ".", ","), '', '', '', '', ''));
                $pdf->RowNoBorder(array('', '', '', '', 'Total:', '$' . number_format($Total, 2, ".", ","), '', '', '', '', ''));
            }



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/OrdenesCompra';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ORDEN DE COMPRA " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/OrdenesCompra/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
