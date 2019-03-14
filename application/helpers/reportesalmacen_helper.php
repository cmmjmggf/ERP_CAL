<?php

class PDFAlm extends FPDF {

    public $Sem;
    public $Maq;
    public $Doc;

    function getSem() {
        return $this->Sem;
    }

    function getMaq() {
        return $this->Maq;
    }

    function getDoc() {
        return $this->Doc;
    }

    function setSem($Sem) {
        $this->Sem = $Sem;
    }

    function setMaq($Maq) {
        $this->Maq = $Maq;
    }

    function setDoc($Doc) {
        $this->Doc = $Doc;
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
        $this->Cell(60, 4, utf8_decode("Entrada al Almacén"), 0/* BORDE */, 1, 'L');


        $this->SetX(36);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, utf8_decode("Doc."), 0/* BORDE */, 0, 'L');
        $this->SetX(46);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(30, 4, utf8_decode($this->getDoc()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(76);
        $this->Cell(20, 4, utf8_decode("De la maq. "), 0/* BORDE */, 0, 'L');
        $this->SetX(96);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getMaq()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(106);
        $this->Cell(10, 4, utf8_decode("Sem "), 0/* BORDE */, 0, 'L');
        $this->SetX(116);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getSem()), 0/* BORDE */, 1, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0/* 0 */, 90/* 1 */, 13/* 2 */, 16/* 3 */, 16/* 4 */, 16/* 5 */, 26/* 6 */, 26/* 7 */);
        $aligns = array('R', 'L', 'L', 'L', 'L', 'L', 'C', 'C');

        $this->SetY(22);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array('', utf8_decode('Artículo'), 'Cant.', 'U.M.', 'Precio', 'Subtotal', utf8_decode('Fecha'), 'T. Mov.'));

        $anchos = array(10/* 0 */, 80/* 1 */, 13/* 2 */, 16/* 3 */, 16/* 4 */, 16/* 5 */, 26/* 6 */, 26/* 7 */);
        $aligns = array('R', 'L', 'L', 'L', 'L', 'L', 'C', 'C');
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

    function Row($data) {
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
            $this->MultiCell($w, 4, $data[$i], 'B', $a);
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

class PDFSalidaAlm extends FPDF {

    public $Sem;
    public $Maq;
    public $Doc;

    function getSem() {
        return $this->Sem;
    }

    function getMaq() {
        return $this->Maq;
    }

    function getDoc() {
        return $this->Doc;
    }

    function setSem($Sem) {
        $this->Sem = $Sem;
    }

    function setMaq($Maq) {
        $this->Maq = $Maq;
    }

    function setDoc($Doc) {
        $this->Doc = $Doc;
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
        $this->Cell(60, 4, utf8_decode("Salida del Almacén"), 0/* BORDE */, 1, 'L');


        $this->SetX(36);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, utf8_decode("Doc."), 0/* BORDE */, 0, 'L');
        $this->SetX(46);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(30, 4, utf8_decode($this->getDoc()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(76);
        $this->Cell(20, 4, utf8_decode("De la maq. "), 0/* BORDE */, 0, 'L');
        $this->SetX(96);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getMaq()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(106);
        $this->Cell(10, 4, utf8_decode("Sem "), 0/* BORDE */, 0, 'L');
        $this->SetX(116);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getSem()), 0/* BORDE */, 1, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0/* 0 */, 90/* 1 */, 13/* 2 */, 16/* 3 */, 16/* 4 */, 16/* 5 */, 26/* 6 */, 26/* 7 */);
        $aligns = array('R', 'L', 'L', 'L', 'L', 'L', 'C', 'C');

        $this->SetY(22);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array('', utf8_decode('Artículo'), 'Cant.', 'U.M.', 'Precio', 'Subtotal', utf8_decode('Fecha'), 'T. Mov.'));

        $anchos = array(10/* 0 */, 80/* 1 */, 13/* 2 */, 16/* 3 */, 16/* 4 */, 16/* 5 */, 26/* 6 */, 26/* 7 */);
        $aligns = array('R', 'L', 'L', 'L', 'L', 'L', 'C', 'C');
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

    function Row($data) {
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
            $this->MultiCell($w, 4, $data[$i], 'B', $a);
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
