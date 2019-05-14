<div class="modal " id="mdlParesEntregadosCalidadXMaq"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Controles Entregados por Maquila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-4">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
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


    var mdlParesEntregadosCalidadXMaq = $('#mdlParesEntregadosCalidadXMaq');

    $(document).ready(function () {

        mdlParesEntregadosCalidadXMaq.on('shown.bs.modal', function () {
            mdlParesEntregadosCalidadXMaq.find("input").val("");
            $.each(mdlParesEntregadosCalidadXMaq.find("select"), function (k, v) {
                mdlParesEntregadosCalidadXMaq.find("select")[k].selectize.clear(true);
            });

            mdlParesEntregadosCalidadXMaq.find('#FechaIni').val(getFirstDayMonth());
            mdlParesEntregadosCalidadXMaq.find('#FechaFin').val(getLastDayMonth());
            mdlParesEntregadosCalidadXMaq.find('#FechaIni').focus();
        });
        mdlParesEntregadosCalidadXMaq.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlParesEntregadosCalidadXMaq.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/onReporteControlesEntXMaquila',
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
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlParesEntregadosCalidadXMaq.find('#Articulo')[0].selectize.focus();
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