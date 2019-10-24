<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class NotasCargo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('NotasCargo_model')->helper('Notacredito_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vNotasCargo');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->NotasCargo_model->getRecords($this->input->post('NC'), $this->input->post('Tp'), $this->input->post('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelarNotaCredito() {
        try {
            $x = $this->input;
            $Tp = $x->post('Tp');
            $Folio = $x->post('Folio');
            $Proveedor = $x->post('Proveedor');

            $NotaCredito = $this->NotasCargo_model->getRegistrosParaCancelar($Tp, $Folio, $Proveedor);

            if (!empty($NotaCredito)) {

                $Total = 0;
                foreach ($NotaCredito as $key => $G) {
                    $Total += $G->Subtotal;
                }
                if ($Tp === '1') {
                    $Total = $Total * 1.16;
                }


                //ACTUALIZA CARTERA DE PROVEEDORES
                $datosCartProv = array(
                    'Proveedor' => $Proveedor,
                    'Factura' => $NotaCredito[0]->DocCartProv,
                    'Importe' => $Total,
                    'Tp' => $Tp,
                );

                $this->NotasCargo_model->onRegresarSaldoCartera($datosCartProv);

                //ACTUALIZA ESTATUS Y PONE CANTIDADES EN 0
                $this->NotasCargo_model->onCancelarNotaCredito($Tp, $Folio, $Proveedor);
                $this->NotasCargo_model->onCancelarPagoProv($Tp, $Folio, $Proveedor);
                $this->NotasCargo_model->onCancelarMovArt($Tp, $Folio, $Proveedor);
            } else {
                print '0';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarNotaCredito() {
        try {
            $x = $this->input;
            $Tp = $x->post('Tp');
            $Folio = $x->post('Folio');
            $Proveedor = $x->post('Proveedor');
            $CantidadLetra = $x->post('CantidadLetra');
            $SubtotalNC = $x->post('SubtotalNC');
            $Tipo = $x->post('Tipo');
            $DocCartProv = $x->post('DocCartProv');

            $Registros = $this->NotasCargo_model->getRegistrosParaFinalizar($Tp, $Folio, $Proveedor);

            foreach ($Registros as $key => $R) {
                //AGREGA EN MOV ART LA SALIDA SI ES DEVOLUCIÓN
                $datos = array(
                    'Articulo' => $R->Clave,
                    'PrecioMov' => $R->Precio,
                    'CantidadMov' => $R->Cantidad,
                    'FechaMov' => Date('d/m/Y'),
                    'DocMov' => $Folio,
                    'EntradaSalida' => '2',
                    'TipoMov' => 'SXO',
                    'Tp' => $Tp,
                    'Maq' => '1',
                    'Ano' => Date('Y'),
                    'OrdenCompra' => $R->DocCartProv,
                    'Subtotal' => $R->Subtotal,
                    'Proveedor' => $Proveedor
                );
                if ($Tipo === '5') {//EN ESTE MODULO ES 2 pero como lo convertimos al TIPO deL MODULO DE pagos 5 es DEVOLUCION
                    $this->NotasCargo_model->onAgregarMovArt($datos);
                }
                //REGISTRA EN PAGOS PROVEEDORES
                $datosPagoProv = array(
                    'Proveedor' => $Proveedor,
                    'Factura' => $R->DocCartProv,
                    'Fecha' => Date('d/m/Y'),
                    'Importe' => $R->Subtotal,
                    'Tp' => $Tp,
                    'DocPago' => 'NC ' . $Folio,
                    'NotaCredito' => $Folio,
                    'TipoPago' => $Tipo,
                    'Estatus' => 'ACTIVO',
                    'Registro' => Date('d/m/Y H:i:s'),
                    'Usuario' => $this->session->userdata('ID')
                );
                $this->NotasCargo_model->onAgregarPagoProveedor($datosPagoProv);
            }
            //ACTUALIZA ESTATUS Y AGREGA EL IMPORTE EN LETRA
            $this->NotasCargo_model->onModificarNotaCredito($Tp, $Folio, $Proveedor, $CantidadLetra);
            //ACTUALIZA CARTERA DE PROVEEDORES
            $datosCartProv = array(
                'Proveedor' => $Proveedor,
                'Factura' => $DocCartProv,
                'Importe' => $SubtotalNC,
                'Tp' => $Tp,
            );
            $this->NotasCargo_model->onModificarSaldoCartera($datosCartProv);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolioByTp() {
        try {
            $FolioNC = $this->NotasCargo_model->getFolioByTp($this->input->post('Tp'));

            if (!empty($FolioNC)) {
                $NC = intval($FolioNC[0]->Folio) + 1;
            } else {
                $NC = 1;
            }
            print $NC;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {

            $x = $this->input;
            $datosNC = array(
                'Folio' => $x->post('Folio'),
                'Proveedor' => $x->post('Proveedor'),
                'DocCartProv' => $x->post('DocCartProv'),
                'Tp' => $x->post('Tp'),
                'Fecha' => Date('d/m/Y H:i:s'),
                'Articulo' => $x->post('Articulo'),
                'Precio' => $x->post('Precio'),
                'Cantidad' => $x->post('Cantidad'),
                'Subtotal' => $x->post('Subtotal'),
                'Concepto' => $x->post('Concepto'),
                'Estatus' => '1'
            );



            //AGREGA EN NOTAS DE CREDITO
            $this->NotasCargo_model->onAgregarNotaCredito($datosNC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID() {
        try {
            $this->NotasCargo_model->onEliminarDetalleByID($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosArticuloCompra() {
        try {
            print json_encode($this->NotasCargo_model->getDatosArticuloCompra($this->input->get('Tp'), $this->input->get('Doc'), $this->input->get('Proveedor'), $this->input->get('Articulo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosDocProvTp() {
        try {
            print json_encode($this->NotasCargo_model->getArticulosDocProvTp($this->input->get('Doc'), $this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteDocumento() {
        try {
            print json_encode($this->NotasCargo_model->onVerificarExisteDocumento($this->input->get('Doc'), $this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDocumentosByTpByProveedor() {
        try {
            print json_encode($this->NotasCargo_model->getDocumentosByTpByProveedor($this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Documentos compras por tp-proveedor */

    public function getDocsByTpByProveedor() {
        try {
            $tp = $this->input->get('Tp');
            $prov = $this->input->get('Proveedor');
            print json_encode($this->db->query("select distinct(Doc) as Doc from compras "
                                    . " where proveedor = $prov and tp = $tp order by Doc ASC ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotasByTpByProveedor() {
        try {
            print json_encode($this->NotasCargo_model->getNotasByTpByProveedor($this->input->get('Tp'), $this->input->get('Proveedor')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->NotasCargo_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporteNotaCargo() {
        $Tp = $this->input->post('Tp');
        $Folio = $this->input->post('Folio');
        $Proveedor = $this->input->post('Proveedor');

        $cm = $this->NotasCargo_model;
        $Articulos = $cm->getNotaCreditoParaReporte($Tp, $Folio, $Proveedor);


        if (!empty($Articulos)) {

            $pdf = new PDFNotaCredito('P', 'mm', array(215.9, 279.4));
            $pdf->setProveedor($Proveedor . ' ' . $Articulos[0]->NombreProv);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Articulos[0]->Fecha);
            $pdf->setDocCartProv($Articulos[0]->DocCartProv);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 9.5);
            foreach ($Articulos as $key => $D) {


                $pdf->Row(array(
                    number_format($D->Cantidad, 2, ".", ","),
                    utf8_decode($D->Unidad),
                    utf8_decode($D->Clave . ' ' . $D->Descripcion),
                    '$' . number_format($D->Precio, 2, ".", ","),
                    '$' . number_format($D->Subtotal, 2, ".", ",")
                        ), 0);

                $TP_IMPORTE += $D->Subtotal;
            }


            $pdf->SetY($pdf->GetY() + 5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 9.5);
            $pdf->Cell(60, 5, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 9.5);
            $pdf->SetX(5);
            $pdf->Cell(60, 5, strtoupper(utf8_decode($Articulos[0]->CantidadLetra)), 0/* BORDE */, 0, 'L');


            $pdf->SetFont('Calibri', 'B', 9.5);
            $pdf->Row(array('', '', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 'T');

            if ($Tp === '1') {
                $pdf->Row(array('', '', '', 'I.V.A. 16%:', '$' . number_format($TP_IMPORTE * .16, 2, ".", ","),), 0);
                $pdf->Row(array('', '', '', 'Total:', '$' . number_format($TP_IMPORTE * 1.16, 2, ".", ","),), 0);
            }



            $pdf->SetY($pdf->GetY() + 5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 9.5);
            $pdf->Cell(60, 5, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 9.5);
            $pdf->SetX(5);
            $pdf->Cell(150, 5, utf8_decode($Articulos[0]->Concepto), 0/* BORDE */, 1, 'L');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Proveedores';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Proveedores/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
