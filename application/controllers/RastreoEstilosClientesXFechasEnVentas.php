<?php

class RastreoEstilosClientesXFechasEnVentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CLIENTES':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vRastreoEstilosClientesXFechasEnVentas')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getFacturas() {
        try {
            $x = $this->input->get();
            $this->db->select("F.ID AS ID, F.cliente AS CLIENTE, F.estilo AS ESTILO, F.combin AS COLOR, "
                            . "F.pareped AS PARES, F.contped AS CONTROL, F.factura AS DOCUMENTO, F.tp AS TP, "
                            . "F.precto AS PRECIO, F.staped AS ESTATUS, DATE_FORMAT(F.fecha, '%d/%m/%Y') AS FECHA")
                    ->from("facturacion AS F");
            if ($x['ESTILO'] !== '') {
                $this->db->where('F.estilo', $x['ESTILO']);
            }
            if ($x['COLOR'] !== '') {
                $this->db->where('F.combin', $x['COLOR']);
            }
            if ($x['FECHA_INICIO'] !== '' && $x['FECHA_FIN'] !== '') {
                $this->db->where("F.fecha BETWEEN date_format(STR_TO_DATE('{$x['FECHA_INICIO']}', \"%d/%m/%Y\"), '%Y-%m-%d') AND date_format(STR_TO_DATE('{$x['FECHA_FIN']}', \"%d/%m/%Y\"), '%Y-%m-%d')", null, false);
            }
            if ($x['CLIENTE'] !== '') {
                $this->db->where('F.cliente', $x['CLIENTE']);
            }
            if ($x['ESTILO'] === '' && $x['COLOR'] === '' && $x['FECHA_INICIO'] === '' && $x['FECHA_FIN'] === '' && $x['CLIENTE'] === '') {
                $this->db->limit(99);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            if ($this->input->get('ESTILO') !== '') {
                print json_encode($this->db->select("CAST(C.Clave AS SIGNED) AS Clave, CONCAT(C.Clave,'-', C.Descripcion) AS Color", false)
                                        ->from('colores AS C')
                                        ->where('C.Estilo', $this->input->get('ESTILO'))
                                        ->where('C.Estatus', 'ACTIVO')
                                        ->order_by('C.Clave', 'ASC')
                                        ->get()->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
