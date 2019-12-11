<div class="modal " id="mdlReportePagoPromedioClientes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Días de Pago Promedio por Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
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
    var mdlReportePagoPromedioClientes = $('#mdlReportePagoPromedioClientes');
    $(document).ready(function () {

        mdlReportePagoPromedioClientes.on('shown.bs.modal', function () {
            handleEnterDiv(mdlReportePagoPromedioClientes);
            mdlReportePagoPromedioClientes.find("input").val("");
            $.each(mdlReportePagoPromedioClientes.find("select"), function (k, v) {
                mdlReportePagoPromedioClientes.find("select")[k].selectize.clear(true);
            });
            mdlReportePagoPromedioClientes.find('#FechaIni').val(getFirstDayMonth());
            mdlReportePagoPromedioClientes.find('#FechaFin').val(getToday());
            mdlReportePagoPromedioClientes.find('#FechaIni').focus();
        });
        mdlReportePagoPromedioClientes.find('#btnImprimir').on("click", function () {
            onDisable(mdlReportePagoPromedioClientes.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReportePagoPromedioClientes.find("#frmCaptura")[0]);
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteDiasPagoPromedio'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlReportePagoPromedioClientes.find('#FechaIni').focus();
                        onEnable(mdlReportePagoPromedioClientes.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlReportePagoPromedioClientes.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlReportePagoPromedioClientes.find('#btnImprimir'));
            });
        });
    });
</script>