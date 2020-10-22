<div class="modal " id="mdlEtiCajaXCliente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-barcode"></span> Etiquetas por Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">

                        <div class="col-8" >
                            <label>Cliente</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sCliente" name="sCliente" class="form-control form-control-sm required NotSelectize selectNotEnter" required="" >
                                        <option value=""></option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id = "dEtiquetasPorMaSemAno">
                        <div class="col-4" >
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-4">
                            <label>Maq</label>
                            <input type="text" id="Maq" name="Maq" class="form-control form-control-sm numbersOnly" maxlength="2" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="bPorControlEti" name="bPorControlEti">
                                <label class="custom-control-label text-info labelCheck" for="bPorControlEti">Imprimir X Control</label>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="dPorControl">
                        <div class="col-6">
                            <label>Control</label>
                            <input type="text" maxlength="10" class="form-control form-control-sm numbersOnly" id="Control" name="Control" >
                        </div>
                        <div class="col-6">
                            <label>Al Control</label>
                            <input type="text" maxlength="10" class="form-control form-control-sm numbersOnly" id="AControl" name="AControl" >
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
    var mdlEtiCajaXCliente = $('#mdlEtiCajaXCliente');
    $(document).ready(function () {
        mdlEtiCajaXCliente.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlEtiCajaXCliente.on('shown.bs.modal', function () {
            mdlEtiCajaXCliente.find("input").val("");
            $.each(mdlEtiCajaXCliente.find("select"), function (k, v) {
                mdlEtiCajaXCliente.find("select")[k].selectize.clear(true);
            });
            getClientesEtiXCli();
            mdlEtiCajaXCliente.find('#Ano').val(getYear());
            mdlEtiCajaXCliente.find('#Cliente').focus();
        });
        mdlEtiCajaXCliente.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtCliente = $(this).val();
                if (txtCliente) {
                    $.getJSON(base_url + 'index.php/PrioridadesPorCliente/onVerificarClienteAgregarPrioridad', {Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            mdlEtiCajaXCliente.find("#sCliente")[0].selectize.addItem(txtCliente, true);
                            mdlEtiCajaXCliente.find('#Ano').focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                mdlEtiCajaXCliente.find('#sCliente')[0].selectize.clear(true);
                                mdlEtiCajaXCliente.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    mdlEtiCajaXCliente.find('#Ano').focus().select();
                }
            }
        });
        mdlEtiCajaXCliente.find("#sCliente").change(function () {
            if ($(this).val()) {
                mdlEtiCajaXCliente.find('#Cliente').val($(this).val());
                mdlEtiCajaXCliente.find('#Ano').focus().select();
            }
        });
        mdlEtiCajaXCliente.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlEtiCajaXCliente.find("#Ano").val("");
                        mdlEtiCajaXCliente.find("#Ano").focus();
                    });
                } else {
                    mdlEtiCajaXCliente.find("#Sem").focus().select();
                }
            }
        });
        mdlEtiCajaXCliente.find("#Sem").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = mdlEtiCajaXCliente.find("#Ano");
                    onComprobarSemanasProduccionEtiquetasCaja($(this), ano.val());
                }
            }
        });
        mdlEtiCajaXCliente.find("#Maq").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onComprobarMaquilasEtiCaja($(this));
                }
            }
        });
        mdlEtiCajaXCliente.find("#Control").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlEtiCajaXCliente.find("#AControl").focus();
                }
            }
        });
        mdlEtiCajaXCliente.find("#AControl").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    mdlEtiCajaXCliente.find('#btnImprimir').focus();
                }
            }
        });
        mdlEtiCajaXCliente.find("#bPorControlEti").change(function () {
            if (mdlEtiCajaXCliente.find("#bPorControlEti")[0].checked) {
                mdlEtiCajaXCliente.find("#dPorControl").removeClass('d-none');
                mdlEtiCajaXCliente.find("#dEtiquetasPorMaSemAno").addClass('d-none');
                mdlEtiCajaXCliente.find("#Control").focus();
            } else {
                mdlEtiCajaXCliente.find("#dEtiquetasPorMaSemAno").removeClass('d-none');
                mdlEtiCajaXCliente.find("#dPorControl").addClass('d-none');
                mdlEtiCajaXCliente.find("#Cliente").focus();
            }
        });
        mdlEtiCajaXCliente.find('#btnImprimir').on("click", function () {
            var client = mdlEtiCajaXCliente.find('#Cliente');
            if (client.val() === '') {
                onCampoInvalido(mdlEtiCajaXCliente, "DEBE DE ESPECIFICAR UN CLIENTE", function () {
                    client.focus().select();
                });
                return;
            } else {
                onDisable(mdlEtiCajaXCliente.find('#btnImprimir'));
                HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
                var reporte = 'OnReporteEtiquetasCajasGeneral';
                var csv = 'onExportarCSVGenerico';
                var cte = mdlEtiCajaXCliente.find('#Cliente').val();
                if (cte === '854') {//PAKAR
                    reporte = 'OnReporteEtiquetasCajasPakar';
                    csv = 'onExportarCSVPakar';
                } else if (cte === '39' || cte === '995') {//PRICE y ZAPATERÍA SUPER
                    reporte = 'OnReporteEtiquetasCajasPriceSuper';
                    csv = 'onExportarCSVPriceSuper';
                } else if (cte === '2564' || cte === '2566' || cte === '2567' || cte === '2568') {//EXPORTACION SUSANA
                    reporte = 'OnReporteEtiquetasCajasExportacion';
                    csv = 'onExportarCSVExportacion';
                } else {//CUALQUIER OTRO CLIENTE QUE NO SEA LOS ANTERIORES
                    reporte = 'OnReporteEtiquetasCajasGeneral';
                    csv = 'onExportarCSVGenerico';
                }


                var frm = new FormData(mdlEtiCajaXCliente.find("#frmCaptura")[0]);
                var tpo = mdlEtiCajaXCliente.find("#bPorControlEti")[0].checked ? '1' : '0';
                frm.append('Tipo', tpo);
                $.ajax({
                    url: base_url + 'index.php/ReportesEstiquetasProduccion/' + reporte,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data.length > 0) {


                        $.ajax({
                            url: base_url + 'index.php/ReportesEstiquetasProduccion/' + csv,
                            type: "POST"
                        }).done(function (data, x, jq) {
                            console.log(data);
                            if (data.length > 0) {
                                window.open(data, '_blank');
                                onNotifyOld('<span class="fa fa-check fa-lg"></span>', 'REPORTE EN EXCEL GENERADO', 'success');
                            }
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                            HoldOn.close();
                        });
                    } else {
                        HoldOn.close();
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS PARA GENERAR EL ARCHIVO",
                            icon: "error"
                        }).then((action) => {
                            mdlEtiCajaXCliente.find('#Ano').focus();
                        });
                    }
                    onEnable(mdlEtiCajaXCliente.find('#btnImprimir'));
                }).fail(function (x, y, z) {
                    onEnable(mdlEtiCajaXCliente.find('#btnImprimir'));
                    console.log(x.responseText);
                    HoldOn.close();
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {

                });
            }
        });

    });
    function onComprobarSemanasProduccionEtiquetasCaja(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlEtiCajaXCliente.find("#Maq").focus().select();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onComprobarMaquilasEtiCaja(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
                mdlEtiCajaXCliente.find('#btnImprimir').focus();
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getClientesEtiXCli() {
        $.getJSON('<?php print base_url('PrioridadesPorCliente/getClientesEtiXCli'); ?>').done(function (a, b, c) {
            mdlEtiCajaXCliente.find('#sCliente')[0].selectize.clear(true);
            mdlEtiCajaXCliente.find('#sCliente')[0].selectize.clearOptions();
            $.each(a, function (k, v) {
                mdlEtiCajaXCliente.find('#sCliente')[0].selectize.addOption({text: v.CLIENTE, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {

        });
    }
</script>


