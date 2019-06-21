<div class="modal fade" id="mdlGeneraNominaDeSemana" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Genera nomina de semana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label>Año</label>
                        <input type="text" id="AnioGNS" name="AnioGNS" max="2050"  maxlength="4" class="form-control numeric" autofocus="" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="ConsultaNominaCerrada" name="ConsultaNominaCerrada" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="ConsultaNominaCerrada" style="cursor: pointer !important;">Consulta nomina cerrada</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Semana</label>
                        <input type="text" id="SemanaGNS" name="SemanaGNS" maxlength="3" class="form-control numeric" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                            <input type="checkbox" class="custom-control-input selectNotEnter" id="GeneraDiezPorcientoDeptos" name="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">
                            <label class="custom-control-label text-danger labelCheck" for="GeneraDiezPorcientoDeptos" style="cursor: pointer !important;">Genera 10 % depto 90 (ENTRETELADO), 120 (PREL-PESPUNTE), 140 (ENSUELADO)</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Fecha Inicial</label>
                        <input type="text" id="FechaInicialGNS" name="FechaInicialGDF" maxlength="12" class="form-control date">
                    </div>
                    <div class="col-6">
                        <label>Fecha Final</label>
                        <input type="text" id="FechaFinalGNS" name="FechaFinalGDF" maxlength="12" class="form-control date">
                    </div>  
                    <div class="col-12 mt-4">
                        <div class="alert alert-dismissible alert-primary">
                            <strong>
                                Nota. Para semana de vacaciones debe ser año actual sem-99. Para semana de aguinaldo debe ser año actual y sem-98
                            </strong> 
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Fecha de corte para aguinaldo</label>
                        <input type="text" id="FechaCorteAguinaldoGNS" name="FechaCorteAguinaldoGNS" maxlength="12" class="form-control date">
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-block" id="btnGuardarGNS">
                            <span class="fa fa-cogs"></span> GENERA</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-default btn-block" id="btnSalirGNS">
                            <span class="fa fa-times-circle"></span> SALIR</button>
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-warning btn-block" id="btnSemanasGNS">
                            <span class="fa fa-calendar-alt"></span> SEMANAS</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger btn-block" id="btnCierraNominaGNS">
                            <span class="fa fa-calendar-times"></span> CIERRA NOMINA</button>
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlGeneraNominaDeSemana = $("#mdlGeneraNominaDeSemana"),
            AnioGNS = mdlGeneraNominaDeSemana.find("#AnioGNS"),
            SemanaGNS = mdlGeneraNominaDeSemana.find("#SemanaGNS"),
            btnGuardarGNS = mdlGeneraNominaDeSemana.find("#btnGuardarGNS");

    $(document).ready(function () {
        mdlGeneraNominaDeSemana.on('shown.bs.modal', function () {
            AnioGNS.val('<?php print Date('Y'); ?>');
            $.getJSON('<?php print base_url('DiaFestivo/getSemanaNomina'); ?>',
                    {FECHA: '<?php print Date('d/m/Y'); ?>'}).done(function (a) {
                if (a.length > 0) {
                    SemanaGNS.val(a[0].SEMANA);
//                    FechaInicialGDF.val(a[0].FECHAINI);
//                    FechaFinalGDF.val(a[0].FECHAFIN);
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

    function onGenerarNominaSemanal() {
        mdlGeneraNominaDeSemana.modal({
            backdrop: 'static',
            keyboard: false
        });
    }

</script>