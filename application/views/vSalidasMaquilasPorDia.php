<div class="modal " id="mdlSalidasMaquilasPorDia"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Salidas de Material a Maquilas Por Día</h5>
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

                    <div class="row mt-4">
                        <div class="col-12 col-sm-12">
                            <span class="badge badge-warning " style="font-size: 13px;">Para todas las maquilas y semanas, dejar en blanco</span>
                        </div>
                        <div class="col-4">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-4">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">0 DIRECTAS, 10 Piel/Forro, 80 Suela, 90 Peletería, P' AUDITORÍA</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="1">TODO</option>
                                <option value="0">0 DIRECTOS</option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS/PELETERÍA</option>
                                <option value="100">PARA AUDITORÍA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="SalConDesgloce" name="SalConDesgloce" >
                                <label class="custom-control-label text-info labelCheck" for="SalConDesgloce">Desglosado</label>
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
    var mdlSalidasMaquilasPorDia = $('#mdlSalidasMaquilasPorDia');
    var mdlReporte = $('#mdlReporte');
    var generado = false;
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlSalidasMaquilasPorDia);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlSalidasMaquilasPorDia);

        mdlSalidasMaquilasPorDia.on('shown.bs.modal', function () {
            handleEnterDiv(mdlSalidasMaquilasPorDia);
            mdlSalidasMaquilasPorDia.find("input").val("");
            $.each(mdlSalidasMaquilasPorDia.find("select"), function (k, v) {
                mdlSalidasMaquilasPorDia.find("select")[k].selectize.clear(true);
            });
            mdlSalidasMaquilasPorDia.find('#FechaFin').val(getToday());
            mdlSalidasMaquilasPorDia.find('#FechaIni').focus();
        });


        mdlSalidasMaquilasPorDia.find('#btnImprimir').on("click", function () {
            var Tipo = parseInt(mdlSalidasMaquilasPorDia.find('#Tipo').val());

            if (Tipo > 0) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlSalidasMaquilasPorDia.find("#frmCaptura")[0]);

                var Tipo = parseInt(mdlSalidasMaquilasPorDia.find('#Tipo').val());
                var desglosado = mdlSalidasMaquilasPorDia.find("#SalConDesgloce")[0].checked ? true : false;
                var Reporte = '';

                if (Tipo > 90) {
                    Reporte = 'index.php/ReportesCompras/onReporteAuditoriaMovimientos';
                } else {
                    if (desglosado) {
                        Reporte = 'index.php/ReportesCompras/onReporteSalidasMaquilasPorDiaDesglosado';
                    } else {
                        Reporte = 'index.php/ReportesCompras/onReporteSalidasMaquilasPorDia';
                    }

                }

                $.ajax({
                    url: base_url + Reporte,
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
                            mdlSalidasMaquilasPorDia.find('#Maq').focus();
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
                    text: "DEBES DE SELECCIONAR UN TIPO",
                    icon: "error"
                }).then((action) => {
                    mdlSalidasMaquilasPorDia.find('#Tipo')[0].selectize.focus();
                });
            }
        });

        mdlSalidasMaquilasPorDia.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlSalidasMaquilasPorDia.find("#Sem").change(function () {
            if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 52 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "SEMANA INCORRECTA",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlSalidasMaquilasPorDia.find("#Maq").val("");
                    mdlSalidasMaquilasPorDia.find("#Maq").focus();
                });
            }
        });

    });

    function onComprobarMaquilas(v) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarMaquilas', {Clave: $(v).val()}).done(function (data) {
            if (data.length > 0) {
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA MAQUILA " + $(v).val() + " NO ES VALIDA",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"
                        }
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>