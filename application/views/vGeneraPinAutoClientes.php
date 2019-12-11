<div class="modal " id="mdlGeneraPinAutoClientes"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera pin de acceso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4">
                            <label><span class="badge badge-danger" style="font-size: 14px;">PIN a generar:</span></label>
                            <input type="text" maxlength="7" readonly="" class="form-control form-control-sm" id="PinClientes" name="PinClientes" required="">
                        </div>
                        <div class="col-4 d-none" id="dMensajeExistePin">
                            <label>
                                <span class="badge badge-info" style="font-size: 14px;">Ya existe un PIN para el día de hoy: </span>
                                <input type="text" readonly="" class="form-control form-control-sm" id="dPinActual" name="dPinActual">
                            </label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>Para el día</label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="fechaPinClientes" readonly="" name="fechaPinClientes" required="">
                        </div>
                        <div class="col-4 d-none" id="dMensajeExiste">
                            <label>
                                <span class="badge badge-warning" style="font-size: 14px;">Si desea usar el nuevo pin sólo de click en aceptar</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraPinAutoClientes = $('#mdlGeneraPinAutoClientes');
    var existe = 0;
    $(document).ready(function () {
        mdlGeneraPinAutoClientes.on('shown.bs.modal', function () {
            mdlGeneraPinAutoClientes.find("input").val("");
            $.getJSON(base_url + 'index.php/Pin/onVerificarExiste').done(function (data) {
                if (data.length > 0) {
                    mdlGeneraPinAutoClientes.find('#dMensajeExiste').removeClass('d-none');
                    mdlGeneraPinAutoClientes.find('#dMensajeExistePin').removeClass('d-none');
                    mdlGeneraPinAutoClientes.find('#dPinActual').val(data[0].pin);

                } else {
                    mdlGeneraPinAutoClientes.find('#dMensajeExiste').addClass('d-none');
                    mdlGeneraPinAutoClientes.find('#dMensajeExistePin').addClass('d-none');
                }
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
            mdlGeneraPinAutoClientes.find("#PinClientes").val(Math.floor(Math.random() * 10000000));
            mdlGeneraPinAutoClientes.find("#fechaPinClientes").val(getToday());
            mdlGeneraPinAutoClientes.find('#btnAceptar').focus();
        });

        mdlGeneraPinAutoClientes.find('#btnAceptar').click(function () {
            onDisable(mdlGeneraPinAutoClientes.find('#btnAceptar'));
            var frm = new FormData(mdlGeneraPinAutoClientes.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/Pin/onGeneraNuevoPin',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                mdlGeneraPinAutoClientes.modal('hide');
            }).fail(function (x, y, z) {
                swal('ATENCIÓN', '* OCURRIO UN ERROR, PIN NO GENERADO *', 'error');
                console.log(x, y, z);
                HoldOn.close();
            }).always(function () {
                onEnable(mdlGeneraPinAutoClientes.find('#btnAceptar'));
            });
        });
    });
</script>