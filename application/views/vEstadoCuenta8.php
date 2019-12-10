<div class="modal " id="mdlEstadoCuenta8"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
                        <div class="col-5">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCtaOchoDias" name="dClienteEdoCtaOchoDias" maxlength="5" required="">
                        </div>
                        <div class="col-5">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCtaOchoDias" name="aClienteEdoCtaOchoDias" maxlength="5" required="">
                        </div>
                        <div class="col-3 mb-3">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuentaOchoDias" name="TpEdoCuentaOchoDias" required="">
                        </div>
                        <div class="col-10">
                            <label class="mb-1">Orden <span class="badge badge-info" style="font-size: 14px;"> 1 Cliente, 2 Agente, 3 Agente/Ciudad</span></label>
                            <select id="OrdenEdocta" name="OrdenEdocta" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="1">1 CLIENTE</option>
                                <option value="2">2 AGENTE</option>
                                <option value="3">3 AGENTE/CIUDAD</option>
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
        mdlEstadoCuenta8.on('shown.bs.modal', function () {
            mdlEstadoCuenta8.find("input").val("");
            $.each(mdlEstadoCuenta8.find("select"), function (k, v) {
                mdlEstadoCuenta8.find("select")[k].selectize.clear(true);
            });
            mdlEstadoCuenta8.find('#dClienteEdoCtaOchoDias').focus();
        });
        mdlEstadoCuenta8.find('#dClienteEdoCtaOchoDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta8.find('#aClienteEdoCtaOchoDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
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
        mdlEstadoCuenta8.find('#aClienteEdoCtaOchoDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta8.find('#TpEdoCuentaOchoDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
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
            onDisable(mdlEstadoCuenta8.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta8.find("#frmCaptura")[0]);
            var reporte;
            if (mdlEstadoCuenta8.find("#OrdenEdocta").val() === '1') {
                reporte = 'imprimirReportesCartera';
            } else if (mdlEstadoCuenta8.find("#OrdenEdocta").val() === '2') {
                reporte = 'imprimirReportesCarteraAgenteCliente';
            } else if (mdlEstadoCuenta8.find("#OrdenEdocta").val() === '3') {
                reporte = 'imprimirReportesCarteraAgenteClienteEdoCiudad';
            }
            $.ajax({
                url: base_url + 'index.php/AuxReportesClientes/' + reporte,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onEnable(mdlEstadoCuenta8.find('#btnImprimir'));
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onImprimirReporteFancyArray(JSON.parse(data));
                    HoldOn.close();
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlEstadoCuenta8.find('#btnImprimir'));
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
</script>
