<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ControlPlantilla extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('ControlPlantilla_model', 'cpm')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion')->view('vControlPlantilla')->view('vFooter');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion')->view('vControlPlantilla')->view('vFooter');
                    break;
                default :
                    $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    /* Captura Porcentajes */

    public function onGuardarPorcentaje() {
        try {
            $x = $this->input;

            $Existe = $this->db->query("select * from porcentajesmaquilaplantilla where fraccion = '{$x->post('Fraccion')}' ")->result();

            if (!empty($Existe)) {
                $this->db->query("update porcentajesmaquilaplantilla set porcentaje = {$x->post('Porcentaje')} where fraccion = '{$x->post('Fraccion')}' ");
            } else {
                $this->db->insert('porcentajesmaquilaplantilla', array(
                    'fraccion' => $x->post('Fraccion'),
                    'porcentaje' => $x->post('Porcentaje')
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPorcentajes() {
        try {
            print json_encode($this->db->query('SELECT CP.`ID`,
                                        CP.`fraccion` AS FRACCION,
                                        CP.porcentaje AS PORCENTAJE,
                                        CONCAT(\'<span class="fa fa-trash fa-lg text-danger" onclick="onEliminarPorcentajeByID(\',CP.ID,\')">\',\'</span>\') AS BTN
                                        from porcentajesmaquilaplantilla AS CP ')->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarFraccionExiste() {
        try {
            $Fraccion = $this->input->get('Fraccion');
            print json_encode($this->db->query("select * from fracciones where Clave = '$Fraccion' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarPorcentajeByID() {
        try {
            $ID = $this->input->post('ID');
            $this->db->query("delete from porcentajesmaquilaplantilla where ID = {$ID} ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarPlantilla() {
        try {
            $Maquila = $this->input->get('Maquila');
            print json_encode($this->db->query("select Clave from maquilasplantillas where Clave = '$Maquila' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarProveedor() {
        try {
            $Proveedor = $this->input->get('Proveedor');
            print json_encode($this->db->query("select numprv from provmaqui where numprv = '$Proveedor' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
//            print json_encode($this->cpm->getRecords());
            $this->db->select('CP.`ID`,
                                        CP.`Proveedor` AS PROVEEDOR,
                                        CP.`Tipo` AS ESTATUS,
                                        CP.`Documento` AS DOCUMENTO,
                                        CP.`Control` AS CONTROL,
                                        CP.`Estilo` AS ESTILO,
                                        CP.`Color` AS COLOR,
                                        CP.`Pares` AS PARES,
                                        CP.`Fraccion` AS FRACCION,
                                        CP.`FraccionT` AS FRACCIONT,
                                        CP.`Precio` AS PRECIO,
                                        CP.`Fecha` AS FECHA,
                                        CP.`Registro`,
                                        CP.`Estatus` AS ESTATUS,
                                        CONCAT("<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminarControlPlantilla(",CP.ID,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN', false)
                    ->from('controlpla AS CP')->where_in('CP.Estatus', array(1, 2));

            $x = $this->input->get();
            if ($x['DOCUMENTO'] !== '') {
                $this->db->where('CP.Documento', $x['DOCUMENTO']);
            }
            if ($x['DOCUMENTO'] === '') {
                $this->db->where('CP.Documento', 0);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEntregados() {
        try {
//            print json_encode($this->cpm->getEntregados());
            $this->db->select('CP.`ID`,
                                        CP.`Tipo` AS ESTATUS,
                                        CP.Documento AS DOCUMENTO,
                                        CP.`Proveedor` AS PROVEEDOR,
                                        CP.`Fecha` AS FECHA,
                                        CP.FechaRetorna AS FECHA_RETORNA,
                                        CP.`Control` AS CONTROL,
                                        CP.`Estilo` AS ESTILO,
                                        CP.`Color` AS COLOR,
                                        CP.`Pares` AS PARES,
                                        CP.`Fraccion` AS FRACCION,
                                        CP.`FraccionT` AS FRACCIONT,
                                        CP.`Precio` AS PRECIO,
                                        CP.`Registro`,
                                        CP.`Estatus` AS ESTATUS,
                                        CONCAT("<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"onEliminarRetornoControlPlantilla(",CP.ID,")\"><span class=\"fa fa-trash\"></span></button>") AS BTN', false)
                    ->from('controlpla AS CP')->where('CP.Estatus', 1);
            $x = $this->input->get();
            $this->db->where('CP.Documento', $x['DOCUMENTO']);
//            if ($x['DOCUMENTO'] !== '') {
//                $this->db->where('CP.Documento', $x['DOCUMENTO']);
//            }
//            if ($x['DOCUMENTO'] === '') {
//                $this->db->limit(25);
//            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            print json_encode($this->cpm->getMaquilasPlantillas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresMaquilas() {
        try {
            print json_encode($this->cpm->getProveedoresMaquilas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoDocumento() {
        try {
            print json_encode($this->db->query("SELECT max(ifnull(Documento,0))+1 as docto FROM controlpla  WHERE Documento <> 0; ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->cpm->getInfoXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->cpm->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesXEstilo() {
        try {
            print json_encode($this->cpm->getFraccionesXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificaFraccionControlFraccionCobrada() {
        try {
            $est = $this->input->get('ESTILO');
            $control = $this->input->get('CONTROL');
            $fracc = $this->input->get('FRACCION');


            //Verifica existe fracción en catalogo de fracciones

            $Existe = $this->db->query("select * from fraccionesxestilo where estilo = '$est' and fraccion = $fracc ")->result();
            if (!empty($Existe)) {
                //Verifica que no hayan enviado el control a maquilar con anterioridad
                $ExisteControlPla = $this->db->query("SELECT * from controlpla where control = {$control} and fraccion = {$fracc} ")->result();
                if (empty($ExisteControlPla)) {
                    //Verifica que no hayan cobrado el control con anterioridad en otros módulos
                    $ExisteFracPagNom = $this->db->query("SELECT * from fracpagnomina where control = {$control} and numfrac = {$fracc} ")->result();
                    if (empty($ExisteFracPagNom)) {
                        print ($Existe[0]->CostoMO);
                    } else {
                        print (99);
                    }
                } else {
                    print (88);
                }
            } else {
                print (0);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarEstatusDocumento() {
        try {
            print json_encode($this->cpm->onComprobarEstatusDocumento($this->input->get('DOCTO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            /*
             *  ESTATUS
             *  1 = ENTREGADO A MAQUILA / EN PROCESO / EN TRANSITO
             *  2 = ENTREGADO/RECIBIDO/RETORNADO
             *  3 = PROCESADO COMO PLANTILLA
             */
            $x = $this->input;
            $this->db->insert('controlpla', array(
                'Proveedor' => $x->post('PROVEEDOR'),
                'ProveedorT' => str_replace("{$x->post('PROVEEDOR')} ", "", $x->post('PROVEEDORT')),
                'Tipo' => $x->post('TIPO'),
                'Documento' => $x->post('DOCUMENTO'),
                'Control' => $x->post('CONTROL'),
                'Estilo' => $x->post('ESTILO'),
                'Color' => $x->post('COLOR'),
                'ColorT' => str_replace("{$x->post('COLOR')}-", "", $x->post('COLORT')),
                'Pares' => $x->post('PARES'),
                'Fraccion' => $x->post('FRACCION'),
                'FraccionT' => str_replace("{$x->post('FRACCION')} ", "", $x->post('FRACCIONT')),
                'Precio' => $x->post('PRECIO'),
                'Fecha' => $x->post('FECHA'),
                'Registro' => Date('d/m/Y h:i:s a'),
                'Estatus' => 1));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->set('Estatus', 3)->where('ID', $this->input->post('ID'))->update('controlpla');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRetornaDocumento() {
        try {
            $docto = $this->input->post('Docto');
            $fecdoc = $this->input->post('FECHA');
            $this->db->set('Estatus', 2)->set('FechaRetorna', $fecdoc)->where('Documento', $docto)->update('controlpla');
            //Hacemos el movimiento de NÓMINA
            $Doc = $this->db->query("select * from controlpla where Documento = {$docto} ")->result();
            if (!empty($Doc)) {
                $numemp = $Doc[0]->Proveedor;
                //$fecdoc = $Doc[0]->Fecha; //se usaba cuando capturaban anteriores, pero ahora debe ser al momento de entrega de retorno
                if (intval($numemp) > 99) {//Si el campo proveedor es mayor a 99 lo capturamos en nomina con concepto 15
                    $total = 0;
                    foreach ($Doc as $key => $v) {//Sacamos el total
                        $subtotal = floatval($v->Pares) * floatval($v->Precio);
                        $total += $subtotal;
                    }
                    //Ahora sacamos la semana y año actual de nomina en base a la fecha del documento
                    //Se saca con la fecha actual para que no se pague en nominas con fechas anteriores o cerradas
                    $NomActu = $this->db->query("select Sem, Ano from semanasnomina AS U "
                                    . " where str_to_date('$fecdoc','%d/%m/%Y') BETWEEN str_to_date(FechaIni,'%d/%m/%Y') AND str_to_date(FechaFin,'%d/%m/%Y') ")->result();
                    $Sem = $NomActu[0]->Sem;
                    $Ano = $NomActu[0]->Ano;

                    //Verificamos si el registro ya existe en prenomina por año- sem - empleado y vemos si inserta o modifica
                    $PN = $this->db->query("select * from prenomina where año = {$Ano} and numsem = {$Sem} and numemp = {$numemp} and numcon = 15 and status = 1 ")->result();
                    $PNL = $this->db->query("select * from prenominal where año = {$Ano} and numsem = {$Sem} and numemp = {$numemp} and status = 1  ")->result();
                    //Tenemos que sacar información del empleado para traer depto y la asistencia en tabla de asistencias
                    $Empleado = $this->db->query("select e.DepartamentoFisico as depto, ifnull(a.numasistencias, 0) as asis
                            from empleados e
                            left join asistencia a on e.numero = a.numemp and a.año = {$Ano}  and a.numsem = {$Sem}
                            where e.numero = {$numemp}  ")->result();
                    /* PRENOMINA */
                    if (!empty($PN)) {
                        $this->db->where('numemp', $numemp)->where('numsem', $Sem)->where('año', $Ano)->where('numcon', 15);
                        $this->db->update("prenomina", array(
                            'registro' => 999,
                            'tpcon' => 1,
                            'tpcond' => 0,
                            'importe' => ($total + $PN[0]->importe),
                            'imported' => 0
                        ));
                    } else {
                        $data = array(
                            'numsem' => $Sem,
                            'numemp' => $numemp,
                            'numcon' => 15,
                            'año' => $Ano,
                            'tpcon' => 1,
                            'tpcond' => 0,
                            'importe' => $total,
                            'imported' => 0,
                            'diasemp' => $Empleado[0]->asis,
                            'fecha' => Date('Y-m-d'),
                            'tpomov' => 1,
                            'status' => 1,
                            'registro' => 999,
                            'depto' => $Empleado[0]->depto
                        );
                        $this->db->insert("prenomina", $data);
                    }
                    /* PRENOMINA L */
                    if (!empty($PNL)) {

                        $this->db->where('numemp', $numemp)->where('numsem', $Sem)->where('año', $Ano);
                        $this->db->set('diasemp', $Empleado[0]->asis);
                        $this->db->set('tpomov', 1);
                        $this->db->set('status', 1);
                        $this->db->set('registro', 999);
                        $this->db->set('depto', $Empleado[0]->depto);
                        $this->db->set('año', $Ano);
                        $this->db->set('otrper', ($total + $PNL[0]->otrper))->update("prenominal");
                    } else {
                        $this->db->insert("prenominal", array(
                            'numsem' => $Sem,
                            'numemp' => $numemp,
                            'diasemp' => $Empleado[0]->asis,
                            'tpomov' => 1,
                            'status' => 1,
                            'año' => $Ano,
                            'registro' => 999,
                            'depto' => $Empleado[0]->depto,
                            'salario' => 0,
                            'salariod' => 0,
                            'horext' => 0,
                            'otrper' => $total,
                            'otrper1' => 0,
                            'infon' => 0,
                            'impu' => 0,
                            'imss' => 0,
                            'impu' => 0,
                            'precaha' => 0,
                            'cajhao' => 0,
                            'vtazap' => 0,
                            'zapper' => 0,
                            'fune' => 0,
                            'cargo' => 0,
                            'fonac' => 0,
                            'otrde' => 0,
                            'otrde1' => 0
                        ));
                    }
                    //Imprimimos el reporte para nómina
                    $jc = new JasperCommand();
                    $jc->setFolder('rpt/' . $this->session->USERNAME);
                    $parametros = array();
                    $parametros["logo"] = base_url() . $this->session->LOGO;
                    $parametros["empresa"] = $this->session->EMPRESA_RAZON;
                    $parametros["docto"] = $docto;
                    $jc->setParametros($parametros);
                    $jc->setJasperurl('jrxml\plantilla\reporteDoctoPlantillaConFraccion.jasper');
                    $jc->setFilename('IMPRIME_DOCTO_PLANTILLA_MAQUILA_CON_FRACCIONES_' . Date('h_i_s'));
                    $jc->setDocumentformat('pdf');
                    PRINT $jc->getReport();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha($fecha) {
        try {
            $this->db->select('U.sem, U.Ano ', false);
            $this->db->from('semanasnomina AS U');
            $this->db->where("str_to_date('$fecha','%d/%m/%Y') BETWEEN str_to_date(FechaIni,'%d/%m/%Y') AND str_to_date(FechaFin,'%d/%m/%Y')", null, false);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//        print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRetornoControlPlantilla() {
        try {
            $this->db->set('Estatus', 1)->set('FechaRetorna', $this->input->post('FECHA'))->where('ID', $this->input->post('ID'))->update('controlpla');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimir() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["docto"] = $this->input->post('DOCUMENTO');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\plantilla\reporteDoctoPlantilla.jasper');
        $jc->setFilename('IMPRIME_DOCTO_PLANTILLA_MAQUILA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getReporteDePago() {
        $x = $this->input->post();
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["FECHAINICIAL"] = $x['FECHAINICIAL'];
        $parametros["FECHAFINAL"] = $x['FECHAFINAL'];
        switch (intval($x['STS'])) {
            case 1:
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\plantilla\ReportePagoSinRecibir.jasper');
                $jc->setFilename('ReporteDePagoSinRecibir_' . Date('h_i_s'));

                switch (intval($x['TDOC'])) {
                    case 1:
                        $jc->setDocumentformat('pdf');
                        break;
                    case 2:
                        $jc->setDocumentformat('xls');
                        break;
                }
                PRINT $jc->getReport();
                break;
            case 2:
                $jc->setParametros($parametros);
                $jc->setJasperurl('jrxml\plantilla\ReportePagoRecibido.jasper');
                $jc->setFilename('ReporteDePagoRecibido_' . Date('h_i_s'));

                switch (intval($x['TDOC'])) {
                    case 1:
                        $jc->setDocumentformat('pdf');
                        break;
                    case 2:
                        $jc->setDocumentformat('xls');
                        break;
                }
                $l = new Logs("Captura plantillas para maquila", "GENERO UN REPORTE DE PAGO '{$x['FECHAINICIAL']}' - '{$x['FECHAFINAL']}' , " . (intval($x['STS']) === 1 ? "sin recibir" : "recibido") . ". ", $this->session);
                PRINT $jc->getReport();
                break;
        }
    }

}
