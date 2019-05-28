<div class="modal " id="mdlComparativoInvFisInvSis"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte de comparación Inv. físico VS Inv. sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">[10] Corte / [80] Montado / [90] Adorno</span></label>
                            <select class="form-control form-control-sm required" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="0">TODO</option>
                                <option value="10">10 CORTE</option>
                                <option value="80">80 MONTADO</option>
                                <option value="90">90 ADORNO</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Almacen/Maquila <span class="badge badge-warning mb-2" style="font-size: 12px;">Sólo Almacén [1] y Sub-Almacén [97]</span></label>
                            <select class="form-control form-control-sm required" id="Maq" name="Maq" >
                                <option value=""></option>
                                <option value="articulos">1 Almacén General</option>
                                <option value="articulos10">97 Sub Almacén</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <label>Mes </label>
                            <select class="form-control form-control-sm required" id="Mes" name="Mes" >
                                <option value=""></option>
                                <option value="1">1 Enero</option>
                                <option value="2">2 Febrero</option>
                                <option value="3">3 Marzo</option>
                                <option value="4">4 Abril</option>
                                <option value="5">5 Mayo</option>
                                <option value="6">6 Junio</option>
                                <option value="7">7 Julio</option>
                                <option value="8">8 Agosto</option>
                                <option value="9">9 Septiembre</option>
                                <option value="10">10 Octubre</option>
                                <option value="11">11 Noviembre</option>
                                <option value="12">12 Diciembre</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Año </label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
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
    var mdlComparativoInvFisInvSis = $('#mdlComparativoInvFisInvSis');
    var precio_Art = 0;
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlComparativoInvFisInvSis);
        setFocusSelectToSelectOnChange('#Tipo', '#Maq', mdlComparativoInvFisInvSis);
        setFocusSelectToSelectOnChange('#Maq', '#Mes', mdlComparativoInvFisInvSis);
        setFocusSelectToInputOnChange('#Mes', '#Ano', mdlComparativoInvFisInvSis);
        mdlComparativoInvFisInvSis.on('shown.bs.modal', function () {
            mdlComparativoInvFisInvSis.find("input").val("");
            $.each(mdlComparativoInvFisInvSis.find("select"), function (k, v) {
                mdlComparativoInvFisInvSis.find("select")[k].selectize.clear(true);
            });
            mdlComparativoInvFisInvSis.find('#Tipo')[0].selectize.focus();
        });

        mdlComparativoInvFisInvSis.find('#btnAceptar').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlComparativoInvFisInvSis.find("#frmCaptura")[0]);

            var nombre_alm = mdlComparativoInvFisInvSis.find('#Maq option:selected').text().toUpperCase();
            frm.append('Almacen', nombre_alm);

            $.ajax({
                url: base_url + 'index.php/CapturaInventarios/onReporteComparativoInvFisInvSis',
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
                        mdlComparativoInvFisInvSis.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlComparativoInvFisInvSis.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlComparativoInvFisInvSis.find("#Ano").val("");
                    mdlComparativoInvFisInvSis.find("#Ano").focus();
                });
            }
        });
    });
</script>