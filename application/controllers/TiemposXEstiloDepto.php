<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class TiemposXEstiloDepto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('TiemposXEstiloDepto_model', 'txed')->helper('tiemposxestilos_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vTiemposXEstiloDepto')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDepartamentosXEstilo() {
        try {
            print json_encode($this->txed->getDepartamentosXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarTiempoXEstiloDeptos() {
        try {
            print json_encode($this->txed->onComprobarTiempoXEstiloDeptos($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaXEstilo() {
        try {
            print json_encode($this->txed->getLineaXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarEstilo() {
        try {
            print json_encode($this->txed->onComprobarEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTiemposXEstiloDepto() {
        try {
            print json_encode($this->txed->getTiemposXEstiloDepto($this->input->get('ESTILO'),$this->input->get('LINEA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarTiempos() {
        try {
            $x = $this->input;
            $TIEMPOS = json_decode($x->post('TIEMPOS'));
            switch ($x->post('N')) {
                case 0:
                    $this->db->trans_start();
                    $this->db->insert('tiemposxestilodepto', array('Linea' => $x->post('LINEA'), 'Estilo' => $x->post('ESTILO')));
                    $row = $this->db->query('SELECT LAST_INSERT_ID()')->row_array();
                    $ID = $row['LAST_INSERT_ID()'];
                    $this->db->trans_complete();
                    $TOTAL = 0;
                    foreach ($TIEMPOS as $k => $v) {
                        $this->db->insert('tiemposxestilodepto_has_deptos', array('TiempoXEstiloDepto' => $ID, 'Departamento' => $v->DEPTO, 'Tiempo' => $v->DEPTOTIME, 'Fecha' => Date('d/m/Y h:i:s a')));
                        $TOTAL += $v->DEPTOTIME;
                    }
                    $this->db->set('Total', $TOTAL)->where('ID', $ID)->update('tiemposxestilodepto');

                    /* AGREGAR EN TABLA DE PASO */
                    $this->db->insert('estilostiempox', array('linea' => $x->post('LINEA'), 'estilo' => $x->post('ESTILO')));
                    $rowX = $this->db->query('SELECT LAST_INSERT_ID()')->row_array();
                    $IDX = $rowX['LAST_INSERT_ID()'];

                    foreach ($TIEMPOS as $k => $v) {
                        switch (intval($v->DEPTO)) {
                            case 10:
                                /* CORTE */
                                $this->db->set('cortep', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                $this->db->set('cortef', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 20:
                                /* RAYADO */
                                $this->db->set('rayado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 30:
                                /* REBAJADO Y PERFORADO */
                                $this->db->set('rebaja', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 40:
                                /* FOLEADO */
                                $this->db->set('folead', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 90:
                                /* ENTRETELADO */
                                $this->db->set('entrete', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 110:
                                /* PESPUNTE */
                                $this->db->set('pespu', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 140:
                                /* ENSUELADO */
                                $this->db->set('ensuel', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 120:
                                /* PRELIMINAR - PESPUNTE */
                                $this->db->set('prepes', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 60:
                                /* LASER (ES LASER PERO FILI NO LO CAMBIO DE TEJIDO A LASER, SOLO LO CAMBIO EN EL REPORTE EL TITULO) */
                                $this->db->set('tejido', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 180:
                                /* MONTADO A */
                                $this->db->set('montado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 190:
                                /* MONTADO B */
                                $this->db->set('montado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 210:
                                /* ADORNO A */
                                $this->db->set('adorno', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                            case 220:
                                /* ADORNO B */
                                $this->db->set('adorno', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                break;
                        }
                    }
                    break;
                case 1:
                    $TOTAL = 0;
                    foreach ($TIEMPOS as $k => $v) {
                        $EX = $this->txed->onComprobarDeptoXEstilo($x->post('ESTILO'), $v->DEPTO)[0]->EXISTE;
                        if (intval($EX) > 0) {
                            $this->db->set('Tiempo', $v->DEPTOTIME)
                                    ->where('TiempoXEstiloDepto', $x->post('ID'))
                                    ->where('Departamento', $v->DEPTO)
                                    ->update('tiemposxestilodepto_has_deptos');
                            $TOTAL += $v->DEPTOTIME;
                        } else {
                            $this->db->insert('tiemposxestilodepto_has_deptos', array('TiempoXEstiloDepto' => $x->post('ID'), 'Departamento' => $v->DEPTO, 'Tiempo' => $v->DEPTOTIME));
                            $TOTAL += $v->DEPTOTIME;
                        }
                    }
                    $this->db->set('Total', $TOTAL)->where('ID', $x->post('ID'))->update('tiemposxestilodepto');

                    $IDR = $this->db->select('E.ID AS IDEX')->from('estilostiempox AS E')->where('E.linea', $x->post('LINEA'))->where('E.estilo', $x->post('ESTILO'))->get()->result();
                    if (isset($IDR[0]->IDEX)) {
                        $IDX = $IDR[0]->IDEX;
                        foreach ($TIEMPOS as $k => $v) {
                            switch (intval($v->DEPTO)) {
                                case 10:
                                    /* CORTE */
                                    $this->db->set('cortep', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    $this->db->set('cortef', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 20:
                                    /* RAYADO */
                                    $this->db->set('rayado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 30:
                                    /* REBAJADO Y PERFORADO */
                                    $this->db->set('rebaja', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 40:
                                    /* FOLEADO */
                                    $this->db->set('folead', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 90:
                                    /* ENTRETELADO */
                                    $this->db->set('entrete', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 110:
                                    /* PESPUNTE */
                                    $this->db->set('pespu', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 140:
                                    /* ENSUELADO */
                                    $this->db->set('ensuel', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 120:
                                    /* PRELIMINAR - PESPUNTE */
                                    $this->db->set('prepes', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 60:
                                    /* LASER (ES LASER PERO FILI NO LO CAMBIO DE TEJIDO A LASER, SOLO LO CAMBIO EN EL REPORTE EL TITULO) */
                                    $this->db->set('tejido', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 180:
                                    /* MONTADO A */
                                    $this->db->set('montado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 190:
                                    /* MONTADO B */
                                    $this->db->set('montado', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 210:
                                    /* ADORNO A */
                                    $this->db->set('adorno', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                                case 220:
                                    /* ADORNO B */
                                    $this->db->set('adorno', $v->DEPTOTIME)->where('ID', $IDX)->update('estilostiempox');
                                    break;
                            }
                        }
                    }
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDeptosXEstilo() {
        try {
            $this->db->where('ID', $this->input->post('ID'))
                    ->delete('tiemposxestilodepto');
            $this->db->where('TiempoXEstiloDepto', $this->input->post('ID'))
                    ->delete('tiemposxestilodepto_has_deptos');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDeptoXEstilo() {
        try {
            $this->db->where('TiempoXEstiloDepto', $this->input->post('ID'))
                    ->where('ID', $this->input->post('IDD'))
                    ->delete('tiemposxestilodepto_has_deptos');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onObtenerTiemposXEstilo() {
        try {
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $ESTILO = $this->input->post('ESTILO');
            $LINEA = "";
            $pdf->AddFont('Calibri', '');
            $pdf->AddFont('Calibri', 'I');
            $pdf->AddFont('Calibri', 'B');
            $pdf->AddFont('Calibri', 'BI');
            $TIEMPOS = $this->txed->getTiemposXEstilo($ESTILO);
            if (count($TIEMPOS) > 0) {
                $pdf->setEstilo($ESTILO . " - " . $TIEMPOS[0]->ESTILO);
                $LINEA = $TIEMPOS[0]->LINEA;
                $pdf->setLinea($LINEA);
                $pdf->AddPage();
                $pdf->SetAutoPageBreak(true, 10);
                $pdf->SetFont('Calibri', 'B', 7.5);
                $pdf->setY(25);
                $pdf->setFilled(1);
                $pdf->SetFillColor(244, 244, 244);
                $pdf->SetAligns(array('C'/* 0 */, 'C'/* 1 */, 'C'/* 2 */));
                $pdf->SetWidths(array(70/* 0 */, 20/* 1 */, 20/* 2 */));
                $pdf->SetX(10);
                $pdf->Row(array("DEPARTAMENTO", "TIEMPO"));
                $TOTAL = 0;
                $pdf->SetFont('Calibri', '', 7.5);
                $pdf->setFilled(0);
                $pdf->setY(30);
                $pdf->SetX(10);
                foreach ($TIEMPOS as $k => $v) {
                    $TOTAL += $v->TIEMPO;
                    $pdf->SetAligns(array('L'/* 0 */, 'C'/* 1 */, 'C'/* 2 */));
                    $pdf->SetWidths(array(70/* 0 */, 20/* 1 */, 20/* 2 */));
                    $r = array(
                        utf8_decode($v->CLAVE_DEPTO . " - " . $v->DEPTO)/* 0 */,
                        ($v->TIEMPO)/* 1 */
                    );
                    $pdf->SetX(10);
                    $pdf->Row($r);
                }
                $pdf->SetFont('Calibri', 'B', 7.5);
                $pdf->SetX(30);
                $pdf->Cell(50, 5, utf8_decode("TOTAL DEL ESTILO $ESTILO, LINEA $LINEA "), 1/* BORDE */, 0, 'L', 1);
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 5, $TOTAL, 1/* BORDE */, 1, 'C', 0);

                /* FIN RESUMEN */
                $path = 'uploads/Reportes/TiemposXEstilo';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                if (delete_files('uploads/Reportes/TiemposXEstilo/')) {
                    /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
                }
                $file_name = "TiemposXEstilo_$ESTILO- " . date("d_m_Y_his");
                $url = $path . '/' . $file_name . '.pdf';
                /* Borramos el archivo anterior */

                $pdf->Output($url);
                print base_url() . $url;
            } else {
                return '';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
