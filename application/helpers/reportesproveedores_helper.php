<?php

class PDFCostosMateriales extends FPDF {

    public $Fecha;
    public $Afecha;
    public $Maq;

    function getMaq() {
        return $this->Maq;
    }

    function setMaq($Maq) {
        $this->Maq = $Maq;
    }

    function getFecha() {
        return $this->Fecha;
    }

    function getAfecha() {
        return $this->Afecha;
    }

    function setFecha($Fecha) {
        $this->Fecha = $Fecha;
    }

    function setAfecha($Afecha) {
        $this->Afecha = $Afecha;
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
        $this->Cell(50, 4, utf8_decode("Costeo de materiales de la maquila: "), 0/* BORDE */, 0, 'L');


        $this->SetX(90);
        $this->SetFont('Calibri', '', 9);
        $this->Cell(10, 4, utf8_decode($this->getMaq()), 0/* BORDE */, 1, 'C');

        $this->SetX(36);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(10, 4, utf8_decode("Del: "), 0/* BORDE */, 0, 'L');


        $this->SetX(50);
        $this->SetFont('Calibri', '', 9);
        $this->Cell(10, 4, utf8_decode($this->getFecha()), 0/* BORDE */, 0, 'C');

        $this->SetX(65);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(80);
        $this->SetFont('Calibri', '', 9);
        $this->Cell(10, 4, utf8_decode($this->getAfecha()), 0/* BORDE */, 1, 'C');


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


        $this->SetY(22);
        $this->SetX(5);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(0/* 0 */, 80/* 1 */, 12/* 2 */, 8/* 3 */, 14/* 4 */, 14/* 5 */, 19/* 6 */, 21/* 7 */, 20/* 8 */, 9/* 9 */, 9/* 10 */);
        $aligns = array('R', 'L', 'L', 'C', 'R', 'R', 'R', 'C', 'C', 'L', 'L');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('', utf8_decode('Artículo'), 'U.M.', 'Tp', 'Cant', 'Precio', 'Subtotal', 'Docto', 'Fecha', 'Maq', 'Sem'), 'B');
        $anchos = array(10/* 0 */, 70/* 1 */, 12/* 2 */, 8/* 3 */, 14/* 4 */, 14/* 5 */, 19/* 6 */, 21/* 7 */, 20/* 8 */, 9/* 9 */, 9/* 10 */);

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

class PDFRecibosEfectivo extends FPDF {

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

        $this->SetY(7);
        $this->SetX(182);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode(strftime("León Gto., %A %d de %B del %Y")
                ), 0/* BORDE */, 1, 'R');


        $this->SetY(25);
        $this->SetX(15);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(19/* 1 */, 22/* 2 */, 5/* 3 */, 70/* 3 */);
        $aligns = array('L', 'R', 'C', 'L');
        $this->SetFont('Calibri', 'B', 9);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('Documento', 'Importe', '', 'Concepto'));

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
            $this->MultiCell($w, 4, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
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
            $this->MultiCell($w, 4, $data[$i], 0, $a);
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

class PDFRelacionPagos extends FPDF {

    public $Fecha;
    public $Afecha;

    function getFecha() {
        return $this->Fecha;
    }

    function getAfecha() {
        return $this->Afecha;
    }

    function setFecha($Fecha) {
        $this->Fecha = $Fecha;
    }

    function setAfecha($Afecha) {
        $this->Afecha = $Afecha;
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
        $this->Cell(40, 4, utf8_decode("Relación de pagos del: "), 0/* BORDE */, 0, 'L');


        $this->SetX(80);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getFecha()), 0/* BORDE */, 0, 'C');

        $this->SetX(96);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAfecha()), 0/* BORDE */, 1, 'C');


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


        $this->SetY(22);
        $this->SetX(5);
        $this->SetFont('Calibri', 'B', 8.5);
        $this->Cell(80, 4, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');


        $this->SetY(22);
        $this->SetX(85);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(8/* 1 */, 15/* 2 */, 16/* 3 */, 20/* 4 */, 60/* 5 */);
        $aligns = array('L', 'L', 'C', 'R', 'L');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('Tp', 'Docto', 'Fecha', 'Importe', 'Doc. Pago'));

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
        $this->SetX(90);

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

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(90);

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
            $this->MultiCell($w, 4, $data[$i], 0, $a);
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

class PDFAntiguedadProv extends FPDF {

    public $Proveedor;
    public $Aproveedor;

    function getProveedor() {
        return $this->Proveedor;
    }

    function getAproveedor() {
        return $this->Aproveedor;
    }

    function setProveedor($Proveedor) {
        $this->Proveedor = $Proveedor;
    }

    function setAproveedor($Aproveedor) {
        $this->Aproveedor = $Aproveedor;
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
        $this->Cell(50, 4, utf8_decode("Antigüedad de Saldos del Proveedor: "), 0/* BORDE */, 0, 'L');



        $this->SetX(90);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getProveedor()), 0/* BORDE */, 0, 'C');

        $this->SetX(100);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAproveedor()), 0/* BORDE */, 1, 'C');


        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        $this->SetFont('Calibri', 'B', 8);
        $this->SetY(18);
        $this->SetX(5);

        $this->Cell(17, 3.5, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');

//        $this->SetX(5);
//        $this->Cell(24, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX(104);
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(5/* 1 */, 12/* 2 */, 12/* 3 */, 18/* 4 */, 18/* 5 */, 18/* 6 */, 7/* 7 */,
            18/* 8 */,
            18/* 9 */,
            18/* 10 */,
            18/* 11 */,
            18/* 12 */,
            18/* 13 */,
            18/* 14 */,
            18/* 15 */,
            18/* 16 */);
        $aligns = array('C', 'C', 'C', 'R', 'R', 'R', 'C', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 8);
        $this->Row(array('Tp', 'Doc', 'Fecha', 'Importe', 'Pagos', 'Saldo', 'Dias',
            'de 0 a 7',
            'de 8 a 15',
            'de 16 a 21',
            'de 22 a 30',
            'de 31 a 37',
            'de 38 a 45',
            'de 46 a 52',
            'de 53 a 60',
            'Mas de 61'));


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
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(22);

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
            $this->MultiCell($w, 3.5, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(22);

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
            $this->MultiCell($w, 3.5, $data[$i], 0, $a);
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

class PDFEdoCtaProv extends FPDF {

    public $Proveedor;
    public $Aproveedor;

    function getProveedor() {
        return $this->Proveedor;
    }

    function getAproveedor() {
        return $this->Aproveedor;
    }

    function setProveedor($Proveedor) {
        $this->Proveedor = $Proveedor;
    }

    function setAproveedor($Aproveedor) {
        $this->Aproveedor = $Aproveedor;
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
        $this->Cell(50, 4, utf8_decode("Estado de Cuenta del Proveedor: "), 0/* BORDE */, 0, 'L');


        $this->SetX(86);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getProveedor()), 0/* BORDE */, 0, 'C');

        $this->SetX(96);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(106);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAproveedor()), 0/* BORDE */, 1, 'C');


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


        $this->SetY(22);
        $this->SetX(5);

        $this->Cell(70, 3.5, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');
        $this->SetX(75);
        $this->Cell(15, 3.5, utf8_decode('Plazo'), 'B'/* BORDE */, 1, 'L');

        $this->SetY(22);
        $this->SetX(90);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(10/* 1 */, 18/* 2 */, 17/* 3 */, 19/* 4 */, 20/* 5 */, 20/* 6 */, 15/* 7 */);
        $aligns = array('L', 'L', 'L', 'R', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('Tp', 'Docto', 'Fecha', 'Importe', 'Pagos', 'Saldo', 'Dias'));
        $aligns = array('L', 'L', 'L', 'R', 'R', 'R', 'R');
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
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(90);

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
            $this->MultiCell($w, 3.5, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(90);

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
            $this->MultiCell($w, 3.5, $data[$i], 0, $a);
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

class PDFEdoCtaProvSinDesgloce extends FPDF {

    public $Proveedor;
    public $Aproveedor;

    function getProveedor() {
        return $this->Proveedor;
    }

    function getAproveedor() {
        return $this->Aproveedor;
    }

    function setProveedor($Proveedor) {
        $this->Proveedor = $Proveedor;
    }

    function setAproveedor($Aproveedor) {
        $this->Aproveedor = $Aproveedor;
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
        $this->Cell(50, 4, utf8_decode("Estado de Cuenta del Proveedor: "), 0/* BORDE */, 0, 'L');


        $this->SetX(86);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getProveedor()), 0/* BORDE */, 0, 'C');

        $this->SetX(96);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(106);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAproveedor()), 0/* BORDE */, 1, 'C');


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


        $this->SetY(22);
        $this->SetX(5);

        $this->Cell(70, 4, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');
        $this->SetX(75);
        $this->Cell(15, 4, utf8_decode('Plazo'), 'B'/* BORDE */, 1, 'L');

        $this->SetY(22);
        $this->SetX(90);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(10/* 1 */, 18/* 2 */, 17/* 3 */, 19/* 4 */, 20/* 5 */, 20/* 6 */, 15/* 7 */);
        $aligns = array('L', 'L', 'L', 'R', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('', '', '', 'Importe', 'Pagos', 'Saldo', ''));
        $aligns = array('L', 'L', 'L', 'R', 'R', 'R', 'R');
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
        $this->SetX(90);

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

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(90);

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
            $this->MultiCell($w, 4, $data[$i], 0, $a);
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

class PDFAntiguedadProvExt extends FPDF {

    public $Proveedor;
    public $Aproveedor;

    function getProveedor() {
        return $this->Proveedor;
    }

    function getAproveedor() {
        return $this->Aproveedor;
    }

    function setProveedor($Proveedor) {
        $this->Proveedor = $Proveedor;
    }

    function setAproveedor($Aproveedor) {
        $this->Aproveedor = $Aproveedor;
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
        $this->Cell(50, 4, utf8_decode("Antigüedad de Saldos del Proveedor: "), 0/* BORDE */, 0, 'L');



        $this->SetX(90);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getProveedor()), 0/* BORDE */, 0, 'C');

        $this->SetX(100);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAproveedor()), 0/* BORDE */, 1, 'C');


        //Paginador
        $this->SetY(3);
        $this->SetX(265);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');

        $this->SetY(7);
        $this->SetX(245);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Fecha: " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'R');
        $this->AliasNbPages(' {totalPages}');



        $this->SetFont('Calibri', 'B', 8);
        $this->SetY(18);
        $this->SetX(5);

        $this->Cell(17, 3.5, utf8_decode('Proveedor'), 'B'/* BORDE */, 0, 'L');

//        $this->SetX(5);
//        $this->Cell(24, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX(104);
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//        $this->SetX($this->GetX());
//        $this->Cell(18, 3.5, '', 1/* BORDE */, 0, 'C');
//


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(5/* 1 */, 12/* 2 */, 12/* 3 */, 18/* 4 */, 18/* 5 */, 18/* 6 */, 7/* 7 */,
            18/* 8 */,
            18/* 9 */,
            18/* 10 */,
            18/* 11 */,
            18/* 12 */,
            18/* 13 */,
            18/* 14 */,
            18/* 15 */,
            18/* 16 */);
        $aligns = array('C', 'C', 'C', 'R', 'R', 'R', 'C', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 8);
        $this->Row(array('Tp', 'Doc', 'Fecha', 'Importe', 'Pagos', 'Saldo', 'Dias',
            'de 0 a 59',
            'de 60 a 67',
            'de 68 a 75',
            'de 76 a 83',
            'de 84 a 91',
            'de 92 a 99',
            'de 100 a 107',
            'de 108 a 115',
            'Mas de 116'));


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
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(22);

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
            $this->MultiCell($w, 3.5, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoBorder($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX(22);

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
            $this->MultiCell($w, 3.5, $data[$i], 0, $a);
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
