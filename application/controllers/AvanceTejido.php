<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AvanceTejido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->model('AvanceTejido_model', 'avtm');
    }

    public function index() {
        try {
            $is_valid = false;
            if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
                $this->load->view('vEncabezado');
                switch ($this->session->userdata["TipoAcceso"]) {
                    case 'SUPER ADMINISTRADOR':
                        $this->load->view('vNavGeneral')->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                    case 'ADMINISTRACION':
                        $this->load->view('vNavGeneral');
                        $this->load->view('vMenuAdministracion');
                        $is_valid = true;
                        break;
                    case 'PRODUCCION':
                        $this->load->view('vNavGeneral');
                        $this->load->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                }
                $dt["TYPE"] = 2;
                $this->load->view('vFondo')->view('vAvanceTejido')->view('vWatermark', $dt)->view('vFooter');
            }
            if (!$is_valid) {
                $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getChoferes() {
        try {
//            print json_encode($this->avtm->getChoferes());
            print json_encode($this->db->select("E.Numero AS ID, CONCAT(E.Numero,' ', E.PrimerNombre,' ', E.SegundoNombre,' ', E.Paterno,' ', E.Materno) AS Empleado", false)
                                    ->from('empleados AS E')
                                    ->where('E.AltaBaja', 1)->where('E.DepartamentoFisico', 170)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
//            print json_encode($this->apm->getColoresXEstilo($this->input->get('ESTILO')));
            $x = $this->input->get();
            $this->db->select("CAST(C.Clave AS SIGNED ) AS CLAVE, CONCAT(C.Clave,'-', C.Descripcion) AS COLOR ", false)
                    ->from('colores AS C');
            if ($x['ESTILO'] !== '') {
                $this->db->where('C.Estilo', $x['ESTILO']);
            }
            $this->db->where('C.Estatus', 'ACTIVO')
                    ->order_by('ID', 'ASC');
            if ($x['ESTILO'] === '') {
                $this->db->limit(10);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->avtm->getSemanaNomina($this->input->get('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVale() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["DOCUMENTO"] = $this->input->post('DOCUMENTO');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\tejido\AvanceTejidox.jasper');
        $jc->setFilename('CONTROLES_ENTREGADOS_A_TEJIDA' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento(Date('Y'), Date('m'), Date('d')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarNumeroDeDocumento() {
        try {
            print json_encode($this->avtm->getUltimoDocumento($this->input->post('DOCUMENTO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
//            print json_encode($this->avtm->getUltimoAvanceXControl($this->input->get('CONTROL')));
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT P.stsavan AS AVANCE FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaTejido() {
        try {
//            print json_encode($this->avtm->getControlesParaTejido());
            $this->db->select("C.ID, C.Control AS CONTROL, "
                            . "C.Estilo AS ESTILO, C.Color AS COLOR, C.Pares AS PARES, "
                            . "P.FechaEntrega AS ENTREGA, C.Maquila AS MAQUILA", false)
                    ->from('controles AS C')
                    ->join('pedidox AS P', 'C.Control = P.Control')
                    ->join('controltej AS CT', 'CT.Control = C.Control', 'left')
                    ->where('CT.ID IS NULL', null, false)
                    ->where('C.DeptoProduccion', 130);
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnTejido() {
        try {
//            print json_encode($this->avtm->getControlesEnTejido());
            $x = $this->input->get();

            $this->db->select("C.ID, C.numcho AS CHOFER, "
                            . "C.numtej AS TEJEDORA, DATE_FORMAT(C.fechapre,\"%d/%m/%Y\") AS FECHA, "
                            . "C.control AS CONTROL, C.estilo AS ESTILO, "
                            . "C.color AS COLOR, C.nomcolo AS COLORT, "
                            . "C.docto AS DOCTO, C.pares AS PARES", false)
                    ->from('controltej AS C');
            if ($x['CHOFER'] !== '') {
                $this->db->where('C.numcho', $x['CHOFER']);
            }
            if ($x['TEJEDORA'] !== '') {
                $this->db->where('C.numtej', $x['TEJEDORA']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('C.control', $x['CONTROL']);
            }
            $this->db->order_by('C.fechapre', 'DESC');
            if ($x['CHOFER'] === '') {
                $this->db->limit(10);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarFraccionXEstilo() {
        try {
            $estilo = $this->input->get('Estilo');
            $frac = $this->input->get('Fraccion');
            print json_encode($this->db->query("select * from fraccionesxestilo where Estilo = '$estilo' and Fraccion = $frac ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance() {
        try {
            $x = $this->input->get();
            $check_maquila = $this->db->query("SELECT P.Maquila, P.stsavan FROM pedidox AS P WHERE P.Control = {$x['CONTROL']}")->result();
            switch (intval($check_maquila[0]->Maquila)) {
                case 98:
                case 1:
                    print json_encode($this->db->select("COUNT(A.ID) AS EXISTE, 1 AS MAQUILA", false)
                                            ->from('avance AS A')
                                            ->where_in('A.Departamento', array(150, 160))
                                            ->like('A.Control', $x['CONTROL'])
                                            ->get()->result());
                    break;
                case 2:
                    $check_docto_existe = $this->db->query("SELECT COUNT(*) AS EXISTE "
                                    . "FROM avaprd AS A "
                                    . "WHERE A.contped = {$x['CONTROL']}")->result();
                    if (intval($check_docto_existe[0]->EXISTE) > 0) {
                        $check_docto = $this->db->query("SELECT A.almpesp AS DOCUMENTO  "
                                        . "FROM avaprd AS A "
                                        . "WHERE A.contped = {$x['CONTROL']}")->result();

                        $check_avanceproduccionmaq = $this->db->query("SELECT COUNT(*) AS EXISTE "
                                        . "FROM avanceproduccionmaq AS A "
                                        . "WHERE A.Documento = {$check_docto[0]->DOCUMENTO}")->result();
                        if (intval($check_avanceproduccionmaq[0]->EXISTE) > 0) {
                            print json_encode($this->db->select("COUNT(A.ID) AS EXISTE, 1 AS MAQUILA", false)
                                                    ->from('avance AS A')
                                                    ->where_in('A.Departamento', array(150, 160))
                                                    ->like('A.Control', $x['CONTROL'])
                                                    ->get()->result());
                        } else {
                            print json_encode($this->db->select("0 AS EXISTE", false)
                                                    ->from('avance AS A')
                                                    ->where_in('A.Departamento', array(150, 160))
                                                    ->like('A.Control', 99999999999999999999)
                                                    ->get()->result());
                        }
                    } else {
                        print json_encode($this->db->select("0 AS EXISTE", false)
                                                ->from('avance AS A')
                                                ->where_in('A.Departamento', array(150, 160))
                                                ->like('A.Control', 99999999999999999999)
                                                ->get()->result());
                    }
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getxSemanaNomina() {
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

    public function onAvanzar() {
        try {
            $x = $this->input;
            $xXx = $this->input->post();
            $check_fraccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx['CONTROL']} AND F.numfrac = {$xXx['FRACCION']} LIMIT 1")->result();
            $existe = count($check_fraccion[0]->EXISTE) > 0 ? intval($check_fraccion[0]->EXISTE) : 0;

            if ($existe === 0) {
                $fecha = $x->post('FECHA');
                $dia = substr($fecha, 0, 2);
                $mes = substr($fecha, 3, 2);
                $anio = substr($fecha, 6, 4);
                $nueva_fecha = new DateTime();
                $nueva_fecha->setDate($anio, $mes, $dia);
                /* avance, avaprd */
                $this->db->insert('controltej', array(
                    'numcho' => $xXx['NUM_CHOFER'],
                    'nomcho' => str_replace("0", "", $xXx['CHOFER']),
                    'numtej' => $xXx['NUM_TEJEDORA'],
                    'nomtej' => str_replace("0", "", $xXx['TEJEDORA']),
                    'fechapre' => $nueva_fecha->format('Y-m-d 00:00:00'),
                    'control' => $xXx['CONTROL'],
                    'estilo' => $xXx['ESTILO'],
                    'color' => $xXx['COLOR'],
                    'nomcolo' => $xXx['COLORT'],
                    'docto' => $xXx['DOCUMENTO'],
                    'pares' => $xXx['PARES'],
                    'fechalle' => NULL,
                    'tipo' => 0,
                    'fraccion' => $xXx['FRACCION'],
                    'registro' => Date('Y-m-d h:i:s a')
                ));

                /* fracpagnomina */
                $FXE = $this->db->select('FXE.CostoMO AS PRECIO', false)->from('fraccionesxestilo AS FXE')
                                ->where('FXE.Estilo', $xXx['ESTILO'])
                                ->where('FXE.Fraccion', $xXx['FRACCION'])
                                ->get()->result();

                $MAQUILA_X_CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x->post('CONTROL')} limit 1")->result();

                $TOTAL = (intval($x->post('PARES')) * floatval($FXE[0]->PRECIO));
                $l = new Logs("AVANCE TEJIDO(VALE)", "VALE PARA LA TEJEDORA {$xXx['NUM_TEJEDORA']} DE $ {$TOTAL} "
                        . "DEL CONTROL {$xXx['CONTROL']} CON {$xXx['PARES']} PARES, LA FRACCION {$xXx['FRACCION']} CON UN PRECIO DE {$FXE[0]->PRECIO} MAQUILA {$MAQUILA_X_CONTROL[0]->MAQUILA}.", $this->session);

                $ID = $this->db->insert('avance', array(
                    'Control' => $xXx['CONTROL'],
                    'FechaAProduccion' => Date('d/m/Y'),
                    'Departamento' => 150,
                    'DepartamentoT' => 'TEJIDO',
                    'FechaAvance' => $xXx['FECHA']/* FECHA AVANCE */,
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => $xXx['FRACCION']
                ));
                $ID = $this->db->insert_id();
                $this->db->insert('fracpagnomina', array(
                    'numeroempleado' => $x->post('NUM_TEJEDORA'),
                    'maquila' => intval($MAQUILA_X_CONTROL[0]->MAQUILA),
                    'control' => $x->post('CONTROL'),
                    'estilo' => $x->post('ESTILO'),
                    'numfrac' => $x->post('FRACCION'),
                    'preciofrac' => $FXE[0]->PRECIO,
                    'pares' => $x->post('PARES'),
                    'subtot' => (intval($x->post('PARES')) * floatval($FXE[0]->PRECIO)),
                    'status' => 0,
                    'fecha' => $nueva_fecha->format('Y-m-d 00:00:00'),
                    'semana' => $x->post('SEMANA'),
                    'depto' => 150,
                    'registro' => 0,
                    'anio' => Date('Y'),
                    'avance_id' => $ID,
                    'fraccion' => $xXx['FRACCION'],
                    'fecha_registro' => Date('d/m/Y h:i:s'),
                    'modulo' => 'TJ'
                ));
                $TOTAL = (intval($x->post('PARES')) * floatval($FXE[0]->PRECIO));
                $l = new Logs("AVANCE TEJIDO(NOMINA)", "PAGO A LA TEJEDORA {$x->post('NUM_TEJEDORA')} $ {$TOTAL} "
                        . "DEL CONTROL {$xXx['CONTROL']} CON {$x->post('PARES')} PARES, LA FRACCION {$xXx['FRACCION']} CON UN PRECIO DE {$FXE[0]->PRECIO} MAQUILA {$MAQUILA_X_CONTROL[0]->MAQUILA}.", $this->session);

                /* ACTUALIZAR  ESTATUS DE PRODUCCION  EN CONTROLES */
                $this->db->set('EstatusProduccion', 'TEJIDO')->set('DeptoProduccion', 150)
                        ->where('Control', $xXx['CONTROL'])->update('controles');
                /* ACTUALIZAR ESTATUS DE PRODUCCION EN PEDIDOS */
                $this->db->set('stsavan', 7)->set('EstatusProduccion', 'TEJIDO')
                        ->set('DeptoProduccion', 150)->where('Control', $xXx['CONTROL'])
                        ->update('pedidox');
                /* ACTUALIZAR FECHA 7 (TEJIDO) EN AVAPRD (SE HACE PARA FACILITAR LOS REPORTES) */
                $this->db->set('fec7', Date('Y-m-d 00:00:00'))->where('contped', $xXx['CONTROL'])->update('avaprd');
                $l = new Logs("Avance tejido", "HA AVANZO EL CONTROL {$xXx['CONTROL']} A TEJIDO CON LA FRACCION {$xXx['FRACCION']}.", $this->session);

                /* REVISA EL PAGO */
                $check_revision = $this->db->query("SELECT COUNT(*) AS EXISTE FROM fracpagnomina AS F WHERE F.control = {$xXx['CONTROL']} AND F.numfrac = {$xXx['FRACCION']}")->result();
                if (intval($check_revision[0]->EXISTE) === 0) {
                    $nueva_fecha = new DateTime();
                    $nueva_fecha->setDate($anio, $mes, $dia);
                    $FXE = $this->db->select('FXE.CostoMO AS PRECIO', false)->from('fraccionesxestilo AS FXE')
                                    ->where('FXE.Estilo', $xXx['ESTILO'])
                                    ->where('FXE.Fraccion', 401)
                                    ->get()->result();
                    $MAQUILA_X_CONTROL = $this->db->query("SELECT P.Maquila AS MAQUILA FROM pedidox AS P WHERE P.Control = {$x->post('CONTROL')} limit 1")->result();
                    $this->db->insert('fracpagnomina', array(
                        'numeroempleado' => $x->post('NUM_TEJEDORA'),
                        'maquila' => intval($MAQUILA_X_CONTROL[0]->MAQUILA),
                        'control' => $x->post('CONTROL'),
                        'estilo' => $x->post('ESTILO'),
                        'numfrac' => $x->post('FRACCION'),
                        'preciofrac' => $FXE[0]->PRECIO,
                        'pares' => $x->post('PARES'),
                        'subtot' => (intval($x->post('PARES')) * floatval($FXE[0]->PRECIO)),
                        'status' => 0,
                        'fecha' => $nueva_fecha->format('Y-m-d 00:00:00'),
                        'semana' => $x->post('SEMANA'),
                        'depto' => 150,
                        'registro' => 0,
                        'anio' => Date('Y'),
                        'avance_id' => $ID,
                        'fraccion' => $xXx['FRACCION'],
                        'fecha_registro' => Date('d/m/Y h:i:s'),
                        'modulo' => 'TJ'
                    ));
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoControl() {
        try {
            print json_encode($this->db->select("C.ID, C.Control, C.FechaProgramacion, C.Estilo, "
                                            . "C.Color, C.Serie, C.Cliente, C.Pares, C.Pedido, "
                                            . "C.PedidoDetalle, C.Estatus, C.Departamento, C.Ano, "
                                            . "C.Maquila, C.Semana, C.Consecutivo, C.Motivo, (SELECT P.EstatusProduccion FROM pedidox AS P WHERE P.Control = C.Control LIMIT 1) AS AVANCE_ACTUAL", false)
                                    ->from('controles AS C')
                                    ->where('C.Control', $this->input->get('CONTROL'))
                                    ->where('C.DeptoProduccion', 130)
                                    ->where('C.EstatusProduccion', 'ALMACEN PESPUNTE')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoControlFueraDeAvance() {
        try {
            print json_encode($this->db->select("C.ID, C.Control, C.FechaProgramacion, C.Estilo, "
                                            . "C.Color, C.Serie, C.Cliente, C.Pares, C.Pedido, "
                                            . "C.PedidoDetalle, C.Estatus, C.Departamento, C.Ano, "
                                            . "C.Maquila, C.Semana, C.Consecutivo, C.Motivo, (SELECT P.EstatusProduccion FROM pedidox AS P WHERE P.Control = C.Control LIMIT 1) AS AVANCE_ACTUAL", false)
                                    ->from('controles AS C')
                                    ->where('C.Control', $this->input->get('CONTROL'))
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAvance() {
        try {
            $x = $this->input->post();
            $check_avance = $this->db->query("SELECT count(*) AS EXISTE FROM pedidox AS P WHERE P.stsavan IN(9,10,11,12,13,14) AND P.Control = {$this->input->post("CONTROL")}")->result();
            $check_stsavan = $this->db->query("SELECT P.stsavan AS AVANCE_ACTUAL FROM pedidox AS P WHERE  P.Control = {$this->input->post("CONTROL")}")->result();
            $SEMANA_COBRO_FRACCION = $this->db->query("SELECT semana AS SEMANA FROM fracpagnomina WHERE Control = {$x['CONTROL']} AND numfrac = 401")->result();

            $SEMANA_NOMINA = $this->db->query("SELECT COUNT(*) AS EXISTE FROM prenomina WHERE status = 2 AND numsem = {$SEMANA_COBRO_FRACCION[0]->SEMANA}")->result();

            if (intval($check_avance[0]->EXISTE) === 0 || intval($SEMANA_NOMINA[0]->EXISTE) === 0) {
                $eliminable = array("ELIMINABLE" => 1, "AVANCE_ACTUAL" => $check_stsavan[0]->AVANCE_ACTUAL);
                print json_encode($eliminable);
            } else {
                $eliminable = array("ELIMINABLE" => 0, "AVANCE_ACTUAL" => $check_stsavan[0]->AVANCE_ACTUAL);
                $l = new Logs("AVANCE TEJIDO ELIMINA", "INTENTO ELIMINAR EL AVANCE DE TEJIDO DEL CONTROL {$this->input->post("CONTROL")} .", $this->session);

                print json_encode($eliminable);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminaAvanceXControl() {
        try {
            $x = $this->input->post();
            $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P WHERE P.stsavan = 7 AND P.Control = {$x['CONTROL']}")->result();
            if (intval($check_avance[0]->EXISTE) === 0) {
                exit(0);
            }
            if (intval($check_avance[0]->EXISTE) > 0) {
                $SEMANA_COBRO_FRACCION = $this->db->query("SELECT semana AS SEMANA FROM fracpagnomina WHERE Control = {$x['CONTROL']} AND numfrac = 401")->result();
                $AÑO = Date('Y');
                $SEMANA_NOMINA = $this->db->query("SELECT COUNT(*) AS EXISTE FROM prenomina WHERE status = 2 AND numsem = {$SEMANA_COBRO_FRACCION[0]->SEMANA} AND año = $AÑO")->result();
                if (intval($SEMANA_NOMINA[0]->EXISTE) >= 1) {
                    print "\n NO SE PUEDE ELIMINAR EL AVANCE NI LA NOMINA QUE YA FUE PAGADA {$AÑO} {$SEMANA_COBRO_FRACCION[0]->SEMANA} \n";
                    $l = new Logs("AVANCE TEJIDO ELIMINA", "INTENTO ELIMINAR EL AVANCE DE TEJIDO(401) DEL CONTROL {$x['CONTROL']} .", $this->session);
                    EXIT(0);
                } else {
                    print "ELIMINANDO FRACCION 401 DEL CONTROL";
                }
                $this->db->query("DELETE FROM avance WHERE Control = {$x['CONTROL']} AND Departamento = 150 AND DepartamentoT = 'TEJIDO'");
                $this->db->query("DELETE FROM controltej WHERE control = {$x['CONTROL']} AND fraccion = 401");
                $this->db->query("DELETE FROM fracpagnomina   where Control = {$x['CONTROL']} AND numfrac = 401");
                $this->db->set("EstatusProduccion", 'ALMACEN PESPUNTE')->set("DeptoProduccion", 130)
                        ->set("stsavan", 6)->where("Control", $x['CONTROL'])->update("pedidox");
                $this->db->set("EstatusProduccion", 'ALMACEN PESPUNTE')->set("DeptoProduccion", 130)
                        ->where("Control", $x['CONTROL'])->update("controles");
                $l = new Logs("AVANCE TEJIDO ELIMINA", "ELIMINO EL AVANCE DE TEJIDO DEL CONTROL {$x['CONTROL']} .", $this->session);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
