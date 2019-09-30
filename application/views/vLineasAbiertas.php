<div class="modal " id="mdlLineasAbiertas"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta/Cierra Lineas Abiertas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive" id="LineasAbiertas">
                                <table id="tblLineasAbiertas" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Linea</th>
                                            <th>Estilo</th>
                                            <th>0=Abierta , 1=Cerrada</th>
                                            <th>Abierta Por:</th>
                                            <th>Fecha</th>
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
                <button type="button" class="btn btn-secondary" id="btnSalir" data-dismiss="modal">SALIR</button>
                <button type="button" class="btn btn-primary" id="btnMarcarTodasLineasAbiertas">MARCAR TODO</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlLineasAbiertas = $('#mdlLineasAbiertas');
    var tblLineasAbiertas = $('#tblLineasAbiertas');
    var LineasAbiertas;

    $(document).ready(function () {
        mdlLineasAbiertas.on('shown.bs.modal', function () {
            mdlLineasAbiertas.find("input").val("");
            $.each(mdlLineasAbiertas.find("select"), function (k, v) {
                mdlLineasAbiertas.find("select")[k].selectize.clear(true);
            });
            getLineasAbiertas();
        });
        mdlLineasAbiertas.find("#btnMarcarTodasLineasAbiertas").click(function () {
            $.post(base_url + 'index.php/GeneraCostosVenta/onMarcarTodasLineasAbiertas').done(function (data, x, jq) {
                LineasAbiertas.ajax.reload();
                onNotifyOld('fa fa-check', 'PROCESO TERMINADO CORRECTAMENTE', 'success');
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });

        });
    });

    function getLineasAbiertas() {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblLineasAbiertas')) {
            tblLineasAbiertas.DataTable().destroy();
        }
        LineasAbiertas = tblLineasAbiertas.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/GeneraCostosVenta/getLineasAbiertas',
                "dataType": "json",
                "type": 'GET',
                "dataSrc": ""
            },
            "columns": [
                {"data": "linea"},
                {"data": "clave"},
                {"data": "seguridad"},
                {"data": "usuario"},
                {"data": "fechaAbre"}
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": false,
            "displayLength": 500,
            scrollY: 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']/*ID*/, [1, 'asc']/*ID*/, [2, 'asc']/*ID*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-success text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-info text-strong');
                            break;
                        case 2:
                            /*PZXPAR*/
                            c.addClass('text-danger text-strong ');
                            break;
                        case 3:
                            /*PZXPAR*/
                            c.addClass('text-warning text-strong ');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblLineasAbiertas.find('tbody').on('click', 'tr', function () {
            tblLineasAbiertas.find("tbody tr").removeClass("success");
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>