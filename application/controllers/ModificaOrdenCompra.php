<?php

require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class ModificaOrdenCompra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuMateriales');
                    break;
                case 'ALMACEN':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuMateriales');
                    break;
            }

            $this->load->view('vFondo');
            $this->load->view('vModificaOrdenCompra');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function onVerificarProveedor() {
        try {
            $Prov = $this->input->get('Proveedor');
            print json_encode($this->db->query("select * from proveedores where clave = '$Prov' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarEnMasa() {
        try {
            $x = $this->input->post();
            $renglones = json_decode($x['renglones']);

            foreach ($renglones as $k => $v) {
                /* actualiza AÑO */
                if ($x['Ano'] !== '') {
                    $upd_ped = "update ordencompra set Ano = {$x['Ano']} where TP = {$v->TP} and Folio = {$v->Folio} and Proveedor = {$v->Proveedor} and estatus = 'ACTIVA' ; ";
                    $this->db->query($upd_ped);
                }
                /* actualiza SEM */
                if ($x['Sem'] !== '') {
                    $upd_fec = "update ordencompra set Sem = '{$x['Sem']}' where TP = {$v->TP} and Folio = {$v->Folio} and Proveedor = {$v->Proveedor} and estatus = 'ACTIVA'  ; ";
                    $this->db->query($upd_fec);
                }
                /* actualiza MAQ */
                if ($x['Maq'] !== '') {
                    $upd_año = "update ordencompra set Maq = {$x['Maq']} where TP = {$v->TP} and Folio = {$v->Folio} and Proveedor = {$v->Proveedor} and estatus = 'ACTIVA'  ; ";
                    $this->db->query($upd_año);
                }
                /* actualiza FEC_ENT */
                if ($x['FechaEntrega'] !== '') {
                    $upd_sem = "update ordencompra set FechaEntrega = '{$x['FechaEntrega']}' where TP = {$v->TP} and Folio = {$v->Folio} and Proveedor = {$v->Proveedor} and estatus = 'ACTIVA'  ; ";
                    $this->db->query($upd_sem);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            $Ano = $this->input->get('Ano');
            $Sem = $this->input->get('Sem');
            $Maq = $this->input->get('Maq');
            print json_encode($this->db->query("
                SELECT Tp, Proveedor, Folio, Ano, Sem, Maq, FechaEntrega, Cantidad
FROM ordencompra WHERE estatus = 'ACTIVA'
GROUP BY TP, Proveedor, Folio
ORDER BY Ano DESC, Maq ASC, Sem DESC, TP ASC, Proveedor ASC, Folio ASC
  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
