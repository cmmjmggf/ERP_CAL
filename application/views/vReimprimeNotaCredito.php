<div class="modal " id="mdlReimprimeNotaCredito"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reimprime Nota de Crédito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label for="Clave" >Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
                        </div>
                        <div class="w-100"></div>
                        <div class="col-3">
                            <label>Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sCliente" name="sCliente" class="form-control form-control-sm mb-2 required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-5" >
                            <label for="" >Nota</label>
                            <select id="NotaCredito" name="NotaCredito" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
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
    var mdlReimprimeNotaCredito = $('#mdlReimprimeNotaCredito');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlReimprimeNotaCredito);
        mdlReimprimeNotaCredito.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlReimprimeNotaCredito.on('shown.bs.modal', function () {

            mdlReimprimeNotaCredito.find("input").val("");
            $.each(mdlReimprimeNotaCredito.find("select"), function (k, v) {
                mdlReimprimeNotaCredito.find("select")[k].selectize.clear(true);
            });
            getClientesReimprimeNC();
            mdlReimprimeNotaCredito.find('#Tp').focus();
        });
        mdlReimprimeNotaCredito.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    mdlReimprimeNotaCredito.find('#Cliente').focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
        mdlReimprimeNotaCredito.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    var tp = mdlReimprimeNotaCredito.find("#Tp").val();
                    $.getJSON(base_url + 'PagosConCincoDescuento/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlReimprimeNotaCredito.find("#sCliente")[0].selectize.addItem(txtcte, true);

                            var tp = mdlReimprimeNotaCredito.find("#Tp").val();
                            $.getJSON(base_url + 'index.php/NotasCreditoClientes/getNotasByTpByCliente', {
                                Tp: tp,
                                Cliente: txtcte
                            }).done(function (data) {
                                mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                                mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clearOptions();
                                if (data.length > 0) {//Existe
                                    $.each(data, function (k, v) {
                                        mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.addOption({text: v.nc, value: v.nc});
                                    });
                                    mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.open();
                                } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                                    swal({
                                        title: "ATENCIÓN",
                                        text: "NO EXISTEN NOTAS DE CREDITO PARA ESTE CLIENTE/TP",
                                        icon: "error",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false
                                    }).then((action) => {
                                        mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                                        mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.focus();
                                    });
                                }
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });

                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlReimprimeNotaCredito.find("#sCliente")[0].selectize.clear(true);
                                mdlReimprimeNotaCredito.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlReimprimeNotaCredito.find("#sCliente").change(function () {
            if ($(this).val()) {
                mdlReimprimeNotaCredito.find("#Cliente").val($(this).val());
                var tp = mdlReimprimeNotaCredito.find("#Tp").val();
                $.getJSON(base_url + 'index.php/NotasCreditoClientes/getNotasByTpByCliente', {
                    Tp: tp,
                    Cliente: $(this).val()
                }).done(function (data) {
                    mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                    mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clearOptions();
                    if (data.length > 0) {//Existe
                        $.each(data, function (k, v) {
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.addOption({text: v.nc, value: v.nc});
                        });
                        mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.open();
                    } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN NOTAS DE CREDITO PARA ESTE CLIENTE/TP",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        mdlReimprimeNotaCredito.find("#NotaCredito").change(function () {
            if ($(this).val()) {
                mdlReimprimeNotaCredito.find('#btnImprimir').focus();
            }
        });
        mdlReimprimeNotaCredito.find('#btnImprimir').on("click", function () {
            onDisable(mdlReimprimeNotaCredito.find('#btnImprimir'));
            var tp = mdlReimprimeNotaCredito.find("#Tp").val();
            var folio = mdlReimprimeNotaCredito.find("#NotaCredito").val();
            var cte = mdlReimprimeNotaCredito.find("#Cliente").val();
            var reporte = (tp === '1') ? 'onImprimirReporteNotaCreditoTp1' : 'onImprimirReporteNotaCreditoTp2';
            onImprimirReporteNotaCredito(tp, folio, cte, reporte);
        });

    });


    function onImprimirReporteNotaCredito(tp, folio, cte, reporte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(base_url + 'index.php/NotasCreditoClientes/' + reporte, {
            Tp: tp,
            Folio: folio,
            Cliente: cte
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {
                onImprimirReporteFancyAFC(data, function () {
                    mdlReimprimeNotaCredito.find('#Tp').focus().select();
                    onEnable(mdlReimprimeNotaCredito.find('#btnImprimir'));
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN REGISTROS",
                    icon: "error"
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        }).always(function () {
            onEnable(mdlReimprimeNotaCredito.find('#btnImprimir'));
        });
    }

    function getClientesReimprimeNC() {
        mdlReimprimeNotaCredito.find("#sCliente")[0].selectize.clear(true);
        mdlReimprimeNotaCredito.find("#sCliente")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/PagosConCincoDescuento/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlReimprimeNotaCredito.find("#sCliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
