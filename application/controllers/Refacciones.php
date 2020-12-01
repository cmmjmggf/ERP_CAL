<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Refacciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
            var_dump($_FILES);
            EXIT(0);
            $check_refaccion = $this->db->query("SELECT COUNT(*) AS EXISTE FROM refacciones AS R WHERE R.Codigo = {$x['CODIGO']} OR R.Descripcion ='{$x['DESCRIPCION']}'")->result();
            if (intval($check_refaccion[0]->EXISTE) === 0) {
                $this->db->insert('refacciones', array(
                    'Codigo' => $x['CODIGO'], 'Descripcion' => $x['DESCRIPCION'],
                    'FechaAlta' => $x['FECHA_ALTA'], 'Costo' => $x['COSTO'],
                    'Departamento' => $x['DEPARTAMENTO'],
                    'DepartamentoT' => $x['DEPARTAMENTOT'],
                    'ProveedorUno' => $x['PROVEEDOR_UNO'],
                    'ProveedorUnoT' => $x['PROVEEDOR_UNOT'],
                    'ProveedorDos' => $x['PROVEEDOR_DOS'],
                    'ProveedorDosT' => $x['PROVEEDOR_DOST'],
                    'ProveedorTres' => $x['PROVEEDOR_TRES'],
                    'ProveedorTresT' => $x['PROVEEDOR_TREST']
                ));
                /* AGREGAR FOTOS REFACCIONES */
                foreach ($_FILES as $k => $v) {
                    $temp = explode(".", $v["name"]);
                    if ($v["tmp_name"] !== "") {
                        $URL_DOC = 'uploads/Refacciones';
                        $URL_DOC_ID = "uploads/Refacciones/{$x['CODIGO']}";
                        $master_url = $URL_DOC_ID . '/';
                        if (isset($v["name"])) {
                            if (!file_exists($URL_DOC)) {
                                mkdir($URL_DOC, 0777, true);
                            }
                            if (!file_exists(
                                            utf8_decode($URL_DOC))) {
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
                                $this->db->insert("refacciones_fotos", array('url' => $img, 'RefaccionID' => $x['CODIGO']));
                            }
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoCodigo() {
        try {
            print json_encode($this->db->query("SELECT IFNULL(R.Codigo, 1) AS CODIGO,COUNT(*) AS N FROM refacciones AS R ORDER BY R.Codigo DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRefacciones() {
        try {
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
