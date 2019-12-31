<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ResourceManager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('ResourceManager_model', 'rsm');
    }

    public function getModulos() {
        try {
            print json_encode($this->db->select("M.ID, M.Modulo, M.Fecha, M.Icon, M.Ref, M.Order")
                                    ->from("modulos AS M")
                                    ->order_by('M.Order', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModulos() {
        try {
            $x = $this->input->get();
            $this->db->select("OXM.ID, M.Modulo AS MODULO, OXM.Opcion AS OPCION, 
                OXM.Fecha AS FECHA, OXM.Icon AS ICONO, OXM.Ref AS REF, 
                OXM.Order AS ORDEN, OXM.Button AS BOTON, 
                OXM.Class AS CLASE, M.ID MODULO_ID ", false)
                    ->from("opcionesxmodulo AS OXM")
                    ->join('modulos AS M', 'M.ID = OXM.Modulo');
            if ($x['MODULO'] !== '') {
                $this->db->where('M.ID', $x['MODULO']);
            }

            $data = $this->db->order_by('M.Order', 'ASC')->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getModulosX() {
        try {
            print json_encode($this->db->select("M.ID, M.Modulo, M.Fecha, M.Icon, M.Ref, M.Order")->from("modulos AS M")
                                    ->join('modulosxusuario AS MXU', 'MXU.Modulo = M.ID', 'left')
                                    ->where('MXU.Usuario', $_SESSION["ID"])
                                    ->order_by('M.Order', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModulo() {
        try {
            $USUARIO_ID = $this->session->ID;
            $selects = "F.Usuario AS INDICADOR_USUARIO , H.Usuario AS USUARIO_ITEM, I.Usuario AS USUARIO_SUBITEM, J.Usuario AS USUARIO_SUBSUBITEM, "
                    . "`B`.`Order` AS OrderB, `C`.`Order` AS OrderC, `D`.`Order` AS OrderD, `E`.`Order` AS OrderE,`J`.`ID` AS `is_subsubitem`, `I`.`ID` AS `is_subitem`, `B`.`Opcion`, `B`.`Icon`, `B`.`Ref`, `B`.`Button`, `B`.`Class`, `C`.`Item`, `C`.`Icon` AS `IconItem`, `C`.`Ref` AS `RefItem`, `C`.`Modal` AS `ItemModal`, `C`.`Backdrop` AS `ItemBackdrop`, `C`.`Dropdown` AS `ItemDropdown`, (CASE WHEN C.Function IS NULL THEN 0 ELSE C.Function END) AS Function, `C`.`Trigger`, `D`.`SubItem` AS `SubItem`, `D`.`Icon` AS `IconSubItem`, `D`.`Ref` AS `RefSubItem`, `D`.`Modal` AS `SubItemModal`, `D`.`Backdrop` AS `SubItemBackdrop`, `D`.`Dropdown` AS `SubItemDropdown`, (CASE WHEN D.Function IS NULL THEN 0 ELSE D.Function END) AS FunctionSubItem, `D`.`Trigger` AS `TriggerSubItem`, `E`.`SubSubItem` AS `SubSubItem`, `E`.`Icon` AS `IconSubSubItem`, `E`.`Ref` AS `RefSubSubItem`, `E`.`Modal` AS `SubSubItemModal`, `E`.`Backdrop` AS `SubSubItemBackdrop`, J.Usuario AS PERTENECE_SUBSUBITEM";
            $lefts = "LEFT JOIN `opcionesxmodulo` AS `B` ON `A`.`ID` = `B`.`Modulo`
                                        LEFT JOIN `itemsxopcion` AS `C` ON `B`.`ID` = `C`.`Opcion`
                                        LEFT JOIN `subitemsxitem` AS `D` ON `C`.`ID` = `D`.`Item`
                                        LEFT JOIN `subsubitemxsubitem` AS `E` ON `D`.`ID` = `E`.`SubItem`
                                        LEFT JOIN `modulosxusuario` AS `F` ON `A`.`ID` = `F`.`Modulo`";
//                $wheres = "WHERE `B`.`Modulo` = '{$this->input->post('MOD')}'
//                                        AND `F`.`Usuario` = '{$this->session->ID}'
//                                        AND `G`.`Usuario` = '{$this->session->ID}'
//                                        AND `H`.`Usuario` = '{$this->session->ID}'
//                                        AND `I`.`Usuario` = '{$this->session->ID}'
//                                        AND `J`.`Usuario` = '{$this->session->ID}'";
            $wheres = "WHERE `B`.`Modulo` = '{$this->input->post('MOD')}'
                                        AND `F`.`Usuario` = '{$USUARIO_ID}'
                                        AND `G`.`Usuario` = '{$USUARIO_ID}'
                                        AND `H`.`Usuario` = '{$USUARIO_ID}'";

            $orders = "ORDER BY `OrderB` IS NULL ASC, `OrderB` ASC, `OrderC` IS NULL ASC,  `OrderC` ASC, `OrderD` IS NULL ASC,`OrderD` ASC, `OrderE` IS NULL ASC,`OrderE` ASC";
            $mnus = $this->db->query("SELECT $selects 
                                        FROM `modulos` AS `A`
                                        $lefts

                                        LEFT JOIN `opcionesxmoduloxusuario` AS `G` ON `A`.`ID` = `G`.`Modulo` AND `B`.`ID` = `G`.`Opcion` 
                                        LEFT JOIN `itemsxopcionxmoduloxusuario` AS `H` ON `A`.`ID` = `H`.`Modulo` AND `B`.`ID` = `H`.`Opcion` AND `C`.`ID` = `H`.`Item`
                                        LEFT JOIN `subitemsxitemxopcionxmoduloxusuario` AS `I` ON `A`.`ID` = `I`.`Modulo` AND `B`.`ID` = `I`.`Opcion` AND `C`.`ID` = `I`.`Item` AND `I`.`SubItem`  = `D`.`ID`
                                        LEFT JOIN `subsubitemsxitemxopcionxmoduloxusuario` AS `J` ON `A`.`ID` = `J`.`Modulo` AND `B`.`ID` = `J`.`Opcion` AND `C`.`ID` = `J`.`Item` AND `J`.`SubItem` = `D`.`ID` AND `J`.`SubSubItem` = `E`.`ID` AND `J`.`Usuario` = `I`.`Usuario` 
                                        $wheres
                                        UNION
                                        SELECT DISTINCT 
                                        $selects
                                        FROM `modulos` AS `A`
                                        $lefts
                                        
                                        LEFT JOIN `opcionesxmoduloxusuario` AS `G` ON `A`.`ID` = `G`.`Modulo` AND `B`.`ID` = `G`.`Opcion` AND B.Button = 1
                                        LEFT JOIN `itemsxopcionxmoduloxusuario` AS `H` ON `A`.`ID` = `H`.`Modulo` AND  B.Button = 1
                                        LEFT JOIN `subitemsxitemxopcionxmoduloxusuario` AS `I` ON `A`.`ID` = `I`.`Modulo`   AND B.Button = 1
                                        LEFT JOIN `subsubitemsxitemxopcionxmoduloxusuario` AS `J` ON `A`.`ID` = `J`.`Modulo` AND   B.Button = 1
                                        $wheres 
                                        $orders")->result();
//            print $this->db->last_query();
//            exit(0);
            print json_encode($mnus);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAccesosDirectosXModulo() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT AD.ID, AD.Modulo, AD.Nombre, 
                AD.Fecha, AD.Icon, AD.Ref, AD.`Order` FROM accesos_directos AS AD 
                INNER JOIN accesos_directos_x_usuario AS ADU ON AD.ID = ADU.Acceso_directo 
                WHERE AD.Modulo = {$x["MODULO"]} AND ADU.Usuario = {$x["USUARIO"]} ORDER BY AD.Order ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarModulo() {
        try {
            $x = $this->input->post();
//            var_dump($x);
//            exit(0);
            switch ($x['NUEVO']) {
                case 0:
                    $this->db->set('Modulo', $x['MODULO'])
                            ->set('Icon', strtolower($x['ICONO']))
                            ->set('Ref', $x['REFERENCIA'])
                            ->set('Order', $x['ORDEN'])
                            ->where('ID', $x['ID'])
                            ->update('modulos');
                    break;
                case 1:
                    $this->db->insert("modulos",
                            array("Modulo" => $x['MODULO'],
                                "Fecha" => Date('d/m/Y'),
                                "Icon" => strtolower($x['ICONO']),
                                "Ref" => $x['REFERENCIA'],
                                "Order" => $x['ORDEN']));
                    print json_encode(array("REGISTRO" => 1));
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarOpcionXModulo() {
        try {
            $x = $this->input->post();
            switch (intval($x['NUEVO'])) {
                case 0:
                    $this->db->set('Modulo', $x['MODULO'])
                            ->set('Opcion', $x['NOMBRE_OPCION'])
                            ->set('Icon', strtolower($x['ICONO_OPCION']))
                            ->set('Ref', $x['REFERENCIA_OPCION'])
                            ->set('Order', $x['ORDEN_OPCION'])
                            ->where('ID', $x['ID'])
                            ->update('opcionesxmodulo');
                    break;
                case 1:
                    $this->db->insert("opcionesxmodulo",
                            array(
                                "Modulo" => $x['MODULO'],
                                "Opcion" => $x['NOMBRE_OPCION'],
                                "Fecha" => Date('d/m/Y'),
                                "Icon" => strtolower($x['ICONO_OPCION']),
                                "Ref" => $x['REFERENCIA_OPCION'],
                                "Order" => $x['ORDEN_OPCION'],
                                "Button" => $x['BOTON'],
                                "Class" => $x['CLASECSS']));
                    print json_encode(array("REGISTRO" => 1));
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoOrdenXM() {
        try {
            $this->db->select("(M.Order + 1) AS ULTIMO_ORDEN ", false)
                    ->from("modulos AS M")->order_by("M.Order", "DESC")->limit(1);
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoOrdenOXM() {
        try {
            $x = $this->input->get();
            $this->db->select("(M.Order + 1) AS ULTIMO_ORDEN ", false)
                    ->from("opcionesxmodulo AS M");
            if ($x['MODULO'] !== '') {
                $this->db->where("M.Modulo", $x['MODULO']);
            }
            $this->db->order_by("M.Order", "DESC")->limit(1);
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoOrdenIXOXM() {
        try {
            $x = $this->input->get();
            $this->db->select("IFNULL((A.Order + 1),1) AS ULTIMO_ORDEN ", false)
                    ->from("itemsxopcion AS A")->join("opcionesxmodulo AS B", "A.Opcion = B.ID");
            if ($x['MODULO'] !== '') {
                $this->db->where("B.Modulo", $x['MODULO']);
            }
            if ($x['OPCION'] !== '') {
                $this->db->where("A.Opcion", $x['OPCION']);
            }
            $data = $this->db->order_by("A.Order", "DESC")->limit(1)->get()->result();

            if (isset($data[0]->ULTIMO_ORDEN)) {
                print json_encode($data);
            } else {
                print json_encode(array(array("ULTIMO_ORDEN" => "1")));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getModulosGenerales() {
        try {
            print json_encode($this->db->select("M.ID AS ID, M.Modulo AS MODULO, "
                                            . "M.Fecha AS FECHA, M.Icon AS ICONO, "
                                            . "M.Ref AS REF, M.Order AS ORDEN")
                                    ->from("modulos AS M")
                                    ->order_by('M.Order', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarModuloByID() {
        try {
            $x = $this->input->post();
//            var_dump($x);
//            exit(0);
            $this->db->query("DELETE FROM modulos WHERE ID = {$x['ID']}");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarOpcionXModuloByID() {
        try {
            $x = $this->input->post();
            $this->db->query("DELETE FROM opcionesxmodulo WHERE ID = {$x['ID']}");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getItemsXOpcionesXModulos() {
        try {
            $x = $this->input->get();
            $span_ok = '<span class=\"fa fa-check\" style=\"color: #8BC34A !important;\"></span>';
            $span_nook = '<span class=\"fa fa-times\" style=\"color: #F44336 !important;\"></span>';

            $this->db->select("A.ID, C.ID AS MODULO_ID, C.Modulo AS MODULO, B.Opcion AS OPCION, "
                            . "A.Opcion AS OPCION_ID, A.Item AS ITEM, A.Fecha AS FECHA, "
                            . "A.Icon AS ICONOX, CONCAT('') AS ICONO, A.Ref AS REF, "
                            . "(CASE WHEN A.Modal = 1 THEN '{$span_ok}' ELSE '{$span_nook}' END) AS MODAL, A.Modal AS ESMODAL, "
                            . "(CASE WHEN A.Backdrop = 1 THEN '{$span_ok}' ELSE '{$span_nook}' END)AS BACKDROP, A.Backdrop AS TIENEBACKDROP, "
                            . "(CASE WHEN A.Dropdown = 1 THEN '{$span_ok}' ELSE '{$span_nook}' END) AS DROPDOWN, A.Dropdown AS ESDROPDOWN, "
                            . "(CASE WHEN A.Function = 1 THEN '{$span_ok}' ELSE '{$span_nook}' END) AS FUNCION, A.Function AS ESFUNCION, "
                            . "CONCAT('<span class=\"font-weight-bold\">',A.`Order`,'</span>') AS ORDEN, A.`Trigger` AS \"TRIGGER\"", false)
                    ->from("itemsxopcion AS A")->join("opcionesxmodulo AS B", "A.Opcion = B.ID")
                    ->join("modulos AS C", "B.Modulo = C.ID");
            if ($x['OPCION'] !== '') {
                $this->db->where('B.ID', $x['OPCION']);
            }
            if ($x['MODULO'] !== '') {
                $this->db->where('C.ID', $x['MODULO']);
            }
            $data = $this->db->order_by('C.ID', 'ASC')->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModuloX() {
        try {
            $x = $this->input->get();
            $this->db->select("A.ID, B.Modulo, A.Opcion", false)->from("opcionesxmodulo AS A")
                    ->join("modulos AS B", "A.Modulo = B.ID");
            if ($x['MODULO'] !== '') {
                $this->db->where("B.ID", $x['MODULO']);
            }
            $data = $this->db->order_by("B.ID", "ASC")->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
