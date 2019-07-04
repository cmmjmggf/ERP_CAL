<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
    }

    public function onVerificarExiste() {
        try {
            print json_encode($this->db->query("SELECT pin FROM pin where fecha = CURDATE() and modulo = 'CLIENTES' and estatus ='ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGeneraNuevoPin() {
        try {
            $Pin = $this->input->post('PinClientes');
            $Existe = $this->db->query("SELECT pin FROM pin where fecha = CURDATE() and modulo = 'CLIENTES' and estatus ='ACTIVO' ")->result();
            $DATA = array(
                'fecha' => Date('Y-m-d'),
                'pin' => $Pin,
                'modulo' => 'CLIENTES',
                'estatus' => 'ACTIVO'
            );
            if (empty($Existe)) {
                $this->db->insert('pin', $DATA);
            } else {
                $this->db->query("update pin set pin = $Pin where fecha = CURDATE() and modulo = 'CLIENTES' and estatus ='ACTIVO' ");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
