<div class="modal " id="mdlEstadoCuenta"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-5">
                            <label>Del Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="dClienteEdoCta" name="dClienteEdoCta" maxlength="5" required="">
                        </div>
                        <div class="col-5">
                            <label>Al Cliente</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="aClienteEdoCta" name="aClienteEdoCta" maxlength="5" required="">
                        </div>
                        <div class="w-100"></div>
                        <div class="col-4">
                            <label class="mb-1">Tp: <span class="badge badge-danger" style="font-size: 14px;">Nota: Para ver todo, dejar en blanco</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpEdoCuenta" name="TpEdoCuenta" required="">
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
    var mdlEstadoCuenta = $('#mdlEstadoCuenta');
    $(document).ready(function () {

        mdlEstadoCuenta.on('shown.bs.modal', function () {
            mdlEstadoCuenta.find("input").val("");
            mdlEstadoCuenta.find('#dClienteEdoCta').focus();
        });
        mdlEstadoCuenta.find('#dClienteEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    mdlEstadoCuenta.find('#aClienteEdoCta').focus().select();
                }
            }
        });
        mdlEstadoCuenta.find('#aClienteEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    mdlEstadoCuenta.find('#TpEdoCuenta').focus().select();
                }
            }
        });
        mdlEstadoCuenta.find("#TpEdoCuenta").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpEdoCuentaUno($(this));
                } else {
                    mdlEstadoCuenta.find('#btnImprimir').focus();
                }
            }
        });
        mdlEstadoCuenta.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlEstadoCuenta.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesClientesJasper/onReporteEstadoCuenta',
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
                        mdlEstadoCuenta.find('#dClienteEdoCta').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
    });

    function onVerificarTpEdoCuentaUno(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuenta.find('#btnImprimir').focus();
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
