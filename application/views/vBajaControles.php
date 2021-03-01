<div class="modal fade next-art" id="mdlBajaControles" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"  
     aria-labelledby="mdlBajaControles" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title next-art"><span class="fa fa-arrow-down"></span> Baja controles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label>OBSERVACIONES</label>
                        <textarea class="form-control" id="ObservacionesFacturaVarios" rows="3"></textarea>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>CONTROL</label>
                        <input type="text" id="ControlADarDeBaja" name="ControlADarDeBaja" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="12">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label>PARES</label>
                        <input type="text" id="ParesADarDeBaja" name="ParesADarDeBaja" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="3">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>FACTURA</label>
                        <input type="text" id="FacturaCorresponde" name="FacturaCorresponde" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="10">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label>PARES-F</label>
                        <input type="text" id="ParesFacturaADarDeBaja" name="ParesFacturaADarDeBaja" readonly="" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="3">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic pares_del_control_baja " style="color: #007eff;">-</h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic pares_facturados_del_control_baja "  style="color: #703ab7;">-</h4>
                    </div>
                    <div class="w-100"><hr></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic estatus_del_control_baja">-</h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic cliente_del_control_baja">-</h4>
                    </div>
                    <div class="w-100"><hr></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic estilo_control_baja">-</h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <h4 class="font-weight-bold font-italic color_control_baja">-</h4>
                    </div>
                    <div class="col-12">
                        <p class="font-italic font-weight-bold text-center pares_dadosdebaja" style="font-size: 28px;">0 PARES</p>
                    </div>
                    <div class="col-12">
                        <p class="font-italic font-weight-bold text-center ultimo_control_ingresado" style="font-size: 28px;">-</p>
                    </div>
                    <input type="file" id="ComprobanteCoppel" name="ComprobanteCoppel" class="d-none">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnAceptaBajaControl" style="background-color: #4CAF50;border-color: #4CAF50; font-weight: bold;">
                    <span class="fa fa-check"></span> ACEPTA</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var mdlBajaControles = $("#mdlBajaControles"), 
            ObservacionesFacturaVarios = mdlBajaControles.find("#ObservacionesFacturaVarios"),
            ControlADarDeBaja = mdlBajaControles.find("#ControlADarDeBaja"),
            btnAceptaBajaControl = mdlBajaControles.find("#btnAceptaBajaControl"),
            ParesADarDeBaja = mdlBajaControles.find("#ParesADarDeBaja"),
            FacturaCorresponde = mdlBajaControles.find("#FacturaCorresponde");

    $(document).ready(function () {
        handleEnterDiv(mdlBajaControles);

        btnAceptaBajaControl.click(function () {
            onDisable(btnAceptaBajaControl);
            if (ControlADarDeBaja.val() && parseInt(ParesADarDeBaja.val()) > 0 && FacturaCorresponde.val()) {
                onOpenOverlay('');
                mdlBajaControles.find("p.ultimo_control_ingresado").text(ControlADarDeBaja.val());
                $.post('<?php print base_url('BajaControles/onDarDeBajaControl'); ?>',
                        {CONTROL: ControlADarDeBaja.val(),
                            PARES: ParesADarDeBaja.val(),
                            FACTURA: FacturaCorresponde.val()
                        }).done(function (a) {
                    onCloseOverlay();
                    onBeep(5);
                    swal({
                        title: "ATENCIÓN",
                        text: "SE HA DADO DE BAJA EL CONTROL",
                        icon: "success",
                        buttons: false,
                        timer: 500
                    }).then((action) => {
                        getInformacionDelControl();
                        onDisable(btnAceptaBajaControl);
                        ControlADarDeBaja.focus().select();
                        pares_dadosdebaja += parseInt(ParesADarDeBaja.val());
                        xpares = 0;
                        mdlBajaControles.find("p.pares_dadosdebaja").text(pares_dadosdebaja + ' PARES');
                        mdlBajaControles.find("p.pares_dadosdebaja").text(pares_dadosdebaja + ' PARES');
                    });
                }).fail(function (e) {
                    onCloseOverlay();
                    onEnable(btnAceptaBajaControl);
                    getError(e);
                }).always(function () {
                    onCloseOverlay();
                    onDisable(btnAceptaBajaControl);
                });
            } else {
                if (!ControlADarDeBaja.val()) {
                    ControlADarDeBaja.focus().select();
                }
                if (!ParesADarDeBaja.val()) {
                    ParesADarDeBaja.focus().select();
                }
                if (!FacturaCorresponde.val()) {
                    FacturaCorresponde.focus().select();
                }
                onEnable(btnAceptaBajaControl);
                return;
            }
        });

        mdlBajaControles.on('shown.bs.modal', function () {
            mdlBajaControles.find("input").val("");
            onDisable(btnAceptaBajaControl);
            ControlADarDeBaja.focus();
        });
        mdlBajaControles.on('hidden.bs.modal', function () {
            mdlBajaControles.find("h4.pares_del_control_baja").html('0<br> PARES');
            mdlBajaControles.find("h4.pares_facturados_del_control_baja").html('0<br>PARES FACTURADOS');
            mdlBajaControles.find("h4.estatus_del_control_baja").html('<span style="color:#cc0000;">-</span>');
            mdlBajaControles.find("h4.cliente_del_control_baja").text('-');
            mdlBajaControles.find("h4.estilo_control_baja").html('ESTILO <span style="color:#558B2F;">-</span>');
            mdlBajaControles.find("h4.color_control_baja").html('COLOR <span style="color:#cc0000;">-</span>');
        });

        FacturaCorresponde.keydown(function (e) {
            if (FacturaCorresponde.val() && e.keyCode === 13) {
                onEnable(btnAceptaBajaControl);
                getCantidadDeParesXFactura();
                btnAceptaBajaControl.focus();
            } else if (FacturaCorresponde.val() === '' && e.keyCode === 13) {
                onCampoInvalido(mdlBajaControles, "DEBE DE ESPECIFICAR EL NÚMERO DE FACTURA", function () {

                });
            }
        });

        ControlADarDeBaja.keydown(function (e) {
            if (ControlADarDeBaja.val() && e.keyCode === 13) {
                getInformacionDelControl();
            }
            if (ControlADarDeBaja.val() === '' && e.keyCode === 13 ||
                    ControlADarDeBaja.val() === '' && e.keyCode === 8 ||
                    ControlADarDeBaja.val() === '' && e.keyCode === 46) {
                mdlBajaControles.find("h4.pares_del_control_baja").html('0<br> PARES');
                mdlBajaControles.find("h4.pares_facturados_del_control_baja").html('0<br>PARES FACTURADOS');
                mdlBajaControles.find("h4.estatus_del_control_baja").html('<span style="color:#cc0000;">-</span>');
                mdlBajaControles.find("h4.cliente_del_control_baja").text('-');
                mdlBajaControles.find("h4.estilo_control_baja").html('ESTILO <span style="color:#558B2F;">-</span>');
                mdlBajaControles.find("h4.color_control_baja").html('COLOR <span style="color:#cc0000;">-</span>');
            }
        });
    });
    var pares_dadosdebaja = 0, xpares = 0;
    function getInformacionDelControl( ) {
        onOpenOverlay('');
        $.post('<?php print base_url('BajaControles/getInformacionXControl'); ?>',
                {CONTROL: ControlADarDeBaja.val()}).done(function (a) {
            if (a.length > 0) {
                var c = JSON.parse(a)[0];
                xpares = parseInt(c.Pares);
                mdlBajaControles.find("#ParesADarDeBaja").val(c.Pares);
                mdlBajaControles.find("h4.pares_del_control_baja").html(c.Pares + '<br> PARES');
                mdlBajaControles.find("h4.pares_facturados_del_control_baja").html(c.ParesFacturados + '<br>PARES FACTURADOS');
                mdlBajaControles.find("h4.estatus_del_control_baja").html('<span style="color:#cc0000;">' + c.DeptoProduccion + ' ' + c.EstatusProduccion + '<br>(' + c.stsavan + ')</span>');
                mdlBajaControles.find("h4.cliente_del_control_baja").html('CLIENTE <br><span style="color:#558B2F;">' + c.Cliente + '</span>');
                mdlBajaControles.find("h4.estilo_control_baja").html('ESTILO <br><span style="color:#558B2F;">' + c.Estilo + '</span>');
                mdlBajaControles.find("h4.color_control_baja").html('COLOR <br><span style="color:#cc0000;">' + c.Color + '</span>');

                if (parseInt(c.stsavan) === 12 && parseInt(c.DeptoProduccion) === 240) {
                    FacturaCorresponde.focus().select();
                } else {
                    onDisable(btnAceptaBajaControl);
                }
            }
            onCloseOverlay();
        }).fail(function (e) {
            onCloseOverlay();
            getError(e);
        }).always(function () {
            onCloseOverlay();
        });
    }

    function getCantidadDeParesXFactura() {
        onOpenOverlay('');
        $.getJSON('<?php print base_url('BajaControles/getCantidadDeParesXFactura'); ?>',
                {FACTURA: FacturaCorresponde.val()}).done(function (a) {
            if (a.length > 0) {
                var c = a[0];
                xpares = parseInt(c.PARES);
                pares_dadosdebaja = parseInt(c.PARES);
                mdlBajaControles.find("p.pares_dadosdebaja").text(c.PARES + ' PARES');
                mdlBajaControles.find("p.ultimo_control_ingresado").text(c.CONTROL);
            }
            onCloseOverlay();
        }).fail(function (e) {
            onCloseOverlay();
            getError(e);
        }).always(function () {
            onCloseOverlay();
        });
    }
</script>
<style>

    p.ultimo_control_ingresado {
        animation: color-change 6s infinite;
    }

    @keyframes color-change {
        0% { color: #FF841D; }
        50% { color: #FFB100; }
        100% { color: #FF841D; }
    }
</style>