<div class="modal " id="mdlPagosDiariosClientes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagos Diarios de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label class="badge badge-info" style="font-size: 14px;">Nota: Fecha de Captura</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="TpPagoDiario" name='TpPagoDiario' maxlength="1" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnImprimirExcel">EXPORTAR A EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlPagosDiariosClientes = $('#mdlPagosDiariosClientes');
    $(document).ready(function () {

        mdlPagosDiariosClientes.on('shown.bs.modal', function () {
            //handleEnterDiv(mdlPagosDiariosClientes);
            mdlPagosDiariosClientes.find("input").val("");
            $.each(mdlPagosDiariosClientes.find("select"), function (k, v) {
                mdlPagosDiariosClientes.find("select")[k].selectize.clear(true);
            });
            mdlPagosDiariosClientes.find('#FechaIni').val(getFirstDayMonth());
            mdlPagosDiariosClientes.find('#FechaFin').val(getToday());
            mdlPagosDiariosClientes.find('#FechaIni').focus();
        });

        mdlPagosDiariosClientes.find("#FechaIni").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlPagosDiariosClientes.find("#FechaFin").focus().select();
                }
            }
        });

        mdlPagosDiariosClientes.find("#FechaFin").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlPagosDiariosClientes.find("#TpPagoDiario").focus().select();
                }
            }
        });


        mdlPagosDiariosClientes.find("#TpPagoDiario").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpPagosDiarios($(this));
                } else {
                    mdlPagosDiariosClientes.find('#btnImprimir').focus();
                }
            }
        });
        mdlPagosDiariosClientes.find('#btnImprimirExcel').on("click", function () {
            onDisable(mdlPagosDiariosClientes.find('#btnImprimirExcel'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPagosDiariosClientes.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReportePagosClientesExcel',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onEnable(mdlPagosDiariosClientes.find('#btnImprimirExcel'));
                if (data.length > 0) {
                    window.open(data, '_blank');
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlPagosDiariosClientes.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlPagosDiariosClientes.find('#btnImprimirExcel'));
            });
        });
        mdlPagosDiariosClientes.find('#btnImprimir').on("click", function () {
            onDisable(mdlPagosDiariosClientes.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPagosDiariosClientes.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReportePagosClientes',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlPagosDiariosClientes.find('#FechaIni').focus();
                        onEnable(mdlPagosDiariosClientes.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlPagosDiariosClientes.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlPagosDiariosClientes.find('#btnImprimir'));
            });
        });
    });

    function onVerificarTpPagosDiarios(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlPagosDiariosClientes.find('#btnImprimir').focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
</script>