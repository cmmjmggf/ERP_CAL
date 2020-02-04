<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avance9 extends CI_Controller {

    private $avances = array(2 => "CORTE", 3 => "RAYADO", 4 => "FOLEADO", 33 => "REBAJADO", 40 => "ENTRETELADO", 42 => "MAQUILA", 44 => "ALMACEN DE CORTE", 5 => "PESPUNTE", 6 => "ALMACEN DE PESPUNTE", 7 => "TEJIDO", 8 => "ALMACEN DE TEJIDO", 9 => "MONTADO", 10 => "ADORNO", 11 => "ALMACEN ADORNO", 12 => "TERMINADO", 13 => "FACTURADO", 14 => "CANCELADO");

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance9_model', 'axepn');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vEncabezado')->view('vAvance9')->view('vFooter');
                    break;
                case 'DESTAJOS':
                    switch ($this->session->USERNAME) {
                        case '999999':
                            /*
                             *
                             * 99 CORTE FORRO
                             * 100 CORTE PIEL (1)
                             * 96 CORTE MUESTRAS
                             * 102 RAYADO (EMPLEADO DEPTO 80)(2)
                             * 60 FOLEADO (EMPLEADO DEPTO 40)(3)
                             * 103 REBAJADO (EMPLEADO DEPTO 30)(4)
                             *
                             * */
                            $this->load->view('vEncabezado')->view('vAvance9')->view('vFooter');
                            break;
                    }
                    break;
                default :
                    $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getSemanaByFecha() {
        try {
//            print json_encode($this->axepn->getSemanaByFecha(Date('d/m/Y')));
            $fecha = Date('d/m/Y');
            $this->db->select("U.Sem, '{$fecha}' AS Fecha", false)
                    ->from('semanasnomina AS U')
                    ->where("STR_TO_DATE(\"{$fecha}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl() {
        try {
            $x = $this->input->get();
            if ($x['FR'] !== '' && intval($x['DEPTO']) === 10) {
                $FRACCIONES = json_decode($x['FR']);
                $TIENE_LAS_FRACCIONES_99_Y_100 = 0;
                foreach ($FRACCIONES as $k => $v) {
                    switch (intval($v->NUMERO_FRACCION)) {
                        case 96:
                            $TIENE_LAS_FRACCIONES_99_Y_100 += 1;
                            break;
                        case 99:
                            $TIENE_LAS_FRACCIONES_99_Y_100 += 1;
                            break;
                        case 100:
                            $TIENE_LAS_FRACCIONES_99_Y_100 += 1;
                            break;
                    }
                }
                if ($TIENE_LAS_FRACCIONES_99_Y_100 > 0) {
                    $data = $this->db->select("P.Estilo, P.Pares, F.CostoMO, "
                                            . "(P.Pares*F.CostoMO) AS TOTAL, {$v->NUMERO_FRACCION} AS Fraccion", false)
                                    ->from("pedidox AS P")->join('fraccionesxestilo as F', 'P.Estilo = F.Estilo')
                                    ->where_in("F.Fraccion", 99, 100, 96)
                                    ->where("P.Control", $x['CR'])->limit(1)->get()->result();
                    print json_encode($data);
                } else {
                    print json_encode(array("MENSAJE" => "CONTROL INEXISTENTE O NO TIENE LAS FRACCIONES 99,100 O 96(MUESTRA)"));
                }

                exit(0);



                /* 05/01/2020 LO QUITE PORQUE NO FUNCIONA */



                switch (intval($x['FR'])) {
                    case 99:
                        //FORRO O SINTETICO, SE METE COMO 99 EL SINTETICO
//                        $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
//                                ->from('asignapftsacxc AS A')
//                                ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo')
//                                ->where("A.Fraccion", $x['FR'])->where("FXE.Fraccion", $x['FR'])
//                                ->where("A.Control", $x['CR'])->limit(1);

                        $this->db->select("P.Estilo, P.Pares, F.CostoMO, (P.Pares*F.CostoMO) AS TOTAL, 99 AS Fraccion", false)
                                ->from("pedidox AS P")->join('fraccionesxestilo as F', 'P.Estilo = F.Estilo')
                                ->where("F.Fraccion", 99)
                                ->where("P.Control", $x['CR'])->limit(1);
                        break;
                    default:
//                        EN LA ORDEN DE PRODUCCIÓN NO VIENE FORRO PERO SI SINTETICO, EL SINTETICO LO METEN COMO FORRO.
//                        SINTETICO
//                        $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
//                                ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo')
//                                ->where("FXE.Fraccion", $x['FR'])
//                                ->where("A.Control", $x['CR']);
                        $this->db->select(" O.Pares, O.Sintetico1, O.CantidadSintetico1,O.TotalSintetico,
                            FXE.CostoMO, (O.Pares * FXE.CostoMO) AS TOTAL, 99 AS FRACCION", false)
                                ->from("ordendeproduccion AS O")->join("`fraccionesxestilo` as `FXE`", "O.Estilo = `FXE`.`Estilo`")
                                ->where("O.ControlT IN('{$x['CR']}') AND FXE.Fraccion = 99", null, false);
                        break;
                }
                $data = $this->db->get()->result();
//                print $this->db->last_query();
                print json_encode($data);
                exit(0);
            } else {
                /* AQUI YA ES CUANDO PASO POR CORTE Y ESTA EN RAYADO, SE REVISA POR DEPTO PARA PONERLE LA FRACCIÓN */

//                $this->db->select("FE.ID, FE.Estilo, FE.FechaAlta, FE.Fraccion, FE.CostoMO, "
//                                . "FE.CostoVTA, FE.AfectaCostoVTA, FE.Estatus, F.ID AS FID, "
//                                . "F.Clave AS FCLAVE, F.Descripcion AS FRACCIONDES, "
//                                . "F.Departamento AS FRACCIONDEPTO", false)
//                        ->from('fraccionesxestilo AS FE')->join('fracciones AS F', 'F.Clave = FE.Fraccion');
                $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, "
                                . "FXE.Fraccion AS Fraccion, F.Descripcion AS FRACCION_DES ", false)
                        ->from("asignapftsacxc AS A")
                        ->join("fraccionesxestilo AS FXE", "A.Estilo = FXE.Estilo")
                        ->join("fracciones AS F", "FXE.Fraccion = F.Clave");
                $this->db->where('A.Control', $x['CR']);
                switch (intval($x['DEPTO'])) {
                    case 80:
                        /* RAYADO CONTADO : FRACCION 102 */
                        $this->db->where('F.Clave', 102);
                        break;
                    case 30:
                        /* REBAJADO Y PERFORADO : FRACCION 103 */
                        $this->db->where('F.Clave', 103);
                        break;
                    case 50:
                        /* DOBLILLADO : FRACCION 300 */
                        $this->db->where('F.Clave', 300);
                        break;
                    case 60:
                        /* LASER : FRACCION 300 */
                        $this->db->where('F.Clave', 300);
                        break;
                }
                print json_encode($this->db->get()->result());
//                print json_encode($this->db->query("SELECT A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, "
//                                        . "FXE.Fraccion AS Fraccion, F.Descripcion AS FRACCION_DES "
//                                        . "FROM asignapftsacxc AS A  "
//                                        . "INNER JOIN fraccionesxestilo as FXE ON A.Estilo = FXE.Estilo "
//                                        . "INNER JOIN fracciones as F ON FXE.Fraccion = F.Clave "
//                                        . "WHERE A.Control = {$x['CR']} 
//                                        AND F.Departamento = {$x['DEPTO']} LIMIT 1")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            $x = $this->input->get();
//            print json_encode($this->axepn->getUltimoAvanceXControl($x->get('C')));

            print json_encode($this->db->select("A.ID, A.Control, A.FechaAProduccion, "
                                            . "A.Departamento, A.DepartamentoT, A.FechaAvance, "
                                            . "A.Estatus, A.Usuario, A.Fecha, A.Hora ", false)
                                    ->from('avance AS A')
                                    ->where("A.Control", $x['C'])
                                    ->order_by('A.ID', 'DESC')
                                    ->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarDeptoXEmpleado() {
        try {
            /*
             * COMPROBAR SI EL DEPTO ES 
             * 
             * 10 CORTE
             * 30 REBAJADO Y PERFORADO
             * 80 RAYADO CONTADO
             * 280 CALIDAD
             * 
             * ADEMÁS EL EMPLEADO DEBE DE ESTAR A DESTAJO O AMBOS, NO COMO EMPLEADO FIJO
             * 
             * DE LO CONTRARIO ARROJAR UN MENSAJE
             */
//            $EMPLEADO_VALIDO = $this->axepn->onComprobarDeptoXEmpleado($this->input->post('EMPLEADO'));
//            print json_encode($EMPLEADO_VALIDO);

            $DEPTOS_FISICOS = array(10/* CORTE */, 70, 20/* RAYADO */, 80/* RAYADO CONTADO */,
                30/* REBAJADO Y PERFORADO */, 180, 190/* MONTADO B */, 200, 210, 220, 300 /* SUPERVISORES */);
            $xXx = $this->input->post();
            $ES_SUPERVISOR = $this->db->query("SELECT E.DepartamentoFisico AS DEPTO FROM empleados AS E WHERE E.Numero = {$xXx["EMPLEADO"]} LIMIT 1")->result();

            $this->db->select("(CASE WHEN E.PrimerNombre = '0' AND E.SegundoNombre = '0' THEN E.Busqueda ELSE "
                            . "CONCAT(E.PrimerNombre,' ',"
                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) END) AS NOMBRE_COMPLETO, "
                            . "E.DepartamentoFisico AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Clave AS DEPTO, D.Descripcion AS DEPTO_DES, E.Busqueda AS CELULAS ", false)
                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                    ->where('E.Numero', $this->input->post('EMPLEADO'))
                    ->where_in('E.AltaBaja', array(1));
            if (count($ES_SUPERVISOR) > 0) {
                if (intval($ES_SUPERVISOR[0]->DEPTO) === 300) {
                    $this->db->where_in('E.FijoDestajoAmbos', array(1, 2, 3));
                }
            } else {
                $this->db->where_in('E.FijoDestajoAmbos', array(2, 3));
            }
            $this->db->where_in('E.DepartamentoFisico', $DEPTOS_FISICOS);

//            991	CELULA  MONTADO "B"
//            992	CELULA  ADORNO "A"
//            993	CELULA  MONTADO "A"
//            1005 CELULA  ADORNO "B"
//            1006 PEGADO
            $this->db->or_where_in('E.Numero', $this->input->post('EMPLEADO'));
            $this->db->where_in('E.DepartamentoFisico', array(180, 190/* MONTADO B */, 200, 210, 220));
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFraccionXEstilo() {
        try {
//            print json_encode($this->axepn->onComprobarFraccionXEstilo($this->input->post('ESTILO'), $this->input->post('FRACCION')));
            $x = $this->input->post();
            $this->db->select("FE.ID, FE.Estilo, FE.FechaAlta, FE.Fraccion, FE.CostoMO, "
                            . "FE.CostoVTA, FE.AfectaCostoVTA, FE.Estatus, F.ID AS FID, "
                            . "F.Clave AS FCLAVE, F.Descripcion AS FRACCIONDES, "
                            . "F.Departamento AS FRACCIONDEPTO", false)
                    ->from('fraccionesxestilo AS FE')->join('fracciones AS F', 'F.Clave = FE.Fraccion')
                    ->where('FE.Estilo', $x['ESTILO']);
            switch (intval($x['DEPTO'])) {
                case 80:
                    /* RAYADO CONTADO : FRACCION 102 */
                    $this->db->where('FE.Clave', 102);
                    break;
                case 30:
                    /* REBAJADO Y PERFORADO : FRACCION 103 */
                    $this->db->where('FE.Clave', 103);
                    break;
                case 50:
                    /* DOBLILLADO : FRACCION 300 */
                    $this->db->where('FE.Clave', 300);
                    break;
                case 60:
                    /* LASER : FRACCION 300 */
                    $this->db->where('FE.Clave', 300);
                    break;
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesPagoNomina() {
        try {
            $url = $this->uri;
            $x = $this->input->get();
            $SPAN_100 = "<span class='font-weight-bold text-success'>100</span>";
            $SPAN_99 = "<span class='font-weight-bold text-info'>99</span>";
            $SPAN_96 = "<span class='font-weight-bold' style='color: #ef1000 !important;'>96</span>";
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "(CASE "
                            . "WHEN FACN.numfrac = 100 THEN \"$SPAN_100\" "
                            . "WHEN FACN.numfrac = 99 THEN \"$SPAN_99\" "
                            . "WHEN FACN.numfrac = 96 THEN \"$SPAN_96\" "
                            . "ELSE FACN.numfrac "
                            . "END) AS FRAC, "
                            . "FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, "
                            . "CONCAT('$',FORMAT(FACN.subtot,2)) AS SUBTOTAL, "
                            . "CONCAT('<span class=\"text-black\">$',FORMAT(FACN.subtot,2),'</span>') AS SUBTOTAL_SPAN, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN');
            switch ($url->segment(2)) {
                case 1:
//                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "96,99,100"));
                    if ($x['SEMANA_FILTRO'] !== '') {
                        $this->db->where("FACN.numfrac IN(80,96,99,100,102,60,103,299,300)", null, false);
                    } else {
                        $this->db->where("FACN.numfrac IN(80,96,99,100,102,60,103,299,300) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);
                    }
                    break;
                case 2:
//                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337"));
                    if ($x['SEMANA_FILTRO'] !== '') {
                        $this->db->where("FACN.numfrac IN(51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337)", null, false);
                    } else {
                        $this->db->where("FACN.numfrac IN(51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);
                    }
                    break;
            }
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('FACN.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['SEMANA'] !== '' && $x['SEMANA_FILTRO'] === '') {
                $this->db->where('FACN.semana', $x['SEMANA']);
            }
            if ($x['SEMANA_FILTRO'] !== '' && $x['SEMANA'] !== '') {
                $this->db->where('FACN.semana', $x['SEMANA_FILTRO']);
            }
            if ($x['ANO_FILTRO'] !== '') {
                $this->db->where('FACN.anio', $x['ANO_FILTRO']);
            }
            if ($x['FRACCION_FILTRO'] !== '') {
                $this->db->where('FACN.numfrac', $x['FRACCION_FILTRO']);
            }
            $this->db
                    ->order_by('ABS(FACN.ID)', 'DESC')
                    ->order_by('ABS(FACN.anio)', 'DESC')
                    ->order_by('ABS(FACN.semana)', 'DESC');
            if ($x['EMPLEADO'] === '') {
                $this->db->limit(5);
            }
            $DATA = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosXEmpleadoXSemana() {
        try {
//            header('Content-type: application/json');
//            print json_encode($this->axepn->getPagosXEmpleadoXSemana(
//                                    $this->input->get('EMPLEADO'), $this->input->get('SEMANA'), $this->input->get('FRACCIONES')));
            $x = $this->input->get();
            $a = "IFNULL((SELECT FORMAT(SUM(fpn.subtot),2) FROM fracpagnomina AS fpn WHERE dayofweek(fpn.fecha)";
            $b = "AND fpn.numeroempleado = '{$x['EMPLEADO']}' AND fpn.Semana = {$x['SEMANA']} GROUP BY dayofweek(fpn.fecha)),0)";
            print json_encode($this->db->select("{$a}= 2 {$b} AS LUNES,"
                                            . "{$a} = 3 {$b} AS MARTES,"
                                            . "{$a} = 4 {$b} AS MIERCOLES,"
                                            . "{$a} = 5 {$b} AS JUEVES,"
                                            . "{$a} = 6 {$b} AS VIERNES,"
                                            . "{$a} = 7 {$b} AS SABADO,"
                                            . "{$a} = 1 {$b} AS DOMINGO", false)->limit(1)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAvanceXEmpleadoYPagoDeNomina() {
        try {
            $x = $this->input;
            $xXx = $this->input->post();


            $FRACCIONES = json_decode($xXx['FRACCIONES'], false);
            $MAQUILA = ($this->getMaquilaXControl($xXx['CONTROL']));
            $MAQUILA_MUESTRA = intval($MAQUILA->MAQUILA) === 98 ? 98 : intval($MAQUILA->MAQUILA);
//            print "\n MAQUILA DEL CONTROL {$xXx['CONTROL']} ES: " . intval($MAQUILA->MAQUILA);
//            exit(0);
//            var_dump($FRACCIONES);
//            foreach ($FRACCIONES as $key => $value) {
//                print $value->NUMERO_FRACCION . "\n";
//            }
//            exit(0);

            $fecha = $xXx['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $data = array(
                "numeroempleado" => $xXx['NUMERO_EMPLEADO'],
                "maquila" => intval($CONTROL[0]->MAQUILA),
                "control" => $xXx['CONTROL'],
                "estilo" => $xXx['ESTILO'],
                "pares" => $xXx['PARES'],
                "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                "semana" => $xXx['SEMANA'],
                "fecha_registro" => Date('d/m/Y h:i:s'),
                "depto" => $xXx['DEPARTAMENTO'],
                "anio" => $xXx['ANIO']);
            $msj = "[";
            $pifo_contador = 0;
            foreach ($FRACCIONES as $k => $v) {
//                print "{$v->NUMERO_FRACCION} = > {$v->DESCRIPCION} {$xXx['CONTROL']}<br>";
//exit(0);
                $NUMERO_ENTERO_FRACCION = intval($v->NUMERO_FRACCION);


                $PRECIO_FRACCION_CONTROL = $this->db->select("P.Estilo, P.Pares, F.CostoMO, "
                                        . "(P.Pares*F.CostoMO) AS TOTAL, {$NUMERO_ENTERO_FRACCION} AS Fraccion", false)
                                ->from("pedidox AS P")->join('fraccionesxestilo as F', 'P.Estilo = F.Estilo')
                                ->where("F.Fraccion", $NUMERO_ENTERO_FRACCION)
                                ->where("P.Control", $xXx['CONTROL'])->get()->result();

                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                $data = array(
                    "numeroempleado" => $xXx['NUMERO_EMPLEADO'],
                    "maquila" => intval($CONTROL[0]->MAQUILA),
                    "control" => $xXx['CONTROL'],
                    "estilo" => $xXx['ESTILO'],
                    "pares" => $xXx['PARES'],
                    "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                    "fecha_registro" => Date('d/m/Y h:i:s'),
                    "semana" => $xXx['SEMANA'],
                    "depto" => $xXx['DEPARTAMENTO'],
                    "anio" => $xXx['ANIO']);
                $data["numfrac"] = $v->NUMERO_FRACCION;
                $data["preciofrac"] = $PXFC;
                $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
//            $retorno_material = $this->axepn->onComprobarRetornoDeMaterial(
//                    $xXx['CONTROL'], $v->NUMERO_FRACCION, $xXx['NUMERO_EMPLEADO']);
                $retorno_material = $this->db->select("COUNT(*) AS EXISTE", false)
                                ->from('asignapftsacxc AS A')
                                ->where("A.Control", $xXx['CONTROL'])
                                ->where("A.Empleado<>", 0)
                                ->order_by('A.ID', 'DESC')
                                ->limit(1)->get()->result();
                /* SI EL CONTROL, LA FRACCION Y EL EMPLEADO HA REGRESADO ESTE MATERIAL SE OBTIENE UN "1" DE LO CONTRARIO SI EL NO REGRESO EL MATERIAL SE DEVUELVE "0" */
//            var_dump($retorno_material);
//            print $this->db->last_query();
//            exit(0);
                if (intval($retorno_material[0]->EXISTE) >= 1) {
                    /* PASO 1 : AGREGAR AVANCE (DEBE DE ESTAR EN CORTE EL CONTROL, ADEMÁS DEBE DE ) */
                    /* AVANCE DE (10) CORTE A (20) RAYADO */
                    /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE (20 - RAYADO) PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
                    $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)
                                    ->from('avance AS A')
                                    ->where('A.Control', $xXx['CONTROL'])
                                    ->where('A.Departamento', 20)
                                    ->where('A.Fraccion', $v->NUMERO_FRACCION)
                                    ->where_not_in('A.Emp')
                                    ->get()->result();

                    /* SOLO SE GENERA EL AVANCE EN LA FRACCIÓN 100 QUE ES LA PIEL */
                    /* CORTE = > RAYADO */
                    if (intval($check_avance[0]->EXISTE) <= 0) {
                        $id = 0;
                        if (intval($v->NUMERO_FRACCION) === 100 ||
                                intval($v->NUMERO_FRACCION) === 96 && $MAQUILA_MUESTRA === 98) {
                            $REVISA_AVANCE_RAYADO = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = '{$xXx['CONTROL']}' AND Departamento = 20")->result();
                            if (intval($REVISA_AVANCE_RAYADO[0]->EXISTE) === 0) {
                                $avance = array(
                                    'Control' => $xXx['CONTROL'],
                                    'FechaAProduccion' => Date('d/m/Y'),
                                    'Departamento' => 20,
                                    'DepartamentoT' => 'RAYADO',
                                    'FechaAvance' => Date('d/m/Y'),
                                    'Estatus' => 'A',
                                    'Usuario' => $_SESSION["ID"],
                                    'Fecha' => Date('d/m/Y'),
                                    'Hora' => Date('h:i:s a'),
                                    'Fraccion' => 102
                                );
                                $this->db->insert('avance', $avance);
                                $id = $this->db->insert_id();
                            }

                            /* ACTUALIZA A 20 RAYADO, stsavan 3 */
                            $this->onAvanzarXControl($xXx['CONTROL'], 'RAYADO', 20, 3);
                        }
                        /* PASO 2 : AGREGAR FRACCION PAGADA */
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $xXx['CONTROL'])
                                        ->where('F.numfrac', $v->NUMERO_FRACCION)
                                        ->get()->result();
                        $data["fraccion"] = $v->NUMERO_FRACCION;
                        if (intval($check_fraccion[0]->EXISTE) <= 0) {
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : $v->NUMERO_FRACCION;

                            if (intval($v->NUMERO_FRACCION) === 100 && $MAQUILA_MUESTRA !== 98) {
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 100", "LE PAGO LA FRACCION 100 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']}", $this->session);
                                $msj .= '{"AVANZO":"1","FR":"100","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A RAYADO  - LOOP FOREACH"}';
                            }
                            if (intval($v->NUMERO_FRACCION) === 99 && $MAQUILA_MUESTRA !== 98) {
                                $data["avance_id"] = NULL;
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 99", "LE PAGO LA FRACCION 99 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']}", $this->session);
                                $msj .= '{"AVANZO":"0","FR":"99","RETORNO":"SI", "MESSAGE":"FRACCION 99, NO GENERA AVANCE - LOOP FOREACH"}';
                            }
                            if (intval($v->NUMERO_FRACCION) === 96 && $MAQUILA_MUESTRA === 98) {
                                $data["avance_id"] = NULL;
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 96", "LE PAGO LA FRACCION 96 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']}", $this->session);
                                $msj .= '{"AVANZO":"0","FR":"96","RETORNO":"SI", "MESSAGE":"FRACCION 96, NO GENERA AVANCE - LOOP FOREACH"}';
                            }
                            if ($pifo_contador >= 1 && count($FRACCIONES) === 3) {
                                $msj .= ",";
                                $pifo_contador += 1;
                            }
                            if ($pifo_contador === 0 && count($FRACCIONES) <= 2) {
                                $msj .= ",";
                                $pifo_contador += 1;
                            }
                        } else {
                            
                        }
                    }
                } else {
                    /* EL CORTADOR NO HA REGRESADO MATERIAL O EL ALMACENISTA NO HA REGISTRADO EL RETORNO DEL MATERIAL */
                    print '[{"AVANZO":"0","RETORNO_MATERIAL":"0","RETORNO":"NO", "MESSAGE":"NUMERO DE FRACCION O EMPLEADO INCORRECTOS  - LOOP FOREACH"}]';
                    exit(0);
                }
            }// *** FIN FOREACH DE FRACCIONES JSON ***
            /* SI NO ESPECIFICO FRACCIONES ES PARA 80 102 RAYADO => FOLEADO */
            if (count($FRACCIONES) <= 0 && intval($xXx['DEPARTAMENTO']) !== 10) {
                switch (intval($xXx['DEPARTAMENTO'])) {
                    case 80:
                        $FRACCION = 102;
                        $data["fraccion"] = $FRACCION;
                        $data["numfrac"] = $FRACCION;
                        /* ACTUALIZA A 40 FOLEADO, stsavan 40 */
                        /* DEBE DE EESTAR EL REGISTRO DE AVANCE EN CORTE Y RAYADO */
                        $revisar_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Departamento IN(10,20) AND A.Control ={$xXx['CONTROL']}")->result();
                        if (intval($revisar_avance[0]->EXISTE) === 2) {
                            $this->onAvanzarXControl($xXx['CONTROL'], 'FOLEADO', 40, 4);
                        } else {
                            exit(0);
                        }
                        /* FILTRADO POR FRACCION 102 RAYADO */
                        $FRACCION_CONTROL = $this->db->query("SELECT COUNT(*) AS EXISTE FROM  fracpagnomina where numfrac IN(102,80) and control = {$xXx['CONTROL']} LIMIT 1")->result();
                        if (intval($FRACCION_CONTROL[0]->EXISTE) >= 1) {
                            /* ENTRA AQUI CUANDO YA SE COBRO LA FRACCION 102 Y 80 */
                            print json_encode(array("AVANZO" => 0, "RETORNO" => 1));
                            exit(0);
                        }
                        $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$FRACCION}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                        $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                        $data["preciofrac"] = $PXFC;
                        $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $xXx['CONTROL'])
                                        ->where('F.numfrac', $FRACCION)
                                        ->get()->result();
                        if (intval($check_fraccion[0]->EXISTE) === 0) {
                            /* 20 RAYADO => 40 FOLEADO */
                            $avance = array(
                                'Control' => $xXx['CONTROL'],
                                'FechaAProduccion' => Date('d/m/Y'),
                                'Departamento' => 40,
                                'DepartamentoT' => 'FOLEADO',
                                'FechaAvance' => Date('d/m/Y'),
                                'Estatus' => 'A',
                                'Usuario' => $_SESSION["ID"],
                                'Fecha' => Date('d/m/Y'),
                                'Hora' => Date('h:i:s a'),
                                'Fraccion' => 60
                            );
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                            /* PAGAR LA FRACCION 102 AL EMPLEADO */
                            $this->db->insert('fracpagnomina', $data);
                        }

                        /* 80 CONTAR TAREA */
                        $FRACCION = 80;
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $xXx['CONTROL'])
                                        ->where('F.numfrac', $FRACCION)
                                        ->get()->result();
                        if (intval($check_fraccion[0]->EXISTE) <= 0) {
                            $data["fraccion"] = $FRACCION;
                            $data["numfrac"] = $FRACCION;
                            /* FILTRADO POR FRACCION 80 RAYADO */
                            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$FRACCION}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                            $data["preciofrac"] = $PXFC;
                            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                            /* PAGAR LA FRACCION 80 AL EMPLEADO */
                            $this->db->insert('fracpagnomina', $data);
                        }
                        print json_encode(array("AVANZO" => 1, "RETORNO" => 1));
                        exit(0);
                        break;
                    case 40:
                        $FRACCION = 60;
                        /* ESTA ASI PORQUE FISICAMENTE ES MAS RAPIDO EL FOLEADO QUE EL REBAJADO */
                        /* 40 FOLEADO = >  30 REBAJADO */
                        /* RAYADO => FOLEADO */

                        /* REVISAR SI LA FRACCION "103 RAYADO" NO HA SIDO PAGADA A OTRO EMPLEADO */
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $xXx['CONTROL'])
                                        ->where('F.numfrac', $FRACCION)
                                        ->get()->result();
                        if (intval($check_fraccion[0]->EXISTE) >= 1) {
                            print '{"AVANZO":"0","FR":"60","RETORNO":"SI","MESSAGE":"EL CONTROL YA HA SIDO AVANZADO A REBAJADO - SWITCH 40 "}';
                            exit(0);
                        }
                        $data["fraccion"] = $FRACCION;
                        $data["numfrac"] = $FRACCION;
                        /* FILTRADO POR FRACCION 102 RAYADO */
                        $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$FRACCION}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                        $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                        $data["preciofrac"] = $PXFC;
                        $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                        if (intval($check_fraccion[0]->EXISTE) <= 0) {
                            /* GENERAR UN AVANCE A REBAJADO */
                            $avance = array(
                                'Control' => $xXx['CONTROL'],
                                'FechaAProduccion' => Date('d/m/Y'),
                                'Departamento' => 30,
                                'DepartamentoT' => 'REBAJADO',
                                'FechaAvance' => Date('d/m/Y'),
                                'Estatus' => 'A',
                                'Usuario' => $_SESSION["ID"],
                                'Fecha' => Date('d/m/Y'),
                                'Hora' => Date('h:i:s a'),
                                'Fraccion' => 103
                            );
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 8080;
                            /* PAGAR LA FRACCION 102 AL EMPLEADO */
                            $this->db->insert('fracpagnomina', $data);

                            /* ACTUALIZA A 30 REBAJADO, stsavan 33 */
                            $this->onAvanzarXControl($xXx['CONTROL'], 'REBAJADO', 30, 33);

                            $this->db->set('stsavan', 33)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        }
                        print '{"AVANZO":"1","FR":"103","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A REBAJADO - SWITCH 40"}';
                        exit(0);
                        break;
                    case 30:
                        /* 30 REBAJADO => 90 ENTRETELADO */
                        $FRACCION = 103;

                        /* REVISAMOS QUE CORTE,RAYADO Y FOLEADO YA HAYAN DADO SU AVANCE, 
                         * DEBE DE ARROJAR 3 POR EL # DE FRACCIONES, DE LO CONTRARIO NO AVANZAREMOS */
                        $check_fraccion_corte_rayado_foleado = $this->db->select('COUNT(*) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')->where('F.control', $xXx['CONTROL'])
                                        ->where_in('F.numfrac', array(100, 102, 60))
                                        ->get()->result();
                        if (intval($check_fraccion_corte_rayado_foleado[0]->EXISTE) <= 2) {
                            print json_encode(array("AVANZO" => 0, "RETORNO" => 1, "AVANCE_REBAJADO" => "NO"));
                            EXIT(0);
                        }

                        if (intval($xXx['NUMERO_EMPLEADO']) === 1894 ||
                                intval($xXx['NUMERO_EMPLEADO']) === 49) {
                            /* REVISAR SI LA FRACCION "102 RAYADO" NO HA SIDO PAGADA A OTRO EMPLEADO */
                            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                            ->from('fracpagnomina AS F')
                                            ->where('F.control', $xXx['CONTROL'])
                                            ->where('F.numfrac', $FRACCION)
                                            ->get()->result();

                            if (intval($check_fraccion[0]->EXISTE) === 0) {
                                $data["fraccion"] = $FRACCION;
                                $data["numfrac"] = $FRACCION;
                                /* FILTRADO POR FRACCION 102 RAYADO */
                                $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$FRACCION}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                                $data["preciofrac"] = $PXFC;
                                $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));


                                $REVISA_AVANCE_REBAJADO = $avance = array(
                                    'Control' => $xXx['CONTROL'],
                                    'FechaAProduccion' => Date('d/m/Y'),
                                    'Departamento' => 30,
                                    'DepartamentoT' => 'REBAJADO',
                                    'FechaAvance' => Date('d/m/Y'),
                                    'Estatus' => 'A',
                                    'Usuario' => $_SESSION["ID"],
                                    'Fecha' => Date('d/m/Y'),
                                    'Hora' => Date('h:i:s a'),
                                    'Fraccion' => 103
                                );
                                $this->db->insert('avance', $avance);
                                $id = $this->db->insert_id();
                                $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;

                                $this->db->insert('fracpagnomina', $data);
                            }

                            /* AVANCE */
                            $revisar_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Departamento IN(10,20,40) AND A.Control ={$xXx['CONTROL']}")->result();
                            if (intval($revisar_avance[0]->EXISTE) === 3) {
                                //25101503
                                /* 28 / 01 / 2020 */
                                /* REVISAR SI TIENE ENTRETELADO */
                                $REVISAR_ENTRETELADO_X_ESTILO_CONTROL = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS F WHERE F.Fraccion = 51 AND F.Estilo = '{$xXx['ESTILO']}' LIMIT 1")->result();
                                if (intval($REVISAR_ENTRETELADO_X_ESTILO_CONTROL[0]->EXISTE) === 1) {
                                    $this->onAvanzarXControl($xXx['CONTROL'], 'ENTRETELADO', 90, 40);
                                    $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                                    . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 90")->result();
                                    if (intval($check_avance[0]->EXISTE) === 0) {
                                        $this->db->insert('avance', array(
                                            'Control' => $xXx['CONTROL'], 'FechaAProduccion' => Date('d/m/Y'),
                                            'Departamento' => 90, 'DepartamentoT' => 'ENTRETELADO',
                                            'FechaAvance' => Date('d/m/Y'), 'Estatus' => 'A',
                                            'Usuario' => $_SESSION["ID"], 'Fecha' => Date('d/m/Y'),
                                            'Hora' => Date('h:i:s a'), 'Fraccion' => 51
                                        ));
                                        $id = $this->db->insert_id();
                                        $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                                    }
                                    print '{"AVANZO":"1","FR":"' . $FRACCION . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A ENTRETELADO - SWITCH 30 EMPLEADO 49 FRACCION ' . $FRACCION . '"}';
                                    exit(0);
                                } else {
                                    $this->onAvanzarXControl($xXx['CONTROL'], 'MAQUILA', 100, 42);
                                    $revisa_proceso_maquila = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                                    . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 100")->result();
                                    if (intval($revisa_proceso_maquila[0]->EXISTE) === 0) {
                                        $avance = array(
                                            'Control' => $xXx['CONTROL'],
                                            'FechaAProduccion' => Date('d/m/Y'),
                                            'Departamento' => 100,
                                            'DepartamentoT' => 'MAQUILA',
                                            'FechaAvance' => Date('d/m/Y'),
                                            'Estatus' => 'A',
                                            'Usuario' => $_SESSION["ID"],
                                            'Fecha' => Date('d/m/Y'),
                                            'Hora' => Date('h:i:s a'),
                                            'Fraccion' => 0
                                        );
                                        $this->db->insert('avance', $avance);
                                    }
                                    print '{"AVANZO":"1","FR":"' . $FRACCION . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A MAQUILA - SWITCH 30 EMPLEADO ' . $xXx['NUMERO_EMPLEADO'] . ' FRACCION ' . $FRACCION . '"}';
                                    exit(0);
                                }
                                /**/
                                /* PAGAR LA FRACCION 103 AL EMPLEADO 49 */
                            }
                            print '{"AVANZO":"1","FR":"' . $FRACCION . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A ENTRETELADO - SWITCH 30 EMPLEADO 49 FRACCION ' . $FRACCION . '"}';
                            exit(0);
                        } else {
                            print "\n 105 ALMACEN DE CORTE";
                            exit(0);
                        }
                        break;
                    case 300:
                        /* SOLO SUPERVISION */
                        /* PESPUNTE */
                        $FRACCION = 300; //PESPUNTE GENERAL
                        $MAQUILA = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx["CONTROL"]} LIMIT 1")->result();
                        if (intval($MAQUILA[0]->MAQUILA) === 98) {
                            $FRACCION = 299; //PESPUNTE MUESTRA
                        }
                        $this->onAvanzarXControl($xXx['CONTROL'], 'PESPUNTE', 110, 5);
                        break;
                }
            } else {
                if (intval($xXx['DEPARTAMENTO']) === 10) {
                    PRINT json_encode(array("AVANZO" => 0, "DEPTO" => 10));
                    exit(0);
                }
                if (count($FRACCIONES) > 1) {
                    $msj .= "]";
                }
                print $msj;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            $xXx = $this->input->post();
            $fecha = $xXx['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);
            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $data = array(
                "numeroempleado" => $xXx['NUMERO_EMPLEADO'],
                "maquila" => intval(substr($xXx['CONTROL'], 4, 2)),
                "control" => $xXx['CONTROL'],
                "estilo" => $xXx['ESTILO'],
                "numfrac" => $xXx['NUMERO_FRACCION'],
                "preciofrac" => $xXx['PRECIO_FRACCION'],
                "pares" => $xXx['PARES'],
                "subtot" => (floatval($xXx['PARES']) * floatval($xXx['PRECIO_FRACCION'])),
                "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPARTAMENTO'],
                "fecha_registro" => Date('d/m/Y h:i:s'),
                "anio" => $xXx['ANIO']);

            $departamento = $xXx['DEPARTAMENTO'];
            switch ($departamento) {
                case 10:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 20:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 30:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 40:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 60:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 70:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
                case 80:
                    $data["fraccion"] = 102;
                    $this->db->insert('fracpagnomina', $data);
                    break;
            }
            print '{"AVANZO":"1"}';
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzarARebajado($data, $xXx) {
        try {
            $xfraccion = 60;
//                            print '{"AVANZO":"0","FR":"102","RETORNO":"SI","MESSAGE":"EL CONTROL YA HA SIDO AVANZADO A FOLEADO - SWITCH 80 "}';
            /* SI LA FRACCION 102 YA FUE REGISTRADA PERO EL DEPTO ES 80 ENTONCES PASAR A  40 FOLEADO CON LA FRACCION 60 */
            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                            ->from('fracpagnomina AS F')
                            ->where('F.control', $xXx['CONTROL'])
                            ->where('F.numfrac', $xfraccion)
                            ->get()->result();

            if (intval($check_fraccion[0]->EXISTE) >= 1) {
                print '{"AVANZO":"0","FR":"' . $xfraccion . '","RETORNO":"SI","MESSAGE":"EL CONTROL YA HA SIDO AVANZADO A REBAJADO - onAvanzarARebajado"}';
                exit(0);
            }
            $data["fraccion"] = $xfraccion;
            $data["numfrac"] = $xfraccion;
            /* FILTRADO POR FRACCION 102 RAYADO */
            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
            $data["preciofrac"] = $PXFC;
            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
            if (intval($check_fraccion[0]->EXISTE) <= 0) {
                /* GENERAR UN AVANCE A REBAJADO */
                $avance = array(
                    'Control' => $xXx['CONTROL'],
                    'FechaAProduccion' => Date('d/m/Y'),
                    'Departamento' => 30,
                    'DepartamentoT' => 'REBAJADO',
                    'FechaAvance' => Date('d/m/Y'),
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => 103
                );
                $this->db->insert('avance', $avance);
                $id = $this->db->insert_id();
                /* ENLACE AL SIG AVANCE */
                $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                /* PAGAR LA FRACCION 60 AL EMPLEADO */
                $this->db->insert('fracpagnomina', $data);

                /* ACTUALIZA A 30 REBAJADO, stsavan 33 */
                $this->onAvanzarXControl($xXx['CONTROL'], 'REBAJADO', 30, 33);
                print '{"AVANZO":"1","FR":"' . $xfraccion . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A REBAJADO - onAvanzarARebajado"}';
                exit(0);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzarXControl($CONTROL, $ESTATUS_PRODUCCION, $DEPTO_PRODUCCION, $STSAVAN) {
        try {
            $this->db->trans_begin();
            $this->db->set('EstatusProduccion', $ESTATUS_PRODUCCION)
                    ->set('DeptoProduccion', $DEPTO_PRODUCCION)
                    ->where('Control', $CONTROL)->update('controles');
            $this->db->set('stsavan', $STSAVAN)
                    ->set('EstatusProduccion', $ESTATUS_PRODUCCION)
                    ->set('DeptoProduccion', $DEPTO_PRODUCCION)
                    ->where('Control', $CONTROL)->update('pedidox');
            $this->db->set("fec{$STSAVAN}", Date('Y-m-d 00:00:00'))
                    ->where('contped', $CONTROL)->update('avaprd');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarCobroDeCorteParaRAYADO() {
        try {
            $x = $this->input->get();
            $avance_pago = array();
            /* 1 REVISAR SI YA ESTA COBRADO POR CORTE FRACCION 100 */
            $sql = "SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.numfrac = 100 AND F.control = {$x['CONTROL']} LIMIT 1";
            $revisa_cobro_de_corte = $this->db->query($sql)->result();
            if (intval($revisa_cobro_de_corte[0]->EXISTE) >= 1) {
                $avance_pago['COBRO_CORTE'] = "SI";
                $avance_pago['PUEDE_AVANZAR_A_RAYADO'] = "SI";
                $avance_pago['PUEDE_AVANZAR_A_RAYADO_VALIDA'] = 1;
            } else {
                $sql = "SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.numfrac = 102 AND F.control = {$x['CONTROL']} LIMIT 1";
                $revisa_cobro = $this->db->query($sql)->result();
                if (intval($revisa_cobro[0]->EXISTE) === 0 && intval($revisa_cobro_de_corte[0]->EXISTE) >= 1) {
                    $avance_pago['COBRO_CORTE'] = "SI";
                    $avance_pago['PUEDE_AVANZAR_A_RAYADO'] = "SI";
                    $avance_pago['PUEDE_AVANZAR_A_RAYADO_VALIDA'] = 1;
                } else {
                    $avance_pago['COBRO_CORTE'] = "NO";
                    $avance_pago['PUEDE_AVANZAR_A_RAYADO'] = "NO";
                    $avance_pago['PUEDE_AVANZAR_A_RAYADO_VALIDA'] = 0;
                }
            }
            /* 1 REVISAR SI YA ESTA AVANZADO POR CORTE EN PEDIDOS stsavan 2 */
            $stsavan = 3; /* ESTACIONADO EN RAYADO */
            $xsql = "SELECT COUNT(*) AS EXISTE,(SELECT PS.stsavan FROM pedidox AS PS WHERE PS.Control = {$x['CONTROL']} LIMIT 1) AS AVANCE FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} AND P.stsavan = {$stsavan} LIMIT 1";
            $revisa_avance_de_corte = $this->db->query($xsql)->result();
            if (intval($revisa_avance_de_corte[0]->EXISTE) >= 1) {
                $avance_pago['AVANZO_EN_CORTE'] = "SI";
                $avance_pago['AVANZO_ACTUAL'] = $this->avances[intval($revisa_avance_de_corte[0]->AVANCE)];
            } else {
                $avance_pago['AVANZO_EN_CORTE'] = "NO";
                $avance_pago['AVANZO_ACTUAL'] = $this->avances[intval($revisa_avance_de_corte[0]->AVANCE)];
            }
            print json_encode(array($avance_pago));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarCobroDeFoleadoParaREBAJADO() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilaXControl($CONTROL) {
        try {

            $MAQUILA = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$CONTROL} LIMIT 1")->result();

            return $MAQUILA[0];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
