<div class="modal " id="mdlParesAsignadosMaqSemGen"  role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pares Asignados X Semana/Maquila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
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
    var mdlParesAsignadosMaqSemGen = $('#mdlParesAsignadosMaqSemGen');
    $(document).ready(function () {
        mdlParesAsignadosMaqSemGen.on('shown.bs.modal', function () {
            handleEnterDiv(mdlParesAsignadosMaqSemGen);
            mdlParesAsignadosMaqSemGen.find("input").val("");
            mdlParesAsignadosMaqSemGen.find('#Ano').val(getYear()).focus().select();
        });
        mdlParesAsignadosMaqSemGen.find('#btnImprimir').on("click", function () {
            mdlParesAsignadosMaqSemGen.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlParesAsignadosMaqSemGen.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/ReporteParesAsignadosMaqSemGen',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {

                onImprimirReporteFancyArrayAFC(JSON.parse(data), function (a, b) {
                    mdlParesAsignadosMaqSemGen.find('#btnImprimir').attr('disabled', false);
                });
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });
        });
        mdlParesAsignadosMaqSemGen.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlParesAsignadosMaqSemGen.find("#Ano").val("");
                    mdlParesAsignadosMaqSemGen.find("#Ano").focus();
                });
            }
        });
    });



</script>


