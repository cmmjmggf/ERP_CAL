<?php

class PDFDesglose extends FPDF {

    public $ano;
    public $dsem;
    public $asem;

    function getAno() {
        return $this->ano;
    }

    function getDsem() {
        return $this->dsem;
    }

    function getAsem() {
        return $this->asem;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setDsem($dsem) {
        $this->dsem = $dsem;
    }

    function setAsem($asem) {
        $this->asem = $asem;
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
        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode("Artículos x Cliente-Control-Estilo-Consumo de la semana:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(113);
        $this->Cell(8, 4, utf8_decode($this->getDsem()), 0/* BORDE */, 0, 'C');


        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(120);
        $this->Cell(8, 4, utf8_decode("a la:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(128);
        $this->Cell(8, 4, utf8_decode($this->getAsem()), 0/* BORDE */, 1, 'C');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(20, 4, utf8_decode("Del Año:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(50);
        $this->Cell(10, 4, utf8_decode($this->getAno()), 0/* BORDE */, 0, 'C');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetFont('Calibri', 'B', 8);
        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(30/* 0 */, 16/* 1 */, 15/* 2 */, 17/* 3 */, 13/* 4 */, 0.1/* 5 */, 69.9/* 6 */, 10/* 7 */, 10/* 8 */, 14/* 9 */, 10/* 10 */);
        $aligns = array('L', 'L', 'C', 'C', 'C', 'C', 'L', 'C', 'C', 'C', 'C');

        $this->SetY(18);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array(utf8_decode('Artículo'), 'Control', 'Pedido', 'Entrega', 'Estilo', '', 'Cliente', 'Sem', 'Maq', 'Cant.', 'Pares'), 'B');

        $anchos = array(30/* 0 */, 16/* 1 */, 15/* 2 */, 17/* 3 */, 13/* 4 */, 10/* 5 */, 60/* 6 */, 10/* 7 */, 10/* 8 */, 14/* 9 */, 10/* 10 */);
        $aligns = array('L', 'L', 'C', 'C', 'C', 'R', 'L', 'C', 'C', 'R', 'R');
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
        $h = 3.5 * $nb;
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

class PDF extends FPDF {

    public $ano;
    public $sem;

    function getAno() {
        return $this->ano;
    }

    function getSem() {
        return $this->sem;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setSem($sem) {
        $this->sem = $sem;
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
        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode("Material de producción de la semana:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(90);
        $this->Cell(8, 4, utf8_decode($this->getSem()), 0/* BORDE */, 1, 'C');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(20, 4, utf8_decode("Del Año:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(50);
        $this->Cell(10, 4, utf8_decode($this->getAno()), 0/* BORDE */, 0, 'C');


        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(18/* 0 */, 14/* 1 */, 12/* 2 */, 80/* 3 */, 17/* 4 */, 17/* 5 */, 17/* 6 */);
        $aligns = array('L', 'L', 'L', 'L', 'C', 'C', 'C');

        $this->SetY(18);
        $this->SetX(5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array('Control', 'Estilo', 'Color', utf8_decode('Artículo'), 'Cant.', 'U.M.', 'Pares'), 'B');

        $anchos = array(18/* 0 */, 14/* 1 */, 12/* 2 */, 80/* 3 */, 17/* 4 */, 17/* 5 */, 17/* 6 */);
        $aligns = array('L', 'L', 'L', 'L', 'R', 'C', 'C');
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
        $h = 3.5 * $nb;
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
