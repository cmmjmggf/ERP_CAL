<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avance9 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance9_model', 'axepn');
    }

    public function getSemanaByFecha() {
        try {
//            print json_encode($this->axepn->getSemanaByFecha(Date('d/m/Y')));
            $fecha = Date('d/m/Y');
            $this->db->select("U.Sem, '{$fecha}' AS Fecha", false)
                    ->from('semanasproduccion AS U')
                    ->where("STR_TO_DATE(\"{$fecha}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")");
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl() {
        try {
            $x = $this->input->get();
            if ($x['FR'] !== '') {
                $this->db->select("A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion", false)
                        ->from('asignapftsacxc AS A')
                        ->join('fraccionesxestilo as FXE', 'A.Estilo = FXE.Estilo');
                $this->db->where("A.Fraccion", $x['FR'])->where("FXE.Fraccion", $x['FR']);
                $this->db->where("A.Control", $x['CR'])->limit(1);
                print json_encode($this->db->get()->result());
            } else {
//                $this->db->select("FE.ID, FE.Estilo, FE.FechaAlta, FE.Fraccion, FE.CostoMO, "
//                                . "FE.CostoVTA, FE.AfectaCostoVTA, FE.Estatus, F.ID AS FID, "
//                                . "F.Clave AS FCLAVE, F.Descripcion AS FRACCIONDES, "
//                                . "F.Departamento AS FRACCIONDEPTO", false)
//                        ->from('fraccionesxestilo AS FE')->join('fracciones AS F', 'F.Clave = FE.Fraccion');
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
                30/* REBAJADO Y PERFORADO */, 190/* MONTADO B */);
            print json_encode($this->db->select("CONCAT(E.PrimerNombre,' ',"
                                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
                                            . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Clave AS DEPTO, D.Descripcion AS DEPTO_DES", false)
                                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                                    ->where('E.Numero', $this->input->post('EMPLEADO'))
                                    ->where_in('E.AltaBaja', array(1))
                                    ->where_in('E.FijoDestajoAmbos', array(2, 3))
                                    ->where_in('E.DepartamentoFisico', $DEPTOS_FISICOS)
                                    ->get()->result());
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
            $this->db->select("FACN.ID, FACN.numeroempleado, FACN.maquila, "
                            . "FACN.control AS CONTROL, FACN.estilo AS ESTILO, "
                            . "FACN.numfrac AS FRAC, FACN.preciofrac AS PRECIO, "
                            . "FACN.pares AS PARES, CONCAT('$',FORMAT(FACN.subtot,2)) AS SUBTOTAL, "
                            . "FACN.status, DATE_FORMAT(FACN.fecha, \"%d/%m/%Y\") AS FECHA, "
                            . "FACN.semana AS SEMANA, FACN.depto AS DEPARTAMENTO, "
                            . "FACN.registro, FACN.anio, FACN.avance_id", false)
                    ->from('fracpagnomina AS FACN');
            switch ($url->segment(2)) {
                case 1:
//                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "96,99,100"));
                    $this->db->where("FACN.numfrac IN(96,99,100) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);
                    break;
                case 2:
//                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337"));
                    $this->db->where("FACN.numfrac IN(51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337) AND DATEDIFF(str_to_date(now(),'%Y-%m-%d'),str_to_date(FACN.fecha,'%Y-%m-%d')) <=30", null, false);
                    break;
            }
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('FACN.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['EMPLEADO'] === '') {
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
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
                "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPARTAMENTO'],
                "anio" => $xXx['ANIO']);
            $msj = "[";
            $pifo_contador = 0;
            foreach ($FRACCIONES as $k => $v) {
//                print "{$v->NUMERO_FRACCION} = > {$v->DESCRIPCION} {$xXx['CONTROL']}<br>";
//exit(0);

                $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT A.Estilo, A.Pares, FXE.CostoMO, (A.Pares * FXE.CostoMO) AS TOTAL, A.Fraccion AS Fraccion FROM asignapftsacxc AS A INNER JOIN fraccionesxestilo as FXE ON A.Estilo = FXE.Estilo WHERE A.Fraccion = {$v->NUMERO_FRACCION} AND FXE.Fraccion = {$v->NUMERO_FRACCION} AND A.Control = {$xXx['CONTROL']}")->result();
                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                $data = array(
                    "numeroempleado" => $xXx['NUMERO_EMPLEADO'],
                    "maquila" => intval($CONTROL[0]->MAQUILA),
                    "control" => $xXx['CONTROL'],
                    "estilo" => $xXx['ESTILO'],
                    "pares" => $xXx['PARES'],
                    "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
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
                    if ($check_avance[0]->EXISTE <= 0) {
                        $id = 0;
                        if (intval($v->NUMERO_FRACCION) === 100) {
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

                            /* ACTUALIZA A 20 RAYADO, stsavan 3 */
                            $this->db->set('EstatusProduccion', 'RAYADO')
                                    ->set('DeptoProduccion', 20)
                                    ->where('Control', $xXx['CONTROL'])
                                    ->update('controles');

                            $this->db->set('stsavan', 3)
                                    ->set('EstatusProduccion', 'RAYADO')
                                    ->set('DeptoProduccion', 20)
                                    ->where('Control', $xXx['CONTROL'])
                                    ->update('pedidox');

                            $this->db->set('fec3', Date('Y-m-d h:i:s'))
                                    ->where('contped', $xXx['CONTROL'])
                                    ->update('avaprd');
                        }
                        /* PASO 2 : AGREGAR FRACCION PAGADA */
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $xXx['CONTROL'])
                                        ->where('F.numfrac', $v->NUMERO_FRACCION)
                                        ->get()->result();
                        $data["fraccion"] = $v->NUMERO_FRACCION;
                        if ($check_fraccion[0]->EXISTE <= 0) {
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : $v->NUMERO_FRACCION;

                            if (intval($v->NUMERO_FRACCION) === 100) {
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 100", "LE PAGO LA FRACCION 100 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']}", $this->session);
                                $msj .= '{"AVANZO":"1","FR":"100","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A RAYADO  - LOOP FOREACH"}';
                            }
                            if (intval($v->NUMERO_FRACCION) === 99) {
                                $data["avance_id"] = NULL;
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 99", "LE PAGO LA FRACCION 99 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']}", $this->session);
                                $msj .= '{"AVANZO":"0","FR":"99","RETORNO":"SI", "MESSAGE":"FRACCION 99, NO GENERA AVANCE - LOOP FOREACH"}';
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
                    } else {
                        /* RAYADO/RAYADO CONTADO => REBAJADO Y PERFORADO/REBAJADO */
                        if (intval($xXx['DEPARTAMENTO']) === 80) {
                            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                            ->from('fracpagnomina AS F')
                                            ->where('F.control', $xXx['CONTROL'])
                                            ->where('F.numfrac', 102)
                                            ->get()->result();
                            $data["fraccion"] = $v->NUMERO_FRACCION;
                            if ($check_fraccion[0]->EXISTE <= 0) {
                                $avance = array(
                                    'Control' => $xXx['CONTROL'],
                                    'FechaAProduccion' => Date('d/m/Y'),
                                    'Departamento' => 30,
                                    'DepartamentoT' => 'REBAJADO Y PERFORADO',
                                    'FechaAvance' => Date('d/m/Y'),
                                    'Estatus' => 'A',
                                    'Usuario' => $_SESSION["ID"],
                                    'Fecha' => Date('d/m/Y'),
                                    'Hora' => Date('h:i:s a'),
                                    'Fraccion' => 103
                                );
                                $this->db->insert('avance', $avance);
                                $id = $this->db->insert_id();
                                $data["avance_id"] = intval($id) >= 0 ? intval($id) : 8081;
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("AVANCE 9 - FRACCION 103", "LE PAGO LA FRACCION 103 DEL CONTROL {$xXx["CONTROL"]} AL CORTADOR {$xXx['NUMERO_EMPLEADO']} PARA RAYADO DEPTO 80.", $this->session);

                                /* ACTUALIZA A 30 REBAJADO Y PERFORADO, stsavan 33 */
                                $this->db->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                        ->set('DeptoProduccion', 30)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('controles');
                                $this->db->set('stsavan', 33)
                                        ->set('EstatusProduccion', 'CORTE')
                                        ->set('DeptoProduccion', 30)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('pedidox');
                                $this->db->set('fec33', Date('Y-m-d h:i:s'))
                                        ->where('contped', $x['CONTROL'])
                                        ->update('avaprd');

                                $this->db->set('stsavan', 33)->where('Control', $xXx['CONTROL'])->update('pedidox');
                                print '[{"AVANZO":"1","FR":"102","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A REBAJADO Y PERFORADO  - LOOP FOREACH"}]';
                            }
                        } else {
                            print '[{"AVANZO":"0","FR":"???","RETORNO":"SI", "MESSAGE":"FRACCION ???, NO GENERA AVANCE  - LOOP FOREACH"}]';
                            exit(0);
                        }
                    }
                } else {
                    /* EL CORTADOR NO HA REGRESADO MATERIAL O EL ALMACENISTA NO HA REGISTRADO EL RETORNO DEL MATERIAL */
                    print '[{"AVANZO":"0","RETORNO":"NO", "MESSAGE":"NUMERO DE FRACCION O EMPLEADO INCORRECTOS  - LOOP FOREACH"}]';
                }
            }
            /* SI NO ESPECIFICO FRACCIONES ES PARA RAYADO => REBAJADO Y PERFORADO */
            if (count($FRACCIONES) <= 0) {
                if (intval($xXx['DEPARTAMENTO']) === 80) {
                    /*REVISAR SI LA FRACCION "102 RAYADO" NO HA SIDO PAGADA A OTRO EMPLEADO*/
                    $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                    ->from('fracpagnomina AS F')
                                    ->where('F.control', $xXx['CONTROL'])
                                    ->where('F.numfrac', 102)
                                    ->get()->result();
                    $data["fraccion"] = 102;
                    $data["numfrac"] = 102;
                    /* FILTRADO POR FRACCION 102 RAYADO */
                    $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = 102  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                    $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                    $data["preciofrac"] = $PXFC;
                    $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                    if ($check_fraccion[0]->EXISTE <= 0) {
                        /*GENERAR UN AVANCE A REBAJADO Y PERFORADO*/
                        $avance = array(
                            'Control' => $xXx['CONTROL'],
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 30,
                            'DepartamentoT' => 'REBAJADO Y PERFORADO',
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
                        /*PAGAR LA FRACCION 102 AL EMPLEADO*/
                        $this->db->insert('fracpagnomina', $data);

                        /* ACTUALIZA A 30 REBAJADO Y PERFORADO, stsavan 33 */
                        $this->db->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                ->set('DeptoProduccion', 30)
                                ->where('Control', $xXx['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 33)
                                ->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                ->set('DeptoProduccion', 30)
                                ->where('Control', $xXx['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec33', Date('Y-m-d h:i:s'))
                                ->where('contped', $xXx['CONTROL'])
                                ->update('avaprd');

                        $this->db->set('stsavan', 33)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        print '{"AVANZO":"1","FR":"103","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A REBAJADO Y PERFORADO - IF 80"}';
                    }
                } else {
                    print '{"AVANZO":"0","FR":"???","RETORNO":"SI", "MESSAGE":"FRACCION ???, NO GENERA AVANCE O EL EMPLEADO NO PERTENECE AL DEPTO 80 RAYADO - IF 80"}';
                    exit(0);
                }
            } else {
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
                "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPARTAMENTO'],
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

}
