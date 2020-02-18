<?php

class PDF_ExisAnual extends FPDF {

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(35, 4, utf8_decode("Existencia anual por mes"), 0/* BORDE */, 0, 'L');


        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetFont('Calibri', 'B', 9);
        $this->SetY(20);
        $this->SetX(5);
        $this->Cell(53, 4, utf8_decode("Artículo"), 'B'/* BORDE */, 0, 'L');
        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(18/* 0 */, 18/* 1 */, 18/* 2 */, 18/* 3 */, 18/* 4 */, 18/* 5 */, 18/* 6 */, 18/* 7 */, 18/* 8 */, 18/* 9 */, 18/* 10 */, 18/* 11 */);
        $aligns = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');

        $this->SetY(20);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'), 1);

        $anchos = array(18/* 0 */, 18/* 1 */, 18/* 2 */, 18/* 3 */, 18/* 4 */, 18/* 5 */, 18/* 6 */, 18/* 7 */, 18/* 8 */, 18/* 9 */, 18/* 10 */, 18/* 11 */);
        $aligns = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
    }

    var $widths;
    var $aligns;
    var $x;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function SetMarginLeft($x) {
        //Set margin left where the row inits
        $this->x = $x;
    }

    function Row($data, $border) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(58);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

class PDF_Etiquetas extends FPDF {

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 2, 2/* TOP */, /* ANCHO */ 20);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(2);
        $this->SetX(23);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 0, 'L');

        $this->SetY(2);
        $this->SetX(68);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode(date("d-m-Y")), 0/* BORDE */, 0, 'R');

        $this->SetLineWidth(0.5);
        $this->SetY(17);
        $this->SetX(3);
        $this->Cell(46, 25, '', 1/* BORDE */, 0, 'L');

        $this->SetY(17);
        $this->SetX(51);
        $this->Cell(46, 25, '', 1/* BORDE */, 0, 'L');
    }

}

class PDF_CostoInv extends FPDF {

    private $mes;

    function getMes() {
        return $this->mes;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function Header() {

        $Texto = '';
        switch ($this->getMes()) {
            case 'Ene':
                $Texto = 'AL 31 DE ENERO';

                break;
            case 'Feb':
                $Texto = 'AL 28 DE FEBRERO';

                break;
            case 'Mar':
                $Texto = 'AL 31 DE MARZO';

                break;
            case 'Abr':
                $Texto = 'AL 30 DE ABRIL';

                break;
            case 'May':
                $Texto = 'AL 31 DE MAYO';

                break;
            case 'Jun':
                $Texto = 'AL 30 DE JUNIO';

                break;
            case 'Jul':
                $Texto = 'AL 31 DE JULIO';

                break;
            case 'Ago':
                $Texto = 'AL 31 DE AGOSTO';

                break;
            case 'Sep':
                $Texto = 'AL 30 DE SEPTIEMBRE';

                break;
            case 'Oct':
                $Texto = 'AL 31 DE OCTUBRE';

                break;
            case 'Nov':
                $Texto = 'AL 30 DE NOVIEMBRE';

                break;
            case 'Dic':
                $Texto = 'AL 31 DE DICIEMBRE';

                break;
        }


        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode("Costeo de inventario del grupo"), 0/* BORDE */, 0, 'L');
        $this->SetX(96);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(8, 4, utf8_decode($Texto), 0/* BORDE */, 0, 'C');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {
            totalPages
        }'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {
            totalPages
        }');


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(15/* 0 */, 70/* 1 */, 12/* 2 */, 25/* 3 */, 25/* 4 */, 25/* 5 */);
        $aligns = array('R', 'L', 'C', 'R', 'R', 'R');

        $this->SetY(17);
        $this->SetX(15);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M.', 'Costo', 'Existencia', 'Total Costo'), 'B');

        $anchos = array(15/* 0 */, 70/* 1 */, 12/* 2 */, 25/* 3 */, 25/* 4 */, 25/* 5 */);
        $aligns = array('R', 'L', 'C', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
    }

    var $widths;
    var $aligns;
    var $x;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function SetMarginLeft($x) {
        //Set margin left where the row inits
        $this->x = $x;
    }

    function Row($data, $border) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(15);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3.5, $data[$i], $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

class PDF_Ajustes extends FPDF {

    private $mes;
    private $ano;
    public $mov;

    function getMov() {
        return $this->mov;
    }

    function setMov($mov) {
        $this->mov = $mov;
    }

    function getMes() {
        return $this->mes;
    }

    function getAno() {
        return $this->ano;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(80, 4, utf8_decode("Movimientos de entradas y salidas X ajuste del mes: "), 0/* BORDE */, 0, 'L');
        $this->SetX(116);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(8, 4, utf8_decode($this->getMes()), 0/* BORDE */, 0, 'C');
        $this->SetX(124);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, utf8_decode("del: "), 0/* BORDE */, 0, 'C');
        $this->SetX(134);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAno()), 0/* BORDE */, 1, 'C');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(10, 4, utf8_decode('Mov: '), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 10);
        $this->SetX(46);
        $this->Cell(10, 4, utf8_decode($this->getMov()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {
            totalPages
        }'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {
            totalPages
        }');



        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0.1/* 0 */, 59.9/* 1 */, 12/* 2 */, 16/* 3 */, 10/* 4 */, 18/* 5 */, 18/* 6 */, 14/* 7 */, 19/* 8 */, 19/* 9 */, 9.5/* 10 */, 9.5/* 11 */);
        $aligns = array('R', 'L', 'C', 'C', 'C', 'R', 'R', 'R', 'R', 'R', 'C', 'C');

        $this->SetY(20);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->SetFont('Calibri', 'B', 8);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M.', 'Fecha.', 'Mov.', 'Entradas', 'Salidas', 'Precio', 'Total Ent', 'Total Sal', 'Sem', 'Maq'), 'B');

        $anchos = array(10/* 0 */, 50/* 1 */, 12/* 2 */, 16/* 3 */, 10/* 4 */, 18/* 5 */, 18/* 6 */, 14/* 7 */, 19/* 8 */, 19/* 9 */, 9.5/* 10 */, 9.5/* 11 */);
        $aligns = array('R', 'L', 'C', 'C', 'C', 'R', 'R', 'R', 'R', 'R', 'C', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
    }

    var $widths;
    var $aligns;
    var $x;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function SetMarginLeft($x) {
        //Set margin left where the row inits
        $this->x = $x;
    }

    function Row($data, $border) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(5);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

class PDF_ComparativoInv extends FPDF {

    public $mes;
    public $maq;

    function getMes() {
        return $this->mes;
    }

    function getMaq() {
        return $this->maq;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setMaq($maq) {
        $this->maq = $maq;
    }

    function Header() {
        $Texto = '';
        switch ($this->getMes()) {
            case '1':
                $Texto = 'AL 31 DE ENERO';

                break;
            case '2':
                $Texto = 'AL 28 DE FEBRERO';

                break;
            case '3':
                $Texto = 'AL 31 DE MARZO';

                break;
            case '4':
                $Texto = 'AL 30 DE ABRIL';

                break;
            case '5':
                $Texto = 'AL 31 DE MAYO';

                break;
            case '6':
                $Texto = 'AL 30 DE JUNIO';

                break;
            case '7':
                $Texto = 'AL 31 DE JULIO';

                break;
            case '8':
                $Texto = 'AL 31 DE AGOSTO';

                break;
            case '9':
                $Texto = 'AL 30 DE SEPTIEMBRE';

                break;
            case '10':
                $Texto = 'AL 31 DE OCTUBRE';

                break;
            case '11':
                $Texto = 'AL 30 DE NOVIEMBRE';

                break;
            case '12':
                $Texto = 'AL 31 DE DICIEMBRE';

                break;
        }

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(35, 4, utf8_decode("Mes del inventario: "), 0/* BORDE */, 0, 'L');
        $this->SetX(71);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(5, 4, utf8_decode($this->getMes()), 0/* BORDE */, 0, 'L');
        $this->SetX(77);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(25, 4, utf8_decode($Texto), 0/* BORDE */, 0, 'L');
        $this->SetX(115);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(25, 4, utf8_decode('Planta: ' . $this->getMaq()), 0/* BORDE */, 0, 'L');



        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        /* ENCABEZADO DETALLE TITULOS */
        $this->SetFont('Calibri', 'B', 9);

        /* PRIMER LINEA */
        $this->SetY(18);
        $this->SetX(95);
        $this->Cell(16, 4, utf8_decode('Exist. mes'), 'TLR'/* BORDE */, 0, 'C');
        $this->SetX(143);
        $this->Cell(45, 4, utf8_decode('Existencia'), 'TLR'/* BORDE */, 0, 'C');
        $this->SetX(216);
        $this->Cell(38, 4, utf8_decode('Existencia en $'), 'TLR'/* BORDE */, 0, 'C');


        /* SEGUNDA LINEA */

        $this->SetY(22);
        $this->SetX(5);

        $this->Cell(75, 4, utf8_decode('Articulo'), 'B'/* BORDE */, 0, 'L');
        $this->SetX($this->GetX());
        $this->Cell(15, 4, utf8_decode('U.M.'), 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('anterior'), 'LRB'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Entradas'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Salidas'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Actual'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(13, 4, utf8_decode(''), 'B'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Físico'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Diferencia'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(12, 4, utf8_decode('Precio'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(19, 4, utf8_decode('Actual X Pre'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(19, 4, utf8_decode('Físico X Pre'), 1/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(19, 4, utf8_decode('Dife $'), 1/* BORDE */, 0, 'C');
        $this->SetY(26);
    }

    var $widths;
    var $aligns;
    var $x;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function SetMarginLeft($x) {
        //Set margin left where the row inits
        $this->x = $x;
    }

    function Row($data, $border) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(5);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

class PDF extends FPDF {

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode("Reporte conteo de inventario fisico fecha: ____/____/____"), 0/* BORDE */, 1, 'L');



        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {
            totalPages
        }'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {
            totalPages
        }');



        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0.1/* 0 */, 39.9/* 1 */, 165/* 2 */);
        $aligns = array('L', 'L', 'L');

        $this->SetY(20);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->SetFont('Calibri', 'B', 8);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M.'), 'B');



        $this->SetY(28);
    }

    var $widths;
    var $aligns;
    var $x;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function SetMarginLeft($x) {
        //Set margin left where the row inits
        $this->x = $x;
    }

    function Row($data, $border) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(5);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], $border, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}
