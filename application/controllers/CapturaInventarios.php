<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class CapturaInventarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteCapturaFisica_model')
                ->helper('Reportecapturafisica_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    /* Para captura de conteo fisico del inventario */

    public function getArticulos() {
        try {
            print json_encode($this->ReporteCapturaFisica_model->getArticulosParaConteoFisico());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoArticulo() {
        try {
            print json_encode($this->ReporteCapturaFisica_model->getInfoArticulo($this->input->get('Articulo'), $this->input->get('Maq'), $this->input->get('Mes')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCapturarConteoInvFisico() {
        try {
            $Maq = $this->input->post('Maq');
            $Mes = $this->input->post('Mes');
            $Articulo = $this->input->post('Articulo');
            $Precio = $this->input->post('Precio');
            $ExistenciaFisica = $this->input->post('ExistenciaFisica');

            $this->db->set("P$Mes", $Precio)
                    ->set($Mes, $ExistenciaFisica)
                    ->where('Clave', $Articulo)
                    ->update($Maq);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* MEtodo que pone en 0 existencia y graba lo que tenga la columna del mes seleccionado */

    public function onCerrarMesInventario() {
        try {
            $Maq = $this->input->post('Maq');
            $Mes = $this->input->post('Mes');

            $this->db->set("Existencia", 0)
                    ->update($Maq);

            $this->db->query("UPDATE articulos A SET A.Existencia = A.$Mes ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Metodo que pone en 0s el mes a capturar */

    public function onPrepararMesCapturaInv() {
        try {
            $Maq = $this->input->post('Maq');
            $Mes = $this->input->post('Mes');

            $this->db->set("P$Mes", 0)
                    ->set($Mes, 0)
                    ->update($Maq);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function onReporteExistenciasAnualPorMes() {
        $Maq = $this->input->post('Maq');
        $Grupos = $this->ReporteCapturaFisica_model->getGruposReporteExistenciasAnualPorMes($Maq);
        $Detalle = $this->ReporteCapturaFisica_model->getArticulosReporteExistenciasAnualPorMes($Maq);

        if (!empty($Grupos)) {
            $pdf = new PDF_ExisAnual('L', 'mm', array(215.9, 279.4));

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $GT_Ene = 0;
            $GT_Feb = 0;
            $GT_Mar = 0;
            $GT_Abr = 0;
            $GT_May = 0;
            $GT_Jun = 0;
            $GT_Jul = 0;
            $GT_Ago = 0;
            $GT_Sep = 0;
            $GT_Oct = 0;
            $GT_Nov = 0;
            $GT_Dic = 0;

            $GP_Ene = 0;
            $GP_Feb = 0;
            $GP_Mar = 0;
            $GP_Abr = 0;
            $GP_May = 0;
            $GP_Jun = 0;
            $GP_Jul = 0;
            $GP_Ago = 0;
            $GP_Sep = 0;
            $GP_Oct = 0;
            $GP_Nov = 0;
            $GP_Dic = 0;

            foreach ($Grupos as $key => $G) {


                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Cell(15, 6, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8.5);
                $pdf->Cell(38, 6, utf8_decode($G->ClaveGrupo . ' ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

                $T_Ene = 0;
                $T_Feb = 0;
                $T_Mar = 0;
                $T_Abr = 0;
                $T_May = 0;
                $T_Jun = 0;
                $T_Jul = 0;
                $T_Ago = 0;
                $T_Sep = 0;
                $T_Oct = 0;
                $T_Nov = 0;
                $T_Dic = 0;

                $P_Ene = 0;
                $P_Feb = 0;
                $P_Mar = 0;
                $P_Abr = 0;
                $P_May = 0;
                $P_Jun = 0;
                $P_Jul = 0;
                $P_Ago = 0;
                $P_Sep = 0;
                $P_Oct = 0;
                $P_Nov = 0;
                $P_Dic = 0;
                foreach ($Detalle as $key => $D) {

                    if ($G->ClaveGrupo === $D->ClaveGrupo) {

                        $pdf->SetLineWidth(0.2);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Calibri', '', 8.5);
                        $pdf->SetY($pdf->GetY());
                        $pdf->SetX(5);
                        $pdf->Cell(11, 4, utf8_decode($D->Codigo), 0/* BORDE */, 0, 'R');
                        $pdf->SetX(16);
                        $pdf->Cell(42, 4, mb_strimwidth(utf8_decode($D->Articulo), 0, 27, ""), 0/* BORDE */, 0, 'L');


                        /* Cantidades */
                        $pdf->SetX(58);
                        $pdf->Cell(18, 4, ($D->Ene <> 0) ? number_format($D->Ene, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Feb <> 0) ? number_format($D->Feb, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Mar <> 0) ? number_format($D->Mar, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Abr <> 0) ? number_format($D->Abr, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->May <> 0) ? number_format($D->May, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Jun <> 0) ? number_format($D->Jun, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Jul <> 0) ? number_format($D->Jul, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Ago <> 0) ? number_format($D->Ago, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Sep <> 0) ? number_format($D->Sep, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Oct <> 0) ? number_format($D->Oct, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Nov <> 0) ? number_format($D->Nov, 2, ".", ",") : '', 'TL'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->Dic <> 0) ? number_format($D->Dic, 2, ".", ",") : '', 'LTR'/* BORDE */, 1, 'R');


                        /* Precios */
                        $pdf->SetFont('Calibri', 'B', 8.5);
                        $pdf->SetX(5);
                        $pdf->Cell(53, 4, 'Precio', 0/* BORDE */, 0, 'R');
                        $pdf->SetFont('Calibri', '', 8.5);


                        $pdf->SetX(58);
                        $pdf->Cell(18, 4, ($D->PEne <> 0) ? number_format($D->PEne, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PFeb <> 0) ? number_format($D->PFeb, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PMar <> 0) ? number_format($D->PMar, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PAbr <> 0) ? number_format($D->PAbr, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PMay <> 0) ? number_format($D->PMay, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PJun <> 0) ? number_format($D->PJun, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PJul <> 0) ? number_format($D->PJul, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PAgo <> 0) ? number_format($D->PAgo, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PSep <> 0) ? number_format($D->PSep, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->POct <> 0) ? number_format($D->POct, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PNov <> 0) ? number_format($D->PNov, 2, ".", ",") : '', 'L'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PDic <> 0) ? number_format($D->PDic, 2, ".", ",") : '', 'LR'/* BORDE */, 1, 'R');


                        /* Totales */
                        $pdf->SetFont('Calibri', 'B', 8.5);
                        $pdf->SetX(5);
                        $pdf->Cell(53, 4, 'Total: $', 'B'/* BORDE */, 0, 'R');

                        $pdf->SetX(58);
                        $pdf->Cell(18, 4, ($D->PEne * $D->Ene <> 0) ? number_format($D->PEne * $D->Ene, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PFeb * $D->Feb <> 0) ? number_format($D->PFeb * $D->Feb, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PMar * $D->Mar <> 0) ? number_format($D->PMar * $D->Mar, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PAbr * $D->Abr <> 0) ? number_format($D->PAbr * $D->Abr, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PMay * $D->May <> 0) ? number_format($D->PMay * $D->May, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PJun * $D->Jun <> 0) ? number_format($D->PJun * $D->Jun, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PJul * $D->Jul <> 0) ? number_format($D->PJul * $D->Jul, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PAgo * $D->Ago <> 0) ? number_format($D->PAgo * $D->Ago, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PSep * $D->Sep <> 0) ? number_format($D->PSep * $D->Sep, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->POct * $D->Oct <> 0) ? number_format($D->POct * $D->Oct, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PNov * $D->Nov <> 0) ? number_format($D->PNov * $D->Nov, 2, ".", ",") : '', 'TLB'/* BORDE */, 0, 'R');

                        $pdf->SetX($pdf->getX());
                        $pdf->Cell(18, 4, ($D->PDic * $D->Dic <> 0) ? number_format($D->PDic * $D->Dic, 2, ".", ",") : '', 'TRLB'/* BORDE */, 1, 'R');

                        //Totales
                        $GT_Ene += $D->Ene;
                        $GT_Feb += $D->Feb;
                        $GT_Mar += $D->Mar;
                        $GT_Abr += $D->Abr;
                        $GT_May += $D->May;
                        $GT_Jun += $D->Jun;
                        $GT_Jul += $D->Jul;
                        $GT_Ago += $D->Ago;
                        $GT_Sep += $D->Sep;
                        $GT_Oct += $D->Oct;
                        $GT_Nov += $D->Nov;
                        $GT_Dic += $D->Dic;

                        $GP_Ene += $D->Ene * $D->PEne;
                        $GP_Feb += $D->Feb * $D->PFeb;
                        $GP_Mar += $D->Mar * $D->PMar;
                        $GP_Abr += $D->Abr * $D->PAbr;
                        $GP_May += $D->May * $D->PMay;
                        $GP_Jun += $D->Jun * $D->PJun;
                        $GP_Jul += $D->Jul * $D->PJul;
                        $GP_Ago += $D->Ago * $D->PAgo;
                        $GP_Sep += $D->Sep * $D->PSep;
                        $GP_Oct += $D->Oct * $D->POct;
                        $GP_Nov += $D->Nov * $D->PNov;
                        $GP_Dic += $D->Dic * $D->PNov;

                        $T_Ene += $D->Ene;
                        $T_Feb += $D->Feb;
                        $T_Mar += $D->Mar;
                        $T_Abr += $D->Abr;
                        $T_May += $D->May;
                        $T_Jun += $D->Jun;
                        $T_Jul += $D->Jul;
                        $T_Ago += $D->Ago;
                        $T_Sep += $D->Sep;
                        $T_Oct += $D->Oct;
                        $T_Nov += $D->Nov;
                        $T_Dic += $D->Dic;

                        $P_Ene += $D->Ene * $D->PEne;
                        $P_Feb += $D->Feb * $D->PFeb;
                        $P_Mar += $D->Mar * $D->PMar;
                        $P_Abr += $D->Abr * $D->PAbr;
                        $P_May += $D->May * $D->PMay;
                        $P_Jun += $D->Jun * $D->PJun;
                        $P_Jul += $D->Jul * $D->PJul;
                        $P_Ago += $D->Ago * $D->PAgo;
                        $P_Sep += $D->Sep * $D->PSep;
                        $P_Oct += $D->Oct * $D->POct;
                        $P_Nov += $D->Nov * $D->PNov;
                        $P_Dic += $D->Dic * $D->PNov;
                    }
                }
                //Totales Cantidades por grupos

                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->SetX(5);
                $pdf->Cell(53, 4, 'Existencias por Grupo:', 0/* BORDE */, 0, 'R');

                $pdf->SetX(58);
                $pdf->Cell(18, 4, ($T_Ene <> 0) ? number_format($T_Ene, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Feb <> 0) ? number_format($T_Feb, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Mar <> 0) ? number_format($T_Mar, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Abr <> 0) ? number_format($T_Abr, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_May <> 0) ? number_format($T_May, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Jun <> 0) ? number_format($T_Jun, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Jul <> 0) ? number_format($T_Jul, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Ago <> 0) ? number_format($T_Ago, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Sep <> 0) ? number_format($T_Sep, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Oct <> 0) ? number_format($T_Oct, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Nov <> 0) ? number_format($T_Nov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($T_Dic <> 0) ? number_format($T_Dic, 2, ".", ",") : '', 0/* BORDE */, 1, 'R');

                //Totales Valor Inventario en Pesos por grupos
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->Cell(53, 4, 'Totales en pesos por Grupo: $', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX(58);
                $pdf->Cell(18, 4, ($P_Ene <> 0) ? number_format($P_Ene, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Feb <> 0) ? number_format($P_Feb, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Mar <> 0) ? number_format($P_Mar, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Abr <> 0) ? number_format($P_Abr, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_May <> 0) ? number_format($P_May, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Jun <> 0) ? number_format($P_Jun, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Jul <> 0) ? number_format($P_Jul, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Ago <> 0) ? number_format($P_Ago, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Sep <> 0) ? number_format($P_Sep, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Oct <> 0) ? number_format($P_Oct, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Nov <> 0) ? number_format($P_Nov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->getX());
                $pdf->Cell(18, 4, ($P_Dic <> 0) ? number_format($P_Dic, 2, ".", ",") : '', 'B'/* BORDE */, 1, 'R');
            }
            //Totales Cantidades generales

            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetX(5);
            $pdf->Cell(53, 4, 'Existencia general:', 0/* BORDE */, 0, 'R');

            $pdf->SetX(58);
            $pdf->Cell(18, 4, ($GT_Ene <> 0) ? number_format($GT_Ene, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Feb <> 0) ? number_format($GT_Feb, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Mar <> 0) ? number_format($GT_Mar, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Abr <> 0) ? number_format($GT_Abr, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_May <> 0) ? number_format($GT_May, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Jun <> 0) ? number_format($GT_Jun, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Jul <> 0) ? number_format($GT_Jul, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Ago <> 0) ? number_format($GT_Ago, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Sep <> 0) ? number_format($GT_Sep, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Oct <> 0) ? number_format($GT_Oct, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Nov <> 0) ? number_format($GT_Nov, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GT_Dic <> 0) ? number_format($GT_Dic, 2, ".", ",") : '', 0/* BORDE */, 1, 'R');

            //Totales Valor Inventario en Pesos por grupos
            $pdf->SetLineWidth(0.5);
            $pdf->SetX(5);
            $pdf->Cell(53, 4, 'Total General en Pesos $', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX(58);
            $pdf->Cell(18, 4, ($GP_Ene <> 0) ? number_format($GP_Ene, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Feb <> 0) ? number_format($GP_Feb, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Mar <> 0) ? number_format($GP_Mar, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Abr <> 0) ? number_format($GP_Abr, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_May <> 0) ? number_format($GP_May, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Jun <> 0) ? number_format($GP_Jun, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Jul <> 0) ? number_format($GP_Jul, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Ago <> 0) ? number_format($GP_Ago, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Sep <> 0) ? number_format($GP_Sep, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Oct <> 0) ? number_format($GP_Oct, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Nov <> 0) ? number_format($GP_Nov, 2, ".", ",") : '', 'B'/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->getX());
            $pdf->Cell(18, 4, ($GP_Dic <> 0) ? number_format($GP_Dic, 2, ".", ",") : '', 'B'/* BORDE */, 1, 'R');

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE EXISTENCIA ANUAL POR MES " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteEtiquetas() {
        $Grupo = $this->input->post('Grupo');
        $aGrupo = $this->input->post('aGrupo');
        $Mes = Date('n');
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
        $Texto_DiaFinMes = '';
        switch ($Mes_Anterior) {
            case 0:
                $Texto_DiaFinMes = '31 Dic';

                break;
            case 1:
                $Texto_DiaFinMes = '31 Ene';

                break;
            case 2:
                $Texto_DiaFinMes = '28 Feb';

                break;
            case 3:
                $Texto_DiaFinMes = '31 Mar';

                break;
            case 4:
                $Texto_DiaFinMes = '30 Abr';

                break;
            case 5:
                $Texto_DiaFinMes = '31 May';

                break;
            case 6:
                $Texto_DiaFinMes = '30 Jun';

                break;
            case 7:
                $Texto_DiaFinMes = '31 Jul';

                break;
            case 8:
                $Texto_DiaFinMes = '31 Ago';

                break;
            case 9:
                $Texto_DiaFinMes = '30 Sep';

                break;
            case 10:
                $Texto_DiaFinMes = '31 Oct';

                break;
            case 11:
                $Texto_DiaFinMes = '30 Nov';

                break;
            case 12:
                $Texto_DiaFinMes = '31 Dic';

                break;
        }

        $Articulos = $this->ReporteCapturaFisica_model->getArticulosPorGruposParaEtiquetas($Grupo, $aGrupo, $Texto_Mes_Anterior);

        if (!empty($Articulos)) {
            $pdf = new PDF_Etiquetas('L', 'mm', array(50, 100));
            $pdf->SetAutoPageBreak(false, 2);

            foreach ($Articulos as $key => $G) {
                $pdf->AddPage();
                $pdf->SetY(6);
                $pdf->SetX(23);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(10, 4, 'Grupo:', 0/* BORDE */, 0, 'L');
                $pdf->SetX(33);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(40, 4, utf8_decode($G->ClaveGrupo) . '  ' . utf8_decode($G->NombreGrupo), 0/* BORDE */, 0, 'L');
                $pdf->SetY(12);
                $pdf->SetX(3);
                $pdf->SetFont('Calibri', 'B', 12);
                $pdf->Cell(40, 4, utf8_decode($G->Clave) . '  ' . mb_strimwidth(utf8_decode($G->Descripcion), 0, 27, ""), 0/* BORDE */, 0, 'L');
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(74);
                $pdf->Cell(23, 4, '', 1/* BORDE */, 0, 'L');

                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->SetY(44);
                $pdf->SetX(3);
                $pdf->Cell(23, 4, 'Inv. al ' . $Texto_DiaFinMes, 0/* BORDE */, 0, 'L');

                $pdf->SetFont('Calibri', 'B', 12);
                $pdf->SetY(44);
                $pdf->SetX(60);
                $pdf->Cell(15, 4, number_format($G->Existencia, 2, ".", ","), 0/* BORDE */, 0, 'L');

                $pdf->SetY(44);
                $pdf->SetX(80);
                $pdf->Cell(14, 4, $G->Unidad, 0/* BORDE */, 0, 'L');
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE ETIQUETAS INVENTARIO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteCostoInv() {
        $Maq = $this->input->post('Maq');
        $Mes = $this->input->post('Mes');

        $Grupos = $this->ReporteCapturaFisica_model->getGruposReporteCosto($Maq);
        $Articulos = $this->ReporteCapturaFisica_model->getDetalleReporteCosto($Maq, $Mes);
        if (!empty($Grupos)) {
            $pdf = new PDF_CostoInv('P', 'mm', array(215.9, 279.4));
            $pdf->setMes($Mes);
            $pdf->SetAutoPageBreak(true, 5);
            $pdf->AddPage();

            $GT_Existencia = 0;
            $GT_Costo = 0;

            foreach ($Grupos as $key => $G) {

                $pdf->SetX(5);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(10, 4, 'Grupo:', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(15);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(40, 4, utf8_decode($G->Clave) . '  ' . utf8_decode($G->Nombre), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', '', 8);
                $T_Existencia = 0;
                $T_Costo = 0;

                foreach ($Articulos as $keyA => $D) {

                    if ($D->ClaveGrupo === $G->Clave) {

                        $Total_Costo = $D->Existencia * $D->Costo;
                        $pdf->Row(array(
                            utf8_decode($D->ClaveArt),
                            mb_strimwidth(utf8_decode($D->Articulo), 0, 60, ""),
                            utf8_decode($D->Unidad),
                            '$' . number_format($D->Costo, 2, ".", ","),
                            number_format($D->Existencia, 2, ".", ","),
                            '$' . number_format($Total_Costo, 2, ".", ",")
                                ), 'B');

                        $T_Existencia += $D->Existencia;
                        $T_Costo += $D->Existencia * $D->Costo;

                        $GT_Existencia += $D->Existencia;
                        $GT_Costo += $D->Existencia * $D->Costo;
                    }
                }
                $pdf->SetX(85);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(25, 4, 'Total costeo por Grupo:', 0/* BORDE */, 0, 'L');

                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '',
                    number_format($T_Existencia, 2, ".", ","),
                    '$' . number_format($T_Costo, 2, ".", ",")
                        ), 0);
            }

            $pdf->SetX(85);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(25, 4, 'Total costeo general:', 0/* BORDE */, 0, 'L');

            $pdf->Row(array(
                '',
                '',
                '',
                '',
                number_format($GT_Existencia, 2, ".", ","),
                '$' . number_format($GT_Costo, 2, ".", ",")
                    ), 0);

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE DE COSTO DEL INVENTARIO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteMovAjuste() {
        $Maq = $this->input->post('Maq');
        $Mes = $this->input->post('Mes');
        $Ano = $this->input->post('Ano');

        $Grupos = $this->ReporteCapturaFisica_model->getGruposMovimientosAjuste($Maq, $Mes, $Ano);
        $Articulos = $this->ReporteCapturaFisica_model->getDetalleMovimientosAjuste($Maq, $Mes, $Ano);
        if (!empty($Grupos)) {
            $pdf = new PDF_Ajustes('P', 'mm', array(215.9, 279.4));
            $pdf->setMes($Mes);
            $pdf->setAno($Ano);
            $pdf->SetAutoPageBreak(true, 5);
            $pdf->AddPage();

            $GT_Entradas = 0;
            $GT_Salidas = 0;
            $GT_TEntradas = 0;
            $GT_TSalidas = 0;
            foreach ($Grupos as $key => $G) {

                $pdf->SetX(5);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(15, 4, 'Grupo:', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(40, 4, utf8_decode($G->Clave) . '    ' . utf8_decode($G->Nombre), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', '', 8);
                $T_Entradas = 0;
                $T_Salidas = 0;
                $T_TEntradas = 0;
                $T_TSalidas = 0;
                $Total_Entradas = 0;
                $Total_Salidas = 0;

                foreach ($Articulos as $keyA => $D) {

                    if ($D->ClaveGrupo === $G->Clave) {

                        $Total_Entradas = ($D->Entradas * $D->PrecioMov <> 0) ? '$' . number_format($D->Entradas * $D->PrecioMov, 2, ".", ",") : '';
                        $Total_Salidas = ($D->Salidas * $D->PrecioMov <> 0) ? '$' . number_format($D->Salidas * $D->PrecioMov, 2, ".", ",") : '';
                        $pdf->Row(array(
                            utf8_decode($D->ClaveArt),
                            mb_strimwidth(utf8_decode($D->Articulo), 0, 50, ""),
                            utf8_decode($D->Unidad),
                            utf8_decode($D->FechaMov),
                            utf8_decode($D->TipoMov),
                            ($D->Entradas <> 0) ? number_format($D->Entradas, 2, ".", ",") : '',
                            ($D->Salidas <> 0) ? number_format($D->Salidas, 2, ".", ",") : '',
                            '$' . number_format($D->PrecioMov, 2, ".", ","),
                            $Total_Entradas,
                            $Total_Salidas,
                            utf8_decode($D->Sem),
                            utf8_decode($D->Maq)
                                ), 'B');

                        $T_Entradas += $D->Entradas;
                        $T_Salidas += $D->Salidas;
                        $T_TEntradas += $D->Entradas * $D->PrecioMov;
                        $T_TSalidas += $D->Salidas * $D->PrecioMov;

                        $GT_Entradas += $D->Entradas;
                        $GT_Salidas += $D->Salidas;
                        $GT_TEntradas += $D->Entradas * $D->PrecioMov;
                        $GT_TSalidas += $D->Salidas * $D->PrecioMov;
                    }
                }

                $pdf->SetX(40);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(25, 4, 'Total por Grupo:', 0/* BORDE */, 0, 'L');
                $pdf->SetX(65);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(40, 4, utf8_decode($G->Clave) . ' ' . utf8_decode($G->Nombre), 0/* BORDE */, 0, 'L');

                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Row(array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    number_format($T_Entradas, 2, ".", ","),
                    number_format($T_Salidas, 2, ".", ","),
                    '',
                    '$' . number_format($T_TEntradas, 2, ".", ","),
                    '$' . number_format($T_TSalidas, 2, ".", ","),
                    '',
                    ''
                        ), 0);
            }

            $pdf->SetX(40);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(25, 4, 'Total general:', 0/* BORDE */, 0, 'L');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Row(array(
                '',
                '',
                '',
                '',
                '',
                number_format($GT_Entradas, 2, ".", ","),
                number_format($GT_Salidas, 2, ".", ","),
                '',
                '$' . number_format($GT_TEntradas, 2, ".", ","),
                '$' . number_format($GT_TSalidas, 2, ".", ","),
                '',
                ''
                    ), 0);

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE MOVIMIENTOS DE AJUSTE AL INVENTARIO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteComparativoInvFisInvSis() {
        $Tipo = $this->input->post('Tipo');
        $Mes = $this->input->post('Mes');
        $Maq = $this->input->post('Maq');
        $Ano = $this->input->post('Ano');
        $Alm = $this->input->post('Almacen');
        $Texto_Mes = '';
        $Texto_Mes_Anterior = '';
        $Mes_Anterior = intval($Mes - 1);

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
        switch ($Mes) {
            case '1':
                $Texto_Mes = 'Ene';

                break;
            case '2':
                $Texto_Mes = 'Feb';

                break;
            case '3':
                $Texto_Mes = 'Mar';

                break;
            case '4':
                $Texto_Mes = 'Abr';

                break;
            case '5':
                $Texto_Mes = 'May';

                break;
            case '6':
                $Texto_Mes = 'Jun';

                break;
            case '7':
                $Texto_Mes = 'Jul';

                break;
            case '8':
                $Texto_Mes = 'Ago';

                break;
            case '9':
                $Texto_Mes = 'Sep';

                break;
            case '10':
                $Texto_Mes = 'Oct';

                break;
            case '11':
                $Texto_Mes = 'Nov';

                break;
            case '12':
                $Texto_Mes = 'Dic';

                break;
        }

        $Grupos = $this->ReporteCapturaFisica_model->getGruposReporteComparativo($Tipo, $Mes, $Maq, $Ano, $Texto_Mes);

        $Detalle = $this->ReporteCapturaFisica_model->getDetalleReporteComparativo($Tipo, $Mes, $Maq, $Ano, $Texto_Mes, $Texto_Mes_Anterior);


        if (!empty($Grupos)) {
            $pdf = new PDF_ComparativoInv('L', 'mm', array(215.9, 279.4));

            $pdf->setMes($Mes);
            $pdf->setMaq($Alm);

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $GTot_Mes_Ant = 0;
            $GTot_Entradas = 0;
            $GTot_Salidas = 0;
            $GTot_Actual = 0;
            $GTot_Fisico = 0;
            $GTot_Diferencia = 0;
            $GTot_Act_Pre = 0;
            $GTot_Fis_Pre = 0;
            $GTot_Dif_Pre = 0;


            foreach ($Grupos as $key => $G) {
                $Departamento_bd = ($Tipo === '0') ? '0' : $G->Departamento;


                if ($Departamento_bd === $Tipo) {

                    $pdf->SetLineWidth(0.5);
                    $pdf->SetX(5);
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->Cell(15, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                    $pdf->SetX(20);
                    $pdf->SetFont('Calibri', '', 7.5);
                    $pdf->Cell(50, 4, utf8_decode($G->Clave . ' ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');

                    $Tot_Mes_Ant = 0;
                    $Tot_Entradas = 0;
                    $Tot_Salidas = 0;
                    $Tot_Actual = 0;
                    $Tot_Fisico = 0;
                    $Tot_Diferencia = 0;
                    $Tot_Act_Pre = 0;
                    $Tot_Fis_Pre = 0;
                    $Tot_Dif_Pre = 0;

                    foreach ($Detalle as $key => $D) {

                        if ($G->Clave === $D->ClaveGrupo) {

                            $Actual = $D->MesAnterior + $D->Entradas - $D->Salidas;
                            $Diferencia = $Actual - $D->MesActual;
                            $Pre_Actual = $Actual * $D->Precio;
                            $Pre_Fisico = $D->MesActual * $D->Precio;
                            $Pre_Difer = ($Pre_Actual) - ($Pre_Fisico);

                            $pdf->SetLineWidth(0.2);
                            $pdf->SetTextColor(0, 0, 0);
                            $pdf->SetY($pdf->GetY());
                            $pdf->SetX(8);
                            $pdf->Cell(11, 4, utf8_decode($D->Codigo), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(61, 4, mb_strimwidth(utf8_decode($D->Articulo), 0, 53, ""), 'B'/* BORDE */, 0, 'L');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(15, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, ($D->MesAnterior <> 0) ? number_format($D->MesAnterior, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, ($D->Entradas <> 0) ? number_format($D->Entradas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, ($D->Salidas <> 0) ? number_format($D->Salidas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, ($Actual <> 0) ? number_format($Actual, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(13, 4, utf8_decode($D->Codigo), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, ($D->MesActual <> 0) ? number_format($D->MesActual, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->SetFont('Calibri', 'B', 7.5);
                            $pdf->SetTextColor(197, 43, 9);
                            $pdf->Cell(16, 4, ($Diferencia <> 0) ? number_format($Diferencia, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->SetFont('Calibri', '', 7.5);
                            $pdf->SetTextColor(0, 0, 0);
                            $pdf->Cell(12, 4, '$' . number_format($D->Precio, 2, ".", ","), 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(19, 4, ($Pre_Actual <> 0) ? '$' . number_format($Pre_Actual, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(19, 4, ($Pre_Fisico <> 0) ? '$' . number_format($Pre_Fisico, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->SetFont('Calibri', 'B', 7.5);
                            $pdf->SetTextColor(197, 43, 9);
                            $pdf->Cell(19, 4, ($Pre_Difer <> 0) ? '$' . number_format($Pre_Difer, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                            $pdf->SetY($pdf->GetY() + 4);
                            $pdf->SetFont('Calibri', '', 7.5);
                            $pdf->SetTextColor(0, 0, 0);

                            $Tot_Mes_Ant += $D->MesAnterior;
                            $Tot_Entradas += $D->Entradas;
                            $Tot_Salidas += $D->Salidas;
                            $Tot_Actual += $Actual;
                            $Tot_Fisico += $D->MesActual;
                            $Tot_Diferencia += $Diferencia;
                            $Tot_Act_Pre += $Pre_Actual;
                            $Tot_Fis_Pre += $Pre_Fisico;
                            $Tot_Dif_Pre += $Pre_Difer;
//Gran totales
                            $GTot_Mes_Ant += $D->MesAnterior;
                            $GTot_Entradas += $D->Entradas;
                            $GTot_Salidas += $D->Salidas;
                            $GTot_Actual += $Actual;
                            $GTot_Fisico += $D->MesActual;
                            $GTot_Diferencia += $Diferencia;
                            $GTot_Act_Pre += $Pre_Actual;
                            $GTot_Fis_Pre += $Pre_Fisico;
                            $GTot_Dif_Pre += $Pre_Difer;
                        }
                    }
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetY($pdf->GetY());
                    $pdf->SetX(8);
                    $pdf->Cell(25, 4, 'Total por Grupo: ', 0/* BORDE */, 0, 'L');
                    $pdf->SetX($pdf->GetX());
                    $pdf->SetFont('Calibri', '', 7.5);
                    $pdf->Cell(47, 4, utf8_decode($G->Clave . ' ' . $G->Nombre), 0/* BORDE */, 0, 'L');
                    $pdf->SetX($pdf->GetX());
                    $pdf->SetFont('Calibri', 'B', 7.5);
                    $pdf->Cell(15, 4, '', 0/* BORDE */, 0, 'C');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 4, number_format($Tot_Mes_Ant, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 4, number_format($Tot_Entradas, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 4, number_format($Tot_Salidas, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 4, number_format($Tot_Actual, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(13, 4, '', 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(16, 4, number_format($Tot_Fisico, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->SetTextColor(197, 43, 9);
                    $pdf->Cell(16, 4, number_format($Tot_Diferencia, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(12, 4, '', 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(19, 4, '$' . number_format($Tot_Act_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->Cell(19, 4, '$' . number_format($Tot_Fis_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetX($pdf->GetX());
                    $pdf->SetTextColor(197, 43, 9);
                    $pdf->Cell(19, 4, '$' . number_format($Tot_Dif_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
                    $pdf->SetY($pdf->GetY() + 4);
                    $pdf->SetFont('Calibri', '', 7.5);
                    $pdf->SetTextColor(0, 0, 0);
                }
            }

            $pdf->SetFont('Calibri', 'B', 7.5);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetY($pdf->GetY());
            $pdf->SetX(8);
            $pdf->Cell(25, 4, '', 0/* BORDE */, 0, 'L');
            $pdf->SetX($pdf->GetX());
            $pdf->SetFont('Calibri', 'B', 7.5);
            $pdf->Cell(47, 4, 'Total general:', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 4, '', 0/* BORDE */, 0, 'C');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 4, number_format($GTot_Mes_Ant, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 4, number_format($GTot_Entradas, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 4, number_format($GTot_Salidas, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 4, number_format($GTot_Actual, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(13, 4, '', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 4, number_format($GTot_Fisico, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->SetTextColor(197, 43, 9);
            $pdf->Cell(16, 4, number_format($GTot_Diferencia, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(12, 4, '', 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 4, '$' . number_format($GTot_Act_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 4, '$' . number_format($GTot_Fis_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->SetTextColor(197, 43, 9);
            $pdf->Cell(19, 4, '$' . number_format($GTot_Dif_Pre, 2, ".", ","), 0/* BORDE */, 0, 'R');
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetFont('Calibri', '', 7.5);
            $pdf->SetTextColor(0, 0, 0);


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE COMPARACION INVENTARIO FIS_SIS " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteConteoCapturaFisica() {
        $Grupos = $this->ReporteCapturaFisica_model->getGrupos();
        $Articulos = $this->ReporteCapturaFisica_model->getArticulos();
        if (!empty($Grupos)) {
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));


            $pdf->SetAutoPageBreak(true, 5);

            foreach ($Grupos as $key => $D) {
                $pdf->AddPage();
                $pdf->SetY(24);
                $pdf->SetX(5);
                $pdf->SetLineWidth(0.5);
                $pdf->SetFont('Calibri', 'B', 7.5);
                $pdf->Cell(15, 4, 'Grupo:', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 7.5);
                $pdf->Cell(40, 4, utf8_decode($D->Clave) . '    ' . utf8_decode($D->Nombre), 'B'/* BORDE */, 1, 'L');

                $Cont = 0;
                $COL = 1;
                $valida1 = true;
                $valida2 = true;
                $valida3 = true;
                $valida4 = true;
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', 'B', 5.5);
                foreach ($Articulos as $keyA => $F) {

                    if ($F->Grupo === $D->Clave) {

                        if ($Cont > 81) {
                            $COL = 2;
                        } if ($Cont > 163) {
                            $COL = 3;
                        } if ($Cont > 245) {
                            $COL = 4;
                        }if ($Cont > 327) {
                            $COL = 1;
                            $valida1 = true;
                            $valida2 = true;
                            $valida3 = true;
                            $valida4 = true;
                            $Cont = 0;
                        }
                        switch ($COL) {
                            case 1:
                                $pdf->SetX(5);
                                $pdf->Cell(6, 3, $F->Clave, 'B'/* BORDE */, 0, 'R');
                                $pdf->SetX(11);
                                $pdf->Cell(32, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 29, ""), 'B'/* BORDE */, 0, 'L');
                                $pdf->SetX(43);
                                $pdf->Cell(13, 3, utf8_decode($F->Unidad), 'BR'/* BORDE */, 1, 'L');

                                break;
                            case 2:
                                if ($valida2) {
                                    $pdf->SetY(28);
                                }
                                $pdf->SetX(56);
                                $pdf->Cell(6, 3, $F->Clave, 'B'/* BORDE */, 0, 'R');
                                $pdf->SetX(62);
                                $pdf->Cell(32, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 29, ""), 'B'/* BORDE */, 0, 'L');
                                $pdf->SetX(94);
                                $pdf->Cell(13, 3, utf8_decode($F->Unidad), 'BR'/* BORDE */, 1, 'L');
                                $pdf->SetY($pdf->GetY());
                                $valida2 = false;
                                break;
                            case 3:
                                if ($valida3) {
                                    $pdf->SetY(28);
                                }
                                $pdf->SetX(107);
                                $pdf->Cell(6, 3, $F->Clave, 'B'/* BORDE */, 0, 'R');
                                $pdf->SetX(113);
                                $pdf->Cell(32, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 29, ""), 'B'/* BORDE */, 0, 'L');
                                $pdf->SetX(145);
                                $pdf->Cell(13, 3, utf8_decode($F->Unidad), 'BR'/* BORDE */, 1, 'L');
                                $pdf->SetY($pdf->GetY());
                                $valida3 = false;
                                break;
                            case 4:
                                if ($valida4) {
                                    $pdf->SetY(28);
                                }
                                $pdf->SetX(158);
                                $pdf->Cell(6, 3, $F->Clave, 'B'/* BORDE */, 0, 'R');
                                $pdf->SetX(164);
                                $pdf->Cell(32, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 29, ""), 'B'/* BORDE */, 0, 'L');
                                $pdf->SetX(196);
                                $pdf->Cell(13, 3, utf8_decode($F->Unidad), 'BR'/* BORDE */, 1, 'L');
                                $pdf->SetY($pdf->GetY());
                                $valida4 = false;
                                break;
                        }

                        $Cont ++;
                    }
                }
            }
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE PARA CAPTURA FISICA INVENTARIO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
