<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8 col-md-8 float-left">
                <legend class="float-left">Captura Fracciones Nómina por Semana</legend>
            </div>
            <div class="col-12 col-sm-4 col-md-4 animated bounceInLeft" align="right" id="Acciones">


            </div>
        </div>
        <hr>
        <form id="frmCaptura">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Año</label>
                    <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Sem Prod</label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="SemProd" name="SemProd" required="">
                </div>
                <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                    <label>Sem Nom</label>
                    <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" required="">
                </div>
                <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                    <label for="" >Empleado</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="Empleado" name="Empleado"   >
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3" >
                    <label for="" >-</label>
                    <select id="sEmpleado" name="sEmpleado" class="form-control form-control-sm required NotSelectize" >
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-1 col-md-2 col-lg-1 col-xl-1" >
                    <label for="" >Fracción</label>
                    <input type="text" class="form-control form-control-sm numbersOnly" maxlength="4" required=""  id="Fraccion" name="Fraccion"   >
                </div>
                <div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-2" >
                    <label for="" >-</label>
                    <select id="sFraccion" name="sFraccion" class="form-control form-control-sm required NotSelectize">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-2 mt-4">
                    <button type="button" id="btnAceptar" class="btn btn-primary btn-sm">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button>
                    <button type="button" id="btnEliminar" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash"></span> ELIMINAR
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    var master_url = base_url + 'index.php/CapturaNominaFraccionesSemanal/';
    var pnlTablero = $("#pnlTablero div.card-body");
    var btnAceptar = pnlTablero.find("#btnAceptar");
    var btnEliminar = pnlTablero.find("#btnEliminar");
    var nuevo = true;
    var DeptoEmp = 0;
    $(document).ready(function () {
        init();
        setFocusSelectToInputOnChange('#sFraccion', '#btnAceptar', pnlTablero);
        setFocusSelectToInputOnChange('#sEmpleado', '#Fraccion', pnlTablero);
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
                    pnlTablero.find("#SemProd").focus().select();
                }
        });
        pnlTablero.find("#SemProd").keydown(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {

                    //Comprobar semanas de produccion
                    var ano = pnlTablero.find("#Ano");
                    onComprobarSemanasProduccion($(this), ano.val());
                }
            }
        });
        pnlTablero.find("#Sem").keydown(function (e) {
            if ($(this).val()) {
                if (e.keyCode === 13) {
                    var ano = pnlTablero.find("#Ano");
                    onComprobarSemanasNomina($(this), ano.val());
                }
            }
        });
        pnlTablero.find('#Empleado').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtempl = $(this).val();
                if (txtempl) {

                    $.getJSON(master_url + 'onVerificarEmpleado', {Empleado: txtempl}).done(function (data) {
                        if (data.length > 0) {
                            getDepartamentoByEmpleado(txtempl);
                            pnlTablero.find("#sEmpleado")[0].selectize.addItem(txtempl, true);
                            pnlTablero.find("#Fraccion").focus().select();

                        } else {
                            swal('ERROR', 'EMPLEADO INEXISTENTE, DADO DE BAJA O NO ES DESTAJISTA', 'warning').then((value) => {
                                pnlTablero.find('#sEmpleado')[0].selectize.clear(true);
                                pnlTablero.find('#Empleado').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sEmpleado").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Empleado').val($(this).val());
                pnlTablero.find("#Fraccion").focus().select();
                getDepartamentoByEmpleado($(this).val());
            }
        });
        pnlTablero.find('#Fraccion').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtfrac = $(this).val();
                if (txtfrac) {
                    $.getJSON(master_url + 'onVerificarFraccion', {Fraccion: txtfrac}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sFraccion")[0].selectize.addItem(txtfrac, true);
                            btnAceptar.focus();
                        } else {
                            swal('ERROR', 'LA FRACCIÓN NO ES VÁLIDA', 'warning').then((value) => {
                                pnlTablero.find('#sFraccion')[0].selectize.clear(true);
                                pnlTablero.find('#Fraccion').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sFraccion").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Fraccion').val($(this).val());
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
        btnEliminar.click(function () {
            if (pnlTablero.find("#Sem").val() && pnlTablero.find("#Empleado").val() && pnlTablero.find("#Ano").val() && pnlTablero.find("#Fraccion").val()) {
                onEliminar(pnlTablero.find("#Empleado").val(), pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val(), pnlTablero.find("#Fraccion").val());
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE CAPTURAR EL EMPLEADO, AÑO/SEM, Y FRACCIÓN",
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
                            pnlTablero.find("#Sem").focus().select();
                            break;
                    }
                });
            }

        });
    });

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Sem").focus().select();
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

    function onComprobarSemanasNomina(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {
                //Valida que no esté cerrada la semana en nomina
                $.getJSON(master_url + 'onVerificarSemanaNominaCerrada', {Sem: $(v).val(), Ano: ano}).done(function (data) {
                    if (data.length > 0) {//Si existe en prenomina validamos que sólo esté en estatus 1
                        if (parseInt(data[0].status) === 2) {
                            swal({
                                title: "ATENCIÓN",
                                text: "LA NÓMINA DE LA SEMANA " + $(v).val() + " DEL " + ano + " " + "ESTÁ CERRADA",
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
                        } else {//Sí está pero esta en estatus 1
                            //getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
                            pnlTablero.find("#Empleado").focus().select();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        //getRecords(pnlTablero.find("#Ano").val(), pnlTablero.find("#Sem").val());
                        pnlTablero.find("#Empleado").focus().select();
                    }
                }).fail(function (x, y, z) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });

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
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData(pnlTablero.find("#frmCaptura")[0]);
        frm.append('deptoemp', DeptoEmp);
        $.ajax(master_url + 'onAgregar', {
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data) {
            console.log(data);
            if (data === '0') {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN MOVIMIENTOS EN PRODUCCIÓN DE ESTA SEM/AÑO",
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
                            HoldOn.close();
                            pnlTablero.find("#SemProd").val('');
                            pnlTablero.find("#SemProd").focus();
                            break;
                    }
                });
            } else {

                $.fancybox.open({
                    src: data,
                    type: 'iframe',
                    opts: {
                        afterShow: function (instance, current) {
                            HoldOn.close();
                        },
                        afterClose: function () {
                            DeptoEmp = 0;
                            pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                            pnlTablero.find("#sEmpleado")[0].selectize.clear(true);
                            pnlTablero.find("#Empleado").val('').focus();
                        },
                        iframe: {
                            // Iframe template
                            tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                            preload: true,
                            // Custom CSS styling for iframe wrapping element
                            // You can use this to set custom iframe dimensions
                            css: {
                                width: "100%",
                                height: "100%"
                            },
                            // Iframe tag attributes
                            attr: {
                                scrolling: "auto"
                            }
                        }
                    }
                });
            }



        }).fail(function (x, y, z) {
            console.log(x, y, z);
        });

    }

    function init() {
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        nuevo = true;
        DeptoEmp = 0;
        getEmpleados();
        getFracciones();
        getSemanaByFecha(getFechaActualConDiagonales());
        pnlTablero.find("#Ano").val(new Date().getFullYear()).focus().select();
    }

    function getEmpleados() {
        pnlTablero.find("#sEmpleado")[0].selectize.clear(true);
        pnlTablero.find("#sEmpleado")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getEmpleados').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sEmpleado")[0].selectize.addOption({text: v.Empleado, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getFracciones() {
        pnlTablero.find("#sFraccion")[0].selectize.clear(true);
        pnlTablero.find("#sFraccion")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getFracciones').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sFraccion")[0].selectize.addOption({text: v.Fraccion, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getSemanaByFecha(fecha) {
        $.getJSON(base_url + 'index.php/CapturaFraccionesParaNomina/getSemanaByFecha', {Fecha: fecha}).done(function (data) {
            if (data.length > 0) {
                pnlTablero.find("#Sem").val(data[0].sem);
            } else {
                swal('ERROR', 'NO EXISTE SEMANA', 'info');
            }
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function onEliminar(numemp, ano, sem, numfrac) {
        swal({
            buttons: ["Cancelar", "Aceptar"],
            title: 'Estas Seguro?',
            text: "Deseas eliminar el registro: \n\nEmpleado: " + numemp + " \n Año: " + ano + " \n Semana: " + sem + " \n Fracción: " + numfrac,
            icon: "warning",
            closeOnEsc: false,
            closeOnClickOutside: false
        }).then((action) => {
            if (action) {
                $.ajax({
                    url: master_url + 'onEliminar',
                    type: "POST",
                    data: {

                        Empleado: numemp,
                        Ano: ano,
                        Sem: sem,
                        Fraccion: numfrac
                    }
                }).done(function (data, x, jq) {
                    pnlTablero.find("#Empleado").val('');
                    pnlTablero.find("#Fraccion").val('');
                    pnlTablero.find("#sFraccion")[0].selectize.clear(true);
                    pnlTablero.find("#sEmpleado")[0].selectize.clear(true);
                    swal('ATENCIÓN', 'REGISTRO ELIMINADO', 'success');
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                HoldOn.close();
            }
        });

    }

    function getDepartamentoByEmpleado(Empleado) {
        $.getJSON(master_url + 'getDepartamentoByEmpleado', {Empleado: Empleado}).done(function (data) {
            if (data.length > 0) {
                DeptoEmp = data[0].Depto;
            } else {
                swal('ERROR', 'EMPLEADO INCORRECTO', 'info');
            }
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
