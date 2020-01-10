<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class NotaDeCredito {

    private $TP, $FOLIO, $CLIENTE;

    public function __construct($TP, $FOLIO, $CLIENTE) {
        $this->TP = $TP;
        $this->FOLIO = $FOLIO;
        $this->CLIENTE = $CLIENTE;
        switch (intval($this->getTP())) {
            case 1:
                $this->onImprimirReporteNotaCreditoTp1Local($this->getTP(), $this->getFOLIO(), $this->getCLIENTE());
                break;
            case 2:
                $this->onImprimirReporteNotaCreditoTp2Local($this->getTP(), $this->getFOLIO(), $this->getCLIENTE());
                break;
        }
    }

    public function getTP() {
        return $this->TP;
    }

    public function getFOLIO() {
        return $this->FOLIO;
    }

    public function getCLIENTE() {
        return $this->CLIENTE;
    }

    public function setTP($TP) {
        $this->TP = $TP;
        return $this;
    }

    public function setFOLIO($FOLIO) {
        $this->FOLIO = $FOLIO;
        return $this;
    }

    public function setCLIENTE($CLIENTE) {
        $this->CLIENTE = $CLIENTE;
        return $this;
    }

    public function onImprimirReporteNotaCreditoTp1Local($pTp, $pFolio, $pCliente) {
        $CI = & get_instance();
        $Tp = $pTp;
        $Folio = $pFolio;
        $Cliente = $pCliente;

        $Documento = $CI->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden, nc.uuid as uuid_aplica,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto,
                                        (select Descripcion from defectos where clave= nc.defecto) as nomdefecto,
                                        nc.detalle,
                                        (select Descripcion from defectosdetalle where clave= nc.detalle) as nomdetalle,
                                        nc.monletra,
                                        c.CadenaOriginal, c.CertificadoCFD, c.CertificadoSAT, c.CfdiTimbrado,
                                        c.Fecha, c.FechaTimbrado, c.Folio, c.FormaPago, c.MetodoPago,
                                        c.Moneda, c.selloCFD, c.selloSAT, c.Serie, c.UsoCfdi,
                                        c.UUID, c.Version, c.ReceptorRfc, c.EmisorRfc, c.Total,
                                        (select descripcion from formaspago where clave = c.FormaPago) as nomformapago,
                                        (select descripcion from metodos_de_pago where clave = c.MetodoPago) as nommetpago,
                                        (select descripcion from uso_cfdi where clave = c.UsoCfdi) as nomusocfdi
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
                                        left join comprobantes c on c.Folio = nc.nc and c.tipo = 'E'
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
            $pdf->setFormapago($Documento[0]->nomformapago);
            $pdf->setMetodopago($Documento[0]->MetodoPago . ' ' . $Documento[0]->nommetpago);
            $pdf->setUsocfdi($Documento[0]->UsoCfdi . ' ' . $Documento[0]->nomusocfdi);

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 15);

            $TP_IMPORTE = 0;
            $pdf->SetFont('Calibri', '', 8);
            foreach ($Documento as $key => $D) {

                $pdf->SetFont('Calibri', '', 8);
                $pdf->SetX(5);
                $pdf->Cell(20, 3, number_format($D->cant, 2, ".", ","), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, utf8_decode('DPPP'), 0/* BORDE */, 0, 'L');
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
                $pdf->Cell(50, 3, utf8_decode('Clave Producto:' . ' ' . '84111506 Servicios de Facturación'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(40, 3, utf8_decode('Clave Unidad: ACT Actividad'), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', '', 6.5);
                $pdf->Cell(50, 3, utf8_decode($D->uuid_aplica), 0/* BORDE */, 0, 'R');
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
            $pdf->Cell(60, 3, utf8_decode($D->UUID . ' ' . $D->Version), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode($D->FechaTimbrado), 0/* BORDE */, 0, 'L');


            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode($D->CertificadoSAT), 0/* BORDE */, 0, 'L');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(40, 3, utf8_decode($D->CertificadoCFD), 0/* BORDE */, 1, 'L');

            /* SELLOS */
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital CFD:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode($D->selloCFD), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Sello Digital SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode($D->selloSAT), 0/* BORDE */, 'J');

            $pdf->SetY($pdf->GetY() + 2);
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->Cell(60, 3, utf8_decode('Cadena Original del Complemento de Certificación Digital del SAT:'), 0/* BORDE */, 1, 'L');
            $pdf->SetX(5);
            $pdf->SetFont('Calibri', '', 8);
            $pdf->MultiCell(160, 3, utf8_decode($D->CadenaOriginal), 0/* BORDE */, 'J');

            /* QR Codigo */
            $rfc_emi = utf8_decode($D->EmisorRfc);
            $rfc_rec = utf8_decode($D->ReceptorRfc);
            $total = number_format(floatval($D->Total), 6, ".", "");
            $uuid = utf8_decode($D->UUID);


            $qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=$uuid&re=$rfc_emi&rr=$rfc_rec&tt=$total&fe=TW9+rA==";
            $pdf->Image(base_url() . "NotasCreditoClientes/getQR?code=" . urlencode($qr), 165, $pdf->GetY() - 40, 40, null, "png");


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Clientes';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "NOTA_CREDITO_TP_" . $Tp . '_NC_' . $Folio . '_' . date("d-m-Y_his");
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
        $CI = & get_instance();
        $Tp = $pTp;
        $Folio = $pFolio;
        $Cliente = $pCliente;

        $Documento = $CI->db->query("SELECT
                                        nc.nc, date_format(nc.fecha,'%d/%m/%Y') as fecha,nc.hora,nc.orden,
                                        nc.cliente, ct.RazonS, ct.RFC, ct.Agente, ag.Descripcion as nomagente, ct.Direccion, ct.Colonia, nc.numfac,
                                        ct.Ciudad, ct.Estado, edo.Descripcion as nomestado, ct.CodigoPostal,
                                        nc.cant, nc.descripcion, nc.precio, nc.subtot,
                                        nc.concepto, nc.defecto,
                                        (select Descripcion from defectos where clave= nc.defecto) as nomdefecto,
                                        nc.detalle,
					(select Descripcion from defectosdetalle where clave= nc.detalle) as nomdetalle,
                                        nc.monletra
                                        FROM notcred nc
                                        join clientes ct on ct.clave= nc.cliente
                                        join agentes ag on ag.clave= ct.agente
                                        join estados edo on edo.clave= ct.estado
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
                $pdf->Cell(20, 3, utf8_decode('S-NC-INT'), 0/* BORDE */, 0, 'L');
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
                $pdf->Cell(50, 3, utf8_decode($D->nomdefecto), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(40, 3, utf8_decode($D->nomdetalle), 0/* BORDE */, 0, 'L');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', '', 6.5);
                $pdf->Cell(50, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(20, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 3, '', 0/* BORDE */, 0, 'R');
                $pdf->SetX($pdf->GetX());
                $pdf->SetFont('Calibri', 'B', 6.5);
                $pdf->Cell(30, 3, '', 0/* BORDE */, 1, 'L');


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

}
