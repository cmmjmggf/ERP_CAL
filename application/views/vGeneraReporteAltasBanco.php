<div class="modal " id="mdlGeneraReporteAltasBanco"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera archivo de altas para el banco</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir"><span class="fa fa-file-alt"></span> EXPORTAR TXT </button>
                <button type="button" class="btn btn-danger" id="btnImprimirPDF"><span class="fa fa-file-pdf"></span> IMPRIMIR PDF</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraReporteAltasBanco = $('#mdlGeneraReporteAltasBanco');
    $(document).ready(function () {
        mdlGeneraReporteAltasBanco.on('shown.bs.modal', function () {
            handleEnterDiv(mdlGeneraReporteAltasBanco);
            mdlGeneraReporteAltasBanco.find("input").val("");
            $.each(mdlGeneraReporteAltasBanco.find("select"), function (k, v) {
                mdlGeneraReporteAltasBanco.find("select")[k].selectize.clear(true);
            });
            mdlGeneraReporteAltasBanco.find('#FechaFin').val(getToday());
            mdlGeneraReporteAltasBanco.find('#FechaIni').focus();
        });
        mdlGeneraReporteAltasBanco.find('#btnImprimirPDF').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlGeneraReporteAltasBanco.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesNominaJasper/onReporteAltasBancoPDF',
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
                        text: "NO EXISTEN DATOS PARA EL REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlGeneraReporteAltasBanco.find('#FechaIni').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        mdlGeneraReporteAltasBanco.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var fecIni = mdlGeneraReporteAltasBanco.find('#FechaIni').val();
            var fecFin = mdlGeneraReporteAltasBanco.find('#FechaFin').val();
            var get = base_url + "index.php/ReportesNominaJasper/onReporteAltasBanco?FechaIni=" + fecIni + "&FechaFin=" + fecFin + "";
            location.href = get;
//            var get2 = base_url + "index.php/ReportesNominaJasper/onReporteAltasBancoDos?FechaIni=" + fecIni + "&FechaFin=" + fecFin + "";
//            location.href = get2;
            HoldOn.close();
        });
    });
</script>