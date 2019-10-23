<div class="modal " id="mdlMaterialRecibidoPedido"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Material Recibido vs Pedido</h5>
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
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6" >
                            <label for="" >Grupo</label>
                            <select id="Grupo" name="Grupo" class="form-control form-control-sm mb-2 required" required="" >
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
    var mdlMaterialRecibidoPedido = $('#mdlMaterialRecibidoPedido');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlMaterialRecibidoPedido);
        setFocusSelectToInputOnChange('#Grupo', '#btnImprimir', mdlMaterialRecibidoPedido);

        mdlMaterialRecibidoPedido.on('shown.bs.modal', function () {
            handleEnterDiv(mdlMaterialRecibidoPedido);
            getGruposMatRecibidoPedido();
            mdlMaterialRecibidoPedido.find("input").val("");
            $.each(mdlMaterialRecibidoPedido.find("select"), function (k, v) {
                mdlMaterialRecibidoPedido.find("select")[k].selectize.clear(true);
            });
            mdlMaterialRecibidoPedido.find('#FechaIni').val(getFirstDayMonth());
            mdlMaterialRecibidoPedido.find('#FechaFin').val(getToday());
            mdlMaterialRecibidoPedido.find('#FechaIni').focus();
        });

        mdlMaterialRecibidoPedido.find('#btnImprimir').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlMaterialRecibidoPedido.find("#frmCaptura")[0]);

            frm.append('NombreGrupo', mdlMaterialRecibidoPedido.find("#Grupo option:selected").text());

            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onReporteMaterialRecibidoPedido',
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
                        mdlMaterialRecibidoPedido.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });

    });

    function getGruposMatRecibidoPedido() {
        $.getJSON(base_url + 'index.php/DocDirecConAfectacion/getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                mdlMaterialRecibidoPedido.find("#Grupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>

