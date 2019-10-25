<div class="modal" id="mdlParesAsignadosXTiempos">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-stopwatch"></span> Pares asignados X Tiempos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <label>Maquila</label>
                        <input type="text" id="MaquilaPAXT" name="MaquilaPAXT" class="form-control form-control-sm numbersOnly" autofocus="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <label>Semana</label>
                        <input type="text" id="SemanaPAXT" name="SemanaPAXT" class="form-control form-control-sm  numbersOnly">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <label>Dia</label>
                        <input type="text" id="DiaPAXT" name="DiaPAXT" class="form-control form-control-sm  numbersOnly">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                        <label>Año</label>
                        <input type="text" id="AnioPAXT" name="AnioPAXT" class="form-control form-control-sm  numbersOnly">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptaPAXT"><span class="fa fa-print"></span> Acepta </button>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlParesAsignadosXTiempos = $("#mdlParesAsignadosXTiempos"),
            MaquilaPAXT = mdlParesAsignadosXTiempos.find("#MaquilaPAXT"),
            SemanaPAXT = mdlParesAsignadosXTiempos.find("#SemanaPAXT"),
            DiaPAXT = mdlParesAsignadosXTiempos.find("#DiaPAXT"),
            AnioPAXT = mdlParesAsignadosXTiempos.find("#AnioPAXT"),
            AnioX = '<?php print Date('Y'); ?>',
            btnAceptaPAXT = mdlParesAsignadosXTiempos.find("#btnAceptaPAXT");

    $(document).ready(function () {

        btnAceptaPAXT.click(function () {
            if (MaquilaPAXT.val() && SemanaPAXT.val() && AnioPAXT.val()) {
                btnAceptaPAXT.attr('disabled', true);
                HoldOn.open({
                    theme: 'sk-cube',
                    message: 'Por favor espere...'
                });
                $.post('<?php print base_url('ParesAsignadosXTiempos/getParesAsignadosControlXTiempos'); ?>', {
                    MAQUILA: MaquilaPAXT.val().trim() !== '' ? parseInt(MaquilaPAXT.val()) : '',
                    SEMANA: SemanaPAXT.val().trim() !== '' ? SemanaPAXT.val() : '',
                    DIA: DiaPAXT.val().trim() !== '' ? DiaPAXT.val() : 0,
                    ANIO: AnioPAXT.val().trim() !== '' ? AnioPAXT.val() : ''
                }).done(function (data, x, jq) {
                    onBeep(1);
                    $.extend($.fancybox.defaults, {
                        afterClose: function () {
                            MaquilaPAXT.focus().select();
                        }
                    });
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                    btnAceptaPAXT.attr('disabled', false);
                });
            } else {
                swal('ATENCIÓN', 'TODOS LOS CAMPOS SON REQUERIDOS', 'warning').then((value) => {
                    if (MaquilaPAXT.val()) {
                        MaquilaPAXT.focus();
                    } else if (SemanaPAXT.val()) {
                        SemanaPAXT.focus().select();
                    } else if (AnioPAXT.val()) {
                        AnioPAXT.focus().select();
                    }
                });
            }
        });

        mdlParesAsignadosXTiempos.on('shown.bs.modal', function () {
            handleEnterDiv(mdlParesAsignadosXTiempos);
            mdlParesAsignadosXTiempos.find("input").val('');
            AnioPAXT.val(AnioX);
            MaquilaPAXT.focus().select();
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
</style>