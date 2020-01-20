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
                $this->db->where('PX.Control = 999999999 ');
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
                            case when A.fec1 = '1899-12-30' then '' else date_format(A.fec1,'%d/%m/%Y') end as PREPROGRAMADO,
                            case when A.fec2 = '1899-12-30' then '' else date_format(A.fec2,'%d/%m/%Y') end as CORTE,
                            case when A.fec3 = '1899-12-30' then '' else date_format(A.fec3,'%d/%m/%Y') end as RAYADO,
                            case when A.fec33 = '1899-12-30' then '' else date_format(A.fec33,'%d/%m/%Y') end as REBAJADO,
                            case when A.fec4 = '1899-12-30' then '' else date_format(A.fec4,'%d/%m/%Y') end as FOLEADO,
                            case when A.fec40 = '1899-12-30' then '' else date_format(A.fec40,'%d/%m/%Y') end as ENTRETELADO,
                            case when A.fec42 = '1899-12-30' then '' else date_format(A.fec42,'%d/%m/%Y') end as MAQUILA,
                            case when A.fec44 = '1899-12-30' then '' else date_format(A.fec44,'%d/%m/%Y') end as 'ALM-CORTE',
                            case when A.fec5 = '1899-12-30' then '' else date_format(A.fec5,'%d/%m/%Y') end as PESPUNTE,
                            case when A.fec55 = '1899-12-30' then '' else date_format(A.fec55,'%d/%m/%Y') end as ENSUELADO,
                            case when A.fec6 = '1899-12-30' then '' else date_format(A.fec6,'%d/%m/%Y') end as 'ALM-PESP',
                            case when A.fec7 = '1899-12-30' then '' else date_format(A.fec7,'%d/%m/%Y') end as TEJIDO,
                            case when A.fec8 = '1899-12-30' then '' else date_format(A.fec8,'%d/%m/%Y') end as 'ALM-TEJIDO',
                            case when A.fec9 = '1899-12-30' then '' else date_format(A.fec9,'%d/%m/%Y') end as MONTADO,
                            case when A.fec10 = '1899-12-30' then '' else date_format(A.fec10,'%d/%m/%Y') end as ADORNO,
                            case when A.fec11 = '1899-12-30' then '' else date_format(A.fec11,'%d/%m/%Y') end as 'ALM-ADORNO',
                            case when A.fec12 = '1899-12-30' then '' else date_format(A.fec12,'%d/%m/%Y') end as TERMINADO,
                A.programado,
                A.corte, A.rayado, A.rebajado, A.foleado, A.pespunte, A.ensuelado, A.almpesp, A.tejido, A.almtejido, A.montado, A.adorno, A.almadorno, A.terminado, A.fec13, A.fec14, A.fec15, A.fec16, A.fec17, A.fec18", false)
                    ->from("avaprd AS A");
            if ($x['CONTROL'] !== '') {
                $this->db->where('contped', $x['CONTROL']);
            } else {
                $this->db->where('contped = 999999999 ');
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
                $this->db->where('FPN.control', '99999999');
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
                $this->db->where('F.cliente', 0);
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
                $this->db->where('D.cliente', 0);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
