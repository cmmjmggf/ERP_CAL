<div class="modal " id="mdlRecalcularCostoManoObra"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calcular Costo de Mano de Obra con Sub-Fracciones</h5>
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
                onDisable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción modificará los COSTOS DE MANO DE OBRA en los estilos creados a partir de esta fecha",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        onActualizarCostosSubfracciones();
                    } else {
                        onEnable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
                    }
                });
            } else {
                mdlRecalcularCostoManoObra.find('#Fecha').focus();
            }
        });

        function onActualizarCostosSubfracciones() {
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
                onEnable(mdlRecalcularCostoManoObra.find('#btnImprimir'));
                if (data.length > 0) {
                    swal({
                        title: 'INFO',
                        text: 'PROECESO TERMINADO CORRECTAMENTE',
                        icon: 'success'
                    }).then((action) => {
                        mdlRecalcularCostoManoObra.find('#Fecha').focus();
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN ESTILOS DADOS DE ALTA DESPUÉS DE ESTA FECHA",
                        icon: "error"
                    }).then((action) => {
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

