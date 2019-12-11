<div class="modal " id="mdlReportePagoSeguro"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pago seguro por mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Mes </label>
                            <select class="form-control form-control-sm required" id="Mes" name="Mes" >
                                <option value=""></option>
                                <option value="1">1 Enero</option>
                                <option value="2">2 Febrero</option>
                                <option value="3">3 Marzo</option>
                                <option value="4">4 Abril</option>
                                <option value="5">5 Mayo</option>
                                <option value="6">6 Junio</option>
                                <option value="7">7 Julio</option>
                                <option value="8">8 Agosto</option>
                                <option value="9">9 Septiembre</option>
                                <option value="10">10 Octubre</option>
                                <option value="11">11 Noviembre</option>
                                <option value="12">12 Diciembre</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Año </label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlReportePagoSeguro = $('#mdlReportePagoSeguro');
    var precio_Art = 0;
    $(document).ready(function () {
        mdlReportePagoSeguro.on('shown.bs.modal', function () {
            handleEnterDiv(mdlReportePagoSeguro);
            mdlReportePagoSeguro.find("input").val("");
            $.each(mdlReportePagoSeguro.find("select"), function (k, v) {
                mdlReportePagoSeguro.find("select")[k].selectize.clear(true);
            });
            mdlReportePagoSeguro.find("#Ano").val(new Date().getFullYear());
            mdlReportePagoSeguro.find('#Mes')[0].selectize.focus();
        });

        mdlReportePagoSeguro.find('#btnAceptar').on("click", function () {
            onDisable(mdlReportePagoSeguro.find('#btnAceptar'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReportePagoSeguro.find("#frmCaptura")[0]);
            frm.append('NombreMes', mdlReportePagoSeguro.find("#Mes option:selected").text());
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteSeguro',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlReportePagoSeguro.find('#Mes')[0].selectize.focus();
                        onEnable(mdlReportePagoSeguro.find('#btnAceptar'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlReportePagoSeguro.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlReportePagoSeguro.find('#btnAceptar'));
            });
        });

        mdlReportePagoSeguro.find("#Ano").change(function () {
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
                    mdlReportePagoSeguro.find("#Ano").val("");
                    mdlReportePagoSeguro.find("#Ano").focus();
                });
            }
        });
    });
</script>
