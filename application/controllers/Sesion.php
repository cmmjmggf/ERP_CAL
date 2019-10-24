<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class Sesion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
        $this->load->model('Usuario_model', 'um');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $dt["TYPE"] = 1;
            $this->load->view('vEncabezado')->view('vFondo');
            switch ($this->session->TipoAcceso) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuPrincipal')->view('vQuickMenu');
                    $is_valid = true;
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    $is_valid = true;
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNominas');
                    $is_valid = true;
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuFacturacion');
                    $is_valid = true;
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral')->view('vMenuPrincipal')->view('vQuickMenu');
                    $is_valid = true;
                    break;
                case 'PRODUCCION':
                    $this->load->view('vNavGeneral')->view('vMenuPrincipal')->view('vQuickMenu');
                    $is_valid = true;
                    break;
                case 'PROVEEDORES':
                    $this->load->view('vMenuProveedores');
                    $is_valid = true;
                    break;
                case 'CONTABILIDAD':
                    $this->load->view('vMenuContabilidad');
                    $is_valid = true;
                    break;
                case 'DESTAJOS':
                    $this->load->view('vMenuPrincipal');
                    switch ($this->session->USERNAME) {
                        case '777777':
                            /*
                             *
                             * 60 FOLEAR CORTE CALIDAD
                             * 70 TROQUELAR PLANTILLA
                             * 71 TROQUELAR MUESTRA
                             * 72 TROQUELAR NORMA
                             * 75 TROQUELAR CORTE
                             * 204 EMPALMAR P'LASER
                             * 337 RECORTAR FORRO LASER
                             *
                             * */
                            $dt["TYPE"] = 2;
                            $this->load->view('vAvance7');
                            $is_valid = true;
                            break;
                        case '888888':
                            /*
                             *
                             * 51 ENTRETELADO
                             * 70 TROQUELAR PLANTILLA
                             * 60 FOLEAR CORTE Y CALIDAD
                             * 62 FOLEADO MUESTRA
                             * 24 DOMAR
                             * 78 LIMPIAR LASER
                             * 204 EMPALMAR P/LASER
                             * 205 APLICA PEGA.P/LASER
                             * 198 LOTEAR P/LASER
                             * 127 ENTRETELAR MUESTRA
                             * 80 CONTAR TAREA
                             * 397 JUNTAR SUELA A CORTE
                             * 34 PEGAR TRANSFER
                             * 106 DOBLILLADO
                             * 306 FORRAR PLATAFORMA
                             * 337 RECORTAR FORRO LASER
                             * 333 PONER CASCO PESPUNTE
                             * 502 PEGADO DE SUELA
                             * 72 TROQUELAR NORMA
                             *
                             * */
                            $dt["TYPE"] = 2;
                            $this->load->view('vAvance8');
                            $is_valid = true;
                            break;
                        case '999999':
                            /*
                             *
                             * 99 CORTE FORRO
                             * 100 CORTE PIEL
                             * 96 CORTE MUESTRAS
                             *
                             * */
                            $dt["TYPE"] = 2;
                            $this->load->view('vAvance9');
                            $is_valid = true;
                            break;
                    }
                    $is_valid = true;
                    break;
                case 'RELOJ':
                    switch ($this->session->USERNAME) {
                        case '99':
                            $this->load->view('vEncabezado')->view('vRelojChecador', array('vigilancia' => 1));
                            $is_valid = true;
                            break;
                    }
                    break;
            }
            $this->load->view('vFooter')->view('vWatermark', $dt);
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getLogoByID() {
        try {
            print json_encode($this->um->getLogoByID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onIngreso() {
        try {
            $x = $this->input;
            $data = $this->um->getAcceso($x->post('USUARIO'), $x->post('CONTRASENA'));
            if (count($data) > 0) {
                $dt = $data[0];
                $newdata = array(
                    'USERNAME' => $dt->Usuario,
                    'PASSWORD' => $dt->AES,
                    'Nombre' => $dt->Nombre,
                    'Apellidos' => $dt->Apellidos,
                    'ID' => $dt->ID,
                    'LOGGED' => TRUE,
                    'TipoAcceso' => $dt->TipoAcceso,
                    'Empresa' => $dt->Empresa,
                    'EMPRESA_RAZON' => $dt->EMPRESA_RAZON,
                    'EMPRESA_DIRECCION' => $dt->EMPRESA_DIRECCION,
                    'EMPRESA_COLONIA' => $dt->EMPRESA_COLONIA,
                    'EMPRESA_CIUDAD' => $dt->EMPRESA_CIUDAD,
                    'EMPRESA_ESTADO' => $dt->EMPRESA_ESTADO,
                    'EMPRESA_RFC' => $dt->EMPRESA_RFC,
                    'EMPRESA_TELEFONO' => $dt->EMPRESA_TELEFONO,
                    'EMPRESA_NOEXT' => $dt->EMPRESA_NOEXT,
                    'EMPRESA_CP' => $dt->EMPRESA_CP,
                    'EMPRESA_REPRESENTANTE' => $dt->EMPRESA_REPRESENTANTE,
                    'LOGO' => $dt->LOGO,
                    'SEG' => $dt->Seguridad
                );
                $this->session->mark_as_temp('LOGGED', 28800);
                $this->session->set_userdata($newdata);
                $this->um->onModificarUltimoAcceso($dt->ID, date("d-m-Y H:i:s"));

                print 1;
            } else {
                print 'ACCESO DENEGADO, VERIFIQUE SU USUARIO Y/O CONTRASEÑA';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCambiarContrasena() {
        try {
            extract($this->input->post());
            $DATA = array(
                'Contrasena' => ($Contrasena !== NULL) ? $Contrasena : NULL
            );
            $this->um->onModificar($ID, $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSalir() {
        try {
            $array_items = array('USERNAME', 'PASSWORD', 'LOGGED');
            $this->session->unset_userdata($array_items);
            header('Location: ' . base_url());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSendMail() {
        extract($this->input->post());
        $data = $this->um->getContrasena($USUARIO);
        //var_dump($data);
        if (!empty($data[0])) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://mut.hosting-mexico.net',
                'smtp_port' => 465,
                'smtp_user' => 'no-reply@ayr.mx',
                'smtp_pass' => 'CDw9#,y^I(_N',
                'mailtype' => 'html',
                'charset' => 'ISO_8859-1',
                'wordwrap' => TRUE
            );
            $this->load->library('email', $config);
            $this->email->from('no-reply@ayr.mx', 'app.ayr.mx');
            $this->email->to($USUARIO);
            $this->email->subject(utf8_decode('Envío de contraseña app.ayr.mx'));
            $this->email->message(utf8_decode('<p>Se ha enviado su contraseña para el usuario: ' . $USUARIO . '</p><br>'
                            . '<p>Su contraseña es: </p>' . '<h3>' . $data[0]->Contrasena . '</h3><hr>'
                            . ''));
            if ($this->email->send()) {
                print 1;
            } else {
                print 0;
            }
        } else {
            print 2;
        }
    }

}
