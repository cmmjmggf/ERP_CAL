<div id="mdlParesProducidosPorDepartamento" class="modal fade" >
    <div class="modal-dialog notdraggable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-print"></span> Pares producidos por departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                        <label>De la fecha</label>
                        <input type="text" id="xFechaInicial" name="xFechaInicial" class="form-control form-control-sm date notEnter" autofocus="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                        <label>A la fecha</label>
                        <input type="text" id="xFechaFinal" name="xFechaFinal" class="form-control form-control-sm date notEnter" autofocus="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                        <label>Maquila</label>
                        <input type="text" id="xMaquila" name="xMaquila" class="form-control form-control-sm  numbersOnly" maxlength="2">
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnCorteP" name="btnCorte" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> CORTE PIEL
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnCorteF" name="btnCorte" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> CORTE FORRO
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnRayado" name="btnRayado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> RAYADO
                        </button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnRebajado" name="btnRebajado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> REBAJADO
                        </button>
                    </div>


                    <div class="col-4">
                        <button type="button" id="btnFoleado" name="btnFoleado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> FOLEADO
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnEntretelado" name="btnEntretelado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> ENTRETELADO
                        </button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnAlmCorte" name="btnAlmCorte" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #990000;  border-color: #990000;">
                            <span class="fa fa-file"></span> ALM-CORTE
                        </button>
                    </div>

                    <div class="col-4">
                        <button type="button" id="btnPespunte" name="btnPespunte" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> PESPUNTE
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnEnsuelado" name="btnEnsuelado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> ENSUELADO
                        </button>
                    </div>

                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnAlmPespunte" name="btnAlmPespunte" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #990000;  border-color: #990000;">
                            <span class="fa fa-file"></span> ALM-PESPUNTE
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnTejido" name="btnTejido" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> TEJIDO
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnAlmTejido" name="btnAlmTejido" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #990000;  border-color: #990000;">
                            <span class="fa fa-file"></span> ALM-TEJIDO
                        </button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnMontado" name="btnMontado" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> MONTADO
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnAdorno" name="btnAdorno" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> ADORNO
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btnAlmAdorno" name="btnAlmAdorno" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #990000;  border-color: #990000;">
                            <span class="fa fa-file"></span> ALM-ADORNO
                        </button>
                    </div>

                    <div class="w-100 my-2"></div>
                    <div class="col-4">
                        <button type="button" id="btnLaser" name="btnLaser" class="btn btn-sm btn-info font-weight-bold"
                                style="background-color: #373a3c;  border-color: #373a3c;">
                            <span class="fa fa-file"></span> LASER
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info font-weight-bold" data-dismiss="modal">
                    <span class="fa fa-times"></span> CERRAR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlParesProducidosPorDepartamento = $("#mdlParesProducidosPorDepartamento"),
            xFechaInicial = mdlParesProducidosPorDepartamento.find("#xFechaInicial"),
            xFechaFinal = mdlParesProducidosPorDepartamento.find("#xFechaFinal"),
            xMaquila = mdlParesProducidosPorDepartamento.find("#xMaquila"),
            Hoy = '<?php print Date('d/m/Y'); ?>';

    $(document).ready(function () {
        handleEnterDiv(mdlParesProducidosPorDepartamento);

        mdlParesProducidosPorDepartamento.find("#btnCorteP").click(function () {
            getReportexDepto(10);
        });

        mdlParesProducidosPorDepartamento.find("#btnCorteF").click(function () {
            getReportexDepto(11);
        });

        mdlParesProducidosPorDepartamento.find("#btnRebajado").click(function () {
            getReportexDepto(30);
        });

        mdlParesProducidosPorDepartamento.find("#btnFoleado").click(function () {
            getReportexDepto(40);
        });

        mdlParesProducidosPorDepartamento.find("#btnEntretelado").click(function () {
            getReportexDepto(90);
        });

        mdlParesProducidosPorDepartamento.find("#btnAlmCorte").click(function () {
            getReportexDepto(105);
        });

        mdlParesProducidosPorDepartamento.find("#btnPespunte").click(function () {
            getReportexDepto(110);
        });

        mdlParesProducidosPorDepartamento.find("#btnAlmPespunte").click(function () {
            getReportexDepto(130);
        });

        mdlParesProducidosPorDepartamento.find("#btnEnsuelado").click(function () {
            getReportexDepto(140);
        });

        mdlParesProducidosPorDepartamento.find("#btnTejido").click(function () {
            getReportexDepto(150);
        });

        mdlParesProducidosPorDepartamento.find("#btnAlmTejido").click(function () {
            getReportexDepto(160);
        });

        mdlParesProducidosPorDepartamento.find("#btnMontado").click(function () {
            getReportexDepto(180);
        });

        mdlParesProducidosPorDepartamento.find("#btnAdorno").click(function () {
            getReportexDepto(210);
        });

        mdlParesProducidosPorDepartamento.find("#btnAlmAdorno").click(function () {
            getReportexDepto(230);
        });

        mdlParesProducidosPorDepartamento.on('shown.bs.modal', function () {
            xFechaInicial.val(Hoy);
            xFechaFinal.val(Hoy);
            xFechaInicial.focus().select();
        });
    });

    function onHabilitar() {
        if (xFechaInicial.val() && xFechaFinal.val() && xMaquila.val()) {
            btnAceptar.attr('disabled', false);
        } else {
            btnAceptar.attr('disabled', true);
        }
    }

    function getReportexDepto(depto) {
        if (mdlParesProducidosPorDepartamento.find("#xMaquila").val()) {
            getReporteXDeptoFiltro(depto);
        } else {
            onCampoInvalido(mdlParesProducidosPorDepartamento, "DEBE DE ESPECIFICAR UNA MAQUILA", function () {
                mdlParesProducidosPorDepartamento.find("#xMaquila").focus();
            });
        }
    }

    function getReporteXDeptoFiltro(depto) {
        onBeep(1);
        onOpenOverlay('Espere un momento por favor...');
        $.post('<?php print base_url('ParesProducidosPorDepartamento/getReportexDepto'); ?>', {
            FECHA_INICIAL: xFechaInicial.val() ? xFechaInicial.val() : '',
            FECHA_FINAL: xFechaFinal.val() ? xFechaFinal.val() : '',
            MAQUILA: xMaquila.val() ? xMaquila.val() : '',
            DEPARTAMENTO: depto !== '' && depto !== undefined ? parseInt(depto) : 0
        }).done(function (data, x, jq) {
            onBeep(1);
            onImprimirReporteFancy(data);
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
        }).always(function () {
            HoldOn.close();
            btnAceptar.attr('disabled', false);
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
    #pnlTablero.card-body{
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
</style>