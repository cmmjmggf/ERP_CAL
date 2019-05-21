<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FichaTecnica extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('Fichatecnica_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vFondo');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                        $this->load->view('vFichaTecnica');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales');
                        $this->load->view('vFichaTecnicaConsulta');
                    } else {
                        $this->load->view('vMenuPrincipal');
                        $this->load->view('vFichaTecnica');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    $this->load->view('vFichaTecnica');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    $this->load->view('vFichaTecnicaConsulta');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    if ($Seguridad === '1') {
                        $this->load->view('vFichaTecnica');
                    } else {
                        $this->load->view('vFichaTecnicaConsulta');
                    }
            }

            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $this->Fichatecnica_model->onLimpiarTabla();
            $this->Fichatecnica_model->onGenerarRecords();
            print json_encode($this->Fichatecnica_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosRequeridos() {
        try {
            print json_encode($this->Fichatecnica_model->getArticulosRequeridos($this->input->get('Grupo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            print json_encode($this->Fichatecnica_model->getGrupos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezas() {
        try {
            print json_encode($this->Fichatecnica_model->getPiezas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            print json_encode($this->Fichatecnica_model->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByClave() {
        try {
            print json_encode($this->Fichatecnica_model->getArticulosByClave($this->input->post('Articulo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarExisteEstiloColor() {
        try {
            print json_encode($this->Fichatecnica_model->onComprobarExisteEstiloColor($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->Fichatecnica_model->getEstilos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosByLinea() {
        try {
            print json_encode($this->Fichatecnica_model->getEstilosByLinea($this->input->get('Linea')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloByID() {
        try {
            print json_encode($this->Fichatecnica_model->getEstiloByID($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->Fichatecnica_model->getColoresXEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaDetalleByID() {
        try {
            print json_encode($this->Fichatecnica_model->getFichaTecnicaDetalleByID($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaByEstiloByColor() {
        try {
            print json_encode($this->Fichatecnica_model->getFichaTecnicaByEstiloByColor($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $PRECIO = $this->Fichatecnica_model->getPrecioPorArticuloByID($x->post('Articulo'));
            $data = array(
                'Estilo' => ($x->post('Estilo') !== NULL) ? $x->post('Estilo') : NULL,
                'Color' => ($x->post('Color') !== NULL) ? $x->post('Color') : NULL,
                'Pieza' => ($x->post('Pieza') !== NULL) ? $x->post('Pieza') : NULL,
                'Articulo' => ($x->post('Articulo') !== NULL) ? $x->post('Articulo') : NULL,
                'Consumo' => ($x->post('Consumo') !== NULL) ? $x->post('Consumo') : 0,
                'PzXPar' => ($x->post('PzXPar') !== NULL) ? $x->post('PzXPar') : NULL,
                'AfectaPV' => ($x->post('AfectaPV') !== NULL) ? $x->post('AfectaPV') : 0,
                'Estatus' => 'ACTIVO'
            );
            if (isset($PRECIO[0])) {
                $data["Precio"] = $PRECIO[0]->PRECIO;
            } else {
                $data["Precio"] = 0;
            }
            $ID = $this->Fichatecnica_model->onAgregar($data);
            print $ID;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarDetalle() {
        try {
            $x = $this->input;
            $data = array(
                'Pieza' => ($x->post('Pieza') !== NULL) ? $x->post('Pieza') : NULL,
                'Articulo' => ($x->post('Articulo') !== NULL) ? $x->post('Articulo') : NULL,
                'Consumo' => ($x->post('Consumo') !== NULL) ? $x->post('Consumo') : 0,
                'PzXPar' => ($x->post('PzXPar') !== NULL) ? $x->post('PzXPar') : NULL,
                'AfectaPV' => ($x->post('AfectaPV') !== NULL) ? $x->post('AfectaPV') : 0,
            );
            $this->Fichatecnica_model->onModificar($this->input->post('ID'), $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Fichatecnica_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRenglonDetalle() {
        try {
            $this->Fichatecnica_model->onEliminarRenglonDetalle($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarArticuloID() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('fichatecnica');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirFraccionesXEstilo() {
        $cm = $this->FraccionesXEstilo_model;

        $DatosEmpresa = $cm->getDatosEmpresa();
        $Encabezado = $cm->getEncabezadoFXE($this->input->get('Estilo'));
        $Departamentos = $cm->getDeptosFXE($this->input->get('Estilo'));
        $Fracciones = $cm->getFraccionesFXE($this->input->get('Estilo'));

        if (!empty($Encabezado)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));

            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Estilo = $Encabezado[0]->ESTILO;
            $pdf->Clinea = $Encabezado[0]->CLINEA;
            $pdf->Dlinea = $Encabezado[0]->DLINEA;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $GTotalD_CVTA = 0;
            $GTotalD_CMO = 0;
            foreach ($Departamentos as $key => $D) {
                $pdf->SetX(5);
                $pdf->SetFont('Arial', 'BI', 8.5);
                $pdf->Cell(10, 5, utf8_decode($D->CDEPTO) . ' ' . utf8_decode($D->DDEPTO), 0/* BORDE */, 1, 'L');

                $TotalD_CVTA = 0;
                $TotalD_CMO = 0;
                foreach ($Fracciones as $key => $F) {
                    if ($F->CDEPTO === $D->CDEPTO) {

                        $pdf->SetFont('Arial', '', 7.5);
                        $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
                        $aligns = array('L', 'L', 'L', 'L');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetMarginLeft(70);
                        $pdf->RowX(array(
                            utf8_decode($F->CFRACCION),
                            utf8_decode($F->DFRACCION),
                            utf8_decode($F->COSTOMO),
                            utf8_decode($F->COSTOVTA)
                        ));

                        $TotalD_CVTA += $F->COSTOVTA;
                        $TotalD_CMO += $F->COSTOMO;

                        $GTotalD_CVTA += $F->COSTOVTA;
                        $GTotalD_CMO += $F->COSTOMO;
                    }
                }
                $pdf->SetX(110);
                $pdf->SetFont('Arial', 'BI', 8.5);
                $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
                $aligns = array('L', 'C', 'L', 'L');
                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);
                $pdf->SetMarginLeft(70);
                $pdf->RowNoBorder(array(
                    "",
                    "Total x Depto",
                    $TotalD_CVTA,
                    $TotalD_CMO
                ));
            }
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'BI', 9.5);
            $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
            $aligns = array('L', 'C', 'L', 'L');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->SetMarginLeft(70);
            $pdf->RowNoBorder(array(
                "",
                "Total x Estilo",
                $GTotalD_CVTA,
                $GTotalD_CMO
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Nomina';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "FRACCIONES POR ESTILO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Nomina/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
