<div class="card border-0 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left text-center">
                <legend class="float-left">CONTROL DE ASISTENCIA</legend>
            </div>
        </div>
        <div class="card-block">
            <div class="row" align="center">
                <div id="ProfilePicture" class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4" >
                    <img src="<?php print base_url('img/LOSO.png'); ?>" class="img-rounded img-fluid" width="350" height="350" alt="Empleado">
                    <h1 class="display-1">0000</h1>
                </div>
                <div id="" class="col-12 col-sm-12 col-md-12 col-xl-8 col-lg-8">
                    <div id="ProfileName" class="col-12 col-sm-12 col-md-12 col-xl-12 col-lg-12">
                        <h1 class="display-1">-</h1>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group"> 
                            <div class="form-group">
                                <div class="input-group mb-3"> 
                                    <input type="text" class="form-control" id="NumeroEmpleado" placeholder="CLAVE DE EMPLEADO" autofocus="">
                                    <div class="input-group-append">
                                        <button type="button" id="btnAcceso" class="btn btn-primary"><span class="fa fa-check"></span></button> 
                                        <button type="button" id="btnReset" class="btn btn-danger"><span class="fa fa-trash"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Tiempo" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/Asistencia/';
    var NumeroEmpleado = $("#NumeroEmpleado");
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
        getInformacionSemana();
    });

    function loop() {
        if (NumeroEmpleado.val() !== '' && parseInt(NumeroEmpleado.val()) > 0 && !typed) {
            console.log('Empleado', NumeroEmpleado.val());
            onLogIn();
            NumeroEmpleado.val('');
        }
        NumeroEmpleado.focus();
        var hora = new Date().getHours();
        $("#Tiempo").html('<div class="row"><div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"><h1 class="text-danger">SEMANA ' + Semana + ' </h1></div><div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"><h1 class="text-info">' + formattedDate() + '</h1></div></div><h1 class="text-default display-1 lead">' + hora + ':' + checkTime(new Date().getMinutes()) + ':' + checkTime(new Date().getSeconds()) + ' ' + (hora >= 12 ? 'pm' : 'am') + '</h1>');
        setTimeout(loop, 50);
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

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function onLogIn() {
        var ne = NumeroEmpleado.val();
        console.log(ne, typed);
        if ($.isNumeric(ne)) {
            $.post(base_url + 'index.php/Asistencia/onAcceder', {Numero: parseInt(ne)}).done(function (data) {
                console.log(data);
                if (data.length > 0) {
                    var info = JSON.parse(data);
                    console.log('* DATA *', info[0]);
                    $("#ProfilePicture h1").text(ne);
                    $("#ProfilePicture > img ").attr('src', (info[0].FOTO !== null ? base_url + info[0].FOTO : base_url + 'img/LOSO.png'));
                    $("#ProfileName > h1 ").text(info[0].Empleado);
                    swal({
                        title: 'GRACIAS',
                        text: '',
                        timer: 350,
                        buttons: false,
                        closeOnEsc: true,
                        closeOnClickOutside: true
                    });
                    onBeep(6);
                } else {
                    onBeep(2);
                    swal({
                        title: 'EL EMPLEADO NO EXISTE',
                        text: '',
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
        $.getJSON(master_url + 'getInformacionSemana').done(function (data) {
            console.log("\n * SEMANA * \n", data);
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
        box-shadow: 0 8px 4px -2px #666666;
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
    h1 { 
        text-shadow: 2px 2px 4px #000000;
    } 
    .swal-title{
        color: #fff;
        font-size: 80px;
        text-shadow: 2px 2px 4px #000000;
    }
    .swal-modal {
        background-color: rgba(100,86,37,0);
        border: none;
    }
    .swal-overlay {
        background-color: rgba(100,86,37,0.45);
    }
</style>
