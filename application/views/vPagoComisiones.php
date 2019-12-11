<div class="modal " id="mdlPagoComisiones"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagos de Comisiones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-8">
                            <label>Agente</label>
                            <select id="AgentePagoComisiones" name="AgentePagoComisiones" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Tp:</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpPagoComisiones" name="TpPagoComisiones" >
                        </div>
                        <div class="col-12 mt-2">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="chMarcaComPagadas">
                                <label class="custom-control-label text-info labelCheck" for="chMarcaComPagadas">Marca Comisiones Pagadas</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">REPORTE COMISIONES</button>
                <button type="button" class="btn btn-success" id="btnReporte2">REPORTE PAGOS 30-60-365</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlPagoComisiones = $('#mdlPagoComisiones'),
            btnImprimirPagoComisiones = mdlPagoComisiones.find('#btnImprimir');

    $(document).ready(function () {

        mdlPagoComisiones.on('shown.bs.modal', function () {
            handleEnterDiv(mdlPagoComisiones);
            mdlPagoComisiones.find("input").val("");
            $.each(mdlPagoComisiones.find("select"), function (k, v) {
                mdlPagoComisiones.find("select")[k].selectize.clear(true);
            });
            getAgentesPagosComisiones();
            mdlPagoComisiones.find('#AgentePagoComisiones')[0].selectize.focus();
        });

        mdlPagoComisiones.find("#TpPagoComisiones").change(function () {
            if ($(this).val()) {
                onVerificarTp($(this));
            } else {
            }
        });

        function onVerificarTp(v) {
            var tp = parseInt($(v).val());
            if (tp === 1 || tp === 2) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "EL TP SÓLO PUEDE SER 1 y 2",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    $(v).val('').focus();
                });
            }
        }

        btnImprimirPagoComisiones.on("click", function () {
            onDisable(btnImprimirPagoComisiones);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPagoComisiones.find("#frmCaptura")[0]);
            var chMarcaComPagadas = mdlPagoComisiones.find("#chMarcaComPagadas")[0].checked ? '1' : '0';

            frm.append('chMarcaComPagadas', chMarcaComPagadas);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReportePagoComisiones',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlPagoComisiones.find('#AgentePagoComisiones')[0].selectize.focus();
                        onEnable(btnImprimirPagoComisiones);
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlPagoComisiones.find('#AgentePagoComisiones').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
        mdlPagoComisiones.find('#btnReporte2').on("click", function () {
            onDisable(mdlPagoComisiones.find('#btnReporte2'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPagoComisiones.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReportePagoComisiones306090365',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        onEnable(mdlPagoComisiones.find('#btnReporte2'));
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
    });


    function getAgentesPagosComisiones() {
        $.getJSON(base_url + 'index.php/Agentes/' + 'getAgentesSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlPagoComisiones.find("#AgentePagoComisiones")[0].selectize.addOption({text: v.Agente, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>


