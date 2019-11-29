<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left">Captura Inventario Inicial Fiscal de Materia Prima</legend>
            </div>
            <div class="col-sm-3" align="right">

                <button type="button" class="btn btn-warning btn-sm " id="btnImprimirInv" >
                    <span class="fa fa-file-pdf" ></span> IMPRIMIR INV.
                </button>

            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-4 col-md-3 col-xl-3" >
                <label>Material</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Articulo" name="Articulo" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sArticulo" name="sArticulo" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >U.M.</label>
                <input type="text" class="form-control form-control-sm" disabled="" maxlength="3" id="Unidad" name="Unidad">
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Precio</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="Pinvini" name="Pinvini" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Existencia</label>
                <input type="text" class="form-control form-control-sm numbersOnly " id="Invini" name="Invini" maxlength="15" required>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnGuardar">
                    <i class="fa fa-save"></i> ACEPTAR
                </button>
            </div>
        </div>
        <div class="row" id="Detalle">
            <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                <label for="" >Mes Inventario</label>
                <select id="Mes" name="Mes" class="form-control form-control-sm" >
                    <option value=""></option>
                    <option value="Ene">1 ENERO</option>
                    <option value="Feb">2 FEBRERO</option>
                    <option value="Mar">3 MARZO</option>
                    <option value="Abr">4 ABRIL</option>
                    <option value="May">5 MAYO</option>
                    <option value="Jun">6 JUNIO</option>
                    <option value="Jul">7 JULIO</option>
                    <option value="Ago">8 AGOSTO</option>
                    <option value="Sep">9 SEPTIEMBRE</option>
                    <option value="Oct">10 OCTUBRE</option>
                    <option value="Nov">11 NOVIEMBRE</option>
                    <option value="Dic">12 DICIEMBRE</option>
                </select>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1">
                <label for="" >&nbsp;</label>
                <button type="button" class="btn btn-success btn-sm" id="btnCerrarInv">
                    <i class="fa fa-check"></i> CERRAR INVENTARIO
                </button>
            </div>

        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/InicialMaterialPrima/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var btnCerrarInv = pnlTablero.find('#btnCerrarInv');
    var btnImprimirInv = pnlTablero.find('#btnImprimirInv');
    $(document).ready(function () {




        /*FUNCIONES INICIALES*/
        pnlTablero.find("#Articulo").focus();
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#sArticulo', '#Precio', pnlTablero);
        setFocusSelectToInputOnChange('#Mes', '#btnCerrarInv', pnlTablero);
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        getMateriales();
        pnlTablero.find('#Articulo').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(master_url + 'onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sArticulo")[0].selectize.addItem(txtart, true);
                            getDatosByMaterial(txtart);

                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                pnlTablero.find('#Articulo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sArticulo").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#Articulo").val($(this).val());
                getDatosByMaterial($(this).val());
            }
        });
        pnlTablero.find("#Pinvini").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                pnlTablero.find("#Invini").focus().select();
            }
        });

        pnlTablero.find("#Invini").keypress(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                btnGuardar.focus();
            }
        });

        btnGuardar.click(function () {
            btnGuardar.attr('disabled', true);
            isValid('pnlTablero');
            if (valido) {
                var mat = pnlTablero.find("#Clave").val();
                var pinvini = pnlTablero.find("#Pinvini").val();
                var invini = pnlTablero.find('#Invini').val();
                $.post(master_url + 'onModificar', {
                    Clave: mat,
                    Pinvini: pinvini,
                    Invini: invini
                }).done(function (data) {
                    btnGuardar.attr('disabled', false);
                    onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                    pnlTablero.find("input").val("");
                    $.each(pnlTablero.find("select"), function (k, v) {
                        pnlTablero.find("select")[k].selectize.clear(true);
                    });
                    pnlTablero.find("#Clave")[0].selectize.focus();
                }).fail(function (x, y, z) {
                    btnGuardar.attr('disabled', false);
                    console.log(x, y, z);
                });
            } else {
                btnGuardar.attr('disabled', false);
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });

        btnCerrarInv.click(function () {
            if (pnlTablero.find("#Mes").val() !== '') {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estas Seguro?',
                    text: "Esta acción capturará el inv. incial en el mes que seleccionaste",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var mes = pnlTablero.find("#Mes").val();
                        $.post(master_url + 'onCerrarInv', {
                            Mes: mes,
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'INVENTARIO CERRADO', 'info');
                            pnlTablero.find("input").val("");
                            $.each(pnlTablero.find("select"), function (k, v) {
                                pnlTablero.find("select")[k].selectize.clear(true);
                            });
                            pnlTablero.find("#Clave")[0].selectize.focus();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN MES",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#Mes")[0].selectize.focus();
                });
            }
        });

        btnImprimirInv.click(function () {
            //HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
            $.get(master_url + 'onImprimirInvIni').done(function (data) {
                console.log(data);

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
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
    });
    function getDatosByMaterial(mat) {
        $.getJSON(master_url + 'getDatosByMaterial', {
            Material: mat
        }).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find('#Pinvini').val(data[0].Pinvini);
                pnlTablero.find('#Invini').val(data[0].Invini);
                pnlTablero.find('#Unidad').val(data[0].Unidad);
                pnlTablero.find('#Pinvini').focus().select();
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getMateriales() {
        $.when($.getJSON(master_url + 'getMateriales').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sArticulo")[0].selectize.addOption({text: v.Material, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        })).then(function (x) {
            HoldOn.close();
        });

    }
</script>



