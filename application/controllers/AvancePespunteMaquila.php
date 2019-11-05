<?php

/**
 * Description of AvancePespunteMaquila
 *
 * @author Y700
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class AvancePespunteMaquila extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AvancePespunteMaquila_model', 'apm');
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
                        $this->load->view('vMenuAdministracion');
                        $is_valid = true;
                        break;
                    case 'PRODUCCION':
                        $this->load->view('vMenuProduccion');
                        $is_valid = true;
                        break;
                }
                $dt["TYPE"] = 2;
                $this->load->view('vFondo')->view('vAvancePespunteMaquila')->view('vWatermark', $dt)->view('vFooter');
            }
            if (!$is_valid) {
                $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
//            print json_encode($this->apm->getMaquilas());
            print json_encode($this->db->select("CAST(M.Clave AS SIGNED) AS CLAVE, "
                                            . "CONCAT(M.Clave,' ',M.Nombre) AS MAQUILA", false)
                                    ->from('maquilas AS M')
                                    ->where('M.Estatus', 'ACTIVO')
                                    ->order_by('CLAVE', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
//            print json_encode($this->apm->getEmpleados());
            print json_encode($this->db->select("E.Numero AS CLAVE, "
                                            . "CONCAT(E.Numero,' ',E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ',E.Materno) AS EMPLEADO", false)
                                    ->from('empleados AS E')
                                    ->where_in('E.Puesto', array('PESPUNTE', 'PESPUNTADOR', 'PRELIMINAR'))
                                    ->where('E.AltaBaja', 1)
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParaPespunte() {
        try {
            $x = $this->input->get();
            $this->db->select("C.ID, C.Control AS CONTROL, C.Estilo AS ESTILO, "
                            . "C.Color AS COLOR, C.Pares AS PARES, "
                            . "P.FechaEntrega AS ENTREGA, C.Maquila AS MAQUILA", false)
                    ->from('controles AS C')
                    ->join('pedidox AS P', 'C.Control = P.Control')
                    ->join('controlpes AS CP', 'CP.Control = C.Control', 'left')
                    ->where('CP.ID IS NULL', null, false);
            if ($x['MAQUILA'] !== '') {
                $this->db->where('C.Maquila', $x['MAQUILA']);
            }
            if ($x['MAQUILA'] === '') {
                $this->db->limit(50);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnPespunte() {
        try {
//            print json_encode($this->apm->getControlesEnPespunte());
            print json_encode($this->db->select('CPS.ID, CPS.numcho AS MAQUILA, CPS.nomcho AS MAQUILAT, CPS.numtej, '
                                            . 'CPS.nomtej, CPS.fechapre AS FECHA, CPS.control AS CONTROL, '
                                            . 'CPS.estilo AS ESTILO, CPS.color AS COLOR, CPS.nomcolo AS COLORT, '
                                            . 'CPS.docto AS DOCTO, CPS.pares AS PARES, AV.ID AS IDA', false)
                                    ->from('controles AS C')
                                    ->join('controlpes AS CPS', 'CPS.Control = C.Control', 'left')
                                    ->join('avance AS AV', 'AV.Control = C.Control')
                                    ->where('CPS.ID IS NOT NULL', null, false)->limit(999)
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
                $this->db->limit(99);
            }
            $this->db->get()->result();
            print json_encode();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarAvance() {
        try {
//            print json_encode($this->apm->onVerificarAvance($this->input->get('CONTROL')));
//            print json_encode($this->apm->onVerificarAvance($this->input->get('CONTROL')));
            $x = $this->input->get();
            $this->db->select("COUNT(A.ID) AS EXISTE", false)
                    ->from('avance AS A')
                    ->where('A.Departamento', 100);
            if ($x['CONTROL'] !== '') {
                $this->db->where('A.Control', $x['CONTROL']);
            }
            if ($x['CONTROL'] === '') {
                $this->db->limit(99);
            }
            $this->db->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoControl() {
        try {
            print json_encode($this->apm->getInfoControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAvanzar() {
        try {
            $x = $this->input;
            $xXx = $this->input->post();
            /* AVANCE A MAQUILA */
            $avance = array(
                'Control' => $xXx['CONTROL'],
                'FechaAProduccion' => Date('d/m/Y'),
                'Departamento' => 110,
                'DepartamentoT' => 'PESPUNTE',
                'FechaAvance' => Date('d/m/Y'),
                'Estatus' => 'A',
                'Usuario' => $_SESSION["ID"],
                'Fecha' => Date('d/m/Y'),
                'Hora' => Date('h:i:s a'),
                'Fraccion' => $xXx['FRACCION'] /* INFORMATIVO */
            );
            $this->db->insert('avance', $avance);

            /* AVANCE A PESPUNTE */
            $avance["Departamento"] = 110;
            $avance["DepartamentoT"] = 'PESPUNTE';
            $avance["Fraccion"] = $xXx['FRACCION'];
            $this->db->insert('avance', $avance);

            /* ACTUALIZA A 130 ALM-PESPUNTE, stsavan 6 */
//            $this->db->set('EstatusProduccion', 'PESPUNTE')->set('DeptoProduccion', 110)
//                    ->where('Control', $xXx['CONTROL'])
//                    ->update('controles');
//            $this->db->set('stsavan', 5)->set('EstatusProduccion', 'PESPUNTE')
//                    ->set('DeptoProduccion', 110)->where('Control', $xXx['CONTROL'])
//                    ->update('pedidox');
//            $this->db->set('fec5', Date('Y-m-d h:i:s'))->where('contped', $xXx['CONTROL'])
//                    ->update('avaprd');

            $pes = array(
                'numcho' => $xXx['MAQUILA'],
                'nomcho' => $xXx['MAQUILAT'],
                'fechapre' => $xXx['FECHA'],
                'control' => $xXx['CONTROL'],
                'estilo' => $xXx['ESTILO'],
                'color' => $xXx['COLOR'],
                'nomcolo' => $xXx['COLORT'],
                'docto' => $xXx['DOCTO'],
                'pares' => $xXx['PARES'],
                'fraccion' => $xXx['FRACCION']
            );
            $this->db->insert('controlpes', $pes);


            /* ACTUALIZA A 130 ALM-PESPUNTE, stsavan 6 */
            $this->db->set('EstatusProduccion', 'ALM-PESPUNTE')
                    ->set('DeptoProduccion', 130)
                    ->where('Control', $xXx['CONTROL'])
                    ->update('controles');
            $this->db->set('stsavan', 6)->set('EstatusProduccion', 'ALM-PESPUNTE')
                    ->set('DeptoProduccion', 130)->where('Control', $xXx['CONTROL'])
                    ->update('pedidox');
            $this->db->set('fec6', Date('Y-m-d h:i:s'))->where('contped', $xXx['CONTROL'])
                    ->update('avaprd');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAvanceMaquilaByID() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('controlpes');
            $this->db->where('ID', $this->input->post('IDA'))->delete('avance');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
