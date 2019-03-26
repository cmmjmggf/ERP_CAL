<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-7 float-left">
                <legend class="float-left">Órdenes de producción</legend>
            </div>

            <div class="col-12 col-sm-3 col-md-3 animated bounceInUp" align="right" id="Acciones">
                <input type="text" placeholder="CAPTURA EL CONTROL" class="form-control form-control-sm numbersOnly" maxlength="10" id="Control" name="Control" required="">
            </div>
            <div class="col-12 col-sm-3 col-md-2 animated bounceInLeft" align="right" id="Acciones">
                <label for="" > <span class="badge badge-warning" style="font-size: 16px;" id="EstatusProduccion"> -- </span></label>
            </div>
        </div>
        <hr>
        <div class="card-block " id="pnlDatos">
            <form id="frmNuevo">
                <div class="row" >
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-1">
                        <label for="Pedido" >Pedido</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Pedido" name="Pedido" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Cliente</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Cliente" name="Cliente" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Agente</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Agente" name="Agente" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                        <label for="FechaPedido" >Fecha Pedido</label>
                        <input type="text" class="form-control form-control-sm" readonly=""  id="FechaPedido" name="FechaPedido" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-2">
                        <label for="FechaEntrega" >Fecha Entrega</label>
                        <input type="text" class="form-control form-control-sm" readonly=""  id="FechaEntrega" name="FechaEntrega">
                    </div>
                </div>
                <div class="row" >
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Folio" >Linea</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Linea" name="Linea" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 col-xl-1">
                        <label for="" >Estilo</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Estilo" name="Estilo" >
                    </div>
                    <div class="col-12 col-sm-4 col-md-3 col-xl-3">
                        <label for="Color" >Color</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Color" name="Color" >
                    </div>
                    <div class="col-12 col-sm-5 col-md-4 col-xl-4">
                        <label for="Observaciones" >Observaciones</label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="Observaciones" name="Observaciones" >
                    </div>
                </div>

                <div class="row" >

                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" > <span class="badge badge-success" style="font-size: 14px;">Total Piel </span></label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="TotalPiel" name="TotalPiel" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" > <span class="badge badge-success" style="font-size: 14px;">Total Piel X Par</span></label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="TotalPielPorPar" name="TotalPielPorPar" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" > <span class="badge badge-info" style="font-size: 14px;">Total Forro</span></label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="TotalForro" name="TotalForro" >
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                        <label for="" > <span class="badge badge-info" style="font-size: 14px;">Total Forro X Par</span></label>
                        <input type="text" class="form-control form-control-sm" readonly="" id="TotalForroPorPar" name="TotalForroPorPar" >
                    </div>

                </div>
            </form>
        </div>
        <div class="card-block mt-1" id="pnlDatosDetalle" >
            <div class="row" id="ControlesDetalle">

                <!--TALLAS-->
                <div class="col-12">
                    <div class="table-responsive" style="overflow-x:auto; white-space: nowrap;">
                        <label class="font-weight-bold" for="Tallas"></label>
                        <table id="tblTallas" class="Tallas" >
                            <thead></thead>
                            <tbody>
                                <tr id="rTallas">
                                    <td class="font-weight-bold">Tallas</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="S' . $index . '" name="S' . $index . '" readonly class="form-control form-control-sm "></td>';
                                    }
                                    ?>
                                    <td class="font-weight-bold">Pares</td>
                                </tr>
                                <tr id="rCantidades">
                                    <td class="font-weight-bold">Pares</td>
                                    <?php
                                    for ($index = 1; $index < 21; $index++) {
                                        print '<td><input type="text" style="width: 55px;" id="C' . $index . '" class="form-control form-control-sm " readonly name="C' . $index . '" ></td>';
                                    }
                                    ?>
                                    <td><input type="text" style="width: 55px;" maxlength="4" class="form-control form-control-sm numbersOnly font-weight-bold" disabled=""  id="Pares"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--        DETALLE-->
            <div class="row">
                <div class="col-12 mt-4">
                    <table id="tblDetalle" class="table table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Pieza</th>
                                <th></th>
                                <th>Artículo</th>
                                <th></th>
                                <th>U.M.</th>
                                <th>Consumo</th>
                                <th>Grupo</th>
                                <th>GrupoT</th>
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
    var master_url = base_url + 'index.php/OrdenDeProduccionPantalla/';

    var pnlTablero = $("#pnlTablero");
    var tblDetalle = $("#tblDetalle"), Detalle;


    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        handleEnter();

        pnlTablero.find('#Control').keyup(function (e) {
            if (e.keyCode === 13 && $(this).val()) {
                $.getJSON(master_url + 'getOrdenProduccion', {
                    Control: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) { //Si el control existe
                        $.each(data[0], function (k, v) {
                            pnlTablero.find("#" + k).val(v);
                        });

                        pnlTablero.find('#EstatusProduccion').text(data[0].EstatusProduccion);
                        getRecords(pnlTablero.find('#Control').val());
                    } else { //Si el control no existe
                        swal({
                            title: "ATENCIÓN",
                            text: "EL CONTROL NO EXISTE O ESTÁ CANCELADO ",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            if (action) {
                                pnlTablero.find('#Control').val('').focus();
                            }
                        });
                    }
                });
            }
        });

    });

    function init() {
        pnlTablero.find('#Control').focus();
    }

    function getRecords(control) {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblDetalle')) {
            tblDetalle.DataTable().destroy();
        }
        Detalle = tblDetalle.DataTable({
            "dom": 'Bfrtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getOrdenProduccion',
                "dataType": "json",
                "type": 'GET',
                "data": {Control: control},
                "dataSrc": ""
            },
            "columns": [
                {"data": "Pieza"},
                {"data": "PiezaT"},
                {"data": "Articulo"},
                {"data": "ArticuloT"},
                {"data": "UnidadMedidaT"},
                {"data": "Consumo"},
                {"data": "Grupo"},
                {"data": "GrupoT"}
            ],
            "columnDefs": [
                {
                    "targets": [6],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [7],
                    "visible": false,
                    "searchable": false
                }
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
                        case 2:
                            /*CONSUMO*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*PZXPAR*/
                            c.addClass('text-strong');
                            break;
                        case 5:
                            /*ELIMINAR*/
                            c.addClass('text-strong text-danger');
                            break;

                    }
                });
            },
            rowGroup: {
                dataSrc: "GrupoT"
            },
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 100,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            keys: true,
            "scrollY": 400,
            "bSort": true,
            "aaSorting": [
                [6, 'asc']/*ID*/
            ],
            "initComplete": function (x, y) {
                HoldOn.close();
            }
        });

        tblDetalle.find('tbody').on('click', 'tr', function () {
            HoldOn.open({theme: 'sk-bounce', message: 'ESPERE...'});
            nuevo = false;
            tblDetalle.find("tbody tr").removeClass("success");
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

    td span.badge{
        font-size: 100% !important;
    }

    #tblTallas tbody tr:hover {
        background-color: #FFF !important;
        color: #000 !important;
    }
</style>

