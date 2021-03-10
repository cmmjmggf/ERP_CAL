<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}

class ReporteExplosionConProyeccionSuelas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('ReporteExplosionProyeccion_model')
                ->helper('Explosiones_helper')->helper('file');
    }

    public function onReporteExplosionProyeccionSuelas() {
        $this->db->query("TRUNCATE TABLE explosion_proyeccion_temp; ");
        $this->db->query("truncate table explosion_proyeccion_tallas_temp;");
        $cm = $this->ReporteExplosionProyeccion_model;

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
            $Explosion = $cm->getExplosionTallas(
                    $Ano, $Semana_Anterior, $Maq, $aMaq
            );
            $ExplosionCant = 0;
            foreach ($Explosion as $key => $D) {
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
                            //Insertamos la explosion en la tabla temporal
                            $this->db->query("INSERT INTO explosion_proyeccion_temp
                                             (Grupo,Articulo,Descripcion,Unidad,Talla,SemAnt) VALUES
                                            ({$D->Grupo},$Articulo,'{$D->Descripcion}','{$D->Unidad}',$Talla,$Exp_Acum) ");
                        }
                    } else {
                        if ($Exp_Acum > 0) {
                            $Articulo = $D->{"A$i"};
                            //Insertamos la explosion en la tabla temporal
                            $this->db->query("INSERT INTO explosion_proyeccion_temp
                                             (Grupo,Articulo,Descripcion,Unidad,Talla,SemAnt) VALUES
                                            ({$D->Grupo},$Articulo,'{$D->Descripcion}','{$D->Unidad}',$Talla,$Exp_Acum) ");
                        }
                        $Talla = $D->{"T$sig"};
                        $Exp_Acum = $D->{"C$sig"};
                    }
                }
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
                $Explosion = $cm->getExplosionTallas(
                        $Ano, $Sem, $Maq, $aMaq
                );
                $ExplosionCant = 0;


                foreach ($Explosion as $key => $D) {
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
                                //Insertamos la explosion en la tabla temporal
                                $this->db->query("INSERT INTO explosion_proyeccion_temp
                                             (Grupo,Articulo,Descripcion,Unidad,Talla,Sem{$Cont}) VALUES
                                            ({$D->Grupo},$Articulo,'{$D->Descripcion}','{$D->Unidad}',$Talla,$Exp_Acum) ");
                            }
                        } else {
                            if ($Exp_Acum > 0) {
                                $Articulo = $D->{"A$i"};
                                //Insertamos la explosion en la tabla temporal
                                $this->db->query("INSERT INTO explosion_proyeccion_temp
                                             (Grupo,Articulo,Descripcion,Unidad,Talla,Sem{$Cont}) VALUES
                                            ({$D->Grupo},$Articulo,'{$D->Descripcion}','{$D->Unidad}',$Talla,$Exp_Acum) ");
                            }
                            $Talla = $D->{"T$sig"};
                            $Exp_Acum = $D->{"C$sig"};
                        }
                    }
                }
                //Grabamos titulos de semana actual y posteriores para el reporte
                array_push($semanas_reporte, $Sem);
                $Sem++;
            }
            $Cont++; //Incrementamos cada ves para aumentar la semana
        }
        //Obtenemos la tabla agrupada para eliminar registros que no sirven
        $Desglosado = $this->input->post('Desglosado');
        $ArticulosAgrupados = $cm->onCreaYObtieneTablaTemporalAgrupada($Texto_Mes_Anterior, $Desglosado);

        if (!empty($ArticulosAgrupados)) {
            foreach ($ArticulosAgrupados as $key => $D) {
                //SACA LAS ENTRADAS Y SALIDAS
                $sql = "select MA.Articulo,
                                sum(case when MA.EntradaSalida = '1' then MA.CantidadMov else 0 end) as entradas,
                                sum(case when MA.EntradaSalida = '2' then MA.CantidadMov else 0 end) as salidas
                                from movarticulos MA
                                where MA.Articulo = {$D->Articulo}
                                AND MA.TipoMov <> 'CAN'
                                AND STR_TO_DATE(MA.FechaMov, '%d/%m/%Y') BETWEEN STR_TO_DATE('{$FechaIni}', '%d/%m/%Y') AND STR_TO_DATE('{$FechaFin}', '%d/%m/%Y') ";

                $InfoMovArt = $this->db->query($sql)->result();
                if (!empty($InfoMovArt)) {//Actualizamos cantidades en la tabla si vienen con datos
                    if (floatval($InfoMovArt[0]->entradas) > 0 || floatval($InfoMovArt[0]->salidas > 0)) {
                        //Traemos el saldo final existente, con el saldo inicial mas las entradas menos las salidas
                        $sald_act = ($D->Inicial + $InfoMovArt[0]->entradas) - $InfoMovArt[0]->salidas;
                        $this->db->query("update explosion_proyeccion_tallas_temp set "
                                . "Entradas = {$InfoMovArt[0]->entradas}, "
                                . "Salidas = {$InfoMovArt[0]->salidas}, "
                                . "Actual = {$sald_act} "
                                . "where Articulo = {$D->Articulo} ");
                    }
                }
                //SACA LA INFORMACIÓN DE COMPRAS
                $sqloc = "select SUM(OC.Cantidad) AS Pedida,  SUM(OC.CantidadRecibida) AS Recibida, OC.Folio, OC.FechaOrden
                            from ordencompra OC where OC.Articulo = {$D->Articulo}
                            and OC.Maq BETWEEN $Maq AND $aMaq AND OC.Sem = $Sem_Compras
                            AND OC.Ano = $Ano AND OC.Estatus NOT IN ('CANCELADA') ";

                $InfoOrdComp = $this->db->query($sqloc)->result();
                if (!empty($InfoOrdComp)) {//Actualizamos cantidades en la tabla si vienen con datos
                    if (floatval($InfoOrdComp[0]->Pedida) > 0 || floatval($InfoOrdComp[0]->Recibida > 0)) {
                        $this->db->query("update explosion_proyeccion_tallas_temp set "
                                . "Pedido = {$InfoOrdComp[0]->Pedida}, "
                                . "Recibido = {$InfoOrdComp[0]->Recibida}, "
                                . "OrdCom = {$InfoOrdComp[0]->Folio}, "
                                . "FechaCom = '{$InfoOrdComp[0]->FechaOrden}' "
                                . "where Articulo = {$D->Articulo} ");
                    }
                }
            }


            /*             * *************REPORTE *************** */
            $Pares = $cm->getPares($Ano, $Sem_Compras, $Maq, $aMaq);
            $Grupos = $cm->getGruposReporteTallas();
            $ArticulosRep = $cm->getDetalleReporteTallas();


            $pdf = new ExplosionProyeccion('L', 'mm', array(215.9, 279.4));
            $TipoE = '******* SUELA *******';

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

                foreach ($ArticulosRep as $key => $D) {
                    if ($G->ClaveGrupo === $D->ClaveGrupo) {
                        $pdf->SetFont('Calibri', '', 7);
                        $pdf->SetX(5);
                        $pdf->Cell(10, 3.5, utf8_decode($D->Articulo), 'B'/* BORDE */, 0, 'R');
                        $pdf->SetX($pdf->GetX());
                        $pdf->Cell(40, 3.5, mb_strimwidth(utf8_decode($D->Descripcion), 0, 33, ""), 'B'/* BORDE */, 0, 'L');
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
