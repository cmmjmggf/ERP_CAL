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
        validacionSelectPorContenedor(mdlConciliaFabricaProduccion);
        setFocusSelectToInputOnChange('#Precio', '#btnImprimir', mdlConciliaFabricaProduccion);
        mdlConciliaFabricaProduccion.on('shown.bs.modal', function () {
            handleEnterDiv(mdlConciliaFabricaProduccion);
            mdlConciliaFabricaProduccion.find("input").val("");
            $.each(mdlConciliaFabricaProduccion.find("select"), function (k, v) {
                mdlConciliaFabricaProduccion.find("select")[k].selectize.clear(true);
            });
            mdlConciliaFabricaProduccion.find('#Ano').focus();
        });

        mdlConciliaFabricaProduccion.find('#btnImprimir').on("click", function () {
            mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', true);
            var t_precio = mdlConciliaFabricaProduccion.find('#Precio').val();
            if (t_precio !== '') {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlConciliaFabricaProduccion.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ConciliaFabricaProduccion/onReporteConciliaFabricaProduccion',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data.length > 0) {

                        onImprimirReporteFancyAFC(data, function (a, b) {
                            mdlConciliaFabricaProduccion.find('#btnImprimir').attr('disabled', false);
                        });
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                            icon: "error"
                        }).then((action) => {
                            mdlConciliaFabricaProduccion.find('#Ano').focus();
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
                    text: "DEBES DE SELECCIONAR UN TIPO DE PRECIO",
                    icon: "error"
                }).then((action) => {
                    mdlConciliaFabricaProduccion.find('#Precio')[0].selectize.focus();
                });
            }
        });

        mdlConciliaFabricaProduccion.find("#Ano").change(function () {
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
            }
        });
        mdlConciliaFabricaProduccion.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlConciliaFabricaProduccion.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlConciliaFabricaProduccion.find("#Sem").change(function () {
            var ano = mdlConciliaFabricaProduccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlConciliaFabricaProduccion.find("#aSem").change(function () {
            var ano = mdlConciliaFabricaProduccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
    });
    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
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
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

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


</script>