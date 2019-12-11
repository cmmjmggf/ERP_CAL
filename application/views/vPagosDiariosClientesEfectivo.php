<div class="modal " id="mdlPagosDiariosClientesEfectivo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagos Diarios de Clientes en Efectivo</h5>
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
    var mdlPagosDiariosClientesEfectivo = $('#mdlPagosDiariosClientesEfectivo');
    $(document).ready(function () {

        mdlPagosDiariosClientesEfectivo.on('shown.bs.modal', function () {
            handleEnterDiv(mdlPagosDiariosClientesEfectivo);
            mdlPagosDiariosClientesEfectivo.find("input").val("");
            $.each(mdlPagosDiariosClientesEfectivo.find("select"), function (k, v) {
                mdlPagosDiariosClientesEfectivo.find("select")[k].selectize.clear(true);
            });
            mdlPagosDiariosClientesEfectivo.find('#FechaIni').val(getFirstDayMonth());
            mdlPagosDiariosClientesEfectivo.find('#FechaFin').val(getToday());
            mdlPagosDiariosClientesEfectivo.find('#FechaIni').focus();
        });
        mdlPagosDiariosClientesEfectivo.find('#btnImprimir').on("click", function () {
            onDisable(mdlPagosDiariosClientesEfectivo.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPagosDiariosClientesEfectivo.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReportePagosClientesEfectivo',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlPagosDiariosClientesEfectivo.find('#FechaIni').focus();
                        onEnable(mdlPagosDiariosClientesEfectivo.find('#btnImprimir'));
                    }); 
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlPagosDiariosClientesEfectivo.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlPagosDiariosClientesEfectivo.find('#btnImprimir'));
            });
        });
    });
</script>