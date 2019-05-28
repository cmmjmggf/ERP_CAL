<div class="modal " id="mdlCostoInventariosProceso"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Costeo de Inventario de Producción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-4">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                        <div class="col-4">
                            <label>Maq</label>
                            <input type="text" maxlength="3" class="form-control form-control-sm numbersOnly" id="Maq" name="Maq" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Mes </label>
                            <select class="form-control form-control-sm required" id="Mes" name="Mes" >
                                <option value=""></option>
                                <option value="1">1 Enero</option>
                                <option value="2">2 Febrero</option>
                                <option value="3">3 Marzo</option>
                                <option value="4">4 Abril</option>
                                <option value="5">5 Mayo</option>
                                <option value="6">6 Junio</option>
                                <option value="7">7 Julio</option>
                                <option value="8">8 Agosto</option>
                                <option value="9">9 Septiembre</option>
                                <option value="10">10 Octubre</option>
                                <option value="11">11 Noviembre</option>
                                <option value="12">12 Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-sm-6">
                            <label>Tipo <span class="badge badge-info" style="font-size: 14px;">1 Proceso, 2 Terminado, 3 Devolución, 4 Prod-Termin</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="1">1 Proceso</option>
                                <option value="2">2 Terminado</option>
                                <option value="3">3 Devolución</option>
                                <option value="4">4 Producción Terminada</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnGeneraCostos">GENERA COSTOS MP Y MO P' INVENTARIOS</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlCostoInventariosProceso = $('#mdlCostoInventariosProceso');
    var btnGeneraCostos = $('#btnGeneraCostos')
    $(document).ready(function () {

        btnGeneraCostos.click(function () {
            $.fancybox.open({
                src: base_url + '/GenerarCostosFabricacion.shoes/?origen=PRODUCCION',
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
        });

        mdlCostoInventariosProceso.on('shown.bs.modal', function () {
            mdlCostoInventariosProceso.find("input").val("");
            $.each(mdlCostoInventariosProceso.find("select"), function (k, v) {
                mdlCostoInventariosProceso.find("select")[k].selectize.clear(true);
            });
            mdlCostoInventariosProceso.find('#Ano').focus();
        });
        mdlCostoInventariosProceso.find('#btnImprimir').on("click", function () {
            var tipo = mdlCostoInventariosProceso.find('#Tipo').val();
            var num_mes = mdlCostoInventariosProceso.find('#Mes').val();
            var reporte = '';
            if (tipo) {



                HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});

                switch (tipo) {
                    case '1':
                        reporte = 'reporteCostoProdProcesoTerminado';
                        break;
                    case '2':
                        reporte = 'reporteCostoProdTerminado';
                        break;
                    case '3':
                        reporte = 'reporteCostoInvDevolucion'
                        break;
                    case '4':
                        reporte = 'reporteCostoProdTerminadoGen'
                        break;
                }

                var nom_mes = '';

                switch (num_mes) {
                    case '1':
                        nom_mes = 'Enero';
                        break;
                    case '2':
                        nom_mes = 'Febrero';
                        break;
                    case '3':
                        nom_mes = 'Marzo'
                        break;
                    case '4':
                        nom_mes = 'Abril'
                        break;
                    case '5':
                        nom_mes = 'Mayo';
                        break;
                    case '6':
                        nom_mes = 'Junio';
                        break;
                    case '7':
                        nom_mes = 'Julio'
                        break;
                    case '8':
                        nom_mes = 'Agosto';
                        break;
                    case '9':
                        nom_mes = 'Septiembre';
                        break;
                    case '10':
                        nom_mes = 'Octubre';
                        break;
                    case '11':
                        nom_mes = 'Noviembre'
                        break;
                    case '12':
                        nom_mes = 'Diciembre'
                        break;
                }

                var frm = new FormData(mdlCostoInventariosProceso.find("#frmCaptura")[0]);

                frm.append('Reporte', reporte);
                frm.append('NumMes', num_mes);
                frm.append('Mes', nom_mes);

                $.ajax({
                    url: base_url + 'index.php/ReportesProduccionJasper/onReporteCostoInvProduccion',
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
                            mdlCostoInventariosProceso.find('#Ano').focus();
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
                    text: "DEBES DE SELECCIONAR UN TIPO DE REPORTE",
                    icon: "error"
                }).then((action) => {
                    mdlCostoInventariosProceso.find('#Tipo')[0].selectize.focus();
                });
            }
        });
        mdlCostoInventariosProceso.find("#Ano").change(function () {
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
                    mdlCostoInventariosProceso.find("#Ano").val("");
                    mdlCostoInventariosProceso.find("#Ano").focus();
                });
            }
        });
        mdlCostoInventariosProceso.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
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

</script>



