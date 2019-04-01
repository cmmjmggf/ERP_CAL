<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class ResourceManager_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getModulos() {
        try {
            return $this->db->select("M.ID, M.Modulo, M.Fecha, M.Icon, M.Ref")->from("modulos AS M")
                            ->join('modulosxusuario AS MXU', 'MXU.Modulo = M.ID', 'left')
                            ->where('MXU.Usuario', $_SESSION["ID"])
                            ->order_by('M.Order', 'ASC')->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOpcionesXModulo($M) {
        try {
            if (isset($_SESSION["ID"])) {
               return $this->db->query("(SELECT `J`.`ID` AS `is_subsubitem`, `I`.`ID` AS `is_subitem`, `B`.`Opcion`, `B`.`Icon`, `B`.`Ref`, `B`.`Button`, `B`.`Class`, `C`.`Item`, `C`.`Icon` AS `IconItem`, `C`.`Ref` AS `RefItem`, `C`.`Modal` AS `ItemModal`, `C`.`Backdrop` AS `ItemBackdrop`, `C`.`Dropdown` AS `ItemDropdown`, (CASE WHEN C.Function IS NULL THEN 0 ELSE C.Function END) AS Function, `C`.`Trigger`, `D`.`SubItem` AS `SubItem`, `D`.`Icon` AS `IconSubItem`, `D`.`Ref` AS `RefSubItem`, `D`.`Modal` AS `SubItemModal`, `D`.`Backdrop` AS `SubItemBackdrop`, `D`.`Dropdown` AS `SubItemDropdown`, (CASE WHEN D.Function IS NULL THEN 0 ELSE D.Function END) AS FunctionSubItem, `D`.`Trigger` AS `TriggerSubItem`, `E`.`SubSubItem` AS `SubSubItem`, `E`.`Icon` AS `IconSubSubItem`, `E`.`Ref` AS `RefSubSubItem`, `E`.`Modal` AS `SubSubItemModal`, `E`.`Backdrop` AS `SubSubItemBackdrop`
                                        FROM `modulos` AS `A`
                                        LEFT JOIN `opcionesxmodulo` AS `B` ON `A`.`ID` = `B`.`Modulo`
                                        LEFT JOIN `itemsxopcion` AS `C` ON `B`.`ID` = `C`.`Opcion`
                                        LEFT JOIN `subitemsxitem` AS `D` ON `C`.`ID` = `D`.`Item`
                                        LEFT JOIN `subsubitemxsubitem` AS `E` ON `D`.`ID` = `E`.`SubItem`
                                        LEFT JOIN `modulosxusuario` AS `F` ON `A`.`ID` = `F`.`Modulo`

                                        LEFT JOIN `opcionesxmoduloxusuario` AS `G` ON `A`.`ID` = `G`.`Modulo` AND `B`.`ID` = `G`.`Opcion` 
                                        LEFT JOIN `itemsxopcionxmoduloxusuario` AS `H` ON `A`.`ID` = `H`.`Modulo` AND `B`.`ID` = `H`.`Opcion` AND `C`.`ID` = `H`.`Item`
                                        LEFT JOIN `subitemsxitemxopcionxmoduloxusuario` AS `I` ON `A`.`ID` = `I`.`Modulo` AND `B`.`ID` = `I`.`Opcion` AND `C`.`ID` = `I`.`Item` AND `I`.`SubItem`  = `D`.`ID`
                                        LEFT JOIN `subsubitemsxitemxopcionxmoduloxusuario` AS `J` ON `A`.`ID` = `J`.`Modulo` AND `B`.`ID` = `J`.`Opcion` AND `C`.`ID` = `J`.`Item` AND `J`.`SubItem` = `D`.`ID` AND `J`.`SubSubItem` = `E`.`ID`
                                        WHERE `B`.`Modulo` = '{$M}'
                                        AND `F`.`Usuario` = '{$_SESSION["ID"]}'
                                        AND `G`.`Usuario` = '{$_SESSION["ID"]}'
                                        AND `H`.`Usuario` = '{$_SESSION["ID"]}'
                                        ORDER BY `B`.`Order` ASC, `C`.`Order` ASC, `D`.`Order` ASC, `E`.`Order` ASC)
                                        UNION
                                        (SELECT distinct 
                                        `J`.`ID` AS `is_subsubitem`, `I`.`ID` AS `is_subitem`, `B`.`Opcion`, `B`.`Icon`, `B`.`Ref`, `B`.`Button`, `B`.`Class`, `C`.`Item`, `C`.`Icon` AS `IconItem`, `C`.`Ref` AS `RefItem`, `C`.`Modal` AS `ItemModal`, `C`.`Backdrop` AS `ItemBackdrop`, `C`.`Dropdown` AS `ItemDropdown`, (CASE WHEN C.Function IS NULL THEN 0 ELSE C.Function END) AS Function, `C`.`Trigger`, `D`.`SubItem` AS `SubItem`, `D`.`Icon` AS `IconSubItem`, `D`.`Ref` AS `RefSubItem`, `D`.`Modal` AS `SubItemModal`, `D`.`Backdrop` AS `SubItemBackdrop`, `D`.`Dropdown` AS `SubItemDropdown`, (CASE WHEN D.Function IS NULL THEN 0 ELSE D.Function END) AS FunctionSubItem, `D`.`Trigger` AS `TriggerSubItem`, `E`.`SubSubItem` AS `SubSubItem`, `E`.`Icon` AS `IconSubSubItem`, `E`.`Ref` AS `RefSubSubItem`, `E`.`Modal` AS `SubSubItemModal`, `E`.`Backdrop` AS `SubSubItemBackdrop`
                                        FROM `modulos` AS `A`
                                        LEFT JOIN `opcionesxmodulo` AS `B` ON `A`.`ID` = `B`.`Modulo`
                                        LEFT JOIN `itemsxopcion` AS `C` ON `B`.`ID` = `C`.`Opcion`
                                        LEFT JOIN `subitemsxitem` AS `D` ON `C`.`ID` = `D`.`Item`
                                        LEFT JOIN `subsubitemxsubitem` AS `E` ON `D`.`ID` = `E`.`SubItem`
                                        LEFT JOIN `modulosxusuario` AS `F` ON `A`.`ID` = `F`.`Modulo`
                                        LEFT JOIN `opcionesxmoduloxusuario` AS `G` ON `A`.`ID` = `G`.`Modulo` AND `B`.`ID` = `G`.`Opcion` AND B.Button = 1
                                        LEFT JOIN `itemsxopcionxmoduloxusuario` AS `H` ON `A`.`ID` = `H`.`Modulo` AND  B.Button = 1
                                        LEFT JOIN `subitemsxitemxopcionxmoduloxusuario` AS `I` ON `A`.`ID` = `I`.`Modulo`   AND B.Button = 1
                                        LEFT JOIN `subsubitemsxitemxopcionxmoduloxusuario` AS `J` ON `A`.`ID` = `J`.`Modulo` AND   B.Button = 1
                                        WHERE `B`.`Modulo` = '{$M}'
                                        AND `F`.`Usuario` = '{$_SESSION["ID"]}'
                                        AND `G`.`Usuario` = '{$_SESSION["ID"]}'
                                        AND `H`.`Usuario` = '{$_SESSION["ID"]}'
                                        ORDER BY `B`.`Order` ASC, `C`.`Order` ASC, `D`.`Order` ASC, `E`.`Order` ASC)")->result();     
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
