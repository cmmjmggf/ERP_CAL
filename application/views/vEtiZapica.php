<div class="modal " id="mdlEtiZapica"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Etiquetas para Sapica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4" >
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>Linea</label>
                            <select id="Linea" name="Linea" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Temporada</label>
                            <select id="Temporada" name="Temporada" class="form-control form-control-sm required">
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
    var mdlEtiZapica = $('#mdlEtiZapica');
    $(document).ready(function () {
        mdlEtiZapica.on('shown.bs.modal', function () {
            handleEnterDiv(mdlEtiZapica);
            mdlEtiZapica.find("input").val("");
            $.each(mdlEtiZapica.find("select"), function (k, v) {
                mdlEtiZapica.find("select")[k].selectize.clear(true);
            });
            getLineasEtiZapica();
            getTemporadasEtiZapica();
            mdlEtiZapica.find('#Ano').focus();
        });

        mdlEtiZapica.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-cube', message: 'Por favor espere...'});
            var frm = new FormData(mdlEtiZapica.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesEstiquetasProduccion/OnReporteEtiquetaZapica',
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
                        mdlEtiZapica.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
            }).always(function () {
                HoldOn.close();
            });
        });
        mdlEtiZapica.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2000 || parseInt($(this).val()) > 2040 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlEtiZapica.find("#Ano").val("");
                    mdlEtiZapica.find("#Ano").focus();
                });
            }
        });
    });

    function getLineasEtiZapica() {
        $.getJSON(base_url + 'index.php/Lineas/' + 'getLineasSelect').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEtiZapica.find("#Linea")[0].selectize.addOption({text: v.Linea, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getTemporadasEtiZapica() {
        $.getJSON(base_url + 'index.php/Lineas/' + 'getTemporadas').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlEtiZapica.find("#Temporada")[0].selectize.addOption({text: v.Temporada, value: v.Clave});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }


</script>


