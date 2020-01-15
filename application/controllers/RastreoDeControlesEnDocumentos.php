<?php

/**
 * Description of RastreoDeControlesEnDocumentos
 *
 * @author Y700
 */
class RastreoDeControlesEnDocumentos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('RastreoDeControlesEnDocumentos_model', 'rced');
    }

    public function index() {
        $indice = $this->input->get();
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    switch ($indice['ORIGEN']) {
                        case 'A':
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                        case 'B':
                            $this->load->view('vNavGeneral')->view('vMenuClientes');
                            break;
                        default :
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                    }
                    break;
                case 'CLIENTES':
                    switch ($indice['ORIGEN']) {
                        case 'A':
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                        case 'B':
                            $this->load->view('vNavGeneral')->view('vMenuClientes');
                            break;
                        default :
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                    }
                    break;
                case 'VENTAS':
                    switch ($indice['ORIGEN']) {
                        case 'A':
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                        case 'B':
                            $this->load->view('vNavGeneral')->view('vMenuClientes');
                            break;
                        default :
                            $this->load->view('vNavGeneral')->view('vMenuProduccion');
                            break;
                    }
                    break;
            }
            $this->load->view('vRastreoDeControlesEnDocumentos')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->rced->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->rced->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidos() {
        try {
            $x = $this->input->get();
            $this->db->select("PX.ID AS ID, PX.Clave AS PEDIDO, "
                            . "PX.FechaEntrega  AS ENTREGA,  PX.FechaRecepcion AS CAPTURA, "
                            . "date_format(PX.FechaProg,'%d/%m/%Y') AS PRODUCCION, "
                            . "PX.Control AS CONTROL", false)
                    ->from('pedidox AS PX');
            if ($x['CONTROL'] !== '') {
                $this->db->where('PX.Control', $x['CONTROL']);
            } else {
                $this->db->where('PX.Control <> 0', null, false)->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFechasDeAvance() {
        try {
            $x = $this->input->get();
            $this->db->select("A.ID, A.contped AS CONTROL, A.status,
                A.fec1 AS PREPROGRAMADO,
                date_format(A.fec2,'%d/%m/%Y') AS CORTE,
                date_format(A.fec3,'%d/%m/%Y') AS RAYADO,
                date_format(A.fec33,'%d/%m/%Y') AS REBAJADO,
                date_format(A.fec4,'%d/%m/%Y') AS FOLEADO,
                date_format(A.fec40,'%d/%m/%Y') AS ENTRETELADO,
                date_format(A.fec42,'%d/%m/%Y') AS  MAQUILA,
                date_format(A.fec44,'%d/%m/%Y') AS \"ALM-CORTE\",
                date_format(A.fec5,'%d/%m/%Y') AS PESPUNTE,
                date_format(A.fec55,'%d/%m/%Y') AS ENSUELADO,
                date_format(A.fec6,'%d/%m/%Y') AS \"ALM-PESP\",
                date_format(A.fec7,'%d/%m/%Y') AS TEJIDO,
                date_format(A.fec9,'%d/%m/%Y') AS \"ALM-TEJIDO\",
                date_format(A.fec9,'%d/%m/%Y') AS MONTADO,
                date_format(A.fec10,'%d/%m/%Y') AS  ADORNO,
                date_format(A.fec11,'%d/%m/%Y') AS \"ALM-ADORNO\",
                date_format(A.fec12,'%d/%m/%Y') AS \"TERMINADO\",
                A.programado,
                A.corte, A.rayado, A.rebajado, A.foleado, A.pespunte, A.ensuelado, A.almpesp, A.tejido, A.almtejido, A.montado, A.adorno, A.almadorno, A.terminado, A.fec13, A.fec14, A.fec15, A.fec16, A.fec17, A.fec18", false)
                    ->from("avaprd AS A");
            if ($x['CONTROL'] !== '') {
                $this->db->where('contped', $x['CONTROL']);
            } else {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesEnNomina() {
        try {
            $x = $this->input->get();

            $this->db->select("FPN.ID AS ID, FPN.numeroempleado AS EMPLEADO,
                FPN.control AS CONTROL, date_format(FPN.fecha,'%d/%m/%Y') AS FECHA,
                FPN.estilo AS ESTILO, FPN.fraccion AS FRACCION, FPN.numfrac AS NUM_FRACCION,
                FPN.semana AS SEMANA, FPN.pares AS PARES, FPN.depto AS DEPTO", false)
                    ->from('fracpagnomina AS FPN');
            if ($x['CONTROL'] !== '') {
                $this->db->where('FPN.control', $x['CONTROL']);
            }
            if ($x['EMPLEADO'] !== '') {
                $this->db->where('FPN.numeroempleado', $x['EMPLEADO']);
            }
            if ($x['FRACCION'] !== '') {
                $this->db->where('FPN.fraccion', $x['FRACCION']);
            }
            if ($x['CONTROL'] === '' && $x['EMPLEADO'] === '' && $x['FRACCION'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->rced->getColoresXEstilo($this->input->get('ESTILO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            print json_encode($this->rced->getInfoXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturas() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID AS ID, F.cliente AS CLIENTE, F.factura AS FACTURA, "
                            . "date_format(F.fecha,'%d/%m/%Y') AS FECHA, F.staped AS ESTATUS", false)
                    ->from("facturacion AS F");
            if ($x['CLIENTE'] !== '') {
                $this->db->where('F.cliente', $x['CLIENTE']);
            } else {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDevoluciones() {
        try {
            $x = $this->input->get();
            $this->db->select("D.ID, D.cliente AS CLIENTE, D.docto AS FACTURA, date_format(D.fecha,'%d/%m/%Y') AS FECHA", false)
                    ->from("devolucionnp AS D");
            if ($x['CLIENTE'] !== '') {
                $this->db->where('D.cliente', $x['CLIENTE']);
            } else {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
