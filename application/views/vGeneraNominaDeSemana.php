<div class="modal fade" id="mdlGeneraNominaDeSemana" role="dialog" >
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-coins"></span> Genera Nómina Semanal</h5>
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
                            <label class="custom-control-label text-danger" for="ConsultaNominaCerrada" style="cursor: pointer !important;">Consulta nómina cerrada</label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGNS"  name="SemanaGNS" maxlength="2" class="form-control form-control-sm numeric" autocomplete="off">
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
                    <div class="col-12">
                        <div class="m-2 p-2 border border-primary rounded">
                            <span class="font-weight-bold text-danger">Nota:</span>
                            <div class="w-100"></div>
                            <span class="font-weight-bold text-primary">Para semana de vacaciones debe ser año actual semana </span><span class="font-weight-bold text-danger">99. </span>
                            <div class="w-100"></div>
                            <span class="font-weight-bold text-primary">Para semana de aguinaldo debe ser año actual y semana </span><span class="font-weight-bold text-danger">98.</span>
                        </div>
                    </div>
                    <!--ESTO SOLO APLICA CUANDO PONEN LA SEM 99 (VACACIONES) Y 98 (AGUINALDO)-->
                    <div class="row d-none m-1 animated fadeIn" id="SeccionVacacionesAguinaldosParaDestajo">
                        <div class="col-12 mt-2"> 
                            <p style="color:#E53935; font-weight: bold;">SEMANAS A PROCESAR DE VACACIONES O AGUINALDOS PARA DESTAJOS</p>
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
                        <div class="w-100 my-2">
                            <hr>
                        </div>
                        <div class="col-6">
                            <label>Fecha de corte</label>
                            <input type="text" id="FechaCorteAguinaldoGNS" name="FechaCorteAguinaldoGNS" maxlength="12" class="form-control date form-control-sm notEnter">
                        </div>
                        <div class="col-6 mt-3">
                            <button id="btnGeneraVacaciones" name="btnGeneraVacaciones" class="btn btn-block btn-sm btn-success"  style="background-color: #4CAF50; border-color: #4CAF50;">
                                <span class="fa fa-file-excel"></span> VACACIONES A EXCEL
                            </button>
                            <button id="btnGeneraAguinaldoXLS" name="btnGeneraAguinaldoXLS" class="btn btn-block btn-sm btn-success"  style="background-color: #4CAF50; border-color: #4CAF50;">
                                <span class="fa fa-file-excel"></span> AGUINALDO A EXCEL
                            </button>
                        </div>
                    </div>
                    <div class="w-100 my-2">
                        <hr></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-info btn-sm btn-block" id="btnGeneraGNS">
                            <span class="fa fa-print"></span> GENERA</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-success btn-sm btn-block" id="btnPrenominaExcel" style="background-color: #4CAF50; border-color: #4CAF50;">
                            <span class="fa fa-file-excel"></span> PRENÓMINA EXCEL</button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-warning btn-sm btn-block" id="btnSemanasGNS">
                            <span class="fa fa-calendar-alt"></span> SEMANAS</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger btn-sm btn-block" id="btnCierraNominaGNS" style="background-color: #E53935;
                                border-color: #E91E63;">
                            <span class="fa fa-calendar-times"></span> CIERRA NÓMINA</button>
                    </div>
                    <div class="w-100 my-2">
                        <hr>
                    </div>
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
            btnPrenominaExcel = mdlGeneraNominaDeSemana.find("#btnPrenominaExcel"),
            SVacacionesAguinaldosParaDestajo = mdlGeneraNominaDeSemana.find("#SeccionVacacionesAguinaldosParaDestajo"),
            btnCierraNominaGNS = mdlGeneraNominaDeSemana.find("#btnCierraNominaGNS"), btnSemanasGNS = mdlGeneraNominaDeSemana.find("#btnSemanasGNS"),
            btnEliminaMovGenGNS = mdlGeneraNominaDeSemana.find("#btnEliminaMovGenGNS"),
            GeneraDiezPorcientoDeptos = mdlGeneraNominaDeSemana.find("#GeneraDiezPorcientoDeptos"),
            btnGeneraVacaciones = mdlGeneraNominaDeSemana.find("#btnGeneraVacaciones"),
            btnGeneraAguinaldoXLS = mdlGeneraNominaDeSemana.find("#btnGeneraAguinaldoXLS");

    function getAguinaldo(pdf_xls) {
        if (FechaCorteAguinaldoGNS.val()) {
            if (!mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val()) {
                onCampoInvalido(mdlGeneraNominaDeSemana, "SE REQUIEREN SEMANAS INICIALES", function () {
                    SemanaGNS.focus();
                });
            }
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Generando aguinaldos...'
            });
            var parms = {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val(),
                FECHAINI: FechaInicialGNS.val(), FECHAFIN: FechaFinalGNS.val()};
            parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
            parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
            parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
            var url = '';
            switch (pdf_xls) {
                case 1:
                    /*PDF*/
                    url = '<?php print base_url('GeneraNominaDeSemana/getAguinaldos'); ?>';
                    break;
                case 2:
                    /*XLS*/
                    url = '<?php print base_url('GeneraNominaDeSemana/getAguinaldosXLS'); ?>';
                    break;
            }
            $.post(url, parms).done(function (a) {
                console.log(a);
                busy = false;
                switch (pdf_xls) {
                    case 1:
                        /*PDF*/
                        onEnable(btnGeneraGNS);
                        break;
                    case 2:
                        if (a.length > 0) {
                            var r = JSON.parse(a);
                            window.open(r["1UNO"], '_blank');
                            swal({
                                title: "ATENCIÓN",
                                text: "SE HA GENERADO EL AGUINALDO EN EXCEL",
                                icon: "success"
                            }).then(function () {
                                SemanaGNS.focus().select();
                            });
                        } else {
                            busy = false;
                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LA NOMINA DE LA SEMANA 98, INTENTE DE NUEVO O MÁS TARDE', 'warning');
                        }
                        onCloseOverlay();
                        break;
                }

            }).fail(function (x) {
                getError(x);
            }).always(function () {
                switch (pdf_xls) {
                    case 1:
                        /*PDF*/
                        onEnable(btnGeneraGNS);
                        break;
                    case 2:
                        /*XLS*/
                        onEnable(btnGeneraGNS);
                        onEnable(btnGeneraVacaciones);
                        onEnable(btnGeneraAguinaldoXLS);
                        onEnable(btnCierraNominaGNS);
                        onEnable(btnEliminaMovGenGNS);
                        break;
                }
                HoldOn.close();
                busy = false;
            });
        } else {
            swal('ATENCIÓN', 'ES REQUERIDA UNA FECHA DE CORTE', 'warning').then((values) => {
                FechaCorteAguinaldoGNS.focus().select();
            });
            busy = false;
        }
    }

    $(document).ready(function () {

        btnGeneraAguinaldoXLS.click(function () {
            switch (parseInt(SemanaGNS.val())) {
                case 98:
                    onDisable(btnGeneraGNS);
                    onDisable(btnGeneraVacaciones);
                    onDisable(btnGeneraAguinaldoXLS);
                    onDisable(btnCierraNominaGNS);
                    onDisable(btnEliminaMovGenGNS);
                    getAguinaldo(2);
                    break;
            }
        });

        ConsultaNominaCerrada.change(function () {
            SemanaGNS.focus().select();
        });

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

        btnGeneraVacaciones.click(function () {
            onDisable(btnGeneraVacaciones);
            if (parseInt(SemanaGNS.val()) === 99 && AnioGNS.val() && FechaCorteAguinaldoGNS.val()) {
                onOpenOverlay("Generando vacaciones...");
                var parms = {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val(),
                    FECHAINI: FechaInicialGNS.val(), FECHAFIN: FechaFinalGNS.val()};
                parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
                parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
                parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
                $.post('<?php print base_url('GeneraNominaDeSemana/getVacaciones'); ?>', parms).done(function (a) {
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HAN GENERADO LAS VACACIONES",
                        icon: "success",
                        buttons: false,
                        timer: 2000
                    });
                    //                    SVacacionesAguinaldosParaDestajo.addClass("d-none");
                    console.log(a);
                    $.post('<?php print base_url('GeneraNominaDeSemana/getReportesNomina9998XLS'); ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val()
                            }).done(function (a) {
                        HoldOn.close();
                        if (a.length > 0) {
                            onCloseOverlay();
                            var r = JSON.parse(a);
                            window.open(r["1UNO"], '_blank');
                        } else {
                            //                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS', 'warning');
                        }
                        onEnable(btnPrenominaExcel);
                        onEnable(btnGeneraVacaciones);
                    }).fail(function (x) {
                        HoldOn.close();
                        getError(x);
                        onEnable(btnPrenominaExcel);
                        onEnable(btnGeneraVacaciones);
                    }).always(function () {
                        HoldOn.close();
                    });
                }).fail(function (x) {
                    getError(x);
                    onCloseOverlay();
                    onEnable(btnPrenominaExcel);
                    onEnable(btnGeneraVacaciones);
                }).always(function () {
                    busy = false;
                });
            } else {
                onCampoInvalido(mdlGeneraNominaDeSemana, "DEBE DE ESPECIFICAR LA SEMANA 99 Y UNA FECHA DE CORTE", function () {
                    if (!SemanaGNS.val() && SemanaGNS.val() !== 99) {
                        SemanaGNS.focus().select();
                        return;
                    }
                    if (!FechaCorteAguinaldoGNS.val()) {
                        FechaCorteAguinaldoGNS.focus().select();
                        return;
                    }
                });
            }
        });

        btnPrenominaExcel.click(function () {
            btnPrenominaExcel.attr('disabled', true);
            if (parseInt(SemanaGNS.val()) === 99 && AnioGNS.val()) {
                onOpenOverlay("Generando vacaciones...");
                var parms = {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val(),
                    FECHAINI: FechaInicialGNS.val(), FECHAFIN: FechaFinalGNS.val()};
                parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
                parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
                parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
                $.post('<?php print base_url('GeneraNominaDeSemana/getVacaciones'); ?>', parms).done(function (a) {
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HAN GENERADO LAS VACACIONES",
                        icon: "success",
                        buttons: false,
                        timer: 2000
                    });
                    //                    SVacacionesAguinaldosParaDestajo.addClass("d-none");
                    console.log(a);
                    $.post('<?php print base_url('GeneraNominaDeSemana/getReportesNomina9998XLS'); ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val()
                            }).done(function (a) {
                        HoldOn.close();
                        if (a.length > 0) {
                            onCloseOverlay();
                            var r = JSON.parse(a);
                            window.open(r["1UNO"], '_blank');
                        } else {
                            //                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS', 'warning');
                        }
                        onEnable(btnPrenominaExcel);
                    }).fail(function (x) {
                        HoldOn.close();
                        getError(x);
                        onEnable(btnPrenominaExcel);
                    }).always(function () {
                        HoldOn.close();
                    });
                }).fail(function (x) {
                    getError(x);
                    onCloseOverlay();
                    onEnable(btnPrenominaExcel);
                }).always(function () {
                    busy = false;
                });
            } else {
                if (SemanaGNS.val() && AnioGNS.val()) {
                    HoldOn.open({
                        theme: 'sk-rect',
                        message: 'Por favor espere...'
                    });
                    $.post('<?php print base_url('GeneraNominaDeSemana/getPrenominaExcel'); ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val(),
                                FECHAINI: FechaInicialGNS.val(),
                                FECHAFIN: FechaFinalGNS.val()
                            }).done(function (a) {
                        console.log(a);
                        HoldOn.close();
                        if (a.length > 0) {
                            window.open(a, '_blank');
                            btnPrenominaExcel.attr('disabled', false);

                        } else {
                            //                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS', 'warning');
                        }
                    }).fail(function (x) {
                        HoldOn.close();
                        getError(x);
                    }).always(function () {
                        btnPrenominaExcel.attr('disabled', false);
                        HoldOn.close();
                    });
                }
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
        var busy = false;
        btnGeneraGNS.click(function () {
            if (busy)
            {
                return;
            } else {
                busy = true;
            }
            var parms = {SEMANA: SemanaGNS.val(), ANIO: AnioGNS.val(),
                FECHAINI: FechaInicialGNS.val(), FECHAFIN: FechaFinalGNS.val()};
            console.log(parms);
            console.log(parms);
            onDisable(btnGeneraGNS);
            if (SemanaGNS.val() && AnioGNS.val()) {
                switch (parseInt(SemanaGNS.val())) {
                    case 98:
                        /* SEMANA 98  = AGUINALDOS*/
                        getAguinaldo(1);
//                        if (FechaCorteAguinaldoGNS.val()) {
//                            HoldOn.open({
//                                theme: 'sk-rect',
//                                message: 'Generando aguinaldos...'
//                            });
//                            parms["S1"] = mdlGeneraNominaDeSemana.find("#SemanaUnoGNS").val();
//                            parms["S4"] = mdlGeneraNominaDeSemana.find("#SemanaCuatroGNS").val();
//                            parms["FECHACORTE"] = FechaCorteAguinaldoGNS.val();
//                            $.post('<?php print base_url('GeneraNominaDeSemana/getAguinaldos'); ?>', parms).done(function (a) {
//                                console.log(a);
//                                busy = false;
//                            }).fail(function (x) {
//                                getError(x);
//                            }).always(function () {
//                                onEnable(btnGeneraGNS);
//                                HoldOn.close();
//                                busy = false;
//                            });
//                        } else {
//                            swal('ATENCIÓN', 'ES REQUERIDA UNA FECHA DE CORTE', 'warning').then((values) => {
//                                FechaCorteAguinaldoGNS.focus().select();
//                            });
//                            busy = false;
                        //                        }
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
                            swal({
                                title: "ATENCIÓN",
                                text: "SE HAN GENERADO LAS VACACIONES",
                                icon: "success",
                                buttons: false,
                                timer: 2000
                            });
                            SVacacionesAguinaldosParaDestajo.addClass("d-none");
                            console.log(a);
                        }).fail(function (x) {
                            getError(x);
                        }).always(function () {
                            onEnable(btnGeneraGNS);
                            busy = false;
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
                            onImprimirReporteFancyArrayAFC(JSON.parse(a), function (a, b) {
                                onEnable(btnGeneraGNS);
                            });
                        } else {
                            //                            swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS', 'warning');
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        busy = false;
                        onEnable(btnGeneraGNS);
                        HoldOn.close();
                    });
                } else {
                    /* GENERA NOMINA POR SEMANA, AÑO */
                    /* CONSULTA NOMINA CERRADA */
                    onBeep(1);
                    onOpenOverlay('Por favor espere...');
                    $.getJSON('<?php print base_url('GeneraNominaDeSemana/onRevisarGenerandoNomina') ?>',
                            {
                                SEMANA: SemanaGNS.val(),
                                ANIO: AnioGNS.val(),
                                FECHAINI: (SemanaGNS.val() !== 98 && SemanaGNS.val() !== 99 ? FechaInicialGNS.val() : ''),
                                FECHAFIN: (SemanaGNS.val() !== 98 && SemanaGNS.val() !== 99 ? FechaFinalGNS.val() : '')
                            }).done(function (a) {
                        var r = a[0];
                        switch (parseInt(r.TOTAL)) {
                            case 0:
                                switch (parseInt(SemanaGNS.val())) {
                                    case 98:
                                        $.post('<?php print base_url('GeneraNominaDeSemana/getReportesNomina9998'); ?>',
                                                {
                                                    SEMANA: 98,
                                                    ANIO: AnioGNS.val()
                                                }).done(function (a) {
                                            console.log(a);
                                            if (a.length > 0) {
                                                onImprimirReporteFancyArrayAFC(JSON.parse(a), function (a, b) {
                                                    onEnable(btnGeneraGNS);
                                                    busy = false;
                                                });
                                            } else {
                                                busy = false;
                                                swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LA NOMINA DE LA SEMANA 98, INTENTE DE NUEVO O MÁS TARDE', 'warning');
                                            }
                                        }).fail(function (x) {
                                            getError(x);
                                        }).always(function () {
                                            onEnable(btnGeneraGNS);
                                            onCloseOverlay();
                                            busy = false;
                                        });
                                        break;
                                    case 99:
                                        onOpenOverlay('Generando vacaciones...');
                                        $.post('<?php print base_url('GeneraNominaDeSemana/getReportesNomina9998'); ?>',
                                                {
                                                    SEMANA: 99,
                                                    ANIO: AnioGNS.val()
                                                }).done(function (a) {
                                            console.log(a);
                                            if (a.length > 0) {
                                                onImprimirReporteFancyArrayAFCZ(JSON.parse(a), function (a, b) {
                                                    onEnable(btnGeneraGNS);
                                                    SemanaGNS.focus().select();
                                                    busy = false;
                                                }, 140);
                                            } else {
                                                busy = false;
                                                swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LA NOMINA DE LA SEMANA 99, INTENTE DE NUEVO O MÁS TARDE', 'warning');
                                            }
                                            onCloseOverlay();
                                        }).fail(function (x) {
                                            getError(x);
                                            onCloseOverlay();
                                        }).always(function () {
                                            onEnable(btnGeneraGNS);
                                            busy = false;
                                        });
                                        break;
                                    default :
                                        $.post('<?php print base_url('GeneraNominaDeSemana/onGeneraNomina'); ?>',
                                                {
                                                    SEMANA: SemanaGNS.val(),
                                                    ANIO: AnioGNS.val(),
                                                    FECHAINI: (SemanaGNS.val() !== 98 && SemanaGNS.val() !== 99 ? FechaInicialGNS.val() : ''),
                                                    FECHAFIN: (SemanaGNS.val() !== 98 && SemanaGNS.val() !== 99 ? FechaFinalGNS.val() : ''),
                                                    GENERADIEZ: GeneraDiezPorcientoDeptos[0].checked ? 1 : 0
                                                }).done(function (a) {
                                            console.log(a);
                                            if (a.length > 0) {
                                                onImprimirReporteFancyArrayAFC(JSON.parse(a), function (a, b) {
                                                    onEnable(btnGeneraGNS);
                                                    busy = false;
                                                });
                                            } else {
                                                busy = false;
                                                swal('ATENCIÓN', 'NO HA SIDO POSIBLE GENERAR LA NOMINA, INTENTE DE NUEVO O MÁS TARDE', 'warning');
                                            }
                                        }).fail(function (x) {
                                            getError(x);
                                        }).always(function () {
                                            onEnable(btnGeneraGNS);
                                            onCloseOverlay();
                                            busy = false;
                                        });
                                        break;
                                }
                                break;
                            case 1:
                                onCloseOverlay();
                                iMsg('EL USUARIO ' + r.USUARIO + ' ESTA GENERANDO LA NOMINA DE LA SEMANA ' + SemanaGNS.val() + ' AÑO ' + AnioGNS.val() + ', INTENTE MÁS TARDE.', 'w', function () {
                                    SemanaGNS.focus().select();
                                });
                                busy = false;
                                break;
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                    });
                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA SEMANA Y UN AÑO', 'warning').then((value) => {
                    SemanaGNS.focus().select();
                    busy = false;
                });
            }
        });
        AnioGNS.keypress(function (e) {
            if (e.keyCode === 13) {
                if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                    swal({
                        title: "ATENCIÓN",
                        text: "AÑO INCORRECTO",
                        icon: "warning"
                    }).then((action) => {
                        AnioGNS.val("");
                        AnioGNS.focus();
                    });
                } else {
                    SemanaGNS.focus().select();
                }
            }
        });
        SemanaGNS.keydown(function (e) {
            if (parseInt(SemanaGNS.val()) === 99 && e.keyCode === 13 ||
                    parseInt(SemanaGNS.val()) === 98 && e.keyCode === 13) {
                SVacacionesAguinaldosParaDestajo.removeClass("d-none");
                onEnable(btnGeneraGNS);
                onDisable(btnPrenominaExcel);
            } else if (parseInt(SemanaGNS.val()) !== 99 && e.keyCode === 13 ||
                    parseInt(SemanaGNS.val()) !== 98 && e.keyCode === 13) {
                onEnable(btnGeneraGNS);
                onEnable(btnPrenominaExcel);
                SVacacionesAguinaldosParaDestajo.addClass("d-none");
            }
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    if (ConsultaNominaCerrada[0].checked) {//Si sólo es consulta
                        onComprobarSemanasNominaGeneraNominaConsulta($(this), AnioGNS.val());
                    } else {//Si es la de generación
                        onComprobarSemanasNominaGeneraNomina($(this), AnioGNS.val());
                    }
                }
            }
            if (e.keyCode === 8 && SemanaGNS.val() === '') {
                onDisable(btnGeneraGNS);
                onDisable(btnCierraNominaGNS);
                onDisable(btnEliminaMovGenGNS);
                SVacacionesAguinaldosParaDestajo.addClass("d-none");
            }
        }).keyup(function (e) {
            if (e.keyCode === 8 && SemanaGNS.val() === '') {
                onDisable(btnGeneraGNS);
                onDisable(btnCierraNominaGNS);
                onDisable(btnEliminaMovGenGNS);
                SVacacionesAguinaldosParaDestajo.addClass("d-none");
            }
        });

        FechaCorteAguinaldoGNS.keydown(function (e) {
            if (e.keyCode === 13 && parseInt(SemanaGNS.val()) === 99 ||
                    e.keyCode === 13 && parseInt(SemanaGNS.val()) === 98) {
                if ($(this).val()) {
                    onEnable(btnGeneraGNS);
                    onDisable(btnPrenominaExcel);
                    btnGeneraGNS.focus();
                }
            }
        });

        mdlGeneraNominaDeSemana.on('shown.bs.modal', function () {
            AnioGNS.val('<?php print Date('Y'); ?>').focus().select();
            onDisable(btnGeneraGNS);
            onDisable(btnCierraNominaGNS);
            onDisable(btnEliminaMovGenGNS);
            getSemanaNomina();
            $.post('<?php print base_url('GeneraNominaDeSemana/onRefrescarSaldoDePrestamos'); ?>').done(function (a) {
            }).fail(function (x) {
                console.log(x);
            });
        });
    });

    function onValidarSemanaConsultaAguinaldoVacaciones() {
        if (SemanaGNS.val() && parseInt(SemanaGNS.val()) !== 99 && parseInt(SemanaGNS.val()) !== 98) {
            SVacacionesAguinaldosParaDestajo.addClass("d-none");
            onEnable(btnGeneraGNS);
            btnGeneraGNS.focus();
        } else if (SemanaGNS.val() && parseInt(SemanaGNS.val()) === 99) {
            $.getJSON('<?php print base_url('GeneraNominaDeSemana/getSemanaNominaX'); ?>',
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
            FechaCorteAguinaldoGNS.focus();
        } else if (SemanaGNS.val() && parseInt(SemanaGNS.val()) === 98) {
            $.getJSON('<?php print base_url('GeneraNominaDeSemana/getSemanaNominaX'); ?>',
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
            FechaCorteAguinaldoGNS.focus();
        }
    }

    function onComprobarSemanasNominaGeneraNominaConsulta(v, ano) {
        //Valida que esté creada la semana en nominas
        var semana_no_1_52_99_98 = parseInt($(v).val());
        if (semana_no_1_52_99_98 >= 1 && semana_no_1_52_99_98 <= 52 || semana_no_1_52_99_98 !== 98 ||
                semana_no_1_52_99_98 !== 99) {
            $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {
                Clave: $(v).val(), Ano: ano}).done(function (dataUno) {
                if (dataUno.length > 0) {
                    console.log('onComprobarSemanaNomina ok');
                    FechaInicialGNS.val(dataUno[0].FechaIni);
                    FechaFinalGNS.val(dataUno[0].FechaFin);
                    onValidarSemanaConsultaAguinaldoVacaciones();
                } else {
                    console.log('onComprobarSemanaNomina else')
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
    }

    function onComprobarSemanasNominaGeneraNomina(v, ano) {

        //Valida que este creada la semana en nominas
        console.log("SEMANA " + $(v).val())
        if (parseInt($(v).val()) !== 98 && parseInt($(v).val()) !== 99) {
            $.getJSON(base_url + 'index.php/Semanas/onComprobarSemanaNomina', {Clave: $(v).val(), Ano: ano}).done(function (dataUno) {
                if (dataUno.length > 0) {
                    //Valida que no esté cerrada la semana en nomina
                    $.getJSON(base_url + 'index.php/ConceptosVariablesNomina/onVerificarSemanaNominaCerrada', {Sem: $(v).val(), Ano: ano}).done(function (data) {
                        if (data.length > 0) {//Si existe en prenomina validamos que sólo esté en estatus 1
                            if (parseInt(data[0].status) === 2) {
                                swal({
                                    title: "ATENCIÓN",
                                    text: "LA NÓMINA DE LA SEMANA " + $(v).val() + " DEL " + ano + " " + "ESTÁ CERRADA", icon: "warning",
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
                                            $(v).focus().select();
                                            onDisable(btnGeneraGNS);
                                            onDisable(btnCierraNominaGNS);
                                            onDisable(btnEliminaMovGenGNS);
                                            break;
                                    }
                                });
                            } else {//Sí está pero esta en estatus 1
                                FechaInicialGNS.val(dataUno[0].FechaIni);
                                FechaFinalGNS.val(dataUno[0].FechaFin);
                                onEnable(btnGeneraGNS);
                                onEnable(btnCierraNominaGNS);
                                onEnable(btnEliminaMovGenGNS);
                                onValidarSemanaConsultaAguinaldoVacaciones();
                            }
                        } else {//Aún no existe la nomina, podemos continuar
                            FechaInicialGNS.val(dataUno[0].FechaIni);
                            FechaFinalGNS.val(dataUno[0].FechaFin);
                            onValidarSemanaConsultaAguinaldoVacaciones();
                        }
                    }).fail(function (x, y, z) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    swal({
                        title: "ATENCIÓN",
                        text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE (2)",
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
                                $(v).focus().select();
                                onDisable(btnGeneraGNS);
                                onDisable(btnCierraNominaGNS);
                                onDisable(btnEliminaMovGenGNS);
                                break;
                        }
                    });
                }
            }).fail(function (x, y, z) {
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                console.log(x.responseText);
                $(v).focus().select();
                onDisable(btnGeneraGNS);
                onDisable(btnCierraNominaGNS);
                onDisable(btnEliminaMovGenGNS);
            });
        } else {
            onEnable(btnGeneraGNS);
            onEnable(btnCierraNominaGNS);
            onEnable(btnEliminaMovGenGNS);
            onValidarSemanaConsultaAguinaldoVacaciones();
        }
    }

    //Trae la semana actual
    function getSemanaNomina() {
        $.getJSON('<?php print base_url('DiaFestivo/getSemanaNomina'); ?>',
                {FECHA: '<?php print Date('d/m/Y'); ?>'}).done(function (a) {
            if (a.length > 0) {
                SemanaGNS.val(a[0].SEMANA);
                FechaInicialGNS.val(a[0].FECHAINI);
                FechaFinalGNS.val(a[0].FECHAFIN);
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