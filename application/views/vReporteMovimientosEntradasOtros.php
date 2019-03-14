<div class="modal " id="mdlReporteMovimientosEntradasOtros"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entradas por Documento OTROS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-5">
                            <label>Doc</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" id="Doc" name="Doc" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" >Tipo</label>
                            <select id="Tipo" name="Tipo" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                                <option value="EPR">EPR - Entrada X Producción</option>
                                <option value="EAJ">EAJ - Entrada X Ajuste</option>
                                <option value="EDV">EDV - Entrada X Devolución</option>
                                <option value="ETR">ETR - Entrada X Traspaso</option>
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
    var mdlReporteMovimientosEntradasOtros = $('#mdlReporteMovimientosEntradasOtros');
    $(document).ready(function () {

        validacionSelectPorContenedor(mdlReporteMovimientosEntradasOtros);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlReporteMovimientosEntradasOtros);

        mdlReporteMovimientosEntradasOtros.on('shown.bs.modal', function () {
            mdlReporteMovimientosEntradasOtros.find("input").val("");
            $.each(mdlReporteMovimientosEntradasOtros.find("select"), function (k, v) {
                mdlReporteMovimientosEntradasOtros.find("select")[k].selectize.clear(true);
            });
            mdlReporteMovimientosEntradasOtros.find('#Doc').focus();
        });

        mdlReporteMovimientosEntradasOtros.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReporteMovimientosEntradasOtros.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onImprimirValeEntradaOTROS',
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
                        mdlReporteMovimientosEntradasOtros.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });


    });




</script>