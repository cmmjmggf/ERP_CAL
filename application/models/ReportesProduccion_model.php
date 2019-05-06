<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ReportesProduccion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function getFechas($Año, $Semana) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select('
                STR_TO_DATE(FechaIni, "%d/%m/%Y") AS Dia1,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 1 DAY) AS Dia2,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 2 DAY) AS Dia3,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 3 DAY) AS Dia4,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 4 DAY) AS Dia5,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 5 DAY) AS Dia6,
                DATE_ADD(STR_TO_DATE(FechaIni, "%d/%m/%Y"),INTERVAL 6 DAY) AS Dia7 '
                            . " ", false)
                    ->from('semanasnomina')
                    ->where('Ano', $Año)
                    ->where('Sem', $Semana)
                    ->where('Estatus', 'ACTIVO');


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDeptos($Año, $Semana) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("fpn.depto, "
                            . "ifnull(D.Descripcion,'N/A FALTA ENLAZAR NUEVOS DEPTOS') AS NombreDepto "
                            . " ", false)
                    ->from('fracpagnomina fpn ')
                    ->join('departamentos D', 'on fpn.depto = D.Clave', 'left')
                    ->where('fpn.anio', $Año)
                    ->where('fpn.semana', $Semana)
                    ->where('fpn.depto > 0', null, false)
                    ->group_by(array('fpn.depto'))
                    ->order_by('fpn.depto', 'ASC');


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTablaTemporal($Depto) {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("depto "
                            . " ", false)
                    ->from('costomanoobratemp')
                    ->where('depto', $Depto);


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesParesByDeptoAnoSemanaFecha($Año, $Semana) {
        try {
            $this->db->query("set sql_mode=''");
            return $this->db->query("
                SELECT fpn.depto,fpn.control, fpn.pares, fpn.subtot,  DATE_FORMAT(fpn.fecha, '%Y-%m-%d') as fecha ,
                ifnull(D.Descripcion,'N/A FALTA ENLAZAR NUEVOS DEPTOS') AS NombreDepto
                        from fracpagnomina fpn
                        left join departamentos D on fpn.depto = D.Clave
                        where fpn.anio = $Año
                        and fpn.semana = $Semana
                        and fpn.depto > 0
                        order by  fpn.fecha asc, fpn.depto asc ,fpn.control asc ")->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getManoObraDestajo() {
        try {
            $this->db->query("set sql_mode=''");
            $this->db->select("
depto, nombreDepto,
ifnull(cast(tpares1 as decimal(7,0)),0) as tp1,
ifnull(cast(tpesos1 as decimal(7,2)),0) as tpe1,
ifnull(cast(tpares2 as decimal(7)),0) as tp2,
ifnull(cast(tpesos2 as decimal(7,2)),0) as tpe2,
ifnull(cast(tpares3 as decimal(7)),0) as tp3,
ifnull(cast(tpesos3 as decimal(7,2)),0) as tpe3,
ifnull(cast(tpares4 as decimal(7)),0) as tp4,
ifnull(cast(tpesos4 as decimal(7,2)),0) as tpe4,
ifnull(cast(tpares5 as decimal(7)),0) as tp5,
ifnull(cast(tpesos5 as decimal(7,2)),0) as tpe5,
ifnull(cast(tpares6 as decimal(7)),0) as tp6,
ifnull(cast(tpesos6 as decimal(7,2)),0) as tpe6,
ifnull(cast(tpares7 as decimal(7)),0) as tp7,
ifnull(cast(tpesos7 as decimal(7,2)),0) as tpe7,
ifnull(tpares1,0)+ifnull(tpares2,0)+ifnull(tpares3,0)+ifnull(tpares4,0)+ifnull(tpares5,0)+ifnull(tpares6,0)+ifnull(tpares7,0) as total_pares,
cast(ifnull(tpesos1,0)+ifnull(tpesos2,0)+ifnull(tpesos3,0)+ifnull(tpesos4,0)+ifnull(tpesos5,0)+ifnull(tpesos6,0)+ifnull(tpesos7,0)as decimal (10,2))  as total_pesos
FROM
costomanoobratemp
order by depto asc "
                    . " ", false);


            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
