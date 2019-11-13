<div class="modal" id="mdlGeneraPreciosMaquila"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera costo maq-1 lo que está en producción, o por estilo-color</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmGeneraPreciosMaquilas">
                    <div class="row">
                        <div class="col-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-2">
                            <label>Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2" >
                            <label for="" >Estilo</label>
                            <input type="text" class="form-control form-control-sm " maxlength="7"  id="Estilo" name="Estilo"   >
                        </div>
                        <div class="col-2" >
                            <label for="" >Color</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2"  id="Color" name="Color"   >
                        </div>
                        <div class="col-8">
                            <label for="">-</label>
                            <select class="form-control form-control-sm required selectize" id="sColor" name="sColor" required="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 mt-2">
                            <legend class="badge badge-danger text-white" style="font-size: 14px;">Para generar lo que está en proceso captura el AÑO-SEMANA<br><br>
                                Para generar por estilo, sólo capture el ESTILO-COLOR
                            </legend>
                        </div>
                        <div class="col-12 col-sm-12 mt-2">
                            <legend class="badge badge-info text-white" style="font-size: 14px;">
                                El precio es calculado en base a la FICHA TÉCNICA, incluye MANO DE OBRA
                            </legend>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGenerar">GENERAR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
<script>

    var mdlGeneraPreciosMaquila = $('#mdlGeneraPreciosMaquila');
    $(document).ready(function () {

        mdlGeneraPreciosMaquila.find("#Estilo").keydown(function (e) {
            if (e.keyCode === 13) {
                var Estilo = $(this).val();
                if (Estilo) {
                    $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {Clave: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlGeneraPreciosMaquila.find("#sColor")[0].selectize.clear(true);
                            mdlGeneraPreciosMaquila.find("#sColor")[0].selectize.clearOptions();
                            getColoresXEstiloReporte(Estilo);
                            mdlGeneraPreciosMaquila.find("#Color").focus().select();
                        } else {
                            swal('ERROR', 'ESTILO NO EXISTE', 'warning').then((value) => {
                                mdlGeneraPreciosMaquila.find('#Estilo').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlGeneraPreciosMaquila.find("#Color").keydown(function (e) {
            if (e.keyCode === 13) {
                var Color = $(this).val();
                var Estilo = mdlGeneraPreciosMaquila.find("#Estilo").val();
                if (Color) {
                    $.getJSON(base_url + 'index.php/GeneraPreciosMaquilas/onComprobarEstiloColor', {Color: Color, Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlGeneraPreciosMaquila.find("#sColor")[0].selectize.addItem(Color, true);
                            mdlGeneraPreciosMaquila.find("#btnGenerar").focus();
                        } else {
                            swal('ERROR', 'EL COLOR NO EXISTE', 'warning').then((value) => {
                                mdlGeneraPreciosMaquila.find('#Color').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlGeneraPreciosMaquila.find("#Ano").keydown(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        mdlGeneraPreciosMaquila.find("#Ano").val("");
                        mdlGeneraPreciosMaquila.find("#Ano").focus();
                    });
                }
            }
        });

        mdlGeneraPreciosMaquila.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = mdlGeneraPreciosMaquila.find("#Ano");
                    onComprobarSemanasProduccion($(this), ano.val());
                }
            }
        });

        mdlGeneraPreciosMaquila.find("#sColor").change(function () {
            if ($(this).val()) {
                mdlGeneraPreciosMaquila.find("#Color").val($(this).val());
                mdlGeneraPreciosMaquila.find("#Maquila").focus().select();
            }
        });

        mdlGeneraPreciosMaquila.on('shown.bs.modal', function () {
            getMaquilasCostosEstilos();
            mdlGeneraPreciosMaquila.find("input").val("");
            $.each(mdlGeneraPreciosMaquila.find("select"), function (k, v) {
                mdlGeneraPreciosMaquila.find("select")[k].selectize.clear(true);
            });
            mdlGeneraPreciosMaquila.find('#Ano').val(getYear()).focus().select();
        });

        mdlGeneraPreciosMaquila.find('#btnGenerar').on("click", function () {
            mdlGeneraPreciosMaquila.find('#btnGenerar').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData($('#mdlGeneraPreciosMaquila').find("#frmGeneraPreciosMaquilas")[0]);
            $.ajax({
                url: base_url + 'index.php/GeneraPreciosMaquilas/onGeneraPreciosMaquilas',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                mdlGeneraPreciosMaquila.find('#btnGenerar').attr('disabled', false);
                if (data === '0') {
                    swal('ERROR', 'LOS SIGUIENTES ESTILOS, NO EXISTEN, O NO TIENEN SU FICHA TÉCNICA', 'warning').then((value) => {
                        mdlGeneraPreciosMaquila.find('#btnGenerar').focus();
                    });
                } else if (data === '1') {
                    swal('ERROR', 'NO EXISTEN CONTROLES PARA COSTEO EN PRODUCCIÓN DE LA MAQUILA 1', 'warning').then((value) => {
                        mdlGeneraPreciosMaquila.find('#btnGenerar').focus();
                    });
                } else {
                    swal('ATENCIÓN', 'PROCESO TERMINADO CORRECTAMENTE', 'success').then((value) => {
                        mdlGeneraPreciosMaquila.modal('hide');
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
                mdlGeneraPreciosMaquila.find('#btnGenerar').attr('disabled', false);
            });
        });
    });
    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlGeneraPreciosMaquila.find("#Estilo").focus().select();
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
    function getColoresXEstiloReporte(Estilo) {
        $.getJSON(base_url + 'index.php/GeneraPreciosMaquilas/getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlGeneraPreciosMaquila.find("#sColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

</script>