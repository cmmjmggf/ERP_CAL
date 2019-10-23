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
                        <div class="col-12 col-sm-12">
                            <label>Proveedor</label>
                            <select class="form-control form-control-sm" id="ProveedorKardex" name="Proveedor" >
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


    var mdlKardexPorProveedor = $('#mdlKardexPorProveedor');

    $(document).ready(function () {
        validacionSelectPorContenedor(mdlSalidasMaquilasPorDia);
        setFocusSelectToInputOnChange('#ProveedorKardex', '#btnImprimir', mdlKardexPorProveedor);

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

        mdlKardexPorProveedor.find('#btnImprimir').on("click", function () {
            var Art = parseInt(mdlKardexPorProveedor.find('#ProveedorKardex').val());

            if (Art > 0) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlKardexPorProveedor.find("#frmCaptura")[0]);
                var nombre_prov = mdlKardexPorProveedor.find("#ProveedorKardex option:selected").text();
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
                            mdlKardexPorProveedor.find('#ProveedorKardex')[0].selectize.focus();
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
                    text: "DEBES DE SELECCIONAR UN ARTÍCULO",
                    icon: "error"
                }).then((action) => {
                    mdlKardexPorProveedor.find('#ProveedorKardex')[0].selectize.focus();
                });
            }
        });

    });

    function onVerificarTpKardex(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            mdlKardexPorProveedor.find('#ProveedorKardex')[0].selectize.focus();
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
        mdlKardexPorProveedor.find("#ProveedorKardex")[0].selectize.clear(true);
        mdlKardexPorProveedor.find("#ProveedorKardex")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesKardex/getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlKardexPorProveedor.find("#ProveedorKardex")[0].selectize.addOption({text: (tp === 1) ? v.ProveedorF : v.ProveedorI, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>