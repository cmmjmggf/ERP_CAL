<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ExplosionesPorArticulo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ExplosionesPorArticulo_model')
                ->helper('Explosiones_helper')->helper('file');
    }

    public function onReporteExplosionSemanaSuelaArticulo() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');
        $Articulo = $this->input->post('Articulo');

        $cm = $this->ExplosionesPorArticulo_model;
        $DatosEmpresa = $cm->getDatosEmpresa();


        $Explosion = $cm->getExplosionMaterialesTallas(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Articulo
        );


        if (!empty($Explosion)) {

            $pdf = new PDFExpTallas('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;



            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->Pares = '';
            $pdf->Tipo = '******* SUELA *******';
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);



//                $pdf->SetFont('Calibri', 'B', 8);
//                $pdf->SetX(5);
//                $pdf->Cell(20, 5, 'Grupo: ', 0/* BORDE */, 0, 'L');
//                $pdf->SetX(25);
//                $pdf->SetFont('Calibri', '', 9);
//                $pdf->Cell(50, 5, utf8_decode($G->Clave . '     ' . $G->Nombre), 0/* BORDE */, 1, 'L');


            $TOTAL_EXP_ART = 0;
            $TOTAL_SUBT_ART = 0;

            foreach ($Explosion as $key => $D) {


                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);



                $ExplosionCant = ($D->Consumo * $D->Pares);
                $Subtotal = $ExplosionCant * $D->Precio;

                $Exp_Acum = $D->C1;
                $Talla = $D->T1;


                for ($i = 1; $i < 22; $i++) {
                    $sig = $i + 1;
                    if ($D->{"A$i"} === $D->{"A$sig"}) {
                        $Exp_Acum += $D->{"C$sig"};
                    } else if ($D->{"A$sig"} === '0') {
                        $Exp_Acum += $D->{"C$sig"};
                        if ($Exp_Acum > 0) {
                            $pdf->Row(array(
                                utf8_decode($D->Articulo),
                                mb_strimwidth(utf8_decode($D->Descripcion), 0, 35, ""),
                                utf8_decode($D->Unidad),
                                $Talla,
                                number_format($Exp_Acum, 2, ".", ","),
                                '$' . number_format($D->Precio, 2, ".", ","),
                                '$' . number_format($Exp_Acum * $D->Precio, 2, ".", ","),
                                '',
                                '',
                                ''
                            ));
                        }
                    } else {
                        if ($Exp_Acum > 0) {
                            $pdf->Row(array(
                                utf8_decode($D->Articulo),
                                mb_strimwidth(utf8_decode($D->Descripcion), 0, 35, ""),
                                utf8_decode($D->Unidad),
                                $Talla,
                                number_format($Exp_Acum, 2, ".", ","),
                                '$' . number_format($D->Precio, 2, ".", ","),
                                '$' . number_format($Exp_Acum * $D->Precio, 2, ".", ","),
                                '',
                                '',
                                ''
                            ));
                        }
                        $Talla = $D->{"T$sig"};
                        $Exp_Acum = $D->{"C$sig"};
                    }
                }

                $TOTAL_EXP_ART += $ExplosionCant;
                $TOTAL_SUBT_ART += $Subtotal;
            }
            if ($TOTAL_EXP_ART > 0 && $TOTAL_SUBT_ART > 0) {
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(58);
                $pdf->Cell(40, 4, 'Total por Articulo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(98);
                $pdf->Cell(14, 4, number_format($TOTAL_EXP_ART, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(112);
                $pdf->Cell(15, 4, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(127);
                $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT_ART, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
                $pdf->SetX(150);
            }





            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES POR ARTICULO DESGLOSE TALLAS" . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteExplosionSemanaPorArticulo() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $Articulo = $this->input->post('Articulo');


        $cm = $this->ExplosionesPorArticulo_model;
        $DatosEmpresa = $cm->getDatosEmpresa();

        $Explosion = $cm->getExplosionMateriales(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo, $Articulo
        );


        if (!empty($Explosion)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;


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

            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->Pares = '';
            $pdf->Tipo = $TipoE;
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $TOTAL_EXP_ART = 0;
            $TOTAL_SUBT_ART = 0;
            foreach ($Explosion as $key => $D) {
                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', '', 8);

                switch ($Tipo) {
                    case '10':
                        $ExplosionCant = ($D->Consumo * $D->Pares) * ($D->Desperdicio + 1);
                        break;
                    case '80':
                        $ExplosionCant = ($D->Consumo * $D->Pares);
                        break;
                    case '90':
                        $ExplosionCant = ($D->Consumo * $D->Pares);
                        break;
                }

                $Subtotal = $ExplosionCant * $D->Precio;
                $pdf->Row(array(
                    utf8_decode($D->Articulo),
                    mb_strimwidth(utf8_decode($D->Descripcion), 0, 40, ""),
                    utf8_decode($D->Clasificacion),
                    utf8_decode($D->Unidad),
                    number_format($ExplosionCant, 2, ".", ","),
                    '$' . number_format($D->Precio, 2, ".", ","),
                    '$' . number_format($Subtotal, 2, ".", ","),
                    '',
                    '',
                    '',
                ));
                $TOTAL_EXP_ART += $ExplosionCant;
                $TOTAL_SUBT_ART += $Subtotal;
            }

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(59);
            $pdf->Cell(40, 4, 'Total por Articulo: ', 'B'/* BORDE */, 0, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(99);
            $pdf->Cell(14, 4, number_format($TOTAL_EXP_ART, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(113);
            $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(130);
            $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT_ART, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
            $pdf->SetX(150);




            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES POR ARTICULO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
