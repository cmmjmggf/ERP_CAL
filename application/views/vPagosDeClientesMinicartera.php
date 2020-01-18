<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 col-lg-4 col-xl-4">
                <h4 class="card-title">Pagos a Minicartera</h4>
            </div>
            <div class="col-12 col-sm-12 col-xs-12 col-lg-8 col-xl-8" align="right">
                <button type="button" id="btnImprimeCartera" name="btnImprimeCartera" class="btn btn-success  btn-sm">
                    Imprime Cartera
                </button>
                <button type="button" id="btnMovimientos" name="btnMovimientos" class="btn btn-warning  btn-sm">
                    Movimientos
                </button>
            </div>
        </div>
        <hr>
        <!--1er Renglon Captura-->
        <div class="row">
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Cliente</label>
                <input type="text" id="ClientePDC" name="ClientePDC"  class="form-control form-control-sm  numbersOnly "maxlength="5" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-4 col-xl-3">
                <label for="">-</label>
                <select id="sClientePDC" name="sClientePDC" class="form-control form-control-sm NotSelectize">
                    <option></option>
                    <?php
                    $q = $this->db->query("SELECT C.Clave AS CLAVE,  C.RazonS AS CLIENTE FROM clientes AS C WHERE C.Estatus IN('ACTIVO') ORDER BY C.RazonS ASC")->result();
                    foreach ($q as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE} </option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <label for="">Docto</label>
                <input type="text" id="DoctoPDC" name="DoctoPDC" class="form-control form-control-sm numbersOnly" maxlength="10">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Fecha</label>
                <input type="text" id="FechaPDC" name="FechaPDC" readonly="" class="form-control notEnter form-control-sm date">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="TPPDC" maxlength="1" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-1 col-xl-1">
                <label for="">Captura</label>
                <input type="text" id="CapturaPDC" name="CapturaPDC" class="form-control form-control-sm date">
            </div>
            <div class="col-3 col-sm-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chRegresaSaldo" name="chRegresaSaldo" >
                    <label class="custom-control-label text-danger labelCheck" for="chRegresaSaldo">Recupera el pago a cartera de clientes para su nota de crédito al cliente</label>
                </div>
            </div>

            <div class="w-100"></div>
            <!--2do Renglon Captura-->
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Factura</label>
                <input type="text" id="FacturaPDC" name="FacturaPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Importe</label>
                <input type="text" id="ImportePDC" name="ImportePDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Pagos</label>
                <input type="text" id="PagosPDC" name="PagosPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-1">
                <label for="">Saldo</label>
                <input type="text" id="SaldoPDC" name="SaldoPDC" class="form-control form-control-sm numbersOnly" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-2 col-xl-2">
                <h5 class="">Tipos de movimiento</h5>
                <span class="badge badge-info border border-primary">1 = Depósito </span>
                <span class="badge badge-info border border-primary">2 = Efec </span>
                <span class="badge badge-info border border-primary">9 = Otros </span>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-lg-5 col-xl-5 ">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label for="">Mov</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="MovUno" name="MovUno" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                        <label for="">Importe</label>
                        <input type="text" id="ImporteUno" name="ImporteUno" class="form-control form-control-sm numbersOnly">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4">
                        <label for="">Ref</label>
                        <input type="text" id="RefUno" name="RefUno" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-2">
                        <br>
                        <button type="button" id="btnAceptaPagos" name="btnAceptaPagos" class="btn btn-info btn-sm ">
                            <span class="fa fa-check"></span>  Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE-->
            <div id="DocumentosConSaldoXClientesMini" class="col-12 col-sm-12 col-md-6">
                <h5>Documentos con saldo de este cliente en minicartera</h5>
                <table id="tblDocumentosConSaldoXClientesMini" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th><!--0-->
                            <th>Cliente</th>
                            <th>Docto</th><!--2-->
                            <th>TP</th>
                            <th>Importe</th>
                            <th>Pagos</th><!--6-->
                            <th>Saldo</th>
                            <th>St</th><!--8: 1 SIN PAGOS; 2 CON PAGOS; 3 PAGADO-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div id="PagosDeEsteDocumentoMini" class="col-12 col-sm-12 col-md-6">
                <h5>Pagos de este documento en minicartera</h5>
                <table id="tblPagosDeEsteDocumentoMini" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Docto</th>
                            <th>TP</th>
                            <th>Fec-cap</th>
                            <th>Importe</th>
                            <th>Mv</th>
                            <th>Referencia</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <!--TABLA DE DOCUMENTOS CON SALDO POR CLIENTE-->
            <div id="DocumentosConSaldoXClientes" class="col-12 col-sm-12 col-md-6">
                <h5>Documentos con saldo de este cliente</h5>
                <table id="tblDocumentosConSaldoXClientes" class="table table-sm display " style="width:100%">
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
            <!--TABLA DE PAGOS POR DOCUMENTO-->
            <div id="PagosDeEsteDocumento" class="col-12 col-sm-12 col-md-6">
                <h5>Pagos de este documento</h5>
                <table id="tblPagosDeEsteDocumento" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Docto</th>
                            <th>TP</th>
                            <th>Fec-dep</th>
                            <th>Fec-cap</th>
                            <th>Importe</th>
                            <th>Mv</th>
                            <th>Referencia</th>
                            <th>Dias</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"),
            DoctoPDC = pnlTablero.find("#DoctoPDC"),
            TPPDC = pnlTablero.find("#TPPDC"),
            CapturaPDC = pnlTablero.find("#CapturaPDC"),
            ImportePDC = pnlTablero.find("#ImportePDC"),
            PagosPDC = pnlTablero.find("#PagosPDC"),
            SaldoPDC = pnlTablero.find("#SaldoPDC"),
            FechaPDC = pnlTablero.find("#FechaPDC"),
            FacturaPDC = pnlTablero.find("#FacturaPDC"),
            MovUno = pnlTablero.find("#MovUno"),
            ImporteUno = pnlTablero.find("#ImporteUno"),
            RefUno = pnlTablero.find("#RefUno"),
            PagosDeEsteDocumento,
            tblPagosDeEsteDocumento = pnlTablero.find("#tblPagosDeEsteDocumento"),
            PagosDeEsteDocumentoMini,
            tblPagosDeEsteDocumentoMini = pnlTablero.find("#tblPagosDeEsteDocumentoMini"),
            ClientePDC = pnlTablero.find("#ClientePDC"),
            sClientePDC = pnlTablero.find("#sClientePDC"),
            chRegresaSaldo = pnlTablero.find("#chRegresaSaldo"),
            DocumentosConSaldoXClientes,
            tblDocumentosConSaldoXClientes = pnlTablero.find("#tblDocumentosConSaldoXClientes"),
            DocumentosConSaldoXClientesMini,
            tblDocumentosConSaldoXClientesMini = pnlTablero.find("#tblDocumentosConSaldoXClientesMini"),
            FechaActual = '<?php print Date('d/m/Y'); ?>',
            btnAceptaPagos = pnlTablero.find("#btnAceptaPagos"), btnMovimientos = pnlTablero.find("#btnMovimientos"), btnImprimeCartera = pnlTablero.find("#btnImprimeCartera");
    txtCondicion = 0;

    $(document).ready(function () {
        init();
        /*Evento tabla*/
        tblDocumentosConSaldoXClientesMini.find('tbody').on('dblclick', 'tr', function () {
            tblDocumentosConSaldoXClientesMini.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var doc = DocumentosConSaldoXClientesMini.row(this).data().DOCUMENTO;
            DoctoPDC.val(doc).focus().select();
        });
        /*BOTONES*/
        btnMovimientos.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });
        ClientePDC.on('keypress', function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON('<?php print base_url('PagosDeClientes/onVerificarCliente'); ?>', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            onOpenOverlay('Por favor espere...');
                            pnlTablero.find("input:not(#CapturaPDC):not(#ClientePDC)").val('');
                            sClientePDC[0].selectize.addItem(txtcte, true);
                            MovUno.val('');
                            if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                                getPagosDocumento();
                            } else {
                                PagosDeEsteDocumento.ajax.reload();
                            }
                            if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                                getDocumentosConSaldoXClientes();
                            } else {
                                DocumentosConSaldoXClientes.ajax.reload();
                            }
                            /*Minicartera*/
                            if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumentoMini')) {
                                getPagosDocumentoMini();
                            } else {
                                PagosDeEsteDocumentoMini.ajax.reload();
                            }
                            if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientesMini')) {
                                getDocumentosConSaldoXClientesMini();
                            } else {
                                DocumentosConSaldoXClientesMini.ajax.reload();
                            }

                            $.getJSON('<?php print base_url('PagosDeClientes/getAgenteXCliente'); ?>', {CLIENTE: txtcte})
                                    .done(function (a) {
                                        if (a.length > 0) {
                                            DoctoPDC.focus();
                                        }
                                    }).fail(function (x) {
                                getError(x);
                            }).always(function () {
                                HoldOn.close();
                            });

                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                sClientePDC[0].selectize.clear(true);
                                ClientePDC.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        sClientePDC.change(function (e) {
            if ($(this).val()) {
                ClientePDC.val(sClientePDC.val());
                pnlTablero.find("input:not(#CapturaPDC):not(#ClientePDC)").val('');
                MovUno.val('');
                if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                    getPagosDocumento();
                } else {
                    PagosDeEsteDocumento.ajax.reload();
                }
                if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                    getDocumentosConSaldoXClientes();
                } else {
                    DocumentosConSaldoXClientes.ajax.reload();
                }
                /*Minicartera*/
                if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumentoMini')) {
                    getPagosDocumentoMini();
                } else {
                    PagosDeEsteDocumentoMini.ajax.reload();
                }
                if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientesMini')) {
                    getDocumentosConSaldoXClientesMini();
                } else {
                    DocumentosConSaldoXClientesMini.ajax.reload();
                }
                $.getJSON('<?php print base_url('PagosDeClientes/getAgenteXCliente'); ?>', {CLIENTE: sClientePDC.val()})
                        .done(function (a) {
                            if (a.length > 0) {
                                DoctoPDC.focus().select();
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });
        DoctoPDC.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                onNotifyOld('', 'OBTENIENDO INFORMACIÓN DEL DOCUMENTO...', 'info');
                $.getJSON('<?php print base_url('PagosDeClientesMinicartera/getDatosDelDocumentoConSaldo'); ?>',
                        {
                            DOCUMENTO: DoctoPDC.val(),
                            CLIENTE: ClientePDC.val()
                        })
                        .done(function (a) {
                            console.log(a);
                            if (a.length > 0) {
                                if (parseFloat(a[0].SALDO) <= 1) {
                                    swal('ERROR', 'FACTURA SALDADA, IMPOSIBLE MODIFICAR ', 'warning').then((value) => {
                                        ImportePDC.val('');
                                        PagosPDC.val('');
                                        SaldoPDC.val('');
                                        TPPDC.val('');
                                        FacturaPDC.val('');
                                        DoctoPDC.focus().val('');
                                    });
                                } else {
                                    PagosDeEsteDocumento.ajax.reload();
                                    DocumentosConSaldoXClientes.ajax.reload();
                                    PagosDeEsteDocumentoMini.ajax.reload();
                                    DocumentosConSaldoXClientesMini.ajax.reload();
                                    FacturaPDC.val(parseFloat(a[0].IMPORTE_FACTURA).toFixed(2));
                                    ImportePDC.val(parseFloat(a[0].IMPORTE).toFixed(2));
                                    PagosPDC.val(parseFloat(a[0].PAGOS).toFixed(2));
                                    SaldoPDC.val(parseFloat(a[0].SALDO).toFixed(2));
                                    TPPDC.val(a[0].TIPO);
                                    FechaPDC.val(a[0].FECHA);
                                    CapturaPDC.focus();
                                }
                            } else {
                                swal('ERROR', 'EL DOCUMENTO NO EXISTE', 'warning').then((value) => {
                                    ImportePDC.val('');
                                    PagosPDC.val('');
                                    SaldoPDC.val('');
                                    TPPDC.val('');
                                    FacturaPDC.val('');
                                    DoctoPDC.focus().val('');
                                });
                            }
                        }).fail(function (x) {
                    getError(x);
                }).always(function () {
                });
            }
        });
        TPPDC.keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        CapturaPDC.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                MovUno.focus();
            }
        });
        /*PAGO 1*/
        MovUno.on('keypress', function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var val = $(this).val();
                if (val === '1' || val === '2' || val === '9') {

                    switch (parseInt(val)) {
                        case 1:
                            /*EFECTIVO*/
                            RefUno.val("Dep-");
                            break;
                        case 2:
                            /*CHEQUE POSFECHADO*/
                            RefUno.val("Efe-");
                            break;
                        case 9:
                            /*OTROS*/
                            RefUno.val("Otr");
                            break;
                    }
                    ImporteUno.focus();
                } else {
                    swal('ERROR', 'Tipo de movimiento debe ser sólo: 1,2 ó 9', 'warning').then((value) => {
                        MovUno.focus().val('');
                    });
                }
            }
        });
        ImporteUno.on('keypress', function (e) {
            var total_de_pagos = 0;
            total_de_pagos += ImporteUno.val() ? parseFloat(ImporteUno.val()) : 0;
            if (e.keyCode === 13 && $(this).val()) {
                if (parseFloat(total_de_pagos) > parseFloat(SaldoPDC.val())) {
                    swal('ATENCIÓN', 'EL IMPORTE DEL PAGO SUPERA AL SALDO DEL DOCUMENTO', 'warning').then((value) => {
                        ImporteUno.val('').focus().select();
                    });
                } else {
                    RefUno.focus();
                }
            }
        });
        RefUno.on('keypress', function (e) {
            if (RefUno.val() && e.keyCode === 13) {
                btnAceptaPagos.focus();
            }
        });
        btnAceptaPagos.click(function () {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción no se puede revertir",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    if (ClientePDC.val() && DoctoPDC.val() && FechaPDC.val() && TPPDC.val() && CapturaPDC.val()) {
                        HoldOn.open({theme: 'sk-rect', message: 'Guardando pagos...'});
                        /*Datos generales*/
                        var p = {
                            CLIENTE: ClientePDC.val(),
                            NUMERO_RF: DoctoPDC.val(),
                            TP: TPPDC.val(),
                            FECHA: CapturaPDC.val(),
                            FECHAFAC: FechaPDC.val(),
                            IMPORTEFAC: ImportePDC.val(),
                            MOVIMIENTO: MovUno.val(),
                            IMPORTE: ImporteUno.val(),
                            REF: RefUno.val(),
                            REGRESA_SALDO: chRegresaSaldo[0].checked ? '1' : '0'
                        };
                        if (MovUno.val() && ImporteUno.val() && RefUno.val()) {
                            if (parseFloat(ImporteUno.val()) > parseFloat(SaldoPDC.val())) {
                                HoldOn.close();
                                swal('ATENCIÓN', 'EL IMPORTE DEL MOVIMIENTO ES MAYOR AL SALDO DE LA FACTURA', 'warning').then((value) => {
                                    ImporteUno.focus().select();
                                });
                            } else {
                                console.log("\n P CONTIENE \n", p);
                                $.post('<?php print base_url('PagosDeClientesMinicartera/onPagoCliente') ?>', p).done(function (a) {
                                    console.log(a);
                                    /*TERMINAR PROCESO */

                                    pnlTablero.find("input:not(#ClientePDC):not(#CapturaPDC)").val('');
                                    if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
                                        getPagosDocumento();
                                    } else {
                                        PagosDeEsteDocumento.ajax.reload();
                                    }
                                    if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
                                        getDocumentosConSaldoXClientes();
                                    } else {
                                        DocumentosConSaldoXClientes.ajax.reload();
                                    }

                                    /*Minicartera*/
                                    if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumentoMini')) {
                                        getPagosDocumentoMini();
                                    } else {
                                        PagosDeEsteDocumentoMini.ajax.reload();
                                    }
                                    if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientesMini')) {
                                        getDocumentosConSaldoXClientesMini();
                                    } else {
                                        DocumentosConSaldoXClientesMini.ajax.reload();
                                    }
                                    HoldOn.close();
                                    DoctoPDC.focus();
                                    onNotifyOld('', 'SE HAN REALIZADO LOS MOVIMIENTOS', 'success');
                                }).fail(function (x) {
                                    HoldOn.close();
                                    getError(x);
                                });
                            }
                        } else {
                            HoldOn.close();
                            swal('ATENCIÓN', 'ES NECESARIO AÑADIR LOS DATOS DEL PAGO', 'warning').then((value) => {
                                MovUno.focus();
                            });
                        }
                    } else {
                        HoldOn.close();
                        swal('ATENCIÓN', 'ES NECESARIO CAPTURAR LA INFORMACIÓN DEL CLIENTE,DEPOSITO,DOCUMENTO,TIPO,FECHAS', 'warning').then((value) => {
                            if (!ClientePDC.val()) {
                                ClientePDC.focus();
                            } else {
                                DepositoPDC.focus().select();
                            }
                        });
                    }
                }
            });

        });
        btnImprimeCartera.on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            $.ajax({
                url: base_url + 'index.php/PagosDeClientesMinicartera/onReporteMinicartera',
                type: "POST"
            }).done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlReportePagoSeguro.find('#btnAceptar'));
            });
        });
    });

    function init() {
        ClientePDC.focus();
        CapturaPDC.val(FechaActual);
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        /*Cartera*/
        if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            getPagosDocumento();
        } else {
            PagosDeEsteDocumento.ajax.reload();
        }
        if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientes')) {
            getDocumentosConSaldoXClientes();
        } else {
            DocumentosConSaldoXClientes.ajax.reload();
        }
        /*Minicartera*/
        if (!$.fn.DataTable.isDataTable('#tblPagosDeEsteDocumentoMini')) {
            getPagosDocumentoMini();
        } else {
            PagosDeEsteDocumentoMini.ajax.reload();
        }
        if (!$.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientesMini')) {
            getDocumentosConSaldoXClientesMini();
        } else {
            DocumentosConSaldoXClientesMini.ajax.reload();
        }
    }
    function getPagosDocumento() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumento.DataTable().destroy();
        }
        PagosDeEsteDocumento = tblPagosDeEsteDocumento.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientes/getPagosXDocumentos'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}, {"data": "CLIENTE"}, {"data": "DOCUMENTO"},
                {"data": "TP"}, {"data": "FECHA_DEPOSITO"}, {"data": "FECHA_CAPTURA"},
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
            "scrollY": "220px",
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
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientes/getDocumentosConSaldoXClientes'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
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
            "scrollY": "220px",
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
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
    function getPagosDocumentoMini() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDeEsteDocumento')) {
            tblPagosDeEsteDocumentoMini.DataTable().destroy();
        }
        PagosDeEsteDocumentoMini = tblPagosDeEsteDocumentoMini.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientesMinicartera/getPagosXDocumentosMini'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "CLIENTE"},
                {"data": "DOCUMENTO"},
                {"data": "TP"},
                {"data": "FECHA_CAPTURA"},
                {"data": "IMPORTE"},
                {"data": "MV"},
                {"data": "REFERENCIA"}
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
            "scrollY": "220px",
            "bSort": true,
            "aaSorting": [
                [0, 'desc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    function getDocumentosConSaldoXClientesMini() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDocumentosConSaldoXClientesMini')) {
            tblDocumentosConSaldoXClientesMini.DataTable().destroy();
        }
        DocumentosConSaldoXClientesMini = tblDocumentosConSaldoXClientesMini.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('PagosDeClientesMinicartera/getDocumentosConSaldoXClientesMini'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.CLIENTE = getVR(ClientePDC);
                    d.DOCUMENTO = getVR(DoctoPDC);
                }
            },
            "columns": [
                {"data": "ID"}/*0*/,
                {"data": "CLIENTE"}/*1*/,
                {"data": "DOCUMENTO"}/*2*/,
                {"data": "TP"}/*3*/,
                {"data": "IMPORTE"}/*4*/,
                {"data": "PAGOS"}/*5*/,
                {"data": "SALDO"}/*6*/,
                {"data": "ST"}/*7*/,
                {"data": "SALDOX"}/*8*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [8],
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
            "scrollY": "220px",
            "bSort": true,
            "aaSorting": [
                [1, 'asc']/*ID*/
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            //getBancos(tp);
            CapturaPDC.focus().select();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getImporteSinIva(e) {
        var ee = e.val() ? parseFloat(e.val()) : 0;
        return parseFloat((ee / 1.16)).toFixed(2);
    }
    function getIntVR(e) {
        return parseInt(e.val() ? e.val() : 0);
    }
</script>
<style>
    table tbody td{
        font-weight: bold ;
    }
    table tbody tr:hover td{
        font-weight: bold ;
    }
    label {
        margin-top: 0.02rem;
        margin-bottom: 0.0rem;
    }
    table tbody tr {
        font-size: 0.75rem !important;
    }
</style>