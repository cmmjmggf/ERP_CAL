<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-4 float-left">
                <legend class="float-left" id="Titulo">Inspección de piel y forro
                </legend>
            </div>
            <div class="col-sm-4 float-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input selectNotEnter" id="PermiteRecibidas" name="SalidaMaquilas" >
                    <label class="custom-control-label labelCheck" for="PermiteRecibidas">Permitir Órdenes Recibidas</label>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnNuevo" >
                    <span class="fa fa-plus" ></span> NUEVO
                </button>
            </div>
        </div>
        <div class="row Encabezado">
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >Tp*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                <label for="Clave" >Orden Compra*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="OrdenCompra" name="OrdenCompra" required="">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Proveedor</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Proveedor" name="Proveedor">
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                <label for="Clave" >Fecha</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="FechaOrden" name="FechaOrden" required="">
            </div>
        </div>
        <hr>
        <div class="row Encabezado">
            <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                <label for="Clave" >Docto*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Factura" name="Factura" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                <label for="Clave" >Fecha*</label>
                <input type="text" class="form-control form-control-sm date notEnter" id="FechaFactura" name="FechaFactura" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >Hojas*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="3" id="NumHojas" name="NumHojas" required="">
            </div>
            <div class="d-none" >
                <input type="text" id="Articulo" name="Articulo">
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label for="" >Artículo</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="DescArticulo" name="DescArticulo" required="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="Precio" name="Precio" required="">
            </div>
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
                <label>Cant.</label>
                <input type="text" class="form-control form-control-sm disabledForms" id="CantidadOrden" name="CantidadOrden" required="">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" >
                <legend class="badge badge-info">CANTIDAD DM2</legend>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" >
                <legend class="badge badge-danger">Total DM2</legend>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label class="text-info">Recibida</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="Cantidad" name="Cantidad" maxlength="6" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label class="text-danger">Devolver</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="CantidadDevuelta" maxlength="6" name="CantidadDevuelta">
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Defecto</label>
                <select id="Defecto" name="Defecto" class="form-control form-control-sm required" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                <label for="" >Detalle</label>
                <select id="DetalleDefecto" name="DetalleDefecto" class="form-control form-control-sm required">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >1ra</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Primera" name="Primera" >
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >2da</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Segunda" name="Segunda" >
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >3ra</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Tercera" name="Tercera" >
            </div>
            <div class="col-12 col-sm-6 col-md-3 col-lg-1 col-xl-1">
                <label for="Clave" >4ta</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="5" id="Cuarta" name="Cuarta" >
            </div>

            <div class="w-100"></div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-4" >
                <label for="" >Observaciones</label>
                <input type="text" class="form-control form-control-sm" maxlength="150" id="Observaciones" name="Observaciones">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2" >
                <label >Aprovechamiento</label>
                <select id="Aprovechamiento" name="Aprovechamiento" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                    <option value="100">100%</option>
                    <option value="9505">95% / 5%</option>
                    <option value="9010">90% / 10%</option>
                    <option value="8515">85% / 15%</option>
                    <option value="8020">80% / 20%</option>
                    <option value="7525">75% / 25%</option>
                    <option value="7030">70% / 30%</option>
                    <option value="6535">65% / 35%</option>
                    <option value="6040">60% / 40%</option>
                    <option value="5545">55% / 45%</option>
                    <option value="5050">50% / 50%</option>
                </select>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-2" >
                <label>Hojas Revisadas</label>
                <input type="text" class="form-control form-control-sm numbersOnly" id="HojasRevisadas" name="HojasRevisadas"  maxlength="4" >
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
                <label>Detalle Inspección</label>
                <div class="row">
                    <table id="tblMovimientos" class="table table-sm display " style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Art</th>
                                <th></th>
                                <th>Entregada</th>
                                <th>Devuelta</th>
                                <th>Defecto</th>
                                <th>Detalle</th>
                                <th>(-)</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total: </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div id="Compra" class="col-12 col-sm-12 col-md-6">
                <label>Detalle Orden Compra <span class="badge badge-warning">Haga click para seleccionar material</span></label>
                <div class="row">
                    <table id="tblCompra" class="table table-sm display " style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Artículo</th>
                                <th>Entregado</th>
                                <th>Factura</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Sem</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
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
</div>
<script>
    var master_url = base_url + 'index.php/InspeccionPielForro/';
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
    var clave_prov = '';

    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#Defecto', '#DetalleDefecto', pnlTablero);
        setFocusSelectToInputOnChange('#DetalleDefecto', '#Primera', pnlTablero);
        setFocusSelectToInputOnChange('#Aprovechamiento', '#HojasRevisadas', pnlTablero);
        handleEnter();
        init();
        btnNuevo.click(function () {
            init();
        });
        btnGuardar.click(function () {
            //Calcular total 1
            var cant = $.isNumeric(pnlTablero.find("#Cantidad").val()) ? parseFloat(pnlTablero.find("#Cantidad").val()) : 0;
            var cant_dev = $.isNumeric(pnlTablero.find("#CantidadDevuelta").val()) ? parseFloat(pnlTablero.find("#CantidadDevuelta").val()) : 0;


            var tot1 = cant - cant_dev;
            //Calcular total 2
            var primera = $.isNumeric(pnlTablero.find("#Primera").val()) ? parseFloat(pnlTablero.find("#Primera").val()) : 0;
            var segunda = $.isNumeric(pnlTablero.find("#Segunda").val()) ? parseFloat(pnlTablero.find("#Segunda").val()) : 0;
            var tercera = $.isNumeric(pnlTablero.find("#Tercera").val()) ? parseFloat(pnlTablero.find("#Tercera").val()) : 0;
            var cuarta = $.isNumeric(pnlTablero.find("#Cuarta").val()) ? parseFloat(pnlTablero.find("#Cuarta").val()) : 0;
            var tot2 = primera + segunda + tercera + cuarta;

            if (tot1 !== tot2) {//No Coinciden las cantidades
                swal({
                    title: "ATENCIÓN",
                    text: "LA CANTIDAD RECIBIDA/DEVUELTA NO CONCUERDA CON CANTIDADES CLASIFICADAS COMO 1RA, 2DA, 3RA, 4TA",
                    icon: "warning"
                }).then((value) => {
                    $(this).focus();
                });
            } else {
                isValid('pnlTablero');
                if (valido) {
                    //Aquí me quedé
                    var tp = pnlTablero.find("#Tp").val();
                    var orden_compra = pnlTablero.find("#OrdenCompra").val();
                    var fact = pnlTablero.find('#Factura').val();
                    var fecha_fact = pnlTablero.find('#FechaFactura').val();
                    var Articulo = pnlTablero.find("#Articulo").val();
                    var precio = pnlTablero.find("#Precio").val();
                    var cantidad_rec = pnlTablero.find('#Cantidad').val();
                    var cantidad_dev = pnlTablero.find('#CantidadDevuelta').val();
                    var obser = pnlTablero.find("#Observaciones").val();
                    var defecto = pnlTablero.find('#Defecto').val();
                    var detalle_def = pnlTablero.find("#DetalleDefecto").val();
                    var partida_ini = pnlTablero.find('#Factura').val() + clave_prov + '001';
                    var partida_fin = pnlTablero.find('#Factura').val() + clave_prov + padLeft(pnlTablero.find('#NumHojas').val(), 3);
                    var aprovechamiento = pnlTablero.find('#Aprovechamiento').val();
                    var num_hojas = pnlTablero.find("#NumHojas").val();
                    var hojas_rev = pnlTablero.find('#HojasRevisadas').val();
                    //Guardar registro
                    $.post(master_url + 'onAgregar', {
                        Tp: tp,
                        OrdenCompra: orden_compra,
                        Proveedor: clave_prov,
                        Factura: fact,
                        FechaFactura: fecha_fact,
                        Articulo: Articulo,
                        Precio: precio,
                        Cantidad: cantidad_rec,
                        CantidadDevuelta: cantidad_dev,
                        Observaciones: obser,
                        Defecto: defecto,
                        DetalleDefecto: detalle_def,
                        PartidaIni: partida_ini,
                        PartidaFin: partida_fin,
                        Aprovechamiento: aprovechamiento,
                        NumHojas: num_hojas,
                        HojasRevisadas: hojas_rev,
                        Primera: primera,
                        Segunda: segunda,
                        Tercera: tercera,
                        Cuarta: cuarta
                    }).done(function (data) {
                        onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'success');
                        if (nuevo) {
                            getRecords(tp, fact, clave_prov);
                            nuevo = false;
                        } else {
                            Movimientos.ajax.reload();
                        }
                        pnlTablero.find('#Detalle').find("input").val('');
                        pnlTablero.find("#Defecto")[0].selectize.clear(true);
                        pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
                        pnlTablero.find("#Aprovechamiento")[0].selectize.clear(true);
                        pnlTablero.find('#Cantidad').focus();
                        btnTerminarCaptura.removeClass('disabledForms');
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });

                } else {
                    swal('ATENCION', 'Completa los campos requeridos', 'warning');
                }
            }

        });
        btnTerminarCaptura.click(function () {
            var tp = pnlTablero.find("#Tp").val();
            var fact = pnlTablero.find('#Factura').val();
            if (!nuevo) {
                //Guardar registro
                $.post(master_url + 'onCerrarCaptura', {
                    Tp: tp,
                    Proveedor: clave_prov,
                    Factura: fact
                }).done(function (data) {
                    swal({
                        title: "REGISTRO FINALIZADO",
                        text: "Se ha capturado completamente la inspección",
                        icon: "success",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        onImprimirReporteInspeccion(tp, fact);
                        init();
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        });
        pnlTablero.find("#Tp").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 1 || tp === 2) {
                pnlTablero.find('#OrdenCompra').focus();
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
        pnlTablero.find("#OrdenCompra").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            if ($(this).val() !== '') {
                onVerificarExisteOrdenCompra(tp, $(this));
            }
        });
        pnlTablero.find("#Factura").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            if ($(this).val() !== '') {
                onVerificarExisteFactura(tp, $(this));
            }
        });
        pnlTablero.find("#NumHojas").change(function () {
            if ($(this).val() !== '' && parseFloat($(this).val()) > 0) {
                onNotifyOld('fa fa-exclamation', 'SELECCIONE EL ARTICULO A RECIBIR EN EL DETALLE DE LA ORDEN DE COMPRA', 'info');
            }
        });
        pnlTablero.find("#Cantidad").change(function () {
            if ($(this).val() !== '' && parseFloat($(this).val()) > 0) {
                pnlTablero.find("#CantidadDevuelta").focus();
            } else {
                $(this).val('').focus();
            }
        });
        pnlTablero.find("#CantidadDevuelta").change(function () {
            var cantidad_rec = parseFloat(pnlTablero.find("#Cantidad").val());
            if ($(this).val() !== '' && parseFloat($(this).val()) <= cantidad_rec) {
                pnlTablero.find("#Defecto")[0].selectize.focus();
            } else {

                swal({//No Existe
                    title: "ATENCIÓN",
                    text: "LA CANTIDAD A DEVOLVER NO PUEDE SER MAYOR A CANTIDAD RECIBIDA",
                    icon: "warning"
                }).then((value) => {
                    $(this).val('').focus();
                });
            }
        });
        pnlTablero.find("#HojasRevisadas").keydown(function (e) {
            if (e.keyCode === 13) {
                var cantidad_rec = parseFloat(pnlTablero.find("#Cantidad").val());
                if ($(this).val() !== '' && parseFloat($(this).val()) > 0) {
                    if (parseFloat($(this).val()) > cantidad_rec) {
                        btnGuardar.addClass('selectNotEnter');
                        swal({//No Existe
                            title: "ATENCIÓN",
                            text: "LA CANTIDAD DE HOJAS REVISADAS NO PUEDE SER MAYOR A CANTIDAD RECIBIDA",
                            icon: "warning"
                        }).then((value) => {
                            $(this).val('').focus();
                        });
                    } else {
                        btnGuardar.removeClass('selectNotEnter');
                        btnGuardar.focus();
                    }
                } else {
                    btnGuardar.addClass('selectNotEnter');
                    swal({//No PUEDE IR EN CEROS O VACIO
                        title: "ATENCIÓN",
                        text: "LA CANTIDAD DE HOJAS REVISADAS NO PUEDE IR VACÍO Ó EN 0'S",
                        icon: "warning"
                    }).then((value) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
    });

    function onImprimirReporteInspeccion(tp, fact) {
        //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

        $.post(master_url + 'onReporteInspeccion', {
            Tp: tp,
            Proveedor: clave_prov,
            Factura: fact
        }).done(function (data) {
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
                                width: "95%",
                                height: "95%"
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
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
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

    function getDefectos() {
        pnlTablero.find("#Defecto")[0].selectize.clear(true);
        pnlTablero.find("#Defecto")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getDefectos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Defecto")[0].selectize.addOption({text: v.Defecto, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getDetallesDefectos() {
        pnlTablero.find("#DetalleDefecto")[0].selectize.clear(true);
        pnlTablero.find("#DetalleDefecto")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getDetallesDefectos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#DetalleDefecto")[0].selectize.addOption({text: v.DetalleDefecto, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onVerificarExisteOrdenCompra(tp, v) {
        $.getJSON(master_url + 'onVerificarExisteOrdenCompra', {
            Tp: tp,
            Doc: $(v).val()
        }).done(function (data) {
            if (data.length > 0) {//Existe
                var prov = (tp === '1') ? data[0].NombreF : data[0].NombreI;
                var permiteRecibidas = pnlTablero.find("#PermiteRecibidas")[0].checked ? 1 : 0;
                clave_prov = data[0].Proveedor;
                if (data[0].Estatus === 'CANCELADA' || data[0].Estatus === 'INACTIVA') { //NO SE PUEDE PROCESAR
                    swal({//No Existe
                        title: "ATENCIÓN",
                        text: "ORDEN DE COMPRA CANCELADA O INACTIVA",
                        icon: "warning"
                    }).then((value) => {
                        pnlTablero.find('input').val('');
                        pnlTablero.find('#Tp').focus();
                    });
                } else if (data[0].Estatus === 'RECIBIDA') {
                    if (permiteRecibidas === 0) { //SI NO ESTÁ ACTIVADA LA OPCION DE PERMITIR RECIBIDAS MANDAR MENSAJE
                        swal({//No Existe
                            title: "ATENCIÓN",
                            text: "ORDEN DE COMPRA YA RECIBIDA",
                            icon: "warning"
                        }).then((value) => {
                            pnlTablero.find('input').val('');
                            pnlTablero.find('#Tp').focus();
                        });
                    } else {
                        pnlTablero.find('#Proveedor').val(data[0].Proveedor + ' - ' + prov);
                        pnlTablero.find('#FechaOrden').val(data[0].FechaOrden);
                        getDetalleOrdenCompra(tp, $(v).val());

                    }
                } else {//SI SE PUEDE PROCESAR
                    pnlTablero.find('#Proveedor').val(data[0].Proveedor + ' - ' + prov);
                    pnlTablero.find('#FechaOrden').val(data[0].FechaOrden);
                    getDetalleOrdenCompra(tp, $(v).val());
                }

            } else {//EL DOCUMENTO NO EXISTE
                swal({//No Existe
                    title: "ATENCIÓN",
                    text: "NO EXISTE ORDEN DE COMPRA Ó NO ES DE TIPO 10",
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

    function onVerificarExisteFactura(tp, v) {
        $.getJSON(master_url + 'onVerificarExisteFactura', {
            Tp: tp,
            Doc: $(v).val()
        }).done(function (data) {
            if (data.length > 0) {//Existe
                swal({//No Existe
                    title: "ATENCIÓN",
                    text: "LA FACTURA PARA LA ORDEN DE COMPRA, YA HA SIDO CAPTURADA",
                    icon: "warning"
                }).then((value) => {
                    pnlTablero.find('#Factura').val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getRecords(tp, fact, prov) {
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
                "data": {Tp: tp, Fac: fact, Proveedor: prov},
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "ClaveArt"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "CantidadDevuelta"},
                {"data": "Defecto"},
                {"data": "DetalleDefecto"},
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
                        return $.number(parseFloat(data), 2, '.', ',');
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
                [0, 'desc']
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
                var total = api.column(4).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">' + $.number(parseFloat(total), 2, '.', ',') + '</span>';
                }, 0));
            },
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-success text-strong');
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
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;

                        case 6:
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

    function getDetalleOrdenCompra(tp, folio) {
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
                "url": master_url + 'getDetalleOrdenCompra',
                "data": {
                    Tp: tp,
                    Doc: folio
                },
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "ClaveArt"},
                {"data": "Articulo"},
                {"data": "Recibida"},
                {"data": "Factura"},
                {"data": "Cantidad"},
                {"data": "Precio"},
                {"data": "SubTotal"},
                {"data": "Sem"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [7],
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
                            c.addClass('text-success text-strong');
                            break;
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(); //Get access to Datatable API
                //Entregado
                var total = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">' + $.number(parseFloat(total), 2, '.', ',') + '</span>';
                }, 0));
                // Cantidad
                var totalC = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">' + $.number(parseFloat(totalC), 2, '.', ',') + '</span>';
                }, 0));
                // Cantidad
                var totalSubTotal = api.column(7).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(7).footer()).html(api.column(7, {page: 'current'}).data().reduce(function (a, b) {
                    return  '<span class="badge badge-info">$' + $.number(parseFloat(totalSubTotal), 2, '.', ',') + '</span>';
                }, 0));


            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });
        tblCompra.find('tbody').on('click', 'tr', function () {
            tblCompra.find("tbody tr").removeClass("success");
            $(this).addClass("success");


            var dtm = Compra.row(this).data();
            pnlTablero.find('#Articulo').val(dtm.ClaveArt);
            pnlTablero.find('#DescArticulo').val(dtm.ClaveArt + ' - ' + dtm.Articulo);
            pnlTablero.find('#Precio').val(dtm.Precio);
            pnlTablero.find('#CantidadOrden').val(dtm.Cantidad);
            pnlTablero.find('#Cantidad').focus();
        });
    }

    function init() {
        nuevo = true;
        total = 0;
        clave_prov = '';
        getDefectos();
        getDetallesDefectos();
        getDetalleOrdenCompra('', '');
        getRecords('', '', '');
        Movimientos.clear().draw();
        Compra.clear().draw();
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        btnTerminarCaptura.addClass('disabledForms');
        pnlTablero.find("#FechaFactura").val(getToday());
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
