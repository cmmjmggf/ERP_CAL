<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteCuentasPorCobrarMaquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteCuentasPorCobrarMaquilas_model')
                ->helper('Reportescuentasporcobrarmaquilas_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteCtasPorCobrarMaquilas() {
        $Año = $this->input->post('Ano');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');


        $cm = $this->ReporteCuentasPorCobrarMaquilas_model;
        $Maquilas = $cm->getMaquilasReporte($Maq, $aMaq, $Año);
        $Semanas = $cm->getSemanasReporte($Maq, $aMaq, $Año);
        $Doctos = $cm->getDoctosReporte($Maq, $aMaq, $Año);

        if (!empty($Maquilas)) {

            $pdf = new PDFCtasXCobrarMaquilas('P', 'mm', array(215.9, 279.4));
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $Total_G = 0;
            foreach ($Maquilas as $key => $M) {
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->Cell(70, 5, utf8_decode(mb_strimwidth(utf8_decode($M->Maquila . ' ' . $M->NombreMaquila), 0, 60, "")), 'B'/* BORDE */, 1, 'L');


                $Total_M = 0;
                foreach ($Semanas as $key => $S) {

                    if ($M->Maquila === $S->Maquila) {

                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Cell(70, 5, utf8_decode('Semana ' . $S->Semana), 0/* BORDE */, 1, 'L');

                        $Total_S = 0;
                        foreach ($Doctos as $key => $D) {

                            if ($S->Semana === $D->Semana && $S->Maquila === $D->Maquila) {
                                $pdf->SetFont('Calibri', '', 9);
                                $pdf->Row(array($D->DocMov, '$' . number_format($D->Subtotal, 2, ".", ","),), 0);
                                $Total_S += $D->Subtotal;
                                $Total_M += $D->Subtotal;
                                $Total_G += $D->Subtotal;
                            }
                        }
                        /* Hacer sumatoria de la semana */
                        $pdf->SetX(70);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Cell(70, 4, utf8_decode('Total de la semana ' . $S->Semana . ':'), 0/* BORDE */, 0, 'L');
                        $pdf->Row(array('', '$' . number_format($Total_S, 2, ".", ","),), 'T');
                    }
                }
                /* Hacer sumatoria de la maquila */
                $pdf->SetX(70);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(70, 4, utf8_decode('Total de la maquila: '), 0/* BORDE */, 0, 'L');
                $pdf->Row(array('', '$' . number_format($Total_M, 2, ".", ","),), 'T');
            }
            /* Hacer sumatoria general */
            $pdf->SetLineWidth(0.6);
            $pdf->SetX(70);
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->Cell(70, 4, utf8_decode('Total general: '), 0/* BORDE */, 0, 'L');
            $pdf->Row(array('', '$' . number_format($Total_G, 2, ".", ","),), 'T');



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/CXC_Maquilas';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "CTAS POR COBRAR DE MAQUILAS " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/CXC_Maquilas/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
