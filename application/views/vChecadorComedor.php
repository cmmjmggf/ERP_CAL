<div class="card border-0" id="pnlTablero" style="box-shadow: none !important; background-color: #f5f5f5 !important;">
    <div class="card-body ">
        <div class="row pt-2">
            <div class="col-12 col-sm-12 col-md-10" align='center'>
                <h2>CONTROL DEL COMEDOR</h2>
            </div>
            <?php
            if ($_SESSION["USERNAME"] === '666666') {
                ?>
                <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" align='right'>
                    <button type="button" id="btnSalir" name="btnSalir" class="btn btn-primary font-weight-bold" style="background-color: #f71100; font-size: 20px;">
                        <span class="fa fa-door-open"></span> SALIR
                    </button>
                </div>
                <?php
            }
            if ($_SESSION["USERNAME"] === 'MONICARH' || $_SESSION["USERNAME"] === 'CECY' || $_SESSION["USERNAME"] === 'ALICIA' || $_SESSION["USERNAME"] === 'CMEDINA') {
                ?>
                <div class="col-12 col-sm-12 col-md-2 mt-2" align='center'>
                    <button type="button" class="btn btn-warning btn-sm" id="btnAplicarANomina" >
                        <span class="fa fa-dollar-sign" ></span> APLICAR A NÓMINA
                    </button>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="card-block">
            <div class="row" align="center">
                <div id="ProfilePicture" class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 my-3" >
                    <img src="<?php print base_url('img/empleado_sin_foto.png'); ?>" class="img-rounded img-fluid" width="350" height="350" alt="Empleado">
                    <h2 class="display-3"  style=" color: #645625 !important; font-weight: bold !important;">0000</h2>
                </div>
                <div id="" class="col-12 col-sm-12 col-md-12 col-xl-8 col-lg-8">
                    <div id="ProfileName" class="col-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 my-3">
                        <h2 class=" my-3"  style=" color: #645625 !important;"> - </h2>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control noBorders text-center numbersOnly" maxlength="4"  placeholder="####" autocomplete="off" id="NumeroEmpleado" style="
                                           height: 70px !important; font-weight: bold !important; font-size: 70px !important; color: #645625 !important;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Tiempo" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div>
                    <!--AQUI VA LA TABLA CON REGISTROS-->
                    <div class="col-sm-12 mt-1">
                        <div class="table-responsive" id="EmpleadosComidasSemana">
                            <table id="tblEmpleadosComidasSemana" class="table table-sm  " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nombre</th>
                                        <th>Año</th>
                                        <th>Sem</th>
                                        <th>Fecha</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = '<?php print base_url('ChecadorComedor'); ?>', pnlTablero = $("#pnlTablero");
    var NumeroEmpleado = pnlTablero.find("#NumeroEmpleado");
    var Semana = 0;
    var typed = false;
    var tblEmpleadosComidasSemana = $('#tblEmpleadosComidasSemana');
    var EmpleadosComidasSemana;
    var btnAplicarANomina = pnlTablero.find("#btnAplicarANomina"),
            btnSalir = pnlTablero.find("#btnSalir");

    $(document).ready(function () {
        
        btnSalir.click(function () {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: '¿Estas seguro?',
                text: "Saliendo del comedor...",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    location.href = '<?php print base_url('Sesion/onSalir'); ?>';
                }
            });
        });
        
        btnAplicarANomina.click(function () {
            swal({
                title: 'Aplicar comidas a Nómina',
                text: "DE LA SEMANA: ",
                content: 'input',
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((value) => {
                if (value === '') {
                    onNotifyOld('fa fa-times', 'DEBE CAPTURAR UNA SEMANA', 'danger');
                    btnAplicarANomina.trigger('click');
                } else {
                    swal({
                        buttons: ["Cancelar", "Aceptar"],
                        title: 'Estas Seguro?',
                        text: "Esta acción no se puede revertir",
                        icon: "warning",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then((action) => {
                        if (action) {
                            onOpenOverlay("Aplicando comidas, por favor espere");
                            $.post(master_url + '/onAplicarComidasEmpleadosSemana', {
                                Sem: value
                            }).done(function (data) {
                                console.log(data);
                                if (data === 0) {
                                    swal('ATENCION', 'No existen capturas de comida para esta SEMANA', 'warning').then((action) => {
                                        onCloseOverlay();
                                    });
                                } else {
                                    //Imprimir Reportes
                                    console.log(JSON.parse(data));

                                    var response = JSON.parse(data);

                                    onImprimirReporteFancyAFC(response.PDF, function (a, b) {
                                        onCloseOverlay();
                                        onNotifyOld('fa fa-check', 'COMIDAS APLICADAS CORRECTAMENTE', 'info');
                                        EmpleadosComidasSemana.ajax.reload();
                                        NumeroEmpleado.focus();
                                    });


                                    onOpenWindowBlank(response.XLS);
                                }

                            }).fail(function (x, y, z) {
                                onCloseOverlay();
                                console.log(x, y, z);
                            });
                        }
                    });
                }
            });
        });
        NumeroEmpleado.keypress(function () {
            typed = true;
        });
        NumeroEmpleado.keyup(function (e) {
            if (e.keyCode === 13 && typed) {
                onChecarComida();
                typed = false;
            }
        });
        NumeroEmpleado.focus();
        loop();
        loopsemana();
        getInformacionSemana();
        getEmpleadosComidasSemana();
    });
    function loop() {
        var hora = formatAMPM(new Date());
        $("#Tiempo").html('<div class="row">' +
                '<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<h1 class="semana_actual"style=" color: #645625 !important;">SEMANA ' + Semana + ' </h1>' +
                '</div><div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<h1 style=" color: #645625 !important;">' + formattedDate() + '</h1>' +
                '</div>' +
                '</div>' +
                '<h2 class="display-3 lead font-weight-bold" style=" color: #645625 !important;">' + hora + '</h2>');
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
        minutes = minutes < 10 ? minutes : minutes;
        var strTime = checkTime(hours) + ':' + checkTime(minutes) + ':' + checkTime(seconds) + ' ' + ampm;
        return strTime;
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getInformacionSemana() {
        $.getJSON('<?php print base_url('RelojChecador/getInformacionSemana'); ?>').done(function (data) {
            Semana = data[0].SEMANA;
        }).fail(function (x, y, z) {
            console.log(x, x.responseText);
        }).always(function () {

        });
    }

    function onChecarComida() {
        var ne = NumeroEmpleado.val();
        if ($.isNumeric(ne)) {
            $.post('<?php print base_url('ChecadorComedor/onChecarComedor'); ?>', {Numero: parseInt(ne), Semana: Semana}).done(function (data) {
                if (data.length > 0) {
                    var info = JSON.parse(data);
                    //console.log(info);
                    $("#ProfilePicture h2").text(parseInt(ne));
                    $("#ProfileName > h2 ").text(info.Busqueda);
                    var ext = getExt(info.Foto);
                    $.ajax({
                        url: base_url + info.Foto,
                        type: 'HEAD'
                    }).done(function (data) {
                        //console.log(data);
                        if (ext === "gif" || ext === "jpg" || ext === "png" || ext === "jpeg" || ext === "GIF") {
                            $("#ProfilePicture > img ").attr('src', base_url + info.Foto);
                        } else {
                            $("#ProfilePicture > img ").attr('src', '<?php print base_url('img/empleado_sin_foto.png'); ?>');
                        }
                    }).fail(function (x, y, z) {
                        $("#ProfilePicture > img ").attr('src', '<?php print base_url('img/empleado_sin_foto.png'); ?>');
                        console.log(x, x.responseText, z);
                    });
                    EmpleadosComidasSemana.ajax.reload();
                    NumeroEmpleado.val('').focus();
                } else {
                    onBeep(2);
                    swal({
                        icon: 'warning',
                        title: 'ERROR',
                        text: 'EL EMPLEADO NO EXISTE Ó ESTÁ DADO DE BAJA',
                        timer: 1200,
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
        }
    }

    function getEmpleadosComidasSemana() {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEmpleadosComidasSemana')) {
            tblEmpleadosComidasSemana.DataTable().destroy();
        }
        EmpleadosComidasSemana = tblEmpleadosComidasSemana.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('ChecadorComedor/getComidas'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.Empleado = (NumeroEmpleado.val()) ? NumeroEmpleado.val() : '0';
                    d.Semana = (Semana) ? Semana : '0';
                }
            },
            "columns": [
                {"data": "numemp"},
                {"data": "nomemp"},
                {"data": "año"},
                {"data": "sem"},
                {"data": "fecha"},
                {"data": "cantida"}
            ],
            "columnDefs": [
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {"width": "340", "targets": 1}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 10,
            scrollY: 200,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [

            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblEmpleadosComidasSemana_filter input[type=search]').addClass('selectNotEnter');
        tblEmpleadosComidasSemana.find('tbody').on('click', 'tr', function () {
            tblEmpleadosComidasSemana.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
</script>
<style>
    table tbody td {
        font-size: 14px !important;
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

    img {
        -webkit-filter: drop-shadow(5px 5px 5px #222);
        filter: drop-shadow(5px 5px 5px #222);
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
    h2 {
        text-shadow: 2px 2px 4px #000000;
    }
    html, body {background-color: #f2f2f2 !important;
    }
</style>
