<div class="modal " id="mdlConsultaClientesBloqueoAut"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta de Clientes Bloqueados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive" id="ClientesBloqueadosAut">
                                <table id="tblClientesBloqueadosAut" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Motivo</th>
                                            <th>Fecha</th>
                                            <th>Sts-Venta</th>
                                            <th>Sts-Pedido</th>
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
                <button type="button" class="btn btn-primary" id="btnImprimir">IMPRIMIR</button>
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlConsultaClientesBloqueoAut = $('#mdlConsultaClientesBloqueoAut');
    var tblClientesBloqueadosAut = $('#tblClientesBloqueadosAut');
    var ClientesBloqueadosAut;
    $(document).ready(function () {
        mdlConsultaClientesBloqueoAut.on('shown.bs.modal', function () {
            getClientesBloqueadosAut();
        });
    });

    function getClientesBloqueadosAut() {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblClientesBloqueadosAut')) {
            tblClientesBloqueadosAut.DataTable().destroy();
        }
        ClientesBloqueadosAut = tblClientesBloqueadosAut.DataTable({
            "dom": 'Bfrti',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/Clientes/getClientesBloqueados',
                "dataType": "json",
                "type": 'GET',
                "dataSrc": ""
            },
            "columns": [
                {"data": "cliente"},
                {"data": "motivo"},
                {"data": "fecha"},
                {"data": "status"},
                {"data": "statusped"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 320,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [

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
                            c.addClass('text-strong');
                            break;
                        case 3:
                            /*CONSUMO*/
                            c.addClass('text-strong text-danger');
                            break;
                        case 4:
                            /*CONSUMO*/
                            c.addClass('text-strong text-danger');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        $('#tblClientesBloqueadosAut_filter input[type=search]').addClass('selectNotEnter');
        tblClientesBloqueadosAut.find('tbody').on('click', 'tr', function () {
            tblClientesBloqueadosAut.find("tbody tr").removeClass("success");
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
    td{
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>
