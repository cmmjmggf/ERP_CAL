<div class="modal " id="mdlParesPesosTiendas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventas consolidado por mes de Tiendas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label class="mb-1">Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoParesPesosTiendas" name="AnoParesPesosTiendas" >
                        </div>
                        <div class="col-8">
                            <label class="mb-1">Tp: <span class="badge badge-info" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpParesPesosTiendas" name="TpParesPesosTiendas">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="mb-1">Nota: <span class="badge badge-danger" style="font-size: 14px;">Este reporte se imprime en tamaño oficio</span></label>
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
    var mdlParesPesosTiendas = $('#mdlParesPesosTiendas');
    $(document).ready(function () {
        mdlParesPesosTiendas.on('shown.bs.modal', function () {
            mdlParesPesosTiendas.find("input").val("");
            $.each(mdlParesPesosTiendas.find("select"), function (k, v) {
                mdlParesPesosTiendas.find("select")[k].selectize.clear(true);
            });
            mdlParesPesosTiendas.find('#AnoParesPesosTiendas').focus();
        });


        mdlParesPesosTiendas.find("#AnoParesPesosTiendas").keypress(function (e) {
            if (e.keyCode === 13) {
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
                        mdlParesPesosTiendas.find("#AnoParesPesosTiendas").val("");
                        mdlParesPesosTiendas.find("#AnoParesPesosTiendas").focus();
                    });
                } else {
                    mdlParesPesosTiendas.find('#TpParesPesosTiendas').focus();
                }
            }
        });
        mdlParesPesosTiendas.find("#TpParesPesosTiendas").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                } else {
                    mdlParesPesosTiendas.find('#btnImprimir').focus();
                }
            }
        });
        mdlParesPesosTiendas.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlParesPesosTiendas.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteParesPesosTiendas',
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
                        mdlParesPesosTiendas.find('#Cliente')[0].selectize.focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTp(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlParesPesosTiendas.find('#btnImprimir').focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }



</script>
