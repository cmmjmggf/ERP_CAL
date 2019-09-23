<div class="modal " id="mdlMaterialAnoSemMaqDesgloseControlEstilo"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Programación por Artículo (Desglose Control-Estilo)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmReporte">



                    <div class="row">
                        <div class="col-4">
                            <label>Año </label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>De Semana: </label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="dSem" name="dSem" >
                        </div>
                        <div class="col-4">
                            <label>A Semana: </label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select id="Tipo" name="Tipo" class="form-control form-control-sm required" required="">
                                <option value=""></option>
                                <option value="10">10 PIEL/FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 PELETERÍA</option>
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

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Estatus Control <span class="badge badge-warning mb-2" style="font-size: 12px;">1 PRE-PROGRAMADO, PROGRAMADO Y CORTE , 2 CUALQUIER ESTATUS</span></label>
                            <select id="Estatus" name="Estatus" class="form-control form-control-sm required" required="">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
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

    var mdlMaterialAnoSemMaqDesgloseControlEstilo = $('#mdlMaterialAnoSemMaqDesgloseControlEstilo');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlMaterialAnoSemMaqDesgloseControlEstilo);
        setFocusSelectToSelectOnChange('#Tipo', '#Articulo', mdlMaterialAnoSemMaqDesgloseControlEstilo);
        setFocusSelectToSelectOnChange('#Articulo', '#Estatus', mdlMaterialAnoSemMaqDesgloseControlEstilo);
        setFocusSelectToInputOnChange('#Estatus', '#btnImprimir', mdlMaterialAnoSemMaqDesgloseControlEstilo);

        mdlMaterialAnoSemMaqDesgloseControlEstilo.on('shown.bs.modal', function () {
            mdlMaterialAnoSemMaqDesgloseControlEstilo.find("input").val("");
            $.each(mdlMaterialAnoSemMaqDesgloseControlEstilo.find("select"), function (k, v) {
                mdlMaterialAnoSemMaqDesgloseControlEstilo.find("select")[k].selectize.clear(true);
            });

            mdlMaterialAnoSemMaqDesgloseControlEstilo.find('#Ano').focus();
        });

        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Ano").change(function () {
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
                    mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Ano").val("");
                    mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Ano").focus();
                });
            }
        });

        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#dSem").change(function () {
            var ano = mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });

        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#aSem").change(function () {
            var ano = mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });

        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Tipo").change(function () {
            getArticulosMatSemProdControl($(this).val());
        });

        mdlMaterialAnoSemMaqDesgloseControlEstilo.find('#btnImprimir').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#frmReporte")[0]);

            $.ajax({
                url: base_url + 'index.php/ReporteMaterialProduccionEstilo/onReporteMaterialSemanaDesgloseProdEstilo',
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
                        mdlMaterialAnoSemMaqDesgloseControlEstilo.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

    });

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
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

    function getArticulosMatSemProdControl(tipo) {
        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Articulo")[0].selectize.clear(true);
        mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Articulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReporteMaterialProduccionEstilo/getArticulosXDepto', {Tipo: tipo}).done(function (data) {
            console.log(data);
            $.each(data, function (k, v) {
                mdlMaterialAnoSemMaqDesgloseControlEstilo.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>