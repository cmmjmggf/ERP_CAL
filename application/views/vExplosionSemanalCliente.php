<div class="modal " id="mdlExplosionSemanalCliente"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Explosión Semanal de Materiales por Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-12">
                            <label class="text-danger">Nota. El % extra (PIEL Y FORRO) se tomará del No. de piezas del Estilo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-9">
                            <label>Cliente</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly" id="ClienteExplosion" name="ClienteExplosion" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sClienteExplosion" name="sClienteExplosion" class="form-control form-control-sm required NotSelectize " required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-6">
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaq" name="aMaq" >
                        </div>
                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-6">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-sm-12">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                                <option value="0">80 SUELA C/ DESGLOSE</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="selectPiel">
                                <label class="custom-control-label text-info labelCheck" for="selectPiel">Con Selección de Piel</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="FaltanteCorte" >
                                <label class="custom-control-label text-info labelCheck" for="FaltanteCorte">Lo faltante X Cortar</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="SinClasifPorCliente" name="SinClasifPorCliente" >
                                <label class="custom-control-label text-info labelCheck" for="SinClasifPorCliente">S/ 1ras 2das 3ras</label>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 mt-2">
                            <legend class="badge badge-danger" style="font-size: 14px;">Para maquila 98 sale con precios de compra y venta</legend>
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
    var mdlExplosionSemanalCliente = $('#mdlExplosionSemanalCliente');
    $(document).ready(function () {
        mdlExplosionSemanalCliente.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(mdlExplosionSemanalCliente);
        setFocusSelectToInputOnChange('#sClienteExplosion', '#Maq', mdlExplosionSemanalCliente);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlExplosionSemanalCliente);
        mdlExplosionSemanalCliente.on('shown.bs.modal', function () {
            handleEnterDiv(mdlExplosionSemanalCliente);
            mdlExplosionSemanalCliente.find("input").val("");
            $.each(mdlExplosionSemanalCliente.find("select"), function (k, v) {
                mdlExplosionSemanalCliente.find("select")[k].selectize.clear(true);
            });
            getClientes();
            mdlExplosionSemanalCliente.find('#Ano').val(getYear()).focus();
        });

        mdlExplosionSemanalCliente.find('#ClienteExplosion').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(base_url + 'index.php/ExplosionesPorCliente/onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            mdlExplosionSemanalCliente.find("#sClienteExplosion")[0].selectize.addItem(txtcte, true);
                            mdlExplosionSemanalCliente.find('#Maq').focus().select();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                mdlExplosionSemanalCliente.find("#sClienteExplosion")[0].selectize.clear(true);
                                mdlExplosionSemanalCliente.find('#ClienteExplosion').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlExplosionSemanalCliente.find('#sClienteExplosion').change(function () {
            var txtcte = $(this).val();
            if (txtcte) {
                mdlExplosionSemanalCliente.find('#ClienteExplosion').val(txtcte);
                mdlExplosionSemanalCliente.find('#Maq').focus().select();
            }
        });

        mdlExplosionSemanalCliente.find('#btnImprimir').on("click", function () {
            onDisable(mdlExplosionSemanalCliente.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

            var Tipo = parseInt(mdlExplosionSemanalCliente.find('#Tipo').val());
            var Reporte = '';

            if (Tipo === 10 || Tipo === 80 || Tipo === 90) {
                Reporte = 'index.php/ExplosionesPorCliente/onReporteExplosionSemanaPorCliente';
            } else {
                Reporte = 'index.php/ExplosionesPorCliente/onReporteExplosionSemanaSuelaDesglose';
            }
            console.log(Reporte);
            var frm = new FormData(mdlExplosionSemanalCliente.find("#frmExplosion")[0]);
            var SinClasif = mdlExplosionSemanalCliente.find("#SinClasifPorCliente")[0].checked ? '1' : '0';

            frm.append('SinClasifPorCliente', SinClasif);

            $.ajax({
                url: base_url + Reporte,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                onEnable(mdlExplosionSemanalCliente.find('#btnImprimir'));
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
                        text: "NO EXISTEN PROGRAMACION DE LA SEMANA/MAQUILA",
                        icon: "error"
                    }).then((action) => {
                        onEnable(mdlExplosionSemanalCliente.find('#btnImprimir'));
                        mdlExplosionSemanalCliente.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlExplosionSemanalCliente.find('#btnImprimir'));
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlExplosionSemanalCliente.find("#Ano").change(function () {
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
                    mdlExplosionSemanalCliente.find("#Ano").val("");
                    mdlExplosionSemanalCliente.find("#Ano").focus();
                });
            }
        });
        mdlExplosionSemanalCliente.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanalCliente.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanalCliente.find("#Sem").change(function () {
            var ano = mdlExplosionSemanalCliente.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlExplosionSemanalCliente.find("#aSem").change(function () {
            var ano = mdlExplosionSemanalCliente.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
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

    function getClientes() {
        mdlExplosionSemanalCliente.find("#sClienteExplosion")[0].selectize.clear(true);
        mdlExplosionSemanalCliente.find("#sClienteExplosion")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ExplosionesPorCliente/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlExplosionSemanalCliente.find("#sClienteExplosion")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>

