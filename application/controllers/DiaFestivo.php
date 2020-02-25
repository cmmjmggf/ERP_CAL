<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DiaFestivo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('DiaFestivo_model', 'dfm');
    }

    public function getSemanaNomina() {
        try {
//            print json_encode($this->dfm->getSemanaNomina($this->input->get('FECHA')));
            print json_encode($this->db->select("S.Sem AS SEMANA, S.FechaIni AS FECHAINI, S.FechaFin AS FECHAFIN", false)
                            ->from('semanasnomina AS S')
                            ->where("STR_TO_DATE(\"{$this->input->get('FECHA')}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                            ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAnadirDiaFestivo() {
        try {
            /*
             * conceptosnomina 
             * 20 = DIA FESTIVO
             * 
             */
            $x = $this->input;
            $SALARIODIA = 999999;
            $ANIO = $x->post('ANIO');
            $SEMANA = $x->post('SEMANA');
            $FECHA_INICIAL = $x->post('FECHA_INICIAL');
            $FECHA_FINAL = $x->post('FECHA_FINAL');
            $this->db->query("DELETE FROM prenomina where numsem = {$SEMANA} AND año = {$ANIO}  AND numcon = 20 AND registro = 999;");
            $prenomina = $this->db->query("SELECT PN.* FROM prenomina AS PN "
                            . "WHERE PN.numsem = {$SEMANA} AND PN.año = {$ANIO}")->result();

            /* 150 = TEJIDO (DESCARTADO) */
            $SQL = "SELECT ";
            $SQL .= "E.Numero AS NUMERO_EMPLEADO,";
            $SQL .= "E.FijoDestajoAmbos AS FIJO_DESTAJO_AMBOS,";
            $SQL .= "E.DepartamentoFisico AS DEPTO, E.Sueldo AS SUELDO ";
            $SQL .= "FROM empleados AS E WHERE E.AltaBaja = 1 AND E.DepartamentoFisico <> 150 AND ";
            /* 1 OBTENER LOS EMPLEADOS FIJOS */
            $empleados_fijos = $this->db->query("{$SQL}E.FijoDestajoAmbos = 1")->result();
            /* 1.1 AÑADIR DIA FESTIVO A EMPLEADOS FIJOS */
            foreach ($empleados_fijos as $k => $v) {
                $pn = array();
                $pn['numsem'] = $SEMANA;
                $pn['año'] = $ANIO;
                $pn['numemp'] = $v->NUMERO_EMPLEADO;
                $pn['diasemp'] = 0;
                $pn['numcon'] = 20/* DIA FESTIVO */;
                $pn['tpcon'] = 1;
                $pn['tpcond'] = 0;
                $pn['importe'] = $v->SUELDO;
                $pn['imported'] = 0;
                $pn['fecha'] = Date('Y-m-d 00:00:00');
                $pn['registro'] = 999;
                $pn['status'] = 1;
                $pn['tpomov'] = 1;
                $pn['depto'] = $v->DEPTO;
                $this->db->insert('prenomina', $pn);
                /* MODIFICA EN PRENOMINAL OTRAS */
                $this->db->set('otrper1', $v->SUELDO)->where('numsem', $SEMANA)
                        ->where('año', $ANIO)->where('numemp', $v->NUMERO_EMPLEADO)
                        ->update('prenominal');
            }

            /* 2 OBTENER LOS EMPLEADOS POR DESTAJOS */
            $empleados_destajos = $this->db->query("{$SQL}E.FijoDestajoAmbos = 2")->result();
            /* 2.1 AÑADIR DIA FESTIVO A EMPLEADOS POR DESTAJO */
            foreach ($empleados_destajos as $k => $v) {
                /* 2.2 CALCULAR EL SUELDO DIARIO A PAGAR */
                $sueldin = $this->db->select('SUM(FPN.subtot) AS SUELDIN', false)->from('fracpagnomina AS FPN')
                                ->where('FPN.numeroempleado', $v->NUMERO_EMPLEADO)
                                ->where('FPN.semana', $SEMANA)
                                ->where('FPN.anio', $ANIO)->get()->result();
                $pn = array();
                $pn['numsem'] = $SEMANA;
                $pn['año'] = $ANIO;
                $pn['numemp'] = $v->NUMERO_EMPLEADO;
                $pn['diasemp'] = 0;
                $pn['numcon'] = 20/* DIA FESTIVO */;
                $pn['tpcon'] = 1;
                $pn['tpcond'] = 0;
                $pn['importe'] = ($SUELDO_FINAL_DESTAJO * 0.10);
                $pn['imported'] = 0;
                $pn['fecha'] = Date('Y-m-d 00:00:00');
                $pn['registro'] = 999;
                $pn['status'] = 1;
                $pn['tpomov'] = 1;
                $pn['depto'] = $v->DEPTO;
                $this->db->insert('prenomina', $pn);
                /* MODIFICA EN PRENOMINAL OTRAS */
                $this->db->set('otrper1', ($SUELDO_FINAL_DESTAJO * 0.10))->where('numsem', $SEMANA)
                        ->where('año', $ANIO)->where('numemp', $v->NUMERO_EMPLEADO)
                        ->update('prenominal');
            }

            /* 3 OBTENER LOS EMPLEADOS FIJOS Y POR DESTAJOS */
            $empleados_fijos_destajos = $this->db->query("{$SQL}E.FijoDestajoAmbos = 3")->result();
            /* 3.1 AÑADIR DIA FESTIVO A EMPLEADOS FIJOS Y POR DESTAJO */
            foreach ($empleados_fijos_destajos as $k => $v) {
                /* 3.2 OBTENER EL SUELDO FIJO */
                $SUELDIN = floatval($v->SUELDO);
                /* 3.3 CALCULAR EL SUELDO DIARIO A PAGAR POR DESTAJO */
                $SUELDIN_FRACCION = $this->db->select('SUM(FPN.subtot) AS SUELDIN', false)->from('fracpagnomina AS FPN')
                                ->where('FPN.numeroempleado', $v->NUMERO_EMPLEADO)
                                ->where('FPN.semana', $SEMANA)
                                ->where('FPN.anio', $ANIO)->get()->result();
                $SUELDIN_FINAL = $SUELDIN + (floatval($SUELDIN_FRACCION[0]->SUELDIN) * 0.1);
                $pn = array();
                $pn['numsem'] = $SEMANA;
                $pn['año'] = $ANIO;
                $pn['numemp'] = $v->NUMERO_EMPLEADO;
                $pn['diasemp'] = 0;
                $pn['numcon'] = 20/* DIA FESTIVO */;
                $pn['tpcon'] = 1;
                $pn['tpcond'] = 0;
                $pn['importe'] = $SUELDIN_FINAL;
                $pn['imported'] = 0;
                $pn['fecha'] = Date('Y-m-d 00:00:00');
                $pn['registro'] = 999;
                $pn['status'] = 1;
                $pn['tpomov'] = 1;
                $pn['depto'] = $v->DEPTO;
                $this->db->insert('prenomina', $pn);
                /* MODIFICA EN PRENOMINAL OTRAS PERCEPCIONES */
                $this->db->set('otrper1', $SUELDIN_FINAL)->where('numsem', $SEMANA)
                        ->where('año', $ANIO)->where('numemp', $v->NUMERO_EMPLEADO)
                        ->update('prenominal');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanaNomina() {
        try {
            $S = $this->input->get('SEMANA');
            $A = $this->input->get('ANO');
            print json_encode($this->db->select("G.Sem")->from("semanasnomina AS G")
                                    ->where("G.Sem", $S)
                                    ->where("G.Ano", $A)
                                    ->where("G.Estatus", "ACTIVO")->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaNominaCerrada() {
        try {
            $x = $this->input;
            print json_encode($this->db->select("PM.status AS ESTATUS")
                                    ->from('prenomina PM')
                                    ->where('PM.numsem', $x->get('SEMANA'))
                                    ->where('PM.año', $x->get('SEMANA'))
                                    ->group_by('PM.numsem')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
