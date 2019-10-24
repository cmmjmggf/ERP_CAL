<?php

class PDFNotaCredito extends FPDF {

    public $proveedor;
    public $folio;
    public $tp;
    public $fecha;
    public $DocCartProv;

    function getProveedor() {
        return $this->proveedor;
    }

    function getFolio() {
        return $this->folio;
    }

    function getTp() {
        return $this->tp;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getDocCartProv() {
        return $this->DocCartProv;
    }

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function setFolio($folio) {
        $this->folio = $folio;
    }

    function setTp($tp) {
        $this->tp = $tp;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setDocCartProv($DocCartProv) {
        $this->DocCartProv = $DocCartProv;
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
        $this->Cell(60, 5, utf8_decode($_SESSION["EMPRESA_RAZON"]), 0/* BORDE */, 0, 'L');
        $this->SetFont('Calibri', 'B', 9.5);
        $this->SetX(140);
        $this->Cell(70, 5, utf8_decode("Nota de Cargo"), 1/* BORDE */, 1, 'C');

        $this->SetFont('Calibri', 'B', 9.5);
        $this->SetX(36);
        $this->Cell(20, 5, utf8_decode("Proveedor: "), 0/* BORDE */, 0, 'L');
        $this->SetX(55);
        $this->SetFont('Calibri', '', 9.5);
        $this->Cell(55, 5, utf8_decode($this->getProveedor()), 0/* BORDE */, 0, 'L');



        $this->SetX(140);
        $this->SetFont('Calibri', '', 9.5);
        $this->Cell(70, 5, utf8_decode($this->getFolio()), 1/* BORDE */, 1, 'C');
        $this->SetFont('Calibri', 'B', 9.5);
        $this->SetX(140);
        $this->Cell(70, 5, utf8_decode("Fecha y Hora:"), 1/* BORDE */, 1, 'C');
        $this->SetFont('Calibri', '', 9.5);
        $this->SetX(140);
        $this->Cell(70, 5, utf8_decode($this->getFecha()), 1/* BORDE */, 1, 'C');
        $this->SetX(140);
        $this->SetFont('Calibri', 'B', 9.5);
        $this->Cell(70, 5, utf8_decode("Referencia:"), 1/* BORDE */, 1, 'C');
        $this->SetFont('Calibri', '', 9.5);
        $this->SetX(140);
        $this->Cell(70, 5, utf8_decode($this->getTp() . '   ' . $this->getDocCartProv()), 1/* BORDE */, 1, 'C');


        $this->SetY(40);
        $this->SetX(5);


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(15/* 0 */, 25/* 1 */, 100/* 2 */, 30/* 3 */, 30/* 4 */);
        $aligns = array('L', 'C', 'L', 'R', 'R');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);

        $this->SetFont('Calibri', 'B', 9.5);
        $this->Row(array('Cantidad', 'U.M.', 'Descripcion', 'Precio', 'Importe'), 'B');

        $aligns = array('R', 'C', 'L', 'R', 'R');
        $this->SetAligns($aligns);
        $this->SetWidths($anchos);
    }

    function Footer() {

        $this->SetY(265);
        $this->SetX(15);
        $this->SetFont('Calibri', 'B', 9);
        $this->Cell(80, 10, utf8_decode("Recibido por:"), 'T'/* BORDE */, 0, 'C');

        $this->SetX(120);
        $this->Cell(80, 10, utf8_decode("Autorizado por:"), 'T'/* BORDE */, 1, 'C');

        $this->SetY(272);
        $this->SetX(200);
        $this->SetFont('Calibri', 'I', 8);
        $this->AliasNbPages(' {totalPages}');

        $this->Cell(20, 4, utf8_decode('Pag. ' . $this->PageNo() . ' de  {totalPages}'), 0/* BORDE */, 1, 'C');
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
        $h = 5 * $nb;
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
            $this->MultiCell($w, 5, $data[$i], $border, $a);
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
