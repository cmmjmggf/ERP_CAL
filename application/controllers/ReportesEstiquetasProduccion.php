<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}

class ReportesEstiquetasProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file')->model('ReportesEstiquetasProduccion_model');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function OnReporteEtiquetaZapica() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["Ano"] = $this->input->post('Ano');
        $parametros["Linea"] = $this->input->post('Linea');
        $parametros["Temporada"] = $this->input->post('Temporada');
        $parametros["Logo"] = base_url() . $this->session->LOGO;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\etiquetas\etiquetaZapica.jasper');
        $jc->setFilename('ETIQUETA_ZAPICA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    /* Reporte de Etiquetas para EXPORTACION */

    public function OnReporteEtiquetasCajasExportacion() {
        $cm = $this->ReportesEstiquetasProduccion_model;
        $this->db->query('truncate table etiqcaja;');
        $Controles = $cm->getControlesParaEtiquetasCajas(
                $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Maq'), $this->input->post('Control'), $this->input->post('AControl'), $this->input->post('Tipo'), $this->input->post('Cliente'));

        //Si hay controles generados hace el reporte
        if (!empty($Controles)) {
            foreach ($Controles as $key => $v) {
                $Serie = $cm->getDatosSerie($v->Serie);
                $Suela = $cm->getSuelaFromFichaTecnica($v->Estilo, $v->Color)[0]->Suela;
                $talla = '';
                $pares = 0;

                /* Iteramos 22 veces para que recorra todas las tallas */
                for ($i = 1; $i <= 22; $i++) {
                    //Si el punto trae pares capturados
                    if (intval($v->{"C$i"}) > 0) {
                        $talla = floatval($Serie[0]->{"T$i"});
                        $pares = intval($v->{"C$i"});

                        //variables para crear el codigo de barras
                        $estilo_cb = str_pad($v->Estilo, 6, '.', STR_PAD_LEFT);
                        $color_cb = str_pad($v->Color, 3, '0', STR_PAD_LEFT);
                        $talla_cb = (strlen($talla) <= 2) ? str_pad($talla, 4, '0', STR_PAD_LEFT) : $talla;
                        $codigo_barras = $estilo_cb . $color_cb . $talla_cb;

                        //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                        $cont = 1;
                        while ($cont <= $pares) {
                            $this->db->insert("etiqcaja", array(
                                'contped' => $codigo_barras,
                                'estiped' => $v->Estilo,
                                'combped' => $v->Color,
                                'punto' => $talla,
                                'recio' => $v->Clave,
                                'cliente' => $v->Cliente,
                                'control' => $v->Control,
                                'suela' => $Suela
                            ));
                            $cont++;
                        }
                    }
                }
            }
            print 1;
        }
    }

    public function onExportarCSVExportacion() {

        try {
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelExportacion();
            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Nombre de columnas
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Control');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Estilo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Talla');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Codigo Barras');


            $row = 2;
            foreach ($reporte as $key => $value) {
                // Agregamos los datos
                //$objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->control);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $row, $value->estilo, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->color);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->talla);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->codbarr);
                $row++;
            }
            // Renombramos hoja
            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $path = 'uploads/Reportes/Etiquetas';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ETIQUETAS CAJAS EXPORTACION " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Etiquetas/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte de Etiquetas para PAKAR */

    public function OnReporteEtiquetasCajasPakar() {
        $cm = $this->ReportesEstiquetasProduccion_model;
        $this->db->query('truncate table etiqcaja;');
        $Controles = $cm->getControlesParaEtiquetasCajas(
                $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Maq'), $this->input->post('Control'), $this->input->post('AControl'), $this->input->post('Tipo'), $this->input->post('Cliente'));

        //Si hay controles generados hace el reporte
        if (!empty($Controles)) {
            foreach ($Controles as $key => $v) {
                $Serie = $cm->getDatosSerie($v->Serie);
                $Suela = $cm->getSuelaFromFichaTecnica($v->Estilo, $v->Color)[0]->Suela;
                $talla = '';
                $pares = 0;

                /* Iteramos 22 veces para que recorra todas las tallas */
                for ($i = 1; $i <= 22; $i++) {
                    //Si el punto trae pares capturados
                    if (intval($v->{"C$i"}) > 0) {
                        $talla = floatval($Serie[0]->{"T$i"});
                        $pares = intval($v->{"C$i"});

                        //variables para crear el codigo de barras
                        $estilo_cb = str_pad($v->Estilo, 6, '.', STR_PAD_LEFT);
                        $color_cb = str_pad($v->Color, 3, '0', STR_PAD_LEFT);
                        $talla_cb = (strlen($talla) <= 2) ? str_pad($talla, 4, '0', STR_PAD_LEFT) : $talla;
                        $codigo_barras = $estilo_cb . $color_cb . $talla_cb;

                        //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                        $cont = 1;
                        while ($cont <= $pares) {
                            $this->db->insert("etiqcaja", array(
                                'contped' => $codigo_barras,
                                'estiped' => $v->Estilo,
                                'combped' => $v->Color,
                                'punto' => $talla,
                                'recio' => $v->Clave,
                                'cliente' => $v->Cliente,
                                'control' => $v->Control,
                                'suela' => $Suela
                            ));
                            $cont++;
                        }
                    }
                }
            }
            print 1;
        }
    }

    public function onExportarCSVPakar() {

        try {
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelPakar();
            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Nombre de columnas
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Control');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Estilo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Piel Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Suela');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'Punto');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'Codigo Barras');


            $row = 2;
            foreach ($reporte as $key => $value) {
                // Agregamos los datos
                //$objPHPExcel->getActiveSheet()->getStyle('B' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->control);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $row, $value->estilo, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->color);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->piel);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->suela);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value->punto);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->codbarr);
                $row++;
            }
            // Renombramos hoja
            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $path = 'uploads/Reportes/Etiquetas';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ETIQUETAS CAJAS PAKAR " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Etiquetas/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte para Price Shoes y Super Zap */

    public function OnReporteEtiquetasCajasPriceSuper() {
        $cm = $this->ReportesEstiquetasProduccion_model;
        $this->db->query('truncate table etiqcaja;');
        $Controles = $cm->getControlesParaEtiquetasCajas(
                $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Maq'), $this->input->post('Control'), $this->input->post('AControl'), $this->input->post('Tipo'), $this->input->post('Cliente'));

        //Si hay controles generados hace el reporte
        if (!empty($Controles)) {
            foreach ($Controles as $key => $v) {
                $Serie = $cm->getDatosSerie($v->Serie);
                $talla = '';
                $pares = 0;

                /* Iteramos 22 veces para que recorra todas las tallas */
                for ($i = 1; $i <= 22; $i++) {
                    //Si el punto trae pares capturados
                    if (intval($v->{"C$i"}) > 0) {
                        $talla = floatval($Serie[0]->{"T$i"});
                        $pares = intval($v->{"C$i"});

                        //variables para crear el codigo de barras
                        $estilo_cb = str_pad($v->Estilo, 6, '.', STR_PAD_LEFT);
                        $color_cb = str_pad($v->Color, 3, '0', STR_PAD_LEFT);
                        $talla_cb = (strlen($talla) <= 2) ? str_pad($talla, 4, '0', STR_PAD_LEFT) : $talla;
                        $codigo_barras = $estilo_cb . $color_cb . $talla_cb;

                        //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                        $cont = 1;
                        while ($cont <= $pares) {
                            $this->db->insert("etiqcaja", array(
                                'contped' => $codigo_barras,
                                'estiped' => $v->Estilo,
                                'combped' => $v->Color,
                                'punto' => $talla,
                                'recio' => $v->Clave,
                                'cliente' => $v->Cliente,
                                'control' => $v->Control
                            ));
                            $cont++;
                        }
                    }
                }
            }
            print 1;
        }
    }

    public function onExportarCSVPriceSuper() {

        try {
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelPriceSuper();
            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Nombre de columnas
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Estilo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '3');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Id Art');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Marca');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '6');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'Control');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'Punto');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'Codigo Barras');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'Num Prov');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '11');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, 'Pedido');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, 'Catalogo');


            $row = 2;
            foreach ($reporte as $key => $value) {
                // Agregamos los datos
                //$objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                //    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $row, PHPExcel_Cell_DataType::TYPE_STRING);
                //$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->estilo);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $row, $value->estilo, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->color);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->c3);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->idart);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->nomprov);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value->c6);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->control);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value->punto);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $value->codbarr);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $value->ClaveProv);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $value->c11);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value->Pedido);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value->catalogo);
                $row++;
            }
            // Renombramos hoja
            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $path = 'uploads/Reportes/Etiquetas';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ETIQUETAS PRICE SUPER " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Etiquetas/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte general */

    public function OnReporteEtiquetasCajasGeneral() {
        $cm = $this->ReportesEstiquetasProduccion_model;
        $this->db->query('truncate table etiqcaja;');
        $Controles = $cm->getControlesParaEtiquetasCajas(
                $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Maq'), $this->input->post('Control'), $this->input->post('AControl'), $this->input->post('Tipo'), $this->input->post('Cliente'));

        //Si hay controles generados hace el reporte
        if (!empty($Controles)) {
            foreach ($Controles as $key => $v) {
                $Serie = $cm->getDatosSerie($v->Serie);
                $talla = '';
                $pares = 0;

                /* Iteramos 22 veces para que recorra todas las tallas */
                for ($i = 1; $i <= 22; $i++) {
                    //Si el punto trae pares capturados
                    if (intval($v->{"C$i"}) > 0) {
                        $talla = floatval($Serie[0]->{"T$i"});
                        $pares = intval($v->{"C$i"});

                        //variables para crear el codigo de barras
                        $estilo_cb = str_pad($v->Estilo, 6, '.', STR_PAD_LEFT);
                        $color_cb = str_pad($v->Color, 3, '0', STR_PAD_LEFT);
                        $talla_cb = (strlen($talla) <= 2) ? str_pad($talla, 4, '0', STR_PAD_LEFT) : $talla;

                        $talla_con9 = str_replace(".", "9", $talla_cb); //Cambia el punto en la talla por un 9

                        $codigo_barras = $estilo_cb . $color_cb . $talla_cb;
                        $codigo_barras_texto = $estilo_cb . $color_cb . $talla_con9;

                        //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                        $cont = 1;
                        while ($cont <= $pares) {
                            $this->db->insert("etiqcaja", array(
                                'contped' => $codigo_barras,
                                'codigobarras' => $codigo_barras_texto,
                                'estiped' => $v->Estilo,
                                'combped' => $v->Color,
                                'punto' => $talla,
                                'recio' => $v->ColorT,
                                'cliente' => $v->Cliente,
                                'control' => $v->Control
                            ));
                            $cont++;
                        }
                    }
                }
            }
            print 1;
        }
    }

    public function onExportarCSVGenerico() {

        try {
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelGenerico();
            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Nombre de columnas

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Control');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Estilo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Talla');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Tpo');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'Nom Color');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'Codigo 1');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'Codigo 2');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'Foto');


            $row = 2;
            foreach ($reporte as $key => $value) {
                // Agregamos los datos
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->control);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $row, $value->estiped, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->punto);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->tpo);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->combped);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value->recio);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->cod1);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value->cod2);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, 'C:\\SIS386\\Fotos\\' . $value->estiped . '-1.jpg');
                $row++;
            }
            // Renombramos hoja
            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
            $path = 'uploads/Reportes/Etiquetas';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ETIQUETAS CAJAS GENERAL " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Etiquetas/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte etiqueta trazabilidad , en lobo solo no la usan */

    public function OnReporteEtiquetaTrazabalidad() {
        $cm = $this->ReportesEstiquetasProduccion_model;
        $this->db->query('truncate table etiqcaja;');
        $Controles = $cm->getControlesParaEtiquetas(
                $this->input->post('Ano'), $this->input->post('Sem'), $this->input->post('Maq'), $this->input->post('Control'), $this->input->post('AControl'));
        foreach ($Controles as $key => $v) {
            $DatosEtiqueta = $cm->getDatosEtiqueta($v->Estilo, $v->Color);
            $Serie = $cm->getDatosSerie($v->Serie);
            $talla = '';
            $pares = 0;

            /* Iteramos 22 veces para que recorra todas las tallas */
            for ($i = 1; $i <= 22; $i++) {
                //Si el punto trae pares capturados
                if (intval($v->{"C$i"}) > 0) {
                    $talla = floatval($Serie[0]->{"T$i"});
                    $pares = intval($v->{"C$i"}) * 2;

                    //Tallas otros paises
                    $t_usa = '';
                    $t_eur = '';
                    $t_bra = '';
                    //Validacion de serias para convertir en otros paises
                    if (intval($v->Serie) === 1) {//Hombre
                        switch ($talla) {
                            case 25:
                                $t_usa = '7';
                                $t_eur = '40';
                                $t_bra = '37';
                                break;
                            case 25.5:
                                $t_usa = '7 1/2';
                                $t_eur = '40 1/2';
                                $t_bra = '37 1/2';
                                break;
                            case 26:
                                $t_usa = '8';
                                $t_eur = '41';
                                $t_bra = '38 1/2';
                                break;
                            case 26.5:
                                $t_usa = '8 1/2';
                                $t_eur = '42';
                                $t_bra = '38 1/2';
                                break;
                            case 27:
                                $t_usa = '9';
                                $t_eur = '42 1/2';
                                $t_bra = '39';
                                break;
                            case 27.5:
                                $t_usa = '9 1/2';
                                $t_eur = '43';
                                $t_bra = '39 1/2';
                                break;
                            case 28:
                                $t_usa = '10';
                                $t_eur = '44';
                                $t_bra = '40';
                                break;
                            case 28.5:
                                $t_usa = '10 1/2';
                                $t_eur = '44 1/2';
                                $t_bra = '40 1/2';
                                break;
                            case 29:
                                $t_usa = '11';
                                $t_eur = '45';
                                $t_bra = '41';
                                break;
                            case 29.5:
                                $t_usa = '11 1/2';
                                $t_eur = '45 1/2';
                                $t_bra = '42 1/2';
                                break;
                            case 30:
                                $t_usa = '12';
                                $t_eur = '46';
                                $t_bra = '43';
                                break;
                            case 30.5:
                                $t_usa = '12 1/2';
                                $t_eur = '47';
                                $t_bra = '43 1/2';
                                break;
                            case 31:
                                $t_usa = '13';
                                $t_eur = '47 1/2';
                                $t_bra = '44';
                                break;
                            case 31.5:
                                $t_usa = '13 1/2';
                                $t_eur = '48';
                                $t_bra = '44 1/2';
                                break;
                            case 32:
                                $t_usa = '14';
                                $t_eur = '48 1/2';
                                $t_bra = '45';
                                break;
                        }
                    } else if (intval($v->Serie) === 2) {//Mujer
                        switch ($talla) {
                            case 22:
                                $t_usa = '5';
                                $t_eur = '35 1/2';
                                $t_bra = '33 1/2';
                                break;
                            case 22.5:
                                $t_usa = '5 1/2';
                                $t_eur = '36';
                                $t_bra = '34';
                                break;
                            case 23:
                                $t_usa = '6';
                                $t_eur = '36 1/2';
                                $t_bra = '35';
                                break;
                            case 23.5:
                                $t_usa = '6 1/2';
                                $t_eur = '37 1/2';
                                $t_bra = '35 1/2';
                                break;
                            case 24:
                                $t_usa = '7';
                                $t_eur = '38';
                                $t_bra = '36';
                                break;
                            case 24.5:
                                $t_usa = '7 1/2';
                                $t_eur = '38 1/2';
                                $t_bra = '36 1/2';
                                break;
                            case 25:
                                $t_usa = '8';
                                $t_eur = '39';
                                $t_bra = '37';
                                break;
                            case 25.5:
                                $t_usa = '8 1/2';
                                $t_eur = '40';
                                $t_bra = '38';
                                break;
                            case 26:
                                $t_usa = '9';
                                $t_eur = '40 1/2';
                                $t_bra = '38 1/2';
                                break;
                            case 26.5:
                                $t_usa = '9 1/2';
                                $t_eur = '41';
                                $t_bra = '39';
                                break;
                            case 27:
                                $t_usa = '10';
                                $t_eur = '42';
                                $t_bra = '40';
                                break;
                            case 27.5:
                                $t_usa = '10 1/2';
                                $t_eur = '42 1/2';
                                $t_bra = '';
                                break;
                            case 28:
                                $t_usa = '11';
                                $t_eur = '43';
                                $t_bra = '';
                                break;
                            case 28.5:
                                $t_usa = '11 1/2';
                                $t_eur = '44';
                                $t_bra = '';
                                break;
                            case 29:
                                $t_usa = '12';
                                $t_eur = '44 1/2';
                                $t_bra = '';
                                break;
                        }
                    }
                    //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                    $cont = 1;
                    while ($cont <= $pares) {
                        $this->db->insert("etiqcaja", array(
                            'contped' => $v->Control,
                            'estiped' => $v->Estilo,
                            'combped' => $v->Color,
                            'punto' => $talla,
                            'recio' => $v->ColorT,
                            'cliente' => $DatosEtiqueta[0]->trEtiqueta,
                            'control' => $v->Control,
                            'tpo' => $DatosEtiqueta[0]->trPiel,
                            'color' => $DatosEtiqueta[0]->trForro,
                            'suela' => $DatosEtiqueta[0]->trSuela,
                            'tmex' => $talla,
                            'tusa' => $t_usa,
                            'tmer' => $t_eur,
                            'tbra' => $t_bra
                        ));
                        $cont++;
                    }
                }
            }
        }
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\etiquetas\trazabilidad.jasper');



        if ($this->input->post('Tipo') === '1') {

            $jc->setJasperurl('jrxml\etiquetas\trazabilidadNegro.jasper');
        }

        $jc->setFilename('ETIQUETA_TRAZABILIDAD_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
