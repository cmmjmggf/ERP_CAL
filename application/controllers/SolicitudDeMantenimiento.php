<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitudDeMantenimiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquinaria() {
        try {
            print json_encode($this->db->query("SELECT id,CONCAT(id,\" \",nommaq) AS nommaq FROM maquinaria")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSolicitudes() {
        try {
            print json_encode($this->db->query("
SELECT R.ID AS ID, R.codigo AS CODIGO, R.desdpro AS DESCRIPCION, 
CASE WHEN R.desdrea = 0 THEN \"\" ELSE R.desdrea END AS DESCRIPCIONREF, 
R.horalle AS HORALLEGADA,
CASE WHEN R.horae = 0 THEN \"\" ELSE R.horae END AS HORAENTRADA, 
CASE WHEN R.refa1 = 0 THEN \"\" ELSE R.refa1 END AS REFACCION_UNO, 
CASE WHEN R.cant1 = 0 THEN \"\" ELSE R.cant1 END AS CANTIDAD_UNO, 
CASE WHEN R.pre1 = 0 THEN \"\" ELSE R.pre1 END AS PRECIO_UNO, 
CASE WHEN R.refa2 = 0 THEN \"\" ELSE R.refa2 END AS REFACCION_DOS, 
CASE WHEN R.cant2 = 0 THEN \"\" ELSE R.cant2 END AS CANTIDAD_DOS, 
CASE WHEN R.pre2 = 0 THEN \"\" ELSE R.pre2 END AS PRECIO_DOS FROM repomaqui AS R;
")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
