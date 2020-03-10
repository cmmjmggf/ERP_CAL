<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesProduccionJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file')->model('ReportesProduccion_model')
                ->helper('ReporteManoObraDestajo_helper');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onReporteParesPreAsignados() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteParesPreAsignados.jasper');
        $jc->setFilename('PARES_PRE_ASIGNADOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEstadisticasEntrega() {
        $Tipo = $this->input->post('Tipo');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');

        $jc->setJasperurl('jrxml\materiales\ordComMaqSem.jasper');

        switch ($Tipo) {
            case '1':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaCliente.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaGeneral.jasper');
                break;
            case '3':
                $jc->setJasperurl('jrxml\produccion\reporteEstadisticasEntregaSemana.jasper');
                break;
        }

        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_ESTADISTICAS_ENTREGA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteMatrizFraccionesEstiloLinea() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["linea"] = $this->input->post('Linea');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteFraccionesXEstiloMatrizLinea.jasper');
        $jc->setFilename('REPORTE_MATRIZ_FRACCIONES_ESTILO_LINEA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteFraccionesCapturadasNominaSem() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["fraccion"] = $this->input->post('Fraccion');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\fraccionesPagadasNominaPorSemMaq.jasper');
        $jc->setFilename('REPORTE_DESTAJOS_NOMINA_FRACCION_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteLotificacionSuelas() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["grupo"] = $this->input->post('Tipo');
        $parametros["articulo"] = $this->input->post('Articulo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteLotificacionSuela.jasper');
        $jc->setFilename('REPORTE_LOTE_SUELA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteLotificacionSuelasArticulo() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["grupo"] = $this->input->post('Tipo');
        $parametros["articulo"] = $this->input->post('Articulo');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteLotificacionSuelaArticulo.jasper');
        $jc->setFilename('REPORTE_LOTE_SUELA_ARTICULO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteConciliaSemanaFraccionEstilo() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;

        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/produccion/';

        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\conciliaFraccionEstiloNomina.jasper');
        $jc->setFilename('REPORTE_CONCILIA_SEMANA_FRACC_ESTILO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteConciliaCostoManoObraDestajo() {

        $this->db->query("truncate table costomanoobratemp");
        $Ano = $this->input->post('Ano');
        $Sem = $this->input->post('Sem');
        $Fechas = $this->db->query("select
                STR_TO_DATE(FechaIni, '%d/%m/%Y') AS Dia1,
                DATE_ADD(STR_TO_DATE(FechaIni, '%d/%m/%Y'),INTERVAL 1 DAY) AS Dia2,
                DATE_ADD(STR_TO_DATE(FechaIni, '%d/%m/%Y'),INTERVAL 2 DAY) AS Dia3,
                DATE_ADD(STR_TO_DATE(FechaIni,'%d/%m/%Y'),INTERVAL 3 DAY) AS Dia4,
                DATE_ADD(STR_TO_DATE(FechaIni, '%d/%m/%Y'),INTERVAL 4 DAY) AS Dia5,
                DATE_ADD(STR_TO_DATE(FechaIni, '%d/%m/%Y'),INTERVAL 5 DAY) AS Dia6,
                DATE_ADD(STR_TO_DATE(FechaIni, '%d/%m/%Y'),INTERVAL 6 DAY) AS Dia7
                from semanasnomina where Ano = $Ano and Sem = $Sem and Estatus = 'ACTIVO'
                ")->result();
        $Totales_Pares = $this->db->query("
                        SELECT fpn.depto,fpn.control, fpn.pares, fpn.subtot,  DATE_FORMAT(fpn.fecha, '%Y-%m-%d') as fecha , fpn.numfrac,
                        ifnull(D.Descripcion,'N/A FALTA ENLAZAR NUEVOS DEPTOS') AS NombreDepto
                        from fracpagnomina fpn
                        left join departamentos D on fpn.depto = D.Clave
                        where fpn.anio = $Ano
                        and fpn.semana = $Sem
                        and fpn.depto > 0
                        order by  fpn.fecha asc, fpn.depto asc ,fpn.control asc
                ")->result();

        $Pares = 0;
        $sql = '';
        foreach ($Totales_Pares as $key => $v) {

            $Pares = ($v->numfrac === '99') ? 0 : $v->pares;
            $Temp = $this->db->query("select depto from costomanoobratemp where depto = $v->depto ")->result();
            if (empty($Temp)) { //si no existe inserta
                $this->db->insert("costomanoobratemp", array(
                    'depto' => $v->depto,
                    'nombreDepto' => $v->NombreDepto,
                    'tpares1' => ($Fechas[0]->Dia1 === $v->fecha) ? $Pares : NULL,
                    'tpesos1' => ($Fechas[0]->Dia1 === $v->fecha) ? $v->subtot : NULL,
                    'tpares2' => ($Fechas[0]->Dia2 === $v->fecha) ? $Pares : NULL,
                    'tpesos2' => ($Fechas[0]->Dia2 === $v->fecha) ? $v->subtot : NULL,
                    'tpares3' => ($Fechas[0]->Dia3 === $v->fecha) ? $Pares : NULL,
                    'tpesos3' => ($Fechas[0]->Dia3 === $v->fecha) ? $v->subtot : NULL,
                    'tpares4' => ($Fechas[0]->Dia4 === $v->fecha) ? $Pares : NULL,
                    'tpesos4' => ($Fechas[0]->Dia4 === $v->fecha) ? $v->subtot : NULL,
                    'tpares5' => ($Fechas[0]->Dia5 === $v->fecha) ? $Pares : NULL,
                    'tpesos5' => ($Fechas[0]->Dia5 === $v->fecha) ? $v->subtot : NULL,
                    'tpares6' => ($Fechas[0]->Dia6 === $v->fecha) ? $Pares : NULL,
                    'tpesos6' => ($Fechas[0]->Dia6 === $v->fecha) ? $v->subtot : NULL,
                    'tpares7' => ($Fechas[0]->Dia7 === $v->fecha) ? $Pares : NULL,
                    'tpesos7' => ($Fechas[0]->Dia7 === $v->fecha) ? $v->subtot : NULL,
                ));
            } else { // si existe acumula
                switch ($v->fecha) {
                    case $Fechas[0]->Dia1:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares1 = $Pares + ifnull(tpares1,0), "
                                . "tpesos1 = $v->subtot + ifnull(tpesos1,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia2:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares2 = $Pares + ifnull(tpares2,0), "
                                . "tpesos2 = $v->subtot + ifnull(tpesos2,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia3:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares3 = $Pares + ifnull(tpares3,0), "
                                . "tpesos3 = $v->subtot + ifnull(tpesos3,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia4:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares4 = $Pares + ifnull(tpares4,0), "
                                . "tpesos4 = $v->subtot + ifnull(tpesos4,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia5:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares5 = $Pares + ifnull(tpares5,0), "
                                . "tpesos5 = $v->subtot + ifnull(tpesos5,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia6:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares6 = $Pares + ifnull(tpares6,0), "
                                . "tpesos6 = $v->subtot + ifnull(tpesos6,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                    case $Fechas[0]->Dia7:
                        $sql = "UPDATE costomanoobratemp "
                                . "SET tpares7 = $Pares + ifnull(tpares7,0), "
                                . "tpesos7 = $v->subtot + ifnull(tpesos7,0) "
                                . "WHERE depto = $v->depto ";
                        $this->db->query($sql);
                        break;
                }
            }
        }

        /* Reporte */
        $Registros = $this->db->query("
                       select depto, nombreDepto,
                        ifnull(cast(tpares1 as decimal(7,0)),0) as tp1,
                        ifnull(cast(tpesos1 as decimal(7,2)),0) as tpe1,
                        ifnull(cast(tpares2 as decimal(7)),0) as tp2,
                        ifnull(cast(tpesos2 as decimal(7,2)),0) as tpe2,
                        ifnull(cast(tpares3 as decimal(7)),0) as tp3,
                        ifnull(cast(tpesos3 as decimal(7,2)),0) as tpe3,
                        ifnull(cast(tpares4 as decimal(7)),0) as tp4,
                        ifnull(cast(tpesos4 as decimal(7,2)),0) as tpe4,
                        ifnull(cast(tpares5 as decimal(7)),0) as tp5,
                        ifnull(cast(tpesos5 as decimal(7,2)),0) as tpe5,
                        ifnull(cast(tpares6 as decimal(7)),0) as tp6,
                        ifnull(cast(tpesos6 as decimal(7,2)),0) as tpe6,
                        ifnull(cast(tpares7 as decimal(7)),0) as tp7,
                        ifnull(cast(tpesos7 as decimal(7,2)),0) as tpe7,
                        ifnull(tpares1,0)+ifnull(tpares2,0)+ifnull(tpares3,0)+ifnull(tpares4,0)+ifnull(tpares5,0)+ifnull(tpares6,0)+ifnull(tpares7,0) as total_pares,
                        cast(ifnull(tpesos1,0)+ifnull(tpesos2,0)+ifnull(tpesos3,0)+ifnull(tpesos4,0)+ifnull(tpesos5,0)+ifnull(tpesos6,0)+ifnull(tpesos7,0)as decimal (10,2))  as total_pesos
                        FROM
                        costomanoobratemp
                        order by depto asc
                ")->result();
        if (!empty($Registros)) {

            $pdf = new PDFManoObra('L', 'mm', array(215.9, 279.4));
            $pdf->setSem($this->input->post('Sem'));
            $pdf->setAno($this->input->post('Ano'));

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $TP1 = 0;
            $TPe1 = 0;
            $TP2 = 0;
            $TPe2 = 0;
            $TP3 = 0;
            $TPe3 = 0;
            $TP4 = 0;
            $TPe4 = 0;
            $TP5 = 0;
            $TPe5 = 0;
            $TP6 = 0;
            $TPe6 = 0;
            $TP7 = 0;
            $TPe7 = 0;
            $TP = 0;
            $TPe = 0;
            $MO = 0;

            $pdf->SetFont('Calibri', '', 8);
            foreach ($Registros as $key => $R) {


                $pdf->SetX(5);
                $pdf->Cell(43, 4, mb_strimwidth(utf8_decode($R->depto . ' ' . $R->nombreDepto), 0, 20, ""), 'B'/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp1 <> 0) ? number_format($R->tp1, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe1 <> 0) ? number_format($R->tpe1, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp2 <> 0) ? number_format($R->tp2, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe2 <> 0) ? number_format($R->tpe2, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');


                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp3 <> 0) ? number_format($R->tp3, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe3 <> 0) ? number_format($R->tpe3, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(10, 4, ($R->tp4 <> 0) ? number_format($R->tp4, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(10, 4, ($R->tp4 <> 0) ? number_format($R->tp4, 0, ".", ",") : '', 1/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp5 <> 0) ? number_format($R->tp5, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe5 <> 0) ? number_format($R->tpe5, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');


                $pdf->SetX($pdf->GetX());
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp6 <> 0) ? number_format($R->tp6, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe6 <> 0) ? number_format($R->tpe6, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');


                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->tp7 <> 0) ? number_format($R->tp7, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->tpe7 <> 0) ? number_format($R->tpe7, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');


                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->total_pares <> 0) ? number_format($R->total_pares, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');
                $pdf->Cell(15, 4, ($R->total_pesos <> 0) ? number_format($R->total_pesos, 2, ".", ",") : '', 1/* BORDE */, 0, 'R');


                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($R->total_pesos / $R->total_pares <> 0) ? number_format($R->total_pesos / $R->total_pares, 2, ".", ",") : '', 1/* BORDE */, 1, 'C');

                $TP1 += $R->tp1;
                $TPe1 += $R->tpe1;
                $TP2 += $R->tp2;
                $TPe2 += $R->tpe2;
                $TP3 += $R->tp3;
                $TPe3 += $R->tpe3;
                $TP4 += $R->tp4;
                $TPe4 += $R->tpe4;
                $TP5 += $R->tp5;
                $TPe5 += $R->tpe5;
                $TP6 += $R->tp6;
                $TPe6 += $R->tpe6;
                $TP7 += $R->tp7;
                $TPe7 += $R->tpe7;
                $TP += $R->total_pares;
                $TPe += $R->total_pesos;
                $MO += $R->total_pesos / $R->total_pares;
            }
            /* Total general */
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(5);
            $pdf->Cell(43, 5, utf8_decode('Total general:'), 0/* BORDE */, 0, 'C');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP1 <> 0) ? number_format($TP1, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe1 <> 0) ? number_format($TPe1, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP2 <> 0) ? number_format($TP2, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe2 <> 0) ? number_format($TPe2, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP3 <> 0) ? number_format($TP3, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe3 <> 0) ? number_format($TPe3, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(10, 5, ($TP4 <> 0) ? number_format($TP4, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(10, 5, ($TPe4 <> 0) ? number_format($TPe4, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP5 <> 0) ? number_format($TP5, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe5 <> 0) ? number_format($TPe5, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP6 <> 0) ? number_format($TP6, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe6 <> 0) ? number_format($TPe6, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP7 <> 0) ? number_format($TP7, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe7 <> 0) ? number_format($TPe7, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 5, ($TP <> 0) ? number_format($TP, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');
            $pdf->Cell(15, 5, ($TPe <> 0) ? number_format($TPe, 2, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 5, ($MO <> 0) ? number_format($MO, 2, ".", ",") : '', 0/* BORDE */, 1, 'C');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Produccion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE NOMINA DESTAJO MANO OBRA " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Produccion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function ReporteParesAsignadosMaqSemGen() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $parametros["sem"] = intval($x->post('Sem'));
        $parametros["asem"] = intval($x->post('aSem'));
        $parametros["ano"] = intval($x->post('Ano'));
        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/produccion/';
        $jc->setParametros($parametros);
        $reports = array();

        $jc->setJasperurl('jrxml\produccion\paresAsignadosMaqSemGen.jasper');
        $jc->setFilename('paresAsignadosMaqSemGen' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        $reports['PARESASIGNADOSGENERAL1'] = $jc->getReport();

//        $jc->setJasperurl('jrxml\produccion\paresAsignadosMaqSemGen2.jasper');
//        $jc->setFilename('paresAsignadosMaqSemGen2' . Date('h_i_s'));
//        $jc->setDocumentformat('pdf');
//        $reports['PARESASIGNADOSGENERAL2'] = $jc->getReport();
//
//        $jc->setJasperurl('jrxml\produccion\paresAsignadosMaqSemGen3.jasper');
//        $jc->setFilename('paresAsignadosMaqSemGen3' . Date('h_i_s'));
//        $jc->setDocumentformat('pdf');
//        $reports['PARESASIGNADOSGENERAL3'] = $jc->getReport();
        print json_encode($reports);
    }

    public function onReporteAvanceNormalExcel() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\excel\avancePorDeptoExcel.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
        PRINT $jc->getReport();
    }

    public function onReporteAvanceNormalDepto() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\avancePorDepto.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteAvanceNormalDeptoTresdias() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\avancePorDeptoTresDias.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteAvancePorTipo() {
        $Tipo = $this->input->post('Tipo');

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');

        switch ($Tipo) {
            case '1':
                $jc->setJasperurl('jrxml\produccion\avancePorDeptoConPespunte.jasper');
                break;
            case '2':
                $jc->setJasperurl('jrxml\produccion\avancePorDeptoConTejedora.jasper');
                break;
            case '3':
                $jc->setJasperurl('jrxml\produccion\avancePorDeptoConSuela.jasper');
                break;
            case '4':
                $jc->setJasperurl('jrxml\produccion\avancePorDeptoLineaEntrega.jasper');
                break;
            case '5':
                $jc->setJasperurl('jrxml\produccion\avancePorDeptoConMaquilaPlantilla.jasper');
                break;
        }

        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_AVANCE_FILTRADO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteAvanceSemanaDia() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["dia"] = strlen($this->input->post('Dia')) > 0 ? $this->input->post('Dia') : '';
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\avancePorDeptoSemDia.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_DIA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteAvancePorLinea() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\avancePorDeptoLinea.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_LINEA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getDepartamentos() {
        try {
            print json_encode($this->ReportesProduccion_model->getDepartamentos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onReporteAvancePorDeptoEspecifico() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["depto"] = $this->input->post('Depto');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\avancePorDeptoEspecifico.jasper');
        $jc->setFilename('REPORTE_AVANCE_DEPTO_ESPECIFICO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteDiasEntregaFacTermi() {


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\reporteDiasEntregaFacturado.jasper');
        $jc->setFilename('REPORTE_DIAS_ENTREGA_TERMIN_FACTURADO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteControlesEntXMaquila() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\relacionControlesEntregadosMaq.jasper');
        $jc->setFilename('REPORTE_CONTROLES_ENTREGADOS_X_MAQ_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteControlesEntXMaquilaExcel() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\excel\relacionControlesEntregadosMaq.jasper');
        $jc->setFilename('REPORTE_CONTROLES_ENTREGADOS_X_MAQ_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
        PRINT $jc->getReport();
    }

    public function onReporteCostoInvProduccion() {
        $Reporte = $this->input->post('Reporte');
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["mes"] = $this->input->post('Mes');
        $parametros["maq"] = $this->input->post('Maq');
        $parametros["nummes"] = $this->input->post('NumMes');

        $report_name = "jrxml\produccion\\{$Reporte}.jasper";

        $jc->setJasperurl($report_name);
        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_COSTO_INV_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteEstatusPedidoXGrupoAgente() {
        $xGrupo = $this->input->post('EsPorGrupo');

        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["agente"] = $this->input->post('Agente');
        $parametros["grupo"] = $this->input->post('Grupo');

        $jc->setJasperurl('jrxml\produccion\estatusPedidosPorAgenteEstados.jasper');

        if ($xGrupo === '1') {
            $jc->setJasperurl('jrxml\produccion\estatusPedidosPorGrupoCliente.jasper');
        }

        $jc->setParametros($parametros);

        $jc->setFilename('REPORTE_ESTATUS_PEDIDOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onReporteParesProducidosPorTipoConstruccion() {
        $general = $this->input->post('checkGen');


        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('Ano');
        $parametros["sem"] = $this->input->post('Sem');
        $parametros["asem"] = $this->input->post('aSem');
        $parametros["amaq"] = $this->input->post('aMaq');
        $parametros["maq"] = $this->input->post('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\produccion\paresProducidosPorTipoConstruccion.jasper');
        if ($general === '1') {
            $jc->setJasperurl('jrxml\produccion\paresProducidosPorTipoConstruccionResumenXSemanas.jasper');
        }
        $jc->setFilename('REPORTE_PARES_POR_TIPO_CONSTRUCCION_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
