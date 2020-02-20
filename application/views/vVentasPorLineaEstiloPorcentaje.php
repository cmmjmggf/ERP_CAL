<div class="modal " id="mdlVentasPorLineaEstiloPorcentaje"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-file-invoice-dollar"></span> Ventas por Linea y Estilo (Con Porcentaje)</h5>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniVentasLinEstiPorce" name="FechaIniVentasLinEstiPorce" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinVentasLinEstiPorce" name="FechaFinVentasLinEstiPorce" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnImprimir"><span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlVentasPorLineaEstiloPorcentaje = $('#mdlVentasPorLineaEstiloPorcentaje');
    $(document).ready(function () {
        mdlVentasPorLineaEstiloPorcentaje.on('shown.bs.modal', function () {
            handleEnterDiv(mdlVentasPorLineaEstiloPorcentaje);
            mdlVentasPorLineaEstiloPorcentaje.find("input").val("");
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaIniVentasLinEstiPorce').val(getFirstDayMonth());
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaFinVentasLinEstiPorce').val(getToday());
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaIniVentasLinEstiPorce').focus();
        });
        mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir').on("click", function () {
            onDisable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasPorLineaEstiloPorcentaje.find("#frmCaptura")[0]);
            frm.append('Reporte', mdlVentasPorLineaEstiloPorcentaje.find('input[name=ReporteVentasPorFecha]:checked').attr('valor'));
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentaje'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancyAFC(data, function () {
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
                onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
            });
        });
    });
</script>
