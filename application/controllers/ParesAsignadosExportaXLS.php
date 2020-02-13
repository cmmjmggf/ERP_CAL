<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}

class ParesAsignadosExportaXLS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('file');
    }

    public function getXLS() {
        try {
            $x = $this->input->post();
            $this->db->select("P.Clave AS PEDIDO, P.Control AS CONTROL,  REPLACE(P.Estilo, \"-\", \"_\") AS ESTILO, "
                            . "P.Color AS CLAVE_COLOR,  REPLACE(P.ColorT, \"-\", \"_\") AS COLOR_PIEL, "
                            . "P.Cliente AS CLIENTE_CLAVE, "
                            . "(SELECT REPLACE(CC.RazonS, \"-\", \"_\") FROM clientes AS CC "
                            . "WHERE CC.Clave = P.Cliente LIMIT 1) AS CLIENTE, "
                            . "P.FechaEntrega AS FECHA_ENTREGA, P.Pares AS PARES", false)
                    ->from("pedidox AS P");

            if ($x['SEMANA'] !== '') {
                $this->db->where("P.Semana", $x['SEMANA']);
            }
            if ($x['ANIO'] !== '') {
                $this->db->where("P.Ano", $x['ANIO']);
            }
            $this->db->where("P.Control > 0", null, false)
                    ->order_by("abs(P.Cliente)", "ASC");
            if ($x['SEMANA'] === '' && $x['ANIO'] !== '') {
                $this->db->limit(5);
            }
            $data = $this->db->get()->result();

            $xls = new Excel();
            $xls->setActiveSheetIndex(0);
            $hoja = $xls->getActiveSheet();
            //Nombre de columnas
            $hoja->setCellValueByColumnAndRow(0, 1, 'PEDIDO');
            $hoja->setCellValueByColumnAndRow(1, 1, 'CONTROL');
            $hoja->setCellValueByColumnAndRow(2, 1, 'ESTILO');
            $hoja->setCellValueByColumnAndRow(3, 1, 'COLOR');
            $hoja->setCellValueByColumnAndRow(4, 1, 'COLOR/PIEL');
            $hoja->setCellValueByColumnAndRow(5, 1, 'CLIENTE');
            $hoja->setCellValueByColumnAndRow(6, 1, '-');
            $hoja->setCellValueByColumnAndRow(7, 1, 'FECHA-ENTREGA');
            $hoja->setCellValueByColumnAndRow(8, 1, 'PARES');
            $hoja->getColumnDimension('A')->setAutoSize(false);
            $hoja->getColumnDimension('A')->setWidth("15");
            $hoja->getColumnDimension('B')->setAutoSize(false);
            $hoja->getColumnDimension('B')->setWidth("15");
            $hoja->getColumnDimension('C')->setAutoSize(false);
            $hoja->getColumnDimension('C')->setWidth("15");
            $hoja->getColumnDimension('D')->setAutoSize(false);
            $hoja->getColumnDimension('D')->setWidth("10");
            $hoja->getColumnDimension('E')->setAutoSize(false);
            $hoja->getColumnDimension('E')->setWidth("35");
            $hoja->getColumnDimension('F')->setAutoSize(false);
            $hoja->getColumnDimension('F')->setWidth("10");
            $hoja->getColumnDimension('G')->setAutoSize(false);
            $hoja->getColumnDimension('G')->setWidth("35");
            $hoja->getColumnDimension('H')->setAutoSize(false);
            $hoja->getColumnDimension('H')->setWidth("20");
            $hoja->getColumnDimension('I')->setAutoSize(false);
            $hoja->getColumnDimension('I')->setWidth("10");

            $row = 2;
            foreach ($data as $k => $v) {
                $hoja->setCellValue('A' . $row, $v->PEDIDO);
                $hoja->setCellValue('B' . $row, $v->CONTROL);
                $hoja->setCellValue('C' . $row, $v->ESTILO);
                $hoja->setCellValue('D' . $row, $v->CLAVE_COLOR);
                $hoja->setCellValue('E' . $row, $v->COLOR_PIEL);
                $hoja->setCellValue('F' . $row, $v->CLIENTE_CLAVE);
                $hoja->setCellValue('G' . $row, $v->CLIENTE);
                $hoja->setCellValueExplicit('H' . $row, $v->FECHA_ENTREGA, PHPExcel_Cell_DataType::TYPE_STRING);
                $hoja->setCellValue('I' . $row, $v->PARES);
                $row++;
            }
            // Renombramos hoja
            $hoja->setTitle('Hoja1');
            $path = 'uploads/Reportes/PARESASIGNADOSXSEMANIO';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "PARES_ASIGNADOS_X_SEM_ANIO_" . date("d_m_Y_his");
            $url = $path . '/' . $file_name . '.xlsx';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/PARESASIGNADOSXSEMANIO/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }

            $objWriter = new PHPExcel_Writer_Excel2007($xls);
            $objWriter->save(str_replace(__FILE__, $url, __FILE__));
            print base_url() . $url;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
