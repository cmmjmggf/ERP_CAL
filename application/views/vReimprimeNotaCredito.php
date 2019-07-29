<div class="modal " id="mdlReimprimeNotaCredito"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reimprime Nota de Crédito</h5>
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
                            <label for="" >Cliente</label>
                            <select id="Cliente" name="Cliente" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 col-md-5" >
                            <label for="" >Nota</label>
                            <select id="NotaCredito" name="NotaCredito" class="form-control form-control-sm mb-2 required" required="" >
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
    var mdlReimprimeNotaCredito = $('#mdlReimprimeNotaCredito');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlReimprimeNotaCredito);
        mdlReimprimeNotaCredito.on('shown.bs.modal', function () {
            mdlReimprimeNotaCredito.find("input").val("");
            $.each(mdlReimprimeNotaCredito.find("select"), function (k, v) {
                mdlReimprimeNotaCredito.find("select")[k].selectize.clear(true);
            });
            getClientesReimprimeNC();
            mdlReimprimeNotaCredito.find('#Tp').focus();
        });
        mdlReimprimeNotaCredito.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                var tp = parseInt($(this).val());
                if (tp === 1 || tp === 2) {
                    mdlReimprimeNotaCredito.find('#Cliente')[0].selectize.focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        $(this).val('').focus();
                    });
                }
            }
        });
        mdlReimprimeNotaCredito.find("#Cliente").change(function () {
            if ($(this).val()) {
                var tp = mdlReimprimeNotaCredito.find("#Tp").val();
                $.getJSON(base_url + 'index.php/NotaCreditoClientes/getNotasByTpByCliente', {
                    Tp: tp,
                    Cliente: $(this).val()
                }).done(function (data) {
                    mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                    mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clearOptions();
                    if (data.length > 0) {//Existe
                        $.each(data, function (k, v) {
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.addOption({text: v.nc, value: v.nc});
                        });
                        mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.open();
                    } else {//NO TIENE DOCUMENTOS PENDIENTES DE PAGO
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN NOTAS DE CREDITO PARA ESTE CLIENTE/TP",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.clear(true);
                            mdlReimprimeNotaCredito.find("#NotaCredito")[0].selectize.focus();
                        });
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        mdlReimprimeNotaCredito.find("#NotaCredito").change(function () {
            if ($(this).val()) {
                mdlReimprimeNotaCredito.find('#btnImprimir').focus();
            }
        });
        mdlReimprimeNotaCredito.find('#btnImprimir').on("click", function () {
            var tp = mdlReimprimeNotaCredito.find("#Tp").val();
            var folio = mdlReimprimeNotaCredito.find("#NotaCredito").val();
            var cte = mdlReimprimeNotaCredito.find("#Cliente").val();
            onImprimirReporteNotaCredito(tp, folio, cte);
        });

    });


    function onImprimirReporteNotaCredito(tp, folio, cte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        $.post(base_url + 'index.php/NotaCreditoClientes/onImprimirReporteNotaCredito', {
            Tp: tp,
            Folio: folio,
            Cliente: cte
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

    function getClientesReimprimeNC() {
        mdlReimprimeNotaCredito.find("#Cliente")[0].selectize.clear(true);
        mdlReimprimeNotaCredito.find("#Cliente")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/PagosConCincoDescuento/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlReimprimeNotaCredito.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
