<div class="modal " id="mdlAvanceProduccionPorDepto"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte Avance por Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Departamento</label>
                            <select class="form-control form-control-sm required selectize" id="Depto" name="Depto" >
                                <option value=""></option>
                                <option value="110">5-Pespunte </option>
                                <option value="150">7-Tejido</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceProduccionPorDepto = $('#mdlAvanceProduccionPorDepto');
    $(document).ready(function () {
        mdlAvanceProduccionPorDepto.on('shown.bs.modal', function () {
            handleEnterDiv(mdlAvanceProduccionPorDepto);
            mdlAvanceProduccionPorDepto.find("input").val("");
            $.each(mdlAvanceProduccionPorDepto.find("select"), function (k, v) {
                mdlAvanceProduccionPorDepto.find("select")[k].selectize.clear(true);
            });
            //getDeptos();
            mdlAvanceProduccionPorDepto.find('#Depto')[0].selectize.focus();
            mdlAvanceProduccionPorDepto.find('#Depto')[0].selectize.open();
        });
        mdlAvanceProduccionPorDepto.find('#Depto').on("change", function () {
            if ($(this).val) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlAvanceProduccionPorDepto.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesProduccionJasper/onReporteAvancePorDeptoEspecifico',
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
                            mdlAvanceProduccionPorDepto.find('#Depto')[0].selectize.focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            }
        });
    });


    function getDeptos() {
        mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.clear(true);
        mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesProduccionJasper/getDepartamentos').done(function (data) {
            $.each(data, function (k, v) {
                mdlAvanceProduccionPorDepto.find("#Depto")[0].selectize.addOption({text: v.Depto, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>


