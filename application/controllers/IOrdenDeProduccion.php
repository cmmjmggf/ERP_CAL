<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class IOrdenDeProduccion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Iordendeproduccion_model', 'iopm')->helper('ordendeproduccion_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vIOrdenDeProduccion')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $x = $this->input;
            print json_encode($this->iopm->getRecords($x->get('CONTROL_INICIAL'), $x->get('CONTROL_FINAL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerElUltimoControl() {
        try {
            print json_encode($this->iopm->onObtenerElUltimoControl($this->input->get('SEMANA'), $this->input->get('MAQUILA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTE DE ORDENDEPRODUCCION */

    public function getOrdenDeProduccion() {
        try {
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
//            $pdf = new PDF('P', 'mm', array(269.875, 349.25));
            $INICIO = $this->input->post('INICIO');
            $FIN = $this->input->post('FIN');
            $SEMANA = $this->input->post('SEMANA');
            $ANO = $this->input->post('ANIO');
            $DIA = $this->input->post('DIA');

            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
//            $CONTROLES = $this->iopm->getControlesXOrdenDeProduccionEntreControles(
//                    $INICIO, $FIN, $SEMANA, $ANO);
            $this->db->select("OP.Control, OP.ControlT, E.Foto AS FOTO, "
                            . "E.Observaciones AS OBSERVACIONES_ESTILO, C.ObservacionesOrdenProduccion AS "
                            . "OBSERVACIONES_COLOR", false)->from('ordendeproduccion AS OP')
                    ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion')
                    ->join('pedidox AS PE', 'OP.ControlT = PE.Control');
            if ($this->session->USERNAME !== 'ALEJANDRA' && $SEMANA !== '' && $DIA !== '') {
                $this->db->join('programacion AS PR', 'OP.ControlT = PR.control');
            }
            $this->db->join('colores AS C', 'OP.Color = C.Clave', 'left')
                    ->join('estilos AS E', 'OP.Estilo = E.Clave', 'left');
            if ($INICIO !== '' && $FIN !== '') {
                $this->db->where("OP.ControlT BETWEEN {$INICIO} AND {$FIN}", null, false);
            }
            if ($SEMANA !== '') {
                $this->db->where("PE.SemProg", $SEMANA);
            }
            if ($ANO !== '') {
                $this->db->where("PE.AnioProg", $ANO);
            }
            if ($DIA !== '') {
                $this->db->where("PE.DiaProg", $DIA);
            }
            $this->db->where_not_in("PE.stsavan", array(14))
                    ->where_not_in("PE.Estatus", array('C'))
                    ->where_not_in("PE.EstatusProduccion", array('CANCELADO'))
                    ->where_not_in("PE.DeptoProduccion", array(270));
            $CONTROLES = $this->db->where('E.Clave = C.Estilo', null, false)
                            ->group_by(array('OP.ControlT'))
                            ->order_by('ABS(OP.ControlT)', 'ASC')
                            ->order_by('ABS(OPD.Departamento)', 'ASC')->get()->result();
//            print "\n";
//            print $this->db->last_query();
//            print "\n";
            $REPORTE = array("PAGINAS" => 0/* NO */, "URL" => "");
            if (count($CONTROLES) <= 0) {
                print json_encode(array("PAGINAS" => 0, "URL" => ""));
                exit(0);
            }
//            print "\n";
//            print $this->db->last_query();
//            print "\n";
//            exit(0);
            $CLIENTE_CON_SERIE_EUROPEA = false;
            $CLIENTE_CON_SERIE_EUROPEA_SERIE = 1;
            $CLIENTE_CON_SERIE_EUROPEA_GENERO = 1;
            foreach ($CONTROLES as $kc => $vc) {
//                $OP = $this->iopm->getOrdenDeProduccionEntreControles($vc->ControlT, $vc->ControlT, $SEMANA, $ANO);

                $this->db->select("OP.Clave, OP.Cliente, OP.FechaEntrega, "
                                . "OP.FechaPedido, OP.Control, OP.ControlT, OP.Pedido, OP.Linea, "
                                . "OP.LineaT, OP.Recio, OP.Estilo, OP.EstiloT, OP.Color, "
                                . "OP.ColorT, OP.Agente, OP.Transporte, OP.Piel1, OP.CantidadPiel1, "
                                . "OP.Piel2, "
                                . "IFNULL(OP.CantidadPiel2,0) AS CantidadPiel2, "
                                . "CASE WHEN OP.Piel3 IS NULL THEN '' ELSE OP.Piel3 END AS Piel3,  "
                                . "IFNULL(OP.CantidadPiel3,0) AS CantidadPiel3, OP.Piel4, "
                                . "OP.CantidadPiel4, OP.Piel5, OP.CantidadPiel5, OP.Piel6, OP.CantidadPiel6, "
                                . "OP.TotalPiel, OP.Forro1, OP.CantidadForro1, OP.Forro2, OP.CantidadForro2, "
                                . "OP.Forro3, OP.CantidadForro3, OP.TotalForro, OP.Sintetico1, OP.CantidadSintetico1, "
                                . "OP.Sintetico2, OP.CantidadSintetico2, OP.Sintetico3, OP.CantidadSintetico3, OP.TotalSintetico, "
                                . "OP.Suela, OP.SuelaT, OP.Suaje, OP.SerieCorrida, "
                                . "OP.S1, OP.S2, OP.S3, OP.S4, OP.S5, OP.S6, OP.S7, OP.S8, OP.S9, OP.S10, "
                                . "OP.S11, OP.S12, OP.S13, OP.S14, OP.S15, OP.S16, OP.S17, OP.S18, OP.S19, OP.S20, "
                                . "OP.S21, OP.S22, "
                                . "OP.Horma, OP.Pares, "
                                . "OP.C1, OP.C2, OP.C3, OP.C4, OP.C5, OP.C6, OP.C7, OP.C8, OP.C9, OP.C10, "
                                . "OP.C11, OP.C12, OP.C13, OP.C14, OP.C15, OP.C16, OP.C17, OP.C18, OP.C19, OP.C20, "
                                . "OP.C21, OP.C22,"
                                . "OP.Observaciones,"
                                . "OP.ObservacionesDetalle,"
                                . "OP.EstatusProduccion, OPD.Departamento AS DEPARTAMENTO, "
                                . "OPD.DepartamentoT AS DEPARTAMENTOT, OPD.PiezaT AS PIEZA, "
                                . "OPD.ArticuloT AS ARTICULOT, OPD.PzXPar AS PZXPAR, "
                                . "OPD.UnidadMedidaT AS UNIDAD, FORMAT(OPD.Cantidad,2) AS CANTIDAD, "
                                . "(CASE "
                                . "WHEN OPD.PiezaClasificacion = 1 THEN ' - 1ra' "
                                . "WHEN OPD.PiezaClasificacion = 2 THEN ' - 2da' "
                                . "WHEN OPD.PiezaClasificacion = 3 THEN ' - 3ra' "
                                . " ELSE '' END) AS CLASIFICACION", false)
                        ->from('ordendeproduccion AS OP')
                        ->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
                if ($vc->ControlT !== '' && $vc->ControlT !== '') {
                    $this->db->where("OP.ControlT BETWEEN {$vc->ControlT} AND {$vc->ControlT}", null, false);
                }
                $OP = $this->db->order_by('ABS(OPD.Departamento)', 'ASC')->order_by('OPD.ArticuloT', 'ASC')->get()->result();

//                $DEPARTAMENTOS = $this->iopm->getDepartamentosXOrdenDeProduccionEntreControles($vc->ControlT, $vc->ControlT, $SEMANA, $ANO);

                /*  DepartamentosXOrdenDeProduccionEntreControles */
                $this->db->select("OPD.Departamento AS DEPARTAMENTO, OPD.DepartamentoT AS DEPARTAMENTOT", false)
                        ->from('ordendeproduccion AS OP')->join('ordendeproducciond AS OPD', 'OP.ID = OPD.OrdenDeProduccion');
                if ($vc->ControlT !== '' && $vc->ControlT !== '') {
                    $this->db->where("OP.ControlT BETWEEN {$vc->ControlT} AND {$vc->ControlT}", null, false);
                }
                $DEPARTAMENTOS = $this->db->group_by(array('OPD.Departamento'))
                                ->order_by('ABS(OPD.Departamento)', 'ASC')->get()->result();

                $P = $OP[0];
                if (intval($P->Clave) === 1810) {
                    $CLIENTE_CON_SERIE_EUROPEA = true;
                    $CLIENTE_CON_SERIE_EUROPEA_SERIE = intval($P->SerieCorrida);
                    $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS = ARRAY(
                        ($P->S1 !== '0' ? $P->S1 : '-'),
                        ($P->S2 !== '0' ? $P->S2 : '-'),
                        ($P->S3 !== '0' ? $P->S3 : '-'),
                        ($P->S4 !== '0' ? $P->S4 : '-'),
                        ($P->S5 !== '0' ? $P->S5 : '-'),
                        ($P->S6 !== '0' ? $P->S6 : '-'),
                        ($P->S7 !== '0' ? $P->S7 : '-'),
                        ($P->S8 !== '0' ? $P->S8 : '-'),
                        ($P->S9 !== '0' ? $P->S9 : '-'),
                        ($P->S10 !== '0' ? $P->S10 : '-'),
                        ($P->S11 !== '0' ? $P->S11 : '-'),
                        ($P->S12 !== '0' ? $P->S12 : '-'),
                        ($P->S13 !== '0' ? $P->S13 : '-'),
                        ($P->S14 !== '0' ? $P->S14 : '-'),
                        ($P->S15 !== '0' ? $P->S15 : '-'),
                        ($P->S16 !== '0' ? $P->S16 : '-'),
                        ($P->S17 !== '0' ? $P->S17 : '-'),
                        ($P->S18 !== '0' ? $P->S18 : '-'),
                        ($P->S19 !== '0' ? $P->S19 : '-'),
                        ($P->S20 !== '0' ? $P->S20 : '-'),
                        ($P->S21 !== '0' ? $P->S21 : '-'),
                        ($P->S22 !== '0' ? $P->S22 : '-')
                    );
                    $CLIENTE_CON_SERIE_EUROPEA_PARES = ARRAY(
                        ($P->C1 !== '0' ? $P->C1 : '-'),
                        ($P->C2 !== '0' ? $P->C2 : '-'),
                        ($P->C3 !== '0' ? $P->C3 : '-'),
                        ($P->C4 !== '0' ? $P->C4 : '-'),
                        ($P->C5 !== '0' ? $P->C5 : '-'),
                        ($P->C6 !== '0' ? $P->C6 : '-'),
                        ($P->C7 !== '0' ? $P->C7 : '-'),
                        ($P->C8 !== '0' ? $P->C8 : '-'),
                        ($P->C9 !== '0' ? $P->C9 : '-'),
                        ($P->C10 !== '0' ? $P->C10 : '-'),
                        ($P->C11 !== '0' ? $P->C11 : '-'),
                        ($P->C12 !== '0' ? $P->C12 : '-'),
                        ($P->C13 !== '0' ? $P->C13 : '-'),
                        ($P->C14 !== '0' ? $P->C14 : '-'),
                        ($P->C15 !== '0' ? $P->C15 : '-'),
                        ($P->C16 !== '0' ? $P->C16 : '-'),
                        ($P->C17 !== '0' ? $P->C17 : '-'),
                        ($P->C18 !== '0' ? $P->C18 : '-'),
                        ($P->C19 !== '0' ? $P->C19 : '-'),
                        ($P->C20 !== '0' ? $P->C20 : '-'),
                        ($P->C21 !== '0' ? $P->C21 : '-'),
                        ($P->C22 !== '0' ? $P->C22 : '-')
                    );
                    $CLIENTE_CON_SERIE_EUROPEA_GENERO = intval($P->SerieCorrida);
                }
                $pdf->setCliente($P->Clave . " " . $P->Cliente);
                $pdf->setFechaEntrega($P->FechaEntrega);
                $pdf->setObs("{$P->Observaciones}");
                $pdf->setControl($P->ControlT);
                $pdf->setFechaPedido($P->FechaPedido);
                $pdf->setPedido($P->Pedido);
                $pdf->setEstilo($P->Estilo . "  -  " . $P->Color . " " . $P->ColorT);
                $pdf->setAgente($P->Agente);
                $pdf->setTrasp($P->Transporte);
                $pdf->setSuela($P->SuelaT);
                /* PIELES */
                $pdf->setPiel1($P->Piel1);
                $pdf->setPiel2($P->Piel2);
                $pdf->setPiel3($P->Piel3);
                $pdf->setPiel4($P->Piel4);
                $pdf->setPiel5($P->Piel5);
                $pdf->setPiel6($P->Piel6);

                $pdf->setCantidadPiel1($P->CantidadPiel1);
                $pdf->setCantidadPiel2($P->CantidadPiel2);
                $pdf->setCantidadPiel3($P->CantidadPiel3);
                $pdf->setCantidadPiel4($P->CantidadPiel4);
                $pdf->setCantidadPiel5($P->CantidadPiel5);
                $pdf->setCantidadPiel6($P->CantidadPiel6);
                $pdf->setTotalPiel($P->TotalPiel);

                /* FORRO */
                $pdf->setForro1($P->Forro1);
                $pdf->setForro2($P->Forro2);
                $pdf->setForro3($P->Forro3);

                $pdf->setCantidadForro1($P->CantidadForro1);
                $pdf->setCantidadForro2($P->CantidadForro2);
                $pdf->setCantidadForro3($P->CantidadForro3);
                $pdf->setTotalForro($P->TotalForro);

                /* SINTETICO */
                $pdf->setSintetico1($P->Sintetico1);
                $pdf->setSintetico2($P->Sintetico2);
                $pdf->setSintetico3($P->Sintetico3);

                $pdf->setCantidadSintetico1($P->CantidadSintetico1);
                $pdf->setCantidadSintetico2($P->CantidadSintetico2);
                $pdf->setCantidadSintetico3($P->CantidadSintetico3);
                $pdf->setTotalSintetico($P->TotalSintetico);

                $pdf->setSerie($P->SerieCorrida);
                $pdf->setT1(($P->S1 !== '0' ? $P->S1 : '-'));
                $pdf->setT2(($P->S2 !== '0' ? $P->S2 : '-'));
                $pdf->setT3(($P->S3 !== '0' ? $P->S3 : '-'));
                $pdf->setT4(($P->S4 !== '0' ? $P->S4 : '-'));
                $pdf->setT5(($P->S5 !== '0' ? $P->S5 : '-'));
                $pdf->setT6(($P->S6 !== '0' ? $P->S6 : '-'));
                $pdf->setT7(($P->S7 !== '0' ? $P->S7 : '-'));
                $pdf->setT8(($P->S8 !== '0' ? $P->S8 : '-'));
                $pdf->setT9(($P->S9 !== '0' ? $P->S9 : '-'));
                $pdf->setT10(($P->S10 !== '0' ? $P->S10 : '-'));
                $pdf->setT11(($P->S11 !== '0' ? $P->S11 : '-'));
                $pdf->setT12(($P->S12 !== '0' ? $P->S12 : '-'));
                $pdf->setT13(($P->S13 !== '0' ? $P->S13 : '-'));
                $pdf->setT14(($P->S14 !== '0' ? $P->S14 : '-'));
                $pdf->setT15(($P->S15 !== '0' ? $P->S15 : '-'));
                $pdf->setT16(($P->S16 !== '0' ? $P->S16 : '-'));
                $pdf->setT17(($P->S17 !== '0' ? $P->S17 : '-'));
                $pdf->setT18(($P->S18 !== '0' ? $P->S18 : '-'));
                $pdf->setT19(($P->S19 !== '0' ? $P->S19 : '-'));
                $pdf->setT20(($P->S20 !== '0' ? $P->S20 : '-'));
                $pdf->setT21(($P->S21 !== '0' ? $P->S21 : '-'));
                $pdf->setT22(($P->S22 !== '0' ? $P->S22 : '-'));
                $pdf->setEstatusProduccion($P->EstatusProduccion);
                $pdf->setLinea($P->Linea);
                $pdf->setLineaT($P->LineaT);
                $pdf->setPares($P->Pares);
                $pdf->setC1(($P->C1 !== '0' ? $P->C1 : '-'));
                $pdf->setC2(($P->C2 !== '0' ? $P->C2 : '-'));
                $pdf->setC3(($P->C3 !== '0' ? $P->C3 : '-'));
                $pdf->setC4(($P->C4 !== '0' ? $P->C4 : '-'));
                $pdf->setC5(($P->C5 !== '0' ? $P->C5 : '-'));
                $pdf->setC6(($P->C6 !== '0' ? $P->C6 : '-'));
                $pdf->setC7(($P->C7 !== '0' ? $P->C7 : '-'));
                $pdf->setC8(($P->C8 !== '0' ? $P->C8 : '-'));
                $pdf->setC9(($P->C9 !== '0' ? $P->C9 : '-'));
                $pdf->setC10(($P->C10 !== '0' ? $P->C10 : '-'));
                $pdf->setC11(($P->C11 !== '0' ? $P->C11 : '-'));
                $pdf->setC12(($P->C12 !== '0' ? $P->C12 : '-'));
                $pdf->setC13(($P->C13 !== '0' ? $P->C13 : '-'));
                $pdf->setC14(($P->C14 !== '0' ? $P->C14 : '-'));
                $pdf->setC15(($P->C15 !== '0' ? $P->C15 : '-'));
                $pdf->setC16(($P->C16 !== '0' ? $P->C16 : '-'));
                $pdf->setC17(($P->C17 !== '0' ? $P->C17 : '-'));
                $pdf->setC18(($P->C18 !== '0' ? $P->C18 : '-'));
                $pdf->setC19(($P->C19 !== '0' ? $P->C19 : '-'));
                $pdf->setC20(($P->C20 !== '0' ? $P->C20 : '-'));
                $pdf->setC21(($P->C21 !== '0' ? $P->C21 : '-'));
                $pdf->setC22(($P->C22 !== '0' ? $P->C22 : '-'));

                $pdf->AddPage();
                $pdf->SetAutoPageBreak(true, 10);

                $anchos = array(35, 40, 8, 10, 10, 35, 40, 8, 10, 10);
                $aligns = array('L', 'L', 'L', 'L', 'L');
                $pdf->SetTextColor(0, 0, 0);
                /* RESUMEN */
                $pdf->setY(49.5); //DISTANCIA ENTRE EL ENCABEZADO Y EL DETALLE

                /* FOREACH PIEZAS | ARTICULOS | PZXPAR | UNIDAD | CANTIDAD */
                $PUNTO_INICIAL = $pdf->GetY();
                $COLUMN = 1;
                $X = 108;

                /* COLUMNA UNO */
                $pdf->SetFont('Calibri', 'B', 7.1);
                $col = array(5/* 0 */, 40/* 1 */, 80/* 2 */, 88/* 3 */, 98/* 4 */, 108/* 5 */, 143/* 6 */, 183/* 7 */, 191/* 8 */, 201/* 9 */);
                $anc = array(35, 40, 8, 10, 10);
                $alto_celda = 3.5;
                $pdf->SetX($col[0]);
                $pdf->Cell($anc[0], $alto_celda, "Pieza", 0/* BORDE */, 0, 'L', 0);

                $pdf->SetX($col[1]);
                $pdf->Cell($anc[1], $alto_celda, "Articulos", 0/* BORDE */, 0, 'L', 0);

                $pdf->SetX($col[2]);
                $pdf->Cell($anc[2], $alto_celda, "PzXP", 0/* BORDE */, 0, 'C', 0);

                $pdf->SetX($col[3]);
                $pdf->Cell($anc[3], $alto_celda, "Um-Me", 0/* BORDE */, 0, 'C', 0);

                $pdf->SetX($col[4]);
                $pdf->Cell($anc[4], $alto_celda, "Cant", 0/* BORDE */, 0, 'C', 0);

                /* COLUMNA DOS */
                $pdf->SetX($col[5]);
                $pdf->Cell($anc[0], $alto_celda, "Pieza", 0/* BORDE */, 0, 'L', 0);

                $pdf->SetX($col[6]);
                $pdf->Cell($anc[1], $alto_celda, "Articulos", 0/* BORDE */, 0, 'L', 0);

                $pdf->SetX($col[7]);
                $pdf->Cell($anc[2], $alto_celda, "PzXP", 0/* BORDE */, 0, 'C', 0);

                $pdf->SetX($col[8]);
                $pdf->Cell($anc[3], $alto_celda, "Um-Me", 0/* BORDE */, 0, 'C', 0);

                $pdf->SetX($col[9]);
                $pdf->Cell($anc[4], $alto_celda, "Cant", 0/* BORDE */, 1, 'C', 0);
                /* COLUMNA UNO */
                $pdf->SetLineWidth(0.4);
                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());

                $pdf->SetLineWidth(0.2);
                $Y = $pdf->GetY();
                $CELL = 0;
                foreach ($DEPARTAMENTOS as $dk => $dv) {
                    if ($COLUMN === 2) {
                        $pdf->Cell(200, 3, "", 0/* BORDE */, 1/* SALTO NO */, 'C', 0);
                    }
                    $pdf->setFilled(false);
                    $pdf->setBorders(0);
                    $pdf->SetFont('Calibri', 'B', 8);
                    $pdf->SetLineWidth(0.4);
                    $pdf->SetX(5);
                    $pdf->Cell(25, 3.5, $dv->DEPARTAMENTOT, 1/* BORDE */, 1, 'C', 0);
                    /* FIN TALLAS */
                    $pdf->setAlto(3.5);
                    $col = array(5/* 0 */, 30/* 1 */, 80/* 2 */, 88/* 3 */, 98/* 4 */, 108/* 5 */, 133/* 6 */, 183/* 7 */, 191/* 8 */, 200/* 9 */);
                    $anc = array(25, 50, 8, 10, 10);
                    $alto_celda = 3;
                    $COLUMN = 1;
                    $border = 0;
                    $pdf->SetLineWidth(0.2);
                    foreach ($OP as $k => $v) {
                        /* PRIMER DETALLE */
                        if ($vc->ControlT === $v->ControlT && $v->DEPARTAMENTO === $dv->DEPARTAMENTO) {
                            $pdf->SetFont('Calibri', '', 7.1);
                            switch ($COLUMN) {
                                case 1:
                                    $COLUMN += 1;
                                    $pdf->SetX($col[0]);
                                    $pdf->Cell($anc[0], $alto_celda, utf8_decode(mb_strimwidth($v->PIEZA, 0, 17)), $border/* BORDE */, 0, 'L', 0);

                                    $pdf->SetX($col[1]);
                                    $pdf->Cell($anc[1], $alto_celda, utf8_decode(mb_strimwidth($v->ARTICULOT, 0, 44)) . " " . $v->CLASIFICACION, $border/* BORDE */, 0, 'L', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[2]);
                                    $pdf->Cell($anc[2], $alto_celda, ($v->PZXPAR > 0) ? $v->PZXPAR : '', $border/* BORDE */, 0, 'C', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[3]);
                                    $pdf->Cell($anc[3], $alto_celda, $v->UNIDAD, $border/* BORDE */, 0, 'C', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[4]);
                                    $pdf->Cell($anc[4], $alto_celda, $v->CANTIDAD, $border/* BORDE */, 0/* SALTO NO */, 'R', 0);
                                    $pdf->Line(5, $pdf->GetY() + $alto_celda, 108, $pdf->GetY() + $alto_celda);
                                    $CELL = 1;
                                    break;
                                case 2:
                                    $COLUMN = 1;
                                    $pdf->SetX($col[5]);
                                    $pdf->Cell($anc[0], $alto_celda, utf8_decode(mb_strimwidth($v->PIEZA, 0, 17)), $border/* BORDE */, 0, 'L', 0);

                                    $pdf->SetX($col[6]);
                                    $pdf->Cell($anc[1], $alto_celda, utf8_decode(mb_strimwidth($v->ARTICULOT, 0, 44)) . " " . $v->CLASIFICACION, $border/* BORDE */, 0, 'L', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[7]);
                                    $pdf->Cell($anc[2], $alto_celda, ($v->PZXPAR > 0) ? $v->PZXPAR : '', $border/* BORDE */, 0, 'C', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[8]);
                                    $pdf->Cell($anc[3], $alto_celda, $v->UNIDAD, $border/* BORDE */, 0, 'C', 0);

                                    $pdf->SetFont('Calibri', 'B', 7.1);
                                    $pdf->SetX($col[9]);
                                    $pdf->Cell($anc[4], $alto_celda, $v->CANTIDAD, $border/* BORDE */, 1/* SALTO SI */, 'R', 0);
                                    $pdf->Line(108, $pdf->GetY(), 210, $pdf->GetY());
                                    $CELL = 2;
                                    break;
                            }
                            /* FIN PRIMER DETALLE */
                        }
                    }
//                    $pdf->Rect(5, $PUNTO_INICIAL, 104/* DER-X */, $pdf->GetY()/* DER-Y */);
                }

                if ($COLUMN === 2 && $CELL === 1) {
                    $pdf->Cell(200, 3.5, "", 0/* BORDE */, 1/* SALTO NO */, 'C', 0);
                    $pdf->Line(108, $pdf->GetY() - 0.5, 210, $pdf->GetY());
                }

                $pdf->SetLineWidth(0.4);
                $pdf->Line(5, $Y, 5, $pdf->GetY() - 0.5);
                $pdf->Line(108, $Y, 108, $pdf->GetY() - 0.5);
                $pdf->Line(210, $Y, 210, $pdf->GetY());

                $pdf->SetFont('Calibri', 'B', 14);
                $pdf->SetX(5);
                $pdf->Code128(5/* X */, $pdf->GetY()/* Y */, $vc->ControlT/* TEXT */, 53/* ANCHO */, 6/* ALTURA */);

                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(50);
                $pdf->Cell(152, 6, utf8_decode("* LEA CUIDADOSAMENTE LAS INSTRUCCIONES, CUALQUIER ERROR LE SERÁ CARGADO *"), 0/* BORDE */, 1/* SALTO SI */, 'C', 0);
                $OE = strlen($vc->OBSERVACIONES_ESTILO);

                if ($OE > 1) {
                    $pdf->SetX(5);
                    $pdf->Cell(205, 5, (strlen($vc->OBSERVACIONES_ESTILO) > 0) ? utf8_decode($vc->OBSERVACIONES_ESTILO) : '', 0/* BORDE */, 1/* SALTO SI */, 'C', 0);
                }
                $OC = strlen($vc->OBSERVACIONES_COLOR);
                if ($OC > 1) {
                    $pdf->SetX(5);
                    $pdf->Cell(205, 5, utf8_decode($vc->OBSERVACIONES_COLOR), 0/* BORDE */, 1/* SALTO SI */, 'C', 0);
                }


                $path = $vc->FOTO;

                if ($vc->FOTO !== '') {
                    if (!is_file($path)) {
                        // $pdf->Image(base_url() . 'uploads/Empleados/9999.jpg', 68, 11, 30);
                        $pdf->SetLineWidth(.4);
                        $pdf->SetY($pdf->getY());
                        $pdf->SetX(75);
                        $pdf->Image(base_url() . 'uploads/Estilos/esf.jpg', 96, $pdf->getY() + 1, 28);
                    } else {
                        $pdf->Image(base_url() . $vc->FOTO, 96, $pdf->getY() + 1, 28);
                    }
                }
                $pdf->SetY($pdf->getY() + 18);
                $pdf->SetX(5);
                $pdf->Cell(205, 5, utf8_decode($vc->OBSERVACIONES_COLOR), 0/* BORDE */, 1/* SALTO SI */, 'C', 0);

                if ($CLIENTE_CON_SERIE_EUROPEA && $CLIENTE_CON_SERIE_EUROPEA_SERIE === 1) {
                    $alto_celda_final = 4;
                    $posicion_x = 25.5;
                    $ancho_celda = 7;

                    /* SERIE MEXICANA */
                    $pdf->SetY($pdf->getY() + 7);
                    $pdf->SetX(7.5);
                    $pdf->Cell(25, $alto_celda_final, "CABALLERO MX", 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[0], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[1], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[2], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[3], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[4], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[5], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[6], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[7], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_SERIE_TITULOS[8], 1/* BORDE */, 1/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    /* SERIE EUROPEA */
                    $ancho_celda = 7;
                    $pdf->SetY($pdf->getY());
                    $pdf->SetX(7.5);
                    $pdf->Cell(25, $alto_celda_final, "CABALLERO EUR", 1/* BORDE */, 0/* SALTO */, 'C', 0);


                    $pdf->SetX(32.5);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 39.5, 1/* BORDE */, 0, 'C', 0);


                    $pdf->SetX(39.5);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 40, 1/* BORDE */, 0, 'C', 0);

                    $pdf->SetX(46.5);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 40.5, 1/* BORDE */, 0, 'C', 0);

                    $pdf->SetX(53.5);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 41, 1/* BORDE */, 0, 'C', 0);
                    $posicion_x = $pdf->getX();

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 41.5, 1/* BORDE */, 0, 'C', 0);
                    $posicion_x = $pdf->getX();

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 42, 1/* BORDE */, 0, 'C', 0);
                    $posicion_x = $pdf->getX();

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 42.5, 1/* BORDE */, 0, 'C', 0);
                    $posicion_x = $pdf->getX();

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 43, 1/* BORDE */, 0, 'C', 0);
                    $posicion_x = $pdf->getX();

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, 44, 1/* BORDE */, 1, 'C', 0);
                    $posicion_x = $pdf->getX();

                    /* PARES */
                    $pdf->SetFont('Calibri', 'B', 9);
                    $alto_celda_final = 4;
                    $posicion_x = 32.5;
                    $ancho_celda = 7;
                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[0], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[1], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[2], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[3], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[4], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[5], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[6], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[7], 1/* BORDE */, 0/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;

                    $pdf->SetX($posicion_x);
                    $pdf->Cell($ancho_celda, $alto_celda_final, $CLIENTE_CON_SERIE_EUROPEA_PARES[8], 1/* BORDE */, 1/* SALTO */, 'C', 0);
                    $posicion_x += $ancho_celda;
                    $CLIENTE_CON_SERIE_EUROPEA = false;
                }
                /* TOTALES */
                $Y = $pdf->GetY();
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/OrdenesDeProduccion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/OrdenesDeProduccion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "OrdenesDeProduccion_" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            $l = new Logs("IMPRIME ORDEN DE PRODUCCIÓN", "GENERO UN REPORTE DE ORDEN DE PRODUCCIÓN DEL CONTROL {$INICIO} AL CONTROL {$FIN}.", $this->session);
            print json_encode(array("PAGINAS" => 1/* NO */, "URL" => base_url() . $url));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public $Padre = '';
    public $Hijo = '';

    function getPadre() {
        return $this->Padre;
    }

    function getHijo() {
        return $this->Hijo;
    }

    function setPadre($Padre) {
        $this->Padre = $Padre;
    }

    function setHijo($Hijo) {
        $this->Hijo = $Hijo;
    }

    public function onLog($Accion) {
        try {
            /* LOG TO ACCIONS */
            $xlog = array();
            $xlog["Empresa"] = $this->session->Empresa;
            $xlog["Tipo"] = $this->session->TipoAcceso;
            $xlog["IdUsuario"] = $this->session->ID;
            $xlog["Usuario"] = $this->session->Nombre . " " . $this->session->Apellidos;
            $xlog["Modulo"] = "IMPRIME ORDEN DE PRODUCCION";
            $xlog["Accion"] = $this->session->Nombre . " " . $this->session->Apellidos . ":" . $Accion;
            $xlog["Fecha"] = Date('d/m/Y');
            $xlog["Hora"] = Date('h:i:s a');
            $xlog["Dia"] = Date('d');
            $xlog["Mes"] = Date('m');
            $xlog["Anio"] = Date('Y');
            $xlog["Registro"] = Date('d/m/Y h:i:s a');
            $xlog["Padre"] = $this->getPadre();
            $xlog["Hijo"] = $this->getHijo();
            $xlog["Estatus"] = 'ACTIVO';
            $this->db->insert('logs', $xlog);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getSize($i, $limit) {
        $h = $i;
        for ($index = 0; $h > $limit; $index++) {
            $h = $h / 2;
        }
        return $h;
    }

}
