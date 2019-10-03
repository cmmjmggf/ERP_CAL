<div class="modal " id="mdlEstadisticasIngresosEgresos"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estadísitica de ingresos y egresos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pnlCapturaReporteIngreEgre">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 col-xl-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="AnoIngreEgre" name="AnoIngreEgre" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-xl-4">
                            <label>De la Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="dSemIngreEgre" name="dSemIngreEgre" required="">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-xl-4">
                            <label>A la Sem</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly " id="aSemIngreEgre" name="aSemIngreEgre" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Del</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaIniIngreEgre" name="FechaIniIngreEgre">
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-xl-4">
                            <label>Al</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm " readonly="" id="FechaFinIngreEgre" name="FechaFinIngreEgre">
                        </div>
                        <div class="col-4">
                            <label>Tipo <span class="badge badge-info" style="font-size: 14px">1=Ingresos / 2=Egresos</span></label>
                            <select id="TipoEstIngEg" name="TipoEstIngEg" class="form-control form-control-sm ">
                                <option value=""></option>
                                <option value="1">1 INGRESOS</option>
                                <option value="2">2 EGRESOS</option>
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
    var mdlEstadisticasIngresosEgresos = $('#mdlEstadisticasIngresosEgresos');
    $(document).ready(function () {
        mdlEstadisticasIngresosEgresos.on('shown.bs.modal', function () {
            setFocusSelectToInputOnChange('#TipoEstIngEg', '#btnImprimir', mdlEstadisticasIngresosEgresos);
            mdlEstadisticasIngresosEgresos.find("input").val("");
            $.each(mdlEstadisticasIngresosEgresos.find("select"), function (k, v) {
                mdlEstadisticasIngresosEgresos.find("select")[k].selectize.clear(true);
            });
            mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre").val(new Date().getFullYear());
            mdlEstadisticasIngresosEgresos.find('#AnoIngreEgre').focus().select();
        });
        mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre").keypress(function (e) {
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
                        mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre").val("");
                        mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre").focus();
                    });
                } else {
                    mdlEstadisticasIngresosEgresos.find("#dSemIngreEgre").focus().select();
                }
            }
        });
        mdlEstadisticasIngresosEgresos.find("#dSemIngreEgre").keypress(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {
                    var ano = mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre");
                    onComprobarSemanasNominaEstIngEgre($(this), ano.val());
                }
            }
        });
        mdlEstadisticasIngresosEgresos.find("#aSemIngreEgre").keypress(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {
                    var ano = mdlEstadisticasIngresosEgresos.find("#AnoIngreEgre");
                    onComprobarSemanasNominaEstIngEgre2($(this), ano.val());

                }
            }
        });
        mdlEstadisticasIngresosEgresos.find('#btnImprimir').on("click", function () {
            isValid('pnlCapturaReporteIngreEgre');
            if (valido) {
                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                var frm = new FormData(mdlEstadisticasIngresosEgresos.find("#frmCaptura")[0]);
                $.ajax({
                    url: base_url + 'index.php/ReportesNominaJasper/onImprimirIngreEgre',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    if (data.length !== '0') {

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
                                        width: "100%",
                                        height: "100%"
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
                            mdlEstadisticasIngresosEgresos.find('#btnImprimir').focus();
                        });
                    }
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        })

    });


    function onComprobarSemanasNominaEstIngEgre2(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlEstadisticasIngresosEgresos.find('#FechaFinIngreEgre').val(data[0].FechaFin);
                mdlEstadisticasIngresosEgresos.find('#TipoEstIngEg')[0].selectize.focus();

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

    function onComprobarSemanasNominaEstIngEgre(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                mdlEstadisticasIngresosEgresos.find('#FechaIniIngreEgre').val(data[0].FechaIni);
                mdlEstadisticasIngresosEgresos.find("#aSemIngreEgre").focus();
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

</script>

