<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Estilos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')
                ->model('Estilos_model')
                ->model('Hormas_model')
                ->model('Generos_model')
                ->model('Maquilas_model')
                ->model('Maqplantillas_model')
                ->model('Temporadas_model')
                ->model('Lineas_model')
                ->model('Series_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');


            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
//Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas');
                    }
//Cuando no viene de ningun modulo y lo teclean
                    else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vEstilos');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getEstilosSelect() {
        try {
            extract($this->input->post());
            $data = $this->Estilos_model->getEstilos();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas() {
        try {
            extract($this->input->post());
            $data = $this->Lineas_model->getLineas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave() {
        try {
            print json_encode($this->Estilos_model->onComprobarClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getHormas() {
        try {
            extract($this->input->post());
            $data = $this->Hormas_model->getHormas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGeneros() {
        try {
            extract($this->input->post());
            $data = $this->Generos_model->getGeneros();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTemporadas() {
        try {
            extract($this->input->post());
            $data = $this->Temporadas_model->getTemporadas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaquilas() {
        try {
            extract($this->input->post());
            $data = $this->Maquilas_model->getMaquilas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMaqPlantillas() {
        try {
            extract($this->input->post());
            $data = $this->Maqplantillas_model->getMaqPlantillas();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSeries() {
        try {
            extract($this->input->post());
            $data = $this->Series_model->getSeries();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            print json_encode($this->Estilos_model->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloByID() {
        try {
            print json_encode($this->Estilos_model->getEstiloByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloByClave() {
        try {
            print json_encode($this->Estilos_model->getEstiloByClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $ID = $this->Estilos_model->onAgregar(array(
                'Clave' => ($x->post('Clave') !== NULL) ? $x->post('Clave') : NULL,
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Linea' => ($x->post('Linea') !== NULL) ? $x->post('Linea') : NULL,
                'Horma' => ($x->post('Horma') !== NULL) ? $x->post('Horma') : NULL,
                'FechaAlta' => ($x->post('FechaAlta') !== NULL) ? $x->post('FechaAlta') : NULL,
                'FechaBaja' => NULL,
                'Genero' => ($x->post('Genero') !== NULL) ? $x->post('Genero') : NULL,
                'GdoDif' => ($x->post('GdoDif') !== NULL) ? $x->post('GdoDif') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Corrida' => ($x->post('Corrida') !== NULL) ? $x->post('Corrida') : NULL,
                'ConsumoPiel' => ($x->post('ConsumoPiel') !== NULL) ? $x->post('ConsumoPiel') : NULL,
                'ConsumoForro' => ($x->post('ConsumoForro') !== NULL) ? $x->post('ConsumoForro') : NULL,
                'PiezasCorte' => ($x->post('PiezasCorte') !== NULL) ? $x->post('PiezasCorte') : NULL,
                'GolpesCortePiel' => ($x->post('GolpesCortePiel') !== NULL) ? $x->post('GolpesCortePiel') : NULL,
                'GolpesCorteForro' => ($x->post('GolpesCorteForro') !== NULL) ? $x->post('GolpesCorteForro') : NULL,
                'CmPespunte' => ($x->post('CmPespunte') !== NULL) ? $x->post('CmPespunte') : NULL,
                'CmRebajado' => ($x->post('CmRebajado') !== NULL) ? $x->post('CmRebajado') : NULL,
                'Liberado' => ($x->post('Liberado') !== NULL) ? $x->post('Liberado') : NULL,
                'Costos' => ($x->post('Costos') !== NULL) ? $x->post('Costos') : NULL,
                'Herramental' => ($x->post('Herramental') !== NULL) ? $x->post('Herramental') : NULL,
                'Maquila' => ($x->post('Maquila') !== NULL) ? $x->post('Maquila') : NULL,
                'Observaciones' => ($x->post('Observaciones') !== NULL) ? $x->post('Observaciones') : NULL,
                'Ano' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL,
                'Temporada' => ($x->post('Temporada') !== NULL) ? $x->post('Temporada') : NULL,
                'PuntoCentral' => ($x->post('PuntoCentral') !== NULL) ? $x->post('PuntoCentral') : NULL,
                'EstatusEstilo' => ($x->post('EstatusEstilo') !== NULL) ? $x->post('EstatusEstilo') : NULL,
                'MaqPlant1' => ($x->post('MaqPlant1') !== NULL) ? $x->post('MaqPlant1') : NULL,
                'MaqPlant2' => ($x->post('MaqPlant2') !== NULL) ? $x->post('MaqPlant2') : NULL,
                'MaqPlant3' => ($x->post('MaqPlant3') !== NULL) ? $x->post('MaqPlant3') : NULL,
                'MaqPlant4' => ($x->post('MaqPlant4') !== NULL) ? $x->post('MaqPlant4') : NULL,
                'TipoConstruccion' => ($x->post('TipoConstruccion') !== NULL) ? $x->post('TipoConstruccion') : NULL,
                'Estatus' => 'ACTIVO'
            ));
            $AdjuntoP = $this->input->post('Foto');
            if (empty($AdjuntoP)) {
                if ($_FILES["Foto"]["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/Estilos';
                    $master_url = $URL_DOC . '/';
                    if (isset($_FILES["Foto"]["name"])) {
                        if (!file_exists($URL_DOC)) {
                            mkdir($URL_DOC, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC))) {
                            mkdir(utf8_decode($URL_DOC), 0777, true);
                        }
                        if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $URL_DOC . '/' . utf8_decode($_FILES["Foto"]["name"]))) {
                            $img = $master_url . $_FILES["Foto"]["name"];
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
                            $config['width'] = 800;
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $DATA = array(
                                'Foto' => ($img),
                            );
                            $this->Estilos_model->onModificar($ID, $DATA);
                        } else {
                            $DATA = array(
                                'Foto' => (null),
                            );
                            $this->Estilos_model->onModificar($ID, $DATA);
                        }
                    }
                }
            } else {
                $DATA = array(
                    'Foto' => (null),
                );
                $this->trabajo_model->onModificar($ID, $DATA);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $this->Estilos_model->onModificar($x->post('ID'), array(
                'Descripcion' => ($x->post('Descripcion') !== NULL) ? $x->post('Descripcion') : NULL,
                'Linea' => ($x->post('Linea') !== NULL) ? $x->post('Linea') : NULL,
                'Horma' => ($x->post('Horma') !== NULL) ? $x->post('Horma') : NULL,
                'FechaBaja' => ($x->post('FechaBaja') !== NULL) ? $x->post('FechaBaja') : NULL,
                'Genero' => ($x->post('Genero') !== NULL) ? $x->post('Genero') : NULL,
                'GdoDif' => ($x->post('GdoDif') !== NULL) ? $x->post('GdoDif') : NULL,
                'Serie' => ($x->post('Serie') !== NULL) ? $x->post('Serie') : NULL,
                'Corrida' => ($x->post('Corrida') !== NULL) ? $x->post('Corrida') : NULL,
                'ConsumoPiel' => ($x->post('ConsumoPiel') !== NULL) ? $x->post('ConsumoPiel') : NULL,
                'ConsumoForro' => ($x->post('ConsumoForro') !== NULL) ? $x->post('ConsumoForro') : NULL,
                'PiezasCorte' => ($x->post('PiezasCorte') !== NULL) ? $x->post('PiezasCorte') : NULL,
                'GolpesCortePiel' => ($x->post('GolpesCortePiel') !== NULL) ? $x->post('GolpesCortePiel') : NULL,
                'GolpesCorteForro' => ($x->post('GolpesCorteForro') !== NULL) ? $x->post('GolpesCorteForro') : NULL,
                'CmPespunte' => ($x->post('CmPespunte') !== NULL) ? $x->post('CmPespunte') : NULL,
                'CmRebajado' => ($x->post('CmRebajado') !== NULL) ? $x->post('CmRebajado') : NULL,
                'Liberado' => ($x->post('Liberado') !== NULL) ? $x->post('Liberado') : NULL,
                'Costos' => ($x->post('Costos') !== NULL) ? $x->post('Costos') : NULL,
                'Herramental' => ($x->post('Herramental') !== NULL) ? $x->post('Herramental') : NULL,
                'Maquila' => ($x->post('Maquila') !== NULL) ? $x->post('Maquila') : NULL,
                'Observaciones' => ($x->post('Observaciones') !== NULL) ? $x->post('Observaciones') : NULL,
                'Ano' => ($x->post('Ano') !== NULL) ? $x->post('Ano') : NULL,
                'Temporada' => ($x->post('Temporada') !== NULL) ? $x->post('Temporada') : NULL,
                'PuntoCentral' => ($x->post('PuntoCentral') !== NULL) ? $x->post('PuntoCentral') : NULL,
                'EstatusEstilo' => ($x->post('EstatusEstilo') !== NULL) ? $x->post('EstatusEstilo') : NULL,
                'MaqPlant1' => ($x->post('MaqPlant1') !== NULL) ? $x->post('MaqPlant1') : NULL,
                'MaqPlant2' => ($x->post('MaqPlant2') !== NULL) ? $x->post('MaqPlant2') : NULL,
                'MaqPlant3' => ($x->post('MaqPlant3') !== NULL) ? $x->post('MaqPlant3') : NULL,
                'MaqPlant4' => ($x->post('MaqPlant4') !== NULL) ? $x->post('MaqPlant4') : NULL,
                'TipoConstruccion' => ($x->post('TipoConstruccion') !== NULL) ? $x->post('TipoConstruccion') : NULL,
            ));

            $ID = $x->post('ID');
            $AdjuntoP = $this->input->post('Foto');
            if (empty($AdjuntoP)) {
                if ($_FILES["Foto"]["tmp_name"] !== "") {
                    $URL_DOC = 'uploads/Estilos';
                    $master_url = $URL_DOC . '/';
                    if (isset($_FILES["Foto"]["name"])) {
                        if (!file_exists($URL_DOC)) {
                            mkdir($URL_DOC, 0777, true);
                        }
                        if (!file_exists(utf8_decode($URL_DOC))) {
                            mkdir(utf8_decode($URL_DOC), 0777, true);
                        }
                        if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $URL_DOC . '/' . utf8_decode($_FILES["Foto"]["name"]))) {
                            $img = $master_url . $_FILES["Foto"]["name"];
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
                            $config['width'] = 800;
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $DATA = array(
                                'Foto' => ($img),
                            );
                            $this->Estilos_model->onModificar($ID, $DATA);
                        } else {
                            $DATA = array(
                                'Foto' => (null),
                            );
                            $this->Estilos_model->onModificar($ID, $DATA);
                        }
                    }
                }
            } else {
                $DATA = array(
                    'Foto' => (null),
                );
                $this->Estilos_model->onModificar($ID, $DATA);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->Estilos_model->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
