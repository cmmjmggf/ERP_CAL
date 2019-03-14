<div class="modal " id="mdlEtiquetasInventario"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Etiquetas para inventario Materia Prima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-6 col-sm-6 ">
                            <label for="" >Del Grupo*</label>
                            <select id="Grupo" name="Grupo" class="form-control form-control-sm required" required="">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-6 ">
                            <label for="" >Al Grupo*</label>
                            <select id="aGrupo" name="aGrupo" class="form-control form-control-sm required" required="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label class="badge badge-danger" style="font-size: 14px;">
                                Nota: Sólo se imprimen articulos con existencia mayor a 0
                            </label>
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
    var mdlEtiquetasInventario = $('#mdlEtiquetasInventario');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlEtiquetasInventario);
        setFocusSelectToSelectOnChange('#Grupo', '#aGrupo', mdlEtiquetasInventario);
        mdlEtiquetasInventario.on('shown.bs.modal', function () {
            mdlEtiquetasInventario.find("input").val("");
            $.each(mdlEtiquetasInventario.find("select"), function (k, v) {
                mdlEtiquetasInventario.find("select")[k].selectize.clear(true);
            });
            getGrupos();
            mdlEtiquetasInventario.find('#Grupo')[0].selectize.focus();
        });

        mdlEtiquetasInventario.find('#btnAceptar').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEtiquetasInventario.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/CapturaInventarios/onReporteEtiquetas',
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
                        mdlEtiquetasInventario.find('#Maq')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
    });


    function getGrupos() {
        $.getJSON(base_url + 'index.php/Articulos/getGrupos').done(function (data) {
            $.each(data, function (k, v) {
                mdlEtiquetasInventario.find("#Grupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
                mdlEtiquetasInventario.find("#aGrupo")[0].selectize.addOption({text: v.Grupo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        }).always(function () {

        });
    }
</script>
