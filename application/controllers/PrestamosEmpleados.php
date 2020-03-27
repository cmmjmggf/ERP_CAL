<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class PrestamosEmpleados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('PrestamosEmpleados_model', 'pem')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->onRefrescarSaldoDePrestamos();
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuNominas');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuNominas');
                    break;
            }
            $this->load->view('vFondo')->view('vPrestamosEmpleados')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onRefrescarSaldoDePrestamos() {
        try {
            $ANIO = Date('Y');
            $empleados = $this->db->query("SELECT E.Numero, E.SaldoPres,E.AbonoPres, "
                            . "(SELECT SUM(PP.preemp) AS ACUMULADO FROM prestamos AS PP WHERE YEAR(PP.fechapre) = {$ANIO} AND PP.numemp = E.Numero) AS ACUMULADO_PRES, "
                            . "(SELECT  ifnull(SUM(PP.Aboemp),0) AS ACUMULADO FROM prestamospag AS PP WHERE PP.numemp = E.Numero AND PP.año = {$ANIO}  AND PP.status = 2) AS TOTAL_PAGADO,
(SELECT aboemp FROM prestamos AS PP WHERE YEAR(PP.fechapre) = {$ANIO} AND PP.numemp = E.Numero ORDER BY ID DESC LIMIT 1) AS ABONO   
    FROM empleados AS E WHERE E.AltaBaja = 1 HAVING ACUMULADO_PRES IS NOT NULL AND ACUMULADO_PRES > TOTAL_PAGADO;")->result();
            foreach ($empleados as $k => $v) {
                $SALDO_PRESTAMOS = floatval($v->ACUMULADO_PRES) - floatval($v->TOTAL_PAGADO);
                $this->db->set("PressAcum", floatval($v->ACUMULADO_PRES));
                if (floatval($SALDO_PRESTAMOS) > 0) {
                    $this->db->set("SaldoPres", $SALDO_PRESTAMOS);
                } else {
                    $this->db->set("SaldoPres", 0);
                }
                $this->db->where("Numero", $v->Numero)->update("empleados");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->pem->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosEnPagares() {
        try {
            print json_encode($this->pem->getEmpleadosEnPagares());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamos() {
        try {
//            print json_encode($this->pem->getPrestamos($this->input->get('EMPLEADO')));

            $x = $this->input->get();
            $this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                            . "P.pagare AS PAGARE,P.sem AS SEM, DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") AS FECHA, "
                            . "P.preemp AS PRESTAMO,FORMAT(P.preemp,2) AS PRESTAMO_TEXT, P.aboemp AS ABONO,FORMAT(P.aboemp,2) AS ABONO_TEXT, P.salemp, "
                            . "P.pesos,P.fecpag,P.sempag")
                    ->from("prestamos AS P");
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('P.numemp', $x['EMPLEADO']);
            }
            $this->db->where('P.numemp', $x['EMPLEADO'])->where("YEAR(fechapre)", Date('Y'));
            if ($x['EMPLEADO'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamosConsulta() {
        try {
//            print json_encode($this->pem->getPrestamosConsulta($this->input->get('PAGARE'), $this->input->get('FECHA'), $this->input->get('EMPLEADO')));
            $x = $this->input->get();
            $ANIO = Date('Y');
            $this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                            . "P.pagare AS PAGARE,P.sem AS SEM, DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") AS FECHA, "
                            . "P.preemp AS PRESTAMO, P.aboemp AS ABONO, P.salemp, "
                            . "P.pesos,P.fecpag,P.sempag")
                    ->from("prestamos AS P");
            if ($x['FECHA'] !== '') {
                $this->db->where("DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") =  \"{$x['FECHA']}\" ", null, false);
            }
            if ($x['PAGARE'] !== '') {
                $this->db->where('P.pagare', $x['PAGARE']);
            }
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('P.numemp', $x['EMPLEADO']);
            }
            $this->db->where('YEAR(P.fechapre)', $ANIO);
            if ($x['PAGARE'] === '' && $x['FECHA'] === '') {
                $this->db->limit(999);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAbonado() {
        try {
            $x = $this->input->get();
            $this->db->select("SUM(PP.aboemp) AS ABONADO ", false)->from("prestamospag AS PP");
            if ($x["EMPLEADO"] !== '') {
                $this->db->where("PP.numemp", $x["EMPLEADO"]);
            }
            $this->db->where("status", 2)->where("YEAR(fecha)", Date('Y'));
            /* NO EXISTE ENLACE ENTRE EL PRESTAMO Y EL PAGO DE LOS PRESTAMOS */
            if ($x["PAGARE"] !== '') {
                $check_pagare = $this->db->query("SELECT P.numemp AS EMPLEADO, P.sem AS SEMANA FROM prestamos AS P WHERE P.pagare = {$x['PAGARE']}")->result();
                if (count($check_pagare) > 0) {
                    $pagare = $check_pagare[0];
                    $this->db->where("PP.numemp", $pagare->EMPLEADO);
                }
            }

            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrestamosPagos() {
        try {
//            print json_encode($this->pem->getPrestamosPagos($this->input->get('EMPLEADO')));
            $EMPLEADO = $this->input->get('EMPLEADO');
            $this->db->select("PP.ID AS ID, PP.numemp AS EMPLEADO, PP.año, "
                            . "PP.sem AS SEM, DATE_FORMAT(PP.fecha,\"%d/%m/%Y\") AS FECHA, PP.preemp, "
                            . "PP.aboemp AS ABONO, PP.saldoemp, PP.interes AS INTERES, "
                            . "PP.status AS ESTATUS")
                    ->from("prestamospag AS PP");
            if ($EMPLEADO !== '') {
                $this->db->where('PP.numemp', $EMPLEADO);
            }
            $this->db->where('PP.status', 2)->where('YEAR(PP.fecha)', Date('Y'))->order_by('PP.fecha', 'DESC');
            if ($EMPLEADO === '') {
                $this->db->where('PP.numemp', 0);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoSaldo() {
        try {
            $ANIO = Date('Y');
            print json_encode($this->db->select("P.ID AS ID,P.numemp AS EMPLEADO, P.nomemp, "
                                            . "P.pagare AS PAGARE,P.sem AS SEM, P.fechapre AS FECHA, "
                                            . "P.preemp AS PRESTAMO, P.aboemp AS ABONO, P.salemp, "
                                            . "P.pesos,P.fecpag,P.sempag,"
                                            . "((SELECT SUM(PX.preemp) FROM prestamos AS PX WHERE PX.numemp = P.numemp  AND YEAR(PX.fechapre) = {$ANIO}) - "
                                            . "(SELECT SUM(PP.aboemp) FROM prestamospag AS PP WHERE PP.numemp = P.numemp AND PP.status = 2 AND PP.año = {$ANIO})) AS SALDO", false)->from('prestamos AS P')
                                    ->where('P.numemp', $this->input->get('EMPLEADO'))
                                    ->where("year(P.fechapre)", Date('Y'))
                                    ->order_by('P.fechapre', 'DESC')->limit(1)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionSemana() {
        try {
            print json_encode($this->pem->getInformacionSemana(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarPrestamosEmpleados() {
        try {
            $xxx = $this->input->post();
            $E = $this->db->select("E.Numero AS CLAVE, "
                                    . "CONCAT(E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                            ->from("empleados AS E")
                            ->where('E.Numero', $xxx['EMPLEADO'])
                            ->where('E.AltaBaja', 1)->get()->result();
            $semanas = $xxx['PRESTAMO'] / $xxx['ABONO'];
            $dias = $semanas * 7;
            $fecha = Date('Y-m-d');
            $fecha_final = $this->db->query("SELECT DATE_ADD(\"{$fecha}\", INTERVAL {$dias} DAY) AS FDP")->row_array();

            $this->db->insert('prestamos', array(
                'numemp' => $xxx['EMPLEADO'],
                'nomemp' => $E[0]->EMPLEADO,
                'pagare' => $xxx['PAGARE'],
                'sem' => $xxx['SEMANA'],
                'fechapre' => Date('Y-m-d h:i:s'),
                'preemp' => $xxx['PRESTAMO'],
                'aboemp' => $xxx['ABONO'],
                'salemp' => $xxx['SALDO'],
                'pesos' => $xxx['PRESTAMOLETRA'],
                'fecpag' => $fecha_final['FDP'],
                'sempag' => $semanas
            ));
            $this->db->set('PressAcum', $xxx['ULTIMOSALDO'])
                    ->set('AbonoPres', $xxx['ABONO'])
                    ->set('SaldoPres', $xxx['SALDO'])
                    ->where('Numero', $xxx['EMPLEADO'])
                    ->update('empleados');
            $empleado_info = $this->db->select("CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS NOMBRECOMPLETO, "
                                    . "E.Direccion AS DIRECCION,"
                                    . "E.Colonia AS COLONIA,"
                                    . "E.Ciudad AS CIUDAD,"
                                    . "E.Tel AS TEL", false)
                            ->from('empleados AS E')
                            ->where('E.Numero', $xxx['EMPLEADO'])->get()->result();


            /* PAGARE */
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["PAGARE"] = $xxx['PAGARE'];
            $p["FECHAPAGARE"] = Date('d/m/Y');
            $p["EMPRESA"] = $this->session->EMPRESA_RAZON;
            $p["LUGAREXPEDICION"] = "LEON GTO";
            $p["NUMEROENLETRA"] = strtoupper($xxx['PRESTAMOLETRA']);
            $p["DEUDORNOMBRE"] = $this->getValid($empleado_info[0]->NOMBRECOMPLETO);
            $p["DEUDORDIRECCION"] = $this->getValid($empleado_info[0]->DIRECCION);
            $p["DEUDORCOLONIA"] = $this->getValid($empleado_info[0]->COLONIA);
            $p["DEUDORCIUDAD"] = $empleado_info[0]->CIUDAD;
            $p["DEUDORTELEFONO"] = $this->getValid($empleado_info[0]->TEL);
            $p["FECHAPAGO"] = date("d/m/Y", strtotime($fecha_final['FDP']));
            $p["MONTO"] = '$' . number_format($xxx['PRESTAMO'], 2, ".", ",");
            $jc->setParametros($p);
            $jc->setJasperurl('jrxml\prestamos\Pagare.jasper');
            $jc->setFilename('Pagare_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
            $this->onRefrescarSaldoDePrestamos();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagare() {
        try {
            /* PAGARE */
            $ANIO = Date('Y');
            $xxx = $this->input->post();
            $this->db->select("P.ID,P.numemp AS EMPLEADO,P.nomemp, "
                            . "P.pagare,P.sem,P.fechapre,P.preemp AS MONTO, "
                            . "P.aboemp,P.salemp,"
                            . "P.pesos AS PRESTAMOLETRAS,"
                            . "P.fecpag AS FECHA_PAGARE,P.sempag", false)
                    ->from('prestamos AS P')
                    ->where('P.pagare', $xxx['PAGARE'])
                    ->where('YEAR(P.fechapre)', $ANIO);
            if ($xxx['FECHA'] !== '') {
                $pagare_info = $this->db->where("DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") =  \"{$xxx['FECHA']}\" ", null, false)
                                ->get()->result();
            } else {
                $pagare_info = $this->db->get()->result();
            }


            $empleado_info = $this->db->select("CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS NOMBRECOMPLETO, "
                                    . "E.Direccion AS DIRECCION,"
                                    . "E.Colonia AS COLONIA,"
                                    . "E.Ciudad AS CIUDAD,"
                                    . "E.Tel AS TEL", false)
                            ->from('empleados AS E')
                            ->where('E.Numero', $pagare_info[0]->EMPLEADO)->get()->result();

//            $this->benchmark->mark('code_start');
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["PAGARE"] = $xxx['PAGARE'];
            $p["FECHAPAGARE"] = Date('d/m/Y');
            $p["EMPRESA"] = $this->session->EMPRESA_RAZON;
            $p["LUGAREXPEDICION"] = "LEON GTO";
            $p["NUMEROENLETRA"] = strtoupper($pagare_info[0]->PRESTAMOLETRAS);
            $p["DEUDORNOMBRE"] = $this->getValid($empleado_info[0]->NOMBRECOMPLETO);
            $p["DEUDORDIRECCION"] = $this->getValid($empleado_info[0]->DIRECCION);
            $p["DEUDORCOLONIA"] = $this->getValid($empleado_info[0]->COLONIA);
            $p["DEUDORCIUDAD"] = $empleado_info[0]->CIUDAD;
            $p["DEUDORTELEFONO"] = $this->getValid($empleado_info[0]->TEL);
            $p["FECHAPAGO"] = date("d/m/Y", strtotime($pagare_info[0]->FECHA_PAGARE));
            $p["MONTO"] = '$' . number_format($pagare_info[0]->MONTO, 2, ".", ",");
            $jc->setParametros($p);
            $jc->setJasperurl('jrxml\prestamos\Pagare.jasper');
            $jc->setFilename('Pagare_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport(); 
//            $this->benchmark->mark('code_end');
//            echo $this->benchmark->elapsed_time('code_start', 'code_end');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getValid($str) {
        return str_replace("0", "", $str);
    }

    public function ModificaInteresPrestamos($param) {
        try {
            $this->db->set('PP.interes', $this->input->post('INTERES'))->update('prestamos AS PP');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagares() {
        try {
            $xxx = $this->input->post();
            $ANIO = Date('Y');
            /* PAGARE X NUMERO */
            if ($xxx['FECHA'] === '' && $xxx['PAGARE'] !== '') {
                $this->getPagare();
            } else
            if ($xxx['FECHA'] !== '' && $xxx['PAGARE'] === '') {
                /* PAGARE X FECHA */
                $pagare_info = $this->db->select("P.ID,P.numemp AS EMPLEADO,P.nomemp, "
                                        . "P.pagare,P.sem,P.fechapre,P.preemp AS MONTO, "
                                        . "P.aboemp,P.salemp,"
                                        . "P.pesos AS PRESTAMOLETRAS,"
                                        . "P.fecpag AS FECHA_PAGARE,P.sempag", false)
                                ->from('prestamos AS P')
                                ->where('YEAR(P.fechapre)', $ANIO)
                                ->where("DATE_FORMAT(P.fechapre,\"%d/%m/%Y\") =  \"{$xxx['FECHA']}\"  ", null, false)
                                ->get()->result();

                $empleado_info = $this->db->select("CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS NOMBRECOMPLETO, "
                                        . "E.Direccion AS DIRECCION,"
                                        . "E.Colonia AS COLONIA,"
                                        . "E.Ciudad AS CIUDAD,"
                                        . "E.Tel AS TEL", false)
                                ->from('empleados AS E')
                                ->where('E.Numero', $pagare_info[0]->EMPLEADO)->get()->result();

                $jc = new JasperCommand();
                $jc->setFolder('rpt/' . $this->session->USERNAME);
                $p = array();
                $p["FECHAPAGARES"] = $xxx['FECHA'];
                $p["EMPRESA"] = $this->session->EMPRESA_RAZON;
                $p["LUGAREXPEDICION"] = "LEON GTO";
                $jc->setParametros($p);
                $jc->setJasperurl('jrxml\prestamos\PagareMultiple.jasper');
                $jc->setFilename('Pagare_' . Date('h_i_s'));
                $jc->setDocumentformat('pdf');
                PRINT $jc->getReport();
                $this->onRefrescarSaldoDePrestamos();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
