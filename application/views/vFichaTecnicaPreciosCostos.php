<div class="modal animated flipInY" id="mdlFichaTecnicaPreciosCostos"  role="dialog">
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
                            <input type="text" class="form-control form-control-sm " maxlength="7"  id="Estilo" name="Estilo"   >
                        </div>
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

    var mdlFichaTecnicaPreciosCostos = $('#mdlFichaTecnicaPreciosCostos');
    $(document).ready(function () {

        mdlFichaTecnicaPreciosCostos.find("#Estilo").keypress(function (e) {
            if (e.keyCode === 13) {
                var Estilo = $(this).val();
                if (Estilo) {
                    $.getJSON(base_url + 'index.php/Estilos/getEstiloByClave', {Clave: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaPreciosCostos.find("#Piezas").val(parseInt(data[0].PiezasCorte));
                            mdlFichaTecnicaPreciosCostos.find("#sColor")[0].selectize.clear(true);
                            mdlFichaTecnicaPreciosCostos.find("#sColor")[0].selectize.clearOptions();
                            getColoresXEstiloReporte(Estilo);
                            mdlFichaTecnicaPreciosCostos.find("#Color").focus().select();
                        } else {
                            swal('ERROR', 'ESTILO NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaPreciosCostos.find('#Estilo').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaPreciosCostos.find("#Color").keypress(function (e) {
            if (e.keyCode === 13) {
                var Color = $(this).val();
                var Estilo = mdlFichaTecnicaPreciosCostos.find("#Estilo").val();
                if (Color) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarEstiloColor', {Color: Color, Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaPreciosCostos.find("#sColor")[0].selectize.addItem(Color, true);
                            mdlFichaTecnicaPreciosCostos.find("#Maquila").focus().select();
                        } else {
                            swal('ERROR', 'EL COLOR NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaPreciosCostos.find('#Color').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaPreciosCostos.find("#sColor").change(function () {
            if ($(this).val()) {
                mdlFichaTecnicaPreciosCostos.find("#Color").val($(this).val());
                mdlFichaTecnicaPreciosCostos.find("#Maquila").focus().select();
            }
        });

        mdlFichaTecnicaPreciosCostos.find("#Maquila").keypress(function (e) {
            if (e.keyCode === 13) {
                var Maquila = $(this).val();
                if (Maquila) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarMaquila', {Maquila: Maquila}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlFichaTecnicaPreciosCostos.find("#sMaquila")[0].selectize.addItem(Maquila, true);
                            mdlFichaTecnicaPreciosCostos.find("#btnImprimirFichaTecnica").focus();
                        } else {
                            swal('ERROR', 'LA MAQUILA NO EXISTE', 'warning').then((value) => {
                                mdlFichaTecnicaPreciosCostos.find('#Maquila').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlFichaTecnicaPreciosCostos.find("#sMaquila").change(function () {
            if ($(this).val()) {
                mdlFichaTecnicaPreciosCostos.find("#Maquila").val($(this).val());
                mdlFichaTecnicaPreciosCostos.find("#btnImprimirFichaTecnica").focus();
            }
        });

        mdlFichaTecnicaPreciosCostos.on('shown.bs.modal', function () {
            getMaquilasCostosEstilos();
            mdlFichaTecnicaPreciosCostos.find("input").val("");
            $.each(mdlFichaTecnicaPreciosCostos.find("select"), function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("select")[k].selectize.clear(true);
            });
            mdlFichaTecnicaPreciosCostos.find('#Estilo').focus();
        });

        mdlFichaTecnicaPreciosCostos.find('#btnImprimirFichaTecnica').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData($('#mdlFichaTecnicaPreciosCostos').find("#frmFichaTecnicaCompras")[0]);
            var maq = mdlFichaTecnicaPreciosCostos.find("#sMaquila").find("option:selected").text();

            frm.append('NomMaquila', maq);
            $.ajax({
                url: base_url + 'index.php/FichaTecnicaCompra/onImprimirFichaTecnicaCompra',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
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
                        mdlFichaTecnicaPreciosCostos.find('#Estilo').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function getMaquilasCostosEstilos() {
        $.getJSON(base_url + 'index.php/FichaTecnicaCompra/getMaquilas').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("#sMaquila")[0].selectize.addOption({text: v.Maquila, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getColoresXEstiloReporte(Estilo) {
        $.getJSON(base_url + 'index.php/FichaTecnicaCompra/getColoresXEstilo', {Estilo: Estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlFichaTecnicaPreciosCostos.find("#sColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

</script>