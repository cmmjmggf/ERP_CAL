<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class MaterialRecibido extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('Ordencompra_model')
                ->model('MaterialRecibido_model')
                ->helper('ReportesCompras_helper')->helper('file')
                ->helper('jaspercommand_helper');
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
            $this->load->view('vMaterialRecibido');
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado');
            $this->load->view('vSesion');
            $this->load->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $Año = $this->input->post('Ano');
            $Folio = $this->input->post('Folio');
            $Prov = $this->input->post('Proveedor');
            $Arti = $this->input->post('Articulo');
            $Depto = $this->input->post('Tipo');

            $this->db->select("OC.ID,"
                            . "OC.Tp, "
                            . "OC.Folio, "
                            . "OC.Proveedor, "
                            . "CASE WHEN OC.Tp ='1' THEN  CONCAT(P.Clave,' ',P.NombreF) "
                            . "ELSE CONCAT(P.Clave,' ',P.NombreI) END AS NombreProveedor, "
                            . "CASE WHEN OC.Tp ='1' THEN  "
                            . "CONCAT('[Ord_Compra: ',OC.Folio,']----->    Prov. ',OC.Proveedor,' ',P.NombreF) "
                            . "ELSE "
                            . "CONCAT('[Ord_Compra: ',OC.Folio,']----->    Prov. ',OC.Proveedor,' ',P.NombreI) "
                            . "END AS GruposT, "
                            . "OC.FechaOrden, "
                            . "OC.FechaEntrega, "
                            . "OC.FechaFactura, "
                            . "(A.Clave) AS Articulo, "
                            . "(A.Descripcion) AS NomArticulo, "
                            . "format(OC.Cantidad,2) as Cantidad, "
                            . "(case when OC.CantidadRecibida > 0.5 then format(OC.CantidadRecibida,2) else '' end) as CantidadRecibida, "
                            . "(case when (OC.Cantidad - OC.CantidadRecibida) > 0.5 then format((OC.Cantidad - OC.CantidadRecibida),2) else '' end) as Saldo, "
                            . "concat('$',format(OC.Precio,2)) as Precio, "
                            . "concat('$',format(OC.SubTotal,2)) as SubTotal, "
                            . "OC.Cantidad as NFCant, "
                            . "OC.CantidadRecibida as NFCantRec, "
                            . "(OC.Cantidad - OC.CantidadRecibida) as NFSaldo, "
                            . "OC.SubTotal as NFSubTotal,"
                            . "OC.Sem, "
                            . "OC.Maq, "
                            . "CONCAT(G.Clave) AS Grupo,"
                            . "OC.Ano,"
                            . "OC.Tipo, "
                            . "(CASE "
                            . "WHEN  OC.Estatus ='ACTIVA' THEN CONCAT('<span class=\'badge badge-info\'>','ACTIVA','</span>') "
                            . "WHEN  OC.Estatus ='PENDIENTE' THEN CONCAT('<span class=\'badge badge-warning\'>','PENDIENTE','</span>')"
                            . "WHEN  OC.Estatus ='RECIBIDA' THEN CONCAT('<span class=\'badge badge-success\'>','RECIBIDA','</span>')"
                            . "WHEN  OC.Estatus ='CANCELADA' THEN CONCAT('<span class=\'badge badge-danger\'>','CANCELADA','</span>')"
                            . "WHEN  OC.Estatus ='INACTIVA' THEN CONCAT('<span class=\'badge badge-secondary\'>','INACTIVA','</span>')"
                            . " END) AS Estatus "
                            . "", false)
                    ->from("ordencompra AS OC")
                    ->join("proveedores P", 'ON P.Clave = OC.Proveedor')
                    ->join("articulos A", 'ON A.Clave = OC.Articulo')
                    ->join("grupos G", 'ON G.Clave =  A.Grupo')
                    ->join("unidades U", 'ON U.Clave =  A.UnidadMedida');

            if ($Año !== '') {
                $this->db->where('OC.Ano', $Año);
            }
            if ($Depto !== '') {
                $this->db->where('OC.Tipo', $Depto);
            }
            if ($Folio !== '') {
                $this->db->where('OC.Folio', $Folio);
            }
            if ($Prov !== '') {
                $this->db->where('OC.Proveedor', $Prov);
            }
            if ($Arti !== '') {
                $this->db->where('OC.Articulo', $Arti);
            }
            if ($Año === '' && $Folio === '' && $Depto === '' && $Prov === '' && $Arti === '') {
                //$this->db->limit(50);
                $this->db->where('OC.Ano', 0);
            }
            $query = $this->db->get()->result();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;

            print json_encode($query);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function onImprimirOrdenCompra() {
        $cm = $this->Ordencompra_model;
        $DatosEmpresa = $cm->getDatosEmpresa();
        $OrdenCompra = $cm->getReporteOrdenCompra($this->input->post('Tp'), $this->input->post('Folio'));

        if (!empty($OrdenCompra)) {
            $pdf = new PDF('L', 'mm', array(215.9, 279.4));
            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Direccion = $DatosEmpresa[0]->Direccion;
            $pdf->Direccion2 = $DatosEmpresa[0]->Direccion2;
            $pdf->FechaOrden = $OrdenCompra[0]->FechaOrden;
            $pdf->FechaCaptura = $OrdenCompra[0]->FechaCaptura;
            $pdf->ClaveProveedor = $OrdenCompra[0]->Proveedor;
            $pdf->Proveedor = $OrdenCompra[0]->NombreProveedor;
            $pdf->Observaciones = $OrdenCompra[0]->Observaciones;
            $pdf->ConsignarA = $OrdenCompra[0]->ConsignarA;
            $pdf->Folio = $OrdenCompra[0]->Folio;
            $pdf->Estatus = $OrdenCompra[0]->Estatus;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 26.9);

            $SubTotal = 0;
            $TotalCantidad = 0;
            foreach ($OrdenCompra as $keyFT => $F) {
                $pdf->SetLineWidth(0.25);
                $pdf->SetX(5);
                $pdf->SetFont('Arial', '', 7);
                //$anchos = array(10/* 0 */, 90/* 1 */, 15/* 2 */, 10/* 3 */, 20/* 4 */, 20/* 5 */, 10/* 6 */, 15/* 7 */, 30/* 8 */, 30/* 9 */, 20/* 10 */);
                //$aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');


                $anchos = array(10/* 0 */, 90/* 1 */, 15/* 2 */, 10/* 3 */, 20/* 4 */, 20/* 5 */, 10/* 6 */, 15/* 7 */, 25/* 8 */, 35/* 9 */, 20/* 10 */);
                $aligns = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'C', 'C', 'L');

                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);

                $pdf->Row(array(
                    utf8_decode($F->Articulo),
                    mb_strimwidth(utf8_decode($F->NombreArticulo), 0, 60, "..."),
                    number_format($F->Cantidad, 2, ".", ","),
                    utf8_decode($F->Unidad),
                    '$' . number_format($F->Precio, 2, ".", ","),
                    '$' . number_format($F->SubTotal, 2, ".", ","),
                    $F->Sem,
                    $F->Maq,
                    number_format($F->CantidadRecibida, 2, ".", ","),
                    $F->Factura,
                    utf8_decode($F->FechaEntrega)
                ));
                //TOTALES GRUPOS
                $SubTotal += $F->SubTotal;
                $TotalCantidad += $F->Cantidad;
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->RowNoBorder(array('', '', number_format($TotalCantidad, 2, ".", ","), '',
                'Subtotal:', '$' . number_format($SubTotal, 2, ".", ","), '', '', '', '', ''
            ));

            //Pintamos el IVA si es TP 1
            if ($OrdenCompra[0]->Tp === '1') {
                $IVA = $SubTotal * 0.16;
                $Total = $SubTotal + $IVA;
                $pdf->RowNoBorder(array('', '', '', '', 'IVA:', '$' . number_format($IVA, 2, ".", ","), '', '', '', '', ''));
                $pdf->RowNoBorder(array('', '', '', '', 'Total:', '$' . number_format($Total, 2, ".", ","), '', '', '', '', ''));
            }



            /* FIN RESUMEN */
            $path = 'uploads/Reportes/OrdenesCompra';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "ORDEN DE COMPRA " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/OrdenesCompra/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReporteMaterialNoRecibido() {
        try {
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\materiales\reporteMaterialNoRecibido.jasper');
            $jc->setFilename('REPORTE_MATERIAL_SIN_RECIBIR_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
