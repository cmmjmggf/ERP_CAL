<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Ordencompra_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getOrdenCompraByTpFolio($Tp, $Folio) {
        try {
            return $this->db->select("OC.*", false)->from("ordencompra AS OC")->where('OC.Tp', $Tp)->where('OC.Folio', $Folio)->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFolio($tp) {
        try {
            return $this->db->select("CONVERT(A.Folio, UNSIGNED INTEGER) AS Folio")->from("ordencompra AS A")
//                            ->where_in("A.Estatus", array("ACTIVO", "CERRADA"))
                            ->where("A.Tp", $tp)
                            ->order_by("Folio", "DESC")
                            ->limit(1)
                            ->get()
                            ->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosCabecero($Articulo, $Proveedor) {
        try {
            $this->db->select("
S.T1,
S.T2,
S.T3,
S.T4,
S.T5,
S.T6,
S.T7,
S.T8,
S.T9,
S.T10,
S.T11,
S.T12,
S.T13,
S.T14,
S.T15,
S.T16,
S.T17,
S.T18,
S.T19,
S.T20,
S.T21,
S.T22,
sc.A1	,
sc.A2	,
sc.A3	,
sc.A4	,
sc.A5	,
sc.A6	,
sc.A7	,
sc.A8	,
sc.A9	,
sc.A10	,
sc.A11	,
sc.A12	,
sc.A13	,
sc.A14	,
sc.A15	,
sc.A16	,
sc.A17	,
sc.A18	,
sc.A19	,
sc.A20	,
sc.A21	,
sc.A22	,
CASE WHEN A1.ProveedorUno ='$Proveedor'  THEN A1.PrecioUno  WHEN A1.ProveedorDos ='$Proveedor'  THEN A1.PrecioDos  WHEN A1.ProveedorTres ='$Proveedor'  THEN A1.PrecioTres END AS P1,
CASE WHEN A2.ProveedorUno ='$Proveedor'  THEN A2.PrecioUno  WHEN A2.ProveedorDos ='$Proveedor'  THEN A2.PrecioDos  WHEN A2.ProveedorTres ='$Proveedor'  THEN A2.PrecioTres END AS P2,
CASE WHEN A3.ProveedorUno ='$Proveedor'  THEN A3.PrecioUno  WHEN A3.ProveedorDos ='$Proveedor'  THEN A3.PrecioDos  WHEN A3.ProveedorTres ='$Proveedor'  THEN A3.PrecioTres END AS P3,
CASE WHEN A4.ProveedorUno ='$Proveedor'  THEN A4.PrecioUno  WHEN A4.ProveedorDos ='$Proveedor'  THEN A4.PrecioDos  WHEN A4.ProveedorTres ='$Proveedor'  THEN A4.PrecioTres END AS P4,
CASE WHEN A5.ProveedorUno ='$Proveedor'  THEN A5.PrecioUno  WHEN A5.ProveedorDos ='$Proveedor'  THEN A5.PrecioDos  WHEN A5.ProveedorTres ='$Proveedor'  THEN A5.PrecioTres END AS P5,
CASE WHEN A6.ProveedorUno ='$Proveedor'  THEN A6.PrecioUno  WHEN A6.ProveedorDos ='$Proveedor'  THEN A6.PrecioDos  WHEN A6.ProveedorTres ='$Proveedor'  THEN A6.PrecioTres END AS P6,
CASE WHEN A7.ProveedorUno ='$Proveedor'  THEN A7.PrecioUno  WHEN A7.ProveedorDos ='$Proveedor'  THEN A7.PrecioDos  WHEN A7.ProveedorTres ='$Proveedor'  THEN A7.PrecioTres END AS P7,
CASE WHEN A8.ProveedorUno ='$Proveedor'  THEN A8.PrecioUno  WHEN A8.ProveedorDos ='$Proveedor'  THEN A8.PrecioDos  WHEN A8.ProveedorTres ='$Proveedor'  THEN A8.PrecioTres END AS P8,
CASE WHEN A9.ProveedorUno ='$Proveedor'  THEN A9.PrecioUno  WHEN A9.ProveedorDos ='$Proveedor'  THEN A9.PrecioDos  WHEN A9.ProveedorTres ='$Proveedor'  THEN A9.PrecioTres END AS P9,
CASE WHEN A10.ProveedorUno ='$Proveedor'  THEN A10.PrecioUno  WHEN A10.ProveedorDos ='$Proveedor'  THEN A10.PrecioDos  WHEN A10.ProveedorTres ='$Proveedor'  THEN A10.PrecioTres END AS P10,
CASE WHEN A11.ProveedorUno ='$Proveedor'  THEN A11.PrecioUno  WHEN A11.ProveedorDos ='$Proveedor'  THEN A11.PrecioDos  WHEN A11.ProveedorTres ='$Proveedor'  THEN A11.PrecioTres END AS P11,
CASE WHEN A12.ProveedorUno ='$Proveedor'  THEN A12.PrecioUno  WHEN A12.ProveedorDos ='$Proveedor'  THEN A12.PrecioDos  WHEN A12.ProveedorTres ='$Proveedor'  THEN A12.PrecioTres END AS P12,
CASE WHEN A13.ProveedorUno ='$Proveedor'  THEN A13.PrecioUno  WHEN A13.ProveedorDos ='$Proveedor'  THEN A13.PrecioDos  WHEN A13.ProveedorTres ='$Proveedor'  THEN A13.PrecioTres END AS P13,
CASE WHEN A14.ProveedorUno ='$Proveedor'  THEN A14.PrecioUno  WHEN A14.ProveedorDos ='$Proveedor'  THEN A14.PrecioDos  WHEN A14.ProveedorTres ='$Proveedor'  THEN A14.PrecioTres END AS P14,
CASE WHEN A15.ProveedorUno ='$Proveedor'  THEN A15.PrecioUno  WHEN A15.ProveedorDos ='$Proveedor'  THEN A15.PrecioDos  WHEN A15.ProveedorTres ='$Proveedor'  THEN A15.PrecioTres END AS P15,
CASE WHEN A16.ProveedorUno ='$Proveedor'  THEN A16.PrecioUno  WHEN A16.ProveedorDos ='$Proveedor'  THEN A16.PrecioDos  WHEN A16.ProveedorTres ='$Proveedor'  THEN A16.PrecioTres END AS P16,
CASE WHEN A17.ProveedorUno ='$Proveedor'  THEN A17.PrecioUno  WHEN A17.ProveedorDos ='$Proveedor'  THEN A17.PrecioDos  WHEN A17.ProveedorTres ='$Proveedor'  THEN A17.PrecioTres END AS P17,
CASE WHEN A18.ProveedorUno ='$Proveedor'  THEN A18.PrecioUno  WHEN A18.ProveedorDos ='$Proveedor'  THEN A18.PrecioDos  WHEN A18.ProveedorTres ='$Proveedor'  THEN A18.PrecioTres END AS P18,
CASE WHEN A19.ProveedorUno ='$Proveedor'  THEN A19.PrecioUno  WHEN A19.ProveedorDos ='$Proveedor'  THEN A19.PrecioDos  WHEN A19.ProveedorTres ='$Proveedor'  THEN A19.PrecioTres END AS P19,
CASE WHEN A20.ProveedorUno ='$Proveedor'  THEN A20.PrecioUno  WHEN A20.ProveedorDos ='$Proveedor'  THEN A20.PrecioDos  WHEN A20.ProveedorTres ='$Proveedor'  THEN A20.PrecioTres END AS P20,
CASE WHEN A21.ProveedorUno ='$Proveedor'  THEN A21.PrecioUno  WHEN A21.ProveedorDos ='$Proveedor'  THEN A21.PrecioDos  WHEN A21.ProveedorTres ='$Proveedor'  THEN A21.PrecioTres END AS P21,
CASE WHEN A22.ProveedorUno ='$Proveedor'  THEN A22.PrecioUno  WHEN A22.ProveedorDos ='$Proveedor'  THEN A22.PrecioDos  WHEN A22.ProveedorTres ='$Proveedor'  THEN A22.PrecioTres END AS P22

FROM lobo_solo.suelascompras  sc
LEFT JOIN articulos A1 	ON A1.Clave =   sc.A1
LEFT JOIN articulos A2	ON A2.Clave =	sc.A2
LEFT JOIN articulos A3	ON A3.Clave =	sc.A3
LEFT JOIN articulos A4	ON A4.Clave =	sc.A4
LEFT JOIN articulos A5	ON A5.Clave =	sc.A5
LEFT JOIN articulos A6	ON A6.Clave =	sc.A6
LEFT JOIN articulos A7	ON A7.Clave =	sc.A7
LEFT JOIN articulos A8	ON A8.Clave =	sc.A8
LEFT JOIN articulos A9	ON A9.Clave =	sc.A9
LEFT JOIN articulos A10	ON A10.Clave =	sc.A10
LEFT JOIN articulos A11	ON A11.Clave =	sc.A11
LEFT JOIN articulos A12	ON A12.Clave =	sc.A12
LEFT JOIN articulos A13	ON A13.Clave =	sc.A13
LEFT JOIN articulos A14	ON A14.Clave =	sc.A14
LEFT JOIN articulos A15	ON A15.Clave =	sc.A15
LEFT JOIN articulos A16	ON A16.Clave =	sc.A16
LEFT JOIN articulos A17	ON A17.Clave =	sc.A17
LEFT JOIN articulos A18	ON A18.Clave =	sc.A18
LEFT JOIN articulos A19	ON A19.Clave =	sc.A19
LEFT JOIN articulos A20	ON A20.Clave =	sc.A20
LEFT JOIN articulos A21	ON A21.Clave =	sc.A21
LEFT JOIN articulos A22	ON A22.Clave =	sc.A22
JOIN series S ON sc.Serie = S.Clave
where sc.ArticuloCBZ= '$Articulo' ", false);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPorcentajesCompraByProveedor($Proveedor) {
        try {
            $this->db->select("P.PorcentajeComprasPorPedidoF PorFactura , "
                            . "PorcentajeComprasPorPedidoR PorRemision "
                            . " ", false)
                    ->from("proveedores AS P")
                    ->where('P.Clave', $Proveedor);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPrecioCompraByArticuloByProveedor($Articulo, $Proveedor) {
        try {
            $this->db->select(" "
                            . "CASE WHEN  A.ProveedorUno = '" . $Proveedor . "' THEN A.PrecioUno "
                            . "WHEN  A.ProveedorDos = '" . $Proveedor . "' THEN A.PrecioDos "
                            . "WHEN  A.ProveedorTres = '" . $Proveedor . "' THEN A.PrecioTres "
                            . "END AS Precio "
                            . " ", false)
                    ->from("articulos AS A")
                    ->where('A.Clave', $Articulo);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticuloByDeptoByProveedor($Depto, $Proveedor) {
        try {
            $this->db->select(" CONVERT(A.Clave, UNSIGNED INTEGER) AS CLAVE , CONCAT(A.Clave,'-',A.Descripcion) AS Articulo"
                            . " ", false)
                    ->from("articulos AS A")
                    ->where('A.Departamento', $Depto)
                    ->where('A.ProveedorUno', $Proveedor)
                    ->or_where('A.ProveedorDos', $Proveedor)
                    ->or_where('A.ProveedorTres', $Proveedor)
                    ->where('A.Estatus', 'ACTIVO')
                    ->order_by('CLAVE', 'ASC');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCabecerosByProveedor($Proveedor) {
        try {
            $this->db->select(" CONVERT(SC.ArticuloCBZ, UNSIGNED INTEGER) AS CLAVE , CONCAT(A.Clave,'-',A.Descripcion) AS Articulo"
                            . " ", false)
                    ->from("suelascompras AS SC")
                    ->join("articulos AS A", 'ON SC.ArticuloCBZ = A.Clave')
                    ->where('SC.Estatus', 'ACTIVO')
                    ->where('A.ProveedorUno', $Proveedor)
                    ->or_where('A.ProveedorDos', $Proveedor)
                    ->or_where('A.ProveedorTres', $Proveedor)
                    ->order_by('CLAVE', 'ASC');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
//            print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarMaquilas($Clave) {
        try {
            return $this->db->select("G.Clave, G.Direccion")->from("maquilas AS G")->where("G.Clave", $Clave)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarSemanasProduccion($Clave, $Ano) {
        try {
            return $this->db->select("G.Sem")->from("semanasproduccion AS G")->where("G.Sem", $Clave)->where("G.Ano", $Ano)->where("G.Estatus", "ACTIVO")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdCerrada($Ano, $Maq, $Sem) {
        try {
            $this->db->select("G.Estatus")->from("semanasproduccioncerradas AS G")
                    ->where("G.Ano", $Ano)
                    ->where("G.Maq", $Maq)
                    ->where("G.Sem", $Sem);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarSemanaProdDepartamentoCerrada($Ano, $Maq, $Sem, $Depto) {
        try {
            $this->db->select("G.Estatus")->from("semanasproduccioncerradasdepartamento AS G")
                    ->where("G.Departamento", $Depto)
                    ->where("G.Ano", $Ano)
                    ->where("G.Maq", $Maq)
                    ->where("G.Sem", $Sem);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProveedores() {
        try {
            return $this->db->select("P.Clave AS ID, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreI,'')) AS ProveedorI, "
                                    . "CONCAT(P.Clave,' ',IFNULL(P.NombreF,'')) AS ProveedorF ", false)
                            ->from("proveedores AS P")->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($Tp, $Folio, $DATA) {
        try {
            $this->db->where('Tp', $Tp)->where('Folio', $Folio)->update("ordencompra", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCancelar($Tp, $Folio) {
        try {
            $this->db->set('Estatus', 'CANCELADA')->where('Tp', $Tp)->where('Folio', $Folio)->update("ordencompra");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* DETALLE */

    /* AGRUPAR POR TALLAS */

    public function getOrdenCompraTallasTemp() {
        try {
            $this->db->query("SET sql_mode = '';");
            $this->db->select('Tp, Proveedor, Tipo, Folio, FechaOrden, FechaCaptura, '
                    . 'FechaEntrega, ConsignarA, Sem, Maq, Ano, '
                    . 'Observaciones, Estatus, Usuario, '
                    . 'Articulo, sum(Cantidad) AS Cantidad, '
                    . 'Precio, sum(SubTotal) AS Subtotal '
                    . '', false);
            $this->db->from('ordencompratallastemp AS OCDT');
            $this->db->group_by('Articulo');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleParaSepararByID($Tp, $Folio) {
        try {
            $this->db->select('OCD.ID, OCD.Articulo, OCD.Cantidad, OCD.Precio, OCD.Subtotal '
                    . '', false);
            $this->db->from('ordencompra AS OCD')
                    ->where('OCD.Folio', $Folio)
                    ->where('OCD.Tp', $Tp);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleByID($Tp, $Folio) {
        try {
            $this->db->select('OCD.ID,'
                    . 'OCD.Articulo AS ClaveArticulo,'
                    . "CONCAT(A.Clave,'-',A.Descripcion) AS Articulo,"
                    . 'OCD.Cantidad,'
                    . 'UM.Descripcion AS Unidad,'
                    . "OCD.Precio AS Precio,"
                    . "OCD.Subtotal AS Subtotal,"
                    . 'CONCAT(\'<span class="fa fa-trash fa-lg" onclick="onEliminarDetalleByID(\',OCD.ID,\')">\',\'</span>\') AS Eliminar'
                    . '', false);
            $this->db->from('ordencompra AS OCD')
                    ->join('articulos AS A', 'A.Clave = OCD.Articulo', 'left')
                    ->join('unidades AS UM', 'A.UnidadMedida = UM.Clave', 'left')
                    ->where('OCD.Tp', $Tp)
                    ->where('OCD.Folio', $Folio);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarDetalleByID($ID) {
        try {
            $this->db->where('ID', $ID);
            $this->db->delete("ordencompra");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarDetalle($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)->update("ordencompra", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* REPORTES */

    public function getDatosEmpresa() {
        try {
            $this->db->select("E.RazonSocial as Empresa, E.Foto as Logo,"
                            . "CONCAT(E.Direccion,' ',E.NoExt,' Col. ',E.Colonia) AS Direccion, "
                            . "CONCAT(E.Ciudad,', ',EDOS.Descripcion,'  Tel. 1464646 AL 49   E-mail: compras@lobosolo.com.mx') AS Direccion2 "
                            . " ", false)
                    ->from('empresas AS E')
                    ->join('estados AS EDOS', 'EDOS.Clave = E.Estado');

            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporteOrdenCompra($Tp, $Folio) {
        try {
            $this->db->select(''
                    . 'OC.Tp,'
                    . 'OC.Folio,'
                    . 'OC.FechaOrden,'
                    . 'OC.FechaCaptura,'
                    . 'OC.Estatus,'
                    . "OC.Proveedor,"
                    . "CASE WHEN OC.Tp = '1' THEN "
                    . "P.NombreF "
                    . "ELSE P.NombreI "
                    . "END AS NombreProveedor,"
                    . "OC.ConsignarA,"
                    . "OC.Observaciones,"
                    . "OC.Cantidad,"
                    . "U.Descripcion AS Unidad,"
                    . "OC.Articulo,"
                    . "A.Descripcion AS NombreArticulo,"
                    . "OC.Precio,"
                    . "OC.SubTotal,"
                    . "OC.Sem,"
                    . "OC.Maq,"
                    . "OC.FechaEntrega, "
                    . "OC.Factura,"
                    . "OC.CantidadRecibida "
                    . '', false);
            $this->db->from('ordencompra AS OC')
                    ->join('proveedores AS P', 'OC.Proveedor = P.Clave')
                    ->join('articulos AS A', ' A.Clave = OC.Articulo')
                    ->join('unidades AS U', 'U.Clave = A.UnidadMedida')
                    ->where('OC.Tp', $Tp)
                    ->where('OC.Folio', $Folio)
                    ->order_by('OC.Articulo', 'ASC');
//                    ->where('OC.Tp', $TP);
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            //print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
