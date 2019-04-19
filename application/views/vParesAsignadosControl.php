<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header" align="center">
        <h3 class="font-weight-bold">Pares asignados</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <label>De la Maquila</label>
                <input type="text" id="ParesMaquilaInicial" name="ParesMaquilaInicial" class="form-control form-control-sm numbersOnly" autofocus="">
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <label>A la Maquila</label>
                <input type="text" id="ParesMaquilaFinal" name="ParesMaquilaFinal" class="form-control form-control-sm  numbersOnly">
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2">
                <label>De sem</label>
                <input type="text" id="ParesSemanaInicial" name="ParesSemanaInicial" class="form-control form-control-sm  numbersOnly">
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-2">
                <label>A sem</label>
                <input type="text" id="ParesSemanaFinal" name="ParesSemanaFinal" class="form-control form-control-sm  numbersOnly">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-2">
                <label>Año</label>
                <input type="text" id="ParesAnio" name="ParesAnio" class="form-control form-control-sm  numbersOnly">
            </div>

            <div class="w-100 my-3"></div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4" align="center">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-indigo active">
                        <input type= "radio" name="btnControl" id="btnControl" autocomplete="off" checked> CONTROL
                    </label>
                    <label class="btn btn-indigo">
                        <input type="radio" name="btnEsponjasYLatex" id="btnEsponjasYLatex" autocomplete="off"> ESPONJAS Y LATEX
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <div class="form-group">
                    <span class="switch switch-lg">
                        <input id="rConNumeracion" name="rConNumeracion"  type="checkbox" class="switch" id="rConNumeracion">
                        <label for="rConNumeracion">Con numeración</label>
                    </span>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
            <button type="button" class="btn btn-primary" id="btnAceptar">Aceptar</button>
        </div>
    </div>
</div>
<div id="rpts">

</div>
<script>
    var pnlTablero = $("#pnlTablero"), ParesAnio = pnlTablero.find("#ParesAnio"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            ParesMaquilaInicial = pnlTablero.find("#ParesMaquilaInicial"),
            ParesMaquilaFinal = pnlTablero.find("#ParesMaquilaFinal"),
            ParesSemanaInicial = pnlTablero.find("#ParesSemanaInicial"),
            ParesSemanaFinal = pnlTablero.find("#ParesSemanaFinal");

    $(document).ready(function () {
        ParesAnio.val(new Date().getFullYear());

        btnAceptar.click(function () {
            if (ParesMaquilaInicial.val() && ParesMaquilaFinal.val()
                    && ParesSemanaInicial.val() && ParesSemanaFinal.val()) {
                HoldOn.open({
                    theme: 'sk-cube',
                    message: 'Por favor espere...'
                });
                $.post('<?php print base_url('ParesAsignadosControl/getParesAsignadosControl'); ?>', {
                    MAQUILA_INICIAL: ParesMaquilaInicial.val().trim() !== '' ? parseInt(ParesMaquilaInicial.val()) : '',
                    MAQUILA_FINAL: ParesMaquilaFinal.val().trim() !== '' ? parseInt(ParesMaquilaFinal.val()) : '',
                    SEMANA_INICIAL: ParesSemanaInicial.val().trim() !== '' ? ParesSemanaInicial.val() : '',
                    SEMANA_FINAL: ParesSemanaFinal.val().trim() !== '' ? ParesSemanaFinal.val() : '',
                    ANIO: ParesAnio.val().trim() !== '' ? ParesAnio.val() : '',
                    TIPO: pnlTablero.find("#btnControl")[0].checked ? 1 :
                            pnlTablero.find("#btnEsponjasYLatex")[0].checked ? 2 : 0,
                    NUMERACION: pnlTablero.find("#rConNumeracion")[0].checked ? 1 : 0
                }).done(function (data, x, jq) { 
                    onBeep(1);
                    onImprimirReporteFancyArray(JSON.parse(data));
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'TODOS LOS CAMPOS SON REQUERIDOS', 'warning').then((value) => {
                    if (ParesMaquilaInicial.val()) {
                        ParesMaquilaInicial.focus();
                    } else if (ParesMaquilaFinal.val()) {
                        ParesMaquilaFinal.focus().select();
                    } else if (ParesSemanaInicial.val()) {
                        ParesSemanaInicial.focus().select();
                    } else if (ParesSemanaFinal.val()) {
                        ParesSemanaFinal.focus().select();
                    }
                });
            }
        });

    });
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
</style>