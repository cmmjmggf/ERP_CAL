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
            print json_encode($this->rsm->getModulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModulo() {
        try {
//            print json_encode($this->rsm->getOpcionesXModulo($this->input->post('MOD')));
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

    public function onNuevoModulo() {
        try {
            $x = $this->input->post();
            $this->db->insert("modulos",
                    array("Modulo" => $x['MODULO'],
                        "Fecha" => Date('d/m/Y'),
                        "Icon" => $x['ICONO'],
                        "Ref" => $x['REFERENCIA'],
                        "Order" => $x['ORDEN']));
            print json_encode(array("REGISTRO" => 1));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onNuevaOpcionXModulo() {
        try {
            $x = $this->input->post();
            $this->db->insert("opcionesxmodulo",
                    array(
                        "Modulo" => $x['MODULO'],
                        "Opcion" => $x['NOMBRE_OPCION'],
                        "Fecha" => Date('d/m/Y'),
                        "Icon" => $x['ICONO_OPCION'],
                        "Ref" => $x['REFERENCIA_OPCION'],
                        "Order" => $x['ORDEN_OPCION'],
                        "Button" => $x['BOTON'],
                        "Class" => $x['CLASECSS']));
            print json_encode(array("REGISTRO" => 1));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
