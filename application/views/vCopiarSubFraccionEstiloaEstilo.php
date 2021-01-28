<div class="modal " id="mdlCopiaSubFraccionesEstilo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copiar Sub-Fracciones de un estilo a otro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del Estilo</label>
                            <input id="dEstilo" name="dEstilo" class="form-control form-control-sm required" maxlength="8">
                        </div>
                        <div class="col-6">
                            <label>Al Estilo</label>
                            <input id="aEstilo" name="aEstilo" class="form-control form-control-sm required" maxlength="8">
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
    var mdlCopiaSubFraccionesEstilo = $('#mdlCopiaSubFraccionesEstilo');
    $(document).ready(function () {
        mdlCopiaSubFraccionesEstilo.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCopiaSubFraccionesEstilo);
            mdlCopiaSubFraccionesEstilo.find("input").val("");
            mdlCopiaSubFraccionesEstilo.find('#dEstilo').focus();
        });

        mdlCopiaSubFraccionesEstilo.find("#dEstilo").keydown(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {
                    $.getJSON(base_url + 'index.php/Pedidos/onVerificaEstilo', {Estilo: estilo}).done(function (data) {
                        if (data.length > 0) {

                        } else {
                            swal('ERROR', 'EL ESTILO NO EXISTE', 'warning').then((value) => {
                                mdlCopiaSubFraccionesEstilo.find('#dEstilo').focus().val('');
                            });
                        }
                    });
                }
            }
        });
        mdlCopiaSubFraccionesEstilo.find("#aEstilo").keydown(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {

                    $.getJSON(base_url + 'index.php/SubfraccionesXEstilo/' + 'onVerificaEstiloSubFracciones', {Estilo: estilo}).done(function (data, x, jq) {
                        $.each(data, function (k, v) {
                            if (data.length > 0) {
                                swal('ERROR', 'EL ESTILO YA TIENE SUS SUB-FRACCIONES CAPTURADAS', 'warning').then((value) => {
                                    mdlCopiaSubFraccionesEstilo.find('#aEstilo').focus().val('');
                                });
                            } else {
                                mdlCopiaSubFraccionesEstilo.find('#btnImprimir').focus();
                            }
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlCopiaSubFraccionesEstilo.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlCopiaSubFraccionesEstilo.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/SubfraccionesXEstilo/onCopiarSubFraccionesDeEstiloaEstilo',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                HoldOn.close();
                swal({
                    title: "ATENCIÓN",
                    text: "SE HAN COPIADO LAS SUB-FRACCIONES DEL ESTILO SELECCIONADO AL ESTILO DESTINO",
                    icon: "success"
                }).then((willDelete) => {
                    mdlCopiaSubFraccionesEstilo.find("input").val("");
                    mdlCopiaSubFraccionesEstilo.find('#dEstilo').focus();
                });


            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            });
        });

    });
</script>


