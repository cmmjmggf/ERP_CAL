<?php

class Concilias extends FPDF {

    public $Maq;
    public $Sem;
    public $Ano;

    function getMaq() {
        return $this->Maq;
    }

    function getSem() {
        return $this->Sem;
    }

    function getAno() {
        return $this->Ano;
    }

    function setMaq($Maq) {
        $this->Maq = $Maq;
    }

    function setSem($Sem) {
        $this->Sem = $Sem;
    }

    function setAno($Ano) {
        $this->Ano = $Ano;
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
        $this->Cell(60, 4, utf8_decode("Concilia de materiales de la maquila: "), 0/* BORDE */, 0, 'L');
        $this->SetX(95);
        $this->Cell(25, 4, utf8_decode("de la semana:"), 0/* BORDE */, 0, 'R');
        $this->SetX(120);
        $this->Cell(25, 4, utf8_decode("del año:"), 0/* BORDE */, 0, 'R');



        $this->SetFont('Calibri', '', 9);
        $this->SetY(9);
        $this->SetX(90);
        $this->Cell(11, 4, $this->getMaq(), 0/* BORDE */, 0, 'C');
        $this->SetY(9);
        $this->SetX(120);
        $this->Cell(11, 4, $this->getSem(), 0/* BORDE */, 0, 'C');
        $this->SetY(9);
        $this->SetX(145);
        $this->Cell(11, 4, $this->getAno(), 0/* BORDE */, 1, 'C');

        //Paginador
        $this->SetY(3);
        $this->SetX(260);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(242);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages('{totalPages}');

        /* ENCABEZADO DETALLE TITULOS */
        $this->SetFont('Calibri', 'B', 8);




        /* PRIMERA LINEA */
        $this->SetLineWidth(0.2);
        $this->SetY(18);
        $this->SetX(5);
        $this->Cell(70, 4, utf8_decode(''), 0/* BORDE */, 0, 'L');
        $this->SetX($this->GetX());
        $this->Cell(12.5, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(12.5, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Diferencia'), 'TRL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(14, 4, utf8_decode(''), 0/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Explosión'), 'TL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Entregado'), 'TL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Devolución'), 'TL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Diferencia'), 'TRL'/* BORDE */, 0, 'C');



        /* SEGUNDA LINEA */

        $this->SetY(22);
        $this->SetX(5);

        $this->Cell(70, 4, utf8_decode('Artículo'), 'B'/* BORDE */, 0, 'L');
        $this->SetX($this->GetX());
        $this->Cell(12.5, 4, utf8_decode('U.M.'), 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(12.5, 4, utf8_decode('Talla'), 'B'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Explosión'), 'TBL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Entregado'), 'TBL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Diferencia'), 'TBL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(16, 4, utf8_decode('Devol'), 'TBL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Ex-En-Dv'), 'BL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(14, 4, utf8_decode('Precio'), 'TBL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('XPrecio'), 'BL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('XPrecio'), 'BL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Pesos'), 'BL'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 4, utf8_decode('Pesos'), 'RBL'/* BORDE */, 0, 'C');

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
