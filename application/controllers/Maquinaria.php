<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinaria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function getMaquinaria() {
        try {
            print json_encode($this->db->query("SELECT M.IDE AS IDE, M.nummaq AS CODIGO, M.id AS ID, M.maq AS MAQUILA, "
                                    . "M.nommaq AS DESCRIPCION, M.marmaq AS MARCA, M.modmaq AS MODELO, "
                                    . "M.sermaq AS SERIE,M.depmaq AS DEPTO, DATE_FORMAT(M.fechaalt,\"%d/%m/%Y\") AS FECHA_ALTA, "
                                    . "M.facmaq AS FACTURA, FORMAT(M.cosmaq,2) AS COSTO, M.cosmaq AS COSTOSF, "
                                    . "M.FotoUno AS FOTO_UNO, M.FotoDos AS FOTO_DOS, M.FotoTres AS FOTO_TRES, M.FotoCuatro AS FOTO_CUATRO, "
                                    . "M.FotoCinco AS FOTO_CINCO, M.FotoSeis AS FOTO_SEIS, M.fecultma AS FECHA_ULTIMO_MANTENIMIENTO, "
                                    . "M.diasmaq AS DIAS_M, M.critisida AS CRITISIDAD, M.stsmaq AS ESTATUS_MAQ, "
                                    . "M.fecbaja AS FECHA_BAJA, M.motmaq AS MOTIVO_BAJA FROM maquinaria AS M")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaMaquinaria() {
        try {
            print json_encode($this->db->query("SELECT  (M.nummaq + 1) AS ULTIMO_CODIGO FROM maquinaria AS M ORDER BY M.nummaq DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            var_dump($_FILES);
            $check_codigo_maq = $this->db->query("SELECT COUNT(*) AS EXISTE FROM maquinaria AS M WHERE M.nummaq = {$x["CodigoMaquina"]}")->result();
            if (intval($check_codigo_maq[0]->EXISTE) > 0) {
                exit(0);
            }

            $FechaAltaMaq = $x['FechaAltaMaquina'] !== '' ? $x['FechaAltaMaquina'] : Date('d/m/Y');
            $fecha = $FechaAltaMaq;
            $dia = substr($fecha, 0, 2);
            $mes = substr($fecha, 3, 2);
            $anio = substr($fecha, 6, 4);
            $nueva_fecha = new DateTime();
            $nueva_fecha->setDate($anio, $mes, $dia);

            $FechaUltimoMantenimientoMaquina = $x['UltimoMantenimientoMaquina'] !== '' ? $x['UltimoMantenimientoMaquina'] : Date('d/m/Y');

            $dia = substr($FechaUltimoMantenimientoMaquina, 0, 2);
            $mes = substr($FechaUltimoMantenimientoMaquina, 3, 2);
            $anio = substr($FechaUltimoMantenimientoMaquina, 6, 4);
            $UltimoMantenimientoMaquina = new DateTime();
            $UltimoMantenimientoMaquina->setDate($anio, $mes, $dia);


            $this->db->insert("maquinaria", array(
                "nummaq" => $x['CodigoMaquina'],
                "id" => $x['IdMaquina'],
                "nommaq" => $x['DescripcionMaquina'],
                "marmaq" => $x['MarcaMaquina'],
                "modmaq" => $x['ModeloMaquina'],
                "sermaq" => $x['SerieMaquina'],
                "depmaq" => $x['DeptoClaveMaquina'],
                "fechaalt" => $nueva_fecha->format('Y-m-d 00:00:00'),
                "fecultma" => $x['UltimoMantenimientoMaquina'] !== '' ? $UltimoMantenimientoMaquina->format('Y-m-d 00:00:00') : NULL,
                "diasmaq" => $x['DiasDeMantenimientoMaquina'],
                "stsmaq" => $x['EstatusMaquina'],
                "facmaq" => $x['FacturaMaquina'],
                "cosmaq" => $x['CostoMaquina'],
                "fecbaja" => $x['FechaBajaMaquina'] !== '' ? $x['FechaBajaMaquina'] : NULL,
                "motmaq" => $x['MotivoMaquina'],
                "critisida" => $x['CriticidadMaquina'],
                "maq" => $x['MaquilaMaquina']
            ));
            $i = 1;
            foreach ($_FILES as $k => $v) {
//                var_dump($v);
                $campo = array(1 => "FotoUno", 2 => "FotoDos", 3 => "FotoTres", 4 => "FotoCuatro", 5 => "FotoCinco", 6 => "FotoSeis");
                $temp = explode(".", $v["name"]);
                print "\n {$v["name"]}, {$v["type"]}, {$v["tmp_name"]}, {$v["size"]} - {$temp} \n \n";
                if ($v["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/Maquinaria';
                    $URL_DOC_ID = "uploads/Maquinaria/{$x['CodigoMaquina']}";
                    $master_url = $URL_DOC_ID . '/';
                    if (isset($v["name"])) {
                        if (!file_exists($URL_DOC)) {
                            mkdir($URL_DOC, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC))) {
                            mkdir(utf8_decode($URL_DOC), 0777, true);
                        }
                        if (!file_exists($URL_DOC_ID)) {
                            mkdir($URL_DOC_ID, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC_ID))) {
                            mkdir(utf8_decode($URL_DOC_ID), 0777, true);
                        }
                        $master_name = $i . "." . end($temp);
                        if (move_uploaded_file($v["tmp_name"], "{$URL_DOC_ID}/{$master_name}")) {
                            $img = "{$URL_DOC_ID}/{$master_name}";
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
                            $config['width'] = 800;
                            $config['file_ext_tolower'] = TRUE;
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $this->db->set($campo[$i], $img)->where("nummaq", $x['CodigoMaquina'])->update("maquinaria");
                        }
                    }
                }
                $i = $i + 1;
            }
            exit(0);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input->post();
            $this->db->set("id", $x["IdMaquina"])
                    ->set("nummaq", $x["CodigoMaquina"])
                    ->set("nommaq", $x["DescripcionMaquina"])
                    ->where("IDE", $x["ID"])
                    ->where("nummaq", $x["CodigoMaquina"]) 
                    ->update("maquinaria");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
