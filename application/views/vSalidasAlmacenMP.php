<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left" id="Titulo">Salidas del Almacén General de Materia Prima
                    <span class="badge badge-danger" >Mat. a entregar</span>
                    <span class="badge badge-info" id="EntregaMat"></span>
                </legend>
            </div>
            <div class="col-sm-3" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnNuevo" >
                    <span class="fa fa-plus" ></span> NUEVO
                </button>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-2 col-sm-2 col-md-1 col-xl-1">
                <label for="" >Maq.*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="3" id="Maq" name="Maq" required="">
            </div>
            <div class="col-2 col-sm-2 col-md-1 col-xl-1">
                <label for="" >Año*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" id="Ano" name="Ano" required="">
            </div>
            <div class="col-2 col-sm-2 col-md-1 col-xl-1">
                <label for="" >Sem.*</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="Sem" name="Sem" required="">
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm " readonly="" id="DocMov" name="DocMov" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-4 col-md-2 col-lg-2 col-xl-2" >
                <label>Fecha</label>
                <input type="text" class="form-control form-control-sm  numbersOnly date notEnter " readonly="" id="FechaMov" name="FechaMov" maxlength="12" >
            </div>
            <div class="col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                <label for="" >Tipo Mov.*</label>
                <select id="TipoMov" name="TipoMov" class="form-control form-control-sm required" required="">
                    <option value=""></option>
                    <option value="SXM">SXM - SALIDA A MAQUILAS</option>
                    <option value="SPR">SPR - SALIDA A PRODUCCIÓN</option>
                    <option value="SDV">SDV - SALIDA POR DEVOLUCIÓN</option>
                    <option value="SAJ">SAJ - SALIDA POR AJUSTE</option>
                    <option value="SXP">SXP - SALIDA POR PIOCHA</option>
                    <option value="SXC">SXC - SALIDA POR CALIDAD</option>
                    <option value="SXV">SXV - SALIDA POR VENTA OBSOLETA</option>
                    <option value="STR">STR - SALIDA POR TRASPASO</option>
                </select>
            </div>
            <div class="col-6 col-sm-5 col-md-3 col-lg-2 col-xl-2">
                <label for="">Mat Ent. a Maq 1 de Otra Maq</label>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input selectNotEnter" id="MatOtraMaquila" name="MatOtraMaquila" >
                    <label class="custom-control-label" for="MatOtraMaquila"></label>
                </div>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label>Artículo</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Articulo" name="Articulo" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sArticulo" name="sArticulo" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-2 col-md-1 col-xl-1">
                <label for="" >U.M.</label>
                <input type="text" class="form-control form-control-sm" readonly="" maxlength="3" id="Unidad" name="Unidad">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm " readonly=""  id="Precio" name="Precio" maxlength="15">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Cantidad</label>
                <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Cantidad" name="Cantidad" maxlength="10" required>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-2 mt-4">
                <button type="button" class="btn btn-primary disabledForms" id="btnGuardar">
                    <i class="fa fa-save"></i> ACEPTAR
                </button>
                <button type="button" class="btn btn-success disabledForms" id="btnTerminarCaptura" >
                    <i class="fa fa-check"></i> CERRAR
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div id="Movimientos" class="col-12 col-sm-12 col-md-7">
                <h5>Material a entregar de este documento</h5>

                <table id="tblMovimientos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Maq.</th>
                            <th>Tipo</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="MatEntregado" class="col-12 col-sm-12 col-md-5">
                <h5>Total de Material Entregado Maq-Sem</h5>

                <table id="tblMatEntregado" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Entregado:</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/SalidasAlmacenMP/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var btnNuevo = pnlTablero.find('#btnNuevo');
    var btnTerminarCaptura = pnlTablero.find('#btnTerminarCaptura');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var tblMatEntregado = $('#tblMatEntregado');
    var MatEntregado;
    var nuevo = true;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#TipoMov', '#sArticulo', pnlTablero);
        setFocusSelectToInputOnChange('#sArticulo', '#Cantidad', pnlTablero);
        getArticulos();
        getRecords('0', '0');
        getMatEntregado('', '', '', '');
        pnlTablero.find('#Ano').keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#Ano").val("");
                        pnlTablero.find("#Ano").focus();
                    });
                } else {
                    pnlTablero.find("#Sem").focus().select();
                }
            }
        });
        pnlTablero.find('#Maq').keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilas($(this));
                }
            }
        });
        pnlTablero.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                var ano = pnlTablero.find("#Ano").val();
                var maq = pnlTablero.find("#Maq").val();
                onComprobarSemanasProduccion($(this), ano, maq);
            }
        });
        pnlTablero.find("#TipoMov").change(function () {
            var maq = pnlTablero.find("#Maq").val();
            if (maq !== '1' && $(this).val() === 'SAJ') {
                swal({
                    title: "ATENCIÓN",
                    text: "SALIDA POR AJUSTE SÓLO APLICA PARA MAQUILA 1",
                    icon: "warning"
                }).then((value) => {
                    if (value) {
                        $(this)[0].selectize.setValue('', true);
                        $(this)[0].selectize.focus();
                        $(this)[0].selectize.open();
                    }
                });
            }
            if (maq === '1' && $(this).val() === 'SXM') {
                swal({
                    title: "ATENCIÓN",
                    text: "SALIDA A MAQUILA(SXM) NO APLICA EN MAQUILA 1",
                    icon: "warning"
                }).then((value) => {
                    if (value) {
                        $(this)[0].selectize.setValue('', true);
                        $(this)[0].selectize.focus();
                        $(this)[0].selectize.open();

                    }
                });
            } else {
                isValid('Encabezado');
                if (valido) {
                    pnlTablero.find('#Encabezado').find('input').addClass('disabledForms');
                    pnlTablero.find('#Detalle').find('input, button').removeClass('disabledForms');
                    $.when(pnlTablero.find("#sArticulo")[0].selectize.enable()).then(function (data, textStatus, jqXHR) {
                        pnlTablero.find("#TipoMov")[0].selectize.disable();
                        pnlTablero.find("#Articulo").attr('readonly', false);
                        pnlTablero.find("#Articulo").focus();

                    });
                } else {
                    swal('ATENCION', 'Completa los campos requeridos', 'warning');
                    pnlTablero.find('#Detalle').find('input, button').addClass('disabledForms');
                    pnlTablero.find("#sArticulo")[0].selectize.disable();
                    pnlTablero.find("#Articulo").attr('readonly', true);
                }
            }

        });
        pnlTablero.find('#Articulo').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(master_url + 'onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sArticulo")[0].selectize.addItem(txtart, true);
                            var maq = pnlTablero.find("#Maq").val();
                            var ano = pnlTablero.find("#Ano").val();
                            var sem = pnlTablero.find("#Sem").val();
                            if (maq !== '') {
                                $.getJSON(master_url + 'getDatosByArticulo', {
                                    Articulo: txtart,
                                    Maquila: maq,
                                    Depto1: depto1,
                                    Depto2: depto2,
                                    Depto3: depto3
                                }).done(function (data) {
                                    if (data.length > 0) {
                                        //Validar que no sea de tipo 3 para mandarle mensaje: En este módulo no se permite dar salida a SUELAS
                                        if (data[0].grupo === '3' && maq === '1') {
                                            swal({
                                                title: "ATENCIÓN",
                                                text: "EN ESTE MÓDULO NO SE PERMITE DAR SALIDA A SUELAS",
                                                icon: "warning"
                                            }).then((value) => {
                                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                                pnlTablero.find("#Articulo").val('').focus();
                                            });
                                        } else {
                                            pnlTablero.find('#Precio').val(data[0].Precio);
                                            pnlTablero.find('#Unidad').val(data[0].Unidad);
                                            getMatEntregado(ano, maq, sem, pnlTablero.find("#Articulo").val());
                                            pnlTablero.find('#Cantidad').focus();
                                        }
                                    } else {
                                        swal({
                                            title: "ATENCIÓN",
                                            text: "EL TIPO DE ARTÍCULO (10,80,90) NO COINCIDE CON EL TIPO DE ARTÍCULO A ENTREGAR DE LA MAQUILA",
                                            icon: "warning"
                                        }).then((value) => {

                                            pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                            pnlTablero.find("#Articulo").val('');
                                            pnlTablero.find('#Maq').focus();
                                        });
                                    }
                                }).fail(function (x, y, z) {
                                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                    console.log(x.responseText);
                                });
                            } else {
                                swal({
                                    title: "ATENCIÓN",
                                    text: "DEBES DE SELECCIONAR UNA MAQUILA",
                                    icon: "warning"
                                }).then((value) => {
                                    pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                    pnlTablero.find("#Articulo").val('');
                                    pnlTablero.find('#Maq').focus();
                                });
                            }

                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                pnlTablero.find('#Articulo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sArticulo").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#Articulo").val($(this).val());
                var maq = pnlTablero.find("#Maq").val();
                var ano = pnlTablero.find("#Ano").val();
                var sem = pnlTablero.find("#Sem").val();
                if (maq !== '') {
                    $.getJSON(master_url + 'getDatosByArticulo', {
                        Articulo: $(this).val(),
                        Maquila: maq,
                        Depto1: depto1,
                        Depto2: depto2,
                        Depto3: depto3
                    }).done(function (data) {
                        if (data.length > 0) {
                            //Validar que no sea de tipo 3 para mandarle mensaje: En este módulo no se permite dar salida a SUELAS
                            if (data[0].grupo === '3' && maq === '1') {
                                swal({
                                    title: "ATENCIÓN",
                                    text: "EN ESTE MÓDULO NO SE PERMITE DAR SALIDA A SUELAS",
                                    icon: "warning"
                                }).then((value) => {
                                    pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                    pnlTablero.find("#Articulo").val('').focus();
                                });
                            } else {
                                pnlTablero.find('#Precio').val(data[0].Precio);
                                pnlTablero.find('#Unidad').val(data[0].Unidad);
                                getMatEntregado(ano, maq, sem, pnlTablero.find("#Articulo").val());
                                pnlTablero.find('#Cantidad').focus();
                            }
                        } else {
                            swal({
                                title: "ATENCIÓN",
                                text: "EL TIPO DE ARTÍCULO (10,80,90) NO COINCIDE CON EL TIPO DE ARTÍCULO A ENTREGAR DE LA MAQUILA",
                                icon: "warning"
                            }).then((value) => {

                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                pnlTablero.find("#Articulo").val('');
                                pnlTablero.find('#Maq').focus();
                            });
                        }
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBES DE SELECCIONAR UNA MAQUILA",
                        icon: "warning"
                    }).then((value) => {
                        pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                        pnlTablero.find("#Articulo").val('');
                        pnlTablero.find('#Maq').focus();
                    });
                }

            }
        });
        pnlTablero.find("#Cantidad").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                btnGuardar.focus();
            }
        });
        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                var ano = pnlTablero.find("#Ano").val();
                var maq = pnlTablero.find("#Maq").val();
                var sem = pnlTablero.find('#Sem').val();
                var docMov = pnlTablero.find("#DocMov").val();
                var fechaMov = pnlTablero.find("#FechaMov").val();
                var tipoMov = pnlTablero.find('#TipoMov').val();
                var Articulo = pnlTablero.find("#Articulo").val();
                var precio = pnlTablero.find("#Precio").val();
                var cantidad = pnlTablero.find('#Cantidad').val();
                var matOtraMaquila = pnlTablero.find("#MatOtraMaquila")[0].checked ? 1 : 0
                var subtotal = precio * cantidad;
                $.post(master_url + 'onAgregar', {
                    Articulo: Articulo,
                    PrecioMov: precio,
                    CantidadMov: cantidad,
                    FechaMov: fechaMov,
                    DocMov: docMov,
                    TipoMov: tipoMov,
                    Maq: maq,
                    Sem: sem,
                    Ano: ano,
                    Subtotal: subtotal,
                    MatOtraMaquila: matOtraMaquila
                }).done(function (data) {
                    btnGuardar.attr('disabled', false);
                    onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                    if (nuevo) {
                        getRecords(docMov);
                        nuevo = false;
                    } else {
                        Movimientos.ajax.reload();

                    }
                    MatEntregado.ajax.reload();
                    pnlTablero.find('#Detalle').find("input").val('');
                    pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                    pnlTablero.find("#Articulo").val('').focus();
                }).fail(function (x, y, z) {
                    btnGuardar.attr('disabled', false);
                    console.log(x, y, z);
                });
            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });
        btnNuevo.click(function () {
            nuevo = true;
            Movimientos.clear().draw();
            MatEntregado.clear().draw();
            pnlTablero.find("input").val("");
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            pnlTablero.find('#Encabezado').find('input, button').removeClass('disabledForms');
            pnlTablero.find("#TipoMov")[0].selectize.enable();
            pnlTablero.find("#sArticulo")[0].selectize.disable();
            pnlTablero.find("#Articulo").attr('readonly', true);
            pnlTablero.find("#FechaMov").val(getToday());
            pnlTablero.find("#Maq").focus();
            depto1 = '';
            depto2 = '';
            depto3 = '';
        });
        btnTerminarCaptura.click(function () {
            var docMov = pnlTablero.find("#DocMov").val();
            $.post(master_url + 'onImprimirValeEntrada', {Doc: docMov}).done(function (data) {
                onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                $.fancybox.open({
                    src: data,
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                        },
                        afterClose: function () {
                            btnNuevo.trigger('click');
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
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        });
    });

    function getMatEntregado(ano, maq, sem, art) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMatEntregado')) {
            tblMatEntregado.DataTable().destroy();
        }
        MatEntregado = tblMatEntregado.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getMatEntregado',
                "data": {
                    Ano: ano,
                    Maq: maq,
                    Sem: sem,
                    Articulo: art
                },
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "DocMov"},
                {"data": "Articulo"},
                {"data": "CantidadMov"}
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
                    return  '<span class="badge badge-info">' + $.number(parseFloat(total), 3, '.', ',') + '</span>';
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblMatEntregado.find('tbody').on('click', 'tr', function () {
            MatEntregado.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });
    }
    function getRecords(doc, maq) {
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
                "url": master_url + 'getRecords',
                "data": {DocMov: doc, Maq: maq},
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "ID"},
                {"data": "Clave"},
                {"data": "Descripcion"},
                {"data": "CantidadMov"},
                {"data": "Maq"},
                {"data": "TipoMov"},
                {"data": "Eliminar"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
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
    function getFolio() {
        var currentdate = new Date();
        var datetime = currentdate.getFullYear().toString().substr(-2)
                + ('0' + (currentdate.getMonth() + 1)).slice(-2)
                + ('0' + currentdate.getDate()).slice(-2)
                + ('0' + currentdate.getHours()).slice(-2)
                + ('0' + currentdate.getMinutes()).slice(-2)
                + ('0' + currentdate.getSeconds()).slice(-2);
        pnlTablero.find('#DocMov').val(datetime);
    }

    function getArticulos() {
        HoldOn.open({theme: 'sk-bounce', message: 'INCIALIZANDO DATOS...'});
        $.when($.getJSON(master_url + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sArticulo")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        })).then(function (x) {
            HoldOn.close();
            btnNuevo.trigger('click');
        });

    }
    var depto1, depto2, depto3;
    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {

            if (data.length > 0) {
//                if (parseInt($(v).val()) === 97) {
//                    swal({
//                        title: "ATENCIÓN",
//                        text: "LOS MOVIMIENTOS A SUB ALMACEN (97) SE HACEN EN OTRO MÓDULO",
//                        icon: "warning"
//                    }).then((value) => {
//                        $(v).val('').focus();
//                    });
//                } else {
//
//                }
                depto1 = data[0].Depto1;
                depto2 = data[0].Depto2;
                depto3 = data[0].Depto3;
                pnlTablero.find('#EntregaMat').text(data[0].EntregaMat);
                pnlTablero.find("#Ano").focus().select();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
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
    function onComprobarSemanasProduccion(v, ano, maq) {
        if ($(v).val() !== '') {
            $.getJSON(master_url + 'onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
                if (data.length > 0) {
                    $.getJSON(master_url + 'onVerificarSemanaProdCerrada', {
                        Ano: ano,
                        Maq: maq,
                        Sem: $(v).val()
                    }).done(function (data) {
                        if (data.length > 0) {
                            if (data[0].Estatus === 'CERRADA') {//CERRADA
                                swal({
                                    title: "ATENCIÓN",
                                    text: "LA SEMANA YA ESTA CERRADA",
                                    icon: "warning"
                                }).then((value) => {
                                    $(v).val('').focus();
                                });
                            } else {//ABIERTA
                                getFolio();
                                pnlTablero.find("#TipoMov")[0].selectize.focus();
                                pnlTablero.find("#TipoMov")[0].selectize.open();
                            }
                        } else {//ABIERTA
                            getFolio();
                            pnlTablero.find("#TipoMov")[0].selectize.focus();
                            pnlTablero.find("#TipoMov")[0].selectize.open();
                        }
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
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
