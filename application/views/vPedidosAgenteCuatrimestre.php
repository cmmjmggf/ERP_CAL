<div class="modal " id="mdlPedidosAgenteCuatrimestre"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pedidos de Agentes por Cuatrimestre/Anual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoCuatrimestre" name="AnoCuatrimestre" >
                        </div>
                        <div class="col-12">
                            <label class="mb-2 mt-2">Tipo <span class="badge badge-info" style="font-size: 14px;">1 Cuatrimestre, 2 Cuatrimestre, 3 Cuatrimestre, 4 Anual</span></label>
                            <select id="Cuatrimestre" name="Cuatrimestre" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 CUATRIMESTRE</option>
                                <option value="2">2 CUATRIMESTRE</option>
                                <option value="3">3 CUATRIMESTRE</option>
                                <option value="4">4 ANUAL</option>
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
    var mdlPedidosAgenteCuatrimestre = $('#mdlPedidosAgenteCuatrimestre'),
            btnImprimirPedidosAgenteCuatrimestre = mdlPedidosAgenteCuatrimestre.find('#btnImprimir');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlPedidosAgenteCuatrimestre);
        mdlPedidosAgenteCuatrimestre.on('shown.bs.modal', function () {
            mdlPedidosAgenteCuatrimestre.find("input").val("");
            $.each(mdlPedidosAgenteCuatrimestre.find("select"), function (k, v) {
                mdlPedidosAgenteCuatrimestre.find("select")[k].selectize.clear(true);
            });
            mdlPedidosAgenteCuatrimestre.find('#AnoCuatrimestre').focus();
        });

        mdlPedidosAgenteCuatrimestre.find("#AnoCuatrimestre").keypress(function (e) {
            if (e.keyCode === 13) {
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
                        mdlPedidosAgenteCuatrimestre.find("#AnoCuatrimestre").val("");
                        mdlPedidosAgenteCuatrimestre.find("#AnoCuatrimestre").focus();
                    });
                } else {
                    mdlPedidosAgenteCuatrimestre.find('#Cuatrimestre')[0].selectize.focus();
                }
            }
        });

        mdlPedidosAgenteCuatrimestre.find("#Cuatrimestre").change(function () {
            if ($(this).val()) {
                mdlPedidosAgenteCuatrimestre.find("#btnImprimir").focus();
            }
        });
        btnImprimirPedidosAgenteCuatrimestre.on("click", function () {
            onDisable(btnImprimirPedidosAgenteCuatrimestre);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlPedidosAgenteCuatrimestre.find("#frmCaptura")[0]);
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteAgentesCuatriAnual'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        mdlPedidosAgenteCuatrimestre.find('#AnoCuatrimestre').focus();
                        onEnable(btnImprimirPedidosAgenteCuatrimestre);
                    });
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlPedidosAgenteCuatrimestre.find('#Cuatrimestre')[0].selectize.focus();
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
