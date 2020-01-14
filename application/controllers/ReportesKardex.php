<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesKardex extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReportesKardex_model')
                ->helper('Reporteskardex_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onVerificarProveedor() {
        try {
            $Proveedor = $this->input->get('Proveedor');
            print json_encode($this->db->query("select clave from proveedores where clave = '$Proveedor ' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarArticulo() {
        try {
            $Articulo = $this->input->get('Articulo');
            print json_encode($this->db->query("select clave from articulos where clave = '$Articulo ' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            print json_encode($this->ReportesKardex_model->getProveedores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            print json_encode($this->ReportesKardex_model->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteKardexPorProveedor() {


        $Proveedor = $this->input->post('Proveedor');
        $NomProveedor = $this->input->post('Nombre');
        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');



        $Mes_Act = substr($fecha, 3, 2);
        $Texto_Mes = '';

        switch ($Mes_Act) {

            case 1:
                $Texto_Mes = 'ENERO';

                break;
            case 2:
                $Texto_Mes = 'FEBRERO';

                break;
            case 3:
                $Texto_Mes = 'MARZO';

                break;
            case 4:
                $Texto_Mes = 'ABRIL';

                break;
            case 5:
                $Texto_Mes = 'MAYO';

                break;
            case 6:
                $Texto_Mes = 'JUNIO';

                break;
            case 7:
                $Texto_Mes = 'JULIO';

                break;
            case 8:
                $Texto_Mes = 'AGOSTO';

                break;
            case 9:
                $Texto_Mes = 'SEPTIEMBRE';

                break;
            case 10:
                $Texto_Mes = 'OCTUBRE';

                break;
            case 11:
                $Texto_Mes = 'NOVIMEBRE';

                break;
            case 12:
                $Texto_Mes = 'DICIEMBRE';

                break;
        }

        $Mes = substr($fecha, 3, 2);
        $Texto_Mes_Anterior = '';
        $Mes_Anterior = $Mes - 1;

        switch ($Mes_Anterior) {
            case 0:
                $Texto_Mes_Anterior = 'Dic';

                break;
            case 1:
                $Texto_Mes_Anterior = 'Ene';

                break;
            case 2:
                $Texto_Mes_Anterior = 'Feb';

                break;
            case 3:
                $Texto_Mes_Anterior = 'Mar';

                break;
            case 4:
                $Texto_Mes_Anterior = 'Abr';

                break;
            case 5:
                $Texto_Mes_Anterior = 'May';

                break;
            case 6:
                $Texto_Mes_Anterior = 'Jun';

                break;
            case 7:
                $Texto_Mes_Anterior = 'Jul';

                break;
            case 8:
                $Texto_Mes_Anterior = 'Ago';

                break;
            case 9:
                $Texto_Mes_Anterior = 'Sep';

                break;
            case 10:
                $Texto_Mes_Anterior = 'Oct';

                break;
            case 11:
                $Texto_Mes_Anterior = 'Nov';

                break;
            case 12:
                $Texto_Mes_Anterior = 'Dic';

                break;
        }


        $cm = $this->ReportesKardex_model;
        $Grupos = $cm->getGruposPorProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior);
        $Articulos = $cm->getArticulosByProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior);
        $Doctos = $cm->getDoctosByProveedor($Proveedor, $fecha, $aFecha, $Texto_Mes_Anterior);

        if (!empty($Grupos)) {

            $pdf = new PDFKardexProveedor('P', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->setProveedor($NomProveedor);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);


            $GGTotal_Sub = 0;
            $GGTotal_Ent = 0;
            $GGTotal_Ent_P = 0;
            $GGTotal_Sal = 0;
            $GGTotal_Sal_P = 0;

            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->Cell(15, 3.5, utf8_decode('Grupo: '), 'LTB'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 7);
                $pdf->Cell(50, 3.5, utf8_decode($G->ClaveGrupo . '  ' . $G->NombreGrupo), 'BTR'/* BORDE */, 1, 'L');

                $GTotal_Sub = 0;
                $GTotal_Ent = 0;
                $GTotal_Ent_P = 0;
                $GTotal_Sal = 0;
                $GTotal_Sal_P = 0;

                foreach ($Articulos as $key => $A) {
                    if ($G->ClaveGrupo === $A->ClaveGrupo) {
                        $pdf->SetLineWidth(0.5);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', 'B', 7);
                        $pdf->Cell(15, 3, utf8_decode('Artículo: '), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX(20);
                        $pdf->SetFont('Calibri', '', 7);
                        $pdf->Cell(90, 3, utf8_decode($A->ClaveArt . '  ' . $A->Articulo), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX(110);
                        $pdf->SetFont('Calibri', 'B', 7);
                        $pdf->Cell(15, 3, utf8_decode($A->Unidad), 'B'/* BORDE */, 1, 'C');

                        $pdf->SetLineWidth(0.2);
                        $pdf->SetFont('Calibri', '', 7);

                        $Total_Sub = 0;
                        $Total_Ent = 0;
                        $Total_Ent_P = 0;
                        $Total_Sal = 0;
                        $Total_Sal_P = 0;

                        foreach ($Doctos as $key => $D) {
                            if ($A->ClaveGrupo === $D->ClaveGrupo && $A->ClaveArt === $D->ClaveArt) {
                                $pdf->SetX(5);

                                $pdf->Cell(16, 4, $D->DocMov, 'B'/* BORDE */, 0, 'L');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(13, 4, $D->OrdenCompra, 'B'/* BORDE */, 0, 'C');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(7, 4, $D->Maq, 'B'/* BORDE */, 0, 'C');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(7, 4, $D->Sem, 'B'/* BORDE */, 0, 'C');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(8, 4, $D->TipoMov, 'B'/* BORDE */, 0, 'C');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(15, 4, $D->FechaMov, 'B'/* BORDE */, 0, 'C');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(12, 4, '$' . number_format($D->PrecioMov, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(15, 4, '$' . number_format($D->Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(17, 4, ($D->Entrada <> 0) ? number_format($D->Entrada, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(17, 4, ($D->Entrada * $D->PrecioMov <> 0) ? '$' . number_format($D->Entrada * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(17, 4, ($D->Salida <> 0) ? number_format($D->Salida, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(17, 4, ($D->Salida * $D->PrecioMov <> 0) ? '$' . number_format($D->Salida * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                                $pdf->SetX($pdf->GetX());
                                $pdf->Cell(45, 4, $NomProveedor, 'B'/* BORDE */, 1, 'L');

                                $Total_Sub += $D->Subtotal;
                                $Total_Ent += $D->Entrada;
                                $Total_Ent_P += $D->Entrada * $D->PrecioMov;
                                $Total_Sal += $D->Salida;
                                $Total_Sal_P += $D->Salida * $D->PrecioMov;


                                $GTotal_Sub += $D->Subtotal;
                                $GTotal_Ent += $D->Entrada;
                                $GTotal_Ent_P += $D->Entrada * $D->PrecioMov;
                                $GTotal_Sal += $D->Salida;
                                $GTotal_Sal_P += $D->Salida * $D->PrecioMov;

                                $GGTotal_Sub += $D->Subtotal;
                                $GGTotal_Ent += $D->Entrada;
                                $GGTotal_Ent_P += $D->Entrada * $D->PrecioMov;
                                $GGTotal_Sal += $D->Salida;
                                $GGTotal_Sal_P += $D->Salida * $D->PrecioMov;
                            }
                        }
                        $pdf->SetFont('Calibri', 'B', 7);
                        $pdf->SetX(5);

                        $pdf->SetLineWidth(0.5);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(33, 3, "Saldo Inicial de $Texto_Mes:", 'LB'/* BORDE */, 0, 'L');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3, number_format($A->SaldoInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3, '$' . number_format($A->PrecioInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3, '$' . number_format($A->SaldoInicial * $A->PrecioInicial, 2, ".", ","), 'BR'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3, '$' . number_format($Total_Sub, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(17, 3, number_format($Total_Ent, 2, ".", ","), 'LB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(17, 3, '$' . number_format($Total_Ent_P, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(17, 3, number_format($Total_Sal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(17, 3, '$' . number_format($Total_Sal_P, 2, ".", ","), 'RB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(30, 3, 'Existencia Actual: ', 'B'/* BORDE */, 0, 'L');

                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3, number_format($A->SaldoInicial + $Total_Ent - $Total_Sal, 2, ".", ","), 'B'/* BORDE */, 1, 'L');
                    }
                }
                $pdf->SetFont('Calibri', 'B', 7);
                $pdf->SetX(5);

                $pdf->SetLineWidth(0.5);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(78, 3.5, "Total por grupo:", 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3.5, '$' . number_format($GTotal_Sub, 2, ".", ","), 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3.5, number_format($GTotal_Ent, 2, ".", ","), 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3.5, '$' . number_format($GTotal_Ent_P, 2, ".", ","), 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3.5, number_format($GTotal_Sal, 2, ".", ","), 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3.5, '$' . number_format($GTotal_Sal_P, 2, ".", ","), 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(30, 3.5, '', 0/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3.5, '', 0/* BORDE */, 1, 'L');
            }

            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->SetX(5);

            $pdf->SetLineWidth(0.5);
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(78, 3.5, "Total general:", 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($GGTotal_Sub, 2, ".", ","), 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($GGTotal_Ent, 2, ".", ","), 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($GGTotal_Ent_P, 2, ".", ","), 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($GGTotal_Sal, 2, ".", ","), 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($GGTotal_Sal_P, 2, ".", ","), 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(30, 3.5, '', 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '', 0/* BORDE */, 1, 'L');

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Kardex';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "KARDEX DE ARTICULOS POR PROVEEDOR" . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Kardex/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteKardexSubAlmacePorArticulo() {

        $Articulo = $this->input->post('Articulo');
        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');

        $Mes_Act = substr($fecha, 3, 2);
        $Texto_Mes = '';

        switch ($Mes_Act) {

            case 1:
                $Texto_Mes = 'ENERO';

                break;
            case 2:
                $Texto_Mes = 'FEBRERO';

                break;
            case 3:
                $Texto_Mes = 'MARZO';

                break;
            case 4:
                $Texto_Mes = 'ABRIL';

                break;
            case 5:
                $Texto_Mes = 'MAYO';

                break;
            case 6:
                $Texto_Mes = 'JUNIO';

                break;
            case 7:
                $Texto_Mes = 'JULIO';

                break;
            case 8:
                $Texto_Mes = 'AGOSTO';

                break;
            case 9:
                $Texto_Mes = 'SEPTIEMBRE';

                break;
            case 10:
                $Texto_Mes = 'OCTUBRE';

                break;
            case 11:
                $Texto_Mes = 'NOVIMEBRE';

                break;
            case 12:
                $Texto_Mes = 'DICIEMBRE';

                break;
        }

        $Mes = substr($fecha, 3, 2);
        $Texto_Mes_Anterior = '';
        $Mes_Anterior = $Mes - 1;

        switch ($Mes_Anterior) {
            case 0:
                $Texto_Mes_Anterior = 'Dic';

                break;
            case 1:
                $Texto_Mes_Anterior = 'Ene';

                break;
            case 2:
                $Texto_Mes_Anterior = 'Feb';

                break;
            case 3:
                $Texto_Mes_Anterior = 'Mar';

                break;
            case 4:
                $Texto_Mes_Anterior = 'Abr';

                break;
            case 5:
                $Texto_Mes_Anterior = 'May';

                break;
            case 6:
                $Texto_Mes_Anterior = 'Jun';

                break;
            case 7:
                $Texto_Mes_Anterior = 'Jul';

                break;
            case 8:
                $Texto_Mes_Anterior = 'Ago';

                break;
            case 9:
                $Texto_Mes_Anterior = 'Sep';

                break;
            case 10:
                $Texto_Mes_Anterior = 'Oct';

                break;
            case 11:
                $Texto_Mes_Anterior = 'Nov';

                break;
            case 12:
                $Texto_Mes_Anterior = 'Dic';

                break;
        }

        $cm = $this->ReportesKardex_model;
        $Detalle = $cm->getDoctosSubAlmacenByArticulo($Articulo, $fecha, $aFecha, $Texto_Mes_Anterior);


        if (!empty($Detalle)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);

            $pdf->SetLineWidth(0.5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(20);
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(50, 3.5, utf8_decode($Detalle[0]->ClaveGrupo . '  ' . $Detalle[0]->NombreGrupo), 'B'/* BORDE */, 1, 'L');

            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode('Artículo: '), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(20);
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(90, 3.5, utf8_decode($Detalle[0]->ClaveArt . '  ' . $Detalle[0]->Articulo), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(110);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode($Detalle[0]->Unidad), 'B'/* BORDE */, 1, 'C');

            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Calibri', '', 7);

            $Total_Sub = 0;
            $Total_Ent = 0;
            $Total_Ent_P = 0;
            $Total_Sal = 0;
            $Total_Sal_P = 0;

            foreach ($Detalle as $key => $D) {
                $pdf->SetX(5);

                $pdf->Cell(16, 3, $D->DocMov, 'B'/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(13, 3, $D->OrdenCompra, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(7, 3, $D->Maq, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(7, 3, $D->Sem, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(8, 3, $D->TipoMov, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, $D->FechaMov, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 3, '$' . number_format($D->PrecioMov, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, '$' . number_format($D->Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Entrada <> 0) ? number_format($D->Entrada, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Entrada * $D->PrecioMov <> 0) ? '$' . number_format($D->Entrada * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Salida <> 0) ? number_format($D->Salida, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Salida * $D->PrecioMov <> 0) ? '$' . number_format($D->Salida * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(45, 3, $D->Proveedor, 'B'/* BORDE */, 1, 'L');

                $Total_Sub += $D->Subtotal;
                $Total_Ent += $D->Entrada;
                $Total_Ent_P += $D->Entrada * $D->PrecioMov;
                $Total_Sal += $D->Salida;
                $Total_Sal_P += $D->Salida * $D->PrecioMov;
            }
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->SetX(5);

            $pdf->SetLineWidth(0.5);
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(33, 3.5, "Saldo Inicial de $Texto_Mes:", 'LB'/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, number_format($Detalle[0]->SaldoInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Detalle[0]->PrecioInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Detalle[0]->SaldoInicial * $Detalle[0]->PrecioInicial, 2, ".", ","), 'BR'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Total_Sub, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($Total_Ent, 2, ".", ","), 'LB'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($Total_Ent_P, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($Total_Sal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($Total_Sal_P, 2, ".", ","), 'RB'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(30, 3.5, 'Existencia Actual: ', 'B'/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, number_format($Detalle[0]->SaldoInicial + $Total_Ent - $Total_Sal, 2, ".", ","), 'B'/* BORDE */, 1, 'L');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Kardex';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "KARDEX DE ARTICULOS SUBALMACEN " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Kardex/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteKardexPorArticulo() {

        $Articulo = $this->input->post('Articulo');
        $fecha = $this->input->post('FechaIni');
        $aFecha = $this->input->post('FechaFin');



        $Mes_Act = substr($fecha, 3, 2);
        $Texto_Mes = '';

        switch ($Mes_Act) {

            case 1:
                $Texto_Mes = 'ENERO';

                break;
            case 2:
                $Texto_Mes = 'FEBRERO';

                break;
            case 3:
                $Texto_Mes = 'MARZO';

                break;
            case 4:
                $Texto_Mes = 'ABRIL';

                break;
            case 5:
                $Texto_Mes = 'MAYO';

                break;
            case 6:
                $Texto_Mes = 'JUNIO';

                break;
            case 7:
                $Texto_Mes = 'JULIO';

                break;
            case 8:
                $Texto_Mes = 'AGOSTO';

                break;
            case 9:
                $Texto_Mes = 'SEPTIEMBRE';

                break;
            case 10:
                $Texto_Mes = 'OCTUBRE';

                break;
            case 11:
                $Texto_Mes = 'NOVIMEBRE';

                break;
            case 12:
                $Texto_Mes = 'DICIEMBRE';

                break;
        }

        $Mes = substr($fecha, 3, 2);
        $Texto_Mes_Anterior = '';
        $Mes_Anterior = $Mes - 1;

        switch ($Mes_Anterior) {
            case 0:
                $Texto_Mes_Anterior = 'Dic';

                break;
            case 1:
                $Texto_Mes_Anterior = 'Ene';

                break;
            case 2:
                $Texto_Mes_Anterior = 'Feb';

                break;
            case 3:
                $Texto_Mes_Anterior = 'Mar';

                break;
            case 4:
                $Texto_Mes_Anterior = 'Abr';

                break;
            case 5:
                $Texto_Mes_Anterior = 'May';

                break;
            case 6:
                $Texto_Mes_Anterior = 'Jun';

                break;
            case 7:
                $Texto_Mes_Anterior = 'Jul';

                break;
            case 8:
                $Texto_Mes_Anterior = 'Ago';

                break;
            case 9:
                $Texto_Mes_Anterior = 'Sep';

                break;
            case 10:
                $Texto_Mes_Anterior = 'Oct';

                break;
            case 11:
                $Texto_Mes_Anterior = 'Nov';

                break;
            case 12:
                $Texto_Mes_Anterior = 'Dic';

                break;
        }


        $cm = $this->ReportesKardex_model;
        $Detalle = $cm->getDoctosByArticulo($Articulo, $fecha, $aFecha, $Texto_Mes_Anterior);


        if (!empty($Detalle)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->setFecha($fecha);
            $pdf->setAFecha($aFecha);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);

            $pdf->SetLineWidth(0.5);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(20);
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(50, 3.5, utf8_decode($Detalle[0]->ClaveGrupo . '  ' . $Detalle[0]->NombreGrupo), 'B'/* BORDE */, 1, 'L');

            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode('Artículo: '), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(20);
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(90, 3.5, utf8_decode($Detalle[0]->ClaveArt . '  ' . $Detalle[0]->Articulo), 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(110);
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->Cell(15, 3.5, utf8_decode($Detalle[0]->Unidad), 'B'/* BORDE */, 1, 'C');

            $pdf->SetLineWidth(0.2);
            $pdf->SetFont('Calibri', '', 7);

            $Total_Sub = 0;
            $Total_Ent = 0;
            $Total_Ent_P = 0;
            $Total_Sal = 0;
            $Total_Sal_P = 0;

            foreach ($Detalle as $key => $D) {
                $pdf->SetX(5);

                $pdf->Cell(16, 3, $D->DocMov, 'B'/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(13, 3, $D->OrdenCompra, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(7, 3, $D->Maq, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(7, 3, $D->Sem, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(8, 3, $D->TipoMov, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, $D->FechaMov, 'B'/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 3, '$' . number_format($D->PrecioMov, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, '$' . number_format($D->Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Entrada <> 0) ? number_format($D->Entrada, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Entrada * $D->PrecioMov <> 0) ? '$' . number_format($D->Entrada * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Salida <> 0) ? number_format($D->Salida, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(17, 3, ($D->Salida * $D->PrecioMov <> 0) ? '$' . number_format($D->Salida * $D->PrecioMov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(45, 3, $D->Proveedor, 'B'/* BORDE */, 1, 'L');

                $Total_Sub += $D->Subtotal;
                $Total_Ent += $D->Entrada;
                $Total_Ent_P += $D->Entrada * $D->PrecioMov;
                $Total_Sal += $D->Salida;
                $Total_Sal_P += $D->Salida * $D->PrecioMov;
            }
            $pdf->SetFont('Calibri', 'B', 7);
            $pdf->SetX(5);

            $pdf->SetLineWidth(0.5);
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(33, 3.5, "Saldo Inicial de $Texto_Mes:", 'LB'/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, number_format($Detalle[0]->SaldoInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Detalle[0]->PrecioInicial, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Detalle[0]->SaldoInicial * $Detalle[0]->PrecioInicial, 2, ".", ","), 'BR'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, '$' . number_format($Total_Sub, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($Total_Ent, 2, ".", ","), 'LB'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($Total_Ent_P, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, number_format($Total_Sal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(17, 3.5, '$' . number_format($Total_Sal_P, 2, ".", ","), 'RB'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(30, 3.5, 'Existencia Actual: ', 'B'/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 3.5, number_format($Detalle[0]->SaldoInicial + $Total_Ent - $Total_Sal, 2, ".", ","), 'BR'/* BORDE */, 1, 'L');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Kardex';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "KARDEX DE ARTICULOS " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Kardex/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
