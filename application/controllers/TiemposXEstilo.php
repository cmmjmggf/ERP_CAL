<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class TiemposXEstilo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            $this->load->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";
                    if ($Origen === 'PRODUCCION') {
                        $this->load->view('vMenuProduccion');
                    } else if ($Origen === 'CLIENTES') {
                        $this->load->view('vMenuClientes');
                    } else {
                        $this->load->view('vMenuPrincipal');
                    }
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuAdministracion');
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vTiemposXEstilo')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;

            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
//            var_dump($data);
            $this->db->insert("estilostiempox", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            unset($data["linea"]);
            unset($data["estilo"]);
            $this->db->where('estilo', $x->post('estilo'))->update("estilostiempox", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('estilostiempox');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            $Linea = $this->input->get('Linea');
            print json_encode($this->db->query("SELECT `ID`,`linea`,`estilo`,`cortep`,`cortef`,`rayado`,
                                        `rebaja`,`folead`,`entrete`,`pespu`,`ensuel`,`prepes`,`tejido`,`montado`,`adorno`, "
                                    . ' CONCAT(\'<span class="fa fa-trash fa-lg " onclick="onEliminar(\', ID, \')">\', \'</span>\') AS eliminar '
                                    . " FROM `estilostiempox` where linea = '$Linea' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->query("select clave, linea from estilos where clave = '$Estilo'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarTiemposEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->query("select * from estilostiempox where estilo = '$Estilo'  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
