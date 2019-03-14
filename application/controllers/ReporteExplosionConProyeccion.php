<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReporteExplosionConProyeccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteExplosionProyeccion_model')
                ->helper('Explosiones_helper')->helper('file');
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
                //Cálcula explosión en base a tipo ya que se suma el desperdicio si es de piel y forro
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
                    'SemAnt' => $ExplosionCant
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
                    //Cálcula explosión en base a tipo ya que se suma el desperdicio si es de piel y forro
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
                        "Sem{$Cont}" => $ExplosionCant
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
                $pdf->Cell(15, 5, utf8_decode('Grupo: '), 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(38, 5, utf8_decode($G->ClaveGrupo . '    ' . $G->NombreGrupo), 'B'/* BORDE */, 1, 'L');

                $pdf->SetLineWidth(0.2);

                foreach ($Articulos as $key => $D) {
                    if ($G->ClaveGrupo === $D->ClaveGrupo) {
                        $pdf->SetFont('Calibri', '', 7);
                        $pdf->SetX(5);
                        $pdf->Cell(10, 4, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(40, 4, mb_strimwidth(utf8_decode($D->Descripcion), 0, 35, ""), 'B'/* BORDE */, 0, 'L');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(15, 4, utf8_decode($D->Unidad), 'B'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Inicial <> 0) ? number_format($D->Inicial, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, ($D->Entradas <> 0) ? number_format($D->Entradas, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, ($D->Salidas <> 0) ? number_format($D->Salidas, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Actual <> 0) ? number_format($D->Actual, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(12, 4, mb_strimwidth(utf8_decode($D->OrdCom), 0, 10, ""), 'TBL'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, utf8_decode($D->FechaCom), 'TBL'/* BORDE */, 0, 'C');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, ($D->Pedido <> 0) ? number_format($D->Pedido, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(13, 4, ($D->Recibido <> 0) ? number_format($D->Recibido, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Anterior <> 0) ? number_format($D->Anterior, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem1 <> 0) ? number_format($D->Sem1, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem2 <> 0) ? number_format($D->Sem2, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem3 <> 0) ? number_format($D->Sem3, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem4 <> 0) ? number_format($D->Sem4, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem5 <> 0) ? number_format($D->Sem5, 2, ".", ",") : '', 'TBL'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(14, 4, ($D->Sem6 <> 0) ? number_format($D->Sem6, 2, ".", ",") : '', 'TRBL'/* BORDE */, 1, 'R');
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
