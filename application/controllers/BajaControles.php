<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BajaControles extends CI_Controller {

    public function getInformacionXControl() {
        try {
            $x = $this->input->post();
            print json_encode($this->db->query("SELECT (SELECT CONCAT(C.Clave,\" \",C.RazonS) FROM clientes AS C WHERE C.Clave = P.Cliente LIMIT 1) AS Cliente, P.Pares, P.EstatusProduccion, P.stsavan, P.DeptoProduccion,IFNULL(P.ParesFacturados,0) AS ParesFacturados, CONCAT(P.Color,\" \",(SELECT CX.Descripcion FROM colores AS CX WHERE CX.Clave = P.Color AND CX.Estilo = P.Estilo LIMIT 1)) AS Color, P.Estilo FROM pedidox AS P WHERE P.Control = {$x["CONTROL"]}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDarDeBajaControl() {
        try {
            $x = $this->input->post();
            $check_existe_control = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} AND P.DeptoProduccion = 240  AND P.stsavan = 12")->result();
            if ($x['CONTROL'] !== "" && intval($check_existe_control[0]->EXISTE) >= 1) {
                $this->db->query("UPDATE controles SET EstatusProduccion = 'FACTURADO',  DeptoProduccion = 260 WHERE Control = {$x['CONTROL']};");
                $this->db->query("UPDATE pedidox SET EstatusProduccion = 'FACTURADO', stsavan = 13, DeptoProduccion = 260, Estatus = 'F', ParesFacturados = Pares  WHERE Control = {$x['CONTROL']} AND stsavan = 12 AND DeptoProduccion = 240;");
                $this->db->query("UPDATE avaprd SET fec13 = '" . Date('Y-m-d 00:00:00') . "' WHERE contped = {$x['CONTROL']};");
                $this->db->insert('avance', array(
                    'Control' => $x['CONTROL'],
                    'FechaAProduccion' => Date('d/m/Y'),
                    'Departamento' => 260,
                    'DepartamentoT' => 'FACTURADO',
                    'FechaAvance' => Date('d/m/Y'),
                    'Estatus' => 'A',
                    'Usuario' => $_SESSION["ID"],
                    'Fecha' => Date('d/m/Y'),
                    'Hora' => Date('h:i:s a'),
                    'Fraccion' => 0,
                    'modulo' => 'BJC'
                ));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
