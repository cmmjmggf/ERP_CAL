<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-6 float-left">
                <legend class="float-left">Consulta Prioridades por Cliente</legend>
            </div>
            <div class="col-sm-6" align="right">

                <button type="button" class="btn btn-info btn-sm " id="btnVerDetalles" >
                    <span class="fa fa-cube" ></span> AÑADE CLIENTES A PRIORIDAD
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnImprimir">
                    <i class="fa fa-print"></i> IMPRIME TODOS LOS PEDIDOS
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="btnPedidosCliente">
                    <i class="fa fa-check"></i> IMPRIME PEDIDOS DEL CLIENTE
                </button>
                <button type="button" class="btn btn-danger" id="btnLimpiarFiltros" data-toggle="tooltip" data-placement="right" title="Limpiar Filtros">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-5 col-lg-4 col-xl-4">
                <label>Cliente</label>
                <select id="Cliente" name="Cliente" class="form-control form-control-sm required">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-2">
                <label>Año</label>
                <input type="text" maxlength="4" class="form-control form-control-sm numbersOnly" id="Ano" name="Ano" >
            </div>
            <div class="col-2">
                <label>Sem</label>
                <input type="text" maxlength="2" class="form-control form-control-sm numbersOnly" id="Sem" name="Sem" >
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
<script>
    var master_url = base_url + 'index.php/PrioridadesPorCliente/';
    var tblRegistros = $('#tblRegistros');
    var Registros;
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        validacionSelectPorContenedor(pnlTablero);
        setFocusSelectToInputOnChange('#Cliente', '#Ano', pnlTablero);
        init();
        handleEnter();
        pnlTablero.find("input").val("");
        $(':input:text:enabled:visible:first').focus();

        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            tblRegistros.DataTable().columns().search('').draw();
            $.each(pnlTablero.find("select"), function (k, v) {
                pnlTablero.find("select")[k].selectize.clear(true);
            });
            $(':input:text:enabled:visible:first').focus();
        });


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





        pnlTablero.find("#Cliente").change(function () {
            Registros.column(0).search($(this).val()).draw();
        });

        pnlTablero.find("#Sem").keyup(function (e) {
            Registros.column(3).search($(this).val()).draw();
        });

        pnlTablero.find("#Ano").keyup(function (e) {
            Registros.column(2).search($(this).val()).draw();
        });

        pnlTablero.find("#Sem").change(function () {
            if (parseInt($(this).val()) < 1 || parseInt($(this).val()) > 52 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "SEMANA INCORRECTA",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#Sem").val("");
                    pnlTablero.find("#Sem").focus();
                });
            }
        });

        pnlTablero.find("#Ano").change(function () {
            if (parseInt($(this).val()) < 2016 || parseInt($(this).val()) > 2020 || $(this).val() === '') {
                swal({
                    title: "ATENCIÓN",
                    text: "AÑO INCORRECTO",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: false,
                    timer: 1000
                }).then((action) => {
                    pnlTablero.find("#Ano").val("");
                    pnlTablero.find("#Ano").focus();
                });
            }
        });

    });

    function init() {
        getRecords();
        getClientes();
    }
    function getRecords() {
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
                }
            ],
            rowGroup: {
                startRender: function (rows, group) {

                    return $('<tr>')
                            .append('<td colspan="9">Pedido: ' + group + '</td></tr>');
                },
                dataSrc: "Pedido"
            },
            language: lang,

            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'],
                [1, 'asc'],
                [6, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*FECHA ORDEN*/
                            c.addClass('text-strong');
                            break;
                        case 5:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 7:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                        case 10:
                            /*fecha conf*/
                            c.addClass('text-danger text-strong');
                            break;
                    }
                });
            },
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
    function getClientes() {
        $.getJSON(master_url + 'getClientes').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                pnlTablero.find("#Cliente")[0].selectize.addOption({text: v.Cliente, value: v.ID});
            });
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    td span.badge{
        font-size: 100% !important;
    }
</style>
