<div id="pnlTablero" class="card m-2">
    <div class="card-body">
        <h4 class="card-title"><span class="fa fa-calendar"></span> CONSUMO EXTRA POR FECHAS</h4>
        <h6 class="card-subtitle mb-2 text-muted">FILTRO POR FECHAS</h6>
        <div class="row">
            <div class="col-5">
                <label>DE LA FECHA</label>
                <input type="text" id="FechaInicialConsumoExtra" name="FechaInicialConsumoExtra" class="form-control date">
            </div>
            <div class="col-5">
                <label>DE LA FECHA</label>
                <input type="text" id="FechaFinalConsumoExtra" name="FechaFinalConsumoExtra" class="form-control date">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-info btn-lg mt-4" id="btnImprimirConsumoExtra">
                    <span class="fa fa-print"></span> IMPRIMIR
                </button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-success btn-lg mt-4" id="btnImprimirConsumoExtraXLS" style="color: #fff;
                        background-color: #2e9432;
                        border-color: #2e9432;">
                    <span class="fa fa-print"></span> EXCEL
                </button>
            </div>
        </div>
    </div> 
</div>
<script>
    var pnlTablero = $("#pnlTablero"), FechaInicialConsumoExtra = pnlTablero.find("#FechaInicialConsumoExtra"),
            FechaFinalConsumoExtra = pnlTablero.find("#FechaFinalConsumoExtra"),
            btnImprimirConsumoExtra = pnlTablero.find("#btnImprimirConsumoExtra"),
            btnImprimirConsumoExtraXLS = pnlTablero.find("#btnImprimirConsumoExtraXLS");

    $(document).ready(function (e) {
        FechaInicialConsumoExtra.focus();
        FechaFinalConsumoExtra.keydown(function (e) {
            if (FechaFinalConsumoExtra.val() && e.keyCode === 13) {
                btnImprimirConsumoExtra.focus();
            }
        });
        FechaInicialConsumoExtra.keydown(function (e) {
            if (FechaInicialConsumoExtra.val() && e.keyCode === 13) {
                FechaFinalConsumoExtra.focus();
            }
        });
        btnImprimirConsumoExtraXLS.click(function () {
            if (FechaInicialConsumoExtra.val() && FechaFinalConsumoExtra.val()) {
                onDisableOnTime(btnImprimirConsumoExtraXLS,6000);
                onOpenOverlay('Espere...');
                $.post('<?php print base_url('ConsumoExtraPorFecha/onImprimirConsumoPielYForroExtraXLS'); ?>', {
                    FECHA_INICIAL: FechaInicialConsumoExtra.val(),
                    FECHA_FINAL: FechaFinalConsumoExtra.val()
                }).done(function (a) {
                    console.log(a)
                    if (a.length > 0) {
                        onOpenWindowBlank(a);
                        
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR EL RANGO DE FECHAS", function () {
                    if (!FechaInicialConsumoExtra.val()) {
                        FechaInicialConsumoExtra.focus();
                        return;
                    }
                    if (!FechaFinalConsumoExtra.val()) {
                        FechaFinalConsumoExtra.focus();
                        return;
                    }
                });
            }
        });
        btnImprimirConsumoExtra.click(function () {
            if (FechaInicialConsumoExtra.val() && FechaFinalConsumoExtra.val()) {
                onDisableOnTime(btnImprimirConsumoExtra, 3500);
                onOpenOverlay('Espere...');
                $.post('<?php print base_url('ConsumoExtraPorFecha/onImprimirConsumoPielYForroExtra'); ?>', {
                    FECHA_INICIAL: FechaInicialConsumoExtra.val(),
                    FECHA_FINAL: FechaFinalConsumoExtra.val()
                }).done(function (a) {
                    if (a.length > 0) {
                        onImprimirReporteFancyAFC(a, function (a, b) {
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                onCampoInvalido(pnlTablero, "DEBE DE ESPECIFICAR EL RANGO DE FECHAS", function () {
                    if (!FechaInicialConsumoExtra.val()) {
                        FechaInicialConsumoExtra.focus();
                        return;
                    }
                    if (!FechaFinalConsumoExtra.val()) {
                        FechaFinalConsumoExtra.focus();
                        return;
                    }
                });
            }
        });
    });
</script>