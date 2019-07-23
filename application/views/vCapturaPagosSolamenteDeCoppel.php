<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header"> 
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-4 col-xl-4">
                <h4 class="card-title">Captura pagos solamente de Coppel</h4>  
            </div> 
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-xl-8" align="right"> 
                <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-success btn-sm">
                    Movimientos
                </button>
                <button type="button" id="btnCierraNotaDeCredito" name="btnCierraNotaDeCredito" class="btn btn-danger btn-sm">
                    Cierra nota de credito
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-4 col-lg-2 col-xl-1">
                <label for="">TP</label>
                <select id="TPPDC" name="TPPDC" class="form-control form-control-sm">
                    <option></option>
                    <option value="1">1 F</option>
                    <option value="2">2 R</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-8 col-lg-5 col-xl-5">
                <label for="">Banco</label>
                <select id="Banco" name="Banco" class="form-control form-control-sm">
                    <option></option>
                    <?php
                    foreach ($this->db->query("SELECT B.Clave AS CLAVE, CONCAT(B.Clave,' ',B.Nombre) AS BANCO FROM bancos AS B ORDER BY ABS(B.Clave) ASC")->result() as $key => $value) {
                        print "<option value=\"{$value->CLAVE}\">{$value->BANCO}</option>";
                    }
                    ?>
                </select>
            </div> 
            <div class="col-12 col-xs-12 col-sm-12 col-lg-6 col-xl-6">
                <label for="">Documento</label>
                <select id="Documento" name="Documento" class="form-control form-control-sm">
                    <option></option> 
                    <?php
                    foreach ($this->db->query("SELECT  date_format(D.fecha,'%d/%m/%Y') AS FECHA, D.ID AS ID,D.importe AS IMPORTE, D.pagos AS APLICADO, (D.importe - D.pagos) AS SALDO, D.banco AS BANCO, CONCAT(D.docto,'-',D.banco, '-', D.cuenta,'-',D.importe) AS DOCUMENTO FROM depoctes AS D WHERE  D.status < 3")->result() as $k => $v) {
                        print "<option value=\"{$v->ID}-{$v->IMPORTE}-{$v->APLICADO}-{$v->SALDO}-{$v->FECHA}-{$v->DOCUMENTO}\"> {$v->BANCO} {$v->DOCUMENTO}</option>";
                    }
                    ?>
                </select>
                <input type="text" id="DocumentoBancario" name="DocumentoBancario" class="d-none">
            </div> 
            <div class="col-12 col-xs-12 col-sm-4 col-lg-2 col-xl-2">
                <label for="">Importe</label>
                <input type="text" id="ImporteDocumentoPDC" name="ImporteDocumentoPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-2 col-xl-2">
                <label for="">Aplicado</label>
                <input type="text" id="AplicadoPDC" name="AplicadoPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-2 col-xl-2">
                <label for="">Saldo</label>
                <input type="text" id="SaldoDocumentoPDC" name="SaldoDocumentoPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label for="">Cliente</label>
                <select id="ClientePDC" name="ClientePDC" class="form-control form-control-sm">
                    <?php
                    foreach ($this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM erp_cal.clientes AS C WHERE C.Clave = '2121'")->result() as $k => $v) {
                        print "<option value=\"{$v->CLAVE}\"> {$v->CLAVE} {$v->CLIENTE}</option>";
                    }
                    ?>
                </select>
                <input type="text" id="AgentePDC" name="AgentePDC" class="d-none">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <label for="">Docto</label>
                <input type="text" id="DoctoPDC" name="DoctoPDC" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                <label for="">Fecha Docto</label>
                <input type="text" id="FechaDoctoPDC" name="FechaDoctoPDC" class="form-control form-control-sm date notEnter">
            </div>
            <div class="w-100">
                <hr>
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                <span class="text-primary font-weight-bold">Importe</span>
                <span class="text-danger font-weight-bold ImportePDC">$ 0.0</span>                 
                <input type="text" id="ImportePDC" name="ImportePDC" class="form-control form-control-sm d-none numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                <span class="text-primary font-weight-bold">Pagos</span>
                <span class="text-danger font-weight-bold PagosPDC">$ 0.0</span>   
                <input type="text" id="PagosPDC" name="PagosPDC" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-1 col-xl-1">
                <span class="text-primary font-weight-bold">Saldo</span>
                <span class="text-danger font-weight-bold SaldoPDC">$ 0.0</span>   
                <input type="text" id="SaldoPDC" name="SaldoPDC" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                <span class="text-primary font-weight-bold">Monto</span>
                <span class="text-danger font-weight-bold MontoPDC">$ 0.0</span>  
                <input type="text" id="MontoPDC" name="MontoPDC" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                <span class="text-primary font-weight-bold">2%</span>
                <span class="text-danger font-weight-bold DosPorcientoPDC">$ 0.0</span>  
                <input type="text" id="DosPorcientoPDC" name="DosPorcientoPDC" class="form-control form-control-sm d-none numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                <span class="text-primary font-weight-bold">3%</span>
                <span class="text-danger font-weight-bold TresPorcientoPDC">$ 0.0</span> 
                <input type="text" id="TresPorcientoPDC" name="TresPorcientoPDC" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                <span class="text-primary font-weight-bold">Total%</span>
                <span class="text-danger font-weight-bold TotalPorcientoPDC">$ 0.0</span> 
                <input type="text" id="TotalPorcientoPDC" name="TotalPorcientoPDC" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                <span class="text-primary font-weight-bold">I.V.A</span>
                <span class="text-danger font-weight-bold IVATotalPorcientoPDC">$ 0.0</span> 
                <input type="text" id="IVATotalPorcientoPDC" name="IVATotalPorcientoPDC"  data-toggle="tooltip" data-placement="top" title="I.V.A Total %" class="form-control form-control-sm numbersOnly d-none" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                <span class="text-primary font-weight-bold">Deposito</span>
                <span class="text-danger font-weight-bold DepositoPDC">$ 0.0</span> 
                <input type="text" id="DepositoPDC" name="DepositoPDC" class="form-control form-control-sm d-none numbersOnly" readonly="">
            </div> 

            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-4 col-xl-4">
                <label for="">Depostio real</label>
                <input type="text" id="SaldoDelDeposito" name="SaldoDelDeposito" class="form-control form-control-sm" readonly="" >
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-2">
                <label for="">Captura</label>
                <input type="text" id="Captura" name="Captura" class="form-control form-control-sm date" >
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-2">
                <label for="">Deposito</label>
                <input type="text" id="Deposito" name="Deposito" class="form-control form-control-sm date" >
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-2 col-xl-2">
                <label for="">Nota de crédito</label>
                <input type="text" id="NotaDeCredito" name="NotaDeCredito" class="form-control form-control-sm" >
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-2">
                <br>
                <button type="button" id="btnAceptaPagos" name="btnAceptaPagos" class="btn btn-primary mt-1 btn-sm btn-block">
                    Acepta
                </button>
            </div> 
            <div class="w-100"></div> 
            <!--TABLA DE PAGOS POR DOCUMENTO--> 

            <div class="col-12 col-xs-12 col-sm-12 col-lg-12 col-xl-12" align="">   
                <span class="text-primary font-weight-bold font-italic">FOLIO FISCAL : </span>
                <span class="text-danger font-weight-bold foliofiscal"> * </span> 
                <input type="text" id="FolioFiscal" name="FolioFiscal" class="d-none form-control form-control-sm" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-6 col-xl-6" align="">
                <h3 class="text-info font-italic">Documentos con saldo de este cliente</h3> 
                <div id="DocumentosConSaldoXClientes" class="table-responsive">
                    <table id="tblDocumentosConSaldoXClientes" class="table table-sm " style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th><!--0-->
                                <th>Cliente</th>
                                <th>Docto</th><!--2-->
                                <th>TP</th>
                                <th>Fec-dep</th><!--4-->
                                <th>Importe</th>
                                <th>Pagos</th><!--6-->
                                <th>Saldo</th>
                                <th>St</th><!--8: 1 SIN PAGOS; 2 CON PAGOS; 3 PAGADO-->
                                <th>Dias</th> 
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-6 col-xl-6" align="">
                <h3 class="text-info font-italic">Pagos de este documento</h3> 
                <div id="PagosDeEsteDocumento" class="table-responsive">
                    <table id="tblPagosDeEsteDocumento" class="table table-sm display " style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Docto</th>
                                <th>TP</th> 
                                <th>Fecha-cap</th>
                                <th>Importe</th>
                                <th>MV</th>
                                <th>Referencia</th> 
                                <th>Dias</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div> 
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE--> 

            <div id="SaldoTotalPendiente" class="col-12">
                <h4 class="text-danger font-weight-bold">Saldo </h4>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), TPPDC = pnlTablero.find('#TPPDC'),
            Banco = pnlTablero.find('#Banco'), Documento = pnlTablero.find('#Documento'),
            ImporteDocumentoPDC = pnlTablero.find('#ImporteDocumentoPDC'), AplicadoPDC = pnlTablero.find('#AplicadoPDC'),
            SaldoDocumentoPDC = pnlTablero.find('#SaldoDocumentoPDC'), ClientePDC = pnlTablero.find('#ClientePDC'),
            AgentePDC = pnlTablero.find('#AgentePDC'), DoctoPDC = pnlTablero.find('#DoctoPDC'),
            FechaDoctoPDC = pnlTablero.find('#FechaDoctoPDC'), ImportePDC = pnlTablero.find('#ImportePDC'),
            PagosPDC = pnlTablero.find('#PagosPDC'), SaldoPDC = pnlTablero.find('#SaldoPDC'),
            MontoPDC = pnlTablero.find('#MontoPDC'), DosPorcientoPDC = pnlTablero.find('#DosPorcientoPDC'),
            TresPorcientoPDC = pnlTablero.find('#TresPorcientoPDC'), TotalPorcientoPDC = pnlTablero.find('#TotalPorcientoPDC'),
            IVATotalPorcientoPDC = pnlTablero.find('#IVATotalPorcientoPDC'), DepositoPDC = pnlTablero.find('#DepositoPDC'),
            SaldoDelDeposito = pnlTablero.find('#SaldoDelDeposito'), Captura = pnlTablero.find('#Captura'),
            Deposito = pnlTablero.find('#Deposito'), NotaDeCredito = pnlTablero.find('#NotaDeCredito'),
            FolioFiscal = pnlTablero.find('#FolioFiscal'), Hoy = '<?php print Date('d/m/Y'); ?>', PagosDeEsteDocumento,
            tblPagosDeEsteDocumento = pnlTablero.find("#tblPagosDeEsteDocumento"), DocumentosConSaldoXClientes,
            tblDocumentosConSaldoXClientes = pnlTablero.find("#tblDocumentosConSaldoXClientes"),
            btnAceptaPagos = pnlTablero.find("#btnAceptaPagos"), DocumentoBancario = pnlTablero.find("#DocumentoBancario");

    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        btnAceptaPagos.click(function () {
            if (DoctoPDC.val()) {
                if (FolioFiscal.val()) {
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Guardando...por favor espere'
                    });
                    var dostres = {
                        TP: TPPDC.val(),
                        DOCUMENTO_BANCO: DocumentoBancario.val(),
                        DOCUMENTO: DoctoPDC.val(),
                        BANCO: Banco.val(),
                        IMPORTE_DOS: DosPorcientoPDC.val(),
                        IMPORTE_TRES: DosPorcientoPDC.val(),
                        IVADOSTRES: IVATotalPorcientoPDC.val(),
                        DEPOSITO_REAL: SaldoDelDeposito.val(),
                        SALDO: SaldoDocumentoPDC.val(),
                        FECHA_DEPOSITO: Deposito.val(),
                        FOLIO_NC: NotaDeCredito.val(),
                        UUID: FolioFiscal.val(),
                        MONTO_LETRA: NumeroALetras(MontoPDC.val())
                    };
                    /*DOSTRES PORCIENTO*/
                    $.post('<?php print base_url('CapturaPagosSolamenteDeCoppel/onAgregarPagoDosTresTotal'); ?>', dostres).done(function () {
                        onNotifyOld('', 'SE HAN REALIZADO LOS MOVIMIENTOS', 'success');

                        onBeep(1);
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                    /*FIN DOSTRES PORCIENTO*/
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN DOCUMENTO/FACTURA CON UN FOLIO FISCAL VÁLIDO', 'warning').then((value) => {
                        DoctoPDC.focus().select();
                    });
                }
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN DOCUMENTO/FACTURA', 'warning').then((value) => {
                    DoctoPDC.focus().select();
                });
            }
        });

        ClientePDC[0].selectize.disable();
        TPPDC[0].selectize.focus();
        DoctoPDC.on('keydown', function (e) {
            if (e.keyCode === 13) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere...'
                });
                $.getJSON('<?php print base_url('CapturaPagosSolamenteDeCoppel/getCartCliente'); ?>', {
                    FACTURA: DoctoPDC.val()
                }).done(function (a) {
                    console.log(a);
                    if (a.length > 0) {
                        var m = a[0];
                        FechaDoctoPDC.val(m.fecha);
                        ImportePDC.val(m.importe);
                        pnlTablero.find(".ImportePDC").text("$" + $.number(m.importe, 2, '.', ','));
                        PagosPDC.val(m.pagos);
                        pnlTablero.find(".PagosPDC").text("$" + $.number(m.pagos, 2, '.', ','));
                        SaldoPDC.val(m.saldo);
                        pnlTablero.find(".SaldoPDC").text("$" + $.number(m.saldo, 2, '.', ','));
                        MontoPDC.val(m.importe);
                        pnlTablero.find(".MontoPDC").text("$" + $.number(m.importe, 2, '.', ','));
                        var dospr = ((m.importe * 0.02) / 1.16), trespr = ((m.importe * 0.03) / 1.16), total = 0, ivatt = 0, ttf = 0;
                        DosPorcientoPDC.val($.number(dospr, 2, '.', ''));
                        pnlTablero.find(".DosPorcientoPDC").text("$" + $.number(dospr, 2, '.', ','));
                        TresPorcientoPDC.val($.number(trespr, 2, '.', ''));
                        pnlTablero.find(".TresPorcientoPDC").text("$" + $.number(trespr, 2, '.', ','));
                        total = (dospr + trespr);
                        ivatt = total * 0.16;
                        TotalPorcientoPDC.val($.number(total, 2, '.', ''));
                        pnlTablero.find(".TotalPorcientoPDC").text("$" + $.number(total, 2, '.', ','));
                        IVATotalPorcientoPDC.val($.number(ivatt, 2, '.', ''));
                        pnlTablero.find(".IVATotalPorcientoPDC").text("$" + $.number(ivatt, 2, '.', ','));
                        total += ivatt;
                        ttf = m.importe - total;
                        DepositoPDC.val($.number(ttf, 2, '.', ''));
                        pnlTablero.find(".DepositoPDC").text("$" + $.number(ttf, 2, '.', ','));
                        Captura.val(Hoy);
                        /*OBTENER UUID*/
                        $.getJSON('<?php print base_url('CapturaPagosSolamenteDeCoppel/getUUID'); ?>', {DOCUMENTO: DoctoPDC.val()}).done(function (aa) {
                            //console.log(aa);
                            if (aa.length > 0) {
                                FolioFiscal.val(aa[0].UUID);
                                pnlTablero.find(".foliofiscal").text(aa[0].UUID);
                                SaldoDelDeposito.val($.number(ttf, 2, '.', ''));
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                        });
                        $.getJSON('<?php print base_url('CapturaPagosSolamenteDeCoppel/getUltimaNC'); ?>').done(function (aaa) {
                            //console.log(aa);
                            if (aaa.length > 0) {
                                NotaDeCredito.val(aaa[0].NCM);
                            }
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                        });
                        PagosDeEsteDocumento.ajax.reload();
                        DocumentosConSaldoXClientes.ajax.reload();
                    } else {
                        swal('ATENCIÓN', 'ESTA FACTURA NO EXISTE CON ESTE CLIENTE', 'warning').then((value) => {
                            DoctoPDC.focus().select();
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

        Documento.change(function () {
            var model = $(this).val().split("-");
            ImporteDocumentoPDC.val(model[1]);
            AplicadoPDC.val(model[2]);
            SaldoDocumentoPDC.val(model[3]);
            Deposito.val(model[4]);
            console.log(model);
        });

        Banco.change(function () {
            console.log($(this).val());
        });
        getPagosDocumento();
        getDocumentosConSaldoXClientes();
    });/*FIN DOCUMENT READY*/


    function getPagosDocumento() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumento.DataTable().destroy();
        }
        PagosDeEsteDocumento = tblPagosDeEsteDocumento.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('CapturaPagosSolamenteDeCoppel/getPagosXDocumentos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"}, {"data": "DOCUMENTO"},
                {"data": "TP"}, {"data": "FECHA_CAPTURA"},
                {"data": "IMPORTE"}, {"data": "MV"}, {"data": "REFERENCIA"},
                {"data": "DIAS"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "300px",
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }

    function getDocumentosConSaldoXClientes() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
            tblDocumentosConSaldoXClientes.DataTable().destroy();
        }
        DocumentosConSaldoXClientes = tblDocumentosConSaldoXClientes.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('CapturaPagosSolamenteDeCoppel/getDocumentosConSaldoXClientes'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/, {"data": "DOCUMENTO"}/*2*/,
                {"data": "TP"}/*3*/, {"data": "FECHA_DEPOSITO"}/*4*/,
                {"data": "IMPORTE"}/*5*/, {"data": "PAGOS"}/*6*/, {"data": "SALDO"}/*7*/,
                {"data": "ST"}/*8*/, {"data": "DIAS"}/*9*/, {"data": "SALDOX"}/*10*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": "300px",
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API  
                var saldox = api.column(10).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(b) ? parseFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                pnlTablero.find("#SaldoTotalPendiente h4").text('Saldo $' + $.number(parseFloat(saldox), 2, '.', ','));
            }
        });
    }
</script>
<style>
    .card{ 
        background-color: #fff;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #003366, rgb(0,0,0,0)) 1 100% ;
    }
    .card-body{
        padding-top: 5px !important;
    }
    table tbody td{
        color: #000 !important;
        font-weight: bold ;
    }
    table tbody tr:hover td{
        color: #fff !important;
        font-weight: bold ;
    }
</style>