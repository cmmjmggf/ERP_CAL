<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Consulta de Movimientos Clientes con Desgloce</legend>
            </div>
            <div class="col-sm-6" align="right">
                <button type="button" class="btn btn-danger btn-sm " id="btnVerCartera" >
                    <span class="fa fa-search" ></span> EDO. CUENTA
                </button>
                <button type="button" class="btn btn-info btn-sm " id="btnVerPagosClientes" >
                    <span class="fa fa-search" ></span> PAGOS CLIENTES
                </button>
                <button type="button" class="btn btn-primary btn-sm " id="btnVerClientes" >
                    <span class="fa fa-search" ></span> VER CLIENTES
                </button>
            </div>
        </div>
        <hr>
        <div class="row" id="Encabezado">
            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Cliente</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Cliente" name="Cliente" maxlength="5" required="">
            </div>
            <div class="col-12 col-sm-5 col-md-5 col-xl-3" >
                <label for="" >-</label>
                <select id="sCliente" name="sCliente" class="form-control form-control-sm required NotSelectize" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm  " id="Doc" name="Doc" maxlength="15" required>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <!--            primera tabla-->
            <div class="col-6 border border-info border-left-0  border-bottom-0 border-top-0">
                <label>Documentos <span class="badge badge-info" style="font-size: 13px !important;">Doble click para imprimir documento</span></label>
                <div class="card-block mt-2">
                    <div id="MovimientosClientes">
                        <table id="tblMovimientosClientes" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Docto</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Pagos</th>
                                    <th>Saldo</th>
                                    <th>Tp</th>
                                    <th>Sts</th>

                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" align="center">Totales:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!--            segunda tabla-->
            <div class="col-6 border border-info border-left-0  border-bottom-0 border-top-0">
                <label>Detalle del Documento</label>
                <div class="card-block mt-2">
                    <div id="DetalleMovimientoFactura">
                        <table id="tblDetalleMovimientoFactura" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Estilo</th>
                                    <th>Color/Combinación del Estilo</th>
                                    <th>Control</th>
                                    <th>Corrida</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>$0.0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/MovimientosClienteDetalle/';
    var tblMovimientosClientes = $('#tblMovimientosClientes');
    var MovimientosClientes;

    var tblDetalleMovimientoFactura = $('#tblDetalleMovimientoFactura');
    var DetalleMovimientoFactura;
    var pnlTablero = $("#pnlTablero");

    var Remicion, Cliente, Tp;
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        getClientes();
        getRecords();
        getDetalleMovimientoFactura('', '', '');
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Cliente").focus();

        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {

                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#Tp").val('');
                            pnlTablero.find("#Doc").val('');
                            DetalleMovimientoFactura.clear().draw();
                            MovimientosClientes.ajax.reload();

                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtcte, true);
                            pnlTablero.find("#Doc").focus();
                        } else {
                            swal('ERROR', 'EL CLIENTE NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sCliente")[0].selectize.clear(true);
                                pnlTablero.find('#Cliente').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    pnlTablero.find("#Doc").focus();
                }
            }
        });

        pnlTablero.find("#sCliente").change(function () {
            if ($(this).val()) {
                pnlTablero.find("#Doc").val('');
                DetalleMovimientoFactura.clear().draw();
                MovimientosClientes.ajax.reload();

                pnlTablero.find("#Cliente").val($(this).val());
                MovimientosClientes.ajax.reload();
                pnlTablero.find("#Doc").focus();
            }
        });
        pnlTablero.find("#Doc").on('keypress', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    DetalleMovimientoFactura.clear().draw();
                    MovimientosClientes.ajax.reload();
                } else {
                    DetalleMovimientoFactura.clear().draw();
                    MovimientosClientes.ajax.reload();
                }
            }
        });

        pnlTablero.find("#btnVerClientes").click(function () {
            $.fancybox.open({
                src: base_url + '/Clientes',
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
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });

        pnlTablero.find("#btnVerPagosClientes").click(function () {
            $.fancybox.open({
                src: base_url + '/PagosDeClientes',
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
                            width: "100%",
                            height: "100%"
                        },
                        // Iframe tag attributes
                        attr: {
                            scrolling: "auto"
                        }
                    }
                }
            });
        });
        pnlTablero.find('#btnVerCartera').on("click", function () {
            var cliente = pnlTablero.find("#Cliente").val();
            if (cliente) {
                //HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
                $.ajax({
                    url: master_url + 'onReporteAntiguedadSaldosPorCliente',
                    type: "POST",
                    data: {
                        Cliente: cliente
                    }
                }).done(function (data, x, jq) {
                    console.log(data);


                    onImprimirReporteFancyArray(JSON.parse(data));
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES DE SELECCIONAR UN CLIENTE",
                    icon: "error",
                    closeOnClickOutside: false,
                    closeOnEsc: false
                }).then((action) => {
                    pnlTablero.find("#Cliente").focus();
                });
            }
        });

        tblMovimientosClientes.find('tbody').on('click', 'tr', function () {
            tblMovimientosClientes.find("tbody tr").removeClass("success");
            $(this).addClass("success");

        });

        tblMovimientosClientes.find('tbody').on('dblclick', 'tr', function () {
            tblMovimientosClientes.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = MovimientosClientes.row(this).data();
            Remicion = dtm.remicion;
            Cliente = dtm.cliente;
            Tp = dtm.tipo;
            DetalleMovimientoFactura.ajax.reload();
        });

    });

    function getClientes() {
        pnlTablero.find("#sCliente")[0].selectize.clear(true);
        pnlTablero.find("#sCliente")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getClientes').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sCliente")[0].selectize.addOption({text: v.Cliente, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }

    function getRecords() {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientosClientes')) {
            tblMovimientosClientes.DataTable().destroy();
        }
        MovimientosClientes = tblMovimientosClientes.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Cliente = pnlTablero.find("#Cliente").val() ? pnlTablero.find("#Cliente").val() : '';
                    d.Doc = pnlTablero.find("#Doc").val() ? pnlTablero.find("#Doc").val() : '';
                }
            },
            "columns": [
                {"data": "cliente"},
                {"data": "remicion"},
                {"data": "fechadoc"},
                {"data": "importe"},
                {"data": "pagos"},
                {"data": "saldo"},
                {"data": "tipo"},
                {"data": "status"}
            ],
            "columnDefs": [
                {
                    "targets": [3, 4, 5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'desc'], [1, 'asc']
            ],
//            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//
//                        case 0:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 1:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 3:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong text-success');
//                            break;
//                        case 7:
//                            /*fecha conf*/
//                            c.addClass('badge badge-info text-strong');
//                            break;
//                    }
//                });
//            },
//            "footerCallback": function (row, data, start, end, display) {
//                var api = this.api();//Get access to Datatable API
//                // Update footer
//                var importe = api.column(3).data().reduce(function (a, b) {
//                    var ax = 0, bx = 0;
//                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
//                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
//                    return  (ax + bx);
//                }, 0);
//                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
//                    return '$' + $.number(parseFloat(importe), 2, '.', ',');
//                }, 0));
//                var pagos = api.column(4).data().reduce(function (a, b) {
//                    var ax = 0, bx = 0;
//                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
//                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
//                    return  (ax + bx);
//                }, 0);
//                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
//                    return '$' + $.number(parseFloat(pagos), 2, '.', ',');
//                }, 0));
//                var saldo = api.column(5).data().reduce(function (a, b) {
//                    var ax = 0, bx = 0;
//                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
//                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
//                    return  (ax + bx);
//                }, 0);
//                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
//                    return '$' + $.number(parseFloat(saldo), 2, '.', ',');
//                }, 0));
//            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

    }

    function getDetalleMovimientoFactura() {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalleMovimientoFactura')) {
            tblDetalleMovimientoFactura.DataTable().destroy();
        }
        DetalleMovimientoFactura = tblDetalleMovimientoFactura.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getDetalleMovimiento',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Remicion = Remicion;
                    d.Cliente = Cliente;
                    d.Tp = Tp;
                }
            },
            "columns": [
                {"data": "estilo"},
                {"data": "color"},
                {"data": "contped"},
                {"data": "corrida"},
                {"data": "pareped"},
                {"data": "precto"},
                {"data": "subtot"}
            ],
            "columnDefs": [
                {
                    "targets": [5, 6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'desc']
            ],
            initComplete: function (a, b) {
                HoldOn.close();
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var stt = 0.0;
                //console.log(api.rows().data());
                $.each(api.rows().data(), function (k, v) {
                    stt += parseFloat(v.subtot);
                });
                $(api.column(6).footer()).html(
                        '<span class="font-weight-bold">$' +
                        $.number(stt, 2, '.', ',') + '</span>');
            }
        });
        tblDetalleMovimientoFactura.find('tbody').on('click', 'tr', function () {
            tblDetalleMovimientoFactura.find("tbody tr").removeClass("success");
            $(this).addClass("success");
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

    .badge{
        font-size: 100% !important;
    }

    .table-sm th, .table-sm td {
        padding: 0.092rem;
    }


    .table th, .table td {
        vertical-align: middle;
    }
</style>

