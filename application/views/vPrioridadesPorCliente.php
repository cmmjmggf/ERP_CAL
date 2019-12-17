<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Consulta Prioridades por Cliente</legend>
            </div>
            <div class="col-sm-6" align="right">

                <button type="button" class="btn btn-info btn-sm " id="btnAnadeClientes" >
                    <span class="fa fa-cube" ></span> AÑADE CLIENTES A PRIORIDAD
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnTodosPedidos">
                    <i class="fa fa-print"></i> IMPRIME TODOS LOS PEDIDOS
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnPedidosCliente">
                    <i class="fa fa-check"></i> IMPRIME PEDIDOS DEL CLIENTE
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-5 col-md-2 col-lg-1 col-xl-1">
                <label for="Cliente" >Cliente</label>
                <input type="text" class="form-control form-control-sm numbersOnly NotSelectize" maxlength="6" id="Cliente" name="Cliente" required="" placeholder="">
            </div>
            <div class="col-12 col-xs-12 col-sm-4 col-lg-3 col-xl-3">
                <label>-</label>
                <select id="sCliente" name="sCliente" class="form-control form-control-sm required">
                    <option value=""></option>
                    <?php
                    $clientesPnl = $this->db->query("SELECT P.cliente AS CLAVE, C.RazonS AS CLIENTE "
                                    . " FROM clientesprioridad AS P join clientes C on C.Clave = P.cliente "
                                    . " ORDER BY C.RazonS ASC;")->result();
                    foreach ($clientesPnl as $k => $v) {
                        print "<option value=\"{$v->CLAVE}\">{$v->CLIENTE}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-block mt-1">
                    <div class="col-2">
                        <label class="badge badge-danger" style="font-size: 14px;">Da click en el renglón para imprimir el pedido del cliente</label>
                    </div>
                    <div id="Registros" class="table-responsive">
                        <table id="tblRegistros" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Pedido</th>
                                    <th>Año</th>
                                    <th>Sem</th>
                                    <th>Maq</th>
                                    <th>Pares</th>
                                    <th>Control</th>
                                    <th>Estilo</th>
                                    <th>Avance</th>
                                    <th>Pedido</th>
                                    <th>Entrega</th>
                                    <th>Dias</th>
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

<div class="modal " id="mdlSeleccionaSemana"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selecciona Semana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-6">
                            <label>Año</label>
                            <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>De la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
                        </div>
                        <div class="col-6">
                            <label>A la sem.</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="aSem" name="aSem" >
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnImprimir">ACEPTAR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/PrioridadesPorCliente/';
    var tblRegistros = $('#tblRegistros');
    var Registros;
    var pnlTablero = $("#pnlTablero");
    var btnAnadeClientes = $("#btnAnadeClientes");
    var mdlSeleccionaSemana = $("#mdlSeleccionaSemana");
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnterDiv(mdlSeleccionaSemana);
        pnlTablero.find("select").selectize({
            hideSelected: false,
            openOnFocus: false
        });
        pnlTablero.find("input").val("");
        pnlTablero.find('#Cliente').focus();
        pnlTablero.find('#btnPedidosCliente').click(function () {
            var cliente = pnlTablero.find('#Cliente').val();
            if (cliente !== '') {
                HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                $.post(master_url + 'onImprimirReportePedidoCliente', {Cliente: cliente}).done(function (data) {
                    onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                    onImprimirReporteFancy(data);
                    HoldOn.close();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                });
            }
        });

        mdlSeleccionaSemana.on('shown.bs.modal', function () {
            mdlSeleccionaSemana.find("input").val("");
            mdlSeleccionaSemana.find('#Ano').val(getYear()).focus().select();
        });

        mdlSeleccionaSemana.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    mdlSeleccionaSemana.find("#Ano").val("");
                    mdlSeleccionaSemana.find("#Ano").focus();
                });
            }
        });

        mdlSeleccionaSemana.find("#Sem").change(function () {
            var ano = mdlSeleccionaSemana.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });

        mdlSeleccionaSemana.find("#aSem").change(function () {
            var ano = mdlSeleccionaSemana.find("#Ano");
            onComprobarSemanasProduccion($(this), ano.val());
        });

        mdlSeleccionaSemana.find('#btnImprimir').click(function () {
            onDisable(mdlSeleccionaSemana.find('#btnImprimir'));
            var sem = mdlSeleccionaSemana.find('#Sem').val();
            var asem = mdlSeleccionaSemana.find('#aSem').val();
            var ano = mdlSeleccionaSemana.find('#Ano').val();
            HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
            $.post(master_url + 'onImprimirReportePedidoGeneral', {dSem: sem, aSem: asem, ano: ano}).done(function (data) {
                onEnable(mdlSeleccionaSemana.find('#btnImprimir'));
                onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                onEnable(mdlSeleccionaSemana.find('#btnImprimir'));
                console.log(x, y, z);
            });

        });

        pnlTablero.find('#btnTodosPedidos').click(function () {
            mdlSeleccionaSemana.modal('show');
        });
        btnAnadeClientes.click(function () {
            $('#mdlCapturaClientePrioridad').modal('show');
        });


        pnlTablero.find('#Cliente').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtCliente = $(this).val();
                if (txtCliente) {
                    $.getJSON(master_url + 'onVerificarCliente', {Cliente: txtCliente}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sCliente")[0].selectize.addItem(txtCliente, true);
                            pnlTablero.find('#Cliente').focus().select();
                            getRecords(txtCliente);
                        } else {
                            swal('ERROR', 'EL CLIENTE CAPTURADO NO EXISTE EN LISTA DE PRIORIDADES', 'warning').then((value) => {
                                pnlTablero.find('#sCliente')[0].selectize.clear(true);
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
                pnlTablero.find('#Cliente').val($(this).val());
                getRecords($(this).val());
            }
        });

    });

    function init() {
        getRecords(0);
    }
    function getRecords(cliente) {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblRegistros')) {
            tblRegistros.DataTable().destroy();
        }
        Registros = tblRegistros.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": {Cliente: cliente},
                "type": "POST"
            },
            "columns": [
                {"data": "Cliente"},
                {"data": "Pedido"},
                {"data": "Ano"},
                {"data": "Semana"},
                {"data": "Maquila"},
                {"data": "Pares"},
                {"data": "Control"},
                {"data": "Estilo"},
                {"data": "EstatusProduccion"},
                {"data": "FechaPedido"},
                {"data": "FechaEntrega"},
                {"data": "Dias"}

            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": true
                }],
            //            rowGroup: {
//                startRender: function (rows, group) {
//
//                    return $('<tr>')
//                            .append('<td colspan="9">Pedido: ' + group + '</td></tr>');
//                },
//                dataSrc: "Pedido"
//            },
            language: lang,

            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "scrollY": 400,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'],
                [1, 'asc'],
                [6, 'asc']
            ],
            //            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//                        case 0:
//                            /*FECHA ORDEN*/
//                            c.addClass('text-strong');
//                            break;
//                        case 5:
//                            /*fecha conf*/
//                            c.addClass('text-info text-strong');
//                            break;
//                        case 7:
//                            /*fecha conf*/
//                            c.addClass('text-warning text-strong');
//                            break;
//                        case 10:
//                            /*fecha conf*/
//                            c.addClass('text-danger text-strong');
//                            break;
//                    }
//                });
//            },
            initComplete: function (a, b) {
                HoldOn.close();

            }
        });
        tblRegistros.find('tbody').on('click', 'tr', function () {
            tblRegistros.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Registros.row(this).data();

            swal("Imprimir", "Pedido: " + dtm.Pedido + ' \nCliente: ' + dtm.Cliente, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
                    $.post(master_url + 'onImprimirReportePedidoControl', {Pedido: dtm.Pedido, Cliente: dtm.Cliente}).done(function (data) {
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

    function onComprobarSemanasProduccion(v, ano) {
        $.getJSON(base_url + 'index.php/OrdenCompra/onComprobarSemanasProduccion', {Clave: $(v).val(), Ano: ano}).done(function (data) {
            if (data.length > 0) {

            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "LA SEMANA " + $(v).val() + " DEL " + ano + " " + "NO EXISTE",
                    icon: "warning",
                    buttons: {
                        eliminar: {
                            text: "Aceptar",
                            value: "aceptar"}
                    }
                }).then((value) => {
                    switch (value) {
                        case "aceptar":
                            swal.close();
                            $(v).val('');
                            $(v).focus();
                            break;
                    }
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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
</style>
<?php
$this->load->view('vCapturaClientePrioridad');
