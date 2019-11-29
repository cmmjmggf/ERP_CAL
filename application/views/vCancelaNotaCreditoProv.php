<div class="modal " id="mdlCancelaNotaCargo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" id='mdlReporte' role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar Nota de Cargo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEdoCta">

                    <div class="row">
                        <div class="col-6">
                            <label>Tp </label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly" id="TpC" name="TpC" >
                        </div>
                        <div class="col-6">
                            <label>Folio</label>
                            <input type="text" maxlength="15" class="form-control form-control-sm numbersOnly" id="FolioC" name="FolioC" >
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12" >
                            <label>Proveedor</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="ProveedorC" name="ProveedorC" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sProveedorC" name="sProveedorC" class="form-control form-control-sm required NotSelectize selectNotEnter" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnCancelarDoc">ACEPTAR</button>
                <button type="button" class="btn btn-info" id="btnVerMovProv">VER MOVIMIENTOS</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-fullscreen" id="mdlMovimientosProv"  role="dialog">
    <div class="modal-dialog modal-dialog-centered" id='mdlVista' role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Movimientos del Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="width: 100%; height: 80%">
                <iframe id="ifMovs" frameborder="0" scrolling="no" style="width: 100%; height: 100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/NotasCargo/';
    var mdlCancelaNotaCargo = $('#mdlCancelaNotaCargo');
    var mdlReporte = mdlCancelaNotaCargo.find('#mdlReporte');
    var btnVerMovProv = mdlCancelaNotaCargo.find('#btnVerMovProv');
    var mdlMovimientosProv = $('#mdlMovimientosProv');
    var mdlVista = mdlMovimientosProv.find('#mdlVista');
    $(document).ready(function () {
        mdlCancelaNotaCargo.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(mdlCancelaNotaCargo);
        setFocusSelectToInputOnChange('#sProveedorC', '#btnCancelarDoc', mdlCancelaNotaCargo);
        mdlCancelaNotaCargo.on('shown.bs.modal', function () {
            mdlCancelaNotaCargo.find("input").val("");
            $.each(mdlCancelaNotaCargo.find("select"), function (k, v) {
                mdlCancelaNotaCargo.find("select")[k].selectize.clear(true);
            });
            mdlCancelaNotaCargo.find('#TpC').focus();
        });
        mdlMovimientosProv.on('shown.bs.modal', function () {
            mdlVista.find('#ifMovs').attr('src', base_url + '/MovimientosProveedor/?origen=MATERIALES');

        });
        btnVerMovProv.click(function () {
            mdlMovimientosProv.modal('show');
        });
        mdlCancelaNotaCargo.find("#TpC").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        mdlCancelaNotaCargo.find("#FolioC").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlCancelaNotaCargo.find("#ProveedorC").focus();
                }
            }
        });
        mdlCancelaNotaCargo.find('#ProveedorC').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.addItem(txtprov, true);
                            mdlCancelaNotaCargo.find("#btnCancelarDoc").focus();

                        } else {
                            onCampoInvalido('', 'EL PROVEEDOR NO EXISTE', function () {
                                mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.clear(true);
                                mdlCancelaNotaCargo.find('#ProveedorC').focus().val('');
                                return;
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    onCampoInvalido('', 'DEBE DE CAPTURAR EL PROVEEDOR', function () {
                        mdlCancelaNotaCargo.find('#ProveedorC').focus();
                        return;
                    });
                }
            }
        });
        mdlCancelaNotaCargo.find("#sProveedorC").change(function () {
            if ($(this).val()) {
                mdlCancelaNotaCargo.find('#Proveedorc').val($(this).val());
                mdlCancelaNotaCargo.find("#btnCancelarDoc").focus();

            } else {
                onCampoInvalido('', 'DEBE DE CAPTURAR EL PROVEEDOR', function () {
                    mdlCancelaNotaCargo.find('#ProveedorC').focus();
                    return;
                });
            }
        });
        mdlCancelaNotaCargo.find("#btnCancelarDoc").click(function () {
            mdlCancelaNotaCargo.find("#btnCancelarDoc").attr('disabled', true);
            var tp = mdlCancelaNotaCargo.find("#TpC").val();
            var folio = mdlCancelaNotaCargo.find("#FolioC").val();
            var prov = mdlCancelaNotaCargo.find("#ProveedorC").val();
            $.post(master_url + 'onCancelarNotaCredito', {
                Tp: tp,
                Folio: folio,
                Proveedor: prov
            }).done(function (data) {
                if (parseInt(data) === 0) {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL DOCUMENTO NO EXISTE O YA FUE CANCELADO",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlCancelaNotaCargo.find("#btnCancelarDoc").attr('disabled', false);
                        mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.clear(true);
                        mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.clearOptions();
                        mdlCancelaNotaCargo.find('#ProveedorC').val('');
                        mdlCancelaNotaCargo.find('#FolioC').val('');
                        mdlCancelaNotaCargo.find('#TpC').val('').focus();
                    });
                } else {
                    swal({
                        title: "OPERACIÓN EXITOSA",
                        text: "EL DOCUMENTO HA SIDO CANCELADO CORRECTAMENTE",
                        icon: "success",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlCancelaNotaCargo.find("#btnCancelarDoc").attr('disabled', false);
                        mdlCancelaNotaCargo.modal('hide');
                    });
                }
            }).fail(function (x, y, z) {
                mdlCancelaNotaCargo.find("#btnCancelarDoc").attr('disabled', false);
                console.log(x, y, z);
            });
        });
    });

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            getProveedoresCancela(tp);
            mdlCancelaNotaCargo.find('#FolioC').focus().select();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getProveedoresCancela(tp) {
        mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.clear(true);
        mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlCancelaNotaCargo.find("#sProveedorC")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>
