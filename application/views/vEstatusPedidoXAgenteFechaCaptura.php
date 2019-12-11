<div class="modal " id="mdEstatusPedidoXAgenteFechaCaptura"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estatus del Pedido Por Agente y Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6" id="dAgente">
                            <label>Agente</label>
                            <select id="AgenteRepFechas" name="AgenteRepFechas" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniRepFechas" name="FechaIniRepFechas" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinRepFechas" name="FechaFinRepFechas" >
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
    var mdEstatusPedidoXAgenteFechaCaptura = $('#mdEstatusPedidoXAgenteFechaCaptura');
    $(document).ready(function () {
        mdEstatusPedidoXAgenteFechaCaptura.on('shown.bs.modal', function () {
            handleEnterDiv(mdEstatusPedidoXAgenteFechaCaptura);
            mdEstatusPedidoXAgenteFechaCaptura.find("input").val("");
            $.each(mdEstatusPedidoXAgenteFechaCaptura.find("select"), function (k, v) {
                mdEstatusPedidoXAgenteFechaCaptura.find("select")[k].selectize.clear(true);
            });
            getAgentesReporteFechas();
            mdEstatusPedidoXAgenteFechaCaptura.find('#FechaIniRepFechas').val(getFirstDayMonth());
            mdEstatusPedidoXAgenteFechaCaptura.find('#FechaFinRepFechas').val(getToday());
            mdEstatusPedidoXAgenteFechaCaptura.find('#AgenteRepFechas')[0].selectize.focus();
        });


        mdEstatusPedidoXAgenteFechaCaptura.find('#btnImprimir').on("click", function () {
            onDisable(mdEstatusPedidoXAgenteFechaCaptura.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdEstatusPedidoXAgenteFechaCaptura.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteEstatusPedidoXAgenteFechas',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdEstatusPedidoXAgenteFechaCaptura.find('#AgenteRepFechas')[0].selectize.focus();
                        onEnable(mdEstatusPedidoXAgenteFechaCaptura.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdEstatusPedidoXAgenteFechaCaptura.find('#FechaIniRepFechas')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdEstatusPedidoXAgenteFechaCaptura.find('#btnImprimir'));
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
                onEnable(mdEstatusPedidoXAgenteFechaCaptura.find('#btnImprimir'));
            });
        });

    });



    function getAgentesReporteFechas() {
        $.getJSON(base_url + 'index.php/Agentes/' + 'getAgentesSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdEstatusPedidoXAgenteFechaCaptura.find("#AgenteRepFechas")[0].selectize.addOption({text: v.Agente, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>


