<div class="modal " id="mdlDetalleMovimientos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detallado de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <label for="" >Del Cliente</label>
                            <select id="dClienteDetalleMovimientos" name="dClienteDetalleMovimientos" class="form-control form-control-sm mb-2 required" required="" >
                                <option value=""></option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniDetalleMovimientos" name="FechaIniDetalleMovimientos" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinDetalleMovimientos" name="FechaFinDetalleMovimientos" >
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
    var mdlDetalleMovimientos = $('#mdlDetalleMovimientos');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlDetalleMovimientos);
        mdlDetalleMovimientos.on('shown.bs.modal', function () {
            handleEnterDiv(mdlDetalleMovimientos);
            mdlDetalleMovimientos.find("input").val("");
            $.each(mdlDetalleMovimientos.find("select"), function (k, v) {
                mdlDetalleMovimientos.find("select")[k].selectize.clear(true);
            });
            getClientesDetalleMovimientos();
            mdlDetalleMovimientos.find('#dClienteDetalleMovimientos')[0].selectize.focus();
            mdlDetalleMovimientos.find('#FechaIniDetalleMovimientos').val(getFirstDayMonth());
            mdlDetalleMovimientos.find('#FechaFinDetalleMovimientos').val(getToday());
        });


        mdlDetalleMovimientos.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlDetalleMovimientos.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteDetalladoMovimientosClientes',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    console.log(data);
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
                    HoldOn.close();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlDetalleMovimientos.find('#dClienteDetalleMovimientos')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });



    function getClientesDetalleMovimientos() {
        mdlDetalleMovimientos.find("#dClienteDetalleMovimientos")[0].selectize.clear(true);
        mdlDetalleMovimientos.find("#dClienteDetalleMovimientos")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/AuxReportesClientes/getClientes').done(function (data) {
            $.each(data, function (k, v) {
                mdlDetalleMovimientos.find("#dClienteDetalleMovimientos")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }


</script>
