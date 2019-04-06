<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of producion_helper
 *
 * @author Y700
 */
class producion_helper {
    //put your code here
    public function SetEstatusProducion($param) {
             $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                        ->set('DeptoProduccion', $x->post('DEPTO'))
                        ->where('Control', $x->post('CONTROL'))->update('controles');
                $this->db->set('EstatusProduccion', $x->post('DEPTOT'))
                        ->set('DeptoProduccion', $x->post('DEPTO'))
                        ->where('Control', $x->post('CONTROL'))->update('pedidox');
            
    }
}
