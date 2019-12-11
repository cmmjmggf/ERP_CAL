<div class="modal " id="mdlEtiquetaCajas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imp. Etiquetas p' Cajas Producto Terminado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3">
                            <label>Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="ClienteEtiCaja" name="ClienteEtiCaja" maxlength="5" required="">
                        </div>
                        <div class="col-9">
                            <label for="" >-</label>
                            <select id="sClienteEtiCajaImp" name="sClienteEtiCajaImp" class="form-control form-control-sm required NotSelectize" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="Clave" >Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
                        </div>
                        <div class="col-9" >
                            <label for="" >Documento</label>
                            <select id="Documento" name="Documento" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <label for="Clave" >Transporte Actual</label>
                            <input type="text" class="form-control form-control-sm" id="Transporte" name="Transporte" required="">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <label for="Clave" >Captura Transporte Distinto</label>
                            <input type="text" class="form-control form-control-sm" id="TransporteDos" name="TransporteDos">
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
    var mdlEtiquetaCajas = $('#mdlEtiquetaCajas');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlEtiquetaCajas);
        mdlEtiquetaCajas.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlEtiquetaCajas.on('shown.bs.modal', function () {

            mdlEtiquetaCajas.find("input").val("");
            $.each(mdlEtiquetaCajas.find("select"), function (k, v) {
                mdlEtiquetaCajas.find("select")[k].selectize.clear(true);
            });
            getClientesEtiquetaCajasTerm();
            mdlEtiquetaCajas.find('#ClienteEtiCaja').focus();
        });
        mdlEtiquetaCajas.find('#ClienteEtiCaja').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'AuxReportesClientesTres/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlEtiquetaCajas.find("#sClienteEtiCajaImp")[0].selectize.addItem(txtcte, true);
                            $.getJSON(base_url + 'index.php/AuxReportesClientes/getTransporteCliente', {
                                Cliente: txtcte
                            }).done(function (data) {
                                if (data.length > 0) {//Existe Transporte
                                    mdlEtiquetaCajas.find('#Transporte').val(data[0].nomtra);
                                    mdlEtiquetaCajas.find('#Tp').focus().select();
                                }
                            }).fail(function (x, y, z) {
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                                console.log(x.responseText);
                            });
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEtiquetaCajas.find("#sClienteEtiCajaImp")[0].selectize.clear(true);
                                mdlEtiquetaCajas.find('#ClienteEtiCaja').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEtiquetaCajas.find("#sClienteEtiCajaImp").change(function () {
            console.log('entra');
            if ($(this).val()) {
                mdlEtiquetaCajas.find('#ClienteEtiCaja').val($(this).val());
                $.getJSON(base_url + 'index.php/AuxReportesClientes/getTransporteCliente', {
                    Cliente: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) {//Existe Transporte
                        mdlEtiquetaCajas.find('#Transporte').val(data[0].nomtra);
                    }
                    mdlEtiquetaCajas.find('#Tp').focus().select();
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        mdlEtiquetaCajas.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                var cte = mdlEtiquetaCajas.find('#ClienteEtiCaja').val();
                if (tp === 1 || tp === 2) {
                    $.getJSON(base_url + 'index.php/AuxReportesClientes/getDoctosEtiCajas', {
                        Tp: tp,
                        Cliente: cte
                    }).done(function (data) {
                        mdlEtiquetaCajas.find("#Documento")[0].selectize.clear(true);
                        mdlEtiquetaCajas.find("#Documento")[0].selectize.clearOptions();
                        if (data.length > 0) {//Existe
                            $.each(data, function (k, v) {
                                mdlEtiquetaCajas.find("#Documento")[0].selectize.addOption({text: v.remicion, value: v.remicion});
                            });
                            mdlEtiquetaCajas.find("#Documento")[0].selectize.focus();
                            mdlEtiquetaCajas.find("#Documento")[0].selectize.open();
                        } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                            swal({
                                title: "ATENCIÓN",
                                text: "NO EXISTEN DOCUMENTOS PARA ESTE CLIENTE/TP",
                                icon: "error",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then((action) => {
                                mdlEtiquetaCajas.find("#Tp").val('').focus();
                            });
                        }
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
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
        mdlEtiquetaCajas.find("#Documento").change(function () {
            if ($(this).val()) {
                var tp = mdlEtiquetaCajas.find("#Tp").val();
                var cte = mdlEtiquetaCajas.find('#ClienteEtiCaja').val();
                $.getJSON(base_url + 'index.php/AuxReportesClientes/getCajasFactura', {
                    Cliente: cte,
                    Tp: tp,
                    Factura: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) {//Existe Transporte
                        mdlEtiquetaCajas.find('#Transporte').focus().select();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DOCUMENTOS EN FACTURACIÓN PARA ESTE DOCUMENTO/CLIENTE/TP",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            mdlEtiquetaCajas.find("#Documento")[0].selectize.clear(true);
                            mdlEtiquetaCajas.find("#Documento")[0].selectize.focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

            }
        });
        mdlEtiquetaCajas.find("#Transporte").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlEtiquetaCajas.find("#TransporteDos").focus().select();
                }
            }
        });
        mdlEtiquetaCajas.find("#TransporteDos").keypress(function (e) {
            if (e.keyCode === 13) {
                mdlEtiquetaCajas.find('#btnImprimir').focus();
            }
        });
        mdlEtiquetaCajas.find('#btnImprimir').on("click", function () {
            onDisable(mdlEtiquetaCajas.find('#btnImprimir'));
            var tp = mdlEtiquetaCajas.find("#Tp").val();
            var folio = mdlEtiquetaCajas.find("#Documento").val();
            var cte = mdlEtiquetaCajas.find("#ClienteEtiCaja").val();
            onImprimirReporteEtiCajas(tp, folio, cte);
        });
    });


    function onImprimirReporteEtiCajas(tp, folio, cte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(base_url + 'index.php/AuxReportesClientes/onReporteEtiCajas', {
            Tp: tp,
            Factura: folio,
            Cliente: cte,
            Transporte: mdlEtiquetaCajas.find("#TransporteDos").val()
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {
                onImprimirReporteFancyAFC(data, function () {
                    mdlEtiquetaCajas.find('#ClienteEtiCaja').focus();
                    onEnable(mdlEtiquetaCajas.find('#btnImprimir'));
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
            onEnable(mdlEtiquetaCajas.find('#btnImprimir'));
        });
    }

    function getClientesEtiquetaCajasTerm() {
        mdlEtiquetaCajas.find("#sClienteEtiCajaImp")[0].selectize.clear(true);
        mdlEtiquetaCajas.find("#sClienteEtiCajaImp")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlEtiquetaCajas.find("#sClienteEtiCajaImp")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
