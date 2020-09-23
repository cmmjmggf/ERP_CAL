<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Maquinaria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('string');
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

    public function getMaquinaByID() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT M.IDE AS IDE, M.nummaq AS CODIGO, M.id AS ID, M.maq AS MAQUILA, "
                                    . "M.nommaq AS DESCRIPCION, M.marmaq AS MARCA, M.modmaq AS MODELO, "
                                    . "M.sermaq AS SERIE,M.depmaq AS DEPTO, DATE_FORMAT(M.fechaalt,\"%d/%m/%Y\") AS FECHA_ALTA, "
                                    . "M.facmaq AS FACTURA, FORMAT(M.cosmaq,2) AS COSTO, M.cosmaq AS COSTOSF, "
                                    . "M.FotoUno AS FOTO_UNO, M.FotoDos AS FOTO_DOS, M.FotoTres AS FOTO_TRES, M.FotoCuatro AS FOTO_CUATRO, "
                                    . "M.FotoCinco AS FOTO_CINCO, M.FotoSeis AS FOTO_SEIS, M.fecultma AS FECHA_ULTIMO_MANTENIMIENTO, "
                                    . "M.diasmaq AS DIAS_M, M.critisida AS CRITISIDAD, M.stsmaq AS ESTATUS_MAQ, "
                                    . "M.fecbaja AS FECHA_BAJA, M.motmaq AS MOTIVO_BAJA FROM maquinaria AS M WHERE M.IDE = {$x['IDE']}")->result());
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

    public function getUltimaIDMaquinaria() {
        try {
            print json_encode($this->db->query("SELECT A.id AS UID FROM maquinaria AS A ORDER BY id DESC LIMIT 5;")->result());
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
//                print "\n {$v["name"]}, {$v["type"]}, {$v["tmp_name"]}, {$v["size"]} - {$temp} \n \n";
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
                        $key = sha1($v["name"]);
                        $master_name = $i . "_{$key}." . end($temp);
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
//            var_dump($_FILES);
//            var_dump($x);
//            exit(0);

            $FechaUltimoMantenimientoMaquina = $x['UltimoMantenimientoMaquina'] !== '' ? $x['UltimoMantenimientoMaquina'] : Date('d/m/Y');

            $dia = substr($FechaUltimoMantenimientoMaquina, 0, 2);
            $mes = substr($FechaUltimoMantenimientoMaquina, 3, 2);
            $anio = substr($FechaUltimoMantenimientoMaquina, 6, 4);
            $UltimoMantenimientoMaquina = new DateTime();
            $UltimoMantenimientoMaquina->setDate($anio, $mes, $dia);

            $this->db->set("id", $x["IdMaquina"])
                    ->set("nommaq", $x["DescripcionMaquina"])
                    ->set("marmaq", $x["MarcaMaquina"])
                    ->set("modmaq", $x["ModeloMaquina"])
                    ->set("sermaq", $x["SerieMaquina"])
                    ->set("maq", $x["MaquilaClaveMaquina"])
                    ->set("depmaq", $x["DeptoClaveMaquina"])
                    ->set("diasmaq", $x["DiasDeMantenimientoMaquina"])
                    ->set("stsmaq", $x["EstatusMaquina"])
                    ->set("facmaq", $x["FacturaMaquina"])
                    ->set("cosmaq", $x["CostoMaquina"])
                    ->set("motmaq", $x['MotivoMaquina'])
                    ->set("critisida", $x['CriticidadMaquina'])
                    ->set("fecultma", $x['UltimoMantenimientoMaquina'] !== '' ? $UltimoMantenimientoMaquina->format('Y-m-d 00:00:00') : NULL)
                    ->where("nummaq", $x["CodigoMaquina"])
                    ->where("IDE", $x["ID"])
                    ->update("maquinaria");

            /* fotos */

            $i = 1;
            foreach ($_FILES as $k => $v) {
//                var_dump($v);
                $campo = array(1 => "FotoUno", 2 => "FotoDos", 3 => "FotoTres", 4 => "FotoCuatro", 5 => "FotoCinco", 6 => "FotoSeis");
                $temp = explode(".", $v["name"]);
//                print "\n {$v["name"]}, {$v["type"]}, {$v["tmp_name"]}, {$v["size"]} - {$temp} \n \n";
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
                        $key = sha1($v["name"]);
                        $master_name = $i . "_{$key}." . end($temp);
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
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarImagen() {
        try {
            $x = $this->input->post();
            $campo = array(1 => "FotoUno", 2 => "FotoDos", 3 => "FotoTres", 4 => "FotoCuatro", 5 => "FotoCinco", 6 => "FotoSeis");
            $this->db->set($campo[intval($x['INDICE'])], NULL)->where("IDE", $x["IDE"])->update("maquinaria");
            $imagenes = $this->db->query("SELECT M.FotoUno, M.FotoDos, M.FotoTres, M.FotoCuatro, M.FotoCinco, M.FotoSeis FROM maquinaria AS M WHERE M.IDE ={$x["IDE"]}")->result();
            $v = $imagenes[0];
            if ($v->FotoUno === NULL && $v->FotoDos !== NULL) {
                $this->db->set($campo[2], NULL)
                        ->set($campo[1], $v->FotoDos)
                        ->where("IDE", $x["IDE"])->update("maquinaria");
            }
            $imagenes = $this->db->query("SELECT  M.FotoDos, M.FotoTres FROM maquinaria AS M WHERE M.IDE ={$x["IDE"]}")->result();
            $v = $imagenes[0];
            if ($v->FotoDos === NULL && $v->FotoTres !== NULL) {
                $this->db->set($campo[3], NULL)
                        ->set($campo[2], $v->FotoTres)
                        ->where("IDE", $x["IDE"])->update("maquinaria");
            }
            $imagenes = $this->db->query("SELECT M.FotoTres, M.FotoCuatro FROM maquinaria AS M WHERE M.IDE ={$x["IDE"]}")->result();
            $v = $imagenes[0];
            if ($v->FotoTres === NULL && $v->FotoCuatro !== NULL) {
                $this->db->set($campo[4], NULL)
                        ->set($campo[3], $v->FotoCuatro)
                        ->where("IDE", $x["IDE"])->update("maquinaria");
            }
            $imagenes = $this->db->query("SELECT M.FotoCuatro, M.FotoCinco FROM maquinaria AS M WHERE M.IDE ={$x["IDE"]}")->result();
            $v = $imagenes[0];
            if ($v->FotoCuatro === NULL && $v->FotoCinco !== NULL) {
                $this->db->set($campo[5], NULL)
                        ->set($campo[4], $v->FotoCinco)
                        ->where("IDE", $x["IDE"])->update("maquinaria");
            }
            $imagenes = $this->db->query("SELECT M.FotoCinco, M.FotoSeis FROM maquinaria AS M WHERE M.IDE ={$x["IDE"]}")->result();
            $v = $imagenes[0];
            if ($v->FotoCinco === NULL && $v->FotoSeis !== NULL) {
                $this->db->set($campo[6], NULL)
                        ->set($campo[5], $v->FotoSeis)
                        ->where("IDE", $x["IDE"])->update("maquinaria");
            }
            exit(0);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarImagen() {
        try {
            $x = $this->input->post();
            $i = $x['INDICE'];
            foreach ($_FILES as $k => $v) {
                $campo = array(1 => "FotoUno", 2 => "FotoDos", 3 => "FotoTres", 4 => "FotoCuatro", 5 => "FotoCinco", 6 => "FotoSeis");
                $temp = explode(".", $v["name"]);

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
                        $key = sha1($v["name"]);
                        $master_name = $i . "_{$key}." . end($temp);
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
                            $check_images = $this->db->query("SELECT FotoUno, FotoDos, FotoTres, FotoCuatro, FotoCinco, FotoSeis FROM maquinaria as M  WHERE M.nummaq = {$x['CodigoMaquina']}")->result();
                            if ($check_images[0]->FotoUno === NULL) {
                                $this->db->set("FotoUno", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            } else
                            if ($check_images[0]->FotoDos === NULL) {
                                $this->db->set("FotoDos", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            } else
                            if ($check_images[0]->FotoTres === NULL) {
                                $this->db->set("FotoTres", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            } else
                            if ($check_images[0]->FotoCuatro === NULL) {
                                $this->db->set("FotoCuatro", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            } else
                            if ($check_images[0]->FotoCinco === NULL) {
                                $this->db->set("FotoCinco", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            } else
                            if ($check_images[0]->FotoSeis === NULL) {
                                $this->db->set("FotoSeis", $img)->where("nummaq", $x['CodigoMaquina'])->where("IDE", $x['IDE'])->update("maquinaria");
                            }
                        }
                    }
                }
            }
            exit(0);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
