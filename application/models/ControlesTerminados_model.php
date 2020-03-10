<?php

/**
 * Description of ControlesTerminados_model
 *
 * @author Y700
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ControlesTerminados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getControl($Control, $Maq) {
        try {
            $this->db->select("
                                CONCAT(PE.Estilo, ' - ', PE.EstiloT) AS Estilo,
                                CONCAT(PE.Color, ' - ', PE.ColorT) AS Color,
                                PE.Estilo AS  `ClaveEstilo`,
                                PE.Color AS `ClaveColor`,
                                (select linea from estilos where clave = PE.Estilo) AS `Linea`,
                                PE.Semana,
                                PE.Maquila,
                                PE.Pares,
                                CAST(ifnull(LPM.PrecioVta, 0) AS DECIMAL(5, 2)) AS Precio,
                                `PE`.`DeptoProduccion` AS `Depto`,
                                ifnull(CT.Control, '') AS Terminado
                                FROM `pedidox` `PE`
                                LEFT JOIN `listapreciosmaquilas` `LPM` ON `LPM`.`Estilo` = `PE`.`Estilo` AND `LPM`.`Color` =  `PE`.`Color` AND `LPM`.`Maq` = '$Maq'
                                LEFT JOIN `controlterm` `CT` ON `CT`.`Control` = `PE`.`Control`
                                WHERE `PE`.`Control` = '$Control' ");
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

    public function getControlesRechazados($Docto, $Maq) {
        try {
            $this->db->select("
                            CT.ID,
                            CT.Control,
                            CT.Defecto,
                            CT.Detalle,
                            CT.Maq,
                            CT.Sem,
                            CT.Docto,
                            date_format(CT.Fecha,'%d/%m/%Y') as Fecha,
                            CT.Pares "
                            . "")
                    ->from("controlcali CT")
                    ->where("CT.Maq", $Maq)
                    ->where("CT.Docto", $Docto);
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

    public function getControlesTerminados($Docto, $Maq) {
        try {
            $this->db->select("
                            CT.ID,
                            CT.control,
                            date_format(CT.fecha,'%d/%m/%Y') as fecha,
                            P.Maquila,
                            P.Semana,
                            CT.estilo,
                            CT.color,
                            CT.prevta,
                            CT.docto,
                            CT.pares, "
                            . 'CONCAT(\'<span class="fa fa-times fa-lg" '
                            . ' onclick="onEliminarDetalleByID(\',CT.control,\',\',P.Maquila,\',\',CT.sem,\',\',CT.docto,\',\',CT.pares,\')">\',\'</span>\') '
                            . 'AS Rechazar'
                            . "")
                    ->from("controlterm CT")
                    ->join("pedidox P", 'ON P.Control = CT.control')
                    ->where("P.Maquila", $Maq)
                    ->where("CT.docto", $Docto);
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

    public function getDocMaqByControlTerm($Control) {
        try {
            $this->db->select("
                            P.Maquila,
                            CT.docto "
                            . "")
                    ->from("controlterm CT")
                    ->join("pedidox P", 'ON P.Control = CT.control')
                    ->where("CT.control", $Control)->limit(1);
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

    public function onEliminarDetalleByID($Control) {
        try {
            $this->db->where('Control', $Control);
            $this->db->delete("controlterm");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlParaRechazar($Control) {
        try {
            $this->db->select("

                            D.Clave AS Depto

                            "
                            . "")
                    ->from("controles C")
                    ->join("departamentos D", 'ON D.Descripcion = C.EstatusProduccion')
                    ->where("C.Control", $Control);
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

    public function onModificarControlRechazado($Control, $Maq) {
        try {
            $Depto = ($Maq === '1') ? 'ALMACEN ADORNO' : 'ENSUELADO';
            $NumDepto = ($Maq === '1') ? '230' : '140';
            $this->db->set('DeptoProduccion', $NumDepto)->set('EstatusProduccion', $Depto)->where('Control', $Control)->update("controles");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarControlPedidos($Control, $Maq) {
        try {
            $Depto = ($Maq === '1') ? '11' : '55';
            $newDepto = ($Maq === '1') ? '240' : '140';
            $newNomDepto = ($Maq === '1') ? 'ALMACEN ADORNO' : 'ENSUELADO';
            $this->db->set('stsavan', $Depto)->where('Control', $Control)->update("pedidox");

            $this->db->set('DeptoProduccion', $newDepto)->set('EstatusProduccion', $newNomDepto)->set('stsavan', $Depto)->where('Control', $Control)->update("pedidox");
            $this->db->set('fec12', NULL)->set('status', $Depto)->where('contped', $Control)->update("avaprd");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAvanceByControl($Control) {
        try {
            $this->db->where('Departamento', 240);
            $this->db->where('Control', $Control);
            $this->db->delete("avance");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("controlterm", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarRechazado($array) {
        try {
            $this->db->insert("controlcali", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregarAvanceControl($array) {
        try {
            $this->db->insert("avance", $array);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarControl($Control, $Depto, $NumDepto, $stsavan) {
        try {
            $st_ped = 'A';
            if ($stsavan === '13') {
                $st_ped = 'F';
            }

            $this->db->set('DeptoProduccion', $NumDepto)->set('EstatusProduccion', $Depto)->where('Control', $Control)->update("controles");
            $this->db->set('DeptoProduccion', $NumDepto)->set('EstatusProduccion', $Depto)->set('stsavan', $stsavan)->set('Estatus', $st_ped)->where('Control', $Control)->update("pedidox");
            $this->db->set('fec12', Date('Y-m-d'))->set('status', $stsavan)->where('contped', $Control)->update("avaprd");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
