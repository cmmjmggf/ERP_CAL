<div class="modal " id="mdlExplosionSemanalOrdComProyeccion"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Explosión de Materiales con existencia, Orden de Compra y Proyección</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-12">
                            <label class="text-danger">Nota. El % extra (PIEL Y FORRO) se tomará del No. de piezas del Estilo</label>
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

                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 mt-2">
                            <legend class="badge badge-info" style="font-size: 14px;">Fechas para tomar el inventario inicial y movimientos por artículo</legend>
                        </div>
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIni" name="FechaIni" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFin" name="FechaFin" >
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 col-sm-12">
                            <label>Tipo <span class="badge badge-info mb-2" style="font-size: 12px;">10 Piel/Forro, 80 Suela, 90 Peletería</span></label>
                            <select class="form-control form-control-sm required selectize" id="Tipo" name="Tipo" >
                                <option value=""></option>
                                <option value="10">10 PIEL Y FORRO</option>
                                <option value="80">80 SUELA</option>
                                <option value="90">90 INDIRECTOS</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnImprimir"><span class="fa fa-file-pdf"> </span> IMPRIMIR</button>
                <button type="button" class="btn btn-success" id="btnExcel"><span class="fa fa-file-excel"> </span> EXCEL</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlExplosionSemanalOrdComProyeccion = $('#mdlExplosionSemanalOrdComProyeccion');
    $(document).ready(function () {
        validacionSelectPorContenedor(mdlExplosionSemanalOrdComProyeccion);
        setFocusSelectToInputOnChange('#Tipo', '#btnImprimir', mdlExplosionSemanalOrdComProyeccion);
        mdlExplosionSemanalOrdComProyeccion.on('shown.bs.modal', function () {
            handleEnterDiv(mdlExplosionSemanalOrdComProyeccion);
            mdlExplosionSemanalOrdComProyeccion.find("input").val("");
            $.each(mdlExplosionSemanalOrdComProyeccion.find("select"), function (k, v) {
                mdlExplosionSemanalOrdComProyeccion.find("select")[k].selectize.clear(true);
            });
            mdlExplosionSemanalOrdComProyeccion.find('#FechaFin').val(getToday());
            mdlExplosionSemanalOrdComProyeccion.find('#Ano').focus();
        });
        mdlExplosionSemanalOrdComProyeccion.find('#btnExcel').on("click", function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlExplosionSemanalOrdComProyeccion.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/ReporteExplosionConProyeccion/onReporteExplosionProyeccionExcel',
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
                        text: "NO EXISTEN PROGRAMACION DE LA SEMANA/MAQUILA",
                        icon: "error"
                    }).then((action) => {
                        mdlExplosionSemanalOrdComProyeccion.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });
        mdlExplosionSemanalOrdComProyeccion.find('#btnImprimir').on("click", function () {
            mdlExplosionSemanalOrdComProyeccion.find('#btnImprimir').attr('disabled', true);
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlExplosionSemanalOrdComProyeccion.find("#frmCaptura")[0]);

            $.ajax({
                url: base_url + 'index.php/ReporteExplosionConProyeccion/onReporteExplosionProyeccion',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                if (data.length > 0) {
                    onImprimirReporteFancyAFC(data, function (a, b) {
                        mdlExplosionSemanalOrdComProyeccion.find('#btnImprimir').attr('disabled', false);
                    });

                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NO EXISTEN PROGRAMACION DE LA SEMANA/MAQUILA",
                        icon: "error"
                    }).then((action) => {
                        mdlExplosionSemanalOrdComProyeccion.find('#Ano').focus();
                    });
                }
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
            });
        });

        mdlExplosionSemanalOrdComProyeccion.find("#Ano").change(function () {
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
                    mdlExplosionSemanalOrdComProyeccion.find("#Ano").val("");
                    mdlExplosionSemanalOrdComProyeccion.find("#Ano").focus();
                });
            }
        });
        mdlExplosionSemanalOrdComProyeccion.find("#Maq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanalOrdComProyeccion.find("#aMaq").change(function () {
            onComprobarMaquilas($(this));
        });
        mdlExplosionSemanalOrdComProyeccion.find("#Sem").change(function () {
            var ano = mdlExplosionSemanalOrdComProyeccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });
        mdlExplosionSemanalOrdComProyeccion.find("#aSem").change(function () {
            var ano = mdlExplosionSemanalOrdComProyeccion.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
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

