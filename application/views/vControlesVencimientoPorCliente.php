<div class="modal " id="mdlControlesVencimientoPorCliente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Días de Vencimiento por Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="ClienteCVC" name="ClienteCVC" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sClienteCVC" name="sClienteCVC" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
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
    var mdlControlesVencimientoPorCliente = $('#mdlControlesVencimientoPorCliente');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlControlesVencimientoPorCliente);
        mdlControlesVencimientoPorCliente.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlControlesVencimientoPorCliente.on('shown.bs.modal', function () {
            mdlControlesVencimientoPorCliente.find("input").val("");
            $.each(mdlControlesVencimientoPorCliente.find("select"), function (k, v) {
                mdlControlesVencimientoPorCliente.find("select")[k].selectize.clear(true);
            });
            getClientesControlesVencimiento();
            mdlControlesVencimientoPorCliente.find('#ClienteCVC').focus();
        });

        mdlControlesVencimientoPorCliente.find('#ClienteCVC').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlControlesVencimientoPorCliente.find("#sClienteCVC")[0].selectize.addItem(txtcte, true);
                            mdlControlesVencimientoPorCliente.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlControlesVencimientoPorCliente.find("#sClienteCVC")[0].selectize.clear(true);
                                mdlControlesVencimientoPorCliente.find('#ClienteCVC').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlControlesVencimientoPorCliente.find("#sClienteCVC").change(function () {
            if ($(this).val()) {
                mdlControlesVencimientoPorCliente.find('#ClienteCVC').val($(this).val());
                mdlControlesVencimientoPorCliente.find('#btnImprimir').focus();
            }
        });
        mdlControlesVencimientoPorCliente.find('#btnImprimir').on("click", function () {
            onDisable(mdlControlesVencimientoPorCliente.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlControlesVencimientoPorCliente.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteVencimientoCte',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlControlesVencimientoPorCliente.find('#ClienteCVC').focus();
                        onEnable(mdlControlesVencimientoPorCliente.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlControlesVencimientoPorCliente.find('#ClienteCVC').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlControlesVencimientoPorCliente.find('#btnImprimir'));
            });
        });
    });


    function getClientesControlesVencimiento() {
        mdlControlesVencimientoPorCliente.find("#sClienteCVC")[0].selectize.clear(true);
        mdlControlesVencimientoPorCliente.find("#sClienteCVC")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlControlesVencimientoPorCliente.find("#sClienteCVC")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
