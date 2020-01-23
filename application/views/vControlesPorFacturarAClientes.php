<div class="modal " id="mdlControlesPorFacturarAClientes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-print"></span>
                    Controles por facturar a Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="row" align="center"> 
                    <div class="col-4">
                        <button type="button" id="rProduccion" name="rProduccion" style="background-color: #8BC34A !important;
    border-color: #6b8c0a !important;" class="btn btn-sm btn-info font-weight-bold">
                            <span class="fa fa-print"></span> DE PRODUCCIÓN
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="rDevolucion" name="rDevolucion" class="btn btn-sm btn-info font-weight-bold">
                            <span class="fa fa-print"></span> DE DEVOLUCIÓN
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="rMuestras" name="rMuestras" class="btn btn-sm btn-info font-weight-bold" style="background-color: #673AB7 !important;
    border-color: #4527A0 !important;">
                            <span class="fa fa-print"></span> DE MUESTRAS Y PROTOTIPOS
                        </button>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" id="btnSalir" data-dismiss="modal">
                    <span class="fa fa-times"></span> SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlControlesPorFacturarAClientes = $('#mdlControlesPorFacturarAClientes');
    $(document).ready(function () {

        mdlControlesPorFacturarAClientes.on('shown.bs.modal', function () {
            mdlControlesPorFacturarAClientes.find('input:radio').prop("checked", false);
        });

        mdlControlesPorFacturarAClientes.find('#rProduccion').click(function () {
            onReporteControlesPorFacturar(1);
        });
        mdlControlesPorFacturarAClientes.find('#rDevolucion').click(function () {
            onReporteControlesPorFacturar(2);
        });
        mdlControlesPorFacturarAClientes.find('#rMuestras').click(function () {
            onReporteControlesPorFacturar(3);
        });
    });
    function onReporteControlesPorFacturar(reporte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData();
        frm.append('Reporte', reporte);
        $.ajax({
            url: base_url + 'index.php/ReportesClientesJasper/onReporteControlesPorFacturar',
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
                });
                HoldOn.close();
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }
</script>
