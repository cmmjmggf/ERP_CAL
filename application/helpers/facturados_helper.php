<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Facturados {

    public function __construct() {
        $this->onRevisarPedidosFacturados();
    }

    public function onRevisarPedidosFacturados() {
        $CI = & get_instance();
        $controles_terminados_facturados = $CI->db->query("SELECT P.ID, P.Control FROM pedidox AS P WHERE P.Pares = P.ParesFacturados AND P.stsavan = 12 AND P.DeptoProduccion = 240 AND P.EstatusProduccion = 'TERMINADO'")->result();
        foreach ($controles_terminados_facturados as $k => $v) {
            $check_terminado = $CI->db->query("SELECT COUNT(*) AS TERMINADO FROM controlterm AS C WHERE C.control = {$v->Control}")->result();
            switch (intval($check_terminado[0]->TERMINADO)) {
                case 1:
                    $EstatusProduccion = 'FACTURADO';
                    $DeptoProduccion = 260;
                    /* ACTUALIZAR  ESTATUS DE PRODUCCION  EN CONTROLES */
                    $CI->db->set('EstatusProduccion', $EstatusProduccion)
                            ->set('DeptoProduccion', $DeptoProduccion)
                            ->where('EstatusProduccion', 'TERMINADO')->where('DeptoProduccion', 240)
                            ->where('Control', $v->Control)->update('controles');
                    /* ACTUALIZAR ESTATUS DE PRODUCCION EN PEDIDOS */
                    $CI->db->where('EstatusProduccion', 'TERMINADO')
                            ->where('DeptoProduccion', 240)
                            ->where('stsavan', 12)->where('Control', $v->Control)
                            ->update('pedidox', array('stsavan' => 13,
                                'EstatusProduccion' => $EstatusProduccion,
                                'DeptoProduccion' => $DeptoProduccion,
                                'Estatus' => 'F'
                    ));
                    $CI->db->insert("avance", array(
                        'Control' => $v->Control,
                        'FechaAProduccion' => Date('d/m/Y'),
                        'Departamento' => $DeptoProduccion,
                        'DepartamentoT' => $EstatusProduccion,
                        'FechaAvance' => Date('d/m/Y'),
                        'Estatus' => 'A',
                        'Usuario' => 999,
                        'Fecha' => Date('d/m/Y'),
                        'Hora' => Date('H:i:s'),
                        'modulo' => 'FP'
                    ));
                    /* ACTUALIZAR FECHA 13 (FACTURADO) EN AVAPRD (SE HACE PARA FACILITAR LOS REPORTES) */
                    $CI->db->set('fec13', Date('Y-m-d 00:00:00'))
                            ->where('contped', $v->Control)
                            ->where('fec13 IS NULL', null, false)
                            ->update('avaprd');
                    break;
            }
        }
    }
}