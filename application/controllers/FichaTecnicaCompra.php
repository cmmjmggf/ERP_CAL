<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class FichaTecnicaCompra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('FichaTecnicaCompra_model')
                ->helper('ReportesFichaTecnica_helper')->helper('file')->helper('array');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onImprimirFichaTecnicaSinPrecios() {
        $cm = $this->FichaTecnicaCompra_model;

        $DatosEmpresa = $cm->getDatosEmpresa();
        $Encabezado = $cm->getEncabezadoFT($this->input->post('Estilo'), $this->input->post('Color'));
        $Grupos = $cm->getGruposFT($this->input->post('Estilo'), $this->input->post('Color'));
        $Departamentos = $cm->getDeptosFT($this->input->post('Estilo'), $this->input->post('Color'));
        $FichaTecnica = $cm->getFichaTecnicaDetalleByID($this->input->post('Estilo'), $this->input->post('Color'), $this->input->post('Maquila'), $this->input->post('Desperdicio'));


        if (!empty($Encabezado)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Estilo = $Encabezado[0]->ESTILO;
            $pdf->Clinea = $Encabezado[0]->CLINEA;
            $pdf->Dlinea = $Encabezado[0]->DLINEA;
            $pdf->Ccolor = $Encabezado[0]->CCOLOR;
            $pdf->Dcolor = $Encabezado[0]->DCOLOR;
            $pdf->Maquila = $this->input->post('NomMaquila');
            $pdf->desperdicio = $this->input->post('Desperdicio') * 100;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 25);


            $TOTAL_CONSUMO_GEN = 0;
            foreach ($Departamentos as $key => $D) {
                $TOTAL_CONSUMO_DEPTOS = 0;
                foreach ($Grupos as $key => $G) {

                    if ($G->CDEPTO === $D->CDEPTO) {
                        $TOTAL_CONSUMO_GPOS = 0;

                        foreach ($FichaTecnica as $keyFT => $F) {

                            if ($F->CDEPTO === $D->CDEPTO && $F->CGRUPO === $G->CGRUPO) {
                                $pdf->SetLineWidth(0.25);
                                $pdf->SetX(5);
                                $pdf->SetFont('Calibri', 'B', 8);
                                $anchos = array(8/* cpie */, 39.5/* pie */, 9.5/* c art */, 64/* d art */, 12/* un */, 15/* pre */, 14/* 6 */, 18/* 7 */, 16/* 8 */, 9/* 9 */);
                                $aligns = array('R', 'L', 'R', 'L', 'L', 'L', 'L', 'L', 'L', 'R');
                                $pdf->SetAligns($aligns);
                                $pdf->SetWidths($anchos);

                                $pdf->Row(array(
                                    utf8_decode($F->CPIEZA),
                                    utf8_decode($F->DPIEZA),
                                    utf8_decode($F->CMATERIAL),
                                    mb_strimwidth(utf8_decode($F->DMATERIAL), 0, 45, "..."),
                                    utf8_decode($F->UNIDAD),
                                    '',
                                    number_format($F->CONSUMO, 3, ".", ","),
                                    '',
                                    '',
                                    '',
                                ));
                                //TOTALES GRUPOS
                                $TOTAL_CONSUMO_GPOS += $F->CONSUMO;

                                //TOTALES DEPTOS
                                $TOTAL_CONSUMO_DEPTOS += $F->CONSUMO;

                                //TOTALES GENERALES
                                $TOTAL_CONSUMO_GEN += $F->CONSUMO;
                            }
                        }

                        /* TOTALES POR GRUPOS */
                        $pdf->SetFont('Calibri', 'B', 8);
                        $anchos = array(7.5/* cpie */, 30/* pie */, 56/* c art */, 44.5/* d art */, 10/* un */, 0/* pre */, 14/* 6 */, 18/* 7 */, 15/* 8 */, 10/* 9 */);
                        $aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'R');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetMarginLeft(5);
                        $pdf->RowNoBorder(array(
                            '',
                            '',
                            '',
                            'Consumo total de ' . utf8_decode($G->DGRUPO),
                            '',
                            '',
                            number_format($TOTAL_CONSUMO_GPOS, 3, ".", ","),
                            '',
                            '',
                            '',
                        ));
                    }
                }

                /* TOTALES POR DEPARTAMENTOS */
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(75);
                $pdf->SetFont('Calibri', 'BI', 8);
                $pdf->Cell(75, 4, 'Total del Departamento: ' . utf8_decode($D->DDEPTO), 'BTL'/* BORDE */, 0, 'L');
                $pdf->SetX(150);
                $pdf->Cell(14, 4, number_format($TOTAL_CONSUMO_DEPTOS, 3, ".", ","), 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(164);
                $pdf->Cell(14, 4, '', 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(178);
                $pdf->Cell(22, 4, '', 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(200);
                $pdf->Cell(10, 4, '', 'BTR'/* BORDE */, 1, 'R');
            }

            /* TOTALES POR DEPARTAMENTOS */
            $pdf->SetX(75);
            $pdf->SetFont('Calibri', 'BI', 9.5);
            $pdf->Cell(75, 4, 'Total de Materiales del Estilo Color: ', 'BTL'/* BORDE */, 0, 'L');
            $pdf->SetX(150);
            $pdf->Cell(14, 4, number_format($TOTAL_CONSUMO_GEN, 2, ".", ","), 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(164);
            $pdf->Cell(14, 4, '', 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(178);
            $pdf->Cell(22, 4, '', 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(200);
            $pdf->Cell(10, 4, '', 'BTR'/* BORDE */, 1, 'R');



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/FichaTecnica';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "FICHA TECNICA SPRECIO ESTILO " . $this->input->post('Estilo') . ' COLOR ' . $this->input->post('Color') . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/FichaTecnica/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirFichaTecnicaCompra() {
        $cm = $this->FichaTecnicaCompra_model;

        $DatosEmpresa = $cm->getDatosEmpresa();
        $Encabezado = $cm->getEncabezadoFT($this->input->post('Estilo'), $this->input->post('Color'));
        $Grupos = $cm->getGruposFT($this->input->post('Estilo'), $this->input->post('Color'));
        $Departamentos = $cm->getDeptosFT($this->input->post('Estilo'), $this->input->post('Color'));
        $FichaTecnica = $cm->getFichaTecnicaDetalleByID($this->input->post('Estilo'), $this->input->post('Color'), $this->input->post('Maquila'), $this->input->post('Desperdicio'));
        $ManoObra = $cm->getManoObra($this->input->post('Estilo'));
        $ManoObraPOST = ($this->input->post('ManoObra') !== "") ? $this->input->post('ManoObra') : 0;
        $GastosPOST = ($this->input->post('Gastos') !== "") ? $this->input->post('Gastos') : 0;
        $UtilidadPOST = ($this->input->post('Utilidad') !== "") ? $this->input->post('Utilidad') : 0;


        if (!empty($Encabezado)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Estilo = $Encabezado[0]->ESTILO;
            $pdf->Clinea = $Encabezado[0]->CLINEA;
            $pdf->Dlinea = $Encabezado[0]->DLINEA;
            $pdf->Ccolor = $Encabezado[0]->CCOLOR;
            $pdf->Dcolor = $Encabezado[0]->DCOLOR;
            $pdf->Maquila = $this->input->post('NomMaquila');
            $pdf->desperdicio = $this->input->post('Desperdicio') * 100;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 25);


            $TOTAL_CONSUMO_COSTO_GEN = 0;
            $TOTAL_DESPERDICIO_GEN = 0;

            foreach ($Departamentos as $key => $D) {
                $TOTAL_CONSUMO_DEPTOS = 0;
                $TOTAL_COSTO_DEPTOS = 0;
                $TOTAL_CONSUMO_COSTO_DEPTOS = 0;
                $TOTAL_DESPERDICIO_DEPTOS = 0;
                foreach ($Grupos as $key => $G) {

                    if ($G->CDEPTO === $D->CDEPTO) {
                        $TOTAL_CONSUMO_GPOS = 0;
                        $TOTAL_COSTO_GPOS = 0;
                        $TOTAL_CONSUMO_COSTO_GPOS = 0;
                        $TOTAL_DESPERDICIO_GPOS = 0;

                        foreach ($FichaTecnica as $keyFT => $F) {

                            if ($F->CDEPTO === $D->CDEPTO && $F->CGRUPO === $G->CGRUPO) {
                                $pdf->SetLineWidth(0.25);
                                $pdf->SetX(5);
                                $pdf->SetFont('Calibri', 'B', 8);
                                $anchos = array(8/* cpie */, 39.5/* pie */, 9.5/* c art */, 64/* d art */, 12/* un */, 15/* pre */, 14/* 6 */, 18/* 7 */, 16/* 8 */, 9/* 9 */);
                                $aligns = array('R', 'L', 'R', 'L', 'L', 'L', 'L', 'L', 'L', 'R');
                                $pdf->SetAligns($aligns);
                                $pdf->SetWidths($anchos);

                                $pdf->Row(array(
                                    utf8_decode($F->CPIEZA),
                                    utf8_decode($F->DPIEZA),
                                    utf8_decode($F->CMATERIAL),
                                    mb_strimwidth(utf8_decode($F->DMATERIAL), 0, 45, "..."),
                                    utf8_decode($F->UNIDAD),
                                    '$' . number_format($F->PRECIO, 3, ".", ","),
                                    number_format($F->CONSUMO, 3, ".", ","),
                                    number_format($F->COSTO, 3, ".", ","),
                                    number_format($F->CONSUMO_COSTO, 4, ".", ","),
                                    number_format($F->DESPERDICIO, 2, ".", ","),
                                ));
                                //TOTALES GRUPOS
                                $TOTAL_CONSUMO_GPOS += $F->CONSUMO;
                                $TOTAL_COSTO_GPOS += $F->COSTO;
                                $TOTAL_CONSUMO_COSTO_GPOS += $F->CONSUMO_COSTO;
                                $TOTAL_DESPERDICIO_GPOS += $F->DESPERDICIO;

                                //TOTALES DEPTOS
                                $TOTAL_CONSUMO_DEPTOS += $F->CONSUMO;
                                $TOTAL_COSTO_DEPTOS += $F->COSTO;
                                $TOTAL_CONSUMO_COSTO_DEPTOS += $F->CONSUMO_COSTO;
                                $TOTAL_DESPERDICIO_DEPTOS += $F->DESPERDICIO;

                                //TOTALES GENERALES
                                $TOTAL_CONSUMO_COSTO_GEN += $F->COSTO;
                                $TOTAL_DESPERDICIO_GEN += $F->DESPERDICIO;
                            }
                        }

                        /* TOTALES POR GRUPOS */
                        $pdf->SetFont('Calibri', 'B', 8);
                        $anchos = array(7.5/* cpie */, 30/* pie */, 56/* c art */, 44.5/* d art */, 10/* un */, 0/* pre */, 14/* 6 */, 18/* 7 */, 15/* 8 */, 10/* 9 */);
                        $aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'R');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetMarginLeft(5);
                        $pdf->RowNoBorder(array(
                            '',
                            '',
                            '',
                            'Consumo total de ' . utf8_decode($G->DGRUPO),
                            '',
                            '',
                            number_format($TOTAL_CONSUMO_GPOS, 3, ".", ","),
                            number_format($TOTAL_COSTO_GPOS, 3, ".", ","),
                            number_format($TOTAL_CONSUMO_COSTO_GPOS, 4, ".", ","),
                            number_format($TOTAL_DESPERDICIO_GPOS, 2, ".", ","),
                        ));
                    }
                }

                /* TOTALES POR DEPARTAMENTOS */
                $pdf->SetLineWidth(0.5);
                $pdf->SetX(75);
                $pdf->SetFont('Calibri', 'BI', 8);
                $pdf->Cell(75, 4, 'Total del Departamento: ' . utf8_decode($D->DDEPTO), 'BTL'/* BORDE */, 0, 'L');
                $pdf->SetX(150);
                $pdf->Cell(14, 4, number_format($TOTAL_CONSUMO_DEPTOS, 3, ".", ","), 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(164);
                $pdf->Cell(14, 4, number_format($TOTAL_COSTO_DEPTOS, 3, ".", ","), 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(178);
                $pdf->Cell(22, 4, number_format($TOTAL_CONSUMO_COSTO_DEPTOS, 4, ".", ","), 'BT'/* BORDE */, 0, 'C');
                $pdf->SetX(200);
                $pdf->Cell(10, 4, number_format($TOTAL_DESPERDICIO_DEPTOS, 2, ".", ","), 'BTR'/* BORDE */, 1, 'R');
            }

            /* TOTALES POR DEPARTAMENTOS */
            $pdf->SetX(75);
            $pdf->SetFont('Calibri', 'BI', 9.5);
            $pdf->Cell(75, 4, 'Total de Materiales del Estilo Color: ', 'BTL'/* BORDE */, 0, 'L');
            $pdf->SetX(150);
            $pdf->Cell(14, 4, '', 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(164);
            $pdf->Cell(14, 4, '', 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(178);
            $pdf->Cell(22, 4, number_format($TOTAL_CONSUMO_COSTO_GEN, 2, ".", ","), 'BT'/* BORDE */, 0, 'C');
            $pdf->SetX(200);
            $pdf->Cell(10, 4, number_format($TOTAL_DESPERDICIO_GEN, 2, ".", ","), 'BTR'/* BORDE */, 1, 'R');

            /* DATOS FINALES */

            $pdf->SetLineWidth(0.3);
            /* Resumen */
            $TOTAL_MO = 0;
            $Y = $pdf->GetY();
            /* Datos Mano Obra */
            $pdf->SetY($Y + 10);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->Cell(30, 4, 'Mano de Obra', 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 7);
            foreach ($ManoObra as $key => $MO) {
                $pdf->SetX(5);
                $pdf->Cell(50, 4, utf8_decode($MO->CDEPTO . ' ' . $MO->DDEPTO), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(55);
                $pdf->Cell(10, 4, '$' . number_format($MO->COSTOMO, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
                $TOTAL_MO += $MO->COSTOMO;
            }
            $pdf->SetFont('Calibri', 'BI', 8.5);
            $pdf->SetX(5);
            $pdf->Cell(30, 4, 'Total M.O.', ''/* BORDE */, 0, 'L');
            $pdf->SetX(55);
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_MO, 2, ".", ","), ''/* BORDE */, 1, 'R');


            /* Datos Resumen Generales */
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetY($Y + 10);
            $pdf->SetX(70);
            /* Titulo */
            $pdf->Cell(30, 4, 'Datos Maquila', 'B'/* BORDE */, 1, 'L');
            $pdf->SetY($Y + 15);
            $pdf->SetX(70);
            /* total materiales */
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(30, 4, 'MATERIALES', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(100);
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_CONSUMO_COSTO_GEN, 2, ".", ","), 'B'/* BORDE */, 1, 'R');

            $pdf->SetY($Y + 20);
            $pdf->SetX(70);
            $pdf->Cell(30, 4, 'MANO OBRA', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(100);
            $pdf->Cell(10, 4, '$' . number_format($ManoObraPOST, 2, ".", ","), 'B'/* BORDE */, 1, 'R');

            $pdf->SetY($Y + 25);
            $pdf->SetX(70);
            $pdf->Cell(30, 4, 'GASTOS', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(100);
            $pdf->Cell(10, 4, '$' . number_format($GastosPOST, 2, ".", ","), 'B'/* BORDE */, 1, 'R');

            $pdf->SetY($Y + 30);
            $pdf->SetX(70);
            $pdf->Cell(30, 4, 'UTILIDAD', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(100);
            $pdf->Cell(10, 4, '$' . number_format($UtilidadPOST, 2, ".", ","), 'B'/* BORDE */, 1, 'R');

            $TOTAL_CONSUMO_COSTO_GEN = $TOTAL_CONSUMO_COSTO_GEN +
                    $ManoObraPOST +
                    $GastosPOST +
                    $UtilidadPOST;

            $pdf->SetY($Y + 35);
            $pdf->SetX(70);
            $pdf->SetFont('Calibri', 'BI', 8.5);
            $pdf->Cell(30, 4, 'Total', ''/* BORDE */, 0, 'L');
            $pdf->SetX(100);
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_CONSUMO_COSTO_GEN, 2, ".", ","), ''/* BORDE */, 1, 'R');

            /* TOTAL GENERAL */

            /* Datos Resumen Generales */
            $pdf->SetFont('Calibri', 'B', 8.5);
            $pdf->SetY($Y + 10);
            $pdf->SetX(170);
            /* Titulo */
            $pdf->Cell(30, 4, 'Total General', 'B'/* BORDE */, 1, 'L');
            $pdf->SetY($Y + 15);
            $pdf->SetX(170);
            /* total materiales */
            $pdf->SetFont('Calibri', '', 7);
            $pdf->Cell(30, 4, 'MATERIALES', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(200);
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_DESPERDICIO_GEN, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
            $pdf->SetX(170);
            $pdf->Cell(30, 4, 'MANO OBRA', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(200);
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_MO, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
            $pdf->SetX(170);
            $pdf->Cell(30, 4, 'GASTOS', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX(200);
            $pdf->Cell(10, 4, '$' . number_format($GastosPOST, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
            $pdf->SetFont('Calibri', 'BI', 10);
            $pdf->SetX(170);
            $pdf->Cell(30, 4, 'Total', ''/* BORDE */, 0, 'L');
            $pdf->SetX(200);
            $TOTAL_FINAL = $TOTAL_DESPERDICIO_GEN + $TOTAL_MO + $GastosPOST;
            $pdf->Cell(10, 4, '$' . number_format($TOTAL_FINAL, 2, ".", ","), ''/* BORDE */, 1, 'R');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/FichaTecnica';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "FICHA TECNICA ESTILO " . $this->input->post('Estilo') . ' COLOR ' . $this->input->post('Color') . ' ' . date("d-m-Y his");

            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/FichaTecnica/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
