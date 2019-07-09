<div class="modal modal-fullscreen" id="mdlObsPedidoModificaEliminaPedidoSinControl"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Renglón Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaModPedSinControl">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="d-none">
                            <input type="text" id="ID" name="ID" readonly="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <label for="Pedido" >Pedido*</label>
                            <input type="text" class="form-control form-control-sm" id="Clave" name="Clave" readonly="" placeholder="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                            <label for="Cliente" >Cliente*</label>
                            <select class="form-control form-control-sm" id="Cliente" name="Cliente" required="" placeholder="">
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <label for="FechaPedido" >Fec-Pedido*</label>
                            <input type="text" id="FechaPedido" name="FechaPedido" class="form-control form-control-sm date notEnter" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <label for="FechaEntrega" >Fec-Entrega*</label>
                            <input type="text" id="FechaEntrega" name="FechaEntrega" class="form-control form-control-sm date notEnter">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                            <label for="Estilo" >Estilo*</label>
                            <select class="form-control form-control-sm" id="Estilo" name="Estilo" required placeholder="">
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
                            <label for="Color" >Color*</label>
                            <select class="form-control form-control-sm" id="Color" name="Color" required placeholder="">
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-1 col-xl-2">
                            <label for="Semana" >Año*</label>
                            <input type="text" id="Ano" name="Ano" class="form-control form-control-sm numbersOnly" maxlength="4">
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-1 col-xl-2">
                            <label for="Semana" >Sem*</label>
                            <input type="text" id="Semana" name="Semana" class="form-control form-control-sm numbersOnly" maxlength="2" onkeyup="onChecarSemanaValida(this)">
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-2">
                            <label for="Maquila" >Maq*</label>
                            <input type="text" id="Maquila" name="Maquila" class="form-control form-control-sm numbersOnly" maxlength="2">
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-2 col-xl-2">
                            <label for="Precio" >Precio*</label>
                            <input type="text" id="Precio" name="Precio" class="form-control form-control-sm numbersOnly" maxlength="8">
                        </div>
                        <div class="col-12">
                            <label for="Observaciones" >Observaciones*</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" id="Observacion" name="Observacion" class="form-control form-control-sm" placeholder="" maxlength="450">
                                </div>
                                <div class="col-6">
                                    <input type="text" id="ObservacionDetalle" name="ObservacionDetalle" class="form-control form-control-sm" placeholder="" maxlength="450">
                                </div>
                            </div>
                        </div>
                        <!--TALLAS-->
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12" >
                                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                                        <label class="font-weight-bold" for="Tallas">Tallas</label>
                                        <table id="tblTallas" class="Tallas" >
                                            <thead></thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                    for ($index = 1; $index < 23; $index++) {
                                                        print '<td><input type="text" style="width: 37px;" maxlength="4" class="numbersOnly" name="T' . $index . '" disabled></td>';
                                                    }
                                                    ?>
                                                    <td class="font-weight-bold">Pares</td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    for ($index = 1; $index < 23; $index++) {
                                                        print '<td><input type="text" style="width: 37px;" maxlength="4" class=" numbersOnly" name="C' . $index . '" onfocus="onCalcularPares(this);" on change="onCalcularPares(this);" keyup="onCalcularPares(this);" onfocusout="onCalcularPares(this);"></td>';
                                                    }
                                                    ?>
                                                    <td><input type="text" style="width: 40px;" maxlength="4" class=" numbersOnly font-weight-bold" readonly="" name="Pares" id="Pares"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlObsPedidoModificaEliminaPedidoSinControl = $('#mdlObsPedidoModificaEliminaPedidoSinControl');
    $(document).ready(function () {
        mdlObsPedidoModificaEliminaPedidoSinControl.on('shown.bs.modal', function () {
            handleEnterDiv(mdlObsPedidoModificaEliminaPedidoSinControl);
            mdlObsPedidoModificaEliminaPedidoSinControl.find("input").val("");
            $.each(mdlObsPedidoModificaEliminaPedidoSinControl.find("select"), function (k, v) {
                mdlObsPedidoModificaEliminaPedidoSinControl.find("select")[k].selectize.clear(true);
            });
            getDatosPedidoDetalle(id_pedidoDetalle);
        });
        mdlObsPedidoModificaEliminaPedidoSinControl.find('#btnAceptar').click(function () {
            isValid('pnlCapturaModPedSinControl');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlObsPedidoModificaEliminaPedidoSinControl.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ModificaEliminaPedidoSinControl/onModificar',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    HoldOn.close();
                    mdlObsPedidoModificaEliminaPedidoSinControl.modal("hide");
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
        mdlObsPedidoModificaEliminaPedidoSinControl.find("#Maquila").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlObsPedidoModificaEliminaPedidoSinControl.find("#Semana").change(function () {
            var ano = mdlObsPedidoModificaEliminaPedidoSinControl.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlObsPedidoModificaEliminaPedidoSinControl.find("#Ano").keydown(function (e) {
            if (e.keyCode === 13)
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: false,
                        timer: 1000
                    }).then((action) => {
                        mdlObsPedidoModificaEliminaPedidoSinControl.find("#Ano").val("");
                        mdlObsPedidoModificaEliminaPedidoSinControl.find("#Ano").focus();
                    });
                }
        });
    });
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
    function getDatosPedidoDetalle(ID) {
        $.getJSON(base_url + 'index.php/ModificaEliminaPedidoSinControl/getPedidosByID', {ID: ID}).done(function (data) {
            var dt = data[0];//Encabezado

            $.getJSON(base_url + 'index.php/ModificaEliminaPedidoSinControl/getClientes').done(function (data) {
                $.each(data, function (k, v) {
                    mdlObsPedidoModificaEliminaPedidoSinControl.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
                });
                mdlObsPedidoModificaEliminaPedidoSinControl.find("#Cliente")[0].selectize.setValue(dt.Cliente);
                mdlObsPedidoModificaEliminaPedidoSinControl.find('#Cliente')[0].selectize.focus();
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });

            $.getJSON(base_url + 'index.php/ModificaEliminaPedidoSinControl/getEstilos').done(function (data) {
                $.each(data, function (k, v) {
                    mdlObsPedidoModificaEliminaPedidoSinControl.find("#Estilo")[0].selectize.addOption({text: v.Estilo, value: v.Clave});
                });
                mdlObsPedidoModificaEliminaPedidoSinControl.find("#Estilo")[0].selectize.setValue(dt.Estilo);
                mdlObsPedidoModificaEliminaPedidoSinControl.find('#Cliente')[0].selectize.focus();
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });

            $.getJSON(base_url + 'index.php/ModificaEliminaPedidoSinControl/getColoresByEstilo', {Estilo: dt.Estilo}).done(function (data) {
                $.each(data, function (k, v) {
                    mdlObsPedidoModificaEliminaPedidoSinControl.find("#Color")[0].selectize.addOption({text: v.Color, value: v.Clave});
                });
                mdlObsPedidoModificaEliminaPedidoSinControl.find("#Color")[0].selectize.setValue(dt.Color);
                mdlObsPedidoModificaEliminaPedidoSinControl.find('#Cliente')[0].selectize.focus();
            }).fail(function (x) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });

            $.each(data[0], function (k, v) {
                if (!mdlObsPedidoModificaEliminaPedidoSinControl.find("[name='" + k + "']").is('select')) {
                    mdlObsPedidoModificaEliminaPedidoSinControl.find("[name='" + k + "']").val(v);
                }
            });

        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onCalcularPares(e) {
        var total_pares = 0;
        $.each(mdlObsPedidoModificaEliminaPedidoSinControl.find("#tblTallas input[name*='C']"), function (k, v) {
            total_pares += (parseInt($(v).val()) > 0) ? parseInt($(v).val()) : 0;
            mdlObsPedidoModificaEliminaPedidoSinControl.find("#Pares").val(total_pares);
        });
    }
</script>