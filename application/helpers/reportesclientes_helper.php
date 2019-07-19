<?php

class PDFAntiguedadCliente extends FPDF {

    public $Cliente;
    public $Acliente;

    function getCliente() {
        return $this->Cliente;
    }

    function getAcliente() {
        return $this->Acliente;
    }

    function setCliente($Cliente) {
        $this->Cliente = $Cliente;
    }

    function setAcliente($Acliente) {
        $this->Acliente = $Acliente;
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
        $this->Cell(50, 4, utf8_decode("Cartera de Clientes: "), 0/* BORDE */, 0, 'L');

        $this->SetX(90);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getCliente()), 0/* BORDE */, 0, 'C');

        $this->SetX(100);
        $this->SetFont('Calibri', 'B', 10);
        $this->Cell(10, 4, 'Al: ', 0/* BORDE */, 0, 'C');
        $this->SetX(110);
        $this->SetFont('Calibri', '', 10);
        $this->Cell(10, 4, utf8_decode($this->getAcliente()), 0/* BORDE */, 1, 'C');


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



        $this->SetFont('Times', 'B', 7.2);
        $this->SetY(22);
        $this->SetX(5);

        $this->Cell(45, 4, utf8_decode('Cliente'), 'B'/* BORDE */, 0, 'L');


        $this->SetY(22);
        $this->SetX(20);

        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(6/* 1 */, 10/* 2 */, 15/* 3 */, 17/* 4 */, 17/* 5 */, 17/* 6 */, 8/* 7 */,
            17/* 8 */,
            17/* 9 */,
            17/* 10 */,
            17/* 11 */,
            17/* 12 */,
            17/* 13 */,
            17/* 14 */,
            17/* 15 */,
            17/* 16 */,
            10/* 17 */);
        $aligns = array('C', 'C', 'C', 'R', 'R', 'R', 'C', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);


        $this->Row(array('Tp', 'Doc', 'Fecha', 'Importe', 'Pagos', 'Saldo', 'Dias',
            'de 0 a 7',
            'de 8 a 15',
            'de 16 a 21',
            'de 22 a 30',
            'de 31 a 37',
            'de 38 a 45',
            'de 46 a 52',
            'de 53 a 60',
            'Mas de 61',
            'Pares'));


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
        $this->SetX(20);

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
        $this->SetX(20);

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
