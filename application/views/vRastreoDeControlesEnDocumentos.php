<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de controles en documentos</legend>
            </div>
            <div class="col-sm-6 float-right" align="right"></div>
        </div>
        <hr>
        <div class="card-block">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">
                    <label>Estilo</label>
                    <input type="text" id="Estilo" name="Estilo" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Color</label>
                    <input type="text" id="Color" name="Color" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-1">
                    <label>Pares</label>
                    <input type="text" id="Pares" name="Pares" class="form-control form-control-sm" readonly="">
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <label>Cliente</label>
                    <div class="row">
                        <div class="col-3">
                            <input type="text" id="xCliente" name="xCliente" class="form-control form-control-sm numbersOnly notdot" readonly="" maxlength="15">
                        </div>
                        <div class="col-9">
                            <input type="text" id="Cliente" name="Cliente" class="form-control form-control-sm" readonly="" maxlength="600">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
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
                                <th scope="col">Corte</th>
                                <th scope="col">Rayado</th>
                                <th scope="col">Foleado</th>
                                <th scope="col">Rebajado</th>
                                <th scope="col">Entretelado</th>
                                <th scope="col">Maq</th>
                                <th scope="col">Alm-Corte</th>
                                <th scope="col">Pespunte</th>
                                <th scope="col">Ensuelado</th>
                                <th scope="col">Alm-Pespunte</th>
                                <th scope="col">Tejido</th>
                                <th scope="col">Alm-Tejido</th>
                                <th scope="col">Montado</th>
                                <th scope="col">Adorno</th>
                                <th scope="col">Alm-Adorno</th>
                                <th scope="col">Terminado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="w-100"></div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
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
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label>Estatus en producción</label>
                            <input type="text" id="EstatusProduccion" name="EstatusProduccion" class="form-control rojo text-max" readonly="" >
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
        Control.focus();
        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                getInfoXControl(Control.val());
            } else {
                FechasDelPedido.ajax.reload();
                FechasDeFacturacion.ajax.reload();
                FechasDevolucion.ajax.reload();
                RastreoDeControlesEnNomina.ajax.reload();
                FechasDeAvance.ajax.reload();
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
                    d.CLIENTE = (Cliente.val() ? Cliente.val().trim() : '');
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
            "scrollY": "150px",
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


    function getInfoXControl(e) {
        if (e) {
            $.getJSON("<?php print base_url('RastreoDeControlesEnDocumentos/getInfoXControl') ?>", {CONTROL: e}).done(function (x, y, z) {
                if (x.length > 0) {
                    var xx = x[0];
                    Estilo.val(xx.Estilo);
                    Color.val(xx.Color + ' ' + xx.ColorT);
                    Pares.val(xx.Pares);
                    xCliente.val(xx.Cliente);
                    Cliente.val(xx.ClienteT);
                    EstatusProduccion.val(xx.EstatusProduccion);
                    Control.focus().select();
                    FechasDelPedido.ajax.reload();
                    FechasDeFacturacion.ajax.reload();
                    FechasDevolucion.ajax.reload();
                    RastreoDeControlesEnNomina.ajax.reload();
                    FechasDeAvance.ajax.reload();
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
</style>