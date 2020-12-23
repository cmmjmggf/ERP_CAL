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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <label>CONTROL</label>
                        <input type="text" id="ControlADarDeBaja" name="ControlADarDeBaja" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="12">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>PARES</label>
                        <input type="text" id="ParesADarDeBaja" name="ParesADarDeBaja" class="form-control text-center mb-3" style="font-size: 34px;border-top: none !important;border-right: none !important;border-left: none !important;border-radius: 0px !important; padding-top: 0px;padding-bottom: 0px;" maxlength="3">
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
    var mdlBajaControles = $("#mdlBajaControles"), ControlADarDeBaja = mdlBajaControles.find("#ControlADarDeBaja"),
            btnAceptaBajaControl = mdlBajaControles.find("#btnAceptaBajaControl"),
            ParesADarDeBaja = mdlBajaControles.find("#ParesADarDeBaja");

    $(document).ready(function () {
        handleEnterDiv(mdlBajaControles);

        btnAceptaBajaControl.click(function () {
            onDisable(btnAceptaBajaControl);
            if (ControlADarDeBaja.val() && parseInt(ParesADarDeBaja.val()) > 0) {
                onOpenOverlay('');
                $.post('<?php print base_url('BajaControles/onDarDeBajaControl'); ?>',
                        {CONTROL: ControlADarDeBaja.val(), PARES: ParesADarDeBaja.val()}).done(function (a) {
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
                        pares_dadosdebaja += xpares;
                        xpares = 0;
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
                ControlADarDeBaja.focus().select();
                onEnable(btnAceptaBajaControl);
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
                    onEnable(btnAceptaBajaControl);
                    btnAceptaBajaControl.focus();
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
</script>