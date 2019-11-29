<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-4 float-left">
                <legend class="float-left" id="Titulo">Nota de Cargo
                    <span class="badge badge-info" >Folio </span>
                    <span class="badge badge-danger" id="Folio"></span>
                </legend>
            </div>
            <div class="col-sm-8" align="right">
                <a class="btn btn-danger btn-sm selectNotEnter" href="#" data-toggle="modal" data-target="#mdlCancelaNotaCargo" data-backdrop='true'>
                    <span class="fa fa-ban" ></span> CANCELAR NOTA</a>
                <a class="btn btn-primary btn-sm selectNotEnter" href="#" data-toggle="modal" data-target="#mdlEstadoCuentaProveedor" data-backdrop='true'>
                    <span class="fa fa-file-pdf" ></span> EDOS. DE CUENTA</a>
                <button type="button" class="btn btn-warning btn-sm selectNotEnter" id="btnVerArticulos" >
                    <span class="fa fa-cube" ></span> ARTÍCULOS
                </button>
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
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Proveedor*</label>
                <select id="Proveedor" name="Proveedor" class="form-control form-control-sm mb-2 required" required="" >
                    <option value=""></option>
                </select>
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
            <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Tipo Movimiento</label>
                <select id="Tipo" name="Tipo" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                    <option value="1">1 Cambio de Precio</option>
                    <option value="2">2 Devolución</option>
                    <option value="3">3 Descuento</option>
                </select>
            </div>

        </div>
        <hr>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-5 col-md-3 col-xl-3" >
                <label for="" >Artículo</label>
                <select id="Articulo" name="Articulo" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-1 col-xl-1">
                <label for="" >U.M.</label>
                <input type="text" class="form-control form-control-sm disabledForms"  maxlength="3" id="Unidad" name="Unidad">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm "  id="Precio" name="Precio" maxlength="15">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Cantidad</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Cantidad" name="Cantidad" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Subtotal</label>
                <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Subtotal" name="Cantidad" >
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 mt-4">
                <button type="button" class="btn btn-primary selectNotEnter" id="btnGuardar" data-toggle="tooltip" data-placement="top" title="Aceptar">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-success disabledForms" id="btnTerminarCaptura" data-toggle="tooltip" data-placement="right" title="Finalizar">
                    <i class="fa fa-check"></i> TERMINAR CAPTURA
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div id="Movimientos" class="col-12 col-sm-12 col-md-6">
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
            <div id="Compra" class="col-12 col-sm-12 col-md-6">
                <h5>Detalle de la Compra</h5>
                <table id="tblCompra" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Articulo</th>
                            <th></th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Total: </th>
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
    var master_url = base_url + 'index.php/NotasCargo/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var btnNuevo = pnlTablero.find('#btnNuevo');
    var btnVerArticulos = pnlTablero.find('#btnVerArticulos');
    var btnTerminarCaptura = pnlTablero.find('#btnTerminarCaptura');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var tblCompra = $('#tblCompra');
    var Compra;
    var nuevo = true;
    var folio = '';

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Proveedor', '#DocCartProv', pnlTablero);
        setFocusSelectToInputOnChange('#DocCartProv', '#Concepto', pnlTablero);
        setFocusSelectToSelectOnChange('#Tipo', '#Articulo', pnlTablero);
        setFocusSelectToInputOnChange('#Articulo', '#Precio', pnlTablero);
        // handleEnter();
        init();
        pnlTablero.find("#Tp").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 1 || tp === 2) {

                getProveedores(tp);
                pnlTablero.find('#Proveedor')[0].selectize.focus();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    $(this).val('').focus();
                });
            }
        });
        pnlTablero.find("#Proveedor").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            $.getJSON(master_url + 'getDocumentosByTpByProveedor', {
                Tp: tp,
                Proveedor: $(this).val()
            }).done(function (data) {
                pnlTablero.find("#DocCartProv")[0].selectize.clear(true);
                pnlTablero.find("#DocCartProv")[0].selectize.clearOptions();
                if (data.length > 0) {//Existe
                    $.each(data, function (k, v) {
                        pnlTablero.find("#DocCartProv")[0].selectize.addOption({text: v.Doc + ' ----> [' + v.FechaDoc + ']', value: v.Doc});
                    });
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
        });
        pnlTablero.find("#DocCartProv").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find("#Proveedor").val();
            pnlTablero.find("#Articulo")[0].selectize.clear(true);
            pnlTablero.find("#Articulo")[0].selectize.clearOptions();
            onVerificarExisteDocumento($(this), tp, prov);
        });
        pnlTablero.find("#Articulo").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var prov = pnlTablero.find("#Proveedor").val();
            var doc = pnlTablero.find("#DocCartProv").val();
            $.getJSON(master_url + 'getDatosArticuloCompra', {
                Tp: tp,
                Doc: doc,
                Proveedor: prov,
                Articulo: $(this).val()
            }).done(function (data) {
                if (data.length > 0) {//Existe

                    pnlTablero.find('#Unidad').val(data[0].Unidad);
                    pnlTablero.find('#Precio').val(parseFloat(data[0].Precio).toFixed(2));
                    pnlTablero.find('#Cantidad').val(parseFloat(data[0].Cantidad).toFixed(2));
                    pnlTablero.find('#Subtotal').val(parseFloat(data[0].Subtotal).toFixed(2));
                    pnlTablero.find('#Precio').focus().select();
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });
        pnlTablero.find("#Tipo").change(function () {
            isValid('Encabezado');
            if (valido) {
                enableFieldsDetalle();
                disableFieldsEncabezado();
                pnlTablero.find("#Articulo")[0].selectize.focus();
                pnlTablero.find("#Articulo")[0].selectize.open();

            }
        });
        pnlTablero.find("#Precio").change(function () {
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
                }
            }
        });
        pnlTablero.find("#Cantidad").change(function () {
            var precio = pnlTablero.find("#Precio").val();
            var saldo = pnlTablero.find("#Saldo_Doc").val();
            var subt = 0;
            if (precio !== '' && $(this).val() !== '') {
                subt = (parseFloat($(this).val()) * parseFloat(precio));

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
                    btnGuardar.removeClass('disabledForms');
                }
            }
        });
        btnVerArticulos.click(function () {
            $.fancybox.open({
                src: base_url + '/Articulos/?origen=MATERIALES',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "85%",
                            height: "85%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        btnGuardar.click(function () {
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
                    var Articulo = pnlTablero.find("#Articulo").val();
                    var cantidad = pnlTablero.find('#Cantidad').val();
                    var precio = pnlTablero.find("#Precio").val();
                    var subtotal = pnlTablero.find("#Subtotal").val();
                    var tipo = pnlTablero.find('#Tipo').val();
                    var concepto = pnlTablero.find("#Concepto").val();

                    $.post(master_url + 'getFolioByTp', {
                        Tp: tp
                    }).done(function (data) {
                        if (nuevo) {
                            folio = data;
                        }
                        $.post(master_url + 'onAgregar', {
                            Tp: tp,
                            Folio: folio,
                            Proveedor: prov,
                            DocCartProv: docMov,
                            Articulo: Articulo,
                            Precio: precio,
                            Cantidad: cantidad,
                            Subtotal: subtotal,
                            Tipo: tipo,
                            Concepto: concepto

                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                            if (nuevo) {
                                getRecords(folio, tp, prov);
                                pnlTablero.find("#Folio").html(folio);
                                nuevo = false;
                            } else {
                                Movimientos.ajax.reload();
                            }
                            Compra.ajax.reload();
                            pnlTablero.find('#Detalle').find("input").val('');
                            pnlTablero.find("#Articulo")[0].selectize.clear(true);
                            pnlTablero.find("#Articulo")[0].selectize.focus();
                            pnlTablero.find('#Tipo')[0].selectize.disable();
                            btnTerminarCaptura.removeClass('disabledForms');
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                } else {
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
            var tipo = pnlTablero.find('#Tipo').val();
            var docMov = pnlTablero.find("#DocCartProv").val();
            var tipoNC = '';

            switch (tipo) {
                case '1':
                    tipoNC = '6';
                    break;
                case '2':
                    tipoNC = '5';
                    break;
                case '3':
                    tipoNC = '4';
                    break;
            }

            if (tp === '1') {
                total = total * 1.16;
            }
            $.post(master_url + 'onCerrarNotaCredito', {
                Tp: tp,
                Folio: folio,
                Proveedor: prov,
                SubtotalNC: total,
                CantidadLetra: NumeroALetras(total),
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
        $.post(master_url + 'onImprimirReporteNotaCargo', {
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
    function getCompra(doc, tp, prov) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCompra')) {
            tblCompra.DataTable().destroy();
        }
        Compra = tblCompra.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getArticulosDocProvTp',
                "data": {
                    Doc: doc,
                    Tp: tp,
                    Proveedor: prov
                },
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Clave"},
                {"data": "Descripcion"},
                {"data": "Cantidad"},
                {"data": "Precio"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [3],
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
                [0, 'asc']
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
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">' + $.number(parseFloat(total), 2, '.', ',') + '</span>';
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblCompra.find('tbody').on('click', 'tr', function () {
            tblCompra.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
    }
    var total = 0;
    function getRecords(nc, tp, prov) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
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
                "url": master_url + 'getRecords',
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
                    url: master_url + 'onEliminarDetalleByID',
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
        $.getJSON(master_url + 'onVerificarExisteDocumento', {
            Doc: $(v).val(),
            Tp: tp,
            Proveedor: prov
        }).done(function (data) {
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
                    //Traer los materiales
                    $.getJSON(master_url + 'getArticulosDocProvTp', {
                        Doc: $(v).val(),
                        Tp: tp,
                        Proveedor: prov
                    }).done(function (data) {
                        if (data.length > 0) {//Existen
                            $.each(data, function (k, v) {
                                pnlTablero.find("#Articulo")[0].selectize.addOption({text: v.Clave + ' - ' + v.Descripcion, value: v.Clave});
                            });
                            //Obtenemos la tabla de la compra
                            getCompra($(v).val(), tp, prov);
                            pnlTablero.find('#Tipo').focus();
                        } else {
                            swal({//No Existe
                                title: "ATENCIÓN",
                                text: "NO EXISTEN REGISTROS DE MATERIALES CON ESTOS DATOS",
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
        pnlTablero.find("#Proveedor")[0].selectize.clear(true);
        pnlTablero.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Proveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function init() {
        disableFieldsDetalle();
        enableFieldsEncabezado();
        nuevo = true;
        total = 0;
        folio = '';
        getCompra('', '', '');
        getRecords('', '', '');
        Movimientos.clear().draw();
        Compra.clear().draw();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        btnTerminarCaptura.addClass('disabledForms');
        pnlTablero.find("#Folio").html('');
        pnlTablero.find("#Tp").focus();
    }
    function disableFieldsDetalle() {
        $('#Detalle').find("input").prop("readonly", true);
        $.each($('#Detalle').find("select"), function (k, v) {
            $('#Detalle').find("select")[k].selectize.disable();
        });

    }
    function enableFieldsDetalle() {
        $('#Detalle').find("input").prop("readonly", false);
        $.each($('#Detalle').find("select"), function (k, v) {
            $('#Detalle').find("select")[k].selectize.enable();
        });


    }
    function disableFieldsEncabezado() {
        pnlTablero.find('#Tp').prop("readonly", true);
        pnlTablero.find('#Concepto').prop("readonly", true);
        pnlTablero.find('#Proveedor')[0].selectize.disable();
        pnlTablero.find('#DocCartProv')[0].selectize.disable();
        //pnlTablero.find('#Tipo')[0].selectize.disable();
    }
    function enableFieldsEncabezado() {
        $('#Encabezado').find("input").prop("readonly", false);
        $.each($('#Encabezado').find("select"), function (k, v) {
            $('#Encabezado').find("select")[k].selectize.enable();
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
