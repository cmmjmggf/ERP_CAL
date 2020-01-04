<div class="card m-2" id="pnlTablero">
    <div class="card-body" style="padding-top: 10px;    padding-bottom: 10px;">
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
            <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                <input type="text"  style="height: 50px; font-weight: bold; font-size: 45px;"  id="NumeroDeEmpleado" name="NumeroDeEmpleado" class="form-control form-control-sm shadow-lg numeric" maxlength="8" style="height: 50px; font-weight: bold; font-size: 25px;" autofocus="" data-toggle="tooltip" data-placement="bottom" title="Ingrese un empleado del depto de corte">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-10 col-xl-10 text-center">
                <h1 style="color: #c1850c !important;" class="nombre_empleado">-</h1>
                <input type="text" id="NombreEmpleado" name="NombreEmpleado" class="form-control form-control-sm d-none" placeholder="-" disabled="" style="height: 50px; font-weight: bold; font-size: 25px; text-align: center;">
            </div>
            <!--FIN BLOQUE 2 COL 6-->
            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" align="center">
                <h4>FRACCIONES DE ESTE EMPLEADO</h4>
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

                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
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
                        <input type="text" id="Semana" name="Semana" readonly="" class="form-control form-control-sm  numeric" maxlength="2">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                        <label>Fecha</label>
                        <input type="text" id="Fecha" name="Fecha" class="form-control form-control-sm  " readonly="">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Departamento</label>
                        <input type="text" id="Departamento" name="Departamento" readonly="" class="form-control form-control-sm numeric " maxlength="3">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <label>Control</label>
                        <input type="text" id="Control" name="Control" style="height: 50px; font-weight: bold; font-size: 45px;" class="form-control form-control-sm  numeric" maxlength="10">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Estilo</label>
                        <h1 style="color: #c1850c !important;" class="estilo_control">-</h1>
                        <input type="text" id="Estilo" name="Estilo" readonly=""  class="form-control form-control-sm d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Pares</label>
                        <h1 style="color: #c1850c !important;"  class="pares_control">-</h1>
                        <input type="text" id="Pares" name="Pares" readonly=""  class="form-control form-control-sm  numeric  d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        <label>Avance</label>
                        <h1 style="color: #c1850c !important;"  class="avance_control">-</h1>
                        <input type="text" id="Avance" name="Avance" readonly=""  class="form-control form-control-sm  numeric d-none">
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 mx-auto d-none">
                        <button type="button" class="btn btn-success mt-3" id="btnAceptar" name="btnAceptar" data-toggle="tooltip" data-placement="top" title="Aceptar"><span class="fa fa-check"></span></button>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div id="ManoDeObra" class="col-6">

                        <label class="text-danger">Seleccione Fracción</label>
                        <div  class="row  bg-danger text-white" style="border-radius: 5px; height: 435px; overflow-y: auto;" >
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk51" description="ENTRETELADO" fraccion="51">
                                    <label class="custom-control-label" for="chk51">51 Entretelado</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk70" description="TROQUELAR PLANTILLA" fraccion="70">
                                    <label class="custom-control-label" for="chk70">70 Troquelar plantilla</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk60" description="FOLEAR CORTE Y CALIDAD" fraccion="60">
                                    <label class="custom-control-label" for="chk60">60 Folear corte y calidad</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk61" description="FOLEADO MUESTRA" fraccion="61">
                                    <label class="custom-control-label" for="chk61">61 Foleado muestra</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk62" description="SERIGRAFIA FORRO" fraccion="62">
                                    <label class="custom-control-label" for="chk62">62 Serigrafia forro</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk24" description="DOMAR" fraccion="24">
                                    <label class="custom-control-label" for="chk24">24 Domar</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk78" description="LIMPIA LASER" fraccion="78">
                                    <label class="custom-control-label" for="chk78">78 Limpia laser</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk204" description="EMPALMAR PARA LASER" fraccion="204">
                                    <label class="custom-control-label" for="chk204">204 Empalmar p/laser</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk205" description="APLICA PEGA PARA LASER" fraccion="205">
                                    <label class="custom-control-label" for="chk205">205 Aplica pega.p/laser</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk198" description="LOTEAR PARA LASER" fraccion="198">
                                    <label class="custom-control-label" for="chk198">198 Lotear p/laser</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk127" description="ENTRETELAR MUESTRA" fraccion="127">
                                    <label class="custom-control-label" for="chk127">127 Entretelar muestra</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk80" description="CONTAR TAREA" fraccion="80">
                                    <label class="custom-control-label" for="chk80">80 Contar tarea</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk397" description="JUNTAR SUELA A CORTE" fraccion="397">
                                    <label class="custom-control-label" for="chk397">397 Juntar suela a corte</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk34" description="PEGAR TRANSFER" fraccion="34">
                                    <label class="custom-control-label" for="chk34">34 Pegar transfer</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk106" description="DOBLILLADO" fraccion="106">
                                    <label class="custom-control-label" for="chk106">106 Doblillado</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk306" description="FORRAR PLATAFORMA" fraccion="306">
                                    <label class="custom-control-label" for="chk306">306 Forrar plataforma</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk337" description="RECORTAR FORRO LASER" fraccion="337">
                                    <label class="custom-control-label" for="chk337">337 Recortar forro laser</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk333" description="PONER CASCO PESPUNTE" fraccion="333">
                                    <label class="custom-control-label" for="chk333">333 Poner casco pespunte</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk502" description="PEGADO DE SUELA" fraccion="502">
                                    <label class="custom-control-label" for="chk502">502 Pegado de suela</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk72" description="TROQUELAR NORMA" fraccion="72">
                                    <label class="custom-control-label" for="chk72">72 Troquelar norma</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk607" description="ARMAR PLANTILLA ADORNO" fraccion="607">
                                    <label class="custom-control-label" for="chk607">607 Armar plantilla adorno</label>
                                </div>
                            </div> 
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk606" description="ARMAR PLANT AD MUEST" fraccion="606">
                                    <label class="custom-control-label" for="chk606">606 Armar plant.ad.muest</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="text-info">Pago de Nómina</label>
                        <div id="DiasPagoDeNomina" class="row">
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>JUEVES</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtJUEVES" name="txtJUEVES" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>VIERNES</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtVIERNES" name="txtVIERNES" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>SABADO</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtSABADO" name="txtSABADO" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>DOMINGO</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtDOMINGO" name="txtDOMINGO" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>LUNES</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtLUNES" name="txtLUNES" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>MARTES</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtMARTES" name="txtMARTES" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-1">
                                <label>MIERCOLES</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtMIERCOLES" name="txtMIERCOLES" readonly="" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;" readonly="">
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <label>TOTAL</label>
                            </div>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="txtTotal" disabled="" name="txtTotal" class="form-control form-control-sm" placeholder="0" style="font-weight: bold;">
                            </div>
                        </div>
                        <div class="w-100 my-2"></div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none" align="center">
                            <h4 class="text-danger">Estatus actual del avance</h4>
                            <input type="text" id="EstatusAvance" name="EstatusAvance" class="form-control form-control-sm ">
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                            <span class="font-weight-bold" style="color : #3F51B5 !important;">ESTATUS ACTUAL DEL AVANCE </span>  
                            <div class="w-100"></div>
                            <span class="font-weight-bold estatus_de_avance" style="color : #ef1000 !important">-</span>
                         </div>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-2 d-none">
                        <div class="row">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="GeneraAvance" name="GeneraAvance" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="text" id="Depto" name="Depto" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div> 
                    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
                        <label>MO</label>
                        <input type="text" id="ManoDeOB" name="ManoDeOB" class="form-control form-control-sm  numeric" readonly="">
                        <label>AN</label>
                        <input type="text" id="Anio" name="Anio" class="form-control form-control-sm  numeric" readonly="">
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
            estatus_de_avance = pnlTablero.find("span.estatus_de_avance"),
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
        var fff = "";
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            fff += $(v).attr('fraccion') + ",";
        });
        console.log(fff);
        Semana.val('<?php print $SP[0]->Semana; ?>');
        Fecha.val('<?php print $F; ?>');
        handleEnter();

        btnAceptar.click(function () {
            onAgregarAvance();
        });

        Anio.val(new Date().getFullYear());

        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {

                getInfoXControl(onAgregarAvance);
            } else {
                Estilo.val('');
                Pares.val('');
                SigAvance.val('');
                DiasPagoDeNomina.find("input").val(0);
                DiasPagoDeNomina.find("#txtTotal").val(0);
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
            Control.focus().select();
        });

        NumeroDeEmpleado.on('keydown', function (e) {
            if (e.keyCode === 13) {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: 'Revisando si el empleado cumple con los requisitos...'
                });
                Avance.ajax.reload();
                $.post('<?php print base_url('Avance8/onComprobarDeptoXEmpleado') ?>', {EMPLEADO: NumeroDeEmpleado.val()})
                        .done(function (data) {
                            var dt = JSON.parse(data);
                            if (dt.length > 0) {
                                var r = dt[0];
                                GeneraAvance.val(r.GENERA_AVANCE);
                                Depto.val(r.DEPTO);
                                NombreEmpleado.val(r.NOMBRE_COMPLETO);
                                pnlTablero.find(".nombre_empleado").text(dt[0].NOMBRE_COMPLETO);
                                Departamento.val(r.DEPTOCTO);
                                $.getJSON('<?php print base_url('Avance8/getSemanaByFecha'); ?>').done(function (data) {
                                    var rr = data[0];
                                    Semana.val((data.length > 0) ? rr.Sem : '');
                                    Fecha.val((data.length > 0) ? rr.Fecha : '');
                                    getPagosXEmpleadoXSemana();
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
                                pnlTablero.find(".nombre_empleado").text('');
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
            "scrollY": "490px",
            "scrollX": true,
            createdRow: function (row, data, dataIndex) {
            }
        };
        xoptions.ajax = {
            "url": '<?php print base_url('Avance8/getFraccionesPagoNomina'); ?>',
            "dataSrc": "",
            "data": function (d) {
                d.EMPLEADO = NumeroDeEmpleado.val() ? NumeroDeEmpleado.val() : '';
                d.SEMANA = Semana.val() ? Semana.val() : '';
                d.FRACCIONES = "51,70,60,61,62,24,78,204,205,198,127,80,397,34,106,306,337,333,502,72,607,606";
            }
        };
        $.fn.dataTable.ext.errMode = 'throw';
        Avance = tblAvance.DataTable(xoptions);
    });

    function onAgregarAvance() {
        var cks = pnlTablero.find("input[type='checkbox']:checked");
        var fra = cks.attr('fraccion');
        console.log("FRACCION * ", fra);




        var fracciones = [];
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(this)[0].checked) {
                fracciones.push({
                    NUMERO_FRACCION: $(v).attr('fraccion'),
                    DESCRIPCION: $(v).attr('description')
                });
            }
        });
//        console.log(fracciones, JSON.stringify(fracciones));


        if (cks.length > 0) {
            if (Control.val()) {
                $.getJSON('<?php print base_url('Avance8/onComprobarFraccionXEstilo'); ?>',
                        {CONTROL: Control.val(), FRACCIONES: JSON.stringify(fracciones)}).done(function (a) {
                    console.log(a, a.FRACCIONES_VALIDAS, fracciones.length);
                    if (parseInt(a.FRACCIONES_VALIDAS) < fracciones.length) {
                        iMsg(a.FALTAN + ' DE LAS FRACCIONES SELECCIONADAS NO CORRESPONDEN A ESTE ESTILO', 'w', function () {
                            Control.focus().select();
                        });
                    } else {
                        Estilo.val(a.ESTILO);
                        Pares.val(a.PARES);
                        pnlTablero.find(".estilo_control").text(a.ESTILO);
                        pnlTablero.find(".pares_control").text(a.PARES);
                        $.getJSON('<?php print base_url('Avance9/getUltimoAvanceXControl'); ?>',
                                {C: Control.val()}).done(function (data) {
                            var x = data[0];
                            if (data.length > 0) {
                                SigAvance.val(x.Departamento);
                                EstatusAvance.val(x.DepartamentoT);
                                estatus_de_avance.text(x.DepartamentoT);
                                pnlTablero.find(".avance_control").text(x.Departamento);
                                onAvanzar();
                            }
                        });

                    }
//                    if (a.length > 0) {
//                        var r = a[0];
//                        Estilo.val(r.Estilo);
//                        Pares.val(r.Pares);
//                        ManoDeOB.val(r.CostoMO);
//                        $.getJSON('<?php print base_url('Avance8/getUltimoAvanceXControl'); ?>', {C: Control.val()}).done(function (b) {
//                            if (b.length > 0) {
//                                SigAvance.val(b[0].Departamento);
//                                EstatusAvance.val(b[0].DepartamentoT);
//                                var d = new Date();
//                                var n = d.getDay();
//                                DiasPagoDeNomina.find("#txt" + ndias[n - 1]).val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
//                                var tt = 0;
//                                ndias.forEach(function (i) {
//                                    tt += parseFloat(pnlTablero.find("#txt" + i).val());
//                                });
//                                DiasPagoDeNomina.find("#txtTotal").val(parseFloat(r.Pares) * parseFloat(r.CostoMO));
//                                onAvanzar();
//                            }
//                        }).fail(function (x, y, z) {
//                            console.log(x.responseText);
//                            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, REVISE LA CONSOLA PARA MÁS DETALLE', 'error');
//                        }).always(function () {
//                            HoldOn.close();
//                        });
//                    } else {
//                        swal('ATENCIÓN', 'LA FRACCIÓN O EL CONTROL NO SON CORRECTAS, ELIJA OTRA FRACCIÓN O ESPECIFIQUE UN CONTROL CON LA FRACCIÓN SELECCIONADA', 'error').then((value) => {
//                            Control.focus().select();
//                            Estilo.val('');
//                            Pares.val('');
//                            SigAvance.val('');
//                        });
                    //                    }
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

    var fracciones = [51, 70, 60, 61, 62, 24, 78, 204, 205, 198, 127, 80, 397, 34, 106, 306, 337, 333, 502, 72, 607, 606];

    function onCheckFraccion(e) {
//        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
//            if ($(e)[0].id !== $(v)[0].id) {
//                $(v)[0].checked = false;
//            }
        //        });
    }

    function onClearMO() {
        Control.focus().select();
        Estilo.val('');
        Pares.val('');
        SigAvance.val('');
//        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
//            $(v)[0].checked = false;
//        });
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

        var fracciones = [], xfracciones = [];
        $.each(pnlTablero.find("input[type='checkbox']"), function (k, v) {
            if ($(v)[0].checked) {
                xfracciones.push({
                    NUMERO_FRACCION: parseInt($(v).attr('fraccion')),
                    DESCRIPCION: $(v).attr('description')
                });
            }
        });

        if (pnlTablero.find("#chk606")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 606,
                DESCRIPCION: "ARMAR PLANT AD MUESTRA"
            });
        }
        if (pnlTablero.find("#chk34")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 34,
                DESCRIPCION: "PEGAR TRANSFER"
            });
        }
        if (pnlTablero.find("#chk607")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 607,
                DESCRIPCION: "ARMAR PLANTILLA ADORNO"
            });
        }
        if (pnlTablero.find("#chk72")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 72,
                DESCRIPCION: "TROQUELAR NORMA"
            });
        }
        if (pnlTablero.find("#chk502")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 502,
                DESCRIPCION: "PEGADO DE SUELA"
            });
        }
        if (pnlTablero.find("#chk333")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 333,
                DESCRIPCION: "PONER CASCO A PESPUNTE"
            });
        }
        if (pnlTablero.find("#chk337")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 337,
                DESCRIPCION: "RECORTAR FORRO LASER"
            });
        }

        if (pnlTablero.find("#chk306")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 306,
                DESCRIPCION: "FORRAR PLATAFORMA"
            });
        }
        if (pnlTablero.find("#chk106")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 106,
                DESCRIPCION: "DOBLILLADO"
            });
        }
        if (pnlTablero.find("#chk80")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 80,
                DESCRIPCION: "CONTAR TAREA"
            });
        }
        if (pnlTablero.find("#chk127")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 127,
                DESCRIPCION: "ENTRETELAR MUESTRA"
            });
        }
        if (pnlTablero.find("#chk198")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 198,
                DESCRIPCION: "LOTEAR PARA LASER"
            });
        }
        if (pnlTablero.find("#chk205")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 205,
                DESCRIPCION: "APLICA PEGA PARA LASER"
            });
        }
        if (pnlTablero.find("#chk204")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 204,
                DESCRIPCION: "EMPALMAR PARA LASER"
            });
        }
        if (pnlTablero.find("#chk78")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 78,
                DESCRIPCION: "LIMPIA LASER"
            });
        }
        if (pnlTablero.find("#chk24")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 24,
                DESCRIPCION: "DOMAR"
            });
        }
        if (pnlTablero.find("#chk62")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 62,
                DESCRIPCION: "SERIGRAFIA FORRO"
            });
        }
        if (pnlTablero.find("#chk61")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 61,
                DESCRIPCION: "FOLEADO MUESTRA"
            });
        }
        if (pnlTablero.find("#chk60")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 60,
                DESCRIPCION: "FOLEAR CORTE Y CALIDAD"
            });
        }
        if (pnlTablero.find("#chk70")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 70,
                DESCRIPCION: "TROQUELAR PLANTILLA"
            });
        }
        /*AVANZA EL CONTROL A ENTRETELADO A ALMACEN DE CORTE*/
        if (pnlTablero.find("#chk51")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 51,
                DESCRIPCION: "ENTRETELADO"
            });
        }
        /*AVANZA EL CONTROL A ENSUELADO*/
        if (pnlTablero.find("#chk397")[0].checked) {
            fracciones.push({
                NUMERO_FRACCION: 397,
                DESCRIPCION: "JUNTAR SUELA A CORTE"
            });
        }
        AVANO.FRACCIONES = JSON.stringify(fracciones);

        $.post('<?php print base_url('Avance8/onAgregarAvanceXEmpleadoYPagoDeNomina') ?>', AVANO).done(function (c) {
            var dt = JSON.parse(c);
            if (c !== undefined && c.length > 0) {
                if (dt.AVANZO > 0) {
                    onNotifyOld('<span class="fa fa-check"></span>', 'SE HA HECHO EL PAGO DE LA(S) FRACCION(ES)', 'success');
                    onClearMO();
                    Control.focus().select();
                    onBeep(5);
                } else {
                    onBeep(2);
                    Avance.ajax.reload();
                    swal('ATENCIÓN', 'ESTE CONTROL (' + Control.val() + ') YA TIENE UN AVANCE EN ESTA FRACCIÓN, POR FAVOR ESPECIFIQUE UN CONTROL DIFERENTE O UNA FRACCIÓN DIFERENTE, DE LO CONTRARIO REVISE CON EL AREA CORRESPONDIENTE', 'warning').then((value) => {
                        onClearMO();
                        Control.val('');
                        Control.focus().select();
                    });
                }
            }
        }).fail(function (x, y, z) {
            console.log(x.responseText);
        }).always(function () {
            Avance.ajax.reload();
            getPagosXEmpleadoXSemana();
        });
    }
    function getInfoXControl(f) {
        $.getJSON('<?php print base_url('Avance8/getInfoXControl'); ?>', {
            CONTROL: Control.val()
        }).done(function (a) {
            console.log(a, a.length)
            var r = a[0];
            Estilo.val(r.ESTILO);
            Pares.val(r.PARES);
            SigAvance.val(r.DEPTOAVANCE);
            pnlTablero.find(".estilo_control").text(r.ESTILO);
            pnlTablero.find(".pares_control").text(r.PARES);
            pnlTablero.find(".avance_control").text(r.DEPTOAVANCE); 
            estatus_de_avance.text(r.ESTATUS_PRODUCCION);
            f();
        });
    }
    function getTotalPagado() {
        ndias.forEach(function (e) {
            console.log(e);
        });
    }
    function getPagosXEmpleadoXSemana() {
        $.getJSON('<?php print base_url('Avance8/getPagosXEmpleadoXSemana'); ?>',
                {EMPLEADO: NumeroDeEmpleado.val(), SEMANA: Semana.val(), FRACCIONES: "51,70,60,61,62,24,78,204,205,198,127,80,397,34,106,306,337,333,502,72,607,606"}).done(function (a) {
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
    table tbody tr {
        font-size: 0.75rem !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    label {
        margin-top: 0.0rem;
        margin-bottom: 0.0rem;
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
</style>