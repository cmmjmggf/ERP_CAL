<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Rastreo de controles en documentos(Facturado y devuelto)</legend>
            </div>
            <div class="col-sm-6 float-right" align="right"></div>
        </div>
        <div class="card-block">
            <div class="row  mb-2">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <label>Control</label>
                    <input type="text" id="Control" name="Control" class="form-control form-control-sm numbersOnly" autofocus="">
                </div> 
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6"></div> 
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                    <label>Docto</label>
                    <input type="text" id="Docto" name="Docto" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                    <div class="col text-center">
                        <p class="font-weight-bold text-danger font-italic">FACTURADOS</p>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblFacturados" class="table table-sm table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Docto</th>
                                <th scope="col">TP</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Pares</th>
                                <th scope="col">Estilo</th>
                                <th scope="col">Color</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table> 
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                    <div class="row">
                        <div class="col-12 text-center mt-3">
                            <h4 class="font-weight-bold font-italic">Pares</h4>
                        </div>
                        <div class="col-12">
                            <label>Fabricados</label>
                            <input type="text" id="ParesFabricados" name="ParesFabricados" class="form-control" readonly="">
                        </div>
                        <div class="col-12">
                            <label>Vendidos</label>
                            <input type="text" id="ParesVendidos" name="ParesVendidos" class="form-control" readonly="">
                        </div>
                        <div class="col-12">
                            <label>Cancelados</label>
                            <input type="text" id="ParesCancelados" name="ParesCancelados" class="form-control" readonly="">
                        </div>
                        <div class="col-12">
                            <label>Devueltos</label>
                            <input type="text" id="ParesDevueltos" name="ParesDevueltos" class="form-control" readonly="">
                        </div>
                        <div class="col-12">
                            <label>Sts</label>
                            <input type="text" id="ParesEstatus" name="ParesEstatus" class="form-control" readonly="">
                        </div>
                        <div class="col-12">
                            <label>Fac</label>
                            <input type="text" id="ParesFacturados" name="ParesFacturados" class="form-control" readonly="">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                    <div class="col text-center">
                        <p class="font-weight-bold text-danger font-italic">DEVOLUCIONES</p>
                    </div>
                    <div class="w-100"></div>
                    <table id="tblDevoluciones" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Control</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Pares</th>
                                <th scope="col">Estilo</th>
                                <th scope="col">Color</th>
                                <th scope="col">Cart</th>
                                <th scope="col">Fac</th>
                                <th scope="col">Maq</th>
                                <th scope="col">Cargo</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                    <div class="w-100 my-3"></div>
                    <p class="font-weight-bold">Ordernar por</p>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rDocto" name="rOrdenar" class="custom-control-input" tipo="1">
                            <label class="custom-control-label" for="rDocto">Docto</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rFecha" name="rOrdenar" class="custom-control-input" tipo="2">
                            <label class="custom-control-label" for="rFecha">Fecha</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="rEstilo" name="rOrdenar" class="custom-control-input" tipo="3">
                            <label class="custom-control-label" for="rEstilo">Estilo</label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <button type="button" id="btnMovimientosClientes" name="btnMovimientosClientes" class="btn btn-info btn-block font-weight-bold">
                        MOVIMIENTOS
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var pnlTablero = $("#pnlTablero"),
            Docto = pnlTablero.find("#Docto"),
            Control = pnlTablero.find("#Control"),
            ParesFabricados = pnlTablero.find("#ParesFabricados"),
            ParesVendidos = pnlTablero.find("#ParesVendidos"),
            ParesCancelados = pnlTablero.find("#ParesCancelados"),
            ParesDevueltos = pnlTablero.find("#ParesDevueltos"),
            ParesEstatus = pnlTablero.find("#ParesEstatus"),
            ParesFacturados = pnlTablero.find("#ParesFacturados"),
            Facturados, tblFacturados = pnlTablero.find("#tblFacturados"),
            Devoluciones, tblDevoluciones = pnlTablero.find("#tblDevoluciones"),
            OrdenDevs = 0, btnMovimientosClientes = pnlTablero.find("#btnMovimientosClientes");

    $(document).ready(function () {

        Control.focus();

        btnMovimientosClientes.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente'); ?>');
        });

        pnlTablero.find("input[name='rOrdenar']").change(function () {
            if (pnlTablero.find("input[name='rOrdenar']:checked")) {
                onOpenOverlay('Ordenando...');
                Facturados.ajax.reload(function () {
                    onCloseOverlay();
                });
            } else {
                console.log(pnlTablero.find("input[name='rOrdenar']"));
            }
        });

        Docto.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                onOpenOverlay('Buscando documento...');
                Facturados.ajax.reload(function () {
                    onCloseOverlay();
                });
            }
        });
        Control.on('keydown', function (e) {
            if (e.keyCode === 13 && Control.val()) {
                getInfoXControl(Control.val());
            } else if (Control.val().length <= 0) {
                Facturados.ajax.reload();
                Devoluciones.ajax.reload();
                ParesFabricados.val('');
                ParesFacturados.val('');
                ParesVendidos.val('');
                ParesCancelados.val('');
                ParesDevueltos.val('');
                ParesEstatus.val('');
            }
        });

        /*DATATABLES*/
        Facturados = tblFacturados.DataTable({
            "dom": 'ritp',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentosClientes/getFacturas'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.DOCTO = (Docto.val() ? Docto.val() : '');
                    d.CONTROL = (Control.val() ? Control.val().trim() : '');
                    d.ORDEN = parseInt(pnlTablero.find("input[name='rOrdenar']:checked").attr('tipo')) !== 0 ? parseInt(pnlTablero.find("input[name='rOrdenar']:checked").attr('tipo')) : 0;
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "DOCUMENTO"}/*1*/,
                {"data": "TP"}/*2*/, {"data": "CLIENTE"},
                {"data": "CONTROL"}/*4*/, {"data": "FECHA"},
                {"data": "PARES"}/*6*/, {"data": "ESTILO"},
                {"data": "COLOR"}/*6*/, {"data": "PRECIO"},
                {"data": "SUBTOTAL"}/*6*/, {"data": "ESTATUS_PEDIDO"}
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
            ordering: false,
            "colReorder": true,
            "displayLength": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true
        });
//        TestThisJSONURL('<?php print base_url('RastreoDeControlesEnDocumentosClientes/getDevoluciones'); ?>');
        Devoluciones = tblDevoluciones.DataTable({
            "dom": 'rit',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('RastreoDeControlesEnDocumentosClientes/getDevoluciones'); ?>',
                "contentType": "application/json",
                "dataSrc": "",
                "data": function (d) {
                    d.CONTROL = (Control.val() ? Control.val().trim() : '');
                }
            },
            "columns": [
                {"data": "ID"}/*0*/, {"data": "CLIENTE"}/*1*/,
                {"data": "CONTROL"}/*2*/, {"data": "FECHA"},
                {"data": "PARES"}, {"data": "ESTILO"},
                {"data": "COLOR"}, {"data": "CART"},
                {"data": "FAC"}, {"data": "MAQUILA"},
                {"data": "CARGO"}
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
            ordering: false,
            "colReorder": true,
            "displayLength": 99999999,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "scrollY": "250px",
            "scrollX": true
        });
    });

    function getInfoXControl(e) {
        if (e) {
            onOpenOverlay('Espere un momento por favor...');
            $.getJSON("<?php print base_url('RastreoDeControlesEnDocumentosClientes/getInfoXControl') ?>", {CONTROL: e}).done(function (a, b, c) {
                if (a.length > 0) {
                    var xx = a[0];
                    switch (parseInt(xx.ESTATUS_PEDIDO)) {
                        case 2:
                            /*VENDIDO/CERRADA/CONCLUIDA*/
                            ParesFabricados.val(xx.TOTAL_PARES);
                            ParesFacturados.val(xx.TOTAL_PARES);
                            ParesVendidos.val(xx.PARES_VENDIDOS);
                            ParesCancelados.val(0);
                            /*PARES DEVUELTOS*/
                            $.getJSON('<?php print base_url('RastreoDeControlesEnDocumentosClientes/getDevolucionesXControl') ?>', {CONTROL: e}).done(function (aa, bb, cc) {
                                if (aa.length > 0) {
                                    var xxx = aa[0];
                                    ParesDevueltos.val(xxx.PARES_DEVUELTOS);
                                } else {
                                    ParesDevueltos.val(0);
                                }
                            }).fail(function (xxx) {
                                getError(xxx);
                            }).always(function () {

                            });
                            /*ESTATUS DE AVANCE EN PEDIDOS*/
                            $.getJSON('<?php print base_url('RastreoDeControlesEnDocumentosClientes/getEstatusPedidoXControl') ?>', {CONTROL: e}).done(function (aaa) {
                                console.log(aaa);
                                if (aaa.length > 0) {
                                    var z = aaa[0];
                                    ParesEstatus.val(z.ESTATUS_AVANCE_PEDIDO)
                                } else {
                                    ParesDevueltos.val(0);
                                }
                            }).fail(function (xxxx) {
                                getError(xxxx);
                            }).always(function () {

                            });
                            break;
                        case 3:
                            /*CANCELADA/CANCELADOS LOS PARES*/
                            ParesFabricados.val(xx.PARES);
                            ParesVendidos.val(0);
                            ParesCancelados.val(xx.PARES);
                            break;
                    }
                    Facturados.ajax.reload(function () {
                        Docto.focus().select();
                    });
                    Devoluciones.ajax.reload();
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