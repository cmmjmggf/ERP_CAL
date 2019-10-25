<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AsignaDiaSemACtrlParaCorte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AsignaDiaSemACtrlParaCorte_model', 'adscpc')
                ->helper('jaspercommand_helper');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vEncabezado')->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vEncabezado')->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    $is_valid = true;
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vAsignaDiaSemACtrlParaCorte')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
//            print json_encode($this->adscpc->getRecords());
            $x = $this->input->get();
            $this->db->select("P.ID, CONCAT('<span class=\"font-weight-bold\">',P.Control,'</span>') AS Control, P.Cliente, "
                            . "P.Estilo, P.Color, P.Pares, "
                            . "P.Semana AS Semana", false)
                    ->from("pedidox AS P")->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('tiemposxestilodepto AS TXE', 'P.Estilo = TXE.Estilo')
                    ->join('programacion AS PR', 'P.Control = PR.Control', 'left')
                    ->where('PR.Control IS NULL', null, false)
                    ->where_not_in('P.Control', array(0));
            if ($x['ANIO'] !== '') {
                $this->db->where('P.Ano', $x['ANIO']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('P.Semana', $x['SEMANA']);
            }
            if ($x['CORTADOR'] !== '') {
                $this->db->where('PR.numemp', $x['CORTADOR']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('P.Semana', $x['CONTROL']);
            }
            $this->db->order_by("YEAR(PR.fecha)", "DESC")->order_by("MONTH(PR.fecha)", "DESC")->order_by("DAY(PR.fecha)", "DESC");
            if ($x['ANIO'] === '' && $x['SEMANA'] === '' && $x['CORTADOR'] === '' && $x['CONTROL'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCortadores() {
        try {
            print json_encode($this->adscpc->getCortadores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->adscpc->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProgramacion() {
        try {
//            print json_encode($this->adscpc->getProgramacion());
            $x = $this->input->get();

            $styl = 'style=\"font-size: 100%;\"';
            $sp = "<span class=\"badge badge-pill badge-info\" {$styl}>";
            $spbf = "<span class=\"badge badge-pill badge-fusion\" {$styl}>";
            $sps = "<span class=\"badge badge-pill badge-fusion-success\" {$styl}>";
            $spda = "<span class=\"badge badge-pill badge-danger\" {$styl}>";
            $spd = "<span class=\"badge badge-pill badge-dark\" {$styl}>";
            $spw = "<span class=\"badge badge-pill badge-warning\" {$styl}>";
            $spf = '</span>';
            $this->db->select("PR.ID, CONCAT('{$sps}',PR.numemp,'{$spf}') AS Emp, CONCAT('{$spw}',PR.control,'{$spf}') AS Control, "
                            . "PR.año AS Ano, CONCAT('{$spda}',PR.semana,'{$spf}') AS Sem, ELT(PR.diaprg,"
                            . "'{$sp}JUEVES{$spf}','{$sp}VIERNES{$spf}','{$sp}SABADO{$spf}',"
                            . "'{$sp}LUNES{$spf}','{$sp}MARTES{$spf}','{$sp}MIERCOLES{$spf}',"
                            . "'{$sp}DOMINGO{$spf}') AS Dia, "
                            . " CONCAT('{$spbf}',PR.frac,'{$spf}') AS Frac, DATE_FORMAT(PR.fecha, \"%d/%m/%Y\") AS Fecha, PR.estilo AS Estilo, "
                            . "PR.par AS Pares, PR.tiempo AS Tiempo, PR.precio AS Precio, "
                            . "PR.nomart", false)
                    ->from("programacion AS PR")->where_in("PR.frac", array(99, 100));
            if ($x['ANIO'] !== '') {
                $this->db->where('PR.año', $x['ANIO']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('PR.semana', $x['SEMANA']);
            }
            if ($x['CORTADOR'] !== '') {
                $this->db->where('PR.numemp', $x['CORTADOR']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('PR.control', $x['CONTROL']);
            }
            $this->db->order_by("YEAR(PR.fecha)", "DESC")->order_by("MONTH(PR.fecha)", "DESC")
                    ->order_by("DAY(PR.fecha)", "DESC");
            if ($x['ANIO'] === '' && $x['SEMANA'] === '' && $x['CORTADOR'] === '' && $x['CONTROL'] === '') {
                $this->db->limit(25);
            }


            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->adscpc->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesAsignados() {
        try {
            print json_encode($this->adscpc->getControlesAsignados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            print json_encode($this->adscpc->getRegresos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->adscpc->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl() {
        try {
            print json_encode($this->adscpc->getParesXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            print json_encode($this->adscpc->getPieles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            print json_encode($this->adscpc->getForros(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            print json_encode($this->adscpc->getTextiles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            print json_encode($this->adscpc->getSinteticos(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo() {
        try {
            print json_encode($this->adscpc->getExplosionXSemanaControlFraccionArticulo($this->input->get('SEMANA'), $this->input->get('CONTROL'), $this->input->get('FRACCION'), $this->input->get('ARTICULO'), $this->input->get('GRUPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColorParesTxParPorControl() {
        try {
            $x = $this->input;
            print json_encode($this->adscpc->getEstiloColorParesTxParPorControl($x->get('CONTROL'), $x->get('TIPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarAsignacionDeDiaXControl() {
        try {
            $x = $this->input;
            $data = array(
                'CORTADOR' => $x->post('CORTADOR'),
                'control' => $x->post('CONTROL'),
                'año' => $x->post('ANIO'),
                'semana' => $x->post('SEMANA'),
                'diaprg' => $x->post('DIA'),
                'frac' => $x->post('FRACCION'),
                'fecha' => Date('d/m/Y h:i:s a'),
                'estilo' => $x->post('ESTILO'),
                'par' => $x->post('PARES'),
                'tiempo' => $x->post('TIEMPO'),
                'precio' => $x->post('PRECIO'),
                'nomart' => $x->post('ARTICULO')
            );
            $this->db->insert('programacion', $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAsignacion() {
        try {
            $this->db->delete('programacion', array('ID' => $this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAnadirAsignacion() {
        try {
            $x = $this->input;
            $data = ($this->adscpc->getEstiloColorParesTxParPorControl($x->post('CONTROL'), $x->post('FRACCION')));
            if (isset($data[0])) {
                $r = $data[0];
                $dtm = array(
                    'numemp' => $x->post('CORTADOR'),
                    'control' => $x->post('CONTROL'),
                    'año' => $x->post('ANIO'),
                    'semana' => $x->post('Semana'),
                    'diaprg' => $x->post('DIA'),
                    'frac' => $x->post('FRACCION'),
                    'fecha' => Date('d/m/Y h:i:s a'),
                    'estilo' => $x->post('Estilo'),
                    'par' => $x->post('Pares'),
                    'tiempo' => $r->TIEMPO,
                    'precio' => $r->PRECIO,
                    'nomart' => $x->CLAVE_ARTICULO
                );
                $this->db->insert('programacion', $dtm);
                /* Modificar en pedidox */
                $this->db->set('DiaProg', $x->post('DIA'))
                        ->set('SemProg', $x->post('Semana'))
                        ->set('AnioProg', $x->post('ANIO'))
                        ->set('FechaProg', Date('Y-m-d'))
                        ->set('HoraProg', Date('h:i:s'))
                        ->where('Control', $x->post('CONTROL'))
                        ->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporte() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["ANO"] = $x['ANO'];
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\produccion\asidiacont.jasper');
            $jc->setFilename('asidiacont');
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReportesXSemDiaAno() {
        try {
            $reports = array();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];
            
            /* 1. REPORTE Pares programados para corte de la sem - tiempos, pares, pares x tiempo , precio por par*/
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacont.jasper');
            $jc->setFilename('asidiacont_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports["1UNO"] = $jc->getReport();

            /* 2. REPORTE Entrega de material para corte del programa - agrupado empleado  */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmat.jasper');
            $jc->setFilename('asidiacontmat_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /* 3. REPORTE Entrega de material para corte del programa - agrupado grupos de articulo */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmatg.jasper');
            $jc->setFilename('asidiacontmatg_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();
                
            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
