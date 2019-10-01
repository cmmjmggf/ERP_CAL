<div class="modal " id="mdlConsultaEstiloLineaLista"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta Estilo-Linea-Lista Precios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <label>Estilo</label>
                        <input type="text" maxlength="6" class="form-control form-control-sm" id="EstiloConsultaGenCos" name="EstiloConsultaGenCos" required="">
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="table-responsive" id="EstiloLineaLista">
                            <table id="tblEstiloLineaLista" class="table table-sm  " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Linea</th>
                                        <th>Lista</th>
                                        <th>Estilo</th>
                                        <th>Color</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary selectNotEnter" id="btnSalir" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var mdlConsultaEstiloLineaLista = $('#mdlConsultaEstiloLineaLista');
    var tblEstiloLineaLista = $('#tblEstiloLineaLista');
    var EstiloLineaLista;

    $(document).ready(function () {
        mdlConsultaEstiloLineaLista.on('shown.bs.modal', function () {
            mdlConsultaEstiloLineaLista.find("input").val("");
            $.each(mdlConsultaEstiloLineaLista.find("select"), function (k, v) {
                mdlConsultaEstiloLineaLista.find("select")[k].selectize.clear(true);
            });
            getEstiloLineaLista('');
            mdlConsultaEstiloLineaLista.find('#EstiloConsultaGenCos').focus().select();
        });
        mdlConsultaEstiloLineaLista.find("#EstiloConsultaGenCos").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var estilo = $(this).val();
                    //veririca essitlo
                    $.getJSON(base_url + 'index.php/GeneraCostosVenta/onVerificarExisteEstilo', {Estilo: estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            getEstiloLineaLista(estilo);
                        } else {
                            swal('ATENCIÓN', 'EL ESTILO NO EXISTE', 'error').then((value) => {
                                mdlConsultaEstiloLineaLista.find('#EstiloConGenCos').val('').focus();
                            });
                        }
                    });
                }
            }
        });
    });

    function getEstiloLineaLista(estilo) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEstiloLineaLista')) {
            tblEstiloLineaLista.DataTable().destroy();
        }
        EstiloLineaLista = tblEstiloLineaLista.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/GeneraCostosVenta/getEstiloLineaLista',
                "dataType": "json",
                "type": 'GET',
                "data": {Estilo: estilo},
                "dataSrc": ""
            },
            "columns": [
                {"data": "linea"},
                {"data": "lista"},
                {"data": "estilo"},
                {"data": "color"}
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
                [0, 'asc']/*ID*/, [1, 'asc']/*ID*/, [2, 'asc']/*ID*/, [3, 'asc']
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 0:
                            /*UNIDAD*/
                            c.addClass('text-strong');
                            break;
                        case 1:
                            /*CONSUMO*/
                            c.addClass('text-info text-strong');
                            break;
                        case 2:
                            /*PZXPAR*/
                            c.addClass('text-success text-strong ');
                            break;
                        case 3:
                            /*PZXPAR*/
                            c.addClass('text-strong ');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblEstiloLineaLista.find('tbody').on('click', 'tr', function () {
            tblEstiloLineaLista.find("tbody tr").removeClass("success");
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