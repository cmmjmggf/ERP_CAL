<div class="modal " id="mdlEstadoCuenta306090"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
                        <div class="col-5">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCtaMasDias" name="dClienteEdoCtaMasDias" maxlength="5" required="">
                        </div>
                        <div class="col-5">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCtaMasDias" name="aClienteEdoCtaMasDias" maxlength="5" required="">
                        </div>
                        <div class="col-3">
                            <label class="mb-1">Tp: <span class="badge badge-info" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuentaMasDias" name="TpEdoCuentaMasDias" required="">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rGen" name="Reporte" class="custom-control-input" checked="true">
                                    <label class="custom-control-label text-danger" for="rGen">General</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="r60" name="Reporte" class="custom-control-input">
                                    <label class="custom-control-label text-danger" for="r60">Sólo general con más de 60 días</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="r90" name="Reporte" class="custom-control-input">
                                    <label class="custom-control-label text-danger" for="r90">Sólo general con más de 90 días</label>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnImprimirExcel">EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlEstadoCuenta306090 = $('#mdlEstadoCuenta306090');
    var dias = 0;
    $(document).ready(function () {
        mdlEstadoCuenta306090.on('shown.bs.modal', function () {
            dias = 0;
            mdlEstadoCuenta306090.find("input").val("");
            mdlEstadoCuenta306090.find('#rGen').prop("checked", true);
            mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias').focus();
        });
        mdlEstadoCuenta306090.find('#rGen').change(function () {
            dias = 0;
            mdlEstadoCuenta306090.find('#btnImprimir').focus();
        });
        mdlEstadoCuenta306090.find('#r60').change(function () {
            dias = 60;
            mdlEstadoCuenta306090.find('#btnImprimir').focus();
        });
        mdlEstadoCuenta306090.find('#r90').change(function () {
            dias = 90;
            mdlEstadoCuenta306090.find('#btnImprimir').focus();
        });
        mdlEstadoCuenta306090.find('#dClienteEdoCtaMasDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta306090.find('#aClienteEdoCtaMasDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
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
        mdlEstadoCuenta306090.find('#aClienteEdoCtaMasDias').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuenta306090.find('#TpEdoCuentaMasDias').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
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
        mdlEstadoCuenta306090.find("#TpEdoCuentaMasDias").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpMasDias($(this));
                } else {
                    mdlEstadoCuenta306090.find('#btnImprimir').focus();
                }
            }
        });
        mdlEstadoCuenta306090.find('#btnImprimir').on("click", function () {
            onDisable(mdlEstadoCuenta306090.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta306090.find("#frmCaptura")[0]);
            frm.append('Dias', dias);
            $.ajax({
                url: base_url + 'index.php/AuxReportesClientesDos/imprimirReportesCartera',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onEnable(mdlEstadoCuenta306090.find('#btnImprimir'));
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onImprimirReporteFancy(data);
                    HoldOn.close();
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlEstadoCuenta306090.find('#btnImprimir'));
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        mdlEstadoCuenta306090.find('#btnImprimirExcel').on("click", function () {
            onDisable(mdlEstadoCuenta306090.find('#btnImprimirExcel'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta306090.find("#frmCaptura")[0]);
            frm.append('Dias', dias);
            $.ajax({
                url: base_url + 'index.php/AuxReportesClientesDos/imprimirReportesCarteraExcel',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onEnable(mdlEstadoCuenta306090.find('#btnImprimirExcel'));
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
                    onOpenWindowBlank(data);
                    HoldOn.close();
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlEstadoCuenta306090.find('#btnImprimirExcel'));
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTpMasDias(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuenta306090.find('#btnImprimir').focus();
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
