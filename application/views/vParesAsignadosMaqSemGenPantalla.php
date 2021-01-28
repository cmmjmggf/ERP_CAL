<div class="modal " id="mdlParesAsignadosMaqSemGenPantalla"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pares Asignados X Semana/Maquila Con Minutaje Actual</h5>
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
    var mdlParesAsignadosMaqSemGenPantalla = $('#mdlParesAsignadosMaqSemGenPantalla');
    $(document).ready(function () {
        mdlParesAsignadosMaqSemGenPantalla.on('shown.bs.modal', function () {
            handleEnterDiv(mdlParesAsignadosMaqSemGenPantalla);
            mdlParesAsignadosMaqSemGenPantalla.find("input").val("");
            mdlParesAsignadosMaqSemGenPantalla.find('#Ano').val(getYear()).focus().select();
        });
        mdlParesAsignadosMaqSemGenPantalla.find('#btnImprimir').on("click", function () {
            mdlParesAsignadosMaqSemGenPantalla.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlParesAsignadosMaqSemGenPantalla.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/ReporteParesAsignadosMaqSemGenMinutajeActual',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {

                onImprimirReporteFancyAFC(data, function (a, b) {
                    mdlParesAsignadosMaqSemGenPantalla.find('#btnImprimir').attr('disabled', false);
                });
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });
        });
        mdlParesAsignadosMaqSemGenPantalla.find("#Ano").change(function () {
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
                    mdlParesAsignadosMaqSemGenPantalla.find("#Ano").val("");
                    mdlParesAsignadosMaqSemGenPantalla.find("#Ano").focus();
                });
            }
        });

        mdlParesAsignadosMaqSemGenPantalla.find("#Sem").change(function () {
            var ano = mdlParesAsignadosMaqSemGenPantalla.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlParesAsignadosMaqSemGenPantalla.find("#aSem").change(function () {
            var ano = mdlParesAsignadosMaqSemGenPantalla.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
    });

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>


