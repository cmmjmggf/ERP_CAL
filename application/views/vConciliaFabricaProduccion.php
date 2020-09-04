<div class="modal " id="mdlConciliaFabricaProduccion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Concilia de la Fábrica Producción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-6">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>

                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12">
                            <label>Precio <span class="badge badge-info mb-2" style="font-size: 12px;">1 Actual - 2 Del Movimiento</span></label>
                            <select class="form-control form-control-sm required selectize" id="Precio" name="Precio" >
                                <option value=""></option>
                                <option value="1">1 Actual</option>
                                <option value="2">2 Del Movimiento</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Artículo <span class="badge badge-info mb-2" style="font-size: 12px;">Para un artículo en especifico, sólo captura el código</span></label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm numbersOnly" id="ArticuloConcilia" name="ArticuloConcilia" maxlength="6" >
                                </div>
                                <div class="col-9">
                                    <select id="sArticuloConcilia" name="sArticuloConcilia" class="form-control form-control-sm NotSelectize selectNotEnter" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlConciliaFabricaProduccion = $('#mdlConciliaFabricaProduccion');
    $(document).ready(function () {
        mdlConciliaFabricaProduccion.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlConciliaFabricaProduccion.on('shown.bs.modal', function () {
            mdlConciliaFabricaProduccion.find("input").val("");
            $.each(mdlConciliaFabricaProduccion.find("select"), function (k, v) {
                mdlConciliaFabricaProduccion.find("select")[k].selectize.clear(true);
            });
            getArticulosReporteConcilia();
            mdlConciliaFabricaProduccion.find('#Ano').focus();
        });
        mdlConciliaFabricaProduccion.find('#btnImprimir').on("click", function () {
            //mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', true);
            var t_precio = mdlConciliaFabricaProduccion.find('#Precio').val();
            if (t_precio !== '') {
                //Verificamos que nadie ma esté sacando el reporte al mismo tiempo
                $.get(base_url + 'index.php/ConciliaFabricaProduccion/verificaUsoReporte').done(function (data) {
                    console.log(data);
                    if (data === '0') {//Si trae 0 esta libre
                        //INTENTAR CABIANDO DE METODO SIN FRM SIN AJAX NI CONTENTYPE
                        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                        $.get(base_url + 'index.php/ConciliaFabricaProduccion/onReporteConciliaFabricaProduccion', {
                            Precio: t_precio,
                            Maq: mdlConciliaFabricaProduccion.find('#Maq').val(),
                            Sem: mdlConciliaFabricaProduccion.find('#Sem').val(),
                            Ano: mdlConciliaFabricaProduccion.find('#Ano').val(),
                            Articulo: mdlConciliaFabricaProduccion.find('#ArticuloConcilia').val()
                        }).done(function (data, x, jq) {
                            onImprimirReporteFancyAFC(data, function (a, b) {
                                mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', false);
                            });
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', false);
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    } else {//Si no, esta ocupada por otro usuario
                        swal({
                            title: "ATENCIÓN",
                            text: "HAY OTRO USUARIO GENERANDO LA CONCILIA, POR FAVOR INTÉNTALO EN 10 SEGUNDOS",
                            icon: "error"
                        }).then((action) => {
                            mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', false);
                            mdlConciliaFabricaProduccion.find('#btnImprimir').focus();
                            return;
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN TIPO DE PRECIO",
                    icon: "error"
                }).then((action) => {
                    mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', false);
                    mdlConciliaFabricaProduccion.find('#Precio')[0].selectize.focus();
                });
            }
        });
        mdlConciliaFabricaProduccion.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {

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
                        mdlConciliaFabricaProduccion.find("#Ano").val("");
                        mdlConciliaFabricaProduccion.find("#Ano").focus();
                    });
                } else {
                    mdlConciliaFabricaProduccion.find("#Maq").focus().select();
                }
            }
        });
        mdlConciliaFabricaProduccion.find("#Maq").keypress(function (e) {
            if (e.keyCode === 13) {
                onComprobarMaquilasConcilia($(this));
            }
        });
        mdlConciliaFabricaProduccion.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13) {
                var ano = mdlConciliaFabricaProduccion.find("#Ano");
                onComprobarSemanasProduccionConcilia($(this), ano.val());
            }
        });
        mdlConciliaFabricaProduccion.find('#Precio').change(function () {
            var txtart = $(this).val();
            if (txtart) {
                mdlConciliaFabricaProduccion.find('#ArticuloConcilia').focus();
            }
        });
        mdlConciliaFabricaProduccion.find('#ArticuloConcilia').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(base_url + 'index.php/ReportesKardex/onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.addItem(txtart, true);
                            mdlConciliaFabricaProduccion.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.clear(true);
                                mdlConciliaFabricaProduccion.find('#ArticuloConcilia').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.clear(true);
                    mdlConciliaFabricaProduccion.find('#btnImprimir').focus();
                }
            }
        });
        mdlConciliaFabricaProduccion.find('#sArticuloConcilia').change(function () {
            var txtart = $(this).val();
            if (txtart) {
                mdlConciliaFabricaProduccion.find('#ArticuloConcilia').val(txtart);
                mdlConciliaFabricaProduccion.find('#btnImprimir').focus();
            }
        });
    });
    function onComprobarMaquilasConcilia(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                mdlConciliaFabricaProduccion.find("#Sem").focus().select();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onComprobarSemanasProduccionConcilia(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlConciliaFabricaProduccion.find('#Precio')[0].selectize.focus();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getArticulosReporteConcilia() {
        mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.clear(true);
        mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/EntradasAlmacenMP/getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlConciliaFabricaProduccion.find("#sArticuloConcilia")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>