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
            print json_encode($this->avm->getAvancesNomina($this->input->post('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXConcepto() {
        try {
            print json_encode($this->avm->getRastreoXConcepto());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRastreoXControl() {
        try {
            print json_encode($this->avm->getRastreoXControl());
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
            print json_encode($this->avm->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->avm->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanasDeProduccion() {
        try {
            print json_encode($this->avm->getSemanaByFecha(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSemanaNomina() {
        try {
            print json_encode($this->avm->getSemanaNomina($this->input->post('FECHA')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptoActual() {
        try {
            print json_encode($this->avm->getDeptoActual($this->input->post('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioFraccionXEstiloFraccion() {
        try {
            $x = $this->input;
            print json_encode($this->avm->getPrecioFraccionXEstiloFraccion($x->get('ESTILO'), $x->get('FRACCION')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilasPlantillas() {
        try {
            print json_encode($this->avm->getMaquilasPlantillas());
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

    public function onAvanzar() {
        try {
            $db = $this->db;
            $x = $this->input;
            $id = 0;
            $frac = intval($x->post('FRACCION'));
            $depto = intval($x->post('DEPTO'));

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
                $this->db->set('EstatusProduccion', ($depto === 180) ? "MONTADO A" : "MONTADO B")
                        ->set('DeptoProduccion', $x->post('DEPTO'))
                        ->where('Control', $x->post('CONTROL'))->update('pedidox');
            }
            if ($x->post('FRACCION') === 600 && $x->post('DEPTO') === 210 ||
                    $x->post('FRACCION') === 600 && $x->post('DEPTO') === 220) {
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
                /* DE ADORNO B PASA A ALMACEN DE ADORNO */
                if ($x->post('DEPTO') === 220) {
                    $this->db->set('EstatusProduccion', 'ALMACEN ADORNO')
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('controles');
                    $this->db->set('EstatusProduccion', 'ALMACEN ADORNO')
                            ->set('DeptoProduccion', $x->post('DEPTO'))
                            ->where('Control', $x->post('CONTROL'))->update('pedidox');
                }
                $id = $this->db->insert_id();
            }
            $fecha = $x->post('FECHA');
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);

            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $this->db->insert('fracpagnomina', array(
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
//SOLO SI NO HA LLEGADO A ADORNO B SE COLOCA OTRO ESTATUS
            if ($x->post('DEPTO') !== 220) {
                $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                        ->set('DeptoProduccion', $x->post('DEPTO'))
                        ->where('Control', $x->post('CONTROL'))->update('controles');
                $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                        ->set('DeptoProduccion', $x->post('DEPTO'))
                        ->where('Control', $x->post('CONTROL'))->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
