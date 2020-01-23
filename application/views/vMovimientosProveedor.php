<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">
                    <span class="fa fa-check-circle"></span>
                    Consulta de Movimientos de Proveedores</legend>
            </div>
            <div class="col-sm-4" align="right">

            </div>
        </div>
        <div class="row" id="Encabezado">

            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1">
                <label>Proveedor</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Proveedor" name="Proveedor" maxlength="5" required="">
            </div>
            <div class="col-12 col-sm-5 col-md-5 col-xl-3" >
                <label for="" >-</label>
                <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                    <option value=""></option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-md-3 col-lg-2 col-xl-2" >
                <label>Doc.</label>
                <input type="text" class="form-control form-control-sm captura " id="Doc" name="Doc" maxlength="15" required>
            </div>
        </div>
        <hr>
        <div class="row">
            <!--            primera tabla-->
            <div class="col-6 border border-info border-left-0  border-bottom-0 border-top-0">
                <label>Documentos</label>
                <div class="card-block mt-2">
                    <div id="MovimientosProveedores">
                        <table id="tblMovimientosProveedores" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Proveedor</th>
                                    <th>Docto</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Pagos</th>
                                    <th>Saldo</th>
                                    <th>Tp</th>
                                    <th>Sts</th>

                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" align="center">Totales:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!--            segunda tabla-->
            <div class="col-6 border border-info border-left-0  border-bottom-0 border-top-0">
                <label>Pagos</label>
                <div class="card-block mt-2">
                    <div id="PagosProveedores">
                        <table id="tblPagosProveedores" class="table table-sm display " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Docto</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Ref.</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
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
    </div>
</div>

<script>
    var master_url = base_url + 'index.php/MovimientosProveedor/';
    var tblMovimientosProveedores = $('#tblMovimientosProveedores');
    var MovimientosProveedores;
    var tblPagosProveedores = $('#tblPagosProveedores');
    var PagosProveedores;

    var pnlTablero = $("#pnlTablero");
    var btnGuardar = pnlTablero.find('#btnGuardar');
    $(document).ready(function () {

        /*FUNCIONES INICIALES*/
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        getProveedores();
        getRecords(0);
        getPagos(0, 0);
        pnlTablero.find("input").val("");
        $.each(pnlTablero.find("select"), function (k, v) {
            pnlTablero.find("select")[k].selectize.clear(true);
        });
        pnlTablero.find("#Proveedor").focus();

        pnlTablero.find('#Proveedor').keypress(function (e) {
            if (e.keyCode === 13) {
                var txtprov = $(this).val();
                if (txtprov) {
                    $.getJSON(master_url + 'onVerificarProveedor', {Proveedor: txtprov}).done(function (data) {
                        if (data.length > 0) {
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprov, true);
                            getRecords(txtprov);
                            getPagos(txtprov, '');
                            MovimientosProveedores.column(1).search('').draw();
                            pnlTablero.find('#Doc').val('').focus();
                        } else {
                            swal('ERROR', 'EL PROVEEDOR NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                }
            }
        });
        pnlTablero.find("#sProveedor").change(function () {
            if ($(this).val()) {
                pnlTablero.find('#Proveedor').val($(this).val());
                pnlTablero.find('#Doc').val('').focus();
                getRecords($(this).val());
                getPagos($(this).val(), '');
//                MovimientosProveedores.column(1).search('').draw();
                MovimientosProveedores.ajax.reload();
            }
        });
        pnlTablero.find("#Doc").on('keypress', function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
//                    MovimientosProveedores.column(1).search('^' + $(this).val() + '$', true, false).draw();
                    MovimientosProveedores.ajax.reload();
                    getPagos(pnlTablero.find("#Proveedor").val(), $(this).val());
                } else {
                    getPagos(pnlTablero.find("#Proveedor").val(), '');
//                    MovimientosProveedores.column(1).search('').draw();
                    MovimientosProveedores.ajax.reload();
                }
            }
        });
        tblMovimientosProveedores.find('tbody').on('click', 'tr', function () {
            tblMovimientosProveedores.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });
        tblPagosProveedores.find('tbody').on('click', 'tr', function () {
            tblPagosProveedores.find("tbody tr").removeClass("success");
            $(this).addClass("success");
        });

    });
    function getProveedores() {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(master_url + 'getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getPagos(cliente, doc) {
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblPagosProveedores')) {
            tblPagosProveedores.DataTable().destroy();
        }
        PagosProveedores = tblPagosProveedores.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getPagos',
                "dataSrc": "",
                "data": {Proveedor: cliente, Doc: doc},
                "type": "POST"
            },
            "columns": [
                {"data": "remicion"},
                {"data": "fechacap"},
                {"data": "importeP"},
                {"data": "DocPago"}
            ],
//            "columnDefs": [
//                {
//                    "targets": [4],
//                    "render": function (data, type, row) {
//                        return '$' + $.number(parseFloat(data), 2, '.', ',');
//                    }
//                }
//            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [1, 'desc']
            ],
//            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//
//                        case 0:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 1:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 2:
//                            /*FECHA ORDEN*/
//                            c.addClass('text-success text-strong');
//                            break;
//                        case 5:
//                            /*fecha conf*/
//                            c.addClass('text-info text-strong');
//                            break;
//                    }
//                });
//            },
            initComplete: function (a, b) {
                HoldOn.close();
            },
            "drawCallback": function (settings) {
                var api = this.api();
                var stt = 0.0;
                console.log(api.rows().data());
                $.each(api.rows().data(), function (k, v) {
                    stt += parseFloat(v.importeP);
                });
                $(api.column(2).footer()).html(
                        '<span class="font-weight-bold">$' +
                        $.number(stt, 2, '.', ',') + '</span>');
            }
        });

    }
    function getRecords(prov) {
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblMovimientosProveedores')) {
            MovimientosProveedores.ajax.reload();
            return;
        }
        MovimientosProveedores = tblMovimientosProveedores.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "data": function (d) {
                    d.Proveedor = pnlTablero.find("#Proveedor").val() ? pnlTablero.find("#Proveedor").val() : ''; 
                    d.Documento = pnlTablero.find("#Doc").val() ? pnlTablero.find("#Doc").val() : ''; 
                }
            },
            "columns": [
                {"data": "Proveedor"},
                {"data": "Doc"},
                {"data": "fechadoc"},
                {"data": "ImporteDoc"},
                {"data": "Pagos_Doc"},
                {"data": "Saldo_Doc"},
                {"data": "Tp"},
                {"data": "Estatus"}
            ],
//            "columnDefs": [
//                {
//                    "targets": [3, 4, 5],
//                    "render": function (data, type, row) {
//                        return '$' + $.number(parseFloat(data), 2, '.', ',');
//                    }
//                }
//            ],
            language: lang,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 500,
            "scrollX": true,
            "scrollY": 400,
            "bLengthChange": false,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [2, 'desc'], [1, 'asc']
            ],
//            "createdRow": function (row, data, index) {
//                $.each($(row).find("td"), function (k, v) {
//                    var c = $(v);
//                    var index = parseInt(k);
//                    switch (index) {
//
//                        case 0:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 1:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong');
//                            break;
//                        case 3:
//                            /*FECHA ENTREGA*/
//                            c.addClass('text-strong text-success');
//                            break;
//                        case 7:
//                            /*fecha conf*/
//                            c.addClass('badge badge-info text-strong');
//                            break;
//                    }
//                });
//            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // Update footer
                var importe = api.column(3).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(3).footer()).html(api.column(3, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(importe), 2, '.', ',');
                }, 0));
                var pagos = api.column(4).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(4).footer()).html(api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(pagos), 2, '.', ',');
                }, 0));
                var saldo = api.column(5).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(5).footer()).html(api.column(5, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(saldo), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
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

    .badge{
        font-size: 100% !important;
    }

    .table-sm th, .table-sm td {
        padding: 0.092rem;
    }


    .table th, .table td {
        vertical-align: middle;
    }
</style>

