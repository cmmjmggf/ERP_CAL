<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Aplica Depósitos de Clientes</legend>
            </div>
            <div class="col-sm-6" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnAplicarDepositos" >
                    <span class="fa fa-users" ></span> ACTUALIZA DESCUENTOS
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimir" >
                    <span class="fa fa-file-pdf" ></span> NOTAS DE CRÉDITO
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnVerMovimientos" >
                    <span class="fa fa-dollar-sign" ></span> MOVIMIENTOS
                </button>
            </div>
        </div>
        <div class="row ">
            <!--primer columna-->
            <div class="col-9 border border-info border-left-0  border-bottom-0">
                <div class="row">
                    <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                        <label>Tp</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
                    </div>
                    <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>Banco</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Banco" name="Banco" maxlength="3" required="">
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >-</label>
                        <select id="sBanco" name="sBanco" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Documento</label>
                        <select id="Doc" name="Doc" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                        <label>Cliente</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="5" required="">
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >-</label>
                        <select id="sCliente" name="sCliente" class="form-control form-control-sm required NotSelectize" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Importe</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteDeposito" name="ImporteDeposito" maxlength="10"  required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Aplicado</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="PagosDeposito" name="PagosDeposito" maxlength="10" required=""  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-xl-2" >
                        <label>Saldo</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="SaldoDeposito" name="SaldoDeposito" maxlength="10" required=""  >
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <label>Documentos con saldo del cliente <span class="badge badge-info" style="font-size: 13px !important;">Doble click para seleccionar</span></label>
                        <div class="card-block">
                            <div id="AplicaDepositosCliente" class="datatable-wide">
                                <table id="tblAplicaDepositosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Tp</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Pagos</th>
                                            <th>Saldo</th>
                                            <th>Estatus</th>
                                            <th>Días</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--segunda tabla-->
                    <div class="col-12 mt-2" >
                        <label>Pagos de este documento</label>
                        <div class="card-block ">
                            <div id="PagosDoctos">
                                <table id="tblPagosDocto" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Docto</th>
                                            <th>Tp</th>
                                            <th>Fecha Dep</th>
                                            <th>Fecha Cap</th>
                                            <th>Importe</th>
                                            <th>Mv</th>
                                            <th>Referencia</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--segunda columna-->
            <div class="col-3 border border-info border-right-0  border-left-0 border-bottom-0">
                <div class="row">
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-8" >
                        <label>Depósito</label>
                        <input type="text" class="form-control form-control-sm " id="FechaDeposito" name="FechaDeposito" readonly=""  required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-4" >
                        <label>Cuenta</label>
                        <input type="text" class="form-control form-control-sm " id="CuentaDeposito" name="CuentaDeposito" readonly=""  required="" >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-6" >
                        <label>Estatus</label>
                        <input type="text" class="form-control form-control-sm  " id="EstatusDeposito" name="EstatusDeposito" readonly="" required="" >
                    </div>
                    <!--datos aplicacion-->
                    <div class="w-100 border border-info mt-2 border-right-0  border-left-0 border-bottom-0"></div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-6" >
                        <label>Docto</label>
                        <input type="text" class="form-control form-control-sm " id="Docto" name="Docto" readonly=""  required="" >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-4 col-xl-6" >
                        <label>Fecha</label>
                        <input type="text" class="form-control form-control-sm  numbersOnly" id="FechaDocto" name="FechaDocto"  readonly="" required="" >
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                        <label>Folio Fiscal</label>
                        <input type="text" class="form-control form-control-sm " readonly="" id="FolioDeposito" name="FolioDeposito" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Importe</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteDocto" name="ImporteDocto" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Pagos</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="PagosDocto" name="PagosDocto" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Saldo</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="SaldoDocto" name="SaldoDocto" required="" >
                    </div>
                    <div class="w-100 border border-info mt-2 border-right-0  border-left-0 border-bottom-0"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-12 col-xl-6" >
                        <label>Importe a pagar:</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ImporteAPagar" name="ImporteAPagar" required="" >
                    </div>
                    <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4 pt-2">
                        <button type="button" class="btn btn-primary btn-sm" id="btnGuardar" data-toggle="tooltip" data-placement="top" title="Capturar Documento">
                            <i class="fa fa-save"></i> ACEPTAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/AplicaDepositosCliente/';
    var tblAplicaDepositosCliente = $('#tblAplicaDepositosCliente');
    var AplicaDepositosCliente;
    var tblPagosDocto = $('#tblPagosDocto');
    var PagosDoctos;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var ctaCheques, agente;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        getClientes();
        getRecords('', '');
        getPagosByClienteFactTp('', '', '')
        pnlTablero.find("#Tp").focus();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });

        pnlTablero.find('#Banco').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtbco = $(this).val();
                if (txtbco) {
                    var tp = pnlTablero.find("#Tp").val();
                    $.getJSON(master_url + 'onVerificarBanco', {Banco: txtbco, Tp: tp}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sBanco")[0].selectize.addItem(txtbco, true);
                            pnlTablero.find("#Doc")[0].selectize.clear(true);
                            pnlTablero.find("#Doc")[0].selectize.clearOptions();
                            $.getJSON(master_url + 'getDocumentos', {
                                Banco: txtbco,
                                Tp: tp
                            }).done(function (data) {
                                $.each(data, function (k, v) {
                                    pnlTablero.find("#Doc")[0].selectize.addOption({text: v.docto + '-' + v.banco + '-' + v.cuenta + ' - $' + v.importe, value: v.docto});
                                });
                                pnlTablero.find("#Doc")[0].selectize.focus();
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        } else {
                            swal('ERROR', 'EL BANCO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sBanco")[0].selectize.clear(true);
                                pnlTablero.find('#Banco').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sBanco").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                var banco = pnlTablero.find("#sBanco").val();
                pnlTablero.find('#Banco').val($(this).val());
                pnlTablero.find("#Doc")[0].selectize.clear(true);
                pnlTablero.find("#Doc")[0].selectize.clearOptions();
                $.getJSON(master_url + 'getDocumentos', {
                    Banco: banco,
                    Tp: tp
                }).done(function (data) {
                    $.each(data, function (k, v) {
                        pnlTablero.find("#Doc")[0].selectize.addOption({text: v.docto + '-' + v.banco + '-' + v.cuenta + ' - $' + v.importe, value: v.docto});
                    });
                    pnlTablero.find("#Doc")[0].selectize.focus();
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#Doc").change(function () {
            if ($(this).val()) {
                $.getJSON(master_url + 'getDepositobyDocto', {
                    Docto: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) {
                        pnlTablero.find("#ImporteDeposito").val(parseFloat(data[0].importe).toFixed(2));
                        pnlTablero.find("#PagosDeposito").val(parseFloat(data[0].pagos).toFixed(2));
                        pnlTablero.find("#SaldoDeposito").val((data[0].importe - data[0].pagos).toFixed(2));
                        pnlTablero.find("#FechaDeposito").val(data[0].fechaF);
                        pnlTablero.find("#EstatusDeposito").val(data[0].status);
                        pnlTablero.find("#CuentaDeposito").val(data[0].cuenta);
                        pnlTablero.find("#Cliente").focus().select();
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

            }
        });


        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    var tp = pnlTablero.find("#Tp").val();
                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtcte, true);
                            $.getJSON(master_url + 'getDatosCliente', {
                                Cliente: txtcte
                            }).done(function (data) {
                                if (data.length > 0) {
                                    agente = data[0].Agente;
                                }
                                //obtenemos los documentos de este cliente con saldo
                                pnlTablero.find("#ImporteAPagar").focus().select();
                                getRecords(tp, txtcte);
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sCliente")[0].selectize.clear(true);
                                pnlTablero.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sCliente").change(function () {
            var cliente = $(this).val();
            var tp = pnlTablero.find("#Tp").val();
            if (cliente) {
                pnlTablero.find('#Cliente').val(cliente);
                $.getJSON(master_url + 'getDatosCliente', {
                    Cliente: cliente
                }).done(function (data) {
                    if (data.length > 0) {
                        agente = data[0].Agente;
                    }
                    pnlTablero.find("#ImporteAPagar").focus().select();
                    //obtenemos los documentos de este cliente con saldo
                    getRecords(tp, cliente);
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#ImporteAPagar").keypress(function (e) {
            var importeaPag = parseFloat(pnlTablero.find("#ImporteAPagar").val());
            var saldo = parseFloat(pnlTablero.find("#SaldoDeposito").val());
            var saldoDoc = parseFloat(pnlTablero.find("#SaldoDocto").val());
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    /*valida la cantidad a pagar sea menor al saldo del deposito y menor al saldo del docto*/
                    if (importeaPag > saldo || importeaPag > saldoDoc) {
                        swal({
                            title: "ATENCIÓN",
                            text: "EL IMPORTE DE LA APLICACIÓN DEBE DE SER MENOR AL DEL DEPOSITO Y MENOR AL DEL DOCUMENTO",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            $(this).val('').focus();
                        });
                    } else {
                        btnGuardar.focus();
                    }
                }
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                var importeaPag = parseFloat(pnlTablero.find("#ImporteAPagar").val());
                var saldo = parseFloat(pnlTablero.find("#SaldoDeposito").val());
                var saldoDoc = parseFloat(pnlTablero.find("#SaldoDocto").val());

                if (importeaPag > saldo || importeaPag > saldoDoc) {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL IMPORTE DE LA APLICACIÓN DEBE DE SER MENOR AL DEL DEPOSITO Y MENOR AL DEL DOCUMENTO",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#ImporteAPagar").val('').focus();
                    });
                } else {
                    swal({
                        buttons: ["Cancelar", "Aceptar"],
                        title: 'Estás Seguro?',
                        text: "Esta acción no se puede revertir",
                        icon: "warning",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then((action) => {
                        if (action) {
                            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                            $.post(master_url + 'onAgregar', {
                                Tp: pnlTablero.find("#Tp").val(),
                                Cliente: pnlTablero.find("#Cliente").val(),
                                SaldoDeposito: pnlTablero.find("#SaldoDeposito").val(),
                                ImporteAPagar: pnlTablero.find("#ImporteAPagar").val(),
                                Documento: pnlTablero.find("#Doc").val(),
                                Banco: pnlTablero.find("#Banco").val(),
                                DocFac: pnlTablero.find("#Docto").val(),
                                FechaDeposito: pnlTablero.find("#FechaDeposito").val(),
                                CuentaDeposito: pnlTablero.find("#CuentaDeposito").val(),
                                Agente: agente,
                                UUID: pnlTablero.find("#FolioDeposito").val(),
                                ImporteDocto: pnlTablero.find("#ImporteDocto").val(),
                                PagosDocto: pnlTablero.find("#PagosDocto").val(),
                                SaldoDocto: pnlTablero.find("#SaldoDocto").val()
                            }).done(function (data) {
                                btnGuardar.attr('disabled', false);
                                var saldoActDepo = parseFloat(pnlTablero.find("#SaldoDeposito").val()) - parseFloat(pnlTablero.find("#ImporteAPagar").val());

                                if (saldoActDepo > 0) {
                                    pnlTablero.find("#SaldoDeposito").val(saldoActDepo.toFixed(2));
                                    pnlTablero.find("#Docto").val('');
                                    pnlTablero.find("#FechaDocto").val('');
                                    pnlTablero.find("#ImporteDocto").val('');
                                    pnlTablero.find("#PagosDocto").val('');
                                    pnlTablero.find("#SaldoDocto").val('');
                                    pnlTablero.find("#FolioDeposito").val('');
                                    pnlTablero.find("#ImporteAPagar").val('');
                                } else if (saldoActDepo <= 0) {
                                    agente = 0;
                                    ctaCheques = 0;
                                    pnlTablero.find("input").val("");
                                    $.each(pnlTablero.find("select"), function (k, v) {
                                        pnlTablero.find("select")[k].selectize.clear(true);
                                    });
                                    pnlTablero.find("#Tp").focus();
                                }
                                PagosDoctos.ajax.reload();
                                AplicaDepositosCliente.ajax.reload();
                                HoldOn.close();
                                onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');

                            }).fail(function (x, y, z) {
                                console.log(x, y, z);
                            });
                        }
                    });
                }
            } else {
                btnGuardar.attr('disabled', false);
            }
        });

        pnlTablero.find("#btnVerMovimientos").click(function () {
            $.fancybox.open({
                src: base_url + '/MovimientosCliente',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
    });
    function getRecords(tp, cliente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblAplicaDepositosCliente')) {
            tblAplicaDepositosCliente.DataTable().destroy();
        }
        AplicaDepositosCliente = tblAplicaDepositosCliente.DataTable({
            "dom": 'frt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Tp: tp, Cliente: cliente},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "tipo"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "status"},
                {"data": "dias"}
            ],
            "columnDefs": [
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 300,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'desc'], [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 6:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                        case 8:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblAplicaDepositosCliente.find('tbody').on('click', 'tr', function () {
            tblAplicaDepositosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblAplicaDepositosCliente.find('tbody').on('dblclick', 'tr', function () {
            var dtm = AplicaDepositosCliente.row(this).data();
            /*Obtenemos el folio fiscal*/
            $.getJSON(master_url + 'getFolioFiscal', {Factura: dtm.docto, Tp: dtm.tipo}).done(function (data) {
                if (data.length > 0) {
                    pnlTablero.find("#FolioDeposito").val(data[0].uuid);
                } else {
                    onNotifyOld('fa fa-times', 'FACTURA NO TIMBRADA EN EL SISTEMA', 'error');
                    return;
                }
            });
            pnlTablero.find("#Tp").val(dtm.tipo);
            pnlTablero.find("#Docto").val(dtm.docto);
            pnlTablero.find("#FechaDocto").val(dtm.fecha);
            pnlTablero.find("#ImporteDocto").val(parseFloat(dtm.importe).toFixed(2));
            pnlTablero.find("#PagosDocto").val(parseFloat(dtm.pagos).toFixed(2));
            pnlTablero.find("#SaldoDocto").val(parseFloat(dtm.saldo).toFixed(2));
            pnlTablero.find("#ImporteAPagar").val(parseFloat(dtm.saldo).toFixed(2)).focus().select();

            getPagosByClienteFactTp(dtm.cliente, dtm.docto, dtm.tipo);
        });
    }
    function getPagosByClienteFactTp(cliente, docfac, tp) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosDocto')) {
            tblPagosDocto.DataTable().destroy();
        }

        PagosDoctos = tblPagosDocto.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getPagosByClienteFactTp',
                "dataSrc": "",
                "data": {Tp: tp, Cliente: cliente, Factura: docfac},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "tipo"},
                {"data": "fechadep"},
                {"data": "fechacap"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"}
            ],
            "columnDefs": [
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 300,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'desc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                        case 7:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblPagosDocto.find('tbody').on('click', 'tr', function () {
            tblPagosDocto.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            getBancos(tp);
            pnlTablero.find('#Banco').focus().select();
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
    function getBancos(tp) {
        pnlTablero.find("#sBanco")[0].selectize.clear(true);
        pnlTablero.find("#sBanco")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getBancos', {Tp: tp}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sBanco")[0].selectize.addOption({text: v.Banco, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getClientes() {
        pnlTablero.find("#sCliente")[0].selectize.clear(true);
        pnlTablero.find("#sCliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sCliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }

    td span.badge{
        font-size: 100% !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
</style>
