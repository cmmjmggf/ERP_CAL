<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Pares producidos por departamento semana</h3>
    </div>
    <div class="card-body">
        <div class="row" align="center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>Año</label>
                <input type="text" id="Ano" name="Ano" class="form-control form-control-sm  numbersOnly" maxlength="4" >
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>Semana nomina actual</label>
                <input type="text" id="Semana" name="Semana" class="form-control form-control-sm  numbersOnly" maxlength="2" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="w-100"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>De la fecha</label>
                <input type="text" id="FechaInicial" name="FechaInicial" class="form-control form-control-sm date" readonly="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label>A la fecha</label>
                <input type="text" id="FechaFinal" name="FechaFinal" class="form-control form-control-sm date" readonly="">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="w-100 m-2"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetallePespunte">
                    <label class="custom-control-label" for="chkDetallePespunte" >Detalle de pespunte</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleMontado">
                    <label class="custom-control-label" for="chkDetalleMontado" >Detalle montado</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleAdorno">
                    <label class="custom-control-label" for="chkDetalleAdorno" >Detalle adorno</label>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="chkDetalleTejido">
                    <label class="custom-control-label" for="chkDetalleTejido" >Detalle tejido</label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            <div class="col-12 mt-4">
                <p class="font-weight-bold">Nota: Para imprimir todos los departamentos por dia no seleccione ninguna casilla</p>
            </div>
            <div class="w-100 my-3"></div>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
            <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Anio = pnlTablero.find("#Ano"), Semana = pnlTablero.find("#Semana"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            FechaInicial = pnlTablero.find("#FechaInicial"),
            FechaFinal = pnlTablero.find("#FechaFinal"),
            Maquila = pnlTablero.find("#Maquila");

    function onDetallechk(chk) {
        pnlTablero.find("#chkDetallePespunte")[0].checked = false;
        pnlTablero.find("#chkDetalleMontado")[0].checked = false;
        pnlTablero.find("#chkDetalleAdorno")[0].checked = false;
        pnlTablero.find("#chkDetalleTejido")[0].checked = false;
        pnlTablero.find("#" + chk)[0].checked = true;
    }
    $(document).ready(function () {
        Anio.val(new Date().getFullYear());
        getSemanaActual('<?php print Date('d/m/Y'); ?>');

        Semana.on('keydown', function (e) {
            if (e.keyCode === 13 && Semana.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere...'
                });
                $.get('<?php print base_url('ParesProducidosPorDepartamentoSemana/getFechasXSemana'); ?>', {
                    SEMANA: Semana.val()
                }).done(function (a, b, c) {
                    console.log(a);
                    var d = JSON.parse(a);
                    if (d.length > 0) {
                        Semana.val(d[0].SEMANA);
                        FechaInicial.val(d[0].FEINI);
                        FechaFinal.val(d[0].FEFIN);
                    }
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

        pnlTablero.find("#chkDetallePespunte").on('change', function () {
            if (pnlTablero.find("#chkDetallePespunte")[0].checked) {
                onDetallechk("chkDetallePespunte");
            }
        });

        pnlTablero.find("#chkDetalleMontado").on('change', function () {
            if (pnlTablero.find("#chkDetalleMontado")[0].checked) {
                onDetallechk("chkDetalleMontado");
            }
        });

        pnlTablero.find("#chkDetalleAdorno").on('change', function () {
            if (pnlTablero.find("#chkDetalleAdorno")[0].checked) {
                onDetallechk("chkDetalleAdorno");
            }
        });

        pnlTablero.find("#chkDetalleTejido").on('change', function () {
            if (pnlTablero.find("#chkDetalleTejido")[0].checked) {
                onDetallechk("chkDetalleTejido");
            }
        });

        btnAceptar.click(function () {
            btnAceptar.attr('disabled', true);
            HoldOn.open({
                theme: 'sk-cube',
                message: 'Por favor espere...'
            });
            if (Anio.val() && Semana.val() && FechaInicial.val() && FechaFinal.val()) {
                $.post('<?php print base_url('ParesProducidosPorDepartamentoSemana/getReporte'); ?>', {
                    FECHA_INICIAL: FechaInicial.val().trim() !== '' ? parseInt(FechaInicial.val()) : '',
                    FECHA_FINAL: FechaFinal.val().trim() !== '' ? parseInt(FechaFinal.val()) : '',
                    ANIO: Anio.val().trim() !== '' ? Anio.val() : '',
                    SEMANA: Semana.val().trim() !== '' ? Semana.val() : '',
                    TIPO: pnlTablero.find("#chkDetallePespunte")[0].checked ? 1 :
                            pnlTablero.find("#chkDetalleMontado")[0].checked ? 2 :
                            pnlTablero.find("#chkDetalleAdorno")[0].checked ? 3 :
                            pnlTablero.find("#chkDetalleTejido")[0].checked ? 4 : 0
                }).done(function (data, x, jq) {
                    onBeep(1);
                    onImprimirReporteFancy(base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs');
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    HoldOn.close();
                    btnAceptar.attr('disabled', false);
                });
            } else {
                if (!Anio.val()) {
                    swal('ATENCIÓN', 'EL AÑO ES REQUERIDO', 'warning').then((value) => {
                        if (value) {
                            Anio.focus().select();
                            btnAceptar.attr('disabled', false);
                        }
                    });
                }
                if (!Semana.val()) {
                    swal('ATENCIÓN', 'LA SEMANA ES REQUERIDA', 'warning').then((value) => {
                        if (value) {
                            Semana.focus().select();
                            btnAceptar.attr('disabled', false);
                        }
                    });
                }
                if (!FechaInicial.val() || !FechaFinal.val()) {
                    swal('ATENCIÓN', 'LAS FECHAS SON REQUERIDAS', 'warning').then((value) => {
                        FechaInicial.focus().select();
                        btnAceptar.attr('disabled', false);
                    });
                }
            }
        });
    });

    function getSemanaActual(fecha) {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Espere...'
        });
        $.get('<?php print base_url('ParesProducidosPorDepartamentoSemana/getSemanaActual'); ?>', {
            FECHA: fecha
        }).done(function (a, b, c) {
            console.log(a);
            var d = JSON.parse(a);
            if (d.length > 0) {
                Semana.val(d[0].SEMANA);
                FechaInicial.val(d[0].FEINI);
                FechaFinal.val(d[0].FEFIN);
            }
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }
</script>
<style>
    .btn-indigo {
        color: #fff;
        background-color: #3F51B5;
        border-color: #3F51B5;
    }
    .btn-indigo:not(:disabled):not(.disabled):active, 
    .btn-indigo:not(:disabled):not(.disabled).active, 
    .show > .btn-indigo.dropdown-toggle {
        color: #fff;
        background-color: #99cc00;
        border: 2px solid #99cc00;
        font-weight: bold;
    }   
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }
    .card-body{
        padding-top: 10px;
    }
    .card-header{
        padding: 0px;
    }
    li.list-group-item {  
        padding-top: 3px;
        padding-bottom: 3px;
    }  
    li.list-group-item:hover { 
        font-weight: bold; 
        color: #fff;
        cursor: pointer;
        background-color: #3f51b5;  
        -webkit-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        -moz-box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        box-shadow: 0px 3px 67px 1px rgba(47,56,99,1);
        padding-top: 3px;
        padding-bottom: 3px; 
        animation: myfirst .4s;
        -moz-animation:myfirst 1.4s infinite; /* Firefox */
        -webkit-animation:myfirst 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }
    .li-selected{
        font-weight: bold; 
        color: #D32F2F;
        cursor: pointer;
        background-color: #fff;   
        padding-top: 3px;
        padding-bottom: 3px;  
        border-radius: 0px;
        font-weight: bold;
    }
    .li-selected span.badge-primary{
        font-weight: bold; 
        color: #fff;
        background-color: #D32F2F;   
        padding-top: 3px;
        padding-bottom: 3px;   
    } 
    ul.list-group {
        animation: highlight .4s;
        -moz-animation:highlight 1.4s infinite; /* Firefox */
        -webkit-animation:highlight 1.4s infinite; /* Safari and Chrome */
        border-radius: 5px;
    }

    table tbody tr:hover { 
        font-weight:normal !important; 
    }

    .box-success{
        box-shadow: 0 0 0 0.2rem #CDDC39 !important;
    }

    .box-info{
        box-shadow: 0 0 0 0.2rem #33C2E1 !important;
    }

    @-moz-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;        font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-webkit-keyframes myfirst /* Firefox */
    {
        0%   {    border: 1px solid #2196F3}
        50%  {    border: 1px solid #6610f2;font-weight: bold;}
        100%   {border: 1px solid #2196F3}
    }

    @-moz-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;        }
        100%   {border: 1px solid #3F51B5}
    }

    @-webkit-keyframes highlight /* Firefox */
    {
        0%   {    border: 1px solid #3F51B5}
        50%  {    border: 1px solid #2196f3;}
        100%   {border: 1px solid #3F51B5}
    }

    /*SWITCH*/
    .switch {
        font-size: 1rem;
        position: relative;
    }
    .switch input {
        position: absolute;
        height: 1px;
        width: 1px;
        background: none;
        border: 0;
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        overflow: hidden;
        padding: 0;
    }
    .switch input + label {
        position: relative;
        min-width: calc(calc(2.375rem * .8) * 2);
        border-radius: calc(2.375rem * .8);
        height: calc(2.375rem * .8);
        line-height: calc(2.375rem * .8);
        display: inline-block;
        cursor: pointer;
        outline: none;
        user-select: none;
        vertical-align: middle;
        text-indent: calc(calc(calc(2.375rem * .8) * 2) + .5rem);
    }
    .switch input + label::before,
    .switch input + label::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(calc(2.375rem * .8) * 2);
        bottom: 0;
        display: block;
    }
    .switch input + label::before {
        right: 0;
        background-color: #dee2e6;
        border-radius: calc(2.375rem * .8);
        transition: 0.2s all;
    }
    .switch input + label::after {
        top: 2px;
        left: 2px;
        width: calc(calc(2.375rem * .8) - calc(2px * 2));
        height: calc(calc(2.375rem * .8) - calc(2px * 2));
        border-radius: 50%;
        background-color: white;
        transition: 0.2s all;
    }
    .switch input:checked + label::before {
        background-color: #08d;
    }
    .switch input:checked + label::after {
        margin-left: calc(2.375rem * .8);
    }
    .switch input:focus + label::before {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 221, 0.25);
    }
    .switch input:disabled + label {
        color: #868e96;
        cursor: not-allowed;
    }
    .switch input:disabled + label::before {
        background-color: #e9ecef;
    }
    .switch.switch-sm {
        font-size: 0.875rem;
    }
    .switch.switch-sm input + label {
        min-width: calc(calc(1.9375rem * .8) * 2);
        height: calc(1.9375rem * .8);
        line-height: calc(1.9375rem * .8);
        text-indent: calc(calc(calc(1.9375rem * .8) * 2) + .5rem);
    }
    .switch.switch-sm input + label::before {
        width: calc(calc(1.9375rem * .8) * 2);
    }
    .switch.switch-sm input + label::after {
        width: calc(calc(1.9375rem * .8) - calc(2px * 2));
        height: calc(calc(1.9375rem * .8) - calc(2px * 2));
    }
    .switch.switch-sm input:checked + label::after {
        margin-left: calc(1.9375rem * .8);
    }
    .switch.switch-lg {
        font-size: 1.25rem;
    }
    .switch.switch-lg input + label {
        min-width: calc(calc(3rem * .8) * 2);
        height: calc(3rem * .8);
        line-height: calc(3rem * .8);
        text-indent: calc(calc(calc(3rem * .8) * 2) + .5rem);
    }
    .switch.switch-lg input + label::before {
        width: calc(calc(3rem * .8) * 2);
    }
    .switch.switch-lg input + label::after {
        width: calc(calc(3rem * .8) - calc(2px * 2));
        height: calc(calc(3rem * .8) - calc(2px * 2));
    }
    .switch.switch-lg input:checked + label::after {
        margin-left: calc(3rem * .8);
    }
    .switch + .switch {
        margin-left: 1rem;
    } 
    .dropdown-menu {
        margin-top: 0.75rem;
    }
    .custom-control.custom-checkbox:hover{
        cursor: pointer !important;
    }
</style>A