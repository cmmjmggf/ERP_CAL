<div class="modal " id="mdlVentasPorLineaEstiloPorcentaje"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-file-invoice-dollar"></span> Ventas por Linea y Estilo (Con Porcentaje)</h5>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-6">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniVentasLinEstiPorce" name="FechaIniVentasLinEstiPorce" >
                        </div>
                        <div class="col-6">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinVentasLinEstiPorce" name="FechaFinVentasLinEstiPorce" >
                        </div>
                        <div class="col-12">
                            <label>Linea: </label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control form-control-sm" id="ClaveLineaVentaXLineaEstilo" name="ClaveLineaVentaXLineaEstilo" >
                                </div>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" id="LineaVentaXLineaEstilo" name="LineaVentaXLineaEstilo" >
                                        <option></option>
                                        <?php
                                        $lineasx = $this->db->query("SELECT * FROM lineas AS L ORDER BY L.clave ASC")->result();
                                        foreach ($lineasx as $k => $v) {
                                            print "<option value='{$v->Clave}'>{$v->Clave} {$v->Descripcion}</option>";
                                        }
                                        ?>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        <div class="w-100 my-2"></div>
                        <div class="col-12">
                            <span class="switch switch-lg">
                                <input id="checkTotalesVendidos" name="checkTotalesVendidos"  type="checkbox" class="switch">
                                <label for="checkTotalesVendidos">TOTALES</label>
                            </span>
                        </div>
                        <div class="w-100 my-2"></div>
                        <div class="col-4 d-none">
                            <span class="switch switch-lg">
                                <input id="checkCABALLERO" name="checkCABALLERO"  type="checkbox" checked="" class="switch">
                                <label for="checkCABALLERO">CABALLERO</label>
                            </span>
                        </div>
                        <div class="col-4 d-none"> 
                            <span class="switch switch-lg">
                                <input id="checkDAMA" name="checkDAMA"  type="checkbox" checked="" class="switch">
                                <label for="checkDAMA">DAMA</label>
                            </span>
                        </div>
                        <div class="col-4 d-none"> 
                            <span class="switch switch-lg">
                                <input id="checkAMBOS" name="checkAMBOS"  type="checkbox" checked="" class="switch">
                                <label for="checkAMBOS">AMBOS</label>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnImprimirConTotales"><span class="fa fa-plus"></span> ACEPTAR (TOTALES)</button>
                <button type="button" class="btn btn-info" id="btnImprimir"><span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlVentasPorLineaEstiloPorcentaje = $('#mdlVentasPorLineaEstiloPorcentaje'),
            ClaveLineaVentaXLineaEstilo = mdlVentasPorLineaEstiloPorcentaje.find("#ClaveLineaVentaXLineaEstilo"),
            LineaVentaXLineaEstilo = mdlVentasPorLineaEstiloPorcentaje.find("#LineaVentaXLineaEstilo")
    checkTotalesVendidos = mdlVentasPorLineaEstiloPorcentaje.find("#checkTotalesVendidos"),
    checkCABALLERO = mdlVentasPorLineaEstiloPorcentaje.find("#checkCABALLERO"),
            checkDAMA = mdlVentasPorLineaEstiloPorcentaje.find("#checkDAMA"),
            checkAMBOS = mdlVentasPorLineaEstiloPorcentaje.find("#checkAMBOS");

    $(document).ready(function () {

        checkAMBOS.change(function () {
            if (checkAMBOS[0].checked) {
                checkDAMA[0].checked = true;
                checkCABALLERO[0].checked = true;
            } else {
                checkDAMA[0].checked = false;
                checkCABALLERO[0].checked = false;
            }
        });

        LineaVentaXLineaEstilo.change(function (e) {
            if (LineaVentaXLineaEstilo.val()) {
                ClaveLineaVentaXLineaEstilo.val($(this).val());
            }
            if (LineaVentaXLineaEstilo.val() === '') {
                ClaveLineaVentaXLineaEstilo.val("");
            }
        });

        ClaveLineaVentaXLineaEstilo.keydown(function (e) {
            if (e.keyCode === 13 && ClaveLineaVentaXLineaEstilo.val()) {
                LineaVentaXLineaEstilo[0].selectize.setValue($(this).val());
            }
            if (e.keyCode === 8 && ClaveLineaVentaXLineaEstilo.val() === '') {
                onClear(LineaVentaXLineaEstilo);
            }
        });

        mdlVentasPorLineaEstiloPorcentaje.on('shown.bs.modal', function () {
            handleEnterDiv(mdlVentasPorLineaEstiloPorcentaje);
            mdlVentasPorLineaEstiloPorcentaje.find("input").val("");
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaIniVentasLinEstiPorce').val(getFirstDayMonth());
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaFinVentasLinEstiPorce').val(getToday());
            mdlVentasPorLineaEstiloPorcentaje.find('#FechaIniVentasLinEstiPorce').focus();
        });

        mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales').on("click", function () {
            onDisable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
            onDisable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasPorLineaEstiloPorcentaje.find("#frmCaptura")[0]);
            frm.append('Reporte', mdlVentasPorLineaEstiloPorcentaje.find('input[name=ReporteVentasPorFecha]:checked').attr('valor'));
            if (LineaVentaXLineaEstilo.val() !== '' && checkTotalesVendidos[0].checked) {
                frm.append('LINEA', LineaVentaXLineaEstilo.val());
                $.ajax({
                    url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentajeTotalesXLineaEspecifica'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                    });
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
            } else if (LineaVentaXLineaEstilo.val() !== '' && !checkTotalesVendidos[0].checked) {
                frm.append('LINEA', LineaVentaXLineaEstilo.val());
                $.ajax({
                    url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentajeTotalesXLineaDetallada'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                    });
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
            
            } else if (checkTotalesVendidos[0].checked) {
                frm.append('LINEA', LineaVentaXLineaEstilo.val());
                $.ajax({
                    url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentajeTotalesXLinea'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                    });
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
            } else {
                $.ajax({
                    url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentajeTotales'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: frm
                }).done(function (data, x, jq) {
                    console.log(data);
                    onImprimirReporteFancyAFC(data, function () {
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                        onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                    });
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimirConTotales'));
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
            }
        });
        mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir').on("click", function () {
            onDisable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            var frm = new FormData(mdlVentasPorLineaEstiloPorcentaje.find("#frmCaptura")[0]);
            frm.append('Reporte', mdlVentasPorLineaEstiloPorcentaje.find('input[name=ReporteVentasPorFecha]:checked').attr('valor'));
            $.ajax({
                url: '<?php print base_url('ReportesClientesJasper/onReporteVentasPorLineaEstiloPorcentaje'); ?>',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: frm
            }).done(function (data, x, jq) {
                console.log(data);
                onImprimirReporteFancyAFC(data, function () {
                    onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
                });
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
                HoldOn.close();
                onEnable(mdlVentasPorLineaEstiloPorcentaje.find('#btnImprimir'));
            });
        });
    });
</script>
<style>
    input[type="checkbox"]:hover, span:hover input[type="checkbox"] {
        cursor: pointer;
    }    
</style>