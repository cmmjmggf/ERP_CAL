<?php

class ProgramacionProveeduria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR' || 'ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuProveedores')->view('vProgramacionProveeduria')->view('vFooter');
                    break;
                default:
                    header("Location: " . base_url());
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getDocumentosXTipo() {
        try {
            $x = $this->input->get();
            $this->db->query("UPDATE cartera_proveedores SET Mark = 0 WHERE ID > 0;");

            $this->db->select("
                CONCAT(\"<div class='checkbox-big' style=' cursor:pointer;'>
            <label style='font-size: 22
            px; cursor:pointer;'>
                <input type='checkbox' id='chk\",CP.ID,\"' onClick='onCalcularMontoSeleccionado()' value='\",CP.ID,\"'>
                <span class='cr'><i class='cr-icon fa fa-check fa-lg' style='cursor:pointer;'></i></span> 
            </label>
        </div>\") AS SELECCIONA,
                CP.ID, 
                        CAST(CP.Proveedor AS SIGNED) AS ClaveNum,
    CP.Tp,
    CP.Doc,
    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
            '%d/%m/%y') AS FechaDoc,
    STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y') AS FechaOrd,
    CP.ImporteDoc,
    CONCAT(\"$\",FORMAT(CP.ImporteDoc,2)) AS IMPORTE,
    CP.Pagos_Doc,
    CONCAT(\"$\",FORMAT(CP.Pagos_Doc,2)) AS PAGOS, 
    CP.Saldo_Doc,
     CONCAT(\"$\",FORMAT(CP.Saldo_Doc,2)) AS SALDO,
    IFNULL(DATEDIFF(CURDATE(),
                    STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y')),
            '') AS Dias,
            
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) >= 0
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 8
        THEN
            CP.Saldo_Doc
    END AS 'UNO',
     FORMAT(       
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) >= 0
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 8
        THEN
            CP.Saldo_Doc
    END,2) AS 'UNO_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 7
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 16
        THEN
            CP.Saldo_Doc
    END AS 'DOS',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 7
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 16
        THEN
            CP.Saldo_Doc
    END,2) AS 'DOS_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 15
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 22
        THEN
            CP.Saldo_Doc
    END AS 'TRES',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 15
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 22
        THEN
            CP.Saldo_Doc
    END,2) AS 'TRES_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 21
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 31
        THEN
            CP.Saldo_Doc
    END AS 'CUATRO',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 21
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 31
        THEN
            CP.Saldo_Doc
    END,2) AS 'CUATRO_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 30
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 38
        THEN
            CP.Saldo_Doc
    END AS 'CINCO',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 30
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 38
        THEN
            CP.Saldo_Doc
    END,2) AS 'CINCO_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 37
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 46
        THEN
            CP.Saldo_Doc
    END AS 'SEIS',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 37
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 46
        THEN
            CP.Saldo_Doc
    END,2) AS 'SEIS_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 45
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 53
        THEN
            CP.Saldo_Doc
    END AS 'SIETE',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 45
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 53
        THEN
            CP.Saldo_Doc
    END,2) AS 'SIETE_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 52
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 61
        THEN
            CP.Saldo_Doc
    END AS 'OCHO',
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 52
                AND DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) < 61
        THEN
            CP.Saldo_Doc
    END,2) AS 'OCHO_F',
    
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 60
        THEN
            CP.Saldo_Doc
    END AS 'NUEVE', 
    FORMAT(
    CASE
        WHEN
            DATEDIFF(CURRENT_DATE(),
                    DATE_FORMAT(STR_TO_DATE(CP.FechaDoc, '%d/%m/%Y'),
                            '%Y-%m-%d')) > 60
        THEN
            CP.Saldo_Doc
    END,2) AS 'NUEVE_F',
    
    (SELECT P.Plazo FROM proveedores AS P WHERE P.Clave = CP.Proveedor) AS PLAZO, 
    (SELECT CONCAT(P.Clave, ' ', IFNULL(P.NombreI, '')) FROM proveedores AS P WHERE P.Clave = CP.Proveedor) AS ProveedorI ,
    (SELECT P.NombreF FROM proveedores AS P WHERE P.Clave = CP.Proveedor) AS NombreF ,
    (SELECT CONCAT(P.Clave, ' ', IFNULL(P.NombreF, '')) FROM proveedores AS P WHERE P.Clave = CP.Proveedor) AS ProveedorF ", false)
                    ->from("cartera_proveedores AS CP");
            if ($x['TP'] !== '') {
                $this->db->like("CP.Tp", $x['TP']);
            } 
            $this->db->where_in("CP.Estatus", array('SIN PAGAR', 'PENDIENTE'))
                    ->where("CP.Saldo_Doc > 1 ", null, false);
            if ($x['PROVEEDOR_INICIAL'] !== '' && $x['PROVEEDOR_INICIAL'] !== '') {
                $this->db->where("CP.Proveedor BETWEEN {$x['PROVEEDOR_INICIAL']} AND {$x['PROVEEDOR_FINAL']} ", null, false);
            } else {
                $this->db->where("CP.Proveedor = 99999999", null, false);
            }
            $cartera_proveedores = $this->db->order_by("NombreF", 'ASC')
                            ->order_by("ClaveNum", 'ASC')
                            ->order_by("FechaOrd", 'ASC')
                            ->order_by("abs(Dias)", 'DESC')
                            ->order_by("CP.Doc", 'ASC')
                            ->get()->result();
            
            $l = new Logs("PROGRAMACION PROVEEDURIA", "CONSULTO LOS DOCUMENTOS DE TIPO {$x['TP']} DEL PROVEEDOR {$x['PROVEEDOR_INICIAL']} AL PROVEEDOR {$x['PROVEEDOR_FINAL']}", $this->session);
//            print $this->db->last_query();
            print json_encode($cartera_proveedores);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onMarcarParaPago() {
        try {
            $x = $this->input->post();
            $this->db->set("Mark", 1)->where("ID", $x['ID'])->update("cartera_proveedores");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDesMarcarParaPago() {
        try {
            $x = $this->input->post();
            $this->db->set("Mark", 0)->where("ID", $x['ID'])->update("cartera_proveedores");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirAntiguedadDeSaldos() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["TP"] = $x['TP'];
            $MOVIMIENTOS = $x['MOVIMIENTOS'];
            $MOVIMIENTOS = str_replace("[", "", $MOVIMIENTOS);
            $MOVIMIENTOS = str_replace("]", "", $MOVIMIENTOS);
            $parametros["MOVIMIENTOS"] = $MOVIMIENTOS;
            $jc->setJasperurl("jrxml\proveedores\AntiguedadDeSaldos.jasper");
            $jc->setParametros($parametros);
            $jc->setFilename('AntiguedadDeSaldos_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
