<div class="modal " id="mdlRecalcularCostoManoObra"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calcular Costo de Mano de Obra con Sub-Fraccioens</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-3">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label>A partir de: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="Fecha" name="Fecha" >
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
    var mdlRecalcularCostoManoObra = $('#mdlRecalcularCostoManoObra');
    var mdlReporte = $('#mdlReporte');
    var generado = false;
    $(document).ready(function () {

        mdlRecalcularCostoManoObra.on('shown.bs.modal', function () {
            handleEnterDiv(mdlRecalcularCostoManoObra);
            mdlRecalcularCostoManoObra.find("input").val("");
            mdlRecalcularCostoManoObra.find('#Fecha').focus();
        });


        mdlRecalcularCostoManoObra.find('#btnImprimir').on("click", function () {
            if (mdlRecalcularCostoManoObra.find("#Fecha").val()) {
                onActualizarCostosSubfracciones();
            }
        });

        function onActualizarCostosSubfracciones() {
            onDisable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlRecalcularCostoManoObra.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/GeneraCostosVenta/onActualizarCostosSubfracciones',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {

                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA EL PROCESO",
                        icon: "error"
                    }).then((action) => {
                        onEnable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
                        mdlRecalcularCostoManoObra.find('#Fecha').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
                console.log(x, y, z);
                HoldOn.close();
            });
        }
    });

</script>

