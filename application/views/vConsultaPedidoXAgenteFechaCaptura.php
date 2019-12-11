<div class="modal modal-fullscreen" id="mdlConsultaPedidoXAgenteFechaCaptura"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg notdraggable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta Pedidos Por Agente y Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCaptura">
                    <div class="row">
                        <div class="col-3" id="dAgente">
                            <label>Agente</label>
                            <select id="AgenteConsultaFechas" name="AgenteConsultaFechas" class="form-control form-control-sm required">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>Del: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaIniConsultaFechas" name="FechaIniConsultaFechas" >
                        </div>
                        <div class="col-2">
                            <label>Hasta: </label>
                            <input type="text" class="form-control form-control-sm date notEnter" id="FechaFinConsultaFechas" name="FechaFinConsultaFechas" >
                        </div>
                        <div class="col-3">
                            <label >Color: <span id="color" class="badge badge-info " style="font-size: 14px;"></span></label>
                            <div class="w-100"></div>
                            <label >Avance: <span id="avance" class="badge badge-danger " style="font-size: 14px;"></span></label>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="PedidosPorAgenteFecha">
                                <table id="tblPedidosPorAgenteFecha" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Control</th>
                                            <th>Pedido</th>
                                            <th>Fec-Cap</th>
                                            <th>Fec-Ped</th>
                                            <th>Fec-Ent</th>
                                            <th>Estilo</th>
                                            <th>Color</th>
                                            <th></th>
                                            <th>Maq</th>
                                            <th>Sem</th>
                                            <th>Avance</th>
                                            <th>Avance T</th>
                                            <th>Pares</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlConsultaPedidoXAgenteFechaCaptura = $('#mdlConsultaPedidoXAgenteFechaCaptura');
    var tblPedidosPorAgenteFecha = $('#tblPedidosPorAgenteFecha');
    var PedidosPorAgenteFecha;
    $(document).ready(function () {
        mdlConsultaPedidoXAgenteFechaCaptura.on('shown.bs.modal', function () {
            handleEnterDiv(mdlConsultaPedidoXAgenteFechaCaptura);
            mdlConsultaPedidoXAgenteFechaCaptura.find("input").val("");
            $.each(mdlConsultaPedidoXAgenteFechaCaptura.find("select"), function (k, v) {
                mdlConsultaPedidoXAgenteFechaCaptura.find("select")[k].selectize.clear(true);
            });
            getAgentesConsultaPedidosAgenteFechas();

        });

        mdlConsultaPedidoXAgenteFechaCaptura.find("#FechaFinConsultaFechas").keydown(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var fechaIni = mdlConsultaPedidoXAgenteFechaCaptura.find("#FechaIniConsultaFechas").val();
                    var agente = mdlConsultaPedidoXAgenteFechaCaptura.find("#AgenteConsultaFechas").val();
                    getPedidosPorAgenteFecha(agente, fechaIni, $(this).val());
                }
            }
        });

    });

    function getPedidosPorAgenteFecha(agente, fechaIni, fechaFin) {
        onOpenOverlay('Por favor, espere...');
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPedidosPorAgenteFecha')) {
            tblPedidosPorAgenteFecha.DataTable().destroy();
        }
        PedidosPorAgenteFecha = tblPedidosPorAgenteFecha.DataTable({
            "dom": 'frtip',
            buttons: buttons,
            "ajax": {
                "url": '<?php print base_url('AuxReportesClientesDos/getPedidosXAgenteFechaCaptura'); ?>',
                "dataType": "json",
                "type": 'GET',
                "data": {FechaIni: fechaIni, FechaFin: fechaFin, Agente: agente},
                "dataSrc": ""
            },
            "columns": [
                {"data": "Cliente"},
                {"data": "Control"},
                {"data": "Pedido"},
                {"data": "FechaCaptura"},
                {"data": "FechaPedido"},
                {"data": "FechaEntrega"},
                {"data": "Estilo"},
                {"data": "Color"},
                {"data": "ColorT"},
                {"data": "Maquila"},
                {"data": "Semana"},
                {"data": "Avance"},
                {"data": "AvanceT"},
                {"data": "Pares"}
            ],
            "columnDefs": [
                {
                    "targets": [8, 12],
                    "visible": false,
                    "searchable": false
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 200,
            scrollY: 370,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']/*ID*/, [2, 'asc']/*ID*/, [1, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-info text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 6:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                        case 10:
                            /*PZXPAR*/
                            c.addClass('text-strong text-danger');
                            break;
                        case 11:
                            /*PZXPAR*/
                            c.addClass('text-strong');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                onCloseOverlay();
            }
        });
        $('#tblPedidosPorAgenteFecha_filter input[type=search]').addClass('selectNotEnter');
        tblPedidosPorAgenteFecha.find('tbody').on('click', 'tr', function () {
            tblPedidosPorAgenteFecha.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

        tblPedidosPorAgenteFecha.find('tbody').on('dblclick', 'tr', function () {
            tblPedidosPorAgenteFecha.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = PedidosPorAgenteFecha.row(this).data();
            mdlConsultaPedidoXAgenteFechaCaptura.find("#color").html(dtm.Color + '-' + dtm.ColorT);
            mdlConsultaPedidoXAgenteFechaCaptura.find("#avance").html(dtm.Avance + '-' + dtm.AvanceT);
        });

    }

    function getAgentesConsultaPedidosAgenteFechas() {
        $.getJSON('<?php print base_url('Agentes/getAgentesSelect'); ?>').done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlConsultaPedidoXAgenteFechaCaptura.find("#AgenteConsultaFechas")[0].selectize.addOption({text: v.Agente, value: v.Clave});
            });
            mdlConsultaPedidoXAgenteFechaCaptura.find('#AgenteConsultaFechas')[0].selectize.focus();
        }).fail(function (x, y, z) {
            console.log(x, y, z);
        }).always(function () {
            HoldOn.close();
        });
    }

</script>


