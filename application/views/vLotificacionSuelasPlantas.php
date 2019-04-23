<div class="modal " id="mdlLotificacionSuelasPlantas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lotif. Suela X Semana/Maquila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label class="text-danger">Nota. Controles FACTURADOS/CANCELADOS no se imprimirán</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>De la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                        <div class="col-6">
                            <label>A la maq.</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="aMaq" name="aMaq" >
                        </div>
                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-6">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">1 SUELA, 2 PLANTA</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="3">1 SUELA</option>
                                <option value="52">2 PLANTA</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label>Lotificación <span class="badge badge-warning mb-2" style="font-size: 12px;">Sí desea toda la sem-maq. Dejar en blanco</span></label>
                            <select class="form-control form-control-sm required selectize" id="Articulo" name="Articulo" >
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
    var mdlLotificacionSuelasPlantas = $('#mdlLotificacionSuelasPlantas');
    $(document).ready(function () {
        mdlLotificacionSuelasPlantas.on('shown.bs.modal', function () {
            mdlLotificacionSuelasPlantas.find("input").val("");
            $.each(mdlLotificacionSuelasPlantas.find("select"), function (k, v) {
                mdlLotificacionSuelasPlantas.find("select")[k].selectize.clear(true);
            });
            getSuelasPlantas();
            mdlLotificacionSuelasPlantas.find('#Ano').focus();
        });
        mdlLotificacionSuelasPlantas.find('#btnImprimir').on("click", function () {

            if (mdlLotificacionSuelasPlantas.find('#Articulo').val() !== '') {
                onImprimirReporte('onReporteLotificacionSuelasArticulo');
            } else {
                if (mdlLotificacionSuelasPlantas.find('#Tipo').val() !== '') {
                    onImprimirReporte('onReporteLotificacionSuelas');
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "DEBE DE ELEGIR UN TIPO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        if (action) {
                            mdlLotificacionSuelasPlantas.find("#Tipo")[0].selectize.focus();
                        }
                    });
                }
            }



        }
        );
        mdlLotificacionSuelasPlantas.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2016 || parseInt($(this).val()) > 2020 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlLotificacionSuelasPlantas.find("#Ano").val("");
                    mdlLotificacionSuelasPlantas.find("#Ano").focus();
                });
            }
        });
        mdlLotificacionSuelasPlantas.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlLotificacionSuelasPlantas.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlLotificacionSuelasPlantas.find("#Sem").change(function () {
            var ano = mdlLotificacionSuelasPlantas.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlLotificacionSuelasPlantas.find("#aSem").change(function () {
            var ano = mdlLotificacionSuelasPlantas.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
    });

    function onImprimirReporte(reporte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData(mdlLotificacionSuelasPlantas.find("#frmCaptura")[0]);
        $.ajax({
            url: base_url + 'index.php/ReportesProduccionJasper/' + reporte,
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
                    mdlLotificacionSuelasPlantas.find('#Ano').focus();
                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

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
    function getSuelasPlantas() {
        mdlLotificacionSuelasPlantas.find("#Articulo")[0].selectize.clear(true);
        mdlLotificacionSuelasPlantas.find("#Articulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/Articulos/getSuelasPlantas').done(function (data) {
            $.each(data, function (k, v) {
                mdlLotificacionSuelasPlantas.find("#Articulo")[0].selectize.addOption({text: v.Articulo, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

</script>


