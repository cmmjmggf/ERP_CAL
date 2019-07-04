<div class="modal fade" id="mdlGeneraNominaDeSemana" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-coins"></span> Genera nomina de semana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Año</label>
                        <input type="text" id="AnioGNS" name="AnioGNS" max="2050"  maxlength="4" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <br>
                        <div class="custom-control custom-checkbox"  align="left" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input" id="ConsultaNominaCerrada" name="ConsultaNominaCerrada" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger" for="ConsultaNominaCerrada" style="cursor: pointer !important;">Consulta nomina cerrada</label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGNS" name="SemanaGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 d-none">
                        <div class="custom-control custom-checkbox"  align="left" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input" id="GeneraDiezPorcientoDeptos" name="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger" for="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">Genera 10 % depto 90 (ENTRETELADO), 120 (PREL-PESPUNTE), 140 (ENSUELADO)</label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6">
                        <label>Fecha Inicial</label>
                        <input type="text" id="FechaInicialGNS" name="FechaInicialGDF" maxlength="12" class="form-control form-control-sm date" readonly="">
                    </div>
                    <div class="col-6">
                        <label>Fecha Final</label>
                        <input type="text" id="FechaFinalGNS" name="FechaFinalGDF" maxlength="12" class="form-control form-control-sm date" readonly="">
                    </div>  
                    <div class="col-12 mt-4">
                        <div class="alert alert-dismissible alert-primary">
                            <strong>
                                Nota. Para semana de vacaciones debe ser año actual sem-99. Para semana de aguinaldo debe ser año actual y sem-98
                            </strong> 
                        </div>
                    </div>
                    <!--ESTO SOLO APLICA CUANDO PONEN LA SEM 99 (VACACIONES) Y 98 (AGUINALDO)-->
                    <div class="row d-none m-1 animated fadeIn" id="SeccionVacacionesAguinaldosParaDestajo">
                        <div class="col-12 mt-2">
                            <div class="alert alert-dismissible alert-warning">
                                <strong>
                                    Semanas a procesar de vacaciones o aguinaldos para destajos
                                </strong> 
                            </div>
                        </div>
                        <div class="col-3"> 
                            <input type="text" id="SemanaUnoGNS" name="SemanaUnoGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off" readonly="">
                        </div>
                        <div class="col-3"> 
                            <input type="text" id="SemanaDosGNS" name="SemanaDosGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off" readonly="">
                        </div>
                        <div class="col-3"> 
                            <input type="text" id="SemanaTresGNS" name="SemanaTresGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off" readonly="">
                        </div>
                        <div class="col-3"> 
                            <input type="text" id="SemanaCuatroGNS" name="SemanaCuatroGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off" readonly="">
                        </div>
                        <div class="w-100"></div>
                        <div class="col-6"></div>
                        <div class="col-6">
                            <label>Fecha de corte para aguinaldo</label>
                            <input type="text" id="FechaCorteAguinaldoGNS" name="FechaCorteAguinaldoGNS" maxlength="12" class="form-control date form-control-sm notEnter">
                        </div>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-sm btn-block" id="btnGeneraGNS">
                            <span class="fa fa-cogs"></span> GENERA</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-default btn-sm btn-block" id="btnSalirGNS">
                            <span class="fa fa-times-circle"></span> SALIR</button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-info btn-sm btn-block" id="btnSemanasGNS">
                            <span class="fa fa-calendar-alt"></span> SEMANAS</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger btn-sm btn-block" id="btnCierraNominaGNS">
                            <span class="fa fa-calendar-times"></span> CIERRA NOMINA</button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-12">
                        <button type="button" class="btn btn-danger btn-sm btn-block" id="btnEliminaMovGenGNS">
                            <span class="fa fa-calendar-times"></span> ELIMINA MOVIMIENTOS GENERADOS </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var mdlGeneraNominaDeSemana = $("#mdlGeneraNominaDeSemana"),
            AnioGNS = mdlGeneraNominaDeSemana.find("#AnioGNS"),
            SemanaGNS = mdlGeneraNominaDeSemana.find("#SemanaGNS"),
            SemanaUnoGNS = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS"),
            SemanaDosGNS = mdlGeneraNominaDeSemana.find("#SemanaDosGNS"),
            SemanaTresGNS = mdlGeneraNominaDeSemana.find("#SemanaTresGNS"),
            SemanaCuatroGNS = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS"),
            FechaInicialGNS = mdlGeneraNominaDeSemana.find("#FechaInicialGNS"),
            FechaFinalGNS = mdlGeneraNominaDeSemana.find("#FechaFinalGNS"),
            FechaCorteAguinaldoGNS = mdlGeneraNominaDeSemana.find("#FechaCorteAguinaldoGNS"),
            ConsultaNominaCerrada = mdlGeneraNominaDeSemana.find("#ConsultaNominaCerrada"),
            btnGeneraGNS = mdlGeneraNominaDeSemana.find("#btnGeneraGNS"),
            SVacacionesAguinaldosParaDestajo = mdlGeneraNominaDeSemana.find("#SeccionVacacionesAguinaldosParaDestajo"),
            btnCierraNominaGNS = mdlGeneraNominaDeSemana.find("#btnCierraNominaGNS"),
            btnSemanasGNS = mdlGeneraNominaDeSemana.find("#btnSemanasGNS"),
            btnEliminaMovGenGNS = mdlGeneraNominaDeSemana.find("#btnEliminaMovGenGNS"),
            GeneraDiezPorcientoDeptos = mdlGeneraNominaDeSemana.find("#GeneraDiezPorcientoDeptos");

    $(document).ready(function () {

        btnEliminaMovGenGNS.click(function () {
            if (AnioGNS.val() && SemanaGNS.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Eliminando...'
                });
                $.post('<?php print base_url('GeneraNominaDeSemana/onEliminarMovimientos'); ?>', {
                    ANIO: AnioGNS.val(),
                    SEMANA: SemanaGNS.val()
                }).done(function (a) {
                    onNotifyOld('<span class="fa fa-success"></span>', 'MOVIMIENTOS ELIMINADOS', 'danger').t;
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                swal('ATENCIÓN', 'EL AÑO Y SEMANA SON NECESARIOS, PARA PODER ELIMINAR LOS MOVIMIENTOS', 'warning').then((value) => {
                    AnioGNS.focus().select();
                });
            }
        });

        btnSemanasGNS.click(function () {
            $.fancybox.open({
                src: '<?php print base_url('Semanas.shoes'); ?>',
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

        btnCierraNominaGNS.click(function () {
            $("#mdlCerrarNominaDeSemana").modal('show');
        });

//        handleEnterDiv(mdlGeneraNominaDeSemana);

        btnGeneraGNS.click(function () {
            var parms = {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val(),
                FECHAINI: FechaInicialGNS.val(), FECHAFIN: FechaFinalGNS.val()};
            console.log(parms);
            console.log(parms);
            if (SemanaGNS.val() && AnioGNS.val()) {
                switch (parseInt(SemanaGNS.val())) {
                    case 98:
                        /* SEMANA 98  = AGUINALDOS*/
                        if (FechaCorteAguinaldoGNS.val()) {
                            HoldOn.open({
                                theme: 'sk-rect',
                                message: 'Generando aguinaldos...'
                            });
                            parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
                            parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
                            parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
                            $.post('<?php print base_url('GeneraNominaDeSemana/getAguinaldos'); ?>', parms).done(function (a) {
                                console.log(a);
                            }).fail(function (x) {
                                getError(x);
                            }).always(function () {
                                HoldOn.close();
                            });
                        } else {
                            swal('ATENCIÓN', 'ES REQUERIDA UNA FECHA DE CORTE', 'warning').then((values) => {
                                FechaCorteAguinaldoGNS.focus().select();
                            });
                        }
                        break;
                    case 99:
                        /* SEMANA 99  = VACACIONES*/
                        HoldOn.open({
                            theme: 'sk-rect',
                            message: 'Generando vacaciones...'
                        });
                        parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
                        parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
                        parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
                        $.post('<?php print base_url('GeneraNominaDeSemana/getVacaciones'); ?>', parms).done(function (a) {
                            swal('ATENCIÓN', 'SE HAN GENERADO LAS VACACIONES', 'success');
                            SVacacionesAguinaldosParaDestajo.addClass("d-none");
                            console.log(a);
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                            HoldOn.close();
                        });
                        break;
                }
                if (ConsultaNominaCerrada[0].checked) {
                    /* CONSULTA NOMINA CERRADA */
                    onBeep(1);
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Por favor espere...'
                    });
                    $.post('<?php print base_url('GeneraNominaDeSemana/getNominaCerrada'); ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val(),
                                FECHAINI: FechaInicialGNS.val(),
                                FECHAFIN: FechaFinalGNS.val()
                            }).done(function (a) {
                        console.log(a);
                        if (a.length > 0) {
                            onImprimirReporteFancyArray(JSON.parse(a));
                        } else {
//                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS', 'warning');
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    /* GENERA NOMINA POR SEMANA, AÑO */
                    /* CONSULTA NOMINA CERRADA */
                    onBeep(1);
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Por favor espere...'
                    });
                    $.post('<?php print base_url('GeneraNominaDeSemana/onGeneraNomina'); ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val(),
                                FECHAINI: FechaInicialGNS.val(),
                                FECHAFIN: FechaFinalGNS.val(),
                                GENERADIEZ: GeneraDiezPorcientoDeptos[0].checked ? 1 : 0
                            }).done(function (a) {
                        console.log(a);
                        if (a.length > 0) {
                            onImprimirReporteFancyArray(JSON.parse(a));
                        } else {
                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LA NOMINA, INTENTE DE NUEVO O MÁS TARDE', 'warning');
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA SEMANA Y UN AÑO', 'warning').then((value) => {
                    SemanaGNS.focus().select();
                });
            }
        });

        SemanaGNS.on('keydown', function (e) {
            if (SemanaGNS.val() && e.keyCode === 13 && parseInt(SemanaGNS.val()) !== 99 && parseInt(SemanaGNS.val()) !== 98) {
                SVacacionesAguinaldosParaDestajo.addClass("d-none");
                getSemanaNomina();
            } else if (SemanaGNS.val() && e.keyCode === 13 && parseInt(SemanaGNS.val()) === 99) {

                $.getJSON('<?php print base_url('DiaFestivo/getSemanaNomina'); ?>',
                        {FECHA: '<?php print Date('d/m/Y'); ?>'}).done(function (a) {
                    if (a.length > 0) {
                        var sm = parseInt(a[0].SEMANA);
                        SemanaCuatroGNS.val(sm);
                        SemanaTresGNS.val(sm - 1);
                        SemanaDosGNS.val(sm - 2);
                        SemanaUnoGNS.val(sm - 3);
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
                SVacacionesAguinaldosParaDestajo.removeClass("d-none");
            } else if (SemanaGNS.val() && e.keyCode === 13 && parseInt(SemanaGNS.val()) === 98) {
                SVacacionesAguinaldosParaDestajo.removeClass("d-none");
            }
        });
        mdlGeneraNominaDeSemana.on('shown.bs.modal', function () {
            AnioGNS.val('<?php print Date('Y'); ?>');
            getSemanaNomina();
        });
    });
    function getSemanaPrenomina() {
        $.getJSON('<?php print base_url('DiaFestivo/getSemanaPrenomina'); ?>',
                {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val()}).done(function (a) {
            if (a.length <= 0) {
                onBeep(2);
                swal('ATENCIÓN', 'LA SEMANA DE PRENOMINA PARA ESTE AÑO Y SEMANA YA ESTA CERRADA O NO SE HAN GENERADO LAS SEMANAS DE PRENOMINA', 'warning');
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getSemanaNomina() {
        $.getJSON('<?php print base_url('DiaFestivo/getSemanaNomina'); ?>',
                {FECHA: '<?php print Date('d/m/Y'); ?>'}).done(function (a) {
            if (a.length > 0) {
                SemanaGNS.val(a[0].SEMANA);
                FechaInicialGNS.val(a[0].FECHAINI);
                FechaFinalGNS.val(a[0].FECHAFIN);
                AnioGNS.focus();
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'NO SE HA SIDO POSIBLE OBTENER LA SEMANA O NO SE HAN GENERADO LAS SEMANAS EN NOMINA', 'warning');
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getFechasXSemanaNomina(s) {
        $.getJSON('<?php print base_url('DiaFestivo/getFechasXSemanaNomina'); ?>',
                {SEMANA: parseInt(s)}).done(function (a) {
            if (a.length > 0) {
                SemanaGNS.val(a[0].SEMANA);
                FechaInicialGNS.val(a[0].FECHAINI);
                FechaFinalGNS.val(a[0].FECHAFIN);
                var sems = a[0].SEMANA;
                SemanaUnoGNS.val(sems - 3);
                SemanaDosGNS.val(sems - 3);
                SemanaTresGNS.val(sems - 1);
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'NO SE HA SIDO POSIBLE OBTENER LA SEMANA O NO SE HAN GENERADO LAS SEMANAS EN NOMINA', 'warning');
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function onGenerarNominaSemanal() {
        mdlGeneraNominaDeSemana.modal({
            backdrop: 'static',
            keyboard: false
        });
    }

</script>