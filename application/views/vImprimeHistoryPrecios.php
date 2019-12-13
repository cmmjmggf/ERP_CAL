<div class="modal " id="mdlImprimeHistoryPrecios"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Obtener Historial de Cambio de Precios p' Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row" id = "dXArticulo">
                        <div class="col-3">
                            <label>Artículo</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm numbersOnly" id="ArticuloHistory" name="ArticuloHistory" >
                        </div>
                        <div class="col-9">
                            <label>-</label>
                            <select class="form-control form-control-sm required selectize" id="sArticuloHistory" name="sArticuloHistory" >
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="chPorRangoFechas" name="chPorRangoFechas">
                                <label class="custom-control-label text-info labelCheck" for="chPorRangoFechas">Imprimir X Rango de Fechas</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 d-none" id="dXRangoFechas">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniHistory" name="FechaIniHistory" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinRepHistory" name="FechaFinRepHistory" >
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
    var mdlImprimeHistoryPrecios = $('#mdlImprimeHistoryPrecios');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlImprimeHistoryPrecios);
        setFocusSelectToInputOnChange('#sArticuloHistory', '#btnImprimir', mdlImprimeHistoryPrecios);
        mdlImprimeHistoryPrecios.on('shown.bs.modal', function () {
            mdlImprimeHistoryPrecios.find("input").val("");
            $.each(mdlImprimeHistoryPrecios.find("select"), function (k, v) {
                mdlImprimeHistoryPrecios.find("select")[k].selectize.clear(true);
            });
            mdlImprimeHistoryPrecios.find('#FechaIniHistory').val(getFirstDayMonth());
            mdlImprimeHistoryPrecios.find('#FechaFinRepHistory').val(getToday());
            getArticulosHistory();
            mdlImprimeHistoryPrecios.find('#ArticuloHistory').focus();
        });
        mdlImprimeHistoryPrecios.find("#chPorRangoFechas").change(function () {
            if (mdlImprimeHistoryPrecios.find("#chPorRangoFechas")[0].checked) {
                mdlImprimeHistoryPrecios.find("#dXRangoFechas").removeClass('d-none');
                mdlImprimeHistoryPrecios.find("#dXArticulo").addClass('d-none');
                mdlImprimeHistoryPrecios.find('#FechaIniHistory').focus();
            } else {
                mdlImprimeHistoryPrecios.find("#dXArticulo").removeClass('d-none');
                mdlImprimeHistoryPrecios.find("#dXRangoFechas").addClass('d-none');
                mdlImprimeHistoryPrecios.find('#ArticuloHistory').focus();
            }
        });

        mdlImprimeHistoryPrecios.find('#ArticuloHistory').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(base_url + 'index.php/Articulos/onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            mdlImprimeHistoryPrecios.find("#sArticuloHistory")[0].selectize.addItem(txtart, true);
                            mdlImprimeHistoryPrecios.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EL ARTICULO CAPTURADO NO EXISTE', 'warning').then((value) => {
                                mdlImprimeHistoryPrecios.find("#sArticuloHistory")[0].selectize.clear(true);
                                mdlImprimeHistoryPrecios.find('#ArticuloHistory').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlImprimeHistoryPrecios.find("#sArticuloHistory").change(function () {
            if ($(this).val()) {
                mdlImprimeHistoryPrecios.find('#ArticuloHistory').val($(this).val());
                mdlImprimeHistoryPrecios.find('#btnImprimir').focus();
            }
        });
        mdlImprimeHistoryPrecios.find('#btnImprimir').on("click", function () {
            mdlImprimeHistoryPrecios.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlImprimeHistoryPrecios.find("#frmExplosion")[0]);
            var reporte = mdlImprimeHistoryPrecios.find("#chPorRangoFechas")[0].checked ? 'onReporteHistoryPreciosFechas' : 'onReporteHistoryPrecios';
            $.ajax({
                url: base_url + 'index.php/Articulos/' + reporte,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function (a, b) {
                        mdlImprimeHistoryPrecios.find('#btnImprimir').attr('disabled', false);
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL HISTORIAL",
                        icon: "error"
                    }).then((action) => {
                        mdlImprimeHistoryPrecios.find('#btnImprimir').attr('disabled', false);
                        mdlImprimeHistoryPrecios.find('#ArticuloHistory').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                mdlImprimeHistoryPrecios.find('#btnImprimir').attr('disabled', false);
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getArticulosHistory() {
        mdlImprimeHistoryPrecios.find("#sArticuloHistory")[0].selectize.clear(true);
        mdlImprimeHistoryPrecios.find("#sArticuloHistory")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/EntradasAlmacenMP/getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlImprimeHistoryPrecios.find("#sArticuloHistory")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
