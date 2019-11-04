<div class="card m-2 animated fadeIn" id="pnlTablero">
    <div class="card-body" style="padding-top: 3px; padding-bottom: 3px;">
        <div class="row">
            <div class="col-6">
                <legend class="font-weight-bold" style="margin-bottom: 0px;">Avance por empleado y pago de nómina</legend>
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <input type="text" id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control shadow-lg numeric" maxlength="4" style="height: 50px; font-weight: bold; font-size: 25px;" autofocus="" data-toggle="tooltip" data-placement="bottom" title="Ingrese un empleado del depto de corte">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control" placeholder="-" disabled="" style="height: 50px; font-weight: bold; font-size: 25px; text-align: center;">
            </div>
            <div class="w-100 my-1"></div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <div class="row justify-content-center" align="center">
                    <span onclick="onActualizarAvances();" class="fa fa-retweet fa-2x text-info text-shadow" style="cursor: pointer;" class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Actualizar"></span>
                    <h5> FRACCIONES DE ESTE EMPLEADO</h5>
                </div>
                <table id="tblAvance" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Control</th>

                            <th scope="col">Estilo</th>
                            <th scope="col">Frac.</th>
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
                                        ->from('semanasproduccion AS SP')
                                        ->where("STR_TO_DATE('{$F}', \"%d/%m/%Y\") "
                                                . "BETWEEN STR_TO_DATE(FechaIni, \"%d/%m/%Y\") "
                                                . "AND STR_TO_DATE(FechaFin, \"%d/%m/%Y\") AND SP.Ano = {$YYYY}")
                                        ->get()->result();
                        ?>
                        <label>Semana</label>
                        <input type="text" id="Semana" name="Semana" class="form-control form-control-sm numeric" maxlength="2">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" readonly="" class="form-control form-control-sm date notEnter">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Departamento</label>
                        <input type="text" id="Departamento" readonly="" name="Departamento" class="form-control form-control-sm numeric" maxlength="3">
                        <input type="text" id="DepartamentoDes" name="DepartamentoDes" class="form-control d-none" maxlength="3">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" class="form-control form-control-sm numeric" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" readonly="" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <input type="text" id="Pares" name="Pares" readonly=""  class="form-control form-control-sm numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <input type="text" id="Avance" name="Avance"  readonly=""  class="form-control form-control-sm numeric">
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
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
                        <span class="font-weight-bold" style="color : #3F51B5 !important;">ESTATUS ACTUAL DEL AVANCE </span>  
                        <div class="w-100"></div>
                        <span class="font-weight-bold estatus_de_avance" style="color : #ef1000 !important">-</span>
                        <input type="text" id="EstatusAvance" name="EstatusAvance" readonly="" class="form-control form-control-sm d-none" style="text-align: center">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <p class="text-info font-weight-bold" style="color : #3F51B5 !important;">PAGO DE NÓMINA</p>
                        <div id="DiasPagoDeNomina" class="row"></div>
                    </div> 
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->
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
            if (e.keyCode === 13) {
                if (pnlTablero.find("input[type='checkbox']:checked").length > 0) {
                    console.log('avance 1');
                    onAgregarAvance(true);
                } else {
                    console.log('avance 2');
                    onAgregarAvanceSinFraccion();
                }
            }
        });

        pnlTablero.find("input[type='checkbox']").change(function () {
            if (NumeroDeEmpleado.val()) {
                Control.focus().select();
            } else {
                NumeroDeEmpleado.focus().select();
            }
        });

        NumeroDeEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13 && NumeroDeEmpleado.val()) {
                btnAceptar.attr('disabled', false);
                getInformacionEmpleado();
                Control.focus().select();
            } else {
                btnAceptar.attr('disabled', true);
            }

        });

        /*FRACCIONES*/
        var fracciones = '';
        dias.forEach(function (i) {
            fracciones += '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">' +
                    '<label>' + i + '</label>' +
                    '</div>' +
                    '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                    '<input type="text" id="txt' + i + '" name="txt' + i + '" class="form-control form-control-sm" placeholder="0"  style="font-weight: bold; " readonly="">' +
                    '</div>';
        });
        fracciones += '<div class="col-12"><hr></div><div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<label>TOTAL</label>' +
                '</div>' +
                '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control form-control-sm" placeholder="0"  style="font-weight: bold; ">' +
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
            {"data": "PRECIO"}, {"data": "SUBTOTAL"}
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
            createdRow: function (row, data, dataIndex) {
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Total over this page
                pageTotal = api
                        .column(7, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                // Update footer
                $(api.column(7).footer()).html(
                        '$' + $.number(pageTotal, 2, '.', ',') + ' ( $' + $.number(total, 2, '.', ',') + ' total)'
                        );
            }
        };
        xoptions.ajax = {
            "url": '<?php print base_url('obtener_avances_pago_nomina/1'); ?>',
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val() ? NumeroDeEmpleado.val() : '';
                d.FRACCIONES = "96,99,100";
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
                        Departamento.val(dt[0].DEPTO);
                        DepartamentoDes.val(dt[0].DEPTO_DES);
                        GeneraAvance.val(dt[0].GENERA_AVANCE);
                        $.getJSON('<?php print base_url('Avance9/getSemanaByFecha'); ?>').done(function (data) {
                            Semana.val((data.length > 0) ? data[0].Sem : '');
                            Fecha.val((data.length > 0) ? data[0].Fecha : '');
                            getPagosXEmpleadoXSemana();
                        }).fail(function (x, y, z) {
                            console.log(x.responseText);
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                        }).always(function () {

                        });
//                        swal('ATENCIÓN', 'SELECCIONE UNA FRACCIÓN', 'success').then((value) => {
//                            pnlTablero.find("#ManoDeObra label.custom-control-label").addClass("highlight");
//                        });
                    } else {
                        NombreEmpleado.val('');
                        onBeep(2);
                        swal('ATENCIÓN', 'ESTE EMPLEADO NO ES APTO PARA DAR AVANCES O ESTA DADO DE BAJA', 'warning').then((value) => {
                            NumeroDeEmpleado.focus().select();
                            Semana.val('');
                            Fecha.val('');
                            Departamento.val('');
                            Control.val('');
                        });
                    }
                }).fail(function (x, y, z) {
            console.log(x.responseText);
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
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
            $.getJSON('<?php print base_url('Avance9/onComprobarRetornoDeMaterialXControl'); ?>', {CR: Control.val(), FR: fra, DEPTO: Departamento.val()}).done(function (data) {
                if (data.length > 0) {
                    var r = data[0];
                    Estilo.val(r.Estilo);
                    Pares.val(r.Pares);
                    ManoDeOB.val(r.CostoMO);
                    $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (data) {
                        if (data.length > 0) {
                            SigAvance.val(data[0].Departamento);
                            EstatusAvance.val(data[0].DepartamentoT);
                            estatus_de_avance.text(data[0].DepartamentoT);
                            var d = new Date();
                            var n = d.getDay();
                            var stf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                            stf = stf.toString();
                            stf = stf.slice(0, (stf.indexOf(".")) + 3);

                            DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(stf);
                            var tt = 0;
                            ndias.forEach(function (i) {
                                tt += parseFloat(pnlTablero.find("#txt" + i).val());
                            });
                            var tf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                            tf = tf.toString();
                            tf = tf.slice(0, (tf.indexOf(".")) + 3);
                            DiasPagoDeNomina.find("#txtTotal").val(tf);
                            if (type) {
                                onAvanzar();
                            }
                        }
                    }).fail(function (x, y, z) {
                        console.log(x.responseText);
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                    }).always(function () {
                        HoldOn.close();
                    });
                } else {
                    swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN CORRESPONDIENTE. ES POSIBLE QUE TAMPOCO HAYAN HECHO UN RETORNO DE ESTE MATERIAL EN LA FRACCIÓN SELECCIONADA.', 'warning').then((value) => {
                        Control.focus().select();
                        Estilo.val('');
                        Pares.val('');
                        SigAvance.val('');
                    });
                }
            }).fail(function (x, y, z) {
                console.log(x.responseText);
                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
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
//                                console.log('Avance9/getUltimoAvanceXControl', data);
                            $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (data) {
                                if (data.length > 0) {
                                    SigAvance.val(data[0].Departamento);
                                    EstatusAvance.val(data[0].DepartamentoT);
                                    estatus_de_avance.text(data[0].DepartamentoT);
                                    var d = new Date();
                                    var n = d.getDay();
                                    var stf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                                    stf = stf.toString();
                                    stf = stf.slice(0, (stf.indexOf(".")) + 3);
                                    DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(stf);
                                    var tt = 0;
                                    ndias.forEach(function (i) {
                                        tt += parseFloat(pnlTablero.find("#txt" + i).val());
                                    });
                                    var tf = parseFloat(r.Pares) * parseFloat(r.CostoMO);
                                    tf = tf.toString();
                                    tf = tf.slice(0, (tf.indexOf(".")) + 3);
                                    DiasPagoDeNomina.find("#txtTotal").val(tf);
                                    onAvanzar();
                                }
                            }).fail(function (x, y, z) {
                                console.log(x.responseText);
                                swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                            }).always(function () {
                                HoldOn.close();
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
        pnlTablero.find("#txtTotal").val('');
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
        $.post('<?php print base_url('Avance9/onAgregarAvanceXEmpleadoYPagoDeNomina') ?>', AVANO).done(function (data) {
            console.log("\n", "* AVANCE NOMINA *", "\n", data, JSON.parse(data));
            var dt = JSON.parse(data), avanzo = 0;
            console.log("# de objetos  = > ", dt);
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
                            swal('ATENCIÓN', 'ESTE CONTROL (' + Control.val() + ') O ESTE EMPLEADO ESTAN FUERA DE AVANCE (DEPTO 80)', 'warning').then((value) => {
                                Control.focus().select();
                                btnAceptar.attr('disabled', true)
                            });
                        }
                    }
                    return false;
                }
                if ($.isNumeric(v)) {
                    if (parseInt(v) === 1) {
                        Avance.ajax.reload();
                        onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
//                    swal('ATENCIÓN', 'SE HA AVANZADO EL CONTROL Y SE HA HECHO EL PAGO AL EMPLEADO ' + NumeroDeEmpleado.val(), 'success').then((value) => {
                        onClearMO();
                        Control.focus().select();
                        onBeep(5);
                    }
                }
            });
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
                    tt += $.isNumeric(b[i]) ? parseFloat(b[i]) : 0;
                });
                pnlTablero.find("#txtTotal").val(tt);
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
</style>