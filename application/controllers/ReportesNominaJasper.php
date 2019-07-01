<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ReportesNominaJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onImprimirCostoMOGen() {

        $this->db->query("truncate table costomanoobratemp");
        $Ano = $this->input->post('AnoCostoMOGen');
        $Sem = $this->input->post('SemCostoMOGen');

        $RegistrosNomina = $this->db->query("
                        SELECT  p.salario,
                                p.salariod,
                                p.horext,
                                p.otrper,
                                cast(ifnull(D.Clave,'999')as signed) as numdepto,
                                ifnull(D.Descripcion,'NO EXISTE DEPTO') as nomdepto,
                                E.FijoDestajoAmbos as tiposal,
                                p.numemp
                        from prenominal p
                        join empleados E on E.numero =  p.numemp
                        left join departamentos D on E.DepartamentoFisico = D.Clave
                        where p.año = $Ano
                        and p.numsem = $Sem
                        order by  numdepto asc ")->result();

        $sql = '';
        foreach ($RegistrosNomina as $key => $v) {

            $salario = floatval($v->salario);
            $salariod = floatval($v->salariod);
            $bonos = floatval($v->horext);
            $extras = floatval($v->otrper);


            $Temp = $this->db->query("select depto from costomanoobratemp where depto = $v->numdepto ")->result();
            if (empty($Temp)) { //si no existe inserta
                $this->db->insert("costomanoobratemp", array(
                    'depto' => $v->numdepto,
                    'nombreDepto' => $v->nomdepto,
                    'salario' => $salario,
                    'salariod' => $salariod,
                    'bonos' => $bonos,
                    'extras' => $extras
                ));
            } else { // si existe acumula
                $sql = "UPDATE costomanoobratemp set "
                        . "salariod = ifnull(salariod,0) + $salariod  , "
                        . "salario = ifnull(salario,0) + $salario  , "
                        . "bonos = ifnull(bonos,0) + $bonos , "
                        . "extras =ifnull(extras,0) + $extras "
                        . "WHERE depto = $v->numdepto ";
                $this->db->query($sql);
            }
        }
        /* reporte */
    }

}
