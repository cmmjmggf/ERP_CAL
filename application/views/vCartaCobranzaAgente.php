<div class="modal " id="mdlCartaCobranzaAgente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carta Cobranza por Agente</h5>
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
    var mdlCartaCobranzaAgente = $('#mdlCartaCobranzaAgente');
    $(document).ready(function () {
        mdlCartaCobranzaAgente.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCartaCobranzaAgente);
            mdlCartaCobranzaAgente.find("input").val("");
            $.each(mdlCartaCobranzaAgente.find("select"), function (k, v) {
                mdlCartaCobranzaAgente.find("select")[k].selectize.clear(true);
            });
            getAgenteslCartaCobranzaAgente();
            mdlCartaCobranzaAgente.find('#FechaIniRepFechas').val(getFirstDayMonth());
            mdlCartaCobranzaAgente.find('#FechaFinRepFechas').val(getToday());
            mdlCartaCobranzaAgente.find('#AgenteRepFechas')[0].selectize.focus();
        });


        mdlCartaCobranzaAgente.find('#btnImprimir').on("click", function () {
            onDisable(mdlCartaCobranzaAgente.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlCartaCobranzaAgente.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteCartaCobranzaXAgente',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyArrayAFC(JSON.parse(data), function () {
                        mdlCartaCobranzaAgente.find('#AgenteRepFechas')[0].selectize.focus();
                        onEnable(mdlCartaCobranzaAgente.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlCartaCobranzaAgente.find('#AgenteRepFechas')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlCartaCobranzaAgente.find('#btnImprimir'));
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
                onEnable(mdlCartaCobranzaAgente.find('#btnImprimir'));
            });
        });

    });



    function getAgenteslCartaCobranzaAgente() {
        $.getJSON(base_url + 'index.php/Agentes/' + 'getAgentesSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlCartaCobranzaAgente.find("#AgenteRepFechas")[0].selectize.addOption({text: v.Agente, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>


