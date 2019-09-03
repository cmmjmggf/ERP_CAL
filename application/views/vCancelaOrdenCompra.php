<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-9 float-left">
                <legend class="float-left">Cancela Orden de Compra</legend>
            </div>
            <div class="col-sm-3" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Tp</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="1" id="Tp" name="Tp" required="">
            </div>
            <div class="col-12 col-sm-6 col-md-1 col-xl-1">
                <label for="" >Folio</label>
                <input type="text" class="form-control form-control-sm numbersOnly" maxlength="10" id="Folio" name="Folio" required="">
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-1 mt-4 pt-2">
                <button type="button" class="btn btn-danger btn-sm" id="btnGuardar">
                    <i class="fa fa-ban"></i> CANCELAR O.C.
                </button>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Movimientos" class="table-responsive">
                <table id="tblMovimientos" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Total:</th>
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
</div>
<script>
    var master_url = base_url + 'index.php/CancelaOrdenCompra/';
    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    var tblMovimientos = $('#tblMovimientos');
    var Movimientos;
    var nuevo = true;
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        handleEnter();
        init();
        pnlTablero.find("#Tp").change(function () {
            var tp = parseInt($(this).val());
            if (tp === 1 || tp === 2) {
                pnlTablero.find('#Folio').focus();
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
                    $(this).val('').focus();
                });
            }
        });
        pnlTablero.find("#Folio").change(function () {
            var tp = pnlTablero.find("#Tp").val();
            var folio = pnlTablero.find("#Folio");

            if (tp !== '' && $(this).val() !== '') {
                $.getJSON(master_url + 'onVerificarExisteOrdenCompra', {
                    Tp: tp,
                    Folio: $(this).val()
                }).done(function (data) {
                    if (data.length > 0) {//Si existe el registro
                        if (data[0].Estatus === 'ACTIVA') {//ACTIVA

                            getRecords(tp, folio.val());
                            console.log(data);

                        } else {//ABIERTA
                            swal({
                                title: "ATENCIÓN",
                                text: "YA SE HA RECIBIDO EL MATERIAL DE ESTA ORDEN DE COMPRA",
                                icon: "warning"
                            }).then((value) => {
                                folio.val('').focus();
                            });
                        }
                    } else {//ABIERTA
                        swal({
                            title: "ATENCIÓN",
                            text: "NO EXISTE LA ORDEN DE COMPRA",
                            icon: "error"
                        }).then((value) => {
                            folio.val('').focus();
                        });
                    }
                });


            } else {
                swal({
                    title: "ATENCIÓN",
                    text: "DEBES INTRODUCIR EL TP DEL MOVIMIENTO Y EL FOLIO CORRECTAMENTE",
                    icon: "warning",
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    buttons: true
                }).then((action) => {
                    $(this).val("");
                    $(this).focus();
                });
            }

        });
        btnGuardar.click(function () {
            isValid('pnlTablero');
            if (valido) {
                swal({
                    buttons: ["Cancelar", "Aceptar"],
                    title: 'Estás Seguro?',
                    text: "Esta acción cancelará todo el documento seleccionado",
                    icon: "warning",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                }).then((action) => {
                    if (action) {
                        var tp = pnlTablero.find("#Tp").val();
                        var folio = pnlTablero.find('#Folio').val();

                        $.post(master_url + 'onCancelarOrden', {
                            Tp: tp,
                            Folio: folio
                        }).done(function (data) {
                            onNotifyOld('fa fa-check', 'REGISTRO CANCELADO EXITOSAMENTE', 'info');
                            init();
                        }).fail(function (x, y, z) {
                            console.log(x, y, z);
                        });
                    }

                });
            } else {
                swal('ATENCION', 'Completa los campos requeridos', 'warning');
            }
        });

    });
    function init() {
        getRecords('0', '0');
        Movimientos.clear().draw();
        pnlTablero.find("input").val("");
        pnlTablero.find("#Tp").focus();
    }
    function getRecords(tp, folio) {
        HoldOn.open({theme: 'sk-bounce', message: 'CARGANDO DATOS...'});
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientos')) {
            tblMovimientos.DataTable().destroy();
        }
        Movimientos = tblMovimientos.DataTable({
            "dom": 'rtip',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "data": {
                    Tp: tp,
                    Folio: folio
                },
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Clave"},
                {"data": "Articulo"},
                {"data": "Cantidad"},
                {"data": "Precio"},
                {"data": "SubTotal"},
                {"data": "Fecha"},
                {"data": "Proveedor"}
            ],
            "columnDefs": [
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return $.number(parseFloat(data), 2, '.', ',');
                    }
                },
                {
                    "targets": [4],
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
                [1, 'asc']
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

                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var total = api.column(2).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric((a)) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(2).footer()).html(api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                    return  $.number(parseFloat(total), 2, '.', ',');
                }, 0));
                // Update footer
                var total2 = api.column(4).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric((a)) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(total2), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();

            }
        });

        tblMovimientos.find('tbody').on('click', 'tr', function () {
            tblMovimientos.find("tbody tr").removeClass("success");
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

    td span.badge{
        font-size: 100% !important;
    }
</style>
