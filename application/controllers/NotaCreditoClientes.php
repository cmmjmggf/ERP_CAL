<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class NotaCreditoClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('Notacreditoclientes_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }

            //$this->load->view('vFondo')->view('vNotaCredito')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getNotasByTpByCliente() {
        try {
            $cte = $this->input->get('Cliente');
            $tipo = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT nc FROM notcred "
                                    . " where cliente = $cte and tp = $tipo group by nc order by nc asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporteNotaCredito() {
        $Tp = $this->input->post('Tp');
        $Folio = $this->input->post('Folio');
        $Cliente = $this->input->post('Cliente');

        $Documento = $this->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto, df.Descripcion as nomdefecto, nc.detalle, dt.Descripcion as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join defectos df on df.clave= nc.defecto
                                        left join defectosdetalle dt on dt.clave= nc.detalle
                                        where nc.cliente= $Cliente
                                        and nc.tp = $Tp
                                        and nc.nc = $Folio ")->result();


        if (!empty($Documento)) {

            $pdf = new PDFNotaCreditoClientes('P', 'mm', array(215.9, 279.4));
            $pdf->setCliente($Cliente . ' ' . $Documento[0]->RazonS);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Documento[0]->fecha . ' ' . $Documento[0]->hora);
            $pdf->setDoc($Documento[0]->numfac);

            $pdf->setRfc($Documento[0]->RFC);
            $pdf->setDireccion($Documento[0]->Direccion);
            $pdf->setColonia($Documento[0]->Colonia);
            $pdf->setCiudad($Documento[0]->Ciudad . ', ' . $Documento[0]->nomestado);
            $pdf->setCp($Documento[0]->CodigoPostal);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('9999'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(80, 3, utf8_decode($D->descripcion), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format($D->precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(25, 3, '$' . number_format($D->subtot, 2, ".", ","), 0/* BORDE */, 1, 'R');

                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());
                $TP_IMPORTE += $D->subtot;
            }


            $pdf->SetY($pdf->GetY() + 5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 5, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(60, 5, utf8_decode($Documento[0]->monletra), 0/* BORDE */, 0, 'L');


            $pdf->SetFont('Calibri', 'B', 8);
//            $pdf->Row(array('', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 'T');
//
//            if ($Tp === '1') {
//                $pdf->Row(array('', '', 'I.V.A. 16%:', '$' . number_format($TP_IMPORTE * .16, 2, ".", ","),), 0);
//                $pdf->Row(array('', '', 'Total:', '$' . number_format($TP_IMPORTE * 1.16, 2, ".", ","),), 0);
//            }
//
//

            $pdf->SetY($pdf->GetY() + 5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 5, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(150, 5, utf8_decode($Documento[0]->concepto), 0/* BORDE */, 1, 'L');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
