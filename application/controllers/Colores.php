<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Colores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Colores_model')->model('Estilos_model');
    }

    public function index() {
//        $url = "http://frecuenciacotizador.estafeta.com/Service.asmx?WSDL";
//        try {
//            $client = new SoapClient($url);
//            $result = $client->FrecuenciaCotizador(["idusuario" => 91, "usuario" => "0", 
//                "esFrecuencia" => false,
//                "esLista" => true,
//                "tipoEnvio" =>0]);
//            var_dump($result->FrecuenciaCotizadorResult);
//            print "------------------------------------------";
//            var_dump($result->FrecuenciaCotizadorResult->Respuesta);
//        } catch (SoapFault $e) {
//            echo $e->getMessage();
//        }


        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    } else if ($Origen === 'CONSULTA') {
                        
                    }
                    //Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral')->view('vMenuFichasTecnicas');
                    break;
            }
            $this->load->view('vFondo')->view('vColores')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->Colores_model->getEstilos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            print json_encode($this->Colores_model->getPieles());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Colores_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColorByID() {
        try {
            print json_encode($this->Colores_model->getColorByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimaClave() {
        try {
            $Datos = $this->Colores_model->getUltimaClave($this->input->post('Estilo'));
            $Clave = $Datos[0]->Clave;
            if (empty($Clave)) {
                $Clave = 1;
            } else {
                $Clave = $Clave + 1;
            }

            print $Clave;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
            $check_color = $this->db->query("SELECT COUNT(*) AS EXISTE FROM colores AS C WHERE C.Clave = {$x['Clave']} AND C.Estilo = '{$x['Estilo']}'")->result();
            if(intval($check_color[0]->EXISTE) >= 1) {
                print "ESTA COMBINACIÓN YA EXISTE \n";
                exit(0);
            }
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            $this->db->insert("colores", $data);
            $query = $this->db->query('SELECT LAST_INSERT_ID()');
            $row = $query->row_array();
            $LastIdInserted = $row['LAST_INSERT_ID()'];

            $i = 1;
            foreach ($_FILES as $k => $v) {
                $temp = explode(".", $v["name"]);
                if ($v["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/EstiloColor';
                    $URL_DOC_ID = "uploads/EstiloColor";
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
                        $master_name = "{$x['Estilo']}_{$x['Clave']}." . end($temp);
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
                            $this->db->set("Foto", $img)->where("ID", $LastIdInserted)->update("colores");
                        }
                    }
                }
                $i = $i + 1;
            }
            return $LastIdInserted;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input->post();
            $i = 1;
            foreach ($_FILES as $k => $v) {
                $temp = explode(".", $v["name"]);
//                print "\n {$v["name"]}, {$v["type"]}, {$v["tmp_name"]}, {$v["size"]} - {$temp} \n \n";
                if ($v["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/EstiloColor';
                    $URL_DOC_ID = "uploads/EstiloColor";
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
                        $master_name = "{$x['Estilo']}_{$x['Clave']}." . end($temp);
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
                            $this->db->set("Foto", $img)->where("ID", $x['ID'])->update("colores");
                        }
                    }
                }
                $i = $i + 1;
            }
            $data = array();
            foreach ($x as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            $this->db->where('ID', $x['ID'])->update("colores", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Colores_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
