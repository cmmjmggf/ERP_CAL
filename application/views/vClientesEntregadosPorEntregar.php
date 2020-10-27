<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-3 float-left">
                <legend class="float-left">Pedidos Entregados y por Entregar</legend>

            </div>
            <div class="col-sm-9" align="right">
                <button type="button" class="btn btn-info btn-sm " id="btnImprimePedidosXEntregar" >
                    <span class="fa fa-search" ></span> PEDIDOS X ENTREGAR POR MAQ-SEM-FECHA
                </button>
                <button type="button" class="btn btn-success btn-sm " id="btnVerMovimientos" >
                    <span class="fa fa-dollar-sign" ></span> MOVIMIENTOS
                </button>
                <button type="button" class="btn btn-primary btn-sm " id="btnRastreoPedido" >
                    <span class="fa fa-search" ></span> RASTREO ESTILO-CLIENTE-PEDIDO
                </button>
                <button type="button" class="btn btn-danger btn-sm " id="btnVerCartera" >
                    <span class="fa fa-dollar-sign" ></span> DESFACES PEDIDOS
                </button>
            </div>
        </div>
        <hr>
        <div class="row ">
            <!--primer columna-->
            <div class="col-12" >
                <div class="row">
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
                    <div class="col-12 col-sm-4 col-md-3 col-xl-2" >
                        <label for="" >Pedido</label>
                        <input type="text" class="form-control form-control-sm numbersOnly" id="Pedido" name="Pedido">
                    </div>
                </div>
                <div class="row" >
                    <!--Primer tabla-->
                    <div class="col-12 mt-1" >
                        <div class="col-12" align="center">
                            <label class="badge badge-warning" style="font-size: 14px;">Pedidos por Entregar</label>
                        </div>
                        <div class="card-block">
                            <div id="NoEntregadosCliente" class="datatable-wide">
                                <table id="tblNoEntregadosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">Cliente</th>
                                            <th>Pedido</th>
                                            <th>Maq</th>
                                            <th>Fec-Ped</th>
                                            <th>Fec-Ent</th>
                                            <th>Sem</th>
                                            <th>Par-fab</th>
                                            <th>Par-ent</th>
                                            <th>Control</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Precio</th>
                                            <th>Av</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="d-none">Cliente</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Totales:</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 border border-info mt-1 border-right-0  border-left-0 border-bottom-0"></div>
                    <!--segunda tabla-->
                    <div class="col-12 mt-1" >
                        <div class="col-12" align="center">
                            <label class="badge badge-success" style="font-size: 14px;">Pedidos Entregados</label>
                        </div>
                        <div class="card-block ">
                            <div id="EntregadosCliente" class="datatable-wide">
                                <table id="tblEntregadosCliente" class="table table-sm display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">Cliente</th>
                                            <th>Pedido</th>
                                            <th>Maq</th>
                                            <th>Fec-Ped</th>
                                            <th>Fec-Ent</th>
                                            <th>Sem</th>
                                            <th>Par-fab</th>
                                            <th>Par-ent</th>
                                            <th>Control</th>
                                            <th>Estilo</th>
                                            <th>Col</th>
                                            <th>Precio</th>
                                            <th>Av</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/ClientesEntregadosPorEntregar/';
    var pnlTablero = $("#pnlTablero");
    var tblEntregadosCliente = $('#tblEntregadosCliente');
    var EntregadosCliente;
    var tblNoEntregadosCliente = $('#tblNoEntregadosCliente');
    var NoEntregadosCliente;
    var search_value;

    $(document).ready(function () {
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        getClientes();
        getPedidosEntregados(0);
        getPedidosNoEntregados(0);
        pnlTablero.find("#Cliente").focus();
        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtcte = $(this).val();
                if (txtcte) {

                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtcte}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtcte, true);
                            //Obtener registros entregados pedidos
                            getPedidosEntregados(txtcte);
                            getPedidosNoEntregados(txtcte);
                            pnlTablero.find("#Pedido").focus();
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
                }
            }
        });
        pnlTablero.find("#sCliente").change(function () {
            if ($(this).val()) {
                var cliente = $(this).val();
                pnlTablero.find("#Cliente").val(cliente);
                //Obtener registros entregados pedidos
                getPedidosEntregados(cliente);
                getPedidosNoEntregados(cliente);
                pnlTablero.find("#Pedido").focus();
            }
        });

        pnlTablero.find("#Pedido").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    EntregadosCliente.column(1).search('^' + $(this).val() + '$', true, false).draw();
                    NoEntregadosCliente.column(1).search('^' + $(this).val() + '$', true, false).draw();
                } else {
                    EntregadosCliente.column(1).search('').draw();
                    NoEntregadosCliente.column(1).search('').draw();
                }
            }
        });

        /*Botones*/
        $('#tblNoEntregadosCliente').on('search.dt', function () {
            search_value = $('.dataTables_filter input').val();
        });

        pnlTablero.find("#btnImprimePedidosXEntregar").click(function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            if (pnlTablero.find('#Cliente').val()) {
                $.post(base_url + 'index.php/ClientesEntregadosPorEntregar/onImprimirReportePedidosXEntregarFecha', {
                    Cliente: pnlTablero.find('#Cliente').val(),
                    Estilo: search_value
                }).done(function (data, x, jq) {
                    HoldOn.close();
                    console.log(data);
                    onImprimirReporteFancy(data);
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                    HoldOn.close();
                });
            } else {
                swal('ERROR', 'SELECCIONA UN CLIENTE', 'warning').then((value) => {
                    HoldOn.close();
                    pnlTablero.find('#Cliente').focus();
                });
            }
        });

        pnlTablero.find("#btnVerMovimientos").click(function () {
            $.fancybox.open({
                src: base_url + '/MovimientosCliente',
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
        pnlTablero.find("#btnRastreoPedido").click(function () {
            $.fancybox.open({
                src: base_url + '/RastreoDeEstilosEnPedidos',
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
    function getPedidosEntregados(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';

        if ($.fn.DataTable.isDataTable('#tblEntregadosCliente')) {
            tblEntregadosCliente.DataTable().destroy();
        }

        EntregadosCliente = tblEntregadosCliente.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getPedidosEntregados',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [
                {"data": "cliente"},
                {"data": "pedido"},
                {"data": "maquila"},
                {"data": "fechaped"},
                {"data": "fechaentrega"},
                {"data": "semana"},
                {"data": "pares"},
                {"data": "paresfacturados"},
                {"data": "control"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "precio"},
                {"data": "avance"}
            ],

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 220,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc'], [4, 'asc']
            ]
        });
        tblEntregadosCliente.find('tbody').on('click', 'tr', function () {
            tblEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

        tblEntregadosCliente.find('tbody').on('dblclick', 'tr', function () {
            tblEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = EntregadosCliente.row(this).data();

            swal("Imprimir", "Pedido: " + dtm.pedido + ' \nCliente: ' + dtm.cliente, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    $.post(base_url + 'index.php/Pedidos/onImprimirPedidoReducido', {ID: dtm.pedido, CLIENTE: dtm.cliente}).done(function (data) {
                        //check Apple device

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

                    }).fail(function (x, y, z) {
                        HoldOn.close();
                        console.log(x, y, z);
                        swal('ATENCIÓN', 'NO HA SIDO POSIBLE MOSTRAR EL PEDIDO PARA SU IMPRESIÓN,VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'warning');
                    }).always(function () {
                        HoldOn.close();
                    });
                }
            });

        });
    }
    function getPedidosNoEntregados(cliente) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblNoEntregadosCliente')) {
            tblNoEntregadosCliente.DataTable().destroy();
        }

        NoEntregadosCliente = tblNoEntregadosCliente.DataTable({
            "dom": 'frtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getPedidosNoEntregados',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "GET"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [
                {"data": "cliente"},
                {"data": "pedido"},
                {"data": "maquila"},
                {"data": "fechaped"},
                {"data": "fechaentrega"},
                {"data": "semana"},
                {"data": "pares"},
                {"data": "paresfacturados"},
                {"data": "control"},
                {"data": "estilo"},
                {"data": "color"},
                {"data": "precio"},
                {"data": "avance"}
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                // Total 1
                var pageTotal = api
                        .column(6, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                // Update footer
                $(api.column(6).footer()).html(pageTotal);
                // Total 2
                var pageTotal = api
                        .column(7, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                // Update footer
                $(api.column(7).footer()).html(pageTotal);
            },

            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "scrollX": true,
            "scrollY": 220,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'asc'], [4, 'asc']
            ]
        }
        );
        tblNoEntregadosCliente.find('tbody').on('click', 'tr', function () {
            tblNoEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblNoEntregadosCliente.find('tbody').on('dblclick', 'tr', function () {
            tblNoEntregadosCliente.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = NoEntregadosCliente.row(this).data();
            swal("Imprimir", "Pedido: " + dtm.pedido + ' \nCliente: ' + dtm.cliente, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    $.post(base_url + 'index.php/PrioridadesPorCliente/' + 'onImprimirReportePedidoControl', {Pedido: dtm.pedido, Cliente: dtm.cliente}).done(function (data) {
                        onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                        onImprimirReporteFancy(data);
                        HoldOn.close();
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

    .verde  {
        background-color: #4BEFF1 !important;
    }

    .rojo {
        background-color: #FFBEAC !important;

    }
    label {
        margin-top: 0.14rem;
        margin-bottom: 0.0rem;
    }

</style>
