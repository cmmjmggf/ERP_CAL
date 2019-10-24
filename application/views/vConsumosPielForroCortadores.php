<div class="card m-3 animated fadeIn" id="mdlConsumosPielForro">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Consumo piel forro, cortador</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Maquila</label>
                <input type="text" id="Maquila" name="Maquila" class="form-control form-control-sm" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>De sem</label>
                <input type="text" id="SemanaInicial" name="SemanaInicial" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>A sem</label>
                <input type="text" id="SemanaFinal" name="SemanaFinal" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Cortador</label>
                <select id="Cortador" name="Cortador" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Articulo</label>
                <select id="Articulo" name="Articulo" class="form-control form-control-sm">
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Fecha Inicial</label>
                <input type="text" id="FechaInicial" name="FechaInicial"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Fecha Final</label>
                <input type="text" id="FechaFinal" name="FechaFinal"  class="form-control form-control-sm date notEnter" placeholder="" >
            </div> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                <div class="alert alert-dismissible alert-danger"> 
                    <strong>Nota!</strong> Si desea información entre fechas solo capture maquila y fechas.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2">
                <div class="alert alert-dismissible alert-danger"> 
                    <strong>Nota!</strong> El resultado de este reporte es lo que se ha entregado de almacen a corte solamente. No tiene que ser el programa completo.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2" align="center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" id="btnAceptarPiel" name="btnAceptarPiel">CONSUMO DE PIEL</button>
                    <button type="button" class="btn btn-primary" id="btnAceptarForro" name="btnAceptarForro">CONSUMO DE FORRO</button>
                    <button type="button" class="btn btn-warning" id="btnAceptarPielGeneral" name="btnAceptarPielGeneral">CONSUMO DE PIEL GENERAL</button>
                    <button type="button" class="btn btn-danger" id="btnAceptarForroGeneral" name="btnAceptarForroGeneral">CONSUMO DE FORRO GENERAL</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var master_url_modal = base_url + 'index.php/ConsumosPielForroCortadores/';
    var mdlConsumosPielForro = $("#mdlConsumosPielForro");
    var Maquila = mdlConsumosPielForro.find("#Maquila"), SemanaInicial = mdlConsumosPielForro.find("#SemanaInicial"), SemanaFinal = mdlConsumosPielForro.find("#SemanaFinal");
    var Ano = mdlConsumosPielForro.find("#Ano"), Cortador = mdlConsumosPielForro.find("#Cortador"), Articulo = mdlConsumosPielForro.find("#Articulo");
    var FechaInicial = mdlConsumosPielForro.find("#FechaInicial"), FechaFinal = mdlConsumosPielForro.find("#FechaFinal");
    var btnAceptar = mdlConsumosPielForro.find("#btnAceptar");
    var btnAceptarPiel = mdlConsumosPielForro.find("#btnAceptarPiel"),
            btnAceptarForro = mdlConsumosPielForro.find("#btnAceptarForro"),
            btnAceptarPielGeneral = mdlConsumosPielForro.find("#btnAceptarPielGeneral"),
            btnAceptarForroGeneral = mdlConsumosPielForro.find("#btnAceptarForroGeneral");

    $(document).ready(function () {

        btnAceptarForroGeneral.click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForroGeneral'); ?>',
                    {
                        TIPO: 2,
                        MAQUILA: Maquila.val(),
                        SEMANA_INICIAL: SemanaInicial.val(),
                        SEMANA_FINAL: SemanaFinal.val(),
                        ANIO: Ano.val(),
                        CORTADOR: Cortador.val(),
                        ARTICULO: Articulo.val(),
                        FECHA_INICIAL: FechaInicial.val(),
                        FECHA_FINAL: FechaFinal.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        btnAceptarPielGeneral.click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForroGeneral'); ?>',
                    {
                        TIPO: 1,
                        MAQUILA: Maquila.val(),
                        SEMANA_INICIAL: SemanaInicial.val(),
                        SEMANA_FINAL: SemanaFinal.val(),
                        ANIO: Ano.val(),
                        CORTADOR: Cortador.val(),
                        ARTICULO: Articulo.val(),
                        FECHA_INICIAL: FechaInicial.val(),
                        FECHA_FINAL: FechaFinal.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        btnAceptarForro.click(function () {
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForro'); ?>',
                    {
                        TIPO: 2,
                        MAQUILA: Maquila.val(),
                        SEMANA_INICIAL: SemanaInicial.val(),
                        SEMANA_FINAL: SemanaFinal.val(),
                        ANIO: Ano.val(),
                        CORTADOR: Cortador.val(),
                        ARTICULO: Articulo.val(),
                        FECHA_INICIAL: FechaInicial.val(),
                        FECHA_FINAL: FechaFinal.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        btnAceptarPiel.click(function () {
            console.log('xxxxxxxxxxxxxxxxxxxxxx')
            HoldOn.open({
                theme: 'sk-cube',
                message: 'GENERANDO...'
            });
            $.post('<?php print base_url('ConsumosPielForroCortadores/getReportePielForro'); ?>',
                    {
                        TIPO: 1,
                        MAQUILA: Maquila.val(),
                        SEMANA_INICIAL: SemanaInicial.val(),
                        SEMANA_FINAL: SemanaFinal.val(),
                        ANIO: Ano.val(),
                        CORTADOR: Cortador.val(),
                        ARTICULO: Articulo.val(),
                        FECHA_INICIAL: FechaInicial.val(),
                        FECHA_FINAL: FechaFinal.val()
                    }).done(function (data, x, jq) {
                onImprimirReporteFancy(data);
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                onBeep(2);
                swal('ATENCIÓN', 'HA OCURRIDO UN PROBLEMA AL GENERAR LOS REPORTES, REVISE LA CONSOLA PARA MÁS DETALLES', 'warning');
            }).always(function () {
                console.log('ok');
                HoldOn.close();
            });
        });

        SemanaInicial.on('keydown', function (e) {
            onVerificarSemana(e, $(this));
        });

        SemanaFinal.on('keydown', function (e) {
            onVerificarSemana(e, $(this));
        });

        Maquila.on('keydown', function (e) {
            onComprobarMaquilas(e, $(this));
        });

        getCortadores();
        getArticulos();

        mdlConsumosPielForro.find("input").val('');
        mdlConsumosPielForro.find("#Articulo")[0].selectize.clear(true);
        mdlConsumosPielForro.find("#Cortador")[0].selectize.clear(true);
        mdlConsumosPielForro.find("#Ano").val(new Date().getFullYear());
        mdlConsumosPielForro.find("#Maquila").focus();
    });

    function getCortadores() {
        $.getJSON(master_url_modal + 'getCortadores').done(function (data) {
            $.each(data, function (k, v) {
                mdlConsumosPielForro.find("#Cortador")[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });
    }

    function getArticulos() {
        HoldOn.open({
            theme: 'sk-bounce',
            message: 'Por favor espere...'
        });
        $.getJSON(master_url_modal + 'getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                mdlConsumosPielForro.find("#Articulo")[0].selectize.addOption({text: v.CLAVE_ARTICULO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onComprobarMaquilas(e, input) {
        if (e.keyCode === 13 && input.val() !== '') {
            $.getJSON('<?php print base_url('ConsumosPielForroCortadores/onComprobarMaquilas'); ?>', {MAQUILA: input.val()}).done(function (data, x, jq) {
                if (parseInt(data[0].EXISTE_MAQUILA) <= 0) {
                    swal('ATENCIÓN', 'LA MAQUILA ESPECIFICADA NO EXISTE', 'warning').then((value) => {
                        input.focus();
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {

            });
        }
    }

    function onVerificarSemana(e, input) {
        if (e.keyCode === 13 && input.val() !== '') {
            $.getJSON('<?php print base_url('ConsumosPielForroCortadores/onChecarSemanaValida'); ?>', {SEMANA: input.val()}).done(function (data, x, jq) {
                if (parseInt(data[0].SEMANA_NO_CERRADA) === 1) {
                    swal('ATENCIÓN', 'LA SEMANA ESPECIFICADA NO EXISTE', 'warning').then((value) => {
                        input.focus();
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {

            });
        }
    }
</script>