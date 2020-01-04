<div class="modal " id="mdlKardexSubAlmacen"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kardex del Sub-Almacen por Artículo</h5>
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
                        <div class="col-12">
                            <label>Artículo</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm  numbersOnly" id="Articulo" name="Articulo" maxlength="6" required="">
                                </div>
                                <div class="col-9">
                                    <select id="sArticulo" name="sArticulo" class="form-control form-control-sm required NotSelectize " required="" >
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

    var mdlKardexSubAlmacen = $('#mdlKardexSubAlmacen');

    $(document).ready(function () {
        mdlKardexSubAlmacen.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        validacionSelectPorContenedor(mdlKardexSubAlmacen);
        setFocusSelectToInputOnChange('#sArticulo', '#btnImprimir', mdlKardexSubAlmacen);

        mdlKardexSubAlmacen.on('shown.bs.modal', function () {
            handleEnterDiv(mdlKardexSubAlmacen);
            mdlKardexSubAlmacen.find("input").val("");
            $.each(mdlKardexSubAlmacen.find("select"), function (k, v) {
                mdlKardexSubAlmacen.find("select")[k].selectize.clear(true);
            });
            getArticulosKardexSubAlm();

            mdlKardexSubAlmacen.find('#FechaIni').val(getFirstDayMonth());
            mdlKardexSubAlmacen.find('#FechaFin').val(getLastDayMonth());
            mdlKardexSubAlmacen.find('#FechaIni').focus();
        });


        mdlKardexSubAlmacen.find('#Articulo').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(base_url + 'index.php/ReportesKardex/onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            mdlKardexSubAlmacen.find("#sArticulo")[0].selectize.addItem(txtart, true);
                            mdlKardexSubAlmacen.find('#btnImprimir').focus();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                                mdlKardexSubAlmacen.find("#sArticulo")[0].selectize.clear(true);
                                mdlKardexSubAlmacen.find('#Articulo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlKardexSubAlmacen.find('#sArticulo').change(function () {
            var txtart = $(this).val();
            if (txtart) {
                mdlKardexSubAlmacen.find('#Articulo').val(txtart);
                mdlKardexSubAlmacen.find('#btnImprimir').focus();
            }
        });
        mdlKardexSubAlmacen.find('#btnImprimir').on("click", function () {
            mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', true);
            var Art = parseInt(mdlKardexSubAlmacen.find('#Articulo').val());

            if (Art > 0) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlKardexSubAlmacen.find("#frmCaptura")[0]);

                $.ajax({
                    url: base_url + 'index.php/ReportesKardex/onReporteKardexSubAlmacePorArticulo',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                    if (data.length > 0) {
                        onImprimirReporteFancyAFC(data, function (a, b) {
                            mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                        });
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                            icon: "error"
                        }).then((action) => {
                            mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                            mdlKardexSubAlmacen.find('#Articulo').focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN ARTÍCULO",
                    icon: "error"
                }).then((action) => {
                    mdlKardexSubAlmacen.find('#btnImprimir').attr('disabled', false);
                    mdlKardexSubAlmacen.find('#Articulo').focus();
                });
            }
        });

    });

    function getArticulosKardexSubAlm() {
        mdlKardexSubAlmacen.find("#sArticulo")[0].selectize.clear(true);
        mdlKardexSubAlmacen.find("#sArticulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesKardex/getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlKardexSubAlmacen.find("#sArticulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>