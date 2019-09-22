<?php

class PDEntSalContables extends FPDF {

    public $Fecha;
    public $AFecha;
    public $Mes;

    function getMes() {
        return $this->Mes;
    }

    function setMes($Mes) {
        $this->Mes = $Mes;
    }

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

        $this->AddFont('NewsCycle', 'B');
        $this->AddFont('NewsCycle', '');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(40, 4, utf8_decode("Entradas y Salidas de la fecha: "), 0/* BORDE */, 0, 'L');


        $this->SetX(85);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(20, 4, utf8_decode($this->getFecha()), 0/* BORDE */, 0, 'C');


        $this->SetX(105);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(25, 4, utf8_decode($this->getAfecha()), 0/* BORDE */, 1, 'C');

        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(20, 4, utf8_decode("Del mes de: "), 0/* BORDE */, 0, 'L');

        $this->SetX(56);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(20, 4, utf8_decode($this->getMes()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 9);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');

        /* Primer Renglon de Titulos */
        $this->SetY(16);
        $this->SetX(123);


        $this->SetX($this->GetX());
        $this->Cell(28, 4, 'Existencia', 'TLR'/* BORDE */, 0, 'C');

        /* Segundo Renglon de Titulos */
        $this->SetY(20);
        $this->SetX(5);

        $this->Cell(40, 4, utf8_decode('Artículo'), 'B'/* BORDE */, 0, 'L');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, 'Inv-Ini', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(15, 4, 'Fecha', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(19, 4, 'Docto', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(14, 4, 'Entrada', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(14, 4, 'Salida', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(14, 4, 'Virtual', 'LB'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(14, 4, utf8_decode('Física'), 'BR'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(12, 4, 'Precio', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, '$ Inv-Ini', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, '$ Debe', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, '$ Haber', 'RB'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, '$ Saldo', 'RB'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(45, 4, 'Proveedor', 'B'/* BORDE */, 1, 'L');
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
        $this->SetFont('Calibri', 'B', 11);
        $this->SetY(5);
        $this->SetX(36);
        $this->Cell(60, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 10);
        $this->SetX(36);
        $this->Cell(40, 4, utf8_decode("Kardex de Artículos de la fecha: "), 0/* BORDE */, 0, 'L');


        $this->SetX(85);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(20, 4, utf8_decode($this->getFecha()), 0/* BORDE */, 0, 'C');


        $this->SetX(105);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(25, 4, utf8_decode($this->getAfecha()), 0/* BORDE */, 0, 'C');
        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 9);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');

        /* Primer Renglon de Titulos */
        $this->SetY(19);
        $this->SetX(5);
        $this->SetFont('Calibri', 'B', 9.5);
        $this->Cell(20, 4, 'Docto', 0/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, 'Orden', 0/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(88, 4, '', 0/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(84, 4, 'Cantidad en U.Medida y pesos', 1/* BORDE */, 0, 'C');


        $this->SetX($this->GetX());
        $this->Cell(60, 4, '', 0/* BORDE */, 0, 'L');


        /* Segundo Renglon de Titulos */
        $this->SetY(23);
        $this->SetX(5);

        $this->Cell(20, 4, 'Ent-Sal', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(16, 4, 'Compra', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(11, 4, 'Maq', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(11, 4, 'Sem', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(13, 4, 'Mov', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(19, 4, 'Fecha', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(15, 4, 'Precio', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(19, 4, 'Subtotal', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(21, 4, 'Entrada', 'LB'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(21, 4, 'Pesos $', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(21, 4, 'Salida', 'B'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(21, 4, 'Pesos $', 'RB'/* BORDE */, 0, 'C');

        $this->SetX($this->GetX());
        $this->Cell(60, 4, 'Proveedor', 'B'/* BORDE */, 1, 'L');
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
