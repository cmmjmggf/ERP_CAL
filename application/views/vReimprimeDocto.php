<div class="modal" id="mdlReimprimeDocto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Regenera pdf y xml factura y reimprimer nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label>Cliente</label>
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
                        <select id="TPReg" name="TPReg" class="form-control form-control-sm">
                            <option></option> 
                            <option value="1">1</option> 
                            <option value="2">2</option> 
                        </select>
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
                <button type="button" class="btn btn-primary" id="btnAceptarReImprime">
                    <span class="fa fa-check"></span> Aceptar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlReimprimeDocto = $("#mdlReimprimeDocto"),
            ClienteReg = mdlReimprimeDocto.find("#ClienteReg"),
            FacturaReg = mdlReimprimeDocto.find("#FacturaReg"),
            TPReg = mdlReimprimeDocto.find("#TPReg"),
            btnAceptarReImprime = mdlReimprimeDocto.find("#btnAceptarReImprime");

    $(document).ready(function () {

        handleEnterDiv(mdlReimprimeDocto);

        btnAceptarReImprime.click(function () {
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
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ATENCIÓN', 'HA OCURRIDO UN ERROR INESPERADO AL OBTENER EL REPORTE,CONSULTE LA CONSOLA PARA MÁS DETALLES.', 'warning');
                }).always(function () {
                    onCloseOverlay();
                });
            } else {
                iMsg('ES NECESARIO ESPECIFICAR UN CLIENTE, UNA FACTURA Y UN TP', 'w', function () {
                    ClienteReg[0].selectize.focus();
                });
            }
        });

        ClienteReg.change(function () {

        });

        mdlReimprimeDocto.on('shown.bs.modal', function () {
            ClienteReg[0].selectize.focus();
        });
    });
</script>