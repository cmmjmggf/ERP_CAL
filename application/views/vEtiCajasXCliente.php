<div class="modal " id="mdlEtiCajaXCliente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Etiquetas por Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Cliente</label>
                            <select id="Cliente" name="Cliente" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
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
        mdlEtiCajaXCliente.on('shown.bs.modal', function () {
            mdlEtiCajaXCliente.find("input").val("");
            $.each(mdlEtiCajaXCliente.find("select"), function (k, v) {
                mdlEtiCajaXCliente.find("select")[k].selectize.clear(true);
            });
            getClientesEtiCajas();
            mdlEtiCajaXCliente.find('#Cliente')[0].selectize.focus();
        });
        mdlEtiCajaXCliente.find("#bPorControlEti").change(function () {
            if (mdlEtiCajaXCliente.find("#bPorControlEti")[0].checked) {
                mdlEtiCajaXCliente.find("#dPorControl").removeClass('d-none');
                mdlEtiCajaXCliente.find("#dEtiquetasPorMaSemAno").addClass('d-none');
            } else {
                mdlEtiCajaXCliente.find("#dEtiquetasPorMaSemAno").removeClass('d-none');
                mdlEtiCajaXCliente.find("#dPorControl").addClass('d-none');
            }
        });
        mdlEtiCajaXCliente.find('#btnImprimir').on("click", function () {
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
            } else {
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
                    location.href = base_url + 'index.php/ReportesEstiquetasProduccion/' + csv;
                    HoldOn.close();
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
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                HoldOn.close();
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {

            });
        });
        mdlEtiCajaXCliente.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2016 || parseInt($(this).val()) > 2020 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlEtiCajaXCliente.find("#Ano").val("");
                    mdlEtiCajaXCliente.find("#Ano").focus();
                });
            }
        });
        mdlEtiCajaXCliente.find("#Sem").change(function () {
            var ano = mdlEtiCajaXCliente.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlEtiCajaXCliente.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
    });

    function getClientesEtiCajas() {
        $.getJSON(base_url + 'index.php/PrioridadesPorCliente/' + 'getClientes').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEtiCajaXCliente.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });

    }

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

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

    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
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


</script>


