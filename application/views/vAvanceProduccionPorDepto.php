<div class="modal " id="mdlAvanceProduccionPorDepto"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-file"></span>  Reporte Avance por Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row"> 
                        <div class="col-6">
                            <button type="button" id="btnPespunte" name="btnPespunte" class="btn btn-block btn-sm btn-info font-weight-bold" style="background-color: #373a3c;  border-color: #373a3c;"> 
                                <span class="fa fa-file"></span> 5-PESPUNTE
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="btnTejido" name="btnTejido" class="btn btn-block btn-sm btn-info font-weight-bold" style="background-color: #373a3c;  border-color: #373a3c;"> 
                                <span class="fa fa-file"></span> 7-TEJIDO
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceProduccionPorDepto = $('#mdlAvanceProduccionPorDepto');
    $(document).ready(function () {

        mdlAvanceProduccionPorDepto.find("#btnTejido").click(function () {
            onOpenOverlay('Espere un momento por favor...');
            $.post('<?php print base_url('ReportesProduccionJasper/onReporteAvancePorDeptoEspecifico'); ?>', {
                Depto: 7
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancy(data);
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlAvanceProduccionPorDepto.find("#btnPespunte").click(function () {
            onOpenOverlay('Espere un momento por favor...');
            $.post('<?php print base_url('ReportesProduccionJasper/onReporteAvancePorDeptoEspecifico'); ?>', {
                Depto: 5
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancy(data);
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });


    function getDeptos() {
        mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.clear(true);
        mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesProduccionJasper/getDepartamentos').done(function (data) {
            $.each(data, function (k, v) {
                mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.addOption({text: v.Depto, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>


