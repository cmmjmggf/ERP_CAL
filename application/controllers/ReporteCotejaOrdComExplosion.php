<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteCotejaOrdComExplosion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteCotejaOrdComExplosion_model')
                ->helper('Explosiones_helper')->helper('Concilias_helper')->helper('file');
    }

    public function onReporteCotejaTallas() {

        $cm = $this->ReporteCotejaOrdComExplosion_model;
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $this->db->query("TRUNCATE TABLE coteja_temp ");
        //Realizacion de consulta a cabeceros para insertarlos
        $Explosion_tallas = $cm->getExplosionTallas($Ano, $Sem, $aSem, $Maq, $aMaq);


        foreach ($Explosion_tallas as $key => $D) {

            $Exp_Acum = $D->C1;
            $Talla = $D->T1;

            for ($i = 1; $i < 22; $i++) {
                $sig = $i + 1;
                if ($D->{"A$i"} === $D->{"A$sig"}) {
                    $Exp_Acum += $D->{"C$sig"};
                } else if ($D->{"A$sig"} === '0') {
                    $Exp_Acum += $D->{"C$sig"};
                    if ($Exp_Acum > 0) {
                        $Articulo = $D->{"A$i"};
                        $this->db->query("INSERT INTO coteja_temp (Grupo,Articulo,NomArticulo,Unidad,Talla,Explosion,Precio) "
                                . " VALUES ($D->Grupo,$Articulo,'$D->Descripcion','$D->Unidad',$Talla,$Exp_Acum,$D->Precio) ");
                    }
                } else {
                    if ($Exp_Acum > 0) {
                        $Articulo = $D->{"A$i"};
                        $this->db->query("INSERT INTO coteja_temp (Grupo,Articulo,NomArticulo,Unidad,Talla,Explosion,Precio) "
                                . " VALUES ($D->Grupo,$Articulo,'$D->Descripcion','$D->Unidad',$Talla,$Exp_Acum,$D->Precio) ");
                    }
                    $Talla = $D->{"T$sig"};
                    $Exp_Acum = $D->{"C$sig"};
                }
            }
        }
        // **************Reporte*************** */
        $Grupos = $cm->getGruposReporte();
        $Articulos = $cm->getDetalleReporte($Ano, $Sem, $aSem, $Maq, $aMaq);
        $DatosEmpresa = $cm->getDatosEmpresa();

        if (!empty($Grupos)) {

            $pdf = new CotejaOrdComExplosionTallas('L', 'mm', array(215.9, 279.4));


            $pdf->Sem = $Sem;
            $pdf->aSem = $aSem;
            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->Tipo = '******* SUELA *******';
            $pdf->TipoE = '80';

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $TOTAL_EXP = 0;
            $TOTAL_SUBT = 0;

            $GCantPedida = 0;
            $GCantEntregada = 0;
            $GSaldoXEntregar = 0;
            $GEntregadoMaquilas = 0;

            $GCantPedidaP = 0;
            $GCantEntregadaP = 0;
            $GSaldoXEntregarP = 0;
            $GEntregadoMaquilasP = 0;

            foreach ($Grupos as $key => $G) {


                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 4, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 4, utf8_decode($G->ClaveGrupo . '     ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

                $TOTAL_EXP_GRUPO = 0;
                $TOTAL_SUBT_GRUPO = 0;

                $CantPedida = 0;
                $CantEntregada = 0;
                $SaldoXEntregarG = 0;
                $EntregadoMaquilas = 0;

                $CantPedidaP = 0;
                $CantEntregadaP = 0;
                $SaldoXEntregarP = 0;
                $EntregadoMaquilasP = 0;

                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->Grupo) {
                        $pdf->SetLineWidth(0.25);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', '', 8);

                        $ExplosionCant = $D->Explosion;
                        $Subtotal = $ExplosionCant * $D->Precio;
                        $SaldoXEntregar = $D->CantPedida - $D->CantEntregada;

                        $pdf->SetX(5);
                        $pdf->Cell(10, 4, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(58, 4, utf8_decode(mb_strimwidth($D->Descripcion, 0, 37, "")), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(8, 4, utf8_decode($D->Talla), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(8, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, number_format($ExplosionCant, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 4, '$' . number_format($D->Precio, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(21, 4, '$' . number_format($Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantPedida <> 0) ? number_format($D->CantPedida, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantPedida * $D->Precio <> 0) ? '$' . number_format($D->CantPedida * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantEntregada <> 0) ? number_format($D->CantEntregada, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantEntregada * $D->Precio <> 0) ? '$' . number_format($D->CantEntregada * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($SaldoXEntregar <> 0) ? number_format($SaldoXEntregar, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($SaldoXEntregar * $D->Precio <> 0) ? '$' . number_format($SaldoXEntregar * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->EntregadoMaquilas <> 0) ? number_format($D->EntregadoMaquilas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->EntregadoMaquilas * $D->Precio <> 0) ? '$' . number_format($D->EntregadoMaquilas * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 1, 'R');

                        $TOTAL_EXP_GRUPO += $ExplosionCant;
                        $TOTAL_SUBT_GRUPO += $Subtotal;
                        $TOTAL_EXP += $ExplosionCant;
                        $TOTAL_SUBT += $Subtotal;

                        //Totales grupo
                        $CantPedida += $D->CantPedida;
                        $CantEntregada += $D->CantEntregada;
                        $SaldoXEntregarG += $SaldoXEntregar;
                        $EntregadoMaquilas += $D->EntregadoMaquilas;

                        $CantPedidaP += $D->CantPedida * $D->Precio;
                        $CantEntregadaP += $D->CantEntregada * $D->Precio;
                        $SaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $EntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;

                        //Totales generales
                        $GCantPedida += $D->CantPedida;
                        $GCantEntregada += $D->CantEntregada;
                        $GSaldoXEntregar += $SaldoXEntregar;
                        $GEntregadoMaquilas += $D->EntregadoMaquilas;

                        $GCantPedidaP += $D->CantPedida * $D->Precio;
                        $GCantEntregadaP += $D->CantEntregada * $D->Precio;
                        $GSaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $GEntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;
                    }
                }
                //Totales grupo
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->RowNoBorder(array(
                    '',
                    'Totales por Grupo ' . utf8_decode($G->ClaveGrupo . ' ' . $G->NombreGrupo) . ':',
                    '',
                    number_format($TOTAL_EXP_GRUPO, 2, ".", ","),
                    '',
                    '$' . number_format($TOTAL_SUBT_GRUPO, 2, ".", ","),
                    number_format($CantPedida, 2, ".", ","),
                    '$' . number_format($CantPedidaP, 2, ".", ","),
                    number_format($CantEntregada, 2, ".", ","),
                    '$' . number_format($CantEntregadaP, 2, ".", ","),
                    number_format($SaldoXEntregarG, 2, ".", ","),
                    '$' . number_format($SaldoXEntregarP, 2, ".", ","),
                    number_format($EntregadoMaquilas, 2, ".", ","),
                    '$' . number_format($EntregadoMaquilasP, 2, ".", ",")
                ));
            }
            //Total general
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->RowNoBorder(array(
                '',
                'Total por Semana Maquila: ',
                '',
                number_format($TOTAL_EXP, 2, ".", ","),
                '',
                '$' . number_format($TOTAL_SUBT, 2, ".", ","),
                number_format($GCantPedida, 2, ".", ","),
                '$' . number_format($GCantPedidaP, 2, ".", ","),
                number_format($GCantEntregada, 2, ".", ","),
                '$' . number_format($GCantEntregadaP, 2, ".", ","),
                number_format($GSaldoXEntregar, 2, ".", ","),
                '$' . number_format($GSaldoXEntregarP, 2, ".", ","),
                number_format($GEntregadoMaquilas, 2, ".", ","),
                '$' . number_format($GEntregadoMaquilasP, 2, ".", ",")
            ));

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "COTEJA ORD_COM - EXPL - ENTREGADO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteCotejaOrdComExplosion() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $cm = $this->ReporteCotejaOrdComExplosion_model;
        $DatosEmpresa = $cm->getDatosEmpresa();
        $Grupos = $cm->getGrupos(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );
        $Explosion = $cm->getExplosionMateriales(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );


        if (!empty($Explosion)) {

            $pdf = new CotejaOrdComExplosion('L', 'mm', array(215.9, 279.4));
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
            $pdf->Tipo = $TipoE;
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $TOTAL_EXP = 0;
            $TOTAL_SUBT = 0;

            $GCantPedida = 0;
            $GCantEntregada = 0;
            $GSaldoXEntregar = 0;
            $GEntregadoMaquilas = 0;

            $GCantPedidaP = 0;
            $GCantEntregadaP = 0;
            $GSaldoXEntregarP = 0;
            $GEntregadoMaquilasP = 0;


            foreach ($Grupos as $key => $G) {

                $TOTAL_EXP_GRUPO = 0;
                $TOTAL_SUBT_GRUPO = 0;

                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 4, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 4, utf8_decode($G->Clave . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');

                $CantPedida = 0;
                $CantEntregada = 0;
                $SaldoXEntregarG = 0;
                $EntregadoMaquilas = 0;

                $CantPedidaP = 0;
                $CantEntregadaP = 0;
                $SaldoXEntregarP = 0;
                $EntregadoMaquilasP = 0;


                foreach ($Explosion as $key => $D) {

                    if ($G->Clave === $D->Grupo) {

                        $pdf->SetLineWidth(0.25);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', '', 8);

                        $ExplosionCant = $D->Explosion;
                        $Subtotal = $ExplosionCant * $D->Precio;
                        $SaldoXEntregar = $D->CantPedida - $D->CantEntregada;

                        $pdf->SetX(5);
                        $pdf->Cell(10, 4, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(60, 4, utf8_decode(mb_strimwidth($D->Descripcion, 0, 38, "")), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, number_format($ExplosionCant, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 4, '$' . number_format($D->Precio, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(21, 4, '$' . number_format($Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantPedida <> 0) ? number_format($D->CantPedida, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantPedida * $D->Precio <> 0) ? '$' . number_format($D->CantPedida * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantEntregada <> 0) ? number_format($D->CantEntregada, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantEntregada * $D->Precio <> 0) ? '$' . number_format($D->CantEntregada * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($SaldoXEntregar <> 0) ? number_format($SaldoXEntregar, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($SaldoXEntregar * $D->Precio <> 0) ? '$' . number_format($SaldoXEntregar * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->EntregadoMaquilas <> 0) ? number_format($D->EntregadoMaquilas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->EntregadoMaquilas * $D->Precio <> 0) ? '$' . number_format($D->EntregadoMaquilas * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 1, 'R');

                        $TOTAL_EXP_GRUPO += $ExplosionCant;
                        $TOTAL_SUBT_GRUPO += $Subtotal;
                        $TOTAL_EXP += $ExplosionCant;
                        $TOTAL_SUBT += $Subtotal;

                        //Totales grupo
                        $CantPedida += $D->CantPedida;
                        $CantEntregada += $D->CantEntregada;
                        $SaldoXEntregarG += $SaldoXEntregar;
                        $EntregadoMaquilas += $D->EntregadoMaquilas;

                        $CantPedidaP += $D->CantPedida * $D->Precio;
                        $CantEntregadaP += $D->CantEntregada * $D->Precio;
                        $SaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $EntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;

                        //Totales generales
                        $GCantPedida += $D->CantPedida;
                        $GCantEntregada += $D->CantEntregada;
                        $GSaldoXEntregar += $SaldoXEntregar;
                        $GEntregadoMaquilas += $D->EntregadoMaquilas;

                        $GCantPedidaP += $D->CantPedida * $D->Precio;
                        $GCantEntregadaP += $D->CantEntregada * $D->Precio;
                        $GSaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $GEntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;
                    }
                }


                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->RowNoBorder(array(
                    '',
                    'Totales por Grupo ' . utf8_decode($G->Clave . ' ' . $G->Nombre) . ':',
                    '',
                    number_format($TOTAL_EXP_GRUPO, 2, ".", ","),
                    '',
                    '$' . number_format($TOTAL_SUBT_GRUPO, 2, ".", ","),
                    number_format($CantPedida, 2, ".", ","),
                    '$' . number_format($CantPedidaP, 2, ".", ","),
                    number_format($CantEntregada, 2, ".", ","),
                    '$' . number_format($CantEntregadaP, 2, ".", ","),
                    number_format($SaldoXEntregarG, 2, ".", ","),
                    '$' . number_format($SaldoXEntregarP, 2, ".", ","),
                    number_format($EntregadoMaquilas, 2, ".", ","),
                    '$' . number_format($EntregadoMaquilasP, 2, ".", ",")
                ));
            }

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->RowNoBorder(array(
                '',
                'Total por Semana Maquila: ',
                '',
                number_format($TOTAL_EXP, 2, ".", ","),
                '',
                '$' . number_format($TOTAL_SUBT, 2, ".", ","),
                number_format($GCantPedida, 2, ".", ","),
                '$' . number_format($GCantPedidaP, 2, ".", ","),
                number_format($GCantEntregada, 2, ".", ","),
                '$' . number_format($GCantEntregadaP, 2, ".", ","),
                number_format($GSaldoXEntregar, 2, ".", ","),
                '$' . number_format($GSaldoXEntregarP, 2, ".", ","),
                number_format($GEntregadoMaquilas, 2, ".", ","),
                '$' . number_format($GEntregadoMaquilasP, 2, ".", ",")
            ));

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "COTEJA ORD_COM - EXPL - ENTREGADO " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    /* Reportes Coteja Ordenes de Compra sin explosionar */

    public function onReporteCotejaOrdComExplosionSinExplosion() {
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $aSem = $this->input->post('aSem');
        $Ano = $this->input->post('Ano');

        $cm = $this->ReporteCotejaOrdComExplosion_model;
        $DatosEmpresa = $cm->getDatosEmpresa();
        $Grupos = $cm->getGruposSinE(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );
        $Explosion = $cm->getExplosionMaterialesSinE(
                $Ano, $Sem, $aSem, $Maq, $aMaq, $Tipo
        );


        if (!empty($Explosion)) {

            $pdf = new CotejaOrdComSinExplosion('L', 'mm', array(215.9, 279.4));
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
            $pdf->Tipo = $TipoE;
            $pdf->TipoE = $Tipo;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);


            $GCantPedida = 0;
            $GCantEntregada = 0;
            $GSaldoXEntregar = 0;
            $GEntregadoMaquilas = 0;

            $GCantPedidaP = 0;
            $GCantEntregadaP = 0;
            $GSaldoXEntregarP = 0;
            $GEntregadoMaquilasP = 0;


            foreach ($Grupos as $key => $G) {


                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 4, 'Grupo: ', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 4, utf8_decode($G->Clave . '     ' . $G->Nombre), 'B'/* BORDE */, 1, 'L');

                $CantPedida = 0;
                $CantEntregada = 0;
                $SaldoXEntregarG = 0;
                $EntregadoMaquilas = 0;

                $CantPedidaP = 0;
                $CantEntregadaP = 0;
                $SaldoXEntregarP = 0;
                $EntregadoMaquilasP = 0;


                foreach ($Explosion as $key => $D) {

                    if ($G->Clave === $D->Grupo) {

                        $pdf->SetLineWidth(0.25);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', '', 8);


                        $SaldoXEntregar = $D->CantPedida - $D->CantEntregada;

                        $pdf->SetX(5);
                        $pdf->Cell(10, 4, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(60, 4, utf8_decode(mb_strimwidth($D->Descripcion, 0, 38, "")), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, number_format(0, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 4, '$' . number_format($D->Precio, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(21, 4, '$' . number_format(0, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantPedida <> 0) ? number_format($D->CantPedida, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantPedida * $D->Precio <> 0) ? '$' . number_format($D->CantPedida * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->CantEntregada <> 0) ? number_format($D->CantEntregada, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->CantEntregada * $D->Precio <> 0) ? '$' . number_format($D->CantEntregada * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($SaldoXEntregar <> 0) ? number_format($SaldoXEntregar, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($SaldoXEntregar * $D->Precio <> 0) ? '$' . number_format($SaldoXEntregar * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 4, ($D->EntregadoMaquilas <> 0) ? number_format($D->EntregadoMaquilas, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 4, ($D->EntregadoMaquilas * $D->Precio <> 0) ? '$' . number_format($D->EntregadoMaquilas * $D->Precio, 2, ".", ",") : '', 1/* BORDE */, 1, 'R');


                        //Totales grupo
                        $CantPedida += $D->CantPedida;
                        $CantEntregada += $D->CantEntregada;
                        $SaldoXEntregarG += $SaldoXEntregar;
                        $EntregadoMaquilas += $D->EntregadoMaquilas;

                        $CantPedidaP += $D->CantPedida * $D->Precio;
                        $CantEntregadaP += $D->CantEntregada * $D->Precio;
                        $SaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $EntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;

                        //Totales generales
                        $GCantPedida += $D->CantPedida;
                        $GCantEntregada += $D->CantEntregada;
                        $GSaldoXEntregar += $SaldoXEntregar;
                        $GEntregadoMaquilas += $D->EntregadoMaquilas;

                        $GCantPedidaP += $D->CantPedida * $D->Precio;
                        $GCantEntregadaP += $D->CantEntregada * $D->Precio;
                        $GSaldoXEntregarP += $SaldoXEntregar * $D->Precio;
                        $GEntregadoMaquilasP += $D->EntregadoMaquilas * $D->Precio;
                    }
                }


                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->RowNoBorder(array(
                    '',
                    'Totales por Grupo ' . utf8_decode($G->Clave . ' ' . $G->Nombre) . ':',
                    '',
                    number_format(0, 2, ".", ","),
                    '',
                    '$' . number_format(0, 2, ".", ","),
                    number_format($CantPedida, 2, ".", ","),
                    '$' . number_format($CantPedidaP, 2, ".", ","),
                    number_format($CantEntregada, 2, ".", ","),
                    '$' . number_format($CantEntregadaP, 2, ".", ","),
                    number_format($SaldoXEntregarG, 2, ".", ","),
                    '$' . number_format($SaldoXEntregarP, 2, ".", ","),
                    number_format($EntregadoMaquilas, 2, ".", ","),
                    '$' . number_format($EntregadoMaquilasP, 2, ".", ",")
                ));
            }

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->RowNoBorder(array(
                '',
                'Total por Semana Maquila: ',
                '',
                number_format(0, 2, ".", ","),
                '',
                '$' . number_format(0, 2, ".", ","),
                number_format($GCantPedida, 2, ".", ","),
                '$' . number_format($GCantPedidaP, 2, ".", ","),
                number_format($GCantEntregada, 2, ".", ","),
                '$' . number_format($GCantEntregadaP, 2, ".", ","),
                number_format($GSaldoXEntregar, 2, ".", ","),
                '$' . number_format($GSaldoXEntregarP, 2, ".", ","),
                number_format($GEntregadoMaquilas, 2, ".", ","),
                '$' . number_format($GEntregadoMaquilasP, 2, ".", ",")
            ));

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "COTEJA ORD_COM - EXPL - ENTREGADO " . ' ' . date("d-m-Y his");
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
