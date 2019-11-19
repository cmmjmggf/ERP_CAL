<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Captura Depositos de Clientes</legend>
            </div>
            <div class="col-sm-6" align="right">
                <button type="button" class="btn btn-primary btn-sm " id="btnAplicarDepositos" >
                    <span class="fa fa-users" ></span> APLICA DEPÓSITOS
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimir" >
                    <span class="fa fa-file-pdf" ></span> IMPRIME
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnImprimeNoAplicados" >
                    <span class="fa fa-file-pdf" ></span> IMPRIME NO APLICADOS
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnTipoCambio" >
                    <span class="fa fa-dollar-sign" ></span> T. DE CAMBIO
                </button>
            </div>
        </div>
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
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Bco Cont.</label>
                <input type="text" class="form-control form-control-sm  " id="CtaCont" name="CtaCont" readonly="">
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter" id="FechaDoc" name="FechaDoc" maxlength="12" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm  " readonly="" id="Doc" name="Doc" maxlength="15" required>
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                <label for="" >Moneda</label>
                <select id="Moneda" name="Moneda" class="form-control form-control-sm required" >
                    <option value=""></option>
                    <option value="1">1 PESOS</option>
                    <option value="2">2 DOLAR</option>
                    <option value="3">3 EURO</option>
                    <option value="4">4 LIBRA</option>
                    <option value="5">5 JEN</option>
                </select>
            </div>
            <div class="col-6 col-sm-4 col-md-2 col-lg-1 col-xl-1" >
                <label>T.C.</label>
                <input type="text" class="form-control form-control-sm  " readonly="" id="TipoCambio" name="TipoCambio">
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2" >
                <label>Importe Tpo de Cambio</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="ImporteTC" name="ImporteTC" maxlength="10"  >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Importe" name="Importe"  maxlength="10" required>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnGuardar" data-toggle="tooltip" data-placement="right" title="Capturar Documento">
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
        <legend class="mt-2">Detalle depositos <span class="badge badge-danger" style="font-size: 14px !important;">Doble click para eliminar</span></legend>
        <div class="card-block ">
            <div id="DepositosClientes">
                <table id="tblDepositosClientes" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Tp</th>
                            <th>Banco</th>
                            <th>Cuenta</th>
                            <th>Fecha</th>
                            <th>Doc</th>
                            <th>Importe</th>
                            <th>Aplicado</th>
                            <th>Moneda</th>
                            <th>T.C.</th>
                            <th>Importe T.C.</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CapturaDepositosCliente/';
    var tblDepositosClientes = $('#tblDepositosClientes');
    var DepositosClientes;
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var remi = 0;
    $(document).ready(function () {
        /*BOTONES*/

        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        pnlTablero.find("#btnTipoCambio").click(function () {
            $('#mdlTipoCambio').modal('show');
        });
        pnlTablero.find("#btnImprimeNoAplicados").click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData();
            $.ajax({
                url: base_url + 'index.php/CapturaDepositosCliente/onImprimirDepositoClientesNoApli',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
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
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        fecha.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        pnlTablero.find("#btnImprimir").click(function () {
            var fecha = pnlTablero.find("#FechaDoc");
            if (fecha.val()) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData();
                frm.append('Fecha', fecha.val());
                $.ajax({
                    url: base_url + 'index.php/CapturaDepositosCliente/onImprimirDepositoClientes',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data.length > 0) {

                        $.fancybox.open({
                            src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
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
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                            icon: "error"
                        }).then((action) => {
                            fecha.focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "CAPTURE LA FECHA PARA IMPRIMIR EL REPORTE",
                    icon: "warning"
                }).then((value) => {
                    fecha.focus();
                });
            }
        });
        /*FUNCIONES INICIALES*/
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#FechaDoc").val(getToday());
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

                            $.getJSON(master_url + 'getCtaBancoCont', {
                                Banco: txtbco
                            }).done(function (data) {
                                if (data.length > 0) {
                                    pnlTablero.find("#CtaCont").val(data[0].sctaconf);
                                }
                                pnlTablero.find("#FechaDoc").focus().select();
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
                pnlTablero.find('#Banco').val($(this).val());
                var banco = pnlTablero.find("#sBanco").val();
                $.getJSON(master_url + 'getCtaBancoCont', {
                    Banco: banco
                }).done(function (data) {
                    if (data.length > 0) {
                        pnlTablero.find("#CtaCont").val(data[0].sctaconf);
                    }
                    pnlTablero.find("#FechaDoc").focus().select();
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

            }
        });
        pnlTablero.find("#FechaDoc").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var tp = pnlTablero.find("#Tp").val();
                    var bco = pnlTablero.find("#Banco").val();
                    var input = $(this).val();
                    var fields = input.split('/');
                    var dia = fields[0];
                    var mes = fields[1];
                    var año = fields[2].substring(2, 4);
                    var ref = tp + año + mes + dia;
                    remi = tp + año + mes + dia;
                    $.getJSON(master_url + 'onVerificaExisteDepoCliente', {
                        Docto: ref
                    }).done(function (data) {
                        if (data.length > 0) {
                            ref = parseInt(data[0].docto) + 1;
                            pnlTablero.find("#Doc").val(ref);
                        } else {
                            pnlTablero.find("#Doc").val(ref + '01');
                        }
                        pnlTablero.find("#Moneda")[0].selectize.focus();
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                    //Obtiene registros de esa fecha banco
                    getRecords(tp, bco, $(this).val(), ref);
                }
            }
        });
        pnlTablero.find("#Moneda").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                if ($(this).val() !== '1' && tp === '2') {//moneda extranjera sólo con Tp = 1
                    swal({
                        title: 'ATENCIÓN',
                        text: "Moneda extranjera, sólo puede ser con Tp = 1",
                        icon: "warning",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then((action) => {
                        pnlTablero.find("#Moneda")[0].selectize.clear(true);
                        pnlTablero.find("#Moneda")[0].selectize.focus();
                    });
                } else {//con tp=1 puede ser cualquiera
                    if (parseInt($(this).val()) === 1) {
                        pnlTablero.find("#Importe").focus().select();
                        pnlTablero.find("#ImporteTC").val('0');
                        pnlTablero.find("#TipoCambio").val('0');
                    } else {
                        pnlTablero.find("#ImporteTC").focus().select();
                        pnlTablero.find("#TipoCambio").val('14.52');
                        $.getJSON(base_url + 'index.php/DocDirecSinAfectacion/getTipoCambio').done(function (data) {
                            if (data.length > 0) {
                                switch (pnlTablero.find("#Moneda").val()) {
                                    case '1':
                                        pnlTablero.find('#TipoCambio').val(1);
                                        break;
                                    case '2':
                                        pnlTablero.find('#TipoCambio').val(data[0].Dolar);
                                        break;
                                    case '3':
                                        pnlTablero.find('#TipoCambio').val(data[0].Euro);
                                        break;
                                    case '4':
                                        pnlTablero.find('#TipoCambio').val(data[0].Libra);
                                        break;
                                    case '5':
                                        pnlTablero.find('#TipoCambio').val(data[0].Jen);
                                        break;
                                    default:
                                        pnlTablero.find('#TipoCambio').val(1);
                                }
                            }
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        });
                    }
                }
            }
        });
        pnlTablero.find("#ImporteTC").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {

                    var importe = pnlTablero.find("#TipoCambio").val() * $(this).val();
                    pnlTablero.find("#Importe").val(importe.toFixed(2));
                    btnGuardar.focus();
                }
            }
        });
        pnlTablero.find("#Importe").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    btnGuardar.focus();
                }
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción no se puede revertir",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var tp = pnlTablero.find("#Tp").val();
                        var prov = pnlTablero.find("#Cliente").val();
                        var doc = pnlTablero.find('#Doc').val();
                        var fecDoc = pnlTablero.find('#FechaDoc').val();
                        var importe = pnlTablero.find("#Importe").val();
                        var importetc = pnlTablero.find("#ImporteTC").val();
                        var banco = pnlTablero.find("#Banco").val();
                        var ctab = pnlTablero.find("#CtaCont").val();
                        var mnda = pnlTablero.find("#Moneda").val();
                        var tc = pnlTablero.find("#TipoCambio").val();
                        $.post(master_url + 'onAgregar', {
                            Tp: tp,
                            Cliente: prov,
                            Doc: doc,
                            FechaDoc: fecDoc,
                            Importe: importe,
                            ImporteTC: importetc,
                            Banco: banco,
                            Remi: remi,
                            CtaCont: ctab,
                            Moneda: mnda,
                            TipoCambio: tc
                        }).done(function (data) {
                            btnGuardar.attr('disabled', false);
                            onNotifyOld('fa fa-check', 'DOCUMENTO GUARDADO', 'info');
                            remi = 0;
                            DepositosClientes.ajax.reload();
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#FechaDoc").val(getToday());
                            pnlTablero.find("#Tp").focus();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }

        });
    });
    function getTipoCambio(mnda) {
        $.getJSON(master_url + 'getTipoCambio').done(function (data) {
            if (data.length > 0) {
                switch (mnda) {
                    case 'MXN':
                        pnlTablero.find('#TipoCambio').val(1);
                        break;
                    case 'USD':
                        pnlTablero.find('#TipoCambio').val(data[0].Dolar);
                        break;
                    case 'EUR':
                        pnlTablero.find('#TipoCambio').val(data[0].Euro);
                        break;
                    case 'LIB':
                        pnlTablero.find('#TipoCambio').val(data[0].Libra);
                        break;
                    case 'JEN':
                        pnlTablero.find('#TipoCambio').val(data[0].Jen);
                        break;
                    default:
                        pnlTablero.find('#TipoCambio').val(1);
                }
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarExisteDocumento(tp, cte, v) {
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            Tp: tp,
            Cliente: cte
        }).done(function (data) {
            if (data.length > 0) {
                swal({
                    title: "ATENCIÓN",
                    text: "ESTE DOCUMENTO YA FUE CAPTURADO",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            } else {//EL DOCUMENTO NO EXISTE
                pnlTablero.find("#FechaDoc").focus();
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getRecords(tp, bco, fecha, rem) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDepositosClientes')) {
            tblDepositosClientes.DataTable().destroy();
        }
        DepositosClientes = tblDepositosClientes.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Tp: tp, Banco: bco, Fecha: fecha, Rem: rem},
                "type": "POST"
            },
            "columns": [
                {"data": "tipo"},
                {"data": "banco"},
                {"data": "cuenta"},
                {"data": "fecha"},
                {"data": "docto"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "tmnda"},
                {"data": "tcamb"},
                {"data": "importemn"}
            ],
            "columnDefs": [
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
                },
                {
                    "targets": [8],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [9],
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
            "scrollY": 380,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [4, 'desc']
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
                        case 6:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 7:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 8:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDepositosClientes.find('tbody').on('click', 'tr', function () {
            tblDepositosClientes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblDepositosClientes.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DepositosClientes.row(this).data();
            swal({
                title: "¿Deseas eliminar el registro? ",
                text: "Tp: " + dtm.tipo + "\n Banco: " + dtm.banco + "\n Cuenta: " + dtm.cuenta + "\n Documento: " + dtm.docto,
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post(master_url + 'onEliminar', {Tp: dtm.tipo, Doc: dtm.docto, Banco: dtm.banco, Cuenta: dtm.cuenta}).done(function (data) {
                        DepositosClientes.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    }).always(function () {
                    });
                }
            });
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
</style>
<?php
$this->load->view('vTipoCambio');
