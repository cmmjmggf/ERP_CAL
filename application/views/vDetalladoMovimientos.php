<div class="modal " id="mdlDetalleMovimientos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detallado de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">

                        <div class="col-3">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteDetalleMovimientos" name="dClienteDetalleMovimientos" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sdClienteDetalleMovimientos" name="sdClienteDetalleMovimientos" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniDetalleMovimientos" name="FechaIniDetalleMovimientos" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinDetalleMovimientos" name="FechaFinDetalleMovimientos" >
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
    var mdlDetalleMovimientos = $('#mdlDetalleMovimientos');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlDetalleMovimientos);
        mdlDetalleMovimientos.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlDetalleMovimientos.on('shown.bs.modal', function () {
            handleEnterDiv(mdlDetalleMovimientos);
            mdlDetalleMovimientos.find("input").val("");
            $.each(mdlDetalleMovimientos.find("select"), function (k, v) {
                mdlDetalleMovimientos.find("select")[k].selectize.clear(true);
            });
            getClientesDetalleMovimientos();
            mdlDetalleMovimientos.find('#dClienteDetalleMovimientos').focus();
            mdlDetalleMovimientos.find('#FechaIniDetalleMovimientos').val(getFirstDayMonth());
            mdlDetalleMovimientos.find('#FechaFinDetalleMovimientos').val(getToday());
        });
        mdlDetalleMovimientos.find('#dClienteDetalleMovimientos').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlDetalleMovimientos.find("#sdClienteDetalleMovimientos")[0].selectize.addItem(txtcte, true);
                            mdlDetalleMovimientos.find('#FechaIniDetalleMovimientos').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlDetalleMovimientos.find("#sdClienteDetalleMovimientos")[0].selectize.clear(true);
                                mdlDetalleMovimientos.find('#dClienteDetalleMovimientos').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlDetalleMovimientos.find("#sdClienteEdoCta").change(function () {
            if ($(this).val()) {
                mdlDetalleMovimientos.find("#dClienteDetalleMovimientos").val($(this).val());
                mdlDetalleMovimientos.find('#FechaIniDetalleMovimientos').focus().select();
            }
        });
        mdlDetalleMovimientos.find('#btnImprimir').on("click", function () {
            onDisable(mdlDetalleMovimientos.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlDetalleMovimientos.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteDetalladoMovimientosClientes',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        mdlDetalleMovimientos.find('#dClienteDetalleMovimientos').focus();
                        onEnable(mdlDetalleMovimientos.find('#btnImprimir'));
                    });
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlDetalleMovimientos.find('#dClienteDetalleMovimientos').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });



    function getClientesDetalleMovimientos() {
        mdlDetalleMovimientos.find("#sdClienteDetalleMovimientos")[0].selectize.clear(true);
        mdlDetalleMovimientos.find("#sdClienteDetalleMovimientos")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlDetalleMovimientos.find("#sdClienteDetalleMovimientos")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
