<div class="modal " id="mdlCopiaFraccionesEstilo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Copiar Fracciones de un estilo a otro</h5>
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
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="chCopiarFraccionMuestras" name="chCopiarFraccionMuestras">
                                <label class="custom-control-label text-info labelCheck" for="chCopiarFraccionMuestras">Fracciones de Muestras</label>
                            </div>
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
    var mdlCopiaFraccionesEstilo = $('#mdlCopiaFraccionesEstilo');
    $(document).ready(function () {
        mdlCopiaFraccionesEstilo.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCopiaFraccionesEstilo);
            mdlCopiaFraccionesEstilo.find("input").val("");
            mdlCopiaFraccionesEstilo.find('#dEstilo').focus();
        });

        mdlCopiaFraccionesEstilo.find("#dEstilo").keydown(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {
                    $.getJSON(base_url + 'index.php/Pedidos/onVerificaEstilo', {Estilo: estilo}).done(function (data) {
                        if (data.length > 0) {

                        } else {
                            swal('ERROR', 'EL ESTILO NO EXISTE', 'warning').then((value) => {
                                mdlCopiaFraccionesEstilo.find('#dEstilo').focus().val('');
                            });
                        }
                    });
                }
            }
        });
        mdlCopiaFraccionesEstilo.find("#aEstilo").keydown(function (e) {
            if (e.keyCode === 13) {
                var estilo = $(this).val();
                if (estilo) {

                    $.getJSON(base_url + 'index.php/FraccionesXEstilo/' + 'onVerificaEstiloFracciones', {Estilo: estilo}).done(function (data, x, jq) {
                        $.each(data, function (k, v) {
                            if (data.length > 0) {
                                swal('ERROR', 'EL ESTILO YA TIENE SUS FRACCIONES CAPTURADAS', 'warning').then((value) => {
                                    mdlCopiaFraccionesEstilo.find('#aEstilo').focus().val('');
                                });
                            } else {
                                mdlCopiaFraccionesEstilo.find('#btnImprimir').focus();
                            }
                        });
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlCopiaFraccionesEstilo.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlCopiaFraccionesEstilo.find("#frmCaptura")[0]);
            var cMuestras = mdlCopiaFraccionesEstilo.find("#chCopiarFraccionMuestras")[0].checked ? '1' : '0';
            frm.append('cMuestras', cMuestras);
            $.ajax({
                url: base_url + 'index.php/FraccionesXEstilo/onCopiarFraccionesDeEstiloaEstilo',
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
                    text: "SE HAN COPIADO LAS FRACCIONES DEL ESTILO SELECCIONADO AL ESTILO DESTINO",
                    icon: "success"
                }).then((willDelete) => {
                    mdlCopiaFraccionesEstilo.find("input").val("");
                    mdlCopiaFraccionesEstilo.find('#dEstilo').focus();
                });


            }).fail(function (x, y, z) {
                HoldOn.close();
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            });
        });

    });
</script>


