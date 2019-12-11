<div class="modal " id="mdlControlesVencimientoPorMaquila"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Días de Vencimiento por Maquila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="MaqCV" name="MaqCV" >
                        </div>
                        <div class="col-4">
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaqCV" name="aMaqCV" >
                        </div>
                        <div class="col-4">
                            <label>Días</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="DiasCV" name="DiasCV" >
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
    var mdlControlesVencimientoPorMaquila = $('#mdlControlesVencimientoPorMaquila');
    $(document).ready(function () {
        mdlControlesVencimientoPorMaquila.on('shown.bs.modal', function () {
            handleEnterDiv(mdlControlesVencimientoPorMaquila);
            mdlControlesVencimientoPorMaquila.find("input").val("");
            $.each(mdlControlesVencimientoPorMaquila.find("select"), function (k, v) {
                mdlControlesVencimientoPorMaquila.find("select")[k].selectize.clear(true);
            });
            mdlControlesVencimientoPorMaquila.find('#Ano').focus();
        });

        mdlControlesVencimientoPorMaquila.find('#btnImprimir').on("click", function () {
            onDisable(mdlControlesVencimientoPorMaquila.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlControlesVencimientoPorMaquila.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteVencimientoMaqCte',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlControlesVencimientoPorMaquila.find('#Ano').focus().select();
                        onEnable(mdlControlesVencimientoPorMaquila.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlControlesVencimientoPorMaquila.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlControlesVencimientoPorMaquila.find('#btnImprimir'));
            });
        });

        mdlControlesVencimientoPorMaquila.find("#Ano").change(function () {
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
                    mdlControlesVencimientoPorMaquila.find("#Ano").val("");
                    mdlControlesVencimientoPorMaquila.find("#Ano").focus();
                });
            }
        });
        mdlControlesVencimientoPorMaquila.find("#MaqCV").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlControlesVencimientoPorMaquila.find("#aMaqCV").change(function () {
            onComprobarMaquilas($(this));
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
</script>


