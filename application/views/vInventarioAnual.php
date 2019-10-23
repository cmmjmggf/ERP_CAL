<div class="modal " id="mdlInventarioAnual"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inventario Anual de Materia Prima por Mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">


                    <div class="row">
                        <div class="col-12">
                            <label>Almacen/Maquila <span class="badge badge-warning mb-2" style="font-size: 12px;">Sólo Almacén [1] y Sub-Almacén [97]</span></label>
                            <select class="form-control form-control-sm required" id="Maq" name="Maq" >
                                <option value=""></option>
                                <option value="articulos">1 Almacén General</option>
                                <option value="articulos10">97 Sub Almacén</option>
                            </select>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptar">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlInventarioAnual = $('#mdlInventarioAnual');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlInventarioAnual);
        setFocusSelectToInputOnChange('#Maq', '#btnAceptar', mdlInventarioAnual);
        mdlInventarioAnual.on('shown.bs.modal', function () {
            handleEnterDiv(mdlInventarioAnual);
            mdlInventarioAnual.find("input").val("");
            $.each(mdlInventarioAnual.find("select"), function (k, v) {
                mdlInventarioAnual.find("select")[k].selectize.clear(true);
            });
            mdlInventarioAnual.find('#Maq')[0].selectize.focus();
        });

        mdlInventarioAnual.find('#btnAceptar').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlInventarioAnual.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/CapturaInventarios/onReporteExistenciasAnualPorMes',
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
                        mdlInventarioAnual.find('#Maq')[0].selectize.focus();
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


