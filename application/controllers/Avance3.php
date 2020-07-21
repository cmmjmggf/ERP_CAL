<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avance3 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vFondo')->view('vAvance3')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getSemanaByFecha() {
        try {
            $fecha = Date('d/m/Y');
            $this->db->select("U.Sem, '{$fecha}' AS Fecha", false)
                    ->from('semanasnomina AS U')
                    ->where("STR_TO_DATE(\"{$fecha}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionEmpleado() {
        try {
            $x = $this->input->get();
            $this->db->select("(CASE WHEN E.PrimerNombre = '0' AND E.SegundoNombre = '0' THEN E.Busqueda ELSE "
                            . "CONCAT(E.PrimerNombre,' ',"
                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) END) AS NOMBRE_COMPLETO, "
                            . "E.DepartamentoFisico AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Clave AS DEPTO, D.Descripcion AS DEPTO_DES, E.Busqueda AS CELULAS ", false)
                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                    ->where('E.Numero', $x['EMPLEADO'])
                    ->where_in('E.AltaBaja', array(1));
            $this->db->where_in('E.FijoDestajoAmbos', array(2, 3))->where_in('E.DepartamentoFisico', 110);
            $D = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($D);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.Pares AS PARES, P.Estilo AS ESTILO, P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x['CONTROL']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function FraccionesPespunteXEmpleadoControl() {
        try { 
            $x = $this->input->get();
            $span = "<span class='font-weight-bold' style='color: #f50101 !important'>";
            $SPAN_308 = "{$span}308</span>";
            $SPAN_309 = "{$span}309</span>";
            $SPAN_315 = "{$span}315</span>";
            $SPAN_322 = "{$span}322</span>";
            $SPAN_324 = "{$span}324</span>";
            $SPAN_405 = "{$span}405</span>";
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "(CASE "
                            . "WHEN FACN.numfrac = 308 THEN \"$SPAN_308\" "
                            . "WHEN FACN.numfrac = 309 THEN \"$SPAN_309\" "
                            . "WHEN FACN.numfrac = 315 THEN \"$SPAN_315\" "
                            . "WHEN FACN.numfrac = 322 THEN \"$SPAN_322\" "
                            . "WHEN FACN.numfrac = 324 THEN \"$SPAN_324\" "
                            . "WHEN FACN.numfrac = 405 THEN \"$SPAN_405\" "
                            . "ELSE FACN.numfrac "
                            . "END) AS FRAC, "
                            . "FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, "
                            . "FORMAT(FACN.subtot,2) AS SUBTOTAL, "
                            . "CONCAT('<span class=\"precio-pagado\">$',FORMAT(FACN.subtot,2),'</span>') AS SUBTOTAL_SPAN, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN');
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('FACN.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('FACN.semana', $x['SEMANA']);
            }
            $this->db->order_by('ABS(FACN.ID)', 'DESC')
                    ->order_by('ABS(FACN.anio)', 'DESC')
                    ->order_by('ABS(FACN.semana)', 'DESC');
            if ($x['EMPLEADO'] === '') {
                $this->db->where('FACN.numeroempleado', 99999999999999);
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
            $x = $this->input->get();
            $ANIO = Date('Y');
            $a = "IFNULL((SELECT FORMAT(SUM(fpn.subtot),2) FROM fracpagnomina AS fpn WHERE dayofweek(fpn.fecha)";
            $b = "AND fpn.numeroempleado = '{$x['EMPLEADO']}' AND fpn.Semana = {$x['SEMANA']} AND YEAR(fpn.fecha) = {$ANIO}  GROUP BY dayofweek(fpn.fecha)),0)";
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

    public function onPagarFraccionesPespunte() {
        try {
            $x = $this->input->post();
            $FRACCIONES = json_decode($x['FRACCIONES'], false);
            
            $MAQUILA = $this->db->query("SELECT P.Pares AS PARES, P.Estilo AS ESTILO, P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x['CONTROL']}")->result()[0];
            $MAQUILA_MUESTRA = intval($MAQUILA->MAQUILA) === 98 ? 98 : intval($MAQUILA->MAQUILA);

            $fecha = $x['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);
            $CONTROL_EXISTE = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} AND P.stsavan NOT IN(12,13,14) AND P.DeptoProduccion NOT IN(270) AND P.EstatusProduccion NOT IN('CANCELADO') AND P.Estatus NOT IN('C') LIMIT 1")->result();
            if (intval($CONTROL_EXISTE[0]->EXISTE) === 0) {
                print "\n * * * CONTROL CANCELADO * * * \n";
                exit(0);
            }
            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result();
            $data = array(
                "numeroempleado" => $x['NUMERO_EMPLEADO'],
                "maquila" => intval($CONTROL[0]->MAQUILA),
                "control" => $x['CONTROL'],
                "estilo" => $x['ESTILO'],
                "pares" => $x['PARES'],
                "fecha" => $nueva_fecha->format('Y-m-d 00:00:00'),
                "semana" => $x['SEMANA'],
                "fecha_registro" => Date('d/m/Y h:i:s'),
                "depto" => 110,
                "anio" => Date('Y'));
            foreach ($FRACCIONES as $k => $v) {
                $NUMERO_ENTERO_FRACCION = intval($v->NUMERO_FRACCION);
                $check_fraccion_x_estilo = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS F WHERE F.Fraccion = {$NUMERO_ENTERO_FRACCION} AND F.Estilo= '{$x['ESTILO']}'")->result();
                if (intval($check_fraccion_x_estilo[0]->EXISTE) > 0) {
                    $PRECIO_FRACCION_CONTROL = $this->db->select("P.Estilo, P.Pares, F.CostoMO, "
                                            . "(P.Pares*F.CostoMO) AS TOTAL, {$NUMERO_ENTERO_FRACCION} AS Fraccion", false)
                                    ->from("pedidox AS P")->join('fraccionesxestilo as F', 'P.Estilo = F.Estilo')
                                    ->where("F.Fraccion", $NUMERO_ENTERO_FRACCION)
                                    ->where("P.Control", $x['CONTROL'])->get()->result();

                    $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                    $data["numfrac"] = $v->NUMERO_FRACCION;
                    $data["preciofrac"] = $PXFC;
                    $data["subtot"] = (floatval($x['PARES']) * floatval($PXFC));
                    $retorno_material = $this->db->select("COUNT(*) AS EXISTE", false)
                                    ->from('asignapftsacxc AS A')
                                    ->where("A.Control", $x['CONTROL'])
                                    ->where("A.Empleado<>", 0)
                                    ->order_by('A.ID', 'DESC')
                                    ->limit(1)->get()->result();
                    /* SI EL CONTROL, LA FRACCION Y EL EMPLEADO HA REGRESADO ESTE MATERIAL SE OBTIENE UN "1" DE LO CONTRARIO SI EL NO REGRESO EL MATERIAL SE DEVUELVE "0" */
                    if (intval($retorno_material[0]->EXISTE) >= 1) {
                        /* PASO 1 : AGREGAR AVANCE (DEBE DE ESTAR EN CORTE EL CONTROL, ADEMÁS DEBE DE ) */
                        /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE (20 - RAYADO) PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
                        $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)
                                        ->from('avance AS A')
                                        ->where('A.Control', $x['CONTROL'])
                                        ->where('A.Departamento', 140)
                                        ->where('A.Fraccion', $v->NUMERO_FRACCION)
                                        ->get()->result();

                        /* REVISAR QUE ESTE EN PESPUNTE, REVISAR QUE NO SE HAYA PAGADO EN CONTROLES PLANTILLA NI EN NOMINA COMUN */
                        if (intval($check_avance[0]->EXISTE) <= 0) {
                            $id = 0;
                            $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)
                                            ->from('controlpla AS C')
                                            ->where('C.Control', $x['CONTROL'])
                                            ->where('C.Fraccion', $v->NUMERO_FRACCION)
                                            ->get()->result();

                            /* PASO 2 : AGREGAR FRACCION PAGADA */
                            $check_pago_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                            ->from('fracpagnomina AS F')
                                            ->where('F.control', $x['CONTROL'])
                                            ->where('F.numfrac', $v->NUMERO_FRACCION)
                                            ->get()->result();

                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            if (intval($check_pago_fraccion[0]->EXISTE) <= 0 && intval($check_fraccion_plantilla[0]->EXISTE) <= 0 || intval($check_fraccion[0]->EXISTE) === 1) {
                                $data["avance_id"] = NULL;
                                $data["modulo"] = 'A3';
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 3", "LE PAGO LA FRACCION {$v->NUMERO_FRACCION} DEL CONTROL {$x["CONTROL"]} AL CORTADOR {$x['NUMERO_EMPLEADO']}", $this->session);
                            }
                        }
                    } else {
                        /* EL CORTADOR NO HA REGRESADO MATERIAL O EL ALMACENISTA NO HA REGISTRADO EL RETORNO DEL MATERIAL */
                    
                    }
                    
                }
            }// *** FIN FOREACH DE FRACCIONES JSON ***
            print json_encode($this->db->query("SELECT * FROM fracpagnomina AS F WHERE F.control = {$x["CONTROL"]}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
