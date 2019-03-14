<?php

class PDFSalidasMaterialMaquilasDesgloce extends FPDF {

    public $fechaIni;
    public $fechaFin;

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Salida de materiales a maquilas del: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');



        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(18);
        $this->SetX(5);


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0.1/* 1 */, 80/* 2 */, 13/* 3 */, 20/* 4 */, 18/* 5 */, 16/* 6 */, 22/* 7 */, 23/* 8 */, 14/* 9 */);
        $aligns = array('R', 'L', 'C', 'C', 'R', 'R', 'R', 'R', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M.', 'Fecha', 'Cantidad', 'Precio', 'Subtotal', 'No. Vale', 'Sem'), 'B');

        $anchos = array(12/* 1 */, 68/* 2 */, 13/* 3 */, 20/* 4 */, 18/* 5 */, 15/* 6 */, 22/* 7 */, 23/* 8 */, 14/* 9 */);
        $aligns = array('R', 'L', 'C', 'C', 'R', 'R', 'R', 'R', 'R');
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

    function RowFill($data, $border, $fill) {
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
            $this->MultiCell($w, 4, $data[$i], $border, $a, $fill);
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

class PDFSalidasMaterialMaquilas extends FPDF {

    public $fechaIni;
    public $fechaFin;

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Salida de materiales a maquilas del: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');



        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(18);
        $this->SetX(5);


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(110/* 1 */, 25/* 2 */, 8/* 3 */, 50/* 4 */);
        $aligns = array('R', 'R', 'C', 'L');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('No. Vale', 'Importe', '', 'Semana'), 'B');

        $anchos = array(110/* 1 */, 25/* 2 */, 8/* 3 */, 50/* 4 */);
        $aligns = array('R', 'R', 'C', 'L');
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

class PDFMovimientosAlmacen extends FPDF {

    public $fechaIni;
    public $fechaFin;

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Movimientos del almacen del: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');



        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(18);
        $this->SetX(5);


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0.1/* 1 */, 69.9/* 2 */, 15/* 3 */, 20/* 3 */, 17/* 4 */, 22/* 5 */, 22/* 6 */, 25/* 7 */, 15/* 7 */);
        $aligns = array('R', 'L', 'C', 'C', 'R', 'R', 'R', 'C', 'L');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M', 'Fecha', 'Precio', 'Cantidad', 'Total', 'Doc', 'Tipo'), 'B');

        $anchos = array(12/* 1 */, 58/* 2 */, 15/* 3 */, 20/* 3 */, 17/* 4 */, 22/* 5 */, 22/* 6 */, 25/* 7 */, 15/* 7 */);
        $aligns = array('R', 'L', 'C', 'C', 'R', 'R', 'R', 'R', 'L');
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

class PDFDevolucionesCompras extends FPDF {

    public $fechaIni;
    public $fechaFin;
    public $tp;

    function getTp() {
        return $this->tp;
    }

    function setTp($tp) {
        $this->tp = $tp;
    }

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Devoluciones de compras del: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(10, 4, utf8_decode("Tp: " . $this->getTp()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(20);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(14/* 1 */, 17/* 2 */, 15/* 3 */, 63/* 4 */, 63/* 5 */, 15/* 6 */, 18/* 7 */);
        $aligns = array('L', 'C', 'R', 'L', 'L', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('Nota', 'Fecha', 'Cant', utf8_decode('Descripcion'), 'Concepto', 'Precio', 'Importe'), 'B');
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

class PDFComprasDesgloce extends FPDF {

    public $fechaIni;
    public $fechaFin;
    public $tp;
    public $Reporte;

    function getReporte() {
        return $this->Reporte;
    }

    function setReporte($Reporte) {
        $this->Reporte = $Reporte;
    }

    function getTp() {
        return $this->tp;
    }

    function setTp($tp) {
        $this->tp = $tp;
    }

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Reporte de compras de la fecha:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(10, 4, utf8_decode("Tp: " . ( $this->getTp() !== '' ? $this->getTp() : '1 y 2')), 0/* BORDE */, 0, 'L');

        $this->SetX(65);
        $this->Cell(10, 4, utf8_decode($this->getReporte()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(260);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(240);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(20);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */


        $anchos = array(18/* 3 */, 20/* 4 */, 20/* 5 */, 20/* 6 */, 20/* 7 */);
        $aligns = array('L', 'L', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 10);

        $this->Cell(80, 4, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');


        $this->Row(array('Docto', 'Fecha', 'Importe', 'Abonos', 'Saldo'), 1, 4);


        /* Segundo Detalle va a dentro del for each de la compra */
        $this->SetLineWidth(0.2);
        $this->SetX(105);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(70, 5, utf8_decode('Artículo'), 'B'/* BORDE */, 0, 'L');
        $this->SetX($this->GetX());
        $this->Cell(12, 5, utf8_decode('U.M.'), 'B'/* BORDE */, 0, 'C');
        $this->SetX($this->GetX());
        $this->Cell(18, 5, utf8_decode('Cant'), 'B'/* BORDE */, 0, 'R');
        $this->SetX($this->GetX());
        $this->Cell(15, 5, utf8_decode('Precio'), 'B'/* BORDE */, 0, 'R');
        $this->SetX($this->GetX());
        $this->Cell(19, 5, utf8_decode('Subtotal'), 'B'/* BORDE */, 0, 'R');
        $this->SetX($this->GetX());
        $this->Cell(16, 5, utf8_decode('IVA'), 'B'/* BORDE */, 0, 'R');
        $this->SetX($this->GetX());
        $this->Cell(19, 5, utf8_decode('Total'), 'B'/* BORDE */, 1, 'R');
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

    function Row($data, $border, $altura) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = $altura * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(85);

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
            $this->MultiCell($w, $altura, $data[$i], $border, $a);
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

class PDFComprasSinDesgloce extends FPDF {

    public $fechaIni;
    public $fechaFin;
    public $tp;
    public $Reporte;

    function getReporte() {
        return $this->Reporte;
    }

    function setReporte($Reporte) {
        $this->Reporte = $Reporte;
    }

    function getTp() {
        return $this->tp;
    }

    function setTp($tp) {
        $this->tp = $tp;
    }

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Reporte de compras de la fecha:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(10, 4, utf8_decode("Tp: " . ( $this->getTp() !== '' ? $this->getTp() : '1 y 2')), 0/* BORDE */, 0, 'L');

        $this->SetX(65);
        $this->Cell(10, 4, utf8_decode($this->getReporte()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(20);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */


        $anchos = array(20/* 3 */, 18/* 4 */, 20/* 5 */, 20/* 6 */, 20/* 7 */);
        $aligns = array('L', 'L', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);

        $this->Cell(80, 4, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');

        $this->Row(array('Fecha', 'Docto', 'Importe', 'Abonos', 'Saldo'), 'B');

        $anchos = array(20/* 3 */, 18/* 4 */, 20/* 5 */, 20/* 6 */, 20/* 7 */);
        $aligns = array('L', 'L', 'R', 'R', 'R');
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
        $this->SetX(85);

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

    function RowCenter($data, $border) {
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

class PDFComprasArticulos extends FPDF {

    public $fechaIni;
    public $fechaFin;
    public $tp;

    function getTp() {
        return $this->tp;
    }

    function setTp($tp) {
        $this->tp = $tp;
    }

    function getFechaIni() {
        return $this->fechaIni;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function setFechaIni($fechaIni) {
        $this->fechaIni = $fechaIni;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
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
        $this->Cell(50, 4, utf8_decode("Compras por artículo de la fecha:"), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(85);
        $this->Cell(22, 4, utf8_decode($this->getFechaIni()), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(105);
        $this->Cell(22, 4, utf8_decode("al: "), 0/* BORDE */, 0, 'L');

        $this->SetFont('Calibri', '', 9);
        $this->SetX(112);
        $this->Cell(22, 4, utf8_decode($this->getFechaFin()), 0/* BORDE */, 1, 'L');

        $this->SetFont('Calibri', 'B', 9);
        $this->SetX(36);
        $this->Cell(10, 4, utf8_decode("Tp: " . $this->getTp()), 0/* BORDE */, 0, 'L');

        //Paginador
        $this->SetY(3);
        $this->SetX(200);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(180);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');


        $this->SetY(20);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0.1/* 1 */, 130/* 2 */, 15/* 3 */, 15/* 3 */, 15/* 4 */);
        $aligns = array('L', 'L', 'C', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9);
        $this->Row(array('', utf8_decode('Artículo'), 'U.M', 'Cantidad', '%'), 'B');
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
