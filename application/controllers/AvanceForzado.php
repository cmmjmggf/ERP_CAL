<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AvanceForzado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function onAvanzarControl() {
        try {
            $x = $this->input->post();
            switch ($this->session->TipoAcceso) {
                case 'SUPER ADMINISTRADOR':
                    $control_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P WHERE P.Control =" . $x['CONTROL'] . " AND P.EstatusProduccion NOT IN('TERMINADO','FACTURADO','CANCELADO','TERMINADO') AND P.DeptoProduccion NOT IN(240,250,260,270) AND P.stsavan NOT IN(12,13,14)")->result();
                    if (intval($control_existe[0]->EXISTE) === 1) {
                        
                    }
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ControlExiste() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT COUNT(*) AS EXISTE, "
                    . "P.Control, (SELECT CONCAT(E.Clave,' ',E.Descripcion) FROM estilos AS E WHERE E.Clave = P.Estilo LIMIT 1) AS Estilo, (SELECT CONCAT(C.Clave,' ',C.Descripcion) FROM colores AS C WHERE C.Clave = P.Color AND C.Estilo = P.Estilo LIMIT 1) AS Color, "
                    . "CONCAT(P.Pares,' PARES') AS Pares, CONCAT(P.ParesFacturados, ' PARES FACTURADOS' ) AS ParesFacturados, P.EstatusProduccion, "
                    . "(select CONCAT(C.Clave,' ',C.RazonS) from clientes AS C WHERE C.Clave = P.Cliente LIMIT 1) AS Cliente FROM pedidox AS P WHERE P.Control =" . $x['CONTROL'] . " AND P.EstatusProduccion NOT IN('TERMINADO','FACTURADO','CANCELADO','TERMINADO') AND P.DeptoProduccion NOT IN(240,250,260,270) AND P.stsavan NOT IN(12,13,14)")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
