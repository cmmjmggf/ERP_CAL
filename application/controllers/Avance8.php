<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class Avance8 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Avance8_model', 'axepn');
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
            print json_encode($this->axepn->onComprobarFraccionXEstilo($x->get('CR'), $x->get('FR')));
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
            $EMPLEADO_VALIDO = $this->axepn->onComprobarDeptoXEmpleado($this->input->post('EMPLEADO'));
            print json_encode($EMPLEADO_VALIDO);
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
                            ->where('A.Control', $x->post('CONTROL'))
                            ->where('A.Departamento', 90)
                            ->where_not_in('A.Emp', $x->post('NUMERO_EMPLEADO'))
                            ->get()->result();

            /* SOLO SE GENERA EL AVANCE EN LA FRACCIÓN 51 QUE ES LA PIEL */
            if ($check_avance[0]->EXISTE <= 0) {
                $id = 0;

                if (intval($x->post('NUMERO_FRACCION')) === 51) {
                    /* 51 = ENTRETELADO */
                    $avance = array(
                        'Control' => $x->post('CONTROL'),
                        'FechaAProduccion' => Date('d/m/Y'),
                        'Departamento' => 90,
                        'DepartamentoT' => 'ENTRETELADO',
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x->post('NUMERO_FRACCION')
                    );
                    $this->db->insert('avance', $avance);
                    $id = $this->db->insert_id();
                    $this->db->set('EstatusProduccion', 'ENTRETELADO')
                            ->where('Control', $x->post('CONTROL'))
                            ->update('controles');
                    $this->db->set('EstatusProduccion', 'ALMACEN CORTE')
                            ->set('DeptoProduccion', 105)
                            ->where('Control', $x->post('CONTROL'))
                            ->update('controles');
                } else if (intval($x->post('NUMERO_FRACCION')) === 397) {
                    $avance = array(
                        'Control' => $x->post('CONTROL'),
                        'FechaAProduccion' => Date('d/m/Y'),
                        'Departamento' => 140,
                        'DepartamentoT' => 'ENSUELADO',
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => $x->post('NUMERO_FRACCION')
                    );
                    $this->db->insert('avance', $avance);
                    $id = $this->db->insert_id();
                    $this->db->set('EstatusProduccion', 'ENSUELADO')
                            ->where('Control', $x->post('CONTROL'))
                            ->update('controles');
                } else {
                    $check_depto = $this->db->select('E.Numero AS EMPLEADO, E.DepartamentoFisico AS DEPTO, D.Descripcion AS DEPTODES', false)
                                    ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                                    ->where('E.Numero', $x->post('NUMERO_EMPLEADO'))
                                    ->get()->result();
                    $avance = array(
                        'Control' => $x->post('CONTROL'),
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
                            $this->db->set('EstatusProduccion', 'REBAJADO Y PERFORADO')
                                    ->set('DeptoProduccion', 30)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            break;
                        case 40:
                            /* FOLEADO */
                            $avance['Departamento'] = 40;
                            $avance['Fraccion'] = 60;
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* FOLEADO */;
                            $this->db->set('EstatusProduccion', 'FOLEADO')
                                    ->set('DeptoProduccion', 40)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            break;
                        case 50:
                            /* DOBLILLADO */
                            $this->db->set('EstatusProduccion', 'DOBLILLADO')
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $this->db->set('EstatusProduccion', 'DOBLILLADO')
                                    ->set('DeptoProduccion', 50)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            break;
                        case 60:
                            /* LASER */
                            $avance['Departamento'] = 60;
                            $avance['Fraccion'] = $x->post('NUMERO_FRACCION');
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* FOLEADO */;
                            $this->db->insert('avance', $avance);
                            $this->db->set('EstatusProduccion', 'FOLEADO')
                                    ->set('DeptoProduccion', 60)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $id = $this->db->insert_id();
                            break;
                        case 70:
                            /* PREL-CORTE */
                            $avance['Departamento'] = 70;
                            $avance['Fraccion'] = $x->post('NUMERO_FRACCION');
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* LASER */;
                            $this->db->set('EstatusProduccion', 'LASER')
                                    ->set('DeptoProduccion', 70)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            break;
                        case 80:
                            /* RAYADO CONTADO */
                            $avance['Departamento'] = 80;
                            $avance['Fraccion'] = $x->post('NUMERO_FRACCION');
                            $avance['DepartamentoT'] = $check_depto[0]->DEPTODES/* RAYADO CONTADO */;
                            $this->db->set('EstatusProduccion', 'RAYADO CONTADO')
                                    ->set('DeptoProduccion', 80)
                                    ->where('Control', $x->post('CONTROL'))
                                    ->update('controles');
                            $this->db->insert('avance', $avance);
                            $id = $this->db->insert_id();
                            break;
                    }
                }
                /* PASO 2 : PAGAR FRACCION */
                $check_fraccion = $this->db->select('COUNT(F.numeroempleado) AS EXISTE', false)
                                ->from('fracpagnomina AS F')
                                ->where('F.control', $x->post('CONTROL'))
                                ->where('F.numfrac', $x->post('NUMERO_FRACCION'))
                                ->get()->result();

                $data["fraccion"] = $x->post('FRACCION');
                if ($check_fraccion[0]->EXISTE <= 0) {
                    $data["avance_id"] = intval($id) >= 0 ? intval($id) : 0;
                    $this->db->insert('fracpagnomina', $data);
                    print '{"AVANZO":"1","FR":"' . $x->post('NUMERO_FRACCION') . '","RETORNO":"SI","MESSAGE":"EL CONTROL HA SIDO AVANZADO A ENTRETELADO"}';
                } else {
                    print '{"AVANZO":"0","FR":"' . $x->post('NUMERO_FRACCION') . '","RETORNO":"SI", "MESSAGE":"FRACCION ' . $x->post('NUMERO_FRACCION') . ', NO GENERA AVANCE"}';
                }
            } else {
                /* YA EXISTE UN AVANCE DE ENTRETELADO EN ESTE CONTROL */
                print '{"AVANZO":"0","FR":"' . $x->post('NUMERO_FRACCION') . '","RETORNO":"SI", "MESSAGE":"EL NUMERO DE FRACCION Y EMPLEADO SON CORRECTOS, PERO YA HA SIDO AVANZADO A ENTRETELADO CON ANTERIORIDAD"}';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
