<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AdendaCoppel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onComprobarFactura() {
        try {
            $x = $this->input->get();
            $EXISTE_FACTURA = $this->db->query("SELECT COUNT(*) AS EXISTE FROM facturas AS F WHERE F.numero ={$x['TIENDA']}  and factura = '{$x['FACTURA']}'")->result();
            $factura = $this->db->query("SELECT COUNT(*) AS EXISTE   FROM facturacion AS F WHERE F.factura = {$x['FACTURA']} AND F.tp = 1")->result();
            if (intval($EXISTE_FACTURA[0]->EXISTE) === 0 && intval($factura[0]->EXISTE) > 0) {
                $factura = $this->db->query("SELECT COUNT(*) AS EXISTE, SUM(subtot) AS SUBTOTAL, F.cliente AS CLIENTE,DATE_FORMAT(F.fecha,'%d/%m/%Y') AS FECHA_FACTURA FROM facturacion AS F WHERE F.factura = {$x['FACTURA']} AND F.tp = 1")->result();
                $pedidox = $this->db->query("SELECT P.FechaPedido AS FECHA_PEDIDO, P.Clave AS CLAVE_PEDIDO "
                                . " FROM pedidox AS p WHERE p.Control IN(SELECT F.contped FROM facturacion AS F WHERE F.factura = {$x['FACTURA']} AND F.tp = 1)  ")->result();
                $SUBTOTAL = floatval($factura[0]->SUBTOTAL);
                print json_encode(array("FACTURA_EXISTE" => intval($EXISTE_FACTURA[0]->EXISTE),
                    "CLIENTE" => $factura[0]->CLIENTE,
                    "FACTURA" => $factura[0]->EXISTE,
                    "FACTURA_ENCONTRADA" => 1,
                    "CLAVE_PEDIDO" => $pedidox[0]->CLAVE_PEDIDO,
                    "FECHA_FACTURA" => $factura[0]->FECHA_FACTURA,
                    "FECHA_PEDIDO" => $pedidox[0]->FECHA_PEDIDO,
                    "SUBTOTAL" => $SUBTOTAL, "DESCUENTO" => 0,
                    "IVA" => $SUBTOTAL * 0.16, "TOTAL" => $SUBTOTAL * 1.16));
            } else {
                print json_encode(array("FACTURA_EXISTE" => 0,
                    "FACTURA" => 0,
                    "FACTURA_ENCONTRADA" => 0,
                    "CLAVE_PEDIDO" => "", "FECHA_PEDIDO" => "",
                    "FECHA_FACTURA" => "", "CLIENTE" => "",
                    "SUBTOTAL" => 0, "DESCUENTO" => 0,
                    "IVA" => 0, "TOTAL" => 0));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDatosFactura() {
        try {
            $x = $this->input->get();
            $factura = $this->db->query("SELECT F.*, DATE_FORMAT(F.fecha,'%d/%m/%Y') AS _FECHA_ FROM facturacion AS F WHERE F.factura = {$x['FACTURA']}")->result();
            print json_encode($factura);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFacturasDetalles() {
        try {
            $x = $this->input->get();
            $this->db->select("FD.Factura AS FACTURA,
(SELECT T.numtda FROM facturas AS F INNER JOIN tiendas AS T ON F.NumeroBodega = T.numtda 
WHERE F.Factura = FD.Factura LIMIT 1) AS RAZON_SOCIAL, 
FD.EstiloCliente AS EST_CTE, 
FD.Talla AS TALLA, FD.Estilo4E AS EST_4E,  
FD.ParesPorPunto AS PARES, 
FD.PrecioPorPunto AS PRECIO, 
CONCAT('$',FORMAT(FD.PrecioPorPunto,2)) AS PRECIO_F, 
FD.PrecioConDescuento AS PRE_CON_DES,
CONCAT('$',FORMAT(FD.PrecioConDescuento,2)) AS PRE_CON_DES_F,
FD.CantidadPrepack AS CANTIDAD,
FD.PorcentajeDescuento AS PORCENTAJE_DESCUENTO, 
FD.MontoDelDescuento AS MONTO_DESCUENTO, 
FD.TotalItem AS TOTAL, 
CONCAT('$',FORMAT(FD.TotalItem,2)) AS TOTAL_F, 
FD.TotalConDescuentoItem AS TOTAL_CON_DESCUENTO,
CONCAT('$',FORMAT(FD.TotalConDescuentoItem,2)) AS TOTAL_CON_DESCUENTO_F", false)
                    ->from("facturasdetalles AS FD");
            if ($x['FACTURA'] !== '') {
                $this->db->where("FD.Factura", $x['FACTURA']);
            }
            if ($x['FACTURA'] === '') {
                $this->db->limit(1);
            }
            $this->db->order_by('FD.Factura', 'DESC');
            $data = $this->db->get()->result();
            print json_encode($data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardar() {
        try {
            $x = $this->input->post();
            $tienda_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM tiendas AS T WHERE T.numtda = {$x['TIENDA']}")->result();
            $facturadetalle_existe = $this->db->query("SELECT COUNT(*) AS EXISTE FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']} AND F.numcte= 2121")->result();
            if ($x['TIENDA'] !== '' && intval($tienda_existe[0]->EXISTE) > 0 && intval($facturadetalle_existe[0]->EXISTE) > 0) {
                $tienda = $this->db->query("SELECT * FROM tiendas AS T WHERE T.numtda = {$x['TIENDA']}")->result();
                $this->db->set("tienda", $x['TIENDA'])->where("numfac", $x['FACTURA'])->update("facturadetalle");
                $this->db->insert("facturas",
                        array("factura" => $x["FACTURA"],
                            "numero" => $x["TIENDA"],
                            "fechafactura" => $x["FECHA_FACTURA"],
                            "pedido" => $x["PEDIDO"],
                            "fechapedido" => $x["FECHA_PEDIDO"],
                            "referenciapedido" => $x["PEDIDO"],
                            "proveedor" => $tienda[0]->provee,
                            "tipoproveedor" => $tienda[0]->tpprov,
                            "nombrebodega" => $tienda[0]->nomtda,
                            "direccion" => $tienda[0]->dirtda,
                            "ciudad" => $tienda[0]->ciutda,
                            "codigopostal" => $tienda[0]->coptda,
                            "numerobodega" => $tienda[0]->numtda,
                            "cantidadlotes" => $x["CANTIDAD_LOTES"],
                            "importe" => $x["IMPORTE"],
                            "descuento" => $x["DESCUENTO"],
                            "subtotal" => $x["SUBTOTAL"],
                            "iva" => $x["IVA"],
                            "total" => $x["TOTAL"]
                ));
                $facturadetalle = $this->db->query("SELECT  SUBSTRING(REPLACE(F.descripcion,\" \",\"\"), -3) AS TALLA, F.* FROM facturadetalle AS F WHERE F.numfac = {$x['FACTURA']} and F.numcte = 2121")->result();
                foreach ($facturadetalle as $k => $v) {
                    $check_existe = $this->db->query("SELECT COUNT(*) AS EXISTE "
                                    . "FROM facturasdetalles AS F "
                                    . "WHERE F.factura = {$x["FACTURA"]} "
                                    . "AND F.EstiloCliente = {$v->noidentificado} "
                                    . "AND F.Talla = {$v->TALLA} LIMIT 1")->result();
                    if (intval($check_existe[0]->EXISTE) === 0) {
                        $this->db->insert("facturasdetalles",
                                array("Factura" => $x["FACTURA"],
                                    "EstiloCliente" => $v->noidentificado,
                                    "Talla" => $v->TALLA,
                                    "Estilo4E" => "{$v->descripcion}",
                                    "ParesPorPunto" => $v->cantidad,
                                    "PrecioPorPunto" => $v->Precio,
                                    "PrecioConDescuento" => $v->Precio,
                                    "CantidadPrepack" => $x["CANTIDAD_PREPACK"],
                                    "PorcentajeDescuento" => 0,
                                    "MontoDelDescuento" => 0,
                                    "TotalItem" => floatval($v->cantidad) * floatval($v->Precio),
                                    "TotalConDescuentoItem" => floatval($v->cantidad) * floatval($v->Precio),
                                    "numero" => $x["TIENDA"],
                                    "grupo" => 1
                        ));
                    } else {
//                        $TotalItem = floatval($v->cantidad) * floatval($v->Precio);
//                        $TotalConDescuentoItem = floatval($v->cantidad) * floatval($v->Precio);
//                        $ParesPorPunto = $v->ParesPorPunto + $v->cantidad;
//                        $this->db
//                                ->set("TotalItem", "{$TotalItem}")
//                                ->set("TotalConDescuentoItem", "{$TotalConDescuentoItem}")
//                                ->where("factura", $x["FACTURA"])
//                                ->where("EstiloCliente", $v->noidentificado)
//                                ->where("Talla", $v->TALLA)
//                                ->update("facturasdetalles");
                    }
//                    $this->db->set("cantidadlotes", $x['CANTIDAD_LOTES'])
//                            ->where("numero", $x["TIENDA"])
//                            ->where("factura", $x["FACTURA"])
//                            ->where("grupo", 0)
//                            ->update("facturasdetalles");
                }
                $l = new Logs("ADDENDA", "GENERO LA ADDENDA PARA LA FACTURA {$x['FACTURA']}, $" . number_format($x["TOTAL"], 2, ".", ","), $this->session);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSerieZeroPad($CONTROL) {
        try {
            return $this->db->query("SELECT S.Clave, 
(CASE 
WHEN length(S.T1)= 2 THEN CONCAT(S.T1,\"0\") WHEN length(S.T1)= 4 THEN REPLACE(S.T1,\".\",\"\")
END) AS T1, S.T1 AS XT1, 
(CASE 
WHEN length(S.T2)= 2 THEN CONCAT(S.T2,\"0\") WHEN length(S.T2)= 4 THEN REPLACE(S.T2,\".\",\"\")
END) AS T2, S.T2 AS XT2,
(CASE 
WHEN length(S.T3)= 2 THEN CONCAT(S.T3,\"0\") WHEN length(S.T3)= 4 THEN REPLACE(S.T3,\".\",\"\")
END) AS T3,  S.T3 AS XT3,
(CASE 
WHEN length(S.T4)= 2 THEN CONCAT(S.T4,\"0\") WHEN length(S.T4)= 4 THEN REPLACE(S.T4,\".\",\"\")
END) AS T4,  S.T4 AS XT4,
(CASE 
WHEN length(S.T5)= 2 THEN CONCAT(S.T5,\"0\") WHEN length(S.T5)= 4 THEN REPLACE(S.T5,\".\",\"\")
END) AS T5, S.T5 AS XT5, 
(CASE 
WHEN length(S.T6)= 2 THEN CONCAT(S.T6,\"0\") WHEN length(S.T6)= 4 THEN REPLACE(S.T6,\".\",\"\")
END) AS T6, S.T6 AS XT6, 
(CASE 
WHEN length(S.T7)= 2 THEN CONCAT(S.T7,\"0\") WHEN length(S.T7)= 4 THEN REPLACE(S.T7,\".\",\"\")
END) AS T7, S.T7 AS XT7, 
(CASE 
WHEN length(S.T8)= 2 THEN CONCAT(S.T8,\"0\") WHEN length(S.T8)= 4 THEN REPLACE(S.T8,\".\",\"\")
END) AS T8, S.T8 AS XT8, 
(CASE 
WHEN length(S.T9)= 2 THEN CONCAT(S.T9,\"0\") WHEN length(S.T9)= 4 THEN REPLACE(S.T9,\".\",\"\")
END) AS T9, S.T9 AS XT9,  
(CASE 
WHEN length(S.T10)= 2 THEN CONCAT(S.T10,\"0\") WHEN length(S.T10)= 4 THEN REPLACE(S.T10,\".\",\"\")
END) AS T10, S.T10 AS XT10,  
(CASE 
WHEN length(S.T11)= 2 THEN CONCAT(S.T11,\"0\") WHEN length(S.T11)= 4 THEN REPLACE(S.T11,\".\",\"\")
END) AS T11, S.T11 AS XT11,  
(CASE 
WHEN length(S.T12)= 2 THEN CONCAT(S.T12,\"0\") WHEN length(S.T12)= 4 THEN REPLACE(S.T12,\".\",\"\")
END) AS T12,S.T12 AS XT12,  
(CASE 
WHEN length(S.T13)= 2 THEN CONCAT(S.T13,\"0\") WHEN length(S.T13)= 4 THEN REPLACE(S.T13,\".\",\"\")
END) AS T13,S.T13 AS XT13,  
(CASE 
WHEN length(S.T14)= 2 THEN CONCAT(S.T14,\"0\") WHEN length(S.T14)= 4 THEN REPLACE(S.T14,\".\",\"\")
END) AS T14,S.T14 AS XT14, 
(CASE 
WHEN length(S.T15)= 2 THEN CONCAT(S.T15,\"0\") WHEN length(S.T15)= 4 THEN REPLACE(S.T15,\".\",\"\")
END) AS T15,S.T15 AS XT15,  
(CASE 
WHEN length(S.T16)= 2 THEN CONCAT(S.T16,\"0\") WHEN length(S.T16)= 4 THEN REPLACE(S.T16,\".\",\"\")
END) AS T16,S.T16 AS XT16, 
(CASE 
WHEN length(S.T17)= 2 THEN CONCAT(S.T17,\"0\") WHEN length(S.T17)= 4 THEN REPLACE(S.T17,\".\",\"\")
END) AS T17,S.T17 AS XT17, 
(CASE 
WHEN length(S.T18)= 2 THEN CONCAT(S.T18,\"0\") WHEN length(S.T18)= 4 THEN REPLACE(S.T18,\".\",\"\")
END) AS T18,S.T18 AS XT18, 
(CASE 
WHEN length(S.T19)= 2 THEN CONCAT(S.T19,\"0\") WHEN length(S.T19)= 4 THEN REPLACE(S.T19,\".\",\"\")
END) AS T19,S.T19 AS XT19, 
(CASE 
WHEN length(S.T20)= 2 THEN CONCAT(S.T20,\"0\") WHEN length(S.T20)= 4 THEN REPLACE(S.T20,\".\",\"\")
END) AS T20,S.T20 AS XT20, 
(CASE 
WHEN length(S.T21)= 2 THEN CONCAT(S.T21,\"0\") WHEN length(S.T21)= 4 THEN REPLACE(S.T21,\".\",\"\")
END) AS T21,S.T21 AS XT21, 
(CASE 
WHEN length(S.T22)= 2 THEN CONCAT(S.T22,\"0\") WHEN length(S.T22)= 4 THEN REPLACE(S.T22,\".\",\"\")
END) AS T22, S.T22 AS XT22 
FROM pedidox AS P INNER JOIN series AS S ON P.Serie = S.Clave AND P.Control = {$CONTROL} LIMIT 1")->result();
        } catch (Exception $ex) {
            
        }
    } 
}
