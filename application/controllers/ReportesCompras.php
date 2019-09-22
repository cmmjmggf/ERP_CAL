<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesCompras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReportesCompras_model')
                ->helper('Reportesgeneralcompras_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteSalidasMaquilasPorDiaDesglosado() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tipo = $this->input->post('Tipo');
        $Sem = $this->input->post('Sem');
        $Maq = $this->input->post('Maq');

        $cm = $this->ReportesCompras_model;
        $Maquilas = $cm->getMaquilasReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        $Deptos = $cm->getDepartamentosReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);


        /* Desgloce */
        $Semanas = $cm->getSemanasReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        $Docs = $cm->getDocumentosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        $Grupos = $cm->getGruposArticulosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);

        $Articulos = $cm->getArticulosReporteVenta($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);

        if (!empty($Maquilas)) {

            $pdf = new PDFSalidasMaterialMaquilasDesgloce('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);


            $T_S = 0;
            $T_C = 0;
            foreach ($Maquilas as $key => $P) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(15, 5, utf8_decode('Maquila: '), 'TBL'/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 5, mb_strimwidth(utf8_decode($P->Maquila), 0, 45, ""), 'TBR'/* BORDE */, 1, 'L');


                $Depto = '';

                $T_SMaq = 0;
                $T_CMaq = 0;


                foreach ($Deptos as $key => $DE) {
                    if ($P->Maquila === $DE->Maquila) {

                        switch ($DE->Departamento) {
                            case '10':
                                $Depto = 'Piel y Forro';
                                break;
                            case '80':
                                $Depto = 'Suela y Planta';
                                break;
                            case '90':
                                $Depto = 'Peleteria';
                                break;
                            default:
                                $Depto = 'Otros';
                                break;
                        }
                        $pdf->SetY($pdf->GetY() + 1);
                        $pdf->SetLineWidth(0.2);
                        $pdf->SetFillColor(186, 186, 186);
                        $pdf->SetX(5);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Cell(15, 4, utf8_decode('Tipo: '), 0/* BORDE */, 0, 'L', true);
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(50, 4, utf8_decode($DE->Departamento . '   ' . $Depto), 0/* BORDE */, 1, 'L', true);

                        $T_STipo = 0;
                        $T_CTipo = 0;

                        foreach ($Semanas as $key => $S) {
                            if ($P->Maquila === $S->Maquila && $DE->Departamento === $S->Departamento) {

                                $T_CSems = 0;
                                $T_SSems = 0;

                                foreach ($Docs as $key => $DOC) {
                                    if ($P->Maquila === $DOC->Maquila && $DE->Departamento === $DOC->Departamento && $DOC->Sem === $S->Sem) {

                                        $T_CDocs = 0;
                                        $T_SDocs = 0;
                                        foreach ($Grupos as $key => $G) {
                                            if ($P->Maquila === $G->Maquila && $DE->Departamento === $G->Departamento && $DOC->Sem === $G->Sem && $G->Doc === $DOC->Doc) {

                                                $T_CGrupos = 0;
                                                $T_SGrupos = 0;
                                                foreach ($Articulos as $key => $A) {
                                                    if ($P->Maquila === $A->Maquila && $DE->Departamento === $A->Departamento && $DOC->Sem === $A->Sem && $G->Doc === $A->Doc && $G->ClaveGrupo === $A->ClaveGrupo) {

                                                        $pdf->SetFont('Calibri', '', 9);
                                                        $pdf->Row(array(
                                                            $A->ClaveArt,
                                                            utf8_decode(mb_strimwidth($A->Articulo, 0, 48, "")),
                                                            $A->Unidad,
                                                            $A->FechaMov,
                                                            number_format($A->CantidadMov, 2, ".", ","),
                                                            '$' . number_format($A->PrecioMov, 2, ".", ","),
                                                            '$' . number_format($A->Subtotal, 2, ".", ","),
                                                            $A->Doc,
                                                            $A->Sem), 'B');
                                                        $T_SGrupos += $A->Subtotal;
                                                        $T_CGrupos += $A->CantidadMov;
                                                        $T_SDocs += $A->Subtotal;
                                                        $T_CDocs += $A->CantidadMov;
                                                        $T_SSems += $A->Subtotal;
                                                        $T_CSems += $A->CantidadMov;
                                                        $T_STipo += $A->Subtotal;
                                                        $T_CTipo += $A->CantidadMov;
                                                        $T_SMaq += $A->Subtotal;
                                                        $T_CMaq += $A->CantidadMov;
                                                        $T_S += $A->Subtotal;
                                                        $T_C += $A->CantidadMov;
                                                    }
                                                }
                                                $pdf->SetFont('Calibri', 'B', 9);
                                                $pdf->Row(array(
                                                    '',
                                                    'Total por Grupo ' . utf8_decode($G->ClaveGrupo . ' ' . $G->NombreGrupo) . ':',
                                                    '',
                                                    '',
                                                    number_format($T_CGrupos, 2, ".", ","),
                                                    '',
                                                    '$' . number_format($T_SGrupos, 2, ".", ","),
                                                    '',
                                                    ''), 0);
                                            }
                                        }
                                        $pdf->SetFont('Calibri', 'B', 9);
                                        $pdf->Row(array(
                                            '',
                                            'Total por Documento:',
                                            '',
                                            '',
                                            number_format($T_CDocs, 2, ".", ","),
                                            '',
                                            '$' . number_format($T_SDocs, 2, ".", ","),
                                            '',
                                            ''), 0);
                                    }
                                }
                                $pdf->SetFillColor(255, 204, 153);
                                $pdf->SetFont('Calibri', 'B', 9);
                                $pdf->RowFill(array(
                                    '',
                                    'Total de Semana ' . $S->Sem . ':',
                                    '',
                                    '',
                                    number_format($T_CSems, 2, ".", ","),
                                    '',
                                    '$' . number_format($T_SSems, 2, ".", ","),
                                    '',
                                    ''), 0, true);
                            }
                        }
                        $pdf->SetFillColor(186, 186, 186);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->RowFill(array(
                            '',
                            'Total por Tipo ' . $DE->Departamento . ':',
                            '',
                            '',
                            number_format($T_CTipo, 2, ".", ","),
                            '',
                            '$' . number_format($T_STipo, 2, ".", ","),
                            '',
                            ''), 0, true);
                        $pdf->SetY($pdf->GetY() + 1);
                    }
                }
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->RowFill(array(
                    '',
                    'Total de la Maquila ' . $P->Maquila . ':',
                    '',
                    '',
                    number_format($T_CMaq, 2, ".", ","),
                    '',
                    '$' . number_format($T_SMaq, 2, ".", ","),
                    '',
                    ''), 0, true);
                $pdf->SetY($pdf->GetY() + 1);
            }
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->SetLineWidth(0.5);
            $pdf->RowFill(array(
                '',
                'Total general:',
                '',
                '',
                number_format($T_C, 2, ".", ","),
                '',
                '$' . number_format($T_S, 2, ".", ","),
                '',
                ''), 1, true);
            $pdf->SetY($pdf->GetY() + 1);

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Almacen';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "SALIDA DE MATERIALES A MAQUILAS DESGLOCE " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Almacen/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteSalidasMaquilasPorDia() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tipo = $this->input->post('Tipo');
        $Sem = $this->input->post('Sem');
        $Maq = $this->input->post('Maq');

        $cm = $this->ReportesCompras_model;
        $Maquilas = $cm->getMaquilasReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        $Deptos = $cm->getDepartamentosReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        $Docs = $cm->getDocumentosReporteVentaSinDesgloce($FechaIni, $FechaFin, $Tipo, $Sem, $Maq);
        if (!empty($Maquilas)) {

            $pdf = new PDFSalidasMaterialMaquilas('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $Total_Gen = 0;
            foreach ($Maquilas as $key => $P) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(20, 5, utf8_decode('Maquila: '), 'TBL'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 9);
                $pdf->Cell(50, 5, mb_strimwidth(utf8_decode($P->Maquila), 0, 45, ""), 'TBR'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);
                $Depto = '';
                $Total_Maq = 0;
                foreach ($Deptos as $key => $DE) {
                    if ($P->Maquila === $DE->Maquila) {

                        switch ($DE->Departamento) {
                            case '10':
                                $Depto = 'Piel y Forro';
                                break;
                            case '80':
                                $Depto = 'Suela y Planta';
                                break;
                            case '90':
                                $Depto = 'Peleteria';
                                break;
                            default:
                                $Depto = 'Otros';
                                break;
                        }

                        $Total_Grupo = 0;
                        $pdf->SetX(45);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Cell(20, 5, utf8_decode('Tipo: '), 0/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(50, 5, utf8_decode($DE->Departamento . '   ' . $Depto), 0/* BORDE */, 1, 'L');

                        foreach ($Docs as $key => $DOC) {
                            if ($DE->Maquila === $DOC->Maquila && $DE->Departamento === $DOC->Departamento) {
                                $pdf->SetFont('Calibri', '', 9);
                                $pdf->Row(array(
                                    $DOC->Doc,
                                    '$' . number_format($DOC->Subtotal, 2, ".", ","),
                                    '',
                                    $DOC->Sem), 0);
                                $Total_Grupo += $DOC->Subtotal;
                                $Total_Maq += $DOC->Subtotal;
                                $Total_Gen += $DOC->Subtotal;
                            }
                        }
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Row(array(
                            'Total por tipo: ',
                            '$' . number_format($Total_Grupo, 2, ".", ","),
                            '',
                            ''), 'T');
                    }
                }
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Row(array(
                    'Total por maquila: ',
                    '$' . number_format($Total_Maq, 2, ".", ","),
                    '',
                    ''), 'T');
            }
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->Row(array(
                'Total general: ',
                '$' . number_format($Total_Gen, 2, ".", ","),
                '',
                ''), 'T');

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Almacen';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "SALIDA DE MATERIALES A MAQUILAS SIN DESGLOCE " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Almacen/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteAuditoriaMovimientos() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');

        $cm = $this->ReportesCompras_model;
        $Grupos = $cm->getGruposMovimientosAlmacen($FechaIni, $FechaFin);

        if (!empty($Grupos)) {

            $pdf = new PDFMovimientosAlmacen('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);
            $pdf->SetLineWidth(0.2);

            foreach ($Grupos as $key => $P) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(20, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(50, 4, utf8_decode(mb_strimwidth($P->ClaveGrupo . '    ' . $P->NombreGrupo, 0, 45, "")), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', '', 8);

                $Articulos = $cm->getArticulosMovimientosAlmacen($FechaIni, $FechaFin, $P->ClaveGrupo);

                foreach ($Articulos as $key => $A) {
                    $pdf->SetX(5);
                    $pdf->Cell(12, 3, $A->Clave . ' ', 'B'/* BORDE */, 0, 'R');
                    $pdf->Cell(58, 3, utf8_decode(mb_strimwidth($A->Articulo, 0, 40, "")), 'B'/* BORDE */, 0, 'L');
                    $pdf->Cell(15, 3, $A->Unidad, 'B'/* BORDE */, 0, 'C');
                    $pdf->Cell(20, 3, $A->FechaMov, 'B'/* BORDE */, 0, 'C');
                    $pdf->Cell(17, 3, '$' . number_format($A->PrecioMov, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                    $pdf->Cell(22, 3, number_format($A->CantidadMov, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                    $pdf->Cell(22, 3, '$' . number_format($A->Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                    $pdf->Cell(25, 3, $A->DocMov, 'B'/* BORDE */, 0, 'R');
                    $pdf->Cell(15, 3, $A->TipoMov, 'B'/* BORDE */, 1, 'L');
                }
                $pdf->SetY($pdf->GetY() + 2);
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Almacen';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE MOVIMIENTOS DEL ALMACEN " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Almacen/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteDevolucionesCompra() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tp = $this->input->post('Tp');

        $cm = $this->ReportesCompras_model;
        $Proveedores = $cm->getProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp);
        $Docs = $cm->getDocsProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp);
        $Articulos = $cm->getDetalleDocsProveedoresReporteDevoluciones($FechaIni, $FechaFin, $Tp);
        if (!empty($Proveedores)) {

            $pdf = new PDFDevolucionesCompras('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->setTp($Tp);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $Total_G = 0;
            foreach ($Proveedores as $key => $P) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(20, 6, utf8_decode('Proveedor: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(25);
                $pdf->SetFont('Calibri', '', 9);
                $pdf->Cell(50, 6, mb_strimwidth(utf8_decode($P->ClaveProveedor . '    ' . $P->NombreProveedor), 0, 45, ""), 'B'/* BORDE */, 0, 'L');


                $PTotal_C = 0;
                $PTotal_P = 0;

                foreach ($Docs as $key => $D) {
                    if ($P->ClaveProveedor === $D->ClaveProveedor) {
                        $pdf->SetLineWidth(0.5);
                        $pdf->SetX(75);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->Cell(15, 6, utf8_decode('Docto: '), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX(90);
                        $pdf->SetFont('Calibri', '', 9);
                        $pdf->Cell(15, 6, utf8_decode($D->DocCartProv), 'B'/* BORDE */, 1, 'L');

                        $DTotal_C = 0;
                        $DTotal_P = 0;
                        foreach ($Articulos as $key => $A) {
                            if ($A->ClaveProveedor === $D->ClaveProveedor && $A->DocCartProv === $D->DocCartProv) {
                                $pdf->SetFont('Calibri', '', 8.5);
                                $pdf->SetLineWidth(0.2);
                                $anchos = array(14/* 1 */, 17/* 2 */, 15/* 3 */, 63/* 4 */, 63/* 5 */, 15/* 6 */, 18/* 7 */);
                                $aligns = array('L', 'C', 'R', 'L', 'L', 'R', 'R');
                                $pdf->SetAligns($aligns);
                                $pdf->SetWidths($anchos);
                                $pdf->Row(array(
                                    $A->Folio,
                                    substr($A->Fecha, 0, 8),
                                    number_format($A->Cantidad, 2, ".", ","),
                                    mb_strimwidth(utf8_decode($A->Articulo), 0, 45, ""),
                                    mb_strimwidth(utf8_decode($A->Concepto), 0, 45, ""),
                                    '$' . number_format($A->Precio, 2, ".", ","),
                                    '$' . number_format($A->Subtotal, 2, ".", ","),
                                        ), 0);

                                $DTotal_C += $A->Cantidad;
                                $DTotal_P += $A->Subtotal;
                                $PTotal_C += $A->Cantidad;
                                $PTotal_P += $A->Subtotal;
                                $Total_G += $A->Subtotal;
                            }
                        }
                        /* Total por doc */
                        $pdf->SetFont('Calibri', 'B', 8.5);
                        $anchos = array(31/* 2 */, 15/* 3 */, 141/* 3 */, 18/* 4 */);
                        $aligns = array('L', 'R', 'C', 'R', 'C');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->Row(array(utf8_decode('Total por doc:'), number_format($DTotal_C, 2, ".", ","), '', '$' . number_format($DTotal_P, 2, ".", ",")), 'T');
                    }
                }


                /* Total por prov */
                $pdf->SetFont('Calibri', 'B', 8.5);
                $anchos = array(31/* 2 */, 15/* 3 */, 141/* 3 */, 18/* 4 */);
                $aligns = array('L', 'R', 'C', 'R', 'C');
                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);
                $pdf->Row(array(utf8_decode('Total por Proveedor:'), number_format($PTotal_C, 2, ".", ","), '', '$' . number_format($PTotal_P, 2, ".", ",")), 'T');
            }
            /* Total general */
            $pdf->SetFont('Calibri', 'B', 8.5);
            $anchos = array(31/* 2 */, 20/* 3 */, 136/* 3 */, 18/* 4 */);
            $aligns = array('L', 'R', 'C', 'R', 'C');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->Row(array('', '', 'Total General:', '$' . number_format($Total_G, 2, ".", ",")), 'T');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Devoluciones';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE DEVOLUCIONES DE COMPRAS " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Devoluciones/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteComprasGeneralDesglose() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tp = $this->input->post('Tp');
        $Tipo = $this->input->post('Tipo');

        $cm = $this->ReportesCompras_model;
        $Proveedores = $cm->getProveedoresReporte($FechaIni, $FechaFin, $Tp, $Tipo);
        $Documentos = $cm->getDocumentosReporte($FechaIni, $FechaFin, $Tp, $Tipo);
        if (!empty($Proveedores)) {

            $pdf = new PDFComprasDesgloce('L', 'mm', array(215.9, 279.4));

            $TipoE = '';
            switch ($Tipo) {
                case '':
                    $TipoE = '******* GENERAL *******';
                    break;
                case '0':
                    $TipoE = '******* DIRECTOS *******';
                    break;
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

            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->setTp($Tp);
            $pdf->setReporte($TipoE);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $GTotal_Importe = 0;
            $GTotal_Abonos = 0;
            $GTotal_Saldo = 0;

            $GDTotal_Cantidad = 0;
            $GDTotal_Sub = 0;
            $GDTotal_Iva = 0;
            $GDTotal = 0;
            foreach ($Proveedores as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->Cell(55, 6, utf8_decode($G->ClaveProveedor . '    ' . $G->NombreProveedor), 0/* BORDE */, 0, 'L');


                $Total_Importe = 0;
                $Total_Abonos = 0;
                $Total_Saldo = 0;

                $DTotal_Cantidad = 0;
                $DTotal_Sub = 0;
                $DTotal_Iva = 0;
                $DTotal = 0;
                foreach ($Documentos as $key => $D) {
                    if ($G->ClaveProveedor === $D->ClaveProveedor) {
                        $anchos = array(18/* 3 */, 20/* 4 */, 20/* 5 */, 20/* 6 */, 20/* 7 */);
                        $aligns = array('L', 'L', 'R', 'R', 'R');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetFont('Calibri', 'B', 10);
                        $pdf->Row(array(
                            $D->Doc,
                            $D->FechaDoc,
                            ($D->ImporteDoc <> 0) ? '$' . number_format($D->ImporteDoc, 2, ".", ",") : '',
                            ($D->Pagos_Doc <> 0) ? '$' . number_format($D->Pagos_Doc, 2, ".", ",") : '',
                            ($D->Saldo_Doc <> 0) ? '$' . number_format($D->Saldo_Doc, 2, ".", ",") : ''
                                ), 0, 6);

                        $Articulos = $cm->getArticulosReporteGeneralDesgloce($D->Doc, $D->ClaveProveedor, $Tp);
                        $Total_Cantidad = 0;
                        $Total_Sub = 0;
                        $Total_Iva = 0;
                        $Total = 0;
                        foreach ($Articulos as $key => $A) {
                            $pdf->SetLineWidth(0.2);
                            $pdf->SetX(105);
                            $pdf->SetFont('Calibri', '', 9);
                            $pdf->Cell(10, 4, utf8_decode($A->Clave), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(60, 4, mb_strimwidth(utf8_decode($A->Articulo), 0, 45, ""), 'B'/* BORDE */, 0, 'L');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(12, 4, utf8_decode($A->Unidad), 'B'/* BORDE */, 0, 'C');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(18, 4, number_format($A->Cantidad, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(15, 4, '$' . number_format($A->Precio, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(19, 4, '$' . number_format($A->Subtotal, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(16, 4, '$' . number_format($A->Iva, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                            $pdf->SetX($pdf->GetX());
                            $pdf->Cell(19, 4, '$' . number_format($A->Total, 2, ".", ","), 'B'/* BORDE */, 1, 'R');

                            $Total_Cantidad += $A->Cantidad;
                            $Total_Sub += $A->Subtotal;
                            $Total_Iva += $A->Iva;
                            $Total += $A->Total;

                            $DTotal_Cantidad += $A->Cantidad;
                            $DTotal_Sub += $A->Subtotal;
                            $DTotal_Iva += $A->Iva;
                            $DTotal += $A->Total;

                            $GDTotal_Cantidad += $A->Cantidad;
                            $GDTotal_Sub += $A->Subtotal;
                            $GDTotal_Iva += $A->Iva;
                            $GDTotal += $A->Total;
                        }
                        //TOTALES POR DOCUMENTO ARTICULOS
                        $pdf->SetLineWidth(0.4);
                        $pdf->SetX(105);
                        $pdf->SetFont('Calibri', 'B', 9.5);
                        $pdf->Cell(70, 5, 'Total por Documento', 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 5, '', 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(18, 5, number_format($Total_Cantidad, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 5, '', 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(19, 5, '$' . number_format($Total_Sub, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(16, 5, '$' . number_format($Total_Iva, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(19, 5, '$' . number_format($Total, 2, ".", ","), 'B'/* BORDE */, 1, 'R');


                        $Total_Importe += $D->ImporteDoc;
                        $Total_Abonos += $D->Pagos_Doc;
                        $Total_Saldo += $D->Saldo_Doc;
                        $GTotal_Importe += $D->ImporteDoc;
                        $GTotal_Abonos += $D->Pagos_Doc;
                        $GTotal_Saldo += $D->Saldo_Doc;
                    }
                }


                /* Total por proveedor */
                $pdf->SetX(65);
                $pdf->SetLineWidth(0.9);
                $pdf->SetFont('Calibri', 'B', 10);
                //TOTALES POR DOCUMENTO ARTICULOS
                $pdf->Cell(58, 6, 'Total por Proveedor', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 6, '$' . number_format($Total_Importe, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 6, '$' . number_format($Total_Abonos, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 6, '$' . number_format($Total_Saldo, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(4, 6, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 6, number_format($DTotal_Cantidad, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 6, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(19, 6, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(16, 6, '', 'B'/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(19, 6, '$' . number_format($DTotal, 2, ".", ","), 'B'/* BORDE */, 1, 'R');
            }
            /* Total general */
            $pdf->SetX(65);
            $pdf->SetLineWidth(0.9);
            $pdf->SetFont('Calibri', 'B', 10);
            //TOTALES POR DOCUMENTO ARTICULOS
            $pdf->Cell(58, 6, 'Total general', 'B'/* BORDE */, 0, 'L');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(20, 6, '$' . number_format($GTotal_Importe, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(20, 6, '$' . number_format($GTotal_Abonos, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(20, 6, '$' . number_format($GTotal_Saldo, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(4, 6, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 6, number_format($GDTotal_Cantidad, 2, ".", ","), 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 6, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 6, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(16, 6, '', 'B'/* BORDE */, 0, 'R');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(19, 6, '$' . number_format($GDTotal, 2, ".", ","), 'B'/* BORDE */, 1, 'R');



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ComprasGeneral';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE GENERAL DE COMPRAS DESGLOSE " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/ComprasGeneral/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteComprasGeneralSinDesglose() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tp = $this->input->post('Tp');
        $Tipo = $this->input->post('Tipo');

        $cm = $this->ReportesCompras_model;
        $Proveedores = $cm->getProveedoresReporte($FechaIni, $FechaFin, $Tp, $Tipo);
        $Documentos = $cm->getDocumentosReporte($FechaIni, $FechaFin, $Tp, $Tipo);
        if (!empty($Proveedores)) {

            $pdf = new PDFComprasSinDesgloce('P', 'mm', array(215.9, 279.4));

            $TipoE = '';
            switch ($Tipo) {
                case '':
                    $TipoE = '******* GENERAL *******';
                    break;
                case '0':
                    $TipoE = '******* DIRECTOS *******';
                    break;
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

            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->setTp($Tp);
            $pdf->setReporte($TipoE);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $GTotal_Importe = 0;
            $GTotal_Abonos = 0;
            $GTotal_Saldo = 0;
            foreach ($Proveedores as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->Cell(55, 5, utf8_decode($G->ClaveProveedor . '    ' . $G->NombreProveedor), 'B'/* BORDE */, 1, 'L');


                $Total_Importe = 0;
                $Total_Abonos = 0;
                $Total_Saldo = 0;
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont('Calibri', '', 9);

                foreach ($Documentos as $key => $D) {
                    if ($G->ClaveProveedor === $D->ClaveProveedor) {
                        $anchos = array(20/* 3 */, 18/* 4 */, 20/* 5 */, 20/* 6 */, 20/* 7 */);
                        $aligns = array('L', 'L', 'R', 'R', 'R');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->Row(array(
                            $D->FechaDoc,
                            $D->Doc,
                            ($D->ImporteDoc <> 0) ? '$' . number_format($D->ImporteDoc, 2, ".", ",") : '',
                            ($D->Pagos_Doc <> 0) ? '$' . number_format($D->Pagos_Doc, 2, ".", ",") : '',
                            ($D->Saldo_Doc <> 0) ? '$' . number_format($D->Saldo_Doc, 2, ".", ",") : ''
                                ), 'B');
                        $Total_Importe += $D->ImporteDoc;
                        $Total_Abonos += $D->Pagos_Doc;
                        $Total_Saldo += $D->Saldo_Doc;
                        $GTotal_Importe += $D->ImporteDoc;
                        $GTotal_Abonos += $D->Pagos_Doc;
                        $GTotal_Saldo += $D->Saldo_Doc;
                    }
                }


                /* Total por articulo */
                $pdf->SetX(70);
                $pdf->SetFont('Calibri', 'B', 9);
                $anchos = array(0/* 1 */, 38/* 2 */, 20/* 3 */, 20/* 3 */, 20/* 4 */);
                $aligns = array('R', 'L', 'R', 'R', 'R');
                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);
                $pdf->Row(array(
                    '',
                    utf8_decode('Total por Proveedor:'),
                    ($Total_Importe <> 0) ? '$' . number_format($Total_Importe, 2, ".", ",") : '',
                    ($Total_Abonos <> 0) ? '$' . number_format($Total_Abonos, 2, ".", ",") : '',
                    ($Total_Saldo <> 0) ? '$' . number_format($Total_Saldo, 2, ".", ",") : ''
                        ), 0);
            }
            /* Total general */
            $pdf->SetX(70);
            $pdf->SetFont('Calibri', 'B', 9);
            $anchos = array(0/* 1 */, 38/* 2 */, 20/* 3 */, 20/* 3 */, 20/* 4 */);
            $aligns = array('R', 'L', 'R', 'R', 'R');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->Row(array(
                '',
                utf8_decode('Total general:'),
                ($GTotal_Importe <> 0) ? '$' . number_format($GTotal_Importe, 2, ".", ",") : '',
                ($GTotal_Abonos <> 0) ? '$' . number_format($GTotal_Abonos, 2, ".", ",") : '',
                ($GTotal_Saldo <> 0) ? '$' . number_format($GTotal_Saldo, 2, ".", ",") : ''
                    ), 0);


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ComprasGeneral';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE GENERAL DE COMPRAS SIN DESGLOSE " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/ComprasGeneral/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteComprasPorArticulo() {
        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');
        $Tp = $this->input->post('Tp');

        $Grupo = $this->input->post('TipoArticuloComprasFechaArt');
        $Articulo = $this->input->post('ArticuloComprasFechaArt');

        $cm = $this->ReportesCompras_model;
        $Grupos = $cm->getGruposReporte($FechaIni, $FechaFin, $Tp, $Grupo, $Articulo);
        $Articulos = $cm->getArticulosReporte($FechaIni, $FechaFin, $Tp, $Grupo, $Articulo);
        if (!empty($Grupos)) {

            $pdf = new PDFComprasArticulos('P', 'mm', array(215.9, 279.4));
            $pdf->setFechaFin($FechaFin);
            $pdf->setFechaIni($FechaIni);
            $pdf->setTp($Tp);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 4);
            $pdf->SetLineWidth(0.2);

            $Total_G = 0;
            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Cell(15, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8.5);
                $pdf->Cell(38, 4, utf8_decode($G->ClaveGrupo . '    ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');


                $Total_M = 0;
                $pdf->SetLineWidth(0.2);

                $TotalGrupo = $cm->getTotalGrupoReporte($FechaIni, $FechaFin, $Tp, $G->ClaveGrupo)[0]->TotalGrupo;


                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->ClaveGrupo) {

                        $Porcentaje = ($D->Cantidad / $TotalGrupo) * 100;

                        $pdf->SetFont('Calibri', '', 8.5);

                        $anchos = array(12/* 1 */, 118/* 2 */, 15/* 3 */, 18/* 3 */, 18/* 4 */);
                        $aligns = array('R', 'L', 'C', 'R', 'R');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->Row(array($D->Clave, utf8_decode($D->Descripcion), $D->Unidad, number_format($D->Cantidad, 2, ".", ","), number_format($Porcentaje, 2, ".", ",")), 'B');

                        $Total_M += $D->Cantidad;
                        $Total_G += $D->Cantidad;
                    }
                }


                /* Total por articulo */
                $pdf->SetX(70);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $anchos = array(12/* 1 */, 118/* 2 */, 15/* 3 */, 18/* 3 */, 18/* 4 */);
                $aligns = array('R', 'R', 'C', 'R', 'C');
                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);
                $pdf->Row(array('', utf8_decode('Total por Grupo:'), '', number_format($Total_M, 2, ".", ","), ''), 0);
            }
            /* Total general */
            $pdf->SetX(70);
            $pdf->SetFont('Calibri', 'B', 8.5);
            $anchos = array(12/* 1 */, 118/* 2 */, 15/* 3 */, 18/* 3 */, 18/* 4 */);
            $aligns = array('R', 'R', 'C', 'R', 'C');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->Row(array('', utf8_decode('Total general:'), '', number_format($Total_G, 2, ".", ","), ''), 0);


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ComprasGeneral';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE ARTICULOS DE COMPRAS POR FECHAS Y TP " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/ComprasGeneral/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
