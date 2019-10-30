<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/phpqrcode/qrlib.php";

class NotasCreditoClientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('Notacreditoclientes_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuClientes');
                    break;
                case 'VENTAS':
                    $this->load->view('vMenuClientes');
                    break;
                case 'FACTURACION':
                    $this->load->view('vMenuClientes');
                    break;
            }
            $this->load->view('vFondo')->view('vNotasCreditoClientes')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onCerrarNC() {
        try {
            $x = $this->input->post();
            $status = ($x['Tp'] === '1') ? 0 : 1;
            $notcred = $this->db->query("SELECT * FROM notcred  WHERE nc = {$x['nc']} and status = $status and tp = {$x['Tp']} and cliente = {$x['Cliente']} ")->result();

            $fechacap = str_replace('/', '-', $x['fechacap']);
            $nuevafechacap = date("Y-m-d", strtotime($fechacap));
            //Verificamos en los renglones de la nota de crédito
            foreach ($notcred as $key => $v) {
                $txtnc = $v->nc;
                $txtcliente = $v->cliente;
                $txtnumfac = $v->numfac;
                $txttp = $v->tp;
                $txtfecha = $v->fecha;
                $txtdesc = $v->descripcion;
                $txtsubtot = $v->subtot;
                $txtorden = $v->orden;
                $txtuuid = $v->uuid;
                $txttmnda = $v->tmnda;
                //Registramos el pago correspondiente
                $datospago = array(
                    'cliente' => $txtcliente,
                    'remicion' => $txtnumfac,
                    'tipo' => $txttp,
                    'mov' => $txtorden,
                    'fecha' => $txtfecha,
                    'fechadep' => $txtfecha,
                    'fechacap' => $nuevafechacap,
                    'doctopa' => $txtdesc,
                    'importe' => $txtsubtot,
                    'agente' => $x['agente'],
                    'status' => 1,
                    'nc' => $txtnc,
                    'control' => 0,
                    'uuid' => ($txttp === '1') ? $txtuuid : 0
                );
                $this->db->insert("cartctepagos", $datospago);
            }

            //Capturamos el pago de IVA del total de la nota de crédito desglosado
            $txtiva = 0;
            if ($x['Tp'] === '1') {
                if (intval($txttmnda) > 1) {
                    $txtiva = 0;
                } else {
                    $txtiva = floatval($x['total']) * 0.16;
                }
            }
            //Registramos el iva del pago correspondiente
            $datospagoIVA = array(
                'cliente' => $txtcliente,
                'remicion' => $txtnumfac,
                'tipo' => $txttp,
                'mov' => $txtorden,
                'fecha' => $txtfecha,
                'fechadep' => $txtfecha,
                'fechacap' => $nuevafechacap,
                'doctopa' => 'IVA N-C ' . $txtnc,
                'importe' => $txtiva,
                'agente' => $x['agente'],
                'status' => 3,
                'nc' => $txtnc,
                'control' => 0,
                'uuid' => ($txttp === '1') ? $txtuuid : 0
            );
            $this->db->insert("cartctepagos", $datospagoIVA);

            //Actualiza statua a nota de crédito
            $statusnc = ($x['Tp'] === '1') ? 0 : 2;
            $sql = "update notcred set status = {$statusnc} , monletra = '{$x['totalletra']}' "
                    . " WHERE nc = {$x['nc']} and tp = {$x['Tp']} and cliente = {$x['Cliente']} ";
            $this->db->query($sql);
            //Actualizamos el saldo de la cartera de clientes
            $cartcliente = $this->db->query("SELECT * FROM cartcliente  WHERE remicion = {$txtnumfac} and tipo = {$txttp} and cliente = {$txtcliente} ")->result();
            $txtsaldo = $cartcliente[0]->saldo;
            $txtpagos = $cartcliente[0]->pagos;
            $id = $cartcliente[0]->ID;
            if ($txttp === '1') {
                if (intval($txttmnda) > 1) {
                    $txtsaldo = floatval($txtsaldo) - floatval($x['total']);
                    $txtpagos = floatval($txtpagos) + floatval($x['total']);
                } else {
                    $txtsaldo = floatval($txtsaldo) - floatval($x['total']) - floatval($txtiva);
                    $txtpagos = floatval($txtpagos) + floatval($x['total']) + floatval($txtiva);
                }
            } else {
                $txtsaldo = floatval($txtsaldo) - floatval($x['total']);
                $txtpagos = floatval($txtpagos) + floatval($x['total']);
            }

            //Actualizamos la cartera con el nuevo saldo y los pagos correspondientes
            $stscartcliente = 0;
            if (floatval($txtsaldo) <= 0.1) {
                $txtsaldo = 0;
                $stscartcliente = 3;
            } else if (floatval($txtsaldo) > 0) {
                $stscartcliente = 2;
            }


            $datosCartCliente = array(
                'saldo' => $txtsaldo,
                'pagos' => $txtpagos,
                'status' => $stscartcliente
            );
            $this->db->where('ID', $id);
            $this->db->update('cartcliente', $datosCartCliente);
            //Actualiza los días de diferencia de la fecha pago en relacion a la fecha de factura
            $sql2 = " update cartctepagos cp
                        join cartcliente cc on cc.cliente = cp.cliente and cc.remicion = cp.remicion and cc.tipo = cp.tipo
                        set cp.numfol = datediff(cp.fecha, cc.fecha)
                        where cp.numfol = 0 ";
            $this->db->query($sql2);
            //Timbra e imprime
            if ($x['Tp'] === '1') {
                /*                 * ********************** Timbrar.exe ***************** */
                $this->onImprimirReporteNotaCreditoTp1Local($x['Tp'], $x['nc'], $x['Cliente']);
            } else {
                $this->onImprimirReporteNotaCreditoTp2Local($x['Tp'], $x['nc'], $x['Cliente']);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $Folio = 0;
            $x = $this->input->post();
            $nuevo = $x['nuevo'];

            if ($nuevo === '1') {//Si es nuevo trae el nuevo folio
                if ($x['tp'] === '1') {
                    $Folio = $this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc < 10000  and tp = 1 ; ")->result()[0]->nc;
                } else {
                    $Folio = $this->db->query("SELECT max(nc)+1 as nc FROM notcred  WHERE nc > 0  and tp = 2 ; ")->result()[0]->nc;
                }
            } else {//Si no usa el folio actual en uso
                $Folio = $x['folioact'];
            }


            $fecha = str_replace('/', '-', $x['fecha']);
            $nuevafecha = date("Y-m-d", strtotime($fecha));

            $datos = array(
                'nc' => $Folio,
                'tp' => $x['tp'],
                'cliente' => $x['cliente'],
                'numfac' => $x['numfac'],
                'orden' => $x['orden'],
                'fecha' => $nuevafecha,
                'hora' => Date('h:i:s A'),
                'cant' => 1,
                'descripcion' => $x['descripcion'] . $Folio,
                'precio' => $x['precio'],
                'subtot' => $x['subtot'],
                'concepto' => 0,
                'defecto' => $x['defecto'],
                'detalle' => $x['detalle'],
                'status' => ($x['tp'] === '1') ? 0 : 1,
                'tmnda' => ($x['tmnda'] === '0') ? 0 : $x['tmnda'],
                'tcamb' => ($x['tmnda'] === '0') ? 0 : $x['tcamb'],
                'tp' => $x['tp'],
                'uuid' => ($x['tp'] === '1') ? $x['uuid'] : 0
            );
            $this->db->insert("notcred", $datos);
            print $Folio;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUUID() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("select uuid from cfdifa where Factura = $Remicion and numero = $Tp ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarDocumento() {
        try {
            $Remicion = $this->input->get('Remicion');
            $Cliente = $this->input->get('Cliente');
            $Tp = $this->input->get('Tp');
            print json_encode($this->db->query("select importe, pagos, saldo, status, date_format(fecha,'%d/%m/%Y') as fecha "
                                    . " from cartcliente "
                                    . " where cliente = '$Cliente' and remicion = '$Remicion' and tipo = $Tp ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            print json_encode($this->db->query("select * from clientes where clave = '$Cliente' and estatus = 'ACTIVO' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getDetalleNC() {
        try {
            $cte = $this->input->get('Cliente');
            $tp = $this->input->get('Tp');
            $doc = $this->input->get('NC');
            print json_encode($this->db->query("select nc, cliente, numfac, orden, date_format(fecha,'%d/%m/%Y') as fecha, descripcion, precio, subtot
                                                from notcred where cliente = $cte and tp = $tp and nc = $doc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRecords() {
        try {
            $cte = $this->input->get('Cliente');
            print json_encode($this->db->query("SELECT
                                                cliente, remicion as docto, tipo,
                                                date_format(fecha,'%d/%m/%Y') as fecha, importe, pagos, importe-pagos as saldo,
                                                status, datediff(now(),fecha) as dias
                                                FROM cartcliente
                                                where cliente = '$cte'
                                                and status < 3
                                                and saldo > 5 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNotasByTpByCliente() {
        try {
            $cte = $this->input->get('Cliente');
            $tipo = $this->input->get('Tp');
            print json_encode($this->db->query("SELECT nc FROM notcred "
                                    . " where cliente = $cte and tp = $tipo group by nc order by nc asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirReporteNotaCreditoTp1Local($pTp, $pFolio, $pCliente) {
        $Tp = $pTp;
        $Folio = $pFolio;
        $Cliente = $pCliente;

        $Documento = $this->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto, df.Descripcion as nomdefecto, nc.detalle, dt.Descripcion as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join defectos df on df.clave= nc.defecto
                                        left join defectosdetalle dt on dt.clave= nc.detalle
                                        where nc.cliente= $Cliente
                                        and nc.tp = $Tp
                                        and nc.nc = $Folio ")->result();


        if (!empty($Documento)) {

            $pdf = new PDFNotaCreditoClientes('P', 'mm', array(215.9, 279.4));
            $pdf->setCliente($Cliente . ' ' . $Documento [0]->RazonS);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Documento[0]->fecha . ' ' . $Documento [0]->hora);
            $pdf->setDoc($Documento[0]->numfac);

            $pdf->setRfc($Documento[0]->RFC);
            $pdf->setDireccion($Documento[0]->Direccion);
            $pdf->setColonia($Documento[0]->Colonia);
            $pdf->setCiudad($Documento[0]->Ciudad . ', ' . $Documento [0]->nomestado);
            $pdf->setCp($Documento[0]->CodigoPostal);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('9999'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(80, 3, utf8_decode($D->descripcion), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format($D->precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(25, 3, '$' . number_format($D->subtot, 2, ".", ","), 0/* BORDE */, 1, 'R');

                $pdf->SetFont('Calibri', 'B', 6.5);
                $pdf->SetX(5);
                $pdf->Cell(50, 3, utf8_decode('Clave Producto:' . ' ' . '53111802 Sandalias para mujer'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(40, 3, utf8_decode('Clave Unidad: PR Par'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', '', 6.5);
                $pdf->Cell(50, 3, '03565385-B983-4A21-A6E0-F2DCF1D19282', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '9490-F', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', 'B', 6.5);
                $pdf->Cell(30, 3, utf8_decode('Traslado: IVA 16%= ') . '$' . number_format($D->subtot * 0.16, 2, ".", ","), 0/* BORDE */, 1, 'L');

                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());
                $TP_IMPORTE += $D->subtot;
            }
            /* Importes */
            $pdf->SetY($pdf->GetY() + 1);
            $pdf->SetFont('Calibri', 'B', 8);
            $aligns = array('L', 'L', 'L', 'C', 'C', 'R', 'R');
            $pdf->SetAligns($aligns);
            $pdf->Row(array('', '', '', '', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'I.V.A. 16%:', '$' . number_format($TP_IMPORTE * 0.16, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'Total:', '$' . number_format($TP_IMPORTE + ($TP_IMPORTE * 0.16), 2, ".", ","),), 0, false);

            $pdf->SetY($pdf->GetY());
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(60, 4, utf8_decode($Documento[0]->monletra), 0/* BORDE */, 0, 'L');

            /* Observaciones */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(150, 4, utf8_decode($Documento[0]->concepto), 0/* BORDE */, 1, 'L');


            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 4, utf8_decode('La reproducción no autorizada de este comprobante constituye un delito en los términos de las disposiciones fiscales.'), 0/* BORDE */, 1, 'L');

            /* Regimen fiscal */
            $pdf->SetY($pdf->GetY() + 7);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('601 General de Ley Personas Morales'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado TITULOS  */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Folio Fiscal/UUID:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Fecha Timbrado:'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado SAT:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado del Emisor:'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado DATOS  */
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('870BE2C8-92B9-4019-BA08-1977F9A3A1B5' . ' ' . '3.3'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('24/07/2019 05:50:03 p.m.'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000404594081'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000401998453'), 0/* BORDE */, 1, 'L');

            /* SELLOS */
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital CFD:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('g2jKdXkSg4TFMrfoNHO/XwDQndbdnEmMYl+y/Hnx6D6MzLG6HUayhNMIsUdgYwmSx66487IJmelShtSnRs8fPtehkmxuRcmtAmV1HMrgfyVFnluh0NHY4qJjdwGNG+n15+9jkoYrvb3qHT5UzdQ0QRS7a7BVI1+xY4K4OqVf5gX19qqj6p451tQxO2hXLqO0KhMK/uoTpc1LeAT2pvFZSXT5bRyOOTyE2/dpEi3pHBQS/I1rx1qzKtXhjzPgPSm'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('OJkUGTrTiA61UiGTz/UxwgnWBijRx4jN24xvdFEQOcUP9duBXdOSBqz1JrD2ym7ycdbPohCgjsznF1IjdD6+LM1lmtGAPhnLTx+9nMt5YUqCK9/+cZpAyQVgoeP64X0vw/L86vilJ8svacBTsEdw3dYe9ztn5pf5qksmlfA29Wdqmy7Pe7LZ1Xg2lPCHWPI5GLqs1+U34bhXC3vIbAu4UCMKPizX8WyOGgtjpHDy0Uu4oWYZIbgxbd2cbqm2XfZ'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Cadena Original del Complemento de Certificación Digital del SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('||1.1|3ddac28e-f737-4907-90b7-f596d982c759|2019-07-03t12:28:02z|g2jkdxksg4tfmrfonho/xwdqndbdnemmyl+y/hnx6d6mzlg6huayhnmisudgywmsx66487ijmelshtsnrs8fptehkmxurcmtamv1hmrgfyvfnluh0nhy4qjjdwgng+n15+9jkoyrvb3qht5uzdq0qrs7a7bvi1+xy4k4oqvf5gx19qqj6p451tqxo2hxlqo0khmk/uotpc1leat2pvfzsxt5bryootye2/dpei3phbqs/i1rx1qzktxhjzpgpsm|00001000000404477432||'), 0/* BORDE */, 'J');

            /* QR Codigo */
            $rfc_emi = 'CLO070608J19';
            $rfc_rec = 'DCO161130PG7';
            $total = number_format(2271.28, 6, ".", "");
            $uuid = '870BE2C8-92B9-4019-BA08-1977F9A3A1B5';

            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$uuid&re=$rfc_emi&rr=$rfc_rec&tt=$total&fe=TW9+rA==";
            $pdf->Image(base_url() . "NotasCreditoClientes/getQR?code=" . urlencode($qr), 165, $pdf->GetY() - 40, 40, null, "png");


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReporteNotaCreditoTp2Local($pTp, $pFolio, $pCliente) {
        $Tp = $pTp;
        $Folio = $pFolio;
        $Cliente = $pCliente;

        $Documento = $this->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto, df.Descripcion as nomdefecto, nc.detalle, dt.Descripcion as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join defectos df on df.clave= nc.defecto
                                        left join defectosdetalle dt on dt.clave= nc.detalle
                                        where nc.cliente= $Cliente
                                        and nc.tp = $Tp
                                        and nc.nc = $Folio ")->result();


        if (!empty($Documento)) {

            $pdf = new PDFNotaCreditoClientes('P', 'mm', array(215.9, 279.4));
            $pdf->setCliente($Cliente . ' ' . $Documento [0]->RazonS);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Documento[0]->fecha . ' ' . $Documento [0]->hora);
            $pdf->setDoc($Documento[0]->numfac);

            $pdf->setRfc($Documento[0]->RFC);
            $pdf->setDireccion($Documento[0]->Direccion);
            $pdf->setColonia($Documento[0]->Colonia);
            $pdf->setCiudad($Documento[0]->Ciudad . ', ' . $Documento [0]->nomestado);
            $pdf->setCp($Documento[0]->CodigoPostal);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('9999'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(80, 3, utf8_decode($D->descripcion), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format($D->precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(25, 3, '$' . number_format($D->subtot, 2, ".", ","), 0/* BORDE */, 1, 'R');

                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());
                $TP_IMPORTE += $D->subtot;
            }
            /* Importes */
            $pdf->SetY($pdf->GetY() + 1);
            $pdf->SetFont('Calibri', 'B', 8);
            $aligns = array('L', 'L', 'L', 'C', 'C', 'R', 'R');
            $pdf->SetAligns($aligns);
            $pdf->Row(array('', '', '', '', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'I.V.A. 16%:', '$' . number_format(0, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'Total:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);

            $pdf->SetY($pdf->GetY());
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(60, 4, utf8_decode($Documento[0]->monletra), 0/* BORDE */, 0, 'L');

            /* Observaciones */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(150, 4, utf8_decode($Documento[0]->concepto), 0/* BORDE */, 1, 'L');


            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 4, utf8_decode('La reproducción no autorizada de este comprobante constituye un delito en los términos de las disposiciones fiscales.'), 0/* BORDE */, 1, 'L');

            /* Regimen fiscal */
            $pdf->SetY($pdf->GetY() + 7);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('601 General de Ley Personas Morales'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado TITULOS  */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Folio Fiscal/UUID:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Fecha Timbrado:'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado SAT:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado del Emisor:'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado DATOS  */
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('870BE2C8-92B9-4019-BA08-1977F9A3A1B5' . ' ' . '3.3'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('24/07/2019 05:50:03 p.m.'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000404594081'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000401998453'), 0/* BORDE */, 1, 'L');

            /* SELLOS */
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital CFD:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('g2jKdXkSg4TFMrfoNHO/XwDQndbdnEmMYl+y/Hnx6D6MzLG6HUayhNMIsUdgYwmSx66487IJmelShtSnRs8fPtehkmxuRcmtAmV1HMrgfyVFnluh0NHY4qJjdwGNG+n15+9jkoYrvb3qHT5UzdQ0QRS7a7BVI1+xY4K4OqVf5gX19qqj6p451tQxO2hXLqO0KhMK/uoTpc1LeAT2pvFZSXT5bRyOOTyE2/dpEi3pHBQS/I1rx1qzKtXhjzPgPSm'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('OJkUGTrTiA61UiGTz/UxwgnWBijRx4jN24xvdFEQOcUP9duBXdOSBqz1JrD2ym7ycdbPohCgjsznF1IjdD6+LM1lmtGAPhnLTx+9nMt5YUqCK9/+cZpAyQVgoeP64X0vw/L86vilJ8svacBTsEdw3dYe9ztn5pf5qksmlfA29Wdqmy7Pe7LZ1Xg2lPCHWPI5GLqs1+U34bhXC3vIbAu4UCMKPizX8WyOGgtjpHDy0Uu4oWYZIbgxbd2cbqm2XfZ'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Cadena Original del Complemento de Certificación Digital del SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('||1.1|3ddac28e-f737-4907-90b7-f596d982c759|2019-07-03t12:28:02z|g2jkdxksg4tfmrfonho/xwdqndbdnemmyl+y/hnx6d6mzlg6huayhnmisudgywmsx66487ijmelshtsnrs8fptehkmxurcmtamv1hmrgfyvfnluh0nhy4qjjdwgng+n15+9jkoyrvb3qht5uzdq0qrs7a7bvi1+xy4k4oqvf5gx19qqj6p451tqxo2hxlqo0khmk/uotpc1leat2pvfzsxt5bryootye2/dpei3phbqs/i1rx1qzktxhjzpgpsm|00001000000404477432||'), 0/* BORDE */, 'J');

            /* QR Codigo */
            $rfc_emi = 'CLO070608J19';
            $rfc_rec = 'DCO161130PG7';
            $total = number_format(2271.28, 6, ".", "");
            $uuid = '870BE2C8-92B9-4019-BA08-1977F9A3A1B5';

            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$uuid&re=$rfc_emi&rr=$rfc_rec&tt=$total&fe=TW9+rA==";
            $pdf->Image(base_url() . "NotasCreditoClientes/getQR?code=" . urlencode($qr), 165, $pdf->GetY() - 40, 40, null, "png");


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReporteNotaCreditoTp1() {
        $Tp = $this->input->post('Tp');
        $Folio = $this->input->post('Folio');
        $Cliente = $this->input->post('Cliente');

        $Documento = $this->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto, df.Descripcion as nomdefecto, nc.detalle, dt.Descripcion as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join defectos df on df.clave= nc.defecto
                                        left join defectosdetalle dt on dt.clave= nc.detalle
                                        where nc.cliente= $Cliente
                                        and nc.tp = $Tp
                                        and nc.nc = $Folio ")->result();


        if (!empty($Documento)) {

            $pdf = new PDFNotaCreditoClientes('P', 'mm', array(215.9, 279.4));
            $pdf->setCliente($Cliente . ' ' . $Documento [0]->RazonS);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Documento[0]->fecha . ' ' . $Documento [0]->hora);
            $pdf->setDoc($Documento[0]->numfac);

            $pdf->setRfc($Documento[0]->RFC);
            $pdf->setDireccion($Documento[0]->Direccion);
            $pdf->setColonia($Documento[0]->Colonia);
            $pdf->setCiudad($Documento[0]->Ciudad . ', ' . $Documento [0]->nomestado);
            $pdf->setCp($Documento[0]->CodigoPostal);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('9999'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(80, 3, utf8_decode($D->descripcion), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format($D->precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(25, 3, '$' . number_format($D->subtot, 2, ".", ","), 0/* BORDE */, 1, 'R');

                $pdf->SetFont('Calibri', 'B', 6.5);
                $pdf->SetX(5);
                $pdf->Cell(50, 3, utf8_decode('Clave Producto:' . ' ' . '53111802 Sandalias para mujer'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(40, 3, utf8_decode('Clave Unidad: PR Par'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', '', 6.5);
                $pdf->Cell(50, 3, '03565385-B983-4A21-A6E0-F2DCF1D19282', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '9490-F', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', 'B', 6.5);
                $pdf->Cell(30, 3, utf8_decode('Traslado: IVA 16%= ') . '$' . number_format($D->subtot * 0.16, 2, ".", ","), 0/* BORDE */, 1, 'L');

                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());
                $TP_IMPORTE += $D->subtot;
            }
            /* Importes */
            $pdf->SetY($pdf->GetY() + 1);
            $pdf->SetFont('Calibri', 'B', 8);
            $aligns = array('L', 'L', 'L', 'C', 'C', 'R', 'R');
            $pdf->SetAligns($aligns);
            $pdf->Row(array('', '', '', '', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'I.V.A. 16%:', '$' . number_format($TP_IMPORTE * 0.16, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'Total:', '$' . number_format($TP_IMPORTE + ($TP_IMPORTE * 0.16), 2, ".", ","),), 0, false);

            $pdf->SetY($pdf->GetY());
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(60, 4, utf8_decode($Documento[0]->monletra), 0/* BORDE */, 0, 'L');

            /* Observaciones */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(150, 4, utf8_decode($Documento[0]->concepto), 0/* BORDE */, 1, 'L');


            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 4, utf8_decode('La reproducción no autorizada de este comprobante constituye un delito en los términos de las disposiciones fiscales.'), 0/* BORDE */, 1, 'L');

            /* Regimen fiscal */
            $pdf->SetY($pdf->GetY() + 7);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('601 General de Ley Personas Morales'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado TITULOS  */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Folio Fiscal/UUID:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Fecha Timbrado:'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado SAT:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado del Emisor:'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado DATOS  */
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('870BE2C8-92B9-4019-BA08-1977F9A3A1B5' . ' ' . '3.3'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('24/07/2019 05:50:03 p.m.'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000404594081'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000401998453'), 0/* BORDE */, 1, 'L');

            /* SELLOS */
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital CFD:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('g2jKdXkSg4TFMrfoNHO/XwDQndbdnEmMYl+y/Hnx6D6MzLG6HUayhNMIsUdgYwmSx66487IJmelShtSnRs8fPtehkmxuRcmtAmV1HMrgfyVFnluh0NHY4qJjdwGNG+n15+9jkoYrvb3qHT5UzdQ0QRS7a7BVI1+xY4K4OqVf5gX19qqj6p451tQxO2hXLqO0KhMK/uoTpc1LeAT2pvFZSXT5bRyOOTyE2/dpEi3pHBQS/I1rx1qzKtXhjzPgPSm'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('OJkUGTrTiA61UiGTz/UxwgnWBijRx4jN24xvdFEQOcUP9duBXdOSBqz1JrD2ym7ycdbPohCgjsznF1IjdD6+LM1lmtGAPhnLTx+9nMt5YUqCK9/+cZpAyQVgoeP64X0vw/L86vilJ8svacBTsEdw3dYe9ztn5pf5qksmlfA29Wdqmy7Pe7LZ1Xg2lPCHWPI5GLqs1+U34bhXC3vIbAu4UCMKPizX8WyOGgtjpHDy0Uu4oWYZIbgxbd2cbqm2XfZ'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Cadena Original del Complemento de Certificación Digital del SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('||1.1|3ddac28e-f737-4907-90b7-f596d982c759|2019-07-03t12:28:02z|g2jkdxksg4tfmrfonho/xwdqndbdnemmyl+y/hnx6d6mzlg6huayhnmisudgywmsx66487ijmelshtsnrs8fptehkmxurcmtamv1hmrgfyvfnluh0nhy4qjjdwgng+n15+9jkoyrvb3qht5uzdq0qrs7a7bvi1+xy4k4oqvf5gx19qqj6p451tqxo2hxlqo0khmk/uotpc1leat2pvfzsxt5bryootye2/dpei3phbqs/i1rx1qzktxhjzpgpsm|00001000000404477432||'), 0/* BORDE */, 'J');

            /* QR Codigo */
            $rfc_emi = 'CLO070608J19';
            $rfc_rec = 'DCO161130PG7';
            $total = number_format(2271.28, 6, ".", "");
            $uuid = '870BE2C8-92B9-4019-BA08-1977F9A3A1B5';

            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$uuid&re=$rfc_emi&rr=$rfc_rec&tt=$total&fe=TW9+rA==";
            $pdf->Image(base_url() . "NotasCreditoClientes/getQR?code=" . urlencode($qr), 165, $pdf->GetY() - 40, 40, null, "png");


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onImprimirReporteNotaCreditoTp2() {
        $Tp = $this->input->post('Tp');
        $Folio = $this->input->post('Folio');
        $Cliente = $this->input->post('Cliente');

        $Documento = $this->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto, df.Descripcion as nomdefecto, nc.detalle, dt.Descripcion as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join defectos df on df.clave= nc.defecto
                                        left join defectosdetalle dt on dt.clave= nc.detalle
                                        where nc.cliente= $Cliente
                                        and nc.tp = $Tp
                                        and nc.nc = $Folio ")->result();


        if (!empty($Documento)) {

            $pdf = new PDFNotaCreditoClientes('P', 'mm', array(215.9, 279.4));
            $pdf->setCliente($Cliente . ' ' . $Documento [0]->RazonS);
            $pdf->setFolio($Folio);
            $pdf->setTp($Tp);
            $pdf->setFecha($Documento[0]->fecha . ' ' . $Documento [0]->hora);
            $pdf->setDoc($Documento[0]->numfac);

            $pdf->setRfc($Documento[0]->RFC);
            $pdf->setDireccion($Documento[0]->Direccion);
            $pdf->setColonia($Documento[0]->Colonia);
            $pdf->setCiudad($Documento[0]->Ciudad . ', ' . $Documento [0]->nomestado);
            $pdf->setCp($Documento[0]->CodigoPostal);


            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('9999'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(80, 3, utf8_decode($D->descripcion), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format($D->precio, 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '$' . number_format('0', 2, ".", ","), 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(25, 3, '$' . number_format($D->subtot, 2, ".", ","), 0/* BORDE */, 1, 'R');

                $pdf->Line(5, $pdf->GetY(), 210, $pdf->GetY());
                $TP_IMPORTE += $D->subtot;
            }
            /* Importes */
            $pdf->SetY($pdf->GetY() + 1);
            $pdf->SetFont('Calibri', 'B', 8);
            $aligns = array('L', 'L', 'L', 'C', 'C', 'R', 'R');
            $pdf->SetAligns($aligns);
            $pdf->Row(array('', '', '', '', '', 'Subtotal:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'I.V.A. 16%:', '$' . number_format(0, 2, ".", ","),), 0, false);
            $pdf->Row(array('', '', '', '', '', 'Total:', '$' . number_format($TP_IMPORTE, 2, ".", ","),), 0, false);

            $pdf->SetY($pdf->GetY());
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Importe con Letra: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(60, 4, utf8_decode($Documento[0]->monletra), 0/* BORDE */, 0, 'L');

            /* Observaciones */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(80, 4, utf8_decode('Observaciones: '), 'B'/* BORDE */, 1, 'L');
            $pdf->SetFont('Calibri', '', 8);
            $pdf->SetX(5);
            $pdf->Cell(150, 4, utf8_decode($Documento[0]->concepto), 0/* BORDE */, 1, 'L');


            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 4, utf8_decode('La reproducción no autorizada de este comprobante constituye un delito en los términos de las disposiciones fiscales.'), 0/* BORDE */, 1, 'L');

            /* Regimen fiscal */
            $pdf->SetY($pdf->GetY() + 7);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('601 General de Ley Personas Morales'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado TITULOS  */
            $pdf->SetY($pdf->GetY() + 4);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Folio Fiscal/UUID:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Fecha Timbrado:'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado SAT:'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('Certificado del Emisor:'), 0/* BORDE */, 1, 'L');

            /* Datos CFDI Timbrado DATOS  */
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->Cell(60, 3, utf8_decode('870BE2C8-92B9-4019-BA08-1977F9A3A1B5' . ' ' . '3.3'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('24/07/2019 05:50:03 p.m.'), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000404594081'), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode('00001000000401998453'), 0/* BORDE */, 1, 'L');

            /* SELLOS */
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital CFD:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('g2jKdXkSg4TFMrfoNHO/XwDQndbdnEmMYl+y/Hnx6D6MzLG6HUayhNMIsUdgYwmSx66487IJmelShtSnRs8fPtehkmxuRcmtAmV1HMrgfyVFnluh0NHY4qJjdwGNG+n15+9jkoYrvb3qHT5UzdQ0QRS7a7BVI1+xY4K4OqVf5gX19qqj6p451tQxO2hXLqO0KhMK/uoTpc1LeAT2pvFZSXT5bRyOOTyE2/dpEi3pHBQS/I1rx1qzKtXhjzPgPSm'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('OJkUGTrTiA61UiGTz/UxwgnWBijRx4jN24xvdFEQOcUP9duBXdOSBqz1JrD2ym7ycdbPohCgjsznF1IjdD6+LM1lmtGAPhnLTx+9nMt5YUqCK9/+cZpAyQVgoeP64X0vw/L86vilJ8svacBTsEdw3dYe9ztn5pf5qksmlfA29Wdqmy7Pe7LZ1Xg2lPCHWPI5GLqs1+U34bhXC3vIbAu4UCMKPizX8WyOGgtjpHDy0Uu4oWYZIbgxbd2cbqm2XfZ'), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Cadena Original del Complemento de Certificación Digital del SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode('||1.1|3ddac28e-f737-4907-90b7-f596d982c759|2019-07-03t12:28:02z|g2jkdxksg4tfmrfonho/xwdqndbdnemmyl+y/hnx6d6mzlg6huayhnmisudgywmsx66487ijmelshtsnrs8fptehkmxurcmtamv1hmrgfyvfnluh0nhy4qjjdwgng+n15+9jkoyrvb3qht5uzdq0qrs7a7bvi1+xy4k4oqvf5gx19qqj6p451tqxo2hxlqo0khmk/uotpc1leat2pvfzsxt5bryootye2/dpei3phbqs/i1rx1qzktxhjzpgpsm|00001000000404477432||'), 0/* BORDE */, 'J');

            /* QR Codigo */
            $rfc_emi = 'CLO070608J19';
            $rfc_rec = 'DCO161130PG7';
            $total = number_format(2271.28, 6, ".", "");
            $uuid = '870BE2C8-92B9-4019-BA08-1977F9A3A1B5';

            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$uuid&re=$rfc_emi&rr=$rfc_rec&tt=$total&fe=TW9+rA==";
            $pdf->Image(base_url() . "NotasCreditoClientes/getQR?code=" . urlencode($qr), 165, $pdf->GetY() - 40, 40, null, "png");


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA CREDITO TP " . $Tp . ' NC ' . $Folio . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Clientes/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function getQR() {
        QRcode::png($_GET['code']);
    }

}
