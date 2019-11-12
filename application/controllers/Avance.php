<?php

class Avance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance_model', 'avm')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vAvance')->view('vFooter');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas')->view('vAvance')->view('vFooter');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales')->view('vAvance')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vAvance')->view('vFooter');
                    break;
                default:
                    header("Location: " . base_url());
                    break;
            }
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
            print json_encode($this->db->query("SELECT E.Numero AS CLAVE, "
                                    . "(CASE "
                                    . "WHEN E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 THEN "
                                    . "CONCAT(E.Numero,' ', (CASE WHEN E.PrimerNombre = \"0\" THEN \"\" ELSE E.PrimerNombre END),' ',(CASE WHEN E.SegundoNombre = \"0\" THEN \"\" ELSE E.SegundoNombre END),' ',(CASE WHEN E.Paterno = \"0\" THEN \"\" ELSE E.Paterno END),' ', (CASE WHEN E.Materno = \"0\" THEN \"\" ELSE E.Materno END)) "
                                    . "WHEN E.AltaBaja = 2 AND E.Celula NOT IN(0) THEN CONCAT(E.Numero,' ',E.Busqueda) END) AS EMPLEADO "
                                    . "FROM empleados AS E "
                                    . "WHERE E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 "
                                    . "OR E.AltaBaja = 2 AND E.Celula NOT IN(0)")->result());
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
            print json_encode($this->db->select("A.Departamento AS DEPTO, C.Estilo AS ESTILO,  C.DeptoProduccion AS DEPTOPROD, "
                                            . "(CASE "
                                            . "WHEN E.MaqPlant1 IS NULL OR E.MaqPlant1 = \"0\" THEN "
                                            . "(CASE WHEN E.MaqPlant2 IS NULL OR E.MaqPlant2 = \"0\" THEN "
                                            . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant3 = \"0\" THEN  "
                                            . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant4 = \"0\" THEN \"\" "
                                            . "ELSE E.MaqPlant4 END) "
                                            . "ELSE E.MaqPlant3 END)"
                                            . "ELSE E.MaqPlant2 END)  "
                                            . "ELSE E.MaqPlant1 END) AS MAQUILADO, "
                                            . "C.Pares AS PARES, E.Foto AS FOTO, P.stsavan AS ESTATUS_PRODUCCION", false)
                                    ->from('avance AS A')
                                    ->join('controles AS C', 'A.Control = C.Control')
                                    ->join('pedidox AS P', 'A.Control = P.Control')
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
            print json_encode($this->db->select("A.Departamento AS DEPTO, C.Estilo AS ESTILO,  C.DeptoProduccion AS DEPTOPROD, "
                                            . "(CASE "
                                            . "WHEN E.MaqPlant1 IS NULL OR E.MaqPlant1 = \"0\" THEN "
                                            . "(CASE WHEN E.MaqPlant2 IS NULL OR E.MaqPlant2 = \"0\" THEN "
                                            . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant3 = \"0\" THEN  "
                                            . "(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant4 = \"0\" THEN \"\" "
                                            . "ELSE E.MaqPlant4 END) "
                                            . "ELSE E.MaqPlant3 END)"
                                            . "ELSE E.MaqPlant2 END)  "
                                            . "ELSE E.MaqPlant1 END) AS MAQUILADO, "
                                            . "C.Pares AS PARES, E.Foto AS FOTO, P.stsavan AS ESTATUS_PRODUCCION, P.Maquila AS MAQUILA", false)
                                    ->from('avance AS A')
                                    ->join('controles AS C', 'A.Control = C.Control')
                                    ->join('pedidox AS P', 'A.Control = P.Control')
                                    ->join('estilos AS E', 'E.Clave = P.Estilo')
                                    ->where("A.Control", $x['CONTROL'])
                                    ->order_by("A.ID", "DESC")
                                    ->limit(1)->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $db = $this->db;
            $x = $this->input;
            $xXx = $this->input->post();
            $id = 0;
            $frac = 0;
            if ($frac !== '') {
                $frac = intval($x->post('FRACCION'));
            }
            $depto = intval($x->post('DEPTO'));
            $depto_actual = intval($x->post('AVANCEDEPTOACTUAL'));
            $PROCESO_MAQUILA = intval($x->post('PROCESO_MAQUILA'));

            if ($depto === 33 && $depto_actual === 3 && $frac === 102 ||
                    $depto === 33 && $depto_actual === 3 && $frac === 93 ||
                    $depto === 33 && $depto_actual === 3 && $frac === 113) {

//                93	RAYADO PROTOTIPO
//                102	RAYADO
//                113	RAYADO MUESTRA

                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                ->from('fracpagnomina AS F')
                                ->where('F.control', $xXx['CONTROL'])
                                ->where('F.numfrac', $frac)
                                ->get()->result();
                if (intval($check_fraccion[0]->EXISTE) >= 1) {
                    exit(0);
                }
                /* REBAJADO Y PERFORADO */
                switch (intval($frac)) {
                    case 102:
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
                            'Fraccion' => 103
                        ));
                        $id = $this->db->insert_id();
                        $this->db->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)
                                ->where('Control', $xXx['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 33)->set('EstatusProduccion', 'REBAJADO')
                                ->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec33', Date('Y-m-d h:i:s'))->where('contped', $xXx['CONTROL'])
                                ->update('avaprd');
                        $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                        $data = array(
                            "numeroempleado" => $xXx['EMPLEADO'],
                            "maquila" => intval($CONTROL[0]->MAQUILA),
                            "control" => $xXx['CONTROL'],
                            "estilo" => $xXx['ESTILO'],
                            "pares" => $xXx['PARES'],
                            "fecha" => Date('Y-m-d h:i:s'),
                            "semana" => $xXx['SEMANA'],
                            "depto" => $xXx['DEPTO'],
                            "anio" => Date('Y'));
                        $data["fraccion"] = $xfraccion;
                        $data["numfrac"] = $xfraccion;
                        $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                        $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                        $data["preciofrac"] = $PXFC;
                        $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                        $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                        $this->db->insert('fracpagnomina', $data);
                        break;
                    default:
                        $this->onPagarFraccionSinAvance($xXx, $frac);
                        break;
                }
                exit(0);
            }

            if ($depto === 4 && $frac === 103 && $depto_actual <= 33 ||
                    $depto === 4 && $frac === 59 && $depto_actual <= 33 ||
                    $depto === 4 && $frac === 58 && $depto_actual <= 33) {
//                    59	REBAJAR CASCO
//                    58	REBAJAR CONTRAFUERTE
//                    103	REBAJAR PIEL

                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                ->from('fracpagnomina AS F')
                                ->where('F.control', $xXx['CONTROL'])
                                ->where('F.numfrac', $frac)
                                ->get()->result();
                if (intval($check_fraccion[0]->EXISTE) >= 1) {
                    exit(0);
                }
                switch (intval($frac)) {
                    case 103:
                        /* FOLEADO */
                        $this->db->set('EstatusProduccion', 'FOLEADO')->set('DeptoProduccion', 40)
                                ->where('Control', $xXx['CONTROL'])
                                ->update('controles');
                        $this->db->set('stsavan', 4)->set('EstatusProduccion', 'FOLEADO')
                                ->set('DeptoProduccion', 40)->where('Control', $xXx['CONTROL'])
                                ->update('pedidox');
                        $this->db->set('fec4', Date('Y-m-d h:i:s'))
                                ->where('contped', $xXx['CONTROL'])
                                ->update('avaprd');

                        /* PAGAR FRACCION */
                        $this->onPagarFraccion($xXx, 60, 40, 'FOLEADO');
                        $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A FOLEADO.", $this->session);
                        break;
                    default:
                        $this->onPagarFraccionSinAvance($xXx, $frac);
                        break;
                }
                exit(0);
            }

            if ($depto_actual === 42 && $PROCESO_MAQUILA >= 1) {
                $this->db->insert('avance', array(
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
                ));
                $id = $this->db->insert_id();

                $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)
                        ->where('Control', $xXx['CONTROL'])
                        ->update('controles');
                $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')
                        ->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])
                        ->update('pedidox');
                $this->db->set('fec44', Date('Y-m-d h:i:s'))
                        ->where('contped', $xXx['CONTROL'])
                        ->update('avaprd');
                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE CORTE.", $this->session);
                exit(0);
            }
            /* CUANDO NO OCUPAN (40 ENTRETELADO) PERO ESTAN EN ESE DEPTO 
             * Y ES NECESARIO MOVERLOS A (44 ALM-CORTE) PORQUE TAMPOCO UTILIZAN (42 PROCESO MAQUILA) */
            if ($depto === 44 && $frac === 51 && intval($xXx['EMPLEADO']) === 2160 && $depto_actual === 40 && $PROCESO_MAQUILA === 0) {
                $this->db->insert('avance', array(
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
                ));
                $id = $this->db->insert_id();
                $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)
                        ->where('Control', $xXx['CONTROL'])
                        ->update('controles');
                $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')
                        ->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])
                        ->update('pedidox');
                $this->db->set('fec44', Date('Y-m-d h:i:s'))
                        ->where('contped', $xXx['CONTROL'])
                        ->update('avaprd');
                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE CORTE.", $this->session);
                exit(0);
            }

            /* 5 PESPUNTE Y STSAVAN 44 ALM-CORTE */
            if ($depto === 5 && $depto_actual === 44) {
                /* 44 ALMACEN DE CORTE A 5 PESPUNTE */
                $this->db->set('EstatusProduccion', 'PESPUNTE')
                        ->set('DeptoProduccion', 110)
                        ->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 5)
                        ->set('EstatusProduccion', 'PESPUNTE')
                        ->set('DeptoProduccion', 110)
                        ->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set("status", 5)->set("pespunte", $xXx['EMPLEADO'])->set("fec5", Date('Y-m-d h:i:s'))
                        ->where('contped', $xXx['CONTROL'])->update('avaprd');
                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - PESPUNTE.", $this->session);
                exit(0);
            }
            /* 55 ENSUELADO */
            /* 55 ENSUELADO Y STSAVAN 5 PESPUNTE */
            if ($depto === 55 && $depto_actual === 5 && $frac === 300 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 303 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 298 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 290 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 295 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 299 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 90 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 300 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 302 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 301 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 304 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 322 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 324 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 199 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 317 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 349 ||
                    $depto === 55 && $depto_actual === 5 && $frac === 333) {
                /* 5 PESPUNTE A 55 ENSUELADO, CON PAGO DE FRACCION DE 300 PESPUNTE GENERAL */
//                303	PIOCHA DE PESPUNTE +
//                299	PESPUNTE MUESTRA +
//                90	PESPUNTE PROTOTIPO+
//                300	PESPUNTE GENERAL+
//                301	PESPUNTAR PLANTILLA+
//                302	MAQ. PESPUNTE +
//                304	PRELIMINAR DE PESPUNTE +
//                324	PESPUNTAR YUTE +
//                322	PESPUNTE ORISOL +
//                199	PESPUNTA R BASE DE HERRAJ +
//                317	PESPUNTAR TALON PLANTILLA + 
//                298	PESPUNTAR FLOR +
//                295	PESPUNTAR FLOR +
//                349	PESPUNTE CONTORNO +
//                290	PESPUNTAR APLI. PLANTILLA +
//                333	PONER CASCO - C. PESPUNTE +

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                if (intval($check_fraccion[0]->EXISTE) === 0) {
                    switch (intval($frac)) {
                        case 300:
                            $this->db->set('EstatusProduccion', 'ENSUELADO')
                                    ->set('DeptoProduccion', 140)
                                    ->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 55)
                                    ->set('EstatusProduccion', 'ENSUELADO')
                                    ->set('DeptoProduccion', 140)
                                    ->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set("status", 55)->set("fec55", Date('Y-m-d h:i:s'))
                                    ->where('contped', $xXx['CONTROL'])->update('avaprd');

                            /* PAGAR FRACCION */
                            // 300 PESPUNTE GENERAL
                            $this->onPagarFraccion($xXx, 300, 140, 'ENSUELADO');
                            $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ENSUELADO.", $this->session);
                            break;
                        default:
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                            break;
                    }
                }
                exit(0);
            }
            /* 6 ALMACEN - PESPUNTE Y STSAVAN 55 ENSUELADO */
            /* 55 ENSUELADO (FRACCIONES) */
            if ($depto === 6 && $depto_actual === 55 && $frac === 306 ||
                    $depto === 6 && $depto_actual === 55 && $frac === 502 ||
                    $depto === 6 && $depto_actual === 55 && $frac === 397) {

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                if (intval($check_fraccion[0]->EXISTE) === 0) {
                    switch (intval($frac)) {
                        case 397: $this->db->set('EstatusProduccion', 'ALMACEN PESPUNTE')
                                    ->set('DeptoProduccion', 130)
                                    ->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 6)
                                    ->set('EstatusProduccion', 'ALMACEN PESPUNTE')
                                    ->set('DeptoProduccion', 130)
                                    ->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set("status", 6)->set("fec6", Date('Y-m-d h:i:s'))
                                    ->where('contped', $xXx['CONTROL'])->update('avaprd');

                            /* PAGAR FRACCION */
                            // 300 PESPUNTE GENERAL
                            $this->onPagarFraccion($xXx, 397, 130, 'ALMACEN PESPUNTE');
                            $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE PESPUNTE.", $this->session);
                            break;
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                        default:
                            break;
                    }
                }
                exit(0);
            }

            /* 7 TEJIDO */
            if ($depto === 7 && $depto_actual === 6) {

                /* 6 ALMACEN PESPUNTE "A" 7 TEJIDO */
                $this->db->set('EstatusProduccion', 'TEJIDO')->set('DeptoProduccion', 150)
                        ->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 7)->set('EstatusProduccion', 'TEJIDO')
                        ->set('DeptoProduccion', 150)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set("status", 7)->set("fec7", Date('Y-m-d h:i:s'))
                        ->where('contped', $xXx['CONTROL'])->update('avaprd');
                $ID = $this->db->insert('avance', array(
                    'Control' => $xXx['CONTROL'],
                    'FechaAProduccion' => Date('d/m/Y'),
                    'Departamento' => 150,
                    'DepartamentoT' => 'TEJIDO',
                    'FechaAvance' => Date('d/m/Y')/* FECHA AVANCE */,
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => 401
                ));
                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - TEJIDO.", $this->session);

                exit(0);
            }
            /* AVANCE A ALMACEN DE TEJIDO , PAGA NOMINA DE TEJIDO */
            if ($depto === 8 && $depto_actual === 7 && $frac === 401 ||
                    $depto === 8 && $depto_actual === 7 && $frac === 402 ||
                    $depto === 8 && $depto_actual === 7 && $frac === 403 ||
                    $depto === 8 && $depto_actual === 7 && $frac === 89 ||
                    $depto === 8 && $depto_actual === 7 && $frac === 320 ||
                    $depto === 8 && $depto_actual === 7 && $frac === 404) {
                /* 7 TEJIDO "A" 8 ALMACEN DE TEJIDO */
//                    404	TEJIDA MAQUINA  2 +
//                    89	TEJIDA PROTOTIPO +
//                    320	TEJIDA TIRAS +
//                    401	TEJIDA A MANO * GENERA AVANCE * +
//                    402	TEJIDA A MANO MUESTRA
//                    403	TEJIDA MAQUINA 1 

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();

//                var_dump($check_fraccion);
//                exit(0);
                switch (intval($frac)) {
                    case 401:
                        /* YA NO SE PAGA FRACCION PORQUE ESTE TIENE UN MODULO DEDICADO DONDE SE PAGA DIRECTO,SOLO MUEVE EL CONTROL A ALMACEN TEJIDO 
                         * VER AVANCE TEJIDO (vAvanceTejido, AvanceTejido) */
                        $this->db->insert('avance', array(
                            'Control' => $xXx['CONTROL'],
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 160,
                            'DepartamentoT' => 'ALMACEN TEJIDO',
                            'FechaAvance' => Date('d/m/Y'),
                            'Estatus' => 'A',
                            'Usuario' => $_SESSION["ID"],
                            'Fecha' => Date('d/m/Y'),
                            'Hora' => Date('h:i:s a'),
                            'Fraccion' => NULL
                        ));
                        $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)
                                ->where('Control', $xXx['CONTROL'])->update('controles');
                        $this->db->set('stsavan', 8)->set('EstatusProduccion', 'ALMACEN TEJIDO')
                                ->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        $this->db->set("status", 8)->set("fec8", Date('Y-m-d h:i:s'))
                                ->where('contped', $xXx['CONTROL'])->update('avaprd');
                        $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE TEJIDO.", $this->session);
                        exit(0);
                        break;
                    default:
                        if (intval($check_fraccion[0]->EXISTE) === 0) {
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                        }
                        exit(0);
                        break;
                }
                exit(0);
            }

            /* MARTIN */
            /* 9 MONTADO */
            /* AVANCE A "MONTADO A" O "MONTADO B" (SOLO LOS MUEVE DE ALMACEN TEJIDO A "MONTADO", NO PAGA NOMINA) */
            if ($depto === 9 && $depto_actual === 8) {
                /* SACA DE ALMACEN DE TEJIDO Y LOS PONE EN MONTADO (SOLO MUEVE) */
                $this->db->insert('avance', array(
                    'Control' => $xXx['CONTROL'],
                    'FechaAProduccion' => Date('d/m/Y'),
                    'Departamento' => 180,
                    'DepartamentoT' => 'MONTADO A',
                    'FechaAvance' => Date('d/m/Y'),
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => NULL
                ));
                $this->db->set('EstatusProduccion', 'MONTADO A')->set('DeptoProduccion', 180)
                        ->where('Control', $xXx['CONTROL'])
                        ->update('controles');
                $this->db->set('stsavan', 9)->set('EstatusProduccion', 'MONTADO A')
                        ->set('DeptoProduccion', 180)->where('Control', $xXx['CONTROL'])
                        ->update('pedidox');
                $this->db->set('fec9', Date('Y-m-d h:i:s'))
                        ->where('contped', $xXx['CONTROL'])
                        ->update('avaprd');
                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - MONTADO A.", $this->session);
                exit(0);
            }
            /* 10 ADORNO */
            /* AVANCE A "ADORNO A" O "ADORNO B" (MUEVE EL AVANCE A ADORNO (NO PAGA ADORNO), PAGA NOMINA DE MONTADO) */
            if ($depto === 10 && $depto_actual === 9) {
                if ($frac === 88 && $depto_actual === 9 ||
                        $frac === 499 && $depto_actual === 9 ||
                        $frac === 500 && $depto_actual === 9 ||
                        $frac === 503 && $depto_actual === 9) {
                    //88	MONTADO PROTOTIPO
                    //499	MONTADO MUESTRA
                    //500	MONTADO GENERAL "A" * (GENERA AVANCE) *
                    //503	MONTADO GENERAL "B"

                    $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                    if (intval($check_fraccion[0]->EXISTE) === 0) {
                        switch (intval($frac)) {
                            case 500:
                                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ADORNO A.", $this->session);
                                $this->onPagarFraccion($xXx, $frac, 210, 'ADORNO A');
                                $this->db->set('EstatusProduccion', 'ADORNO A')->set('DeptoProduccion', 210)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('controles');
                                $this->db->set('stsavan', 10)->set('EstatusProduccion', 'ADORNO A')
                                        ->set('DeptoProduccion', 210)->where('Control', $xXx['CONTROL'])
                                        ->update('pedidox');
                                $this->db->set('fec10', Date('Y-m-d h:i:s'))
                                        ->where('contped', $xXx['CONTROL'])
                                        ->update('avaprd');
                                exit(0);
                                break;
                            default:
                                $this->onPagarFraccionSinAvance($xXx, $frac);
                                exit(0);
                                break;
                        }
                    }
                }
            }
            /* 11 ALMACEN ADORNO */
            /* AVANCE A "ALMACEN ADORNO"  (MUEVE EL AVANCE A ALMACEN ADORNO (NO PAGA ALMACEN ADORNO), PAGA NOMINA DE ADORNO) */
            if ($depto === 11 && $depto_actual === 10) {
                if ($frac === 87 && $depto_actual === 10 ||
                        $frac === 600 && $depto_actual === 10 ||
                        $frac === 602 && $depto_actual === 10 ||
                        $frac === 606 && $depto_actual === 10 ||
                        $frac === 607 && $depto_actual === 10) {
//                    606	ARM.PLANTILLA ADORNO MUES
//                    87	ADORNO PROTOTIPO
//                    600	ADORNO GENERAL * (GENERA AVANCE) *
//                    602	PLANTILLA DE ADORNO
//                    607	ARMAR PLANTILLA DE ADORNO

                    $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                    if (intval($check_fraccion[0]->EXISTE) === 0) {
                        switch (intval($frac)) {
                            case 600:
                                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN ADORNO.", $this->session);
                                $this->onPagarFraccion($xXx, $frac, 230, 'ALMACEN ADORNO');

                                $this->db->set('EstatusProduccion', 'ALMACEN ADORNO')->set('DeptoProduccion', 230)
                                        ->where('Control', $xXx['CONTROL'])
                                        ->update('controles');
                                $this->db->set('stsavan', 11)->set('EstatusProduccion', 'ALMACEN ADORNO')
                                        ->set('DeptoProduccion', 230)->where('Control', $xXx['CONTROL'])
                                        ->update('pedidox');
                                $this->db->set('fec11', Date('Y-m-d h:i:s'))
                                        ->where('contped', $xXx['CONTROL'])
                                        ->update('avaprd');
                                exit(0);
                                break;
                            default:
                                $this->onPagarFraccionSinAvance($xXx, $frac);
                                exit(0);
                                break;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagarFraccion($xXx, $fraccion, $depto_avance, $depto_avance_txt) {
        try {
            $xfraccion = $fraccion;
            $id = 0;
            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                            ->from('fracpagnomina AS F')
                            ->where('F.control', $xXx['CONTROL'])
                            ->where('F.numfrac', $xfraccion)
                            ->get()->result();
            if (intval($check_fraccion[0]->EXISTE) >= 1) {
                exit(0);
            }
            $this->db->insert('avance', array(
                'Control' => $xXx['CONTROL'],
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => $depto_avance,
                'DepartamentoT' => $depto_avance_txt,
                'FechaAvance' => Date('d/m/Y'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => 0
            ));
            $id = $this->db->insert_id();
            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $data = array(
                "numeroempleado" => $xXx['EMPLEADO'],
                "maquila" => intval($CONTROL[0]->MAQUILA),
                "control" => $xXx['CONTROL'],
                "estilo" => $xXx['ESTILO'],
                "pares" => $xXx['PARES'],
                "fecha" => Date('Y-m-d h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPTO'],
                "anio" => Date('Y'));
            $data["fraccion"] = $xfraccion;
            $data["numfrac"] = $xfraccion;
            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
            $data["preciofrac"] = $PXFC;
            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
            $this->db->insert('fracpagnomina', $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagarFraccionSinAvance($xXx, $fraccion) {
        try {
            $xfraccion = $fraccion;
            $id = 0;
            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                            ->from('fracpagnomina AS F')
                            ->where('F.control', $xXx['CONTROL'])
                            ->where('F.numfrac', $xfraccion)
                            ->get()->result();
            if (intval($check_fraccion[0]->EXISTE) >= 1) {
                exit(0);
            }
            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $data = array(
                "numeroempleado" => $xXx['EMPLEADO'],
                "maquila" => intval($CONTROL[0]->MAQUILA),
                "control" => $xXx['CONTROL'],
                "estilo" => $xXx['ESTILO'],
                "pares" => $xXx['PARES'],
                "fecha" => Date('Y-m-d h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPTO'],
                "anio" => Date('Y'));
            $data["fraccion"] = $xfraccion;
            $data["numfrac"] = $xfraccion;
            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
            $data["preciofrac"] = $PXFC;
            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
            $data["avance_id"] = NULL;
            $this->db->insert('fracpagnomina', $data);
            $l = new Logs("Captura de Avance de produccion", "HA COBRADO O PAGADO LA FRACCION {$xfraccion} PARA EL CONTROL {$xXx['CONTROL']}.", $this->session);
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

    public function ImprimePagosCelulas() {
        try {
            $x = $this->input->post();
            $FECHA = explode('/', $x['FECHA']);
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["EMPLEADO"] = $x['EMPLEADO'];
            $parametros["SEMANA"] = $x['SEMANA'];
            $parametros["ANIO"] = intval($FECHA[2]);
            $jc->setJasperurl("jrxml\avance\pagonomina.jasper");
            $jc->setParametros($parametros);
            $jc->setFilename('PAGONOMINA_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControlParaRastreo() {
        try {
            $x = $this->input->post();
            print json_encode($this->db->query("SELECT P.stsavan AS AVANCE_ACTUAL, (SELECT F.Descripcion FROM fracciones as F WHERE F.Clave = {$x['FRACCION']} LIMIT 1) AS FRACCION_DES FROM pedidox AS P WHERE P.Control =  {$x['CONTROL']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
