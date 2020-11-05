<div class="modal " id="mdlVentasClientesRankingFechas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-file-invoice-dollar"></span> Reporte de ventas a clientes (Ranking)</h5>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniVentasRanking" name="FechaIniVentasRanking" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinVentasRanking" name="FechaFinVentasRanking" >
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
    var mdlVentasClientesRankingFechas = $('#mdlVentasClientesRankingFechas');
    $(document).ready(function () {
        mdlVentasClientesRankingFechas.on('shown.bs.modal', function () {
            handleEnterDiv(mdlVentasClientesRankingFechas);
            mdlVentasClientesRankingFechas.find("input").val("");
            mdlVentasClientesRankingFechas.find('#FechaIniVentasRanking').val(getFirstDayYear());
            mdlVentasClientesRankingFechas.find('#FechaFinVentasRanking').val(getToday());
            mdlVentasClientesRankingFechas.find('#FechaIniVentasRanking').focus();
        });
        mdlVentasClientesRankingFechas.find('#btnImprimir').on("click", function () {
            onDisable(mdlVentasClientesRankingFechas.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasClientesRankingFechas.find("#frmCaptura")[0]);
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onImprimirVentasClientesRanking'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onEnable(mdlVentasClientesRankingFechas.find('#btnImprimir'));
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
                onEnable(mdlVentasClientesRankingFechas.find('#btnImprimir'));
            });
        });
    });
</script>
