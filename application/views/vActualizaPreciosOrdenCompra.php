<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Modifica Precio a Orden de Compra <span class="badge badge-danger">NOTA: SÓLO SE MODIFICARÁN PRECIOS DE ARTÍCULOS SIN RECIBIR</span></legend>
            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1">
                <label>Tp</label>
                <input type="text" class="form-control form-control-sm  numbersOnly" id="Tp" maxlength="1" >
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-1">
                <label>O. Compra</label>
                <input type="text" class="form-control form-control-sm numbersOnly"  id="OC" maxlength="10" required>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4">
                <button type="button" class="btn btn-primary" id="btnActualizaPrecios" data-toggle="tooltip" data-placement="right" title="Actualizar Precios">
                    <i class="fa fa-pencil-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="OrdenesCompra" class="table-responsive">
                <table id="tblOrdenesCompra" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Tp</th>
                            <th>Folio</th>
                            <th>Proveedor</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/ActualizaPrecioOrdenCompra/';
    var tblOrdenesCompra = $('#tblOrdenesCompra');
    var OrdenesCompra;
    var pnlTablero = $("#pnlTablero");
    var btnActualizaPrecios = pnlTablero.find('#btnActualizaPrecios');
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        handleEnter();
        pnlTablero.find("input").val("");
        pnlTablero.find('#Tp').focus().select();
        pnlTablero.find("#Tp").change(function () {
            onVerificarTp($(this));
        });
        pnlTablero.find("#OC").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            getOrdenCompra($(this), tp);
        });
        btnActualizaPrecios.click(function () {
            swal({
                buttons: ["Cancelar", "Aceptar"],
                title: 'Estás Seguro?',
                text: "Esta acción modificará los precios de toda la orden",
                icon: "warning",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then((action) => {
                if (action) {
                    var tp = pnlTablero.find("#Tp").val();
                    var oc = pnlTablero.find("#OC").val();
                    $.post(master_url + 'onModificarPreciosOrdenCompraByOrdenCompra', {
                        OC: oc,
                        Tp: tp,
                        Prov: Prov
                    }).done(function (data) {
                        onNotifyOld('fa fa-check', 'PRECIOS ACTUALIZADOS', 'info');
                        OrdenesCompra.ajax.reload();
                        pnlTablero.find("#Tp").val('');
                        pnlTablero.find("#OC").val('');
                        Prov = 0;
                        pnlTablero.find("#Tp").focus();
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
    });
    function getRecords(Folio, Tp) {
        temp = 0;
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblOrdenesCompra')) {
            tblOrdenesCompra.DataTable().destroy();
        }
        OrdenesCompra = tblOrdenesCompra.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "data": {Folio: Folio, Tp: Tp},
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [

                {"data": "Tp"},
                {"data": "Folio"},
                {"data": "Proveedor"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "Precio"},
                {"data": "Subtotal"}
            ],
            "columnDefs": [
                {
                    "targets": [5],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [6],
                    "render": function (data, type, row) {
                        return '$' + $.number(parseFloat(data), 2, '.', ',');
                    }
                }
            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 15,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [0, 'asc'], [1, 'asc'], [2, 'desc']
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
                        case 1:
                            /*FECHA ENTREGA*/
                            c.addClass('text-success text-strong');
                            break;
                        case 2:
                            /*fecha conf*/
                            c.addClass('text-info text-strong');
                            break;
                        case 3:
                            /*fecha conf*/
                            c.addClass('text-success text-strong');
                            break;
                        case 4:
                            /*fecha conf*/
                            c.addClass('text-warning text-strong');
                            break;
                    }
                });
            },
            initComplete: function (a, b) {
                HoldOn.close();

            }
        });
        tblOrdenesCompra.find('tbody').on('click', 'tr', function () {
            tblOrdenesCompra.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
    }
    var Prov;
    function getOrdenCompra(v, Tp) {
        $.getJSON(master_url + 'getOrdenCompra', {Folio: $(v).val(), Tp: Tp}).done(function (data) {
            if (data.length > 0) {
                if (data[0].Estatus === 'ACTIVA') {
                    Prov = data[0].Proveedor;
                    getRecords($(v).val(), Tp);
                } else {
                    swal({
                        title: "ERROR",
                        text: "YA SE HA RECIBIDO MATERIAL DE ESTA ORDEN DE COMPRA",
                        icon: "warning"
                    }).then((value) => {
                        $(v).val('').focus();
                    });
                }
            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "NO EXISTE LA ORDEN DE COMPRA",
                    icon: "warning"
                }).then((value) => {
                    if ($.fn.DataTable.isDataTable('#tblOrdenesCompra')) {
                        OrdenesCompra.clear().draw();
                    }
                    $(v).val('').focus();
                });
            }
        }).fail(function (x, y, z) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function onVerificarTp(v) {
        var tp = parseInt(v.val());
        if (tp === 1 || tp === 2) {
        } else {
            swal({
                title: "ATENCIÓN",
                text: "EL TP SÓLO PUEDE SER 1 Ó 2",
                icon: "error",
                closeOnClickOutside: false,
                closeOnEsc: false,
                buttons: false,
                timer: 1000
            }).then((action) => {
                $(v).val('').focus();
            });
        }
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
