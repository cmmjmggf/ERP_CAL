<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}

class ReporteExplosionConProyeccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteExplosionProyeccion_model')
                ->helper('Explosiones_helper')->helper('file');
    }

    public function onReporteExplosionProyeccionExcel() {
        $this->db->query("TRUNCATE TABLE explosion_proyeccion_temp ");
        $cm = $this->ReporteExplosionProyeccion_model;
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $Ano = $this->input->post('Ano');

        $Sem_Compras = $this->input->post('Sem');

        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');

        $Mes = substr($FechaIni, 3, 2);  //Obtenemos el valor del mes 10/10/2018

        $Texto_Mes_Anterior = '';
        $Mes_Anterior = intval($Mes) - 1;

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

        //Definimos arreglo donde guardaremos las semanas
        $semanas_reporte = array();

        //Sacamos la semana anterior
        $Semana_Anterior = intval($Sem) - 1;

        if ($Semana_Anterior > 0) {
            //Consulta semana anterior e inserta lo que devuelve el objeto
            $Explosion = $cm->getRegistros(
                    $Ano, $Semana_Anterior, $Maq, $aMaq, $Tipo, $Texto_Mes_Anterior, $FechaIni, $FechaFin, $Sem_Compras
            );
            $ExplosionCant = 0;
            foreach ($Explosion as $key => $D) {

                //Insertamos la explosion en la tabla temporal
                $this->db->insert("explosion_proyeccion_temp", array(
                    'Grupo' => $D->Grupo,
                    'Articulo' => $D->Articulo,
                    'Descripcion' => $D->Descripcion,
                    'Unidad' => $D->Unidad,
                    'Inicial' => $D->Inv_Ini,
                    'Entradas' => $D->Entradas,
                    'Salidas' => $D->Salidas,
                    'Actual' => ($D->Inv_Ini + $D->Entradas) - $D->Salidas,
                    'OrdCom' => $D->FolioOrden,
                    'FechaCom' => $D->FechaOrden,
                    'Pedido' => $D->CantPedida,
                    'Recibido' => $D->CantEntregada,
                    'SemAnt' => $D->Explosion
                ));
            }
            //Grabamos titulo anterior del reporte
            array_push($semanas_reporte, $Semana_Anterior);
        } else {
            //sólo insertamos vacio en la leyenda del reporte semana anterior
            array_push($semanas_reporte, '');
        }

        //Saca la semana actual y posteriores
        $Cont = 1; //Iniciamos con la semana principal
        while ($Cont <= 6) {//El ciclo dura 6 veces por que son 6 semanas las posteriores en el reporte
            if ($Sem <= 53) {//Mientras sea menor a las semanas del año sigue incrementando la semana
                //Se va consultando por cada semana los registros y se insertan en la columna de la semana que le corresponda
                $Explosion = $cm->getRegistros(
                        $Ano, $Sem, $Maq, $aMaq, $Tipo, $Texto_Mes_Anterior, $FechaIni, $FechaFin, $Sem_Compras
                );
                $ExplosionCant = 0;
                foreach ($Explosion as $key => $D) {
                    //Insertamos la explosion en la tabla temporal
                    $this->db->insert("explosion_proyeccion_temp", array(
                        'Grupo' => $D->Grupo,
                        'Articulo' => $D->Articulo,
                        'Descripcion' => $D->Descripcion,
                        'Unidad' => $D->Unidad,
                        'Inicial' => $D->Inv_Ini,
                        'Entradas' => $D->Entradas,
                        'Salidas' => $D->Salidas,
                        'Actual' => ($D->Inv_Ini + $D->Entradas) - $D->Salidas,
                        'OrdCom' => $D->FolioOrden,
                        'FechaCom' => $D->FechaOrden,
                        'Pedido' => $D->CantPedida,
                        'Recibido' => $D->CantEntregada,
                        "Sem{$Cont}" => $D->Explosion
                    ));
                }
                //Grabamos titulos de semana actual y posteriores para el reporte
                array_push($semanas_reporte, $Sem);
                $Sem++;
            }
            $Cont ++; //Incrementamos cada ves para aumentar la semana
        }

        // **************Reporte*************** */
        $Pares = $cm->getPares($Ano, $Sem_Compras, $Maq, $aMaq);
        $Grupos = $cm->getGruposReporte();
        $Articulos = $cm->getDetalleReporte();

        if (!empty($Grupos)) {

            $TipoE = '';
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

            $objPHPExcel = new Excel();
            $objPHPExcel->setActiveSheetIndex(0);

            //Ancho de columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("35");

            // Encabezado
            $from = "A1";
            $to = "V7";
            $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, utf8_decode($_SESSION["EMPRESA_RAZON"]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'FECHA:');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, Date('d/m/Y H:i:s'));

            //nombre reporte
            $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Explosión con Proyección de la maquila: " . $Maq . " a la maq: " . $aMaq . " del año: " . $Ano);

            //tipo reporte y pares
            $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
            $objPHPExcel->getActiveSheet()->setCellValue('A3', "Tipo: " . $TipoE);
            $objPHPExcel->getActiveSheet()->mergeCells('G3:I3');
            $objPHPExcel->getActiveSheet()->setCellValue('G3', "Pares: " . $Pares[0]->Pares);

            //titulos 1
            $objPHPExcel->getActiveSheet()->mergeCells('A5:B7');
            $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Artículo');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C7');
            $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Unidad');
            $objPHPExcel->getActiveSheet()->mergeCells('D5:D7');

            $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Exis. Inicial');
            $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->mergeCells('E5:F5');

            $objPHPExcel->getActiveSheet()->mergeCells('G5:G7');
            $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Exis. Inicial');
            $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->mergeCells('H5:K5');

            $objPHPExcel->getActiveSheet()->mergeCells('L5:M5');
            $objPHPExcel->getActiveSheet()->setCellValue('L5', 'Necesidad');
            $objPHPExcel->getActiveSheet()->mergeCells('N5:R5');
            $objPHPExcel->getActiveSheet()->setCellValue('N5', 'Proyección Semanas');
            //titulos 2
            $objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
            $objPHPExcel->getActiveSheet()->setCellValue('E6', 'Movimientos');

            $objPHPExcel->getActiveSheet()->mergeCells('H6:K6');
            $objPHPExcel->getActiveSheet()->setCellValue('H6', 'En transito');

            $objPHPExcel->getActiveSheet()->setCellValue('L6', 'Anterior');
            $objPHPExcel->getActiveSheet()->setCellValue('M6', 'Actual');

            $objPHPExcel->getActiveSheet()->mergeCells('N6:R6');

            //titulos 3
            $objPHPExcel->getActiveSheet()->setCellValue('E7', 'Entró');
            $objPHPExcel->getActiveSheet()->setCellValue('F7', 'Salió');
            $objPHPExcel->getActiveSheet()->setCellValue('H7', 'O.C.');
            $objPHPExcel->getActiveSheet()->setCellValue('I7', 'Fecha');
            $objPHPExcel->getActiveSheet()->setCellValue('J7', 'Pedido');
            $objPHPExcel->getActiveSheet()->setCellValue('K7', 'Transito');
            $objPHPExcel->getActiveSheet()->setCellValue('L7', isset($semanas_reporte[0]) ? $semanas_reporte[0] : '');

            $objPHPExcel->getActiveSheet()->setCellValue('M7', isset($semanas_reporte[1]) ? $semanas_reporte[1] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('N7', isset($semanas_reporte[2]) ? $semanas_reporte[2] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('O7', isset($semanas_reporte[3]) ? $semanas_reporte[3] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('P7', isset($semanas_reporte[4]) ? $semanas_reporte[4] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q7', isset($semanas_reporte[5]) ? $semanas_reporte[5] : '');
            $objPHPExcel->getActiveSheet()->setCellValue('R7', isset($semanas_reporte[6]) ? $semanas_reporte[6] : '');

            /** Borders for heading */
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            //Formato de celdas
            $row = 8;
            $row_group = 9;
            foreach ($Grupos as $key => $G) {
                $objPHPExcel->getActiveSheet()->getStyle("A$row:C$row")->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Grupo:');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $G->ClaveGrupo . ' ' . $G->NombreGrupo);
                $objPHPExcel->getActiveSheet()->mergeCells("C$row:R$row");
                $row++;
                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->ClaveGrupo) {
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                        $objPHPExcel->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('M' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('N' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('O' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('P' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('Q' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                        $objPHPExcel->getActiveSheet()->getStyle('R' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $D->Articulo);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $D->Descripcion);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $D->Unidad);

                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, ($D->Inicial <> 0) ? $D->Inicial : '' );
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, ($D->Entradas <> 0) ? $D->Entradas : '');
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, ($D->Salidas <> 0) ? $D->Salidas : '' );
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, ($D->Actual <> 0) ? $D->Actual : '');

                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $D->OrdCom);
                        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $D->FechaCom);
                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, ($D->Pedido <> 0) ? $D->Pedido : '');
                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, ($D->Recibido <> 0) ? $D->Recibido : '');

                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, ($D->Anterior <> 0) ? $D->Anterior : '' );
                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, ($D->Sem1 <> 0) ? $D->Sem1 : '');
                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, ($D->Sem2 <> 0) ? $D->Sem2 : '' );
                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, ($D->Sem3 <> 0) ? $D->Sem3 : '');
                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, ($D->Sem4 <> 0) ? $D->Sem4 : '');
                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, ($D->Sem5 <> 0) ? $D->Sem5 : '' );
                        $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, ($D->Sem6 <> 0) ? $D->Sem6 : '');
                        $row++;
                    }
                }
                //Total por grupos

                $objPHPExcel->getActiveSheet()->getStyle('D' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('N' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('O' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('P' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('Q' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $objPHPExcel->getActiveSheet()->getStyle('R' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $objPHPExcel->getActiveSheet()->getStyle("A$row:R$row")->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Total por Grupo:');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, "=SUM(D$row_group:D" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, "=SUM(E$row_group:E" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, "=SUM(F$row_group:F" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, "=SUM(G$row_group:G" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, "=SUM(J$row_group:J" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, "=SUM(K$row_group:K" . ($row - 1) . ")");

                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, "=SUM(L$row_group:L" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, "=SUM(M$row_group:M" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, "=SUM(N$row_group:N" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, "=SUM(O$row_group:O" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, "=SUM(P$row_group:P" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, "=SUM(Q$row_group:Q" . ($row - 1) . ")");
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, "=SUM(R$row_group:R" . ($row - 1) . ")");
                $row_group = $row + 1;
                $row++;
            }
            //Total general

            /* FIN RESUMEN */
            $objPHPExcel->getActiveSheet()->getStyle("A5:R" . ($row - 1))->applyFromArray($styleArray);


            // Rename sheet
            $objPHPExcel->getActiveSheet()->setTitle('Hoja1');


            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES CON EXISTENCIA-ORD COM Y CON PROYECCION A 5 SEMANAS " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Explosion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        }
    }

    public function onReporteExplosionProyeccion() {
        $this->db->query("TRUNCATE TABLE explosion_proyeccion_temp ");
        $cm = $this->ReporteExplosionProyeccion_model;
        $Tipo = $this->input->post('Tipo');
        $Maq = $this->input->post('Maq');
        $aMaq = $this->input->post('aMaq');
        $Sem = $this->input->post('Sem');
        $Ano = $this->input->post('Ano');

        $Sem_Compras = $this->input->post('Sem');

        $FechaIni = $this->input->post('FechaIni');
        $FechaFin = $this->input->post('FechaFin');

        $Mes = substr($FechaIni, 3, 2);  //Obtenemos el valor del mes 10/10/2018

        $Texto_Mes_Anterior = '';
        $Mes_Anterior = intval($Mes) - 1;

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

        //Definimos arreglo donde guardaremos las semanas
        $semanas_reporte = array();

        //Sacamos la semana anterior
        $Semana_Anterior = intval($Sem) - 1;

        if ($Semana_Anterior > 0) {
            //Consulta semana anterior e inserta lo que devuelve el objeto
            $Explosion = $cm->getRegistros(
                    $Ano, $Semana_Anterior, $Maq, $aMaq, $Tipo, $Texto_Mes_Anterior, $FechaIni, $FechaFin, $Sem_Compras
            );
            $ExplosionCant = 0;
            foreach ($Explosion as $key => $D) {

                //Insertamos la explosion en la tabla temporal
                $this->db->insert("explosion_proyeccion_temp", array(
                    'Grupo' => $D->Grupo,
                    'Articulo' => $D->Articulo,
                    'Descripcion' => $D->Descripcion,
                    'Unidad' => $D->Unidad,
                    'Inicial' => $D->Inv_Ini,
                    'Entradas' => $D->Entradas,
                    'Salidas' => $D->Salidas,
                    'Actual' => ($D->Inv_Ini + $D->Entradas) - $D->Salidas,
                    'OrdCom' => $D->FolioOrden,
                    'FechaCom' => $D->FechaOrden,
                    'Pedido' => $D->CantPedida,
                    'Recibido' => $D->CantEntregada,
                    'SemAnt' => $D->Explosion
                ));
            }
            //Grabamos titulo anterior del reporte
            array_push($semanas_reporte, $Semana_Anterior);
        } else {
            //sólo insertamos vacio en la leyenda del reporte semana anterior
            array_push($semanas_reporte, '');
        }

        //Saca la semana actual y posteriores
        $Cont = 1; //Iniciamos con la semana principal
        while ($Cont <= 6) {//El ciclo dura 6 veces por que son 6 semanas las posteriores en el reporte
            if ($Sem <= 53) {//Mientras sea menor a las semanas del año sigue incrementando la semana
                //Se va consultando por cada semana los registros y se insertan en la columna de la semana que le corresponda
                $Explosion = $cm->getRegistros(
                        $Ano, $Sem, $Maq, $aMaq, $Tipo, $Texto_Mes_Anterior, $FechaIni, $FechaFin, $Sem_Compras
                );
                $ExplosionCant = 0;
                foreach ($Explosion as $key => $D) {
                    //Insertamos la explosion en la tabla temporal
                    $this->db->insert("explosion_proyeccion_temp", array(
                        'Grupo' => $D->Grupo,
                        'Articulo' => $D->Articulo,
                        'Descripcion' => $D->Descripcion,
                        'Unidad' => $D->Unidad,
                        'Inicial' => $D->Inv_Ini,
                        'Entradas' => $D->Entradas,
                        'Salidas' => $D->Salidas,
                        'Actual' => ($D->Inv_Ini + $D->Entradas) - $D->Salidas,
                        'OrdCom' => $D->FolioOrden,
                        'FechaCom' => $D->FechaOrden,
                        'Pedido' => $D->CantPedida,
                        'Recibido' => $D->CantEntregada,
                        "Sem{$Cont}" => $D->Explosion
                    ));
                }
                //Grabamos titulos de semana actual y posteriores para el reporte
                array_push($semanas_reporte, $Sem);
                $Sem++;
            }
            $Cont ++; //Incrementamos cada ves para aumentar la semana
        }

        // **************Reporte*************** */

        $Pares = $cm->getPares($Ano, $Sem_Compras, $Maq, $aMaq);
        $Grupos = $cm->getGruposReporte();
        $Articulos = $cm->getDetalleReporte();


        if (!empty($Grupos)) {

            $pdf = new ExplosionProyeccion('L', 'mm', array(215.9, 279.4));

            $TipoE = '';
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

            $pdf->Maq = $Maq;
            $pdf->aMaq = $aMaq;
            $pdf->TipoE = $TipoE;
            $pdf->Ano = $Ano;
            $pdf->Titulos = $semanas_reporte;
            $pdf->Pares = $Pares[0]->Pares;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);

            foreach ($Grupos as $key => $G) {

                $pdf->SetLineWidth(0.5);
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(15, 4, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(38, 4, utf8_decode($G->ClaveGrupo . '    ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);

                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->ClaveGrupo) {
                        $pdf->SetFont('Calibri', '', 7);
                        $pdf->SetX(5);
                        $pdf->Cell(10, 3.5, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(40, 3.5, mb_strimwidth(utf8_decode($D->Descripcion), 0, 35, ""), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 3.5, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Inicial <> 0) ? number_format($D->Inicial, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 3.5, ($D->Entradas <> 0) ? number_format($D->Entradas, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 3.5, ($D->Salidas <> 0) ? number_format($D->Salidas, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Actual <> 0) ? number_format($D->Actual, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 3.5, mb_strimwidth(utf8_decode($D->OrdCom), 0, 10, ""), 'TBL'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, utf8_decode($D->FechaCom), 'TBL'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 3.5, ($D->Pedido <> 0) ? number_format($D->Pedido, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 3.5, ($D->Recibido <> 0) ? number_format($D->Recibido, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Anterior <> 0) ? number_format($D->Anterior, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem1 <> 0) ? number_format($D->Sem1, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem2 <> 0) ? number_format($D->Sem2, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem3 <> 0) ? number_format($D->Sem3, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem4 <> 0) ? number_format($D->Sem4, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem5 <> 0) ? number_format($D->Sem5, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 3.5, ($D->Sem6 <> 0) ? number_format($D->Sem6, 2, ".", ",") : '', 'TRBL'/* BORDE */, 1, 'R');
                    }
                }
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Explosion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "EXPLOSION MATERIALES CON EXISTENCIA-ORD COM Y CON PROYECCION A 5 SEMANAS " . ' ' . date("d-m-Y his");
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
