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

    public function onRevisarGenerandoNomina() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query(
                                    "SELECT COUNT(*) AS TOTAL, GN.* FROM generando_nomina AS GN WHERE GN.SEMANA ={$x['SEMANA']} AND GN.ANIO ={$x['ANIO']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRegeneraCelulasPespunte() {
        try {
            $x = $this->input->get();
            var_dump($x);
            exit(0);
            $this->onNominaPreliminaresPespunte($x['ANIO'], $x['SEMANA']);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGeneraNomina() {
        try {
            $x = $this->input->post();
            $this->db->insert('generando_nomina', array('USUARIO' => $this->session->USERNAME,
                'FECHA' => Date('d/m/Y'), 'HORA' => Date('h:i:s'),
                'SEMANA' => $x['SEMANA'], 'ANIO' => $x['ANIO'],
                'FECHA_INICIAL' => $x['FECHAINI'], 'FECHA_FINAL' => $x['FECHAFIN']));

            $this->db->where('semana', $x['SEMANA'])->where('anio', $x['ANIO'])->where('numeroempleado', 0)->delete('fracpagnomina');
            $this->db->where('semana', $x['SEMANA'])->where('año', $x['ANIO'])->where('numemp', 0)->delete('fracpagnominatmp');
            $this->onNominaPreliminaresPespunte($x['ANIO'], $x['SEMANA']);

//            $empleados = $this->db->query('SELECT E.* FROM empleados AS E '
//                            . 'WHERE E.AltaBaja IN(1) '
//                            . 'AND E.Incapacitado = 0')->result(); 
            $empleados = $this->db->query('SELECT E.Numero, E.FijoDestajoAmbos, E.Sueldo, E.DepartamentoFisico, E.CelulaPorcentaje, E.Celula, E.Ahorro, E.Infonavit, E.Comida, E.Funeral, E.IMSS, E.Fierabono, E.FieraBonoPagos, E.Fonacot, E.ZapatosTDA, E.AbonoZap, E.SaldoPres, E.ISR, E.PressAcum, E.AbonoPres FROM empleados AS E '
                            . 'WHERE E.AltaBaja IN(1) '
                            . 'AND E.Incapacitado = 0')->result();

            /* ELIMINAR TODO DE LA SEMANA AÑO ESPECIFICADA */
            $DF = "DELETE FROM ";
            /* ELIMINAR EN PRENOMINA */
//            $pn = $this->db->query("SELECT * FROM prenomina WHERE numsem = {$x['SEMANA']} AND año = {$x['ANIO']} AND registro = 999")->result();
//            print_r($pn);
            $this->db->query("DELETE FROM prenomina WHERE numsem = {$x['SEMANA']} AND año = {$x['ANIO']} AND registro  <> 999  AND status = 1");
            /* ELIMINAR EN PRENOMINAL */
//            $pnl = $this->db->query("SELECT * FROM prenominal WHERE numsem = {$x['SEMANA']} AND año = {$x['ANIO']} AND registro = 999")->result();
//            print_r($pnl);
            $this->db->query("DELETE FROM prenominal WHERE numsem = {$x['SEMANA']} AND año = {$x['ANIO']} AND registro <> 999 AND status = 1");

            /* ELIMINAR EN PRESTAMOSPAG */
            $this->db->query("DELETE FROM prestamospag WHERE sem = {$x['SEMANA']} AND año = {$x['ANIO']}");

            $dias = array(1 => 1, 2 => 2, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 7);

            foreach ($empleados as $k => $v) {

                $FijoDestajoAmbos = intval($v->FijoDestajoAmbos);

                /* CONSULTAR ASISTENCIAS POR # EMPLEADO */
                $ASISTENCIAS_SIETE = $this->db->query("SELECT A.numasistencias AS ASISTENCIAS FROM asistencia AS A WHERE  A.numsem = {$x['SEMANA']} AND A.año = {$x['ANIO']} AND A.numemp = {$v->Numero}")->result();
                if (empty($ASISTENCIAS_SIETE)) {
                    $ASISTENCIAS = 0;
                } else {
                    $ASISTENCIAS = intval($dias[intval($ASISTENCIAS_SIETE[0]->ASISTENCIAS)]);
                }
                /* SALARIOS : FIJO, DESTAJO, DESTAJO (CELULA), FIJO Y DESTAJO */
                if ($FijoDestajoAmbos === 1 && intval($ASISTENCIAS) > 0) {
                    /* 1 FIJO */
                    $SUELDO_FINAL = 0;
                    $SUELDO_FINAL = $v->Sueldo * intval($ASISTENCIAS);
                    /* 1.1 INSERT PARA EL CONCEPTO 1 = SALARIO (FIJO) */
//                    $EXISTE_EN_PRENOMINA = $this->onExisteEnPrenomina($x['ANIO'], $x['SEMANA'], $v->Numero, 1);
                    $EXISTE_EN_PRENOMINA = $this->db->query("SELECT PN.* FROM prenomina AS PN "
                                    . "WHERE PN.año ={$x['ANIO']} AND PN.numsem = {$x['SEMANA']} "
                                    . "AND PN.numemp = {$v->Numero} AND PN.numcon =1")->result();

                    if (empty($EXISTE_EN_PRENOMINA)) {
                        $this->db->insert('prenomina', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "numcon" => 1 /* 1 SALARIO */, "tpcon" => 1 /* PERCEPCION */,
                            "tpcond" => 0 /* DEDUCCION */, "importe" => $SUELDO_FINAL,
                            "imported" => 0, "fecha" => Date('Y-m-d 00:00:00'),
                            "registro" => 0, "status" => 1, "tpomov" => 0,
                            "depto" => $v->DepartamentoFisico
                        ));
                    }
                    /* 1.2 INSERT PARA EL CONCEPTO 1 = SALARIO (FIJO) EN PRENOMINAL */
//                    $EXISTE_EN_PRENOMINAL = $this->onExisteEnPrenominaL($x['ANIO'], $x['SEMANA'], $v->Numero);
                    $EXISTE_EN_PRENOMINAL = $this->db->query("SELECT PNL.* FROM prenominal AS PNL WHERE PNL.año = {$x['ANIO']} AND PNL.numsem = {$x['SEMANA']} AND PNL.numemp = {$v->Numero} ")->result();

                    if (!empty($EXISTE_EN_PRENOMINAL)) {
                        $this->db->set('pares', 0)->set('salario', $SUELDO_FINAL)
                                ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                ->where('numemp', $v->Numero)->update('prenominal');
                    } else {
                        $this->db->insert('prenominal', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "salario" => $SUELDO_FINAL, "depto" => $v->DepartamentoFisico,
                            "status" => 1, "tpomov" => 0
                        ));
                    }
                } else
                if ($FijoDestajoAmbos === 2 && intval($ASISTENCIAS) > 0) {
                    $ES_CELULA = 0;
                    $PARES_TRABAJADOS = 0;
                    /* 2 DESTAJO */
                    /* 2.1 OBTENER EL SUELDO POR DESTAJO HECHO EN LA SEMANA */
                    $SUELDO_DESTAJO = $this->db->query("SELECT CASE WHEN SUM(subtot) IS NULL THEN 0 ELSE SUM(subtot) END AS SUBTOTAL FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = '{$v->Numero}' AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();

                    /* 10 = CORTE , FRACCION 100 */
                    if (intval($v->DepartamentoFisico) === 10) {
                        $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = '{$v->Numero}' AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']} AND FPN.numfrac = 100")->result();
                    } else {
                        $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = '{$v->Numero}' AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();
                    }
                    /* 2.2 VERIFICAR QUE EL SUELDO_DESTAJO SEA IGUAL A CERO Y REVISAR SI LA CELULA TIENE ALGUN PORCENTAJE */
                    $SUELDO_FINAL_DESTAJO = 0;
                    if (intval($SUELDO_DESTAJO[0]->SUBTOTAL) === 0 && floatval($v->CelulaPorcentaje) > 0) {
                        $ES_CELULA = 1;
                        $NUMERO_CELULA = 0;
//                        0,1,2,3,4,5,6,7,8,9,10,11,101,102,103,104,105,106,107,109,110
                        switch (intval($v->Celula)) {
                            case 0:
                                switch (intval($v->DepartamentoFisico)) {
                                    case 120:
                                        $NUMERO_CELULA = 899;
                                        break;
                                    case 180:
                                        $NUMERO_CELULA = 993;
                                        break;
                                    case 190:
                                        $NUMERO_CELULA = 991;
                                        break;
                                    case 200:
                                        $NUMERO_CELULA = 1006;
                                        break;
                                    case 210:
                                        $NUMERO_CELULA = 992;
                                        break;
                                    case 220:
                                        $NUMERO_CELULA = 1005;
                                        break;
                                }
                                break;
                            case 1:
                                $NUMERO_CELULA = 1000;
                                break;
                            case 2:
                                $NUMERO_CELULA = 999;
                                break;
                            case 3:
                                $NUMERO_CELULA = 998;
                                break;
                            case 4:
                                $NUMERO_CELULA = 997;
                                break;
                            case 5:
                                $NUMERO_CELULA = 996;
                                break;
                            case 5:
                                $NUMERO_CELULA = 996;
                                break;
                            case 6:
                                $NUMERO_CELULA = 995;
                                break;
                            case 7:
                                $NUMERO_CELULA = 994;
                                break;
                            case 8:
                                $NUMERO_CELULA = 899;
                                break;
                            case 9:
                                $NUMERO_CELULA = 1001;
                                break;
                            case 10:
                                $NUMERO_CELULA = 1002;
                                break;
                            case 11:
                                $NUMERO_CELULA = 1003;
                                break;
                            case 101:
                                $NUMERO_CELULA = 899;
                                break;
                            case 107:
                                $NUMERO_CELULA = 994;
                                break;
                        }
                        if (intval($v->Celula) > 0 && intval($v->Celula) !== 101 && intval($v->Celula) !== 107) {
                            $SUELDO_DESTAJO = $this->db->query("SELECT CASE WHEN SUM(IFNULL(subtot,0)) IS NULL THEN 0 ELSE SUM(IFNULL(subtot,0)) END AS SUBTOTAL FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = {$NUMERO_CELULA} AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();
                            $SUELDO_FINAL_DESTAJO = $SUELDO_DESTAJO[0]->SUBTOTAL * $v->CelulaPorcentaje;
                            $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = {$NUMERO_CELULA}  AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();
                            $PARES_TRABAJADOS = $PARES_TRABAJADOS_PAGADOS[0]->PARES;
                        } else if (intval($v->Celula) === 0 && intval($v->Celula) !== 101 && intval($v->Celula) !== 107) {
//                            MONTADO A, MONTADO B, ADORNO A, ADORNO B
                            $SUELDO_DESTAJO = $this->db->query("SELECT CASE WHEN SUM(IFNULL(subtot,0)) IS NULL THEN 0 ELSE SUM(IFNULL(subtot,0)) END AS SUBTOTAL FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = {$NUMERO_CELULA} AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();
                            $SUELDO_FINAL_DESTAJO = $SUELDO_DESTAJO[0]->SUBTOTAL * $v->CelulaPorcentaje;
                            $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE FPN.numeroempleado = {$NUMERO_CELULA}  AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();
                            $PARES_TRABAJADOS = $PARES_TRABAJADOS_PAGADOS[0]->PARES;
                        } else if (intval($v->Celula) > 0 && intval($v->Celula) === 101 && floatval($v->CelulaPorcentaje) > 0) {
                            $fraccion_pespunte = 304;
                            $SUELDO_CELULA_PESPUNTE = $this->db->query("SELECT SUM(F.subtot) AS SUBTOTAL FROM fracpagnomina AS F WHERE F.semana = {$x['SEMANA']} AND F.fraccion = {$fraccion_pespunte} AND F.anio = {$x['ANIO']} AND F.depto = {$v->DepartamentoFisico} AND F.maquila = 101 ")->result();
                            $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE  FPN.fraccion = {$fraccion_pespunte} AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}  AND FPN.depto = {$v->DepartamentoFisico}  AND FPN.maquila = 101 ")->result();
                            if (count($SUELDO_CELULA_PESPUNTE) > 0) {
                                $SUELDO_FINAL_DESTAJO = $SUELDO_CELULA_PESPUNTE[0]->SUBTOTAL * $v->CelulaPorcentaje;
                                $PARES_TRABAJADOS = $PARES_TRABAJADOS_PAGADOS[0]->PARES;
                            } else {
                                $SUELDO_FINAL_DESTAJO = 0;
                            }
                        } else if (intval($v->Celula) > 0 && intval($v->Celula) === 107 && floatval($v->CelulaPorcentaje) > 0) {
                            $fraccion_pespunte = 304;
                            $SUELDO_CELULA_PESPUNTE = $this->db->query("SELECT SUM(F.subtot) AS SUBTOTAL FROM fracpagnomina AS F WHERE F.semana = {$x['SEMANA']} AND F.fraccion = {$fraccion_pespunte} AND F.anio = {$x['ANIO']} AND F.depto = {$v->DepartamentoFisico} AND F.maquila = 107")->result();
                            $PARES_TRABAJADOS_PAGADOS = $this->db->query("SELECT CASE WHEN SUM(pares) IS NULL THEN 0 ELSE SUM(pares) END AS PARES FROM fracpagnomina AS FPN WHERE  FPN.fraccion = {$fraccion_pespunte} AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']} AND FPN.maquila = 107 AND FPN.depto = {$v->DepartamentoFisico}")->result();
                            if (count($SUELDO_CELULA_PESPUNTE) > 0) {
                                $SUELDO_FINAL_DESTAJO = $SUELDO_CELULA_PESPUNTE[0]->SUBTOTAL * $v->CelulaPorcentaje;
                                $PARES_TRABAJADOS = $PARES_TRABAJADOS_PAGADOS[0]->PARES;
                            } else {
                                $SUELDO_FINAL_DESTAJO = 0;
                            }
                        }
                    } else {
                        /* 2.3 SI EL EMPLEADO */
                        $SUELDO_FINAL_DESTAJO = $SUELDO_DESTAJO[0]->SUBTOTAL;
                        $PARES_TRABAJADOS = $PARES_TRABAJADOS_PAGADOS[0]->PARES;
                        $ES_CELULA = 0;
                    }
                    /* 2.4 VERIFICAR SI ESTA EN PRENOMINA */
                    $EXISTE_EN_PRENOMINA = $this->onExisteEnPrenomina($x['ANIO'], $x['SEMANA'], $v->Numero, 1);
                    if (empty($EXISTE_EN_PRENOMINA)) {
                        $this->db->insert('prenomina', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "numcon" => 5 /* 5 SALARIO DESTAJO */, "tpcon" => 2 /* PERCEPCION */,
                            "tpcond" => 0 /* DEDUCCION */, "importe" => $SUELDO_FINAL_DESTAJO,
                            "imported" => 0, "fecha" => Date('Y-m-d 00:00:00'),
                            "registro" => 0, "status" => 1, "tpomov" => 0,
                            "depto" => $v->DepartamentoFisico
                        ));
                    }
                    /* 2.5 INSERT PARA EL CONCEPTO 5 = SALARIO (DESTAJO) EN PRENOMINAL */
//                    $EXISTE_EN_PRENOMINAL = $this->onExisteEnPrenominaL($x['ANIO'], $x['SEMANA'], $v->Numero);
                    $EXISTE_EN_PRENOMINAL = $this->db->query("SELECT PNL.* FROM prenominal AS PNL WHERE PNL.año = {$x['ANIO']} AND PNL.numsem = {$x['SEMANA']} AND PNL.numemp = {$v->Numero} ")->result();
                    if (!empty($EXISTE_EN_PRENOMINAL)) {
                        if (intval($v->FijoDestajoAmbos) === 1 && floatval($v->CelulaPorcentaje) <= 0) {
                            $this->db->set('pares', $PARES_TRABAJADOS)->set('salario', $SUELDO_FINAL_DESTAJO)
                                    ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                    ->where('numemp', $v->Numero)->update('prenominal');
                        } else
                        if (intval($v->FijoDestajoAmbos) === 2 && floatval($v->CelulaPorcentaje) >= 0) {
                            $this->db->set('pares', $PARES_TRABAJADOS)
                                    ->set('salario', 0)
                                    ->set('salariod', $SUELDO_FINAL_DESTAJO)
                                    ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                    ->where('numemp', $v->Numero)->update('prenominal');
                        } else
                        if (intval($v->FijoDestajoAmbos) === 3 && floatval($v->CelulaPorcentaje) <= 0) {
                            $this->db->set('pares', $PARES_TRABAJADOS)->set('salario', $SUELDO_FINAL_DESTAJO)
                                    ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                    ->where('numemp', $v->Numero)->update('prenominal');
                            $this->db->set('pares', $PARES_TRABAJADOS)
                                    ->set('salariod', $SUELDO_FINAL_DESTAJO)
                                    ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                    ->where('numemp', $v->Numero)->update('prenominal');
                        }
                    } else {
                        if (intval($v->FijoDestajoAmbos) === 1) {
                            $this->db->insert('prenominal', array(
                                "pares" => $PARES_TRABAJADOS,
                                "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                                "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                                "salario" => $SUELDO_FINAL_DESTAJO, "depto" => $v->DepartamentoFisico,
                                "status" => 1, "tpomov" => 0
                            ));
                        }
                        if (intval($v->FijoDestajoAmbos) === 2) {
                            $this->db->insert('prenominal', array(
                                "pares" => $PARES_TRABAJADOS,
                                "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                                "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                                "salariod" => $SUELDO_FINAL_DESTAJO, "depto" => $v->DepartamentoFisico,
                                "status" => 1, "tpomov" => 0
                            ));
                        }
                        if (intval($v->FijoDestajoAmbos) === 3) {
                            $this->db->insert('prenominal', array(
                                "pares" => $PARES_TRABAJADOS,
                                "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                                "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                                "salariod" => $SUELDO_FINAL_DESTAJO, "depto" => $v->DepartamentoFisico,
                                "status" => 1, "tpomov" => 0
                            ));
                        }
                    }
                } else
                if ($FijoDestajoAmbos === 3 && intval($ASISTENCIAS) > 0) {
                    /* 3 FIJO Y DESTAJO */
                    /* 3.0 FIJO */
                    $SUELDO_FINAL = 0;
                    $SUELDO_FINAL = $v->Sueldo * intval($ASISTENCIAS);
                    /* 3.1 INSERT PARA EL CONCEPTO 1 = SALARIO (FIJO) */
                    $EXISTE_EN_PRENOMINA = $this->onExisteEnPrenomina($x['ANIO'], $x['SEMANA'], $v->Numero, 1);
                    if (empty($EXISTE_EN_PRENOMINA)) {
                        $this->db->insert('prenomina', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "numcon" => 1 /* 1 SALARIO */, "tpcon" => 1 /* PERCEPCION */,
                            "tpcond" => 0 /* DEDUCCION */, "importe" => $SUELDO_FINAL,
                            "imported" => 0, "fecha" => Date('Y-m-d 00:00:00'),
                            "registro" => 0, "status" => 1, "tpomov" => 0,
                            "depto" => $v->DepartamentoFisico
                        ));
                    }
                    /* 3.2 INSERT PARA EL CONCEPTO 1 = SALARIO (FIJO) EN PRENOMINAL */
//                    $EXISTE_EN_PRENOMINAL = $this->onExisteEnPrenominaL($x['ANIO'], $x['SEMANA'], $v->Numero);
                    $EXISTE_EN_PRENOMINAL = $this->db->query("SELECT PNL.* FROM prenominal AS PNL WHERE PNL.año = {$x['ANIO']} AND PNL.numsem = {$x['SEMANA']} AND PNL.numemp = {$v->Numero} ")->result();

                    if (!empty($EXISTE_EN_PRENOMINAL)) {
                        $this->db->set('pares', 0)->set('salario', $SUELDO_FINAL)
                                ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                ->where('numemp', $v->Numero)->update('prenominal');
                    } else {
                        $this->db->insert('prenominal', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "salario" => $SUELDO_FINAL, "depto" => $v->DepartamentoFisico,
                            "status" => 1, "tpomov" => 0
                        ));
                    }
                    /* 3.3 INSERT PARA EL CONCEPTO 5 = SALARIO DESTAJO */
                    $SUELDO_DESTAJO = $this->db->query("SELECT CASE WHEN SUM(subtot) IS NULL THEN 0 ELSE SUM(subtot) END AS SUBTOTAL FROM fracpagnomina AS FPN WHERE FPN.numeroempleado ={$v->Numero} AND FPN.anio = {$x['ANIO']} AND FPN.semana = {$x['SEMANA']}")->result();

                    /* 3.4 VERIFICAR QUE EL SUELDO_DESTAJO SEA IGUAL A CERO Y REVISAR SI LA CELULA TIENE ALGUN PORCENTAJE  */
                    $SUELDO_FINAL_DESTAJO = 0;
                    if (intval($SUELDO_DESTAJO[0]->SUBTOTAL) === 0 && floatval($v->CelulaPorcentaje) > 0) {
                        /* 3.4.1 SI EL EMPLEADO NO TIENE MOVIMIENTOS EN FRACPAGNOM
                         * Y TIENE UN PORCENTAJE PERTENECE A UNA CELULA,
                         * PARA SABER CUAL CELULA ES EN LA QUE ESTA TRABAJANDO,
                         * OBTENGO SU DEPTO FISICO, BUSCO EL EMPLEADO POR ESTE DEPTO FISICO Y POR LA COINCIDENCIA DE BUSQUEDA "CELULA",
                         * OBTENIENDO DE ESTA FORMA EL DEPTO DE LA CELULA Y EL NUMERO DEL EMPLEADO CON EL CUAL INGRESAN LAS FRACCIONES */
                        $CELULA = $this->db->query("SELECT E.Numero AS NUMERO, E.DepartamentoFisico AS DEPTOCEL FROM empleados AS E WHERE E.DepartamentoFisico ={$v->DepartamentoFisico} AND E.Busqueda LIKE '%CELULA%'")->result();
                        /* 3.4.2  UNA VEZ OBTENIDO EL DEPTO DE LA CELULA Y EL NUMERO,
                         *  SE BUSCA EN FRACPAGNOMINA PARA SABER EL TOTAL GENERAL */
                        if (!empty($CELULA)) {
                            $SUELDO_DESTAJO = $this->db->query("SELECT SUM(subtot) AS SUBTOTAL FROM fracpagnomina AS FPN WHERE FPN.numeroempleado ={$CELULA[0]->NUMERO} AND FPN.anio ={$x['ANIO']} AND FPN.semana ={$x['SEMANA']}")->result();
                        } else {
                            $SUELDO_FINAL_DESTAJO = 0;
                            /* ES POSIBLE QUE ESTE EMPLEADO ESTE POR CELULA PERO NO HAYA HECHO AUN NADA O JAMAS SE PRESENTO A LABORAR */
                        }
                        /* 3.4.3  FINALMENTE EL SUBTOTAL GENERADO POR ESA CELULA
                         * SE MULTIPLICA POR EL PORCENTAJE DEL EMPLEADO */
                        $SUELDO_FINAL_DESTAJO = $SUELDO_DESTAJO[0]->SUBTOTAL * $v->CelulaPorcentaje;
                    } else {
                        /* 3.5 EL SUELDO FINAL CORRESPONDE AL SUBTOTAL DE FRACPAGNOMINA,
                         * EN CASO DE NO PERTENECER A NINGUNA CELULA SOLO SE LE PAGA LO QUE HIZO
                         * Y REGISTRO DENTRO DEL SISTEMA */
                        $SUELDO_FINAL_DESTAJO = $SUELDO_DESTAJO[0]->SUBTOTAL;
                    }

                    /* 3.6 INSERT PARA EL CONCEPTO 5 = SALARIO DESTAJO */
                    $EXISTE_EN_PRENOMINA = $this->onExisteEnPrenomina($x['ANIO'], $x['SEMANA'], $v->Numero, 5);
                    if (empty($EXISTE_EN_PRENOMINA)) {
                        $this->db->insert('prenomina', array(
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "numcon" => 5 /* 5 SALARIO DESTAJO */, "tpcon" => 1 /* PERCEPCION */,
                            "tpcond" => 0 /* DEDUCCION */, "importe" => $SUELDO_FINAL_DESTAJO,
                            "imported" => 0, "fecha" => Date('Y-m-d 00:00:00'),
                            "registro" => 0, "status" => 1, "tpomov" => 0,
                            "depto" => $v->DepartamentoFisico
                        ));
                    } else {
                        
                    }
                    /* 3.7 INSERT PARA EL CONCEPTO 5 = SALARIO (DESTAJO) EN PRENOMINAL */
//                    $EXISTE_EN_PRENOMINAL = $this->onExisteEnPrenominaL($x['ANIO'], $x['SEMANA'], $v->Numero);
                    $EXISTE_EN_PRENOMINAL = $this->db->query("SELECT PNL.* FROM prenominal AS PNL WHERE PNL.año = {$x['ANIO']} AND PNL.numsem = {$x['SEMANA']} AND PNL.numemp = {$v->Numero} ")->result();
                    if (!empty($EXISTE_EN_PRENOMINAL)) {
                        /* POR LO REGULAR SALEN LOS QUE ESTAN EN FIJODESTAJOAMBOS EN #3 */
                        $this->db->set('pares', 0)->set('salariod', $SUELDO_FINAL_DESTAJO)
                                ->where('año', $x['ANIO'])->where('numsem', $x['SEMANA'])
                                ->where('numemp', $v->Numero)->update('prenominal');
                    } else {
                        $this->db->insert('prenominal', array(
                            "pares" => 0,
                            "numsem" => $x['SEMANA'], "año" => $x['ANIO'],
                            "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                            "salariod" => $SUELDO_FINAL_DESTAJO, "depto" => $v->DepartamentoFisico,
                            "status" => 1, "tpomov" => 0
                        ));
                    }
                }

                $this->db->set('horext', 0)->set('otrper', 0)->set('otrper1', 0)->where('numsem', $x['SEMANA'])
                        ->where('año', $x['ANIO'])->where('numemp', $v->Numero)->update('prenominal');

                /* CALCULAR SI TIENE O NO CAJA DE AHORRO */
                $this->onCajaDeAhorro($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO INFONAVIT */
                $this->onInfonavit($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO COMIDAS */
                $this->onComida($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO FUNERAL */
                $this->onFuneral($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO IMSS */
                $this->onIMSS($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO FIERABONO */
                $this->onFieraBono($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO FONACOT */
                $this->onFonacot($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO ZAPATOS TIENDA/UNIFORMES */
                $this->onZapatosTienda($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO SALDO DE PRESTAMOS */
                $this->onAbonoPrestamo($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
                /* CALCULAR SI TIENE O NO ISR */
                $this->onISR($x['ANIO'], $x['SEMANA'], $v, $ASISTENCIAS);
            }
            /* 06/02/2020
             * 
             * 10 GRATIFICACION
             * 15 OTRAS PERCEPCIONES
             * 20 DIA FESTIVO
             * 100 OTRAS DED
             */
            $empleados_concepto_10_15_20_100 = $this->db->query("SELECT numemp,importe,imported,numcon FROM prenomina WHERE numsem = {$x['SEMANA']} AND año = {$x['ANIO']} AND numcon IN(10,15,20,100) AND importe > 0 AND registro = 999")->result();

            foreach ($empleados_concepto_10_15_20_100 as $k => $v) {
                switch (intval($v->numcon)) {
                    case 10:
                        $this->db->set('horext', $v->importe)->where('numemp', $v->numemp)
                                ->where('numsem', $x['SEMANA'])->where('año', $x['ANIO'])
                                ->where('status', 1)->update('prenominal');
                        break;
                    case 15:
                        $this->db->set('otrper', $v->importe)->where('numemp', $v->numemp)
                                ->where('numsem', $x['SEMANA'])->where('año', $x['ANIO'])
                                ->where('status', 1)->update('prenominal');
                        break;
                    case 20:
                        $this->db->set('otrper1', $v->importe)->where('numemp', $v->numemp)
                                ->where('numsem', $x['SEMANA'])->where('año', $x['ANIO'])
                                ->where('status', 1)->update('prenominal');
                        break;
                    case 100:
                        $this->db->set('otrde', $v->imported)->where('numemp', $v->numemp)
                                ->where('numsem', $x['SEMANA'])->where('año', $x['ANIO'])
                                ->where('status', 1)->update('prenominal');
                        break;
                }
            }
            $this->onRefrescarSaldoDePrestamos();
            /* ELMINA AL TERMINAR asdasd */

//            $this->db->where('semana', $x['SEMANA'])->where('anio', $x['ANIO'])->where('numeroempleado', 0)->delete('fracpagnomina');
//            $this->db->where('semana', $x['SEMANA'])->where('año', $x['ANIO'])->where('numemp', 0)->delete('fracpagnominatmp');

            /* OBTENER REPORTES */
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $p["SEMANA"] = $x['SEMANA'];
            $p["FECHAINI"] = $x['FECHAINI'];
            $p["FECHAFIN"] = $x['FECHAFIN'];
            $p["ANIO"] = $x['ANIO'];
            $jc->setParametros($p);
            $this->getReportes($jc);

            $this->db->query("DELETE FROM generando_nomina WHERE SEMANA = {$x['SEMANA']} AND ANIO = {$x['ANIO']}");
            $l = new Logs("GENERA NOMINA DE SEMANA", "GENERO LA NOMINA DE LA SEMANA {$x['SEMANA']} LA CUAL ESTA ABIERTA.", $this->session);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReportesNomina9998() {
        try {
            $reports = array();
            $this->benchmark->mark('code_start');

            /* OBTENER REPORTES */
            $x = $this->input->post();

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $p["semana"] = $x['SEMANA'];
            $p["anio"] = $x['ANIO'];
            $jc->setParametros($p);
            /* 1. REPORTE DE PRENOMINA COMPLETO */
            $jc->setJasperurl('jrxml\prenomina\PreNomVac.jasper');
            $jc->setFilename('PreNomVac_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();
            $this->benchmark->mark('code_end');

            $reports['8MARK_TIEMPO_TRANSCURRIDO'] = $this->benchmark->elapsed_time('code_start', 'code_end');
//            echo $this->benchmark->elapsed_time('code_start', 'code_end');
            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCajaDeAhorro($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Ahorro) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 70 /* 70 CAJADEAHORRO */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->Ahorro, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));
//                ID, numsem, año, numemp, cajhao
                $this->db->set('cajhao', $v->Ahorro)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            } else {
                $this->db->set('cajhao', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onInfonavit($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Infonavit) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 50 /* 1 SALARIO */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->Infonavit, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('infon', $v->Infonavit)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('infon', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComida($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Comida) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 80 /* 1 SALARIO */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->Comida, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));
                $this->db->set('zapper', $v->Comida)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            } else {
                $this->db->set('zapper', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onFuneral($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Funeral) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 85 /* 85 FUNERAL */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->Funeral, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('fune', $v->Funeral)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            } else {
                $this->db->set('fune', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onIMSS($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->IMSS) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 55 /* 55 IMSS */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->IMSS, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('imss', $v->IMSS)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('imss', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onFieraBono($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Fierabono) > 0) {
                $importe_fierabono = (floatval($v->Fierabono) / intval($v->FieraBonoPagos));
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 60 /* 60 FIERABONO */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $importe_fierabono, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('fierabono', $importe_fierabono)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('fierabono', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onFonacot($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->Fonacot) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 95 /* 95 FONACOT */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->Fonacot, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('fonac', $v->Fonacot)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('fonac', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onISR($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->ISR) > 0) {
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 82 /* 82 ISR */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $v->ISR, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));

                $this->db->set('impu', $v->ISR)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('impu', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onZapatosTienda($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            /* 75	VENTA ZAPATOS */
            $CONCEPTO_VTA_ZAP_EXISTE = $this->db->query("SELECT COUNT(*) AS EXISTE FROM prenomina AS P "
                            . "WHERE P.numsem = {$SEM} AND P.año = {$ANIO} "
                            . "AND P.numemp = {$v->Numero} AND P.numcon = 75")->result();
            if (intval($CONCEPTO_VTA_ZAP_EXISTE[0]->EXISTE) > 0) {
                $CONCEPTO_VTA_ZAP = $this->db->query("SELECT P.imported AS IMPORTE FROM prenomina AS P "
                                . "WHERE P.numsem = {$SEM} AND P.año = {$ANIO} "
                                . "AND P.numemp = {$v->Numero} "
                                . "AND P.numcon = 75")->result();
                $this->db->set('vtazap', $CONCEPTO_VTA_ZAP[0]->IMPORTE)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            } else {
                $this->db->set('vtazap', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)
                        ->update('prenominal');
            }
            /* 76	ZAPATOS TIENDA */
            if (floatval($v->ZapatosTDA) > 0) {
                $importe_zapatostiendas = (floatval($v->ZapatosTDA) / intval($v->AbonoZap));
                $this->db->insert('prenomina', array(
                    "numsem" => $SEM, "año" => $ANIO,
                    "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                    "numcon" => 76 /* 76 UNIFORMES/TIENDAS */, "tpcon" => 0 /* 1 = PERCECION */,
                    "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                    "imported" => $importe_zapatostiendas, "fecha" => Date('Y-m-d 00:00:00'),
                    "registro" => 0, "status" => 1, "tpomov" => 0,
                    "depto" => $v->DepartamentoFisico
                ));
//                ID, numsem, año, numemp, diasemp, vtazap, zapper
                $this->db->set('otrde1', $importe_zapatostiendas)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            } else {
                $this->db->set('otrde1', 0)->where('numsem', $SEM)
                        ->where('año', $ANIO)->where('numemp', $v->Numero)->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAbonoPrestamo($ANIO, $SEM, $v, $ASISTENCIAS) {
        try {
            if (floatval($v->SaldoPres) > 0) {
                $SALDO_FINAL_PRESTAMO = 0;
                $ACUMULADO_DE_PRESTAMOS = $this->db->query("SELECT SUM(P.preemp) AS ACUMULADO FROM prestamos AS P WHERE P.numemp = {$v->Numero} AND YEAR(P.fechapre) = {$ANIO}", false)->result();
                $ACUMULADO_DE_PAGOS = $this->db->query("SELECT SUM(PP.Aboemp) AS ACUMULADO FROM prestamospag AS PP WHERE PP.numemp = {$v->Numero} AND PP.año = {$ANIO}", false)->result();
                if (!empty($ACUMULADO_DE_PRESTAMOS) && !empty($ACUMULADO_DE_PRESTAMOS)) {
                    if ($ACUMULADO_DE_PRESTAMOS[0]->ACUMULADO) {
                        $SALDO_FINAL_PRESTAMO = floatval($ACUMULADO_DE_PRESTAMOS[0]->ACUMULADO) - floatval($ACUMULADO_DE_PAGOS[0]->ACUMULADO);
                    }
                }
//                print "\n {$v->Numero} {$ACUMULADO_DE_PRESTAMOS[0]->ACUMULADO}, {$ACUMULADO_DE_PAGOS[0]->ACUMULADO}, $SALDO_FINAL_PRESTAMO \n";
                if (floatval($ACUMULADO_DE_PRESTAMOS[0]->ACUMULADO) >= floatval($ACUMULADO_DE_PAGOS[0]->ACUMULADO)) {
                    $this->db->insert('prestamospag', array(
                        "numemp" => $v->Numero, "año" => $ANIO, "sem" => $SEM, "fecha" => Date('Y-m-d 00:00:00'),
                        "preemp" => $v->PressAcum, "aboemp" => $v->{"AbonoPres"}, "saldoemp" => $SALDO_FINAL_PRESTAMO,
                        "interes" => 0, "status" => 1
                    ));
                    $this->db->insert('prenomina', array(
                        "numsem" => $SEM, "año" => $ANIO,
                        "numemp" => $v->Numero, "diasemp" => $ASISTENCIAS,
                        "numcon" => 65 /* 65 PRESTAMO C-AH */, "tpcon" => 0 /* 1 = PERCECION */,
                        "tpcond" => 2 /* 2 = DEDUCCION */, "importe" => 0,
                        "imported" => $v->{"AbonoPres"}, "fecha" => Date('Y-m-d 00:00:00'),
                        "registro" => 0, "status" => 1, "tpomov" => 0,
                        "depto" => $v->DepartamentoFisico
                    ));
                    $this->db->set('precaha', $v->{"AbonoPres"})->where('numsem', $SEM)
                            ->where('año', $ANIO)->where('numemp', $v->Numero)
                            ->update('prenominal');
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRefrescarSaldoDePrestamos() {
        try {
            $ANIO = Date('Y');
            $empleados = $this->db->query("SELECT E.Numero,E.SaldoPres  FROM empleados AS E WHERE E.AltaBaja = 1 AND E.SaldoPres > 0")->result();
            foreach ($empleados as $k => $v) {
                $ACUMULADO_DE_PRESTAMOS_Y_PAGOS = $this->db->query("SELECT  
(SELECT SUM(P.preemp) AS ACUMULADO FROM prestamos AS P WHERE P.numemp = {$v->Numero} AND YEAR(P.fechapre) = {$ANIO}) AS PRESTAMOS,   
(SELECT SUM(PP.Aboemp) AS ACUMULADO FROM prestamospag AS PP WHERE PP.numemp = {$v->Numero} AND PP.año = {$ANIO}) AS PAGOS", false)->result();

                $SALDO_PRESTAMOS = floatval($ACUMULADO_DE_PRESTAMOS_Y_PAGOS[0]->PRESTAMOS) - floatval($ACUMULADO_DE_PRESTAMOS_Y_PAGOS[0]->PAGOS);
                if (floatval($SALDO_PRESTAMOS) > 0 && floatval($v->SaldoPres) !== $SALDO_PRESTAMOS) {
                    $this->db->set("SaldoPres", (floatval($SALDO_PRESTAMOS) > 0 ? $SALDO_PRESTAMOS : 0))
                            ->where("Numero", $v->Numero)
                            ->update("empleados"); 
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onExisteEnPrenomina($ANIO, $SEMANA, $EMP, $TP) {
        try {
            return $this->db->query("SELECT PN.* FROM prenomina AS PN WHERE PN.año ={$ANIO} AND PN.numsem = {$SEMANA} AND PN.numemp = {$EMP} AND PN.numcon ={$TP}")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onExisteEnPrenominaL($ANIO, $SEMANA, $EMP) {
        try {
            return $this->db->query("SELECT PNL.* FROM prenominal AS PNL WHERE PNL.año = {$ANIO} AND PNL.numsem = {$SEMANA} AND PNL.numemp = {$EMP} ")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNominaCerrada() {
        try {
            $x = $this->input;
            $xxx = $this->input->post();
            $l = new Logs("GENERA NOMINA DE SEMANA", "GENERO LA NOMINA CERRADA DE LA SEMANA {$xxx['SEMANA']}.", $this->session);
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $jc->setParametros(array("logo" => base_url() . $this->session->LOGO,
                "empresa" => $this->session->EMPRESA_RAZON,
                "SEMANA" => $xxx['SEMANA'],
                "FECHAINI" => $xxx['FECHAINI'],
                "FECHAFIN" => $xxx['FECHAFIN'],
                "ANIO" => $xxx['ANIO']));
            $this->getReportes($jc);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReportes($jc) {
        try {
            $reports = array();
            $this->benchmark->mark('code_start');
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
//            $jc->setJasperurl('jrxml\prenomina\prenomfisbanamex.jasper');
//            $jc->setFilename('GenNomDeSemPreNomBanamex_' . Date('his'));
//            $jc->setDocumentformat('pdf');
//            $reports['7SIETE'] = $jc->getReport();

            $this->benchmark->mark('code_end');

            $reports['8MARK_TIEMPO_TRANSCURRIDO'] = $this->benchmark->elapsed_time('code_start', 'code_end');
//            echo $this->benchmark->elapsed_time('code_start', 'code_end');
            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVacaciones() {
        try {
            $x = $this->input;
            $xxx = $this->input->post();
            $SEMANA_VACACIONES = 99;
            $l = new Logs("GENERA NOMINA DE SEMANA - VACACIONES", "GENERO LAS VACACIONES DE LA SEMANA {$SEMANA_VACACIONES}, {$xxx["ANIO"]}.", $this->session);
            $anio_completo = 365;
            $treinta_dias = 30.41;
            $total_vacaciones = 0;
            $prima = 0;
            $dias_trabajados_pagados = 0;
            $S1 = intval($x->post('S1'));
            $S4 = intval($x->post('S4'));
            $sueldin = 0;

            /* 1 ELIMINAR TODO REGISTRO QUE YA TENGA LA SEMANA, AÑO EN PRENOMINA Y PRENOMINAL */
            $this->db->where('numsem', $SEMANA_VACACIONES)
                    ->where('año', $x->post('ANIO'))
                    ->where('status', 1)
                    ->where('registro <>', 999)
                    ->delete('prenomina');
            $this->db->where('numsem', $SEMANA_VACACIONES)
                    ->where('año', $x->post('ANIO'))
                    ->where('status', 1)
                    ->where('registro <>', 999)
                    ->delete('prenominal');

            /* 2 OBTENER LOS EMPLEADOS FIJOS */
//            DESCOMENTAR PARA PROBAR CON UN EMPLEADO EN ESPECIFICO
            $empleados = $this->db->select('E.*')->from('empleados AS E')
                            ->where('E.AltaBaja', 1)
                            ->where_not_in('E.DepartamentoFisico', array(470))
                            ->order_by('E.DepartamentoFisico', 'ASC')
                            ->order_by('E.Numero', 'ASC')
                            ->order_by('E.FijoDestajoAmbos', 'ASC')
                            ->get()->result();

//            $empleados = $this->db->select('E.*')->from('empleados AS E')
//                            ->where('E.AltaBaja', 1)
//                            ->where_in('E.Numero', array(3057, 3004, 3019))
//                            ->where_not_in('E.DepartamentoFisico', array(470))
//                            ->order_by('E.DepartamentoFisico', 'ASC')
//                            ->order_by('E.Numero', 'ASC')
//                            ->order_by('E.FijoDestajoAmbos', 'ASC')
//                            ->get()->result(); 
            /* 3 ITERAR LOS EMPLEADOS A VALIDAR */
            foreach ($empleados as $k => $v) {
                $sueldin = $v->Sueldo; /* SUELDO DIARIO */
                $fecha = Date('Y-m-d'); /**/
                $dias = $this->db->select("DATEDIFF(DATE_FORMAT("
                                        . "str_to_date(\"{$x->post('FECHACORTE')}\",\"%d/%m/%Y\"),\"%Y-%m-%d\"), "
                                        . "DATE_FORMAT(E.FechaIngreso,\"%Y-%m-%d\")) AS DIAS", false)
                                ->from("empleados AS E")
                                ->where("E.Numero", $v->Numero)
                                ->where('E.AltaBaja', 1)
                                ->get()->result();
                $dias_trabajados = intval($dias[0]->DIAS);
                print "\n DIAS : $dias_trabajados \n";
                if ($dias_trabajados >= $anio_completo) {
                    $anios = intval(($dias_trabajados / $anio_completo));
                    print "\n" . ($dias_trabajados / $anio_completo) . "\n años : $anios \n";
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
                    $anios = intval($dias_trabajados / $treinta_dias);
                    print "\n {$v->Numero} MESES: $anios \n";
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
//                                PRINT "\n {$v->Numero} {$v->FijoDestajoAmbos} SUELDO: {$SUELDO_CUATRO_SEM[0]->SUBTOTAL} \n";
                if (intval($v->FijoDestajoAmbos) === 1) {
                    /* EMPLEADOS FIJOS */
                }
                if (intval($v->FijoDestajoAmbos) === 2 && $dias_trabajados >= 31) {
                    /* EMPLEADOS POR DESTAJO */
                    if (!empty($SUELDO_CUATRO_SEM) && $S1 !== '' && $S4 !== '') {
                        /* 1 OBTENEMOS LO QUE HIZO EL EMPLEADO DURANTE LAS SEMANAS ESPECIFICADAS */
                        $SUELDO_CUATRO_SEM = $this->db->query("SELECT SUM(P.importe) AS SUELDIN FROM prenomina AS P WHERE P.numemp = {$v->Numero} AND P.numsem BETWEEN {$S1} AND {$S4} AND P.año= {$xxx['ANIO']} AND P.numcon = 5 AND  P.status = 2;")->result();
                        /* 2 SE DIVIDE ENTRE 4 Y SE SACA EL SALARIO DIARIO POR DIA */
                        $SUELDO_CUATRO_SEM_FINAL = $SUELDO_CUATRO_SEM[0]->SUELDIN / 4;
                        print "\n SUELDO : " . $SUELDO_CUATRO_SEM[0]->SUELDIN;
                        /* 3. SE HACE EL CALCULO DE SUELDO DIARIO POR DIASTRABAJADOS */
                        $SUELDO_CUATRO_SEM_FINAL_POR_DIA = $SUELDO_CUATRO_SEM_FINAL / 7;
                        $sueldin = $SUELDO_CUATRO_SEM_FINAL_POR_DIA;
                        /* 4. SE ASIGNA EL RESULTADO AL SUELDO FINAL A PAGAR POR CONCEPTO 25 VACACIONES */
                        $total_vacaciones = $SUELDO_CUATRO_SEM_FINAL_POR_DIA * $dias_trabajados_pagados;
                    }
                }
                if (intval($v->FijoDestajoAmbos) === 3 && $dias_trabajados >= 31) {
                    /* EMPLEADOS FIJOS Y POR DESTAJO */
                    if (!empty($SUELDO_CUATRO_SEM) && $S1 !== '' && $S4 !== '') {
                        $SUELDO_FIJO_DESTAJO = 0;

                        /* 1 OBTENEMOS LO QUE HIZO EL EMPLEADO DURANTE LAS SEMANAS ESPECIFICADAS */
                        $SUELDO_CUATRO_SEM = $this->db->query("SELECT SUM(P.importe) AS SUELDIN FROM prenomina AS P WHERE P.numemp = {$v->Numero} AND P.numsem BETWEEN {$S1} AND {$S4} AND P.año= {$xxx['ANIO']} AND P.numcon = 5 AND  P.status = 2;")->result();
                        /* 2 SE DIVIDE ENTRE 4 Y SE SACA EL SALARIO DIARIO POR DIA */
                        $SUELDO_CUATRO_SEM_FINAL = $SUELDO_CUATRO_SEM[0]->SUELDIN / 4;
                        print "\n SUELDO : " . $SUELDO_CUATRO_SEM[0]->SUELDIN;
                        /* 3. SE HACE EL CALCULO DE SUELDO DIARIO POR DIASTRABAJADOS */
                        $SUELDO_CUATRO_SEM_FINAL_POR_DIA = $SUELDO_CUATRO_SEM_FINAL / 7;
                        $SUELDO_FIJO_DESTAJO = $SUELDO_CUATRO_SEM_FINAL_POR_DIA;


                        /* 4. SE ASIGNA EL RESULTADO AL SUELDO FINAL A PAGAR POR CONCEPTO 25 VACACIONES */
                        $total_vacaciones = $SUELDO_CUATRO_SEM_FINAL_POR_DIA * $dias_trabajados_pagados;
                        $sueldin = $SUELDO_FIJO_DESTAJO;

                        $SUELDO_FIJO = $v->Sueldo;
                        $sueldin += $SUELDO_FIJO;
                        $SUELDO_FIJO = $SUELDO_FIJO * $dias_trabajados_pagados;
                        $total_vacaciones += $SUELDO_FIJO;
                    }
                }

                if ($dias_trabajados >= 31 && floatval($sueldin) > 0) {

                    // if (intval($v->Numero) === 2805) {/*PARA EFECTO DE PRUEBAS*/
                    $prima = $total_vacaciones * 0.25;
                    /* GRABAR VACACIONES */
                    $vp = array(
                        "numsem" => $SEMANA_VACACIONES,
                        "año" => $x->post('ANIO'),
                        "numemp" => $v->Numero,
                        "diasemp" => $dias_trabajados_pagados,
                        "numcon" => 25 /* 25 CONCEPTOS DE NOMINA */,
                        "tpcon" => 1,
                        "tpcond" => 0,
                        "importe" => $total_vacaciones,
                        "imported" => $sueldin,
                        "fecha" => Date('Y-m-d 00:00:00'),
                        "registro" => 0,
                        "status" => 1,
                        "tpomov" => 0,
                        "depto" => $v->DepartamentoFisico
                    );

                    $this->db->insert('prenomina', $vp);
//                    print $this->db->last_query() . "\n";
                    /* GRABA PRE-NOMINA-L */
                    $pnl = array(
                        "numsem" => $SEMANA_VACACIONES,
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
//                    print $this->db->last_query() . "\n";

                    /* GRABA PRIMA-VACACIONAL */
                    $vp["numcon"] = 26;
                    $vp["importe"] = $total_vacaciones * 0.25;
                    $vp["imported"] = 0;
                    $this->db->insert('prenomina', $vp);
                    //}/*PARA EFECTO DE PRUEBAS*/
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAguinaldos() {
        try {
            $x = $this->input;

            $S1 = intval($x->post('S1'));
            $S4 = intval($x->post('S4'));
            /* 1 ELIMINAR REGISTROS EN PRENOMINA Y PRENOMINAL DE LA SEMANA Y AÑO ESPECIFICADO */
            $this->db->where('numsem', $x->post('SEMANA'))
                    ->where('año', $x->post('ANIO'))
                    ->delete('prenomina');
            $this->db->where('numsem', $x->post('SEMANA'))
                    ->where('año', $x->post('ANIO'))
                    ->delete('prenominal');

            /* 2 OBTENER LOS EMPLEADOS FIJOS */
            $empleados = $this->db->select("E.*, DATEDIFF(DATE_FORMAT("
                                    . "str_to_date(\"{$x->post('FECHACORTE')}\",\"%d/%m/%Y\"),\"%Y-%m-%d\"), "
                                    . "DATE_FORMAT(E.FechaIngreso,\"%Y-%m-%d\")) AS DIASFC ", false)
                            ->from('empleados AS E')
                            ->where('E.AltaBaja', 1)
                            ->order_by('E.DepartamentoFisico', 'ASC')
                            ->order_by('E.Numero', 'ASC')
                            ->order_by('E.FijoDestajoAmbos', 'ASC')
                            ->get()->result();
            $it = 0;
            $ita = 0;
            $dias = 15;
            $dias_a_pagar = 0;
            $total_aguinaldo = 0;
            $SUELDO_FINAL = 0;
            foreach ($empleados as $k => $v) {
                $SUELDO_FINAL = $v->Sueldo;
                $it += 1;
                /* VALIDAR EL TIPO DE SALARIO 1 = (FIJO), 2 (DESTAJO) y 3 (FIJO-DESTAJO) */
                if (intval($v->DepartamentoFisico) === 1) {
                    /* 1 SI EL EMPLEADO TIENE MAS DE 365 O IGUAL SE LE PAGAN 15 DIAS DE SALARIO */
                    if (intval($v->DIASFC) >= 365) {
                        $ita += 1;
                        $total_aguinaldo = $SUELDO_FINAL * $dias;
                        $dias_a_pagar = $dias;
                    } else {
                        /* 2. SI EL EMPLEADO TIENE MENOS DE 365 DIAS SE LE CALCULA */
                        $dias_x_quince = intval($v->DIASFC) * $dias;
                        $dias_a_pagar = $dias_x_quince / 365;
                        $total_aguinaldo = $SUELDO_FINAL * $dias_a_pagar;
                    }
                } else if (intval($v->DepartamentoFisico) === 2) {
                    /* CALCULAR EL SALARIO DE LAS ULTIMAS CUATRO SEMANAS */
                    $SUELDO_CUATRO_SEM = $this->db->select("((SUM(importe)/4)/7) AS SUBTOTAL", false)->from('fracpagnomina AS FPN')
                                    ->where("FPN.numeroempleado", $v->Numero)
                                    ->where("FPN.anio", $x->post('ANIO'))
                                    ->where("FPN.semana BETWEEN {$S1} AND {$S4}", null, false)
                                    ->get()->result();
                    $SUELDO_FINAL = $SUELDO_CUATRO_SEM[0]->SUBTOTAL;
                    if (intval($v->DIASFC) >= 365) {
                        $ita += 1;
                        $total_aguinaldo = $SUELDO_FINAL * $dias;
                        $dias_a_pagar = $dias;
                    } else {
                        /* 2. SI EL EMPLEADO TIENE MENOS DE 365 DIAS SE LE CALCULA */
                        $dias_x_quince = intval($v->DIASFC) * $dias;
                        $dias_a_pagar = $dias_x_quince / 365;
                        $total_aguinaldo = $SUELDO_FINAL * $dias_a_pagar;
                    }
                } else if (intval($v->DepartamentoFisico) === 3) {
                    /* PROCESAR POR FIJO */
                    $SUELDO_FIJO_FINAL = $v->Sueldo;
                    if (intval($v->DIASFC) >= 365) {
                        $total_aguinaldo = $SUELDO_FIJO_FINAL * $dias;
                        $dias_a_pagar = $dias;
                    } else {
                        /* 2. SI EL EMPLEADO TIENE MENOS DE 365 DIAS SE LE CALCULA */
                        $dias_x_quince = intval($v->DIASFC) * $dias;
                        $dias_a_pagar = $dias_x_quince / 365;
                        $total_aguinaldo = $SUELDO_FIJO_FINAL * $dias_a_pagar;
                    }
                    /* PROCESAR POR DESTAJO */
                    $SUELDO_CUATRO_SEM = $this->db->select("((SUM(importe)/4)/7) AS SUBTOTAL", false)->from('fracpagnomina AS FPN')
                                    ->where("FPN.numeroempleado", $v->Numero)
                                    ->where("FPN.anio", $x->post('ANIO'))
                                    ->where("FPN.semana BETWEEN {$S1} AND {$S4}", null, false)
                                    ->get()->result();
                    $SUELDO_FINAL = $SUELDO_CUATRO_SEM[0]->SUBTOTAL;
                    if (intval($v->DIASFC) >= 365) {
                        $ita += 1;
                        $total_aguinaldo = $total_aguinaldo + ($SUELDO_FINAL * $dias);
                        $dias_a_pagar = $dias;
                    } else {
                        /* 2. SI EL EMPLEADO TIENE MENOS DE 365 DIAS SE LE CALCULA */
                        $dias_x_quince = intval($v->DIASFC) * $dias;
                        $dias_a_pagar = $dias_x_quince / 365;
                        $total_aguinaldo = $total_aguinaldo + ($SUELDO_FINAL * $dias_a_pagar);
                    }
                }
                /* AGREGAR A PRENOMINA */
                $this->db->insert('prenomina', array("numsem" => $x->post('SEMANA'),
                    "año" => $x->post('ANIO'),
                    "numemp" => $v->Numero,
                    "diasemp" => $dias_a_pagar,
                    "numcon" => 27, "tpcon" => 1,
                    "importe" => $total_aguinaldo,
                    "imported" => $SUELDO_FINAL,
                    "fecha" => Date('Y-m-d 00:00:00'),
                    "status" => 1, "tpomov" => 0));
                /* AGREGAR A PRENOMINAL */
                $this->db->insert('prenominal', array(
                    "numsem" => $x->post('SEMANA'), "año" => $x->post('ANIO'),
                    "numemp" => $v->Numero, "salario" => $SUELDO_FINAL,
                    "otrper" => intval($v->DIASFC),
                    "horext" => $dias_a_pagar,
                    "pares" => 0, "status" => 1, "tpomov" => 0,
                    "otrper1" => $total_aguinaldo,
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAguinaldo($aguinaldo) {
        try {
            $this->db->insert('prenomina', array(
                "numsem" => $this->input->post('SEMANA'),
                "año" => $this->input->post('ANIO'),
                "numemp" => $aguinaldo["NUMERO"],
                "diasemp" => $aguinaldo["DIAS"],
                "numemp" => $aguinaldo["NUMERO"],
                "numemp" => $aguinaldo["NUMERO"],
                "numemp" => $aguinaldo["NUMERO"],
                "numemp" => $aguinaldo["NUMERO"]));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarMovimientos() {
        try {
            $x = $this->input->post();
            $SEM = $x['SEMANA'];
            $AÑO = $x['ANIO'];
            $this->db->trans_start();
            $this->db->query("DELETE FROM prenomina WHERE semana = {$SEM} AND año = {$AÑO} AND tpomov = 0")->result();
            $this->db->query("UPDATE prenominal SET precaha = 0 WHERE semana = {$SEM} AND año = {$AÑO} AND tpomov = 0")->result();
            $this->db->query("DELETE FROM fracpagnominatmp WHERE semana = {$SEM} AND año = {$AÑO}")->result();
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onNominaPreliminaresPespunte($ANIO, $SEM) {
        try {
            $query = "SELECT FPN.* FROM fracpagnomina AS FPN ";
            $query .= "WHERE FPN.anio = {$ANIO} AND FPN.semana = {$SEM} ";
            $query .= "AND FPN.numfrac BETWEEN 299 AND 300 ";
            $query .= "AND FPN.numeroempleado IN(899,994,995,996,997,998,999,1000,1001,1002)";
            $fraccion = 304; /* 304 = PRELIMINAR DE PESPUNTE, DEPTO: 120 = PREL-PESPUNTE */
            $fracciones = $this->db->query($query)->result();
            $celulas = array(
                899 => 101,
                994 => 107,
                995 => 101,
                996 => 101,
                997 => 101,
                998 => 101,
                999 => 101,
                1000 => 101,
                1001 => 101,
                1002 => 101
            );
            foreach ($fracciones as $k => $v) {
                if (array_key_exists(intval($v->numeroempleado), $celulas)) {
                    $CEL = $celulas[$v->numeroempleado];
                    $precio_fraccion = $this->db->query("SELECT  FXE.CostoMO, FXE.CostoVTA  FROM fraccionesxestilo AS FXE WHERE FXE.Estilo LIKE '{$v->estilo}' AND FXE.Fraccion = {$fraccion}")->result();
                    $subtotal = intval($v->pares) * floatval($precio_fraccion[0]->CostoMO);

                    $this->db->insert('fracpagnominatmp', array(
                        "numemp" => 0,
                        "nummaq" => $CEL,
                        "numcont" => $v->control,
                        "numest" => $v->estilo,
                        "numfrac" => $fraccion /* 304 */,
                        "prefrac" => $precio_fraccion[0]->CostoMO,
                        "pares" => $v->pares,
                        "subtot" => $subtotal,
                        "fecha" => $v->fecha,
                        "semana" => $v->semana,
                        "depto" => 120/* 120 = PREL-PESPUNTE */,
                        "registro" => 0,
                        "año" => $v->anio
                    ));

                    $this->db->insert('fracpagnomina', array(
                        "numeroempleado" => 0,
                        "maquila" => $CEL,
                        "control" => $v->control,
                        "estilo" => $v->estilo,
                        "numfrac" => $fraccion /* 304 */,
                        "preciofrac" => $precio_fraccion[0]->CostoMO,
                        "pares" => $v->pares,
                        "subtot" => $subtotal,
                        "fecha" => $v->fecha,
                        "semana" => $v->semana,
                        "depto" => 120/* 120 = PREL-PESPUNTE */,
                        "registro" => 0,
                        "anio" => $v->anio,
                        "fraccion" => 304
                    ));
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrenominaExcel() {
        $xxx = $this->input->post();
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array(
            "empresa" => $this->session->EMPRESA_RAZON,
            "SEMANA" => $xxx['SEMANA'],
            "FECHAINI" => $xxx['FECHAINI'],
            "FECHAFIN" => $xxx['FECHAFIN'],
            "ANIO" => $xxx['ANIO']);
        $jc->setParametros($parametros);

        //Imprimimos el reporte
        $jc->setJasperurl('jrxml\prenomina\excel\excel_prenoml.jasper');
        $jc->setFilename('PRENOMINA_EXCEL_SEM_' . $xxx['SEMANA'] . '_' . Date('h_i_s'));
        $jc->setDocumentformat('xls');
        print $jc->getReport();
    }

    public function getSemanaNominaX() {
        try {
            $ANO = Date('Y');
            print json_encode($this->db->query("SELECT P.numsem AS SEMANA FROM prenomina AS P "
                                    . "WHERE P.año = {$ANO} AND P.numsem <= 52 AND P.status = 2 "
                                    . "ORDER BY P.numsem DESC, P.año DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
