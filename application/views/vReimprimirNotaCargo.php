<div class="modal " id="mdlReimprimirNotaCargo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reimprime Nota de Cargo a Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-5">
                            <label for="Clave" >Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <label for="" >Proveedor</label>
                            <select id="Proveedor" name="Proveedor" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-5" >
                            <label for="" >Nota</label>
                            <select id="NotaCargo" name="NotaCargo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
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
    var mdlReimprimirNotaCargo = $('#mdlReimprimirNotaCargo');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlReimprimirNotaCargo);
        setFocusSelectToSelectOnChange('#Proveedor', '#NotaCargo', mdlReimprimirNotaCargo);
        setFocusSelectToInputOnChange('#NotaCargo', '#btnImprimir', mdlReimprimirNotaCargo);
        mdlReimprimirNotaCargo.on('shown.bs.modal', function () {
            mdlReimprimirNotaCargo.find("input").val("");
            $.each(mdlReimprimirNotaCargo.find("select"), function (k, v) {
                mdlReimprimirNotaCargo.find("select")[k].selectize.clear(true);
            });
            mdlReimprimirNotaCargo.find('#Tp').focus();
        });
        mdlReimprimirNotaCargo.find("#Tp").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 1 || tp === 2) {

                getProveedoresReimprimeNC(tp);
                mdlReimprimirNotaCargo.find('#Proveedor')[0].selectize.focus();
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
                    $(this).val('').focus();
                });
            }
        });
        mdlReimprimirNotaCargo.find('#btnImprimir').on("click", function () {
            var tp = mdlReimprimirNotaCargo.find("#Tp").val();
            var folio = mdlReimprimirNotaCargo.find("#NotaCargo").val();
            var prov = mdlReimprimirNotaCargo.find("#Proveedor").val();
            onImprimirReporteNotaCargo(tp, folio, prov);
        });
        mdlReimprimirNotaCargo.find("#Proveedor").change(function () {
            var tp = mdlReimprimirNotaCargo.find("#Tp").val();
            $.getJSON(base_url + 'index.php/NotasCargo/getNotasByTpByProveedor', {
                Tp: tp,
                Proveedor: $(this).val()
            }).done(function (data) {
                mdlReimprimirNotaCargo.find("#NotaCargo")[0].selectize.clear(true);
                mdlReimprimirNotaCargo.find("#NotaCargo")[0].selectize.clearOptions();
                if (data.length > 0) {//Existe
                    $.each(data, function (k, v) {
                        mdlReimprimirNotaCargo.find("#NotaCargo")[0].selectize.addOption({text: v.Nota, value: v.Nota});
                    });
                    mdlReimprimirNotaCargo.find("#NotaCargo")[0].selectize.open();
                } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                    $.notify({
                        // options
                        icon: 'fa fa-exclamation',
                        title: 'Atención',
                        message: 'PROVEEDOR NO TIENE NOTAS DE CARGO REGISTRADAS'
                    }, {
                        // settings
                        type: 'danger',
                        allow_dismiss: true,
                        newest_on_top: false,
                        showProgressbar: false,
                        delay: 3000,
                        timer: 1000,
                        placement: {
                            from: "bottom",
                            align: "left"
                        },
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
            });
        });
    });


    function onImprimirReporteNotaCargo(tp, folio, prov) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(base_url + 'index.php/NotasCargo/onImprimirReporteNotaCargo', {
            Tp: tp,
            Folio: folio,
            Proveedor: prov
        }).done(function (data, x, jq) {
            console.log(data);
            if (data.length > 0) {

                $.fancybox.open({
                    src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            console.info('done!');
                            init();
                        },
                        iframe: {
                            // Iframe template
                            tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                            preload: true,
                            // Custom CSS styling for iframe wrapping element
                            // You can use this to set custom iframe dimensions
                            css: {
                                width: "100%",
                                height: "100%"
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
                    text: "NO EXISTEN REGISTROS",
                    icon: "error"
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function getProveedoresReimprimeNC(tp) {
        mdlReimprimirNotaCargo.find("#Proveedor")[0].selectize.clear(true);
        mdlReimprimirNotaCargo.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/NotasCargo/getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlReimprimirNotaCargo.find("#Proveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
