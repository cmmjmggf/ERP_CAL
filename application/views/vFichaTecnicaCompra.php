<div class="modal animated flipInY" id="mdlFichaTecnicaCompra"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprimir Ficha Técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmFichaTecnicaCompras">
                    <div class="row">

                        <div class="col-3" >
                            <label for="" >Estilo</label>
                            <input type="text" class="form-control form-control-sm " maxlength="6"  id="Estilo" name="Estilo"   >
                        </div>
                        <div class="col-7" ></div>
                        <div class="col-2">
                            <label>Piezas</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm disabledForms" id="Piezas" name="Piezas" >
                        </div>
                        <div class="w-100"></div>
                        <div class="col-3" >
                            <label for="" >Color</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2"  id="Color" name="Color"   >
                        </div>
                        <div class="col-9">
                            <label for="">-</label>
                            <select class="form-control form-control-sm required selectize" id="sColor" name="sColor" required="">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-3" >
                            <label for="" >Maquila</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2"  id="Maquila" name="Maquila"   >
                        </div>
                        <div class="col-9">
                            <label>-</label>
                            <select class="form-control form-control-sm required selectize" id="sMaquila" name="sMaquila" required="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Mano de Obra</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm numbersOnly" id="ManoObra" name="ManoObra" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Gastos</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm numbersOnly" id="Gastos" name="Gastos"  >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Utilidad</label>
                            <input type="text" maxlength="6" class="form-control form-control-sm numbersOnly" id="Utilidad" name="Utilidad" >
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="text-danger">Ficha Sin Precios</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="FichaSinPrecios" name="FichaSinPrecios" >
                                <label class="custom-control-label" for="FichaSinPrecios"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>% Desperdicio</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly disabledForms" id="Desperdicio" name="Desperdicio" >
                        </div>
                        <div class="col-12 col-sm-8">
                            <br>
                            <label class="badge badge-info">Por piezas de estilo y maquila</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimirFichaTecnica">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
<script>

    var mdlFichaTecnicaCompra = $('#mdlFichaTecnicaCompra');
    $(document).ready(function () {

        mdlFichaTecnicaCompra.find("#Estilo").keypress(function (e) {
            if (e.keyCode === 13) {
                var Estilo = $(this).val();
                if (Estilo) {
                    $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {Clave: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaCompra.find("#Piezas").val(parseInt(data[0].PiezasCorte));
                            mdlFichaTecnicaCompra.find("#sColor")[0].selectize.clear(true);
                            mdlFichaTecnicaCompra.find("#sColor")[0].selectize.clearOptions();
                            getColoresXEstiloReporte(Estilo);
                            mdlFichaTecnicaCompra.find("#Color").focus().select();
                        } else {
                            swal('ERROR', 'ESTILO NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaCompra.find('#Estilo').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaCompra.find("#Color").keypress(function (e) {
            if (e.keyCode === 13) {
                var Color = $(this).val();
                var Estilo = mdlFichaTecnicaCompra.find("#Estilo").val();
                if (Color) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarEstiloColor', {Color: Color, Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaCompra.find("#sColor")[0].selectize.addItem(Color, true);
                            mdlFichaTecnicaCompra.find("#Maquila").focus().select();
                        } else {
                            swal('ERROR', 'EL COLOR NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaCompra.find('#Color').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaCompra.find("#sColor").change(function () {
            if ($(this).val()) {
                var Maquila = $(this).val();
                var Piezas = mdlFichaTecnicaCompra.find("#Piezas").val();
                mdlFichaTecnicaCompra.find("#Color").val($(this).val());
                getDesperdicioByMaquilaPiezas(Maquila, Piezas);
                mdlFichaTecnicaCompra.find("#Maquila").focus().select();
            }
        });

        mdlFichaTecnicaCompra.find("#Maquila").keypress(function (e) {
            if (e.keyCode === 13) {
                var Maquila = $(this).val();
                var Piezas = mdlFichaTecnicaCompra.find("#Piezas").val();
                if (Maquila) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarMaquila', {Maquila: Maquila}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaCompra.find("#sMaquila")[0].selectize.addItem(Maquila, true);
                            getDesperdicioByMaquilaPiezas(Maquila, Piezas);
                            mdlFichaTecnicaCompra.find("#ManoObra").focus().select();
                        } else {
                            swal('ERROR', 'LA MAQUILA NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaCompra.find('#Maquila').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaCompra.find("#sMaquila").change(function () {
            if ($(this).val()) {
                mdlFichaTecnicaCompra.find("#Maquila").val($(this).val());
                mdlFichaTecnicaCompra.find("#ManoObra").focus().select();
            }
        });

        mdlFichaTecnicaCompra.find("#ManoObra").keypress(function (e) {
            if (e.keyCode === 13) {
                mdlFichaTecnicaCompra.find("#Gastos").focus().select();
            }
        });

        mdlFichaTecnicaCompra.find("#Gastos").keypress(function (e) {
            if (e.keyCode === 13) {
                mdlFichaTecnicaCompra.find("#Utilidad").focus().select();
            }
        });

        mdlFichaTecnicaCompra.find("#Utilidad").keypress(function (e) {
            if (e.keyCode === 13) {
                mdlFichaTecnicaCompra.find("#FichaSinPrecios").focus();
            }
        });

        mdlFichaTecnicaCompra.find("#FichaSinPrecios").keypress(function (e) {
            if (e.keyCode === 13) {
                mdlFichaTecnicaCompra.find("#btnImprimirFichaTecnica").focus();
            }
        });




        mdlFichaTecnicaCompra.on('shown.bs.modal', function () {
            getMaquilasCostosEstilos();
            mdlFichaTecnicaCompra.find("input").val("");
            $.each(mdlFichaTecnicaCompra.find("select"), function (k, v) {
                mdlFichaTecnicaCompra.find("select")[k].selectize.clear(true);
            });
            mdlFichaTecnicaCompra.find('#Estilo').focus();
        });

        mdlFichaTecnicaCompra.find('#btnImprimirFichaTecnica').on("click", function () {
            mdlFichaTecnicaCompra.find('#btnImprimirFichaTecnica').attr('disabled', true);
            var TipoFicha = mdlFichaTecnicaCompra.find("#FichaSinPrecios")[0].checked ? 'onImprimirFichaTecnicaSinPrecios' : 'onImprimirFichaTecnicaCompra';
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData($('#mdlFichaTecnicaCompra').find("#frmFichaTecnicaCompras")[0]);
            var maq = mdlFichaTecnicaCompra.find("#sMaquila").find("option:selected").text();

            frm.append('NomMaquila', maq);
            $.ajax({
                url: base_url + 'index.php/FichaTecnicaCompra/' + TipoFicha,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                mdlFichaTecnicaCompra.find('#btnImprimirFichaTecnica').attr('disabled', false);
                if (data.length > 0) {
                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');
                            },
                            iframe: {
                                // Iframe template
                                tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                preload: true,
                                // Custom CSS styling for iframe wrapping element
                                // You can use this to set custom iframe dimensions
                                css: {
                                    width: "85%",
                                    height: "85%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });


                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "ESTILO NO VÁLIDO",
                        icon: "error"
                    }).then((action) => {
                        mdlFichaTecnicaCompra.find('#Estilo').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        //handleEnterDiv(mdlFichaTecnicaCompra);
    });

    function getMaquilasCostosEstilos() {
        $.getJSON(base_url + 'index.php/FichaTecnicaCompra/getMaquilas').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaCompra.find("#sMaquila")[0].selectize.addOption({text: v.Maquila, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getColoresXEstiloReporte(Estilo) {
        $.getJSON(base_url + 'index.php/FichaTecnicaCompra/getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaCompra.find("#sColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getDesperdicioByMaquilaPiezas(Maquila, Piezas) {
        $.getJSON(base_url + 'index.php/Maquilas/getMaquilaByClave', {Clave: Maquila}).done(function (data, x, jq) {
            if (data.length > 0) {
                if (Piezas <= 10) {
                    mdlFichaTecnicaCompra.find("#Desperdicio").val(parseFloat(data[0].PorExtra3a10));
                } else if (Piezas <= 14) {
                    mdlFichaTecnicaCompra.find("#Desperdicio").val(parseFloat(data[0].PorExtra11a14));
                } else if (Piezas <= 18) {
                    mdlFichaTecnicaCompra.find("#Desperdicio").val(parseFloat(data[0].PorExtra15a18));
                } else if (Piezas > 19) {
                    mdlFichaTecnicaCompra.find("#Desperdicio").val(parseFloat(data[0].PorExtra19a));
                }
            } else {
                mdlFichaTecnicaCompra.find("#Desperdicio").val('0')
            }

        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

</script>