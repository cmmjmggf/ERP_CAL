<div class="modal " id="mdlAntiguedadSaldosProveedores"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta General</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEdoCta">

                    <div class="row">
                        <div class="col-4">
                            <label>Tp <span class="badge badge-warning mb-2" style="font-size: 12px;">Para consultar todo deja en blanco</span></label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly" id="Tp" name="Tp" >
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <label>Del Proveedor:</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="dProveedorEdoCtaGen" name="Proveedor" maxlength="5" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sdProveedorEdoCtaGen" name="sdProveedorEdoCtaGen" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Al Proveedor:</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="aProveedorEdoCtaGen" name="aProveedor" maxlength="5" required="">
                                </div>
                                <div class="col-9">
                                    <select id="saProveedorEdoCtaGen" name="saProveedorEdoCtaGen" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-success" id="btnImprimirExt">EXTENDIDO</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url_repantigue = base_url + 'index.php/ReportesProveedores/';
    var mdlAntiguedadSaldosProveedores = $('#mdlAntiguedadSaldosProveedores');

    $(document).ready(function () {
        mdlAntiguedadSaldosProveedores.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlAntiguedadSaldosProveedores.on('shown.bs.modal', function () {
            mdlAntiguedadSaldosProveedores.find("input").val("");
            $.each(mdlAntiguedadSaldosProveedores.find("select"), function (k, v) {
                mdlAntiguedadSaldosProveedores.find("select")[k].selectize.clear(true);
            });
            getProveedoresEdoCtaReporteAntiguedad();
            mdlAntiguedadSaldosProveedores.find('#Tp').focus();
        });
        mdlAntiguedadSaldosProveedores.find('#btnImprimir').on("click", function () {
            mdlAntiguedadSaldosProveedores.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlAntiguedadSaldosProveedores.find("#frmEdoCta")[0]);
            $.ajax({
                url: master_url_repantigue + 'onReporteAntiguedadSaldos',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                mdlAntiguedadSaldosProveedores.find('#btnImprimir').attr('disabled', false);
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
                                    width: "95%",
                                    height: "95%"
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
                        text: "NO EXISTEN DOCUMENTOS PARA ESTE PROVEEDOR",
                        icon: "error"
                    }).then((action) => {
                        mdlAntiguedadSaldosProveedores.find('#btnImprimir').attr('disabled', false);
                        mdlAntiguedadSaldosProveedores.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                mdlAntiguedadSaldosProveedores.find('#btnImprimir').attr('disabled', false);
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlAntiguedadSaldosProveedores.find('#btnImprimirExt').on("click", function () {
            mdlAntiguedadSaldosProveedores.find('#btnImprimirExt').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlAntiguedadSaldosProveedores.find("#frmEdoCta")[0]);
            $.ajax({
                url: master_url_repantigue + 'onReporteAntiguedadSaldosExt',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                mdlAntiguedadSaldosProveedores.find('#btnImprimirExt').attr('disabled', false);
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
                                    width: "95%",
                                    height: "95%"
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
                        text: "NO EXISTEN DOCUMENTOS PARA ESTE PROVEEDOR",
                        icon: "error"
                    }).then((action) => {
                        mdlAntiguedadSaldosProveedores.find('#btnImprimirExt').attr('disabled', false);
                        mdlAntiguedadSaldosProveedores.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                mdlAntiguedadSaldosProveedores.find('#btnImprimirExt').attr('disabled', false);
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlAntiguedadSaldosProveedores.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpEdoCtaGen($(this));
                } else {
                    mdlAntiguedadSaldosProveedores.find("#dProveedorEdoCtaGen").focus();
                }
            }
        });
        mdlAntiguedadSaldosProveedores.find('#dProveedorEdoCtaGen').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url_repantigue + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            mdlAntiguedadSaldosProveedores.find("#sdProveedorEdoCtaGen")[0].selectize.addItem(txtprov, true);
                            mdlAntiguedadSaldosProveedores.find('#aProveedorEdoCtaGen').focus().select();
                        } else {
                            mdlAntiguedadSaldosProveedores.find('#aProveedorEdoCtaGen').focus().select();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlAntiguedadSaldosProveedores.find("#sdProveedorEdoCtaGen").change(function () {
            if ($(this).val()) {
                mdlAntiguedadSaldosProveedores.find("#dProveedorEdoCtaGen").val($(this).val());
                mdlAntiguedadSaldosProveedores.find("#aProveedorEdoCtaGen").focus();
            }
        });
        mdlAntiguedadSaldosProveedores.find('#aProveedorEdoCtaGen').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url_repantigue + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            mdlAntiguedadSaldosProveedores.find("#saProveedorEdoCtaGen")[0].selectize.addItem(txtprov, true);
                            mdlAntiguedadSaldosProveedores.find('#btnImprimir').focus();
                        } else {
                            mdlAntiguedadSaldosProveedores.find('#btnImprimir').focus();
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlAntiguedadSaldosProveedores.find("#saProveedorEdoCtaGen").change(function () {
            if ($(this).val()) {
                mdlAntiguedadSaldosProveedores.find("#aProveedorEdoCtaGen").val($(this).val());
                mdlAntiguedadSaldosProveedores.find('#Tp').focus();
            }
        });
    });

    function onVerificarTpEdoCtaGen(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlAntiguedadSaldosProveedores.find("#dProveedorEdoCtaGen").focus();

        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }

    function getProveedoresEdoCtaReporteAntiguedad() {
        mdlAntiguedadSaldosProveedores.find("#sdProveedorEdoCtaGen")[0].selectize.clear(true);
        mdlAntiguedadSaldosProveedores.find("#saProveedorEdoCtaGen")[0].selectize.clearOptions();
        $.getJSON(master_url_remota + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlAntiguedadSaldosProveedores.find("#sdProveedorEdoCtaGen")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
                mdlAntiguedadSaldosProveedores.find("#saProveedorEdoCtaGen")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>