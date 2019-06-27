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

    public function onReporteAltasBanco() {
        $x = $this->input;
        $fechaI = $x->get('FechaIni');
        $fechaF = $x->get('FechaFin');
        $query = "select
                    CONCAT(
                    '95100000000000000000000AHNOM  ' ,
                    concat('0000000000000000R',      RPAD(  concat(E.PrimerNombre,'/',E.Paterno)  ,24,' ')      ),
                    RPAD(E.PrimerNombre,19,' ') ,
                    RPAD(E.SegundoNombre,25,' '),
                    RPAD(E.Paterno,25,' ') ,
                    RPAD(E.Materno,30,' ') ,
                    case when E.sexo = 'M' then 'MASCULINO' when E.sexo = 'F' then 'FEMENINO ' ELSE 'NODEFINID' END ,
                    date_format(str_to_date(E.Nacimiento,'%Y-%m-%d'),'%Y%m%d'),
                    RPAD(E.RFC,13,' ')
                    ) AS Col1,
                    CONCAT(
                    RPAD(E.Direccion,35,' '),
                    RPAD(E.Colonia,35,' '),
                    RPAD(E.Ciudad,35,' '),
                    'GTO 01240004',
                    RPAD(E.CP,5,' ') ,
                    '477',
                    case when E.Tel = '0' then '1464646'  ELSE RPAD(E.Tel,7,' ') END ,
                    E.EstadoCivil
                    ) AS Col2,
                    CONCAT(
                    RPAD(E.Beneficiario,30,' ') ,
                    RPAD(E.Parentesco,10,' ') ,
                    E.Porcentaje,
                    '0'
                    '                                        0000',
                    '                                        0000'
                    ) AS Col3
                    from empleados E
                    where str_to_date(E.fechaingreso,'%Y-%m-%d')
                    between str_to_date('$fechaI','%d/%m/%Y')
                    and str_to_date('$fechaF','%d/%m/%Y')
                    and E.altabaja = 1
                    order by E.Numero asc ";
        $Ingresos = $this->db->query($query)->result();

        header("Content-Description: File Transfer");
        //Tipo de archivo
        $filename = 'A8149010.' . Date('nj') . '.txt';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        if (!empty($Ingresos)) {
            $handle = fopen('php://output', "w");
            $txt = "9500000000064266210201000008149CALZADO LOBO, S.A. DE C.V.                               RIO SANTIAGO 245            SAN MIGUEL                  LEON                        373900024CARRANZ" . "\n";
            fwrite($handle, $txt);
            foreach ($Ingresos as $M) {
                $txt = $M->Col1 . $M->Col2 . $M->Col3 . "\n";
                fwrite($handle, $txt);
            }
            fclose($handle);
            exit;
        }
    }

    public function onReporteAltasBancoPDF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteAltaEmpleadosBanco.jasper');
        $jc->setFilename('ALTAS_EMPLEADOS_BANCO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
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

    public function onImprimirRecibos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoRecibos');
        $parametros["sem"] = $this->input->post('SemRecibos');
        $parametros["depto"] = $this->input->post('DeptoRecibos');
        $parametros["empleado"] = $this->input->post('EmpleadoRecibos');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reciboNomina.jasper');
        $jc->setFilename('RECIBOS_NOMINAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirContrato() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/nominas/';
        $parametros["empleado"] = $this->input->post('Empleado');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\contratoIndividualTiempoIndefinido.jasper');
        $jc->setFilename('CONTRATO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirIngreEgre() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoIngreEgre');
        $parametros["dsem"] = $this->input->post('dSemIngreEgre');
        $parametros["asem"] = $this->input->post('aSemIngreEgre');
        $parametros["fechaIni"] = $this->input->post('FechaIniIngreEgre');
        $parametros["fechaFin"] = $this->input->post('FechaFinIngreEgre');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteEstIngre.jasper');
        if ($this->input->post('TipoEstIngEg') === '2') {
            $jc->setJasperurl('jrxml\nominas\reporteEstEgre.jasper');
        }
        $jc->setFilename('EST_ING_EGRE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirCajaAhorroPrestamos() {
        $x = $this->input;
        $demp = $x->post('dEmpleadoAhorroPrestamos');
        $aemp = $x->post('aEmpleadoAhorroPrestamos');
        $ano = $x->post('AnoAhorroPrestamos');

        $tipoReporte = $x->post('TipoAhorroPrestamos');
        $tipoReportePrestamos = $x->post('TipoPrestamos');

        /* Limpiamos la tabla temporal */
        $this->db->query('truncate table prescaha');

        $query_empleados = '';
        if ($tipoReporte === '2') {//Ahorro
            $query_empleados = "select "
                    . "E.Numero, "
                    . "E.Busqueda, "
                    . "ifnull(D.Clave,'999') as numdepto,"
                    . "ifnull(D.Descripcion,'REVISAR DEPTO EXISTE') as nomdepto, "
                    . "E.Ahorro  "
                    . "from empleados E left join departamentos D on D.clave = E.DepartamentoFisico "
                    . "where E.numero between $demp and $aemp and E.Ahorro > 0 and E.AltaBaja = 1  ";
        } else {
            $query_empleados = "select "
                    . "E.Numero, "
                    . "E.Busqueda, "
                    . "ifnull(D.Clave,'999') as numdepto,"
                    . "ifnull(D.Descripcion,'REVISAR DEPTO EXISTE') as nomdepto, "
                    . "E.Ahorro  "
                    . "from empleados E left join departamentos D on D.clave = E.DepartamentoFisico "
                    . "where E.numero between $demp and $aemp and E.PressAcum > 0 and E.AltaBaja = 1  ";
        }
        $Empleados = $this->db->query($query_empleados)->result();

        //Iteramos en los registros para hacer el insert/update
        if (!empty($Empleados)) {
            foreach ($Empleados as $M) {

                $numemp = $M->Numero;
                $nomemp = $M->Busqueda;
                $depto = $M->numdepto;
                $ahorro = $M->Ahorro;
                $nomdepto = $M->nomdepto;
                $query_prestamos = '';
                $PrestamoAcum = 0;

                //Si es prestamos consultamos la tabla para obtener el acumulado
                if ($tipoReporte === '1') {
                    $query_prestamos = "SELECT ifnull(sum(preemp),0) as preemp FROM prestamos  WHERE numemp  = $numemp ";
                    $PrestamoAcum = $this->db->query($query_prestamos)->result()[0]->preemp;
                }

                //Agregamos el registro a tabla temp
                $this->db->insert("prescaha", array(
                    'numemp' => $numemp,
                    'nomemp' => $nomemp,
                    'depto' => $depto,
                    'nomdepto' => $nomdepto,
                    'presta' => ($tipoReporte === '1') ? $PrestamoAcum : $ahorro
                ));

                //Validamos que tipo de reporte es para obtener los importes
                if ($tipoReporte === '1') {
                    $query_importes = "SELECT imported,numsem FROM prenomina where numemp = $numemp and año = $ano and numcon  = 65 ";
                } else {
                    $query_importes = "SELECT imported,numsem FROM prenomina where numemp = $numemp and año = $ano and numcon  = 70 ";
                }
                $Importes = $this->db->query($query_importes)->result();
                if (!empty($Importes)) {
                    //Actualizamos la tabla con total por linea
                    $Total_Acum = 0;
                    foreach ($Importes as $I) {
                        if (floatval($I->imported) > 0) {
                            $no_sem = $I->numsem;
                            $Total_Acum += floatval($I->imported);
                            $this->db->where('numemp', $numemp);
                            $this->db->update("prescaha", array(
                                "s$no_sem" => $I->imported,
                                "total" => $Total_Acum
                            ));
                        }
                    }
                }
            }


            //Imprimir reportes
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["ano"] = $ano;
            $jc->setParametros($parametros);
            if ($tipoReporte === '1') {
                $jc->setJasperurl('jrxml\nominas\reportePrestamos.jasper');
            } else {
                $jc->setJasperurl('jrxml\nominas\reporteCajaAhorros.jasper');
            }
            $jc->setFilename('REPORTE_PRESTAMOS_CAJA_AHORROS_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } else {//Si no trae nada mandamos 0
            print 0;
        }
    }

}
