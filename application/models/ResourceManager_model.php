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
                        $this->db->select("J.ID AS is_subsubitem, I.ID AS is_subitem, B.Opcion, B.Icon, B.Ref, B.Button, B.Class, "
                        . "C.Item, C.Icon AS IconItem, C.Ref AS RefItem, C.Modal AS ItemModal, C.Backdrop AS ItemBackdrop, C.Dropdown AS ItemDropdown,(CASE WHEN C.Function IS NULL THEN 0 ELSE C.Function END) AS Function, C.Trigger,"
                        . "D.SubItem AS SubItem, D.Icon AS IconSubItem, D.Ref AS RefSubItem, D.Modal AS SubItemModal, D.Backdrop AS SubItemBackdrop, D.Dropdown AS SubItemDropdown,(CASE WHEN D.Function IS NULL THEN 0 ELSE D.Function END) AS FunctionSubItem, D.Trigger AS TriggerSubItem,"
                        . "E.SubSubItem AS SubSubItem, E.Icon AS IconSubSubItem, E.Ref AS RefSubSubItem, E.Modal AS SubSubItemModal, E.Backdrop AS SubSubItemBackdrop")
                        ->from("modulos AS A")
                        ->join('opcionesxmodulo AS B', 'A.ID = B.Modulo', 'left')
                        ->join('itemsxopcion AS C', 'B.ID = C.Opcion', 'left')
                        ->join('subitemsxitem AS D', 'C.ID = D.Item', 'left')
                        ->join('subsubitemxsubitem AS E', 'D.ID = E.SubItem', 'left')
                        
                        ->join('modulosxusuario AS F', 'A.ID = F.Modulo', 'left')
                        ->join('opcionesxmoduloxusuario AS G', 'A.ID = G.Modulo AND B.ID = G.Opcion', 'left')
                        ->join('itemsxopcionxmoduloxusuario AS H', 'A.ID = H.Modulo AND B.ID = H.Opcion AND C.ID = H.Item', 'left')
                        ->join('subitemsxitemxopcionxmoduloxusuario AS I', 'A.ID = I.Modulo AND B.ID = I.Opcion AND C.ID = I.Item AND I.SubItem  = D.ID', 'left')
                        ->join('subsubitemsxitemxopcionxmoduloxusuario AS J', 'A.ID = J.Modulo AND B.ID = J.Opcion AND C.ID = J.Item AND J.SubItem = D.ID AND J.SubSubItem = E.ID', 'left')
                        
                        ->where('B.Modulo', $M) 
                        ->where('F.Usuario', $_SESSION["ID"])
                        ->where('G.Usuario', $_SESSION["ID"])
                        ->where('H.Usuario', $_SESSION["ID"])
                        ->order_by('B.Order', 'ASC')->order_by('C.Order', 'ASC')
                        ->order_by('D.Order', 'ASC')->order_by('E.Order', 'ASC');
                return $this->db->get()->result();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
