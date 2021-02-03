<?php

class OrdenDeCompraMto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR' || 'PRODUCCION' || 'SUPERVISION':
                    $this->load->view('vNavGeneral')->view('vMenuProduccion')->view('vOrdenDeCompraMto')->view('vFooter');
                    break;
            }
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getHerramientas() {
        try {
           $data = $this->db->query("SELECT O.ID AS ID, DATE_FORMAT(O.Fecha,\"%d/%m/%Y\") AS FECHA, (SELECT OCP.Nombre FROM ordendecompramto_proveedores AS OCP WHERE OCP.ID = O.Proveedor LIMIT 1) AS PROVEEDOR,"
                                    . " O.DestinoMaterial AS DESTINO_MATERIAL, CONCAT(SUBSTRING(O.Observaciones,1,35),\"...\") AS OBSERVACIONES, "
                                    . "O.Folio AS FOLIO, "
                   . "CONCAT(\"$\",FORMAT((SELECT SUM(Cantidad*Precio)  "
                   . "FROM ordendecompramto_detalle AS OD WHERE OD.OrdenID = O.ID),2)) AS TOTAL, "
                   . "CONCAT('<button type=\"button\" onclick=\"getOrdenXFolioButton(\'',O.Folio,'\')\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-print\"></span> IMPRIMIR</button>') AS IMPRIME FROM ordendecompramto AS O ORDER BY O.ID DESC ")->result();
                
            print json_encode($data);
           } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUltimoFolio() {
        try {
            $EXISTEN_FOLIOS = $this->db->query("SELECT COUNT(*) AS EXISTEN_FOLIOS fROM ordendecompramto ORDER BY ID DESC LIMIT 1")->result();
            if (intval($EXISTEN_FOLIOS[0]->EXISTEN_FOLIOS) === 0) {
                 print json_encode($this->db->query("SELECT \"OCD-001\" ULTIMO_FOLIO, COUNT(*) AS NO_EXISTEN fROM ordendecompramto ORDER BY ID DESC LIMIT 1")->result());
            } else {
                print json_encode($this->db->query("SELECT CONCAT(\"OCD-\",LPAD(SUBSTR(Folio,5)+1,3,\"0\")) AS ULTIMO_FOLIO fROM ordendecompramto ORDER BY ID DESC LIMIT 1")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            $check_hmr = $this->db->query("SELECT COUNT(*) AS EXISTE FROM ordendecompramto WHERE Folio = '{$x['FOLIO']}}'")->result();
            switch (intval($check_hmr[0]->EXISTE)) {
                case 0:
                    $DETALLE = json_decode($x['DETALLE']);

                    $fecha = $x['FECHA'];
                    $dia = substr($fecha, 0, 2);
                    $mes = substr($fecha, 3, 2);
                    $anio = substr($fecha, 6, 4);
                    $tiempo = Date('h:i:s');
                    $this->db->insert("ordendecompramto", array(
                        "Fecha" => "$anio-$mes-$dia $tiempo",
                        "Proveedor" => $x['PROVEEDOR'],
                        "DestinoMaterial" => $x['DESTINO'],
                        "Observaciones" => $x['OBSERVACIONES'],
                        "Folio" => $x['FOLIO'],
                        "Registro" => Date('Y-m-d h:i:s'),
                        "Usuario" => $this->session->ID,
                        "UsuarioT" => $this->session->USERNAME,
                        "FacturaRemision" => $x['FACTURA'],
                    ));
                    $ID = $this->db->query("SELECT ID AS OrdenID FROM ordendecompramto WHERE Folio = '{$x['FOLIO']}'")->result();
                    $iva = 0;
                    foreach ($DETALLE as $k => $v) {
                        switch ($v->ESTATUS) {
                            case 1:
                                $this->db->insert("ordendecompramto_detalle", array(
                                    "OrdenID" => $ID[0]->OrdenID,
                                    "Cantidad" => $v->CANTIDAD,
                                    "Unidad" => $v->UNIDAD,
                                    "Descripcion" => $v->DESCRIPCION,
                                    "Precio" => $v->PRECIO,
                                    "Registro" => Date('Y-m-d h:i:s')
                                ));
                                switch (intval($x['FACTURA'])) {
                                    case 1:
                                        $iva += $v->CANTIDAD * $v->PRECIO;
                                        break;
                                    case 2:
                                        $iva = 0;
                                        break;
                                }
                                break;
                        }
                    }
                    $this->db->set('IVA', $iva * 0.16)->where('ID', $ID[0]->OrdenID)->update('ordendecompramto');
                    $l = new Logs("ORDEN DE COMPRA MANTENIMIENTO", "HA CREADO UNA ORDEN DE COMPRA MANTENIMIENTO CON EN EL FOLIO {$x['FOLIO']} .", $this->session);

                    break;
            }
            exit(0);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getOrdenXFolio() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["FOLIO"] = $x['FOLIO'];
            $jc->setJasperurl("jrxml\mantenimiento\orderndecompramto.jasper");
            $jc->setParametros($parametros);
            $jc->setFilename('ORDERDECOMPRAMTO_' . $x['FOLIO'] . '_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
            $l = new Logs("ORDEN DE COMPRA MANTENIMIENTO (IMPRIMIR)", "HA IMPRESO UNA ORDEN DE COMPRA MANTENIMIENTO CON EN EL FOLIO {$x['FOLIO']} .", $this->session);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUnidadesOrdenDeCompraMto() {
        try {
            print json_encode($this->db->query("SELECT U.ID, U.Nombre AS NOMBRE,U.Abreviacion AS ABREVIACION, CONCAT(U.Nombre, \" (\",U.Abreviacion,\")\") AS UNIDAD, DATE_FORMAT(U.Registro,\"%d/%m/%Y\") AS REGISTRO FROM ordendecompramto_unidades AS U ORDER BY Nombre ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedoresOrdenDeCompraMto() {
        try {
            print json_encode($this->db->query("SELECT ID, Nombre AS NOMBRE, Registro AS REGISTRO, Telefono AS TELEFONO FROM ordendecompramto_proveedores AS U ORDER BY Nombre ASC")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarUnidad() {
        try {
            $x = $this->input->post();
            $check_unidad = $this->db->query("SELECT COUNT(*) AS EXISTE FROM ordendecompramto_unidades WHERE Nombre ='{$x['NOMBRE']}' OR Abreviacion = '{$x['ABREVIATURA']}'")->result();
            switch (intval($check_unidad[0]->EXISTE)) {
                case 0:
                    $this->db->insert('ordendecompramto_unidades', array('Nombre' => $x['NOMBRE'], 'Abreviacion' => $x['ABREVIATURA']));
                    break;
            }
            $l = new Logs("ORDEN DE COMPRA MANTENIMIENTO (UNIDADES)", "HA CREADO LA UNIDAD {$x['NOMBRE']}.", $this->session);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarProveedorMto() {
        try {
            $x = $this->input->post();
            switch (intval($x['NUEVO'])) {
                case 1:
                    $check_proveedor = $this->db->query("SELECT COUNT(*) AS EXISTE FROM ordendecompramto_proveedores WHERE Nombre ='{$x['NOMBRE']}' ")->result();
                    switch (intval($check_proveedor[0]->EXISTE)) {
                        case 0:
                            $this->db->insert('ordendecompramto_proveedores', array('Nombre' => $x['NOMBRE'], 'Telefono' => $x['TELEFONO'] !== '' ? $x['TELEFONO'] : NULL));
                            break;
                    }
                    break;
                case 2:
                    $this->db->where('ID', $x['ID'])->update('ordendecompramto_proveedores', array('Nombre' => $x['NOMBRE'], 'Telefono' => $x['TELEFONO'] !== '' ? $x['TELEFONO'] : NULL));
                    break;
            }
            $l = new Logs("ORDEN DE COMPRA MANTENIMIENTO (PROVEEDOR)", "HA CREADO AL PROVEEDOR {$x['NOMBRE']}.", $this->session);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
