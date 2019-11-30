<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs {

    private $modulo, $accion_o_mensaje, $sesion;

    public function __construct($m, $a, $s) {
        $this->sesion = $s;
        $this->modulo = $m;
        $this->accion_o_mensaje = $a;
        $this->onCreateLog();
    }

    public function getSesion() {
        return $this->sesion;
    }

    public function setSesion($sesion) {
        $this->sesion = $this->sesion;
        return $this;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function getAccion_o_mensaje() {
        return $this->accion_o_mensaje;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
        return $this;
    }

    public function setAccion_o_mensaje($accion_o_mensaje) {
        $this->accion_o_mensaje = $accion_o_mensaje;
        return $this;
    }

    public function onCreateLog() {
        /* LOG TO ACCIONS */

        $CI = & get_instance();
        $xlog = array();
        $xlog["Empresa"] = $this->sesion->Empresa;
        $xlog["Tipo"] = $this->sesion->TipoAcceso;
        $xlog["IdUsuario"] = $this->sesion->ID;
        $xlog["Usuario"] = $this->sesion->Nombre . " " . $this->sesion->Apellidos;
        $xlog["Modulo"] = strtoupper($this->getModulo());
        $xlog["Accion"] = strtoupper($this->getAccion_o_mensaje());
        $xlog["Fecha"] = Date('d/m/Y');
        $xlog["Hora"] = Date('h:i:s a');
        $xlog["Dia"] = Date('d');
        $xlog["Mes"] = Date('m');
        $xlog["Anio"] = Date('Y');
        $xlog["Registro"] = Date('d/m/Y h:i:s a');
        $xlog["Padre"] = ""; //ITEM
        $xlog["Hijo"] = ""; //SUBITEM
        $xlog["Estatus"] = 'ACTIVO';
        $CI->db->insert('logs', $xlog);
    }

}
