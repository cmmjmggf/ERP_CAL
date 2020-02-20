<div class="modal" id="mdlAvanceDeProduccionAMaquilas"  tabindex="-1" role="dialog"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fa fa-arrow-right"></span>
                    Avance de producción a maquilas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <label>Fecha</label>
                        <input type="text" id="FechaADPM" name="FechaADPM" class="form-control date">
                    </div>
                    <div class="col-4">
                        <label>Depto</label>
                        <input type="text" id="DeptoADPM" name="DeptoADPM" class="form-control numbersOnly">
                    </div>
                    <div class="col-4">
                        <label>Documento</label>
                        <input type="text" id="DocumentoADPM" name="DocumentoADPM" class="form-control" maxlength="30">
                        <input type="text" id="UC" name="UC" class="form-control d-none" readonly="" maxlength="30">
                    </div>
                    <div class="w-100 my-2"></div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <button type="button" id="btnBuscarDocumentoXControl" name="btnBuscarDocumentoXControl" class="btn btn-success btn-sm">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <ul id="deptos" class="list-group my-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="ENSUELADO">55</span> <span class="d-none" des="ENSUELADO">140</span>55 - ENSUELADO<span class="deptodes d-none">ENSUELADO</span><span class="deptoclave d-none">140</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="ALMACEN PESPUNTE">6</span> <span class="d-none" des="ALMACEN PESPUNTE">130</span>6 - ALMACEN PESPUNTE<span class="deptodes d-none">ALMACEN PESPUNTE</span><span class="deptoclave d-none">130</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="TEJIDO">7</span><span class="d-none" des="TEJIDO">150</span>7 - TEJIDO<span class="deptodes d-none">TEJIDO</span><span class="deptoclave d-none">150</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="ALMACEN TEJIDO">8</span><span class="d-none" des="ALMACEN TEJIDO">160</span>8 - ALMACEN TEJIDO<span class="deptodes d-none">ALMACEN TEJIDO</span><span class="deptoclave d-none">160</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="MONTADO">9</span><span class="d-none" des="MONTADO ">180</span>9 - MONTADO "A"<span class="deptodes d-none">MONTADO "A"</span><span class="deptoclave d-none">180</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="ADORNO ">10</span>10 - ADORNO "A"<span class="deptodes d-none">ADORNO "A"</span><span class="deptoclave d-none">210</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                <span class="d-none stsavan" des="ALMACEN ADORNO">11</span>11 - ALMACEN ADORNO<span class="deptodes d-none">ALMACEN ADORNO</span><span class="deptoclave d-none">230</span><span class="badge badge-primary badge-pill" style="background-color: #8BC34A;">!</span></li>
                        </ul>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-3">
                        <label>Control</label>
                        <input type="text" id="ControlADPM" name="ControlADPM" class="form-control" maxlength="12">
                    </div>
                    <div class="col-3">
                        <label>Estilo</label>
                        <input type="text" id="EstiloADPM" name="EstiloADPM" class="form-control" maxlength="12" readonly="">
                    </div>
                    <div class="col-3">
                        <label>Pares</label>
                        <input type="text" id="ParesADPM" name="ParesADPM" class="form-control" maxlength="12" readonly="">
                    </div>
                    <div class="col-3">
                        <label>Avance</label>
                        <input type="text" id="AvanceActualADPM" name="AvanceActualADPM" class="form-control" maxlength="12"  readonly="">
                    </div>
                    <div class="col-12"></div>
                    <div class="col-12 d-none">
                        <p>NOTA: SI DESEA SABER EL NUMERO DE DOCUMENTO YA CAPTURADO  SOLO TECLEE LA FECHA, DEPTO Y CONTROL</p>
                    </div> 
                </div>
            </div>
            <div class="modal-footer"> 
                <div class="col-6 order-2" align="right">
                    <button type="button" id="btnAceptaADPM" name="btnAceptaADPM" class="btn btn-success btn-sm">
                        <span class="fa fa-check"></span>  Acepta
                    </button>
                </div> 
                <div class="col-6 order-1" align="left">
                    <button type="button" id="btnImprimirADPM" name="btnImprimirADPM" class="btn btn-info btn-sm">
                        <span class="fa fa-print"></span>  Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div> 
</div>
<script>

    var mdlAvanceDeProduccionAMaquilas = $("#mdlAvanceDeProduccionAMaquilas"),
            FechaADPM = mdlAvanceDeProduccionAMaquilas.find("#FechaADPM"),
            DeptoADPM = mdlAvanceDeProduccionAMaquilas.find("#DeptoADPM"),
            DocumentoADPM = mdlAvanceDeProduccionAMaquilas.find("#DocumentoADPM"),
            ControlADPM = mdlAvanceDeProduccionAMaquilas.find("#ControlADPM"),
            EstiloADPM = mdlAvanceDeProduccionAMaquilas.find("#EstiloADPM"),
            ParesADPM = mdlAvanceDeProduccionAMaquilas.find("#ParesADPM"),
            UC = mdlAvanceDeProduccionAMaquilas.find("#UC"),
            AvanceActualADPM = mdlAvanceDeProduccionAMaquilas.find("#AvanceActualADPM"),
            btnAceptaADPM = mdlAvanceDeProduccionAMaquilas.find("#btnAceptaADPM"),
            btnImprimirADPM = mdlAvanceDeProduccionAMaquilas.find("#btnImprimirADPM"),
            btnBuscarDocumentoXControl = mdlAvanceDeProduccionAMaquilas.find("#btnBuscarDocumentoXControl");

    var fecha_hoy = '<?php print Date('d/m/Y'); ?>';
    var d = new Date(), n = d.getSeconds();
    var anio = <?php print substr(Date('Y'), 2); ?>, mes = <?php print Date('m'); ?>,
            dia = <?php print Date('d'); ?>, hora = d.getHours(),
            minutos = d.getMinutes(), segundos = d.getSeconds();

    $(document).ready(function () {
        handleEnterDiv(mdlAvanceDeProduccionAMaquilas);
        btnBuscarDocumentoXControl.click(function () {
            if (ControlADPM.val()) {
                onOpenOverlay('Buscando documento...');
                $.getJSON('<?php print base_url('AvanceDeProduccionAMaquilas/onBuscarDocumentoXControl') ?>',
                        {CONTROL: ControlADPM.val()}).done(function (a) {
                    console.log(a, a.length);
                    if (a[0] !== undefined) {
                        DocumentoADPM.val(a[0].DOC);
                        getConsecutivoXDocto();
                        ControlADPM.focus().select();
                    } else {
                        onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "NO SE ENCONTRO UN DOCUMENTO EN ESTE CONTROL", function () {
                            ControlADPM.focus().select();
                        });
                        DocumentoADPM.val('');
                        UC.val('');
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onEnable(btnImprimirADPM);
                    HoldOn.close();
                });
            } else {
                HoldOn.close();
                onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "DEBE DE ESPECIFICAR UN CONTROL", function () {
                    ControlADPM.focus().select();
                });
            }
        });

        DocumentoADPM.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getConsecutivoXDocto();
            }
            if (e.keyCode === 8 && DocumentoADPM.val() === '') {
                UC.val('');
            }
        }).focusout(function () {
            getConsecutivoXDocto();
            if (DocumentoADPM.val() === '') {
                UC.val('');
            }
        });

        btnImprimirADPM.click(function () {
            getConsecutivoXDocto();
            onDisable(btnImprimirADPM);
            onOpenOverlay('Generando...');
            if (DocumentoADPM.val()) {
                $.getJSON('<?php print base_url('AvanceDeProduccionAMaquilas/getReporte') ?>',
                        {DOCUMENTO: DocumentoADPM.val()}).done(function (a) {
                    console.log(a, a.length);
                    onImprimirReporteFancyArrayAFC(a, function (a, b) {
                        onEnable(btnImprimirADPM);
                        DocumentoADPM.focus();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onEnable(btnImprimirADPM);
                    HoldOn.close();
                });
            } else {
                onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "DEBE DE ESPECIFICAR UN DOCUMENTO", function () {
                    DocumentoADPM.focus().select();
                    UC.val('');
                });
            }
        });

        btnAceptaADPM.click(function () {
            if (DeptoADPM.val() === '') {
                onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "DEBE DE ESPECIFICAR UN DEPARTAMENTO", function () {
                    ControlADPM.focus().select();
                });
                return;
            }
            if (DocumentoADPM.val() === '' ) {
                onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "DEBE DE ESPECIFICAR UN DOCUMENTO", function () {
                    ControlADPM.focus().select();
                });
                return;
            }
            if (ControlADPM.val() === '') {
                onCampoInvalido(mdlAvanceDeProduccionAMaquilas, "DEBE DE ESPECIFICAR UN CONTROL", function () {
                    ControlADPM.focus().select();
                });
                return;
            }
            var p = {
                FECHA: FechaADPM.val(),
                DEPTO: DeptoADPM.val(),
                DOCUMENTO: DocumentoADPM.val(),
                CONTROL: ControlADPM.val(),
                ESTILO: EstiloADPM.val(),
                PARES: ParesADPM.val(),
                CONSECUTIVO: UC.val()
            };
            $.post('<?php print base_url('AvanceDeProduccionAMaquilas/onGuardar') ?>', p).done(function (a) {
                ControlADPM.val('');
                ControlADPM.focus().select();
                onNotifyOldPCF('<span class="fa fa-check"></span>',
                        'SE HAN GUARDADO LOS CAMBIOS',
                        'success', {from: "top", align: "center"}, function () {
                    EstiloADPM.val('');
                    ParesADPM.val('');
                    AvanceActualADPM.val('');
                });
                onEnable(btnImprimirADPM);
            }).fail(function (x) {
                getError(x);
            }).always(function () {

            });
        });

        ControlADPM.on('keydown', function (e) {
            if (e.keyCode === 13 && ControlADPM.val()) {
                getInfoXControlADPAM();
            }
            if (e.keyCode === 8 && ControlADPM.val() === '') {
                EstiloADPM.val('');
                ParesADPM.val('');
                AvanceActualADPM.val('');
            }
        });

        mdlAvanceDeProduccionAMaquilas.on('shown.bs.modal', function () {
            d = new Date();
            segundos = d.getSeconds();
            mdlAvanceDeProduccionAMaquilas.find("input").val("");
            FechaADPM.val(fecha_hoy);
            DeptoADPM.focus().select();
            getUltimoConsecutivo();
        });

    });

    function getUltimoConsecutivo() {
        $.getJSON('<?php print base_url('AvanceDeProduccionAMaquilas/getUltimoConsecutivo'); ?>').done(function (a) {
            console.log(a);
            DocumentoADPM.val(anio + "" + mes + "" + dia + "" + a[0].ULTIMO_CONSECUTIVO);
            UC.val(a[0].UC);
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }
    function getInfoXControlADPAM() {
        $.getJSON('<?php print base_url('AvanceDeProduccionAMaquilas/getInfoXControlADPAM'); ?>', {CONTROL: ControlADPM.val()}).done(function (a) {
            console.log(a);
            if (a.length > 0) {
                EstiloADPM.val(a[0].Estilo);
                ParesADPM.val(a[0].Pares);
                AvanceActualADPM.val(a[0].stsavan);
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function getConsecutivoXDocto() {
        if (DocumentoADPM.val()) {
            $.getJSON('<?php print base_url('AvanceDeProduccionAMaquilas/getConsecutivoDelDocumento') ?>',
                    {DOCUMENTO: DocumentoADPM.val()}).done(function (a) {
                if (a[0].CONSECUTIVO !== undefined) {
                    UC.val(a[0].CONSECUTIVO);
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
            });
        }
    }
</script>