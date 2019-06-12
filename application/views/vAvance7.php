<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-header">   
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 col-lg-12 text-center">
                <h3 class="font-weight-bold" style="margin-bottom: 0px;">Avance por empleado y pago de nomina</h3>
            </div> 
        </div>
    </div>
    <div class="card-body" style="padding-top: 0px; padding-bottom: 10px;">
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <label>Empleado</label>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <input type="text" id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control shadow-lg numeric" placeholder="2805" style="height: 75px; font-weight: bold; font-size: 50px;" autofocus="" data-toggle="tooltip" data-placement="bottom" title="Ingrese un empleado del depto de corte">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control" placeholder="-" disabled="" style="height: 75px; font-weight: bold; font-size: 50px; text-align: center;">
            </div>
            <div class="w-100 my-1"></div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center"> 
                <div class="row justify-content-center" align="center">
                    <span onclick="onActualizarAvances();" class="fa fa-retweet fa-2x text-info text-shadow" style="cursor: pointer;" class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Actualizar"></span> 
                    <h4> Fracciones de este empleado</h4> 
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
                            <h4>Mano de obra</h4>  
                        </div> 
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk60" description="FOLEAR CORTE CALIDAD" fraccion='60'>
                                <label class="custom-control-label" for="chk60" >60 FOLEAR CORTE CALIDAD</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk70" description="TROQUELAR PLANTILLA" fraccion='70'>
                                <label class="custom-control-label" for="chk70">70 TROQUELAR PLANTILLA</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk71" description="TROQUELAR MUESTRA" fraccion='71'>
                                <label class="custom-control-label" for="chk71">71 TROQUELAR MUESTRA</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk72" description="TROQUELAR NORMA" fraccion='72'>
                                <label class="custom-control-label" for="chk72">72 TROQUELAR NORMA</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk75" description="TROQUELAR CORTE" fraccion='75'>
                                <label class="custom-control-label" for="chk75">75 TROQUELAR CORTE</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk204" description="EMPALMAR PARA LASER" fraccion='204'>
                                <label class="custom-control-label" for="chk204">204 EMPALMAR P' LASER</label>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="chk337" description="RECORTAR FORRO LASER" fraccion='337'>
                                <label class="custom-control-label" for="chk337">337 RECORTAR FORRO LASER</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Semana</label>
                        <input type="text" id="Semana" name="Semana" class="form-control numeric" maxlength="2" disabled="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="form-control date notEnter" readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Departamento</label>
                        <input type="text" id="Departamento" name="Departamento" class="form-control numeric" maxlength="3">
                        <input type="text" id="DepartamentoDes" name="DepartamentoDes" class="form-control d-none" maxlength="3">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" class="form-control numeric" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <label>Estilo</label>
                        <input type="text" id="Estilo" name="Estilo" class="form-control">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <input type="text" id="Pares" name="Pares" class="form-control numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <input type="text" id="Avance" name="Avance" class="form-control numeric">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 row justify-content-center align-self-center">
                        <button type="button" class="btn btn-primary mt-4 pt-2" id="btnAceptar" name="btnAceptar" data-toggle="tooltip" data-placement="top" title="Aceptar"><span class="fa fa-check"></span></button>
                        <button type="button" class="btn btn-info m-1 d-none" id="btnAceptarPDF" name="btnAceptarPDF" data-toggle="tooltip" data-placement="top" title="PDF"><span class="fa fa-file-pdf"></span></button>
                        <button type="button" class="btn btn-success m-1 d-none" id="btnAceptarXLS" name="btnAceptarXLS" data-toggle="tooltip" data-placement="top" title="Excel"><span class="fa fa-file-excel"></span></button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none"> 
                        <label>ANIO</label>
                        <input type="text" id="Anio" name="Anio" class="form-control numeric" readonly=""> 
                        <label>GENAVA</label>
                        <input type="text" id="GeneraAvance" name="GeneraAvance" class="form-control" readonly=""> 
                    </div>
                    <div class="col-12 my-1">
                        <hr>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <button type="button" class="btn btn-primary" id="btnRastreo" name="btnRastreo">
                            <span class="fa fa-search"></span>
                            <br>Rastreo 
                        </button>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                        <h3>Pago de nomina</h3>
                        <div id="DiasPagoDeNomina" class="row"></div>
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
                        <h3>Estatus actual del avance</h3>
                        <input type="text" id="EstatusAvance" name="EstatusAvance" class="form-control" style="text-align: center">
                    </div>
                </div>
            </div><!--FIN BLOQUE 2 COL 6-->
        </div>
    </div>
</div>

<div class="modal" id="mdlRastreos" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rastreo de controles ya capturados de nomina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row"> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" class="form-control">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label>Semana</label>
                        <input type="text" id="Semana" name="Semana" class="form-control">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Empleado</label>
                        <select id="Empleado" name="Empleado" class="form-control"></select>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Desc.Fraccion</label>
                        <input type="text" id="DescFraccion" name="DescFraccion" class="form-control">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <label>Avance Actual</label>
                        <input type="text" id="AvanceActual" name="AvanceActual" class="form-control">
                    </div>
                </div>
                <div class="card-block mt-4">
                    <div id="Rastreos" class="table-responsive">
                        <table id="tblRastreos" class="table table-hover table-sm table-bordered  compact nowrap" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Empleado</th>

                                    <th scope="col">Estilo</th>
                                    <th scope="col">Frac.</th>
                                    <th scope="col">Fecha</th>

                                    <th scope="col">Sem</th>
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
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .card{
        background-color: #f9f9f9;
        border-width: 1px 2px 2px;
        border-style: solid; 
        /*border-image: linear-gradient(to bottom,  #2196F3, #cc0066, rgb(0,0,0,0)) 1 100% ;*/
        border-image: linear-gradient(to bottom,  #0099cc, #ccff00, rgb(0,0,0,0)) 1 100% ;
    }
    .card-header{ 
        background-color: transparent;
        border-bottom: 0px;
    }
    .custom-control-label{
        cursor: pointer !important;
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

    .btn-warning, .btn-warning:not(:disabled):not(.disabled):active {
        color: #fff; 
        /*BLUE:INFO*/
        border-color: #0099cc ;
        background-image: linear-gradient(to bottom, #006699 0%, #006699 0% , #99ccff 100% ); 
        /*GREEN:SUCCESS*/
        border-color: #669900 ; 
        background-image: linear-gradient(to bottom, #669900 0%, #669900 0% , #ccff00 100% );  
        /*RED:ERROR*/
        border-color: #990000 ; 
        background-image: linear-gradient(to bottom, #990000 0%, #990000 0% , #ff7070 100% );  
        /*ORANGE:WARNING*/
        border-color: #c79810 ; 
        background: #eab92d; /* Old browsers */
        background: -moz-linear-gradient(top, #eab92d 0%, #c79810 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #eab92d 0%,#c79810 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #eab92d 0%,#c79810 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    .btn-warning:hover{
        /*BLUE:INFO*/
        border-color: #a1c4fd ;
        /*GREEN:SUCCESS*/
        border-color: #669900 ; 
        /*RED:ERROR*/
        border-color: #990000 ;
        /*ORANGE:WARNING*/
        border-color: #ff9900 ; 
    } 
</style>
<script>
    var pnlTablero = $("#pnlTablero"), NumeroDeEmpleado = pnlTablero.find("#NumeroDeEmpleado"),
            NombreEmpleado = pnlTablero.find("#NombreEmpleado"), Semana = pnlTablero.find("#Semana"),
            Fecha = pnlTablero.find("#Fecha"), Departamento = pnlTablero.find("#Departamento"),
            Avance, tblAvance = pnlTablero.find("#tblAvance"), Control = pnlTablero.find("#Control"),
            btnAceptar = pnlTablero.find("#btnAceptar"), Estilo = pnlTablero.find("#Estilo"), Pares = pnlTablero.find("#Pares"),
            Anio = pnlTablero.find("#Anio"), btnAceptarPDF = pnlTablero.find("#btnAceptarPDF"),
            btnAceptarXLS = pnlTablero.find("#btnAceptarXLS"), DiasPagoDeNomina = pnlTablero.find("#DiasPagoDeNomina"),
            EstatusAvance = pnlTablero.find("#EstatusAvance"), btnRastreo = pnlTablero.find("#btnRastreo"),
            mdlRastreos = $("#mdlRastreos");
    var dias = ["JUEVES", "VIERNES", "SABADO", "DOMINGO", "LUNES", "MARTES", "MIERCOLES"],
            ndias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO", "DOMINGO"];

    $(document).ready(function () {
        handleEnter();

        btnRastreo.click(function () {
            mdlRastreos.modal('show');
        });

        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                $.getJSON('<?php print base_url('Avance7/onComprobarAvanceXControl'); ?>', {
                    CONTROL: Control.val()
                }).done(function (a) {
                    console.log(a);
                    if (a.length > 0) {
                        var r = a[0];
                        swal('ATENCIÓN', 'EL EMPLEADO ' + r.EMPLEADO + ' YA HA COBRADO ESTA FRACCION EN EL CONTROL ' + r.CONTROL + ' Y ESTA FUERA DE ESTE AVANCE', 'warning').then((value) => {
                            Control.val('').focus();
                        });
                    } else {
                        $.post('<?php print base_url('Avance7/getInfoXControl') ?>', {CONTROL: Control.val()}).done(function (a, b, c) {
                            var r = JSON.parse(a);
                            if (r.length > 0 && a.length > 0) {
                                Estilo.val(r[0].Estilo);
                                Pares.val(r[0].Pares);
                                /*OBTENER ULTIMO AVANCE*/
                                $.getJSON('<?php print base_url('Avance7/getUltimoAvanceXControl') ?>', {C: Control.val()}).done(function (aa, bb, cc) {
                                    if (aa.length > 0) {
                                        pnlTablero.find("#EstatusAvance").val(aa[0].DepartamentoT);
                                    }
                                }).fail(function (x, y, z) {
                                    console.log(x.responseText);
                                    swal('OPS', 'ALGO EXTRAÑO OCURRIO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                                });
                            } else {
                                Estilo.val('');
                                Pares.val('');
                                EstatusAvance.val('');
                                swal('ATENCIÓN', 'ESTE CONTROL NO ES VÁLIDO O NO TIENE FRACCIONES POR ESTILO', 'error').then((value) => {
                                    Control.focus().select();
                                });
                            }
                        }).fail(function (x, y, z) {
                            console.log(x.responseText);
                            swal('ERROR', ' ERROR AL OBTENER LO PAGADO AL EMPLEADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                        }).always(function () {

                        });
                    }
                });
            } else {
                if (pnlTablero.find("input[type='checkbox']:checked").length < 0) {
                    Control.focus().select();
                }
            }
        });

        btnAceptarXLS.click(function () {
            getReport(2);
        });
        btnAceptarPDF.click(function () {
            getReport(1);
        });

        btnAceptar.click(function () {
            if (pnlTablero.find("input[type='checkbox']:checked").length > 0 &&
                    Control.val() && Estilo.val() && Departamento.val()) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Guardando...'
                });
                onBeep(1);
                var f = new FormData();
                var fracciones = [];
                $.each(pnlTablero.find("input[type='checkbox']:checked"), function (k, v) {
                    fracciones.push({
                        NUMERO_FRACCION: $(v).attr('fraccion'),
                        DESCRIPCION: $(v).attr('description')
                    });
                });
                f.append('NUMERO_EMPLEADO', NumeroDeEmpleado.val());
                f.append('SEMANA', Semana.val());
                f.append('FECHA', Fecha.val());
                f.append('DEPARTAMENTO', Departamento.val());
                f.append('CONTROL', Control.val());
                f.append('ESTILO', Estilo.val());
                f.append('PARES', Pares.val());
                f.append('ANIO', pnlTablero.find("#Anio").val());
                f.append('FRACCIONES', JSON.stringify(fracciones));
                $.ajax({
                    url: '<?php print base_url('Avance7/onRevisarFraccionesPagadas'); ?>',
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: f
                }).done(function (a, b, c) {
                    if (a.length > 0) {
                        var pagado = parseInt($.isNumeric(a[0]) ? a[0] : 0);
                        if (pagado > 0) {
                            HoldOn.close();
                            swal('ATENCIÓN', 'UNA DE LAS FRACCIONES SELECCIONADAS YA HAN SIDO PAGADAS A ESTE CONTROL, ESCRIBA OTRO CONTROL O REVISE CON EL AREA CORRESPONDIENTE', 'warning').then((value) => {
                                Control.focus().select();
                            });
                        } else {
                            $.ajax({
                                url: '<?php print base_url('Avance7/onAvanzar'); ?>',
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: f
                            }).done(function (data, x, jq) {
                                console.log(data);
                                NumeroDeEmpleado.val('');
                                NombreEmpleado.val('');
                                $.each(pnlTablero.find("input[type='checkbox']:checked"), function (k, v) {
                                    $(this)[0].checked = false;
                                });
                                Semana.val('');
                                Fecha.val('');
                                Departamento.val('');
                                Control.val('');
                                Estilo.val('');
                                Pares.val('');
                                swal('ATENCIÓN', 'SE HAN GUARDADO LOS CAMBIOS', 'success');
                            }).fail(function (x, y, z) {
                                console.log(x.responseText);
                            }).always(function () {
                                HoldOn.close();
                            });
                        }
                    }
                }).fail(function (x, y, z) {
                    console.log(x.responseText);
                }).always(function () {
                    HoldOn.close();
                });
            } else {
                onBeep(2);
                swal('ATENCIÓN', 'DEBE DE SELECCIONAR AL MENOS UNA FRACCIÓN Y ESPECIFICAR UN CONTROL', 'warning');
            }
        });

        NumeroDeEmpleado.on('keydown', function (e) {
            Anio.val(new Date().getFullYear());
            if (e.keyCode === 13) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Revisando si el empleado cumple con los requisitos...'
                });
                $.getJSON('<?php print base_url('Avance7/onComprobarDeptoXEmpleado') ?>', {EMPLEADO: NumeroDeEmpleado.val()})
                        .done(function (data) {
                            if (data.length) {
                                var r = data[0];
                                NombreEmpleado.val(r.NOMBRE_COMPLETO);
                                Departamento.val(r.DEPTOCTO);
                                pnlTablero.find("#Avance").val(r.GENERA_AVANCE);
                                $.getJSON('<?php print base_url('Avance7/getSemanaByFecha'); ?>').done(function (data) {
                                    var rr = data[0];
                                    Semana.val(rr.Sem);
                                    Fecha.val(rr.Fecha);
                                    $.getJSON('<?php print base_url('Avance7/getPagosXEmpleadoXSemana'); ?>',
                                            {EMPLEADO: NumeroDeEmpleado.val(), SEMANA: Semana.val()}).done(function (a) {
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
                                    swal('ERROR', ' ERROR AL OBTENER LO PAGADO AL EMPLEADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
                                }).always(function () {

                                });
                            }
                        }).fail(function (x, y, z) {

                }).always(function () {
                    HoldOn.close();
                });
            }
        });

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
            "url": '<?php print base_url('Avance7/getFraccionesPagoNomina'); ?>',
            "type": "POST",
            "contentType": "application/json",
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val();
            }
        };
        Avance = tblAvance.DataTable(xoptions);

        pnlTablero.find("input[type='checkbox']").change(function () {
            if ($(this)[0].checked) {
                onBeep(3);
                Control.focus().select();
                pnlTablero.find("#ManoDeObra input[type='checkbox']:not(:checked)").parent().find("label.custom-control-label").removeClass("highlight");
                pnlTablero.find("#ManoDeObra input[type='checkbox']:checked").parent().find("label.custom-control-label").addClass("highlight");
            } else {
                onBeep(1);
                if (pnlTablero.find("input[type='checkbox']:checked").length <= 0) {
                    pnlTablero.find("#ManoDeObra label.custom-control-label").addClass("highlight");
                } else {
                    $(this).parent().find('label.custom-control-label').removeClass("highlight");
                }
            }
        });
        getDias();
    });

    function getReport(pdfxls) {

        HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
        var f = new FormData();
        f.append('CONTROL', Control.val());
        var url = "";
        switch (parseInt(pdfxls)) {
            case 1:
                url = '<?php print base_url('Avance7/getPDF'); ?>';
                break;
            case 2:
                url = '<?php print base_url('Avance7/getXLS'); ?>';
                break;
        }
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: f
        }).done(function (data, x, jq) {
            console.log(data);
            var ext = getExt(data);
            if (data.length > 0) {
                if (ext === "pdf" || ext === "PDF" || ext === "Pdf") {
                    $.fancybox.defaults.animationEffect = "zoom-in-out";
                    $.fancybox.open({
                        src: base_url + 'js/pdf.js-gh-pages/web/viewer.html?file=' + data + '#pagemode=thumbs',
                        type: 'iframe',
                        opts: {
                            afterShow: function (instance, current) {
                                console.info('done!');
                            },
                            iframe: {
                                // Iframe template
                                tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
                                preload: true,
                                // Custom CSS styling for iframe wrapping element
                                // You can use this to set custom iframe dimensions
                                css: {
                                    width: "95%",
                                    height: "95%"
                                },
                                // Iframe tag attributes
                                attr: {
                                    scrolling: "auto"
                                }
                            }
                        }
                    });
                } else if (ext === "xls" || ext === "XLS" || ext === "Xls") {
                    window.open(data, '_blank');
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTEN DOCUMENTOS PARA ESTE PROVEEDOR",
                    icon: "error"
                }).then((action) => {

                });
            }
            HoldOn.close();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
            HoldOn.close();
        });
    }

    function getDias() {
        var fracciones = '';
        dias.forEach(function (i) {
            fracciones += '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">' +
                    '<label>' + i + '</label>' +
                    '</div>' +
                    '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                    '<input type="text" id="txt' + i + '" name="txt' + i + '" class="form-control" placeholder="0"  style="font-weight: bold; text-align: center;" readonly="">' +
                    '</div>';
        });
        fracciones += '<div class="col-12"><hr></div><div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<label>TOTAL</label>' +
                '</div>' +
                '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' +
                '<input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control" placeholder="0"  style="font-weight: bold; text-align: center;">' +
                '</div>';
        DiasPagoDeNomina.html(fracciones);
    }

    function onActualizarAvances() {
        Avance.ajax.reload();
    }
</script>