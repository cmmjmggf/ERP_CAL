<div id="mdlParesAsignadosXSemanaAnio" class="modal">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pares Asignados x semana año</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Semana</label>
                        <input type="text" id="SemanaAsignadaSemAnio" name="SemanaAsignadaSemAnio" class="form-control form-control-sm" maxlength="2" >
                    </div>
                    <div class="col-4">
                        <label>Año</label>
                        <input type="text" id="AnoAsignadaSemAnio" name="AnoAsignadaSemAnio" class="form-control form-control-sm" maxlength="4">
                    </div> 
                    <div class="col-2">
                        <button type="button" id="btnExportaXLS" name="btnExportaXLS" class="btn btn-sm btn-success mt-3 font-weight-bold">
                            <span class="fa fa-file-excel"></span> Exporta
                        </button>
                    </div> 
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlParesAsignadosXSemanaAnio = $("#mdlParesAsignadosXSemanaAnio"),
            SemanaAsignadaSemAnio = mdlParesAsignadosXSemanaAnio.find("#SemanaAsignadaSemAnio"),
            AnoAsignadaSemAnio = mdlParesAsignadosXSemanaAnio.find("#AnoAsignadaSemAnio"),
            btnExportaXLS = mdlParesAsignadosXSemanaAnio.find("#btnExportaXLS");

    $(document).ready(function () {
        handleEnterDiv(mdlParesAsignadosXSemanaAnio);
        mdlParesAsignadosXSemanaAnio.on('shown.bs.modal', function () {
            SemanaAsignadaSemAnio.focus();
            AnoAsignadaSemAnio.val('<?php print Date('Y'); ?>');
        });
        btnExportaXLS.click(function () {
            console.log('qeqweqweqweqweqw')
            onOpenOverlay('Espere...');
            $.post('<?php print base_url('ParesAsignadosExportaXLS/getXLS'); ?>',
                    {
                        ANIO: AnoAsignadaSemAnio.val() ? AnoAsignadaSemAnio.val() : '',
                        SEMANA: SemanaAsignadaSemAnio.val() ? SemanaAsignadaSemAnio.val() : ''
                    }).done(function (a) {
                onCloseOverlay();
                onOpenWindowBlank(a);
            }).fail(function (x) {
                onCloseOverlay();
                getError(x);
            }).always(function () {
                onCloseOverlay();
            });
        });
    });
</script> 
<style>

    .card {
        background-color: #efefef;; 
    }
    .btn-success {
        color: #fff;
        background-color: #8BC34A;
        border-color: #8BC34A;
    }
</style>