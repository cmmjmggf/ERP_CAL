<div class="modal " id="mdlAvanceProduccion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Reporte Avance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
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
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="custom-control custom-checkbox  ">
                                <input type="checkbox" class="custom-control-input" id="TresDias">
                                <label class="custom-control-label text-info labelCheck" for="TresDias">+3 Días</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="text-danger">Nota. Seleccione un Tipo/Filtro, en caso de ser necesario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label>Tipo/Filtro</label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="1">1 CON CÉLULA DE PESPUNTE</option>
                                <option value="2">2 CON TEJEDORA</option>
                                <option value="3">3 CON SUELA</option>
                                <option value="4">4 ORDENADO POR LINEA/FECHA ENTREGA</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-success" id="btnExcel"><span class="fa fa-file-excel"> </span> EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlAvanceProduccion = $('#mdlAvanceProduccion'),
            anio_actual = <?php print Date('Y'); ?>;
    $(document).ready(function () {
        mdlAvanceProduccion.on('shown.bs.modal', function () {
            handleEnterDiv(mdlAvanceProduccion);
            mdlAvanceProduccion.find("input").val("");
            $.each(mdlAvanceProduccion.find("select"), function (k, v) {
                mdlAvanceProduccion.find("select")[k].selectize.clear(true);
            });
            mdlAvanceProduccion.find('#Ano').val(anio_actual);
            mdlAvanceProduccion.find('#Ano').focus().select();
            
        });
        mdlAvanceProduccion.find('#btnExcel').on("click", function () {

            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlAvanceProduccion.find("#frmCaptura")[0]);
            $.ajax({
                url: base_url + 'index.php/ReportesProduccionJasper/onReporteAvanceNormalExcel',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    window.open(data, '_blank');
                    onNotifyOld('<span class="fa fa-check fa-lg"></span>', 'REPORTE EN EXCEL GENERADO', 'success');
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                        icon: "error"
                    }).then((action) => {
                        mdlAvanceProduccion.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });

        });
        mdlAvanceProduccion.find('#btnImprimir').on("click", function () {
            mdlAvanceProduccion.find('#btnImprimir').attr('disabled', true);
            var TresDias = mdlAvanceProduccion.find("#TresDias")[0].checked ? true : false;

            if (TresDias) {
                onImprimirReporte('onReporteAvanceNormalDeptoTresdias');
            } else {
                if (mdlAvanceProduccion.find('#Tipo').val() !== '') {
                    HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    var frm = new FormData(mdlAvanceProduccion.find("#frmCaptura")[0]);
                    $.ajax({
                        url: base_url + 'index.php/ReportesProduccionJasper/onReporteAvancePorTipo',
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: frm
                    }).done(function (data, x, jq) {
                        console.log(data);

                        if (data.length > 0) {

                            onImprimirReporteFancyAFC(data, function (a, b) {
                                mdlAvanceProduccion.find('#btnImprimir').attr('disabled', false);
                            });
                        } else {
                            swal({
                                title: "ATENCIÓN",
                                text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                                icon: "error"
                            }).then((action) => {
                                mdlAvanceProduccion.find('#Ano').focus();
                            });
                        }
                        HoldOn.close();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                        HoldOn.close();
                    });
                } else {
                    onImprimirReporte('onReporteAvanceNormalDepto');
                }
            }
        });
        mdlAvanceProduccion.find("#Ano").change(function () {
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
                    mdlAvanceProduccion.find("#Ano").val("");
                    mdlAvanceProduccion.find("#Ano").focus();
                });
            }
        });
        mdlAvanceProduccion.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlAvanceProduccion.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlAvanceProduccion.find("#Sem").change(function () {
            var ano = mdlAvanceProduccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlAvanceProduccion.find("#aSem").change(function () {
            var ano = mdlAvanceProduccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
    });

    function onImprimirReporte(reporte) {
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData(mdlAvanceProduccion.find("#frmCaptura")[0]);
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
                //window.open(data, '_blank');
                onImprimirReporteFancyAFC(data, function (a, b) {
                    mdlAvanceProduccion.find('#btnImprimir').attr('disabled', false);
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DATOS PARA ESTE REPORTE",
                    icon: "error"
                }).then((action) => {
                    mdlAvanceProduccion.find('#Ano').focus();
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


</script>


