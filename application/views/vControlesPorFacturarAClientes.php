<div class="modal " id="mdlControlesPorFacturarAClientes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Controles por facturar a Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rProduccion" name="Reporte" class="custom-control-input">
                                    <label class="custom-control-label text-success" for="rProduccion">De producción</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rDevolucion" name="Reporte" class="custom-control-input">
                                    <label class="custom-control-label text-danger" for="rDevolucion">De devolución</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rMuestras" name="Reporte" class="custom-control-input">
                                    <label class="custom-control-label text-info" for="rMuestras">De muestras y prototipos</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
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

        mdlControlesPorFacturarAClientes.find('#rProduccion').change(function () {
            onReporteControlesPorFacturar(1);
        });
        mdlControlesPorFacturarAClientes.find('#rDevolucion').change(function () {
            onReporteControlesPorFacturar(2);
        });
        mdlControlesPorFacturarAClientes.find('#rMuestras').change(function () {
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
