<div class="modal" id="mdlControlesADiasDeVencimientoXCliente">
    <div class="modal-dialog modal-dialog-centered notdraggable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-calendar"></span> Controles a dias de vencimiento por cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-2 col-lg-4 col-xl-4">
                        <label for="" >Cliente*</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" autofocus="" maxlength="5" id="IDClienteCAV" name="IDClienteCAV" required="" placeholder="">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 mt-4">

                        <select id="ClienteCAV" name="ClienteCAV" class="form-control form-control-sm selectNotEnter">
                            <option></option>
                            <?php
                            //YA CONTIENE LOS BLOQUEOS DE VENTA
                            $clientesPnl = $this->db->query("SELECT C.Clave AS CLAVE, C.RazonS AS CLIENTE FROM clientes AS C LEFT JOIN bloqueovta AS B ON C.Clave = B.cliente WHERE C.Estatus IN('ACTIVO') AND B.cliente IS NULL  OR C.Estatus IN('ACTIVO') AND B.`status` = 2 ORDER BY C.RazonS ASC;")->result();
                            foreach ($clientesPnl as $k => $v) {
                                print "<option value=\"{$v->CLAVE}\">{$v->CLIENTE}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label>Año</label>
                        <input type="text" id="AnoCAV" name="AnoCAV" class="form-control form-control-sm  numeric" maxlength="4">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 d-none">
                        <label>De la maquila</label>
                        <input type="text" id="MaqInicialCAV" name="MaqInicialCAV" readonly="" class="form-control form-control-sm numeric"  maxlength="2">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3  d-none" >
                        <label>A la maquila</label>
                        <input type="text" id="MaqFinalCAV" name="MaqFinalCAV"  readonly="" class="form-control form-control-sm numeric" maxlength="2">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3  d-none">
                        <label>Dias</label>
                        <input type="text" id="DiasCAV" name="DiasCAV"  readonly="" class="form-control form-control-sm numeric" maxlength="2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnAceptarCAV"><span class="fa fa-print"></span> Acepta</button>
            </div>
        </div>
    </div>
</div>

<script>

    var mdlControlesADiasDeVencimientoXCliente = $("#mdlControlesADiasDeVencimientoXCliente"),
            IDClienteCAV = mdlControlesADiasDeVencimientoXCliente.find("#IDClienteCAV"),
            ClienteCAV = mdlControlesADiasDeVencimientoXCliente.find("#ClienteCAV"),
            AnoCAV = mdlControlesADiasDeVencimientoXCliente.find("#AnoCAV"),
            MaqInicialCAV = mdlControlesADiasDeVencimientoXCliente.find("#MaqInicialCAV"),
            MaqFinalCAV = mdlControlesADiasDeVencimientoXCliente.find("#MaqFinalCAV"),
            DiasCAV = mdlControlesADiasDeVencimientoXCliente.find("#DiasCAV"),
            btnAceptarCAV = mdlControlesADiasDeVencimientoXCliente.find("#btnAceptarCAV");

    $(document).ready(function () {
        handleEnterDiv(mdlControlesADiasDeVencimientoXCliente);
        AnoCAV.val(new Date().getFullYear());
        ClienteCAV[0].selectize.disable();

        mdlControlesADiasDeVencimientoXCliente.on('hidden.bs.modal', function () {
            mdlControlesADiasDeVencimientoXCliente.find('input').val('');
            $.each(mdlControlesADiasDeVencimientoXCliente.find("select"), function (k, v) {
                mdlControlesADiasDeVencimientoXCliente.find("select")[k].selectize.clear(true);
            });
        });

        IDClienteCAV.keydown(function (e) {
            if (e.keyCode === 13) {
                var txtcliente = $(this).val();
                if (txtcliente) {
                    $.getJSON('<?php print base_url('ControlesADiasDevencimientoXCliente/onVerificaCliente'); ?>', {Cliente: txtcliente}).done(function (data) {
                        if (data.length > 0) {
                            ClienteCAV[0].selectize.setValue(txtcliente); 
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                ClienteCAV[0].selectize.clear(true);
                                ClienteCAV[0].selectize.focus();
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });

        mdlControlesADiasDeVencimientoXCliente.on('shown.bs.modal', function () {
            IDClienteCAV.focus().select();
        });


        btnAceptarCAV.click(function () {
            btnAceptarCAV.attr('disabled', true);
            if (ClienteCAV.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Por favor espere...'
                }); 
                var f = new FormData();
                f.append('CLIENTE', ClienteCAV.val());
                f.append('MAQUILA_INICIAL', MaqInicialCAV.val());
                f.append('MAQUILA_FINAL', MaqFinalCAV.val());
                f.append('DIAS', DiasCAV.val());
                f.append('ANIO', AnoCAV.val());
                $.ajax({
                    url: '<?php print base_url('ControlesADiasDevencimientoXCliente/getReporte'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (data, x, jq) {
                    onImprimirReporteFancyAFC(data, function (instance, current) {
                        IDClienteCAV.focus().select();
                    });
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                    btnAceptarCAV.attr('disabled', false);
                });
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN CLIENTE', 'warning').then((value) => {
                    ClienteCAV[0].selectize.focus();
                });
            }
        });

    });
</script> 