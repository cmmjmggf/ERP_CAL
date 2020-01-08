<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class Avance8 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance8_model', 'axepn');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vEncabezado')->view('vAvance8')->view('vFooter');
                    break;
                case 'DESTAJOS':
                    switch ($this->session->USERNAME) {
                        case '888888':
                            /*
                             *
                             * 51 ENTRETELADO
                             * 70 TROQUELAR PLANTILLA
                             * 60 FOLEAR CORTE Y CALIDAD
                             * 62 FOLEADO MUESTRA
                             * 24 DOMAR
                             * 78 LIMPIAR LASER
                             * 204 EMPALMAR P/LASER
                             * 205 APLICA PEGA.P/LASER
                             * 198 LOTEAR P/LASER
                             * 127 ENTRETELAR MUESTRA
                             * 80 CONTAR TAREA
                             * 397 JUNTAR SUELA A CORTE
                             * 34 PEGAR TRANSFER
                             * 106 DOBLILLADO
                             * 306 FORRAR PLATAFORMA
                             * 337 RECORTAR FORRO LASER
                             * 333 PONER CASCO PESPUNTE
                             * 502 PEGADO DE SUELA
                             * 72 TROQUELAR NORMA
                             *
                             * */
                            $this->load->view('vEncabezado')->view('vAvance8')->view('vFooter');
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
            print json_encode($this->axepn->getSemanaByFecha(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFraccionXEstilo() {
        try {
            $x = $this->input;
            $xxx = $this->input->get();
            $FRACCIONES = json_decode($xxx['FRACCIONES'], false);
            $FRNS = "";
            $i = 1;
            foreach ($FRACCIONES as $k => $v) {
//                print "{$v->NUMERO_FRACCION} = {$v->DESCRIPCION} \n";
                if (count($FRACCIONES) > 1 && $i < count($FRACCIONES)) {
                    $FRNS .= "{$v->NUMERO_FRACCION},";
                    $i += 1;
                } else {
                    $FRNS .= "{$v->NUMERO_FRACCION}";
                }
            }
//            print "\n $FRNS \n"; 
            $FRACCIONES_X_ESTILO = $this->db->select("COUNT(*) AS TOTAL_FRAC, C.Estilo AS ESTILO, C.Pares AS PARES", false)
                            ->from('pedidox as C')
                            ->join('fraccionesxestilo as FXE', 'C.Estilo = FXE.Estilo')
                            ->where("C.Control = {$xxx['CONTROL']} AND FXE.Fraccion IN({$FRNS})", null, false)->get()->result();
//            print $this->db->last_query() . "\n";
            $TOTAL_FRACCIONES = intval($FRACCIONES_X_ESTILO[0]->TOTAL_FRAC);
            if ($TOTAL_FRACCIONES > 0) {
                if ($TOTAL_FRACCIONES === $i) {
                    print json_encode(
                                    array(
                                        "FRACCIONES_SELECCIONADAS" => $i,
                                        "FRACCIONES_X_ESTILO_ENCONTRADAS" => $TOTAL_FRACCIONES,
                                        "FALTAN" => $i - $TOTAL_FRACCIONES,
                                        "FRACCIONES_VALIDAS" => $TOTAL_FRACCIONES,
                                        "STEP" => 1,
                                        "ESTILO" => $FRACCIONES_X_ESTILO[0]->ESTILO,
                                        "PARES" => $FRACCIONES_X_ESTILO[0]->PARES
                    ));
                    exit(0);
                } else {
                    print json_encode(
                                    array(
                                        "FRACCIONES_SELECCIONADAS" => $i,
                                        "FRACCIONES_X_ESTILO_ENCONTRADAS" => $TOTAL_FRACCIONES,
                                        "FALTAN" => $i - $TOTAL_FRACCIONES,
                                        "FRACCIONES_VALIDAS" => $TOTAL_FRACCIONES,
                                        "STEP" => 2,
                                        "ESTILO" => $FRACCIONES_X_ESTILO[0]->ESTILO,
                                        "PARES" => $FRACCIONES_X_ESTILO[0]->PARES
                    ));
                    exit(0);
                }
            } else {
                print json_encode(
                                array(
                                    "FRACCIONES_SELECCIONADAS" => $i,
                                    "FRACCIONES_X_ESTILO_ENCONTRADAS" => $TOTAL_FRACCIONES,
                                    "FALTAN" => $i - $TOTAL_FRACCIONES,
                                    "FRACCIONES_VALIDAS" => 0,
                                    "STEP" => 3,
                                    "ESTILO" => "-",
                                    "PARES" => "-"
                ));
                exit(0);
            }


            /* cr = control, fr = fraccion */
            $control = $this->db->select('P.Estilo', false)->from('pedidox AS P')->where('P.Control', $x->get('CR'))->get()->result();
            print json_encode($this->axepn->getInfoXControl($x->get('CR')));

            $this->db->select("C.Estilo, C.Pares, FXE.CostoMO, (C.Pares * FXE.CostoMO) AS TOTAL", false)
                    ->from('pedidox as C')
                    ->join('fraccionesxestilo as FXE', 'C.Estilo = FXE.Estilo')
                    ->where("C.Control", $xxx['CR'])->limit(1)->get()->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            $x = $this->input->get();
//            print json_encode($this->axepn->getUltimoAvanceXControl($x->get('C')));
            print json_encode($this->db->select(
                                            "A.ID, A.Control, A.FechaAProduccion, "
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
             * 30 REBAJADO Y PERFORADO
             * 40 FOLEADO
             * 60 LASER
             * 70 PREL-CORTE
             * 80 RAYADO CONTADO
             * 90 ENTRETELADO
             * 
             * ADEMÁS EL EMPLEADO DEBE DE ESTAR A DESTAJO O AMBOS, NO COMO EMPLEADO FIJO
             * 
             * DE LO CONTRARIO ARROJAR UN MENSAJE
             */
//            $EMPLEADO_VALIDO = $this->axepn->onComprobarDeptoXEmpleado($this->input->post('EMPLEADO'));
//            print json_encode($EMPLEADO_VALIDO);
//            $x = $this->input->post();
//            print json_encode($this->db->select("CONCAT(E.PrimerNombre,' ',"
//                                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
//                                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
//                                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
//                                            . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Descripcion AS DEPTO", false)
//                                    ->from('empleados AS E')->join('departamentos AS D', 'D.Clave = E.DepartamentoFisico')
//                                    ->where('E.Numero', $x['EMPLEADO'])
//                                    ->where_in('E.AltaBaja', array(1))
//                                    ->where_in('E.FijoDestajoAmbos', array(2, 3))
//                                    ->where_in('E.DepartamentoFisico', array(20, 30, 40/* PREL-CORTE */, 60, 80/* RAYADO CONTADO */, 90/* ENTRETELADO */, 140/* ENSUELADO */))
//                                    ->get()->result());

            $DEPTOS_FISICOS = array(20, 30, 40/* PREL-CORTE */, 60, 120, 140, 70, 80/* RAYADO CONTADO */, 90/* ENTRETELADO */, 140/* ENSUELADO */, 300 /* SUPERVISORES */);
            $xXx = $this->input->post();
            $EXISTE = $this->db->query("SELECT COUNT(*) AS EXISTE FROM empleados AS E WHERE E.Numero = {$xXx["EMPLEADO"]} LIMIT 1")->result();
            if ($EXISTE[0]->EXISTE <= 0) {
                print json_encode(array("NOEXISTE" => 0, "EMPLEADO" => $xXx["EMPLEADO"]));
                exit(0);
            }
            $ES_SUPERVISOR = $this->db->query("SELECT E.DepartamentoFisico AS DEPTO FROM empleados AS E WHERE E.Numero = {$xXx["EMPLEADO"]} LIMIT 1")->result();

            $this->db->select("CONCAT(E.PrimerNombre,' ',"
                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
                            . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Descripcion AS DEPTO", false)
                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                    ->where('E.Numero', $this->input->post('EMPLEADO'))
                    ->where_in('E.AltaBaja', array(1, 2));
            if (intval($ES_SUPERVISOR[0]->DEPTO) === 300) {
                $this->db->where_in('E.FijoDestajoAmbos', array(1, 2, 3));
            } else {
                $this->db->where_in('E.FijoDestajoAmbos', array(2, 3));
            }
            $this->db->where_in('E.DepartamentoFisico', $DEPTOS_FISICOS);
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesPagoNomina() {
        try {
            $url = $this->uri;
            $x = $this->input->get();
            $this->db->select("F.ID, F.numeroempleado, F.maquila, "
                            . "F.control AS CONTROL, F.estilo AS ESTILO, "
                            . "F.numfrac AS FRAC, F.preciofrac AS PRECIO, "
                            . "F.pares AS PARES, CONCAT('$',FORMAT(F.subtot,2)) AS SUBTOTAL, "
                            . "F.status, DATE_FORMAT(F.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "F.semana AS SEMANA, F.depto AS DEPARTAMENTO, "
                            . "F.registro, F.anio, F.avance_id", false)
                    ->from('fracpagnomina AS F')
                    ->where("F.numfrac IN(51, 70,60,61,62,24,78,204,205,198,127,80,397,34,106,306,337,333,502,72,607,606)", null, false);
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('F.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['ANO_FILTRO'] !== '') {
                $this->db->where('FACN.anio', $x['ANO_FILTRO']);
            }
            if ($x['SEMANA_FILTRO'] !== '') {
                $this->db->where('F.semana', $x['SEMANA_FILTRO']);
            }
            if ($x['FRACCION_FILTRO'] !== '') {
                $this->db->where('F.numfrac', $x['FRACCION_FILTRO']);
            }
            $this->db->order_by('ABS(F.semana)', 'DESC');
            if ($x['EMPLEADO'] === '') {
                $this->db->limit(25);
            }
            $dtm = $this->db->get()->result();
//            print $this->db->last_query();
            print json_encode($dtm);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPagosXEmpleadoXSemana() {
        try {
            $x = $this->input->get();
            $ANIO = Date('Y');
            $a = "IFNULL((SELECT FORMAT(SUM(fpn.subtot),2) FROM fracpagnomina AS fpn WHERE dayofweek(fpn.fecha)  ";
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
            $x = $this->input->post();
            $xXx = $this->input->post();
            $fecha = $x['FECHA'];
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $FRACCIONES = json_decode($xXx['FRACCIONES'], false);
            $AVANCES = array("AVANZO" => 0, "FRACCIONES" => count($FRACCIONES));
//            var_dump($FRACCIONES);
//            exit(0);
            foreach ($FRACCIONES as $k => $v) {

                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE, F.numfrac', false)
                                ->from('fracpagnomina AS F')
                                ->where('F.control', $xXx['CONTROL'])
                                ->where('F.numfrac', $v->NUMERO_FRACCION)
                                ->get()->result();
//                print $this->db->last_query();
                if ($check_fraccion[0]->EXISTE <= 0) {
                    $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL FROM pedidox AS A INNER JOIN fraccionesxestilo as FXE ON A.Estilo = FXE.Estilo WHERE  FXE.Fraccion = {$v->NUMERO_FRACCION} AND A.Control = {$xXx['CONTROL']}")->result();
                    $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
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
                        "depto" => $xXx['DEPARTAMENTO'],
                        "anio" => $xXx['ANIO']);
                    $data["numfrac"] = $v->NUMERO_FRACCION;
                    $data["preciofrac"] = $PXFC;
                    $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                    /* SOLO FRACCION 51 ENTRETELADO Y 397 ENSUELADO */
                    $id = 0;
                    switch (intval($x['NUMERO_FRACCION'])) {
                        case 51:
                            /* 51 = ENTRETELADO */
                            /* SE REVISA SI SE TIENE QUE MAQUILAR EL ESTILO */
                            $check_maquila = $this->db->select('(CASE WHEN E.MaqPlant1 IS NULL THEN 0 ELSE E.MaqPlant1 END) AS MP1, '
                                                    . '(CASE WHEN E.MaqPlant2 IS NULL THEN 0 ELSE E.MaqPlant2 END) AS MP2, '
                                                    . '(CASE WHEN E.MaqPlant3 IS NULL THEN 0 ELSE E.MaqPlant3 END) AS MP3,  '
                                                    . '(CASE WHEN E.MaqPlant4 IS NULL THEN 0 ELSE E.MaqPlant4 END) AS MP4', false)
                                            ->from('estilos AS E')->like('E.Clave', $xXx['ESTILO'])->get()->result();
                            /* SI NO TIENE NINGUNA MAQUILA O ESTA EN ZERO O NULO */
                            if (intval($check_maquila[0]->MP1) === 0 &&
                                    intval($check_maquila[0]->MP2) === 0 &&
                                    intval($check_maquila[0]->MP3) === 0 &&
                                    intval($check_maquila[0]->MP4) === 0) {
                                /* ACTUALIZA A 105 ALMACEN CORTE, stsavan 44 */

                                $avance = array(
                                    'Control' => $xXx['CONTROL'],
                                    'FechaAProduccion' => Date('d/m/Y'),
                                    'Departamento' => 105,
                                    'DepartamentoT' => 'ALMACEN CORTE',
                                    'FechaAvance' => Date('d/m/Y'),
                                    'Estatus' => 'A',
                                    'Usuario' => $_SESSION["ID"],
                                    'Fecha' => Date('d/m/Y'),
                                    'Hora' => Date('h:i:s a'),
                                    'Fraccion' => 0
                                );
                                $this->db->insert('avance', $avance);
                                $id = $this->db->insert_id();

                                $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('controles');
                                $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')
                                        ->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])
                                        ->update('pedidox');
                                $this->db->set('fec44', Date('Y-m-d 00:00:00'))
                                        ->where('contped', $xXx['CONTROL'])
                                        ->update('avaprd');
                            } else {
                                /* SI TIENE MAQUILA EL ESTILO EJ: 18 DOMADO SILUETEADO */
                                $avance = array(
                                    'Control' => $x['CONTROL'],
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
                                $id = $this->db->insert_id();
                                /* ACTUALIZA A 100 MAQUILA, stsavan 42 */
                                $this->db->set('EstatusProduccion', 'MAQUILA')->set('DeptoProduccion', 100)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('controles');
                                $this->db->set('stsavan', 42)->set('EstatusProduccion', 'MAQUILA')
                                        ->set('DeptoProduccion', 100)->where('Control', $xXx['CONTROL'])
                                        ->update('pedidox');
                                $this->db->set('fec42', Date('Y-m-d 00:00:00'))
                                        ->where('contped', $xXx['CONTROL'])
                                        ->update('avaprd');
                            }
                            break;
                        case 397:
                            /* AVANCE 397 ENSUELADO */
                            $avance = array(
                                'Control' => $xXx['CONTROL'],
                                'FechaAProduccion' => Date('d/m/Y'),
                                'Departamento' => 130,
                                'DepartamentoT' => 'ALMACEN PESPUNTE',
                                'FechaAvance' => Date('d/m/Y'),
                                'Estatus' => 'A',
                                'Usuario' => $_SESSION["ID"],
                                'Fecha' => Date('d/m/Y'),
                                'Hora' => Date('h:i:s a'),
                                'Fraccion' => $v->NUMERO_FRACCION
                            );
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();


                            $this->db->set('EstatusProduccion', 'ALMACEN PESPUNTE')
                                    ->set('DeptoProduccion', 130)
                                    ->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 6)
                                    ->set('EstatusProduccion', 'ALMACEN PESPUNTE')
                                    ->set('DeptoProduccion', 130)
                                    ->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set("status", 6)->set("fec6", Date('Y-m-d 00:00:00'))
                                    ->where('contped', $xXx['CONTROL'])->update('avaprd');

                            break;
                        case 301:
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                            $this->db->insert('fracpagnomina', $data);
                            print json_encode(array("AVANZO" => 2, "STEP" => 1));
                            exit(0);
                            break;
                        case 24:
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                            $this->db->insert('fracpagnomina', $data);
                            print json_encode(array("AVANZO" => 2, "STEP" => 1));
                            exit(0);
                            break;
                        case 325:
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                            $this->db->insert('fracpagnomina', $data);
                            print json_encode(array("AVANZO" => 2, "STEP" => 1));
                            exit(0);
                            break;
                        case 74:
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                            $this->db->insert('fracpagnomina', $data);
                            print json_encode(array("AVANZO" => 2, "STEP" => 1));
                            exit(0);
                            break;
                        case 130:
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                            $this->db->insert('fracpagnomina', $data);
                            print json_encode(array("AVANZO" => 2, "STEP" => 1));
                            exit(0);
                            break;
                    }

                    /* PAGAR FRACCIONES */
                    $data["fraccion"] = $v->NUMERO_FRACCION;
                    $data["avance_id"] = intval($id) > 0 ? intval($id) : NULL;
                    if (intval($v->NUMERO_FRACCION) === 60) {
                        $avance = array(
                            'Control' => $xXx['CONTROL'],
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 70,
                            'DepartamentoT' => 'PREL-CORTE',
                            'FechaAvance' => Date('d/m/Y'),
                            'Estatus' => 'A',
                            'Usuario' => $_SESSION["ID"],
                            'Fecha' => Date('d/m/Y'),
                            'Hora' => Date('h:i:s a'),
                            'Fraccion' => $v->NUMERO_FRACCION
                        );
                        $this->db->insert('avance', $avance);
                        $id = $this->db->insert_id();
                        $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                        $this->db->insert('fracpagnomina', $data);
                        print json_encode(array("AVANZO" => 2, "STEP" => 1));
                        exit(0);
                    } else {
                        if ((floatval($xXx['PARES']) * floatval($PXFC)) > 0) {
                            $this->db->insert('fracpagnomina', $data);
                        }
                    }
//                    print json_encode(array("AVANZO" => 1, "STEP" => 1));
                    $AVANCES["AVANZO"] = intval($AVANCES["AVANZO"]) + 1;
                } else {
                    print json_encode(array("AVANZO" => 2, "STEP" => 1));
                    exit(0);
                }
            }
            print json_encode($AVANCES);
            exit(0);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl() {
        try {
            $x = $this->input->get();



            exit(0);
            if ($x['FR'] !== '') {
                $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
                        ->from('asignapftsacxc AS A')
                        ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo');
                $this->db->where("A.Fraccion", $x['FR'])->where("FXE.Fraccion", $x['FR']);
                $this->db->where("A.Control", $x['CR'])->limit(1);
                print json_encode($this->db->get()->result());
            } else {
                $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, "
                                . "FXE.Fraccion AS Fraccion, F.Descripcion AS FRACCION_DES ", false)
                        ->from("asignapftsacxc AS A")
                        ->join("fraccionesxestilo AS FXE", "A.Estilo = FXE.Estilo")->join("fracciones AS F", "FXE.Fraccion = F.Clave");
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
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.Control AS CONTROL, P.Estilo AS ESTILO, P.Pares AS PARES, P.DeptoProduccion AS DEPTOAVANCE, P.EstatusProduccion AS ESTATUS_PRODUCCION FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTotalPagado() {
        try {
            $x = $this->input->get();
            $hoy = $x['FECHA_ACTUAL'];
            $this->db->query("SELECT  \"{$hoy}\" DIA_ACTUAL, DATE_ADD(\"{$hoy}\", INTERVAL 1 DAY) DIA_UNO")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
