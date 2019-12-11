<div class="modal " id="mdlRelacionNotasCredito"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprime Relación de Notas de Crédito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniRelNC" name="FechaIniRelNC" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinRelNC" name="FechaFinRelNC" >
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-6 col-sm-6 col-md-5">
                            <label class="mb-1">Tp: </label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpRelNC" name="TpRelNC" required="">
                        </div>
                        <div class="col-12 col-sm-12 col-md-7">
                            <label class="mb-1">Tipo <span class="badge badge-info" style="font-size: 14px;">1 General, 2 Por Concepto</span></label>
                            <select id="TipoRelNC" name="TipoRelNC" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 General</option>
                                <option value="2">2 Por Concepto-Cancelación</option>
                            </select>
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
    var mdlRelacionNotasCredito = $('#mdlRelacionNotasCredito');
    $(document).ready(function () {

        mdlRelacionNotasCredito.on('shown.bs.modal', function () {
            handleEnterDiv(mdlRelacionNotasCredito);
            mdlRelacionNotasCredito.find("input").val("");
            $.each(mdlRelacionNotasCredito.find("select"), function (k, v) {
                mdlRelacionNotasCredito.find("select")[k].selectize.clear(true);
            });
            mdlRelacionNotasCredito.find('#FechaIniRelNC').val(getFirstDayMonth());
            mdlRelacionNotasCredito.find('#FechaFinRelNC').val(getToday());
            mdlRelacionNotasCredito.find('#FechaIniRelNC').focus();
        });

        mdlRelacionNotasCredito.find("#TpRelNC").change(function () {

            if ($(this).val()) {
                onVerificarTp($(this));
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBE CAPTURAR UN TP",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    $(v).val('').focus();
                });
            }

        });

        mdlRelacionNotasCredito.find('#btnImprimir').on("click", function () {
            onDisable(mdlRelacionNotasCredito.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlRelacionNotasCredito.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteRelacionNC',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlRelacionNotasCredito.find('#FechaIniRelNC').focus();
                        onEnable(mdlRelacionNotasCredito.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlRelacionNotasCredito.find('#FechaIniRelNC').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTp(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlRelacionNotasCredito.find("#btnImprimir").focus();
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
</script>