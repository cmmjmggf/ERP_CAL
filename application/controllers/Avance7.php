<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avance7 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('Avance7_model', 'avm')
                ->helper('jaspercommand_helper');
    }

    public function getXLS() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = 1;
        $parametros["ano"] = 2019;
        $parametros["sem"] = 10;
        $parametros["Nmaq"] = 'CALZADO LOBO 12345';
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\relacionCoreHiloTejido.jasper');
        $jc->setFilename('ReporteDelSistema' . Date('h_i_s') . "_" . $this->input->post('CONTROL'));
        $jc->setDocumentformat('xls');
        PRINT $jc->getReport();
    }

    public function getPDF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["maq"] = 1;
        $parametros["ano"] = 2019;
        $parametros["sem"] = 10;
        $parametros["Nmaq"] = 'CALZADO LOBO 12345';
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\materiales\relacionCoreHiloTejido.jasper');
        $jc->setFilename('ReporteDelSistema' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getPagosXEmpleadoXSemana() {
        try {
            header('Content-type: application/json');
            print json_encode($this->avm->getPagosXEmpleadoXSemana($this->input->get('EMPLEADO'), $this->input->get('SEMANA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->avm->getInfoXControl($this->input->post('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoAvanceXControl() {
        try {
            print json_encode($this->avm->getUltimoAvanceXControl($this->input->get('C')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarDeptoXEmpleado() {
        try {
            print json_encode($this->avm->onComprobarDeptoXEmpleado($this->input->get('EMPLEADO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarAvanceXControl() {
        try {
            
            print json_encode($this->avm->onComprobarAvanceXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaByFecha() {
        try {
            print json_encode($this->avm->getSemanaByFecha(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesPagoNomina() {
        try {
            header('Content-type: application/json');
            $x = $this->input;
            print json_encode($this->avm->getFraccionesPagoNomina($x->post('EMPLEADO'), "60,70,71,72,75,204,337"));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarFraccionesPagadas() {
        try {
            $x = $this->input;
            $fracciones = json_decode($x->post('FRACCIONES'), false)/* FALSE = STDCLASS, TRUE = ASSOCIATIVE_ARRAY */;
            $pagado = 0;
            foreach ($fracciones as $k => $v) {
                $precio_x_fraccion = $this->db->select('FPN.ID AS PRECIO')->from('fracpagnomina AS FPN')
                                ->where('FPN.Control', $x->post('CONTROL'))
                                ->where('FPN.numfrac', $v->NUMERO_FRACCION)
                                ->where('FPN.Estilo', $x->post('ESTILO'))->get()->result();
                if (!empty($precio_x_fraccion)) {
                    $pagado = 1;
                    break;
                } else {
                    $pagado = 0;
                }
            }
            print $pagado;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            $fecha = $x->post('FECHA');
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $fracciones = json_decode($x->post('FRACCIONES'), false)/* FALSE = STDCLASS, TRUE = ASSOCIATIVE_ARRAY */;
            foreach ($fracciones as $k => $v) {
                $precio_x_fraccion = $this->db->select('FXE.CostoMO AS PRECIO')->from('fraccionesxestilo AS FXE')
                                ->where('FXE.Fraccion', $v->NUMERO_FRACCION)
                                ->where('FXE.Estilo', $x->post('ESTILO'))->get()->result();
                /* VERIFICAR SI ESE ESTILO TIENE ESA FRACCION */
                if (!empty($precio_x_fraccion)) {
                    $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                    ->from('fracpagnomina AS F')
                                    ->where('F.control', $x->post('CONTROL'))
                                    ->where('F.numfrac', $x->post('NUMERO_FRACCION'))
                                    ->get()->result();
                    $data = array(
                        "numeroempleado" => $x->post('NUMERO_EMPLEADO'),
                        "maquila" => intval(substr($x->post('CONTROL'), 4, 2)),
                        "control" => $x->post('CONTROL'),
                        "estilo" => $x->post('ESTILO'),
                        "numfrac" => $v->NUMERO_FRACCION,
                        "preciofrac" => $precio_x_fraccion[0]->PRECIO,
                        "pares" => $x->post('PARES'),
                        "subtot" => (floatval($x->post('PARES')) * floatval($precio_x_fraccion[0]->PRECIO)),
                        "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                        "semana" => $x->post('SEMANA'),
                        "depto" => $x->post('DEPARTAMENTO'),
                        "anio" => $x->post('ANIO'),
                        "fraccion" => $v->DESCRIPCION);

                    if ($check_fraccion[0]->EXISTE <= 0) {
                        /* 60 FOLEADO CORTE CALIDAD */
                        if (intval($v->NUMERO_FRACCION) === 60) {
                            $avance = array(
                                'Control' => $x->post('CONTROL'),
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
                        } else {
                            $this->db->insert('fracpagnomina', $data);
                        }
                        /* MOVER EL ESTATUS DE PRODUCCION
                         * 70	PREL-CORTE, GENERA AVANCE 1
                         */
                        $this->db->set('EstatusProduccion', 'PREL-CORTE')
                                ->set('DeptoProduccion', 70)
                                ->where('Control', $x->post('CONTROL'))
                                ->update('controles');
                        $this->db->set('EstatusProduccion', 'PREL-CORTE')
                                ->set('DeptoProduccion', 70)
                                ->where('Control', $x->post('CONTROL'))
                                ->update('pedidox');
                        print '{"AVANZO":"1","FR":"' . $x->post('NUMERO_FRACCION') . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A ENTRETELADO"}';
                    } else {
                        print '{"AVANZO":"0","FR":"' . $x->post('NUMERO_FRACCION') . '","RETORNO":"SI", "MESSAGE":"FRACCION ' . $x->post('NUMERO_FRACCION') . ', NO GENERA AVANCE"}';
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* JASPER */
}
