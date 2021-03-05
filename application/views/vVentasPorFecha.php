<div class="modal " id="mdlVentasPorFecha"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-file-invoice-dollar"></span> Ventas por fechas</h5>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniVentasPorFecha" name="FechaIniVentasPorFecha" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinVentasPorFecha" name="FechaFinVentasPorFecha" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="mb-1">Tp <span class="badge badge-info" style="font-size: 14px;">0 = X Maquila, Deja en blanco para ver todo</span></label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="TpVentasPorFecha" name="TpVentasPorFecha">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-block" id="btnMensualSinRefacturacionOtrosTraspasos" style="background-color: #673AB7; border-color: #673AB7;" onclick="onImprimirReporteDeVentas(this, 1)"><span class="fa fa-check"></span> Mensual sin refacturacion, otros y traspasos</button>
                        </div>
                        <div class="col-12 my-2">
                            <button type="button" class="btn btn-danger btn-block" id="btnMovimientosConRefacturacionOtrosTraspasos" style="background-color: #4CAF50; border-color: #4CAF50;"onclick="onImprimirReporteDeVentas(this, 2)"><span class="fa fa-check"></span> Movimientos, con refacturación, otros traspasos</button>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-success btn-block" id="btnImporteDocumentoYCliente" style="background-color: #F44336; border-color: #F44336;"onclick="onImprimirReporteDeVentas(this, 3)"><span class="fa fa-check"></span> Importe, documento y cliente</button>
                        </div>
                        <div class="w-100 my-2"><hr></div>
                        <div class="col-12">
                            <button type="button" class="btn btn-default btn-block" id="btnImporteDocumentoYCliente" style="background-color: #2196F3; border-color: #2196F3;"onclick="onImprimirReporteDeVentas(this, 3)"><span class="fa fa-check"></span> Cliente, Documento, Fecha, Control, Estilo, Pares, Precio, Total</button>
                        </div>
                        <div class="col-12 my-2">
                            <button type="button" class="btn btn-default btn-block" id="btnImporteDocumentoYCliente" style="background-color: #2196F3; border-color: #2196F3;"onclick="onImprimirReporteDeVentas(this, 3)"><span class="fa fa-check"></span> Cliente, Documento, Fecha, Estilo, Pares, Precio, Total</button>
                        </div>
                        <div class="col-12 d-none">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rOpcion1" name="ReporteVentasPorFecha" valor = '1' class="custom-control-input">
                                    <label class="custom-control-label text-success" for="rOpcion1">Mensual sin refacturacion, otros y traspasos</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rOpcion2" name="ReporteVentasPorFecha" valor = '2' class="custom-control-input">
                                    <label class="custom-control-label text-danger" for="rOpcion2" >Movimientos, con refacturación, otros traspasos</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="rOpcion3" name="ReporteVentasPorFecha" valor = '3' class="custom-control-input">
                                    <label class="custom-control-label text-info" for="rOpcion3">Importe, docto y cliente</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info d-none" id="btnImprimir"><span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlVentasPorFecha = $('#mdlVentasPorFecha'),
            btnMensualSinRefacturacionOtrosTraspasos = mdlVentasPorFecha.find("#btnMensualSinRefacturacionOtrosTraspasos"),
            btnMovimientosConRefacturacionOtrosTraspasos = mdlVentasPorFecha.find("#btnMovimientosConRefacturacionOtrosTraspasos"),
            btnImporteDocumentoYCliente = mdlVentasPorFecha.find("#btnImporteDocumentoYCliente");

    function onImprimirReporteDeVentas(btn, id) {
        onDisable($(btn));
        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var frm = new FormData(mdlVentasPorFecha.find("#frmCaptura")[0]);
        frm.append('Reporte', id);
        $.ajax({
            url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorFecha'); ?>',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: frm
        }).done(function (data, x, jq) {
            console.log(data);
            onImprimirReporteFancyArrayAFC(JSON.parse(data), function () {
                onEnable($(btn));
            });
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
            onEnable($(btn));
        });
    }

    $(document).ready(function () {
        mdlVentasPorFecha.on('shown.bs.modal', function () {
            handleEnterDiv(mdlVentasPorFecha);
            mdlVentasPorFecha.find("input").val("");
            mdlVentasPorFecha.find('input:radio').prop("checked", false);
            mdlVentasPorFecha.find('#FechaIniVentasPorFecha').val(getFirstDayMonth());
            mdlVentasPorFecha.find('#FechaFinVentasPorFecha').val(getToday());
            mdlVentasPorFecha.find('#FechaIniVentasPorFecha').focus();
        });

        mdlVentasPorFecha.find("#TpVentasPorFecha").blur(function () {
            if ($(this).val()) {
                onVerificarTp($(this));
            } else {
                mdlVentasPorFecha.find("#btnImprimir").focus();
            }
        });

        mdlVentasPorFecha.find('#btnImprimir').on("click", function () {
            onDisable(mdlVentasPorFecha.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasPorFecha.find("#frmCaptura")[0]);
            frm.append('Reporte', mdlVentasPorFecha.find('input[name=ReporteVentasPorFecha]:checked').attr('valor'));
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorFecha'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancyArrayAFC(JSON.parse(data), function () {
                    onEnable(mdlVentasPorFecha.find('#btnImprimir'));
                });
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
                onEnable(mdlVentasPorFecha.find('#btnImprimir'));
            });
        });
    });

    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2 || tp === 0) {
            mdlVentasPorFecha.find("#btnImprimir").focus();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 , 2 ó 0",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
</script>
