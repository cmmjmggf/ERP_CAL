<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PDFParesPreProCliente extends FPDF {

    public $Borders = 0;
    public $Filled = 0;
    public $fechai;
    public $fechaf;

    function getFechai() {
        return $this->fechai;
    }

    function getFechaf() {
        return $this->fechaf;
    }

    function setFechai($fechai) {
        $this->fechai = $fechai;
    }

    function setFechaf($fechaf) {
        $this->fechaf = $fechaf;
    }

    function Header() {
        $alto_celda = 4;
        $bordes = 0;
        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');

        /* ENCABEZADO FIJO */
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Calibri', 'B', 10);
        $this->SetY(10);
        $this->Rect(10, 10, 259, 12.5);
        $this->Image($_SESSION["LOGO"], /* LEFT */ 10, 10/* TOP */, /* ANCHO */ 30, 12.5);
        $this->SetX(10);
//            $this->Rect(10, 10, 259, 195);/*DELIMITADOR DE MARGENES*/
        $this->SetX(40);
        $this->Cell(229, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 1/* SALTO */, 'L');
        $this->SetX(40);
        $this->Cell(229, $alto_celda, utf8_decode("Pares preprogramados por cliente"), $bordes/* BORDE */, 1/* SALTO */, 'L');
        $this->SetX(40);
        $this->Cell(20, $alto_celda, "Fecha ", $bordes/* BORDE */, 0/* SALTO */, 'L');
        $this->SetX(60);
        $this->Cell(60, $alto_celda, $this->getFechai() . "   a la fecha   " . $this->getFechaf(), $bordes/* BORDE */, 1/* SALTO */, 'L');

        $anchos = array(100/* 0 */, 23/* 1 */, 43/* 2 */, 30/* 3 */, 15/* 4 */, 16/* 5 */, 12/* 6 */, 20/* 7 */);
        $spacex = 10;
        $bordes = 1;
        /* SUB ENCABEZADO */
        $this->SetY($this->GetY() + $alto_celda + .5);
        $this->SetX($spacex);
        $this->Cell($anchos[0], $alto_celda, 'Cliente                                       Agente', $bordes/* BORDE */, 0/* SALTO */, 'L');
        $spacex += $anchos[0];
        $this->SetX($spacex);
        $this->Cell($anchos[4], $alto_celda, 'Pedido', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[4];
        $this->SetX($spacex);
        $this->Cell($anchos[1], $alto_celda, 'Linea', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[1];
        $this->SetX($spacex);
        $this->Cell($anchos[6], $alto_celda, 'Estilo', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[6];
        $this->SetX($spacex);
        $this->Cell($anchos[2], $alto_celda, 'Color', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[2];
        $this->SetX($spacex);
        $this->Cell($anchos[7], $alto_celda, 'Fecha-Ent', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[7];
        $this->SetX($spacex);
        $this->Cell($anchos[5], $alto_celda, 'Pares', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[5];
        $this->SetX($spacex);
        $this->Cell($anchos[4], $alto_celda, 'Maq', $bordes/* BORDE */, 0/* SALTO */, 'C');
        $spacex += $anchos[4];
        $this->SetX($spacex);
        $this->Cell($anchos[4], $alto_celda, 'Sem', $bordes/* BORDE */, 1/* SALTO */, 'C');
        /* FIN SUB ENCABEZADO */
        /* FIN ENCABEZADO FIJO */
    }

    function Footer() {
        // Go to 1.5 cm from bottom
        $this->SetY(-13);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {totalPages}', 0, 0, 'C');
        $this->AliasNbPages(' {totalPages}');
    }

    function getFilled() {
        return $this->Filled;
    }

    function setFilled($Filled) {
        $this->Filled = $Filled;
    }

    function getBorders() {
        return $this->Borders;
    }

    function setBorders($Borders) {
        $this->Borders = $Borders;
    }

    var $widths;
    var $aligns;
    var $alto = 2.65;

    function getAlto() {
        return $this->alto;
    }

    function setAlto($alto) {
        $this->alto = $alto;
    }

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = $this->getAlto() * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->SetFillColor(225, 225, 234);
            $this->MultiCell($w, $this->getAlto(), $data[$i], $this->getBorders(), $a, $this->getFilled());
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
        $h = $this->getAlto() * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //Print the text
            $this->SetFillColor(225, 225, 234);
            $this->MultiCell($w, $this->getAlto(), $data[$i], 0, $a, $this->getFilled());
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            $this->SetX($this->GetX());
        }
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

    public $Borders = 0;
    public $Filled = 0;

    function Footer() {
        // Go to 1.5 cm from bottom
        $this->SetY(-13);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {totalPages}', 0, 0, 'C');
        $this->AliasNbPages(' {totalPages}');
    }

    function getFilled() {
        return $this->Filled;
    }

    function setFilled($Filled) {
        $this->Filled = $Filled;
    }

    function getBorders() {
        return $this->Borders;
    }

    function setBorders($Borders) {
        $this->Borders = $Borders;
    }

    var $widths;
    var $aligns;
    var $alto = 2.65;

    function getAlto() {
        return $this->alto;
    }

    function setAlto($alto) {
        $this->alto = $alto;
    }

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = $this->getAlto() * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->SetFillColor(225, 225, 234);
            $this->MultiCell($w, $this->getAlto(), $data[$i], $this->getBorders(), $a, $this->getFilled());
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
        $h = $this->getAlto() * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //Print the text
            $this->SetFillColor(225, 225, 234);
            $this->MultiCell($w, $this->getAlto(), $data[$i], 0, $a, $this->getFilled());
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            $this->SetX($this->GetX());
        }
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
