<?php

class Avance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance_model', 'avm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales');
                    break;
            }
            $this->load->view('vAvance')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDepartamentos() {
        try {
            print json_encode($this->avm->getDepartamentos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAvance() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('fracpagnomina');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAvancesNomina() {
        try {
//            print json_encode($this->avm->getAvancesNomina($this->input->post('CONTROL')));
            $x = $this->input->get();
            $this->db->select("F.ID, F.numeroempleado AS EMPLEADO, F.maquila AS MAQUILA, "
                            . "F.control AS CONTROL, F.estilo AS ESTILO, F.numfrac AS NUM_FRACCION, "
                            . "F.preciofrac AS PRECIO_FRACCION, F.pares AS PARES, F.subtot AS SUBTOTAL, "
                            . "F.status, DATE_FORMAT(F.fecha,\"%d/%m/%Y\")  AS FECHA, F.semana AS SEMANA, F.depto, "
                            . "F.registro, F.anio, F.avance_id, F.fraccion AS FRACCION", false)
                    ->from("fracpagnomina AS F");

            if ($x['CONTROL'] !== '') {
                $this->db->where('F.control', $x['CONTROL']);
            }

            if ($x['EMPLEADO'] !== '') {
                $this->db->where('F.numeroempleado', $x['EMPLEADO']);
            }
            $this->db->order_by('F.fecha', 'DESC');
            if ($x['CONTROL'] === '' && $x['EMPLEADO'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXConcepto() {
        try {
            $x = $this->input->get();
//            print json_encode($this->avm->getRastreoXConcepto($x->get('EMPLEADO'), $x->get('CONCEPTO')));

            $this->db->select("PN.ID, "
                            . "PN.numsem AS SEMANA,"
                            . "PN.numemp AS EMPLEADO, "
                            . "PN.numcon AS CONCEPTO, "
                            . "DATE_FORMAT(PN.fecha,\"%d/%m/%Y\")  AS FECHA, "
                            . "PN.tpcon AS PER, "
                            . "PN.importe AS IMPORTE, "
                            . "PN.tpcond AS DED, "
                            . "PN.imported AS SUBTOTAL")
                    ->from("prenomina AS PN");
            if ($x['EMPLEADO'] !== "") {
                $this->db->where('PN.numemp', $x['EMPLEADO']);
            }
            if ($x['CONCEPTO'] !== '') {
                $this->db->where('PN.numcon', $x['CONCEPTO']);
            }
            if ($x['EMPLEADO'] === "" && $x['CONCEPTO'] === "") {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXControl() {
        try {
//            print json_encode($this->avm->getRastreoXControl());
            $x = $this->input->get();
            $this->db->select("FP.ID, FP.control AS CONTROL, FP.numeroempleado AS EMPLEADO, FP.estilo AS ESTILO, "
                            . "FP.numfrac AS NUM_FRACCION, DATE_FORMAT(FP.fecha,\"%d/%m/%Y\")  AS FECHA, "
                            . "DATE_FORMAT(FP.fecha,\"%d/%m/%Y\")  AS FECHA,FP.Semana AS SEMANA, "
                            . "FP.pares AS PARES, FP.preciofrac AS PRECIO_FRACCION, "
                            . "FP.subtot AS SUBTOTAL")
                    ->from("fracpagnomina AS FP");

            if ($x['SEMANA'] !== '') {
                $this->db->where('FP.Semana', $x['SEMANA']);
            }
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('FP.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('FP.control', $x['CONTROL']);
            }
            $this->db->order_by('FP.ID', 'DESC');
            if ($x['SEMANA'] === '' && $x['EMPLEADO'] === '' && $x['CONTROL'] === '') {
                $this->db->limit(50);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConceptosNomina() {
        try {
            print json_encode($this->avm->getConceptosNomina());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->db->select("E.Numero AS CLAVE, CONCAT(E.Numero,' ', (CASE WHEN E.PrimerNombre = \"0\" THEN \"\" ELSE E.PrimerNombre END),' ',(CASE WHEN E.SegundoNombre = \"0\" THEN \"\" ELSE E.SegundoNombre END),' ',(CASE WHEN E.Paterno = \"0\" THEN \"\" ELSE E.Paterno END),' ', (CASE WHEN E.Materno = \"0\" THEN \"\" ELSE E.Materno END)) AS EMPLEADO")
                                    ->from("empleados AS E")->where_in('E.FijoDestajoAmbos', array(2, 3))->where('E.AltaBaja', 1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->db->select("F.Clave AS CLAVE, CONCAT(F.Clave,' ',F.Descripcion) AS FRACCION", false)
                                    ->from('fracciones AS F')
                                    ->where_not_in('F.Departamento', array(10, 20))
                                    ->order_by('ABS(F.Clave)', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasDeProduccion() {
        try {
//            print json_encode($this->avm->getSemanaByFecha(Date('d/m/Y')));
            $fechin = Date('d/m/Y');
            print json_encode($this->db->select("U.Sem, '$fechin' AS Fecha", false)
                                    ->from('semanasproduccion AS U')
                                    ->where("STR_TO_DATE(\"{$fechin}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")")
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina() {
        try {
//            print json_encode($this->avm->getSemanaNomina($this->input->post('FECHA')));

            $fechin = $this->input->post('FECHA');
            print json_encode($this->db->select("S.Sem AS SEMANA", false)
                                    ->from('semanasnomina AS S')
                                    ->where("STR_TO_DATE(\"{$fechin}\", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")", null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptoActual() {
        try {
//            print json_encode($this->avm->getDeptoActual($this->input->post('CONTROL')));
            print json_encode($this->db->select("A.Departamento AS DEPTO, C.Estilo AS ESTILO, "
                                            . "C.Pares AS PARES, E.Foto AS FOTO", false)
                                    ->from('avance AS A')
                                    ->join('controles AS C', 'A.Control = C.Control')
                                    ->join('fichatecnica AS F', 'F.Estilo = C.Estilo AND F.Color = C.Color')
                                    ->join('estilos AS E', 'E.Clave = F.Estilo')
                                    ->like("A.Control", $this->input->post('CONTROL'))
                                    ->order_by("A.ID", "DESC")
                                    ->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccionXEstiloFraccion() {
        try {
            $x = $this->input->get();
//            print json_encode($this->avm->getPrecioFraccionXEstiloFraccion($x->get('ESTILO'), $x->get('FRACCION')));
            print json_encode($this->db->select("FXE.ID, FXE.Estilo AS ESTILO, FXE.FechaAlta AS FECHA_ALTA, "
                                            . "FXE.Fraccion AS FRACCION, FXE.CostoMO AS COSTO_MO", false)
                                    ->from('fraccionesxestilo AS FXE')
                                    ->where("FXE.Estilo = '{$x['ESTILO']}' AND FXE.Fraccion = {$x['FRACCION']}", null, false)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
//            print json_encode($this->avm->getMaquilasPlantillas());
            print json_encode($this->db->select("CAST(MP.Clave AS SIGNED ) AS Clave, CONCAT(MP.Clave,\" \",MP.Descripcion) AS MaquilasPlantillas")
                                    ->from("maquilasplantillas AS MP")
                                    ->order_by('MP.Clave', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanceXControl() {
        try {
            /**
             * PARA QUE EL CONTROL SEA VALIDO DEBE DE TENER LOS DEPTOS SIGUIENTES:
             * 
             * 10 - CORTE -> SE OCUPA QUE SE LE HAYA ASIGNADO PIEL, FORRO, TEXTIL O SINTETICO PARA CORTE POR CONTROL
             * 20 - RAYADO -> PARA QUE EL CONTROL ESTE EN ESTE DEPTO EL EMPLEADO TUVO QUE HABER TERMINADO DE CORTAR 
             *                Y TUVO QUE HABER REGRESADO EL MATERIAL SOBRANTE DE LO QUE SE LE DIO PARA CORTE 
             *                O BIEN NOTIFICAR QUE HA TERMINADO Y ES POSIBLE DE RAYAR EL CONTROL
             * 
             * DE LO CONTRARIO EL CONTROL NO PUEDE SER AVANZADO A:
             * 
             * 30	REBAJADO Y PERFORADO
             * 40	FOLEADO
             * 60	LASER
             * 70	PREL-CORTE
             * 80	RAYADO CONTADO
             * 90	ENTRETELADO
             * 100	MAQUILA
             * 110	PESPUNTE
             * 120	PREL-PESPUNTE
             * 140	ENSUELADO
             * 150	TEJIDO
             * 180	MONTADO "A"
             * 190	MONTADO "B"
             * 210	ADORNO "A"
             * 220	ADORNO "B"
             * 
             * DE TIPO "1" Y CON AVANCE EN "1"
             * 
             */
            /* SOLO SE PROCESAN CONTROLES EN EL DEPTO DE (20)RAYADO  */

            /*
             * 
             * PRIMERO HAY QUE COMPROBAR SI ESTE CONTROL NO HA SIDO AVANZADO AL DEPARTAMENTO SELECCIONADO
             *
             */
            $x = $this->input;

            $data = array(
                'Control' => $x->post('CONTROL'),
                'FechaAProduccion' => $x->post('FECHA_A_PRODUCCION'),
                'Departamento' => $x->post('DEPTO'),
                'DepartamentoT' => $x->post('DEPTOT'),
                'FechaAvance' => $x->post('FECHA_AVANCE'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
            );
            $this->db->insert('avance', $data);
            $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                    ->set('DeptoProduccion', $x->post('DEPTO'))
                    ->where('Control', $x->post('CONTROL'))
                    ->update('controles');
            $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                    ->set('DeptoProduccion', $x->post('DEPTO'))
                    ->where('Control', $x->post('CONTROL'))
                    ->update('pedidox');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarAvanceXControl() {
        try {

            $CONTROL = $this->input->post('CONTROL');

            /*
             * SE COMPRUEBA QUE EL CONTROL HAYA PASADO POR LOS DOS DEPARTAMENTOS REQUERIDOS
             * CORTE => RAYADO
             * 10 = CORTE
             * 20 = RAYADO
             * 
             */
            $CORTE_10_RAYADO_20 = $this->db->select('A.Departamento AS DEPARTAMENTO, (CASE WHEN COUNT(*) = 0 OR COUNT(*) IS NULL THEN 0 WHEN COUNT(*) > 0 THEN COUNT(*) END) AS AVANCE')
                            ->from('avance AS A ')
                            ->where_in('A.Departamento', array(10, 20))
                            ->like('A.Control', $CONTROL)->group_by('A.Departamento')
                            ->get()->result();
            /* UNA VEZ COMPROBADO QUE EL CONTROL SE ENCUENTRA EN LOS DOS DEPTOS SE ENVIA UN RESULTADO */
            print json_encode($CORTE_10_RAYADO_20);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT C.Estilo AS ESTILO, C.Pares AS PARES, C.DeptoProduccion AS DEPTOPROD, "
                    . "E.MaqPlant1 AS MAQUILA_UNO, E.MaqPlant2 AS MAQUILA_DOS, E.MaqPlant3 AS MAQUILA_TRES,"
                    . "(CASE "
                    . "WHEN E.MaqPlant1 IS NULL OR E.MaqPlant1 = \"0\" THEN "
                    . "(CASE WHEN E.MaqPlant2 IS NULL OR E.MaqPlant2 = \"0\" THEN "
                    . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant3 = \"0\" THEN  "
                    . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant4 = \"0\" THEN \"\" "
                    . "ELSE E.MaqPlant4 END) "
                    . "ELSE E.MaqPlant3 END)"
                    . "ELSE E.MaqPlant2 END)  "
                    . "ELSE E.MaqPlant1 END) AS MAQUILADO "
                    . "FROM controles AS C INNER JOIN estilos AS E ON C.Estilo = E.Clave WHERE C.Control = {$x['CONTROL']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $db = $this->db;
            $x = $this->input;
            $id = 0;
            $frac = intval($x->post('FRACCION'));
            $depto = intval($x->post('DEPTO'));
            /* AVANCE A "MONTADO A" O "MONTADO B" */
            if ($frac === 500 && $depto === 180 ||
                    $frac === 503 && $depto === 190) {

                $db->insert('avance', array(
                    'Control' => $x->post('CONTROL'),
                    'FechaAProduccion' => $x->post('FECHA'),
                    'Departamento' => $x->post('DEPTO'),
                    'DepartamentoT' => $x->post('DEPTOT'),
                    'FechaAvance' => $x->post('FECHA'),
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => $x->post('FRACCION')
                ));
                $id = $this->db->insert_id();
                if ($depto === 180) {
                    $this->db->set('EstatusProduccion', "MONTADO A")
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('pedidox');
                } else if ($depto === 190) {
                    $this->db->set('EstatusProduccion', "MONTADO B")
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('pedidox');
                }
            }
            /* AVANCE A "ADORNO A" O "ADORNO B" */
            if ($frac === 600 && $depto === 210 ||
                    $frac === 600 && $depto === 220) {
                $db->insert('avance', array(
                    'Control' => $x->post('CONTROL'),
                    'FechaAProduccion' => $x->post('FECHA'),
                    'Departamento' => $x->post('DEPTO'),
                    'DepartamentoT' => $x->post('CONTROL'),
                    'FechaAvance' => $x->post('FECHA'),
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => $x->post('FRACCION')
                ));
                $this->db->set('stsavan', 10)->where('Control', $x->post('CONTROL'))->update('pedidox');
                /* DE ADORNO B PASA A ALMACEN DE ADORNO */
                if ($depto === 220) {
                    $db->set('EstatusProduccion', 'ALMACEN ADORNO')
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('controles');
                    $db->set('EstatusProduccion', 'ALMACEN ADORNO')
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('pedidox');
                    $this->db->set('stsavan', 11)->where('Control', $x->post('CONTROL'))->update('pedidox');
                }
                $id = $db->insert_id();
            }

            $fecha = $x->post('FECHA');
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $db->set('EstatusProduccion', $x->post('DEPTOT'))
                    ->set('DeptoProduccion', $x->post('DEPTO'))
                    ->where('Control', $x->post('CONTROL'))->update('controles');
            $db->set('EstatusProduccion', $x->post('DEPTOT'))
                    ->set('DeptoProduccion', $x->post('DEPTO'))
                    ->where('Control', $x->post('CONTROL'))->update('pedidox');

            //SOLO SI NO HA LLEGADO A ADORNO B SE COLOCA OTRO ESTATUS
            if ($depto !== 220) {
                if ($depto === 30 && $frac === 103) {
                    /* REBAJADO Y PERFORADO */
                    $db->set('fec33', Date('Y-m-d h:i:s'))
                            ->where('contped', $x->post('CONTROL'))
                            ->update('avaprd');
                    $db->insert('avance', array(
                        'Control' => $x->post('CONTROL'),
                        'FechaAProduccion' => $x->post('FECHA'),
                        'Departamento' => $x->post('DEPTO'),
                        'DepartamentoT' => $x->post('DEPTOT'),
                        'FechaAvance' => $x->post('FECHA'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x->post('FRACCION')
                    ));
                }

                if ($depto === 40 && $frac === 60) {
                    /* FOLEADO */
                    $db->set('fec4', Date('Y-m-d h:i:s'))
                            ->where('contped', $x->post('CONTROL'))
                            ->update('avaprd');
                    $db->insert('avance', array(
                        'Control' => $x->post('CONTROL'),
                        'FechaAProduccion' => $x->post('FECHA'),
                        'Departamento' => $x->post('DEPTO'),
                        'DepartamentoT' => $x->post('DEPTOT'),
                        'FechaAvance' => $x->post('FECHA'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x->post('FRACCION')
                    ));
                }
                if ($depto === 90 && $frac === 51) {
                    /* ENTRETELADO */
                    $db->insert('avance', array(
                        'Control' => $x->post('CONTROL'),
                        'FechaAProduccion' => $x->post('FECHA'),
                        'Departamento' => $x->post('DEPTO'),
                        'DepartamentoT' => $x->post('DEPTOT'),
                        'FechaAvance' => $x->post('FECHA'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x->post('FRACCION')
                    ));
                    $db->set('fec40', Date('Y-m-d h:i:s'))
                            ->where('contped', $x->post('CONTROL'))
                            ->update('avaprd');
                    $check_maquila = $db->select('(CASE WHEN E.MaqPlant1 IS NULL THEN 0 ELSE E.MaqPlant1 END) AS MP1, '
                                            . '(CASE WHEN E.MaqPlant2 IS NULL THEN 0 ELSE E.MaqPlant2 END) AS MP2, '
                                            . '(CASE WHEN E.MaqPlant3 IS NULL THEN 0 ELSE E.MaqPlant3 END) AS MP3,  '
                                            . '(CASE WHEN E.MaqPlant4 IS NULL THEN 0 ELSE E.MaqPlant4 END) AS MP4', false)
                                    ->from('estilos AS E')->like('E.Clave', $x->post('ESTILO'))->get()->result();
                    if (intval($check_maquila[0]->MP1) >= 0 &&
                            intval($check_maquila[0]->MP2) >= 0 &&
                            intval($check_maquila[0]->MP3) >= 0 &&
                            intval($check_maquila[0]->MP4) >= 0) {
                        $this->db->set('fec42', Date('Y-m-d h:i:s'))
                                ->where('contped', $x->post('CONTROL'))
                                ->update('avaprd');
                        $this->db->set('EstatusProduccion', 'ALMACEN CORTE')
                                ->set('DeptoProduccion', 105)
                                ->where('Control', $x->post('CONTROL'))
                                ->update('controles');
                    } else {
                        $this->db->set('EstatusProduccion', 'MAQUILA')
                                ->set('DeptoProduccion', 100)
                                ->where('Control', $x->post('CONTROL'))
                                ->update('controles');
                    }
                }
            }
            $id = $db->insert_id();
            $db->insert('fracpagnomina', array(
                'numeroempleado' => $x->post('EMPLEADO'),
                'maquila' => substr($x->post('CONTROL'), 4, 2),
                'control' => $x->post('CONTROL'),
                'estilo' => $x->post('ESTILO'),
                'numfrac' => $x->post('FRACCION'),
                'preciofrac' => $x->post('PRECIO_FRACCION'),
                'pares' => $x->post('PARES'),
                'subtot' => floatval($x->post('PARES')) * floatval($x->post('PRECIO_FRACCION')),
                'status' => 0,
                'fecha' => $nueva_fecha->format('Y-m-d h:i:s'),
                'semana' => $x->post('SEMANA'),
                'depto' => $x->post('DEPTO'),
                'registro' => 0,
                'anio' => Date('Y'),
                'avance_id' => $id,
                'fraccion' => $x->post('FRACCIONT'))
            );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzarControl($NUMERO_DE_AVANCE) {
        try {
            $AVANCES = array(
                0 => "CAPTURADO", 1 => "PROGRAMADO",
                10 => 'CORTE', 20 => 'RAYADO',
                30 => 'RAYADO', 40 => 'FOLEADO',
                50 => 'DOBLILLADO', 60 => 'LASER',
                70 => 'PREL-CORTE', 80 => 'RAYADO CONTADO',
                90 => 'ENTRETELADO', 100 => 'MAQUILA',
                110 => 'PESPUNTE', 120 => 'PREL-PESPUNTE',
                130 => 'ALMACEN PESPUNTE', 140 => 'ENSUELADO',
                150 => 'TEJIDO', 160 => 'ALMACEN TEJIDO',
                170 => 'CHOFERES', 180 => 'MONTADO A',
                190 => 'MONTADO B', 200 => 'PEGADO',
                210 => 'ADORNO A', 220 => 'ADORNO B',
                230 => 'ALMACEN ADORNO', 240 => 'TERMINADO'
            );
            PRINT array_key_exists("$NUMERO_DE_AVANCE", $AVANCES) ? $AVANCES["$NUMERO_DE_AVANCE"] : "NO EXISTE";

            $this->db->set('stsavan', 11)->where('Control', $x->post('CONTROL'))->update('pedidox');
            $this->db->set('EstatusProduccion', 'ALMACEN CORTE')
                    ->set('DeptoProduccion', 105)
                    ->where('Control', $Control)
                    ->update('controles');

            $this->db->set('fec42', Date('Y-m-d h:i:s'))
                    ->where('contped', $Control)
                    ->update('avaprd');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
