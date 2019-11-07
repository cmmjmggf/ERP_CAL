<div class="modal " id="mdlSeleccionaEstiloColorParaEfectoVenta"  role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consulta Colores por Estilo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmExplosion">
                    <div class="row">
                        <div class="col-3">
                            <label>Estilo</label>
                            <input type="text" maxlength="7" class="form-control form-control-sm" id="EstiloGenCos" name="EstiloGenCos" required="">
                        </div>
                        <div class="col-2" >
                            <label for="" >Color</label>
                            <input type="text" class="form-control form-control-sm numbersOnly" maxlength="2"  id="Color" name="Color"   >
                        </div>
                        <div class="col-5">
                            <label for="">-</label>
                            <select class="form-control form-control-sm required selectize" id="sColor" name="sColor" required="">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="button" id="btnAceptar" class="btn btn-primary btn-sm mt-4">
                                <span class="fa fa-check"></span> ACEPTAR
                            </button>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-3">
                            <label class="badge badge-danger" style="font-size: 14px;">El estilo marcado con 1, es el que se tomará como base para costeo</label>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="table-responsive" id="EstiloColores">
                                <table id="tblEstiloColores" class="table table-sm  " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Estilo</th>
                                            <th>Color</th>
                                            <th>Descripcion</th>
                                            <th>Costo</th>
                                            <th>P. Venta</th>
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
    var mdlSeleccionaEstiloColorParaEfectoVenta = $('#mdlSeleccionaEstiloColorParaEfectoVenta');
    var tblEstiloColores = $('#tblEstiloColores');
    var EstiloColores;

    $(document).ready(function () {
        mdlSeleccionaEstiloColorParaEfectoVenta.on('shown.bs.modal', function () {
            mdlSeleccionaEstiloColorParaEfectoVenta.find("input").val("");
            $.each(mdlSeleccionaEstiloColorParaEfectoVenta.find("select"), function (k, v) {
                mdlSeleccionaEstiloColorParaEfectoVenta.find("select")[k].selectize.clear(true);
            });
            getEstiloColores('');
            mdlSeleccionaEstiloColorParaEfectoVenta.find('#EstiloGenCos').focus().select();
        });
        mdlSeleccionaEstiloColorParaEfectoVenta.find("#EstiloGenCos").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var estilo = $(this).val();
                    //veririca essitlo
                    $.getJSON(base_url + 'index.php/GeneraCostosVenta/onVerificarExisteEstilo', {Estilo: $(this).val()}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            getColoresByEstilo(estilo);
                            getEstiloColores(estilo);
                            mdlSeleccionaEstiloColorParaEfectoVenta.find('#Color').focus().select();
                        } else {
                            swal('ATENCIÓN', 'EL ESTILO NO EXISTE', 'error').then((value) => {
                                mdlSeleccionaEstiloColorParaEfectoVenta.find('#EstiloGenCos').val('').focus();

                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                } else {
                    $(this).focus();
                }
            }
        });
        mdlSeleccionaEstiloColorParaEfectoVenta.find("#Color").keypress(function (e) {
            if (e.keyCode === 13) {
                var Color = $(this).val();
                var Estilo = mdlSeleccionaEstiloColorParaEfectoVenta.find("#EstiloGenCos").val();
                if (Color) {
                    $.getJSON(base_url + 'index.php/FichaTecnicaCompra/onComprobarEstiloColor', {Color: Color, Estilo: Estilo}).done(function (data, x, jq) {
                        if (data.length > 0) {
                            mdlSeleccionaEstiloColorParaEfectoVenta.find("#sColor")[0].selectize.addItem(Color, true);
                            mdlSeleccionaEstiloColorParaEfectoVenta.find("#btnAceptar").focus();
                        } else {
                            swal('ERROR', 'EL COLOR NO EXISTE', 'warning').then((value) => {
                                mdlSeleccionaEstiloColorParaEfectoVenta.find('#Color').focus().val('');
                            });
                        }
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            }
        });

        mdlSeleccionaEstiloColorParaEfectoVenta.find("#sColor").change(function () {
            if ($(this).val()) {
                mdlSeleccionaEstiloColorParaEfectoVenta.find('#Color').val($(this).val());
                mdlSeleccionaEstiloColorParaEfectoVenta.find("#btnAceptar").focus();
            }
        });
        mdlSeleccionaEstiloColorParaEfectoVenta.find("#btnAceptar").click(function () {
            var estilo = mdlSeleccionaEstiloColorParaEfectoVenta.find("#EstiloGenCos").val();
            var color = mdlSeleccionaEstiloColorParaEfectoVenta.find("#Color").val();
            $.post(base_url + 'index.php/GeneraCostosVenta/onModificarEstiloColorParaCosto', {Estilo: estilo, Color: color}).done(function (data, x, jq) {
                EstiloColores.ajax.reload();
                mdlSeleccionaEstiloColorParaEfectoVenta.find("#Estilo").focus().select();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });

        });
    });

    function getEstiloColores(estilo) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblEstiloColores')) {
            tblEstiloColores.DataTable().destroy();
        }
        EstiloColores = tblEstiloColores.DataTable({
            "dom": 'rt',
            buttons: buttons,
            "ajax": {
                "url": base_url + 'index.php/GeneraCostosVenta/getEstiloColores',
                "dataType": "json",
                "type": 'GET',
                "data": {Estilo: estilo},
                "dataSrc": ""
            },
            "columns": [
                {"data": "estilo"},
                {"data": "color"},
                {"data": "nomcolor"},
                {"data": "costo"},
                {"data": "pventa"}
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
            "colReorder": false,
            "displayLength": 500,
            scrollY: 350,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc']/*ID*/, [1, 'asc']
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
                            c.addClass('text-info text-strong ');
                            break;
                        case 4:
                            /*PZXPAR*/
                            c.addClass('text-danger text-strong ');
                            break;
                    }
                });
            },
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });
        tblEstiloColores.find('tbody').on('click', 'tr', function () {
            tblEstiloColores.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

    }

    function getColoresByEstilo(estilo) {
        mdlSeleccionaEstiloColorParaEfectoVenta.find("#sColor")[0].selectize.clear(true);
        mdlSeleccionaEstiloColorParaEfectoVenta.find("#sColor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/GeneraCostosVenta/getColoresByEstilo', {Estilo: estilo}).done(function (data, x, jq) {
            $.each(data, function (k, v) {
                mdlSeleccionaEstiloColorParaEfectoVenta.find("#sColor")[0].selectize.addOption({text: v.Descripcion, value: v.ID});
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

    span.badge{
        font-size: 100% !important;
    }

    #Titulo span.badge{
        font-size: 16px !important;
    }
</style>