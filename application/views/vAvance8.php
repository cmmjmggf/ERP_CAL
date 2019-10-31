<div class="card m-3" id="pnlTablero">
    <div class="card-header">   
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 text-center">
                <h3 class="font-weight-bold">Avance por empleado y pago de nomina</h3>
            </div> 
        </div>
    </div>
    <div class="card-body" style="padding-top: 10px;    padding-bottom: 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Empleado</label>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <input type="text" id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control numeric " maxlength="8" placeholder="2805" style="height: 75px; font-weight: bold; font-size: 50px;" autofocus="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control" readonly="" placeholder="-" style="height: 75px; font-weight: bold; font-size: 50px; text-align: center;">
            </div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <h4>Fracciones de este empleado</h4>
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
                </table>
            </div><!--FIN BLOQUE 2 COL 6-->
            <!--INICIO BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="row">
                    <div id="ManoDeObra" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row" style="border-radius: 5px;">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label>Mano de obra</label>  
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk51" description="ENTRETELADO" fraccion="51">
                                <label class="custom-control-label" for="chk51">51 Entretelado</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk70" description="TROQUELAR PLANTILLA" fraccion="70">
                                <label class="custom-control-label" for="chk70">70 Troquelar plantilla</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk60" description="FOLEAR CORTE Y CALIDAD" fraccion="60">
                                <label class="custom-control-label" for="chk60">60 Folear corte y calidad</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk61" description="FOLEADO MUESTRA" fraccion="61">
                                <label class="custom-control-label" for="chk61">61 Foleado muestra</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk62" description="SERIGRAFIA FORRO" fraccion="62">
                                <label class="custom-control-label" for="chk62">62 Serigrafia forro</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk24" description="DOMAR" fraccion="24">
                                <label class="custom-control-label" for="chk24">24 Domar</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk78" description="LIMPIA LASER" fraccion="78">
                                <label class="custom-control-label" for="chk78">78 Limpia laser</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk204" description="EMPALMAR PARA LASER" fraccion="204">
                                <label class="custom-control-label" for="chk204">204 Empalmar p/laser</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk205" description="APLICA PEGA PARA LASER" fraccion="205">
                                <label class="custom-control-label" for="chk205">205 Aplica pega.p/laser</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk198" description="LOTEAR PARA LASER" fraccion="198">
                                <label class="custom-control-label" for="chk198">198 Lotear p/laser</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk127" description="ENTRETELAR MUESTRA" fraccion="127">
                                <label class="custom-control-label" for="chk127">127 Entretelar muestra</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk80" description="CONTAR TAREA" fraccion="80">
                                <label class="custom-control-label" for="chk80">80 Contar tarea</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk397" description="JUNTAR SUELA A CORTE" fraccion="397">
                                <label class="custom-control-label" for="chk397">397 Juntar suela a corte</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk34" description="PEGAR TRANSFER" fraccion="34">
                                <label class="custom-control-label" for="chk34">34 Pegar transfer</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk106" description="DOBLILLADO" fraccion="106">
                                <label class="custom-control-label" for="chk106">106 Doblillado</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk306" description="FORRAR PLATAFORMA" fraccion="306">
                                <label class="custom-control-label" for="chk306">306 Forrar plataforma</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk337" description="RECORTAR FORRO LASER" fraccion="337">
                                <label class="custom-control-label" for="chk337">337 Recortar forro laser</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">  
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk333" description="PONER CASCO PESPUNTE" fraccion="333">
                                <label class="custom-control-label" for="chk333">333 Poner casco pespunte</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk502" description="PEGADO DE SUELA" fraccion="502">
                                <label class="custom-control-label" for="chk502">502 Pegado de suela</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk72" description="TROQUELAR NORMA" fraccion="72">
                                <label class="custom-control-label" for="chk72">72 Troquelar norma</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk607" description="ARMAR PLANTILLA ADORNO" fraccion="607">
                                <label class="custom-control-label" for="chk607">607 Armar plantilla adorno</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk34" description="PEGAR TRANSFER" fraccion="34">
                                <label class="custom-control-label" for="chk34">34 Pegar transfer</label>
                            </div>
                        </div>

                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk606" description="ARMAR PLANT AD MUEST" fraccion="606">
                                <label class="custom-control-label" for="chk606">606 Armar plant.ad.muest</label>
                            </div>
                        </div>
                    </div>

                    <div class="w-100"></div>                    
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2 d-none">
                        <div class="row">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="GeneraAvance" name="GeneraAvance" class="form-control"> 
                            </div>
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <input type="text" id="Depto" name="Depto" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                        <label>Semana</label>
                        <input type="text" id="Semana" name="Semana" class="form-control  numeric" maxlength="2" disabled="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="form-control  ">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Departamento</label>
                        <input type="text" id="Departamento" name="Departamento" class="form-control numeric " maxlength="3">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" class="form-control  numeric" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" class="form-control ">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <input type="text" id="Pares" name="Pares" class="form-control  numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <input type="text" id="Avance" name="Avance" class="form-control  numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mx-auto">
                        <button type="button" class="btn btn-success mt-4" id="btnAceptar" name="btnAceptar" data-toggle="tooltip" data-placement="top" title="Aceptar"><span class="fa fa-check"></span></button>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label>MO</label>
                        <input type="text" id="ManoDeOB" name="ManoDeOB" class="form-control numeric" readonly="">
                        <label>AN</label>
                        <input type="text" id="Anio" name="Anio" class="form-control numeric" readonly="">
                    </div> 
                    <div class="col-12 my-1">
                        <hr>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"></div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <h3>Pago de nomina</h3>
                        <div id="DiasPagoDeNomina" class="row"></div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
                        <h3>Estatus actual del avance</h3>
                        <input type="text" id="EstatusAvance" name="EstatusAvance" class="form-control ">
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
            GeneraAvance = pnlTablero.find("#GeneraAvance"),
            Depto = pnlTablero.find("#Depto"),
            Semana = pnlTablero.find("#Semana"),
            Fecha = pnlTablero.find("#Fecha"),
            Control = pnlTablero.find("#Control"),
            Departamento = pnlTablero.find("#Departamento"),
            Estilo = pnlTablero.find("#Estilo"),
            Pares = pnlTablero.find("#Pares"),
            SigAvance = pnlTablero.find("#Avance"),
            EstatusAvance = pnlTablero.find("#EstatusAvance"),
            ManoDeOB = pnlTablero.find("#ManoDeOB"),
            Anio = pnlTablero.find("#Anio"), btnAceptar = pnlTablero.find("#btnAceptar");

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

        handleEnter();

        btnAceptar.click(function () {
            onAgregarAvance();
        });

        Anio.val(new Date().getFullYear());

        Control.on('keydown', function (e) {
            if (e.keyCode === 13) {
                onAgregarAvance();
            }
        });

        pnlTablero.find("input[type='checkbox']").change(function () {
            var mo = pnlTablero.find("#ManoDeObra");
            if (NumeroDeEmpleado.val()) {
                onCheckFraccion(this);
                if ($(this)[0].checked) {
                    onBeep(3);
                    Control.focus().select();
                    mo.find("input[type='checkbox']:not(:checked)").parent().find("label.custom-control-label").removeClass("highlight");
                    mo.find("input[type='checkbox']:checked").parent().find("label.custom-control-label").addClass("highlight");
                } else {
                    onBeep(1);
                    if (pnlTablero.find("input[type='checkbox']:checked").length <= 0) {
                        mo.find("label.custom-control-label").addClass("highlight");
                    } else {
                        mo.find("label.custom-control-label").removeClass("highlight");
                    }
                }
            } else {
                swal('ATENCIÓN', 'ES NECESARIO ESPECIFICAR UN NUMERO DE EMPLEADO', 'warning').then((value) => {
                    NumeroDeEmpleado.focus().select();
                    $.each(mo.find("input[type='checkbox']"), function (k, v) {
                        $(v)[0].checked = false;
                    });
                });
            }
        });

        NumeroDeEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Revisando si el empleado cumple con los requisitos...'
                });
                Avance.ajax.reload();
                $.post('<?php print base_url('comprobar_numero_de_empleado_ocho') ?>', {EMPLEADO: NumeroDeEmpleado.val()})
                        .done(function (data) {
                            var dt = JSON.parse(data);
                            if (dt.length > 0) {
                                var r = dt[0];
                                GeneraAvance.val(r.GENERA_AVANCE);
                                Depto.val(r.DEPTO);
                                NombreEmpleado.val(r.NOMBRE_COMPLETO);
                                Departamento.val(r.DEPTOCTO);
                                $.getJSON('<?php print base_url('obtener_semana_fecha_ocho'); ?>').done(function (data) {
                                    var rr = data[0];
                                    Semana.val((data.length > 0) ? rr.Sem : '');
                                    Fecha.val((data.length > 0) ? rr.Fecha : '');
                                    $.getJSON('<?php print base_url('obtener_pagos_de_nomina_x_empleado_ocho'); ?>',
                                            {EMPLEADO: NumeroDeEmpleado.val(), SEMANA: Semana.val(), FRACCIONES: "51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337"}).done(function (a) {
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
                                }).fail(function (x, y, z) {
                                    console.log(x.responseText);
                                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                                }).always(function () {

                                });
//                                swal('ATENCIÓN', 'SELECCIONE UNA FRACCIÓN', 'success').then((value) => {
                                pnlTablero.find("#ManoDeObra label.custom-control-label").addClass("highlight");
//                                });
                            } else {
                                NombreEmpleado.val('');
                                onBeep(2);
                                swal('ATENCIÓN', 'ESTE EMPLEADO NO ES APTO PARA DAR AVANCES O ESTA DADO DE BAJA', 'warning').then((value) => {
                                    NumeroDeEmpleado.focus().select();
                                });
                            }
                        }).fail(function (x, y, z) {
                    console.log(x.responseText);
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                }).always(function () {
                    HoldOn.close();
                });
            }
        });

        /*FRACCIONES*/
        var chksfracciones = '';
        dias.forEach(function (i) {
            chksfracciones += '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">' +
                    '<label>' + i + '</label>' +
                    '</div>' +
                    '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                    '<input type="text" id="txt' + i + '" name="txt' + i + '" class="form-control" placeholder="0"  style="font-weight: bold; text-align: center;" readonly="">' +
                    '</div>';
        });
        chksfracciones += '<div class="col-12"><hr></div><div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<label>TOTAL</label>' +
                '</div>' +
                '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control" placeholder="0"  style="font-weight: bold; text-align: center;">' +
                '</div>';
        DiasPagoDeNomina.html(chksfracciones);

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
            "dom": 'rit',
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
            "scrollY": "500px",
            "scrollX": true,
            createdRow: function (row, data, dataIndex) {
            }
        };
        xoptions.ajax = {
            "url": '<?php print base_url('obtener_avances_pago_nomina/2'); ?>', 
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val() ? NumeroDeEmpleado.val() : '';
                d.FRACCIONES = "51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337";
            }
        };
        $.fn.dataTable.ext.errMode = 'throw';
        Avance = tblAvance.DataTable(xoptions);
    });

    function onAgregarAvance() {
        var cks = pnlTablero.find("input[type='checkbox']:checked");
        var fra = cks.attr('fraccion');
        console.log("FRACCION * ", fra);
        if (cks.length > 0) {
            if (Control.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Espere...'
                });
                $.getJSON('<?php print base_url('obtener_estilo_pares_por_control_fraccion_ocho'); ?>', {CR: Control.val(), FR: fra}).done(function (a) {
                    if (a.length > 0) {
                        var r = a[0];
                        Estilo.val(r.Estilo);
                        Pares.val(r.Pares);
                        ManoDeOB.val(r.CostoMO);
                        $.getJSON('<?php print base_url('obtener_ultimo_avance_por_control_ocho'); ?>', {C: Control.val()}).done(function (b) {
                            if (b.length > 0) {
                                SigAvance.val(b[0].Departamento);
                                EstatusAvance.val(b[0].DepartamentoT);
                                var d = new Date();
                                var n = d.getDay();
                                DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
                                var tt = 0;
                                ndias.forEach(function (i) {
                                    tt += parseFloat(pnlTablero.find("#txt" + i).val());
                                });
                                DiasPagoDeNomina.find("#txtTotal").val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
                                onAvanzar();
                            }
                        }).fail(function (x, y, z) {
                            console.log(x.responseText);
                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                        }).always(function () {
                            HoldOn.close();
                        });
                    } else {
                        swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN SELECCIONADA', 'error').then((value) => {
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
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'error').then((value) => {
                    Control.focus().select();
                });
            }
        } else {
            swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UNA FRACCIÓN', 'error').then((value) => {
                Control.focus().select();
            });
        }
    }

    var fracciones = [51, 24, 205, 80, 106, 333, 61, 78, 198, 397, 306, 502, 62, 204, 127, 34, 337];

    function onCheckFraccion(e) {
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(e)[0].id !== $(v)[0].id) {
                $(v)[0].checked = false;
            }
        });
    }

    function onClearMO() {
        Control.focus().select();
        Estilo.val('');
        Pares.val('');
        SigAvance.val('');
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            $(v)[0].checked = false;
        });
        Semana.val('');
        Fecha.val('');
        Departamento.val('');
        ndias.forEach(function (i) {
            pnlTablero.find("#txt" + i).val('');
        });
        pnlTablero.find("#txtTotal").val('');
    }

    function onAvanzar() {

        AVANO.NUMERO_EMPLEADO = NumeroDeEmpleado.val();
        AVANO.CONTROL = Control.val();
        AVANO.ESTILO = Estilo.val();
        AVANO.NUMERO_FRACCION = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('fraccion');
        AVANO.FRACCION = pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").attr('description');
        AVANO.PRECIO_FRACCION = ManoDeOB.val();
        AVANO.PARES = Pares.val();
        AVANO.FECHA = Fecha.val();
        AVANO.SEMANA = Semana.val();
        AVANO.DEPARTAMENTO = Departamento.val();
        AVANO.ANIO = pnlTablero.find("#Anio").val();

        $.post('<?php print base_url('avance_add_avance_x_empleado_add_nomina_ocho') ?>', AVANO).done(function (c) {
            var dt = JSON.parse(c);
            if (c !== undefined && c.length > 0) {
                if (dt.AVANZO > 0) {
                    Avance.ajax.reload();
                    swal('ATENCIÓN', 'SE HA AVANZADO EL CONTROL Y SE HA HECHO EL PAGO AL EMPLEADO ' + NumeroDeEmpleado.val(), 'success').then((value) => {
                        onClearMO();
                        NumeroDeEmpleado.focus().select();
                    });
                } else {
                    onBeep(2);
                    Avance.ajax.reload();
                    swal('ATENCIÓN', 'ESTE CONTROL (' + Control.val() + ') YA TIENE UN AVANCE EN ESTA FRACCIÓN, POR FAVOR ESPECIFIQUE UN CONTROL DIFERENTE O UNA FRACCIÓN DIFERENTE, DE LO CONTRARIO REVISE CON EL AREA CORRESPONDIENTE', 'warning').then((value) => {
                        onClearMO();
                        Control.val('');
                        NumeroDeEmpleado.focus().select();
                    });
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
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
        background:#4CAF50; 
        font-weight: bold;
        color:#fff;
        -webkit-transition: background-color .1s ease-out;
        -moz-transition: background-color .1s ease-out;
        -o-transition: background-color .1s ease-out;
        transition: background-color .1s ease-out;
    }

    .custom-control-label:hover{
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;    
        background:#03a9f4; 
        font-weight: bold;
        color:#fff;
        -webkit-transition: background-color .1s ease-out;
        -moz-transition: background-color .1s ease-out;
        -o-transition: background-color .1s ease-out;
        transition: background-color .1s ease-out;
    }
    input[type='text']{
        color: #c1850c !important;
        font-weight: bold !important;
    }
</style>
<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        border-image: linear-gradient(to bottom,  #2196F3, #99cc00, rgb(0,0,0,0)) 1 100% ;
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
</style>