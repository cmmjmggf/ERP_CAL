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
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vNavGeneral');
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
            print json_encode($this->Empleados_model->getRecords($this->input->get('Estatus')));
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
            $xxx = $this->input->post();
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }

            //Formateo de fechas para guardarlas
            unset($data['FechaIngreso']);
            unset($data['Nacimiento']);
            unset($data['FechaIMSS']);

            $origFechaIng = $this->input->post('FechaIngreso');
            $fechaIng = str_replace('/', '-', $origFechaIng);
            $data["FechaIngreso"] = date("Y-m-d", strtotime($fechaIng));

            $origFechaNac = $this->input->post('Nacimiento');
            $fechaNac = str_replace('/', '-', $origFechaNac);
            $data["Nacimiento"] = date("Y-m-d", strtotime($fechaNac));

            $origFechaImss = $this->input->post('FechaIMSS');
            $fechaIMSS = str_replace('/', '-', $origFechaImss);
            $data["FechaIMSS"] = date("Y-m-d", strtotime($fechaIMSS));

            $data["Registro"] = Date('d/m/Y h:i:s a');
            $data["Estatus"] = 'ACTIVO';

            $data["Busqueda"] = $xxx['PrimerNombre'] . ' ' . $xxx['SegundoNombre'] . ' ' . $xxx['Paterno'] . ' ' . $xxx['Materno'];
//            var_dump($data);

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
            $xxx = $this->input->post();
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                //print "$key  = $v \n";
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }

            //Formateo de fechas para guardarlas

            unset($data['FechaIngreso']);
            unset($data['Nacimiento']);
            unset($data['FechaIMSS']);

            $origFechaIng = $this->input->post('FechaIngreso');
            $fechaIng = str_replace('/', '-', $origFechaIng);
            $data["FechaIngreso"] = date("Y-m-d", strtotime($fechaIng));

            $origFechaNac = $this->input->post('Nacimiento');
            $fechaNac = str_replace('/', '-', $origFechaNac);
            $data["Nacimiento"] = date("Y-m-d", strtotime($fechaNac));

            $origFechaImss = $this->input->post('FechaIMSS');
            $fechaIMSS = str_replace('/', '-', $origFechaImss);
            $data["FechaIMSS"] = date("Y-m-d", strtotime($fechaIMSS));

            $data["Busqueda"] = $xxx['PrimerNombre'] . ' ' . $xxx['SegundoNombre'] . ' ' . $xxx['Paterno'] . ' ' . $xxx['Materno'];
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
                        if (move_uploaded_file($_FILES["Foto"]["tmp_name"], $URL_DOC . '/' . $xxx['ID'] . '/' . utf8_decode($_FILES["Foto"]["name"]))) {
                            $img = $master_url . "{$xxx['ID']}/" . $_FILES["Foto"]["name"];
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $img;
                            $config['maintain_ratio'] = true;
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

    public function getInfoEmpleadoZapTda() {
        try {
            print json_encode($this->Empleados_model->getInfoEmpleadoZapTda($this->input->get('Empleado')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

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

    public function onModificarBajas() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($this->input->post() as $key => $v) {
                //print "$key  = $v \n";
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            $FECHA_FINAL_EGRE = date("Y-m-d", strtotime(str_replace('/', '-', $x->post('Numero'))));
            $data['Egreso'] = $FECHA_FINAL_EGRE;
            unset($data["Numero"]);
            $this->db->where('Numero', $x->post('Numero'))->update("empleados", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCredenciales() {
        try {
            $pdf = new PDF('P', 'mm', array(215.9, 299.4));
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false, 40);
            $x = $this->input;
            $Y_INI = 5;
            $Cont = 1;

            $Empleados = $this->Empleados_model->getEmpleadosByDepartamentos($x->get('dDepto'), $x->get('aDepto'));
            if (!empty($Empleados)) {
                foreach ($Empleados as $key => $Empleado) {

                    if ($Cont > 5) {
                        $pdf->AddPage();
                        $Y_INI = 5;
                        $Cont = 1;
                    }

                    $pdf->SetLineWidth(.8);
                    $pdf->Image(base_url() . '/img/banner.png', 22.5, $Y_INI + 1, 43);

                    $pdf->SetFont('Calibri', 'B', 12);
                    $pdf->Rect(20.5, $Y_INI, 86/* ANCHO */, 51.5/* ALTO */);
                    $pdf->Line(20.5, $Y_INI + 20, 65, $Y_INI + 20);
                    $pdf->Rect(109.2, $Y_INI, 86/* ANCHO */, 51.5/* ALTO */);
                    $pdf->Line(109.2/* Y1 */, $Y_INI + 47/* Y1 */, 195.2/* Y2 */, $Y_INI + 47/* X2 */);
                    $pdf->SetFont('Calibri', 'B', 13);



                    $path = $Empleado->Foto;

                    if ($Empleado->Foto !== '') {
                        if (!is_file($path)) {
                            // $pdf->Image(base_url() . 'uploads/Empleados/9999.jpg', 68, 11, 30);
                            $pdf->SetLineWidth(.4);
                            $pdf->Rect(77.5, $Y_INI + 1, 28/* ANCHO */, 28/* ALTO */);
                            $pdf->SetY($Y_INI + 11);
                            $pdf->SetX(77.5);
                            $pdf->SetFont('Calibri', 'BI', 13);
                            $pdf->setTextColor(220, 0, 0);
                            $pdf->MultiCell(28, 6, 'Empleado sin foto', 0/* BORDE */, 'C');
                        } else {
                            $pdf->Image(base_url() . $Empleado->Foto, 77.5, $Y_INI + 1, 28);
                        }
                    }

                    $pdf->SetLineWidth(.8);
                    $pdf->setTextColor(0, 0, 0);
                    $pdf->SetY($Y_INI + 22);
                    $pdf->SetX(22.5);
                    $pdf->SetFont('Calibri', 'B', 12);
                    $pdf->Cell(20, 5, utf8_decode('No. Empleado'), 0/* BORDE */, 0/* SALTO */, 'L');
                    $pdf->SetFont('Calibri', 'B', 16);
                    $pdf->SetX(50.5);
                    $pdf->Cell(20, 5, utf8_decode($Empleado->NUMERO), 0/* BORDE */, 1/* SALTO */, 'L');
                    $pdf->SetFont('Calibri', 'BIU', 10);
                    $pdf->SetY($Y_INI + 28);
                    $pdf->SetX(22.5);
                    $pdf->Cell(90, 9.5, utf8_decode($Empleado->NOMBRE_COMPLETO), 0/* BORDE */, 1/* SALTO */, 'L');
                    $pdf->SetFont('Calibri', 'B', 12);
                    $pdf->SetY($Y_INI + 35);
                    $pdf->SetX(20.5);
                    $pdf->Cell(70, 7, utf8_decode($Empleado->DEPARTAMENTO), 0/* BORDE */, 0/* SALTO */, 'C');

                    /* Código Barras */
                    $pdf->SetFont('Calibri', 'B', 10);
                    $pdf->SetY($Y_INI + 41.5);
                    $pdf->SetX(22.5);
                    $pdf->Code39(35, $pdf->GetY(), str_pad($Empleado->NUMERO, 4, "0", STR_PAD_LEFT));

                    $pdf->SetY($Y_INI + 38.5);
                    $pdf->SetX(86.5);
                    $pdf->Cell(20, 5, utf8_decode('VIGENCIA'), 0/* BORDE */, 1/* SALTO */, 'C');

                    $pdf->SetFont('Calibri', 'B', 8);
                    $pdf->SetX(87.5);
                    $pdf->Cell(20, 4, utf8_decode('01/01/' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');
                    $pdf->SetX(87.5);
                    $pdf->Cell(20, 4, utf8_decode('31/12/' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');

                    /*                     * ******************** SEGUNDA HOJA *************************** */


                    $deptos_corte = array(10, 20, 30, 50, 60);
                    $deptos_cordinado = array(40, 70, 80, 90, 140);
                    if (in_array($Empleado->NUM_DEPTO, $deptos_corte)) {

                        $pdf->SetFont('Calibri', 'B', 17);
                        $pdf->SetY($Y_INI);
                        $pdf->SetX(109.2);
                        $pdf->Cell(86, 7, utf8_decode('CALZADO LOBO SOLO'), 1/* BORDE */, 1/* SALTO */, 'C');
                        $pdf->Image(base_url() . '/img/watermark.png', 137, $Y_INI + 6, 28);

                        $pdf->SetY($Y_INI + 32);
                        $pdf->SetX(107.5);
                        $pdf->SetFont('Calibri', 'BI', 12);
                        $pdf->Cell(90, 7, utf8_decode('Corte y Coordinado'), 0/* BORDE */, 0/* SALTO */, 'C');

                        $pdf->SetFont('Calibri', 'B', 10);
                        $pdf->Code128(135, $Y_INI + 38, '999999', 35, 8);

                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->SetY($Y_INI + 46.3);
                        $pdf->SetX(109.2);
                        $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetX(151);
                        $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetY(51.3);
                    } else if (in_array($Empleado->NUM_DEPTO, $deptos_cordinado)) {
                        $pdf->SetFont('Calibri', 'B', 17);
                        $pdf->SetY($Y_INI);
                        $pdf->SetX(109.2);
                        $pdf->Cell(86, 7, utf8_decode('CALZADO LOBO SOLO'), 1/* BORDE */, 1/* SALTO */, 'C');
                        $pdf->Image(base_url() . '/img/watermark.png', 137, $Y_INI + 6, 28);

                        $pdf->SetY($Y_INI + 32);
                        $pdf->SetX(107.5);
                        $pdf->SetFont('Calibri', 'BI', 12);
                        $pdf->Cell(90, 7, utf8_decode('Corte y Coordinado'), 0/* BORDE */, 0/* SALTO */, 'C');

                        $pdf->SetFont('Calibri', 'B', 10);
                        $pdf->Code128(135, $Y_INI + 38, '88888888', 35, 8);

                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->SetY($Y_INI + 46.3);
                        $pdf->SetX(109.2);
                        $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetX(151);
                        $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetY(51.3);
                    } else {
                        $pdf->SetFont('Calibri', 'B', 17);
                        $pdf->SetY($Y_INI);
                        $pdf->SetX(109.2);
                        $pdf->Cell(86, 7, utf8_decode('POLÍTICAS DE CALIDAD'), 1/* BORDE */, 1/* SALTO */, 'C');
                        $pdf->Image(base_url() . '/img/watermark.png', 127.5, $Y_INI + 5, 45);
                        $pdf->SetY($Y_INI + 7);
                        $pdf->SetX(109.2);
                        $pdf->SetFont('Calibri', 'B', 16);
                        $pdf->Cell(90, 7, utf8_decode('En Calzado Lobo'), 0/* BORDE */, 0/* SALTO */, 'C');
                        $pdf->SetFont('Calibri', '', 11.5);
                        $pdf->SetY($Y_INI + 18);
                        $pdf->SetX(109.2);
                        $pdf->MultiCell(86/* ANCHO */, 4/* ALTO */, utf8_decode("Tenemos la responsabilidad de fabricar el mejor calzado en confort y calidad para dama y caballero, mediante la participación comprometida de nuestro personal, buscando siempre una mejora continua en nuestros procesos para satisfacción de nuestros CLIENTES."), 0/* BORDE */, 'J'/* ALINEACION */, false);
                        $pdf->SetFont('Calibri', 'B', 9);
                        $pdf->SetY($Y_INI + 46.3);
                        $pdf->SetX(109.2);
                        $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetX(151);
                        $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
                        $pdf->SetY(51.3);
                    }

                    $Y_INI += $pdf->GetY() + 1.3;
                    $Cont++;
                }
                /* FIN RESUMEN */
                $path = 'uploads/Reportes/Empleados';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                if (delete_files('uploads/Reportes/Empleados/')) {
                    /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
                }
                $url = $path . '/CredencialesDeptos.pdf';
                /* Borramos el archivo anterior */

                $pdf->Output($url);
                print ('{"URL":"' . base_url() . $url . '"}');
            }
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

            $pdf->AddPage();
            $pdf->Image(base_url() . '/img/banner.png', 22.5, 11, 43);
            $pdf->SetFont('Calibri', 'B', 12);
            $pdf->Rect(20.5, 10, 86/* ANCHO */, 51.5/* ALTO */);
            $pdf->Line(20.5, 30, 65, 30);
            $pdf->Rect(109.2, 10, 86/* ANCHO */, 51.5/* ALTO */);
            $pdf->Line(109.2/* Y1 */, 57/* Y1 */, 195.2/* Y2 */, 57/* X2 */);
            $pdf->SetFont('Calibri', 'B', 13);


            $path = $Empleado[0]->Foto;

            if ($Empleado[0]->Foto !== '') {
                if (!is_file($path)) {
                    // $pdf->Image(base_url() . 'uploads/Empleados/9999.jpg', 68, 11, 30);
                    $pdf->SetLineWidth(.4);
                    $pdf->Rect(77.5, 11, 28/* ANCHO */, 28/* ALTO */);
                    $pdf->SetY(21);
                    $pdf->SetX(77.5);
                    $pdf->SetFont('Calibri', 'BI', 13);
                    $pdf->setTextColor(220, 0, 0);
                    $pdf->MultiCell(28, 6, 'Empleado sin foto', 0/* BORDE */, 'C');
                } else {
                    $pdf->Image(base_url() . $Empleado[0]->Foto, 77.5, 11, 28);
                }
            }

            $pdf->SetLineWidth(.8);
            $pdf->setTextColor(0, 0, 0);
            $pdf->SetY(32);
            $pdf->SetX(22.5);
            $pdf->SetFont('Calibri', 'B', 12);
            $pdf->Cell(20, 5, utf8_decode('No. Empleado'), 0/* BORDE */, 0/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'B', 16);
            $pdf->SetX(50.5);
            $pdf->Cell(20, 5, utf8_decode($x->get('ID')), 0/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'BIU', 10);
            $pdf->SetY(38);
            $pdf->SetX(22.5);
            $pdf->Cell(90, 9.5, utf8_decode($Empleado[0]->NOMBRE_COMPLETO), 0/* BORDE */, 1/* SALTO */, 'L');
            $pdf->SetFont('Calibri', 'B', 12);
            $pdf->SetY(45);
            $pdf->SetX(20.5);
            $pdf->Cell(70, 7, utf8_decode($Empleado[0]->DEPARTAMENTO), 0/* BORDE */, 0/* SALTO */, 'C');

            /* Código Barras */
            $pdf->SetFont('Calibri', 'B', 10);
            $pdf->SetY(51.5);
            $pdf->SetX(22.5);

            $pdf->Code39(35, $pdf->GetY(), str_pad($x->get('ID'), 4, "0", STR_PAD_LEFT));

            $pdf->SetY(48.5);
            $pdf->SetX(86.5);
            $pdf->Cell(20, 5, utf8_decode('VIGENCIA'), 0/* BORDE */, 1/* SALTO */, 'C');

            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(87.5);
            $pdf->Cell(20, 4, utf8_decode('01/01/' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');
            $pdf->SetX(87.5);
            $pdf->Cell(20, 4, utf8_decode('31/12/' . date('Y')), 0/* BORDE */, 1/* SALTO */, 'C');


            /*             * ******************** SEGUNDA HOJA *************************** */
            $deptos_corte = array(10, 20, 30, 50, 60);
            $deptos_cordinado = array(40, 70, 80, 90, 140);
            if (in_array($Empleado[0]->NUM_DEPTO, $deptos_corte)) {
                $pdf->SetFont('Calibri', 'B', 17);
                $pdf->SetY(10);
                $pdf->SetX(109.2);
                $pdf->Cell(86, 7, utf8_decode('CALZADO LOBO SOLO'), 1/* BORDE */, 1/* SALTO */, 'C');
                $pdf->Image(base_url() . '/img/watermark.png', 137, 16, 28);

                $pdf->SetY(42);
                $pdf->SetX(107.5);
                $pdf->SetFont('Calibri', 'BI', 12);
                $pdf->Cell(90, 7, utf8_decode('Corte y Coordinado'), 0/* BORDE */, 0/* SALTO */, 'C');

                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->Code128(135, 48, '999999', 35, 8);

                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetY(56.3);
                $pdf->SetX(109.2);
                $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                $pdf->SetX(151);
                $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
            } else if (in_array($Empleado[0]->NUM_DEPTO, $deptos_cordinado)) {
                $pdf->SetFont('Calibri', 'B', 17);
                $pdf->SetY(10);
                $pdf->SetX(109.2);
                $pdf->Cell(86, 7, utf8_decode('CALZADO LOBO SOLO'), 1/* BORDE */, 1/* SALTO */, 'C');
                $pdf->Image(base_url() . '/img/watermark.png', 137, 16, 28);

                $pdf->SetY(42);
                $pdf->SetX(107.5);
                $pdf->SetFont('Calibri', 'BI', 12);
                $pdf->Cell(90, 7, utf8_decode('Corte y Coordinado'), 0/* BORDE */, 0/* SALTO */, 'C');

                $pdf->SetFont('Calibri', 'B', 10);
                $pdf->Code128(135, 48, '888888', 35, 8);

                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetY(56.3);
                $pdf->SetX(109.2);
                $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                $pdf->SetX(151);
                $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
            } else {
                $pdf->SetFont('Calibri', 'B', 17);
                $pdf->SetY(10);
                $pdf->SetX(109.2);
                $pdf->Cell(86, 7, utf8_decode('POLÍTICAS DE CALIDAD'), 1/* BORDE */, 1/* SALTO */, 'C');
                $pdf->Image(base_url() . '/img/watermark.png', 127.5, 15, 45);
                $pdf->SetX(109.2);
                $pdf->SetFont('Calibri', 'B', 16);
                $pdf->Cell(90, 7, utf8_decode('En Calzado Lobo'), 0/* BORDE */, 0/* SALTO */, 'C');
                $pdf->SetFont('Calibri', '', 11.5);
                $pdf->SetY(28);
                $pdf->SetX(109.2);
                $pdf->MultiCell(86/* ANCHO */, 4/* ALTO */, utf8_decode("Tenemos la responsabilidad de fabricar el mejor calzado en confort y calidad para dama y caballero, mediante la participación comprometida de nuestro personal, buscando siempre una mejora continua en nuestros procesos para satisfacción de nuestros CLIENTES."), 0/* BORDE */, 'J'/* ALINEACION */, false);
                $pdf->SetFont('Calibri', 'B', 9);
                $pdf->SetY(56.3);
                $pdf->SetX(109.2);
                $pdf->Cell(45, 6, utf8_decode('Firma'), 0/* BORDE */, 0/* SALTO */, 'L');
                $pdf->SetX(151);
                $pdf->Cell(45, 6, utf8_decode('Rio Santiago No.245 San Miguel'), 0/* BORDE */, 0/* SALTO */, 'L');
            }

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
