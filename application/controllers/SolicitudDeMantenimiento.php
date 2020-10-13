<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitudDeMantenimiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function onAgregar() {
        try {
            $x = $this->input->post();
            $check_solicitud = $this->db->query("SELECT COUNT(*) AS EXISTE FROM repomaqui AS R "
                            . "WHERE R.vale = {$x['VALE']} AND  R.depto = {$x['DEPTO_CLAVE']} AND "
                            . "R.codigo = '{$x['CODIGO']}' AND  R.desdpro = '{$x['DESCRIPCION_PROBLEMA']}'")->result();
            if (intval($check_solicitud[0]->EXISTE) === 0) {
                $this->db->insert('repomaqui', array(
                    "vale" => $x['VALE'],
                    "fecha" => DATE('Y-m-d h:i:s'),
                    "depto" => $x['DEPTO_CLAVE'],
                    "codigo" => $x['CODIGO'],
                    "desdpro" => $x['DESCRIPCION_PROBLEMA'],
                    "ident" => 1
                ));
            } else {
                print "\n\nESTA SOLICITUD YA EXISTE: VALE: {$x['VALE']}, CODIGO: {$x['CODIGO']}\n\n";
            } 
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getMaquinaria() {
        try {
            print json_encode($this->db->query("SELECT nummaq,id,CONCAT(nummaq,\" \",id,\" \",nommaq) AS nommaq FROM maquinaria ORDER BY ID DESC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getMaquinariabyID() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT M.nummaq, M.id, M.nommaq, M.marmaq, M.modmaq, M.sermaq, M.depmaq,DATE_FORMAT(M.fechaalt,\"%d/%m/%Y\") AS fechaalt, DATE_FORMAT(M.fecultma,\"%d/%m/%Y\") AS fecultma, M.diasmaq, M.stsmaq, M.facmaq, M.cosmaq, M.fecbaja, M.motmaq, M.critisida, M.maq, M.IDE, M.FotoUno, M.FotoDos, M.FotoTres, M.FotoCuatro, M.FotoCinco, M.FotoSeis FROM maquinaria AS M WHERE M.id = '{$x['ID']
                                    }' LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getUltimoVale() {
        try {
            print json_encode($this->db->query("SELECT (CAST(vale AS SIGNED) +1 ) AS VALE FROM repomaqui AS R ORDER BY R.vale DESC LIMIT 1")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getSolicitudXNumeroDeVale() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT "
                                    . "R.vale, R.horapa, R.horalle, R.fecha, R.depto, "
                                    . "R.codigo, R.desdpro, R.desdrea, R.numref, R.cant, "
                                    . "R.precio, R.ctomaho, R.horae, R.refa1, R.cant1, "
                                    . "R.pre1, R.refa2, R.cant2, R.pre2, R.refa3, "
                                    . "R.cant3, R.pre3, R.refa4, R.cant4, R.pre4, "
                                    . "R.refa5, R.cant5, R.pre5, R.refa6, R.cant6, "
                                    . "R.pre6, R.refa7, R.cant7, R.pre7, R.refa8, "
                                    . "R.cant8, R.pre8, R.refa9, R.cant9, R.pre9, "
                                    . "R.refa10, R.cant10, R.pre10, R.numfac, R.numpro, R.ident, R.reg, R.ID,
                                        M.nummaq, M.id AS idmaq, M.nommaq, M.marmaq, M.modmaq, 
                                        M.sermaq, M.depmaq, DATE_FORMAT(M.fechaalt,\"%d/%m/%Y\") AS fechaalt, 
                                        DATE_FORMAT(M.fecultma,\"%d/%m/%Y\") AS fecultma, M.diasmaq, 
                                        M.stsmaq, M.facmaq, M.cosmaq, M.fecbaja, M.motmaq, 
                                        M.critisida, M.maq, M.IDE, 
                                        M.FotoUno, M.FotoDos, M.FotoTres, M.FotoCuatro, M.FotoCinco, M.FotoSeis, 
                                        R.tp AS TP, R.factura AS FACTURA, R.proveedor AS PROVEEDOR, R.proveedorid AS PROVEEDOR_ID  
                                        FROM repomaqui AS R INNER JOIN maquinaria AS M ON R.codigo = M.id WHERE R.vale = {$x['VALE']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getSolicitudes() {
        try {
            print json_encode($this->db->query("
                SELECT R.ID AS ID, 
                CONCAT(\"<SPAN CLASS='solicitud_de_mto_codigo'>\",R.codigo,\"</SPAN>\") AS CODIGO, R.desdpro AS DESCRIPCION, 
                CASE WHEN R.desdrea = 0 THEN \"\" ELSE R.desdrea END AS DESCRIPCIONREF, 
                R.horalle AS HORALLEGADA,
                CASE WHEN R.horae = 0 THEN \"\" ELSE R.horae END AS HORAENTRADA, 
                CASE WHEN R.refa1 = 0 THEN \"\" ELSE R.refa1 END AS REFACCION_UNO,  
                CASE WHEN R.cant1 = 0 THEN \"\" ELSE R.cant1 END AS CANTIDAD_UNO, 
                CASE 
                WHEN R.pre1 = 0 THEN \"\" ELSE CONCAT(\"<SPAN CLASS='solicitud_de_mto_codigo'>\", \"$\",FORMAT(R.pre1,2)  ,\"</SPAN>\")
                END AS PRECIO_UNO, 
                CASE WHEN R.refa2 = 0 THEN \"\" ELSE R.refa2 END AS REFACCION_DOS, 
                CASE WHEN R.cant2 = 0 THEN \"\" ELSE R.cant2 END AS CANTIDAD_DOS, 
                CASE WHEN R.pre2 = 0 THEN \"\" ELSE CONCAT(\"<SPAN CLASS='solicitud_de_mto_codigo'>\", \"$\",FORMAT(R.pre2,2),\"</SPAN>\") END AS PRECIO_DOS 
                FROM repomaqui AS R;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getReporteDeSolicitudMantenimiento() {
        try {
            $x = $this->input->post();
            $check_vale = $this->db->query("SELECT COUNT(*) AS EXISTE FROM repomaqui AS R WHERE R.id = {$x['VALE']}")->result();
            if (intval($check_vale[0]->EXISTE) === 1) {
                $jc = new JasperCommand();
                $jc->setFolder('rpt/' . $this->session->USERNAME);
                $pr ["logo"] = base_url() . $this->session->LOGO;
                $pr["empresa"] = $this->session->EMPRESA_RAZON;
                $pr["VALE"] = $x['VALE'];
                $jc->setParametros($pr);
                $jc->setJasperurl('jrxml\mantenimiento\solimanmaq.jasper');
                $jc->setFilename("SOLICITUD_DE_MTO_{$x['VALE']}_" . Date('dmYhis'));
                $jc->setDocumentformat('pdf');
                print $jc->getReport();
            } else {
                $this->db->insert("repomaqui", array(
                    "vale" => $x['VALE'],
                    "fecha" => $x['FECHA'],
                    "depto" => $x['DEPARTAMENTO_CLAVE'],
                    "codigo" => $x['CODIGO'],
                    "horalle" => $x['HORA_LLEGADA'],
                    "desdpro" => $x['DESCRIPCION_DEL_PROBLEMA'],
                    "ident" => 1));
                $jc = new JasperCommand();
                $jc->setFolder('rpt/' . $this->session->USERNAME);
                $pr ["logo"] = base_url() . $this->session->LOGO;
                $pr["empresa"] = $this->session->EMPRESA_RAZON;
                $pr["VALE"] = $x['VALE'];
                $jc->setParametros($pr);
                $jc->setJasperurl('jrxml\mantenimiento\solimanmaq.jasper');
                $jc->setFilename("SOLICITUD_DE_MTO_{$x['VALE']}_" . Date('dmYhis'));
                $jc->setDocumentformat('pdf');
                print $jc->getReport();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function onRevisarSiElValeExiste() {
        try {
            $x = $this->input->get();
            print json_encode($this->db->query("SELECT COUNT(*) AS EXISTE FROM repomaqui AS R WHERE R.vale = {$x['VALE']}")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString
            ();
        }
    }

    public function getSolicitudMtoXVale() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $pr ["logo"] = base_url() . $this->session->LOGO;
            $pr["empresa"] = $this->session->EMPRESA_RAZON;
            $pr["VALE"] = $x['VALE'];
            $jc->setParametros($pr);
            $jc->setJasperurl('jrxml\mantenimiento\solimanmaq.jasper');
            $jc->setFilename("SOLICITUD_DE_MTO_{$x['VALE']}_" . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            print $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
