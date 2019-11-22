<div class="modal " id="mdlEstadoCuenta306090"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Clientes de 30-60-90 días</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCtaMasDias" name="dClienteEdoCtaMasDias" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sdClienteEdoCtaMasDias" name="sdClienteEdoCtaMasDias" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCtaMasDias" name="aClienteEdoCtaMasDias" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="saClienteEdoCtaMasDias" name="saClienteEdoCtaMasDias" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuentaMasDias" name="TpEdoCuentaMasDias" required="">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <label class="mb-1">A cuántos días? <span class="badge badge-info" style="font-size: 14px;">30, 60, 90 Días</span></label>
                            <select id="DiasEdoCta" name="DiasEdoCta" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="30">30 DÍAS</option>
                                <option value="60">60 DÍAS</option>
                                <option value="90">90 DÍAS</option>
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
    var mdlEstadoCuenta306090 = $('#mdlEstadoCuenta306090');
    $(document).ready(function () {
        mdlEstadoCuenta306090.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(mdlEstadoCuenta306090);
        mdlEstadoCuenta306090.on('shown.bs.modal', function () {
            mdlEstadoCuenta306090.find("input").val("");
            $.each(mdlEstadoCuenta306090.find("select"), function (k, v) {
                mdlEstadoCuenta306090.find("select")[k].selectize.clear(true);
            });
            getClientesEdoCuentaMasDias();
            mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias').focus();
        });
        mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta306090.find('#aClienteEdoCtaMasDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias")[0].selectize.clear(true);
                                mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta306090.find("#dClienteEdoCtaMasDias").val($(this).val());
                mdlEstadoCuenta306090.find("#aClienteEdoCtaMasDias").focus();
            }
        });
        mdlEstadoCuenta306090.find('#aClienteEdoCtaMasDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta306090.find('#TpEdoCuentaMasDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias")[0].selectize.clear(true);
                                mdlEstadoCuenta306090.find('#aClienteEdoCtaMasDias').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta306090.find("#aClienteEdoCtaMasDias").val($(this).val());
                mdlEstadoCuenta306090.find("#TpEdoCuentaMasDias").focus();
            }
        });
        mdlEstadoCuenta306090.find("#TpEdoCuentaMasDias").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpMasDias($(this));
                } else {
                    mdlEstadoCuenta306090.find("#DiasEdoCta")[0].selectize.focus();
                }
            }
        });
        mdlEstadoCuenta306090.find("#DiasEdoCta").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta306090.find("#btnImprimir").focus();
            }
        });
        mdlEstadoCuenta306090.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta306090.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/AuxReportesClientesDos/onReporteEdoCta306090',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onImprimirReporteFancyArray(JSON.parse(data));
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTpMasDias(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuenta306090.find("#DiasEdoCta")[0].selectize.focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 y 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

    function getClientesEdoCuentaMasDias() {
        mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias")[0].selectize.clear(true);
        mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias")[0].selectize.clearOptions();
        mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias")[0].selectize.clear(true);
        mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlEstadoCuenta306090.find("#sdClienteEdoCtaMasDias")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
                mdlEstadoCuenta306090.find("#saClienteEdoCtaMasDias")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
