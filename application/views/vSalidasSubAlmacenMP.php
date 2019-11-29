<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left" id="Titulo">Salidas del Sub-Almacén de Materia Prima
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
            <div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <label for="" >Tipo Mov.*</label>
                <select id="TipoMov" name="TipoMov" class="form-control form-control-sm required" required="">
                    <option value=""></option>
                    <option value="SPR">SPR - SALIDA A PRODUCCIÓN</option>
                    <option value="SDV">SDV - SALIDA POR DEVOLUCIÓN</option>
                    <option value="SAJ">SAJ - SALIDA POR AJUSTE</option>
                    <option value="SXP">SXP - SALIDA POR PIOCHA</option>
                    <option value="SXC">SXC - SALIDA POR CALIDAD</option>
                </select>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-5 col-md-3 col-xl-3" >
                <label for="" >Artículo</label>
                <select id="Articulo" name="Articulo" class="form-control form-control-sm required" required="" >
                    <option value=""></option>
                </select>
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
                <input type="text" class="form-control form-control-sm numbersOnly disabledForms" id="Cantidad" name="Cantidad" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 mt-4">
                <button type="button" class="btn btn-primary disabledForms" id="btnGuardar" data-toggle="tooltip" data-placement="top" title="Capturar Entrada">
                    <i class="fa fa-save"></i>
                </button>
                <button type="button" class="btn btn-success disabledForms" id="btnTerminarCaptura" data-toggle="tooltip" data-placement="right" title="Terminar Captura">
                    <i class="fa fa-check"></i> TERMINAR CAPTURA
                </button>
            </div>
        </div>
        <div class="mt-2">
            <div id="Movimientos" >
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
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/SalidasSubAlmacenMP/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var btnNuevo = pnlTablero.find('#btnNuevo');
    var btnTerminarCaptura = pnlTablero.find('#btnTerminarCaptura');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var nuevo = true;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToSelectOnChange('#TipoMov', '#Articulo', pnlTablero);
        setFocusSelectToInputOnChange('#Articulo', '#Cantidad', pnlTablero);
        handleEnterDiv(pnlTablero);
        getArticulos();
        getRecords('0', '0');
        pnlTablero.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#Ano").val("");
                    pnlTablero.find("#Ano").focus();
                });
            }
        });
        pnlTablero.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
            pnlTablero.find("#Sem").trigger('change');
        });
        pnlTablero.find("#Sem").change(function () {
            var ano = pnlTablero.find("#Ano").val();
            var maq = pnlTablero.find("#Maq").val();
            onComprobarSemanasProduccion($(this), ano, maq);
            getFolio();
        });
        pnlTablero.find("#TipoMov").change(function () {

            isValid('Encabezado');
            if (valido) {
                pnlTablero.find('#Encabezado').find('input').addClass('disabledForms');
                pnlTablero.find('#Detalle').find('input, button').removeClass('disabledForms');
                $.when(pnlTablero.find("#Articulo")[0].selectize.enable()).then(function (data, textStatus, jqXHR) {
                    pnlTablero.find("#TipoMov")[0].selectize.disable()
                    pnlTablero.find("#Articulo")[0].selectize.focus();
                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
                pnlTablero.find('#Detalle').find('input, button').addClass('disabledForms');
                pnlTablero.find("#Articulo")[0].selectize.disable();
            }


        });
        pnlTablero.find("#Articulo").change(function () {
            var maq = pnlTablero.find("#Maq").val();
            if (maq !== '') {
                getDatosByArticulo($(this).val(), maq);
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UNA MAQUILA",
                    icon: "warning"
                }).then((value) => {
                    pnlTablero.find('#Maq').focus();
                    $(this)[0].selectize.setValue('', true);
                });
            }


        });
        btnGuardar.click(function () {
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
                    Subtotal: subtotal
                }).done(function (data) {
                    onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                    if (nuevo) {
                        getRecords(docMov);
                        nuevo = false;
                    } else {
                        Movimientos.ajax.reload();

                    }
                    pnlTablero.find('#Detalle').find("input").val('');
                    pnlTablero.find("#Articulo")[0].selectize.clear(true);
                    pnlTablero.find("#Articulo")[0].selectize.focus();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });
        btnNuevo.click(function () {
            nuevo = true;
            Movimientos.clear().draw();
            pnlTablero.find("input").val("");
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            pnlTablero.find('#Encabezado').find('input, button').removeClass('disabledForms');
            pnlTablero.find("#TipoMov")[0].selectize.enable();
            pnlTablero.find("#Articulo")[0].selectize.disable();
            pnlTablero.find("#FechaMov").val(getToday());
            pnlTablero.find("#Maq").focus();
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

    function getRecords(doc, maq) {
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
    function getDatosByArticulo(art, maq) {
        $.getJSON(master_url + 'getDatosByArticulo', {
            Articulo: art,
            Maquila: maq
        }).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find('#Precio').val(data[0].Precio);
                pnlTablero.find('#Unidad').val(data[0].Unidad);
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getArticulos() {
        HoldOn.open({theme: 'sk-bounce', message: 'INCIALIZANDO DATOS...'});
        $.when($.getJSON(master_url + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        })).then(function (x) {
            HoldOn.close();
            btnNuevo.trigger('click');
        });

    }
    function onComprobarMaquilas(v) {
        $.getJSON(master_url + 'onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {

            if (data.length > 0) {
                if (parseInt($(v).val()) > 1) {
                    swal({
                        title: "ATENCIÓN",
                        text: "SÓLO SE PUEDEN HACER SALIDAS A PRODUCCIÓN O A MAQUILA 1 POR DEVOLUCIÓN",
                        icon: "warning"
                    }).then((value) => {
                        $(v).val('').focus();
                    });
                } else {

                }
                pnlTablero.find('#EntregaMat').text(data[0].EntregaMat);
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

                            }
                        } else {//ABIERTA

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
