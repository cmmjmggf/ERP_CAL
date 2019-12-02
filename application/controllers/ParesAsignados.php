<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ParesAsignados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ParesAsignados_model', 'pam')
                ->helper('paresasignados_helper')
                ->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vNavGeneral');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuProduccion');
                    }
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vParesAsignados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getParesPreAsignados() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $x = $this->input;
        $parametros["MAQUILAINICIO"] = intval($x->post('MAQUILA_INICIAL'));
        $parametros["MAQUILAFIN"] = intval($x->post('MAQUILA_FINAL'));
        $parametros["SEMANAINICIO"] = intval($x->post('SEMANA_INICIAL'));
        $parametros["SEMANAFIN"] = intval($x->post('SEMANA_FINAL'));
        $parametros["ANO"] = intval($x->post('ANIO'));
        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/asignados/';
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\asignados\ParesPreAsignadosXLinea.jasper');
        $jc->setFilename('ParesPreAsignadosXLinea_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        print $jc->getReport();
    }

    public function getParesAsignados() {
        try {
            $x = $this->input;
            $PARES_ASIGNADOS = ($this->pam->getParesAsignados(
                            $x->post('MAQUILA_INICIAL'), $x->post('MAQUILA_FINAL'), $x->post('SEMANA_INICIAL'), $x->post('SEMANA_FINAL'), $x->post('ANIO'), $x->post('TIPO')));

            $MAQUILAS = array();
            foreach ($PARES_ASIGNADOS as $k => $v) {
                if (!in_array($v->MAQUILA, $MAQUILAS)) {
                    array_push($MAQUILAS, $v->MAQUILA);
                }
            }
            sort($MAQUILAS);
            $bordes = 0;
            $alto_celda = 4;
            $TIPO = $x->post('TIPO');
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);
            /* ENCABEZADO FIJO */
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Calibri', 'B', 10);
            $pdf->SetY(10);
            $pdf->Image($_SESSION["LOGO"], /* LEFT */ 10, 10/* TOP */, /* ANCHO */ 30, 12.5);
            $pdf->SetX(10);
//            $pdf->Rect(10, 10, 259, 195);
            $pdf->SetX(40);
            $pdf->Cell(229, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetX(40);
            $pdf->Cell(40, $alto_celda, utf8_decode("Pares asignados a maquila"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(80);
            $pdf->Cell(5, $alto_celda, $x->post('MAQUILA_INICIAL') !== '' ? $x->post('MAQUILA_INICIAL') : '', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(85);
            $pdf->Cell(20, $alto_celda, "A la maquila ", $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(105);
            $pdf->Cell(5, $alto_celda, $x->post('MAQUILA_FINAL') !== '' ? $x->post('MAQUILA_FINAL') : '', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(110);
            $pdf->Cell(20, $alto_celda, utf8_decode("De la sem"), $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(130);
            $pdf->Cell(5, $alto_celda, $x->post('SEMANA_INICIAL') !== '' ? $x->post('SEMANA_INICIAL') : '', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(135);
            $pdf->Cell(20, $alto_celda, "A la sem ", $bordes/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(155);
            $pdf->Cell(5, $alto_celda, $x->post('SEMANA_FINAL') !== '' ? $x->post('SEMANA_FINAL') : '', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(160);
            $pdf->Cell(20, $alto_celda, "Fecha ", $bordes/* BORDE */, 0/* SALTO */, 'R');
            $pdf->SetX(180);
            $pdf->Cell(20, $alto_celda, Date('d/m/y'), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $anchos = array(15/* 0 */, 20/* 1 */, 30/* 2 */, 30/* 3 */, 37/* 4 */, 20/* 5 */);
            $spacex = 10;
            $bordes = 1;
            /* SUB ENCABEZADO */
            $pdf->SetY($pdf->GetY() + $alto_celda + .5);
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1], $alto_celda, 'Pedido', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[1];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[0], $alto_celda, 'Estilo', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[0];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[5], $alto_celda, 'Color', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[5];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[2] + 2, $alto_celda, '-', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[2] + 2;
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[0], $alto_celda, 'Cliente', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[0];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[4], $alto_celda, '-', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[4];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1] - 4, $alto_celda, 'Fecha-ent', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[1] - 4;
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[0] - 5, $alto_celda, 'Sem', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[0] - 5;
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1] - 9, $alto_celda, 'Pares', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[1] - 9;
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1] + $anchos[1] + 2 * 7.705, $alto_celda, 'Obs.Ped', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[1] + $anchos[1] + 2 * 7.705;
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1] + 7.705, $alto_celda, 'Obs.Cte', $bordes/* BORDE */, 1/* SALTO */, 'C');
            /* FIN SUB ENCABEZADO */
            /* FIN ENCABEZADO FIJO */

            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3;
            $pdf->SetDrawColor(226, 226, 226);
            $spacex = 10;
            $YF = 0;
            $pdf->SetWidths(array(20, 15));
            $pdf->setFilled(1);
            $pdf->setBorders(0);
            foreach ($MAQUILAS as $k => $v) {
                $pdf->setFilled(1);
                $pdf->SetWidths(array(20, 15));
                $pdf->SetAligns(array('L', 'C'));
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(10);
                $pdf->Row(array('Maquila ', intval($v)));
                $pdf->Line(10, $pdf->GetY(), 269, $pdf->GetY());
                $pdf->SetFont('Calibri', 'B', 7);
                $YF = $pdf->GetY();
                foreach ($PARES_ASIGNADOS as $kk => $vv) {
                    if ($v === $vv->MAQUILA) {
                        $pdf->setFilled(0);
                        $pdf->setBorders(0);
                        $pdf->SetAligns(array('C', 'C', 'C', 'L', 'C', 'L', 'C', 'C', 'C', 'L', 'L', 'L'));
                        $pdf->SetWidths(array(15/* 0 */, 20/* 1 */, 20/* 2 */, 32/* 3 */, 15/* 4 */, 37/* 5 */, 16/* 6 */, 10/* 7 */, 11/* 8 */, 27.7/* 9 */, 27.7/* 10 */, 27.7/* 11 */));
                        $pdf->SetX($spacex);
                        $pdf->Row(array($vv->CLAVE_PEDIDO/* 0 */,
                            $vv->ESTILO/* 1 */,
                            $vv->CLAVE_COLOR/* 2 */,
                            utf8_decode($vv->COLOR)/* 3 */,
                            utf8_decode($vv->CLAVE_CLIENTE)/* 4 */,
                            utf8_decode($vv->CLIENTE)/* 5 */,
                            utf8_decode($vv->FECHA_ENTREGA)/* 6 */,
                            utf8_decode($vv->SEMANA)/* 7 */,
                            utf8_decode($vv->PARES)/* 8 */,
                            utf8_decode(strlen($vv->OBSERVACION_UNO) > 1 ? utf8_decode($vv->OBSERVACION_UNO) : '')/* 9 */,
                            utf8_decode(strlen($vv->OBSERVACION_DOS) > 1 ? utf8_decode($vv->OBSERVACION_DOS) : '')/* 10 */,
                            utf8_decode(strlen($vv->OBSERVACIONES_CLIENTE) > 1 ? utf8_decode($vv->OBSERVACIONES_CLIENTE) : '')/* 11 */));
                        $PARES += $vv->PARES;
                        $TOTAL_PARES += $vv->PARES;
                        $spacex = 10;
                    }
                }
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->setFillColor(225, 225, 234);
                $pdf->SetX(135);
                $pdf->Cell(30, $alto_celda, "Pares por maquila", 1/* BORDE */, 0/* SALTO */, 'C', 1);
                $pdf->SetX(165);
                $pdf->Cell(21, $alto_celda, $PARES, 1/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->setFillColor(225, 225, 234);
            $pdf->SetX(135);
            $pdf->Cell(30, $alto_celda, "Total pares", 1/* BORDE */, 0/* SALTO */, 'C', 1);
            $pdf->SetX(165);
            $pdf->Cell(21, $alto_celda, $TOTAL_PARES, 1/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesAsignados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesAsignados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesAsignados" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas() {
        try {
            print json_encode($this->pam->onComprobarMaquilas($this->input->get('MAQUILA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->pam->onChecarSemanaValida($this->input->get('SEMANA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
