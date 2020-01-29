<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-5 float-left">
                <legend class="float-left">Recepción de Órdenes de Compra
                    <span class="badge badge-danger" >Maquila: </span>
                    <span class="badge badge-info" id="MaquilaRecibe"></span>
                </legend>

            </div>
            <div class="col-sm-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input selectNotEnter" id="SalidaMaquilas" name="SalidaMaquilas" >
                    <label class="custom-control-label labelCheck" for="SalidaMaquilas">Salida automática a maquilas</label>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-secondary btn-sm " id="btnActualizaPreciosOrdenCompra" >
                    <span class="fa fa-dollar-sign" ></span> ACT. PRECIOS O.C.
                </button>
                <button type="button" class="btn btn-warning btn-sm " id="btnVerArticulos" >
                    <span class="fa fa-cube" ></span> ARTÍCULOS
                </button>
                <button type="button" class="btn btn-info btn-sm d-none" id="btnAgregarOC">
                    <i class="fa fa-plus"></i> AGREGAR O.C.
                </button>
            </div>
        </div>
        <hr>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter captura " id="TpOrdenCompra" maxlength="1" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>O. Compra</label>
                <input type="text" class="form-control form-control-sm numbersOnly column_filter captura "  id="OrdenCompra" maxlength="10" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label for="" >Fecha O.C.</label>
                <input type="text" class="form-control form-control-sm disabledForms noCaptura" id="FechaOrden">
            </div>
            <div class="d-none" >
                <input type="text" class="form-control form-control-sm disabledForms" id="Proveedor" name="Proveedor">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Proveedor</label>
                <input type="text" class="form-control form-control-sm disabledForms noCaptura" id="NombreProveedor">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Tp Doc.</label>
                <input type="text" class="form-control form-control-sm numbersOnly captura " id="Tp" name="Tp" maxlength="1" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm captura numeric" id="Factura" name="Factura" maxlength="10" required>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha Doc.</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter captura captura2" id="FechaFactura" name="FechaFactura" maxlength="12" required>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label for="" >Artículo</label>
                <input type="text" class="form-control form-control-sm captura disabledForms" id="Articulo" name="Articulo">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Descripción</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="NombreArtículo">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Cant</label>
                <input type="text" class="form-control form-control-sm numbersOnly captura disabledForms" id="CantidadRecibida" name="CantidadRecibida" maxlength="9" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Precio" name="Precio" maxlength="9" >
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-3 mt-4">
                <button type="button" class="btn btn-primary btn-sm captura disabledForms" id="btnActualizaCantidad">
                    <i class="fa fa-check"></i> ACEPTAR
                </button>
                <button type="button" class="btn btn-success btn-sm d-none" id="btnCerrarCompra">
                    <i class="fa fa-save"></i> CERRAR COMPRA
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div id="OrdenesCompra" class="col-12 col-sm-12 col-md-6">
                <h5>Orden Compra</h5>
                <table id="tblOrdenesCompra" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tp</th>
                            <th>Folio</th>
                            <th>Cod-Art</th>
                            <th>Nom-Art</th>
                            <th>Cantidad</th>
                            <th>Recibida</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                            <th>Maq</th>
                            <th>Sem</th>
                            <th>Ano</th>
                            <th>Tipo</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div id="EntradaCompra" class="col-12 col-sm-12 col-md-6">
                <h5>Entrada Compra</h5>
                <table id="tblEntradaCompra" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cod-Art</th>
                            <th>Descripción Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-danger">Subt</th>
                            <th></th>
                            <th class="text-danger">I.V.A</th>
                            <th></th>
                            <th class="text-danger">Total</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/RecibeOrdenCompra/';
    var tblOrdenesCompra = $('#tblOrdenesCompra');
    var OrdenesCompra;
    var tblEntradaCompra = $('#tblEntradaCompra');
    var EntradaCompra;
    var pnlTablero = $("#pnlTablero");
    var btnActualizaCantidad = pnlTablero.find('#btnActualizaCantidad');
    var btnCerrarCompra = pnlTablero.find('#btnCerrarCompra');
    var btnAgregarOC = pnlTablero.find('#btnAgregarOC');
    var btnVerArticulos = pnlTablero.find('#btnVerArticulos');
    var btnActualizaPreciosOrdenCompra = pnlTablero.find('#btnActualizaPreciosOrdenCompra');
    var agregaOC = false;
    var o_cs = [];

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        //Ordenes de Compra
        pnlTablero.find('#SalidaMaquilas').change(function () {
            if (parseInt(MaqOC) > 1) {
            } else {
                $(this).prop("checked", false);
            }
        });
        pnlTablero.find("#TpOrdenCompra").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    pnlTablero.find('#OrdenCompra').focus().select();
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
        pnlTablero.find("#OrdenCompra").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                pnlTablero.find('#SalidaMaquilas').prop("checked", false);
                var tp = pnlTablero.find("#TpOrdenCompra").val();
                var prov = pnlTablero.find("#Proveedor").val();
                getOrdenCompra($(this), tp, prov);
            }
        });
        //Entrada Compra(Factura)
        pnlTablero.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    OrdenesCompra.ajax.reload();
                    pnlTablero.find('#Factura').focus().select();
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
        pnlTablero.find("#Factura").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var tp = pnlTablero.find("#Tp").val();
                var prov = pnlTablero.find("#Proveedor").val();
                var fact = pnlTablero.find("#Factura").val();
                var componente = pnlTablero.find("#Factura");

                $.getJSON(master_url + 'onVerificarCartProv', {
                    Doc: fact,
                    TpDoc: tp,
                    Proveedor: prov
                }).done(function (data) {
                    console.log(data);
                    if (data.length > 0) {//SI EL DOCUMENTO YA EXISTE EN CART PROV
                        swal({
                            title: "ATENCIÓN",
                            text: "ESTE DOCUMENTO YA FUE CAPTRUADO",
                            icon: "warning"
                        }).then((value) => {
                            pnlTablero.find("#Factura").val('').focus();
                        });
                    } else {//EL DOCUMENTO NO EXISTE
                        onVerificarExisteCompra(componente, tp, prov, fact);
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });






            }
        });
        pnlTablero.find("#FechaFactura").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                isValid('pnlTablero');
                if (valido) {
                    pnlTablero.find('#Detalle').find('.captura').removeClass('disabledForms');
                    pnlTablero.find("#Articulo").focus().select();
                } else {
                    swal('ATENCION', 'Completa los campos requeridos', 'warning');
                    pnlTablero.find('#Detalle').find('.captura').addClass('disabledForms');
                }
            }
        });
        pnlTablero.find("#Articulo").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var tp = pnlTablero.find("#TpOrdenCompra").val();
                var oc = pnlTablero.find("#OrdenCompra").val();
                getArticuloByTpByOC($(this), tp, oc);
            }
        });
        pnlTablero.find("#CantidadRecibida").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                btnActualizaCantidad.focus();
            }
        });
        //Botones
        btnActualizaCantidad.click(function () {
            var cant_rec = pnlTablero.find("#CantidadRecibida").val();
            var art = pnlTablero.find("#Articulo").val();
            if (art !== '' && cant_rec !== '') {
                btnActualizaCantidad.attr('disabled', true);
                var fact = pnlTablero.find('#Factura').val();
                var fecFact = pnlTablero.find('#FechaFactura').val();
                var tp = pnlTablero.find("#Tp").val();
                var tpoc = pnlTablero.find("#TpOrdenCompra").val();
                var oc = pnlTablero.find("#OrdenCompra").val();
                var prov = pnlTablero.find("#Proveedor").val();
                $.post(master_url + 'onModificarCantidadRecibidaByArtByOCByTp', {

                    Factura: fact,
                    FechaFactura: fecFact,
                    Articulo: art,
                    Proveedor: prov,
                    OC: oc,
                    Tp: tp,
                    CantidadRecibida: cant_rec,
                    Precio: Precio,
                    Subtotal: cant_rec * Precio,
                    Maq: Maq,
                    Sem: Sem,
                    Ano: Ano,
                    Departamento: Departamento,
                    TpOrdenCompra: TpOC
                }).done(function (data) {
                    btnActualizaCantidad.attr('disabled', false);
                    o_cs.push({
                        Tp: tpoc,
                        OC: oc
                    });
                    onNotifyOld('fa fa-check', 'CANTIDAD ACTUALIZADA', 'info');
                    OrdenesCompra.ajax.reload();
                    EntradaCompra.ajax.reload();

                    EntradaCompra.columns.adjust().draw();
                    pnlTablero.find("#NombreArtículo").val('');
                    pnlTablero.find("#CantidadRecibida").val('');
                    pnlTablero.find("#Detalle").find('input').val('');
                    pnlTablero.find("#Articulo").focus();
                    Precio = 0;
                    Subtotal = 0;
                    Maq = 0;
                    Sem = 0;
                    Ano = 0;
                    Departamento = 0;
                    pnlTablero.find('#Encabezado').find('.captura').addClass('disabledForms');
                    btnAgregarOC.removeClass('d-none');
                    btnCerrarCompra.removeClass('d-none');
                }).fail(function (x, y, z) {
                    btnActualizaCantidad.attr('disabled', false);
                    console.log(x, y, z);
                });
            } else {
                swal('ATENCION', 'Debes de teclear la cantidad y el artículo', 'warning').then((action) => {
                    btnActualizaCantidad.attr('disabled', false);
                    pnlTablero.find("#Articulo").focus().select();
                });
            }
        });
        btnCerrarCompra.click(function () {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro de Cerrar la Compra?',
                text: "Esta acción no se puede revertir",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    //HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    var frm = new FormData();
                    var tp = pnlTablero.find("#TpOrdenCompra").val();
                    var oc = pnlTablero.find("#OrdenCompra").val();
                    var Fact = pnlTablero.find("#Factura").val();
                    var tpDoc = pnlTablero.find("#Tp").val();
                    var prov = pnlTablero.find("#Proveedor").val();
                    var salidamaquilas = pnlTablero.find("#SalidaMaquilas")[0].checked ? 1 : 0;
                    frm.append('OCS', JSON.stringify(o_cs));
                    frm.append('Tp', tp);
                    frm.append('Folio', oc);
                    frm.append('Factura', Fact);
                    frm.append('TpDoc', tpDoc);
                    frm.append('Proveedor', prov);
                    frm.append('SalidaMaquilas', salidamaquilas);
                    $.ajax({
                        url: master_url + 'onCerrarCompra',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data) {
                        var doc_salida = (data.length > 0) ? data : '';
                        MaqOC = 0;
                        Precio = 0;
                        Maq = 0;
                        Sem = 0;
                        Departamento = 0;
                        TpOC = 0;
                        agregaOC = false;
                        pnlTablero.find("input").val("");
                        btnAgregarOC.addClass('d-none');
                        btnCerrarCompra.addClass('d-none');
                        pnlTablero.find('#Detalle').find('.captura').addClass('disabledForms');
                        pnlTablero.find('#Encabezado').find('input:not(.noCaptura)').removeClass('disabledForms');
                        pnlTablero.find("#FechaFactura").val(getToday());
                        pnlTablero.find('#MaquilaRecibe').html('');
                        pnlTablero.find('#SalidaMaquilas').prop("checked", false);
                        pnlTablero.find('#TpOrdenCompra').focus().select();
                        getRecords(0, 0);
                        getEntradaCompra(0, 0, 0);
                        onImprimirValeEntrada(Fact, tpDoc, prov, salidamaquilas, doc_salida);
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            });
        });
        btnAgregarOC.click(function () {
            agregaOC = true;
            pnlTablero.find('#TpOrdenCompra').removeClass('disabledForms').val("");
            pnlTablero.find('#OrdenCompra').removeClass('disabledForms').val("");
            OrdenesCompra.columns().search('').draw();
            pnlTablero.find('#TpOrdenCompra').focus();
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
        btnActualizaPreciosOrdenCompra.click(function () {
            $.fancybox.open({
                src: base_url + '/ActualizaPrecioOrdenCompra',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                    },
                    afterClose: function () {
                        pnlTablero.find("input").val("");
                        tblOrdenesCompra.DataTable().columns().search('').draw();
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
        /*Eventos de la tabla*/
        tblOrdenesCompra.find('tbody').on('click', 'tr', function () {
            tblOrdenesCompra.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            isValid('pnlTablero');
            if (valido) {
                var dtm = OrdenesCompra.row(this).data();
                temp = parseInt(dtm.ID);
                var fact = pnlTablero.find('#Factura').val();
                var fecFact = pnlTablero.find('#FechaFactura').val();
                var tp = pnlTablero.find("#Tp").val();
                var tpoc = pnlTablero.find("#TpOrdenCompra").val();
                var oc = pnlTablero.find("#OrdenCompra").val();
                var prov = pnlTablero.find("#Proveedor").val();
                var can_pen = dtm.Cantidad - dtm.Recibida;
                swal({
                    title: dtm.Articulo,
                    text: "CANTIDAD RECIBIDA: ",
                    content: 'input',
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                    buttons: ["Cancelar", "Aceptar"]
                }).then((value) => {
                    //Si le dan cancelar manda null
                    if (value === null) {

                    } else {
                        $.post(master_url + 'onModificarCantidadRecibidaByID', {
                            ID: temp,
                            CantidadRecibida: (value === '') ? can_pen : value,
                            Factura: fact,
                            FechaFactura: fecFact,
                            Articulo: dtm.ClaveArticulo,
                            Proveedor: prov,
                            OC: oc,
                            Tp: tp,
                            Precio: dtm.Precio,
                            Subtotal: dtm.Precio * ((value === '') ? parseFloat(can_pen) : parseFloat(value)),
                            Maq: dtm.Maq,
                            Sem: dtm.Sem,
                            Ano: dtm.Ano,
                            Departamento: dtm.Tipo,
                            TpOrdenCompra: dtm.Tp
                        }).done(function (data) {
                            o_cs.push({
                                Tp: dtm.Tp,
                                OC: oc
                            });
                            pnlTablero.find('#Encabezado').find('.captura').addClass('disabledForms');
                            btnAgregarOC.removeClass('d-none');
                            btnCerrarCompra.removeClass('d-none');
                            onNotifyOld('fa fa-check', 'CANTIDAD ACTUALIZADA', 'info');
                            OrdenesCompra.ajax.reload();
                            EntradaCompra.ajax.reload();
                            EntradaCompra.columns.adjust().draw();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }

                });
                $('.swal-modal').find('input.swal-content__input').val(can_pen).focus().select();
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
                pnlTablero.find('#Detalle').find('.captura').addClass('disabledForms');
            }
        });
    });

    function init() {
        pnlTablero.find("input").val("");
        pnlTablero.find("#FechaFactura").val(getToday());
        btnAgregarOC.addClass('d-none');
        pnlTablero.find("#TpOrdenCompra").focus();
        getRecords(0, 0);
        getEntradaCompra(0, 0, 0);
    }
    function getEntradaCompra(folio, tp, prov) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEntradaCompra')) {
            tblEntradaCompra.DataTable().destroy();
        }
        EntradaCompra = tblEntradaCompra.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getEntradaCompra',
                "dataSrc": "",
                "type": 'GET',
                "data": {
                    "Tp": tp,
                    "Doc": folio,
                    "Prov": prov
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "articulo"},
                {"data": "nomart"},
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
                    "targets": [4, 5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var subt = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(subt), 2, '.', ',');
                }, 0));


                var tp_ent_compra = pnlTablero.find("#Tp").val();
                if (tp_ent_compra) {//No hace calculos hasta que se capture el tp de la entrada
                    var iva = (tp_ent_compra === '1') ? subt * 0.16 : 0;
                    $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                        return '$' + $.number(parseFloat(iva), 2, '.', ',');
                    }, 0));

                    var total = (tp_ent_compra === '1') ? subt + iva : subt;
                    $(api.column(6).footer()).html(api.column(6, {page: 'current'}).data().reduce(function (a, b) {
                        return '$' + $.number(parseFloat(total), 2, '.', ',');
                    }, 0));
                }
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": 380,
            "bSort": true,
            "aaSorting": [
                [1, 'asc']
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    function getRecords(folio, tp) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblOrdenesCompra')) {
            tblOrdenesCompra.DataTable().destroy();
        }
        OrdenesCompra = tblOrdenesCompra.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": 'GET',
                "data": {
                    "Tp": tp,
                    "Folio": folio
                }
            },
            "columns": [
                {"data": "ID"},
                {"data": "Tp"},
                {"data": "Folio"},
                {"data": "ClaveArticulo"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "Recibida"},
                {"data": "Precio"},
                {"data": "Subtotal"},
                {"data": "Maq"},
                {"data": "Sem"},
                {"data": "Ano"},
                {"data": "Tipo"}
            ],
            "columnDefs": [
                {
                    "targets": [0, 1, 2],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [7, 8],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [9, 10, 11, 12],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": 380,
            "bSort": true,
            "aaSorting": [
                [3, 'asc']
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
    }
    var MaqOC;
    function getOrdenCompra(v, Tp, prov) {
        $.getJSON(master_url + 'getOrdenCompra', {Folio: $(v).val(), Tp: Tp}).done(function (data) {
            if (data.length > 0) {
                if (!agregaOC) {//Si es la primera o no se agrega una segunda orden de compra

                    //TRAER DATOS DE LA ORDEN
                    getRecords($(v).val(), Tp);
                    MaqOC = parseInt(data[0].Maq);
                    pnlTablero.find('#MaquilaRecibe').text(data[0].Maq);
                    pnlTablero.find('#FechaOrden').val(data[0].FechaOrden);
                    pnlTablero.find('#Proveedor').val(data[0].Proveedor);
                    pnlTablero.find('#NombreProveedor').val((parseInt(Tp) === 1) ? data[0].ProveedorF : data[0].ProveedorI);
                    pnlTablero.find('#Tp').focus().select();
                } else {
                    //Verificar que la orden de compra sea del mismo proveedor
                    if (prov !== data[0].Proveedor) {
                        swal({
                            title: "ATENCIÓN",
                            text: "LA ORDEN DE COMPRA PERTENECE A OTRO PROVEEDOR",
                            icon: "warning"
                        }).then((value) => {
                            $(v).val('').focus();
                        });
                    } else {
                        getRecords($(v).val(), Tp);
                        MaqOC = parseInt(data[0].Maq);
                        pnlTablero.find('#MaquilaRecibe').text(data[0].Maq);
                        pnlTablero.find('#FechaOrden').val(data[0].FechaOrden);
                        pnlTablero.find('#Articulo').focus().select();
                    }
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTE LA ORDEN DE COMPRA",
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
    function onVerificarExisteCompra(v, tp, prov, fact) {
        $.getJSON(master_url + 'onVerificarExisteCompra', {
            Doc: $(v).val(),
            TpDoc: tp,
            Proveedor: prov
        }).done(function (data) {
            console.log(data);
            if (data.length > 0) {
                //SI LA ORDEN DE COMPRA YA EXISTE Y ESTATUS CONCLUIDA
                if (data[0].Estatus === 'CONCLUIDA') {
                    swal({
                        title: "ATENCIÓN",
                        text: "ESTE DOCUMENTO YA FUE CAPTRUADO",
                        icon: "warning"
                    }).then((value) => {
                        $(v).val('').focus();
                    });
                } else {//NOS TRAEMOS LOS DATOS DE LA ORDEN DE COMPRA YA CAPTURADA Y BRINCAMOS EL FOCO A LOS ARTICULOS
                    pnlTablero.find('#Encabezado').find('.captura').addClass('disabledForms');
                    pnlTablero.find('#FechaDoc').val(data[0].FechaDoc);
                    btnAgregarOC.removeClass('d-none');
                    btnCerrarCompra.removeClass('d-none');

                    pnlTablero.find('#Detalle').find('.captura').removeClass('disabledForms');


                    var tpoc = pnlTablero.find("#TpOrdenCompra").val();
                    var oc = pnlTablero.find("#OrdenCompra").val();
                    o_cs.push({
                        Tp: tpoc,
                        OC: oc
                    });
                    getEntradaCompra($(v).val(), tp, prov);
                    pnlTablero.find("#Articulo").focus().select();
                }
            } else {//EL DOCUMENTO NO EXISTE
                pnlTablero.find('#FechaFactura').focus().select();
                getEntradaCompra($(v).val(), tp, prov);
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    var TpOC, Precio, Maq, Sem, Ano, Departamento;
    function getArticuloByTpByOC(v, Tp, Oc) {
        $.getJSON(master_url + 'getArticuloByTpByOC', {Articulo: $(v).val(), Tp: Tp, Oc: Oc}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find('#NombreArtículo').val(data[0].Descripcion);
                pnlTablero.find('#Precio').val(parseFloat(data[0].Precio).toFixed(2));
                Precio = data[0].Precio;
                Maq = data[0].Maq;
                Sem = data[0].Sem;
                Ano = data[0].Ano;
                Departamento = data[0].Tipo;
                TpOC = data[0].Tp;
                pnlTablero.find('#CantidadRecibida').focus().select();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTE EL ARTÍCULO EN ESTA ORDEN DE COMPRA",
                    icon: "error"
                }).then((value) => {
                    pnlTablero.find('#NombreArtículo').val('');
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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
                    console.log(data);
                    OrdenesCompra.ajax.reload();
                    EntradaCompra.ajax.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

    }
    /*Reportes*/
    function onImprimirValeEntrada(Doc, TpDoc, Prov, salidamaquila, doc_salida) {
        $.ajax({
            url: master_url + 'onImprimirValeEntrada',
            type: "POST",
            data: {
                Doc: Doc,
                TpDoc: TpDoc,
                Proveedor: Prov
            }
        }).done(function (data, x, jq) {
            if (data.length > 0) {

                $.fancybox.open({
                    src: data,
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {

                        },
                        afterClose: function () {
                            if (parseInt(salidamaquila) === 1) {
                                onImprimirValeSalida(TpDoc, doc_salida);
                            }
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
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO ES POSIBLE IMPRIMIR EL REPORTE",
                    icon: "error"
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
    function onImprimirValeSalida(TpDoc, doc_salida) {
        console.log(TpDoc, doc_salida);
        $.ajax({
            url: master_url + 'onImprimirValeSalida',
            type: "POST",
            data: {
                Doc: doc_salida,
                TpDoc: TpDoc
            }
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {
                $.fancybox.open({
                    src: data,
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
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO ES POSIBLE IMPRIMIR EL REPORTE",
                    icon: "error"
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
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