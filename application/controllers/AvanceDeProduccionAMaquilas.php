<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AvanceDeProduccionAMaquilas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function getUltimoConsecutivo() {
        try {
            $ucv = $this->db->query("SELECT  COUNT(*) AS ULTIMO_VALIDO FROM avanceproduccionmaq AS A ORDER BY A.ID DESC LIMIT 1")->result();

            if (intval($ucv[0]->ULTIMO_VALIDO) === 0) {
                $uc = $this->db->query("SELECT LPAD(1,3,\"0\") AS ULTIMO_CONSECUTIVO, 1 UC ")->result();
                print json_encode($uc);
            } else {
                $uc = $this->db->query("SELECT (CASE WHEN A.Consecutivo IS NULL THEN LPAD(1,3,\"0\")  ELSE LPAD(A.Consecutivo+1,3,\"0\")  END) AS ULTIMO_CONSECUTIVO, A.Consecutivo+1 AS UC FROM avanceproduccionmaq AS A ORDER BY A.ID DESC LIMIT 1")->result();
                print json_encode($uc);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarPrecioXMaquilaXEstiloXColor() {
        try {
            /*REVISA SI TIENE PRECIO ASIGNADO EN LA MAQUILA*/
            $x = $this->input->get();
            $check_precio = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox pe INNER JOIN listapreciosmaquilas lpm  on lpm.Maq = pe.Maquila and lpm.Estilo = pe.Estilo and lpm.Color = pe.color WHERE  pe.control = {$x['CONTROL']}")->result();
            print json_encode($check_precio);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            /* REVISAR EN LOS AVANCES DE PRODUCCION MAQUILA */
            $check = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avanceproduccionmaq AS A "
                            . "WHERE A.Control = {$x["CONTROL"]} AND A.Documento = {$x["DOCUMENTO"]}")->result();
            $check_control_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM pedidox AS P WHERE P.Control = {$x["CONTROL"]} AND P.stsavan = 55")->result();
            if (intval($check_control_existe[0]->EXISTE) === 0) {
                EXIT(0);
            }
            if (intval($check[0]->EXISTE) === 0) {
                /* REVISAR EN LOS AVANCES DE LA FABRICA QUE NO EXISTA */
                $check_avance = $this->db->query("SELECT COUNT(*) AS EXISTE FROM avance AS A "
                                . "WHERE A.Control = {$x["CONTROL"]} AND A.Departamento = 130")->result();
                if (intval($check_avance[0]->EXISTE) === 0) {
                    $STSAVAN = 6;
                    $DEPTO = 130;
                    $DEPTO_TEXT = 'ALMACEN PESPUNTE';
                    $control = $this->db->query("SELECT P.Control,P.Estilo, P.stsavan, P.Pares "
                                    . "FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} AND P.stsavan = 55")->result();
                    $this->db->insert("avanceproduccionmaq", array(
                        "Fecha" => $x["FECHA"], "Departamento" => $DEPTO,
                        "DepartamentoT" => $DEPTO_TEXT, "Documento" => $x["DOCUMENTO"],
                        "Control" => $x["CONTROL"], "Estilo" => $control[0]->Estilo,
                        "Pares" => $control[0]->Pares, "Avance" => $STSAVAN,
                        "AvanceT" => $DEPTO_TEXT,
                        "Consecutivo" => $x['CONSECUTIVO'],
                        "Usuario" => $this->session->ID,
                        "UsuarioT" => $this->session->USERNAME
                    ));
                    $this->db->insert('avance', array(
                        'Control' => $x['CONTROL'],
                        'FechaAProduccion' => Date('d/m/Y'),
                        'Departamento' => $DEPTO,
                        'DepartamentoT' => $DEPTO_TEXT,
                        'FechaAvance' => $x["FECHA"],
                        'Estatus' => 'A',
                        'Usuario' => $_SESSION["ID"],
                        'Fecha' => $x["FECHA"],
                        'Hora' => Date('h:i:s a'),
                        'Fraccion' => 0
                    ));
                    $this->db->set('EstatusProduccion', $DEPTO_TEXT)
                            ->set('DeptoProduccion', $DEPTO)
                            ->where('Control', $x['CONTROL'])
                            ->where('DeptoProduccion', 140)->update('controles');

                    $this->db->set('stsavan', $STSAVAN)
                            ->set('EstatusProduccion', $DEPTO_TEXT)
                            ->set('DeptoProduccion', $DEPTO)
                            ->where('Control', $x['CONTROL'])
                            ->where('stsavan', 55)->update('pedidox');
                    $date = explode("/", $x["FECHA"]); // 
                    $datetime = $date[2] . '-' . $date[1] . '-' . $date[0] . ' 00:00:00';
                    $this->db->set("status", $STSAVAN)
                            ->set("almpesp", $x["DOCUMENTO"])
                            ->set("fec6", $datetime)
                            ->where('fec6 IS NULL', null, false)
                            ->where('contped', $x['CONTROL'])->update('avaprd');
                    $l = new Logs("Avance de producción a maquilas", "HA AVANZADO EL CONTROL {$x['CONTROL']} A  - ALMACEN DE PESPUNTE CON EL DOCUMENTO {$x["DOCUMENTO"]}.", $this->session);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControlADPAM() {
        try {
            $x = $this->input->get();
            $control = $this->db->query("SELECT P.Control,P.Estilo, P.stsavan, P.Pares "
                            . "FROM pedidox AS P WHERE P.Control = {$x['CONTROL']} AND P.stsavan = 55")->result();
            print json_encode($control);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporte() {
        try {
            $reports = array();
            $this->benchmark->mark('code_start');

            /* OBTENER REPORTES */
            $x = $this->input->get();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $p = array();
            $p["logo"] = base_url() . $this->session->LOGO;
            $p["empresa"] = $this->session->EMPRESA_RAZON;
            $p["docto"] = $x['DOCUMENTO'];
            $jc->setParametros($p);
            /* 1. REPORTE DE PRENOMINA COMPLETO */
            $jc->setJasperurl('jrxml\avance\avanceprodmaquilas.jasper');
            $jc->setFilename('avanceprodmaquilas_' . Date('his'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();

            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getConsecutivoDelDocumento() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT A.Consecutivo AS CONSECUTIVO FROM avanceproduccionmaq AS A WHERE A.Documento = {$x['DOCUMENTO']} ORDER BY ID DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onBuscarDocumentoXControl() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT A.Documento AS DOC FROM avanceproduccionmaq AS A WHERE A.Control = {$x['CONTROL']} ORDER BY ID DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
