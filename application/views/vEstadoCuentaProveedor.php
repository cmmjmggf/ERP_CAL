<div class="modal " id="mdlEstadoCuentaProveedor"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estado de Cuenta de Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEdoCta">

                    <div class="row">
                        <div class="col-12">
                            <label>Tp <span class="badge badge-warning mb-2" style="font-size: 12px;">Para consultar todo deja en blanco</span></label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly" id="Tp" name="Tp" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label>Del Proveedor:</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="dProveedorEdoCta" name="Proveedor" maxlength="5" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sdProveedorEdoCta" name="sdProveedorEdoCta" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Al Proveedor:</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="aProveedorEdoCta" name="aProveedor" maxlength="5" required="">
                                </div>
                                <div class="col-9">
                                    <select id="saProveedorEdoCta" name="saProveedorEdoCta" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="Desglosado">
                                <label class="custom-control-label text-info labelCheck" for="Desglosado">Desglosado</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url_remota = base_url + 'index.php/ReportesProveedores/';
    var mdlEstadoCuentaProveedor = $('#mdlEstadoCuentaProveedor');

    $(document).ready(function () {
        mdlEstadoCuentaProveedor.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(mdlEstadoCuentaProveedor);
        setFocusSelectToInputOnChange('#saProveedorEdoCta', '#btnImprimir', mdlEstadoCuentaProveedor);
        mdlEstadoCuentaProveedor.on('shown.bs.modal', function () {
            mdlEstadoCuentaProveedor.find("input").val("");
            $.each(mdlEstadoCuentaProveedor.find("select"), function (k, v) {
                mdlEstadoCuentaProveedor.find("select")[k].selectize.clear(true);
            });
            getProveedoresEdoCtaReporte();
            mdlEstadoCuentaProveedor.find('#Tp').focus();
        });
        mdlEstadoCuentaProveedor.find('#btnImprimir').on("click", function () {
            mdlEstadoCuentaProveedor.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

            var frm = new FormData(mdlEstadoCuentaProveedor.find("#frmEdoCta")[0]);
            var desgloce = mdlEstadoCuentaProveedor.find("#Desglosado")[0].checked ? '1' : '0';
            var reporte = '';
            if (desgloce === '1') {
                reporte = 'onReporteEdosCuentaDesgloce';
            } else {
                reporte = 'onReporteEdosCuenta';
            }

            $.ajax({
                url: master_url_remota + reporte,
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
                                mdlEstadoCuentaProveedor.find('#btnImprimir').attr('disabled', false);
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
                        text: "NO EXISTEN DOCUMENTOS PARA ESTE PROVEEDOR",
                        icon: "error"
                    }).then((action) => {
                        mdlEstadoCuentaProveedor.find('#btnImprimir').attr('disabled', false);
                        mdlEstadoCuentaProveedor.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                mdlEstadoCuentaProveedor.find('#btnImprimir').attr('disabled', false);
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlEstadoCuentaProveedor.find("#Tp").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTpEdoCtaProv($(this));
                } else {
                    mdlEstadoCuentaProveedor.find("#dProveedorEdoCta").focus();
                }
            }
        });
        mdlEstadoCuentaProveedor.find('#dProveedorEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url_remota + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuentaProveedor.find("#sdProveedorEdoCta")[0].selectize.addItem(txtprov, true);
                            mdlEstadoCuentaProveedor.find('#aProveedorEdoCta').focus().select();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuentaProveedor.find("#sdProveedorEdoCta")[0].selectize.clear(true);
                                mdlEstadoCuentaProveedor.find('#dProveedorEdoCta').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuentaProveedor.find("#sdProveedorEdoCta").change(function () {
            if ($(this).val()) {
                mdlEstadoCuentaProveedor.find("#dProveedorEdoCta").val($(this).val());
                mdlEstadoCuentaProveedor.find("#aProveedorEdoCta").focus();
            }
        });
        mdlEstadoCuentaProveedor.find('#aProveedorEdoCta').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url_remota + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            mdlEstadoCuentaProveedor.find("#saProveedorEdoCta")[0].selectize.addItem(txtprov, true);
                            mdlEstadoCuentaProveedor.find('#btnImprimir').focus().select();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                mdlEstadoCuentaProveedor.find("#saProveedorEdoCta")[0].selectize.clear(true);
                                mdlEstadoCuentaProveedor.find('#aProveedorEdoCta').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        mdlEstadoCuentaProveedor.find("#saProveedorEdoCta").change(function () {
            if ($(this).val()) {
                mdlEstadoCuentaProveedor.find("#aProveedorEdoCta").val($(this).val());
                mdlEstadoCuentaProveedor.find('#btnImprimir').focus().select();
            }
        });

    });
    function getProveedoresEdoCtaReporte() {
        mdlEstadoCuentaProveedor.find("#sdProveedorEdoCta")[0].selectize.clear(true);
        mdlEstadoCuentaProveedor.find("#saProveedorEdoCta")[0].selectize.clearOptions();
        $.getJSON(master_url_remota + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlEstadoCuentaProveedor.find("#sdProveedorEdoCta")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
                mdlEstadoCuentaProveedor.find("#saProveedorEdoCta")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarTpEdoCtaProv(v) {

        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlEstadoCuentaProveedor.find("#dProveedorEdoCta").focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
</script>