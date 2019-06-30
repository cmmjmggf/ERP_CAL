<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraNominaDeSemana extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('GeneraNominaDeSemana_model', 'dfm')->helper('jaspercommand_helper');
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->dfm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaPrenomina() {
        try {
            print json_encode($this->dfm->getSemanaPrenomina($this->input->get('SEMANA'), $this->input->get('ANIO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNominaCerrada() {
        try {
            $this->benchmark->mark('code_start');
            $x = $this->input;
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $p["SEMANA"] = $x->post('SEMANA');
            $p["FECHAINI"] = $x->post('FECHAINI');
            $p["FECHAFIN"] = $x->post('FECHAFIN');
            $p["ANIO"] = $x->post('ANIO');
            $jc->setParametros($p);

            $reports = array();

            /* 1. REPORTE DE PRENOMINA COMPLETO */
            $jc->setJasperurl('jrxml\prenomina\prenoml.jasper');
            $jc->setFilename('GenNomDeSem_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();

            /* 2. REPORTE DE PRENOMINA POR DEPARTAMENTO */
            $jc->setJasperurl('jrxml\prenomina\prenomlt.jasper');
            $jc->setFilename('GenNomDeSemXDepto_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /* 3. REPORTE DE TEJIDO */
            $jc->setJasperurl('jrxml\prenomina\prenomltej.jasper');
            $jc->setFilename('GenNomDeSemXDeptoTej_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();

            /* 4. REPORTE SIN TARJETA */
            $jc->setJasperurl('jrxml\prenomina\prenomlst.jasper');
            $jc->setFilename('GenNomDeSemSinTarjeta_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['4CUATRO'] = $jc->getReport();

            /* 5. REPORTE PRENOMINA FIS */
            $jc->setJasperurl('jrxml\prenomina\prenomfis.jasper');
            $jc->setFilename('GenNomDeSemPreNomFis_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['5CINCO'] = $jc->getReport();

            /* 6. REPORTE PRENOMINA FIS DOS (TJ = 1,ABONO_FIS = 0) */
            $jc->setJasperurl('jrxml\prenomina\prenomfiszero.jasper');
            $jc->setFilename('GenNomDeSemPreNomFisZero_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['6SEIS'] = $jc->getReport();

            /* 7. REPORTE PRENOMINA BANAMEX (ABONO NETO) */
            $jc->setJasperurl('jrxml\prenomina\prenomfisbanamex.jasper');
            $jc->setFilename('GenNomDeSemPreNomBanamex_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['7SIETE'] = $jc->getReport();

            print json_encode($reports);
            $this->benchmark->mark('code_end');
//            echo $this->benchmark->elapsed_time('code_start', 'code_end');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVacaciones() {
        try {
            $x = $this->input;
            $anio_completo = 365;
            $treinta_dias = 31;
            $total_vacaciones = 0;
            $prima = 0;
            $dias_trabajados_pagados = 0;
            $S1 = intval($x->post('S1'));
            $S4 = intval($x->post('S4'));
            $sueldin = 0;

            /* 1 ELIMINAR TODO REGISTRO QUE YA TENGA LA SEMANA, AÑO EN PRENOMINA Y PRENOMINAL */
//            $this->db->where('numsem', $x->post('SEMANA'))
//                    ->where('año', $x->post('ANIO'))
//                    ->delete('prenomina');
//            $this->db->where('numsem', $x->post('SEMANA'))
//                    ->where('año', $x->post('ANIO'))
//                    ->delete('prenominal');
            /* 2 OBTENER LOS EMPLEADOS FIJOS */
            $empleados = $this->db->select('E.*')->from('empleados AS E')
                            ->where('E.Numero', 2805)
                            ->where('E.AltaBaja', 1)
                            ->where('E.FijoDestajoAmbos', 1)
                            ->order_by('E.DepartamentoFisico', 'ASC')
                            ->order_by('E.Numero', 'ASC')
                            ->order_by('E.FijoDestajoAmbos', 'ASC')
                            ->get()->result();
            /* 3 ITERAR LOS EMPLEADOS A VALIDAR */
            foreach ($empleados as $k => $v) {
                $sueldin = $v->Sueldo; /* SUELDO DIARIO */
                $fecha = Date('Y-m-d'); /**/
                $dias = $this->db->select("DATEDIFF(\"{$fecha}\", E.FechaIngreso) AS DIAS", false)
                                ->from("empleados AS E")
                                ->where("E.Numero", $v->Numero)
                                ->where('E.AltaBaja', 1)
                                ->get()->result();
                $dias_trabajados = intval($dias[0]->DIAS);

                if ($dias_trabajados >= $anio_completo) {
                    $anios = intval(substr($dias_trabajados / $anio_completo, 0, 1));
                    if ($anios === 1) {
                        /* 6 DIAS */
                        $dias_trabajados_pagados = 6;
                        $total_vacaciones = $sueldin * 6;
                    } else if ($anios === 2) {
                        /* 8 DIAS */
                        $total_vacaciones = $sueldin * 8;
                        $dias_trabajados_pagados = 8;
                    } else if ($anios === 3) {
                        /* 10 DIAS */
                        $total_vacaciones = $sueldin * 10;
                        $dias_trabajados_pagados = 10;
                    } else if ($anios === 4) {
                        /* 12 DIAS */
                        $total_vacaciones = $sueldin * 12;
                        $dias_trabajados_pagados = 12;
                    } else if ($anios >= 5 && $anios <= 9) {
                        /* 14 DIAS */
                        $total_vacaciones = $sueldin * 14;
                        $dias_trabajados_pagados = 14;
                    } else if ($anios >= 10 && $anios <= 14) {
                        /* 16 DIAS */
                        $total_vacaciones = $sueldin * 16;
                        $dias_trabajados_pagados = 16;
                    } else if ($anios >= 15 && $anios <= 19) {
                        /* 18 DIAS */
                        $total_vacaciones = $sueldin * 18;
                        $dias_trabajados_pagados = 18;
                    } else if ($anios >= 20 && $anios <= 24) {
                        /* 20 DIAS */
                        $total_vacaciones = $sueldin * 20;
                        $dias_trabajados_pagados = 20;
                    } else if ($anios >= 25 && $anios <= 29) {
                        /* 22 DIAS */
                        $total_vacaciones = $sueldin * 22;
                        $dias_trabajados_pagados = 22;
                    } else if ($anios >= 30 && $anios <= 34) {
                        /* 24 DIAS */
                        $total_vacaciones = $sueldin * 24;
                        $dias_trabajados_pagados = 24;
                    }
                } else if ($dias_trabajados >= 30 && $dias_trabajados < 365) {
                    $anios = intval(substr($dias_trabajados / $treinta_dias, 0, 1));
                    if ($anios === 1) {
                        /* 0.5 DIAS */
                        $total_vacaciones = $sueldin * 0.5;
                        $dias_trabajados_pagados = 0.5;
                    } else if ($anios === 2) {
                        /* 1 DIAS */
                        $total_vacaciones = $sueldin * 1;
                        $dias_trabajados_pagados = 1;
                    } else if ($anios === 3) {
                        /* 1.5 DIAS */
                        $total_vacaciones = $sueldin * 1.5;
                        $dias_trabajados_pagados = 1.5;
                    } else if ($anios === 4) {
                        /* 2 DIAS */
                        $total_vacaciones = $sueldin * 2;
                        $dias_trabajados_pagados = 2;
                    } else if ($anios === 5) {
                        /* 2.5 DIAS */
                        $total_vacaciones = $sueldin * 2.5;
                        $dias_trabajados_pagados = 2.5;
                    } else if ($anios === 6) {
                        /* 3 DIAS */
                        $total_vacaciones = $sueldin * 3;
                        $dias_trabajados_pagados = 3;
                    } else if ($anios === 7) {
                        /* 3.5 DIAS */
                        $total_vacaciones = $sueldin * 3.5;
                        $dias_trabajados_pagados = 3.5;
                    } else if ($anios === 8) {
                        /* 4 DIAS */
                        $total_vacaciones = $sueldin * 4;
                        $dias_trabajados_pagados = 4;
                    } else if ($anios === 9) {
                        /* 4.5 DIAS */
                        $total_vacaciones = $sueldin * 4.5;
                        $dias_trabajados_pagados = 4.5;
                    } else if ($anios === 10) {
                        /* 5 DIAS */
                        $total_vacaciones = $sueldin * 5;
                        $dias_trabajados_pagados = 5;
                    } else if ($anios === 11) {
                        /* 5.5 DIAS */
                        $total_vacaciones = $sueldin * 5.5;
                        $dias_trabajados_pagados = 5.5;
                    } else if ($anios === 12) {
                        /* 6 DIAS */
                        $total_vacaciones = $sueldin * 6;
                        $dias_trabajados_pagados = 6;
                    }
                }
                /* 1 SE SUMA TODO LO QUE HIZO EL EMPLEADO DURANTE LAS ULTIMAS 4 SEMANAS */
                $SUELDO_CUATRO_SEM = $this->db->select("SUM(FPN.subtot) AS SUBTOTAL", false)->from('fracpagnomina AS FPN')
                                ->where("FPN.numeroempleado", $v->Numero)
                                ->where("FPN.anio", $x->post('ANIO'))
                                ->where("FPN.semana BETWEEN {$S1} AND {$S4}", null, false)
                                ->get()->result();
                if (intval($v->FijoDestajoAmbos) === 1 && intval($v->Numero) === 2805) {
                    /* EMPLEADOS FIJOS */
                }
                if (intval($v->FijoDestajoAmbos) === 2 && intval($v->Numero) === 2805) {
                    /* EMPLEADOS POR DESTAJO */
                    if (!empty($SUELDO_CUATRO_SEM) && $S1 !== '' && $S4 !== '') {
                        /* 2 SE DIVIDE ENTRE 4 Y SE SACA EL SALARIO DIARIO POR DIA */
                        $SUELDO_CUATRO_SEM_FINAL = empty($SUELDO_CUATRO_SEM) ? $SUELDO_CUATRO_SEM[0]->SUBTOTAL / 4 : 0;
                        $SUELDO_CUATRO_SEM_FINAL_POR_DIA = $SUELDO_CUATRO_SEM_FINAL / 7;
                        /* 3. SE HACE EL CALCULO DE SUELDO DIARIO POR DIASTRABAJADOS */
                        $total_vacaciones = $SUELDO_CUATRO_SEM_FINAL_POR_DIA * $dias_trabajados_pagados;
                        /* 4. SE ASIGNA EL RESULTADO AL SUELDO FINAL A PAGAR POR CONCEPTO 25 VACACIONES */
                        $sueldin = $SUELDO_CUATRO_SEM_FINAL_POR_DIA;
                    }
                }
                if (intval($v->FijoDestajoAmbos) === 3 && intval($v->Numero) === 2805) {
                    /* EMPLEADOS FIJOS Y POR DESTAJO */
                    if (!empty($SUELDO_CUATRO_SEM) && $S1 !== '' && $S4 !== '') {
                        /* 2 SE DIVIDE ENTRE 4 Y SE SACA EL SALARIO DIARIO POR DIA */
                        $SUELDO_CUATRO_SEM_FINAL = $SUELDO_CUATRO_SEM[0]->SUBTOTAL / 4;
                        $SUELDO_CUATRO_SEM_FINAL_POR_DIA = $SUELDO_CUATRO_SEM_FINAL / 7;
                        /* 3. SE HACE EL CALCULO DE SUELDO DIARIO POR DIASTRABAJADOS */
                        /* LO GANADO POR FIJO + LO GANADO POR DESTAJO */
                        $total_vacaciones = $total_vacaciones + ($SUELDO_CUATRO_SEM_FINAL_POR_DIA * $dias_trabajados_pagados);
                        /* 4. SE ASIGNA EL RESULTADO AL SUELDO FINAL A PAGAR POR CONCEPTO 25 VACACIONES */
                        $sueldin = $sueldin + $SUELDO_CUATRO_SEM_FINAL_POR_DIA;
                    }
                }
                if (intval($v->Numero) === 2805) {
                    $prima = $total_vacaciones * 0.25;
                    /* GRABAR VACACIONES */
                    $vp = array(
                        "numsem" => $x->post('SEMANA'),
                        "año" => $x->post('ANIO'),
                        "numemp" => $v->Numero,
                        "diasemp" => $dias_trabajados_pagados,
                        "numcon" => 25 /* 25 CONCEPTOS DE NOMINA */,
                        "tpcon" => 1,
                        "tpcond" => 0,
                        "importe" => $total_vacaciones,
                        "imported" => $sueldin,
                        "fecha" => Date('Y-m-d h:i:s'),
                        "registro" => 0,
                        "status" => 1,
                        "tpomov" => 0,
                        "depto" => $v->DepartamentoFisico
                    );
                    $this->db->insert('prenomina', $vp);
                    /* GRABA PRE-NOMINA-L */
                    $pnl = array(
                        "numsem" => $x->post('SEMANA'),
                        "año" => $x->post('ANIO'),
                        "numemp" => $v->Numero,
                        "salario" => $sueldin,
                        "horext" => $dias_trabajados_pagados,
                        "pares" => 0,
                        "otrper" => $prima,
                        "otrper1" => $total_vacaciones,
                        "imss" => 0,
                        "impu" => 0,
                        "precaha" => 0,
                        "cajhao" => 0,
                        "vtazap" => 0,
                        "zapper" => 0,
                        "fune" => 0,
                        "cargo" => 0,
                        "fonac" => 0,
                        "otrde" => 0,
                        "otrde1" => 0,
                        "registro" => 0,
                        "status" => 1,
                        "tpomov" => 0,
                        "depto" => $v->DepartamentoFisico
                    );

                    $this->db->insert('prenominal', $pnl);

                    /* GRABA PRIMA-VACACIONAL */
                    $vp["numcon"] = 26;
                    $vp["importe"] = $total_vacaciones * 0.25;
                    $vp["imported"] = 0;
                    $this->db->insert('prenomina', $vp);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAguinaldos() {
        try {
            $x = $this->input;
            
            /* 1 ELIMINAR REGISTROS EN PRENOMINA Y PRENOMINAL DE LA SEMANA Y AÑO ESPECIFICADO */
            //            $this->db->where('numsem', $x->post('SEMANA'))
//                    ->where('año', $x->post('ANIO'))
//                    ->delete('prenomina');
//            $this->db->where('numsem', $x->post('SEMANA'))
//                    ->where('año', $x->post('ANIO'))
//                    ->delete('prenominal');
            
            /* 2 OBTENER LOS EMPLEADOS FIJOS */
            $empleados = $this->db->select('E.*')->from('empleados AS E')
                            ->where('E.Numero', 2805)
                            ->where('E.AltaBaja', 1)
                            ->where('E.FijoDestajoAmbos', 1)
                            ->order_by('E.DepartamentoFisico', 'ASC')
                            ->order_by('E.Numero', 'ASC')
                            ->order_by('E.FijoDestajoAmbos', 'ASC')
                            ->get()->result();
            
            
            /*
              'saca los empleados activos con tipo de salario 1  y 3------------------------------------------------------------------------------------------------------------------------------------------
              diai = Mid(Date, 1, 2): mesi = Mid(Date, 4, 2) * 30.41: añoi = Mid(Date, 7, 4) * 365: diah = Val(diai) + Val(mesi) + Val(añoi)
              txtstsemp = 1: Data2.RecordSource = "SELECT * FROM empleados  WHERE stsemp = " & 1 & "and tiposdo = " & 1 & " or tiposdo= " & 3 & "  order by numemp":  Data2.Refresh
              Do While Not Data2.Recordset.EOF
              txtsaldia = Data2.Recordset.Fields("sdbemp"): txtnumemp = Data2.Recordset.Fields("numemp"):
              ingreso = Data2.Recordset.Fields("feiemp"): txtdepto = Data2.Recordset.Fields("depemp"):
              fechafina = DateValue(fechaco) - DateValue(ingreso)

              If Val(fechafina) > 365 Then txtimporte = Val(txtsaldia) * 15: diast = 15 Else di1 = Val(fechafina) * 15: di2 = Val(di1) / 365: txtimporte = Val(txtsaldia) * di2: diast = di2
              gravaagiu
              Data2.Recordset.MoveNext
              Loop
              'saca los empleados activos con tipo de salario 2 ------------------------------------------------------------------------------------------------------------------------------------------
              diai = Mid(Date, 1, 2): mesi = Mid(Date, 4, 2) * 30.41: añoi = Mid(Date, 7, 4) * 365: diah = Val(diai) + Val(mesi) + Val(añoi)
              txtstsemp = 1: Data2.RecordSource = "SELECT * FROM empleados  WHERE stsemp = " & Val(txtstsemp) & " and tiposdo = " & 2 & " order by numemp": Data2.Refresh
              Do While Not Data2.Recordset.EOF
              txtnumemp = Data2.Recordset.Fields("numemp"): ingreso = Data2.Recordset.Fields("feiemp"): txtdepto = Data2.Recordset.Fields("depemp"):
              saldia = 0: Data3.RecordSource = "SELECT * FROM prenomina  WHERE numemp = " & Val(txtnumemp) & " and año = " & Val(año) & " and numsem >= " & Val(txtsemv1) & " and numsem <= " & Val(txtsemv4) & "  and numcon = " & 5 & " order by numemp": Data3.Refresh
              Do While Not Data3.Recordset.EOF
              saldia = Val(saldia) + Val(Data3.Recordset.Fields("importe"))
              Data3.Recordset.MoveNext
              Loop

              saldiar = Val(saldia) / 4: txtsaldia = Val(saldiar) / 7: fechafina = DateValue(fechaco) - DateValue(ingreso)

              If Val(fechafina) > 365 Then txtimporte = Val(txtsaldia) * 15: diast = 15 Else di1 = Val(fechafina) * 15: di2 = Val(di1) / 365: txtimporte = Val(txtsaldia) * di2: diast = di2
              gravaagiu
              Data2.Recordset.MoveNext
              Loop
              cristal.ReportFileName = pathc & "prenomagui.rpt"
              cristal.DataFiles(0) = PATHB & "bdshoesysnomi.MDB"
              cristal.Formulas(0) = "NOMCIA='" & txtnomcia & "'"
              cristal.SelectionFormula = "{prenominal.numsem} =" & Val(txtnumsem) & " and {prenominal.año} =" & Val(año) & ""
              cristal.PrintReport
              Screen.MousePointer = vbIconPointer
              End Sub */
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
