<div class="card mx-2" id="pnlAvance3" style="background-color: #ffffff; border-radius: 10px 10px 10px 10px;">
    <div class="card-body">
        <div class="row"> 
            <div class="col-12">
                <div class="row">
                    <div class="col-7"> 
                        <h2 class="card-title font-weight-bold font-italic" style="color: #1565C0">CAPTURA DE FRACCIONES (PESPUNTE)</h2>   
                        <p style="font-size: 8px" class="font-weight-bold font-italic d-none">23, 1122, 1186, 1348, 1815, 1870, 1880, 1912, 1995, 2005, 2080, 2217, 2274, 2408, 2498, 2614, 2630, 2631, 2632, 2647, 2684, 2685, 2718, 2752, 2801, 2808, 2809, 2863, 2988, 3005, 3006, 3075, 3076</p>
                    </div>
                    <div class="col-4  text-center" style="color: #cc0033">
                        <h2 class="font-weight-bold font-italic semana_avance">-</h2>
                        <input type="text" id="Semana" name="Semana" class="form-control d-none">
                        <input type="text" id="Fecha" name="Fecha" class="form-control d-none">
                    </div>
                    <div class="col-1" align="right">
                        <buttton type="button" class="btn btn-danger" style="background-color: #607D8B;  border-color: #607D8B;" onclick="location.href = '<?php print base_url('Sesion/onSalir'); ?>'"><span class="fa fa-power-off"></span> SALIR</buttton>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <label style="font-size: 35px;" class="font-italic">NUMERO</label>
                <input type="text" id="NumeroEmpleado" name="NumeroEmpleado" class="form-control text-center" maxlength="8" autofocus="" style="height: 65px; font-size: 50px;padding-left: 2px; padding-right: 2px; color: #f00 !important">
            </div>
            <div class="col-10">
                <p style="color: #c1850c !important; font-size: 65px; margin-bottom: 0px;" class="nombre_empleado font-weight-bold font-italic text-center">-</p>
            </div>
            <div class="w-100 my-1"></div>
            <div class="col-7">
                <table id="tblFraccionesPagadas" class="table table-striped table-hover table-sm table-bordered  compact nowrap" style="width:100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Control</th>

                            <th scope="col">Estilo</th>
                            <th scope="col">Fracción</th>
                            <th scope="col">Pares</th>

                            <th scope="col">Precio</th>
                            <th scope="col">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                            <td>TOTAL DE LA SEMANA </td> 
                            <td colspan="2" style="font-size: 30px">$0.0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-5">
                        <label style="font-size: 35px;" class="font-italic">CONTROL</label>
                        <input type="text" id="Control" name="Control" class="form-control numbersOnly text-center" autofocus="" maxlength="10" style="height: 50px; font-size: 35px; color: #311B92 !important">
                    </div> 
                    <div class="col-4">
                        <label style="font-size: 35px;" class="font-italic">ESTILO</label>
                        <div class="w-100"></div>
                        <span style="font-size: 40px; color: #318c35;" class="font-italic font-weight-bold estilo_x_control">-</span>
                        <input type="text" id="Estilo" name="Estilo" class="form-control d-none" readonly="" style="height: 75px; font-size: 3px;">
                    </div>
                    <div class="col-2">
                        <label style="font-size: 35px;" class="font-italic">PARES</label>
                        <div class="w-100"></div>
                        <span style="font-size: 40px; color: #f71100;" class="font-italic font-weight-bold pares_x_control">0</span>
                        <input type="text" id="Pares" name="Pares" class="form-control d-none" readonly="" style="height: 75px; font-size: 30px;">
                    </div>
                    <div class="col-12">
                        <div class="row" id="fracciones_para_pago"> 
                            <div class="col-12 text-center"> 
                                <h5 class="font-weight-bold font-italic" style="color:#1565C0">FRACCIONES</h5>
                                <hr>
                            </div>
                            <?php
                            foreach ($this->db->query("SELECT F.Clave,F.Descripcion,F.Departamento FROM fracciones AS F WHERE F.Clave IN(308,309,322,324,405,315) ORDER BY ABS(F.Clave) ASC")->result() as $k => $v) {
                                $check = ' <div class="col-6" style="border: 2px solid #b9b9b9; border-radius: 5px;">';
                                $check .= '<div class="custom-control custom-checkbox">';
                                $check .= '<input type="checkbox" class="custom-control-input" id="Fraccion' . $v->Clave . '"  description="' . $v->Descripcion . '" fraccion="' . $v->Clave . '">';
                                $check .= '<label class="custom-control-label" for="Fraccion' . $v->Clave . '">' . $v->Clave . ' ' . $v->Descripcion . '</label>';
                                $check .= '</div>';
                                $check .= '</div>';
                                print $check;
                            }
                            ?> 
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h4>JUEVES</h4> 
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_jueves font-weight-bold">$0</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>VIERNES</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50"  class="total_viernes font-weight-bold">$0</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>SABADO</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_sabado font-weight-bold">$0</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>DOMINGO</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_domingo font-weight-bold">$0</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h4>LUNES</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_lunes font-weight-bold">$0</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>MARTES</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_martes font-weight-bold">$0</h4>
                                    </div>
                                    <div class="col-6">
                                        <h4>MIERCOLES</h4>
                                    </div>
                                    <div class="col-6"> 
                                        <h4 style="color: #4CAF50" class="total_miercoles font-weight-bold">$0</h4>
                                    </div> 
                                </div>
                            </div> 
                            <div class="w-100">
                                <hr>
                            </div>
                            <div class="col-5">
                                <h3>TOTAL</h3>
                            </div>
                            <div class="col-7"> 
                                <h3 style="color: #4CAF50; font-weight:bold; font-style:italic;" class="total_final">$0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var pnlAvance3 = $("#pnlAvance3"), Fraccion308 = pnlAvance3.find("#Fraccion308"),
            tblFraccionesPagadas = pnlAvance3.find("#tblFraccionesPagadas"),
            NumeroEmpleado = pnlAvance3.find("#NumeroEmpleado"),
            Control = pnlAvance3.find("#Control"),
            Estilo = pnlAvance3.find("#Estilo"),
            Pares = pnlAvance3.find("#Pares"),
            Fecha = pnlAvance3.find("#Fecha"),
            Semana = pnlAvance3.find("#Semana");

    $(document).ready(function () {

        onDisable(Control);
        Control.on('keydown', function (e) {
            if (Control.val()) {
                if (e.keyCode === 13 && Control.val() && Control.val().length > 5) {
                    onOpenOverlay('');
                    $.getJSON('<?php print base_url('Avance3/getInformacionXControl'); ?>', {
                        CONTROL: Control.val()
                    }).done(function (a) {
                        if (a.length > 0) {
                            var r = a[0];
                            Estilo.val(r.ESTILO);
                            Pares.val(r.PARES);
                            pnlAvance3.find(".estilo_x_control").text(r.ESTILO);
                            pnlAvance3.find(".pares_x_control").text(r.PARES);

                            if (pnlAvance3.find(".custom-control-label-checked").length > 0) {
                                var fracciones = [];
                                $.each(pnlAvance3.find(".custom-control-label-checked"), function (k, v) {
                                    //                                console.log(k, $(v).parent().find(".custom-control-input").attr('fraccion'));
                                    fracciones.push({
                                        NUMERO_FRACCION: parseInt($(v).parent().find(".custom-control-input").attr('fraccion'))
                                    });

                                });
                                console.log(fracciones);
                                $.post('<?php print base_url('Avance3/onPagarFraccionesPespunte') ?>', {
                                    FRACCIONES: JSON.stringify(fracciones),
                                    NUMERO_EMPLEADO: NumeroEmpleado.val(),
                                    CONTROL: Control.val(),
                                    ESTILO: Estilo.val(),
                                    PARES: Pares.val(),
                                    SEMANA: Semana.val(),
                                    FECHA: Fecha.val()
                                }).done(function (a) {
                                    console.log(a);
                                    Control.focus().select();
                                    FraccionesPagadas.ajax.reload(function () {
                                        getPagosXEmpleadoXSemana();
                                    });
                                    //                                    onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
                                    onNotifyOldPCF('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success', {
                                        from: "bottom",
                                        align: "center"
                                    }, function () {
                                        Control.focus().select();
                                    });
                                }).fail(function (x) {
                                    getError(x);
                                });
                            } else {
                                pnlAvance3.find("#fracciones_para_pago").removeClass("border-check-no-selected");
                                onCampoInvalido(pnlAvance3, "POR FAVOR SELECCIONE LAS FRACCIONES QUE VA A COBRAR", function () {
                                    pnlAvance3.find("#fracciones_para_pago").addClass("border-check-no-selected");
                                });
                            }
                        }
                    }).fail(function (x) {
                        getError(x);
                    }).always(function () {
                        onCloseOverlay();
                    });

                } else if (e.keyCode === 8 && Control.val() === '' && e.keyCode === 46) {
                    Estilo.val('');
                    Pares.val(0);
                } else if (e.keyCode === 13 && Control.val().length < 6) {
                    Control.focus().select();
                }
            } else {
                Control.focus().select();
            }
        });

        NumeroEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13 && NumeroEmpleado.val()) {
                onOpenOverlay('');
                $.getJSON('<?php print base_url('Avance3/getInformacionEmpleado'); ?>', {
                    EMPLEADO: NumeroEmpleado.val()
                }).done(function (a) {
                    console.log(a, a.length);
                    if (a.length > 0) {
                        pnlAvance3.find(".nombre_empleado").text(a[0].NOMBRE_COMPLETO);
                        onEnable(Control);
                        Control.focus().select();
                        FraccionesPagadas.ajax.reload();
                    } else {
                        onDisable(Control);
                        pnlAvance3.find(".nombre_empleado").text('-');
                        onCampoInvalido(pnlAvance3, "EMPLEADO INEXISTENTE O NO EXISTE, INTENTE CON OTRO.", function () {
                            NumeroEmpleado.focus().select();
                        });
                    }
                }).fail(function (x) {
                    getError(x);
                }).always(function () {
                    onCloseOverlay();
                });
                getPagosXEmpleadoXSemana();
            } else if (e.keyCode === 8 && NumeroEmpleado.val() === '' ||
                    e.keyCode === 13 && NumeroEmpleado.val() === '' ||
                    e.keyCode === 46 && NumeroEmpleado.val() === '') {
                onDisable(Control);
                pnlAvance3.find(".nombre_empleado").text('-');
            } else if (NumeroEmpleado.val() === '') {
                onDisable(Control);
                pnlAvance3.find(".nombre_empleado").text('-');
            }
        });

        pnlAvance3.find("input.custom-control-input").change(function () {
            console.log($(this).parent().find(".custom-control-input").attr('fraccion'));
            if ($(this)[0].checked) {
                $(this).parent().find("label.custom-control-label").addClass("custom-control-label-checked");
                Control.focus().select();
            } else {
                $(this).parent().find("label.custom-control-label").removeClass("custom-control-label-checked");
            }
        });

        var xoptions = {
            "dom": 'rtp',
            "ajax": {
                "url": '<?php print base_url('Avance3/FraccionesPespunteXEmpleadoControl'); ?>',
                "dataSrc": "",
                "data": function (d) {
                    d.SEMANA = Semana.val() ? Semana.val() : '';
                    d.EMPLEADO = NumeroEmpleado.val() ? NumeroEmpleado.val() : '';
                    d.CONTROL = Control.val() ? Control.val() : '';
                }
            },
            buttons: buttons,
            "columns": [
                {"data": "ID"}/*0*/, {"data": "FECHA"}/*1*/,
                {"data": "CONTROL"}/*2*/, {"data": "ESTILO"},
                {"data": "FRAC"}, {"data": "PARES"},
                {"data": "PRECIO"}, {"data": "SUBTOTAL_SPAN"}, {"data": "SUBTOTAL"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [8],
                    "visible": false,
                    "searchable": false
                }],
            language: lang,
            select: true,
            "autoWidth": true, "colReorder": true,
            "displayLength": 50,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "275px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                $.each(api.rows().data(), function (k, v) {
                    prs += parseInt(v.PARES);
                    r += parseFloat(v.SUBTOTAL);
                    console.log(v);
                });
                $(api.column(5).footer()).text('TOTAL DE LA SEMANA ' + Semana.val());
                $(api.column(6).footer()).text('$ ' + $.number(r, 2, '.', ','));
            }
        };
        FraccionesPagadas = tblFraccionesPagadas.DataTable(xoptions);
        $.getJSON('<?php print base_url('Avance3/getSemanaByFecha'); ?>').done(function (data) {
            Semana.val((data.length > 0) ? data[0].Sem : '');
            pnlAvance3.find("h2.semana_avance").text('SEMANA ' + ((data.length > 0) ? data[0].Sem : ''));
            Fecha.val((data.length > 0) ? data[0].Fecha : '');
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
        }).always(function () {

        });
    });

    function getPagosXEmpleadoXSemana() {
        $.getJSON('<?php print base_url('Avance3/getPagosXEmpleadoXSemana'); ?>', {
            EMPLEADO: NumeroEmpleado.val(),
            SEMANA: Semana.val()
        }).done(function (a) {
            console.log("* * * GANADO X DIA * * *");
            console.log(a, a.length);
            if (a.length > 0) {
                var pagos = a[0];
                pnlAvance3.find(".total_jueves").text('$ ' + $.number(pagos.JUEVES, 2, '.', ','));
                pnlAvance3.find(".total_viernes").text('$ ' + $.number(pagos.VIERNES, 2, '.', ','));
                pnlAvance3.find(".total_sabado").text('$ ' + $.number(pagos.SABADO, 2, '.', ','));
                pnlAvance3.find(".total_domingo").text('$ ' + $.number(pagos.DOMINGO, 2, '.', ','));
                pnlAvance3.find(".total_lunes").text('$ ' + $.number(pagos.LUNES, 2, '.', ','));
                pnlAvance3.find(".total_martes").text('$ ' + $.number(pagos.MARTES, 2, '.', ','));
                pnlAvance3.find(".total_miercoles").text('$ ' + $.number(pagos.MIERCOLES, 2, '.', ','));
                var total = 0;
                $.each(pagos, function (k, v) {
                    console.log(k, v);
                    total += parseFloat(v);
                });
                pnlAvance3.find(".total_final").text('$ ' + $.number(total, 2, '.', ','));
            }
        }).fail(function (x) {
            getError(x);
        }).always(function () {
            onCloseOverlay();
        });
    }
</script>
<style>
    label.custom-control-label{
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome, Edge, Opera and Firefox */
        font-size: 20px
    }
    label.custom-control-label{
        color: #b9b9b9 ;
    }
    label.custom-control-label:hover{
        cursor: pointer;
    }
    .custom-control-label-checked{
        background-color: #4CAF50;
        color: #ffffff !important;
        font-style: italic;
        padding-right: 12px;
        padding-left: 12px;
        border-radius: 10px;
    }
    table thead th, table tfoot td:nth-child(6) , table tfoot td:nth-child(5){
        background-color: #000;
        color: #ffffff;
        font-weight: bold;
        font-size: 20px;
        font-style: italic;
    }
    table tbody td{
        text-align: right;
        font-style: italic;
        font-size: 16px;
        font-weight: bold;
    }

    table tfoot td:nth-child(6),table tfoot td:nth-child(5){
        text-align: right;
        font-style: italic;
    }
    .custom-control-label::before{
        background-color: transparent;
    }
    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before{
        background-color: transparent;
    }
    .border-check-no-selected{
        border: 4px solid transparent; 
        border-radius: 10px;
        animation: blink 0.25s;
        animation-iteration-count: 10;
    }
    .card-body {
        padding-top: 10px;
        padding-left: 10px;
        padding-right: 10px;

    }

    .card-body .custom-control-label::after{
        background-color: transparent;
    }
    .precio-pagado{
        color: #318c35 !important;
    }
    .alert-success{
        background-color: #4CAF50;
        font-weight: bold;
    }
    @keyframes blink { 50% { border-color:#cc0000 ; }  }

</style>