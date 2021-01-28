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
                        <div class="col-6">
                            <label>Lineas: </label>
                            <div class="row">
                                <div class="col-4 d-none">
                                    <input type="text" class="form-control form-control-sm" id="ClaveLineaVentaXLineaEstilo" name="ClaveLineaVentaXLineaEstilo" >
                                </div>
                                <div class="col-12">
                                    <select class="form-control form-control-sm NotSelectize" id="LineaVentaXLineaEstilo" name="LineaVentaXLineaEstilo" multiple="" >
                                        <option></option>
                                        <?php
                                        $lineasx = $this->db->query("SELECT * FROM lineas AS L ORDER BY L.clave ASC")->result();
                                        foreach ($lineasx as $k => $v) {
                                            print "<option value='{$v->Clave}'>{$v->Descripcion}</option>";
                                        }
                                        ?>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Estilo</label>
                            <!--<input type="text" id="EstiloVentaXLineaEstilo" name="EstiloVentaXLineaEstilo" class="form-control" maxlength="10">-->
                            <select class="form-control form-control-sm NotSelectize" id="EstiloVentaXLineaEstilo" name="EstiloVentaXLineaEstilo" multiple="" >
                                <option></option>
                                <?php
                                $estilos = $this->db->query("SELECT E.Clave, E.Descripcion FROM estilos AS E WHERE  E.Clave NOT IN('BIMBOCO','FLETE','BIMBO','VARIOS','COMPLEMENTO','AUTO','IDP','ANTI','EXH','AYUDA','CUERO')  GROUP BY E.Clave ORDER BY ABS(E.clave) ASC")->result();
                                foreach ($estilos as $k => $v) {
                                    print "<option value='{$v->Clave}'>{$v->Clave}</option>";
                                }
                                ?>
                            </select> 
                        </div>
                        <div class="w-100 my-2"></div>
                        <div class="col-6">
                            <span class="switch switch-lg">
                                <input id="checkCABALLERO" name="checkCABALLERO"  type="checkbox" checked="" class="switch">
                                <label for="checkCABALLERO">CABALLERO</label>
                            </span>
                        </div>
                        <div class="col-6"> 
                            <span class="switch switch-lg">
                                <input id="checkDAMA" name="checkDAMA"  type="checkbox" checked="" class="switch">
                                <label for="checkDAMA">DAMA</label>
                            </span>
                        </div>
                        <div class="w-100 my-2"><hr></div>
                        <div class="col-12"> 
                            <span class="switch switch-lg">
                                <input id="checkModeladorDisenador" name="checkModeladorDisenador"  type="checkbox" checked="" class="switch">
                                <label for="checkModeladorDisenador">CON DISEÑADOR / MODELADO (SOLO POR ESTILO)</label>
                            </span>
                        </div>
                        <div class="w-100 my-2"><hr></div>
                        <div class="col-12">
                            <span class="switch switch-lg">
                                <input id="checkTotalesVendidos" name="checkTotalesVendidos"  type="checkbox" class="switch">
                                <label for="checkTotalesVendidos">TOTALES</label>
                            </span>
                        </div>
                        <div class="w-100 my-2"><hr></div> 
                        <div class="col-12"> 
                            <label for="checkOrdenPorPares">ORDENADO POR PARES</label> 
                            <select id="TipoOrdenPorPares" name="TipoOrdenPorPares" class="form-control">
                                <option value="2">DESCENDENTE</option>
                                <option  value="1">ASCENDENTE</option>
                            </select>
                        </div>
                        <div class="col-6 d-none"> 
                            <label for="checkOrdenPorPorcentaje">POR PORCENTAJE</label>
                            <select id="TipoOrdenPorPorcentaje" name="TipoOrdenPorPorcentaje" class="form-control">
                                <option></option>
                                <option value="1">ASCENDENTE</option>
                                <option value="2">DESCENDENTE</option>
                            </select>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info font-weight-bold" id="btnImprimirConTotales" style="background-color: #689F38;  border-color: #689F38;"><span class="fa fa-plus"></span> ACEPTAR (TOTALES)</button>
                <button type="button" class="btn btn-info" id="btnImprimir"><span class="fa fa-check"></span> ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlVentasPorLineaEstiloPorcentaje = $('#mdlVentasPorLineaEstiloPorcentaje'),
            ClaveLineaVentaXLineaEstilo = mdlVentasPorLineaEstiloPorcentaje.find("#ClaveLineaVentaXLineaEstilo"),
            LineaVentaXLineaEstilo = mdlVentasPorLineaEstiloPorcentaje.find("#LineaVentaXLineaEstilo"),
            EstiloVentaXLineaEstilo = mdlVentasPorLineaEstiloPorcentaje.find("#EstiloVentaXLineaEstilo"),
            checkTotalesVendidos = mdlVentasPorLineaEstiloPorcentaje.find("#checkTotalesVendidos"),
            checkCABALLERO = mdlVentasPorLineaEstiloPorcentaje.find("#checkCABALLERO"),
            checkDAMA = mdlVentasPorLineaEstiloPorcentaje.find("#checkDAMA"),
            checkModeladorDisenador = mdlVentasPorLineaEstiloPorcentaje.find("#checkModeladorDisenador"),
            checkAMBOS = mdlVentasPorLineaEstiloPorcentaje.find("#checkAMBOS"),
            checkOrdenPorPares = mdlVentasPorLineaEstiloPorcentaje.find("#checkOrdenPorPares"),
            TipoOrdenPorPares = mdlVentasPorLineaEstiloPorcentaje.find("#TipoOrdenPorPares"),
            checkOrdenPorPorcentaje = mdlVentasPorLineaEstiloPorcentaje.find("#checkOrdenPorPorcentaje"),
            TipoOrdenPorPorcentaje = mdlVentasPorLineaEstiloPorcentaje.find("#TipoOrdenPorPorcentaje");

    $(document).ready(function () {

        LineaVentaXLineaEstilo.selectize({
            persist: true,
            create: false,
            hideSelected: true
        });
        EstiloVentaXLineaEstilo.selectize({
            persist: true,
            create: false,
            hideSelected: true
        });

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

            frm.append('LINEA', LineaVentaXLineaEstilo.val() ? LineaVentaXLineaEstilo.val() : '');
            frm.append('ESTILO', EstiloVentaXLineaEstilo.val() ? EstiloVentaXLineaEstilo.val() : '');
            if (checkDAMA[0].checked && checkCABALLERO[0].checked) {
                frm.append('GENERO', 4);
            } else
            if (checkDAMA[0].checked && !checkCABALLERO[0].checked) {
                frm.append('GENERO', 2);
            } else if (!checkDAMA[0].checked && checkCABALLERO[0].checked) {
                frm.append('GENERO', 1);
            }

            var jasper = '';
            if (checkTotalesVendidos[0].checked) {
                jasper = '<?php print base_url('ReportesClientesJasper/getParesVendidosXFechasXLineaXGeneroTotales'); ?>';
            } else {
                jasper = '<?php print base_url('ReportesClientesJasper/getParesVendidosXFechasXLineaXGenero'); ?>';
                if (checkModeladorDisenador[0].checked) {
                    frm.append('MODELADORDISENADOR', 1);
                } else {
                    frm.append('MODELADORDISENADOR', 0);
                }
            }

            frm.append('ORDEN_PARES', TipoOrdenPorPares.val() ? parseInt(TipoOrdenPorPares.val()) : 0);
            frm.append('ORDEN_PORCENTAJE', TipoOrdenPorPorcentaje.val() ? parseInt(TipoOrdenPorPorcentaje.val()) : 0);

            $.ajax({
                url: jasper,
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

            return;
            if (LineaVentaXLineaEstilo.val() !== '' && checkTotalesVendidos[0].checked
                    && !checkDAMA[0].checked && !checkCABALLERO[0].checked) {
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
            } else if (LineaVentaXLineaEstilo.val() !== '' && !checkTotalesVendidos[0].checked && !checkDAMA[0].checked && !checkCABALLERO[0].checked) {
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

            } else if (checkTotalesVendidos[0].checked && !checkDAMA[0].checked && !checkCABALLERO[0].checked) {
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
    .selectize-control.multi .selectize-input > div {
        background: #000000;
        color: #ffffff;
        border-radius: 10px;
    }
</style>