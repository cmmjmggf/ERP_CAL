<div class="card m-3 animated fadeIn" id="pnlTablero">
    <div class="card-body ">
        <div class="row">
            <div class="col-sm-8 float-left">
                <legend class="float-left">Consulta Ordenes de Compra</legend>
            </div>
            <div class="col-sm-4" align="right">
                <button type="button" class="btn btn-danger" id="btnReporteMatNoRecibido">
                    <i class="fa fa-file-pdf"></i> REPORTE MAT. NO RECIBIDO
                </button>
                <button type="button" class="btn btn-info" id="btnLimpiarFiltros" >
                    <i class="fa fa-align-left"></i> RESTAURAR FILTROS
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Año</label>
                <input type="text" class="form-control form-control-sm  numbersOnly " id="Ano" maxlength="4" >
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-2 col-xl-2">
                <label>Departamento</label>
                <input type="text" placeholder="10-PI/FO 80-SUELA 90-PELET." class="form-control form-control-sm  numbersOnly column_filter" id="Depto" maxlength="2" >
            </div>
            <div class="col-6 col-sm-2 col-md-2 col-lg-2 col-xl-1" >
                <label>Folio</label>
                <input type="text" class="form-control form-control-sm  numbersOnly column_filter" id="Folio" maxlength="10" >
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-4 col-xl-4">
                <label>Proveedor</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Proveedor" name="Proveedor" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sProveedor" name="sProveedor" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-5 col-md-5 col-lg-4 col-xl-4">
                <label>Artículo</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm  numbersOnly " id="Articulo" name="Articulo" maxlength="6" required="">
                    </div>
                    <div class="col-9">
                        <select id="sArticulo" name="sArticulo" class="form-control form-control-sm required NotSelectize" required="" >
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-block mt-4">
            <div id="Compras" class="table-responsive">
                <table id="tblCompras" class="table table-sm display " style="width:100%">
                    <thead>
                        <tr>
                            <th class="d-none">Group</th>
                            <th>Ano</th>
                            <th>Tipo</th>
                            <th>Tp</th>
                            <th>O.C.</th>
                            <th>Prov</th>
                            <th>Fec</th>
                            <th>Fec-Ent</th>
                            <th>Fec-Fac</th>
                            <th>Cod</th>
                            <th>Artículo</th>
                            <th>Cant</th>
                            <th>Recibi</th>
                            <th>Saldo</th>
                            <th>Precio</th>
                            <th>Subt</th>
                            <th>Sem</th>
                            <th>Maq</th>
                            <th>Gpo</th>
                            <th class="d-none">ID</th>
                            <th>Sts</th>
                            <th class="d-none">NFCant</th>
                            <th class="d-none">NFCantRec</th>
                            <th class="d-none">NFSaldo</th>
                            <th class="d-none">NFSubTotal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="9" align="center"></th>
                            <th colspan="2" align="center">Totales:</th>
                            <th>0.0</th>
                            <th>0.0</th>
                            <th>0.0</th>
                            <th></th>
                            <th>$0.0</th>
                            <th colspan="9"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var master_url = base_url + 'index.php/MaterialRecibido/';
    var tblCompras = $('#tblCompras');
    var Compras;
    var pnlTablero = $("#pnlTablero");
    $(document).ready(function () {
        /*FUNCIONES INICIALES*/
        init();
        tblCompras.find('tbody').on('click', 'tr', function () {
            tblCompras.find("tbody tr").removeClass("success");
            $(this).addClass("success");
            var dtm = Compras.row(this).data();
            temp = parseInt(dtm.ID);


            swal("Imprimir", "Orden de Compra: " + dtm.Folio + ' \nProveedor: ' + dtm.NombreProveedor, {
                buttons: ["Cancelar", true]
            }).then((value) => {
                if (value) {
                    $.post(master_url + 'onImprimirOrdenCompra', {Tp: dtm.Tp, Folio: dtm.Folio}).done(function (data) {
                        onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                        onImprimirReporteFancy(data);
                    }).fail(function (x, y, z) {
                        console.log(x, y, z);
                    });
                }
            });
        });
        pnlTablero.find('#btnLimpiarFiltros').click(function () {
            pnlTablero.find("input").val("");
            Compras.ajax.reload();
            $(':input:text:enabled:visible:first').focus();
        });
        pnlTablero.find('#btnReporteMatNoRecibido').click(function () {
            HoldOn.open({theme: 'sk-cube', message: 'CARGANDO...'});
            $.post(master_url + 'onImprimirReporteMaterialNoRecibido').done(function (data) {
                onNotifyOld('fa fa-check', 'REPORTE GENERADO', 'success');
                onImprimirReporteFancy(data);
                HoldOn.close();
            }).fail(function (x, y, z) {
                console.log(x, y, z);
            });
        });

        pnlTablero.find("#Ano").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    if (parseInt($(this).val()) < 2015 || parseInt($(this).val()) > 2025) {
                        swal({
                            title: "ATENCIÓN",
                            text: "AÑO INCORRECTO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            pnlTablero.find("#Ano").val("");
                            pnlTablero.find("#Ano").focus();
                        });
                    } else {
                        Compras.ajax.reload();
                        pnlTablero.find("#Depto").focus().select();
                    }
                } else {
                    Compras.ajax.reload();
                    pnlTablero.find("#Depto").focus().select();
                }
            }
        });
        pnlTablero.find("#Depto").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    var tipo = parseInt($(this).val());
                    if (tipo === 80 || tipo === 90 || tipo === 10) {
                        Compras.ajax.reload();
                        pnlTablero.find('#Folio').focus().select();
                    } else {
                        swal({
                            title: "ATENCIÓN",
                            text: "DEPARTAMENTO INCORRECTO",
                            icon: "warning",
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then((action) => {
                            $(this).val('').focus();
                        });
                    }
                } else {
                    Compras.ajax.reload();
                    pnlTablero.find("#Folio").focus().select();
                }
            }
        });
        pnlTablero.find("#Folio").keypress(function (e) {
            if (e.keyCode === 13) {
                if ($(this).val()) {
                    Compras.ajax.reload();
                    pnlTablero.find("#Proveedor").focus().select();
                } else {
                    Compras.ajax.reload();
                    pnlTablero.find("#Proveedor").focus().select();
                }
            }
        });
        pnlTablero.find('#Articulo').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtart = $(this).val();
                if (txtart) {
                    $.getJSON(base_url + 'index.php/ReportesKardex/onVerificarArticulo', {Articulo: txtart}).done(function (data) {
                        if (data.length > 0) {
                            Compras.ajax.reload();
                            pnlTablero.find("#sArticulo")[0].selectize.addItem(txtart, true);
                            pnlTablero.find('#Articulo').focus().select();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                                pnlTablero.find('#Articulo').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    Compras.ajax.reload();
                    pnlTablero.find("#sArticulo")[0].selectize.clear(true);
                    pnlTablero.find('#Articulo').focus().select();
                }
            }
        });
        pnlTablero.find('#sArticulo').change(function () {
            var txtart = $(this).val();
            if (txtart) {
                Compras.ajax.reload();
                pnlTablero.find('#Articulo').val(txtart);
                pnlTablero.find('#Articulo').focus().select();
            }
        });
        pnlTablero.find('#Proveedor').keydown(function (e) {
            if (e.keyCode === 13) {
                var txtprv = $(this).val();
                if (txtprv) {
                    $.getJSON(base_url + 'index.php/ReportesKardex/onVerificarProveedor', {Proveedor: txtprv}).done(function (data) {
                        if (data.length > 0) {
                            Compras.ajax.reload();
                            pnlTablero.find("#sProveedor")[0].selectize.addItem(txtprv, true);
                            pnlTablero.find('#Articulo').focus().select();
                        } else {
                            swal('ERROR', 'EL ARTÍCULO NO EXISTE', 'warning').then((value) => {
                                pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                                pnlTablero.find('#Proveedor').focus().val('');
                            });
                        }
                    }).fail(function (x) {
                        swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
                        console.log(x.responseText);
                    });
                } else {
                    Compras.ajax.reload();
                    pnlTablero.find("#sProveedor")[0].selectize.clear(true);
                    pnlTablero.find('#Articulo').focus().select();
                }
            }
        });
        pnlTablero.find('#sProveedor').change(function () {
            var txtprv = $(this).val();
            if (txtprv) {
                Compras.ajax.reload();
                pnlTablero.find('#Proveedor').val(txtprv);
                pnlTablero.find('#Articulo').focus().select();
            }
        });
    });
    function init() {
        getRecords();
        pnlTablero.find('.NotSelectize').selectize({
            hideSelected: false,
            openOnFocus: false
        });
        getArticulosMatRecibido();
        getProveedoresMatRecibido();
        pnlTablero.find("input").val("");
        pnlTablero.find("#Ano").val(getYear());
        $(':input:text:enabled:visible:first').focus();
    }
    function getRecords() {
        temp = 0;
        HoldOn.open({
            theme: 'sk-cube',
            message: 'CARGANDO...'
        });
        $.fn.dataTable.ext.errMode = 'throw';
        if ($.fn.DataTable.isDataTable('#tblCompras')) {
            tblCompras.DataTable().destroy();
        }
        Compras = tblCompras.DataTable({
            "dom": 'rtp',
            buttons: buttons,
            orderCellsTop: true,
            fixedHeader: true,
            "ajax": {
                "url": master_url + 'getRecords',
                "dataSrc": "",
                "type": "POST",
                "data": function (d) {
                    d.Ano = pnlTablero.find("#Ano").val() ? pnlTablero.find("#Ano").val() : '';
                    d.Tipo = pnlTablero.find("#Depto").val() ? pnlTablero.find("#Depto").val() : '';
                    d.Articulo = pnlTablero.find("#Articulo").val() ? pnlTablero.find("#Articulo").val() : '';
                    d.Proveedor = pnlTablero.find("#Proveedor").val() ? pnlTablero.find("#Proveedor").val() : '';
                    d.Folio = pnlTablero.find("#Folio").val() ? pnlTablero.find("#Folio").val() : '';
                }
            },
            "columns": [
                {"data": "GruposT"},
                {"data": "Ano"},
                {"data": "Tipo"},
                {"data": "Tp"},
                {"data": "Folio"},
                {"data": "Proveedor"},
                {"data": "FechaOrden"},
                {"data": "FechaEntrega"},
                {"data": "FechaFactura"},
                {"data": "Articulo"},
                {"data": "NomArticulo"},
                {"data": "Cantidad"},
                {"data": "CantidadRecibida"},
                {"data": "Saldo"},
                {"data": "Precio"},
                {"data": "SubTotal"},
                {"data": "Sem"},
                {"data": "Maq"},
                {"data": "Grupo"},
                {"data": "ID"},
                {"data": "Estatus"},
                {"data": "NFCant"},
                {"data": "NFCantRec"},
                {"data": "NFSaldo"},
                {"data": "NFSubTotal"}
            ],
            "columnDefs": [
                {
                    "targets": [0, 2, 3, 19, 21, 22, 23, 24],
                    "visible": false,
                    "searchable": true
                },
                {
                    "targets": [10],
                    width: 350
                }
            ],
            language: lang,
            "scrollY": 450,
            "autoWidth": true,
            "colReorder": true,
            "displayLength": 250,
            "bLengthChange": true,
            "deferRender": true,
            "scrollCollapse": false,
            "bSort": true,
            "aaSorting": [
                [4, 'asc'], [5, 'asc'], [7, 'asc']/*Folio*/
            ],
            "createdRow": function (row, data, index) {
                $.each($(row).find("td"), function (k, v) {
                    var c = $(v);
                    var index = parseInt(k);
                    switch (index) {
                        case 10:
                            /*FECHA ENTREGA*/
                            c.addClass('text-danger text-strong');
                            break;
                    }
                });
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();//Get access to Datatable API
                // cantidad pedida
                var can = api.column(21).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(11).footer()).html(api.column(11, {page: 'current'}).data().reduce(function (a, b) {
                    return  $.number(parseFloat(can), 2, '.', ',');
                }, 0));
                //Cantidad recibida
                var canrec = api.column(22).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(12).footer()).html(api.column(12, {page: 'current'}).data().reduce(function (a, b) {
                    return  (canrec > 0) ? $.number(parseFloat(canrec), 2, '.', ',') : '';
                }, 0));
                //Saldo
                var sald = api.column(23).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(13).footer()).html(api.column(13, {page: 'current'}).data().reduce(function (a, b) {

                    return  (parseInt(sald) === 0) ? '' : "<span class='text-danger' >" + $.number(parseFloat(sald), 2, '.', ',') + "</span>";
                }, 0));
                //Importe
                //Cantidad recibida
                var subt = api.column(24).data().reduce(function (a, b) {
                    var ax = 0, bx = 0;
                    ax = $.isNumeric(a) ? parseFloat(a) : 0;
                    bx = $.isNumeric(getNumberFloat(b)) ? getNumberFloat(b) : 0;
                    return  (ax + bx);
                }, 0);
                $(api.column(15).footer()).html(api.column(15, {page: 'current'}).data().reduce(function (a, b) {
                    return '$' + $.number(parseFloat(subt), 2, '.', ',');
                }, 0));
            },
            initComplete: function (a, b) {
                HoldOn.close();
            }
        });

    }
    function getArticulosMatRecibido() {
        pnlTablero.find("#sArticulo")[0].selectize.clear(true);
        pnlTablero.find("#sArticulo")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesKardex/getArticulos').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sArticulo")[0].selectize.addOption({text: v.Clave + ' - ' + v.Articulo, value: v.Clave});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
        });
    }
    function getProveedoresMatRecibido() {
        pnlTablero.find("#sProveedor")[0].selectize.clear(true);
        pnlTablero.find("#sProveedor")[0].selectize.clearOptions();
        $.getJSON(base_url + 'index.php/ReportesKardex/getProveedores').done(function (data) {
            $.each(data, function (k, v) {
                pnlTablero.find("#sProveedor")[0].selectize.addOption({text: v.ID + ' - ' + v.ProveedorF, value: v.ID});
            });
        }).fail(function (x) {
            swal('ERROR', 'HA OCURRIDO UN ERROR INESPERADO, VERIFIQUE LA CONSOLA PARA MÁS DETALLE', 'info');
            console.log(x.responseText);
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

    table tbody tr {
        font-size: 0.75rem !important;
    }
</style>
