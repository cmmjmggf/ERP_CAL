<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-4 float-left">
                <legend class="float-left" id="Titulo">Nota de Cargo Directa Sin Afectación al Almacén
                    <span class="badge badge-info" >Folio </span>
                    <span class="badge badge-danger" id="Folio"></span>
                </legend>
            </div>
            <div class="col-sm-8" align="right">
                <a class="btn btn-danger btn-sm selectNotEnter" href="#" data-toggle="modal" data-target="#mdlCancelaNotaCargo" data-backdrop='true'>
                    <span class="fa fa-ban" ></span> CANCELAR NOTA</a>
                <a class="btn btn-primary btn-sm selectNotEnter" href="#" data-toggle="modal" data-target="#mdlEstadoCuentaProveedor" data-backdrop='true'>
                    <span class="fa fa-file-pdf" ></span> EDOS. DE CUENTA</a>
                <button type="button" class="btn btn-info btn-sm selectNotEnter" id="btnNuevo" >
                    <span class="fa fa-plus" ></span> NUEVO
                </button>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >Tp*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                <label>Proveedor*</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly captura" id="Proveedor" name="Proveedor" maxlength="5" required="">
                    </div>
                    <div class="col-9">
                        <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Documento</label>
                <select id="DocCartProv" name="DocCartProv" class="form-control form-control-sm required captura" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Importe</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="ImporteDoc" name="ImporteDoc" readonly="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Pagos</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Pagos_Doc" name="Pagos_Doc" readonly="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Saldo</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Saldo_Doc" name="Saldo_Doc" readonly="">
            </div>
            <div class="w-100"></div>
            <div class="col-6 col-sm-6 col-md-5 col-lg-5 col-xl-4" >
                <label>Concepto</label>
                <input type="text" class="form-control form-control-sm "  id="Concepto" name="Concepto" maxlength="90">
            </div>

        </div>
        <hr>
        <div class="row" id="Detalle">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Cantidad</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Cantidad" name="Cantidad" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm "  id="Precio" name="Precio" maxlength="15">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Subtotal</label>
                <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Subtotal" name="Cantidad" >
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 mt-4">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnGuardar">
                    <i class="fa fa-save"></i> ACEPTAR
                </button>
                <button type="button" class="btn btn-success disabledForms" id="btnTerminarCaptura">
                    <i class="fa fa-check"></i> CERRAR N.C
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div id="Movimientos" class="col-12 col-sm-12 col-md-12">
                <h5>Detalle de Nota Cargo</h5>
                <table id="tblMovimientos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Articulo</th>
                            <th></th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total: </th>
                            <th>Cantidad</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url_ncd = base_url + 'index.php/NotasCargoDirectas/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var btnNuevo = pnlTablero.find('#btnNuevo');
    var btnTerminarCaptura = pnlTablero.find('#btnTerminarCaptura');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var nuevo = true;
    var folio = '';

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#sProveedor', '#DocCartProv', pnlTablero);
        setFocusSelectToInputOnChange('#Tipo', '#Cantidad', pnlTablero);
        init();
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    pnlTablero.find('#Proveedor').focus();
                    getProveedores(tp);
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
        pnlTablero.find('#Proveedor').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url_ncd + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprov, true);

                            var tp = pnlTablero.find("#Tp").val();
                            $.getJSON(master_url_ncd + 'getDocumentosByTpByProveedor', {
                                Tp: tp,
                                Proveedor: txtprov
                            }).done(function (data) {
                                pnlTablero.find("#DocCartProv")[0].selectize.clear(true);
                                pnlTablero.find("#DocCartProv")[0].selectize.clearOptions();
                                if (data.length > 0) {//Existe
                                    $.each(data, function (k, v) {
                                        pnlTablero.find("#DocCartProv")[0].selectize.addOption({text: v.Doc + ' ----> [' + v.FechaDoc + ']', value: v.Doc});
                                    });
                                    pnlTablero.find("#DocCartProv")[0].selectize.focus();
                                    pnlTablero.find("#DocCartProv")[0].selectize.open();
                                    $.notify({
                                        // options
                                        icon: 'fa fa-check',
                                        title: '',
                                        message: 'DOCUMENTOS PENDIENTES CARGADOS'
                                    }, {
                                        // settings
                                        type: 'success',
                                        allow_dismiss: true,
                                        newest_on_top: false,
                                        showProgressbar: false,
                                        delay: 3000,
                                        timer: 1000,
                                        placement: {
                                            from: "bottom",
                                            align: "left"
                                        },
                                        animate: {
                                            enter: 'animated fadeInDown',
                                            exit: 'animated fadeOutUp'
                                        }
                                    });
                                } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                                    $.notify({
                                        // options
                                        icon: 'fa fa-exclamation',
                                        title: 'Atención',
                                        message: 'PROVEEDOR NO TIENE DOCUMENTOS PENDIENTES DE PAGO'
                                    }, {
                                        // settings
                                        type: 'danger',
                                        allow_dismiss: true,
                                        newest_on_top: false,
                                        showProgressbar: false,
                                        delay: 3000,
                                        timer: 1000,
                                        placement: {
                                            from: "bottom",
                                            align: "left"
                                        },
                                        animate: {
                                            enter: 'animated fadeInDown',
                                            exit: 'animated fadeOutUp'
                                        }
                                    });
                                }
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                $.getJSON(master_url_ncd + 'getDocumentosByTpByProveedor', {
                    Tp: tp,
                    Proveedor: $(this).val()
                }).done(function (data) {
                    pnlTablero.find("#DocCartProv")[0].selectize.clear(true);
                    pnlTablero.find("#DocCartProv")[0].selectize.clearOptions();
                    if (data.length > 0) {//Existe
                        $.each(data, function (k, v) {
                            pnlTablero.find("#DocCartProv")[0].selectize.addOption({text: v.Doc + ' ----> [' + v.FechaDoc + ']', value: v.Doc});
                        });
                        pnlTablero.find("#DocCartProv")[0].selectize.focus();
                        pnlTablero.find("#DocCartProv")[0].selectize.open();
                        $.notify({
                            // options
                            icon: 'fa fa-check',
                            title: '',
                            message: 'DOCUMENTOS PENDIENTES CARGADOS'
                        }, {
                            // settings
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            showProgressbar: false,
                            delay: 3000,
                            timer: 1000,
                            placement: {
                                from: "bottom",
                                align: "left"
                            },
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                        $.notify({
                            // options
                            icon: 'fa fa-exclamation',
                            title: 'Atención',
                            message: 'PROVEEDOR NO TIENE DOCUMENTOS PENDIENTES DE PAGO'
                        }, {
                            // settings
                            type: 'danger',
                            allow_dismiss: true,
                            newest_on_top: false,
                            showProgressbar: false,
                            delay: 3000,
                            timer: 1000,
                            placement: {
                                from: "bottom",
                                align: "left"
                            },
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        pnlTablero.find("#DocCartProv").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find("#Proveedor").val();
            onVerificarExisteDocumento($(this), tp, prov);
        });
        pnlTablero.find('#Concepto').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtc = $(this).val();
                if (txtc) {
                    pnlTablero.find('#Cantidad').focus();
                }
            }
        });
        pnlTablero.find("#Cantidad").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    pnlTablero.find("#Precio").focus();
                }
            }
        });
        pnlTablero.find("#Precio").keypress(function (e) {
            if (e.keyCode === 13) {
                var cant = pnlTablero.find("#Cantidad").val();
                var saldo = pnlTablero.find("#Saldo_Doc").val();
                var subt = 0;
                if (cant !== '' && $(this).val() !== '') {
                    subt = (parseFloat($(this).val()) * parseFloat(cant));

                    if (subt > parseFloat(saldo)) {
                        swal({
                            title: "ATENCIÓN",
                            text: "EL IMPORTE ES MAYOR AL SALDO DEL DOCUMENTO",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {

                            $(this).val('').focus();
                        });
                    } else {
                        pnlTablero.find("#Subtotal").val(subt.toFixed(2));
                        btnGuardar.focus();
                    }
                }
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            var saldo = pnlTablero.find("#Saldo_Doc").val();
            var subtotal = pnlTablero.find("#Subtotal").val();
            if (parseFloat(subtotal) > parseFloat(saldo)) {
                swal({
                    title: "ATENCIÓN",
                    text: "EL IMPORTE ES MAYOR AL SALDO DEL DOCUMENTO",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {

                    pnlTablero.find("#Precio").focus().select();
                });
            } else {
                isValid('pnlTablero');
                if (valido) {
                    var tp = pnlTablero.find("#Tp").val();
                    var prov = pnlTablero.find('#Proveedor').val();
                    var docMov = pnlTablero.find("#DocCartProv").val();
                    var cantidad = pnlTablero.find('#Cantidad').val();
                    var precio = pnlTablero.find("#Precio").val();
                    var subtotal = pnlTablero.find("#Subtotal").val();
                    var concepto = pnlTablero.find("#Concepto").val();

                    $.post(master_url_ncd + 'getFolioByTp', {
                        Tp: tp
                    }).done(function (data) {
                        if (nuevo) {
                            folio = data;
                        }
                        $.post(master_url_ncd + 'onAgregarDirecto', {
                            Tp: tp,
                            Folio: folio,
                            Proveedor: prov,
                            DocCartProv: docMov,
                            Precio: precio,
                            Cantidad: cantidad,
                            Subtotal: subtotal,
                            Concepto: concepto

                        }).done(function (data) {
                            btnGuardar.attr('disabled', false);
                            onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                            if (nuevo) {
                                getRecords(folio, tp, prov);
                                pnlTablero.find("#Folio").html(folio);
                                nuevo = false;
                            } else {
                                Movimientos.ajax.reload();
                            }
                            pnlTablero.find('#Detalle').find("input").val('');
                            btnTerminarCaptura.removeClass('disabledForms');
                            pnlTablero.find('#Concepto').val('').focus();
                        }).fail(function (x, y, z) {
                            btnGuardar.attr('disabled', false);
                            console.log(x, y, z);
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                } else {
                    btnGuardar.attr('disabled', false);
                    swal('ATENCION', 'Completa los campos requeridos', 'warning');
                }
            }
        });
        btnNuevo.click(function () {
            init();
        });
        btnTerminarCaptura.click(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find('#Proveedor').val();
            var docMov = pnlTablero.find("#DocCartProv").val();
            var tipoNC = '';

            tipoNC = '4';//Aqui siempre es x descuento
            if (tp === '1') {
                total = total * 1.16;
            }
            $.post(master_url_ncd + 'onCerrarNotaCredito', {
                Tp: tp,
                Folio: folio,
                Proveedor: prov,
                SubtotalNC: total,
                CantidadLetra: NumeroALetras(parseFloat(total).toFixed(2)),
                Tipo: tipoNC,
                DocCartProv: docMov
            }).done(function (data) {
                onImprimirReporteNotaCargo(tp, folio, prov);
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });

        });
    });
    function onImprimirReporteNotaCargo(tp, folio, prov) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(master_url_ncd + 'onImprimirReporteNotaCargo', {
            Tp: tp,
            Folio: folio,
            Proveedor: prov
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {

                $.fancybox.open({
                    src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                            init();
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
                    text: "NO EXISTEN REGISTROS",
                    icon: "error"
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
    var total = 0;
    function getRecords(nc, tp, prov) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientos')) {
            tblMovimientos.DataTable().destroy();
        }
        Movimientos = tblMovimientos.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url_ncd + 'getRecords',
                "data": {NC: nc, Tp: tp, Proveedor: prov},
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Clave"},
                {"data": "Descripcion"},
                {"data": "Cantidad"},
                {"data": "Precio"},
                {"data": "Subtotal"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return $.number(parseFloat(data), 2, '.', ',');
                    }
                },
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
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 50,
            "scrollY": 260,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'desc'], [1, 'asc']
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var totalC = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">' + $.number(parseFloat(totalC), 2, '.', ',') + '</span>';
                }, 0));
                //-----------------------------
                total = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">$' + $.number(parseFloat(total), 2, '.', ',') + '</span>';
                }, 0));
            },
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
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 4:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-danger');
                            break;

                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
        tblMovimientos.find('tbody').on('click', 'tr', function () {
            tblMovimientos.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
    }
    function onEliminarDetalleByID(IDX) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Esta acción no se puede revertir",
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url_ncd + 'onEliminarDetalleByID',
                    type: "POST",
                    data: {
                        ID: IDX
                    }
                }).done(function (data, x, jq) {
                    Movimientos.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

    }
    function onVerificarExisteDocumento(v, tp, prov) {
        $.getJSON(master_url_ncd + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            Tp: tp,
            Proveedor: prov
        }).done(function (data) {
            console.log(data);
            if (data.length > 0) {//Existe
                if (parseFloat(data[0].Pagos_Doc) >= parseFloat(data[0].ImporteDoc)) { //Si la  factura ya fue pagada
                    swal({//No Existe
                        title: "ATENCIÓN",
                        text: "LA FACTURA YA FUE SALDADA, IMPOSIBLE CAPTURAR NOTA",
                        icon: "warning"
                    }).then((value) => {
                        init();
                    });
                } else {
                    pnlTablero.find('#ImporteDoc').val(data[0].ImporteDoc);
                    pnlTablero.find('#Pagos_Doc').val(data[0].Pagos_Doc);
                    pnlTablero.find('#Saldo_Doc').val(data[0].Saldo_Doc);
                    pnlTablero.find('#Concepto').focus();

                }
            } else {//EL DOCUMENTO NO EXISTE
                swal({//No Existe
                    title: "ATENCIÓN",
                    text: "NO EXISTE DOCUMENTO CON ESTOS DATOS",
                    icon: "warning"
                }).then((value) => {
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getProveedores(tp) {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url_ncd + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function init() {
        nuevo = true;
        total = 0;
        folio = '';
        getRecords('', '', '');
        Movimientos.clear().draw();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        btnTerminarCaptura.addClass('disabledForms');
        pnlTablero.find("#Folio").html('');
        btnGuardar.attr('disabled', false);
        pnlTablero.find("#Tp").focus();
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
<?php
$this->load->view('vEstadoCuentaProveedor');
$this->load->view('vCancelaNotaCreditoProv');
