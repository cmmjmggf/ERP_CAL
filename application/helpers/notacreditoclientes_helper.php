<?php

class PDFNotaCreditoClientes extends FPDF {

    public $cliente;
    public $folio;
    public $tp;
    public $fecha;
    public $Doc;
    public $rfc;
    public $direccion;
    public $colonia;
    public $ciudad;
    public $cp;
    public $usocfdi;
    public $formapago;
    public $metodopago;

    function getFormapago() {
        return $this->formapago;
    }

    function getMetodopago() {
        return $this->metodopago;
    }

    function setFormapago($formapago) {
        $this->formapago = $formapago;
    }

    function setMetodopago($metodopago) {
        $this->metodopago = $metodopago;
    }

    function getRfc() {
        return $this->rfc;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getColonia() {
        return $this->colonia;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getCp() {
        return $this->cp;
    }

    function getUsocfdi() {
        return $this->usocfdi;
    }

    function setRfc($rfc) {
        $this->rfc = $rfc;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setColonia($colonia) {
        $this->colonia = $colonia;
    }

    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    function setCp($cp) {
        $this->cp = $cp;
    }

    function setUsocfdi($usocfdi) {
        $this->usocfdi = $usocfdi;
    }

    function getCliente() {
        return $this->cliente;
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

    function getDoc() {
        return $this->Doc;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
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
        $this->SetFont('Calibri', '', 8);
        $this->SetX(36);
        $this->MultiCell(60, 3, utf8_decode("RIO SANTIAGO No. 245 \nSAN MIGUEL CP: 37390 \nLEÓN, GUANAJUATO \nRFC: CLO070608J19 \nTELÉFONO(S): 477 1464646 - 49 "), 0/* BORDE */, 'L');


        //Datos NC
        $this->SetFillColor(227, 227, 227);
        $this->SetY(5);
        $this->SetX(140);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(70, 4, utf8_decode("Nota de Crédito"), 1/* BORDE */, 1, 'C', true);
        $this->SetX(140);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(70, 4, utf8_decode($this->getFolio()), 1/* BORDE */, 1, 'C');
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(140);
        $this->Cell(70, 4, utf8_decode("Fecha y Hora:"), 1/* BORDE */, 1, 'C', true);
        $this->SetFont('Calibri', '', 8);
        $this->SetX(140);
        $this->Cell(70, 4, utf8_decode($this->getFecha()), 1/* BORDE */, 1, 'C');
        $this->SetX(140);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(70, 4, utf8_decode("Referencia:"), 1/* BORDE */, 1, 'C', true);
        $this->SetFont('Calibri', '', 8);
        $this->SetX(140);
        $this->Cell(70, 4, utf8_decode($this->getTp() . '   ' . $this->getDoc()), 1/* BORDE */, 1, 'C');
        $this->SetX(140);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(70, 4, utf8_decode("Forma de Pago:"), 1/* BORDE */, 1, 'C', true);
        $this->SetFont('Calibri', '', 8);
        $this->SetX(140);
        $this->Cell(70, 4, utf8_decode($this->getMetodopago()), 1/* BORDE */, 1, 'C');
        $this->SetX(140);
        $this->SetFont('Calibri', 'B', 8);
        $this->Cell(70, 4, utf8_decode("Método de Pago:"), 1/* BORDE */, 1, 'C', true);
        $this->SetFont('Calibri', '', 8);
        $this->SetX(140);
        $this->Cell(70, 4, utf8_decode($this->getFormapago()), 1/* BORDE */, 1, 'C');


        $this->Line(5, 29, 130, 29);
        //Datos Cliente
        $this->SetY(30);
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(20, 3, utf8_decode("Cliente: "), 0/* BORDE */, 0, 'L');
        $this->SetX(18);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getCliente()), 0/* BORDE */, 1, 'L');
        //RFC
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(20, 3, utf8_decode("RFC: "), 0/* BORDE */, 0, 'L');
        $this->SetX(18);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getRfc()), 0/* BORDE */, 1, 'L');
        //DIRECCION
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(20, 3, utf8_decode("Dirección: "), 0/* BORDE */, 0, 'L');
        $this->SetX(18);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getDireccion()), 0/* BORDE */, 0, 'L');
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(80);
        $this->Cell(10, 3, utf8_decode("Colonia: "), 0/* BORDE */, 0, 'L');
        $this->SetX(90);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getColonia()), 0/* BORDE */, 1, 'L');
        //CIUDAD
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(20, 3, utf8_decode("Ciudad: "), 0/* BORDE */, 0, 'L');
        $this->SetX(18);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getCiudad()), 0/* BORDE */, 0, 'L');
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(80);
        $this->Cell(10, 3, utf8_decode("CP: "), 0/* BORDE */, 0, 'L');
        $this->SetX(90);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getCp()), 0/* BORDE */, 1, 'L');
        //OTROS DATOS
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(20, 3, utf8_decode("UsoCFDI: "), 0/* BORDE */, 0, 'L');
        $this->SetX(18);
        $this->SetFont('Calibri', '', 8);
        $this->Cell(55, 3, utf8_decode($this->getUsocfdi()), 0/* BORDE */, 1, 'L');


        $this->SetY(50);
        $this->SetX(5);


        /* ENCABEZADO DETALLE TITULOS */
        $anchos = array(20, 20, 80, 20, 20, 20, 25);
        $aligns = array('L', 'L', 'L', 'C', 'C', 'C', 'C');
        $this->SetWidths($anchos);
        $this->SetAligns($aligns);
        $this->SetFont('Calibri', 'B', 8);
        $this->Row(array('Cantidad', utf8_decode('Código'), 'Descripcion', 'Precio', 'Docto %', 'Docto $', 'Subtotal'), 'TB', true);
    }

    function Footer() {
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

    function Row($data, $border, $fill) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 3 * $nb;
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
            $this->MultiCell($w, 3, $data[$i], $border, $a, $fill);
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
