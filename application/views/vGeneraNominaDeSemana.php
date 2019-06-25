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
                        <input type="text" id="AnioGNS" name="AnioGNS" max="2050"  maxlength="4" class="form-control form-control-sm numeric" autofocus="" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <br>
                        <div class="custom-control custom-checkbox"  align="left" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="ConsultaNominaCerrada" name="ConsultaNominaCerrada" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="ConsultaNominaCerrada" style="cursor: pointer !important;">Consulta nomina cerrada</label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGNS" name="SemanaGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <div class="custom-control custom-checkbox"  align="left" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="GeneraDiezPorcientoDeptos" name="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">Genera 10 % depto 90 (ENTRETELADO), 120 (PREL-PESPUNTE), 140 (ENSUELADO)</label>
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
                    <div class="col-12 mt-2">
                        <div class="alert alert-dismissible alert-warning">
                            <strong>
                                Semanas a procesar de vacaciones o aguinaldos para destajos
                            </strong> 
                        </div>
                    </div>
                    <div class="col-4"> 
                        <input type="text" id="SemanaUnoGNS" name="SemanaUnoGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="col-4"> 
                        <input type="text" id="SemanaDosGNS" name="SemanaDosGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="col-4"> 
                        <input type="text" id="SemanaTresGNS" name="SemanaTresGNS" maxlength="3" class="form-control form-control-sm numeric" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <label>Fecha de corte para aguinaldo</label>
                        <input type="text" id="FechaCorteAguinaldoGNS" name="FechaCorteAguinaldoGNS" maxlength="12" class="form-control date form-control-sm">
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
            FechaInicialGNS = mdlGeneraNominaDeSemana.find("#FechaInicialGNS"),
            FechaFinalGNS = mdlGeneraNominaDeSemana.find("#FechaFinalGNS"),
            ConsultaNominaCerrada = mdlGeneraNominaDeSemana.find("#ConsultaNominaCerrada"),
            btnGeneraGNS = mdlGeneraNominaDeSemana.find("#btnGeneraGNS");

    $(document).ready(function () {

        btnGeneraGNS.click(function () {
            if (SemanaGNS.val() && AnioGNS.val()) {
                if (ConsultaNominaCerrada[0].checked) {
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
                        console.log(a)
                        if (a.length > 0) {
                            onImprimirReporteFancyArray(JSON.parse(a));
                        } else {
                            swal('ATENCIÓN','NO HA SIDO POSIBLE GENERAR LOS REPORTES SOLICITADOS','warning');
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {

                }
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA SEMANA Y UN AÑO', 'warning').then((value) => {
                    SemanaGNS.focus().select();
                });
            }
        });

        SemanaGNS.on('keydown', function (e) {
            if (SemanaGNS.val() && e.keyCode === 13) {
                getSemanaPrenomina();
            }
        });

        mdlGeneraNominaDeSemana.on('shown.bs.modal', function () {
            AnioGNS.val('<?php print Date('Y'); ?>');
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

    function onGenerarNominaSemanal() {
        mdlGeneraNominaDeSemana.modal({
            backdrop: 'static',
            keyboard: false
        });
    }

</script>