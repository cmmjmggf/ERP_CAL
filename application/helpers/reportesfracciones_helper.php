<?php

class PDF extends FPDF {

    public $Estilo;
    public $Clinea;
    public $Dlinea;

    function getEstilo() {
        return $this->Estilo;
    }

    function getClinea() {
        return $this->Clinea;
    }

    function getDlinea() {
        return $this->Dlinea;
    }

    function setEstilo($Estilo) {
        $this->Estilo = $Estilo;
    }

    function setClinea($Clinea) {
        $this->Clinea = $Clinea;
    }

    function setDlinea($Dlinea) {
        $this->Dlinea = $Dlinea;
    }

    function Header() {
        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30);
        $this->SetFont('Calibri', 'B', 10);
        $this->SetY(5);
        $this->SetX(40);
        $this->Cell(110, 4, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 1, 'L');
        $this->SetY(7);
        $this->SetX(170);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(100, 4, utf8_decode("Fecha. " . date("d-m-Y     h:i:s a")), 0/* BORDE */, 1, 'L');
        $this->SetY(9);
        $this->SetX(40);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(110, 4, utf8_decode("Fracciones por estilo: "), 0/* BORDE */, 1, 'L');
        $this->SetY(15);
        $this->SetX(40);
        $this->SetFont('Calibri', 'B', 8.5);
        $this->Cell(15, 4, utf8_decode("LINEA: "), 0/* BORDE */, 1, 'L');
        $this->SetY(15);
        $this->SetX(55);
        $this->SetFont('Calibri', '', 8.5);
        $this->Cell(30, 4, utf8_decode($this->getClinea() . ' ' . $this->getDlinea()), 0/* BORDE */, 1, 'L');
        $this->SetFont('Calibri', 'B', 8.5);
        $this->SetY(15);
        $this->SetX(100);
        $this->Cell(15, 4, utf8_decode("ESTILO: "), 0/* BORDE */, 1, 'L');
        $this->SetY(15);
        $this->SetX(115);
        $this->SetFont('Calibri', '', 8.5);
        $this->Cell(15, 4, utf8_decode($this->getEstilo()), 0/* BORDE */, 1, 'L');



        $this->AliasNbPages('{totalPages}');
        // Go to 1.5 cm from bottom
        $this->SetY(3);
        $this->SetX(190);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 8);
        // Print centered page number
        $this->SetTextColor(0, 0, 0);
        $this->Cell(35, 3, utf8_decode('Pag. ' . $this->PageNo() . ' de {totalPages}'), 0, 0, 'R');


        $this->SetY(21);
        $this->SetX(171);
        $this->SetFont('Calibri', 'B', 8.5);
        $this->Cell(15, 4, 'Precio', 0/* BORDE */, 1, 'C');
        $this->Rect(155, 20, 50, 9);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(65/* 0 */, 85/* 1 */, 35/* 2 */, 15/* 3 */);
        $aligns = array('L', 'L', 'L', 'L');

        $this->SetY(25);
        $this->SetX(5);
        $this->SetFont('Calibri', 'B', 8.5);
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->Row(array('Departamento', utf8_decode('Fracción'), 'Ma.Obra', 'Venta'));


        $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
        $aligns = array('L', 'L', 'L', 'L');
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

    function RowX($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Se pone para que depues de insertar una pagina establezca la posicion en X = 5
        $this->SetX($this->x);

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
        $this->SetX($this->x);

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
