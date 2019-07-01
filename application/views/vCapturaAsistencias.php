<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-md-8 float-left">
                <legend class="float-left">Captura Asistencia a Empleados</legend>
            </div>
            <div class="col-12 col-sm-4 col-md-4 animated bounceInLeft" align="right" id="Acciones">
                <button type="button" class="btn btn-info btn-sm " id="btnVerEmpleados" >
                    <span class="fa fa-users" ></span> EMPLEADOS
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <form id="frmCaptura">
            <div class="row">
                <div class="col-12 col-sm-2 col-md-1 col-xl-1">
                    <label>Año</label>
                    <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" required="">
                </div>
                <div class="col-12 col-sm-2 col-md-1 col-xl-1">
                    <label>Sem.</label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" required="">
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >Empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control form-control-sm required" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-6 col-xs-4 col-sm-2 col-lg-2 col-xl-2">
                    <label>No. Asistencias</label>
                    <input type="text" id="NumAsistencias" name="NumAsistencias" maxlength="1" class="form-control form-control-sm numbersOnly" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-3 mt-4">
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                    <button type="button" id="btnCapturaDiasTodos" class="btn btn-success btn-sm">
                        <span class="fa fa-users"></span> CAPTURA # DÍAS A TODOS
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CapturaAsistencias/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var btnAceptar = pnlTablero.find("#btnAceptar");
    var btnCapturaDiasTodos = pnlTablero.find("#btnCapturaDiasTodos");
    var btnVerEmpleados = pnlTablero.find('#btnVerEmpleados');
    var nuevo = true;
    $(document).ready(function () {
        //validacionSelectPorContenedor(pnlTablero);
        init();
        pnlTablero.find("#Ano").keydown(function (e) {
            if (e.keyCode === 13)
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
                        pnlTablero.find("#Ano").val("");
                        pnlTablero.find("#Ano").focus();
                    });
                } else {
                    pnlTablero.find("#Sem").focus();
                }
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if (e.keyCode === 13) {
                var ano = pnlTablero.find("#Ano");
                onComprobarSemanasNomina($(this), ano.val());
            }
        });
        pnlTablero.find("#Empleado").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#NumAsistencias").focus();
            }
        });
        pnlTablero.find("#NumAsistencias").keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) > 0 && parseInt($(this).val()) < 8) {
                    btnAceptar.focus();
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "NÚMERO DE DÍAS INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        pnlTablero.find("#NumAsistencias").val("");
                        pnlTablero.find("#NumAsistencias").focus();
                    });
                }
            }
        });
        btnAceptar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                //Valida que no esté cerrada la semana en nomina
                onAgregar();
            } else {
                swal('ATENCIÓN', '* DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS *', 'error');
            }
        });
        btnCapturaDiasTodos.click(function () {
            if (pnlTablero.find("#Sem").val() && pnlTablero.find("#Ano").val()) {
                swal({
                    title: 'ATENCIÓN',
                    text: "Se guardará el número de días capturado para todos los empleados de la semana " +
                            pnlTablero.find("#Sem").val() + ' del año ' + pnlTablero.find("#Ano").val(),
                    content: 'input'
                }).then((value) => {
                    if (parseInt(value) < 8 && parseInt(value) > 0) {
                        HoldOn.open({theme: 'sk-cube', message: 'GUARDANDO DATOS, POR FAVOR ESPERE...'});
                        $.post(master_url + 'onAgregarAsistenciaTodos', {
                            NumAsistencias: value,
                            Ano: pnlTablero.find("#Ano").val(),
                            Sem: pnlTablero.find("#Sem").val()
                        }).done(function (data) {
                            swal('ATENCIÓN', '* PROCESO COMPLETADO CORRECTAMENTE *', 'success');
                            HoldOn.close();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "NÚMERO DE DÍAS INCORRECTO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        });
                    }
                });
                $('.swal-modal').find('input.swal-content__input').val('0').focus().select();

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE CAPTURAR UNA SEMANA Y EL AÑO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Ano").focus().select();
                });
            }
        });
        btnVerEmpleados.click(function () {
            $.fancybox.open({
                src: base_url + '/Empleados.shoes',
                type: 'iframe',
                opts: {
                    afterShow: function (instance, current) {
                        console.info('done!');
                    },
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "95%",
                            height: "95%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });


        });
    });

    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                //Valida que no esté cerrada la semana en nomina
                pnlTablero.find("#Empleado")[0].selectize.focus();
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
    function onAgregar() {
        //inserta nuevo
        var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
        $.ajax(master_url + 'onAgregar', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            pnlTablero.find("#NumAsistencias").val("");
            pnlTablero.find("#Empleado")[0].selectize.clear(true);
            pnlTablero.find("#Empleado")[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

    }
    function init() {
        nuevo = true;
        getEmpleados();
        pnlTablero.find("#Ano").val(new Date().getFullYear()).focus().select();
    }
    function getEmpleados() {
        pnlTablero.find("#Empleado")[0].selectize.clear(true);
        pnlTablero.find("#Empleado")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getEmpleados').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Empleado")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
