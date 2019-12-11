<div class="modal " id="mdlCobranzaDiaria"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cobranza Por Agente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Del agente: </label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="dAgente" name="dAgente" >
                        </div>
                        <div class="col-12">
                            <label>Al agente: </label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="aAgente" name="aAgente" >
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
    var mdlCobranzaDiaria = $('#mdlCobranzaDiaria');
    $(document).ready(function () {

        mdlCobranzaDiaria.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCobranzaDiaria);
            mdlCobranzaDiaria.find("input").val("");
            $.each(mdlCobranzaDiaria.find("select"), function (k, v) {
                mdlCobranzaDiaria.find("select")[k].selectize.clear(true);
            });
            mdlCobranzaDiaria.find('#dAgente').focus();
        });

        mdlCobranzaDiaria.find('#btnImprimir').on("click", function () {
            onDisable(mdlCobranzaDiaria.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlCobranzaDiaria.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteCobranzaDiaria',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlCobranzaDiaria.find('#dAgente').focus();
                        onEnable(mdlCobranzaDiaria.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlCobranzaDiaria.find('#dAgente').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlCobranzaDiaria.find('#btnImprimir'));
            });

        });
    });
</script>

