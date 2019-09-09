<div id="mdlPrenominaPreliminaresPespunte" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prenomina por semana de las preliminares</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="">Año</label>
                        <input type="text" id="AnioPNSP" name="AnioPNSP" class="form-control form-control-sm numbersOnly" maxlength="4">
                    </div>
                    <div class="col-6">
                        <label for="">Semana</label>
                        <input type="text" id="SemanaPNSP" name="SemanaPNSP" class="form-control form-control-sm numbersOnly" maxlength="2">
                    </div>
                    <div class="col-12 mt-3">
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Nota!</strong> para este reporte es necesario generar la nomina a consultar.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptaPNSP">Acepta</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlPrenominaPreliminaresPespunte = $("#mdlPrenominaPreliminaresPespunte"),
            SemanaPNSP = mdlPrenominaPreliminaresPespunte.find("#SemanaPNSP"),
            AnioPNSP = mdlPrenominaPreliminaresPespunte.find("#AnioPNSP"),
            btnAceptaPNSP = mdlPrenominaPreliminaresPespunte.find("#btnAceptaPNSP");
    $(document).ready(function () {

        btnAceptaPNSP.click(function () {
            if (AnioPNSP.val() && SemanaPNSP.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere por favor...'
                });
                $.post('<?php print base_url('PrenominaPreliminaresPespunte/getReporte') ?>',
                        {ANIO: AnioPNSP.val(), SEM: SemanaPNSP.val()}).done(function (a) {
                    if (a.length > 0) {
                        onImprimirReporteFancy(a);
                    } else {
                        swal('ATENCION', 'NO HA SIDO POSIBLE OBTENER EL REPORTE SOLICITADO', 'warning');
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN AÑO Y UNA SEMANA', 'warning').then((value) => {
                    var t = AnioPNSP.val() ? AnioPNSP.focus().select() : SemanaPNSP.focus().select();
                });
            }
        });

        mdlPrenominaPreliminaresPespunte.on('shown.bs.modal', function () {
            SemanaPNSP.val('');
            AnioPNSP.val('<?php print Date('Y'); ?>');
        });
    });
    function onPrenominaPreliminaresXSemana() {
        mdlPrenominaPreliminaresPespunte.modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>