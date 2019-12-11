<div class="modal " id="mdlConsolidadoPorMes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventas Consolidado por Mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">

                        <div class="col-6">
                            <label class="mb-1">Del Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="dAnoConsolidadoMes" name="dAnoConsolidadoMes" >
                        </div>
                        <div class="col-6">
                            <label class="mb-1">Al Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="aAnoConsolidadoMes" name="aAnoConsolidadoMes" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="mb-1">Tp: <span class="badge badge-info" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpConsolidadoMes" name="TpConsolidadoMes">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <label class="mb-1">Tipo <span class="badge badge-success" style="font-size: 14px;">1 Por Agente, 2 Global</span></label>
                            <select id="TipoConsolidadoMes" name="TipoConsolidadoMes" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 Por Agente</option>
                                <option value="2">2 Global</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-12">
                            <label class="mb-1">Filtro <span class="badge badge-danger" style="font-size: 14px;">1 Pares, 2 Pesos</span></label>
                            <select id="FiltroConsolidadoMes" name="FiltroConsolidadoMes" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 Pares</option>
                                <option value="2">2 Pesos</option>
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
    var mdlConsolidadoPorMes = $('#mdlConsolidadoPorMes');
    $(document).ready(function () {
        mdlConsolidadoPorMes.on('shown.bs.modal', function () {
            mdlConsolidadoPorMes.find("input").val("");
            $.each(mdlConsolidadoPorMes.find("select"), function (k, v) {
                mdlConsolidadoPorMes.find("select")[k].selectize.clear(true);
            });
            var d = new Date();
            mdlConsolidadoPorMes.find('#dAnoConsolidadoMes').val(d.getFullYear() - 1);
            mdlConsolidadoPorMes.find('#aAnoConsolidadoMes').val(d.getFullYear());
            mdlConsolidadoPorMes.find('#dAnoConsolidadoMes').focus().select();

        });

        mdlConsolidadoPorMes.find("#dAnoConsolidadoMes").keypress(function (e) {
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
                        mdlConsolidadoPorMes.find("#dAnoConsolidadoMes").val("");
                        mdlConsolidadoPorMes.find("#dAnoConsolidadoMes").focus();
                    });
                } else {
                    mdlConsolidadoPorMes.find('#aAnoConsolidadoMes').focus();
                }
            }
        });

        mdlConsolidadoPorMes.find("#aAnoConsolidadoMes").keypress(function (e) {
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
                        mdlConsolidadoPorMes.find("#aAnoConsolidadoMes").val("");
                        mdlConsolidadoPorMes.find("#aAnoConsolidadoMes").focus();
                    });
                } else {
                    mdlConsolidadoPorMes.find('#TpConsolidadoMes').focus();
                }
            }
        });
        mdlConsolidadoPorMes.find("#TpConsolidadoMes").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpConsPorMes($(this));
                } else {
                    mdlConsolidadoPorMes.find('#TipoConsolidadoMes')[0].selectize.focus();
                }
            }
        });
        mdlConsolidadoPorMes.find("#TipoConsolidadoMes").change(function () {
            if ($(this).val()) {
                mdlConsolidadoPorMes.find("#FiltroConsolidadoMes")[0].selectize.focus();
            }
        });
        mdlConsolidadoPorMes.find("#FiltroConsolidadoMes").change(function () {
            if ($(this).val()) {
                mdlConsolidadoPorMes.find("#btnImprimir").focus();
            }
        });

        mdlConsolidadoPorMes.find('#btnImprimir').on("click", function () {
            onDisable(mdlConsolidadoPorMes.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlConsolidadoPorMes.find("#frmCaptura")[0]);
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteConsolidadoMes'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlConsolidadoPorMes.find('#dAnoConsolidadoMes').focus().select();
                        onEnable(mdlConsolidadoPorMes.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlConsolidadoPorMes.find('#Cliente')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTpConsPorMes(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlConsolidadoPorMes.find('#TipoConsolidadoMes')[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

</script>
