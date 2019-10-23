<div class="modal " id="mdlDevolucionesCompraFecha"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Devoluciones de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>Tp <span class="badge badge-info mb-2" style="font-size: 12px;">Dejar en blanco para todo</span></label>
                            <input type="text" class="form-control form-control-sm  numbersOnly" name="Tp"  id="Tp" maxlength="1" >
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
    var mdlDevolucionesCompraFecha = $('#mdlDevolucionesCompraFecha');
    $(document).ready(function () {
        mdlDevolucionesCompraFecha.on('shown.bs.modal', function () {
            handleEnterDiv(mdlDevolucionesCompraFecha);
            mdlDevolucionesCompraFecha.find("input").val("");
            $.each(mdlDevolucionesCompraFecha.find("select"), function (k, v) {
                mdlDevolucionesCompraFecha.find("select")[k].selectize.clear(true);
            });
            mdlDevolucionesCompraFecha.find('#FechaFin').val(getToday());
            mdlDevolucionesCompraFecha.find('#FechaIni').focus();
        });


        mdlDevolucionesCompraFecha.find("#Tp").change(function () {
            onVerificarTp($(this));
        });
        mdlDevolucionesCompraFecha.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlDevolucionesCompraFecha.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesCompras/onReporteDevolucionesCompra',
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
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlDevolucionesCompraFecha.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
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
</script>