<div class="card border-0" id="pnlTablero" 
     style="box-shadow: none !important; background-color: #f5f5f5 !important;">
    <div class="card-body ">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4"> 
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 pt-4"> 
                <h1 class="float-left">CONTROL DE ASISTENCIA</h1>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 p-3" align="right"> 
                <span class="fa fa-power-off apagar" style="color: #fff !important; font-size: 75px; cursor: pointer !important; " onclick="onSalirReloj()"></span>
            </div>
        </div>
        <div class="card-block">
            <div class="row" align="center">
                <div id="ProfilePicture" class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 my-5" >
                    <img src="<?php print base_url('img/empleado_sin_foto.png'); ?>" class="img-rounded img-fluid" width="350" height="350" alt="Empleado">
                    <h1 class="display-1"  style=" color: #645625 !important;">0000</h1>
                </div>
                <div id="" class="col-12 col-sm-12 col-md-12 col-xl-8 col-lg-8">
                    <div id="ProfileName" class="col-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 my-5">
                        <h1 class="display-3 my-5"  style=" color: #645625 !important;"> - </h1>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group"> 
                            <div class="form-group">
                                <div class="input-group mb-3"> 
                                    <input type="text" class="form-control noBorders text-center" placeholder="####" autocomplete="off" id="NumeroEmpleado" placeholder="CLAVE DE EMPLEADO" autofocus="" style="
                                           height: 90px !important; font-weight: bold !important; font-size: 90px !important; color: #645625 !important;">
                                    <div class="input-group-append">
                                        <button type="button" id="btnAcceso" class="btn btn-primary d-none"><span class="fa fa-check"></span></button> 
                                        <button type="button" id="btnReset" class="btn btn-danger px-5"><span class="fa fa-trash fa-lg"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Tiempo" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div> 

                    <?php
                    if (intval($vigilancia) === 1) {
                        ?> 
                        <div class="col-12">
                            <button id="btnSalir" class="btn btn-danger btn-lg" onclick="onSalirReloj()">
                                <span class="fa fa-arrow-left"></span> SALIR
                            </button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = '<?php print base_url('RelojChecador'); ?>', pnlTablero = $("#pnlTablero");
    var NumeroEmpleado = pnlTablero.find("#NumeroEmpleado");
    var Semana = 0;
    var typed = false;

    $(document).ready(function () {

        NumeroEmpleado.keypress(function () {
            typed = true;
        });

        NumeroEmpleado.keyup(function (e) {
            if (e.keyCode === 13 && typed) {
                onLogIn();
                NumeroEmpleado.val('');
                typed = false;
            }
        });

        $("#btnReset").click(function () {
            NumeroEmpleado.val('');
        });
        loop();
        loopsemana();
        getInformacionSemana();
    });
    function onSalirReloj() {
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Espere...'
        });
        location.href = "<?php print base_url('Sesion/onSalir'); ?>";
    }
    function loop() {
        if (NumeroEmpleado.val() !== '' && parseInt(NumeroEmpleado.val()) > 0 && !typed) {
            console.log('Empleado', NumeroEmpleado.val());
            onLogIn();
            NumeroEmpleado.val('');
        }
        NumeroEmpleado.focus();
//        getInformacionSemana();
        var hora = formatAMPM(new Date());
        $("#Tiempo").html('<div class="row">' +
                '<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<h1 class="semana_actual"style=" color: #645625 !important;">SEMANA ' + Semana + ' </h1>' +
                '</div><div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<h1 style=" color: #645625 !important;">' + formattedDate() + '</h1>' +
                '</div>' +
                '</div>' +
                '<h1 class="display-1 lead font-weight-bold" style=" color: #645625 !important;">' + hora + '</h1>');
        setTimeout(loop, 30);
    }

    function loopsemana() {
        getInformacionSemana();
        setTimeout(loopsemana, 10000);
    }

    function formattedDate(d = new Date) {
        let month = String(d.getMonth() + 1);
        let day = String(d.getDate());
        const year = String(d.getFullYear());

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return `${day}/${month}/${year}`;
    }

    /*12 HOURS*/
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = checkTime(hours) + ':' + checkTime(minutes) + ':' + checkTime(seconds) + ' ' + ampm;
        return strTime;
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function onLogIn() {
        var ne = NumeroEmpleado.val();

        if ($.isNumeric(ne)) {
            $.post('<?php print base_url('RelojChecador/onAcceder'); ?>', {Numero: parseInt(ne), Semana: Semana}).done(function (data) {
                console.log(data);
                if (data.length > 0) {
                    var info = JSON.parse(data);
                    console.log('* DATA *', info[0]);
                    $("#ProfilePicture h1").text(parseInt(ne));
                    var ext = getExt(info[0].FOTO);
                    $.ajax({
                        url: base_url + info[0].FOTO,
                        type: 'HEAD',
                        error: function ()
                        {
                            $("#ProfilePicture > img ").attr('src', '<?php print base_url('img/empleado_sin_foto.png'); ?>');
                        },
                        success: function ()
                        {
                            if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg" || ext === "GIF") {
                                $("#ProfilePicture > img ").attr('src', base_url + info[0].FOTO);
                            } else {
                                $("#ProfilePicture > img ").attr('src', '<?php print base_url('img/empleado_sin_foto.png'); ?>');
                            }
                        }
                    });
                    $("#ProfileName > h1 ").text(info[0].Empleado);
                } else {
                    onBeep(2);
                    swal({
                        title: 'EL EMPLEADO NO EXISTE',
                        text: '',
                        timer: 750,
                        buttons: false,
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    });
                }
            }).fail(function (x, y, z) {
                swal('Error', 'No ha sido posible ingresar al empleado ' + ne + ', intente de nuevo o más tarde', 'error');
                console.log(x, x.responseText, z);
                console.log(x, y, z);
            });
        } else {

        }
    }

    function getInformacionSemana() {
        $.getJSON('<?php print base_url('RelojChecador/getInformacionSemana'); ?>').done(function (data) {
            Semana = data[0].SEMANA;
        }).fail(function (x, y, z) {
            console.log(x, x.responseText);
        }).always(function () {

        });
    }

    function onValidarPantallaCompleta() {
        if (ValidaPantallaCompleta === '1') {
            $.ajax({url: master_url + 'onCambiarSesion',
                type: "POST"
            }).done(function (data, x, jq) {
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            }).always(function () {
            });
        } else {
            $(':input:text:enabled:visible:first').focus();
            $(':input:text:enabled:visible:first').select();
        }
    }
</script>
<style> 
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
    body{
        background-color: #FFF;
    }
    .card-body{ 
        padding-top: 0px;
        padding-left: 0px;     
        padding-right: 15px;
    }
    .card-body > .row{
        color: #fff;
        background-color: #645625;
        box-shadow: none !important;
    }
    legend{
        text-shadow: 2px 2px 4px #000000;
        font-size: 50px !important;
    }
    .font75{
        font-size: 250px;
    }
    img {
        -webkit-filter: drop-shadow(5px 5px 5px #222);
        filter: drop-shadow(5px 5px 5px #222);
    }

    .apagar{
        transition: 0.3s;
    }
    .apagar:hover{ 
        -webkit-animation: color-change 1s infinite;
        -moz-animation: color-change 1s infinite;
        -o-animation: color-change 1s infinite;
        -ms-animation: color-change 1s infinite;
        animation: color-change 1s infinite;
    }

    @-webkit-keyframes color-change {
        0% { color: #fff; }
        50% { color: #999999; }
        100% { color: #fff; }
    }
    @-moz-keyframes color-change {
        0% { color: #fff; }
        50% { color: #999999; }
        100% { color: #fff; }
    }
    @-ms-keyframes color-change {
        0% { color: #fff; }
        50% { color: #999999; }
        100% { color: #fff; }
    }
    @-o-keyframes color-change {
        0% { color: #fff; }
        50% { color: #999999; }
        100% { color: #fff; }
    }
    @keyframes color-change {
        0% { color: #fff; }
        50% { color: #999999; }
        100% { color: #fff; }
    }
    h1 { 
        text-shadow: 2px 2px 4px #000000;
    }  
    html, body {background-color: #f5f5f5 !important;
    } 
</style>
