<?php

class PDFInspeccion extends FPDF {

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 10);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(70, 4, utf8_decode("Material inspeccionado por control de calidad de la fecha: "), 0/* BORDE */, 0, 'L');



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

        $this->SetY(19);
        $this->SetX(77);
        $this->SetFont('Calibri', 'B', 7.5);
        $this->Cell(30, 10, 'Cantidades', 'LRT'/* BORDE */, 0, 'C');


        $this->SetX(128);
        $this->Cell(16.5, 10, 'Hojas', 'LRT'/* BORDE */, 0, 'C');


        $this->SetX(144.5);
        $this->Cell(10.5, 10, '% X Hoja', 'LRT'/* BORDE */, 0, 'C');

        $this->SetX(213);
        $this->Cell(30, 10, 'Aprovechamiento Real', 'LRT'/* BORDE */, 0, 'C');

        $this->SetX(243);
        $this->Cell(32, 10, 'Partidas', 'LRT'/* BORDE */, 0, 'C');

        $this->SetY(25);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(
            12/* 1 O.C. */,
            10/* 2 Doc */,
            0/* 3 MAT */,
            40/* 4  */,
            9/* 5  PRECIO */,
            10/* 6  CANTIDAD REC */,
            10/* 7   Devuelta */,
            10/* 8 Real */,
            10/* 9 APRV */,
            11/* 10 Merma */,
            9/* 11 HOJA REC */,
            9/* 12  Conta */,
            10/* 13 DM2 */,
            22/* 14 DETALLE */,
            9/* 15  1 */,
            9/* 16 2 */,
            9/* 17 3 */,
            9/* 18 4 */,
            10/* 19 Selecta */,
            10/* 20 90/10 */,
            10/* 21 80/20 */,
            16/* 22 Inicial */,
            16/* 23 Final */);
        $aligns = array('L', 'C', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'L', 'R', 'R', 'R', 'R', 'C', 'C', 'C', 'C', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 7.5);
        $this->Row(array(
            'Ord-Com',
            'Doc',
            '',
            'Material',
            'Precio',
            'Recib',
            'Dev',
            'Real',
            'Aprov',
            'Merma',
            'Recib',
            'Conta',
            'Dm2',
            'Detalle',
            '1ra',
            '2da',
            '3ra',
            '4ta',
            'Selecta',
            '90/10',
            '80/20',
            'Inicial',
            'Final'), 'B');

        $aligns = array('L', 'L', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'L');
        $anchos = array(
            12/* 1 O.C. */,
            10/* 2 Doc */,
            10/* 3 MAT */,
            30/* 4  */,
            9/* 5  PRECIO */,
            10/* 6  CANTIDAD REC */,
            10/* 7   Devuelta */,
            10/* 8 Real */,
            10/* 9 APRV */,
            11/* 10 Merma */,
            9/* 11 HOJA REC */,
            9/* 12  Conta */,
            10/* 13 DM2 */,
            22/* 14 DETALLE */,
            9/* 15  1 */,
            9/* 16 2 */,
            9/* 17 3 */,
            9/* 18 4 */,
            10/* 19 Selecta */,
            10/* 20 90/10 */,
            10/* 21 80/20 */,
            17/* 22 Inicial */,
            17/* 23 Final */);
        $this->SetAligns($aligns);
        $this->SetWidths($anchos);
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

    public $Fecha;
    public $AFecha;

    function getFecha() {
        return $this->Fecha;
    }

    function getAFecha() {
        return $this->AFecha;
    }

    function setFecha($Fecha) {
        $this->Fecha = $Fecha;
    }

    function setAFecha($AFecha) {
        $this->AFecha = $AFecha;
    }

    function Header() {

        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 10);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(70, 4, utf8_decode("Material inspeccionado por control de calidad de la fecha: "), 0/* BORDE */, 0, 'L');


        $this->SetX(112);
        $this->SetFont('Calibri', '', 9);
        $this->Cell(25, 4, utf8_decode($this->getFecha()), 0/* BORDE */, 0, 'C');


        $this->SetX(135);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(140);
        $this->SetFont('Calibri', '', 9);
        $this->Cell(25, 4, utf8_decode($this->getAfecha()), 0/* BORDE */, 0, 'C');
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

        $this->SetY(19);
        $this->SetX(77);
        $this->SetFont('Calibri', 'B', 7.5);
        $this->Cell(30, 10, 'Cantidades', 'LRT'/* BORDE */, 0, 'C');


        $this->SetX(128);
        $this->Cell(16.5, 10, 'Hojas', 'LRT'/* BORDE */, 0, 'C');


        $this->SetX(144.5);
        $this->Cell(10.5, 10, '% X Hoja', 'LRT'/* BORDE */, 0, 'C');

        $this->SetX(213);
        $this->Cell(30, 10, 'Aprovechamiento Real', 'LRT'/* BORDE */, 0, 'C');

        $this->SetX(243);
        $this->Cell(32, 10, 'Partidas', 'LRT'/* BORDE */, 0, 'C');

        $this->SetY(25);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(
            12/* 1 O.C. */,
            10/* 2 Doc */,
            0/* 3 MAT */,
            40/* 4  */,
            9/* 5  PRECIO */,
            10/* 6  CANTIDAD REC */,
            10/* 7   Devuelta */,
            10/* 8 Real */,
            10/* 9 APRV */,
            11/* 10 Merma */,
            9/* 11 HOJA REC */,
            9/* 12  Conta */,
            10/* 13 DM2 */,
            22/* 14 DETALLE */,
            9/* 15  1 */,
            9/* 16 2 */,
            9/* 17 3 */,
            9/* 18 4 */,
            10/* 19 Selecta */,
            10/* 20 90/10 */,
            10/* 21 80/20 */,
            16/* 22 Inicial */,
            16/* 23 Final */);
        $aligns = array('L', 'C', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'L', 'R', 'R', 'R', 'R', 'C', 'C', 'C', 'C', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 7.5);
        $this->Row(array(
            'Ord-Com',
            'Doc',
            '',
            'Material',
            'Precio',
            'Recib',
            'Dev',
            'Real',
            'Aprov',
            'Merma',
            'Recib',
            'Conta',
            'Dm2',
            'Detalle',
            '1ra',
            '2da',
            '3ra',
            '4ta',
            'Selecta',
            '90/10',
            '80/20',
            'Inicial',
            'Final'), 'B');

        $aligns = array('L', 'L', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'L', 'L');
        $anchos = array(
            12/* 1 O.C. */,
            10/* 2 Doc */,
            10/* 3 MAT */,
            30/* 4  */,
            9/* 5  PRECIO */,
            10/* 6  CANTIDAD REC */,
            10/* 7   Devuelta */,
            10/* 8 Real */,
            10/* 9 APRV */,
            11/* 10 Merma */,
            9/* 11 HOJA REC */,
            9/* 12  Conta */,
            10/* 13 DM2 */,
            22/* 14 DETALLE */,
            9/* 15  1 */,
            9/* 16 2 */,
            9/* 17 3 */,
            9/* 18 4 */,
            10/* 19 Selecta */,
            10/* 20 90/10 */,
            10/* 21 80/20 */,
            17/* 22 Inicial */,
            17/* 23 Final */);
        $this->SetAligns($aligns);
        $this->SetWidths($anchos);
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
