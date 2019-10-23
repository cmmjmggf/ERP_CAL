<div class="modal " id="mdlCostoInvMatPrima"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Costo del inventario de Materia Prima</h5>
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
                    <div class="row">
                        <div class="col-12">
                            <label>Mes </label>
                            <select class="form-control form-control-sm required" id="Mes" name="Mes" >
                                <option value=""></option>
                                <option value="Ene">1 Enero</option>
                                <option value="Feb">2 Febrero</option>
                                <option value="Mar">3 Marzo</option>
                                <option value="Abr">4 Abril</option>
                                <option value="May">5 Mayo</option>
                                <option value="Jun">6 Junio</option>
                                <option value="Jul">7 Julio</option>
                                <option value="Ago">8 Agosto</option>
                                <option value="Sep">9 Septiembre</option>
                                <option value="Oct">10 Octubre</option>
                                <option value="Nov">11 Noviembre</option>
                                <option value="Dic">12 Diciembre</option>
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
    var mdlCostoInvMatPrima = $('#mdlCostoInvMatPrima');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlCostoInvMatPrima);
        setFocusSelectToSelectOnChange('#Maq', '#Mes', mdlCostoInvMatPrima);
        setFocusSelectToInputOnChange('#Mes', '#btnAceptar', mdlCostoInvMatPrima);
        mdlCostoInvMatPrima.on('shown.bs.modal', function () {
            handleEnterDiv(mdlCostoInvMatPrima);
            mdlCostoInvMatPrima.find("input").val("");
            $.each(mdlCostoInvMatPrima.find("select"), function (k, v) {
                mdlCostoInvMatPrima.find("select")[k].selectize.clear(true);
            });
            mdlCostoInvMatPrima.find('#Maq')[0].selectize.focus();
        });

        mdlCostoInvMatPrima.find('#btnAceptar').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlCostoInvMatPrima.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/CapturaInventarios/onReporteCostoInv',
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
                        mdlCostoInvMatPrima.find('#Maq')[0].selectize.focus();
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
