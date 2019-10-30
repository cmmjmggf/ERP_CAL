<?php

class PDF extends FPDF {

    private $Pedido = '';
    private $ConsignarA = '';
    private $Observaciones = '';
    private $FechaPedido = '';
    private $FechaEntrega = '';
    private $Borders = 0;
    private $Filled = 0;
    private $Cliente = '';
    private $Obs = '';
    private $Registro = '';
    private $Control = '';
    private $Linea = '';
    private $LineaT = '';
    private $Recio = '';
    private $Estilo = '';
    private $Color = '';
    private $Agente = '';
    private $Trasp = '';

    /* PIELES */
    private $Piel1 = '';
    private $CantidadPiel1 = 0;
    private $Piel2 = '';
    private $CantidadPiel2 = 0;
    private $Piel3 = '';
    private $CantidadPiel3 = 0;
    private $Piel4 = '';
    private $CantidadPiel4 = 0;
    private $Piel5 = '';
    private $CantidadPiel5 = 0;
    private $Piel6 = '';
    private $CantidadPiel6 = 0;
    private $TotalPiel = 0;
    /* FORROS */
    private $Forro1 = '';
    private $CantidadForro1 = 0;
    private $Forro2 = '';
    private $CantidadForro2 = 0;
    private $Forro3 = '';
    private $CantidadForro3 = 0;
    private $TotalForro = 0;
    /* SINTETICOS */
    private $Sintetico1 = '';
    private $CantidadSintetico1 = 0;
    private $Sintetico2 = '';
    private $CantidadSintetico2 = 0;
    private $Sintetico3 = '';
    private $CantidadSintetico3 = 0;
    private $TotalSintetico = 0;
    private $Serie = '';
    private $T1 = '';
    private $T2 = '';
    private $T3 = '';
    private $T4 = '';
    private $T5 = '';
    private $T6 = '';
    private $T7 = '';
    private $T8 = '';
    private $T9 = '';
    private $T10 = '';
    private $T11 = '';
    private $T12 = '';
    private $T13 = '';
    private $T14 = '';
    private $T15 = '';
    private $T16 = '';
    private $T17 = '';
    private $T18 = '';
    private $T19 = '';
    private $T20 = '';
    private $T21 = '';
    private $T22 = '';
    private $C1 = '';
    private $C2 = '';
    private $C3 = '';
    private $C4 = '';
    private $C5 = '';
    private $C6 = '';
    private $C7 = '';
    private $C8 = '';
    private $C9 = '';
    private $C10 = '';
    private $C11 = '';
    private $C12 = '';
    private $C13 = '';
    private $C14 = '';
    private $C15 = '';
    private $C16 = '';
    private $C17 = '';
    private $C18 = '';
    private $C19 = '';
    private $C20 = '';
    private $C21 = '';
    private $C22 = '';
    private $Horma = '';
    private $Pares = 0;
    private $EstatusProduccion = '';
    private $Suela = '';

    function getSuela() {
        return $this->Suela;
    }

    function setSuela($Suela) {
        $this->Suela = $Suela;
    }

    function getLineaT() {
        return $this->LineaT;
    }

    function setLineaT($LineaT) {
        $this->LineaT = $LineaT;
    }

    function getEstatusProduccion() {
        return $this->EstatusProduccion;
    }

    function setEstatusProduccion($EstatusProduccion) {
        $this->EstatusProduccion = $EstatusProduccion;
    }

    function getSerie() {
        return $this->Serie;
    }

    function getT1() {
        return $this->T1;
    }

    function getT2() {
        return $this->T2;
    }

    function getT3() {
        return $this->T3;
    }

    function getT4() {
        return $this->T4;
    }

    function getT5() {
        return $this->T5;
    }

    function getT6() {
        return $this->T6;
    }

    function getT7() {
        return $this->T7;
    }

    function getT8() {
        return $this->T8;
    }

    function getT9() {
        return $this->T9;
    }

    function getT10() {
        return $this->T10;
    }

    function getT11() {
        return $this->T11;
    }

    function getT12() {
        return $this->T12;
    }

    function getT13() {
        return $this->T13;
    }

    function getT14() {
        return $this->T14;
    }

    function getT15() {
        return $this->T15;
    }

    function getT16() {
        return $this->T16;
    }

    function getT17() {
        return $this->T17;
    }

    function getT18() {
        return $this->T18;
    }

    function getT19() {
        return $this->T19;
    }

    function getT20() {
        return $this->T20;
    }

    function getT21() {
        return $this->T21;
    }

    function getT22() {
        return $this->T22;
    }

    function getC1() {
        return $this->C1;
    }

    function getC2() {
        return $this->C2;
    }

    function getC3() {
        return $this->C3;
    }

    function getC4() {
        return $this->C4;
    }

    function getC5() {
        return $this->C5;
    }

    function getC6() {
        return $this->C6;
    }

    function getC7() {
        return $this->C7;
    }

    function getC8() {
        return $this->C8;
    }

    function getC9() {
        return $this->C9;
    }

    function getC10() {
        return $this->C10;
    }

    function getC11() {
        return $this->C11;
    }

    function getC12() {
        return $this->C12;
    }

    function getC13() {
        return $this->C13;
    }

    function getC14() {
        return $this->C14;
    }

    function getC15() {
        return $this->C15;
    }

    function getC16() {
        return $this->C16;
    }

    function getC17() {
        return $this->C17;
    }

    function getC18() {
        return $this->C18;
    }

    function getC19() {
        return $this->C19;
    }

    function getC20() {
        return $this->C20;
    }

    function getC21() {
        return $this->C21;
    }

    function getC22() {
        return $this->C22;
    }

    function getHorma() {
        return $this->Horma;
    }

    function getPares() {
        return $this->Pares;
    }

    function setSerie($Serie) {
        $this->Serie = $Serie;
    }

    function setT1($T1) {
        $this->T1 = $T1;
    }

    function setT2($T2) {
        $this->T2 = $T2;
    }

    function setT3($T3) {
        $this->T3 = $T3;
    }

    function setT4($T4) {
        $this->T4 = $T4;
    }

    function setT5($T5) {
        $this->T5 = $T5;
    }

    function setT6($T6) {
        $this->T6 = $T6;
    }

    function setT7($T7) {
        $this->T7 = $T7;
    }

    function setT8($T8) {
        $this->T8 = $T8;
    }

    function setT9($T9) {
        $this->T9 = $T9;
    }

    function setT10($T10) {
        $this->T10 = $T10;
    }

    function setT11($T11) {
        $this->T11 = $T11;
    }

    function setT12($T12) {
        $this->T12 = $T12;
    }

    function setT13($T13) {
        $this->T13 = $T13;
    }

    function setT14($T14) {
        $this->T14 = $T14;
    }

    function setT15($T15) {
        $this->T15 = $T15;
    }

    function setT16($T16) {
        $this->T16 = $T16;
    }

    function setT17($T17) {
        $this->T17 = $T17;
    }

    function setT18($T18) {
        $this->T18 = $T18;
    }

    function setT19($T19) {
        $this->T19 = $T19;
    }

    function setT20($T20) {
        $this->T20 = $T20;
    }

    function setT21($T21) {
        $this->T21 = $T21;
    }

    function setT22($T22) {
        $this->T22 = $T22;
    }

    function setC1($C1) {
        $this->C1 = $C1;
    }

    function setC2($C2) {
        $this->C2 = $C2;
    }

    function setC3($C3) {
        $this->C3 = $C3;
    }

    function setC4($C4) {
        $this->C4 = $C4;
    }

    function setC5($C5) {
        $this->C5 = $C5;
    }

    function setC6($C6) {
        $this->C6 = $C6;
    }

    function setC7($C7) {
        $this->C7 = $C7;
    }

    function setC8($C8) {
        $this->C8 = $C8;
    }

    function setC9($C9) {
        $this->C9 = $C9;
    }

    function setC10($C10) {
        $this->C10 = $C10;
    }

    function setC11($C11) {
        $this->C11 = $C11;
    }

    function setC12($C12) {
        $this->C12 = $C12;
    }

    function setC13($C13) {
        $this->C13 = $C13;
    }

    function setC14($C14) {
        $this->C14 = $C14;
    }

    function setC15($C15) {
        $this->C15 = $C15;
    }

    function setC16($C16) {
        $this->C16 = $C16;
    }

    function setC17($C17) {
        $this->C17 = $C17;
    }

    function setC18($C18) {
        $this->C18 = $C18;
    }

    function setC19($C19) {
        $this->C19 = $C19;
    }

    function setC20($C20) {
        $this->C20 = $C20;
    }

    function setC21($C21) {
        $this->C21 = $C21;
    }

    function setC22($C22) {
        $this->C22 = $C22;
    }

    function setHorma($Horma) {
        $this->Horma = $Horma;
    }

    function setPares($Pares) {
        $this->Pares = $Pares;
    }

    function getPiel1() {
        return $this->Piel1;
    }

    function getCantidadPiel1() {
        return $this->CantidadPiel1;
    }

    function getPiel2() {
        return $this->Piel2;
    }

    function getCantidadPiel2() {
        return $this->CantidadPiel2;
    }

    function getPiel3() {
        return $this->Piel3;
    }

    function getCantidadPiel3() {
        return $this->CantidadPiel3;
    }

    function getPiel4() {
        return $this->Piel4;
    }

    function getCantidadPiel4() {
        return $this->CantidadPiel4;
    }

    function getPiel5() {
        return $this->Piel5;
    }

    function getCantidadPiel5() {
        return $this->CantidadPiel5;
    }

    function getPiel6() {
        return $this->Piel6;
    }

    function getCantidadPiel6() {
        return $this->CantidadPiel6;
    }

    function getTotalPiel() {
        return $this->TotalPiel;
    }

    function getForro1() {
        return $this->Forro1;
    }

    function getCantidadForro1() {
        return $this->CantidadForro1;
    }

    function getForro2() {
        return $this->Forro2;
    }

    function getCantidadForro2() {
        return $this->CantidadForro2;
    }

    function getForro3() {
        return $this->Forro3;
    }

    function getCantidadForro3() {
        return $this->CantidadForro3;
    }

    function getTotalForro() {
        return $this->TotalForro;
    }

    function getSintetico1() {
        return $this->Sintetico1;
    }

    function getCantidadSintetico1() {
        return $this->CantidadSintetico1;
    }

    function getSintetico2() {
        return $this->Sintetico2;
    }

    function getCantidadSintetico2() {
        return $this->CantidadSintetico2;
    }

    function getSintetico3() {
        return $this->Sintetico3;
    }

    function getCantidadSintetico3() {
        return $this->CantidadSintetico3;
    }

    function getTotalSintetico() {
        return $this->TotalSintetico;
    }

    function setPiel1($Piel1) {
        $this->Piel1 = $Piel1;
    }

    function setCantidadPiel1($CantidadPiel1) {
        $this->CantidadPiel1 = $CantidadPiel1;
    }

    function setPiel2($Piel2) {
        $this->Piel2 = $Piel2;
    }

    function setCantidadPiel2($CantidadPiel2) {
        $this->CantidadPiel2 = $CantidadPiel2;
    }

    function setPiel3($Piel3) {
        $this->Piel3 = $Piel3;
    }

    function setCantidadPiel3($CantidadPiel3) {
        $this->CantidadPiel3 = $CantidadPiel3;
    }

    function setPiel4($Piel4) {
        $this->Piel4 = $Piel4;
    }

    function setCantidadPiel4($CantidadPiel4) {
        $this->CantidadPiel4 = $CantidadPiel4;
    }

    function setPiel5($Piel5) {
        $this->Piel5 = $Piel5;
    }

    function setCantidadPiel5($CantidadPiel5) {
        $this->CantidadPiel5 = $CantidadPiel5;
    }

    function setPiel6($Piel6) {
        $this->Piel6 = $Piel6;
    }

    function setCantidadPiel6($CantidadPiel6) {
        $this->CantidadPiel6 = $CantidadPiel6;
    }

    function setTotalPiel($TotalPiel) {
        $this->TotalPiel = $TotalPiel;
    }

    function setForro1($Forro1) {
        $this->Forro1 = $Forro1;
    }

    function setCantidadForro1($CantidadForro1) {
        $this->CantidadForro1 = $CantidadForro1;
    }

    function setForro2($Forro2) {
        $this->Forro2 = $Forro2;
    }

    function setCantidadForro2($CantidadForro2) {
        $this->CantidadForro2 = $CantidadForro2;
    }

    function setForro3($Forro3) {
        $this->Forro3 = $Forro3;
    }

    function setCantidadForro3($CantidadForro3) {
        $this->CantidadForro3 = $CantidadForro3;
    }

    function setTotalForro($TotalForro) {
        $this->TotalForro = $TotalForro;
    }

    function setSintetico1($Sintetico1) {
        $this->Sintetico1 = $Sintetico1;
    }

    function setCantidadSintetico1($CantidadSintetico1) {
        $this->CantidadSintetico1 = $CantidadSintetico1;
    }

    function setSintetico2($Sintetico2) {
        $this->Sintetico2 = $Sintetico2;
    }

    function setCantidadSintetico2($CantidadSintetico2) {
        $this->CantidadSintetico2 = $CantidadSintetico2;
    }

    function setSintetico3($Sintetico3) {
        $this->Sintetico3 = $Sintetico3;
    }

    function setCantidadSintetico3($CantidadSintetico3) {
        $this->CantidadSintetico3 = $CantidadSintetico3;
    }

    function setTotalSintetico($TotalSintetico) {
        $this->TotalSintetico = $TotalSintetico;
    }

    function getLinea() {
        return $this->Linea;
    }

    function getRecio() {
        return $this->Recio;
    }

    function getEstilo() {
        return $this->Estilo;
    }

    function getColor() {
        return $this->Color;
    }

    function setLinea($Linea) {
        $this->Linea = $Linea;
    }

    function setRecio($Recio) {
        $this->Recio = $Recio;
    }

    function setEstilo($Estilo) {
        $this->Estilo = $Estilo;
    }

    function setColor($Color) {
        $this->Color = $Color;
    }

    function getFechaPedido() {
        return $this->FechaPedido;
    }

    function setFechaPedido($FechaPedido) {
        $this->FechaPedido = $FechaPedido;
    }

    function getControl() {
        return $this->Control;
    }

    function setControl($Control) {
        $this->Control = $Control;
    }

    function getFechaEntrega() {
        return $this->FechaEntrega;
    }

    function setFechaEntrega($FechaEntrega) {
        $this->FechaEntrega = $FechaEntrega;
    }

    function getPedido() {
        return $this->Pedido;
    }

    function getConsignarA() {
        return $this->ConsignarA;
    }

    function getObservaciones() {
        return $this->Observaciones;
    }

    function getBorders() {
        return $this->Borders;
    }

    function getFilled() {
        return $this->Filled;
    }

    function getCliente() {
        return $this->Cliente;
    }

    function getObs() {
        return $this->Obs;
    }

    function getAgente() {
        return $this->Agente;
    }

    function getTrasp() {
        return $this->Trasp;
    }

    function getRegistro() {
        return $this->Registro;
    }

    function setPedido($Pedido) {
        $this->Pedido = $Pedido;
    }

    function setConsignarA($ConsignarA) {
        $this->ConsignarA = $ConsignarA;
    }

    function setObservaciones($Observaciones) {
        $this->Observaciones = $Observaciones;
    }

    function setBorders($Borders) {
        $this->Borders = $Borders;
    }

    function setFilled($Filled) {
        $this->Filled = $Filled;
    }

    function setCliente($Cliente) {
        $this->Cliente = $Cliente;
    }

    function setObs($Obs) {
        $this->Obs = $Obs;
    }

    function setAgente($Agente) {
        $this->Agente = $Agente;
    }

    function setTrasp($Trasp) {
        $this->Trasp = $Trasp;
    }

    function setRegistro($Registro) {
        $this->Registro = $Registro;
    }

    function Header() {
        $this->AddFont('Calibri', '');
        $this->AddFont('Calibri', 'I');
        $this->AddFont('Calibri', 'B');
        $this->AddFont('Calibri', 'BI');
        $this->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 28, 14);
        $this->SetFont('Calibri', 'B', 8);

        $pos = array(37.5/* 0 */, 107.5/* 1 */, 137.5/* 2 */, 167.5/* 3 */, 40/* 4 */, 200/* 5 */, 215/* 6 */);
        $anc = array(15/* 0 */, 65/* 1 */, 40/* 2 */, 120/* 3 */, 55/* 4 */);

        $base = 5;
        $alto_celda = 3.25;
        $cliente = utf8_decode($this->getCliente());
        /* CLIENTE */
        $this->SetY($base);
        $this->SetX($pos[0]);
        $this->Cell(70, $alto_celda, (strlen($cliente) > 50) ? substr($cliente, 0, 50) . '' : $cliente, 1/* BORDE */, 0, 'L', 0);

        /* FECHA ENTREGA */
        $this->SetX($pos[1]);
        $this->Cell(30, $alto_celda, utf8_decode("Entrega. " . $this->getFechaEntrega()), 1/* BORDE */, 0, 'L', 0);

        $Y = $this->GetY();

        /* FECHA PEDIDO */
        $this->SetX($pos[2]);
        $this->Cell(30, $alto_celda, utf8_decode("Pedido. " . $this->getFechaPedido()), 1/* BORDE */, 0, 'L', 0);

        /* CONTROL */
        $this->SetFont('Calibri', 'B', 8.5);
        $this->SetX($pos[3]);
        $this->Cell(42.5, $alto_celda, utf8_decode($this->getControl()), 1/* BORDE */, 1, 'C', 0);

        /* # DE PEDIDO */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($pos[0]);
        $this->Cell(43.33, $alto_celda, utf8_decode("Pedido. " . $this->getPedido()), 0/* BORDE */, 0, 'L', 0);

        /* LINEA */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($pos[1] - 26.67);
        $this->Cell(8, $alto_celda, utf8_decode("Linea "), 0/* BORDE */, 0, 'L', 0);
        $this->SetFont('Calibri', '', 8);
        $this->SetX($pos[1] - 20);
        $this->Cell(35.33, $alto_celda, utf8_decode($this->getLinea()), 0/* BORDE */, 0, 'L', 0);

        /* FECHA DE IMPRESIÓN */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($pos[2] - 15.34);
        $this->Cell(43.33, $alto_celda, utf8_decode("Imp. " . Date('d/m/Y h:i:s a')), 0/* BORDE */, 0, 'L', 0);

        /* CODIGO DE BARRAS */
        $this->SetFont('Calibri', 'B', 14);
        $this->SetX($pos[3]);
        $this->Code128($pos[3]/* X */, $this->GetY()/* Y */, $this->getControl()/* TEXT */, 43/* ANCHO */, 6/* ALTURA */);
        $this->Cell(42.5, 6, "", 0/* BORDE */, 1, 'C', 0);
        $this->SetFont('Calibri', 'B', 8);

        /* ESTILO */
        $this->SetX($pos[0]);
        if (strlen($this->getEstilo()) < 30) {
            $this->Cell(70, $alto_celda, utf8_decode("Estilo  " . $this->getEstilo()), 0/* BORDE */, 0, 'L', 0);
        } else {
            $this->SetFont('Calibri', 'B', 6.5);
            $this->Cell(70, $alto_celda, utf8_decode("Estilo  " . $this->getEstilo()), 0/* BORDE */, 0, 'L', 0);
        }
        $this->SetFont('Calibri', 'B', 8);
        /* AGENTE */
        $this->SetX($pos[1]);
        $this->Cell(5, $alto_celda, utf8_decode("Agt."), 0/* BORDE */, 0, 'L', 0);
        $this->SetFont('Calibri', '', 7);
        $this->SetX($pos[1] + 5);
        $this->Cell(45, $alto_celda, utf8_decode($this->getAgente()), 0/* BORDE */, 0, 'L', 0);

        /* TRANSPORTE */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($pos[2] + 20);
        $this->Cell(5, $alto_celda, utf8_decode("Trans.  "), 0/* BORDE */, 0, 'L', 0);
        $this->SetFont('Calibri', '', 7);
        $this->SetX($pos[2] + 27.5);
        $this->Cell(47.5, $alto_celda, utf8_decode(" " . $this->getTrasp()), 0/* BORDE */, 1, 'L', 0);
        $this->Line(37.5, $this->GetY(), 210, $this->GetY());

        $this->SetY($this->getY() + 2.5);
        /* PIEL */
        $this->SetFont('Calibri', 'B', 8);
        $this->Rect(11.8, $this->GetY(), 61.6/* DER-X */, 13/* DER-Y */);
        $this->Rect(73.4, $this->GetY(), 61.6/* DER-X */, 13/* DER-Y */);
        $this->Rect(135, $this->GetY(), 61.6/* DER-X */, 13/* DER-Y */);
        $this->SetX(5);
        $this->Cell(6.8, $alto_celda, utf8_decode("Piel"), 0/* BORDE */, 0, 'L', 0);

        /* PIEL SECCION UNO */
        $cols = array($pos[0] - 25.7, $pos[0] + 23.3, $pos[0] + 35.9, $pos[0] + 84.9, $pos[0] + 97.5, $pos[0] + 146.5, $pos[0] + 159);
        /* PIEL UNO */
        if (strlen($this->getPiel1()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[0]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel1()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL UNO CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[1]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadPiel1() > 0) ? number_format($this->getCantidadPiel1(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* PIEL DOS */
        if (strlen($this->getPiel2()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[2]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel2()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL DOS CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[3]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadPiel2() > 0) ? number_format($this->getCantidadPiel2(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* PIEL TRES */
        if (strlen($this->getPiel3()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[4]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel3()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL TRES CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[5]);
        $this->Cell(12.5, $alto_celda, ($this->getCantidadPiel3() > 0 ? number_format($this->getCantidadPiel3(), 2, ".", ",") : ''), 0/* BORDE */, 0, 'R', 0);

        /* PIEL TOTAL */
        $this->SetX($cols[6]);
        $this->Cell(13.6, $alto_celda, number_format($this->getTotalPiel() > 0 ? $this->getTotalPiel() : 0, 2, ".", ","), 0/* BORDE */, 1, 'C', 0);

        $this->Line(5, $this->GetY(), 210, $this->GetY());

        /* FIN PIEL SECCION UNO */

        /* PIEL SECCION DOS */
        /* PIEL CUATRO */
        if (strlen($this->getPiel4()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[0]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel4()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL CUATRO CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[1]);
        $this->Cell(12.6, $alto_celda, ( $this->getCantidadPiel4() > 0 ? number_format($this->getCantidadPiel4(), 2, ".", ",") : ''), 0/* BORDE */, 0, 'R', 0);

        /* PIEL CINCO */
        if (strlen($this->getPiel5()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[2]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel5()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL CINCO CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[3]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadPiel5() > 0 ? number_format($this->getCantidadPiel5(), 2, ".", ",") : ''), 0/* BORDE */, 0, 'R', 0);

        /* PIEL SEIS */
        if (strlen($this->getPiel6()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[4]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getPiel6()), 0/* BORDE */, 0, 'L', 0);

        /* PIEL SEIS CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[5]);
        $this->Cell(12.5, $alto_celda, ($this->getCantidadPiel6() > 0 ? number_format($this->getCantidadPiel6(), 2, ".", ",") : ''), 0/* BORDE */, 1, 'R', 0);
        $this->Line(11.8, $this->GetY(), 196.6, $this->GetY());

        /* FIN PIEL SECCION DOS */

        /* FORRO */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(4.3);
        $this->Cell(6.8, $alto_celda, utf8_decode("Forro"), 0/* BORDE */, 0, 'L', 0);

        /* FORRO SECCION UNO */
        /* FORRO UNO */
        $this->SetFont('Calibri', '', 7);
        $this->SetX($cols[0]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getForro1()), 0/* BORDE */, 0, 'L', 0);

        /* FORRO UNO CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[1]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadForro1() > 0) ? number_format($this->getCantidadForro1(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* FORRO DOS */
        $this->SetFont('Calibri', '', 7);
        $this->SetX($cols[2]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getForro2()), 0/* BORDE */, 0, 'L', 0);

        /* FORRO DOS CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[3]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadForro2() > 0) ? number_format($this->getCantidadForro2(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* FORRO TRES */
        $this->SetFont('Calibri', '', 7);
        $this->SetX($cols[4]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getForro3()), 0/* BORDE */, 0, 'L', 0);

        /* FORRO TRES CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[5]);
        $this->Cell(12.5, $alto_celda, ($this->getCantidadForro3() > 0) ? number_format($this->getCantidadForro3(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* FORRO TOTAL */
        $this->SetX($cols[6]);
        $this->Cell(13.6, $alto_celda, number_format($this->getTotalForro(), 2, ".", ","), 0/* BORDE */, 1, 'C', 0);

        $this->Line(5, $this->GetY(), 210, $this->GetY());
        /* FIN FORRO SECCION UNO */

        /* SINTETICO */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(4.5);
        $this->Cell(6.8, $alto_celda, utf8_decode("Sinte"), 0/* BORDE */, 0, 'L', 0);

        /* SINTETICO SECCION UNO */
        /* SINTETICO UNO */
        if (strlen($this->getSintetico1()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[0]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getSintetico1()), 0/* BORDE */, 0, 'L', 0);

        /* SINTETICO UNO CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[1]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadSintetico1() > 0) ? number_format($this->getCantidadSintetico1(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* SINTETICO DOS */
        if (strlen($this->getSintetico2()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[2]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getSintetico2()), 0/* BORDE */, 0, 'L', 0);

        /* SINTETICO DOS CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[3]);
        $this->Cell(12.6, $alto_celda, ($this->getCantidadSintetico2() > 0) ? number_format($this->getCantidadSintetico2(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* SINTETICO TRES */
        if (strlen($this->getSintetico3()) > 40) {
            $this->SetFont('Calibri', '', 6);
        } else {
            $this->SetFont('Calibri', '', 7);
        }
        $this->SetX($cols[4]);
        $this->Cell(49, $alto_celda, utf8_decode($this->getSintetico3()), 0/* BORDE */, 0, 'L', 0);

        /* SINTETICO TRES CANTIDAD */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[5]);
        $this->Cell(12.5, $alto_celda, ($this->getCantidadSintetico3() > 0) ? number_format($this->getCantidadSintetico3(), 2, ".", ",") : '', 0/* BORDE */, 0, 'R', 0);

        /* SINTETICO TOTAL */
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX($cols[6]);
        $this->Cell(13.6, $alto_celda, utf8_decode($this->getTotalSintetico()), 0/* BORDE */, 1, 'C', 0);

        /* FIN FORRO SECCION UNO */

        /* SUELA */
        $this->SetX(25.5);
        $this->Cell(10, $alto_celda, utf8_decode("Suela"), 1/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', '', 7);
        $this->SetX(35.5);
        $this->Cell(90, $alto_celda, utf8_decode($this->getSuela()), 1/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(150);
        $this->Cell(30, $alto_celda, utf8_decode("Suaje"), 0/* BORDE */, 0, 'C', 0);
        $this->SetX(180.1);
        $this->Cell(30, $alto_celda, utf8_decode($this->getEstatusProduccion()), 0/* BORDE */, 1, 'C', 0);

        /* FIN SERIE/CORRIDA */

        /* SERIE/CORRIDA */
//        $this->Rect(25.5, $this->GetY(), 154/* DER-X */, 7/* DER-Y */);
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(10, $alto_celda, utf8_decode("Corrida"), 0/* BORDE */, 0, 'L', 0);
        $this->SetX(15);
        $this->Cell(10.5, $alto_celda, $this->getSerie(), 0/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', '', 7);
        $xplus = 25.5;
        $wc = 7;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT1(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT2(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT3(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT4(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT5(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT6(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT7(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT8(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT9(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT10(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT11(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT12(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT13(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT14(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT15(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT16(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT17(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT18(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT19(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT20(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT21(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getT22(), 1/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', 'B', 8);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell(10, $alto_celda, "Horma", 0/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', '', 7);
        $this->SetX($xplus + 10);
        $this->Cell(10, $alto_celda, $this->getLinea(), 0/* BORDE */, 1, 'C', 0);
        $this->Line(5, $this->GetY(), 210, $this->GetY());
        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(10, $alto_celda, utf8_decode("Pares"), 0/* BORDE */, 0, 'L', 0);
        $this->SetX(15);
        $this->Cell(10.5, $alto_celda, $this->getPares(), 0/* BORDE */, 0, 'C', 0);
        $this->SetFont('Calibri', '', 7);
        $xplus = 25.5;
        $wc = 7;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC1(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC2(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC3(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC4(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC5(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC6(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC7(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC8(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC9(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC10(), 1/* BORDE */, 0, 'C', 0);

        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC11(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC12(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC13(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC14(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC15(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC16(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC17(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC18(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC19(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC20(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC21(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell($wc, $alto_celda, $this->getC22(), 1/* BORDE */, 0, 'C', 0);
        $xplus += $wc;
        $this->SetX($xplus);
        $this->Cell(30.5, $alto_celda, $this->getLineaT(), 0/* BORDE */, 1, 'C', 0);
        $this->Line(5, $this->GetY(), 210, $this->GetY());

        $this->SetFont('Calibri', 'B', 8);
        $this->SetX(5);
        $this->Cell(5, $alto_celda, utf8_decode("Obs."), 0/* BORDE */, 0, 'L', 0);
        $this->SetX(11);
        $this->Cell(200, $alto_celda, $this->getObs(), 0/* BORDE */, 1, 'L', 0);
        $this->Line(5, $this->GetY(), 210, $this->GetY());


        /* FIN SERIE/CORRIDA */

        $this->AliasNbPages('{totalPages}');
        // Go to 1.5 cm from bottom
        $this->SetY(2);
        $this->SetX(188);
        // Select Calibri italic 8
        $this->SetFont('Calibri', 'I', 7);
        // Print centered page number
        $this->SetTextColor(0, 0, 0);
        $this->Cell(32, 3, utf8_decode('Pag. ' . $this->PageNo() . ' de {totalPages}'), 0, 0, 'R');
        $this->SetY(50);
        $this->SetX(5);
    }

    function Footer() {
//        $ac = 3;
//        // Go to 1.5 cm from bottom
//        $this->SetY(-32.5);
//        $this->SetX(5);
//        // Select Calibri italic 8
//        $this->SetFont('Calibri', 'B', 6.5);
//        // Print centered page number
//        $this->Cell(130, 3.5, 'IMPORTANTE', 1, 1, 'C');
//        $this->SetX(5);
//        $this->Cell(130, $ac, utf8_decode('1.- No se recibira ningún documento sin una copia de la orden de compra.'), 0, 1, 'L');
//        $this->SetX(5);
//        $this->Cell(130, $ac, utf8_decode('2.- Las cantidades en el documento deben de coincidir con la orden de compra.'), 0, 1, 'L');
//        $this->SetX(5);
//        $this->Cell(130, $ac, utf8_decode('3.- Solo se recibirán las parcialidades en la fecha descrita en  esta orden de compra.'), 0, 1, 'L');
//        $this->SetX(5);
//        $this->MultiCell(130, $ac, utf8_decode('4.- Solo en el caso de pieles y forros la cantidad a entregar podra variar más menos 500 DM2 teniendo en cuenta que el total de la misma no deberá exceder mas de los 500 DM2 mencionados.'), 0, 'L');
//
//        $this->SetY(-26);
//        $this->SetX(135);
//        $this->Cell(60, $ac, utf8_decode('Recibe mercancia'), 0, 1, 'L');
//        $this->SetX(135);
//        $this->Cell(60, $ac, utf8_decode('Nombre, firma y fecha de confirmación pedido'), 0, 1, 'L');
//
//
//        $this->SetY(-32.5);
//        $this->SetX(200);
//        $this->Rect(200/* X */, $this->GetY()/* Y */, 75, 17.5);
//        $this->Cell(75, $ac, utf8_decode('Favor de entregar mercancia y orden de compra en almacen'), 0, 1, 'C');
//        $this->SetY(-18);
//        $this->SetX(200);
//        $this->Cell(75, $ac, utf8_decode('Atentamente COMPRAS'), 1, 1, 'C');
    }

    var $widths;
    var $aligns;
    var $alto = 5;

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
            $this->SetFillColor(0, 0, 0);
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
            $this->SetFillColor(225, 225, 234);
            $this->MultiCell($w, 4, $data[$i], 0, $a, $this->getFilled());
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

    protected $T128;                                         // Tableau des codes 128
    protected $ABCset = "";                                  // jeu des caractères éligibles au C128
    protected $Aset = "";                                    // Set A du jeu des caractères éligibles
    protected $Bset = "";                                    // Set B du jeu des caractères éligibles
    protected $Cset = "";                                    // Set C du jeu des caractères éligibles
    protected $SetFrom;                                      // Convertisseur source des jeux vers le tableau
    protected $SetTo;                                        // Convertisseur destination des jeux vers le tableau
    protected $JStart = array("A" => 103, "B" => 104, "C" => 105); // Caractères de sélection de jeu au début du C128
    protected $JSwap = array("A" => 101, "B" => 100, "C" => 99);   // Caractères de changement de jeu

//____________________________ Extension du constructeur _______________________

    function __construct($orientation = 'P', $unit = 'mm', $format = 'A4') {

        parent::__construct($orientation, $unit, $format);

        $this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
        $this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
        $this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
        $this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
        $this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
        $this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
        $this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
        $this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
        $this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
        $this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
        $this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
        $this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
        $this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
        $this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
        $this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
        $this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
        $this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
        $this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
        $this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
        $this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
        $this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
        $this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
        $this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
        $this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
        $this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
        $this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
        $this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
        $this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
        $this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
        $this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
        $this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
        $this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
        $this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
        $this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
        $this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
        $this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
        $this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
        $this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
        $this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
        $this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
        $this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
        $this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
        $this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
        $this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
        $this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
        $this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
        $this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
        $this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
        $this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
        $this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
        $this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
        $this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
        $this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
        $this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
        $this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
        $this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
        $this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
        $this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
        $this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
        $this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
        $this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
        $this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
        $this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
        $this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
        $this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
        $this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
        $this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
        $this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
        $this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
        $this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
        $this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
        $this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
        $this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
        $this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
        $this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
        $this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
        $this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
        $this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
        $this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
        $this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
        $this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
        $this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
        $this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
        $this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
        $this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
        $this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
        $this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
        $this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
        $this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
        $this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
        $this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
        $this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
        $this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
        $this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
        $this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
        $this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
        $this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
        $this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
        $this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
        $this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
        $this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]
        $this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
        $this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
        $this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
        $this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
        $this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
        $this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
        $this->T128[] = array(2, 1);                       //107 : [END BAR]

        for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
            $this->ABCset .= chr($i);
        }
        $this->Aset = $this->ABCset;
        $this->Bset = $this->ABCset;

        for ($i = 0; $i <= 31; $i++) {
            $this->ABCset .= chr($i);
            $this->Aset .= chr($i);
        }
        for ($i = 96; $i <= 127; $i++) {
            $this->ABCset .= chr($i);
            $this->Bset .= chr($i);
        }
        for ($i = 200; $i <= 210; $i++) {                                           // controle 128
            $this->ABCset .= chr($i);
            $this->Aset .= chr($i);
            $this->Bset .= chr($i);
        }
        $this->Cset = "0123456789" . chr(206);

        for ($i = 0; $i < 96; $i++) {                                                   // convertisseurs des jeux A & B
            @$this->SetFrom["A"] .= chr($i);
            @$this->SetFrom["B"] .= chr($i + 32);
            @$this->SetTo["A"] .= chr(($i < 32) ? $i + 64 : $i - 32);
            @$this->SetTo["B"] .= chr($i);
        }
        for ($i = 96; $i < 107; $i++) {                                                 // contrôle des jeux A & B
            @$this->SetFrom["A"] .= chr($i + 104);
            @$this->SetFrom["B"] .= chr($i + 104);
            @$this->SetTo["A"] .= chr($i);
            @$this->SetTo["B"] .= chr($i);
        }
    }

//________________ Fonction encodage et dessin du code 128 _____________________
    function Code128($x, $y, $code, $w, $h) {
        $Aguid = "";                                                                      // Création des guides de choix ABC
        $Bguid = "";
        $Cguid = "";
        for ($i = 0; $i < strlen($code); $i++) {
            $needle = substr($code, $i, 1);
            $Aguid .= ((strpos($this->Aset, $needle) === false) ? "N" : "O");
            $Bguid .= ((strpos($this->Bset, $needle) === false) ? "N" : "O");
            $Cguid .= ((strpos($this->Cset, $needle) === false) ? "N" : "O");
        }

        $SminiC = "OOOO";
        $IminiC = 4;

        $crypt = "";
        while ($code > "") {
            // BOUCLE PRINCIPALE DE CODAGE
            $i = strpos($Cguid, $SminiC);                                                // forçage du jeu C, si possible
            if ($i !== false) {
                $Aguid [$i] = "N";
                $Bguid [$i] = "N";
            }

            if (substr($Cguid, 0, $IminiC) == $SminiC) {                                  // jeu C
                $crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // début Cstart, sinon Cswap
                $made = strpos($Cguid, "N");                                             // étendu du set C
                if ($made === false) {
                    $made = strlen($Cguid);
                }
                if (fmod($made, 2) == 1) {
                    $made--;                                                            // seulement un nombre pair
                }
                for ($i = 0; $i < $made; $i += 2) {
                    $crypt .= chr(strval(substr($code, $i, 2)));                          // conversion 2 par 2
                }
                $jeu = "C";
            } else {
                $madeA = strpos($Aguid, "N");                                            // étendu du set A
                if ($madeA === false) {
                    $madeA = strlen($Aguid);
                }
                $madeB = strpos($Bguid, "N");                                            // étendu du set B
                if ($madeB === false) {
                    $madeB = strlen($Bguid);
                }
                $made = (($madeA < $madeB) ? $madeB : $madeA );                         // étendu traitée
                $jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

                $crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // début start, sinon swap

                $crypt .= strtr(substr($code, 0, $made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu
            }
            $code = substr($code, $made);                                           // raccourcir légende et guides de la zone traitée
            $Aguid = substr($Aguid, $made);
            $Bguid = substr($Bguid, $made);
            $Cguid = substr($Cguid, $made);
        }                                                                          // FIN BOUCLE PRINCIPALE

        $check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
        for ($i = 0; $i < strlen($crypt); $i++) {
            $check += (ord($crypt[$i]) * $i);
        }
        $check %= 103;

        $crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

        $i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
        $modul = $w / $i;

        for ($i = 0; $i < strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
            $c = $this->T128[ord($crypt[$i])];
            for ($j = 0; $j < count($c); $j++) {
                $this->Rect($x, $y, $c[$j] * $modul, $h, "F");
                $x += ($c[$j++] + $c[$j]) * $modul;
            }
        }
    }

}
