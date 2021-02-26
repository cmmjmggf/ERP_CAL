<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class Explosiones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('Explosiones_model')
                ->helper('Explosiones_helper')->helper('file');
    }

    public function onReporteExplosionSemanaSuelas() {
        /* Borramos el archivo anterior */
        if (delete_files('uploads/Reportes/Explosion/')) {
            /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
        }
        //Mandamos llamar la funcion que explosiona tallas
        $this->onExplosionaSuelas();
        $reportes = array();
        $reportes['1UNO'] = $this->onReporteExplosionSemanaSuela();
        $reportes['2DOS'] = $this->onReporteExplosionSemanaSuelaDesglose();

        print json_encode($reportes);
    }

    //Impresion de reportes
    public function onReporteExplosionSemana() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');
        $SinClasif = $this->input->post('SinClasif');

        $cm = $this->Explosiones_model;
        $Grupos = $cm->getGrupos(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );
        $Pares = $cm->getPares(
                $Ano, $Sem, $aSem, $Maq, $aMaq
        );
        $Materiales = $cm->getMateriales(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );
        $Explosion = $cm->getExplosionMateriales(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo, $SinClasif
        );


        if (!empty($Explosion)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $this->session->LOGO;
            $pdf->Empresa = $this->session->EMPRESA_RAZON;


            switch ($Tipo) {
                case '10':
                    $TipoE = '******* PIEL Y FORRO *******';
                    break;
                case '90':
                    $TipoE = '******* INDIRECTOS *******';
                    break;
            }

            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->Pares = $Pares[0]->Pares;
            $pdf->Tipo = $TipoE;
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $TOTAL_EXP = 0;
            $TOTAL_SUBT = 0;
            foreach ($Grupos as $key => $G) {

                $TOTAL_EXP_GRUPO = 0;
                $TOTAL_SUBT_GRUPO = 0;

                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 5, 'Grupo: ', 0/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 5, utf8_decode($G->Clave . '     ' . $G->Nombre), 0/* BORDE */, 1, 'L');



                foreach ($Materiales as $key => $M) {
                    $TOTAL_EXP_ART = 0;
                    $TOTAL_SUBT_ART = 0;

                    if ($G->Clave === $M->Grupo) {

                        foreach ($Explosion as $key => $D) {

                            if ($G->Clave === $M->Grupo && $D->Articulo === $M->Articulo) {

                                $pdf->SetLineWidth(0.25);
                                $pdf->SetX(5);
                                $pdf->SetFont('Calibri', '', 8);

                                $ExplosionCant = $D->Explosion;
                                $Subtotal = $ExplosionCant * $D->Precio;


                                $pdf->Row(array(
                                    utf8_decode($D->Articulo),
                                    utf8_decode(mb_strimwidth($D->Descripcion, 0, 40, "")),
                                    ($SinClasif === '0' && $Tipo === '10') ? utf8_decode($D->Clasificacion) : '',
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
                                $TOTAL_EXP_GRUPO += $ExplosionCant;
                                $TOTAL_SUBT_GRUPO += $Subtotal;
                                $TOTAL_EXP += $ExplosionCant;
                                $TOTAL_SUBT += $Subtotal;
                            }
                        }

                        switch ($Tipo) {
                            case '10':
                                if ($SinClasif === '0') {
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
                                }
                                break;
                            case '90':
                                break;
                        }
                    }
                }
                $COSTO = $TOTAL_EXP_GRUPO / $Pares[0]->Pares;

                $pdf->SetFont('Calibri', 'B', 8);
                $y = $pdf->GetY();
                $pdf->SetY($y);
                $pdf->SetX(59);
                $pdf->Cell(40, 4, 'Totales por Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(99);
                $pdf->Cell(14, 4, number_format($TOTAL_EXP_GRUPO, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(113);
                $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(130);
                $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT_GRUPO, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(150);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(15, 4, 'Costo:', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(165);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(15, 4, number_format($COSTO, 2, ".", ","), 'B'/* BORDE */, 1, 'L');
            }

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(59);
            $pdf->Cell(40, 4, 'Total por Semana Maquila: ', 'B'/* BORDE */, 0, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(99);
            $pdf->Cell(14, 4, number_format($TOTAL_EXP, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(113);
            $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(130);
            $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT, 2, ".", ","), 'B'/* BORDE */, 0, 'R');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';

            if ($Tipo === '10') {
                /* Borramos el archivo anterior */
                if (delete_files('uploads/Reportes/Explosion/')) {
                    /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
                }
                $pdf->Output($url);
                print base_url() . $url;
            } else {
                $pdf->Output($url);
                return base_url() . $url;
            }
        }
    }

    public function onReporteExplosionSemanaIndirectos() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');
        $SinClasif = $this->input->post('SinClasif');

        $cm = $this->Explosiones_model;
        $Grupos = $cm->getGrupos(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );
        $Pares = $cm->getPares(
                $Ano, $Sem, $aSem, $Maq, $aMaq
        );
        $Explosion = $cm->getExplosionMaterialesIndirectos(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo, $SinClasif
        );


        if (!empty($Explosion)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->Logo = $this->session->LOGO;
            $pdf->Empresa = $this->session->EMPRESA_RAZON;

            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->Pares = $Pares[0]->Pares;
            $pdf->Tipo = '******* INDIRECTOS *******';
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $TOTAL_EXP = 0;
            $TOTAL_SUBT = 0;
            foreach ($Grupos as $key => $G) {

                $TOTAL_EXP_GRUPO = 0;
                $TOTAL_SUBT_GRUPO = 0;

                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 5, 'Grupo: ', 0/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 5, utf8_decode($G->Clave . '     ' . $G->Nombre), 0/* BORDE */, 1, 'L');


                foreach ($Explosion as $key => $D) {

                    if ($G->Clave === $D->Grupo) {

                        $pdf->SetLineWidth(0.25);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', '', 8);
                        $ExplosionCant = $D->Explosion;
                        $Subtotal = $ExplosionCant * $D->Precio;

                        if ($D->Rango === '' || $D->Rango === '0') {//Si no tiene rango imprime normal
                            $pdf->Row(array(
                                utf8_decode($D->Articulo),
                                utf8_decode(mb_strimwidth($D->Descripcion, 0, 40, "")),
                                '',
                                utf8_decode($D->Unidad),
                                number_format($ExplosionCant, 2, ".", ","),
                                '$' . number_format($D->Precio, 2, ".", ","),
                                '$' . number_format($Subtotal, 2, ".", ","),
                                '',
                                '',
                                '',
                            ));
                        } else {//Busca e imprime por tallas
                            $DT = $cm->getExplosionMaterialesIndirectosTallas($Ano, $Sem, $aSem, $Maq, $aMaq, $D->Articulo)[0];

                            //Aqui valida que el siguiente sea el mismo para irlos acumulando
                            //Aqui valida que el siguiente sea el mismo para irlos acumulando
                            $Exp_Acum = $DT->C1;
                            $Talla = floor($DT->T1);

                            for ($i = 1; $i < 22; $i++) {
                                $sig = $i + 1;

                                $TallaIni = ($G->Clave === '50') ? floor($DT->{"T$i"}) : $DT->{"T$i"}; //floor es para quitar los puntos medios
                                $TallaFin = ($G->Clave === '50') ? floor($DT->{"T$sig"}) : $DT->{"T$sig"};

                                if ($TallaIni === $TallaFin) {//Al principio checa si el que sigue es el mismo articulo para irlo acumulando
                                    $Exp_Acum += $DT->{"C$sig"};
                                } else if ($DT->{"T$sig"} === '0') {//Se imprime al final cuando ya no hay más cabeceros
                                    $Exp_Acum += $DT->{"C$sig"};
                                    if ($Exp_Acum > 0) {
                                        $pdf->Row(array(
                                            utf8_decode($DT->Articulo),
                                            utf8_decode(mb_strimwidth($DT->Descripcion, 0, 40, "")),
                                            $Talla,
                                            utf8_decode($DT->Unidad),
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
                                            utf8_decode($DT->Articulo),
                                            utf8_decode(mb_strimwidth($DT->Descripcion, 0, 40, "")),
                                            $Talla,
                                            utf8_decode($DT->Unidad),
                                            number_format($Exp_Acum, 2, ".", ","),
                                            '$' . number_format($D->Precio, 2, ".", ","),
                                            '$' . number_format($Exp_Acum * $D->Precio, 2, ".", ","),
                                            '',
                                            '',
                                            ''
                                        ));
                                    }
                                    $Talla = $TallaFin = ($G->Clave === '50') ? floor($DT->{"T$sig"}) : $DT->{"T$sig"};
                                    $Exp_Acum = $DT->{"C$sig"};
                                }
                            }
                        }


                        $TOTAL_EXP_GRUPO += $ExplosionCant;
                        $TOTAL_SUBT_GRUPO += $Subtotal;
                        $TOTAL_EXP += $ExplosionCant;
                        $TOTAL_SUBT += $Subtotal;
                    }
                }

                $COSTO = $TOTAL_EXP_GRUPO / $Pares[0]->Pares;

                $pdf->SetFont('Calibri', 'B', 8);
                $y = $pdf->GetY();
                $pdf->SetY($y);
                $pdf->SetX(59);
                $pdf->Cell(40, 4, 'Totales por Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(99);
                $pdf->Cell(14, 4, number_format($TOTAL_EXP_GRUPO, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(113);
                $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(130);
                $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT_GRUPO, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX(150);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(15, 4, 'Costo:', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(165);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(15, 4, number_format($COSTO, 2, ".", ","), 'B'/* BORDE */, 1, 'L');
            }

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(59);
            $pdf->Cell(40, 4, 'Total por Semana Maquila: ', 'B'/* BORDE */, 0, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(99);
            $pdf->Cell(14, 4, number_format($TOTAL_EXP, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(113);
            $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX(130);
            $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT, 2, ".", ","), 'B'/* BORDE */, 0, 'R');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteExplosionSemanaSuela() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $cm = $this->Explosiones_model;
        $DatosEmpresa = $cm->getDatosEmpresa();

        $Pares = $cm->getPares(
                $Ano, $Sem, $aSem, $Maq, $aMaq
        );



        $pdf = new PDF('P', 'mm', array(215.9, 279.4));
        $pdf->Logo = $this->session->LOGO;
        $pdf->Empresa = $this->session->EMPRESA_RAZON;


        $TipoE = '******* SUELA *******';

        $pdf->Sem = $Sem;
        $pdf->aSem = $aSem;
        $pdf->Maq = $Maq;
        $pdf->aMaq = $aMaq;
        $pdf->Pares = $Pares[0]->Pares;
        $pdf->Tipo = $TipoE;
        $pdf->TipoE = $Tipo;

        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 5);

        $TOTAL_EXP = 0;
        $TOTAL_SUBT = 0;

        $pdf->SetFont('Calibri', 'B', 8);
        $pdf->SetX(5);
        $pdf->Cell(20, 5, 'Grupo: ', 0/* BORDE */, 0, 'L');
        $pdf->SetX(25);
        $pdf->SetFont('Calibri', '', 8);
        $pdf->Cell(50, 5, utf8_decode('3    SUELA'), 0/* BORDE */, 1, 'L');

        $Materiales = $this->db->query("SELECT
                                    ex.numart,ex.nomart, ex.unidad, sum(ex.cantidad) as cantidad,
                                    pm.precio, sum(ex.cantidad) * pm.precio as subtot
                                    FROM explosiontallastemp ex
                                    join preciosmaquilas pm on pm.articulo = ex.numart and pm.maquila = 1
                                    group by ex.numart order by ex.nomart; ")->result();
        $Pares_Suela = $this->db->query("SELECT sum(ex.cantidad) as pares_suela FROM explosiontallastemp ex  ")->result();

        foreach ($Materiales as $key => $M) {
            $pdf->SetLineWidth(0.25);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $PorcentajeSuelas = '';
            $Porcentaje = ($M->cantidad / $Pares_Suela[0]->pares_suela) * 100;
            $PorcentajeSuelas = number_format($Porcentaje, 2, ".", ",") . '%';

            $pdf->Row(array(
                utf8_decode($M->numart),
                utf8_decode(mb_strimwidth($M->nomart, 0, 40, "")),
                '',
                utf8_decode($M->unidad),
                number_format($M->cantidad, 2, ".", ","),
                '$' . number_format($M->precio, 2, ".", ","),
                '$' . number_format($M->subtot, 2, ".", ","),
                $PorcentajeSuelas,
                '',
                '',
            ));

            $TOTAL_EXP += $M->cantidad;
            $TOTAL_SUBT += $M->subtot;
        }

        $pdf->SetFont('Calibri', 'B', 8);
        $pdf->SetX(59);
        $pdf->Cell(40, 4, 'Total por Semana Maquila: ', 'B'/* BORDE */, 0, 'L');
        $pdf->SetFont('Calibri', '', 8);
        $pdf->SetX(99);
        $pdf->Cell(14, 4, number_format($TOTAL_EXP, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
        $pdf->SetX(113);
        $pdf->Cell(17, 4, '', 'B'/* BORDE */, 0, 'R');
        $pdf->SetX(130);
        $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT, 2, ".", ","), 'B'/* BORDE */, 0, 'R');


        /* FIN RESUMEN */
        $path = 'uploads/Reportes/Explosion';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file_name = "EXPLOSION MATERIALES SUELA CONCENTRADO " . ' ' . date("d-m-Y his");
        $url = $path . '/' . $file_name . '.pdf';

        if ($Tipo === '10') {
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        } else {
            $pdf->Output($url);
            return base_url() . $url;
        }
    }

    public function onReporteExplosionSemanaSuelaDesglose() {

        //Imprimimos el reporte
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $cm = $this->Explosiones_model;
        $DatosEmpresa = $cm->getDatosEmpresa();

        $Pares = $cm->getPares(
                $Ano, $Sem, $aSem, $Maq, $aMaq
        );

        $pdf = new PDFExpTallas('P', 'mm', array(215.9, 279.4));
        $pdf->Logo = $this->session->LOGO;
        $pdf->Empresa = $this->session->EMPRESA_RAZON;
        $TipoE = '******* SUELA *******';
        $pdf->Sem = $Sem;
        $pdf->aSem = $aSem;
        $pdf->Maq = $Maq;
        $pdf->aMaq = $aMaq;
        $pdf->Pares = $Pares[0]->Pares;
        $pdf->Tipo = $TipoE;
        $pdf->TipoE = $Tipo;

        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 5);

        $pdf->SetFont('Calibri', 'B', 8);
        $pdf->SetX(5);
        $pdf->Cell(20, 4, 'Grupo: ', 0/* BORDE */, 0, 'L');
        $pdf->SetX(25);
        $pdf->SetFont('Calibri', '', 8);
        $pdf->Cell(50, 4, utf8_decode('3    SUELA'), 0/* BORDE */, 1, 'L');


        $Materiales = $this->db->query("SELECT ex.numart , ifnull(a.Observaciones,'') as observ
                                        FROM explosiontallastemp ex
                                        join articulos a on a.clave = ex.numart
                                        group by ex.numart order by ex.nomart; ")->result();
        $Explosion = $this->db->query("SELECT
                ex.numart,ex.nomart, ex.unidad, ex.talla, ex.cantidad, pm.precio, ex.cantidad * pm.precio as subtot
                FROM explosiontallastemp ex join preciosmaquilas pm on pm.articulo = ex.numart and pm.maquila = 1
                order by ex.nomart, ex.talla asc; ")->result();

        $TOTAL_EXP = 0;
        $TOTAL_SUBT = 0;
        foreach ($Materiales as $key => $M) {
            $TOTAL_EXP_ART = 0;
            $TOTAL_SUBT_ART = 0;
            $YTemp = $pdf->GetY() + 3.8;
            $pdf->SetY($YTemp);
            foreach ($Explosion as $key => $D) {
                if ($D->numart === $M->numart) {
                    $pdf->SetLineWidth(0.25);

                    $pdf->SetX(5);
                    $pdf->SetFont('Calibri', '', 8);

                    $pdf->Row(array(
                        utf8_decode($D->numart),
                        utf8_decode(mb_strimwidth($D->nomart, 0, 40, "")),
                        utf8_decode($D->unidad),
                        $D->talla,
                        number_format($D->cantidad, 2, ".", ","),
                        '$' . number_format($D->precio, 2, ".", ","),
                        '$' . number_format($D->subtot, 2, ".", ","),
                        '',
                        '',
                        ''
                    ));
                    $TOTAL_EXP_ART += $D->cantidad;
                    $TOTAL_SUBT_ART += $D->subtot;
                    $TOTAL_EXP += $D->cantidad;
                    $TOTAL_SUBT += $D->subtot;
                }
            }
            if ($TOTAL_EXP_ART > 0 && $TOTAL_SUBT_ART > 0) {
                $pdf->SetFont('Calibri', 'BI', 6.5);
                $pdf->SetX(5);
                $YTemp = $pdf->GetY();
//                $pdf->Cell(65, 4, '*' . utf8_decode(mb_strimwidth($M->observ, 0, 52, "")) . '*', 0/* BORDE */, 0, 'L');
                $pdf->MultiCell(65, 3.5, 'CALIDAD: *' . utf8_decode(mb_strimwidth($M->observ, 0, 95, "")) . '*', 0/* BORDE */, 'L', 0);

                $pdf->SetY($YTemp);
                $pdf->SetX(75);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(25, 4, utf8_decode('Total por Artículo: '), 1/* BORDE */, 0, 'L');
                $pdf->SetX(98);
                $pdf->Cell(14, 4, number_format($TOTAL_EXP_ART, 2, ".", ","), ''/* BORDE */, 0, 'R');
                $pdf->SetX(112);
                $pdf->Cell(15, 4, '', ''/* BORDE */, 0, 'R');
                $pdf->SetX(127);
                $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT_ART, 2, ".", ","), ''/* BORDE */, 1, 'R');
            }
        }
        $pdf->SetFont('Calibri', 'B', 8);
        $pdf->SetX(58);
        $pdf->Cell(40, 4, 'Total por Semana Maquila: ', 'B'/* BORDE */, 0, 'L');
        $pdf->SetFont('Calibri', '', 8);
        $pdf->SetX(98);
        $pdf->Cell(14, 4, number_format($TOTAL_EXP, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
        $pdf->SetX(112);
        $pdf->Cell(15, 4, '', 'B'/* BORDE */, 0, 'R');
        $pdf->SetX(127);
        $pdf->Cell(15, 4, '$' . number_format($TOTAL_SUBT, 2, ".", ","), 'B'/* BORDE */, 0, 'R');

        /* FIN RESUMEN */
        $path = 'uploads/Reportes/Explosion';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file_name = "EXPLOSION MATERIALES DESGLOSE TALLAS" . ' ' . date("d-m-Y his");
        $url = $path . '/' . $file_name . '.pdf';

        $pdf->Output($url);
        return base_url() . $url;
    }

    //Procedimiento para explosionar por tallas
    public function onExplosionaSuelas() {
        $this->db->query("truncate table explosiontallastemp ");
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');
        $Pedidos = $this->db->query(""
                        . " select * from pedidox "
                        . " where "
                        . " maquila between $Maq and $aMaq "
                        . " and semana between $Sem and $aSem "
                        . " and ano = $Ano and stsavan <>  14 order by estilo,color ")->result();


        if (!empty($Pedidos)) {
            foreach ($Pedidos as $key => $P) {
                $FichaTecnica = $this->db->query("select ft.Articulo as cveart, a.Descripcion as nomart, ft.consumo, p.rango,
                                                            ft.pieza as numpza, p.Descripcion as nompza, ft.estilo as numestilo,
                                                            ft.PzXPar as pzaxpar, u.descripcion as unidad
                                            from fichatecnica ft
                                            join estilos e on e.clave = ft.estilo and e.liberado in (2,3)
                                            join articulos a on a.clave = ft.articulo and a.grupo = 3
                                            join piezas p on p.clave = ft.pieza
                                            join unidades u on u.clave = a.unidadmedida
                                            where estilo = '{$P->Estilo}' and color = {$P->Color} ")->result();
                if (empty($FichaTecnica)) {
                    //No existe suela en el estilo $P->Estilo $P->Color
                } else {
                    foreach ($FichaTecnica as $key => $FT) {
                        $txtrangopz = $FT->rango;
                        //sacamos el rango para las suelas
                        if ($txtrangopz !== '' && $txtrangopz !== '0') {
                            $Ran = $this->db->query("select * from rangos where clave = '{$txtrangopz}' ")->result()[0];

                            if (!empty($Ran)) {
                                if (floatval($Ran->PtoInUno) > 0 && floatval($Ran->PtoFinUno) > 0) {
                                    $pnti = $Ran->PtoInUno;
                                    $pntf = $Ran->PtoFinUno;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInDos) > 0 && floatval($Ran->PtoFinDos) > 0) {
                                    $pnti = $Ran->PtoInDos;
                                    $pntf = $Ran->PtoFinDos;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInTres) > 0 && floatval($Ran->PtoFinTres) > 0) {
                                    $pnti = $Ran->PtoInTres;
                                    $pntf = $Ran->PtoFinTres;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInCuatro) > 0 && floatval($Ran->PtoFinCuatro) > 0) {
                                    $pnti = $Ran->PtoInCuatro;
                                    $pntf = $Ran->PtoFinCuatro;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInCinco) > 0 && floatval($Ran->PtoFinCinco) > 0) {
                                    $pnti = $Ran->PtoInCinco;
                                    $pntf = $Ran->PtoFinCinco;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInSeis) > 0 && floatval($Ran->PtoFinSeis) > 0) {
                                    $pnti = $Ran->PtoInSeis;
                                    $pntf = $Ran->PtoFinSeis;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInSiete) > 0 && floatval($Ran->PtoFinSiete) > 0) {
                                    $pnti = $Ran->PtoInSiete;
                                    $pntf = $Ran->PtoFinSiete;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInOcho) > 0 && floatval($Ran->PtoFinOcho) > 0) {
                                    $pnti = $Ran->PtoInOcho;
                                    $pntf = $Ran->PtoFinOcho;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInNueve) > 0 && floatval($Ran->PtoFinNueve) > 0) {
                                    $pnti = $Ran->PtoInNueve;
                                    $pntf = $Ran->PtoFinNueve;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInDiez) > 0 && floatval($Ran->PtoFinDiez) > 0) {
                                    $pnti = $Ran->PtoInDiez;
                                    $pntf = $Ran->PtoFinDiez;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInOnce) > 0 && floatval($Ran->PtoFinOnce) > 0) {
                                    $pnti = $Ran->PtoInOnce;
                                    $pntf = $Ran->PtoFinOnce;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInDoce) > 0 && floatval($Ran->PtoFinDoce) > 0) {
                                    $pnti = $Ran->PtoInDoce;
                                    $pntf = $Ran->PtoFinDoce;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInTrece) > 0 && floatval($Ran->PtoFinTrece) > 0) {
                                    $pnti = $Ran->PtoInTrece;
                                    $pntf = $Ran->PtoFinTrece;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInCatorce) > 0 && floatval($Ran->PtoFinCatorce) > 0) {
                                    $pnti = $Ran->PtoInCatorce;
                                    $pntf = $Ran->PtoFinCatorce;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                                if (floatval($Ran->PtoInQuince) > 0 && floatval($Ran->PtoFinQuince) > 0) {
                                    $pnti = $Ran->PtoInQuince;
                                    $pntf = $Ran->PtoFinQuince;
                                    $this->sacarango($P, $pnti, $pntf, $FT);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function sacarango($P, $pnti, $pntf, $FT) {

        /* Datos para explosión */
        $txtconsumo = $FT->consumo;
        $txtnomart = $FT->nomart;
        $txtcveart = $FT->cveart;
        $txtunidadmedida = $FT->unidad;

        $T = $this->db->query("select * from series where Clave = '{$P->Serie
                        }' ")->result()[0];
        $contador = $pnti;
        while ($contador <= $pntf) {
            for ($i = 1; $i < 22; $i++) {
                if (floatval($T->{"T$i"}) === floatval($contador)) {
                    if (floatval($P->{"C$i"}) > 0) {
                        $cantexp = floatval($P->{"C$i"}) * $txtconsumo;
                        if (floatval($cantexp) > 0) {
                            $this->agregaTempTallas($txtcveart, $txtnomart, $pnti, $cantexp, $txtunidadmedida);
                        }
                    }
                }
            }
            $contador = floatval($contador) + 0.5;
        }
    }

    public function agregaTempTallas($txtcveart, $txtnomart, $pnti, $cantexp, $txtunidadmedida) {
        $ExploTemp = $this->db->query("select * from explosiontallastemp where numart = {$txtcveart} and talla = {$pnti} ")->result();
        if (empty($ExploTemp)) {
            $this->db->insert('explosiontallastemp', array(
                'numart' => $txtcveart,
                'nomart' => $txtnomart,
                'unidad' => $txtunidadmedida,
                'talla' => $pnti,
                'cantidad' => $cantexp
            ));
        } else {
            $this->db->query("update explosiontallastemp set cantidad = (ifnull(cantidad,0) + {$cantexp}) where numart = {$txtcveart} and talla = {$pnti} ; ");
        }
    }

}
