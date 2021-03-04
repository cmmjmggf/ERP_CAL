<div class="card animated fadeIn" id="pnlTablero"style="border:none;">
    <div class="card-body " style="border:none; padding-top: 10px;">
        <div class="row">
            <div class="col-sm-12 text-center font-italic">
                 <h5><span class="fa fa-search"></span> Rastreo de controles en documentos</h5>
            </div> 
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-1">
                    <label class="font-italic">CONTROL</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly numeric " maxlength="9">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                    <label class="font-italic">ESTILO</label>
                    <div class="w-100"></div> 
                    <span class="clave_estilo selectize-input-lg font-italic b-lobo text-nowrap">-</span>
                    <input type="text" id="Estilo" name="Estilo" class="form-control d-none form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-9 col-xl-4">
                    <label class="font-italic">COLOR</label>
                    <div class="w-100"></div> 
                    <span class="clave_color selectize-input-lg font-italic b-lobo text-nowrap">-</span>
                    <input type="text" id="Color" name="Color" class="form-control form-control-sm d-none" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-1 col-xl-1">
                    <label class="font-italic">PARES</label>
                    <div class="w-100"></div> 
                    <span class="pares_del_control selectize-input-lg font-italic b-lobo">-</span> 
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm d-none" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-5">
                    <label class="font-italic">CLIENTE</label>
                    <div class="row">
                        <div class="col-12">
                            <span class="cliente_control selectize-input-lg font-italic b-lobo">-</span> 
                        </div>
                        <div class="col-3 d-none">
                            <input type="text" id="xCliente" name="xCliente" class="form-control form-control-sm numbersOnly notdot" readonly="" maxlength="15">
                        </div>
                        <div class="col-9 d-none">
                            <input type="text" id="Cliente" name="Cliente" class="form-control form-control-sm" readonly="" maxlength="600">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 m-3">
                <hr>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="col text-center">
                        <h6 class="font-weight-bold">FECHAS DEL PEDIDO</h6>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblFechasDelPedido" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Pedido</th>
                                <th scope="col">Entrega</th>
                                <th scope="col">Captura</th>
                                <th scope="col">Produ.</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="col text-center">
                        <h6 class="font-weight-bold">FECHAS DE FACTURACIÓN</h6>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblFechasDeFacturacion" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Factura</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">St</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <div class="col text-center">
                        <h6 class="font-weight-bold">FECHAS DEVOLUCIÓN</h6>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblFechasDevolucion" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Factura(s)</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="col text-center">
                        <h6 class="font-weight-bold">FECHAS DE AVANCE</h6>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblFechasDeAvance" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CONTROL</th>
                                <th scope="col">CORTE</th>
                                <th scope="col">RAYADO</th>
                                <th scope="col">FOLEADO</th>
                                <th scope="col">REBAJADO</th>
                                <th scope="col">ENTRETELADO</th>
                                <th scope="col">MAQUILA</th>
                                <th scope="col">ALM-CORTE</th>
                                <th scope="col">PESPUNTE</th>
                                <th scope="col">ENSUELADO</th>
                                <th scope="col">ALM-PESPUNTE</th>
                                <th scope="col">TEJIDO</th>
                                <th scope="col">ALM-TEJIDO</th>
                                <th scope="col">MONTADO</th>
                                <th scope="col">ADORNO</th>
                                <th scope="col">ALM-ADORNO</th>
                                <th scope="col">TERMINADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="col text-center">
                        <h6 class="font-weight-bold">RASTREO DE CONTROLES EN NOMINA</h6>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblRastreoDeControlesEnNomina" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estilo</th>
                                <th scope="col">Fraccion</th>
                                <th scope="col">Semana</th>
                                <th scope="col">Pares</th>
                                <th scope="col">Depto</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h6 class="font-weight-bold font-italic">ESTATUS EN PRODUCCIÓN</h6> 
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2 text-center">  
                            <span class="font-weight-bold font-italic estatus_de_avance_pfd" 
                                  style="background-color: #f44336;border-radius: 3px;
                                  font-weight: 600;    padding:  5px; color:#fff !important; 
                                  font-size: 36px;  color: #ffffff !important;  text-shadow: 3px 3px 3px #000000, 0 0 5px #000000;padding-left:  10px;padding-right: 10px; ">-</span>
                            <input type="text" id="EstatusProduccion" name="EstatusProduccion" class="form-control rojo d-none text-max" readonly="" >
                        </div>
                        <div class="w-100"></div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <label>Empleado</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" id="xEmpleado" name="xEmpleado" readonly="" class="form-control form-control-sm numbersOnly notdot" maxlength="8">
                                </div>
                                <div class="col-9">
                                    <input type="text" id="Empleado" name="Empleado" readonly="" class="form-control form-control-sm" maxlength="800">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                            <label>Fracción</label>
                            <input type="text" id="Fraccion" name="Fraccion" class="form-control form-control-sm    " readonly="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"), Control = pnlTablero.find("#Control"),
            Estilo = pnlTablero.find("#Estilo"), Color = pnlTablero.find("#Color"),
            xCliente = pnlTablero.find("#xCliente"),
            Cliente = pnlTablero.find("#Cliente"),
            EstatusProduccion = pnlTablero.find("#EstatusProduccion"),
            estatus_de_avance_pfd = pnlTablero.find(".estatus_de_avance_pfd"),
            xEmpleado = pnlTablero.find("#xEmpleado"),
            Empleado = pnlTablero.find("#Empleado"),
            Pares = pnlTablero.find("#Pares"),
            Fraccion = pnlTablero.find("#Fraccion"),
            FechasDelPedido, tblFechasDelPedido = pnlTablero.find("#tblFechasDelPedido"),
            FechasDeFacturacion, tblFechasDeFacturacion = pnlTablero.find("#tblFechasDeFacturacion"),
            FechasDevolucion, tblFechasDevolucion = pnlTablero.find("#tblFechasDevolucion"),
            FechasDeAvance, tblFechasDeAvance = pnlTablero.find("#tblFechasDeAvance"),
            RastreoDeControlesEnNomina, tblRastreoDeControlesEnNomina = pnlTablero.find("#tblRastreoDeControlesEnNomina");
    $(document).ready(function () {
        handleEnterDiv(pnlTablero);
        pnlTablero.find("input").addClass("font-weight-bold");
        Control.focus();
        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                onClear(xEmpleado);
                onClear(Empleado);
                onClear(Fraccion);
                getInfoXControl(Control.val());
            }
            if (e.keyCode === 8 && Control.val() === '' || e.keyCode === 13 && Control.val() === '') {
                FechasDelPedido.ajax.reload();
                FechasDeFacturacion.ajax.reload();
                FechasDevolucion.ajax.reload();
                RastreoDeControlesEnNomina.ajax.reload();
                FechasDeAvance.ajax.reload();

                estatus_de_avance_pfd.text('-');
                pnlTablero.find(".clave_estilo").text('-');
                pnlTablero.find(".clave_color").text('-');
                pnlTablero.find(".pares_del_control").text('-');
                pnlTablero.find(".cliente_control").text('-');
            }
            if (e.keyCode === 8 && Control.val() === '' || e.keyCode === 46 && Control.val() === '' ||
                    e.keyCode === 13 && Control.val() === '') {
                onClear(xEmpleado);
                onClear(Empleado);
                onClear(xEmpleado);
            }
        });

        /*DATATABLES*/
        var cols = [
            {"data": "ID"}/*0*/, {"data": "PEDIDO"}/*1*/,
            {"data": "ENTREGA"}/*2*/, {"data": "CAPTURA"},
            {"data": "PRODUCCION"}
        ];
        var coldefs = [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ];
        FechasDelPedido = tblFechasDelPedido.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentos/getPedidos'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val().trim() : '');
                }
            },
            "columns": cols,
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            ordering: true,
            "colReorder": true,
            "displayLength": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "150px",
            "scrollX": true
        });
        FechasDeFacturacion = tblFechasDeFacturacion.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentos/getFacturas'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val() : '');
                    d.CLIENTE = (Cliente.val() ? Cliente.val() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/,
                {"data": "FACTURA"}/*2*/, {"data": "FECHA"},
                {"data": "ESTATUS"}/*4*/
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            ordering: true,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "150px",
            "scrollX": true
        });
        FechasDevolucion = tblFechasDevolucion.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentos/getDevoluciones'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val() : '');
                    d.CLIENTE = (Cliente.val() ? Cliente.val().trim() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/,
                {"data": "FACTURA"}/*2*/, {"data": "FECHA"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            ordering: true,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "150px",
            "scrollX": true
        });
        FechasDeAvance = tblFechasDeAvance.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentos/getFechasDeAvance'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val().trim() : '');
                }
            },
            "columns": [
                {"data": "ID"}, /*0*/
                {"data": "CONTROL"}, /*1*/
                {"data": "CORTE"}, /*2*/
                {"data": "RAYADO"}, /*3*/
                {"data": "FOLEADO"}, /*5*/
                {"data": "REBAJADO"}, /*4*/
                {"data": "ENTRETELADO"}, /*6*/
                {"data": "MAQUILA"}, /*7*/
                {"data": "ALM-CORTE"}, /*8*/
                {"data": "PESPUNTE"}, /*9*/
                {"data": "ENSUELADO"}, /*10*/
                {"data": "ALM-PESP"}, /*11*/
                {"data": "TEJIDO"}, /*12*/
                {"data": "ALM-TEJIDO"}, /*13*/
                {"data": "MONTADO"}, /*14*/
                {"data": "ADORNO"}, /*15*/
                {"data": "ALM-ADORNO"}, /*16*/
                {"data": "TERMINADO"} /*17*/

            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            select: true,
            "autoWidth": true,
            ordering: true,
            "colReorder": true,
            "displayLength": 25,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "75px",
            "scrollX": true
        });
        RastreoDeControlesEnNomina = tblRastreoDeControlesEnNomina.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentos/getControlesEnNomina'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val().trim() : '');
                    d.EMPLEADO = '';
                    d.FRACCION = (Fraccion.val() ? Empleado.val().trim() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "EMPLEADO"}/*1*/,
                {"data": "CONTROL"}/*2*/,
                {"data": "FECHA"},
                {"data": "ESTILO"},
                {"data": "NUM_FRACCION"},
                {"data": "SEMANA"},
                {"data": "PARES"},
                {"data": "DEPTO"}
            ],
            "columnDefs": coldefs,
            language: lang,
            select: true,
            "autoWidth": true,
            ordering: true,
            "colReorder": true,
            "displayLength": 25,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [3, 'DESC']
            ],
            "scrollY": "250px",
            "scrollX": true
        });
        tblRastreoDeControlesEnNomina.find('tbody').on('click', 'tr', function () {
            if (Control.val()) {
                var r = RastreoDeControlesEnNomina.row($(this)).data();
                console.log('ROW ', r);
                xEmpleado.val(r.EMPLEADO);
                Empleado.val(r.NOM_EMPLEADO);
                Fraccion.val(r.FRACCION);
            } else {
                swal('ATENCIÓN', 'DEBE DE ESPECIFICAR UN CONTROL', 'warning').then((value) => {
                    Control.focus();
                });
            }
        });
    });

    var intento = 1;
    function getInfoXControl(e) {
        if (e) {
            $.getJSON("<?php print base_url('RastreoDeControlesEnDocumentos/getInfoXControl') ?>", {CONTROL: e}).done(function (x, y, z) {
                if (x.length > 0) {
                    var xx = x[0];
                    Estilo.val(xx.Estilo);
                    pnlTablero.find(".clave_estilo").text(xx.Estilo);
                    Color.val(xx.Color + ' ' + xx.ColorT);
                    pnlTablero.find(".clave_color").text(xx.Color + ' ' + xx.ColorT);
                    Pares.val(xx.Pares);
                    pnlTablero.find(".pares_del_control").text(xx.Pares);
                    pnlTablero.find(".cliente_control").text(xx.Cliente + ' ' + xx.ClienteT);
                    xCliente.val(xx.Cliente);
                    Cliente.val(xx.ClienteT);
                    EstatusProduccion.val(xx.EstatusProduccion);
                    estatus_de_avance_pfd.text(xx.EstatusProduccion);
                    Control.focus().select();
                    FechasDelPedido.ajax.reload();
                    FechasDeFacturacion.ajax.reload();
                    FechasDevolucion.ajax.reload();
                    RastreoDeControlesEnNomina.ajax.reload();
                    FechasDeAvance.ajax.reload();
                } else {
                    if (intento < 10) {
                        onCampoInvalido(pnlTablero, "ESTE CONTROL NO EXISTE(" + intento + " de 10)", function () {
                            Control.focus().select();
                            intento += 1;
                        });
                    } else {
                        intento = 1;
                        onCampoInvalido(pnlTablero, "ESTE CONTROL NO EXISTE(" + intento + " de 10)", function () {
                            location.reload();
                        });
                    }
                }
            }).fail(function (x, y, z) {
                getError(x);
            }).always(function () {
                HoldOn.close();
            });
        } else {
            Control.focus().select();
        }
    }
</script>
<style>
    .text-max {
        font-weight: bolder;
        font-size: 22px;
    }


    .rojo {
        background-color: #FFBEAC !important;

    }
    .b-lobo{
        font-size: 26px;  color: #ffffff !important; 
        font-weight: bold; text-shadow: 3px 3px 3px #000000, 0 0 5px #000000;
        background-color: #3F51B5; 
        padding-top: 5px; padding-right: 10px;
        padding-bottom: 5px; padding-left: 10px;
        border-radius: 10px; margin-top: 5px;
    }
    table tbody td {
        font-size: 18px !important;
    }
</style>