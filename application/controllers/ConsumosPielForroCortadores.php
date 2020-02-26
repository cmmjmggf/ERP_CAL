<?php

class ConsumosPielForroCortadores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ConsumoPielForroXCortador_model', 'cpfxc')
                ->helper('consumopielforro_helper')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }
            $this->load->view('vConsumosPielForroCortadores')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getCortadores() {
        try {
            print json_encode($this->cpfxc->getCortadores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            print json_encode($this->cpfxc->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->cpfxc->onComprobarMaquilas($this->input->get('MAQUILA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->cpfxc->onChecarSemanaValida($this->input->post('SEMANA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getReportePielForro() {
        try {
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $TIPO = $this->input->post('TIPO');
            $MAQUILA = $this->input->post('MAQUILA');
            $SEMANA_INICIAL = $this->input->post('SEMANA_INICIAL');
            $SEMANA_FINAL = $this->input->post('SEMANA_FINAL');
            $ANIO = $this->input->post('ANIO');
            $CORTADOR = $this->input->post('CORTADOR');
            $ARTICULO = $this->input->post('ARTICULO');
            $FECHAINICIAL = $this->input->post('FECHA_INICIAL');
            $FECHAFINAL = $this->input->post('FECHA_FINAL');

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 5);

            $anchos = array(35, 40, 8, 10, 10, 35, 40, 8, 10, 10);
            $aligns = array('L', 'L', 'L', 'L', 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Calibri', 'B', 10);

//            $CORTADORES = $this->cpfxc->getCortadoresXMaquilaSemanaArticulo($ARTICULO, str_pad($MAQUILA, 2, "0", STR_PAD_LEFT), $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $CORTADOR, $TIPO);
            $this->db->select("A.Semana AS SEMANA,A.Maquila AS MAQUILA,
                                   IFNULL(E.Numero,0) AS NUMERO, CONCAT(IFNULL(E.PrimerNombre,\"\"), \" \", IFNULL(E.SegundoNombre,\"\"), \" \", IFNULL(E.Paterno,\"\"), \" \", IFNULL(E.Materno,\"\")) AS CORTADOR ", false)
                    ->from("asignapftsacxc AS A")
                    ->join("empleados AS E", "A.Empleado = IFNULL(E.Numero,0)", 'left');
            if ($ARTICULO !== '') {
                $this->db->where("A.Articulo = '$ARTICULO'", null, false);
            }
            if ($CORTADOR !== '') {
                $this->db->where("A.Empleado = '$CORTADOR'", null, false)
                        ->where("E.Numero = '$CORTADOR'", null, false);
            }
            if ($SEMANA_INICIAL !== '' && $SEMANA_FINAL !== '') {
                $this->db->where("A.Semana BETWEEN '$SEMANA_INICIAL' AND '$SEMANA_FINAL'", null, false);
            }
            if ($MAQUILA !== '') {
                $this->db->where("A.Maquila = '$MAQUILA'", null, false);
            }
            if ($ANIO !== '') {
                $this->db->where("YEAR(str_to_date(A.Fecha, '%d/%m/%Y')) = '$ANIO'", null, false);
            }
            $this->db->where("A.TipoMov ='$TIPO'", null, false)->where('E.AltaBaja', 1)
                    ->group_by('A.Empleado')->order_by('abs(A.Empleado)', 'ASC');
            $CORTADORES = $this->db->get()->result();
//            print $this->db->last_query();
//            EXIT(0);
            $base = 6;
            $alto_celda = 4;
            /* ANCHO DESPUÉS DE LOS MARGENES = 259, ES DE 215, PERO SON 10 DE MARGEN IZQ Y 10 DE MARGEN DER */
            $bordes = 0;
            $pdf->SetY(5);
            $pdf->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30, 12.5);
            $pdf->SetX(40);
            $pdf->Cell(90, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(130);
            switch ($TIPO) {
                case 1:
                    $pdf->Cell(139, $alto_celda, utf8_decode("< Piel >"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                    break;
                case 2:
                    $pdf->Cell(139, $alto_celda, utf8_decode("< Forro >"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                    break;
                default:
                    break;
            }
            $pdf->SetX(40);
            $pdf->Cell(45, $alto_celda, utf8_decode("Consumo real de la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(85);
            $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_INICIAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(95);
            $pdf->Cell(25, $alto_celda, utf8_decode("A la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(120);
            $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_FINAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(130);
            $pdf->Cell(70, $alto_celda, utf8_decode("Fecha " . Date('d/m/Y h:i:s a')), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(200);
            $pdf->Cell(69, $alto_celda, utf8_decode("Página " . $pdf->PageNo()), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetY(18);
            $pdf->SetX(110);
            $pdf->Cell(25, $alto_celda, utf8_decode("Cons ord.prod"), 1/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(135);
            $pdf->Cell(60, $alto_celda, utf8_decode("Consumo"), 1/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(195);
            $pdf->Cell(22, $alto_celda, utf8_decode("Consumo real"), 1/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(217);
            $pdf->Cell(42, $alto_celda, utf8_decode("Pesos $"), 1/* BORDE */, 1/* SALTO */, 'C');
            $bordes = 1;
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetY($pdf->GetY());
            $base = 5;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Control"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(12, $alto_celda, utf8_decode("Estilo"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 12;
            $pdf->SetX($base);
            $pdf->Cell(8, $alto_celda, utf8_decode("Color"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 8;
            $pdf->SetX($base);
            $pdf->Cell(50, $alto_celda, utf8_decode("Articulo"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 50;
            $pdf->SetX($base);
            $pdf->Cell(10, $alto_celda, utf8_decode("Precio"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 10;
            $pdf->SetX($base);
            $pdf->Cell(10, $alto_celda, utf8_decode("Pares"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 10;
            $pdf->SetX($base);
            $pdf->Cell(10, $alto_celda, utf8_decode("X esti"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 10;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("X control"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Entregado"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Devolu"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Basura"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Dcm2"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(7, $alto_celda, utf8_decode("%"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 7;
            $pdf->SetX($base);
            $pdf->Cell(12, $alto_celda, utf8_decode("Sistema"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 12;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Real"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("*PIOCHAS*"), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $TOTAL_X_ESTILO = 0;
            $TOTAL_X_CONTROL = 0;
            $TOTAL_X_ENTREGADO = 0;
            $TOTAL_X_DEVOLUCION = 0;
            $TOTAL_X_BASURA = 0;
            $TOTAL_X_DIFERENCIAS = 0;
            $TOTAL_X_DCM2 = 0;
            $TOTAL_X_PORCENTAJE = 0;
            $TOTAL_X_SISTEMA_PESOS = 0;
            $TOTAL_X_REAL_PESOS = 0;
            $TOTAL_X_DIFERENCIA_PESOS = 0;
            $TOTAL_X_PIOCHAS_PESOS = 0;

            $TOTAL_X_ESTILO_CORTADOR = 0;
            $TOTAL_X_CONTROL_CORTADOR = 0;
            $TOTAL_X_ENTREGADO_CORTADOR = 0;
            $TOTAL_X_DEVOLUCION_CORTADOR = 0;
            $TOTAL_X_BASURA_CORTADOR = 0;
            $TOTAL_X_DIFERENCIAS_CORTADOR = 0;
            $TOTAL_X_DCM2_CORTADOR = 0;
            $TOTAL_X_PORCENTAJE_CORTADOR = 0;
            $TOTAL_X_SISTEMA_PESOS_CORTADOR = 0;
            $TOTAL_X_REAL_PESOS_CORTADOR = 0;
            $TOTAL_X_DIFERENCIA_PESOS_CORTADOR = 0;
            $TOTAL_X_PIOCHAS_PESOS_CORTADOR = 0;
            $Y = 0;
            foreach ($CORTADORES as $k => $v) {
                $bordes = 1;
                $pdf->SetFont('Calibri', 'B', 8);
                $base = 5;
                $pdf->SetFillColor(244, 244, 244);
                $pdf->Rect(5.2, $pdf->GetY() + .2, 268.7, 3.5, 'F');
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda - 1, utf8_decode("Cortador"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetX(20);
                $pdf->Cell(254, $alto_celda - 1, utf8_decode($v->NUMERO . " " . $v->CORTADOR), $bordes/* BORDE */, 1/* SALTO */, 'L');
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
                $ESTILOS = $this->cpfxc->getEstilosPorCortador($ARTICULO, str_pad($MAQUILA, 2, "0", STR_PAD_LEFT), $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $v->NUMERO, $TIPO);
                foreach ($ESTILOS as $kk => $vv) {
                    $RESUMEN = $this->cpfxc->getConsumosPielForroXMaquilaSemanaAnioCortadorArticuloFechaInicialFechaFinal($MAQUILA, $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $CORTADOR, $ARTICULO, $FECHAINICIAL, $FECHAFINAL, $v->NUMERO, $vv->Estilo_X_Cortador, $TIPO);
                    $Y = $pdf->GetY();
                    foreach ($RESUMEN as $kkk => $vvv) {
                        $pdf->SetFont('Calibri', '', 8);
                        $alto_celda = 3.5;
                        $base = 5;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, utf8_decode($vvv->Control), $bordes/* BORDE */, 0/* SALTO */, 'C');
                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(12, $alto_celda, utf8_decode($vvv->Estilo), $bordes/* BORDE */, 0/* SALTO */, 'C');
                        $base += 12;
                        $pdf->SetX($base);
                        $pdf->Cell(8, $alto_celda, utf8_decode($vvv->Color), $bordes/* BORDE */, 0/* SALTO */, 'C');
                        $base += 8;
                        $pdf->SetX($base);
                        $pdf->Cell(50, $alto_celda, utf8_decode($vvv->Articulo . " - " . $vvv->ArticuloT), $bordes/* BORDE */, 0/* SALTO */, 'L');
                        $base += 50;
                        $pdf->SetX($base);
                        $pdf->Cell(10, $alto_celda, utf8_decode($vvv->Precio), $bordes/* BORDE */, 0/* SALTO */, 'R');

                        $base += 10;
                        $pdf->SetX($base);
                        $pdf->Cell(10, $alto_celda, utf8_decode($vvv->Pares), $bordes/* BORDE */, 0/* SALTO */, 'C');
                        $base += 10;
                        $pdf->SetX($base);
                        $pdf->Cell(10, $alto_celda, number_format($vvv->Consumo, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R'); /* X ESTILO */
                        $TOTAL_X_ESTILO += $vvv->Consumo;
                        $TOTAL_X_ESTILO_CORTADOR += $vvv->Consumo;

                        $base += 10;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->Cantidad, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R'); /* X CONTROL */
                        $TOTAL_X_CONTROL += $vvv->Cantidad;
                        $TOTAL_X_CONTROL_CORTADOR += $vvv->Cantidad;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->Abono, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R'); /* ENTREGADO/ABONADO */
                        $TOTAL_X_ENTREGADO += $vvv->Abono;
                        $TOTAL_X_ENTREGADO_CORTADOR += $vvv->Abono;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, utf8_decode($vvv->Devolucion), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_DEVOLUCION += $vvv->Devolucion;
                        $TOTAL_X_DEVOLUCION_CORTADOR += $vvv->Devolucion;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, utf8_decode($vvv->Basura), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_BASURA += $vvv->Basura;
                        $TOTAL_X_BASURA_CORTADOR += $vvv->Basura;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->Diferencia, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_DIFERENCIAS += $vvv->Diferencia;
                        $TOTAL_X_DIFERENCIAS_CORTADOR += $vvv->Diferencia;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->DCM2, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_DCM2 += $vvv->DCM2;
                        $TOTAL_X_DCM2_CORTADOR += $vvv->DCM2;

                        $base += 15;
                        $pdf->SetX($base);
                        $rounded = 0.01 * (int) ($vvv->PORCENTAJE * 100);
                        $pdf->Cell(7, $alto_celda, number_format($rounded, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_PORCENTAJE += $rounded;
                        $TOTAL_X_PORCENTAJE_CORTADOR += $rounded;

                        $base += 7;
                        $pdf->SetX($base);
                        $pdf->Cell(12, $alto_celda, number_format($vvv->SistemaPesos, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_SISTEMA_PESOS += $vvv->SistemaPesos;
                        $TOTAL_X_SISTEMA_PESOS_CORTADOR += $vvv->SistemaPesos;

                        $base += 12;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->RealPesos, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_REAL_PESOS += $vvv->RealPesos;
                        $TOTAL_X_REAL_PESOS_CORTADOR += $vvv->RealPesos;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, number_format($vvv->Diferencia * $vvv->Precio, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                        $TOTAL_X_DIFERENCIA_PESOS += $vvv->Diferencia * $vvv->Precio;
                        $TOTAL_X_DIFERENCIA_PESOS_CORTADOR += $vvv->Diferencia * $vvv->Precio;

                        $base += 15;
                        $pdf->SetX($base);
                        $pdf->Cell(15, $alto_celda, ($vvv->Piocha > 0) ? number_format($vvv->Piocha, 2, '.', ',') : '', $bordes/* BORDE */, 1/* SALTO */, 'R');
                        $TOTAL_X_PIOCHAS_PESOS += $vvv->Piocha;
                        $TOTAL_X_PIOCHAS_PESOS_CORTADOR += $vvv->Piocha;
                        $pdf->Line(5, $pdf->GetY(), 274, $pdf->GetY());
                    }
//                    $cols = array(25/* 1 */, 40/* 2 */, 50/* 3 */, 100/* 4 */, 110/* 5 */,
//                        120/* 6 */, 130/* 7 */, 145/* 8 */, 160/* 9 */, 175/* 10 */,
//                        190/* 10 */, 205/* 11 */, 220/* 12 */, 227/* 13 */, 239/* 14 */, 254/* 15 */);
//                    for ($index = 0; $index < count($cols); $index++) {
//                        $pdf->Line($cols[$index], $Y, $cols[$index], $pdf->GetY()); /* PRIMER COLUMNA */
//                    }
                    $base = 85;
//                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->SetFont('Calibri', 'B', 8);
                    $pdf->SetFillColor(244, 244, 244);
                    $pdf->Rect(5.2, $pdf->GetY() + .2, 268.7, 3.5, 'F');
                    $pdf->SetX(85);
                    $pdf->Cell(25, $alto_celda, utf8_decode("Total por estilo"), 0/* BORDE */, 0/* SALTO */, 'L');
                    $base += 25;
                    $pdf->SetX($base);
                    $pdf->Cell(10, $alto_celda, number_format($TOTAL_X_ESTILO, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 10;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_CONTROL, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_ENTREGADO, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DEVOLUCION, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_BASURA, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIAS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DCM2, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(7, $alto_celda, number_format($TOTAL_X_PORCENTAJE, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 7;
                    $pdf->SetX($base);
                    $pdf->Cell(12, $alto_celda, number_format($TOTAL_X_SISTEMA_PESOS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 12;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_REAL_PESOS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIA_PESOS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_PIOCHAS_PESOS, 2, '.', ','), $bordes/* BORDE */, 1/* SALTO */, 'R');

                    $TOTAL_X_ESTILO = 0;
                    $TOTAL_X_CONTROL = 0;
                    $TOTAL_X_ENTREGADO = 0;
                    $TOTAL_X_DEVOLUCION = 0;
                    $TOTAL_X_BASURA = 0;
                    $TOTAL_X_DIFERENCIAS = 0;
                    $TOTAL_X_DCM2 = 0;
                    $TOTAL_X_PORCENTAJE = 0;
                    $TOTAL_X_SISTEMA_PESOS = 0;
                    $TOTAL_X_REAL_PESOS = 0;
                    $TOTAL_X_DIFERENCIA_PESOS = 0;
                    $TOTAL_X_PIOCHAS_PESOS = 0;
                }
                $base = 85;
                $pdf->SetFillColor(244, 244, 244);
                $pdf->Rect(5.2, $pdf->GetY() + .2, 268.7, 3.5, 'F');
                $pdf->SetX(85);
                $pdf->Cell(25, $alto_celda, utf8_decode("Total por cortador"), 0/* BORDE */, 0/* SALTO */, 'L');
                $base += 25;
                $pdf->SetX($base);
                $pdf->Cell(10, $alto_celda, number_format($TOTAL_X_ESTILO_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 10;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_CONTROL_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_ENTREGADO_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DEVOLUCION_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_BASURA_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIAS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DCM2_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(7, $alto_celda, number_format($TOTAL_X_PORCENTAJE_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 7;
                $pdf->SetX($base);
                $pdf->Cell(12, $alto_celda, number_format($TOTAL_X_SISTEMA_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 12;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_REAL_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIA_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'R');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_PIOCHAS_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 1/* SALTO */, 'R');
                $TOTAL_X_ESTILO_CORTADOR = 0;
                $TOTAL_X_CONTROL_CORTADOR = 0;
                $TOTAL_X_ENTREGADO_CORTADOR = 0;
                $TOTAL_X_DEVOLUCION_CORTADOR = 0;
                $TOTAL_X_BASURA_CORTADOR = 0;
                $TOTAL_X_DIFERENCIAS_CORTADOR = 0;
                $TOTAL_X_DCM2_CORTADOR = 0;
                $TOTAL_X_PORCENTAJE_CORTADOR = 0;
                $TOTAL_X_SISTEMA_PESOS_CORTADOR = 0;
                $TOTAL_X_REAL_PESOS_CORTADOR = 0;
                $TOTAL_X_DIFERENCIA_PESOS_CORTADOR = 0;
                $TOTAL_X_PIOCHAS_PESOS_CORTADOR = 0;
                if (isset($CORTADORES[$k + 1])) {
                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(true, 6);

                    $anchos = array(35, 40, 8, 10, 10, 35, 40, 8, 10, 10);
                    $aligns = array('L', 'L', 'L', 'L', 'L');
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('Calibri', 'B', 10);

                    $base = 6;
                    $alto_celda = 4;
                    /* ANCHO DESPUÉS DE LOS MARGENES = 259, ES DE 215, PERO SON 10 DE MARGEN IZQ Y 10 DE MARGEN DER */
                    $bordes = 0;
                    $pdf->SetY(5);
                    $pdf->Image($_SESSION["LOGO"], /* LEFT */ 5, 5/* TOP */, /* ANCHO */ 30, 12.5);
                    $pdf->SetX(40);
                    $pdf->Cell(90, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 0/* SALTO */, 'L');
                    $pdf->SetX(130);
                    switch ($TIPO) {
                        case 1:
                            $pdf->Cell(139, $alto_celda, utf8_decode("< Piel >"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                            break;
                        case 2:
                            $pdf->Cell(139, $alto_celda, utf8_decode("< Forro >"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                            break;
                        default:
                            break;
                    }
                    $pdf->SetX(40);
                    $pdf->Cell(45, $alto_celda, utf8_decode("Consumo real de la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
                    $pdf->SetX(85);
                    $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_INICIAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(95);
                    $pdf->Cell(25, $alto_celda, utf8_decode("A la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
                    $pdf->SetX(120);
                    $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_FINAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(130);
                    $pdf->Cell(70, $alto_celda, utf8_decode("Fecha " . Date('d/m/Y h:i:s a')), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(200);
                    $pdf->Cell(69, $alto_celda, utf8_decode("Página " . $pdf->PageNo()), $bordes/* BORDE */, 1/* SALTO */, 'C');

                    $pdf->SetFont('Calibri', 'B', 8);
                    $pdf->SetY(18);
                    $pdf->SetX(110);
                    $pdf->Cell(25, $alto_celda, utf8_decode("Cons ord.prod"), 1/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(135);
                    $pdf->Cell(60, $alto_celda, utf8_decode("Consumo"), 1/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(195);
                    $pdf->Cell(22, $alto_celda, utf8_decode("Consumo real"), 1/* BORDE */, 0/* SALTO */, 'C');
                    $pdf->SetX(217);
                    $pdf->Cell(42, $alto_celda, utf8_decode("Pesos $"), 1/* BORDE */, 1/* SALTO */, 'C');
                    $bordes = 1;
                    $pdf->SetFont('Calibri', 'B', 8);
                    $pdf->SetY($pdf->GetY());
                    $base = 5;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Control"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(12, $alto_celda, utf8_decode("Estilo"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 12;
                    $pdf->SetX($base);
                    $pdf->Cell(8, $alto_celda, utf8_decode("Color"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 8;
                    $pdf->SetX($base);
                    $pdf->Cell(50, $alto_celda, utf8_decode("Articulo"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 50;
                    $pdf->SetX($base);
                    $pdf->Cell(10, $alto_celda, utf8_decode("Precio"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 10;
                    $pdf->SetX($base);
                    $pdf->Cell(10, $alto_celda, utf8_decode("Pares"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 10;
                    $pdf->SetX($base);
                    $pdf->Cell(10, $alto_celda, utf8_decode("X esti"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 10;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("X control"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Entregado"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Devolu"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Basura"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Dcm2"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(7, $alto_celda, utf8_decode("%"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 7;
                    $pdf->SetX($base);
                    $pdf->Cell(12, $alto_celda, utf8_decode("Sistema"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 12;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Real"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, utf8_decode("*PIOCHAS*"), $bordes/* BORDE */, 1/* SALTO */, 'C');
                }
            }
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ConsumosDePielYForro';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ConsumosDePielYForro/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ConsumoPielForro" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function getReportePielForroGeneral() {
        try {
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $TIPO = $this->input->post('TIPO');
            $MAQUILA = $this->input->post('MAQUILA');
            $SEMANA_INICIAL = $this->input->post('SEMANA_INICIAL');
            $SEMANA_FINAL = $this->input->post('SEMANA_FINAL');
            $ANIO = $this->input->post('ANIO');
            $CORTADOR = $this->input->post('CORTADOR');
            $ARTICULO = $this->input->post('ARTICULO');
            $FECHAINICIAL = $this->input->post('FECHA_INICIAL');
            $FECHAFINAL = $this->input->post('FECHA_FINAL');

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $anchos = array(35, 40, 8, 10, 10, 35, 40, 8, 10, 10);
            $aligns = array('L', 'L', 'L', 'L', 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Calibri', 'B', 10);
            $CORTADORES = $this->cpfxc->getCortadoresXMaquilaSemanaArticulo($ARTICULO, intval($MAQUILA), $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $CORTADOR, $TIPO);
            $base = 6;
            $alto_celda = 4;
            /* ANCHO DESPUÉS DE LOS MARGENES = 259, ES DE 215, PERO SON 10 DE MARGEN IZQ Y 10 DE MARGEN DER */
            $bordes = 0;
            $pdf->SetY(10);
            $pdf->Image($_SESSION["LOGO"], /* LEFT */ 10, 10/* TOP */, /* ANCHO */ 30, 12.5);
            $pdf->SetX(10);
            $pdf->Rect(10, 10, 259, 195);
            $pdf->SetX(40);
            $pdf->Cell(90, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(130);
            switch ($TIPO) {
                case 1:
                    $pdf->Cell(139, $alto_celda, utf8_decode("< Piel general>"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                    break;
                case 2:
                    $pdf->Cell(139, $alto_celda, utf8_decode("< Forro general>"), $bordes/* BORDE */, 1/* SALTO */, 'L');
                    break;
                default:
                    break;
            }
            $pdf->SetX(40);
            $pdf->Cell(45, $alto_celda, utf8_decode("Consumo real de la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(85);
            $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_INICIAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(95);
            $pdf->Cell(25, $alto_celda, utf8_decode("A la semana"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(120);
            $pdf->Cell(10, $alto_celda, utf8_decode($SEMANA_FINAL), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(130);
            $pdf->Cell(70, $alto_celda, utf8_decode("Fecha " . Date('d/m/Y')), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(200);
            $pdf->Cell(69, $alto_celda, utf8_decode("Página " . $pdf->PageNo()), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $pdf->SetX(40);
            $pdf->Cell(90, $alto_celda, utf8_decode("Cons ord.produ"), $bordes/* BORDE */, 0/* SALTO */, 'R');
            $pdf->SetX(130);
            $pdf->Cell(45, $alto_celda, utf8_decode("Consumo"), $bordes/* BORDE */, 0/* SALTO */, 'R');
            $pdf->SetX(175);
            $pdf->Cell(30, $alto_celda, utf8_decode("Consumo real"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(205);
            $pdf->Cell(64, $alto_celda, utf8_decode("Pesos"), $bordes/* BORDE */, 1/* SALTO */, 'C');
            $bordes = 1;
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetY($pdf->GetY() + .5);
            $base = 10;
            $pdf->SetX($base);
            $pdf->Cell(110, $alto_celda, utf8_decode("Cortador"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 110;
            $pdf->SetX($base);
            $pdf->Cell(10, $alto_celda, utf8_decode("Pares"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 10;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("X control"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Entregado"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Devolu"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Basura"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Dcm2"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(7, $alto_celda, utf8_decode("%"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 7;
            $pdf->SetX($base);
            $pdf->Cell(12, $alto_celda, utf8_decode("Sistema"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 12;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Real"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $base += 15;
            $pdf->SetX($base);
            $pdf->Cell(15, $alto_celda, utf8_decode("Difere"), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $TOTAL_X_ESTILO = 0;
            $TOTAL_X_CONTROL = 0;
            $TOTAL_X_ENTREGADO = 0;
            $TOTAL_X_DEVOLUCION = 0;
            $TOTAL_X_BASURA = 0;
            $TOTAL_X_DIFERENCIAS = 0;
            $TOTAL_X_DCM2 = 0;
            $TOTAL_X_PORCENTAJE = 0;
            $TOTAL_X_SISTEMA_PESOS = 0;
            $TOTAL_X_REAL_PESOS = 0;
            $TOTAL_X_DIFERENCIA_PESOS = 0;

            $TOTAL_PARES = 0;
            $TOTAL_PARES_X_ESTILO_CORTADOR = 0;
            $TOTAL_X_ESTILO_CORTADOR = 0;
            $TOTAL_X_CONTROL_CORTADOR = 0;
            $TOTAL_X_ENTREGADO_CORTADOR = 0;
            $TOTAL_X_DEVOLUCION_CORTADOR = 0;
            $TOTAL_X_BASURA_CORTADOR = 0;
            $TOTAL_X_DIFERENCIAS_CORTADOR = 0;
            $TOTAL_X_DCM2_CORTADOR = 0;
            $TOTAL_X_PORCENTAJE_CORTADOR = 0;
            $TOTAL_X_SISTEMA_PESOS_CORTADOR = 0;
            $TOTAL_X_REAL_PESOS_CORTADOR = 0;
            $TOTAL_X_DIFERENCIA_PESOS_CORTADOR = 0;
            $Y = 0;
            $alto_celda = 3.5;
            foreach ($CORTADORES as $k => $v) {
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
                $base = 10;
//                $pdf->SetFillColor(244, 244, 244);
//                $pdf->Rect(10.2, $pdf->GetY() + .2, 258.7, 3.5, 'F');
                $pdf->SetX($base);
                $pdf->Cell(110, $alto_celda, utf8_decode($v->NUMERO . " " . $v->CORTADOR), $bordes/* BORDE */, 0/* SALTO */, 'L');
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
//                $ESTILOS = $this->cpfxc->getEstilosPorCortador($ARTICULO, intval($MAQUILA),
//                        $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $v->NUMERO, $TIPO);

                $CORTADOR_CLAVE = $v->NUMERO;
                $this->db->select("A.Estilo AS Estilo_X_Cortador", false)
                        ->from("asignapftsacxc AS A")
                        ->join("empleados AS E", "A.Empleado = IFNULL(E.Numero,0)", 'left');
                if ($CORTADOR_CLAVE !== '') {
                    $this->db->where("A.Empleado = '$CORTADOR_CLAVE'", null, false);
                }
                if ($ARTICULO !== '') {
                    $this->db->where("A.Articulo = '$ARTICULO'", null, false);
                }
                if ($SEMANA_INICIAL !== '' && $SEMANA_FINAL !== '') {
                    $this->db->where("A.Semana BETWEEN '$SEMANA_INICIAL' AND '$SEMANA_FINAL'", null, false);
                }
                if ($MAQUILA !== '') {
                    $this->db->where("A.Maquila = '$MAQUILA'", null, false);
                }
                if ($ANIO !== '') {
                    $this->db->where("YEAR(str_to_date(A.Fecha, '%d/%m/%Y')) = '$ANIO'", null, false);
                }
                $this->db->where("A.TipoMov = '$TIPO'", null, false)->where('E.AltaBaja', 1)->group_by('A.Estilo');
                $ESTILOS = $this->db->get()->result();

                foreach ($ESTILOS as $kk => $vv) {
                    $RESUMEN = $this->cpfxc->getConsumosPielForroXMaquilaSemanaAnioCortadorArticuloFechaInicialFechaFinal($MAQUILA, $SEMANA_INICIAL, $SEMANA_FINAL, $ANIO, $CORTADOR, $ARTICULO, $FECHAINICIAL, $FECHAFINAL, $v->NUMERO, $vv->Estilo_X_Cortador, $TIPO);
                    $Y = $pdf->GetY();
                    $TOTAL_PARES = 0;
                    foreach ($RESUMEN as $kkk => $vvv) {
                        $TOTAL_PARES_X_ESTILO_CORTADOR += $vvv->Pares;

                        $TOTAL_X_ESTILO += $vvv->Consumo;
                        $TOTAL_X_ESTILO_CORTADOR += $vvv->Consumo;

                        $TOTAL_X_CONTROL += $vvv->Cantidad;
                        $TOTAL_X_CONTROL_CORTADOR += $vvv->Cantidad;

                        $TOTAL_X_ENTREGADO += $vvv->Abono;
                        $TOTAL_X_ENTREGADO_CORTADOR += $vvv->Abono;

                        $TOTAL_X_DEVOLUCION += $vvv->Devolucion;
                        $TOTAL_X_DEVOLUCION_CORTADOR += $vvv->Devolucion;

                        $TOTAL_X_BASURA += $vvv->Basura;
                        $TOTAL_X_BASURA_CORTADOR += $vvv->Basura;

                        $TOTAL_X_DIFERENCIAS += $vvv->Diferencia;
                        $TOTAL_X_DIFERENCIAS_CORTADOR += $vvv->Diferencia;

                        $TOTAL_X_DCM2 += $vvv->DCM2;
                        $TOTAL_X_DCM2_CORTADOR += $vvv->DCM2;

                        $TOTAL_X_PORCENTAJE += $vvv->PORCENTAJE;
                        $TOTAL_X_PORCENTAJE_CORTADOR += $vvv->PORCENTAJE;

                        $TOTAL_X_SISTEMA_PESOS += $vvv->SistemaPesos;
                        $TOTAL_X_SISTEMA_PESOS_CORTADOR += $vvv->SistemaPesos;

                        $TOTAL_X_REAL_PESOS += $vvv->RealPesos;
                        $TOTAL_X_REAL_PESOS_CORTADOR += $vvv->RealPesos;

                        $TOTAL_X_DIFERENCIA_PESOS += $vvv->Diferencia * $vvv->Precio;
                        $TOTAL_X_DIFERENCIA_PESOS_CORTADOR += $vvv->Diferencia * $vvv->Precio;
                        $pdf->Line(10, $pdf->GetY(), 269, $pdf->GetY());
                    }
                    $pdf->SetFont('Calibri', 'B', 8);
                    $base = 100;
                    $pdf->SetX(100);

                    $base += 20;
                    $pdf->SetX($base);
                    $pdf->Cell(10, $alto_celda, $TOTAL_PARES_X_ESTILO_CORTADOR, $bordes/* BORDE */, 0/* SALTO */, 'C');

                    $base += 10;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_CONTROL, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_ENTREGADO, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DEVOLUCION, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_BASURA, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIAS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DCM2, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(7, $alto_celda, number_format($TOTAL_X_PORCENTAJE, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 7;
                    $pdf->SetX($base);
                    $pdf->Cell(12, $alto_celda, number_format($TOTAL_X_SISTEMA_PESOS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 12;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_REAL_PESOS, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                    $base += 15;
                    $pdf->SetX($base);
                    $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIA_PESOS, 2, '.', ','), $bordes/* BORDE */, 1/* SALTO */, 'C');

                    $cols = array(120/* 1 */, 130/* 2 */, 145/* 3 */, 160/* 4 */, 175/* 5 */, 190/* 6 */, 190/* 7 */, 190/* 8 */, 190/* 9 */, 205/* 10 */, 220/* 11 */, 227/* 12 */, 239/* 13 */, 254/* 14 */);
                    for ($index = 0; $index < count($cols); $index++) {
                        $pdf->Line($cols[$index], $Y, $cols[$index], $pdf->GetY()); /* PRIMER COLUMNA */
                    }
                    $TOTAL_X_ESTILO = 0;
                    $TOTAL_X_CONTROL = 0;
                    $TOTAL_X_ENTREGADO = 0;
                    $TOTAL_X_DEVOLUCION = 0;
                    $TOTAL_X_BASURA = 0;
                    $TOTAL_X_DIFERENCIAS = 0;
                    $TOTAL_X_DCM2 = 0;
                    $TOTAL_X_PORCENTAJE = 0;
                    $TOTAL_X_SISTEMA_PESOS = 0;
                    $TOTAL_X_REAL_PESOS = 0;
                    $TOTAL_X_DIFERENCIA_PESOS = 0;
                    $pdf->Line(10, $pdf->GetY(), 269, $pdf->GetY());
                    $TOTAL_PARES += $TOTAL_PARES_X_ESTILO_CORTADOR;
                }
                $base = 100;
                $pdf->SetFillColor(244, 244, 244);
                $pdf->Rect(10.2, $pdf->GetY() + .2, 258.7, 3.5, 'F');
                $pdf->SetX(100);
                $pdf->Cell(15, $alto_celda, utf8_decode("Total general"), 0/* BORDE */, 0/* SALTO */, 'C');
                $base += 20;
                $pdf->SetX($base);
                $pdf->Cell(10, $alto_celda, number_format($TOTAL_PARES, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 10;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_CONTROL_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_ENTREGADO_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DEVOLUCION_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_BASURA_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIAS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DCM2_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(7, $alto_celda, number_format($TOTAL_X_PORCENTAJE_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 7;
                $pdf->SetX($base);
                $pdf->Cell(12, $alto_celda, number_format($TOTAL_X_SISTEMA_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 12;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_REAL_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 0/* SALTO */, 'C');
                $base += 15;
                $pdf->SetX($base);
                $pdf->Cell(15, $alto_celda, number_format($TOTAL_X_DIFERENCIA_PESOS_CORTADOR, 2, '.', ','), $bordes/* BORDE */, 1/* SALTO */, 'C');
                $TOTAL_X_ESTILO_CORTADOR = 0;
                $TOTAL_X_CONTROL_CORTADOR = 0;
                $TOTAL_X_ENTREGADO_CORTADOR = 0;
                $TOTAL_X_DEVOLUCION_CORTADOR = 0;
                $TOTAL_X_BASURA_CORTADOR = 0;
                $TOTAL_X_DIFERENCIAS_CORTADOR = 0;
                $TOTAL_X_DCM2_CORTADOR = 0;
                $TOTAL_X_PORCENTAJE_CORTADOR = 0;
                $TOTAL_X_SISTEMA_PESOS_CORTADOR = 0;
                $TOTAL_X_REAL_PESOS_CORTADOR = 0;
                $TOTAL_X_DIFERENCIA_PESOS_CORTADOR = 0;
                $TOTAL_PARES = 0;
            }
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ConsumosDePielYForro';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ConsumosDePielYForro/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ConsumoPielForro" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporteConsumoPielGeneral() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $pr["logo"] = base_url() . $this->session->LOGO;
            $pr["empresa"] = $this->session->EMPRESA_RAZON;
            $pr["MAQUILA"] = $x['MAQUILA'];
            $pr["SEMANAINICIO"] = $x['SEMANA_INICIAL'];
            $pr["SEMANAFIN"] = $x['SEMANA_FINAL'];
            $pr["ANO"] = $x['ANIO'];
            $jc->setParametros($pr);
            $jc->setJasperurl('jrxml\conspifo\PielGeneral.jasper');
            $jc->setFilename("CONSUMO_PIEL_GENERAL_" . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporteConsumoForroGeneral() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $pr["logo"] = base_url() . $this->session->LOGO;
            $pr["empresa"] = $this->session->EMPRESA_RAZON;
            $pr["MAQUILA"] = $x['MAQUILA'];
            $pr["SEMANAINICIO"] = $x['SEMANA_INICIAL'];
            $pr["SEMANAFIN"] = $x['SEMANA_FINAL'];
            $pr["ANO"] = $x['ANIO'];
            $jc->setParametros($pr);
            $jc->setJasperurl('jrxml\conspifo\ForroGeneral.jasper');
            $jc->setFilename("CONSUMO_FORRO_GENERAL_" . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
