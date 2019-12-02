<div class="modal " id="mdlKardexPorProveedor"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kardex del Almacen por Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">

                    <div class="row">
                        <div class="col-4">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-4">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label>Tp</label>
                            <input type="text" class="form-control form-control-sm  numbersOnly " id="Tp" maxlength="1" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Proveedor</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly " id="ProveedorKardex" name="Proveedor" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sProveedorKardex" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
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


    var mdlKardexPorProveedor = $('#mdlKardexPorProveedor');

    $(document).ready(function () {
        validacionSelectPorContenedor(mdlSalidasMaquilasPorDia);
        setFocusSelectToInputOnChange('#sProveedorKardex', '#btnImprimir', mdlKardexPorProveedor);
        mdlKardexPorProveedor.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        mdlKardexPorProveedor.on('shown.bs.modal', function () {
            handleEnterDiv(mdlKardexPorProveedor);
            mdlKardexPorProveedor.find("input").val("");
            $.each(mdlKardexPorProveedor.find("select"), function (k, v) {
                mdlKardexPorProveedor.find("select")[k].selectize.clear(true);
            });

            mdlKardexPorProveedor.find('#FechaIni').val(getFirstDayMonth());
            mdlKardexPorProveedor.find('#FechaFin').val(getLastDayMonth());
            mdlKardexPorProveedor.find('#FechaIni').focus();
        });

        mdlKardexPorProveedor.find("#Tp").change(function () {
            onVerificarTpKardex($(this));
        });

        mdlKardexPorProveedor.find('#ProveedorKardex').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtprv = $(this).val();
                if (txtprv) {
                    $.getJSON(base_url + 'index.php/ReportesKardex/onVerificarProveedor', {Proveedor: txtprv}).done(function (data) {
                        if (data.length > 0) {
                            mdlKardexPorProveedor.find("#sProveedorKardex")[0].selectize.addItem(txtprv, true);
                            mdlKardexPorProveedor.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                mdlKardexPorProveedor.find("#sProveedorKardex")[0].selectize.clear(true);
                                mdlKardexPorProveedor.find('#ProveedorKardex').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlKardexPorProveedor.find('#sProveedorKardex').change(function () {
            var txtprv = $(this).val();
            if (txtprv) {
                mdlKardexPorProveedor.find('#ProveedorKardex').val(txtprv);
                mdlKardexPorProveedor.find('#btnImprimir').focus();
            }
        });

        mdlKardexPorProveedor.find('#btnImprimir').on("click", function () {
            var PROV = parseInt(mdlKardexPorProveedor.find('#ProveedorKardex').val());

            if (PROV > 0) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlKardexPorProveedor.find("#frmCaptura")[0]);
                var nombre_prov = mdlKardexPorProveedor.find('#ProveedorKardex').val() + ' ' + mdlKardexPorProveedor.find("#sProveedorKardex option:selected").text();
                frm.append('Nombre', nombre_prov);
                $.ajax({
                    url: base_url + 'index.php/ReportesKardex/onReporteKardexPorProveedor',
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
                            mdlKardexPorProveedor.find('#ProveedorKardex').focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN PROV",
                    icon: "error"
                }).then((action) => {
                    mdlKardexPorProveedor.find('#ProveedorKardex').focus();
                });
            }
        });

    });

    function onVerificarTpKardex(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlKardexPorProveedor.find('#ProveedorKardex').focus();
            getProveedoresKardex(tp);
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

    function getProveedoresKardex(tp) {
        mdlKardexPorProveedor.find("#sProveedorKardex")[0].selectize.clear(true);
        mdlKardexPorProveedor.find("#sProveedorKardex")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesKardex/getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlKardexPorProveedor.find("#sProveedorKardex")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>