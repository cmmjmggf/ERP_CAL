<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class HistoricoClientePedidoFacturado extends CI_Controller {

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
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'CLIENTES':
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vHistoricoClientePedidoFacturado')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onImprimirReporteRanking() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Cliente"] = $this->input->post('Cliente');
        $parametros["nomCliente"] = $this->input->post('NomCliente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reporteRankingClienteEstiloColor.jasper');

        $jc->setFilename('REPORTE_PEDIDOS_CLIENTE_ENTREGADOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReportePedidoEntregadosCliente() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["Cliente"] = $this->input->post('Cliente');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\clientes\reportePedidosEntregadosCliente.jasper');

        $jc->setFilename('REPORTE_PEDIDOS_CLIENTE_ENTREGADOS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function getDetallePagosFactura() {
        $cte = $this->input->get('Cliente');
        $fact = $this->input->get('Factura');
        $tp = $this->input->get('Tp');
        print json_encode($this->db->query("select cpp.remicion,
                                                    date_format(cpp.fechadep, '%d/%m/%Y') as fechadep,
                                                    date_format(cpp.fechacap, '%d/%m/%Y') as fechacap,
                                                    cpp.importe, cpp.mov, cpp.doctopa, cpp.numpol,
                                                    datediff(cpp.fechadep,(select fecha from facturacion where cliente= cpp.cliente and factura = cpp.remicion and tp = cpp.tipo limit 1)) as dias
                                                    from cartctepagos cpp
                                                    where cpp.remicion  = $fact and cpp.cliente = $cte and cpp.tipo = $tp  ")->result());
    }

    public function getDetalleFactura() {
        $cte = $this->input->get('Cliente');
        $fact = $this->input->get('Factura');
        $tp = $this->input->get('Tp');
        print json_encode($this->db->query("select factura, tp, contped, date_format(fecha, '%d/%m/%Y') as fecha, pareped, estilo, combin, precto,subtot, staped as status, agente
                                            from facturacion where factura  = $fact and cliente = $cte and tp = $tp  ")->result());
    }

    public function getPedidosEntregados() {
        $cte = $this->input->get('Cliente');
        print json_encode($this->db->query("SELECT
                                            p.cliente, p.clave as pedido, p.maquila,
                                            date_format( str_to_date(p.fechapedido,'%d/%m/%Y') , '%d/%m/%Y') as fechaped,
                                            date_format( str_to_date(p.fechaentrega,'%d/%m/%Y') , '%d/%m/%Y') as fechaentrega,
                                            p.semana, p.pares, p.paresfacturados,
                                            p.control, p.estilo, p.color, p.precio,
                                            ifnull(C.EstatusProduccion,'PROGRAMADO') as avance
                                            FROM pedidox P
                                            left join controles C on C.control = P.control
                                            WHERE p.stsavan = 13 and p.cliente= $cte  ")->result());
    }

    public function getPedidosNoEntregados() {
        $cte = $this->input->get('Cliente');
        print json_encode($this->db->query("SELECT
                                            p.cliente, p.clave as pedido, p.maquila,
                                            date_format( str_to_date(p.fechapedido,'%d/%m/%Y') , '%d/%m/%Y') as fechaped,
                                            date_format( str_to_date(p.fechaentrega,'%d/%m/%Y') , '%d/%m/%Y') as fechaentrega,
                                            p.semana, p.pares, p.paresfacturados,
                                            p.control, p.estilo, p.color, p.precio,
                                            ifnull(C.EstatusProduccion,'PROGRAMADO') as avance
                                            FROM pedidox P
                                            left join controles C on C.control = P.control
                                            WHERE p.stsavan <> 13 and p.stsavan <> 14 and p.cliente= $cte  ")->result());
    }

    public function getCartCliente() {
        $cte = $this->input->get('Cliente');
        print json_encode($this->db->query("SELECT cliente,remicion, date_format(fecha, '%d/%m/%Y') as fecha, importe, pagos, saldo, status, numpol, tipo
                                            FROM cartcliente WHERE cliente = $cte ")->result());
    }

    public function getClientes() {
        try {
            print json_encode($this->db->select("C.Clave AS Clave, CONCAT(C.Clave, \" - \",C.RazonS) AS Cliente", false)
                                    ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoTodo() {
        $cte = $this->input->get('Cliente');
        $datos = array();
        /* 1. */
        $datos['UNO'] = json_encode($this->db->query("SELECT cte.Ciudad, cte.TelOficina, cte.TelPart, cte.EncargadoDePagos, edo.descripcion as Estado, ag.Descripcion as Agente  "
                        . "from clientes cte "
                        . "join estados edo on edo.clave = cte.estado "
                        . "join agentes ag on ag.clave = cte.agente "
                        . "where cte.clave = $cte ")->result());
        /* 2. */
        $datos['DOS'] = json_encode($this->db->query("SELECT "
                        . "sum(precio * pares) as pesosEntregados, "
                        . "sum(pares) as paresEntregados,"
                        . "date_format(MAX(str_to_date(fechaPedido,'%d/%m/%Y')),'%d/%m/%Y') as FechaPedido  "
                        . "FROM pedidox where cliente = $cte and stsavan = 13; ")->result());
        /* 3. */
        $datos['TRES'] = json_encode($this->db->query("SELECT "
                        . "sum(precio * pares) as pesosNoEntregados, "
                        . "sum(pares) as paresNoEntregados "
                        . "FROM pedidox where cliente = $cte and stsavan <> 13 and stsavan <> 14 ; ")->result());

        /* 4. */
        $datos['CUATRO'] = json_encode($this->db->query("SELECT ifnull(sum(pareped),0) as paresFacturadosUno ,ifnull(sum(subtot),0) as pesosFacturadosUno, "
                        . "(SELECT date_format(max(fecha),'%d/%m/%Y') as fecha
                                            FROM facturacion f
                                            where cliente= $cte and staped < 3 ) as fecha "
                        . "FROM facturacion  "
                        . "where cliente= $cte and tp = 1 and staped < 3 ; ")->result());
        /* 5. */
        $datos['CINCO'] = json_encode($this->db->query("SELECT ifnull(sum(pareped),0) as paresFacturadosDos ,ifnull(sum(subtot),0) as pesosFacturadosDos  "
                        . "FROM facturacion  "
                        . "where cliente= $cte and tp = 2 and staped < 3 ; ")->result());
        /* 6. */
        $datos['SEIS'] = json_encode($this->db->query("SELECT sum(pareped) as paresCancelados, sum(subtot) as pesosCancelados "
                        . "FROM facturacion  "
                        . "where cliente= $cte and staped = 3 ; ")->result());

        /* 7. */
        $datos['SIETE'] = json_encode($this->db->query("
                                select sum(A.pares) as ParesPagados, sum(A.pesospagados) as PesosPagados, date_format( max(A.fecha),'%d/%m/%Y') as ultPago
                                from
                                (SELECT ccp.tipo, ccp.remicion,
                                (select sum(pareped) from facturacion where factura = ccp.remicion and tp = ccp.tipo and cliente= ccp.cliente) as pares,
                                (select sum(subtot) from facturacion where factura = ccp.remicion and tp = ccp.tipo and cliente= ccp.cliente) as pesospagados,
                                ccp.fecha
                                FROM cartctepagos ccp
                                WHERE ccp.cliente = $cte and ccp.mov < 5
                                group by ccp.remicion) AS A
                                 ")->result());

        /* 8. */
        $datos['OCHO'] = json_encode($this->db->query("select sum(A.pares) as ParesDevueltos, sum(A.pesospagados) as ParesPagados, date_format( max(A.fecha),'%d/%m/%Y') as UltDevol
                            from
                            (SELECT ccp.tipo, ccp.remicion,
                            (select sum(pareped) from facturacion where factura = ccp.remicion and tp = ccp.tipo and cliente= ccp.cliente) as pares,
                            (select sum(subtot) from facturacion where factura = ccp.remicion and tp = ccp.tipo and cliente= ccp.cliente) as pesospagados,
                            ccp.fecha
                            FROM cartctepagos ccp
                            WHERE ccp.cliente = $cte and ccp.mov = 6
                            group by ccp.remicion) AS A")->result());

        /* 9. */
        $datos['NUEVE'] = json_encode($this->db->query("SELECT cast(AVG(datediff(
                                            ccp.fecha,
                                            (select fecha from facturacion where factura = ccp.remicion  and tp = ccp.tipo and cliente = ccp.cliente group by remicion)
                                            )) as signed) as diasPromedio,
                                            AVG(ccp.importe) as promedioPagos
                                            FROM cartctepagos ccp
                                            WHERE ccp.cliente = $cte and ccp.status = 1; ")->result());
        /* 10. */
        $datos['DIEZ'] = json_encode($this->db->query("SELECT sum(saldo) as saldo
                                            FROM cartcliente
                                            WHERE cliente = $cte  ")->result());

        print json_encode($datos);
    }

}
