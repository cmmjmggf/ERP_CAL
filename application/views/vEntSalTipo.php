<div class="modal " id="mdlEntSalTipo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte de Entradas y Salidas por Tipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-2">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-2">
                            <label>Tipo</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm" id="Tipo" name="Tipo" >
                        </div>
                        <div class="col-4">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-4">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>

                    </div>

                    <div class="row m-2 mt-3" >
                        <div class="col-12 col-sm-6 col-md-6  border">
                            <label for="" class="badge badge-info mb-1 " style="font-size: 14px;">Tipos de Entradas</label>
                            <br>
                            <label for="">EPR = Entrada X Producción</label>
                            <br>
                            <label for="">EAJ = Entrada X Ajuste</label>
                            <br>
                            <label for="">EDV = Entrada X Devolución</label>
                            <br>
                            <label for="">ETR = Entrada X Traspaso</label>
                            <br>
                            <br>
                            <br>
                            <br>
                            <label for="">CAN = CANCELADOS</label>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 border" >
                            <label for="" class="badge badge-danger" style="font-size: 14px;">Tipos de Salidas</label>
                            <br>
                            <label for="">SPR = Salida X Producción</label>
                            <br>
                            <label for="">SDV = Salida X Devolución</label>
                            <br>
                            <label for="">SAJ = Salida X Ajuste</label>
                            <br>
                            <label for="">SXP = Salida X Piocha</label>
                            <br>
                            <label for="">SXC = Salida X Calidad</label>
                            <br>
                            <label for="">SXV = Salida X Venta Obsoleta</label>
                            <br>
                            <label for="">STR = Salida X Traspaso</label>
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
    var mdlEntSalTipo = $('#mdlEntSalTipo');
    $(document).ready(function () {

        mdlEntSalTipo.on('shown.bs.modal', function () {
            getGrupos();
            mdlEntSalTipo.find("input").val("");
            $.each(mdlEntSalTipo.find("select"), function (k, v) {
                mdlEntSalTipo.find("select")[k].selectize.clear(true);
            });
            mdlEntSalTipo.find('#FechaIni').val(getFirstDayMonth());
            mdlEntSalTipo.find('#FechaFin').val(getToday());
            mdlEntSalTipo.find('#Ano').focus();
        });

        mdlEntSalTipo.find("#Ano").change(function () {
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
                    mdlEntSalTipo.find("#Ano").val("");
                    mdlEntSalTipo.find("#Ano").focus();
                });
            }
        });

        mdlEntSalTipo.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEntSalTipo.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesMaterialesJasper/onReporteEntSalTipo',
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
                        mdlEntSalTipo.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });

        mdlEntSalTipo.find("#Tipo").blur(function () {
            var tipos = ['EPR', 'EAJ', 'EDV', 'ETR', 'CAN', 'SPR', 'SDV', 'SAJ', 'SXP', 'SXC', 'SXV', 'STR'];
            if (!tipos.includes($(this).val())) {
                swal({
                    title: "ATENCIÓN",
                    text: "TIPO NO VÁLIDO",
                    icon: "error"
                }).then((action) => {
                    mdlEntSalTipo.find('#Tipo').focus();
                });
            }
        });

    });

</script>

