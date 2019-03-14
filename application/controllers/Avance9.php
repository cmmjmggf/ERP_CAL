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
            print json_encode($this->axepn->getSemanaByFecha(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarRetornoDeMaterialXControl() {
        try {
            $x = $this->input;
            print json_encode($this->axepn->onComprobarRetornoDeMaterialXControl($x->get('CR'), $x->get('FR'), $x->get('DEPTO')));
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
             * 10 CORTE
             * 30 REBAJADO Y PERFORADO
             * 80 RAYADO CONTADO
             * 280 CALIDAD
             * 
             * ADEMÁS EL EMPLEADO DEBE DE ESTAR A DESTAJO O AMBOS, NO COMO EMPLEADO FIJO
             * 
             * DE LO CONTRARIO ARROJAR UN MENSAJE
             */

            $EMPLEADO_VALIDO = $this->axepn->onComprobarDeptoXEmpleado($this->input->post('EMPLEADO'));
            print json_encode($EMPLEADO_VALIDO);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarFraccionXEstilo() {
        try {
            print json_encode($this->axepn->onComprobarFraccionXEstilo($this->input->post('ESTILO'), $this->input->post('FRACCION')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFraccionesPagoNomina() {
        try {
            header('Content-type: application/json');
            $url = $this->uri;
            $x = $this->input;
            switch ($url->segment(2)) {
                case 1:
                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "96,99,100"));
                    break;
                case 2:
                    print json_encode($this->axepn->getFraccionesPagoNomina($x->post('EMPLEADO'), "51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337"));
                    break;
            }
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
            $x = $this->input;
            $fecha = $x->post('FECHA');
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $data = array(
                "numeroempleado" => $x->post('NUMERO_EMPLEADO'),
                "maquila" => intval(substr($x->post('CONTROL'), 4, 2)),
                "control" => $x->post('CONTROL'),
                "estilo" => $x->post('ESTILO'),
                "numfrac" => $x->post('NUMERO_FRACCION'),
                "preciofrac" => $x->post('PRECIO_FRACCION'),
                "pares" => $x->post('PARES'),
                "subtot" => (floatval($x->post('PARES')) * floatval($x->post('PRECIO_FRACCION'))),
                "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                "semana" => $x->post('SEMANA'),
                "depto" => $x->post('DEPARTAMENTO'),
                "anio" => $x->post('ANIO'));

            $retorno_material = $this->axepn->onComprobarRetornoDeMaterial($x->post('CONTROL'), $x->post('NUMERO_FRACCION'), $x->post('NUMERO_EMPLEADO'));
            /* SI EL CONTROL, LA FRACCION Y EL EMPLEADO HA REGRESADO ESTE MATERIAL SE OBTIENE UN "1" DE LO CONTRARIO SI EL NO REGRESO EL MATERIAL SE DEVUELVE "0" */
            if (intval($retorno_material[0]->EXISTE) === 1) {
                /* PASO 1 : AGREGAR AVANCE (DEBE DE ESTAR EN CORTE EL CONTROL, ADEMÁS DEBE DE ) */
                /* AVANCE DE (10) CORTE A (20) RAYADO */
                /* COMPROBAR SI YA EXISTE UN REGISTRO DE ESTE AVANCE (20 - RAYADO) PARA NO GENERAR DOS AVANCES AL MISMO DEPTO EN CASO DE QUE LLEGUEN A PEDIR MÁS MATERIAL */
                $check_avance = $this->db->select('COUNT(A.Control) AS EXISTE', false)
                                ->from('avance AS A')
                                ->where('A.Control', $x->post('CONTROL'))
                                ->where('A.Departamento', 20)
                                ->where('A.Fraccion', $x->post('NUMERO_FRACCION'))
                                ->where_not_in('A.Emp')
                                ->get()->result();

                /* SOLO SE GENERA EL AVANCE EN LA FRACCIÓN 100 QUE ES LA PIEL */
                /* CORTE = > RAYADO */
                if ($check_avance[0]->EXISTE <= 0) {
                    $id = 0;
                    if (intval($x->post('NUMERO_FRACCION')) === 100) {
                        $avance = array(
                            'Control' => $x->post('CONTROL'),
                            'FechaAProduccion' => Date('d/m/Y'),
                            'Departamento' => 20,
                            'DepartamentoT' => 'RAYADO',
                            'FechaAvance' => Date('d/m/Y'),
                            'Estatus' => 'A',
                            'Usuario' => $_SESSION["ID"],
                            'Fecha' => Date('d/m/Y'),
                            'Hora' => Date('h:i:s a'),
                            'Fraccion' => $x->post('NUMERO_FRACCION')
                        );
                        $this->db->insert('avance', $avance);
                        $id = $this->db->insert_id();
                        $this->db->set('EstatusProduccion', 'RAYADO')
                                ->where('Control', $x->post('CONTROL'))
                                ->update('controles');
                    }
                    /* PASO 2 : AGREGAR FRACCION PAGADA */
                    $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                    ->from('fracpagnomina AS F')
                                    ->where('F.control', $x->post('CONTROL'))
                                    ->where('F.numfrac', $x->post('NUMERO_FRACCION'))
                                    ->get()->result();
                    $data["fraccion"] = $x->post('FRACCION');
                    if ($check_fraccion[0]->EXISTE <= 0) {
                        $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                        $this->db->insert('fracpagnomina', $data);
                        print '{"AVANZO":"1","FR":"100","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A RAYADO"}';
                    } else {
                        $this->db->insert('fracpagnomina', $data);
                        print '{"AVANZO":"0","FR":"99","RETORNO":"SI", "MESSAGE":"FRACCION 99, NO GENERA AVANCE"}';
                    }
                } else {
                    /* RAYADO/RAYADO CONTADO => REBAJADO Y PERFORADO/REBAJADO */
                    if ($x->post('DEPARTAMENTO') === 80) {
                        $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                        ->from('fracpagnomina AS F')
                                        ->where('F.control', $x->post('CONTROL'))
                                        ->where('F.numfrac', 103)
                                        ->get()->result();
                        $data["fraccion"] = $x->post('FRACCION');
                        if ($check_fraccion[0]->EXISTE <= 0) {
                            $avance = array(
                                'Control' => $x->post('CONTROL'),
                                'FechaAProduccion' => Date('d/m/Y'),
                                'Departamento' => 30,
                                'DepartamentoT' => 'REBAJADO Y PERFORADO',
                                'FechaAvance' => Date('d/m/Y'),
                                'Estatus' => 'A',
                                'Usuario' => $_SESSION["ID"],
                                'Fecha' => Date('d/m/Y'),
                                'Hora' => Date('h:i:s a'),
                                'Fraccion' => $x->post('NUMERO_FRACCION')
                            );
                            $avance["Fraccion"] = 103;
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                            $this->db->insert('fracpagnomina', $data);
                            $this->db->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            print '{"AVANZO":"1","FR":"102","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A REBAJADO Y PERFORADO"}';
                        }
                    } else {
                        print '{"AVANZO":"0","FR":"???","RETORNO":"SI", "MESSAGE":"FRACCION ???, NO GENERA AVANCE"}';
                    }
                }
            } else {
                /* EL CORTADOR NO HA REGRESADO MATERIAL O EL ALMACENISTA NO HA REGISTRADO EL RETORNO DEL MATERIAL */
                print '{"AVANZO":"0","RETORNO":"NO", "MESSAGE":"NUMERO DE FRACCION O EMPLEADO INCORRECTOS"}';
            }
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

            $data = array(
                "numeroempleado" => $x->post('NUMERO_EMPLEADO'),
                "maquila" => intval(substr($x->post('CONTROL'), 4, 2)),
                "control" => $x->post('CONTROL'),
                "estilo" => $x->post('ESTILO'),
                "numfrac" => $x->post('NUMERO_FRACCION'),
                "preciofrac" => $x->post('PRECIO_FRACCION'),
                "pares" => $x->post('PARES'),
                "subtot" => (floatval($x->post('PARES')) * floatval($x->post('PRECIO_FRACCION'))),
                "fecha" => $nueva_fecha->format('Y-m-d h:i:s'),
                "semana" => $x->post('SEMANA'),
                "depto" => $x->post('DEPARTAMENTO'),
                "anio" => $x->post('ANIO'));

            $departamento = $x->post('DEPARTAMENTO');
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
