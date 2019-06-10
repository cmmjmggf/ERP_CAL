<?php

class Empleados extends CI_Controller {

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
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
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

    /* Funciones para mndificaciones desde otros modulos */

    public function onLimpiarCamposAhorroPrestamo() {
        try {
            $this->db->set('Ahorro', 0)
                    ->set('SaldoPres', 0)
                    ->set('PressAcum', 0)
                    ->set('AbonoPres', 0)
                    ->update("empleados");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadoByNumeroExt() {
        try {
            print json_encode($this->Empleados_model->getEmpleadoByNumeroExt($this->input->get('Numero')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosComidas() {
        try {
            print json_encode($this->Empleados_model->getEmpleadosComidas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosComidasSelect() {
        try {
            print json_encode($this->Empleados_model->getEmpleadosComidasSelect());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleadosCajaAhorro() {
        try {
            print json_encode($this->Empleados_model->getEmpleadosCajaAhorro());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarCampoGeneral() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                //print "$key  = $v \n";
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            $this->db->update("empleados", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarExt() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                //print "$key  = $v \n";
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["Numero"]);
            $this->db->where('Numero', $x->post('Numero'))->update("empleados", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCredencial() {
        try {
            $x = $this->input;
            $Empleado = $this->Empleados_model->getEmpleadoByNumero($x->get('ID'));
            $pdf = new PDF('P', 'mm', array(215.9, 279.4));
            $pdf->SetLineWidth(.8);
            $pdf->setLogo(base_url() . '/img/banner.png');
            $pdf->AddPage();
            $pdf->SetFont('Calibri', 'B', 12);
            $pdf->Rect(10, 10, 90/* ANCHO */, 60/* ALTO */);
            $pdf->Line(10, 30, 65, 30);
            $pdf->Rect(110, 10, 90/* ANCHO */, 60/* ALTO */);
            $pdf->Line(110, 17, 200, 17);
            $pdf->Line(110/* Y1 */, 65/* Y1 */, 200/* Y2 */, 65/* X2 */);
            $pdf->SetFont('Calibri', 'B', 13);


            $path = $Empleado[0]->Foto;

            if ($Empleado[0]->Foto !== '') {
                if (!is_file($path)) {
                    // $pdf->Image(base_url() . 'uploads/Empleados/9999.jpg', 68, 11, 30);
                    $pdf->Rect(68, 12, 30/* ANCHO */, 30/* ALTO */);
                    $pdf->SetY(21);
                    $pdf->SetX(68);
                    $pdf->SetFont('Calibri', 'BI', 14);
                    $pdf->setTextColor(220, 0, 0);
                    $pdf->MultiCell(30, 6, 'Empleado sin foto', 0/* BORDE */, 'C');
                } else {
                    $pdf->Image(base_url() . $Empleado[0]->Foto, 68, 11, 30);
                }
            }


            $pdf->setTextColor(0, 0, 0);
            $pdf->SetY(32);
            $pdf->SetX(12);
            $pdf->Cell(20, 5, utf8_decode('Empleado'), 0/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'B', 16);
            $pdf->SetX(35);
            $pdf->Cell(20, 5, utf8_decode($x->get('ID')), 0/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'BIU', 14);
            $pdf->SetY(40);
            $pdf->SetX(12);
            $pdf->Cell(90, 9.5, utf8_decode($Empleado[0]->NOMBRE_COMPLETO), 0/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'B', 14);
            $pdf->SetY(48);
            $pdf->SetX(10);
            $pdf->Cell(70, 7, utf8_decode($Empleado[0]->DEPARTAMENTO), 0/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetFont('Calibri', 'B', 10);

            $pdf->SetY(55);
            $pdf->SetX(12);
            $pdf->Code128(25, $pdf->GetY(), $x->get('ID'), 42.5, 12);

            $pdf->SetY(55);
            $pdf->SetX(80);
            $pdf->Cell(20, 5, utf8_decode('VIGENCIA'), 0/* BORDE */, 1/* SALTO */, 'C');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(80);
            $pdf->Cell(20, 4, utf8_decode('01/01' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');
            $pdf->SetX(80);
            $pdf->Cell(20, 4, utf8_decode('31/12' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');
            $pdf->SetFont('Calibri', 'B', 17);
            $pdf->SetY(10);
            $pdf->SetX(110);
            $pdf->Cell(90, 7, utf8_decode('POLÍTICAS DE CALIDAD'), 1/* BORDE */, 1/* SALTO */, 'C');
            $pdf->Image(base_url() . '/img/watermark.png', 130, 15, 50);
            $pdf->SetX(110);
            $pdf->SetFont('Calibri', 'B', 16);
            $pdf->Cell(90, 7, utf8_decode('En Calzado Lobo'), 0/* BORDE */, 0/* SALTO */, 'C');
            $pdf->SetFont('Calibri', '', 14);
            $pdf->SetY(25);
            $pdf->SetX(110);
            $pdf->MultiCell(90/* ANCHO */, 5/* ALTO */, utf8_decode("Tenemos la responsabilidad de fabricar el mejor calzado en confort y calidad para dama y caballero, mediante la participación comprometida de nuestro personal, buscando siempre una mejora continua en nuestros procesos para satisfacción de nuestros clientes."), 0/* BORDE */, 'J'/* ALINEACION */, false);
            $pdf->SetFont('Calibri', '', 11);
            $pdf->SetY(65);
            $pdf->SetX(110);
            $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetX(147);
            $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Empleados';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (delete_files('uploads/Reportes/Empleados/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $url = $path . '/' . $x->get("ID") . '.pdf';
            /* Borramos el archivo anterior */

            $pdf->Output($url);
            print ('{"URL":"' . base_url() . $url . '"}');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
