<div class="modal " id="mdlEstadoCuenta"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCta" name="dClienteEdoCta" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sdClienteEdoCta" name="sdClienteEdoCta" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-3">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCta" name="aClienteEdoCta" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="saClienteEdoCta" name="saClienteEdoCta" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-4">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuenta" name="TpEdoCuenta" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnImprimirExcel">EXPORTAR A EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlEstadoCuenta = $('#mdlEstadoCuenta');
    $(document).ready(function () {
        mdlEstadoCuenta.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlEstadoCuenta.on('shown.bs.modal', function () {
            getClientesEdoCuentaUno();
            mdlEstadoCuenta.find("input").val("");
            mdlEstadoCuenta.find('#dClienteEdoCta').focus();
        });
        mdlEstadoCuenta.find('#dClienteEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta.find("#sdClienteEdoCta")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta.find('#aClienteEdoCta').focus().select();
                        } else {
                            mdlEstadoCuenta.find('#aClienteEdoCta').focus().select();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta.find("#sdClienteEdoCta").change(function () {
            console.log($(this).val());
            if ($(this).val()) {

                mdlEstadoCuenta.find("#dClienteEdoCta").val($(this).val());
                mdlEstadoCuenta.find("#aClienteEdoCta").focus();
            }
        });
        mdlEstadoCuenta.find('#aClienteEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta.find("#saClienteEdoCta")[0].selectize.addItem(txtcte, true);
                            mdlEstadoCuenta.find('#TpEdoCuenta').focus().select();
                        } else {
                            mdlEstadoCuenta.find('#TpEdoCuenta').focus().select();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuenta.find("#saClienteEdoCta").change(function () {
            if ($(this).val()) {
                mdlEstadoCuenta.find("#aClienteEdoCta").val($(this).val());
                mdlEstadoCuenta.find("#TpEdoCuenta").focus();
            }
        });
        mdlEstadoCuenta.find("#TpEdoCuenta").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpEdoCuentaUno($(this));
                } else {
                    mdlEstadoCuenta.find('#btnImprimir').focus();
                }
            }
        });
        mdlEstadoCuenta.find('#btnImprimirExcel').on("click", function () {
            onDisable(mdlEstadoCuenta.find('#btnImprimirExcel'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteEstadoCuentaExcel',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onEnable(mdlEstadoCuenta.find('#btnImprimirExcel'));
                console.log(data);
                if (data.length > 0) {
                    window.open(data, '_blank');
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuenta.find('#dClienteEdoCta').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlEstadoCuenta.find('#btnImprimirExcel'));
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlEstadoCuenta.find('#btnImprimir').on("click", function () {
            onDisable(mdlEstadoCuenta.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteEstadoCuenta',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function () {
                        mdlEstadoCuenta.find('#dClienteEdoCta').focus();
                        onEnable(mdlEstadoCuenta.find('#btnImprimir'));
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuenta.find('#dClienteEdoCta').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    }
    );

    function onVerificarTpEdoCuentaUno(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuenta.find('#btnImprimir').focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
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
