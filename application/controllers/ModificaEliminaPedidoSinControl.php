<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";
/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ModificaEliminaPedidoSinControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ModificaEliminaPedidoSinControl_model', 'meped')->helper('parespreprogramados_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break; 
                case 'FACTURACION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vModificaEliminaPedidoSinControl')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            $this->db->where('ID', $x->post('ID'))->update("pedidox", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->meped->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->meped->getEstilos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresByEstilo() {
        try {
            print json_encode($this->meped->getColoresByEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosByID() {
        try {
            print json_encode($this->meped->getPedidosByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoByClienteNumero() {
        try {
            $pedido = $this->input->get('Pedido');
            $cliente = $this->input->get('Cliente');
            print json_encode($this->db->query(" "
                                    . "select clave "
                                    . "from pedidox "
                                    . "where control is null or control = 0 "
                                    . "and cliente = $cliente "
                                    . "and clave = $pedido "
                                    . "order by ID asc  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidoDByID() {
        try {
            print json_encode($this->meped->getPedidoDByID($this->input->get('ID'), $this->input->get('CLIENTE')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            var_dump($this->input->post());
            $this->db->where('ID', $this->input->post('ID'))->delete('pedidox');
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reporte */

    public function getParesPreProgramados() {
        try {
            $xxx = $this->input;
            $MAQUILAS = $this->meped->getMaquila();

            $bordes = 0;
            $alto_celda = 4;
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
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
            $pdf->Rect(10, 10, 195.9, 12.5);
            $pdf->Image($_SESSION["LOGO"], /* LEFT */ 10, 10/* TOP */, /* ANCHO */ 30, 12.5);
            $pdf->SetX(10);
            //$pdf->Rect(10, 10, 259, 195); /* DELIMITADOR DE MARGENES */
            $pdf->SetX(40);
            $pdf->Cell(229, $alto_celda, utf8_decode($_SESSION["EMPRESA_RAZON"]), $bordes/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetX(40);
            $pdf->Cell(229, $alto_celda, utf8_decode("Reporte de pedidos en preprogramación por maquila"), $bordes/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetX(160);
            $pdf->Cell(20, $alto_celda, "Fecha ", $bordes/* BORDE */, 0/* SALTO */, 'R');
            $pdf->SetX(180);
            $pdf->Cell(20, $alto_celda, Date('d/m/Y'), $bordes/* BORDE */, 1/* SALTO */, 'C');

            $anchos = array(90.9/* 0 */, 30/* 1 */, 25/* 2 */, 25/* 3 */, 25/* 4 */, 20/* 5 */, 16/* 6 */, 15/* 7 */, 15/* 8 */);
            $spacex = 10;
            $bordes = 1;
            /* SUB ENCABEZADO */
            $pdf->SetY($pdf->GetY() + $alto_celda + .5);
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[0], $alto_celda, 'Maquila', $bordes/* BORDE */, 0/* SALTO */, 'L');
            $spacex += $anchos[0];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[1], $alto_celda, 'Capacidad', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[1];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[2], $alto_celda, 'Semana', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[2];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[3], $alto_celda, 'Pares', $bordes/* BORDE */, 0/* SALTO */, 'C');
            $spacex += $anchos[3];
            $pdf->SetX($spacex);
            $pdf->Cell($anchos[4], $alto_celda, 'Diferencia', $bordes/* BORDE */, 1/* SALTO */, 'C');
            /* FIN SUB ENCABEZADO */
            /* FIN ENCABEZADO FIJO */

            $pdf->SetFont('Calibri', 'B', 8);
            $Y = 0;
            $YY = 0;
            $bordes = 0;
            $PARES = 0;
            $TOTAL_PARES = 0;
            $alto_celda = 3.5;
            $pdf->SetDrawColor(226, 226, 226);
            $pdf->SetDrawColor(0, 0, 0);
            $spacex = 40;
            $YF = 0;
            foreach ($MAQUILAS as $k => $v) {
                $Y = $pdf->GetY();
                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->SetX(10);
                $pdf->setFilled(0);
                $pdf->setBorders(0);
                $pdf->SetAligns(array('L', 'C', 'C'));
                $pdf->SetWidths(array(90.9/* 0 */, 30/* 1 */, 30/* 2 */));
                $pdf->setAlto(4);
                $pdf->RowNoBorder(array(utf8_decode($v->MAQUILA)/* 0 */, utf8_decode($v->CAPACIDAD_PARES)/* 1 */));
                $pdf->Line(10, $pdf->GetY(), 130.9, $pdf->GetY());
                $PARES_PREPROGRAMADOS = $this->meped->getParesPreProgramadosPorMaquila($v->CLAVE_MAQUILA);
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->setAlto(3.5);
                foreach ($PARES_PREPROGRAMADOS as $kk => $vv) {
                    $pdf->SetFont('Calibri', 'B', 9);
                    $Y = $pdf->GetY();
                    $pdf->SetX(10);
                    $pdf->setFilled(0);
                    $pdf->setBorders(0);
                    $pdf->SetAligns(array('C', 'C'/* 0 */, 'C'/* 1 */, 'C'/* 2 */, 'C'/* 3 */, 'C'/* 4 */, 'C'/* 5 */, 'C'/* 6 */, 'C'/* 7 */, 'C'/* 8 */, 'C'/* 9 */));
                    $pdf->SetWidths(array(120.9, 25/* 0 */, 25/* 1 */, 25/* 2 */, 15/* 3 */, 15/* 4 */, 40/* 5 */, 20/* 6 */, 16/* 7 */, 15/* 8 */, 15/* 9 */));
                    $pdf->RowNoBorder(array('', utf8_decode($vv->SEMANA)/* 0 */,
                        utf8_decode($vv->PARES)/* 1 */,
                        utf8_decode($vv->DIFERENCIA)/* 2 */));
                    $pdf->Line(130.9, $pdf->GetY(), 205, $pdf->GetY());
                    $spacex = 40;
                    $PARES += $vv->PARES;
                    $TOTAL_PARES += $vv->PARES;
                }
                $bordes = 0;
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetX(129.9);
                $pdf->Cell(26, $alto_celda, "Total por maquila", $bordes/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetX(156);
                $pdf->Cell(25, $alto_celda, $PARES, $bordes/* BORDE */, 1/* SALTO */, 'C');
                $PARES = 0;
            }
            $bordes = 0;
            $pdf->SetFont('Calibri', 'B', 9);
            $pdf->SetX(111);
            $pdf->Cell(45, $alto_celda, utf8_decode("Total pares en preprogramación"), $bordes/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetX(156);
            $pdf->Cell(25, $alto_celda, $TOTAL_PARES, $bordes/* BORDE */, 0/* SALTO */, 'C');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/ParesPreProgramados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/ParesPreProgramados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $file_name = "ParesPreProgramadosMaquilas" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
