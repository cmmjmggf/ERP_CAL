<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesNominaJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onImprimirEtiquetasLockers() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["depto"] = $this->input->get('Depto');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteEtiquetasLockers.jasper');
        $jc->setFilename('ETIQUETAS_LOCKERS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirValeZapTda() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["empleado"] = $this->input->get('Empleado');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\valeZapatosTdas.jasper');
        $jc->setFilename('VALE_ZAPATOS_TIENDAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirAsistenciasF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoAsistenciaF');
        $parametros["sem"] = $this->input->post('SemAsistenciaF');
        $parametros["empleado"] = $this->input->post('EmpleadoAsistenciaF');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\asistencias\asistenciasRelojChecadorF.jasper');
        $jc->setFilename('ASISTENCIAS_RELOJ_CHECADOR_F_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirAsistencias() {
        $x = $this->input;
        $sem = $x->post('SemAsistencia');
        $ano = $x->post('AnoAsistencia');
        $depto = $this->input->post('DeptoAsistencia');

        /* Limpiamos la tabla temporal */
        $this->db->query('truncate table relojchecadortemp');

        $query = "select
                    str_to_date(FechaIni,'%d/%m/%Y') as fec1,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 1 DAY) as fec2,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 2 DAY) as fec3,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 3 DAY) as fec4,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 4 DAY) as fec5,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 5 DAY) as fec6,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 6 DAY) as fec7
                    from semanasnomina where Sem = '$sem' and Ano = '$ano' ";
        $Semanas = $this->db->query($query)->result();

        /* Trameos los registros actuales del reloj checador */
        $query2 = "select
                cast(ifnull(D.Clave,'999') as signed) as clavedepto,
                ifnull(D.Descripcion,'NO EXISTE DEPTO') as nombredepto,
                RC.numemp,RC.nomemp,RC.año,RC.semana,date_format(RC.fecalta,'%Y-%m-%d') as fecalta,RC.turno,RC.hora
                from relojchecador RC
                join empleados E on E.Numero = RC.numemp
                left join departamentos D on D.Clave = E.DepartamentoFisico
                where RC.semana = $sem and RC.año = 2019 and E.DepartamentoFisico like '%$depto%'
                order by clavedepto asc,RC.nomemp asc, RC.fecalta asc, RC.turno asc  ";
        $Movimientos = $this->db->query($query2)->result();

        //Iteramos en los registros para hacer el insert/update
        if (!empty($Movimientos)) {
            foreach ($Movimientos as $M) {
                //Ver en que fecha insertar o actualizar al igual que el campo del turno para guardar las horas
                $fecha = '';
                $turno = '';
                switch ($M->fecalta) {
                    case $Semanas[0]->fec1:
                        $fecha = 'fecha1';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ej1';
                                break;
                            case '2':
                                $turno = 'sj1';
                                break;
                            case '3':
                                $turno = 'ej2';
                                break;
                            case '4':
                                $turno = 'sj2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec2:
                        $fecha = 'fecha2';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ev1';
                                break;
                            case '2':
                                $turno = 'sv1';
                                break;
                            case '3':
                                $turno = 'ev2';
                                break;
                            case '4':
                                $turno = 'sv2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec3:
                        $fecha = 'fecha3';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'es1';
                                break;
                            case '2':
                                $turno = 'ss1';
                                break;
                            case '3':
                                $turno = 'es2';
                                break;
                            case '4':
                                $turno = 'ss2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec4:
                        $fecha = 'fecha4';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ed1';
                                break;
                            case '2':
                                $turno = 'sd1';
                                break;
                            case '3':
                                $turno = 'ed2';
                                break;
                            case '4':
                                $turno = 'sd2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec5:
                        $fecha = 'fecha5';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'el1';
                                break;
                            case '2':
                                $turno = 'sl1';
                                break;
                            case '3':
                                $turno = 'el2';
                                break;
                            case '4':
                                $turno = 'sl2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec6:
                        $fecha = 'fecha6';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'em1';
                                break;
                            case '2':
                                $turno = 'sm1';
                                break;
                            case '3':
                                $turno = 'em2';
                                break;
                            case '4':
                                $turno = 'sm2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec7:
                        $fecha = 'fecha7';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'emi1';
                                break;
                            case '2':
                                $turno = 'smi1';
                                break;
                            case '3':
                                $turno = 'emi2';
                                break;
                            case '4':
                                $turno = 'smi2';
                                break;
                        }
                        break;
                }

                $query3 = "select numemp from relojchecadortemp where numemp = '$M->numemp' and año = '$M->año' and sem = '$M->semana' ";
                $RelojTemp = $this->db->query($query3)->result();
                if (!empty($RelojTemp)) {//Si ya existe update
                    $this->db->where('numemp', $M->numemp)->where('sem', $M->semana)->where('año', $M->año);
                    $this->db->update("relojchecadortemp", array(
                        $fecha => $M->fecalta,
                        $turno => $M->hora
                    ));
                } else {//Si no existe insert
                    //Agregamos el registro
                    $this->db->insert("relojchecadortemp", array(
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'numdep' => $M->clavedepto,
                        'nomdep' => $M->nombredepto,
                        'fecha1' => $Semanas[0]->fec1,
                        'fecha2' => $Semanas[0]->fec2,
                        'fecha3' => $Semanas[0]->fec3,
                        'fecha4' => $Semanas[0]->fec4,
                        'fecha5' => $Semanas[0]->fec5,
                        'fecha6' => $Semanas[0]->fec6,
                        'fecha7' => $Semanas[0]->fec7,
                        'año' => $M->año,
                        'sem' => $M->semana,
                        $turno => $M->hora
                    ));
                }
            }

            //Imprimir reporte
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["ano"] = $ano;
            $parametros["sem"] = $sem;
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\asistencias\asistenciasRelojChecador.jasper');
            $jc->setFilename('ASISTENCIAS_RELOJ_CHECADOR_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } else {//Si no trae nada mandamos 0
            print 0;
        }
    }

}
