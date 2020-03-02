<div class="modal " id="mdlEstadoCuentaAgente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta Por Agente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label>Del agente: </label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="dAgenteEdoCuentaAgt" name="dAgenteEdoCuentaAgt" >
                        </div>
                        <div class="col-12">
                            <label>Al agente: </label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2" id="aAgenteEdoCuentaAgt" name="aAgenteEdoCuentaAgt" >
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCtaAgt" name="TpEdoCtaAgt" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" disabled="" id="btnImprimir">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlEstadoCuentaAgente = $('#mdlEstadoCuentaAgente');
    $(document).ready(function () {

        mdlEstadoCuentaAgente.on('shown.bs.modal', function () {
            handleEnterDiv(mdlEstadoCuentaAgente);
            mdlEstadoCuentaAgente.find("input").val("");
            $.each(mdlEstadoCuentaAgente.find("select"), function (k, v) {
                mdlEstadoCuentaAgente.find("select")[k].selectize.clear(true);
            });
            mdlEstadoCuentaAgente.find('#dAgenteEdoCuentaAgt').focus();
        });

        mdlEstadoCuentaAgente.find("#TpEdoCtaAgt").keydown(function (e) {
            if (e.keyCode === 13)
                if ($(this).val()) {
                    onVerificarEdoCtaXAgente($(this));
                } else {
                    mdlEstadoCuentaAgente.find('#btnImprimir').attr('disabled', false);
                }
        });

        function onVerificarEdoCtaXAgente(v) {
            var tp = parseInt($(v).val());
            if (tp === 1 || tp === 2) {
                mdlEstadoCuentaAgente.find('#btnImprimir').attr('disabled', false);
            } else {
                mdlEstadoCuentaAgente.find('#btnImprimir').attr('disabled', true);
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

        mdlEstadoCuentaAgente.find('#btnImprimir').on("click", function () {
            onDisable(mdlEstadoCuentaAgente.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuentaAgente.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteEdoCuentaAgentes',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                mdlEstadoCuentaAgente.find('#btnImprimir').attr('disabled', true);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlEstadoCuentaAgente.find('#dAgenteEdoCuentaAgt').focus();
                        onEnable(mdlEstadoCuentaAgente.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuentaAgente.find('#dAgenteEdoCuentaAgt').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
    });
</script>

