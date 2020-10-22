<div class="card m-2 animated fadeIn" id="pnlTablero">
    <div class="card-body" style="padding-top: 3px; padding-bottom: 3px;">
        <div class="row">
            <div class="col-6">
                <legend class="font-weight-bold" style="margin-bottom: 0px;">AVANCE POR EMPLEADO Y PAGO DE NÓMINA</legend>
            </div>
            <div class="col-6" align="right">
                <a class="btn btn-sm btn-danger mt-1" href="<?php print base_url('Sesion/onSalir'); ?>"><i class="fa fa-sign-out-alt"></i> Salir</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Empleado</label>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-2 col-xl-2  text-center">
                <input type="text" id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control shadow-lg numeric" maxlength="8" style="height: 50px; font-weight: bold; font-size: 45px; color: #673AB7 !important" autofocus="" data-toggle="tooltip" data-placement="bottom" title="Ingrese un empleado del depto de corte">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-10 col-xl-10 text-center">
                <h1 style="color: #c1850c !important;" class="nombre_empleado font-italic">-</h1>
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control d-none" placeholder="-" disabled="" style="height: 50px; font-weight: bold; font-size: 25px; text-align: center;">
            </div>
            <div class="w-100 my-1"></div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <div class="row justify-content-center" align="center">
                    <span onclick="onActualizarAvances();" class="fa fa-retweet fa-lg text-info text-shadow" style="cursor: pointer;" class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Actualizar"></span>
                    <h6> FRACCIONES DE ESTE EMPLEADO</h6>

                </div>
                <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
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
                            <td></td>

                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row" align="center">
                    <div class="col-2">
                        <label>Año</label>
                        <input type="text" id="AnoFiltro" name="AnoFiltro" maxlength="4" class="form-control form-control-sm numbersOnly selectNotEnter noBorders">
                    </div> 
                    <div class="col-2">
                        <label>Semana</label>
                        <input type="text" id="SemanaFiltro" name="SemanaFiltro" maxlength="2" class="form-control form-control-sm  numbersOnly selectNotEnter noBorders">
                    </div> 
                    <div class="col-2">
                        <label>Fraccion</label>
                        <input type="text" id="FraccionFiltro" name="FraccionFiltro" maxlength="4" class="form-control numbersOnly form-control-sm selectNotEnter noBorders">
                    </div>
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->
            <!--INICIO BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div id="ManoDeObra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row" style="border-radius: 5px;">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h5>MANO DE OBRA</h5>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk99" description="CORTE FORRO" fraccion='99'>
                                <label class="custom-control-label" for="chk99" >99 Corte forro</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk100" description="CORTE PIEL" fraccion='100'>
                                <label class="custom-control-label" for="chk100">100 Corte piel</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk96" description="CORTE MUESTRAS" fraccion='96'>
                                <label class="custom-control-label" for="chk96">96 Corte muestras</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <?php
                        $F = Date('d/m/Y');
                        $YYYY = Date('Y');
                        $SP = $this->db->select('SP.Sem AS Semana, SP.FechaIni AS FEINI, SP.FechaFin AS FEFI', false)
                                        ->from('semanasnomina AS SP')
                                        ->where("STR_TO_DATE('{$F}', \"%d/%m/%Y\") "
                                                . "BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") "
                                                . "AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\") AND SP.Ano = {$YYYY}")
                                        ->get()->result();
                        ?>
                        <label>Semana</label>
                        <br>
                        <span class="font-weight-bold font-italic" style="color: #f71100; font-size: 20px;"><?php print $SP[0]->Semana; ?></span>
                        <input type="text" id="Semana" name="Semana"  readonly=""  class="form-control d-none form-control-sm numeric" maxlength="2">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 text-center">
                        <label>Fecha</label>
                        <br>
                        <span class="font-weight-bold font-italic fecha_actual" style="color: #f71100; font-size: 20px;">
                        </span>
                        <input type="text" id="Fecha" name="Fecha" readonly="" class="form-control form-control-sm date notEnter d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 text-center">
                        <label>Departamento</label>
                        <br>
                        <span class="font-weight-bold font-italic departameto_actual_emp" style="color: #f71100; font-size: 20px;">
                        </span>
                        <input type="text" id="Departamento" readonly="" name="Departamento" class="form-control form-control-sm numeric d-none" maxlength="3">
                        <input type="text" id="DepartamentoDes" name="DepartamentoDes" class="form-control d-none" maxlength="3">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control"  style="color: #f71100 !important; height: 50px; font-weight: bold; font-size: 45px;" class="form-control form-control-sm numeric  shadow-lg" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Estilo</label>
                        <h1 style="color: #1565C0 !important" class="estilo_control">-</h1>
                        <input type="text" id="Estilo" name="Estilo" readonly="" class="form-control form-control-sm d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <h1 style="color: #5a8c0b !important"  class="pares_control">-</h1>
                        <input type="text" id="Pares" name="Pares" readonly=""  class="form-control form-control-sm numeric d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <h1 style="color: #c1850c !important;"  class="avance_control">-</h1>
                        <input type="text" id="Avance" name="Avance"  readonly=""  class="form-control form-control-sm numeric d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mx-auto">
                        <button type="button" class="btn btn-info btn-sm mt-4 d-none" disabled="" id="btnAceptar" name="btnAceptar" data-toggle="tooltip" data-placement="top" title="Aceptar"><span class="fa fa-check"></span> Acepta</button>
                    </div>

                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label>MANODEOBRA</label>
                        <input type="text" id="ManoDeOB" name="ManoDeOB" class="form-control numeric" readonly="">
                        <label>ANIO</label>
                        <input type="text" id="Anio" name="Anio" class="form-control numeric" readonly="">
                        <label>GENAVA</label>
                        <input type="text" id="GeneraAvance" name="GeneraAvance" class="form-control" readonly="">
                        <label>FRAC</label>
                        <input type="text" id="Fraccion" name="Fraccion" class="form-control" readonly="">
                        <label>FRACDES</label>
                        <input type="text" id="FraccionDes" name="FraccionDes" class="form-control" readonly="">
                    </div>

                    <div class="col-12 my-1">
                        <hr>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 px-1 mr-3 text-center  border border-dark shadow-lg" style="border-radius: 10px; max-height: 100px !important;">
                        <span class="font-weight-bold" style="color : #3F51B5 !important;">ESTATUS ACTUAL DEL AVANCE </span>  
                        <div class="w-100"></div>
                        <span class="font-weight-bold estatus_de_avance" style="color : #ef1000 !important; font-size: 22px !important;">-</span>
                        <input type="text" id="EstatusAvance" name="EstatusAvance" readonly="" class="form-control form-control-sm d-none" style="text-align: center">
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center border border-dark shadow-lg" style="border-radius: 10px;">
                        <p class="text-info font-weight-bold" style="color : #3F51B5 !important; font-size: 22px;">PAGO DE NÓMINA</p>
                        <div id="DiasPagoDeNomina" class="row"></div>
                    </div> 
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 text-center">
                <span class="text-danger font-weight-bold font-italic">9 9 9 9 9 9</span>
            </div>
        </div>
    </div>
</div>
<script>
    var dias = ["JUEVES", "VIERNES", "SABADO", "DOMINGO", "LUNES", "MARTES", "MIERCOLES"],
            ndias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO", "DOMINGO"],
            pnlTablero = $("#pnlTablero").find("div.card-body"),
            DiasPagoDeNomina = pnlTablero.find("#DiasPagoDeNomina"), Avance,
            tblAvance = pnlTablero.find("#tblAvance"),
            NumeroDeEmpleado = pnlTablero.find("#NumeroDeEmpleado"),
            NombreEmpleado = pnlTablero.find("#NombreEmpleado"),
            Semana = pnlTablero.find("#Semana"),
            Fecha = pnlTablero.find("#Fecha"),
            Control = pnlTablero.find("#Control"),
            Departamento = pnlTablero.find("#Departamento"),
            DepartamentoDes = pnlTablero.find("#DepartamentoDes"),
            Estilo = pnlTablero.find("#Estilo"),
            Pares = pnlTablero.find("#Pares"),
            SigAvance = pnlTablero.find("#Avance"),
            EstatusAvance = pnlTablero.find("#EstatusAvance"),
            estatus_de_avance = pnlTablero.find("span.estatus_de_avance"),
            ManoDeOB = pnlTablero.find("#ManoDeOB"),
            Fraccion = pnlTablero.find("#Fraccion"),
            FraccionDes = pnlTablero.find("#FraccionDes"),
            Anio = pnlTablero.find("#Anio"),
            btnAceptar = pnlTablero.find("#btnAceptar"),
            GeneraAvance = pnlTablero.find("#GeneraAvance");

    var AVANO = {
        NUMERO_EMPLEADO: 0,
        CONTROL: '',
        ESTILO: '',
        FRACCION: '',
        NUMERO_FRACCION: 0,
        PRECIO_FRACCION: 0,
        PARES: 0,
        FECHA: '',
        SEMANA: 0,
        DEPARTAMENTO: 0,
        ANIO: 0
    };

    // IIFE - Immediately Invoked Function Expression
    $(document).ready(function () {
        //handleEnter();

        Semana.val('<?php print $SP[0]->Semana; ?>');
        Fecha.val('<?php print $F; ?>');
        Fecha.parent().find("span.fecha_actual").text('<?php print $F; ?>');
        btnAceptar.click(function () {
            if (NumeroDeEmpleado.val()) {
                if (pnlTablero.find("input[type='checkbox']:checked").length > 0) {
                    onAgregarAvance(true);
                } else {
                    onAgregarAvanceSinFraccion();
                }
            } else {
                iMsg('DEBE DE SELECCIONAR UN EMPLEADO', 'w', function () {
                    NumeroDeEmpleado.focus().select();
                });
            }
        });

        Anio.val(new Date().getFullYear());

        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                pnlTablero.find("#SemanaFiltro").val('');
                pnlTablero.find("#FraccionFiltro").val('');
                if (pnlTablero.find("input[type='checkbox']:checked").length > 0) {
                    console.log('avance 1');
                    onAgregarAvance(true);
                } else {
                    console.log('avance 2');
                    onAgregarAvanceSinFraccion();
                }
            } else if (Control.val() === '') {
                SigAvance.val('');
                pnlTablero.find(".estilo_control").text('-');
                pnlTablero.find(".pares_control").text('-');
                pnlTablero.find(".avance_control").text('-');
            }
        });

        pnlTablero.find("input[type='checkbox']").change(function () {
            if (NumeroDeEmpleado.val()) {
                Control.focus().select();
            } else {
                NumeroDeEmpleado.focus().select();
            }
        });

        pnlTablero.find("#AnoFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Avance.ajax.reload(function () {
                    pnlTablero.find("#AnoFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });

        pnlTablero.find("#SemanaFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Avance.ajax.reload(function () {
                    pnlTablero.find("#SemanaFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });

        pnlTablero.find("#FraccionFiltro").on('keydown', function (e) {
            if (e.keyCode === 13) {
                onOpenOverlay('Buscando...');
                Avance.ajax.reload(function () {
                    pnlTablero.find("#FraccionFiltro").focus().select();
                    onCloseOverlay();
                });
            }
        });


        NumeroDeEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13 && NumeroDeEmpleado.val()) {
                btnAceptar.attr('disabled', false);
                getInformacionEmpleado();
                Control.focus().select();
                onBeep(1);
            } else if (e.keyCode === 13 && NumeroDeEmpleado.val() === '' ||
                    e.keyCode === 8 && NumeroDeEmpleado.val() === '' ||
                    e.keyCode === 46 && NumeroDeEmpleado.val() === '') {
                onClearMO();
                DiasPagoDeNomina.find("input").val(0);

                dias.forEach(function (i) {
                    DiasPagoDeNomina.find("span.txt" + i).text(0);
                });
                DiasPagoDeNomina.find("#txtTotal").val(0);
                DiasPagoDeNomina.find("span.total_acumulado_x_empleado").text("$" + 0);
                pnlTablero.find(".nombre_empleado").text('-');
                btnAceptar.attr('disabled', true);
            }

        });

        /*FRACCIONES*/
        var fracciones = '', ii = 1;
        dias.forEach(function (i) {
            fracciones += '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">' +
                    '<label>' + i + '</label>' +
                    '</div>' +
                    '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">' +
                    '<span class="txt' + i + ' font-weight-bold font-italic" style="color: #2196F3; font-size:20px">0</span>';
            if (ii < dias.length) {
                fracciones += '<hr>';
                ii += 1;
            }
            fracciones += '<input type="text" id="txt' + i + '" name="txt' + i + '" class="form-control form-control-sm d-none" placeholder="0"  style="font-weight: bold; " readonly="">' +
                    '</div>';
        });
        fracciones += '<div class="col-12"><hr></div><div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<label>TOTAL</label>' +
                '</div>' +
                '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">' +
                '<span class="font-weight-bold total_acumulado_x_empleado" style="font-size: 26px; color: #388E3C; font-style: italic;">0.0</span>'
                + '<input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control form-control-sm d-none" placeholder="0"  style="font-weight: bold; ">' +
                '</div>';
        DiasPagoDeNomina.html(fracciones);

        /*AVOID C&P*/
//        var _0x6b99 = ["\x63\x75\x74\x20\x63\x6F\x70\x79\x20\x70\x61\x73\x74\x65",
//            "\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74",
//            "\x6F\x6E",
//            "\x62\x6F\x64\x79"];
//        $(_0x6b99[3])[_0x6b99[2]]
//                (_0x6b99[0], function (_0xd777x1) {
//                    _0xd777x1[_0x6b99[1]]();
        //                });

        var cols = [
            {"data": "ID"}/*0*/, {"data": "FECHA"}/*1*/,
            {"data": "CONTROL"}/*2*/, {"data": "ESTILO"},
            {"data": "FRAC"}, {"data": "PARES"},
            {"data": "PRECIO"}, {"data": "SUBTOTAL_SPAN"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        var xoptions = {
            "dom": 'rt',
            buttons: buttons,
            "columns": cols,
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
            "scrollY": "470px",
            "scrollX": true,
            "aaSorting": [
                [0, 'desc']
            ],
            initComplete: function () {
                pnlTablero.find("#AnoFiltro").val(<?php print Date('Y'); ?>);
            },

            "drawCallback": function (settings) {
                var api = this.api();
                var r = 0, prs = 0;
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                $.each(api.rows().data(), function (k, v) {
                    r += parseFloat(intVal(v.SUBTOTAL));
                    prs += parseInt(v.PARES);
                });

                $(api.column(5).footer()).html(
                        '<span class="font-weight-bold">' + prs + ' pares</span>');
                $(api.column(7).footer()).html(
                        '<span class="font-weight-bold" style="font-size:24px; color: #388E3C; font-style:italic;">$' +
                        $.number(r, 2, '.', ',') + '</span>');
            }
        };
        /*'Avance9/getFraccionesPagoNomina/$1'*/
        xoptions.ajax = {
            "url": '<?php print base_url('obtener_avances_pago_nomina/1'); ?>',
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val() ? NumeroDeEmpleado.val() : '';
                d.SEMANA = Semana.val() ? Semana.val() : '';
                d.ANO_FILTRO = pnlTablero.find("#AnoFiltro").val() ? pnlTablero.find("#AnoFiltro").val() : '';
                d.SEMANA_FILTRO = pnlTablero.find("#SemanaFiltro").val() ? pnlTablero.find("#SemanaFiltro").val() : '';
                d.FRACCION_FILTRO = pnlTablero.find("#FraccionFiltro").val() ? pnlTablero.find("#FraccionFiltro").val() : '';
                d.FRACCIONES = "96,99,100,102";
            }
        };
        $.fn.dataTable.ext.errMode = 'throw';
        Avance = tblAvance.DataTable(xoptions);
    });

    function getInformacionEmpleado() {
        Avance.ajax.reload();
        HoldOn.open({
            theme: 'sk-rect',
            message: 'Comprobando...'
        });
        $.post('<?php print base_url('Avance9/onComprobarDeptoXEmpleado') ?>', {EMPLEADO: NumeroDeEmpleado.val()})
                .done(function (data) {
                    var dt = JSON.parse(data);
                    if (dt.length > 0) {
                        NombreEmpleado.val(dt[0].NOMBRE_COMPLETO);
                        pnlTablero.find(".nombre_empleado").text(dt[0].NOMBRE_COMPLETO);
                        Departamento.val(dt[0].DEPTO);
                        Departamento.parent().find("span.departameto_actual_emp").text(dt[0].DEPTO);
                        DepartamentoDes.val(dt[0].DEPTO_DES);
                        GeneraAvance.val(dt[0].GENERA_AVANCE);
                        $.getJSON('<?php print base_url('Avance9/getSemanaByFecha'); ?>').done(function (data) {
                            Semana.val((data.length > 0) ? data[0].Sem : '');
                            Fecha.val((data.length > 0) ? data[0].Fecha : '');
                            getPagosXEmpleadoXSemana();
                        }).fail(function (x, y, z) {
                            console.log(x.responseText);
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE 1', 'error');
                        }).always(function () {

                        });
//                        swal('ATENCIÓN', 'SELECCIONE UNA FRACCIÓN', 'success').then((value) => {
//                            pnlTablero.find("#ManoDeObra label.custom-control-label").addClass("highlight");
                        //                        });
                    } else {
                        NombreEmpleado.val('');
                        pnlTablero.find(".nombre_empleado").text('-');
                        onBeep(2);
                        swal('ATENCIÓN', 'ESTE EMPLEADO NO ES APTO PARA DAR AVANCES O ESTA DADO DE BAJA', 'warning').then((value) => {
                            NumeroDeEmpleado.focus().select();
                            Semana.val('');
                            Fecha.val('');
                            Departamento.val('');
                            Control.val('');
                            DiasPagoDeNomina.find("input").val(0);
                            dias.forEach(function (e) {
                                DiasPagoDeNomina.find("span.txt"+e).text(0);
                            });
                            DiasPagoDeNomina.find("#txtTotal").val(0);
                            DiasPagoDeNomina.find("span.total_acumulado_x_empleado").text("$" + 0);
                        });
                    }
                }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE 2', 'error');
        }).always(function () {
            HoldOn.close();
        });
    }

    function onAgregarAvance(type) {
        if (Control.val()) {
            HoldOn.open({
                theme: 'sk-rect',
                message: 'Espere...'
            });
            var fra = pnlTablero.find("#chk99")[0].checked ? 99 : (pnlTablero.find("#chk100")[0].checked ? 100 : (pnlTablero.find("#chk96")[0] ? 96 : ''));
            /*COMPROBAR EL RETORNO DE MATERIAL*/
            fra = [];
            if (pnlTablero.find("#chk96")[0].checked) {
                fra.push({
                    NUMERO_FRACCION: 96
                });
            }
            if (pnlTablero.find("#chk99")[0].checked) {
                fra.push({
                    NUMERO_FRACCION: 99
                });
            }
            if (pnlTablero.find("#chk100")[0].checked) {
                fra.push({
                    NUMERO_FRACCION: 100
                });
            }
            $.getJSON('<?php print base_url('Avance9/onComprobarRetornoDeMaterialXControl'); ?>',
                    {CR: Control.val(), FR: JSON.stringify(fra), DEPTO: Departamento.val()}).done(function (data) {
                if (data[0].MENSAJE !== undefined) {
                    swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, \n\
                ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN CORRESPONDIENTE. \n\
                                    ES POSIBLE QUE TAMPOCO HAYAN HECHO UN RETORNO DE ESTE MATERIAL EN LA FRACCIÓN SELECCIONADA.', 'warning').then((value) => {
                        Control.focus().select();
                    });
                    return;
                }
                if (data.length > 0) {
                    var r = data[0];
                    Estilo.val(r.Estilo);
                    Pares.val(r.Pares);
                    ManoDeOB.val(r.CostoMO);

                    pnlTablero.find(".estilo_control").text(r.Estilo);
                    pnlTablero.find(".pares_control").text(r.Pares);

                    $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (data) {
                        if (data.length > 0) {
                            SigAvance.val(data[0].Departamento);
                            EstatusAvance.val(data[0].DepartamentoT);
                            estatus_de_avance.text(data[0].DepartamentoT);
                            pnlTablero.find(".avance_control").text(data[0].Departamento);
                            var d = new Date();
                            var n = d.getDay();
                            var stf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                            stf = stf.toString();
                            stf = stf.slice(0, (stf.indexOf(".")) + 3);

                            DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(stf);
                            DiasPagoDeNomina.find("span.txt" + ndias[n - 1]).text(stf);
                            var tt = 0;
                            ndias.forEach(function (i) {
                                tt += parseFloat(pnlTablero.find("#txt" + i).val());
                            });
                            var tf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                            tf = tf.toString();
                            tf = tf.slice(0, (tf.indexOf(".")) + 3);
                            DiasPagoDeNomina.find("#txtTotal").val(tf);
                            DiasPagoDeNomina.find("span.total_acumulado_x_empleado").text("$" + $.number(tf, 2, '.', ','));

                            getPagosXEmpleadoXSemana();
                            if (type) {
                                onAvanzar();
                            }
                        } else {
                            swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, \n\
                ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN CORRESPONDIENTE. \n\
                                                    ES POSIBLE QUE TAMPOCO HAYAN HECHO UN RETORNO DE ESTE MATERIAL EN LA FRACCIÓN SELECCIONADA.', 'warning').then((value) => {
                                Control.focus().select();
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x.responseText);
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE 3', 'error');
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, \n\
                ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN CORRESPONDIENTE. \n\
                                            ES POSIBLE QUE TAMPOCO HAYAN HECHO UN RETORNO DE ESTE MATERIAL EN LA FRACCIÓN SELECCIONADA.', 'warning').then((value) => {
                        Control.focus().select();
                        Pares.val('');
                        SigAvance.val('');
                        pnlTablero.find(".estilo_control").text('-');
                        pnlTablero.find(".pares_control").text('-');
                        pnlTablero.find(".avance_control").text('-');
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE 4', 'error');
            }).always(function () {
                HoldOn.close();
            });
        } else {
            onNotifyOld('<span class="fa fa-check"></span>', 'DEBE DE ESPECIFICAR UN CONTROL', 'danger');
            Control.focus().select();
        }
    }

    function onAgregarAvanceSinFraccion() {



        if (Control.val()) {
            /*COMPROBAR SI EL EMPLEADO ES DE RAYADO*/
            //            $.post('<?php print base_url('Avance9/onComprobarDeptoXEmpleado') ?>', {EMPLEADO: NumeroDeEmpleado.val()}).done(function (a) {

            $.getJSON('<?php print base_url('Avance9/onComprobarRetornoDeMaterialXControl'); ?>',
                    {CR: Control.val(), FR: '', DEPTO: Departamento.val()})
                    .done(function (data) {
                        if (data.length > 0) {
                            var r = data[0];
                            Estilo.val(r.Estilo);
                            Pares.val(r.Pares);
                            ManoDeOB.val(r.CostoMO);
                            Fraccion.val(r.Fraccion);
                            FraccionDes.val(r.FRACCION_DES);
                            pnlTablero.find(".estilo_control").text(r.Estilo);
                            pnlTablero.find(".pares_control").text(r.Pares);
                            //                                console.log('Avance9/getUltimoAvanceXControl', data);
                            $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (data) {
                                if (data.length > 0) {
                                    SigAvance.val(data[0].Departamento);
                                    pnlTablero.find(".avance_control").text(data[0].Departamento);
                                    EstatusAvance.val(data[0].DepartamentoT);
                                    estatus_de_avance.text(data[0].DepartamentoT);
                                    var d = new Date();
                                    var n = d.getDay();
                                    var stf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                                    stf = stf.toString();
                                    stf = stf.slice(0, (stf.indexOf(".")) + 3);
                                    DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(stf);
                                    DiasPagoDeNomina.find("span.txt" + ndias[n - 1]).text(stf);
                                    var tt = 0;
                                    ndias.forEach(function (i) {
                                        tt += parseFloat(pnlTablero.find("#txt" + i).val());
                                    });
                                    var tf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                                    tf = tf.toString();
                                    tf = tf.slice(0, (tf.indexOf(".")) + 3);
                                    DiasPagoDeNomina.find("#txtTotal").val(tf);
                                    DiasPagoDeNomina.find("span.total_acumulado_x_empleado").text("$" + $.number(tf, 2, '.', ','));
                                    onAvanzar();
                                }
                            }).fail(function (x, y, z) {
                                console.log(x.responseText);
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE 5', 'error');
                            }).always(function () {
                                HoldOn.close();
                                getPagosXEmpleadoXSemana();
                            });
                        }
                    }).fail(function (x, y, z) {
                console.log(x, y, z);
                swal('ERROR', 'ALGO SALIO MAL, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
            }).always(function () {
            });

//            }).fail(function (x, y, z) {
//                console.log(x, y, z);
//                swal('ERROR', 'ALGO SALIO MAL, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
//            }).always(function () {
            //            });
        } else {
            onNotifyOld('<span class="fa fa-check"></span>', 'DEBE DE ESPECIFICAR UN CONTROL', 'danger');
            Control.focus().select();
        }
    }

    function onCheckFraccion(e) {
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(e)[0].id !== $(v)[0].id) {
                $(v)[0].checked = false;
            }
        });
    }

    function onClearMO() {
        Control.val("");
        Estilo.val('');
        Pares.val('');
        SigAvance.val('');
        pnlTablero.find(".estilo_control").text('-');
        pnlTablero.find(".pares_control").text('-');
        pnlTablero.find(".avance_control").text('-');
    }

    function onActualizarAvances() {
        HoldOn.open({theme: 'sk-rect', message: 'Actualizando...'});
        Avance.ajax.reload(function () {
            HoldOn.close();
        });
    }

    function onAvanzar() {
        console.log('avanzando...');
        var frac = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('fraccion');
        var fs = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('description');
        AVANO.NUMERO_EMPLEADO = NumeroDeEmpleado.val();
        AVANO.CONTROL = Control.val();
        AVANO.ESTILO = Estilo.val();
        AVANO.NUMERO_FRACCION = (frac ? frac : Fraccion.val());
        AVANO.FRACCION = (fs ? fs : pnlTablero.find("#FraccionDes").val());
        AVANO.PRECIO_FRACCION = ManoDeOB.val();
        AVANO.PARES = Pares.val();
        AVANO.FECHA = Fecha.val();
        AVANO.SEMANA = Semana.val();
        AVANO.DEPARTAMENTO = Departamento.val();
        AVANO.DEPARTAMENTO_DESCRIPCION = DepartamentoDes.val();
        AVANO.ANIO = pnlTablero.find("#Anio").val();

        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            console.log(k, v);
        });
        var fracciones = [];
        if (pnlTablero.find("#chk96")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 96,
                DESCRIPCION: "CORTE MUESTRAS"
            });
        }
        if (pnlTablero.find("#chk99")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 99,
                DESCRIPCION: "CORTE FORRO"
            });
        }
        if (pnlTablero.find("#chk100")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 100,
                DESCRIPCION: "CORTE PIEL"
            });
        }
        AVANO.FRACCIONES = JSON.stringify(fracciones);

        /*REVISO FRACCIONES 102,60,103*/
        var depa_empleado = parseInt(Departamento.val());
        var registro_valido = true;
        if (depa_empleado === 80) {
            $.getJSON('<?php print base_url('Avance9/onRevisarCobroDeCorteParaRAYADO') ?>', {
                CONTROL: Control.val()
            }).done(function (a) {
                var r = a[0];
                switch (r.PUEDE_AVANZAR_A_RAYADO_VALIDA) {
                    case 0:
                        registro_valido = false;
                        onCampoInvalido(pnlTablero, "CONTROL FUERA DE AVANCE, CORTE NO HA CAPTURADO", function () {
                            Control.focus().select();
                        });
                        break;
                    case 1:
                        registro_valido = true;
                        onPagarFraccion(AVANO, fracciones);
                        break;
                }
            }).fail(function (x) {
                getError(x);
            });
        } else {
            onPagarFraccion(AVANO, fracciones);
        }
    }

    function  onPagarFraccion(AVANO, fracciones) {
        $.post('<?php print base_url('Avance9/onAgregarAvanceXEmpleadoYPagoDeNomina') ?>', AVANO).done(function (data) {
            console.log("\n * AVANCE NOMINA * \n", data);
            Avance.ajax.reload(function () {
                Control.focus().select();
            });
            var dt = JSON.parse(data);
            var avanzo = 0;
            if (fracciones.length >= 1) {
                $.each(dt, function (k, v) {
                    console.log(k, v);
                    if (parseInt(v.AVANZO) === 1) {
                        avanzo = 1;
                        if (data !== undefined && data.length > 0) {
                            if (avanzo > 0) {
                                Avance.ajax.reload();
                                onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
                                //                    swal('ATENCIÓN', 'SE HA AVANZADO EL CONTROL Y SE HA HECHO EL PAGO AL EMPLEADO ' + NumeroDeEmpleado.val(), 'success').then((value) => {
                                onClearMO();
                                Control.focus().select();
                                onBeep(5);
                                //                    });
                            } else {
                                onBeep(2);
                                Avance.ajax.reload();
                                onNotifyOldPCF('', '1 ESTE CONTROL (' + Control.val() + ') O ESTE EMPLEADO ESTAN FUERA DE AVANCE (DEPTO 80)', 'warning', {from: "bottom", align: "center"}, function () {
                                    Control.focus().select();
                                    btnAceptar.attr('disabled', true);
                                });
                                return;
                            }
                        }
                        return false;
                    } else {
                        if (parseInt(v.AVANZO) === 0) {
                            onBeep(2);

                            if (pnlTablero.find("#chk100")[0].checked) {
                                onNotifyOldPCF('', 'ESTE CONTROL (' + Control.val() + ') O ESTE EMPLEADO ESTAN FUERA DE AVANCE O NO HA CAPTURADO ALMACEN EL RETORNO DE MATERIAL.', 'warning', {from: "bottom", align: "center"}, function () {
                                    Control.focus().select();
                                    btnAceptar.attr('disabled', true)
                                    Avance.ajax.reload();
                                });
                                return;
                            } else {
                                onNotifyOldPCF('', '3 ESTE CONTROL (' + Control.val() + ') O ESTE EMPLEADO ESTAN FUERA DE AVANCE O NO SELECCIONO FRACCION Y PERTENECE A CORTE .', 'warning', {from: "bottom", align: "center"}, function () {
                                    Control.focus().select();
                                    btnAceptar.attr('disabled', true)
                                    Avance.ajax.reload();
                                });
                                return;
                            }
                            return;
                        }
                        onNotifyOldPCF('', '2 ESTE CONTROL (' + Control.val() + ') O ESTE EMPLEADO ESTAN FUERA DE AVANCE .', 'warning', {from: "bottom", align: "center"}, function () {
                            Control.focus().select();
                            btnAceptar.attr('disabled', true);
                            Avance.ajax.reload();
                        });
                        return;
                    }
                });
            }

            if ($.isNumeric(dt.AVANZO)) {
                if (parseInt(dt.AVANZO) === 1) {
                    Avance.ajax.reload();
                    onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
                    //                    swal('ATENCIÓN', 'SE HA AVANZADO EL CONTROL Y SE HA HECHO EL PAGO AL EMPLEADO ' + NumeroDeEmpleado.val(), 'success').then((value) => {
                    onClearMO();
                    Control.focus().select();
                    onBeep(5);
                } else {
                    onBeep(5);
                    onNotifyOldPC('<span class="fa fa-check"></span>', 'ESTE CONTROL ESTA FUERA DE AVANCE, SOLO SE MUESTRA INFORMACIÓN SOBRE DONDE SE ENCUENTRA', 'warning', {from: "bottom", align: "center"});
                    Control.focus().select();
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {
            getPagosXEmpleadoXSemana();
        });
    }

    function getPagosXEmpleadoXSemana() {
        $.getJSON('<?php print base_url('Avance9/getPagosXEmpleadoXSemana'); ?>',
                {EMPLEADO: NumeroDeEmpleado.val(), SEMANA: Semana.val(), FRACCIONES: "96, 99, 100"}).done(function (a) {
            if (a.length > 0) {
                var b = a[0];
                var tt = 0;
                ndias.forEach(function (i) {
                    pnlTablero.find("#txt" + i).val(b[i]);
                    pnlTablero.find("span.txt" + i).text(b[i]);
                    tt += $.isNumeric(b[i]) ? parseFloat(b[i]) : 0;
                    console.log(b[i])
                });
                pnlTablero.find("#txtTotal").val(tt);
                pnlTablero.find("span.total_acumulado_x_empleado").text("$" + $.number(tt, 2, '.', ','));
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
            onBeep(3);
            swal('ERROR', ' ERROR AL OBTENER LO PAGADO AL EMPLEADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
        }).always(function () {
        });
    }
</script>
<style>
    .btn-success {
        color: #fff;
        background-color: #2196F3;
        border-color: #03A9F4;
    }

    .btn-success:hover {
        color: #fff;
        background-color: #1976D2;
        border-color: #0288D1;
    }

    .custom-checkbox:hover, .custom-checkbox label:hover{
        cursor: pointer;
    }
    .custom-control-label{
        margin-top: 2px;
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome and Opera */
        -webkit-transition: background-color 0.5s ease-out;
        -moz-transition: background-color 0.5s ease-out;
        -o-transition: background-color 0.5s ease-out;
        transition: background-color 0.5s ease-out;
    }

    .card-body .custom-control-label::after {
        background-color: #3F51B5;
    }

    .highlight{
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
        background:#99cc00;
        font-weight: bold;
        color:#000;
        -webkit-transition: background-color 1s ease-out;
        -moz-transition: background-color 1s ease-out;
        -o-transition: background-color 1s ease-out;
        transition: background-color 1s ease-out;
    }

    input[type='text']{
        color: #c1850c !important;
        font-weight: bold !important;
    }
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid;
        border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;
        /*top
        background-image: linear-gradient(to left, #0099cc,  #cc0000, #0099cc) ;
        background-size: 100% 1px;
        background-position: 10% 0%, 0% 100%;
        background-repeat: no-repeat;  */
    }
    .card-header{
        background-color: transparent;
        border-bottom: 0px;
    }

    table tbody tr {
        font-size: 0.75rem !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    .alert-success{
        background: rgba(148,180,71,1);
        background: -moz-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(148,180,71,1)), color-stop(100%, rgba(93,110,30,1)));
        background: -webkit-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -o-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: -ms-linear-gradient(top, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        background: linear-gradient(to bottom, rgba(148,180,71,1) 0%, rgba(93,110,30,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#94b447', endColorstr='#5d6e1e', GradientType=0 );
    }
    .alert-warning{
        background: rgba(28,167,236,1);
        background: -moz-linear-gradient(top, rgba(28,167,236,1) 0%, rgba(31,47,152,1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(28,167,236,1)), color-stop(100%, rgba(31,47,152,1)));
        background: -webkit-linear-gradient(top, rgba(28,167,236,1) 0%, rgba(31,47,152,1) 100%);
        background: -o-linear-gradient(top, rgba(28,167,236,1) 0%, rgba(31,47,152,1) 100%);
        background: -ms-linear-gradient(top, rgba(28,167,236,1) 0%, rgba(31,47,152,1) 100%);
        background: linear-gradient(to bottom, rgba(28,167,236,1) 0%, rgba(31,47,152,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1ca7ec', endColorstr='#1f2f98', GradientType=0 ); 
    }
    div[data-notify="container"]{
        font-weight: bold !important;
        border: solid 1px #1f2f98 !important;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)!important;
    }
    .text-success{
        color: #9aa531 !important;
    }
    .text-info{
        color: #2196F3 !important;
    }
    .text-black{
        color: #000 !important;
        color: #c1850c  !important;
        font-weight: bold !important;
    }

    tr:hover span.text-success,tr:hover span.text-info,tr:hover span.text-black{
        color: #fff !important;
        font-weight: bold !important;
    }

    table tbody tr td { 
        font-weight: bold !important;
        font-size: 16px;
    }
    table tbody tr:hover { 
        color: #fff !important;
    }

    table tbody tr:hover td{
        background-color: #0375d8 !important; 
        font-weight: bold !important;
    }
    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #000000;
    }
</style>