<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RelojChecador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RelojChecador_model', 'ASM');
    }

    public function index() {
        $this->load->view('vEncabezado')->view('vRelojChecador', array('vigilancia' => 0))->view('vFooter');
    }

    public function getInformacionSemana() {
        try {
            print json_encode($this->ASM->getInformacionSemana(Date('d/m/Y')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAcceder() {
        try {
            $fecha = Date('Y-m-d');
            $x = $this->input->post();
//            $Entrada_Salida = $this->ASM->onComprobarEntrada($x['Numero'], $fecha);
            $Entrada_Salida = $this->db->select("A.numemp AS Numero, A.nomemp AS Empleado, "
                                    . "A.numdep AS DEPARTAMENTO, "
                                    . "A.nomdep AS DEPARTAMENTOT, "
                                    . "A.fecalta AS FECHAALTA, "
                                    . "A.ampm AS AMPM, "
                                    . "A.turno AS TURNO, A.hora AS HORA, "
                                    . "A.semana AS SEMANA, A.año AS ANO, A.reg", false)
                            ->from('relojchecador AS A')
                            ->join('empleados AS E', 'E.Numero = A.numemp', 'left')
                            ->where('A.numemp', $x['Numero'])
                            ->where('A.fecalta  >= \'' . $fecha . '\'')
                            ->order_by('A.ID', 'DESC')->limit(4)->get()->result();
            $info_empleado = $this->db->select("E.ID AS ID, "
                                    . "CONCAT(E.PrimerNombre,' ', E.SegundoNombre,' ',E.Paterno,' ',E.Materno) AS Empleado, "
                                    . "E.Foto AS FOTO, E.DepartamentoFisico AS DEPTO, D.Descripcion AS DEPTOT", false)
                            ->from('empleados AS E')->join('departamentos AS D', 'E.DepartamentoFisico = D.Clave')
                            ->where('E.Numero', intval($x['Numero']))->limit(1)->get()->result();
            $dtm = json_decode(json_encode($info_empleado), FALSE);
            if (count($dtm) > 0) {
                $e = $dtm[0];
                $ANIO = Date('Y');
                $MES = intval(Date('m'));
                $DIA = intval(Date('d'));

                $ultimo_check_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM relojchecador as R WHERE YEAR(R.fecalta) = {$ANIO} AND MONTH(R.fecalta) = {$MES} AND DAY(R.fecalta) = {$DIA} AND numemp = {$x['Numero']} order by ID DESC LIMIT 1")->result();
                if (intval($ultimo_check_existe[0]->EXISTE) > 0) {
                    $ultimo_check = $this->db->query("SELECT * FROM relojchecador as R WHERE YEAR(R.fecalta) = {$ANIO} AND MONTH(R.fecalta) = {$MES} AND DAY(R.fecalta) = {$DIA} AND numemp = {$x['Numero']} order by ID DESC LIMIT 1")->result();
                    $tiempo_check ="{$ultimo_check[0]->fecalta}";
                    
                    $TIEMPO_EN_SEGUNDOS = $this->db->query("SELECT TIMESTAMPDIFF(second,'{$tiempo_check}',now())/60 AS DIFERENCIA_TIEMPO_EN_SEGUNDOS, 
TIMESTAMPDIFF(minute,'{$tiempo_check}',now())  AS DIFERENCIA_TIEMPO_EN_MINUTOS, 
TIMESTAMPDIFF(HOUR,'{$tiempo_check}',now())  AS DIFERENCIA_TIEMPO_EN_HORAS")->result();

                    if (intval($TIEMPO_EN_SEGUNDOS[0]->DIFERENCIA_TIEMPO_EN_HORAS) <= 1) {
                        print json_encode($info_empleado);
//                        print "\n HORA DESFASE \n  \n";
//                        print "\n $tiempo_check \n";
//                        var_dump($TIEMPO_EN_SEGUNDOS);
                        exit(0);
                    }
                }
                $es = array(
                    'numemp' => $x['Numero'],
                    'fecalta' => Date('Y-m-d 00:00:00'),
                    'hora' => Date('H:i:s'),
                    'nomemp' => str_replace("0", "", $dtm[0]->Empleado),
                    'numdep' => $dtm[0]->DEPTO,
                    'nomdep' => $dtm[0]->DEPTOT,
                    'ampm' => Date('a'),
                    'año' => Date('Y'),
                    'semana' => $x['Semana'],
                    'reg' => $this->session->ID);
                $es['Usuario'] = $this->session->ID;
                $es['UsuarioT'] = $this->session->USERNAME;
                switch (count($Entrada_Salida)) {
                    case 0:
                        $es['turno'] = 1;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 1:
                        $es['turno'] = 2;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 2:
                        $es['turno'] = 3;
                        $this->db->insert('relojchecador', $es);
                        break;
                    case 3:
                        $es['turno'] = 4;
                        $this->db->insert('relojchecador', $es);
                        break;
                    default:
                        $es['turno'] = 0;
                        break;
                }
                print json_encode($info_empleado);
                if (intval($es['turno']) > 0) {
                    $l = new Logs("RELOJ CHECADOR", "{$x['Numero']} AH REGISTRADO TURNO {$es['turno']}", $this->session);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
