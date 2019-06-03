<?php

class CapturaFraccionesParaNomina extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->model('Empleados_model')->helper('credencial_helper')->helper('file');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'NOMINAS') {
                        $this->load->view('vMenuNominas');
                    } else if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }//Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuNominas');
                    }
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vEmpleados')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getEstados() {
        try {
            print json_encode($this->Empleados_model->getEstados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDepartamentos() {
        try {
            print json_encode($this->Empleados_model->getDepartamentos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Empleados_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadoByID() {
        try {
            print json_encode($this->Empleados_model->getEmpleadoByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimo() {
        try {
            print json_encode($this->Empleados_model->getUltimo());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            $data["Registro"] = Date('d/m/Y h:i:s a');
            $data["Estatus"] = 'ACTIVO';
            $ID = $this->Empleados_model->onAgregar($data);
            $Foto = $this->input->post('Foto');
            if (empty($Foto)) {
                if ($_FILES["Foto"]["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/Empleados';
                    $master_url = $URL_DOC . '/';
                    if (isset($_FILES["Foto"]["name"])) {
                        if (!file_exists($URL_DOC)) {
                            mkdir($URL_DOC, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC . '/' . $ID))) {
                            mkdir(utf8_decode($URL_DOC . '/' . $ID), 0777, true);
                        }
                        if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $URL_DOC . '/' . $ID . '/' . utf8_decode($_FILES["Foto"]["name"]))) {
                            $img = $master_url . $ID . '/' . $_FILES["Foto"]["name"];
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
                            $config['width'] = 250;
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $this->db->set('Foto', $img)->where('ID', $ID)->update('empleados');
                        } else {
                            $this->db->set('Foto', null)->where('ID', $ID)->update('empleados');
                        }
                    }
                }
            } else {
                $this->db->set('Foto', null)->where('ID', $ID)->update('empleados');
            }
            print $ID;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                //print "$key  = $v \n";
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            $this->db->where('ID', $x->post('ID'))->update("empleados", $data);
            $ID = $x->post('ID');
            $Foto = $this->input->post('Foto');
            if (empty($Foto)) {
                if ($_FILES["Foto"]["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/Empleados';
                    $master_url = $URL_DOC . '/';
                    if (isset($_FILES["Foto"]["name"])) {
                        if (!file_exists($URL_DOC)) {
                            mkdir($URL_DOC, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC . '/' . $ID))) {
                            mkdir(utf8_decode($URL_DOC . '/' . $ID), 0777, true);
                        }
                        if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $URL_DOC . '/' . $ID . '/' . utf8_decode($_FILES["Foto"]["name"]))) {
                            $img = $master_url . $ID . '/' . $_FILES["Foto"]["name"];
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
                            $config['width'] = 250;
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $this->db->set('Foto', $img)->where('ID', $ID)->update('empleados');
                        } else {
                            $this->db->set('Foto', null)->where('ID', $ID)->update('empleados');
                        }
                    }
                }
            } else {
                $this->db->set('Foto', null)->where('ID', $ID)->update('empleados');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
