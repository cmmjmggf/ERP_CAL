<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Prestamos a empleados <span class="fa fa-coins"></span></legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-danger" id="btnInteresPagares"  data-toggle="modal" data-target="#mdlInteresPrestamos"><span class="fa fa-percent"></span> INTERÉS <br></button>

                <button type="button" class="btn btn-primary" id="btnEmpleadosConsulta" data-toggle="tooltip" data-placement="bottom" title="Empleados"><span class="fa fa-user-circle"></span> EMPLEADOS <br></button>

                <button type="button" class="btn btn-info" id="btnReimprimirPagare" data-toggle="tooltip" data-placement="bottom" title="Reimprimir"><span class="fa fa-print"></span> REIMPRESIÓN DE PAGARES<br></button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div class="row">
                <div class="col-10">
                    <label>No.empleado</label>
                    <select id="Empleado" name="Empleado" class="form-control"></select>
                </div>
                <div class="col-2">
                    <!--ULTIMO DIGITO DEL AÑO, MES, DIA,NUMERO DE EMPLEADO-->
                    <label>Pagare No.</label>
                    <input type="text" id="PagareNo" name="PagareNo" class="form-control form-control-sm" autocomplete="off" readonly="">
                </div>
                <div class="w-100"></div>
                <div class="col-1">
                    <span class="badge badge-danger">
                        <h6>Ultimo Saldo</h6>
                    </span>
                </div>
                <div class="col-2">
                    <label>Pres.Acum</label>
                    <input type="text" id="PrestamoAcumulado" name="PrestamoAcumulado" class="form-control form-control-sm" autocomplete="off">
                </div>
                <div class="col-2">
                    <label>Abono</label>
                    <input type="text" id="Abono" name="Abono" class="form-control form-control-sm" autocomplete="off">
                </div>
                <div class="col-2">
                    <label>Saldo</label>
                    <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm" autocomplete="off">
                </div>
                <div class="col-1">
                    <label>Semana</label>
                    <input type="text" id="Semana" name="Semana" class="form-control form-control-sm" data-toggle="tooltip" data-placement="bottom" title="SEMANA DE CARACTER INFORMATIVO" readonly="" autocomplete="off">
                </div>
                <div class="col-2">
                    <div class="alert alert-dismissible alert-info"> 
                        <strong> % </strong> Interés semanal sobre saldo insolutos.
                    </div>
                </div>
                <div class="col-2"> 
                    <input type="text" id="Interes" name="Interes" value="0" class="form-control form-control-sm" autocomplete="off" placeholder="0">
                </div>
                <div class="w-100"></div>
                <div class="col-1">
                    <span class="badge badge-danger">
                        <h6>Prestamo nvo</h6>
                    </span>
                </div>
                <div class="col-2"> 
                    <input type="text" id="NuevoPrestamo" name="NuevoPrestamo" class="form-control form-control-sm numbersOnly" autocomplete="off" maxlength="8">
                </div>
                <div class="col-2"> 
                    <input type="text" id="NuevoPrestamoAbono" name="NuevoPrestamoAbono" class="form-control form-control-sm numbersOnly" autocomplete="off" maxlength="8">
                </div>
                <div class="col-2"> 
                    <button id="btnGuardarNP" name="btnGuardarNP" class="btn btn-primary">
                        <span class="fa fa-check"></span>
                    </button>
                </div>
                <div class="w-100 my-2"></div>
                <div class="col-1">
                    <span class="badge badge-danger">
                        <h6>Saldo actual</h6>
                    </span>
                </div>
                <div class="col-2"> 
                    <input type="text" id="NuevoSaldoPrestamo" name="NuevoSaldoPrestamo" class="form-control form-control-sm" autocomplete="off" readonly="">
                </div>
                <div class="col-2"> 
                </div>
                <div class="col-2"> 
                    <input type="text" id="SaldoFinal" name="SaldoFinal" class="form-control form-control-sm" autocomplete="off" readonly="">
                </div>
                <div class="col-2"> 
                    <div class="alert alert-dismissible alert-primary">
                        <p>STS</p>
                        <p>1 = Sin aplicar</p>
                        <p>2 = Aplicado</p>
                    </div>
                </div>  
                <div class="w-100"></div>
                <div id="TotalEnLetra" class="col-12 text-center">
                    <p class="font-weight-bold text-warning display-4"></p>
                </div>
                <div class="col-12">
                    <p class="font-weight-bold text-danger">
                        NOTA: LOS ABONOS NO DEBEN DE LLEVAR CENTAVOS
                    </p>
                </div>
                <!--PRESTAMOS-->
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <p class="font-weight-bold">Prestamos de este empleado</p>
                    <div id="Prestamos" class="table-responsive">
                        <table id="tblPrestamos" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No</th>
                                    <th>Fecha</th>
                                    <th>Pagare</th>
                                    <th>Sem</th>
                                    <th>Prestamo</th>
                                    <th>Abono</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!--PAGOS DE LOS PRESTAMOS-->
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <p class="font-weight-bold">Pagos de los prestamos</p>
                    <div id="PrestamosPagos" class="table-responsive">
                        <table id="tblPrestamosPagos" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No</th>
                                    <th>Sem</th>
                                    <th>Fecha</th>
                                    <th>Abono</th>
                                    <th>Interes</th>
                                    <th>STS</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col-4">
                    <h3 class="font-weight-bold">Total prestamos</h3>
                    <input type="text" id="TotalPrestamos" name="TotalPrestamos" class="form-control d-none" readonly="">
                    <p id="TotalPrestamosParrafo" class="font-weight-bold text-danger display-4">$ 0.0</p>
                </div>
                <div class="col-4">
                    <h3 class="font-weight-bold">Total abonos</h3>
                    <input type="text" id="TotalAbonos" name="TotalAbonos" class="form-control d-none" readonly="">
                    <p id="TotalAbonosParrafo" class="font-weight-bold text-success display-4">$ 0.0</p>
                </div>
                <div class="col-4">
                    <h3 class="font-weight-bold">Saldo movimientos</h3>
                    <input type="text" id="SaldoMovimientos" name="SaldoMovimientos" class="d-none form-control" readonly="">
                    <p id="SaldoMovimientosParrafo" class="font-weight-bold text-info display-4">$ 0.0</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mdlInteresPrestamos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Interes para prestamos en nomina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Interes %</label>
                        <input type="text" id="InteresPrestamos" name="InteresPrestamos" maxlength="3" class="form-control form-control-sm numbersOnly" autofocus="" autocomplete="off"> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAceptaInteresPrestamo"><span class="fa fa-check"></span> Aceptar</button> 
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Empleado = pnlTablero.find("#Empleado"),
            Prestamos, tblPrestamos = pnlTablero.find("#tblPrestamos"),
            PrestamosPagos, tblPrestamosPagos = pnlTablero.find("#tblPrestamosPagos"),
            NuevoPrestamo = pnlTablero.find("#NuevoPrestamo"),
            NuevoPrestamoAbono = pnlTablero.find("#NuevoPrestamoAbono"),
            SaldoFinal = pnlTablero.find("#SaldoFinal"), Semana = pnlTablero.find("#Semana"),
            btnReimprimirPagare = pnlTablero.find("#btnReimprimirPagare"),
            mdlInteresPrestamos = $("#mdlInteresPrestamos"),
            NuevoSaldoPrestamo = pnlTablero.find("#NuevoSaldoPrestamo"),
            PrestamoAcumulado = pnlTablero.find("#PrestamoAcumulado"),
            btnGuardarNP = pnlTablero.find("#btnGuardarNP");

    $(document).ready(function () {
        btnGuardarNP.click(function () {
            onGuardarNuevoPrestamo();
        });

        mdlInteresPrestamos.find("#btnAceptaInteresPrestamo").click(function () {
            console.log('ok');
            if (mdlInteresPrestamos.find("#InteresPrestamos").val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Modificando intereses...'
                });
                $.post('<?php print base_url('PrestamosEmpleados/ModificaInteresPrestamos'); ?>', {INTERES: mdlInteresPrestamos.find("#InteresPrestamos").val()}).done(function (a) {
                    onBeep(1);
                    swal('ATENCIÓN', 'SE HAN MODIFICADO LOS INTERESES', 'success').then((value) => {
                        mdlInteresPrestamos.find("#InteresPrestamos").val('');
                        mdlInteresPrestamos.find("#InteresPrestamos").focus().select();
                    });
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN INTERÉS', 'warning').then((value) => {
                    mdlInteresPrestamos.find("#InteresPrestamos").focus().select();
                });
            }
        });

        pnlTablero.find("#btnEmpleadosConsulta").click(function () {
            $.fancybox.open({
                src: '<?php print base_url('Empleados'); ?>',
                type: 'iframe',
                opts: {
                    iframe: {
                        // Iframe template
                        tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                        preload: true,
                        // Custom CSS styling for iframe wrapping element
                        // You can use this to set custom iframe dimensions
                        css: {
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });

        btnReimprimirPagare.click(function () {
            $("#mdlReimprimePagare").modal('show');
        });

        NuevoPrestamoAbono.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onGuardarNuevoPrestamo();
            }
        });

        NuevoPrestamo.on('keydown', function (e) {
            if (e.keyCode === 13) {
                getSaldoActual();
            }
        });

        Empleado[0].selectize.focus();

        Empleado.change(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Por favor espere...'
            });
            $.getJSON('<?php print base_url('PrestamosEmpleados/getUltimoSaldo'); ?>', {EMPLEADO: Empleado.val()}).done(function (a) {
                console.log(a);
                var nopagare = '<?php print substr(Date('Y'), 3) . "" . Date('md'); ?>';

                if (a.length > 0) {
//                    ULTIMO DIGITO DEL AÑO, MES, DIA,NUMERO DE EMPLEADO

                    pnlTablero.find("#PagareNo").val(nopagare + '' + Empleado.val());
                    PrestamoAcumulado.val(a[0].PRESTAMO);
                    pnlTablero.find("#Abono").val(a[0].ABONO);
                    pnlTablero.find("#Saldo").val((a[0].SALDO) ? a[0].SALDO : a[0].PRESTAMO);
                    NuevoPrestamo.focus().select();
                    Prestamos.ajax.reload(function () {
                        PrestamosPagos.ajax.reload();
                    });
                } else {
                    if (Empleado.val() === '') {
                        pnlTablero.find("input:not(#Semana)").val('');
                        Prestamos.ajax.reload(function () {
                            PrestamosPagos.ajax.reload();
                        });
                    } else {
                        /*NUEVO PRESTAMO / NUEVO EMPLEADO PIDIENDO PRESTADO*/
                        pnlTablero.find("#PagareNo").val(nopagare + '' + Empleado.val());
                        PrestamoAcumulado.val(0);
                        pnlTablero.find("#Abono").val(0);
                        pnlTablero.find("#Saldo").val(0);
                        NuevoPrestamo.focus().select();
                    }
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });

        getEmpleados();
        getPrestamos();
        getPrestamosPagos();
        getInformacionSemana();
    });

    function onGuardarNuevoPrestamo() {
        getSaldoActual();
        if (NuevoPrestamo.val() && NuevoPrestamoAbono.val()) {
            swal({
                title: 'SE HARÁ UN PRESTAMO AL EMPLEADO(A) "' + Empleado.val() + '" POR UN MONTO DE $ ' + ($.number(NuevoPrestamo.val(), 2, '.', ',')) + ', \n¿ESTÁS SEGURO(A)?',
                text: "Los abonos quedaran de $ " + ($.number(parseFloat(NuevoPrestamoAbono.val()), 2, '.', ',')) + "",
                icon: "warning",
                buttons: {
                    aceptar: {
                        text: "Aceptar",
                        value: "aceptar"
                    },
                    cancelar: {
                        text: "Cancelar",
                        value: "cancelar"
                    }
                }
            }).then((value) => {
                switch (value) {
                    case "aceptar":
                        HoldOn.open({
                            theme: 'sk-rect',
                            message: 'Generando pagare...'
                        });
                        $.post('<?php print base_url('PrestamosEmpleados/onAgregarPrestamosEmpleados'); ?>',
                                {
                                    EMPLEADO: Empleado.val(),
                                    PAGARE: pnlTablero.find("#PagareNo").val(),
                                    SEMANA: Semana.val(),
                                    PRESTAMO: NuevoPrestamo.val(),
                                    ABONO: NuevoPrestamoAbono.val(),
                                    SALDO: SaldoFinal.val(),
                                    PRESTAMOLETRA: NumeroALetras(NuevoPrestamo.val()),
                                    ULTIMOSALDO: NuevoSaldoPrestamo.val()
                                }).done(function (a) {
                            console.log(a);
                            pnlTablero.find("input:not(#Semana)").val('');
                            PrestamoAcumulado.val(0);
                            pnlTablero.find("#Abono").val(0);
                            pnlTablero.find("#Saldo").val(0);
                            Empleado[0].selectize.clear(true);
                            Prestamos.ajax.reload(function () {
                                PrestamosPagos.ajax.reload(function () {
                                    Empleado[0].selectize.focus();
                                    Empleado[0].selectize.open();
                                });
                            });
                            /*IMPRIMIR PAGARE*/
                            onImprimirReporteFancy(base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + a + '#pagemode=thumbs');
                        }).fail(function (x, y, z) {
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                            console.log(x.responseText);
                        }).always(function () {
                            HoldOn.close();
                        });
                        break;
                    case "cancelar":
                        swal.close();
                        break;
                }
            });

        }
    }

    function getSaldoActual() {
        if (NuevoPrestamo.val()) {
            var Saldo = parseFloat(pnlTablero.find("#Saldo").val());
            var PrestamoAcumuladox = parseFloat(PrestamoAcumulado.val());
            var Prestamo = parseFloat(NuevoPrestamo.val());
            var NuevoSaldoPrestamox = PrestamoAcumuladox + Prestamo;
            NuevoSaldoPrestamo.val(NuevoSaldoPrestamox);
            pnlTablero.find("#SaldoFinal").val(Saldo + Prestamo);
            pnlTablero.find("#TotalEnLetra p").text(NumeroALetras(Prestamo));
        } else {
            swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA CANTIDAD VALIDA', 'warning').then((value) => {
                NuevoPrestamo.focus().select();
            });
        }
    }

    function getInformacionSemana() {
        $.getJSON('<?php print base_url('PrestamosEmpleados/getInformacionSemana') ?>').done(function (a) {
            console.log(a);
            Semana.val(a[0].SEMANA);
        }).fail(function (x) {
            getError(x);
        }).always(function () {

        });
    }

    function getEmpleados() {
        HoldOn.open({
            theme: 'sk-rect'
        });
        $.getJSON('<?php print base_url('PrestamosEmpleados/getEmpleados'); ?>').done(function (a) {
            Empleado[0].selectize.clear(true);
            Empleado[0].selectize.clearOptions();
            a.forEach(function (v) {
                Empleado[0].selectize.addOption({text: v.EMPLEADO, value: v.CLAVE});
            });
        }).fail(function (x, y, z) {
            getError(x);
        }).always(function () {
            HoldOn.close();
        });
    }

    function getPrestamos() {
        if ($.fn.DataTable.isDataTable('#tblPrestamos')) {
            Prestamos.ajax.reload(function () {
                HoldOn.close();
            });
        } else {
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            Prestamos = tblPrestamos.DataTable({
                "dom": 'ritp',
                "ajax": {
                    "url": '<?php print base_url('PrestamosEmpleados/getPrestamos'); ?>',
                    "contentType": "application/json",
                    "dataSrc": "",
                    "data": function (d) {
                        d.EMPLEADO = (Empleado.val());
                    }
                },
                buttons: buttons,
                "columns": [
                    {"data": "ID"}/*0*/,
                    {"data": "EMPLEADO"}/*1*/,
                    {"data": "FECHA"}/*2*/,
                    {"data": "PAGARE"}/*4*/,
                    {"data": "SEM"}/*5*/,
                    {"data": "PRESTAMO"}/*6*/,
                    {"data": "ABONO"}/*7*/
                ],
                "columnDefs": coldefs,
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 99999999,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "400px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();//Get access to Datatable API 
//                    // Update footer
                    var prestamos = api.column(5).data().reduce(function (a, b) {
                        var ax = 0, bx = 0;
                        ax = $.isNumeric(a) ? parseFloat(a) : 0;
                        bx = $.isNumeric(b) ? parseFloat(b) : 0;
                        return  (ax + bx);
                    }, 0);
                    pnlTablero.find("#TotalPrestamos").val(prestamos);
                    pnlTablero.find("#TotalPrestamosParrafo").text('$' + $.number(parseFloat(prestamos), 2, '.', ','));
                },
                initComplete: function () {
                    HoldOn.close();
                }
            });
        }
    }

    function getPrestamosPagos() {
        if ($.fn.DataTable.isDataTable('#tblPrestamosPagos')) {
            PrestamosPagos.ajax.reload(function () {
                HoldOn.close();
            });
        } else {
            var coldefs = [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ];
            PrestamosPagos = tblPrestamosPagos.DataTable({
                "dom": 'ritp',
                "ajax": {
                    "url": '<?php print base_url('PrestamosEmpleados/getPrestamosPagos'); ?>',
                    "contentType": "application/json",
                    "dataSrc": "",
                    "data": function (d) {
                        d.EMPLEADO = (Empleado.val());
                    }
                },
                buttons: buttons,
                "columns": [
                    {"data": "ID"}/*0*/,
                    {"data": "EMPLEADO"}/*1*/,
                    {"data": "SEM"}/*2*/,
                    {"data": "FECHA"}/*4*/,
                    {"data": "ABONO"}/*5*/,
                    {"data": "INTERES"}/*6*/,
                    {"data": "ESTATUS"}/*7*/
                ],
                "columnDefs": coldefs,
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 99999999,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "400px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();//Get access to Datatable API 
//                    // Update footer 
                    var abonos = api.column(4).data().reduce(function (a, b) {
                        var ax = 0, bx = 0;
                        ax = $.isNumeric(a) ? parseFloat(a) : 0;
                        bx = $.isNumeric(b) ? parseFloat(b) : 0;
                        return  (ax + bx);
                    }, 0);
                    pnlTablero.find("#TotalAbonos").val(abonos);
                    pnlTablero.find("#TotalAbonosParrafo").text('$' + $.number(parseFloat(abonos), 2, '.', ','));
                    var saldo = parseFloat(pnlTablero.find("#TotalPrestamos").val()) - parseFloat(abonos);

                    pnlTablero.find("#SaldoMovimientosParrafo").text('$' + $.number(parseFloat(saldo), 2, '.', ','));
                },
                initComplete: function () {
                    HoldOn.close();
                }
            });
        }
    }

</script>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
</style> 
