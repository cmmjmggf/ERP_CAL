<div class="modal fade" id="mdlGeneraDiaFestivo" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera día festivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Año</label>
                        <input type="text" id="AnioGDF" name="AnioGDF" max="2050"  maxlength="4" class="form-control form-control-sm numeric" autofocus="" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGDF" name="SemanaGDF" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <label>Fecha Inicial</label>
                        <input type="text" id="FechaInicialGDF" name="FechaInicialGDF" maxlength="12" class="form-control form-control-sm date" readonly="">
                    </div>
                    <div class="col-6">
                        <label>Fecha Final</label>
                        <input type="text" id="FechaFinalGDF" name="FechaFinalGDF" maxlength="12" class="form-control form-control-sm date" readonly="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardarGDF">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraDiaFestivo = $("#mdlGeneraDiaFestivo"),
            AnioGDF = mdlGeneraDiaFestivo.find("#AnioGDF"),
            SemanaGDF = mdlGeneraDiaFestivo.find("#SemanaGDF"),
            FechaInicialGDF = mdlGeneraDiaFestivo.find("#FechaInicialGDF"),
            FechaFinalGDF = mdlGeneraDiaFestivo.find("#FechaFinalGDF"),
            btnGuardarGDF = mdlGeneraDiaFestivo.find("#btnGuardarGDF");

    $(document).ready(function () {

        AnioGDF.keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        AnioGDF.val("");
                        AnioGDF.focus();
                    });
                } else {
                    SemanaGDF.focus().select();
                }
            }
        });

        SemanaGDF.on('keypress', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var ano = AnioGDF.val();
                    onComprobarSemanasNominaDiaFestivo($(this), ano);
                }
            }
        });

        btnGuardarGDF.click(function () {
            if (AnioGDF.val() && SemanaGDF.val() && FechaInicialGDF.val() && FechaFinalGDF.val()) {
                if (parseInt(AnioGDF.val()) > 2000 && parseInt(SemanaGDF.val()) > 0) {
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: ''
                    });
                    var ops = {
                        ANIO: AnioGDF.val(),
                        SEMANA: SemanaGDF.val(),
                        FECHA_INICIAL: FechaInicialGDF.val(),
                        FECHA_FINAL: FechaFinalGDF.val()
                    };
                    $.post('<?php print base_url('DiaFestivo/onAnadirDiaFestivo'); ?>', ops).done(function (a) {
                        swal('ATENCIÓN', 'SE HA HAN ASIGNADO LOS DIAS FESTIVOS PARA LA SEMANA ' + SemanaGDF.val() + ' DEL AÑO ' + AnioGDF.val(), 'success').then((value) => {
                            AnioGDF.focus().select();
                        });
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    swal('ATENCIÓN', 'DEBE DE ESPECIFICAR EL AÑO, SEMANA Y LAS FECHAS', 'warning').then((value) => {
                        AnioGDF.focus().select();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR EL AÑO, SEMANA Y LAS FECHAS', 'warning').then((value) => {
                    AnioGDF.focus().select();
                });
            }
        });

        mdlGeneraDiaFestivo.on('shown.bs.modal', function () {
            mdlGeneraDiaFestivo.find("input").val('');
            AnioGDF.val('<?php print Date('Y'); ?>');
            FechaInicialGDF.val('<?php print Date('d/m/Y'); ?>');
            FechaFinalGDF.val('<?php print Date('d/m/Y'); ?>');
            AnioGDF.focus().select();

            /*OBTENER SEMANA ACTUAL DE NOMINA*/

            $.getJSON('<?php print base_url('DiaFestivo/getSemanaNomina'); ?>',
                    {FECHA: '<?php print Date('d/m/Y'); ?>'}).done(function (a) {
                if (a.length > 0) {
                    SemanaGDF.val(a[0].SEMANA);
                    FechaInicialGDF.val(a[0].FECHAINI);
                    FechaFinalGDF.val(a[0].FECHAFIN);
                } else {
                    onBeep(2);
                    swal('ATENCIÓN', 'NO SE HA SIDO POSIBLE OBTENER LA SEMANA O NO SE HAN GENERADO LAS SEMANAS EN NOMINA', 'warning');
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });

    });

    function onComprobarSemanasNominaDiaFestivo(v, ano) {
        //Valida que esté creada la semana en nominas
        $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (dataUno) {
            if (dataUno.length > 0) {
                //Valida que no esté cerrada la semana en nomina
                $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/onVerificarSemanaNominaCerrada', {Sem: $(v).val(), Ano: ano}).done(function (data) {
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
                            FechaInicialGDF.val(dataUno[0].FechaIni);
                            FechaFinalGDF.val(dataUno[0].FechaFin);
                            btnGuardarGDF.focus();
                        }
                    } else {//Aún no existe la nomina, podemos continuar
                        swal({
                            title: "ATENCIÓN",
                            text: "LA NÓMINA DE LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO HA SIDO CERRADA TODAVÍA",
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
</script>