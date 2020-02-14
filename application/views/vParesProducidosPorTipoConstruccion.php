<div class="modal " id="mdlParesProducidosPorTipoConstruccion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Pares Producidos X Depto X Tipo Construcción</h5>
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
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaq" name="aMaq" >
                        </div>
                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-6">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnImprimir"><span class="fa fa-print"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlParesProducidosPorTipoConstruccion = $('#mdlParesProducidosPorTipoConstruccion'),
            anio_actual = <?php print Date('Y'); ?>;
    $(document).ready(function () {
        mdlParesProducidosPorTipoConstruccion.on('shown.bs.modal', function () {
            handleEnterDiv(mdlParesProducidosPorTipoConstruccion);
            mdlParesProducidosPorTipoConstruccion.find("input").val("");
            $.each(mdlParesProducidosPorTipoConstruccion.find("select"), function (k, v) {
                mdlParesProducidosPorTipoConstruccion.find("select")[k].selectize.clear(true);
            });
            mdlParesProducidosPorTipoConstruccion.find('#Ano').val(anio_actual);
            mdlParesProducidosPorTipoConstruccion.find('#Ano').focus().select();

        });
        mdlParesProducidosPorTipoConstruccion.find('#btnImprimir').on("click", function () {
            mdlParesProducidosPorTipoConstruccion.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlParesProducidosPorTipoConstruccion.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/onReporteParesProducidosPorTipoConstruccion',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function (a, b) {
                        mdlParesProducidosPorTipoConstruccion.find('#btnImprimir').attr('disabled', false);
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlParesProducidosPorTipoConstruccion.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlParesProducidosPorTipoConstruccion.find('#btnImprimir'));
            });
        });
        mdlParesProducidosPorTipoConstruccion.find("#Ano").change(function () {
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
                    mdlParesProducidosPorTipoConstruccion.find("#Ano").val("");
                    mdlParesProducidosPorTipoConstruccion.find("#Ano").focus();
                });
            }
        });
        mdlParesProducidosPorTipoConstruccion.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlParesProducidosPorTipoConstruccion.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlParesProducidosPorTipoConstruccion.find("#Sem").change(function () {
            var ano = mdlParesProducidosPorTipoConstruccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlParesProducidosPorTipoConstruccion.find("#aSem").change(function () {
            var ano = mdlParesProducidosPorTipoConstruccion.find("#Ano");
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


