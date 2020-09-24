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
                case 'SUPER ADMINISTRADOR' || 'PRODUCCION' || 'SUPERVISION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vAvance')->view('vFooter');
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas')->view('vAvance')->view('vFooter');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales')->view('vAvance')->view('vFooter');
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

            $FRACCION_100 = "<span class=\"fracciones_avance\">100</span>";
            $FRACCION_102 = "<span  class=\"fracciones_avance\">102</span>";
            $FRACCION_60 = "<span  class=\"fracciones_avance\">60</span>";
            $FRACCION_103 = "<span  class=\"fracciones_avance\">103</span>";
            $FRACCION_51 = "<span  class=\"fracciones_avance\">51</span>";
            $FRACCION_300 = "<span  class=\"fracciones_avance\">300</span>";
            $FRACCION_397 = "<span  class=\"fracciones_avance\">397</span>";
            $FRACCION_401 = "<span  class=\"fracciones_avance\">401</span>";
            $FRACCION_500 = "<span  class=\"fracciones_avance\">500</span>";
            $FRACCION_600 = "<span  class=\"fracciones_avance\">600</span>";
            $x = $this->input->get();
            $this->db->select("F.ID, F.numeroempleado AS EMPLEADO, F.maquila AS MAQUILA, "
                            . "F.control AS CONTROL, F.estilo AS ESTILO, "
                            . "CONCAT((CASE "
                            . "WHEN F.numfrac = 100 THEN '{$FRACCION_100}' "
                            . "WHEN F.numfrac = 102 THEN '{$FRACCION_102}' "
                            . "WHEN F.numfrac = 60 THEN '{$FRACCION_60}' "
                            . "WHEN F.numfrac = 103 THEN '{$FRACCION_103}' "
                            . "WHEN F.numfrac = 51 THEN '{$FRACCION_51}' "
                            . "WHEN F.numfrac = 300 THEN '{$FRACCION_300}' "
                            . "WHEN F.numfrac = 397 THEN '{$FRACCION_397}' "
                            . "WHEN F.numfrac = 401 THEN '{$FRACCION_401}' "
                            . "WHEN F.numfrac = 500 THEN '{$FRACCION_500}' "
                            . "WHEN F.numfrac = 600 THEN '{$FRACCION_600}' "
                            . "ELSE F.numfrac END),"
                            . "' ',(SELECT FR.Descripcion FROM fracciones AS FR WHERE FR.Clave = F.numfrac limit 1)) AS NUM_FRACCION, "
                            . "F.preciofrac AS PRECIO_FRACCION, F.pares AS PARES, F.subtot AS SUBTOTAL, "
                            . "F.status, DATE_FORMAT(F.fecha,\"%d/%m/%Y\")  AS FECHA, F.semana AS SEMANA, F.depto, "
                            . "F.registro, F.anio, F.avance_id, F.fraccion AS FRACCION, F.modulo AS MODULO ", false)
                    ->from("fracpagnomina AS F");
            if ($x['CONTROL'] !== '') {
                $this->db->where('F.control', $x['CONTROL']);
            }

            if ($x['EMPLEADO'] !== '') {
                $this->db->where('F.numeroempleado', $x['EMPLEADO']);
            }
            $this->db->order_by('F.fecha', 'DESC');
            if ($x['CONTROL'] === '' && $x['EMPLEADO'] === '') {
                $this->db->where('F.numeroempleado', 999999999999)->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAvancesNominaPespunteFail() {
        try {

            $FRACCION_100 = "<span class=\"fracciones_avance\">100</span>";
            $FRACCION_102 = "<span  class=\"fracciones_avance\">102</span>";
            $FRACCION_60 = "<span  class=\"fracciones_avance\">60</span>";
            $FRACCION_103 = "<span  class=\"fracciones_avance\">103</span>";
            $FRACCION_51 = "<span  class=\"fracciones_avance\">51</span>";
            $FRACCION_300 = "<span  class=\"fracciones_avance\">300</span>";
            $FRACCION_397 = "<span  class=\"fracciones_avance\">397</span>";
            $FRACCION_401 = "<span  class=\"fracciones_avance\">401</span>";
            $FRACCION_500 = "<span  class=\"fracciones_avance\">500</span>";
            $FRACCION_600 = "<span  class=\"fracciones_avance\">600</span>";
//            modulo
            $x = $this->input->get();
            $this->db->select("F.ID, F.numeroempleado AS EMPLEADO, F.maquila AS MAQUILA, "
                            . "F.control AS CONTROL, F.estilo AS ESTILO, "
                            . "CONCAT((CASE "
                            . "WHEN F.numfrac = 100 THEN '{$FRACCION_100}' "
                            . "WHEN F.numfrac = 102 THEN '{$FRACCION_102}' "
                            . "WHEN F.numfrac = 60 THEN '{$FRACCION_60}' "
                            . "WHEN F.numfrac = 103 THEN '{$FRACCION_103}' "
                            . "WHEN F.numfrac = 51 THEN '{$FRACCION_51}' "
                            . "WHEN F.numfrac = 300 THEN '{$FRACCION_300}' "
                            . "WHEN F.numfrac = 397 THEN '{$FRACCION_397}' "
                            . "WHEN F.numfrac = 401 THEN '{$FRACCION_401}' "
                            . "WHEN F.numfrac = 500 THEN '{$FRACCION_500}' "
                            . "WHEN F.numfrac = 600 THEN '{$FRACCION_600}' "
                            . "ELSE F.numfrac END),"
                            . "' ',(SELECT FR.Descripcion FROM fracciones AS FR WHERE FR.Clave = F.numfrac limit 1)) AS NUM_FRACCION, "
                            . "F.preciofrac AS PRECIO_FRACCION, F.pares AS PARES, F.subtot AS SUBTOTAL, "
                            . "F.status, DATE_FORMAT(F.fecha,\"%d/%m/%Y\")  AS FECHA, F.semana AS SEMANA, F.depto, "
                            . "F.registro, F.anio, F.avance_id, F.fraccion AS FRACCION", false)
                    ->from("fracpagnomina AS F");
            if ($x['CONTROL'] !== '') {
                $this->db->where('F.control', $x['CONTROL']);
            }
            $this->db->order_by('F.fecha', 'DESC');
            if ($x['CONTROL'] === '' && $x['EMPLEADO'] === '') {
                $this->db->where('F.numeroempleado', 999999999999)->limit(25);
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
//            991	CELULA  MONTADO "B"
//            992	CELULA  ADORNO "A"
//            993	CELULA  MONTADO "A"
//            1005 CELULA  ADORNO "B"
//            1006 PEGADO
            print json_encode($this->db->query("SELECT E.Numero AS CLAVE, "
                                            . "(CASE "
                                            . "WHEN E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 THEN "
                                            . "CONCAT(E.Numero,' ', (CASE WHEN E.PrimerNombre = \"0\" THEN \"\" ELSE E.PrimerNombre END),' ',"
                                            . "(CASE WHEN E.SegundoNombre = \"0\" THEN \"\" ELSE E.SegundoNombre END),' ',"
                                            . "(CASE WHEN E.Paterno = \"0\" THEN \"\" ELSE E.Paterno END),' ', "
                                            . "(CASE WHEN E.Materno = \"0\" THEN \"\" ELSE E.Materno END)) "
                                            . "WHEN E.AltaBaja = 2 AND E.Celula NOT IN(0) THEN CONCAT(E.Numero,' ',E.Busqueda) "
                                            . "WHEN E.AltaBaja = 2 AND E.Celula IN(0) AND E.Numero IN(991,992,993,1005,1006) THEN CONCAT(E.Numero,' ',E.Busqueda) "
                                            . "END) AS EMPLEADO "
                                            . "FROM empleados AS E "
                                            . "WHERE E.FijoDestajoAmbos IN(2,3) AND E.AltaBaja = 1 "
                                            . "OR E.AltaBaja = 2 AND E.Celula NOT IN(0) OR E.Numero IN(991,992,993,1005,1006)")
                                    ->result());
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
                                            . "C.Pares AS PARES, E.Foto AS FOTO, P.stsavan AS ESTATUS_PRODUCCION, P.EstatusProduccion AS ESTATUS_PRODUCCION_TEXT ", false)
                                    ->from('avance AS A')
                                    ->join('controles AS C', 'A.Control = C.Control')
                                    ->join('pedidox AS P', 'A.Control = P.Control')
                                    ->join('fichatecnica AS F', 'F.Estilo = C.Estilo AND F.Color = C.Color')
                                    ->join('estilos AS E', 'E.Clave = F.Estilo')
                                    ->like("A.Control", $this->input->post('CONTROL'))
                                    ->order_by("A.Departamento", "DESC")
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
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => $x->post('DEPTO'),
                'DepartamentoT' => $x->post('DEPTOT'),
                'FechaAvance' => $x->post('FECHA_AVANCE'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'modulo' => 'CA'
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
            print json_encode($this->db->query("SELECT P.DeptoProduccion AS DEPTO, E.Clave AS ESTILO, P.DeptoProduccion AS DEPTOPROD, (CASE WHEN E.MaqPlant1 IS NULL OR E.MaqPlant1 = \"0\" THEN (CASE WHEN E.MaqPlant2 IS NULL OR E.MaqPlant2 = \"0\" THEN 
(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant3 = \"0\" THEN (CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant4 = \"0\" THEN \"\" ELSE E.MaqPlant4 END) 
ELSE E.MaqPlant3 END)ELSE E.MaqPlant2 END) ELSE E.MaqPlant1 END) AS MAQUILADO, P.Pares AS PARES, E.Foto AS FOTO, P.stsavan AS ESTATUS_PRODUCCION, P.EstatusProduccion AS ESTATUS_PRODUCCION_TEXT,
P.Maquila AS MAQUILA 
 FROM pedidox AS P INNER JOIN estilos AS E ON P.Estilo = E.Clave WHERE P.Control = {$x['CONTROL']} AND P.stsavan NOT IN(12,13,14) AND P.DeptoProduccion NOT IN(240, 260,270) LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInformacionXControlFC() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.DeptoProduccion AS DEPTO, E.Clave AS ESTILO, P.DeptoProduccion AS DEPTOPROD, (CASE WHEN E.MaqPlant1 IS NULL OR E.MaqPlant1 = \"0\" THEN (CASE WHEN E.MaqPlant2 IS NULL OR E.MaqPlant2 = \"0\" THEN 
(CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant3 = \"0\" THEN (CASE WHEN E.MaqPlant3 IS NULL OR E.MaqPlant4 = \"0\" THEN \"\" ELSE E.MaqPlant4 END) 
ELSE E.MaqPlant3 END)ELSE E.MaqPlant2 END) ELSE E.MaqPlant1 END) AS MAQUILADO, P.Pares AS PARES, E.Foto AS FOTO, P.stsavan AS ESTATUS_PRODUCCION, P.EstatusProduccion AS ESTATUS_PRODUCCION_TEXT,
P.Maquila AS MAQUILA 
 FROM pedidox AS P INNER JOIN estilos AS E ON P.Estilo = E.Clave WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result());
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

            $REVISA_CONTROL = $this->db->query("SELECT COUNT(*) AS EXISTE "
                            . "FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} AND "
                            . "P.stsavan NOT IN(12,13,14) AND P.EstatusProduccion NOT IN('CANCELADO') "
                            . "AND P.Estatus NOT IN('C') AND P.DeptoProduccion NOT IN(240,260,270) LIMIT 1")->result();
            if (intval($REVISA_CONTROL[0]->EXISTE) === 0) {
                print "CONTROL {$xXx['CONTROL']} CANCELADO O NO EXISTE O ESTA MAL ESCRITO";
                exit(0);
            }

            /* depto ES EL DEPARTAMENTO AL QUE SE QUIERE MOVER, depto_actual ES EL DEPARTAMENTO DONDE ESTA ACTUALMENTE */
            $depto = intval($x->post('DEPTO'));
            $depto_actual = intval($x->post('AVANCEDEPTOACTUAL'));
            $PROCESO_MAQUILA = intval($x->post('PROCESO_MAQUILA'));


            /* INICIO COMODINES */
            /*
             * ES PORQUE ESTAN EN ENTRETELADO, PERO NO LLEVAN ENTRETELADO, 
             * PERO LOS MUEVEN DE A "PROCESO MAQUILA PARA PODER AVANZAR"
             * 
              42 = MAQUILA "A" 44 = ALMACEN DE CORTE
             *              */
            if ($depto === 42 && $depto_actual === 40 && $PROCESO_MAQUILA === 0) {
                /* 44 ALMACEN DE CORTE A 5 PESPUNTE */
                $this->db->set('EstatusProduccion', 'MAQUILA')->set('DeptoProduccion', 100)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 42)->set('EstatusProduccion', 'MAQUILA')->set('DeptoProduccion', 100)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec42', Date('Y-m-d 00:00:00'))->where('contped', $xXx['CONTROL'])->where('fec42 IS NULL', null, false)->update('avaprd');

                $revisa_proceso_maquila = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 100")->result();
                if (intval($revisa_proceso_maquila[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 100, 'MAQUILA', NULL);
                }
                exit(0);
            }

            if ($depto_actual === 42 && $PROCESO_MAQUILA >= 1) {
                $revisa_almacen_corte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = {$xXx['CONTROL']} AND Departamento = 105")->result();
                if (intval($revisa_almacen_corte[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 105, 'ALMACEN CORTE', NULL);
                    $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('controles');
                    $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('pedidox');
                    $this->db->set('fec44', Date('Y-m-d 00:00:00'))->where('fec44 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                    $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE CORTE. ", $this->session);
                    exit(0);
                }
            }
            /*
              42 = MAQUILA "A" 44 = ALMACEN DE CORTE
             *              */
            if ($depto === 44 && $depto_actual === 42) {
                /* 44 ALMACEN DE CORTE A 5 PESPUNTE */
                $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec44', Date('Y-m-d 00:00:00'))->where('fec44 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                $revisa_almacen_corte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = {$xXx['CONTROL']} AND Departamento = 105")->result();
                if (intval($revisa_almacen_corte[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 105, 'ALMACEN CORTE', NULL);
                }
                exit(0);
            }

            if ($depto === 5 && $depto_actual === 44) {
                /* 44 ALMACEN DE CORTE A 5 PESPUNTE */
                $revisa_pespunte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = {$xXx['CONTROL']} AND Departamento = 110")->result();
                if (intval($revisa_pespunte[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 110, 'PESPUNTE', NULL);
                    $this->db->set('EstatusProduccion', 'PESPUNTE')->set('DeptoProduccion', 110)->where('Control', $xXx['CONTROL'])->update('controles');
                    $this->db->set('stsavan', 5)->set('EstatusProduccion', 'PESPUNTE')->set('DeptoProduccion', 110)->where('Control', $xXx['CONTROL'])->update('pedidox');
                    $this->db->set("status", 5)->set("pespunte", $xXx['EMPLEADO'])->set("fec5", Date('Y-m-d 00:00:00'))->where('fec5 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                    $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - PESPUNTE. ", $this->session);
                    exit(0);
                } else {
                    $this->db->set('EstatusProduccion', 'PESPUNTE')->set('DeptoProduccion', 110)->where('Control', $xXx['CONTROL'])->update('controles');
                    $this->db->set('stsavan', 5)->set('EstatusProduccion', 'PESPUNTE')->set('DeptoProduccion', 110)->where('Control', $xXx['CONTROL'])->update('pedidox');
                    $this->db->set("status", 5)->set("pespunte", $xXx['EMPLEADO'])->set("fec5", Date('Y-m-d 00:00:00'))->where('fec5 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                    exit(0);
                }
            }

            /* 7 TEJIDO */
            if ($depto === 7 && $depto_actual === 6) {
                $check_tejido = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND A.Departamento = 150")->result();

                if (intval($check_tejido[0]->EXISTE) === 0) {
                    /* 6 ALMACEN PESPUNTE "A" 7 TEJIDO */
                    $this->db->set('EstatusProduccion', 'TEJIDO')->set('DeptoProduccion', 150)->where('Control', $xXx['CONTROL'])->update('controles');
                    $this->db->set('stsavan', 7)->set('EstatusProduccion', 'TEJIDO')->set('DeptoProduccion', 150)->where('Control', $xXx['CONTROL'])->update('pedidox');
                    $this->db->set("status", 7)->set("fec7", Date('Y-m-d 00:00:00'))->where('fec7 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                    $this->onAvance($xXx['CONTROL'], 150, 'TEJIDO', 401);
                    $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - TEJIDO.  ", $this->session);

                    exit(0);
                }
            }
            
            /* AVANCE A ALMACEN DE TEJIDO , PAGA NOMINA DE TEJIDO */
            $fracciones_tejido = array(89, 320, 401, 402, 403, 404);
            if ($depto === 8 && $depto_actual === 7 && in_array(intval($frac), $fracciones_tejido)) {
                 switch (intval($frac)) {
                    case 402:
                    case 401:
                        /* YA NO SE PAGA FRACCION PORQUE ESTE TIENE UN MODULO DEDICADO DONDE SE PAGA DIRECTO,SOLO MUEVE EL CONTROL A ALMACEN TEJIDO 
                         * VER AVANCE TEJIDO (vAvanceTejido, AvanceTejido) */
                        $check_almtejido = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND A.Departamento = 160")->result();
                        if (intval($check_almtejido[0]->EXISTE) >= 1) {
                            exit(0);
                        }
                        $this->onAvance($xXx['CONTROL'], 160, 'ALMACEN TEJIDO', NULL);
                        $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('controles');
                        $this->db->set('stsavan', 8)->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        $this->db->set("status", 8)->set("fec8", Date('Y-m-d 00:00:00'))->where('fec8 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE TEJIDO.  ", $this->session);
                        exit(0);
                        break; 
                }
            }
            /* MARTIN */
            /* 9 MONTADO */
            /* AVANCE A "MONTADO A" O "MONTADO B" (SOLO LOS MUEVE DE ALMACEN TEJIDO A "MONTADO", NO PAGA NOMINA) */
            if ($depto === 9 && $depto_actual === 8) {
                /* SACA DE ALMACEN DE TEJIDO Y LOS PONE EN MONTADO (SOLO MUEVE) */
                $check_montadoa = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control ={$xXx['CONTROL']}  AND A.Departamento = 180")->result();
                if (intval($check_montadoa[0]->EXISTE) >= 1) {
                    exit(0);
                }
                $this->onAvance($xXx['CONTROL'], 180, 'MONTADO A', 500);
                $this->db->set('EstatusProduccion', 'MONTADO A')->set('DeptoProduccion', 180)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 9)->set('EstatusProduccion', 'MONTADO A')->set('DeptoProduccion', 180)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec9', Date('Y-m-d 00:00:00'))->where('fec9 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - MONTADO A.  ", $this->session);
                exit(0);
            }


            /* FIN COMODINES */

            $REVISA_CONTROL_FRACCION_ESTILO = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P "
                            . "INNER JOIN fraccionesxestilo AS FE ON P.Estilo = FE.Estilo "
                            . "WHERE P.Control = {$xXx['CONTROL']} AND P.Estilo = '{$xXx['ESTILO']}' "
                            . "AND FE.Fraccion ={$frac}")->result();
            if (intval($REVISA_CONTROL_FRACCION_ESTILO[0]->EXISTE) === 0) {
                print "EL ESTILO {$xXx['ESTILO']} DEL CONTROL {$xXx['CONTROL']} NO TIENE LA FRACCION {$frac}, VERIFIQUE CON INGENIERIA";
                exit(0);
            }

            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                            ->from('fracpagnomina AS F')
                            ->where('F.control', $xXx['CONTROL'])
                            ->where('F.numfrac', $frac)->get()->result();
            if (intval($check_fraccion[0]->EXISTE) >= 1) {
                print "LA FRACCION {$frac} DEL CONTROL {$xXx['CONTROL']} YA FUE COBRADA, VERIFIQUE EN AVANCE";
                exit(0);
            }

            $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
            if (intval($check_fraccion_plantilla[0]->EXISTE) >= 1) {
                print "LA FRACCION {$frac} YA FUE COBRADA POR UNA MAQUILA EN CONTROLPLA, VERIFIQUE EN NOMINA O EN ALGUN RECIBO.";
                exit(0);
            }



            if ($depto === 10 && $depto_actual === 2 && $frac === 100 && intval($xXx['EMPLEADO']) > 0) {

                $this->db->set('EstatusProduccion', 'RAYADO')->set('DeptoProduccion', 20)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 3)->set('EstatusProduccion', 'RAYADO')->set('DeptoProduccion', 3)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec2', Date('Y-m-d 00:00:00'))->where('fec2 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
            }

            /* DE RAYADO A REBAJADO (YA NO APLICA ESTAN INVERTIDOS, VA PRIMERO FOLEADO Y LUEGO REBAJADO) */
            if ($depto === 33 && $depto_actual === 3 && $frac === 102 ||
                    $depto === 33 && $depto_actual === 3 && $frac === 93 ||
                    $depto === 33 && $depto_actual === 3 && $frac === 113) {

//                93	RAYADO PROTOTIPO
//                102	RAYADO
//                113	RAYADO MUESTRA

                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)->from('fracpagnomina AS F')->where('F.control', $xXx['CONTROL'])->where('F.numfrac', $frac)->get()->result();

                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();

                /* REBAJADO Y PERFORADO */
                switch (intval($frac)) {
                    case 102:
                        if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND Departamento = 30")->result();
                            if (intval($check_avance[0]->EXISTE) === 0) {
                                $this->onAvance($xXx['CONTROL'], 30, 'REBAJADO', 103);
                                $id = $this->db->insert_id();
                            }
                            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                            $data = array(
                                "numeroempleado" => $xXx['EMPLEADO'],
                                "maquila" => intval($CONTROL[0]->MAQUILA),
                                "control" => $xXx['CONTROL'],
                                "estilo" => $xXx['ESTILO'],
                                "pares" => $xXx['PARES'],
                                "fecha" => Date('Y-m-d 00:00:00'),
                                "fecha_registro" => Date('d/m/Y h:i:s'),
                                "semana" => $xXx['SEMANA'],
                                "depto" => $xXx['DEPTOACTUAL'],
                                "anio" => Date('Y'));
                            $data["fraccion"] = 102;
                            $data["numfrac"] = 102;
                            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                            $data["preciofrac"] = $PXFC;
                            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                            $data["modulo"] = 'CA';
                            $this->db->insert('fracpagnomina', $data);
                            $this->db->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 33)->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set('fec33', Date('Y-m-d 00:00:00'))->where('contped', $xXx['CONTROL'])->where('fec33 IS NULL', null, false)->update('avaprd');
                            exit(0);
                        }
                        $REVISAR_AVANCE = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND A.Departamento = 20")->result();
                        if (intval($REVISAR_AVANCE[0]->EXISTE) >= 1 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            $this->db->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 33)->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set('fec33', Date('Y-m-d 00:00:00'))->where('fec33 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        }
                        break;
                    default:
                        if (intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                        }
                        break;
                }
                exit(0);
            }

            /* DE RAYADO A FOLEADO */
            if ($depto === 4 && $depto_actual === 3 && $frac === 102) {
                $this->db->set('EstatusProduccion', 'FOLEADO')->set('DeptoProduccion', 40)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 4)->set('EstatusProduccion', 'FOLEADO')->set('DeptoProduccion', 40)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec4', Date('Y-m-d 00:00:00'))->where('fec4 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');

                $revisa_foleado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 40")->result();
                if (intval($revisa_foleado[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 40, 'FOLEADO', 60);
                }
                exit(0);
            }

            /* DE REBAJADO A ENTRETELADO */
            if ($depto === 40 && $depto_actual === 33 && $frac === 103) {
                $this->db->set('EstatusProduccion', 'ENTRETELADO')->set('DeptoProduccion', 90)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 40)->set('EstatusProduccion', 'ENTRETELADO')->set('DeptoProduccion', 90)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec40', Date('Y-m-d 00:00:00'))->where('fec40 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');

                $revisa_entretelado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 90")->result();
                if (intval($revisa_entretelado[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 90, 'ENTRETELADO', 51);
                }
                exit(0);
            }


            if ($depto === 4 && $frac === 103 && $depto_actual <= 33 ||
                    $depto === 4 && $frac === 59 && $depto_actual <= 33 ||
                    $depto === 4 && $frac === 58 && $depto_actual <= 33) {
//                    59	REBAJAR CASCO
//                    58	REBAJAR CONTRAFUERTE
//                    103	REBAJAR PIEL

                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)->from('fracpagnomina AS F')->where('F.control', $xXx['CONTROL'])->where('F.numfrac', $frac)->get()->result();

                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
                switch (intval($frac)) {
                    case 103:
                        /* REBAJADO */
                        if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            $FRACCION = $frac;
                            if (intval($xXx['EMPLEADO']) === 1894 ||
                                    intval($xXx['EMPLEADO']) === 49) {
                                $data["fraccion"] = $FRACCION;
                                $data["numfrac"] = $FRACCION;
                                /* FILTRADO POR FRACCION 102 RAYADO */
                                $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$FRACCION}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                                $data["preciofrac"] = $PXFC;
                                $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                                $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND Departamento = 30")->result();
                                if (intval($check_avance[0]->EXISTE) === 0) {
                                    $this->onAvance($xXx['CONTROL'], 30, 'REBAJADO', 103);
                                    $id = $this->db->insert_id();
                                    $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                                }
                                $data["modulo"] = 'CA';
                                $this->db->insert('fracpagnomina', $data);
                            }

                            /* AVANCE */
                            $revisar_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Departamento IN(10,20,40) AND A.Control ={$xXx['CONTROL']}")->result();
                            if (intval($revisar_avance[0]->EXISTE) === 3 && intval($check_fraccion_plantilla[0]->EXISTE) <= 0) {
                                //25101503
                                /* 28 / 01 / 2020 */
                                /* REVISAR SI TIENE ENTRETELADO */
                                $REVISAR_ENTRETELADO_X_ESTILO_CONTROL = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS F WHERE F.Fraccion = 51 AND F.Estilo = '{$xXx['ESTILO']}' LIMIT 1")->result();
                                if (intval($REVISAR_ENTRETELADO_X_ESTILO_CONTROL[0]->EXISTE) === 1) {
                                    $this->onAvanzarXControl($xXx['CONTROL'], 'ENTRETELADO', 90, 40);
                                    $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                                    . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 90")->result();
                                    if (intval($check_avance[0]->EXISTE) === 0) {
                                        $this->onAvance($xXx['CONTROL'], 90, 'ENTRETELADO', 51);
                                    }
                                    exit(0);
                                } else {
                                    $this->onAvanzarXControl($xXx['CONTROL'], 'MAQUILA', 100, 42);
                                    $revisa_proceso_maquila = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                                    . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 100")->result();
                                    if (intval($revisa_proceso_maquila[0]->EXISTE) === 0) {
                                        $this->onAvance($xXx['CONTROL'], 100, 'MAQUILA', NULL);
                                    }
                                    exit(0);
                                }
                            }
                            exit(0);
                        }
                        break;
                    default:
                        $this->onPagarFraccionSinAvance($xXx, $frac);
                        break;
                }
                exit(0);
            }

            /* DE FOLEADO A ENTRETELADO */
            if ($depto === 40 && $depto_actual === 4 && $frac === 60) {
                $this->db->set('EstatusProduccion', 'ENTRETELADO')->set('DeptoProduccion', 90)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 40)->set('EstatusProduccion', 'ENTRETELADO')->set('DeptoProduccion', 90)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec40', Date('Y-m-d 00:00:00'))->where('fec40 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');

                $revisa_entretelado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 90")->result();
                if (intval($revisa_entretelado[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 90, 'ENTRETELADO', 51);
                }
                exit(0);
            }

            /* DE FOLEADO A REBAJADO */
            if ($depto === 33 && $depto_actual === 4 && $frac === 103) {
                $this->db->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('controles');
                $this->db->set('stsavan', 33)->set('EstatusProduccion', 'REBAJADO')->set('DeptoProduccion', 30)->where('Control', $xXx['CONTROL'])->update('pedidox');
                $this->db->set('fec33', Date('Y-m-d 00:00:00'))->where('contped', $xXx['CONTROL'])->where('fec33 IS NULL', null, false)->update('avaprd');

                $revisa_rebajado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance "
                                . "WHERE Control = {$xXx['CONTROL']} AND Departamento = 30")->result();
                if (intval($revisa_rebajado[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 30, 'REBAJADO', 103);
                }
                exit(0);
            }

            /* CUANDO NO OCUPAN (40 ENTRETELADO) PERO ESTAN EN ESE DEPTO 
             * Y ES NECESARIO MOVERLOS A (44 ALM-CORTE) PORQUE TAMPOCO UTILIZAN (42 PROCESO MAQUILA) */
            if ($depto === 44 && $frac === 51 && $depto_actual === 40 && $PROCESO_MAQUILA === 0) {
                $revisa_almacen_corte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = {$xXx['CONTROL']} AND Departamento = 105")->result();
                if (intval($revisa_almacen_corte[0]->EXISTE) === 0) {
                    $this->onAvance($xXx['CONTROL'], 105, 'ALMACEN CORTE', NULL);
                    $this->db->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('controles');
                    $this->db->set('stsavan', 44)->set('EstatusProduccion', 'ALMACEN CORTE')->set('DeptoProduccion', 105)->where('Control', $xXx['CONTROL'])->update('pedidox');
                    $this->db->set('fec44', Date('Y-m-d 00:00:00'))->where('fec44 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                    $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE CORTE. ", $this->session);
                    exit(0);
                }
            }


//            $empleados_pes = $this->db->query("SELECT GROUP_CONCAT(E.Numero) AS EMPLEADOS FROM empleados AS E WHERE E.DepartamentoFisico = 110 AND E.AltaBaja = 1")->result();
//            $ex = array(23, 1122, 1186, 1348, 1815, 1870, 1880, 1912, 1995, 2005, 2080, 2217, 2274, 2408, 2498, 2614, 2630, 2631, 2632, 2647, 2684, 2685, 2718, 2752, 2801, 2808, 2809, 2863, 2988, 3005, 3006, 3075, 3076);

            /* 55 ENSUELADO */
            /* 55 ENSUELADO Y STSAVAN 5 PESPUNTE */

            $empleados_celulas = array("899", "995", "994", "996", "997",
                "998", "999", "1000", "1001", "1002",
                "900", "901", "902", "903", "904");
            $ex = array();
            foreach ($this->db->query("SELECT E.Numero AS EMPLEADOS FROM empleados AS E WHERE E.DepartamentoFisico IN(110,70,115) AND E.AltaBaja = 1")->result() as $k => $v) {
                array_push($ex, intval($v->EMPLEADOS));
            }

            $fracciones_pespunte = array(299, 300, 303, 298, 290, 295, 90, 300, 302, 301, 304, 322, 324, 199, 317, 349, 333);

            if ($depto === 55 && $depto_actual === 5 && in_array(intval($frac), $fracciones_pespunte)) {
                /* 5 PESPUNTE A 55 ENSUELADO, CON PAGO DE FRACCION DE 300 PESPUNTE GENERAL */

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();


                if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0 && in_array(intval($xXx['EMPLEADO']), $ex)) {
                    switch (intval($frac)) {
                        case 299:
                        case 300:
                            $FRACCION = 300;
                            $maquila_control = $this->db->query("SELECT P.Maquila FROM pedidox AS P WHERE P.Control ={$xXx['CONTROL']}")->result();
                            if (intval($maquila_control[0]->Maquila) === 98) {
                                $FRACCION = 299;
                            }
                            $check_pespunte_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Departamento = 140 AND A.Control = {$xXx['CONTROL']}")->result();
                            if (intval($check_pespunte_avance[0]->EXISTE) === 0) {
                                $this->db->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('controles');
                                $this->db->set('stsavan', 55)->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('pedidox');
                                $this->db->set("status", 55)->set("fec55", Date('Y-m-d 00:00:00'))->where('fec55 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                            }
                            $check_pespunte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.numfrac IN(300,299) AND F.control = {$xXx['CONTROL']}")->result();
                            if (intval($check_pespunte[0]->EXISTE) === 0) {
                                /* PAGAR FRACCION */
// 300 PESPUNTE GENERAL
                                $this->onPagarFraccion($xXx, $FRACCION, 140, 'ENSUELADO');
                                $l = new Logs("Captura de Avance de produccion", "HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ENSUELADO. ", $this->session);
                            }

                            /* NO TIENE ESTAS FRACCIONES PORQUE VA PEGADO */
                            /* NO TIENE FRACCION 397 */
                            $check_fraccion_ensuelado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS FXE WHERE FXE.Estilo = '{$xXx['ESTILO']}' AND FXE.Fraccion IN(397,396)")->result();
                            /* NO TIENE FRACCION 401 */
                            $check_fraccion_tejido = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS FXE WHERE FXE.Estilo = '{$xXx['ESTILO']}' AND FXE.Fraccion IN(401,402) ")->result();
                            if (intval($check_fraccion_ensuelado[0]->EXISTE) === 0 && intval($check_fraccion_tejido[0]->EXISTE) === 0) {
                                $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('controles');
                                $this->db->set('stsavan', 8)->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('pedidox');
                                $this->db->set("status", 8)->set("fec8", Date('Y-m-d 00:00:00'))->where('fec8 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                                $this->onPagarFraccion($xXx, $FRACCION, 140, 'ENSUELADO');
                                exit(0);
                            }
                            break;
                        default:
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                            break;
                    }
                } else {
                    /*                      LA FRACCION ESTA PAGADA PERO NO ESTA AVANZADO  */
                    $EXISTE_AVANCE = $this->db->query(
                                    "SELECT COUNT(*) AS EXISTE " . "FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} "
                                    . "AND A.Departamento = 140 LIMIT 1")->result();

                    if (intval($EXISTE_AVANCE[0]->EXISTE) === 1 && $depto === 55 && $depto_actual === 5 && $frac === 300 || intval($EXISTE_AVANCE[0]->EXISTE) === 1 && $depto === 55 && $depto_actual === 5 && $frac === 299) {
                        $this->db->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('controles');
                        $this->db->set('stsavan', 55)->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('pedidox');

                        $this->db->set("status", 55)->set("fec55", Date('Y-m-d 00:00:00'))->where('fec55 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        if (intval($xXx['EMPLEADO']) === 903 || intval($xXx['EMPLEADO']) === 900 || intval($xXx['EMPLEADO']) === 901 || intval($xXx['EMPLEADO']) === 902) {
                            $FRACCION = 300;
                            $maquila_control = $this->db->query("SELECT P.Maquila FROM pedidox AS P WHERE P.Control ={$xXx['CONTROL']}")->result();
                            if (intval($maquila_control[0]->Maquila) === 98) {
                                $FRACCION = 299;
                            }
                            $this->onPagarFraccion($xXx, $FRACCION, 140, 'ENSUELADO');
                        }
                    }
                    $FRACCION = 300;
                    $maquila_control = $this->db->query("SELECT P.Maquila FROM pedidox AS P WHERE P.Control ={$xXx['CONTROL']}  AND P.stsavan = 5")->result();
                    if (intval($maquila_control[0]->Maquila) === 98) {
                        $FRACCION = 299;
                    }
                    $maquila_control_pla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $FRACCION)->get()->result();
                    if (intval($maquila_control[0]->EXISTE) === 0 && intval($maquila_control_pla[0]->EXISTE) === 0 && $depto === 55 && $depto_actual === 5) {
                        $this->db->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('controles');
                        $this->db->set('stsavan', 55)->set('EstatusProduccion', 'ENSUELADO')->set('DeptoProduccion', 140)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        $this->db->set("status", 55)->set("fec55", Date('Y-m-d 00:00:00'))->where('fec55 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        $this->onPagarFraccion($xXx, $FRACCION, 140, 'ENSUELADO');
                    }
                    exit(0);
                }
                exit(0);
            }

            if (in_array("{$xXx['EMPLEADO']}  ", $empleados_celulas) &&
                    $depto === 55 && $depto_actual === 5 && $frac === 300) {
                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control =  {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
                if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                    $this->onPagarFraccionSinAvance($xXx, $frac);
                }
                exit(0);
            }
            /* 6 ALMACEN - PESPUNTE Y STSAVAN 55 ENSUELADO */
            /* 55 ENSUELADO (FRACCIONES) */
            $fracciones_ensuelado = array(306, 396, 397);

            if ($depto === 6 && $depto_actual === 55 && in_array(intval($frac), $fracciones_ensuelado) ||
                    $depto === 6 && $depto_actual === 55 && in_array(intval($frac), $fracciones_ensuelado) && intval($xXx['EMPLEADO']) === 1003) {

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control =  {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
                switch (intval($frac)) {
                    case 396:
                    case 397:
                        /* PAGAR FRACCION */
                        $revisar_avance_ensuelado = $this->db->query("SELECT  COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control ={$xXx['CONTROL']} AND Departamento IN(130,150,160,180,210,230,240) ")->result();
                        if (intval($revisar_avance_ensuelado[0]->EXISTE) === 0) {
                            $this->onAvance($xXx['CONTROL'], 130, 'ALMACEN PESPUNTE', NULL);
                            $this->db->set('EstatusProduccion', 'ALMACEN PESPUNTE')->set('DeptoProduccion', 130)->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 6)->set('EstatusProduccion', 'ALMACEN PESPUNTE')->set('DeptoProduccion', 130)->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set("status", 6)->set("fec6", Date('Y-m-d 00:00:00'))->where('fec6 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        }
                        if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            /* revisar fracciones 100,102 y 300 */
                            $revisar_pago_pespunte = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.Control IN({$xXx['CONTROL']}) AND numfrac IN(100,102,300,96,113,299) ")->result();
                            if (intval($revisar_pago_pespunte[0]->EXISTE) === 0) {
                                exit(0);
                            }
                            $id = NULL;
                            $revisar_avance_existe_ensuelado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND Departamento IN(130,150,160,180,210,230,240) LIMIT 1")->result();
                            if (intval($revisar_avance_existe_ensuelado[0]->EXISTE) === 0) {
                                $id = $this->db->insert_id();
                            } else {
                                $dtm = $this->db->query("SELECT A.ID AS ID FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND Departamento = 130 LIMIT 1")->result();
                                $id = intval($dtm[0]->ID);
                            }
                            $CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$xXx['CONTROL']} LIMIT 1")->result();


                            $xfraccion = 397;
                            $maquila_control = $this->db->query("SELECT P.Maquila FROM pedidox AS P WHERE P.Control ={$xXx['CONTROL']}")->result();
                            if (intval($maquila_control[0]->Maquila) === 98) {
                                $xfraccion = 396;
                            }
                            $data = array(
                                "numeroempleado" => $xXx['EMPLEADO'],
                                "maquila" => intval($CONTROL[0]->MAQUILA),
                                "control" => $xXx['CONTROL'],
                                "estilo" => $xXx['ESTILO'],
                                "pares" => $xXx['PARES'],
                                "fecha" => Date('Y-m-d 00:00:00'),
                                "fecha_registro" => Date('d/m/Y h:i:s'),
                                "semana" => $xXx['SEMANA'],
                                "depto" => $xXx['DEPTOACTUAL'],
                                "anio" => Date('Y'));
                            $data["fraccion"] = $xfraccion;
                            $data["numfrac"] = $xfraccion;
                            $PRECIO_FRACCION_CONTROL_EXISTE_COSTO = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                            if (intval($PRECIO_FRACCION_CONTROL_EXISTE_COSTO[0]->EXISTE) >= 1) {
                                $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
                                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                                $data["preciofrac"] = $PXFC;
                                $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
                                $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                                $data["modulo"] = 'CA';
                                $this->db->insert('fracpagnomina', $data);
                                $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE PESPUNTE.  ", $this->session);
                            }
//                            $this->onPagarFraccionSinAvance($xXx, $frac);
                        }
                        break;
                    default:
                        /* NO TIENE ESTAS FRACCIONES PORQUE VA PEGADO */
                        /* NO TIENE FRACCION 397 */
                        $check_fraccion_ensuelado = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS FXE WHERE FXE.Estilo = '{$xXx['ESTILO']}' AND FXE.Fraccion IN(397,396)")->result();
                        /* NO TIENE FRACCION 401 */
                        $check_fraccion_tejido = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fraccionesxestilo AS FXE WHERE FXE.Estilo = '{$xXx['ESTILO']}' AND FXE.Fraccion IN(401,402) ")->result();
                        if (intval($check_fraccion_ensuelado[0]->EXISTE) === 0 && intval($check_fraccion_tejido[0]->EXISTE) === 0) {
                            $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('controles');
                            $this->db->set('stsavan', 8)->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('pedidox');
                            $this->db->set("status", 8)->set("fec8", Date('Y-m-d 00:00:00'))->where('fec8 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                            exit(0);
                        }
                        break;
                }
                exit(0);
            }

            /* AVANCE A ALMACEN DE TEJIDO , PAGA NOMINA DE TEJIDO */ 
            if ($depto === 8 && $depto_actual === 7 && in_array(intval($frac), $fracciones_tejido)) {

                $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
//                var_dump($check_fraccion);
//                exit(0);
                switch (intval($frac)) {
                    case 402:
                    case 401:
                        /* YA NO SE PAGA FRACCION PORQUE ESTE TIENE UN MODULO DEDICADO DONDE SE PAGA DIRECTO,SOLO MUEVE EL CONTROL A ALMACEN TEJIDO 
                         * VER AVANCE TEJIDO (vAvanceTejido, AvanceTejido) */
                        $check_almtejido = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A WHERE A.Control = {$xXx['CONTROL']} AND A.Departamento = 160")->result();
                        if (intval($check_almtejido[0]->EXISTE) >= 1) {
                            exit(0);
                        }
                        $this->onAvance($xXx['CONTROL'], 160, 'ALMACEN TEJIDO', NULL);
                        $this->db->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('controles');
                        $this->db->set('stsavan', 8)->set('EstatusProduccion', 'ALMACEN TEJIDO')->set('DeptoProduccion', 160)->where('Control', $xXx['CONTROL'])->update('pedidox');
                        $this->db->set("status", 8)->set("fec8", Date('Y-m-d 00:00:00'))->where('fec8 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                        $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN DE TEJIDO.  ", $this->session);
                        exit(0);
                        break;
                    default:
                        if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                            $this->onPagarFraccionSinAvance($xXx, $frac);
                        }
                        exit(0);
                        break;
                }
                exit(0);
            }

            /* 10 ADORNO */
            /* AVANCE A "ADORNO A" O "ADORNO B" (MUEVE EL AVANCE A ADORNO (NO PAGA ADORNO), PAGA NOMINA DE MONTADO) */
            if ($depto === 10 && $depto_actual === 9) {
                if ($frac === 88 && $depto_actual === 9 ||
                        $frac === 499 && $depto_actual === 9 ||
                        $frac === 500 && $depto_actual === 9 ||
                        $frac === 502 && $depto_actual === 9 ||
                        $frac === 503 && $depto_actual === 9) {
//88	MONTADO PROTOTIPO
//499	MONTADO MUESTRA
//500	MONTADO GENERAL "A" * (GENERA AVANCE) *
//503	MONTADO GENERAL "B"
                    $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
                    $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac} ")->result();
                    if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                        switch (intval($frac)) {
                            case 499:
                            case 500:
                                $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']}   A  - ADORNO A.  ", $this->session);
                                $this->onPagarFraccion($xXx, $frac, 210, 'ADORNO A');
                                $this->db->set('EstatusProduccion', 'ADORNO A')->set('DeptoProduccion', 210)->where('Control', $xXx['CONTROL'])->update('controles');
                                $this->db->set('stsavan', 10)->set('EstatusProduccion', 'ADORNO A')->set('DeptoProduccion', 210)->where('Control', $xXx['CONTROL'])->update('pedidox');
                                $this->db->set('fec10', Date('Y-m-d 00:00:00'))->where('fec10 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                                /* EN ONPAGARFRACCION YA REVISO EL AVANCE, PERO DE TODOS MODOS RECTIFICO QUE EXISTA */
                                $revisar_avance_adorno_a = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = '{$xXx['CONTROL']}' AND Departamento = 210 LIMIT 1")->result();
                                if (intval($revisar_avance_adorno_a[0]->EXISTE) === 0 && $frac === 499 || intval($revisar_avance_adorno_a[0]->EXISTE) === 0 && $frac === 500) {
                                    $this->onAvance($xXx['CONTROL'], 210, 'ADORNO A', $frac);
                                }
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
                        $frac === 601 && $depto_actual === 10 ||
                        $frac === 602 && $depto_actual === 10 ||
                        $frac === 606 && $depto_actual === 10 ||
                        $frac === 607 && $depto_actual === 10) {
//                    606	ARM.PLANTILLA ADORNO MUES
//                    87	ADORNO PROTOTIPO
//                    600	ADORNO GENERAL * (GENERA AVANCE) *
//                    602	PLANTILLA DE ADORNO
//                    607	ARMAR PLANTILLA DE ADORNO
                    $check_fraccion_plantilla = $this->db->select('COUNT(*) AS EXISTE', false)->from('controlpla AS C')->where('C.Control', $xXx['CONTROL'])->where('C.Fraccion', $frac)->get()->result();
                    $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx["CONTROL"]} AND F.numfrac ={$frac}")->result();
                    if (intval($check_fraccion[0]->EXISTE) === 0 && intval($check_fraccion_plantilla[0]->EXISTE) === 0) {
                        switch (intval($frac)) {
                            case 601:
                            case 600:
                                $l = new Logs("Captura de Avance de produccion", " HA AVANZADO EL CONTROL {$xXx['CONTROL']} A  - ALMACEN ADORNO.  ", $this->session);
                                $this->onPagarFraccion($xXx, $frac, 230, 'ALMACEN ADORNO');
                                $this->db->set('EstatusProduccion', 'ALMACEN ADORNO')->set('DeptoProduccion', 230)->where('Control', $xXx['CONTROL'])->update('controles');
                                $this->db->set('stsavan', 11)->set('EstatusProduccion', 'ALMACEN ADORNO')->set('DeptoProduccion', 230)->where('Control', $xXx['CONTROL'])->update('pedidox');
                                $this->db->set('fec11', Date('Y-m-d 00:00:00'))->where('fec11 IS NULL', null, false)->where('contped', $xXx['CONTROL'])->update('avaprd');
                                $revisar_avance_alm_adorno = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance WHERE Control = '{$xXx['CONTROL']}' AND Departamento = 230 LIMIT 1")->result();
                                if (intval($revisar_avance_alm_adorno[0]->EXISTE) === 0) {
                                    $this->onAvance($xXx['CONTROL'], 230, 'ALMACEN ADORNO', NULL);
                                }
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
            $check_avance = $this->db->select('COUNT(*) AS EXISTE', false)->from('avance AS A')->where('A.Control', $xXx['CONTROL'])->where('A.Departamento', $depto_avance)->get()->result();

            $id = 0;
            if (intval($check_avance[0]->EXISTE) === 0) {
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
                    'Fraccion' => $fraccion
                ));
                $id = $this->db->insert_id();
            }
            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)->from('fracpagnomina AS F')->where('F.control', $xXx['CONTROL'])->where('F.numfrac', $xfraccion)->get()->result();
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
                "fecha" => Date('Y-m-d 00:00:00'),
                "fecha_registro" => Date('d/m/Y h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPTOACTUAL'],
                "anio" => Date('Y'));
            $data["fraccion"] = $xfraccion;
            $data["numfrac"] = $xfraccion;
            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
            $data["preciofrac"] = $PXFC;
            $data["fecha_registro"] = Date('d/m/Y h:i:s');
            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
            $data["modulo"] = 'CA';
            $this->db->insert('fracpagnomina', $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagarFraccionSinAvance($xXx, $fraccion) {
        try {
            $xfraccion = $fraccion;
            $id = 0;
            $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)->from('fracpagnomina AS F')->where('F.control', $xXx['CONTROL'])->where('F.numfrac', $xfraccion)->get()->result();
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
                "fecha" => Date('Y-m-d 00:00:00'),
                "fecha_registro" => Date('d/m/Y h:i:s'),
                "semana" => $xXx['SEMANA'],
                "depto" => $xXx['DEPTOACTUAL'],
                "anio" => Date('Y'));
            $data["fraccion"] = $xfraccion;
            $data["numfrac"] = $xfraccion;
            $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$xfraccion}  AND P.Control = {$xXx['CONTROL']} LIMIT 1")->result();
            $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
            $data["preciofrac"] = $PXFC;
            $data["subtot"] = (floatval($xXx['PARES']) * floatval($PXFC));
            $data["avance_id"] = NULL;
            $data["modulo"] = 'CA';
            $this->db->insert('fracpagnomina', $data);
            $l = new Logs("Captura de Avance de produccion", "HA COBRADO O PAGADO LA FRACCION {$xfraccion} PARA EL CONTROL {$xXx['CONTROL']}.  ", $this->session);
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
            print json_encode($this->db->query("SELECT P.stsavan AS AVANCE_ACTUAL, (SELECT F.Descripcion FROM fracciones as F WHERE F.Clave = {$x['FRACCION']} LIMIT 1) AS FRACCION_DES FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControlPespunte() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.Pares AS PARES,P.Estilo AS ESTILO, (SELECT E.Foto FROM estilos AS E WHERE E.Clave = P.Estilo) AS FOTO FROM pedidox AS P WHERE P.Control =  {$x['CONTROL']} AND P.stsavan NOT IN(14) LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getManoDeObraXFraccionEstiloPespunte() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT FF.CostoMO AS MANO_DE_OBRA FROM fraccionesxestilo AS FF "
                                    . "WHERE FF.Estilo = '{$x['ESTILO']}' AND FF.Fraccion =  {$x['FRACCION']} LIMIT 1")->result());
//                    print $this->db->last_query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarFraccionPagada() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT COUNT(*) AS COBRADA FROM fracpagnomina AS FF "
                                    . "WHERE FF.Control = '{$x['CONTROL']}' AND FF.numfrac =  {$x['FRACCION']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onPagarFraccionNominaPespunte() {
        try {
            $x = $this->input->get();
            $revisa_fraccion = $this->db->query("SELECT COUNT(*) AS COBRADA FROM fracpagnomina AS FF "
                            . "WHERE FF.Control = '{$x['CONTROL']}' AND FF.numfrac = {$x['FRACCION']} LIMIT 1")->result();
            if (intval($revisa_fraccion[0]->COBRADA) === 0) {
                $PRECIO_FRACCION_CONTROL = $this->db->query("SELECT FXE.CostoMO, FXE.CostoMO AS TOTAL FROM fraccionesxestilo as FXE INNER JOIN pedidox AS P ON FXE.Estilo = P.Estilo WHERE FXE.Fraccion = {$x['FRACCION']}  AND P.Control = {$x['CONTROL']} AND P.stsavan NOT IN(14)  LIMIT 1")->result();
                $_CONTROL_ = $this->db->query("SELECT P.Semana AS SEMANA,P.Maquila AS MAQUILA, P.Pares AS PARES, P.Estilo AS ESTILO FROM pedidox AS P WHERE P.Control =  {$x['CONTROL']} AND P.stsavan NOT IN(14) LIMIT 1")->result();
                $fechin = Date('d/m/Y');
                $_SEMANA_ = $this->db->select("S.Sem AS SEMANA", false)->from('semanasnomina AS S')->where("STR_TO_DATE(\"{$fechin}  \", \"%d/%m/%Y\") BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\")  ", null, false)->get()->result();
                $EMPLEADO = $x['CELULA'];
                $data = array(
                    "numeroempleado" => $EMPLEADO,
                    "maquila" => intval($_CONTROL_[0]->MAQUILA),
                    "control" => $x['CONTROL'],
                    "estilo" => $_CONTROL_[0]->ESTILO,
                    "pares" => $_CONTROL_[0]->PARES,
                    "fecha" => Date('Y-m-d 00:00:00'),
                    "fecha_registro" => Date('d/m/Y h:i:s'),
                    "semana" => $_SEMANA_[0]->SEMANA,
                    "depto" => 110,
                    "anio" => Date('Y'));
                $data["fraccion"] = $x['FRACCION'];
                $data["numfrac"] = $x['FRACCION'];
                $PXFC = $PRECIO_FRACCION_CONTROL[0]->CostoMO;
                $data["preciofrac"] = $PXFC;
                $data["subtot"] = (floatval($_CONTROL_[0]->PARES) * floatval($PXFC));
                $data["avance_id"] = NULL;
                $data["modulo"] = 'CAPES';
                $this->db->insert('fracpagnomina', $data);
                $l = new Logs("Captura de Avance Nomina pespunte", "HA PAGADO LA FRACCION {$x['FRACCION']} PARA EL CONTROL {$x['CONTROL']}.  ", $this->session);
                print json_encode(array("PAGADA" => 1));
            } else {
                print json_encode(array("PAGADA" => 0));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzarXControl($CONTROL, $ESTATUS_PRODUCCION, $DEPTO_PRODUCCION, $STSAVAN) {
        try {
            $this->db->trans_begin();
            $this->db->set('EstatusProduccion', $ESTATUS_PRODUCCION)->set('DeptoProduccion', $DEPTO_PRODUCCION)->where('Control', $CONTROL)->update('controles');
            $this->db->set('stsavan', $STSAVAN)->set('EstatusProduccion', $ESTATUS_PRODUCCION)->set('DeptoProduccion', $DEPTO_PRODUCCION)->where('Control', $CONTROL)->update('pedidox');
            $this->db->set("fec{$STSAVAN}  ", Date('Y-m-d 00:00:00'))->where("fec{$STSAVAN} IS NULL  ", null, false)->where('contped', $CONTROL)->update('avaprd');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvance($CONTROL, $DEPARTAMENTO, $DEPARTAMENTOT, $FRACCION) {
        try {
            $this->db->insert('avance', array(
                'Control' => $CONTROL,
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => $DEPARTAMENTO,
                'DepartamentoT' => $DEPARTAMENTOT,
                'FechaAvance' => Date('d/m/Y'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => $FRACCION,
                'modulo' => 'CA'
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
