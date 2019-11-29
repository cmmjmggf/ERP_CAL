<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class InicialMaterialPrima extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('InicialMateriaPrima_model')
                ->helper('InvIni_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vInicialMateriaPrima');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onVerificarArticulo() {
        try {
            $Articulo = $this->input->get('Articulo');
            print json_encode($this->db->query("select clave from articulos where clave = '$Articulo ' and estatus = 'ACTIVO'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $datos = array(
                'Pinvini' => $x->post('Pinvini'),
                'Invini' => $x->post('Invini')
            );
            $this->InicialMateriaPrima_model->onModificar($x->post('Articulo'), $datos);
            $this->InicialMateriaPrima_model->onModificarArt_Fabrica($x->post('Articulo'), $datos);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCerrarInv() {
        try {
            $x = $this->input;
            $PMes = 'P' . $x->post('Mes');
            $this->InicialMateriaPrima_model->onCerrarInv($x->post('Mes'), $PMes);
            $this->InicialMateriaPrima_model->onCerrarInv_Fabrica($x->post('Mes'), $PMes);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosByMaterial() {
        try {
            print json_encode($this->InicialMateriaPrima_model->getDatosByMaterial($this->input->get('Material')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMateriales() {
        try {
            print json_encode($this->InicialMateriaPrima_model->getMateriales());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirInvIni() {
        $cm = $this->InicialMateriaPrima_model;

        $Grupos = $cm->getGrupos();
        $Articulos = $cm->getArticulos();


        if (!empty($Grupos)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);


            $COL = 1;
            $TOTAL_C_FIN = 0;
            $TOTAL_FIN = 0;

            foreach ($Grupos as $key => $D) {
                if ($COL === 2) {
                    $pdf->Cell(180, 3, '', 0/* BORDE */, 1, 'L');
                }
                $pdf->SetX(5);
                $pdf->SetFont('Calibri', 'B', 8.5);
                $pdf->Cell(15, 3, 'Grupo', 'B'/* BORDE */, 0, 'L');
                $pdf->SetX(20);
                $pdf->SetFont('Calibri', '', 8.5);
                $pdf->Cell(40, 3, utf8_decode($D->Clave) . ' ' . utf8_decode($D->Nombre), 'B'/* BORDE */, 1, 'L');
                $COL = 1;
                $TOTAL_C_GPO = 0;
                $TOTAL_GPO = 0;
                foreach ($Articulos as $key => $F) {

                    if ($F->Grupo === $D->Clave) {
                        $pdf->SetFont('Calibri', '', 8);
                        switch ($COL) {
                            case 1:
                                $COL = 2;
                                $pdf->SetX(5);
                                $pdf->Cell(8, 3, $F->Clave, 0/* BORDE */, 0, 'R');
                                $pdf->SetX(13);
                                $pdf->Cell(43, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 28, ""), 0/* BORDE */, 0, 'L');
                                $pdf->SetX(56);
                                $pdf->Cell(10, 3, utf8_decode($F->Unidad), 0/* BORDE */, 0, 'L');
                                $pdf->SetX(66);
                                $pdf->Cell(13, 3, '$' . number_format($F->Precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                                $pdf->SetX(79);
                                $pdf->Cell(11, 3, number_format($F->Cantidad, 0, ".", ","), 0/* BORDE */, 0, 'R');
                                $pdf->SetX(90);
                                $pdf->SetLineWidth(0.7);
                                $pdf->Cell(17, 3, '$' . number_format($F->Total, 2, ".", ","), 'R'/* BORDE */, 0, 'R');
                                $pdf->SetLineWidth(0.2);

                                break;
                            case 2:
                                $COL = 1;
                                $pdf->SetX(108.5);
                                $pdf->Cell(8, 3, $F->Clave, 0/* BORDE */, 0, 'R');
                                $pdf->SetX(116.5);
                                $pdf->Cell(43, 3, mb_strimwidth(utf8_decode($F->Descripcion), 0, 28, ""), 0/* BORDE */, 0, 'L');
                                $pdf->SetX(159.5);
                                $pdf->Cell(10, 3, utf8_decode($F->Unidad), 0/* BORDE */, 0, 'L');
                                $pdf->SetX(169.5);
                                $pdf->Cell(13, 3, '$' . number_format($F->Precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                                $pdf->SetX(182.5);
                                $pdf->Cell(11, 3, number_format($F->Cantidad, 0, ".", ","), 0/* BORDE */, 0, 'R');
                                $pdf->SetX(193.5);
                                $pdf->SetLineWidth(0.7);
                                $pdf->Cell(17, 3, '$' . number_format($F->Total, 2, ".", ","), 0/* BORDE */, 1, 'R');
                                $pdf->SetLineWidth(0.2);
                                break;
                        }
                        $TOTAL_C_FIN += $F->Cantidad;
                        $TOTAL_FIN += $F->Total;
                        $TOTAL_C_GPO += $F->Cantidad;
                        $TOTAL_GPO += $F->Total;
                    }
                }
                if ($COL === 2) {
                    $pdf->Cell(180, 3, '', 0/* BORDE */, 1, 'L');
                }
                $pdf->SetX(50);
                $pdf->SetFont('Calibri', 'B', 8);
                $pdf->Cell(29, 3, 'Total por grupo', 'T'/* BORDE */, 0, 'L');
                $pdf->SetX(79);
                $pdf->SetFont('Calibri', '', 8);
                $pdf->Cell(11, 3, number_format($TOTAL_C_GPO, 0, ".", ","), 'T'/* BORDE */, 0, 'R');
                $pdf->SetX(90);
                $pdf->Cell(17, 3, '$' . number_format($TOTAL_GPO, 0, ".", ","), 'T'/* BORDE */, 0, 'R');
                $pdf->SetLineWidth(0.7);
                $pdf->SetX(107);
                $pdf->Cell(5, 3, '', 'L'/* BORDE */, 0, 'L');
                $pdf->SetLineWidth(0.2);
                if ($COL === 1) {
                    $pdf->Cell(180, 3, '', 0/* BORDE */, 1, 'L');
                }
            }

            if ($COL === 2) {
                $pdf->Cell(180, 3, '', 0/* BORDE */, 1, 'L');
            }
            $pdf->SetX(50);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(29, 3, 'Total inventario', 'T'/* BORDE */, 0, 'L');
            $pdf->SetX(79);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(11, 3, number_format($TOTAL_C_FIN, 0, ".", ","), 'T'/* BORDE */, 0, 'R');
            $pdf->SetX(90);
            $pdf->Cell(17, 3, '$' . number_format($TOTAL_FIN, 0, ".", ","), 'T'/* BORDE */, 0, 'R');
            if ($COL === 1) {
                $pdf->Cell(180, 3, '', 0/* BORDE */, 1, 'L');
            }

            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Inventario';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "INVENTARIO INICIAL FISCAL " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Inventario/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
