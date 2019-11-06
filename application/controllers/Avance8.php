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
            /* cr = control, fr = fraccion */
            $control = $this->db->select('P.Estilo', false)->from('pedidox AS P')->where('P.Control', $x->get('CR'))->get()->result();
            print json_encode($this->axepn->getInfoXControl($x->get('CR')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            $x = $this->input;
            print json_encode($this->axepn->getUltimoAvanceXControl($x->get('C')));
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
            
            $DEPTOS_FISICOS = array(20, 30, 40/* PREL-CORTE */, 60, 80/* RAYADO CONTADO */, 90/* ENTRETELADO */, 140/* ENSUELADO */, 300 /* SUPERVISORES */);
            $xXx = $this->input->post();
            $ES_SUPERVISOR = $this->db->query("SELECT E.DepartamentoFisico AS DEPTO FROM empleados AS E WHERE E.Numero = {$xXx["EMPLEADO"]} LIMIT 1")->result();
            $this->db->select("CONCAT(E.PrimerNombre,' ',"
                                            . "(CASE WHEN E.SegundoNombre <>'0' THEN E.SegundoNombre ELSE '' END),"
                                            . "' ',(CASE WHEN E.Paterno <>'0' THEN E.Paterno ELSE '' END),' ',"
                                            . "(CASE WHEN E.Materno <>'0' THEN E.Materno ELSE '' END)) AS NOMBRE_COMPLETO, "
                                            . "E.DepartamentoCostos AS DEPTOCTO, D.Avance AS GENERA_AVANCE, D.Descripcion AS DEPTO", false)
                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                    ->where('E.Numero', $this->input->post('EMPLEADO'))
                    ->where_in('E.AltaBaja', array(1));
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
            header('Content-type: application/json');
            print json_encode($this->axepn->getPagosXEmpleadoXSemana(
                                    $this->input->get('EMPLEADO'), $this->input->get('SEMANA'), $this->input->get('FRACCIONES')));
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
            var_dump($FRACCIONES);
            foreach ($FRACCIONES as $key => $value) {
                print $value->NUMERO_FRACCION . "\n";
            }
            exit(0);
            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $Control = $x['CONTROL'];

            $data = array(
                "numeroempleado" => $x['NUMERO_EMPLEADO'],
                "maquila" => intval(substr($Control, 4, 2)),
                "control" => $Control,
                "estilo" => $x['ESTILO'],
                "numfrac" => $x['NUMERO_FRACCION'],
                "preciofrac" => $x['PRECIO_FRACCION'],
                "pares" => $x['PARES'],
                "subtot" => (floatval($x['PARES']) * floatval($x['PRECIO_FRACCION'])),
                "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                "semana" => $x['SEMANA'],
                "depto" => $x['DEPARTAMENTO'],
                "anio" => $x['ANIO']);
            /* PASO 1 : AGREGAR AVANCE (DEBE DE ESTAR EN RAYADO O EN ALGUN OTRO DEPARTAMENTO EL CONTROL) 

             * 
             * 
             * 10	CORTE
              20	RAYADO
             * 
              30	REBAJADO Y PERFORADO
              40	FOLEADO*
              60	LASER
              70	PREL-CORTE
              80	RAYADO CONTADO
             * 
              90	ENTRETELADO
             * 
              100	MAQUILA
              110	PESPUNTE
              120	PREL-PESPUNTE
              140	ENSUELADO
              150	TEJIDO
              180	MONTADO "A"
              190	MONTADO "B"
              210	ADORNO "A"
              220	ADORNO "B"
             * 
             *              */
            /* AVANCE (90) ENTRETELADO */
            /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE (90 - ENTRETELADO) PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
            $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)
                            ->from('avance AS A')
                            ->where('A.Control', $Control)
                            ->where('A.Departamento', 90)
                            ->where_not_in('A.Emp', $x['NUMERO_EMPLEADO'])
                            ->get()->result();

            /* SOLO SE GENERA EL AVANCE EN LA FRACCIÓN 51 QUE ES LA PIEL */
            if ($check_avance[0]->EXISTE <= 0) {
                $id = 0;

                if (intval($x['NUMERO_FRACCION']) === 51) {
                    /* 51 = ENTRETELADO */
//                    $avance = array(
//                        'Control' => $Control,
//                        'FechaAProduccion' => Date('d/m/Y'),
//                        'Departamento' => 90,
//                        'DepartamentoT' => 'ENTRETELADO',
//                        'FechaAvance' => Date('d/m/Y'),
//                        'Estatus' => 'A',
//                        'Usuario' => $_SESSION["ID"],
//                        'Fecha' => Date('d/m/Y'),
//                        'Hora' => Date('h:i:s a'),
//                        'Fraccion' => $x['NUMERO_FRACCION']
//                    );
//                    $this->db->insert('avance', $avance);
//                    $id = $this->db->insert_id();

                    /* ACTUALIZA A 90 ENTRETELADO, stsavan 4 */
//                    $this->db->set('EstatusProduccion', 'ENTRETELADO')->set('DeptoProduccion', 90)
//                            ->where('Control', $x['CONTROL'])
//                            ->update('controles');
//                    $this->db->set('stsavan', 4)->set('EstatusProduccion', 'ENTRETELADO')
//                            ->set('DeptoProduccion', 90)->where('Control', $x['CONTROL'])
//                            ->update('pedidox');
//                    $this->db->set('fec40', Date('Y-m-d h:i:s'))
//                            ->where('contped', $x['CONTROL'])
//                            ->update('avaprd');

                    /* SE REVISA SI SE TIENE QUE MAQUILAR EL ESTILO */
                    $check_maquila = $this->db->select('(CASE WHEN E.MaqPlant1 IS NULL THEN 0 ELSE E.MaqPlant1 END) AS MP1, '
                                            . '(CASE WHEN E.MaqPlant2 IS NULL THEN 0 ELSE E.MaqPlant2 END) AS MP2, '
                                            . '(CASE WHEN E.MaqPlant3 IS NULL THEN 0 ELSE E.MaqPlant3 END) AS MP3,  '
                                            . '(CASE WHEN E.MaqPlant4 IS NULL THEN 0 ELSE E.MaqPlant4 END) AS MP4', false)
                                    ->from('estilos AS E')->like('E.Clave', $x['ESTILO'])->get()->result();

                    if (intval($check_maquila[0]->MP1) === 0 &&
                            intval($check_maquila[0]->MP2) === 0 &&
                            intval($check_maquila[0]->MP3) === 0 &&
                            intval($check_maquila[0]->MP4) === 0) {
                        /* ACTUALIZA A 105 ALMACEN CORTE, stsavan 44 */

                        $avance = array(
                            'Control' => $x['CONTROL'],
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 105,
                            'DepartamentoT' => 'ALMACEN CORTE',
                            'FechaAvance' => Date('d/m/Y'),
                            'Estatus' => 'A',
                            'Usuario' => $_SESSION["ID"],
                            'Fecha' => Date('d/m/Y'),
                            'Hora' => Date('h:i:s a'),
                            'Fraccion' => NULL
                        );
                        $this->db->insert('avance', $avance);
                        $id = $this->db->insert_id();

                        $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)
                                ->where('Control', $x['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')
                                ->set('DeptoProduccion', 105)->where('Control', $x['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec44', Date('Y-m-d h:i:s'))
                                ->where('contped', $x['CONTROL'])
                                ->update('avaprd');
                    } else {
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
                            'Fraccion' => NULL
                        );
                        $this->db->insert('avance', $avance);
                        $id = $this->db->insert_id();
                        /* ACTUALIZA A 100 MAQUILA, stsavan 42 */
                        $this->db->set('EstatusProduccion', 'MAQUILA')->set('DeptoProduccion', 100)
                                ->where('Control', $x['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 42)->set('EstatusProduccion', 'MAQUILA')
                                ->set('DeptoProduccion', 100)->where('Control', $x['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec42', Date('Y-m-d h:i:s'))
                                ->where('contped', $x['CONTROL'])
                                ->update('avaprd');
                    }
                } else 
                if (intval($x['NUMERO_FRACCION']) === 397) {
                    /* AVANCE 397 ENSUELADO */
                    $avance = array(
                        'Control' => $Control,
                        'FechaAProduccion' => Date('d/m/Y'),
                        'Departamento' => 140,
                        'DepartamentoT' => 'ENSUELADO',
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x['NUMERO_FRACCION']
                    );
                    $this->db->insert('avance', $avance);
                    $id = $this->db->insert_id();

                    /* ACTUALIZA A 140 ENSUELADO, stsavan 55 */
                    $this->db->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)
                            ->where('Control', $x['CONTROL'])
                            ->update('controles');
                    $this->db->set('stsavan', 55)->set('EstatusProduccion', 'ENSUELADO')
                            ->set('DeptoProduccion', 140)->where('Control', $x['CONTROL'])
                            ->update('pedidox');
                    $this->db->set('fec55', Date('Y-m-d h:i:s'))->where('contped', $x['CONTROL'])
                            ->update('avaprd');
                } else {
                    /* SI NO ES LA FRACCION 51 = ENTRETELADO, NI LA FRACCION 397 = ENSUELADO, REVISA QUE FRACCION LE PERTENECE CONFORME AL DEPARTAMENTO */
                    $check_depto = $this->db->select('E.Numero AS EMPLEADO, E.DepartamentoFisico AS DEPTO, D.Descripcion AS DEPTODES', false)
                                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                                    ->where('E.Numero', $x['NUMERO_EMPLEADO'])
                                    ->get()->result();
                    $avance = array(
                        'Control' => $Control,
                        'FechaAProduccion' => Date('d/m/Y'),
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a')
                    );
                    switch (intval($check_depto[0]->DEPTO)) {
                        case 30:
                            /* REBAJADO Y PERFORADO */
                            $avance['Departamento'] = 30;
                            $avance['Fraccion'] = 103;
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* REBAJADO */;
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();

                            /* ACTUALIZA A 30 ENSUELADO, stsavan 33 */
                            $this->db->set('EstatusProduccion', 'REBAJADO Y PERFORADO')->set('DeptoProduccion', 30)
                                    ->where('Control', $x['CONTROL'])
                                    ->update('controles');
                            $this->db->set('stsavan', 33)->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                    ->set('DeptoProduccion', 30)->where('Control', $x['CONTROL'])
                                    ->update('pedidox');
                            $this->db->set('fec33', Date('Y-m-d h:i:s'))->where('contped', $x['CONTROL'])
                                    ->update('avaprd');
                            break;
                        case 40:
                            /* FOLEADO */
                            $avance['Departamento'] = 40;
                            $avance['Fraccion'] = 60;
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* FOLEADO */;


                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();

                            /* ACTUALIZA A 40 FOLEADO, stsavan 4 */
                            $this->db->set('EstatusProduccion', 'FOLEADO')->set('DeptoProduccion', 40)
                                    ->where('Control', $x['CONTROL'])
                                    ->update('controles');
                            $this->db->set('stsavan', 4)->set('EstatusProduccion', 'FOLEADO')
                                    ->set('DeptoProduccion', 40)->where('Control', $x['CONTROL'])
                                    ->update('pedidox');
                            $this->db->set('fec4', Date('Y-m-d h:i:s'))
                                    ->where('contped', $x['CONTROL'])
                                    ->update('avaprd');
                            break;
                        case 50:
                            /* DOBLILLADO */
//                            $this->db->set('EstatusProduccion', 'DOBLILLADO')
//                                    ->where('Control', $Control)
//                                    ->update('controles');
//                            $this->db->set('EstatusProduccion', 'DOBLILLADO')
//                                    ->set('DeptoProduccion', 50)
//                                    ->where('Control', $Control)
//                                    ->update('controles');
                            break;
                        case 60:
                            /* LASER */
//                            $avance['Departamento'] = 60;
//                            $avance['Fraccion'] = $x['NUMERO_FRACCION'];
//                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* FOLEADO */;
//                            $this->db->insert('avance', $avance);
//                            $id = $this->db->insert_id();

                            /* ACTUALIZA A 60 LASER, stsavan ? */
//                            $this->db->set('EstatusProduccion', 'LASER')->set('DeptoProduccion', 60)
//                                    ->where('Control', $x['CONTROL'])
//                                    ->update('controles');
//                            $this->db->set('stsavan', ?)->set('EstatusProduccion', 'LASER')
//                                    ->set('DeptoProduccion', 60)->where('Control', $x['CONTROL'])
//                                    ->update('pedidox');
                            break;
                        case 70:
                            /* PREL-CORTE */
//                            $avance['Departamento'] = 70;
//                            $avance['Fraccion'] = $x['NUMERO_FRACCION'];
//                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* LASER */;
//                            $this->db->set('EstatusProduccion', 'LASER')
//                                    ->set('DeptoProduccion', 70)
//                                    ->where('Control', $Control)
//                                    ->update('controles');
//                            $this->db->insert('avance', $avance);
//                            $id = $this->db->insert_id();
                            break;
                        case 80:
                            /* RAYADO CONTADO */
//                            $avance['Departamento'] = 80;
//                            $avance['Fraccion'] = $x['NUMERO_FRACCION'];
//                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* RAYADO CONTADO */;
//                            $this->db->set('EstatusProduccion', 'RAYADO CONTADO')
//                                    ->set('DeptoProduccion', 80)
//                                    ->where('Control', $Control)
//                                    ->update('controles');
//                            $this->db->insert('avance', $avance);
//                            $id = $this->db->insert_id();
                            break;
                    }
                }
                /* PASO 2 : PAGAR FRACCION */
                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                ->from('fracpagnomina AS F')
                                ->where('F.control', $Control)
                                ->where('F.numfrac', $x['NUMERO_FRACCION'])
                                ->get()->result();

                $data["fraccion"] = $x['FRACCION'];
                if ($check_fraccion[0]->EXISTE <= 0) {
                    $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                    $this->db->insert('fracpagnomina', $data);
                    print '{"AVANZO":"1","FR":"' . $x['NUMERO_FRACCION'] . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A ENTRETELADO"}';
                } else {
                    print '{"AVANZO":"0","FR":"' . $x['NUMERO_FRACCION'] . '","RETORNO":"SI", "MESSAGE":"FRACCION ' . $x['NUMERO_FRACCION'] . ', NO GENERA AVANCE"}';
                }
            } else {
                /* YA EXISTE UN AVANCE DE ENTRETELADO EN ESTE CONTROL */
                print '{"AVANZO":"0","FR":"' . $x['NUMERO_FRACCION'] . '","RETORNO":"SI", "MESSAGE":"EL NUMERO DE FRACCION Y EMPLEADO SON CORRECTOS, PERO YA HA SIDO AVANZADO A ENTRETELADO CON ANTERIORIDAD"}';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
