<div class="modal " id="mdlReporteInspeccion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte Inspección</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmReporte">

                    <div class="row">
                        <div class="col-6">
                            <label>Tp </label>
                            <input type="text" maxlength="1" class="form-control form-control-sm numbersOnly" id="Tp" name="Tp" >
                        </div>
                    </div>

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

                    <div class="col-12 col-sm-12 mt-4">
                        <legend class="badge badge-danger" style="font-size: 14px;">Si desea ver todo NO CAPTURE proveedor NI artículo</legend>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Proveedor</label>
                            <select class="form-control form-control-sm" id="Proveedor" name="Proveedor" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Artículo</label>
                            <select class="form-control form-control-sm" id="Articulo" name="Articulo" >
                                <option value=""></option>
                            </select>
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

    var mdlReporteInspeccion = $('#mdlReporteInspeccion');
    $(document).ready(function () {
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlReporteInspeccion);
        handleEnterDiv(mdlReporteInspeccion);
        mdlReporteInspeccion.on('shown.bs.modal', function () {
            mdlReporteInspeccion.find("input").val("");
            $.each(mdlReporteInspeccion.find("select"), function (k, v) {
                mdlReporteInspeccion.find("select")[k].selectize.clear(true);
            });
            getProveedoresInspeccionMat();
            getArticulosInspeccionMat();
            mdlReporteInspeccion.find("#FechaIni").val(getToday());
            mdlReporteInspeccion.find("#FechaFin").val(getToday());
            mdlReporteInspeccion.find('#Tp').focus();
        });

        mdlReporteInspeccion.find("#Tp").change(function () {
            onVerificarTp($(this));
        });

        mdlReporteInspeccion.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlReporteInspeccion.find("#frmReporte")[0]);

            $.ajax({
                url: base_url + 'index.php/ReportesInspeccion/onReporteInspeccion',
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
                        mdlReporteInspeccion.find('#Tp').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function getProveedoresInspeccionMat() {
        mdlReporteInspeccion.find("#Proveedor")[0].selectize.clear(true);
        mdlReporteInspeccion.find("#Proveedor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesInspeccion/' + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                mdlReporteInspeccion.find("#Proveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getArticulosInspeccionMat() {
        mdlReporteInspeccion.find("#Articulo")[0].selectize.clear(true);
        mdlReporteInspeccion.find("#Articulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesInspeccion/' + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlReporteInspeccion.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {


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