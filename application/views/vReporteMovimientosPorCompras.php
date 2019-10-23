<div class="modal " id="mdlReporteMovimientosPorCompras"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entradas por Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-3">
                            <label>Tp</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" id="TpDoc" name="TpDoc" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" >Proveedor*</label>
                            <select id="Proveedor" name="Proveedor" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Doc</label>
                            <select id="Doc" name="Doc" class="form-control form-control-sm mb-2 required" required="" >
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
    var mdlReporteMovimientosPorCompras = $('#mdlReporteMovimientosPorCompras');
    $(document).ready(function () {
        mdlReporteMovimientosPorCompras.on('shown.bs.modal', function () {
            handleEnterDiv(mdlReporteMovimientosPorCompras);
            mdlReporteMovimientosPorCompras.find("input").val("");
            $.each(mdlReporteMovimientosPorCompras.find("select"), function (k, v) {
                mdlReporteMovimientosPorCompras.find("select")[k].selectize.clear(true);
            });
            mdlReporteMovimientosPorCompras.find('#TpDoc').focus();
        });

        mdlReporteMovimientosPorCompras.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReporteMovimientosPorCompras.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/RecibeOrdenCompra/onImprimirValeEntrada',
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
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlReporteMovimientosPorCompras.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });

        mdlReporteMovimientosPorCompras.find("#TpDoc").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 1 || tp === 2) {
                mdlReporteMovimientosPorCompras.find("#Proveedor")[0].selectize.focus();
                getProveedoresEntComp(tp);
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

        mdlReporteMovimientosPorCompras.find("#Proveedor").change(function () {
            var tp = mdlReporteMovimientosPorCompras.find("#TpDoc").val();
            $.getJSON(base_url + 'index.php/NotasCargo/getDocsByTpByProveedor', {
                Tp: tp,
                Proveedor: $(this).val()
            }).done(function (data) {
                mdlReporteMovimientosPorCompras.find("#Doc")[0].selectize.clear(true);
                mdlReporteMovimientosPorCompras.find("#Doc")[0].selectize.clearOptions();
                if (data.length > 0) {//Existe
                    $.each(data, function (k, v) {
                        mdlReporteMovimientosPorCompras.find("#Doc")[0].selectize.addOption({text: v.Doc, value: v.Doc});
                    });
                    mdlReporteMovimientosPorCompras.find("#Doc")[0].selectize.open();
                } else {//NO TIENE DOCUMENTOS
                    $.notify({
                        // options
                        icon: 'fa fa-exclamation',
                        title: 'Atención',
                        message: 'PROVEEDOR/TP NO TIENE DOCUMENTOS'
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

    function getProveedoresEntComp(tp) {
        mdlReporteMovimientosPorCompras.find("#Proveedor")[0].selectize.clear(true);
        mdlReporteMovimientosPorCompras.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/OrdenCompra/getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlReporteMovimientosPorCompras.find("#Proveedor")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>