<div class="modal " id="mdlEstadoCuenta8"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCtaOchoDias" name="dClienteEdoCtaOchoDias" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sdClienteEdoCtaOchoDias" name="sdClienteEdoCtaOchoDias" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCtaOchoDias" name="aClienteEdoCtaOchoDias" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="saClienteEdoCtaOchoDias" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuentaOchoDias" name="TpEdoCuentaOchoDias" required="">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <label class="mb-1">Orden <span class="badge badge-info" style="font-size: 14px;">1 Cliente, 2 Agente</span></label>
                            <select id="OrdenEdocta" name="OrdenEdocta" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 CLIENTE</option>
                                <option value="2">2 AGENTE</option>
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
    var mdlEstadoCuenta8 = $('#mdlEstadoCuenta8');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlEstadoCuenta8);
        mdlEstadoCuenta8.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlEstadoCuenta8.on('shown.bs.modal', function () {
            mdlEstadoCuenta8.find("input").val("");
            $.each(mdlEstadoCuenta8.find("select"), function (k, v) {
                mdlEstadoCuenta8.find("select")[k].selectize.clear(true);
            });
            getClientesEdoCuentaOchoDias();
            mdlEstadoCuenta8.find('#dClienteEdoCtaOchoDias').focus();
        });
        mdlEstadoCuenta8.find('#dClienteEdoCtaOchoDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta8.find('#aClienteEdoCtaOchoDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias")[0].selectize.clear(true);
                                mdlEstadoCuenta8.find('#dClienteEdoCtaOchoDias').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta8.find("#dClienteEdoCtaOchoDias").val($(this).val());
                mdlEstadoCuenta8.find("#aClienteEdoCtaOchoDias").focus();
            }
        });
        mdlEstadoCuenta8.find('#aClienteEdoCtaOchoDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta8.find('#TpEdoCuentaOchoDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias")[0].selectize.clear(true);
                                mdlEstadoCuenta8.find('#aClienteEdoCtaOchoDias').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta8.find("#aClienteEdoCtaOchoDias").val($(this).val());
                mdlEstadoCuenta8.find("#TpEdoCuentaOchoDias").focus();
            }
        });
        mdlEstadoCuenta8.find("#TpEdoCuentaOchoDias").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarEdoCta8($(this));
                } else {
                    mdlEstadoCuenta8.find("#OrdenEdocta")[0].selectize.focus();
                }
            }
        });
        mdlEstadoCuenta8.find("#OrdenEdocta").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta8.find("#btnImprimir").focus();
            }
        });
        mdlEstadoCuenta8.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta8.find("#frmCaptura")[0]);

            var reporte = (mdlEstadoCuenta8.find("#OrdenEdocta").val() === '1') ? 'imprimirReportesCartera' : 'imprimirReportesCarteraAgenteCliente';


            $.ajax({
                url: base_url + 'index.php/AuxReportesClientes/' + reporte,
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
                        mdlEstadoCuenta8.find('#Cliente').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarEdoCta8(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuenta8.find("#OrdenEdocta")[0].selectize.focus();
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

    function getClientesEdoCuentaOchoDias() {
        mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias")[0].selectize.clear(true);
        mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias")[0].selectize.clearOptions();
        mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias")[0].selectize.clear(true);
        mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlEstadoCuenta8.find("#sdClienteEdoCtaOchoDias")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
                mdlEstadoCuenta8.find("#saClienteEdoCtaOchoDias")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
