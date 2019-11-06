<div class="card m-3 animated fadeIn" id="pnlTablero" >
    <div class="card-body " >
        <div class="row">
            <div class="col-sm-12 float-left">
                <legend class="float-left">Devoluciones y descuentos pendientes por recibir</legend>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Cliente</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="5" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-56 col-xl-5">
                <label>-</label>
                <select id="sCliente" name="sCliente" class="form-control form-control-sm NotSelectize">
                    <option></option>
                    <?php
                    foreach ($this->db->query("SELECT C.Clave AS CLAVE, CONCAT(C.RazonS) AS CLIENTE FROM clientes AS C "
                            . "WHERE C.Estatus IN('ACTIVO') ORDER BY (CLIENTE) ASC;")->result() as $k => $v) {
                        print "<option value='{$v->CLAVE}'>{$v->CLIENTE}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="TP" name="TP" maxlength="1" required="">
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-2 col-xl-2">
                <label>Docto</label>
                <input type="text" id="Documento" name="Documento" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <label>Fecha</label>
                <input type="text" id="FechaDevolucion" name="FechaDevolucion" class="form-control form-control-sm date notEnter">
            </div>
            <div class="w-100"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <span class="font-weight-bold text-white badge badge-info">Tipos de movimiento: 5 = Descuentos  6 = Devoluciones</span>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-1 col-xl-1">
                <label>Mov</label>
                <select id="Mov" name="Mov" class="form-control form-control-sm">
                    <option></option>
                    <option value="5">5 - Descuentos</option>
                    <option value="6">6 - Devoluciones</option>
                </select>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Importe</label>
                <input type="text" id="Importe" name="Importe" class="form-control form-control-sm numbersOnly">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <label>Referencia</label>
                <input type="text" id="Referencia" name="Referencia" class="form-control form-control-sm">
            </div>

            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Importe</label>
                <input type="text" id="ImporteD" name="ImporteD" class="form-control form-control-sm numbersOnly verde" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Pagos</label>
                <input type="text" id="Pagos" name="Pagos" class="form-control form-control-sm numbersOnly verde" readonly="">
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <label>Saldo</label>
                <input type="text" id="Saldo" name="Saldo" class="form-control form-control-sm numbersOnly verde" readonly="">
            </div>
            <div class="w-100 mt-2"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <label class="font-weight-bold text-danger">DESCUENTOS Y DEVOLUCIONES DE ESTE CLIENTE <span class="text-white badge badge-primary"> (Doble click para eliminar)</span></label>
                <table id="tblDescuentosYDevoluciones" class="table table-hover table-sm display nowrap"  style="width: 100%!important;">
                    <thead>
                        <tr>
                            <th scope="col">Cte</th><!--1-->
                            <th scope="col">Docto</th><!--2-->
                            <th scope="col">Fecha</th><!--3-->
                            <th scope="col">Importe</th><!--4-->
                            <th scope="col">Mov</th><!--5-->
                            <th scope="col">Concepto</th><!--6--><!--1-->
                            <th scope="col">Agt</th><!--7--><!--2-->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                <div class="row">
                    <div class="col-12">
                        <button type="button" id="btnAcepta" name="btnAcepta" class="btn btn-primary btn-block btn-sm" disabled="">
                            <span class="fa fa-check"></span> Acepta
                        </button>
                    </div>
                    <div class="col-12 my-2">
                        <button type="button" id="btnActualizaSTSDescDevol" name="btnActualizaSTSDescDevol" class="btn btn-info btn-block btn-sm">
                            <span class="fa fa-recycle"></span> Actualiza sts.descu-devol
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="button" id="btnPagosDeClientes" name="btnPagosDeClientes" class="btn btn-info btn-block btn-sm">
                            <span class="fa fa-check"></span> Pagos de clientes
                        </button>
                    </div>
                    <div class="col-12 my-1"></div>
                    <div class="col-6">
                        <button type="button" id="btnLocPlazas" name="btnLocPlazas" class="btn btn-info btn-block btn-sm">
                            <span class="fa fa-map"></span> Loc-Plazas
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btnNotaCreditoDD" name="btnNotaCreditoDD" class="btn btn-info btn-block btn-sm">
                            <span class="fa fa-arrow-down"></span> Nota credito
                        </button>
                    </div>
                    <div class="col-12 my-1"></div>
                    <div class="col-6 ">
                        <button type="button" id="btnMovimientosDD" name="btnMovimientosDD" class="btn btn-info btn-block btn-sm">
                            <span class="fa fa-compress"></span> Movimientos
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-100 mt-2"></div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
                <label class="font-weight-bold text-danger">DOCUMENTOS CON SALDO DE ESTE CLIENTE</label>
                <div id="DoctosCliente" class="datatable-wide">
                    <table id="tblDoctosCliente" class="table table-sm display " style="width:100%">
                        <thead>
                            <tr>
                                <th>Docto</th>
                                <th>Tp</th>
                                <th>Fecha</th>
                                <th>Importe</th>
                                <th>Pagos</th>
                                <th>Saldo</th>
                                <th>Estatus</th>
                                <th>Días</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/DevolucionesYDescuentosPendientesXRecibir/';
    var pnlTablero = $("#pnlTablero"),
            tblDescuentosYDevoluciones = pnlTablero.find("#tblDescuentosYDevoluciones"),
            DescuentosYDevoluciones,
            tblDoctosCliente = $('#tblDoctosCliente'),
            DoctosCliente,
            btnPagosDeClientes = pnlTablero.find("#btnPagosDeClientes"),
            btnActualizaSTSDescDevol = pnlTablero.find("#btnActualizaSTSDescDevol"),
            btnMovimientosDD = pnlTablero.find("#btnMovimientosDD"),
            btnNotaCreditoDD = pnlTablero.find("#btnNotaCreditoDD"),
            Cliente = pnlTablero.find('#Cliente'),
            sCliente = pnlTablero.find('#sCliente'),
            TP = pnlTablero.find('#TP'),
            Documento = pnlTablero.find('#Documento'),
            FechaDevolucion = pnlTablero.find('#FechaDevolucion'),
            Mov = pnlTablero.find('#Mov'),
            Importe = pnlTablero.find('#Importe'),
            Referencia = pnlTablero.find('#Referencia'),
            ImporteD = pnlTablero.find('#ImporteD'),
            Pagos = pnlTablero.find('#Pagos'),
            Saldo = pnlTablero.find('#Saldo'),
            btnAcepta = pnlTablero.find('#btnAcepta');
    var txtcondi, txtcondcte, txtagente;
    $(document).ready(function () {
        init();
        Cliente.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {
                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            txtagente = data[0].Agente;
                            txtcondcte = data[0].Descuento;
                            txtcondi = (parseFloat(txtcondcte) * 100) / 1;
                            sCliente[0].selectize.addItem(txtcte, true);
                            TP.focus().select();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                sCliente[0].selectize.clear(true);
                                Cliente.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        sCliente.change(function () {
            if ($(this).val()) {
                $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtCliente}).done(function (data) {
                    if (data.length > 0) {
                        txtagente = data[0].Agente;
                        txtcondcte = data[0].Descuento;
                        txtcondi = (parseFloat(txtcondcte) * 100) / 1;
                        Cliente.val($(this).val());
                        TP.focus().select();
                    }
                }).fail(function (x) {
                    swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                    console.log(x.responseText);
                });
            }
        });
        TP.keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    onVerificarTp($(this));
                }
            }
        });
        Documento.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtDocto = $(this).val();
                var txtCliente = Cliente.val();
                var txtTp = TP.val();
                if (txtDocto) {
                    $.getJSON(master_url + 'onVerificarDocumento', {Remicion: txtDocto, Tp: txtTp, Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            if (parseFloat(data[0].saldo) <= 0 || parseInt(data[0].status) >= 3) {
                                swal('ERROR', 'DOCUMENTO SALDADO, IMPOSIBLE MODIFICAR', 'warning').then((value) => {
                                    Documento.focus().val('');
                                });
                            } else {
                                ImporteD.val(parseFloat(data[0].importe).toFixed(2));
                                Pagos.val(parseFloat(data[0].pagos).toFixed(2));
                                Saldo.val(parseFloat(data[0].saldo).toFixed(2));
                                FechaDevolucion.focus();
                            }
                        } else {
                            swal('ERROR', 'EL DOCUMENTO NO EXISTE', 'warning').then((value) => {
                                Documento.focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        FechaDevolucion.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtf = $(this).val();
                if (txtf) {
                    Mov[0].selectize.focus();
                    Mov[0].selectize.open();
                }
            }
        });
        Mov.change(function () {
            if ($(this).val() === '5') {
                Referencia.val('Desc' + txtcondi + '%');
                Importe.focus().select();
            } else if ($(this).val() === '6') {
                Referencia.val('Dev');
                Importe.focus().select();

            }
        });
        Importe.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtI = $(this).val();
                if (txtI) {
                    var importedev = Importe.val();
                    var txtsaldo = Saldo.val();
                    if (parseFloat(importedev) > parseFloat(txtsaldo)) {
                        swal({
                            title: "ATENCIÓN",
                            text: "IMPORTE NO DEBE DE SER MAYOR AL SALDO DEL DOCUMENTO",
                            icon: "error",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            Importe.val('').focus();
                        });
                    } else {
                        Referencia.focus().select();
                    }
                }
            }
        });
        Referencia.keypress(function (e) {
            if (e.keyCode === 13) {
                var txtI = $(this).val();
                if (txtI) {
                    btnAcepta.attr('disabled', false);
                    btnAcepta.focus();
                }
            }
        });
        btnAcepta.click(function () {
            isValid('pnlTablero');
            if (valido) {
                var importedev = Importe.val();
                var txtsaldo = Saldo.val();
                if (parseFloat(importedev) > parseFloat(txtsaldo)) {
                    swal({
                        title: "ATENCIÓN",
                        text: "IMPORTE NO DEBE DE SER MAYOR AL SALDO DEL DOCUMENTO",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then((action) => {
                        Importe.val('').focus();
                    });
                } else {
                    //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                    $.post(master_url + 'onAgregar', {
                        tp: TP.val(),
                        cliente: Cliente.val(),
                        docto: Documento.val(),
                        fecha: FechaDevolucion.val(),
                        importe: importedev,
                        agente: txtagente,
                        mov: Mov.val(),
                        doctopa: Referencia.val()
                    }).done(function (data) {
                        DescuentosYDevoluciones.ajax.reload();
                        txtcondi = 0;
                        txtcondcte = 0;
                        txtagente = 0;
                        pnlTablero.find("input").val("");
                        $.each(pnlTablero.find("select"), function (k, v) {
                            pnlTablero.find("select")[k].selectize.clear(true);
                        });
                        Cliente.focus();
                        HoldOn.close();
                        onNotifyOld('fa fa-check', 'REGISTRO GUARDADO', 'info');
                        btnAcepta.attr('disabled', true);
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });
        btnPagosDeClientes.click(function () {
            onOpenWindow('<?php print base_url('PagosDeClientes.shoes'); ?>');
        });
        btnActualizaSTSDescDevol.click(function () {
            onOpenWindow('<?php print base_url('ActualizaSTSDescYDevoXAgenteImprocedentes.shoes'); ?>');
        });
        btnMovimientosDD.click(function () {
            onOpenWindow('<?php print base_url('MovimientosCliente.shoes'); ?>');
        });
        btnNotaCreditoDD.click(function () {
            onOpenWindow('<?php print base_url('NotasCreditoClientes.shoes'); ?>');
        });
    });

    function init() {
        txtcondi = 0;
        txtcondcte = 0;
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        getRecords(0, 0);
        getDevDescImpro(0, 0);
        FechaDevolucion.val(getToday());
        Cliente.focus();
    }
    function onVerificarTp(v) {
        var tp = parseInt($(v).val());
        if (tp === 1 || tp === 2) {
            getRecords(Cliente.val(), $(v).val());
            getDevDescImpro(Cliente.val(), $(v).val());
            Documento.focus().select();
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then((action) => {
                $(v).val('').focus();
            });
        }
    }
    function getRecords(cliente, tp) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDoctosCliente')) {
            tblDoctosCliente.DataTable().destroy();
        }
        DoctosCliente = tblDoctosCliente.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Cliente: cliente, Tp: tp},
                "type": "GET"
            },
            "columns": [
                {"data": "docto"},
                {"data": "tipo"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "status"},
                {"data": "dias"}
            ],
            "columnDefs": [
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'asc'], [0, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 1:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                        case 7:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDoctosCliente.find('tbody').on('click', 'tr', function () {
            tblDoctosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    function getDevDescImpro(cliente, tp) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDoctosCliente')) {
            tblDescuentosYDevoluciones.DataTable().destroy();
        }
        DescuentosYDevoluciones = tblDescuentosYDevoluciones.DataTable({
            "dom": 'rt',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getDevDesImpro',
                "dataSrc": "",
                "data": {Cliente: cliente, Tp: tp},
                "type": "GET"
            },
            "columns": [
                {"data": "cliente"},
                {"data": "docto"},
                {"data": "fecha"},
                {"data": "importe"},
                {"data": "mov"},
                {"data": "doctopa"},
                {"data": "agente"}
            ],
            "columnDefs": [
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 999,
            "scrollX": true,
            "scrollY": 250,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'desc'], [1, 'desc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ENTREGA*/
                            c.addClass('text-strong');
                            break;

                        case 1:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

        tblDescuentosYDevoluciones.find('tbody').on('click', 'tr', function () {
            tblDescuentosYDevoluciones.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

        tblDescuentosYDevoluciones.find('tbody').on('dblclick', 'tr', function () {
            var dtm = DescuentosYDevoluciones.row(this).data();
            swal({
                title: "Estás Seguro?",
                text: "Cliente: " + dtm.cliente + "\n " + "Docto: " + dtm.docto + "\n Importe: $" + $.number(parseFloat(dtm.importe), 2, '.', ','),
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onEliminarRegistro', {ID: dtm.ID}).done(function () {
                        DescuentosYDevoluciones.ajax.reload();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    }
</script>
<style>
    .text-strong {
        font-weight: bolder;
    }

    tr.group-start:hover td{
        background-color: #e0e0e0 !important;
        color: #000 !important;
    }
    tr.group-end td{
        background-color: #FFF !important;
        color: #000!important;
    }

    td span.badge{
        font-size: 100% !important;
    }

    div.datatable-wide {
        padding-left: 0;
        padding-right: 0;
    }
    table tbody tr {
        font-size: 0.75rem !important;
    }
    .verde {

        background-color: #B9F5A2 !important;
    }
</style>