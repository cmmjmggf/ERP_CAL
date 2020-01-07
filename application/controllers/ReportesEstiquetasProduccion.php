<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

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
            //Nombre del archivo
            $filename = 'ETIQUETAS_CAJAS_PAKAR_' . Date('h_i_s') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            //Tipo de archivo
            header("Content-Type: application/csv; ");
            //Abrimos archivo
            $file = fopen('php://output', 'w');
            //Encabezados
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            $header = array("Control", "Estilo", "Color", "Piel Color", "Suela", "Punto", "Codigo Barras");

            //Escribir CSV en memoria
            fputcsv($file, $header);
            //Obtener datos de la tabla de paso
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelPakar();

            //Llenamos el archivo con los datos del detalle, NOTA el return del modelo debe de ser un arreglo bidimensional, no un objeto bidimensional
            foreach ($reporte as $key => $line) {
                //Se meten los datos del arreglo en el excel
                fputcsv($file, array_map(function($v) {
                            //a cada iteracion se le agrega "\r" a final de cada campo para forzar que sea texto
                            return $v;
                        }, $line));
            }
            //Cerramos el archivo
            fclose($file);
            //Fin del metodo
            exit;
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
            //Nombre del archivo
            $filename = 'ETIQUETAS_CAJAS_PRICE_SUPER_' . Date('h_i_s') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            //Tipo de archivo
            header("Content-Type: application/csv; ");
            //Abrimos archivo
            $file = fopen('php://output', 'w');
            //Encabezados
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            $header = array("Estilo", "Color", "3", "Id Art", "Marca", "6", "Control", "Punto", "Codigo Barras", "Num Prov", "11", "Pedido", "Catalogo");
            //Escribir CSV en memoria
            fputcsv($file, $header);
            //Obtener datos de la tabla de paso
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelPriceSuper();

            //Llenamos el archivo con los datos del detalle, NOTA el return del modelo debe de ser un arreglo bidimensional, no un objeto bidimensional
            foreach ($reporte as $key => $line) {
                //Se meten los datos del arreglo en el excel
                fputcsv($file, array_map(function($v) {
                            //a cada iteracion se le agrega "\r" a final de cada campo para forzar que sea texto
                            return $v;
                        }, $line));
            }
            //Cerramos el archivo
            fclose($file);
            //Fin del metodo
            exit;
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
                        $codigo_barras = $estilo_cb . $color_cb . $talla_cb;

                        //Iteramos entre los pares para insertar por cada talla una etiqueta por par
                        $cont = 1;
                        while ($cont <= $pares) {
                            $this->db->insert("etiqcaja", array(
                                'contped' => $codigo_barras,
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
            //Nombre del archivo
            $filename = 'ETIQUETAS_CAJAS_GENERAL_' . Date('h_i_s') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            //Tipo de archivo
            header("Content-Type: application/csv; ");
            //Abrimos archivo
            $file = fopen('php://output', 'w');
            //Encabezados
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            $header = array("Control", "Estilo", "Talla", "Tpo", "Color", "Nom Color", "Codigo 1", "Codigo 2", "Foto");
            //Escribir CSV en memoria
            fputcsv($file, $header);
            //Obtener datos de la tabla de paso
            $reporte = $this->ReportesEstiquetasProduccion_model->getDatosReporteExcelGenerico();

            //Llenamos el archivo con los datos del detalle, NOTA el return del modelo debe de ser un arreglo bidimensional, no un objeto bidimensional
            foreach ($reporte as $key => $line) {


                $row = array(
                    $line->control,
                    $line->estiped,
                    $line->punto,
                    $line->tpo,
                    $line->combped,
                    $line->recio,
                    $line->cod1,
                    $line->cod2,
                    'C:\\SIS386\\Fotos\\' . $line->estiped . '-1.jpg'
                );
                //Se meten los datos del arreglo en el csv
                fputcsv($file, $row);
            }
            //Cerramos el archivo
            fclose($file);
            //Fin del metodo
            exit;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

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
