<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Pagos a clientes con el 5% de descuento automático</legend>
            </div>
            <div class="col-sm-6" align="right">
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
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Banco</label>
                        <select id="Banco" name="Banco" class="form-control form-control-sm required" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Documento</label>
                        <select id="Doc" name="Doc" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                        <label for="" >Cliente</label>
                        <select id="Cliente" name="Cliente" class="form-control form-control-sm required" >
                            <option value=""></option>
                        </select>
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
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Importe</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="ImporteDeposito" name="ImporteDeposito" maxlength="10"  required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Aplicado</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="PagosDeposito" name="PagosDeposito" maxlength="10" required=""  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Saldo</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="SaldoDeposito" name="SaldoDeposito" maxlength="10" required=""  >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-8" >
                        <label>Fecha Depósito</label>
                        <input type="text" class="form-control form-control-sm " id="FechaDeposito" name="FechaDeposito" readonly=""  required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-2 col-lg-4 col-xl-4 d-none" >
                        <label>Cuenta</label>
                        <input type="text" class="form-control form-control-sm " id="CuentaDeposito" name="CuentaDeposito" readonly=""  required="" >
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-6 d-none" >
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
                        <input type="text" class="form-control form-control-sm " readonly="" id="FolioDeposito" name="FolioDeposito" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Monto</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="MontoDocto" name="MontoDocto" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>5% Desc</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="DescuentoDocto" name="DescuentoDocto" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Iva Desc</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="IvaDocto" name="IvaDocto" required="" >
                    </div>
                    <div class="w-100 border border-info mt-2 border-right-0  border-left-0 border-bottom-0"></div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-12 col-xl-6" >
                        <label>Deposito</label>
                        <input type="text" class="form-control form-control-sm numbersOnly " readonly="" id="DepoSugerido" name="DepoSugerido" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-12 col-xl-6" >
                        <label>Deposito real</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="ImporteAPagar" name="ImporteAPagar" required="" >
                    </div>
                    <div class="w-100"></div>

                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Captura</label>
                        <input type="text" class="form-control form-control-sm date notnotEnter" id="FechaCapturaNC" name="FechaCapturaNC" required="" >
                    </div>
                    <div class="col-6 col-sm-2 col-md-4 col-lg-4 col-xl-4" >
                        <label>Nota Cred.</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="FolioNC" name="FolioNC" required="" >
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
    var master_url = base_url + 'index.php/PagosConCincoDescuento/';
    var tblAplicaDepositosCliente = $('#tblAplicaDepositosCliente');
    var AplicaDepositosCliente;
    var tblPagosDocto = $('#tblPagosDocto');
    var PagosDoctos;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var ctaCheques, agente;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FechaCapturaNC").val(getToday());
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
        pnlTablero.find("#Banco").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                var banco = pnlTablero.find("#Banco").val();
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
                        pnlTablero.find("#Cliente")[0].selectize.focus();
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

            }
        });
        pnlTablero.find("#Cliente").change(function () {
            var cliente = $(this).val();
            var tp = pnlTablero.find("#Tp").val();
            if (cliente) {
                $.getJSON(master_url + 'getDatosCliente', {
                    Cliente: cliente
                }).done(function (data) {
                    if (data.length > 0) {
                        agente = data[0].Agente;
                    }
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
            var depoSugerido = parseFloat(pnlTablero.find("#DepoSugerido").val());
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    /*valida la cantidad a pagar sea menor al saldo del deposito y menor al saldo del docto*/
                    if (importeaPag > saldo || importeaPag > depoSugerido) {
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
                        pnlTablero.find("#FechaCapturaNC").focus();
                    }
                }
            }
        });
        pnlTablero.find("#FechaCapturaNC").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#FolioNC").focus().select();
                }
            }
        });
        pnlTablero.find("#FolioNC").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = pnlTablero.find("#Tp").val();
                if ($(this).val()) {
                    $.getJSON(master_url + 'onVerificaExisteNC', {Tp: tp, NC: $(this).val()}).done(function (data) {
                        if (data.length > 0) {
                            swal({
                                title: "ATENCIÓN",
                                text: "NOTA DE CRÉDITO YA EXISTE",
                                icon: "error",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                pnlTablero.find("#FolioNC").val('').focus();
                            });
                        } else {
                            btnGuardar.focus();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });

                } else {
                    getFolioNC(tp);
                    btnGuardar.focus();
                }
            }
        });
        btnGuardar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                var importeaPag = parseFloat(pnlTablero.find("#ImporteAPagar").val());
                var saldo = parseFloat(pnlTablero.find("#SaldoDeposito").val());
                var depoSugerido = parseFloat(pnlTablero.find("#DepoSugerido").val());

                if (importeaPag > saldo || importeaPag > depoSugerido) {
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
                                MontoDocto: pnlTablero.find("#MontoDocto").val(),
                                DescuentoDocto: pnlTablero.find("#DescuentoDocto").val(),
                                IvaDocto: pnlTablero.find("#IvaDocto").val(),
                                FolioNC: pnlTablero.find("#FolioNC").val(),
                                FechaCapturaNC: pnlTablero.find("#FechaCapturaNC").val(),
                            }).done(function (data) {

                                var saldoActDepo = parseFloat(pnlTablero.find("#SaldoDeposito").val()) - parseFloat(pnlTablero.find("#ImporteAPagar").val());

                                if (saldoActDepo > 0) {
                                    pnlTablero.find("#SaldoDeposito").val(saldoActDepo.toFixed(2));
                                    pnlTablero.find("#Docto").val('');
                                    pnlTablero.find("#FechaDocto").val('');
                                    pnlTablero.find("#MontoDocto").val('');
                                    pnlTablero.find("#DescuentoDocto").val('');
                                    pnlTablero.find("#DepoSugerido").val('');
                                    pnlTablero.find("#FolioDeposito").val('');
                                    pnlTablero.find("#ImporteAPagar").val('');
                                    pnlTablero.find("#IvaDocto").val('');
                                    pnlTablero.find("#FolioNC").val('');
                                    pnlTablero.find("#FechaCapturaNC").val('');
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
            "scrollY": 350,
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
                    onNotifyOld('fa fa-times', 'FACTURA NO TIMBRADA EN EL SISTEMA', 'info');
                }
            });
            pnlTablero.find("#Tp").val(dtm.tipo);
            pnlTablero.find("#Docto").val(dtm.docto);
            pnlTablero.find("#FechaDocto").val(dtm.fecha);
            pnlTablero.find("#MontoDocto").val(parseFloat(dtm.saldo).toFixed(2)); //saldo de la factura
            pnlTablero.find("#DescuentoDocto").val(((parseFloat(dtm.saldo) * 0.05) / 1.16).toFixed(2)); //el descuento neto del 5% sin iva se divide entre 1.16
            pnlTablero.find("#IvaDocto").val(((parseFloat(dtm.saldo) * 0.05) - ((parseFloat(dtm.saldo) * 0.05) / 1.16)).toFixed(2)); //al saldo neto le restamos el saldo sin iva y nos da el iva
            //Ponemos el saldo restante menos el descuento en la captura sugerida
            var total_sugerido_con_desc = parseFloat(pnlTablero.find("#MontoDocto").val()) - parseFloat(pnlTablero.find("#DescuentoDocto").val()) - parseFloat(pnlTablero.find("#IvaDocto").val());
            pnlTablero.find("#DepoSugerido").val(parseFloat(total_sugerido_con_desc).toFixed(2));
            pnlTablero.find("#ImporteAPagar").val(parseFloat(total_sugerido_con_desc).toFixed(2)).focus().select();

            getFolioNC(dtm.tipo);
            getPagosByClienteFactTp(dtm.cliente, dtm.docto, dtm.tipo);
        });
    }
    function getFolioNC(tp) {
        $.getJSON(master_url + 'getFolioNC', {Tp: tp}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#FolioNC").val(data[0].nc);
            } else {
                pnlTablero.find("#FolioNC").val('1');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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
            "scrollY": 350,
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
        if (tp === 1) {
            getBancos(tp);
            pnlTablero.find('#Banco')[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 PARA ESTE MÓDULO",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getBancos(tp) {
        pnlTablero.find("#Banco")[0].selectize.clear(true);
        pnlTablero.find("#Banco")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getBancos', {Tp: tp}).done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Banco")[0].selectize.addOption({text: v.Banco, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getClientes() {
        pnlTablero.find("#Cliente")[0].selectize.clear(true);
        pnlTablero.find("#Cliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td span.badge{
        font-size: 100% !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
</style>
