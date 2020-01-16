<div class="modal" id="mdlReimprimeDocto">
    <div class="modal-dialog modal-dialog-centered notdraggable" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <h6 class="modal-title">
                    <span class="fa fa-print"></span> Regenera PDF y XML (Factura) y reimprime nota
                </h6> 
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Cliente</label>
                        <div class="row">
                            <div class="col-3">
                                <input id="xClienteReg" name="xClienteReg" class="form-control form-control-sm" maxlength="15">
                            </div>
                            <div class="col-9">
                                <select id="ClienteReg" name="ClienteReg" class="form-control form-control-sm">
                                    <option></option>
                                    <?php
                                    foreach ($this->db->select("C.Clave AS CLAVE, CONCAT(C.Clave, \" - \",C.RazonS) AS CLIENTE, C.ListaPrecios AS LISTADEPRECIO", false)
                                            ->from('clientes AS C')->where_in('C.Estatus', 'ACTIVO')->order_by('ABS(C.Clave)', 'ASC')->get()->result() as $k => $v) {
                                        print "<option value='{$v->CLAVE}' lista='{$v->LISTADEPRECIO}'>{$v->CLIENTE}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Factura</label>
                        <input type="text" id="FacturaReg" name="FacturaReg" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group"> 
                            <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                                <input type="checkbox" class="custom-control-input" id="NoGenIVA" name="NoGenIVA" style="cursor: pointer !important;">
                                <label class="custom-control-label text-danger labelCheck" for="NoGenIVA" style="cursor: pointer !important;">No genera I.V.A</label>
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group"> 
                            <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                                <input type="checkbox" class="custom-control-input" id="RemisionVarios" name="RemisionVarios" style="cursor: pointer !important;">
                                <label class="custom-control-label text-danger labelCheck" for="RemisionVarios" style="cursor: pointer !important;">Remisión varios</label>
                            </div>
                        </div> 
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>TP</label>
                        <input type="text" id="TPReg" name="TPReg" class="form-control form-control-sm numbersOnly" maxlength="1">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="form-group"> 
                            <div class="custom-control custom-checkbox"  align="center" style="cursor: pointer !important;">
                                <input type="checkbox" class="custom-control-input" id="FacturaVarios" name="FacturaVarios" style="cursor: pointer !important;">
                                <label class="custom-control-label text-danger labelCheck" for="FacturaVarios" style="cursor: pointer !important;">Factura varios</label>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnAceptarReImprime">
                    <span class="fa fa-print"></span> Aceptar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlReimprimeDocto = $("#mdlReimprimeDocto"),
            xClienteReg = mdlReimprimeDocto.find("#xClienteReg"),
            ClienteReg = mdlReimprimeDocto.find("#ClienteReg"),
            FacturaReg = mdlReimprimeDocto.find("#FacturaReg"),
            TPReg = mdlReimprimeDocto.find("#TPReg"),
            btnAceptarReImprime = mdlReimprimeDocto.find("#btnAceptarReImprime");

    $(document).ready(function () {

        handleEnterDiv(mdlReimprimeDocto);
        xClienteReg.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xClienteReg.val()) {
                    ClienteReg[0].selectize.setValue(xClienteReg.val());
                    if (ClienteReg.val()) {
                        ClienteReg[0].selectize.disable();
                    } else {
                        ClienteReg[0].selectize.clear(true);
                        ClienteReg[0].selectize.disable();
                        iMsg('NUMERO DE EMPLEADO INVÁLIDO, INTENTE CON OTRO', 'w', function () {
                            xClienteReg.focus().select();
                            ClienteReg[0].selectize.enable();
                        });
                    }
                } else {
                    ClienteReg[0].selectize.clear(true);
                    ClienteReg[0].selectize.enable();
                }
            } else {
                ClienteReg[0].selectize.clear(true);
                ClienteReg[0].selectize.enable();
            }
        });


        btnAceptarReImprime.click(function () {
            onDisable(btnAceptarReImprime);
            if (ClienteReg.val() && FacturaReg.val() && TPReg.val()) {
                onBeep(1);
                onOpenOverlay('Espere por favor...');
                $.post('<?php print base_url('FacturacionProduccion/getVistaPrevia'); ?>', {
                    CLIENTE: ClienteReg.val().trim() !== '' ? ClienteReg.val() : '',
                    DOCUMENTO_FACTURA: FacturaReg.val().trim() !== '' ? FacturaReg.val() : '',
                    TP: TPReg.val().trim() !== '' ? TPReg.val() : ''
                }).done(function (data, x, jq) {
                    console.log(data);
                    onBeep(1);
                    onImprimirReporteFancyAFC(data, function () {
                        ClienteReg.focus().select();
                        onEnable(btnAceptarReImprime);
                    });
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                iMsg('ES NECESARIO ESPECIFICAR UN CLIENTE, UNA FACTURA Y UN TP', 'w', function () {
                    if (!ClienteReg.val()) {
                        xClienteReg.focus().select();
                    } else if (!FacturaReg.val()) {
                        FacturaReg.focus().select();
                    } else if (!TPReg.val()) {
                        TPReg.focus().select();
                    }
                });
            }
        });

        ClienteReg.change(function () {
            if (ClienteReg.val()) {
                xClienteReg.val(ClienteReg.val());
                ClienteReg[0].selectize.disable();
                FacturaReg.focus().select();
            } else {
                xClienteReg.val("");
                ClienteReg[0].selectize.enable();
                xClienteReg.focus().select();
            }
        });

        mdlReimprimeDocto.on('shown.bs.modal', function () {
            xClienteReg.focus();
        });

        mdlReimprimeDocto.on('hidden.bs.modal', function () {
            onClearPanelInputSelectEnableDisable(mdlReimprimeDocto, function () {
                
            }, true);
        });
    });
</script>