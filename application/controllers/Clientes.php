<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Clientes_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
            }

            $this->load->view('vFondo')->view('vClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $this->db->select("C.ID AS ID, C.Clave AS Clave, C.RazonS AS Nombre,(SELECT E.Descripcion FROM estados AS E WHERE E.Clave = C.Estado LIMIT 1) AS ESTADO,(SELECT Nombre FROM agentes AS AA WHERE AA.Clave = C.Agente LIMIT 1) AS AGENTE ", false)
                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            $data = $query->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientesBloqueados() {
        try {
            print json_encode($this->db->query("select cliente, motivo, date_format(fecha,'%d/%m/%Y') as fecha, "
                                    . "case when status = 1 then 'BLOQUEADO' ELSE '' END AS status, "
                                    . "case when statusped = 1 then 'BLOQUEADO' ELSE '' END AS statusped "
                                    . "from bloqueovta "
                                    . "order by cliente asc")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClienteByID() {
        try {
            print json_encode($this->db->select('U.*', false)->from('clientes AS U')->where('U.Clave', $this->input->get('Clave'))->where_in('U.Estatus', 'ACTIVO')->get()->result());

//            print json_encode($this->Clientes_model->getClienteByID($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClienteBloqueado() {
        try {
            print json_encode($this->Clientes_model->getClienteBloqueado($this->input->get('Cliente')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getID() {
        try {
            print json_encode($this->Clientes_model->getID());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarClave() {
        try {
            print json_encode($this->Clientes_model->onComprobarClave($this->input->get('Clave')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getClientes() {
        try {
            print json_encode($this->Clientes_model->getClientes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstados() {
        try {
            print json_encode($this->Clientes_model->getEstados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFormasDePago() {
        try {
            print json_encode($this->Clientes_model->getFormasDePago());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getMetodosDePago() {
        try {
            print json_encode($this->Clientes_model->getMetodosDePago());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPaises() {
        try {
            print json_encode($this->Clientes_model->getPaises());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgentes() {
        try {
            print json_encode($this->Clientes_model->getAgentes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTransportes() {
        try {
            print json_encode($this->Clientes_model->getTransportes());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getZonas() {
        try {
            print json_encode($this->Clientes_model->getZonas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            print json_encode($this->Clientes_model->getGrupos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getListasDePrecios() {
        try {
            print json_encode($this->Clientes_model->getListasDePrecios());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarBloqueoAut() {
        try {
            $x = $this->input;
            $CarteraCte = $this->db->query('SELECT cliente, max(datediff(now(),fecha)) as dias FROM cartcliente  WHERE pagos = 0 and saldo > 0 group by cliente order by cliente,fecha ')->result();
            if (empty($CarteraCte)) {
                print 1;
            } else {
                foreach ($CarteraCte as $v) {
                    if (intval($v->dias) > intval($x->post('Dias'))) {//Si los días superan a los días seleccionados hacer accion
                        $data = array(
                            'cliente' => $v->cliente,
                            'motivo' => "TEST B.A.DIAS >= " . $x->post('Dias'),
                            'fecha' => Date('Y-m-d'),
                            'status' => $x->post('Facturacion'),
                            'statusped' => $x->post('Pedido')
                        );

                        $ExisteBloq = $this->db->query("SELECT cliente FROM bloqueovta WHERE cliente = $v->cliente ")->result();

                        if (empty($ExisteBloq)) {
                            //Insert
                            $this->db->insert('bloqueovta', $data);
                        } else {
                            //update
                            unset($data["cliente"]);
                            $this->db->where('cliente', $v->cliente)->update("bloqueovta", $data);
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarBloqueoInd() {
        try {
            $x = $this->input;
            $data = array(
                'cliente' => $x->post('ClienteBloqInd'),
                'motivo' => strtoupper($x->post('MotivoBloqInd')),
                'fecha' => Date('Y-m-d'),
                'status' => $x->post('statusBloqInd'),
                'statusped' => $x->post('statusPedBloqInd')
            );

            if ($x->post('Existe') === '1') {
                unset($data["cliente"]);
                $this->db->where('cliente', $x->post('ClienteBloqInd'))->update("bloqueovta", $data);
            } else {
                $this->db->insert('bloqueovta', $data);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($x->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            $data["Estatus"] = 'ACTIVO';
            $data["Registro"] = Date('d/m/Y h:i:s');
            $this->Clientes_model->onAgregar($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            $x = $this->input;
            $data = array();
            foreach ($x->post() as $key => $v) {
                if ($v !== '') {
                    $data[$key] = ($v !== '') ? strtoupper($v) : NULL;
                }
            }
            unset($data["ID"]);
            $this->Clientes_model->onModificar($x->post('ID'), $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* captura cajas p' flete */

    public function onVerificarExistePedidoFactura() {
        try {
            $x = $this->input;
            $Tp = $x->get('Tp');
            $Cliente = $x->get('Cliente');
            $Doc = $x->get('Doc');
            print json_encode($this->db->query("select factura from facturacion where tp = $Tp and factura = $Doc and cliente = $Cliente ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCapturarCajasFlete() {
        try {
            $x = $this->input;
            $Tp = $x->post('TpCajaFlete');
            $Cliente = $x->post('ClienteCajasFlete');
            $Doc = $x->post('DocCajasFlete');
            $Cajas = $x->post('CajasFlete');
            $this->db->query("update facturacion set cajas = $Cajas where tp = $Tp and factura = $Doc and cliente = $Cliente ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
