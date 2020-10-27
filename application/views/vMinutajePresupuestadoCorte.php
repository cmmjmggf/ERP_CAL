<div class="modal " id="mdlMinutajePresupuestadoCorte"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Minutaje Prespuestado CORTE</h5>
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
    var mdlMinutajePresupuestadoCorte = $('#mdlMinutajePresupuestadoCorte');
    $(document).ready(function () {
        mdlMinutajePresupuestadoCorte.on('shown.bs.modal', function () {
            handleEnterDiv(mdlMinutajePresupuestadoCorte);
            mdlMinutajePresupuestadoCorte.find("input").val("");
            mdlMinutajePresupuestadoCorte.find('#Ano').val(getYear()).focus().select();
        });
        mdlMinutajePresupuestadoCorte.find('#btnImprimir').on("click", function () {
            mdlMinutajePresupuestadoCorte.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlMinutajePresupuestadoCorte.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/ReporteMinutosPresupiestadosCORTE',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {

                onImprimirReporteFancyAFC(data, function (a, b) {
                    mdlMinutajePresupuestadoCorte.find('#btnImprimir').attr('disabled', false);
                });
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });
        });
        mdlMinutajePresupuestadoCorte.find("#Ano").change(function () {
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
                    mdlMinutajePresupuestadoCorte.find("#Ano").val("");
                    mdlMinutajePresupuestadoCorte.find("#Ano").focus();
                });
            }
        });
    });



</script>


