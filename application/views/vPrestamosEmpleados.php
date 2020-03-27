<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 float-left font-weight-bold">
                <legend class="float-left"><span class="fa fa-coins"></span> PRÉSTAMOS A EMPLEADOS </legend>
            </div>
            <div class="col-sm-6 float-right" align="right">
                <button type="button" class="btn btn-danger notEnter" id="btnInteresPagares"  data-toggle="modal" data-target="#mdlInteresPrestamos"><span class="fa fa-percent"></span> INTERÉS <br></button>

                <button type="button" class="btn btn-primary notEnter" id="btnEmpleadosConsulta" data-toggle="tooltip" data-placement="bottom" title="Empleados"><span class="fa fa-user-circle"></span> EMPLEADOS <br></button>

                <button type="button" class="btn btn-info notEnter" id="btnReimprimirPagare" data-toggle="tooltip" data-placement="bottom" title="Reimprimir"><span class="fa fa-print"></span> REIMPRESIÓN DE PAGARES<br></button>
            </div>
        </div>
        <div class="card-block ">
            <div class="row">  
                <div class="col-10">
                    <label>No.empleado</label>
                    <div class="row">
                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <input type="text" id="xEmpleado" name="xEmpleado" class="form-control form-control-sm numbersOnly">
                        </div>
                        <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                            <select id="Empleado" name="Empleado" class="form-control form-control-sm NotSelectize">
                                <option></option>
                                <?php
                                foreach ($this->db->select("E.Numero AS CLAVE, "
                                                . "CONCAT(E.Numero,' ', E.PrimerNombre,' ',E.SegundoNombre,' ',E.Paterno,' ', E.Materno) AS EMPLEADO")
                                        ->from("empleados AS E")->where('E.AltaBaja', 1)->get()->result() as $k => $v) {
                                    print "<option value=\"{$v->CLAVE}\">{$v->EMPLEADO}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <!--ULTIMO DIGITO DEL AÑO, MES, DIA,NUMERO DE EMPLEADO-->
                    <label>Pagare No.</label>
                    <input type="text" id="PagareNo" name="PagareNo" class="form-control form-control-sm" autocomplete="off" readonly="">
                </div>
                <div class="w-100"></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 mt-4"> 
                    <h6 class="text-danger font-weight-bold">ÚLTIMO SALDO</h6> 
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <label>Pres.Acum</label>
                    <input type="text" id="PrestamoAcumulado" name="PrestamoAcumulado" readonly="" class="form-control form-control-sm" autocomplete="off">
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <label>Abono</label>
                    <input type="text" id="Abono" name="Abono" class="form-control form-control-sm" readonly=""  autocomplete="off">
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <label>Saldo</label>
                    <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm" readonly=""  autocomplete="off">
                </div>
                <div class="col-2 col-sm-2 col-md-1 col-lg-1 col-xl-1">
                    <label>Semana</label>
                    <input type="text" id="Semana" name="Semana" class="form-control form-control-sm" data-toggle="tooltip" data-placement="bottom" title="SEMANA DE CARACTER INFORMATIVO" readonly="" autocomplete="off">
                </div>
                <div class="col-3"> 
                    <h6 class="text-danger font-weight-bold"><strong> % </strong> INTERÉS SEMANAL SOBRE SALDO INSOLUTOS.</h6> 
                    <input type="text" id="Interes" name="Interes" value="0" class="form-control form-control-sm font-weight-bold" autocomplete="off" placeholder="0">
                </div>
                <div class="w-100 mt-2"></div> 
                <div class="my-1 w-100">
                    <hr>
                </div> 
                <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1"> 
                    <h6 class="text-danger font-weight-bold">PRESTAMO NUEVO</h6>  
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="text" id="NuevoPrestamo" name="NuevoPrestamo" placeholder="Total a prestar" class="form-control form-control-sm numbersOnly" autocomplete="off" maxlength="8" style="font-size: 18px !important;">
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="text" id="NuevoPrestamoAbono" name="NuevoPrestamoAbono" placeholder="Abonos de..." class="form-control form-control-sm numbersOnly" autocomplete="off" maxlength="8" style="font-size: 18px !important;">
                    <p class="font-weight-bold font-italic" style="color:#9C27B0;">
                        NOTA: LOS ABONOS NO DEBEN DE LLEVAR CENTAVOS.</p>
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <button id="btnGuardarNP" name="btnGuardarNP" class="btn btn-info btn-sm font-weight-bold" style="background-color: #43A047; border-color: #43A047;">
                        <span class="fa fa-check"></span> ACEPTAR
                    </button> 
                </div>
                <div id="TotalEnLetra" class="col-5 text-center">
                    <h4 class="font-weight-bold text-warning"></h4>
                </div>  
                <div class="w-100 my-1"></div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 mt-1"> 
                    <h6 class="text-danger font-weight-bold">SALDO ACTUAL</h6> 
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="text" id="NuevoSaldoPrestamo" name="NuevoSaldoPrestamo" class="form-control form-control-sm" autocomplete="off" readonly="">
                </div> 
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="text" id="SaldoFinal" name="SaldoFinal" placeholder="Saldo final..." class="form-control form-control-sm" autocomplete="off" readonly="">
                </div>
                <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3">  
                    <h3 class="text-info font-weight-bold">1 = SIN APLICAR</h3> 
                </div>
                <div class="col-2 col-sm-2 col-md-3 col-lg-3 col-xl-3">   
                    <h3 class="text-info font-weight-bold">2 = APLICADO</h3> 
                </div>
                <div class="my-1 w-100">
                    <hr>
                </div>  

                <!--PRESTAMOS-->
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h5 class="font-weight-bold">PRESTAMOS DE ESTE EMPLEADO</h5>
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
                    <h5 class="font-weight-bold">PAGOS DE LOS PRESTAMOS</h5>
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
                <div class="w-100">
                    <hr>
                </div>
                <div class="col-4">
                    <h3 class="font-weight-bold">TOTAL PRESTAMOS</h3>
                    <input type="text" id="TotalPrestamos" name="TotalPrestamos" class="form-control d-none" readonly="">
                    <p id="TotalPrestamosParrafo" class="font-weight-bold text-danger display-4">$ 0.0</p>
                </div>
                <div class="col-4">
                    <h3 class="font-weight-bold">TOTAL ABONOS</h3>
                    <input type="text" id="TotalAbonos" name="TotalAbonos" class="form-control d-none" readonly="">
                    <p id="TotalAbonosParrafo" class="font-weight-bold display-4" style="    color: #4CAF50 !important">$ 0.0</p>
                </div>
                <div class="col-4">
                    <h3 class="font-weight-bold">SALDO MOVIMIENTOS</h3>
                    <input type="text" id="SaldoMovimientos" name="SaldoMovimientos" class="d-none form-control" readonly="">
                    <p id="SaldoMovimientosParrafo" class="font-weight-bold text-info display-4"  style="color: #673AB7 !important">$ 0.0</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="mdlInteresPrestamos">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="fa fa-percent"></span> Interes para prestamos en nomina</h5>
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
                <button type="button" class="btn btn-info" id="btnAceptaInteresPrestamo"><span class="fa fa-check"></span> Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), xEmpleado = pnlTablero.find("#xEmpleado"),
            Empleado = pnlTablero.find("#Empleado"),
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
        handleEnterDiv(pnlTablero);

        Empleado.selectize({
            hideSelected: false,
            openOnFocus: false
        });

        mdlInteresPrestamos.on('hidden.bs.modal', function () {
            xEmpleado.focus().select();
        });

        pnlTablero.find('input').addClass('font-weight-bold');
        btnGuardarNP.click(function () {
            onGuardarNuevoPrestamo();
        });

        xEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13) {
                if (xEmpleado.val()) {
                    Empleado[0].selectize.setValue(xEmpleado.val());
                    if (Empleado.val()) {
                        Empleado[0].selectize.disable();
                    } else {
                        Empleado[0].selectize.clear(true);
                        Empleado[0].selectize.disable();
                        iMsg('NUMERO DE EMPLEADO INVÁLIDO, INTENTE CON OTRO', 'w', function () {
                            xEmpleado.focus().select();
                            Empleado[0].selectize.enable();
                            PrestamoAcumulado.val('');
                            pnlTablero.find("#Abono").val('');
                            pnlTablero.find("#Saldo").val('');
                        });
                    }
                } else {
                    Empleado[0].selectize.clear(true);
                    Empleado[0].selectize.enable();
                }
                Prestamos.ajax.reload(function () {
                    PrestamosPagos.ajax.reload();
                });
            } else {
                Empleado[0].selectize.clear(true);
                Empleado[0].selectize.enable();
                Prestamos.ajax.reload(function () {
                    PrestamosPagos.ajax.reload();
                });
            }
            if (e.keyCode === 8 && xEmpleado.val() === '') {
                Empleado[0].selectize.enable();
                PrestamoAcumulado.val('');
                pnlTablero.find("#Abono").val('');
                pnlTablero.find("#Saldo").val('');
            }
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

        xEmpleado.focus();

        Empleado.change(function () {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Por favor espere...'
            });
            xEmpleado.val(Empleado.val());
            $.getJSON('<?php print base_url('PrestamosEmpleados/getUltimoSaldo'); ?>', {EMPLEADO: Empleado.val()}).done(function (a) {
//                console.log(a);
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
                        Prestamos.ajax.reload(function () {
                            PrestamosPagos.ajax.reload();
                        });
                    }
                }
            }).fail(function (x) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        });
//        
//        getEmpleados();
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
                    cancelar: {
                        text: "CANCELAR",
                        value: "cancelar"
                    },
                    aceptar: {
                        text: "ACEPTAR",
                        value: "aceptar"
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
                            onImprimirReporteFancyAFC(a, function (a, b) {
                                xEmpleado.focus().select();
                            });
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
            btnGuardarNP.attr('disabled', true);
            NuevoPrestamoAbono.attr('disabled', true);
            swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA CANTIDAD VALIDA', 'warning').then((value) => {
                NuevoPrestamo.focus().select();
                btnGuardarNP.attr('disabled', false);
                NuevoPrestamoAbono.attr('disabled', false);
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
                        d.EMPLEADO = (Empleado.val() ? Empleado.val() : '');
                    }
                },
                buttons: buttons,
                "columns": [
                    {"data": "ID"}/*0*/,
                    {"data": "EMPLEADO"}/*1*/,
                    {"data": "FECHA"}/*2*/,
                    {"data": "PAGARE"}/*4*/,
                    {"data": "SEM"}/*5*/,
                    {"data": "PRESTAMO_TEXT"}/*6*/,
                    {"data": "ABONO_TEXT"}/*7*/
                ],
                "columnDefs": coldefs,
                language: lang,
                select: true,
                "autoWidth": true,
                "colReorder": true,
                "displayLength": 50,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "200px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();//Get access to Datatable API 
//                    // Update footer
                    var prestamos = 0;
                    $.each(data, function (k, v) {
                        prestamos += parseFloat(v.PRESTAMO);
                    });
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
                        d.EMPLEADO = (Empleado.val() ? Empleado.val() : '');
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
                "displayLength": 50,
                "bLengthChange": false,
                "deferRender": true,
                "scrollCollapse": false,
                "bSort": true,
                "scrollY": "200px",
                "scrollX": true,
                "aaSorting": [
                    [0, 'desc']
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();//Get access to Datatable API 
//                    // Update footer
                    var abonos = 0;
                    $.each(data, function (k, v) {
                        abonos += parseFloat(v.ABONO);
                    });
                    pnlTablero.find("#TotalAbonos").val(abonos);
                    pnlTablero.find("#TotalAbonosParrafo").text('$' + $.number(parseFloat(abonos), 2, '.', ','));
                    var saldo = parseFloat(pnlTablero.find("#TotalPrestamos").val()) - parseFloat(abonos);
                    if (saldo < 0) {
                        saldo = 0;
                    }
                    pnlTablero.find("#SaldoMovimientosParrafo").text('$' + $.number(parseFloat(saldo), 2, '.', ','));
                },
                initComplete: function () {
                    HoldOn.close();
                    pnlTablero.find("input[type='search']").addClass("notEnter");
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
    button.swal-button--cancelar{
        background-color: #424242 !important;
    } 
    button.swal-button--aceptar{
        background-color: #43A047 !important;
    }
    #tblPrestamosPagos tbody td, #tblPrestamos tbody td{
        font-weight: bold !important;
        font-size: 13px !important;
    }
    .text-danger{
        color: #D32F2F !important; 
    }
    .selectize-input{
        font-weight: bold !important;
        font-size: 14px;
    }
</style>
